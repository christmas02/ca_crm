<form class="tablelist-form" autocomplete="off">
    <div class="mb-3">
        <label for="date-field" class="form-label">Date affectation</label>
        <input name="dateaffect" type="date" id="date-field" class="form-control" data-provider="flatpickr" required data-date-format="d M, Y" data-enable-time required placeholder="Select date" value="<?php echo e(date('Y-m-d')); ?>" />
    </div>
</form>
<table class="table table-nowrap">
    <?php $__currentLoopData = $agents_dispo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agents): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="listagents_dispo">
            <td style="padding: 5px 10px;">
                <span style="display:block;font-weight: bold;text-transform: uppercase;"><?php echo e($agents['firstname'].' '.$agents['lastname']); ?> </span>
                <span style="display:block; color: #07630f;font-style: italic;font-size: 10px;"> <span style="color:red"><?php echo e(count($agents['affectations'])); ?></span>  Affectation(s) en cours</span>
            </td>
            <td style="text-align:right;padding-right: 10px;"><a class="btn btn-primary setliv" data-idagent="<?php echo e($agents['id']); ?>" style="font-weight: bold;" href="#">affecter</a></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>



<?php /**PATH /Users/zekotch/development/laravel_projets/backofficeassurance/resources/views/available_agents.blade.php ENDPATH**/ ?>