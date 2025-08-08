<?php

namespace App\Models;

use AppModels\UserHabit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_habit_id',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function userHabit()
    {
        return $this->belongsTo(UserHabit::class);
    }
}

