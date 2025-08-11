<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserHabitRequest;
use App\Models\Habit;
use App\Models\HabitLog;
use App\Services\UserHabitService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class HabitController extends Controller
{
    public function __construct(private readonly UserHabitService $userHabitService)
    {
        $this->middleware(['auth', 'verified']);
    }

    public function store(StoreUserHabitRequest $request): RedirectResponse
    {
        $this->userHabitService->createForUser(Auth::user(), $request->validated());

        return back()->with('success', 'Habit created');
    }

    public function index(): View
    {
        $habits = $this->userHabitService->listForUser(Auth::id());

        return view('habits.index', compact('habits'));
    }

    public function toggleLog(Request $request)
    {
        $request->validate([
            'user_habit_id' => 'required|exists:user_habits,id',
            'date' => 'required|date',
            'status' => 'required|in:completed,skipped,missed',
            'notes' => 'nullable|string'
        ]);

        // Ensure user owns this habit
        $userHabit = \App\Models\UserHabit::where('id', $request->user_habit_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $log = HabitLog::updateOrCreate(
            [
                'user_habit_id' => $request->user_habit_id,
                'date' => $request->date
            ],
            [
                'status' => $request->status,
                'notes' => $request->notes
            ]
        );

        return response()->json(['success' => true, 'log' => $log]);
    }

    public function habitSuggest()
    {
        $habitsDef = Habit::all();
        $habitsUser = $this->userHabitService->listForUser(Auth::id());
        $habits = $habitsDef->diff($habitsUser);
        return view('habits.suggest', compact('habits'));
    }
}
