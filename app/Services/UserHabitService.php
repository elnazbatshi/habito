<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserHabitRepository;

class UserHabitService
{
    public function __construct(private readonly UserHabitRepository $habitRepo) {}

    public function createForUser(User $user, array $data)
    {
        $payload = array_merge($data, [
            'user_id' => $user->id,
        ]);
        return $this->habitRepo->create($payload);
    }

    public function listForUser(int $userId)
    {
        return $this->habitRepo->getByUser($userId);
    }
}
