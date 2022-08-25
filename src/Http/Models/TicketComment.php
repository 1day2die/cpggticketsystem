<?php

namespace OneDayToDie\TicketSystem\Http\Models;


use App\Models\User;
use \Illuminate\Database\Eloquent\Model as Eloquent;

class TicketComment extends Eloquent {
protected $fillable = [
    'ticket_id', 'user_id', 'ticketcomment'
];

    public function ticketcategory(){
    return $this->belongsTo(TicketCategory::class);}

    public function ticket(){
    return $this->belongsTo(Ticket::class);}

    public function user(){
    return $this->belongsTo(User::class);}
}
