<?php

namespace OneDayToDie\TicketSystem\Http\Controllers;



use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;

use App\Models\Server;


use OneDayToDie\TicketSystem\Http\Models\Ticket;
use OneDayToDie\TicketSystem\Http\Models\TicketComment;
use OneDayToDie\TicketSystem\Http\Models\TicketCategory;
use OneDayToDie\TicketSystem\Http\Models\TicketBlacklist;
use Yajra\DataTables\Html\Builder;

class TicketsController extends Controller
{
    public function index(Request $request)
    {
        //datatables
        if ($request->ajax()) {
            return $this->dataTableQuery();
        }

        $html = $this->dataTable();

        $tickets = Ticket::where("user_id", Auth::user()->id)->paginate(10);
        $ticketcategories = TicketCategory::all();

        return view("ticket::ticket.index", compact("tickets", "ticketcategories", "html"));
    }
    public function create() {
        #check in blacklist
        $check = TicketBlacklist::where('user_id', Auth::user()->id)->first();
        if($check && $check->status == "True"){
            return redirect()->route('ticket.index')->with('error', __("You can't make a ticket because you're on the blacklist for a reason: '" . $check->reason . "', please contact the administrator"));
        }
        $ticketcategories = TicketCategory::all();
        $servers = Auth::user()->servers;
        return view("ticket::ticket.create", compact("ticketcategories", "servers"));
    }
    public function store(Request $request) {
        $this->validate($request, array(
        	"title" => "required",
        	"ticketcategory" => "required",
        	"priority" => "required",
        	"message" => "required")
    	);
        $ticket = new Ticket(array(
        	"title" => $request->input("title"),
        	"user_id" => Auth::user()->id,
        	"ticket_id" => strtoupper(Str::random(5)),
        	"ticketcategory_id" => $request->input("ticketcategory"),
        	"priority" => $request->input("priority"),
        	"message" => $request->input("message"),
        	"status" => "Open",
            "server" => $request->input("server"))
   		);
        $ticket->save();
        $user = Auth::user();
        $admin = User::permission('1day2die.admin.ticket.read')->permission('1day2die.admin.ticket.write')->get();
        //$user->notify(new CreateNotification($ticket));
        //Notification::send($admin, new AdminCreateNotification($ticket, $user));

        return redirect()->route('ticket.index')->with('success', __('A ticket has been opened, ID: #') . $ticket->ticket_id);
    }
    public function show($ticket_id) {
        $ticket = Ticket::where("ticket_id", $ticket_id)->firstOrFail();
        $ticketcomments = $ticket->ticketcomments;
        $ticketcategory = $ticket->ticketcategory;
        $server = Server::where('id', $ticket->server)->first();
        return view("ticket::ticket.show", compact("ticket", "ticketcategory", "ticketcomments", "server"));
    }

    public function close($ticket_id) {
        $ticket = Ticket::where("ticket_id", $ticket_id)->firstOrFail();
        $ticket->status = "Closed";
        $ticket->save();
        return redirect()->back()->with('success', __('A ticket has been closed, ID: #') . $ticket->ticket_id);
    }


    public function reply(Request $request) {
        #check in blacklist
        $check = TicketBlacklist::where('user_id', Auth::user()->id)->first();
        if($check && $check->status == "True"){
            return redirect()->route('ticket.index')->with('error', __("You can't reply a ticket because you're on the blacklist for a reason: '" . $check->reason . "', please contact the administrator"));
        }
        $this->validate($request, array("ticketcomment" => "required"));
        $ticket = Ticket::where('id', $request->input("ticket_id"))->firstOrFail();
        $ticket->status = "Client Reply";
        $ticket->update();
        $ticketcomment = TicketComment::create(array(
        	"ticket_id" => $request->input("ticket_id"),
        	"user_id" => Auth::user()->id,
        	"ticketcomment" => $request->input("ticketcomment"),
        	"message" => $request->input("message")
        ));
        $user = Auth::user();
        $admin = User::permission('1day2die.admin.ticket.read')->permission('1day2die.admin.ticket.write')->get();
        $newmessage = $request->input("ticketcomment");
        //Notification::send($admin, new AdminReplyNotification($ticket, $user, $newmessage));
        return redirect()->back()->with('success', __('Your comment has been submitted'));
    }








    /**
     * @description create table
     *
     * @return Builder
     */
    public function dataTable(): Builder
    {

        $builder = $this->htmlBuilder
            ->addColumn(['data' => 'category', 'name' => 'category', 'title' => __('Category')])
            ->addColumn(['data' => 'prio', 'name' => 'prio', 'title' => __('Priority')])
            ->addColumn(['data' => 'title', 'name' => 'title', 'title' => __('Title')])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => __('Status')])
            ->addColumn(['data' => 'updated_at', 'name' => 'updated_at', 'title' => __('Updated at'), 'searchable' => false])
            ->addAction(['data' => 'actions', 'name' => 'actions', 'title' => __('Actions'), 'searchable' => false, 'orderable' => false])
            ->parameters($this->dataTableDefaultParameters());

        return $builder;
    }



    /**
     * @return mixed
     * @throws Exception
     */
    public function dataTableQuery(): mixed
    {
        $query = Ticket::where("user_id", Auth::user()->id)->get();


        return datatables($query)
            ->addColumn('category', function (Ticket $ticket) {
                return '<a class="text-info"  href="' . route('ticket.show', ['ticket_id' => $ticket->ticket_id]) . '">' . "#" . $ticket->ticket_id . " - " . $ticket->title . '</a>';
            })
            ->addColumn('prio', function (Ticket $ticket) {
                return $ticket->priority;
            })
            ->addColumn('actions', function (Ticket $ticket) {
                return Blade::render('

                            <form class="d-inline"  method="post" action="' . route('ticket.close', ['ticket_id' => $ticket->ticket_id ]) . '">
                                ' . csrf_field() . '
                                ' . method_field("POST") . '
                            <button data-content="'.__("Close").'" data-toggle="popover" data-trigger="hover" data-placement="top" class="btn btn-sm text-white btn-warning mr-1"><i class="fas fa-times"></i></button>
                            </form>
');
            })
            ->editColumn('title', function (Ticket $ticket) {
                return "$ticket->title";
            })
            ->editColumn('status', function (Ticket $ticket) {
                return $ticket->status;
            })
            ->editColumn('updated_at', function ($model) {
                return $model->updated_at ? $model->updated_at->diffForHumans() : '';
            })
            ->rawColumns(['category','actions', 'code'])
            ->make(true);
    }

}
