<?php

namespace OneDayToDie\TicketSystem\Http\Models;


use \Illuminate\Database\Eloquent\Model as Eloquent;

class TicketCategory extends Eloquent {
    protected $fillable = ['name'];

    public function tickets(){
    return $this->hasMany(Ticket::class);}
}
