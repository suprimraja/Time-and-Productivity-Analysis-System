

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Time Entry Details</h1>
        <div class="flex space-x-2">
            <a href="<?php echo e(route('time-entries.index')); ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Back to Time Entries
            </a>
            <a href="<?php echo e(route('time-entries.edit', $timeEntry)); ?>" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Edit Entry
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Task Information</h2>
                    <p class="text-gray-600 mb-4"><?php echo e($timeEntry->task->title ?? 'No task associated'); ?></p>
                    
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Time Details</h3>
                        <p class="text-gray-600">Start: <?php echo e($timeEntry->start_time->format('M d, Y H:i')); ?></p>
                        <p class="text-gray-600">End: <?php echo e($timeEntry->end_time->format('M d, Y H:i')); ?></p>
                        <p class="text-gray-600">Duration: <?php echo e($timeEntry->duration_minutes ?? 'Not calculated'); ?> minutes</p>
                    </div>
                </div>
                
                <div>
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Description</h3>
                        <p class="text-gray-600"><?php echo e($timeEntry->description ?? 'No description provided'); ?></p>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Additional Information</h3>
                        <p class="text-gray-600">
                            <span class="font-semibold">Billable:</span> 
                            <?php if($timeEntry->is_billable): ?>
                                <span class="text-green-600">Yes</span>
                            <?php else: ?>
                                <span class="text-red-600">No</span>
                            <?php endif; ?>
                        </p>
                        <?php if($timeEntry->efficiency_score): ?>
                        <p class="text-gray-600">
                            <span class="font-semibold">Efficiency Score:</span> <?php echo e($timeEntry->efficiency_score); ?>

                        </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laravel\resources\views/time-entries/show.blade.php ENDPATH**/ ?>