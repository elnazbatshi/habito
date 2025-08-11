<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserHabitRequest;
use App\Http\Requests\ToggleHabitLogRequest;
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
    public function toggleLog(ToggleHabitLogRequest $request)
    {
        $this->userHabitService->toggleLog($request->validated(), Auth::id());

        return redirect()->back()->with('success', 'Log updated');
    }

}
