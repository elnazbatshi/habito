<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserHabit;
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

    public function toggleLog(array $data, int $userId)
    {
        $userHabit = $this->habitRepo->findByIdAndUser($data['user_habit_id'], $userId);

        if (!$userHabit) {
            throw new \Exception('UserHabit not found or unauthorized.');
        }

        return $this->habitRepo->updateOrCreateLog(
            [
                'user_habit_id' => $data['user_habit_id'],
                'date' => $data['date']
            ],
            [
                'status' => $data['status'],
                'notes' => $data['notes'] ?? null
            ]
        );
    }
}
