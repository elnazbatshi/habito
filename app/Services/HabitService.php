<?php

namespace App\Services;

use App\Repositories\UserHabitRepository;

class HabitService
{
    public function __construct(private readonly UserHabitRepository $habitRepo)
    {
    }
    public function getHabitDefault(int $user)
    {
        return $this->habitRepo->getHabitDefaultForUser($user);
    }
}