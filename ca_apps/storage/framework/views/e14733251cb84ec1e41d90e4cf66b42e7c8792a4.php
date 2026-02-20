<?php if(count($histo_rnlist) >0): ?>
    

<table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                                        <thead>



                                        

                                         <tr style="background:lightgray;">
                                                

                                                 <td  colspan="13"><h3 style="text-align:center;"><?php echo e($histo_rnlist[0]['opportunite']['nom'].' '.$histo_rnlist[0]['opportunite']['prenoms']); ?></h3></td>
                                            </tr>

                                        

                                            <tr>
                                                 <th>Date de souscription</th>
                                                 <th>Période souscrite</th>
                                                 <th>Prime Nette souscrite </th>
                                                 <th>Prime Ttc</th>
                                                 <th>Assureur</th>
                                                 <th>Statut</th>
                                                 <th>conseiller(re)</th>
                                                 
                                                
                                                 

                                            </tr>
                                        </thead>
                                        <tbody>

                                               
                                          <?php $__currentLoopData = $histo_rnlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $histo_rnlist_el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                          
                                           
                                          
                                            <tr>
                                                
                                                
                                                
                                                

                                                
                                                <td><?php echo e(\Carbon\Carbon::parse($histo_rnlist_el['created_at'])->format('d-m-Y H:i')); ?></td>
                                                <td><?php echo e($histo_rnlist_el['periode_soucription'].' Mois'); ?></td>
                                                 <td><?php echo e($histo_rnlist_el['primenet']); ?></td>
                                                
                                                 <td><?php echo e($histo_rnlist_el['primettc']); ?></td>
                                               <td><?php echo e($histo_rnlist_el['assureur_actuel']); ?></td>

                                                  <td> 

                                                         <?php if($histo_rnlist_el['resultat'] == 'horscible'|| $histo_rnlist_el['resultat'] == 'horscible_rn'): ?>
                                                            <span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i> <?php echo e($histo_rnlist_el['resultat']); ?></span>
                                                          <?php endif; ?>

                                                           <?php if($histo_rnlist_el['resultat'] == 'reporte'||$histo_rnlist_el['resultat'] == 'reporte_rn'): ?>
                                                            <span class="badge badge-label bg-warning"><i class="mdi mdi-circle-medium"></i> <?php echo e($histo_rnlist_el['resultat']); ?></span>

                                                         <?php endif; ?>


                                                          <?php if($histo_rnlist_el['resultat']== 'perdu'||$histo_rnlist_el['resultat']== 'perdu_rn'): ?>
                                                            <span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i> <?php echo e($histo_rnlist_el['resultat']); ?></span>

                                                         <?php endif; ?>



                                                          <?php if($histo_rnlist_el['resultat']== 'poursuivre'||$histo_rnlist_el['resultat']== 'poursuivre_rn'): ?>
                                                            <span class="badge badge-label bg-dark"><i class="mdi mdi-circle-medium"></i> <?php echo e($histo_rnlist_el['resultat']); ?></span>

                                                         <?php endif; ?>


                                                         <?php if($histo_rnlist_el['resultat']== 'gagne'): ?>
                                                            <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> <?php echo e($histo_rnlist_el['resultat']); ?></span>

                                                         <?php endif; ?>

                                                         <?php if($histo_rnlist_el['resultat']== 'rdvsouscription'||$histo_rnlist_el['resultat']== 'rdvsouscription_rn'): ?>
                                                            <span class="badge badge-label bg-secondary"><i class="mdi mdi-circle-medium"></i> <?php echo e($histo_rnlist_el['resultat']); ?></span>

                                                         <?php endif; ?>

                                                </td>
                                               
                                               

                                                <td><?php echo e($histo_rnlist_el['agent_backoffice']['firstname'].' '.$histo_rnlist_el['agent_backoffice']['lastname']); ?></td>
                                               

                                            </tr>
                                            
                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                      </tbody>
                                  </table>
                                  <?php else: ?>

                                    <p style="text-align:center">Cette opportunité n'a jamais été gagné</p>
                                  <?php endif; ?><?php /**PATH /Users/zekotch/development/laravel_projets/backofficeassurance/resources/views/historique_rn.blade.php ENDPATH**/ ?>