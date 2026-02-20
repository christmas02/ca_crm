 <option selected value="">Choisir...</option>
<?php $__currentLoopData = $carmodel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

     <?php if(array_key_exists('model', $model)): ?>
     <option value="<?php echo e($model['model'].'-'.$model['car_code']); ?>"><?php echo e($model['model']); ?></option>
     <?php endif; ?>

     <?php if(array_key_exists('libelle', $model)): ?>
     <option value="<?php echo e($model['libelle'].'-'.$model['marque']); ?>"><?php echo e($model['libelle']); ?></option>
     <?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /Users/zekotch/development/laravel_projets/backofficeassurance/resources/views/carmodels.blade.php ENDPATH**/ ?>