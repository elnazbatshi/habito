<?php

namespace AppModels;

use App\Models\Habit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHabit  extends Model
{
    use HasFactory;
    protected $table = 'user_habits';

    protected $fillable = ['user_id',
                           'habit_id',
                           'custom_title',
                           'custom_desc',
                           "frequency", // مثل: daily, weekly, custom
                           'start_date', // مثل: روز شروع عادت
                           'time_of_day',// یاد آوری انجام کار
                           'is_avoidance',// عادت اجتنابی
                           'streak',       // تعداد روزهای پشت‌سرهم که انجام شده
                           'is_active',    // فعال یا غیرفعال بودن عادت
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_avoidance' => 'boolean',
        'start_date' => 'date',
    ];

    public function user()
        {
        return $this->belongsTo(User::class);
    }

    public function habit()
    {
        return $this->belongsTo(Habit::class);
    }
}
