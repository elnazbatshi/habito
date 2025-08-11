<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Habit;
use App\Models\UserHabit;
use App\Repositories\UserHabitRepository;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(private readonly UserHabitRepository $userHabitRepository) {}

    public function __invoke()
    {
        $totalHabits = UserHabit::where('user_id', Auth::id())->count();
        $suggestedHabits = $this->userHabitRepository->getHabitDefaultForUser(Auth::id());

        // Get real user habits with their logs
        $userHabits = UserHabit::with(['habitLogs' => function ($query) {
            $query->where('date', today());
        }])->where('user_id', Auth::id())->get();

        return Inertia::render('Dashboard', [
            'totalHabits' => $totalHabits,
            'suggestedHabits' => $suggestedHabits,
            'userHabits' => $userHabits
        ]);
    }
}
