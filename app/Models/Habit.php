<?php

namespace App\Models;

use AppModels\user_habits;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    protected $fillable = [
        'title',
        'description',
        'svg',
        'is_default'
    ];

    public function userHabits()
    {
        return $this->hasMany(user_habits::class);
    }
}
