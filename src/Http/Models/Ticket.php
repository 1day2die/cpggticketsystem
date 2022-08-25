<?php
namespace OneDayToDie\TicketSystem\Http\Models;


use App\Models\User;
use \Illuminate\Database\Eloquent\Model as Eloquent;

class Ticket extends Eloquent  {
    protected $fillable = [
        'user_id', 'ticketcategory_id', 'ticket_id', 'title', 'priority', 'message', 'status', 'server'
    ];

    public function ticketcategory(){
    return $this->belongsTo(TicketCategory::class);}

    public function ticketcomments(){
    return $this->hasMany(TicketComment::class);}

    public function user(){
    return $this->belongsTo(User::class);}
}
