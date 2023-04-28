<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscapeRooms extends Model
{
    use HasFactory;
    protected $fillable = ['theme', 'max_size', 'is_available'];

    public function timsSlots()
    {
        return $this->hasMany(TimeSlots::class, 'escape_rooms_id');
    }

}
