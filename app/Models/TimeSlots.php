<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlots extends Model
{
    use HasFactory;

    protected $fillable = ['price', 'start_time', 'is_available', 'free_seats_number'];
    
    public function escapeRooms()
    {
        return $this->belongsTo(EscapeRoom::class,'escape_rooms_id');
    }

}
