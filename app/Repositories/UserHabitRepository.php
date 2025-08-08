<?php
namespace App\Repositories\UserHabit;


use AppModels\user_habits;

class UserHabitRepository
{
    public function assignDefaultHabitToUser(array $data)
    {
        return user_habits::create($data);
    }

    public function createCustomHabitForUser(array $data)
    {
        return user_habits::create($data);
    }

    public function getUserHabits($userId)
    {
        return user_habits::where('user_id', $userId)->get();
    }
}
