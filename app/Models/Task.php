<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'project_id',
        'user_id',
        'parent_task_id',
        'due_date',
        'priority',
        'status',
        'estimated_hours',
        'actual_hours',
        'completed_at'
    ];

    protected $casts = [
        'due_date' => 'date',
        'estimated_hours' => 'integer',
        'actual_hours' => 'integer',
        'completed_at' => 'datetime'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parentTask()
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class);
    }
}
