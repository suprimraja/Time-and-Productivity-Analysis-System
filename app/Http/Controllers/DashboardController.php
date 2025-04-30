<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\TimeEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfWeek = $now->copy()->startOfWeek();

        // Project Statistics
        $totalProjects = Project::where('user_id', $user->id)->count();
        $newProjects = Project::where('user_id', $user->id)
            ->where('created_at', '>=', $startOfMonth)
            ->count();

        // Task Statistics
        $activeTasks = Task::where('user_id', $user->id)
            ->where('status', '!=', 'completed')
            ->count();
        $completedTasks = Task::where('user_id', $user->id)
            ->where('status', 'completed')
            ->where('completed_at', '>=', $startOfMonth)
            ->count();

        // Time Tracking Statistics
        $totalHours = TimeEntry::where('user_id', $user->id)
            ->where('start_time', '>=', $startOfWeek)
            ->sum('duration_minutes') / 60; // Convert minutes to hours

        // Productivity Score
        $productivityScore = $this->calculateProductivityScore($user);

        // Recent Projects
        $recentProjects = Project::where('user_id', $user->id)
            ->withCount('tasks')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($project) {
                $project->progress = $this->calculateProjectProgress($project);
                return $project;
            });

        // Recent Activities
        $recentActivities = $this->getRecentActivities($user);

        return view('dashboard', compact(
            'totalProjects',
            'newProjects',
            'activeTasks',
            'completedTasks',
            'totalHours',
            'productivityScore',
            'recentProjects',
            'recentActivities'
        ));
    }

    private function calculateProductivityScore($user)
    {
        $completedTasks = Task::where('user_id', $user->id)
            ->where('status', 'completed')
            ->where('completed_at', '>=', Carbon::now()->subWeek())
            ->count();
        $totalTasks = Task::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subWeek())
            ->count();
        $timeEfficiency = TimeEntry::where('user_id', $user->id)
            ->where('start_time', '>=', Carbon::now()->subWeek())
            ->avg('efficiency_score') ?? 0;

        if ($totalTasks === 0) {
            return 0;
        }

        $taskCompletionRate = ($completedTasks / $totalTasks) * 100;
        return round(($taskCompletionRate + $timeEfficiency) / 2);
    }

    private function calculateProjectProgress($project)
    {
        $totalTasks = $project->tasks()->count();
        if ($totalTasks === 0) {
            return 0;
        }
        $completedTasks = $project->tasks()->where('status', 'completed')->count();
        return round(($completedTasks / $totalTasks) * 100);
    }

    private function getRecentActivities($user)
    {
        $activities = collect();

        // Project activities
        $recentProjects = Project::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();
        foreach ($recentProjects as $project) {
            $activities->push((object)[
                'type' => 'project',
                'description' => "Created project: {$project->name}",
                'created_at' => $project->created_at
            ]);
        }

        // Task activities
        $recentTasks = Task::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();
        foreach ($recentTasks as $task) {
            $activities->push((object)[
                'type' => 'task',
                'description' => "{$task->status} task: {$task->title}",
                'created_at' => $task->updated_at
            ]);
        }

        // Time entry activities
        $recentTimeEntries = TimeEntry::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();
        foreach ($recentTimeEntries as $entry) {
            $activities->push((object)[
                'type' => 'time',
                'description' => "Logged {$entry->duration_minutes} minutes",
                'created_at' => $entry->created_at
            ]);
        }

        return $activities->sortByDesc('created_at')->take(10);
    }
} 