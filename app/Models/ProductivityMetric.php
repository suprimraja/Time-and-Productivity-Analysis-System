<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductivityMetric extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'date',
        'tasks_completed',
        'total_time_spent_minutes',
        'productive_time_minutes',
        'productivity_score',
        'breaks_taken',
        'break_time_minutes',
        'focus_time_distribution',
        'task_distribution'
    ];

    protected $casts = [
        'date' => 'date',
        'tasks_completed' => 'integer',
        'total_time_spent_minutes' => 'integer',
        'productive_time_minutes' => 'integer',
        'productivity_score' => 'float',
        'breaks_taken' => 'integer',
        'break_time_minutes' => 'integer',
        'focus_time_distribution' => 'array',
        'task_distribution' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
