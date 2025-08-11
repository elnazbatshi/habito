<?php

namespace App\Models;

use App\Models\UserHabit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_habit_id',
        'date',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];
    protected $attributes = [
        'status' => 'pending',
    ];
    public function userHabit()
    {
        return $this->belongsTo(UserHabit::class);
    }
    public function user()
    {
        return $this->hasOneThrough(User::class, UserHabit::class, 'id', 'id', 'user_habit_id', 'user_id');
    }

}
