  
<?php if(count($findOpportunity)>0): ?>
  

  <?php $__currentLoopData = $findOpportunity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    

  <div class="text-reset notification-item d-block dropdown-item position-relative">
    <div class="d-flex">
      <div class="avatar-xs me-3">
        <span class="avatar-title bg-soft-info text-info rounded-circle fs-16">
          <i class="bx bx-badge-check"></i>
        </span>
      </div>
      <div class="flex-1">
        <a href="/prospection_full_details/<?php echo e($element['id']); ?>" class="stretched-link">
          <h6 class="mt-0 mb-2 lh-base"><b>Client : </b> <?php echo e($element['nom'].' ' .$element['prenoms']); ?> 
            
        </a>
        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
          <span>
            <i class="mdi mdi-clock-outline"></i> <?php echo e($element['created_at']); ?></span>
        </p>
      </div>
     
    </div>
  </div>

  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
 <?php echo e('pas de notifications '); ?>


<?php endif; ?><?php /**PATH /Users/zekotch/development/laravel_projets/backofficeassurance/resources/views/asapnotification.blade.php ENDPATH**/ ?>