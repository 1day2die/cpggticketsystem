<?php

namespace OneDayToDie\TicketSystem\Http\Controllers\Admin;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Server;


use Illuminate\Support\Facades\Blade;
use OneDayToDie\TicketSystem\Http\Models\Ticket;
use OneDayToDie\TicketSystem\Http\Models\TicketComment;
use OneDayToDie\TicketSystem\Http\Models\TicketCategory;
use OneDayToDie\TicketSystem\Http\Models\TicketBlacklist;
use Yajra\DataTables\Html\Builder;

class AdminTicketsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->dataTableQuery();
        }
        $html = $this->dataTable();

        $tickets = Ticket::orderBy('updated_at', 'desc')->paginate(10);
        $ticketcategories = TicketCategory::all();
        return view("ticket::admin.ticket.index", compact("tickets", "ticketcategories", "html"));

    }

    public function show($ticket_id)
    {
        $ticket = Ticket::where("ticket_id", $ticket_id)->firstOrFail();
        $ticketcomments = $ticket->ticketcomments;
        $ticketcategory = $ticket->ticketcategory;
        $server = Server::where('id', $ticket->server)->first();
        return view("admin.ticket.show", compact("ticket", "ticketcategory", "ticketcomments", "server"));
    }

    public function close($ticket_id)
    {
        $ticket = Ticket::where("ticket_id", $ticket_id)->firstOrFail();
        $ticket->status = "Closed";
        $ticket->save();
        $ticketOwner = $ticket->user;
        return redirect()->back()->with('success', __('A ticket has been closed, ID: #') . $ticket->ticket_id);
    }

    public function delete($ticket_id)
    {
        $ticket = Ticket::where("ticket_id", $ticket_id)->firstOrFail();
        TicketComment::where("ticket_id", $ticket->id)->delete();
        $ticket->delete();
        return redirect()->back()->with('success', __('A ticket has been deleted, ID: #') . $ticket_id);

    }

    public function reply(Request $request)
    {
        $this->validate($request, array("ticketcomment" => "required"));
        $ticket = Ticket::where('id', $request->input("ticket_id"))->firstOrFail();
        $ticket->status = "Answered";
        $ticket->update();
        TicketComment::create(array(
            "ticket_id" => $request->input("ticket_id"),
            "user_id" => Auth::user()->id,
            "ticketcomment" => $request->input("ticketcomment"),
        ));
        $user = User::where('id', $ticket->user_id)->firstOrFail();
        $newmessage = $request->input("ticketcomment");
        $user->notify(new ReplyNotification($ticket, $user, $newmessage));
        return redirect()->back()->with('success', __('Your comment has been submitted'));
    }


    public function blacklist()
    {
        return view("admin.ticket.blacklist");
    }

    public function blacklistAdd(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $check = TicketBlacklist::where('user_id', $user->id)->first();
        if ($check) {
            $check->reason = $request->reason;
            $check->status = "True";
            $check->save();

            return redirect()->back()->with('info', __('Target User already in blacklist. Reason updated'));
        }
        TicketBlacklist::create(array(
            "user_id" => $user->id,
            "status" => "True",
            "reason" => $request->reason,
        ));
        return redirect()->back()->with('success', __('Successfully add User to blacklist, User name: ' . $user->name));
    }


    public function blacklistDelete($id)
    {
        $blacklist = TicketBlacklist::where('id', $id)->first();
        $blacklist->delete();
        return redirect()->back()->with('success', __('Successfully remove User from blacklist, User name: ' . $blacklist->user->name));
    }

    public function blacklistChange($id)
    {
        $blacklist = TicketBlacklist::where('id', $id)->first();
        if ($blacklist->status == "True") {
            $blacklist->status = "False";

        } else {
            $blacklist->status = "True";
        }
        $blacklist->update();
        return redirect()->back()->with('success', __('Successfully change status blacklist from, User name: ' . $blacklist->user->name));

    }

    public function dataTableBlacklist()
    {
        $query = TicketBlacklist::with(['user']);
        $query->select('ticket_blacklists.*');
        return datatables($query)
            ->editColumn('user', function (TicketBlacklist $blacklist) {
                return '<a href="' . route('admin.users.show', $blacklist->user->id) . '">' . $blacklist->user->name . '</a>';
            })
            ->editColumn('status', function (TicketBlacklist $blacklist) {
                switch ($blacklist->status) {
                    case 'True':
                        $text = "Blocked";
                        $badgeColor = 'badge-danger';
                        break;
                    default:
                        $text = "Unblocked";
                        $badgeColor = 'badge-success';
                        break;
                }

                return '<span class="badge ' . $badgeColor . '">' . $text . '</span>';
            })
            ->editColumn('reason', function (TicketBlacklist $blacklist) {
                return $blacklist->reason;
            })
            ->addColumn('actions', function (TicketBlacklist $blacklist) {
                return '
                            <form class="d-inline"  method="post" action="' . route('admin.ticket.blacklist.change', ['id' => $blacklist->id]) . '">
                                ' . csrf_field() . '
                                ' . method_field("POST") . '
                            <button data-content="' . __("Change Status") . '" data-toggle="popover" data-trigger="hover" data-placement="top" class="btn btn-sm text-white btn-warning mr-1"><i class="fas fa-sync-alt"></i></button>
                            </form>
                            <form class="d-inline"  method="post" action="' . route('admin.ticket.blacklist.delete', ['id' => $blacklist->id]) . '">
                                ' . csrf_field() . '
                                ' . method_field("POST") . '
                            <button data-content="' . __("Delete") . '" data-toggle="popover" data-trigger="hover" data-placement="top" class="btn btn-sm text-white btn-danger mr-1"><i class="fas fa-trash"></i></button>
                            </form>
                ';
            })
            ->editColumn('created_at', function (TicketBlacklist $blacklist) {
                return $blacklist->created_at ? $blacklist->created_at->diffForHumans() : '';
            })
            ->rawColumns(['user', 'status', 'reason', 'created_at', 'actions'])
            ->make(true);
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

                            <form class="d-inline"  method="post" action="' . route('ticket.close', ['ticket_id' => $ticket->ticket_id]) . '">
                                ' . csrf_field() . '
                                ' . method_field("POST") . '
                            <button data-content="' . __("Close") . '" data-toggle="popover" data-trigger="hover" data-placement="top" class="btn btn-sm text-white btn-warning mr-1"><i class="fas fa-times"></i></button>
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
            ->rawColumns(['category', 'actions', 'code'])
            ->make(true);
    }

}
