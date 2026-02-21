<?php $__env->startSection('content'); ?>
    <?php echo e($slot); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/clintonngwa/Documents/github/CEMS/resources/views/components/layouts/app.blade.php ENDPATH**/ ?>