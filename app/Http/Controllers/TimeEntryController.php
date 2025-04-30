<?php

namespace App\Http\Controllers;

use App\Models\TimeEntry;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimeEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $timeEntries = TimeEntry::where('user_id', Auth::id())
            ->with(['task', 'task.project'])
            ->latest()
            ->paginate(10);

        return view('time-entries.index', compact('timeEntries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->where('status', '!=', 'completed')
            ->get();

        return view('time-entries.create', compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'duration_minutes' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'is_billable' => 'boolean'
        ]);

        $timeEntry = Auth::user()->timeEntries()->create($validated);

        return redirect()->route('time-entries.show', $timeEntry)
            ->with('success', 'Time entry created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TimeEntry $timeEntry)
    {
        $this->authorize('view', $timeEntry);

        return view('time-entries.show', compact('timeEntry'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimeEntry $timeEntry)
    {
        $this->authorize('update', $timeEntry);

        $tasks = Task::where('user_id', Auth::id())->get();

        return view('time-entries.edit', compact('timeEntry', 'tasks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimeEntry $timeEntry)
    {
        $this->authorize('update', $timeEntry);

        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'duration_minutes' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'is_billable' => 'boolean'
        ]);

        $timeEntry->update($validated);

        return redirect()->route('time-entries.show', $timeEntry)
            ->with('success', 'Time entry updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimeEntry $timeEntry)
    {
        $this->authorize('delete', $timeEntry);

        $timeEntry->delete();

        return redirect()->route('time-entries.index')
            ->with('success', 'Time entry deleted successfully.');
    }

    public function startTimer(Task $task)
    {
        $this->authorize('create', [TimeEntry::class, $task]);

        $activeEntry = TimeEntry::where('user_id', Auth::id())
            ->whereNull('end_time')
            ->first();

        if ($activeEntry) {
            return response()->json([
                'error' => 'You already have an active time entry'
            ], 422);
        }

        $timeEntry = TimeEntry::create([
            'user_id' => Auth::id(),
            'task_id' => $task->id,
            'start_time' => now(),
            'is_billable' => true
        ]);

        return response()->json([
            'message' => 'Timer started successfully',
            'timeEntry' => $timeEntry
        ]);
    }

    public function stopTimer(TimeEntry $timeEntry)
    {
        $this->authorize('update', $timeEntry);

        if ($timeEntry->end_time) {
            return response()->json([
                'error' => 'This time entry is already stopped'
            ], 422);
        }

        $endTime = now();
        $duration = Carbon::parse($timeEntry->start_time)->diffInMinutes($endTime);

        $timeEntry->update([
            'end_time' => $endTime,
            'duration_minutes' => $duration
        ]);

        return response()->json([
            'message' => 'Timer stopped successfully',
            'timeEntry' => $timeEntry
        ]);
    }

    public function report(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());

        $timeEntries = TimeEntry::where('user_id', Auth::id())
            ->whereBetween('start_time', [$startDate, $endDate])
            ->with(['task', 'task.project'])
            ->get();

        $summary = [
            'total_time' => $timeEntries->sum('duration_minutes'),
            'billable_time' => $timeEntries->where('is_billable', true)->sum('duration_minutes'),
            'project_distribution' => $timeEntries->groupBy('task.project.name')
                ->map(function ($entries) {
                    return $entries->sum('duration_minutes');
                }),
            'daily_distribution' => $timeEntries->groupBy(function ($entry) {
                return Carbon::parse($entry->start_time)->format('Y-m-d');
            })->map(function ($entries) {
                return $entries->sum('duration_minutes');
            })
        ];

        return view('time-entries.report', compact('timeEntries', 'summary', 'startDate', 'endDate'));
    }
}
