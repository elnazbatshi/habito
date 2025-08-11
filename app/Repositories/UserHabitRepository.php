<?php

namespace App\Repositories;

use App\Models\Habit;
use App\Models\HabitLog;
use App\Models\UserHabit;

class UserHabitRepository
{
    public function create(array $data): UserHabit
    {
        return UserHabit::create($data);
    }

    public function getByUser(int $userId)
    {
        return UserHabit::where('user_id', $userId)->get();
    }

    public function getHabitDefaultForUser(int $userId)
    {
        // Get all default habits
        $defaultHabits = Habit::where('is_default', true)
            ->orderBy('title')
            ->get(['id', 'title']);

        // Get habits that user has already created
        $userHabits = UserHabit::where('user_id', $userId)
            ->whereNotNull('habit_id')
            ->pluck('habit_id');

        // Filter out habits that user already has
        $availableHabits = $defaultHabits->whereNotIn('id', $userHabits);

        return $availableHabits;
    }

    public function updateOrCreateLog(array $attributes, array $values): HabitLog
    {
        return HabitLog::updateOrCreate($attributes, $values);
    }
    public function findByIdAndUser(int $id, int $userId): ?UserHabit
    {
        return UserHabit::where('id', $id)->where('user_id', $userId)->first();
    }
}
