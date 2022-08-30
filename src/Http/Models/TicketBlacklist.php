<?php

namespace OneDayToDie\TicketSystem\Http\Models;


use App\Models\User;
use \Illuminate\Database\Eloquent\Model as Eloquent;
class TicketBlacklist extends Eloquent {
    protected $fillable = [
        'user_id', 'status', 'reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
