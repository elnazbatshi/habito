<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHabit extends Model
{
    use HasFactory;

    protected $table = 'user_habits';

    protected $fillable = [
        'user_id',
        'habit_id',
        'custom_title',
        'custom_desc',
        'color',
        'question',
        'unit',
        'target',
        'target_type',
        'frequency',
        'reminder_time',
        'notes',
        'start_date',
        'is_active',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'start_date'  => 'date',
        'target'      => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function habit()
    {
        return $this->belongsTo(Habit::class);
    }

    public function habitLogs()
    {
        return $this->hasMany(HabitLog::class);
    }

    public function getTodayLog()
    {
        return $this->habitLogs()->where('date', today())->first();
    }
}
