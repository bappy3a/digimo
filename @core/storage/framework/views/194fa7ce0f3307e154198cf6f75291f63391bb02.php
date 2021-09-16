<a tabindex="0" class="btn btn-success btn-xs mb-3 mr-1" role="button" data-toggle="popover" data-trigger="focus" data-html="true" title="" data-content="
   <h6><?php echo e(__('Are you sure to approve it?')); ?></h6>
   <form method='post' action='<?php echo e($url); ?>'>
   <input type='hidden' name='_token' value='<?php echo e(csrf_token()); ?>'>
   <br>
    <input type='submit' class='btn btn-success btn-sm' value='<?php echo e(__('Yes,Please')); ?>'>
    </form>
    " data-original-title="">
    <i class="ti-check"></i>
</a><?php /**PATH /home/xgenxchi/public_html/laravel/nexelit/@core/resources/views/components/backend/payment-approve.blade.php ENDPATH**/ ?>