<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    protected $fillable = [
        'title',
        'description',
        'svg',
        'is_default',
    ];

    public function userHabits()
    {
        return $this->hasMany(UserHabit::class);
    }
}
