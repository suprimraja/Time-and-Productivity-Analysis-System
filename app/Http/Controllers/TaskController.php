<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->with(['project', 'timeEntries'])
            ->latest()
            ->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::where('user_id', Auth::id())->get();
        return view('tasks.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'parent_task_id' => 'nullable|exists:tasks,id',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:todo,in_progress,review,completed',
            'estimated_hours' => 'nullable|integer|min:0'
        ]);

        $task = Auth::user()->tasks()->create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load(['project', 'timeEntries', 'subtasks']);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $projects = Project::where('user_id', Auth::id())->get();
        $parentTasks = Task::where('project_id', $task->project_id)
            ->where('id', '!=', $task->id)
            ->get();

        return view('tasks.edit', compact('task', 'projects', 'parentTasks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'parent_task_id' => 'nullable|exists:tasks,id',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:todo,in_progress,review,completed',
            'estimated_hours' => 'nullable|integer|min:0',
            'actual_hours' => 'nullable|integer|min:0'
        ]);

        $task->update($validated);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'status' => 'required|in:todo,in_progress,review,completed'
        ]);

        $data = $validated;
        if ($validated['status'] === 'completed') {
            $data['completed_at'] = now();
        } else {
            $data['completed_at'] = null;
        }

        $task->update($data);

        return response()->json([
            'message' => 'Task status updated successfully',
            'task' => $task
        ]);
    }

    public function timeTracking(Task $task)
    {
        $this->authorize('view', $task);

        $timeEntries = $task->timeEntries()
            ->with('user')
            ->latest()
            ->get();

        $totalTime = $timeEntries->sum('duration_minutes');
        $billableTime = $timeEntries->where('is_billable', true)->sum('duration_minutes');

        return view('tasks.time-tracking', compact('task', 'timeEntries', 'totalTime', 'billableTime'));
    }
}
