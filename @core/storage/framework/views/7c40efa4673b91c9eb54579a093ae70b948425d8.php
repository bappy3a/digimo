<div class="form-group">
    <?php $value = $value ?? get_static_option($name); ?>
    <label for="<?php echo e($name); ?>"><strong><?php echo e($title); ?></strong></label>
    <label class="switch">
        <input type="checkbox" name="<?php echo e($name); ?>"  <?php if($value): ?> checked <?php endif; ?> >
        <span class="slider"></span>
    </label>
</div><?php /**PATH /Users/sharifur/Desktop/sharifur-backup/localhost/nexelit/@core/resources/views/components/backend/switcher.blade.php ENDPATH**/ ?>