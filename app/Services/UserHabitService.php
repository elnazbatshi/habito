<?php

namespace App\Services;



use App\Repositories\UserHabit\UserHabitRepository;

class UserHabitService
{
    protected $habitRepo;
    public function __construct(UserHabitRepository $habitRepo)
    {
        $this->habitRepo = $habitRepo;
    }
    public function Habits(array $filters = [])
    {
        return $this->habitRepo->allHabits();
    }
    public function listUserHabits(int $userId)
    {
        return $this->habitRepo->allByUser($userId);
    }


}
