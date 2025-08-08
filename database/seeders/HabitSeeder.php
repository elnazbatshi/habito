<?php

namespace Database\Seeders;

use App\Models\Habit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HabitSeeder extends Seeder
{
    public function run(): void
    {
        $habits = [
            ['title' => 'ورزش روزانه'],
            ['title' => 'مطالعه کتاب'],
            ['title' => 'مدیتیشن'],
            ['title' => 'تماس با خانواده'],
            ['title' => 'مرور اهداف'],
            ['title' => 'مرتب‌ سازی ایمیل‌ها'],
        ];

        foreach ($habits as $habit) {
            Habit::create([
                'title' => $habit['title'],
                'is_default' => true,
            ]);
        }
    }
}
