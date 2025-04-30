

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Task Details</h1>
        <div class="flex space-x-2">
            <a href="<?php echo e(route('tasks.index')); ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Back to Tasks
            </a>
            <a href="<?php echo e(route('tasks.edit', $task)); ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Edit Task
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2"><?php echo e($task->title); ?></h2>
                    <p class="text-gray-600 mb-4"><?php echo e($task->description); ?></p>
                    
                    <div class="mb-4">
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                            Priority: <?php echo e(ucfirst($task->priority)); ?>

                        </span>
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                            Status: <?php echo e(ucfirst($task->status)); ?>

                        </span>
                    </div>
                </div>
                
                <div>
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Project</h3>
                        <p class="text-gray-600"><?php echo e($task->project->name ?? 'No project assigned'); ?></p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Due Date</h3>
                        <p class="text-gray-600"><?php echo e($task->due_date ? $task->due_date->format('M d, Y') : 'No due date'); ?></p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Time Estimates</h3>
                        <p class="text-gray-600">Estimated: <?php echo e($task->estimated_hours ?? 0); ?> hours</p>
                        <p class="text-gray-600">Actual: <?php echo e($task->actual_hours ?? 0); ?> hours</p>
                    </div>
                </div>
            </div>
            
            <?php if($task->completed_at): ?>
            <div class="mt-4 p-4 bg-green-100 rounded-lg">
                <p class="text-green-800">
                    <span class="font-semibold">Completed on:</span> <?php echo e($task->completed_at->format('M d, Y H:i')); ?>

                </p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if($task->subtasks->count() > 0): ?>
    <div class="mt-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Subtasks</h2>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $task->subtasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subtask): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo e($subtask->title); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e(ucfirst($subtask->status)); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($subtask->due_date ? $subtask->due_date->format('M d, Y') : 'No due date'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="<?php echo e(route('tasks.show', $subtask)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if($task->timeEntries->count() > 0): ?>
    <div class="mt-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Time Entries</h2>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $task->timeEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($entry->start_time->format('M d, Y')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($entry->start_time->format('H:i')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($entry->end_time->format('H:i')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($entry->duration); ?> hours</td>
                        <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($entry->description); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laravel\resources\views/tasks/show.blade.php ENDPATH**/ ?>