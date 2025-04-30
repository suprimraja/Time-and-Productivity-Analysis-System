<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Statistics Overview -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="text-gray-500 mb-2">Total Projects</div>
            <div class="stat-value"><?php echo e($totalProjects ?? 0); ?></div>
            <div class="text-sm text-green-500 mt-2">+<?php echo e($newProjects ?? 0); ?> this month</div>
        </div>

        <div class="stat-card">
            <div class="text-gray-500 mb-2">Active Tasks</div>
            <div class="stat-value"><?php echo e($activeTasks ?? 0); ?></div>
            <div class="text-sm text-yellow-500 mt-2"><?php echo e($completedTasks ?? 0); ?> completed</div>
        </div>

        <div class="stat-card">
            <div class="text-gray-500 mb-2">Hours Tracked</div>
            <div class="stat-value"><?php echo e($totalHours ?? 0); ?></div>
            <div class="text-sm text-blue-500 mt-2">This week</div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Projects Overview -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Projects</h3>
                    <a href="<?php echo e(route('projects.index')); ?>" class="text-primary-600 hover:text-primary-700">View All</a>
                </div>

                <div class="space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $recentProjects ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="project-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-gray-800"><?php echo e($project->name); ?></h4>
                                <p class="text-sm text-gray-500"><?php echo e($project->description); ?></p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="badge badge-<?php echo e($project->status === 'completed' ? 'success' : 'warning'); ?>">
                                    <?php echo e(ucfirst($project->status)); ?>

                                </span>
                                <div class="text-sm text-gray-500">
                                    <?php echo e($project->tasks_count); ?> tasks
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>Progress</span>
                                <span><?php echo e($project->progress); ?>%</span>
                            </div>
                            <div class="progress-bar mt-2">
                                <div class="progress-bar-fill" style="width: <?php echo e($project->progress); ?>%"></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-8 text-gray-500">
                        No projects yet. <a href="<?php echo e(route('projects.create')); ?>" class="text-primary-600 hover:text-primary-700">Create your first project</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Activity Feed -->
        <div class="lg:col-span-1">
            <div class="card">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Recent Activity</h3>

                <div class="activity-feed">
                    <?php $__empty_1 = true; $__currentLoopData = $recentActivities ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <?php switch($activity->type):
                                case ('project'): ?>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <?php break; ?>
                                <?php case ('task'): ?>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <?php break; ?>
                                <?php case ('time'): ?>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <?php break; ?>
                                <?php default: ?>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                            <?php endswitch; ?>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800"><?php echo e($activity->description); ?></p>
                            <p class="text-xs text-gray-500"><?php echo e($activity->created_at->diffForHumans()); ?></p>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-8 text-gray-500">
                        No recent activity
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Time Tracking and Productivity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Time Tracking Chart -->
        <div class="card">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Time Tracking Overview</h3>
            <div class="chart-container" style="height: 300px;">
                <!-- Chart will be rendered here -->
                <canvas id="timeTrackingChart"></canvas>
            </div>
        </div>

        <!-- Productivity Metrics section removed -->
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Time Tracking Chart
    const timeTrackingCtx = document.getElementById('timeTrackingChart').getContext('2d');
    new Chart(timeTrackingCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Hours Tracked',
                data: [6, 7, 5, 8, 6, 4, 3],
                borderColor: '#4F46E5',
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(79, 70, 229, 0.1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laravel\resources\views/dashboard.blade.php ENDPATH**/ ?>