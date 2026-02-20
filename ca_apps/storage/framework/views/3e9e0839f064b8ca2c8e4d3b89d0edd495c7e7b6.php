 
    <?php $__env->startSection('headerCss'); ?>

   <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">


    <!-- Layout config Js -->
    <script src="/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="/assets/css/custom.min.css" rel="stylesheet" type="text/css" />


    <?php
        

        $affbtnexp='non';
        $usersprivileges = Session::get('userprivilege_list');
        $privarray=  Session::get('userprivilege_list');

        // dd($usersprivileges);
        if (in_array(25, $usersprivileges)) {
            // code...
             $affbtnexp ='oui';
        }
    ?>

    <?php $__env->stopSection(); ?>

 

     <?php $__env->startSection('content'); ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">RELANCES EN COURS</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                        <li class="breadcrumb-item active">Datatables</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                     

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Enregistrements</h5>
                                </div>


                                <div id="filterform" class="row gy-4" style="padding-left: 20px;background: #f2f2f2;margin: 15px;">
                                    <h2>FORMULAIRE DE RECHERCHE</h2>
                                    
                                     <div class="col-md-2">
                                        <label for="basiInput" class="form-label">Filtre </label>
                                         <select id="selectfiltre" class="form-select mb-3" aria-label="Default select example">
                                            <option selected>choisir un filtre</option>
                                            <option value="tel">Telephone</option>
                                            <option value="clientname">Nom ou prenoms</option>
                                            <option value="date">Date Relance</option>
                                            <option value="date_ech">Date Echeance</option>
                                            <option value="agent_ech">Agent - Echeance</option>
                                            <option value="agent">Agent - Relance</option>
                                            
                                        </select>
                                    </div> 





                                        
                                    <div class="col-md-10">
                                    <form id="formnamefield" method="POST" action="/filter_opp_name_admin"  class="col-md-7" style="display:none">
                                            <?php echo csrf_field(); ?>
                                            <div   style=" display: inline-block;width: 170px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Nom ou Prénoms</label>
                                                    <input id="namefilter" type="text" name="namefilter" class="form-control requiredField" id="basiInput" required>
                                                </div>
                                            </div>
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>

                                    </form>
                                      

                                      
                                    <form id="formtelfield" method="POST" action="/filter_opp_tel_admin"  class="col-md-7" style="display:none;">
                                            <?php echo csrf_field(); ?>
                                            <div   style=" display: inline-block;width: 170px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Téléphone</label>
                                                    <input id="telfiltre" type="text" name="telfiltre" class="form-control requiredField " id="basiInput" required>
                                                </div>
                                            </div>
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>
                                    </form>

                                    <form id="formdate_ech_field" method="POST" action="/filter_opp_echeance_admin"  class="col-md-7" style="display:none">
                                            <?php echo csrf_field(); ?>
                                            <div style=" display: inline-block;width: 170px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Date echeance debut</label>
                                                    <input id="datedebut" type="date" name="datedebut" class="form-control requiredField" id="basiInput" required>
                                                </div>
                                            </div> 

                                            <div   style=" display: inline-block;width: 170px;margin-left: 20px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Date echeance fin</label>
                                                    <input id="datefin" type="date" name="datefin" class="form-control requiredField" id="basiInput" required>
                                                </div>
                                            </div> 
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>
                                    </form> 



                                    <form id="formdatefield" method="POST" action="/filter_opp_relance_admin"  class="col-md-7" style="display:none">
                                            <?php echo csrf_field(); ?>
                                            <div style=" display: inline-block;width: 170px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Date relance debut</label>
                                                    <input id="datedebut" type="date" name="datedebut" class="form-control requiredField" id="basiInput" required>
                                                </div>
                                            </div> 

                                            <div   style=" display: inline-block;width: 170px;margin-left: 20px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Date relance fin</label>
                                                    <input id="datefin" type="date" name="datefin" class="form-control requiredField" id="basiInput" required>
                                                </div>
                                            </div> 
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>
                                    </form> 



                                    <form id="formagentfield" method="POST" action="/filter_opp_agent_relance_admin"  class="col-md-10" style="display:none">
                                            <?php echo csrf_field(); ?>

                                             <div class="col-md-2" style=" display: inline-block;margin-right:15px;">
                                                <label for="basiInput" class="form-label"> Agents </label>
                                                 <select id="selectagent" name="selectagent" class="form-select mb-3" aria-label="Default select example" required>
                                                    <option selected>choisir un agent</option>
                                                    <option value="tous">TOUS</option>
                                                    <?php $__currentLoopData = $listecommerciaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listecommerciaux_el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        
                                                         <option value="<?php echo e($listecommerciaux_el['id']); ?>"><?php echo e(strtoupper($listecommerciaux_el['firstname'].' ' .$listecommerciaux_el['lastname'])); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div style=" display: inline-block;width: 170px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Date relance debut</label>
                                                    <input id="datedebut" type="date" name="datedebut" class="form-control requiredField" id="basiInput" required>
                                                </div>
                                            </div> 

                                            <div   style=" display: inline-block;width: 170px;margin-left: 20px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Date relance fin</label>
                                                    <input id="datefin" type="date" name="datefin" class="form-control requiredField" id="basiInput" required>
                                                </div>
                                            </div> 
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>

                                             

                                             
                                    </form> 


                                    <form id="form_agent_date_ech" method="POST" action="/filter_opp_agent_echeance_admin"  class="col-md-10" style="display:none">
                                            <?php echo csrf_field(); ?>

                                             <div class="col-md-2" style=" display: inline-block;margin-right:15px;">
                                                <label for="basiInput" class="form-label"> Agents </label>
                                                 <select id="selectagent" name="selectagent" class="form-select mb-3" aria-label="Default select example" required>
                                                    <option selected>choisir un agent</option>
                                                    <option value="tous">TOUS</option>
                                                    <?php $__currentLoopData = $listecommerciaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listecommerciaux_el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        
                                                         <option value="<?php echo e($listecommerciaux_el['id']); ?>"><?php echo e(strtoupper($listecommerciaux_el['firstname'].' ' .$listecommerciaux_el['lastname'])); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div style=" display: inline-block;width: 170px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Date échéance debut</label>
                                                    <input id="datedebut" type="date" name="datedebut" class="form-control requiredField" id="basiInput" required>
                                                </div>
                                            </div> 

                                            <div   style=" display: inline-block;width: 170px;margin-left: 20px;">
                                                <div>
                                                    <label for="basiInput" class="form-label">Date échéance fin</label>
                                                    <input id="datefin" type="date" name="datefin" class="form-control requiredField" id="basiInput" required>
                                                </div>
                                            </div> 
                                            <div  style=" display: inline-block;margin-left: 20px;">
                                                <div class="mb-3">
                                                    <label class="form-label" style="display:block;">&nbsp;</label>
                                                    <button style="width:120px" type="submit"  class="btn btn-primary">FILTRER</button>
                                                </div>
                                            </div>

                                           
                                    </form> 





                                    </div>

                                    <div id="massaffectationbloc" class="col-md-12" style="margin-top:0px;margin-bottom:15px;display: none;">
                                                <a style="width:170px;display:inline-block;height: 38px;" id="massaffectation" class="btn btn-dark">Reaffecter en masse </a>
                                                <span style="display:inline-block;margin-left:10px"><span id="nbppopp">0 </span>  opportunités selectionées</span>
                                         </div>
                                         
                                         
                                        
                                </div>


                                <div class="card-body">
                                    <table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                                        <thead>



                                            <?php if(!empty($foundagent) && !empty($filtre) ): ?>
                                      <tr style="background:lightgray;">
                                                <td  colspan="13"><h4 style="text-align:center;">Opportunites - Filtre - [ <?php echo e($foundagent[0]['firstname'].' '.$foundagent[0]['lastname']); ?>]<span style="font-weight:bold"><?php echo e($filtre); ?> DEBUT:</span> <span><?php echo e(\Carbon\Carbon::parse($datedebut)->format('d-m-Y')); ?></span> <span style="font-weight:bold"><?php echo e($filtre); ?> FIN: </span> <span><?php echo e(\Carbon\Carbon::parse($datefin)->format('d-m-Y')); ?></span></h4></td>
                                            </tr>

                                        <?php elseif(!empty($selectedagent) && $selectedagent == 'tous' && !empty($filtre)): ?>
                                      <tr style="background:lightgray;">
                                                <td  colspan="13"><h4 style="text-align:center;">Opportunites - Filtre - [Tous] <span style="font-weight:bold"><?php echo e($filtre); ?> DEBUT:</span> <span><?php echo e(\Carbon\Carbon::parse($datedebut)->format('d-m-Y')); ?></span> <span style="font-weight:bold"><?php echo e($filtre); ?> FIN: </span> <span><?php echo e(\Carbon\Carbon::parse($datefin)->format('d-m-Y')); ?></span></h4></td>
                                            </tr>


                                        <?php elseif(!empty($telfiltre) ): ?>
                                            <tr style="background:lightgray;">
                                                    <td  colspan="13"><h4 style="text-align:center;">Opportunites - Filtre - [Telephone] : <span style="font-weight:bold"><?php echo e($telfiltre); ?></span></h4></td>
                                                </tr> 


                                         <?php elseif(!empty($namefilter) ): ?>
                                            <tr style="background:lightgray;">
                                                    <td  colspan="13"><h4 style="text-align:center;">Opportunites - Filtre - [Nom ou Prénom] : <span style="font-weight:bold"><?php echo e($namefilter); ?></span></h4></td>
                                                </tr>

                                        
                                         <?php elseif(!empty($plaquefilter) ): ?>
                                            <tr style="background:lightgray;">
                                                    <td  colspan="13"><h4 style="text-align:center;">Opportunites - Filtre - [Plaque] : <span style="font-weight:bold"><?php echo e($plaquefilter); ?></span></h4></td>
                                                </tr>

                                         <?php else: ?> 

                                         <tr style="background:lightgray;">
                                                <td  colspan="13"><h3 style="text-align:center;">Opportunites</h3></td>
                                            </tr>

                                        <?php endif; ?>

                                            <tr>
                                                 <th>Plaque Imm.</th>
                                                 <th data-orderable="false"> 
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="cardtableChecker">
                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>
                                                 </th>
                                                 <th>Nom</th>
                                                 <th>Prenoms</th>
                                                 <th>Echeance</th>
                                                 <th>Date Relance</th>
                                                 <th>Heure Relance</th>
                                                 <th>Date affectation</th>
                                                 <th>Telephone</th>
                                                 <th>Statut</th>
                                                 <th>Observation</th> 
                                                 <th>Agent en charge</th>
                                                  <th><i style="font-size: 24px;" class="ri-tools-fill"></i></th>
                                                 

                                            </tr>
                                        </thead>
                                        <tbody>

                                               
                                          <?php $__currentLoopData = $liste_relances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $liste_relances_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                          
                                            <?php if($liste_relances_element['opportunite']['isvisible']==1): ?>
                                                
                                          
                                            <tr>
                                                
                                                <td><?php echo e($liste_relances_element['opportunite']['plaque_immatriculation']  ?? 'Non defini'); ?></td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input checkboxOpp" type="checkbox" value="<?php echo e($liste_relances_element['opportunite']['id'] .'|'. $liste_relances_element['echeance'] .'|'. \Carbon\Carbon::parse($liste_relances_element['daterelance'])->format('d-m-Y') .'|'.\Carbon\Carbon::parse($liste_relances_element['heure_relance'])->format('H:i:s')  .'|'. $liste_relances_element['primenet'].'|'. $liste_relances_element['primettc'].'|'. $liste_relances_element['periode_soucription'].'|'. $liste_relances_element['assureur_actuel']); ?>" >
                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>
                                                </td>
                                                <td><?php echo e($liste_relances_element['opportunite']['nom']); ?></td>
                                                <td><?php echo e($liste_relances_element['opportunite']['prenoms']); ?></td>
                                                <td data-sort="<?php echo e(\Carbon\Carbon::parse($liste_relances_element['echeance'])->format('Y-m-d')); ?>"><?php echo e(\Carbon\Carbon::parse($liste_relances_element['echeance'])->format('d-m-Y')); ?></td>
                                                <td data-sort="<?php echo e($liste_relances_element['daterelance']); ?>"><?php echo e(\Carbon\Carbon::parse($liste_relances_element['daterelance'])->format('d-m-Y')); ?></td>
                                                 <td data-sort="<?php echo e($liste_relances_element['heure_relance']); ?>"><?php echo e(\Carbon\Carbon::parse($liste_relances_element['heure_relance'])->format(' H:i:s')); ?></td>
                                                
                                                 <td><?php echo e(is_null($liste_relances_element['date_affect']) ? ' - ': \Carbon\Carbon::parse($liste_relances_element['date_affect'])->format('d-m-Y H:i:s')); ?></td>
                                                <td>
                                                    <a href="tel:<?php echo e($liste_relances_element['opportunite']['telephone']); ?>"><?php echo e($liste_relances_element['opportunite']['telephone']); ?></a>
                                                </td>

                                                  <td> 

                                                         <?php if($liste_relances_element['resultat'] == 'horscible'|| $liste_relances_element['resultat'] == 'horscible_rn'): ?>
                                                            <span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i> <?php echo e($liste_relances_element['resultat']); ?></span>
                                                          <?php endif; ?>

                                                           <?php if($liste_relances_element['resultat'] == 'reporte'||$liste_relances_element['resultat'] == 'reporte_rn'): ?>
                                                            <span class="badge badge-label bg-warning"><i class="mdi mdi-circle-medium"></i> <?php echo e($liste_relances_element['resultat']); ?></span>

                                                         <?php endif; ?>


                                                          <?php if($liste_relances_element['resultat']== 'perdu'||$liste_relances_element['resultat']== 'perdu_rn'): ?>
                                                            <span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i> <?php echo e($liste_relances_element['resultat']); ?></span>

                                                         <?php endif; ?>



                                                          <?php if($liste_relances_element['resultat']== 'poursuivre'||$liste_relances_element['resultat']== 'poursuivre_rn'): ?>
                                                            <span class="badge badge-label bg-dark"><i class="mdi mdi-circle-medium"></i> <?php echo e($liste_relances_element['resultat']); ?></span>

                                                         <?php endif; ?>


                                                         <?php if($liste_relances_element['resultat']== 'gagne'): ?>
                                                            <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> <?php echo e($liste_relances_element['resultat']); ?></span>

                                                         <?php endif; ?>

                                                         <?php if($liste_relances_element['resultat']== 'rdvsouscription'||$liste_relances_element['resultat']== 'rdvsouscription_rn'): ?>
                                                            <span class="badge badge-label bg-secondary"><i class="mdi mdi-circle-medium"></i> <?php echo e($liste_relances_element['resultat']); ?></span>

                                                         <?php endif; ?>

                                                </td>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                                <a href="#" role="button" id="<?php echo e($liste_relances_element['opportunite']['id']); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                                  Afficher     <i class="ri-eye-fill"></i>
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="<?php echo e($liste_relances_element['opportunite']['id']); ?>" style="padding: 10px;min-width: 300px;border: solid 2px #40518959;">
                                                                    <?php echo e($liste_relances_element['opportunite']['observation']); ?>

                                                                </div>
                                                            </div>

                                                </td>

                                                <td><?php echo e($liste_relances_element['agent_backoffice']['firstname'].' '.$liste_relances_element['agent_backoffice']['lastname']); ?></td>
                                                <td>

                                                     <div class="dropdown">
                                                                <a href="#" role="button" id="<?php echo e($liste_relances_element['opportunite']['id']); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i style="font-size: 16px;" class="ri-settings-4-line"></i>
                                                                </a>

                                                                <ul class="dropdown-menu" aria-labelledby="<?php echo e($liste_relances_element['opportunite']['id']); ?>">
                                                                    <li> <a class="dropdown-item" href="/enregister_note_propection/<?php echo e($liste_relances_element['opportunite']['id']); ?>"> <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Commenter</a></li>
                                                                    <li><a class="dropdown-item attrib_btn" href="#" data-bs-toggle="modal" data-type-aff="2"  data-opp="<?php echo e($liste_relances_element['opportunite']['id'] .'|'. $liste_relances_element['opportunite']['echeance'] .'|'. \Carbon\Carbon::parse($liste_relances_element['daterelance'])->format('d-m-Y') .'|'.\Carbon\Carbon::parse($liste_relances_element['heure_relance'])->format('H:i:s') .'|'. $liste_relances_element['primenet'].'|'. $liste_relances_element['primettc'].'|'. $liste_relances_element['periode_soucription'].'|'. $liste_relances_element['assureur_actuel']); ?>">  <i class=" ri-arrow-left-right-line align-bottom me-2 text-muted"></i> Reaffecter</a></li>

                                                                     <li> <a class="dropdown-item histo_rn_btn"href="#"data-opp="<?php echo e($liste_relances_element['opportunite']['id']); ?>"> <i class="ri-stack-line align-bottom me-2 text-muted"></i> Historique RN</a></li>

                                                                     <?php if(in_array(37, $privarray)): ?>
                                                                       
                                                                  
                                                                     <li class="dropdown-divider"></li>

                                                                    <li><a class="dropdown-item delete_btn " href="#" data-bs-toggle="modal"  data-opp="<?php echo e($liste_relances_element['idopportunite']); ?>">  <i class=" ri-delete-bin-fill align-bottom me-2 text-muted"></i> Supprimer</a></li>
                                                                      <?php endif; ?>
                                                                   
                                                                </ul>
                                                            </div>


                                                </td>

                                            </tr>
                                            <?php endif; ?>
                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                          

                                           <?php $__currentLoopData = $liste_reaffectations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $liste_reaffectations_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(empty($liste_reaffectations_element['commentaire']) && count($liste_reaffectations_element['opportunite']) > 0 &&  $liste_reaffectations_element['opportunite']['isvisible']==1): ?>
                                                
                                            <tr>
                                                <td><?php echo e($liste_reaffectations_element['opportunites'][0]['plaque_immatriculation'] ?? 'Non defini'); ?></td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input checkboxOpp" type="checkbox" value="<?php echo e($liste_reaffectations_element['opportunite']['id'] .'|'. $liste_reaffectations_element['echeance'] .'|'. \Carbon\Carbon::parse($liste_reaffectations_element['daterelance'])->format('d-m-Y') .'|'.\Carbon\Carbon::parse($liste_reaffectations_element['heure_relance'])->format('H:i:s').'|'. $liste_reaffectations_element['primenet'].'|'. $liste_reaffectations_element['primettc'].'|'. $liste_reaffectations_element['periode_soucription'].'|'. $liste_reaffectations_element['assureur_actuel']); ?>" >

                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>
                                                </td>
                                                <td><?php echo e($liste_reaffectations_element['opportunite']['nom']); ?></td>
                                                <td><?php echo e($liste_reaffectations_element['opportunite']['prenoms']); ?></td>
                                                

                                                <td><?php echo e(\Carbon\Carbon::parse($liste_reaffectations_element['echeance'])->format('d-m-Y')); ?></td>
                                                <td><?php echo e(\Carbon\Carbon::parse($liste_reaffectations_element['daterelance'])->format('d-m-Y')); ?></td>
                                                 <td><?php echo e(\Carbon\Carbon::parse($liste_reaffectations_element['heure_relance'])->format(' H:i:s')); ?></td>

                                                 <td><?php echo e(is_null($liste_reaffectations_element['date_affect']) ? ' - ': \Carbon\Carbon::parse($liste_reaffectations_element['date_affect'])->format('d-m-Y H:i:s')); ?></td>

                                                <td>
                                                <a href="tel:<?php echo e($liste_reaffectations_element['opportunite']['telephone']); ?>"><?php echo e($liste_reaffectations_element['opportunite']['telephone']); ?></a>
                                                </td> 
                                                <td> 
                                                    
                                                   
                                                  
                                                        
                                                   

                                                         <?php if($liste_reaffectations_element['resultat'] == 'horscible'||$liste_reaffectations_element['resultat']== 'horscible_rn'): ?>
                                                            <span class="badge badge-label bg-info"><i class="mdi mdi-circle-medium"></i> <?php echo e($liste_reaffectations_element['resultat']); ?></span>
                                                          <?php endif; ?>

                                                           <?php if($liste_reaffectations_element['resultat'] == 'reporte'||$liste_reaffectations_element['resultat']== 'reporte_rn'): ?>
                                                            <span class="badge badge-label bg-warning"><i class="mdi mdi-circle-medium"></i> <?php echo e($liste_reaffectations_element['resultat']); ?></span>

                                                         <?php endif; ?>


                                                          <?php if($liste_reaffectations_element['resultat']== 'perdu' ||$liste_reaffectations_element['resultat']== 'perdu_rn'): ?>
                                                            <span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i> <?php echo e($liste_reaffectations_element['resultat']); ?></span>

                                                         <?php endif; ?>



                                                          <?php if($liste_reaffectations_element['resultat']== 'poursuivre'||$liste_reaffectations_element['resultat']== 'poursuivre_rn'): ?>
                                                            <span class="badge badge-label bg-dark"><i class="mdi mdi-circle-medium"></i> <?php echo e($liste_reaffectations_element['resultat']); ?></span>

                                                         <?php endif; ?>


                                                         <?php if($liste_reaffectations_element['resultat']== 'gagne'): ?>

                                                            <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> <?php echo e($liste_reaffectations_element['resultat']); ?></span>

                                                         <?php endif; ?>


                                                          <?php if($liste_reaffectations_element['resultat']== 'rdvsouscription' ||$liste_reaffectations_element['resultat']== 'rdvsouscription_rn'): ?>
                                                            <span class="badge badge-label bg-secondary"><i class="mdi mdi-circle-medium"></i> <?php echo e($liste_reaffectations_element['resultat']); ?></span>

                                                         <?php endif; ?>

                                                     
                                                </td>
                                                </td>
                                               

                                                <td><div class="dropdown">
                                                                <a href="#" role="button" id="<?php echo e($liste_reaffectations_element['opportunite']['id']); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                                  Afficher     <i class="ri-eye-fill"></i>
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="<?php echo e($liste_reaffectations_element['opportunite']['id']); ?>" style="padding: 10px;min-width: 300px;border: solid 2px #40518959;">
                                                                    <?php echo e($liste_reaffectations_element['opportunite']['observation']); ?>

                                                                </div>
                                                            </div></td>
                                                <td><?php echo e($liste_reaffectations_element['agent_backoffice']['firstname'] .' '.$liste_reaffectations_element['agent_backoffice']['lastname']); ?></td>
                                                
                                                <td>

                                                    <div class="dropdown">
                                                                <a href="#" role="button" id="<?php echo e($liste_reaffectations_element['opportunite']['id']); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i style="font-size: 16px;" class="ri-settings-4-line"></i>
                                                                </a>

                                                                <ul class="dropdown-menu" aria-labelledby="<?php echo e($liste_reaffectations_element['opportunite']['id']); ?>">
                                                                    <li> <a class="dropdown-item" href="/enregister_note_propection/<?php echo e($liste_reaffectations_element['opportunite']['id']); ?>"> <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Commenter</a></li>
                                                                    <li><a class="dropdown-item attrib_btn" href="#" data-bs-toggle="modal" data-type-aff="2"   data-opp="<?php echo e($liste_reaffectations_element['opportunite']['id'] .'|'. $liste_reaffectations_element['opportunite']['echeance'] .'|'. \Carbon\Carbon::parse($liste_reaffectations_element['daterelance'])->format('d-m-Y') .'|'.\Carbon\Carbon::parse($liste_reaffectations_element['heure_relance'])->format('H:i:s').'|'. $liste_reaffectations_element['primenet'].'|'. $liste_reaffectations_element['primettc'].'|'. $liste_reaffectations_element['periode_soucription'].'|'. $liste_reaffectations_element['assureur_actuel']); ?>">  <i class=" ri-arrow-left-right-line align-bottom me-2 text-muted"></i> Reaffecter</a></li>


                                                                     <li> <a class="dropdown-item histo_rn_btn"  data-opp="<?php echo e($liste_reaffectations_element['opportunite']['id']); ?>"> <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Historique RN</a></li>

                                                                    <?php if(in_array(37, $privarray)): ?>
                                                                       
                                                                  
                                                                     <li class="dropdown-divider"></li>

                                                                    <li><a class="dropdown-item delete_btn " href="#" data-bs-toggle="modal"  data-opp="<?php echo e($liste_reaffectations_element['idopportunite']); ?>">  <i class=" ri-delete-bin-fill align-bottom me-2 text-muted"></i> Supprimer</a></li>
                                                                      <?php endif; ?>
                                                                    
                                                                </ul>
                                                            </div>


                                                </td>

                                            </tr>
                                            <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          

                                          
                                          <?php $__currentLoopData = $nouvelle_opp; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nouvelle_opp_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php if(empty($nouvelle_opp_element['commentaire']) && count($nouvelle_opp_element['opportunites']) > 0 && $nouvelle_opp_element['opportunites'][0]['isvisible']==1 ): ?>
                                                
                                            <tr>
                                                <td><?php echo e($nouvelle_opp_element['opportunites'][0]['plaque_immatriculation'] ?? 'Non defini'); ?></td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input checkboxOppaff" type="checkbox" value="<?php echo e($nouvelle_opp_element['idopportunite']); ?>" >
                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>
                                                </td>
                                                <td><?php echo e($nouvelle_opp_element['opportunites'][0]['nom']); ?></td>
                                                <td><?php echo e($nouvelle_opp_element['opportunites'][0]['prenoms']); ?></td>
                                                <td data-sort="<?php echo e(\Carbon\Carbon::parse($nouvelle_opp_element['opportunites'][0]['echeance'])->format('Y-m-d')); ?>"
                                                
                                                ><?php echo e(\Carbon\Carbon::parse($nouvelle_opp_element['opportunites'][0]['echeance'])->format('d-m-Y')); ?></td>

                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>

                                                <td>
                                                    <a href="tel:<?php echo e($nouvelle_opp_element['opportunites'][0]['telephone']); ?>"><?php echo e($nouvelle_opp_element['opportunites'][0]['telephone']); ?></a>

                                               </td> 
                                                <td> 
                                                    
                                                   
                                                    <?php if(!empty($nouvelle_opp_element['commentaire'] && count($nouvelle_opp_element['commentaire']) > 0)): ?>
                                                        
                                                   

                                                         <?php if($nouvelle_opp_element['commentaires'][0]['resultat'] == 'horscible'): ?>
                                                            <span class="badge badge-label bg-info"><i class="mdi mdi-circle-medium"></i> <?php echo e($nouvelle_opp_element['commentaires'][0]['resultat']); ?></span>
                                                          <?php endif; ?>

                                                           <?php if($nouvelle_opp_element['commentaires'][0]['resultat'] == 'reporte'): ?>
                                                            <span class="badge badge-label bg-warning"><i class="mdi mdi-circle-medium"></i> <?php echo e($nouvelle_opp_element['commentaires'][0]['resultat']); ?></span>

                                                         <?php endif; ?>


                                                          <?php if($nouvelle_opp_element['commentaires'][0]['resultat']== 'perdu'): ?>
                                                            <span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i> <?php echo e($nouvelle_opp_element['commentaires'][0]['resultat']); ?></span>

                                                         <?php endif; ?>



                                                          <?php if($nouvelle_opp_element['commentaires'][0]['resultat']== 'poursuivre'): ?>
                                                            <span class="badge badge-label bg-dark"><i class="mdi mdi-circle-medium"></i> <?php echo e($nouvelle_opp_element['commentaires'][0]['resultat']); ?></span>

                                                         <?php endif; ?>


                                                         <?php if($nouvelle_opp_element['commentaires'][0]['resultat']== 'gagne'): ?>

                                                            <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> <?php echo e($nouvelle_opp_element['commentaires'][0]['resultat']); ?></span>

                                                         <?php endif; ?>

                                                         <?php if($nouvelle_opp_element['commentaires'][0]['resultat']== 'rdvsouscription'): ?>
                                                            <span class="badge badge-label bg-secondary"><i class="mdi mdi-circle-medium"></i> <?php echo e($nouvelle_opp_element['commentaires'][0]['resultat']); ?></span>

                                                         <?php endif; ?>

                                                     <?php else: ?>

                                                      <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> Opportunité Nouvelle</span>


                                                      <?php endif; ?>
                                                </td>
                                                </td>
                                               

                                                <td><div class="dropdown">
                                                                <a href="#" role="button" id="<?php echo e($nouvelle_opp_element['opportunites'][0]['id']); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                                  Afficher     <i class="ri-eye-fill"></i>
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="<?php echo e($nouvelle_opp_element['opportunites'][0]['id']); ?>" style="padding: 10px;min-width: 300px;border: solid 2px #40518959;">
                                                                    <?php echo e($nouvelle_opp_element['opportunites'][0]['observation']); ?>

                                                                </div>
                                                            </div></td>
                                                <td><?php echo e($nouvelle_opp_element['agent_backoffice'][0]['firstname'] .' '.$nouvelle_opp_element['agent_backoffice'][0]['lastname']); ?></td>
                                               
                                                <td>
                                                  
                                                    <div class="dropdown">
                                                                <a href="#" role="button" id="<?php echo e($nouvelle_opp_element['opportunites'][0]['id']); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i style="font-size: 16px;" class="ri-settings-4-line"></i>
                                                                </a>

                                                                <ul class="dropdown-menu" aria-labelledby="<?php echo e($nouvelle_opp_element['opportunites'][0]['id']); ?>">
                                                                    <li> <a class="dropdown-item" href="/enregister_note_propection/<?php echo e($nouvelle_opp_element['opportunites'][0]['id']); ?>"> <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Commenter</a></li>
                                                                    <li><a class="dropdown-item attrib_btn" data-type-aff="1" href="#" data-bs-toggle="modal"  data-opp="<?php echo e($nouvelle_opp_element['idopportunite']); ?>">  <i class=" ri-arrow-left-right-line align-bottom me-2 text-muted"></i> affecter</a></li>
                                                                    




                                                                    <?php if(in_array(37, $privarray)): ?>
                                                                       
                                                                  
                                                                     <li class="dropdown-divider"></li>

                                                                    <li><a class="dropdown-item delete_btn " href="#" data-bs-toggle="modal"  data-opp="<?php echo e($nouvelle_opp_element['idopportunite']); ?>">  <i class=" ri-delete-bin-fill align-bottom me-2 text-muted"></i> Supprimer</a></li>
                                                                      <?php endif; ?>
                                                                </ul>
                                                            </div>



                                                </td>

                                            </tr>
                                            <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                          <?php $__currentLoopData = $listeprospectioncreated; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listeprospectioncreated_el): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <?php if(empty($listeprospectioncreated_el['commentaires'])): ?>
                                                
                                           
                                            <tr>
                                                
                                                <td><?php echo e($listeprospectioncreated_el['plaque_immatriculation']?? 'Non defini'); ?></td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input checkboxOppaff" type="checkbox" value="<?php echo e($listeprospectioncreated_el['id']); ?>" >
                                                        <label class="form-check-label" for="cardtableCheck01"></label>
                                                    </div>
                                                </td>
                                                <td><?php echo e($listeprospectioncreated_el['nom']); ?></td>
                                                <td><?php echo e($listeprospectioncreated_el['prenoms']); ?></td>

                                                <td ><?php echo e(\Carbon\Carbon::parse($listeprospectioncreated_el['echeance'])->format('d-m-Y')); ?></td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                 <td>
                                                    <a href="tel:<?php echo e($listeprospectioncreated_el['telephone']); ?>"><?php echo e($listeprospectioncreated_el['telephone']); ?></a>
                                                 </td>
                                                
                                                
                                                <td> <?php if(!empty($listeprospectioncreated_el['commentaires'] && count($listeprospectioncreated_el['commentaires']) > 0)): ?>
                                                        
                                                   

                                                         <?php if($listeprospectioncreated_el['commentaires'][0]['resultat'] == 'horscible'): ?>
                                                            <span class="badge badge-label bg-info"><i class="mdi mdi-circle-medium"></i> <?php echo e($listeprospectioncreated_el['commentaires'][0]['resultat']); ?></span>
                                                          <?php endif; ?>

                                                           <?php if($listeprospectioncreated_el['commentaires'][0]['resultat'] == 'reporte'): ?>
                                                            <span class="badge badge-label bg-warning"><i class="mdi mdi-circle-medium"></i> <?php echo e($listeprospectioncreated_el['commentaires'][0]['resultat']); ?></span>

                                                         <?php endif; ?>


                                                          <?php if($listeprospectioncreated_el['commentaires'][0]['resultat']== 'perdu'): ?>
                                                            <span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i> <?php echo e($listeprospectioncreated_el['commentaires'][0]['resultat']); ?></span>

                                                         <?php endif; ?>



                                                          <?php if($listeprospectioncreated_el['commentaires'][0]['resultat']== 'poursuivre'): ?>
                                                            <span class="badge badge-label bg-dark"><i class="mdi mdi-circle-medium"></i> <?php echo e($listeprospectioncreated_el['commentaires'][0]['resultat']); ?></span>

                                                         <?php endif; ?>


                                                         <?php if($listeprospectioncreated_el['commentaires'][0]['resultat']== 'gagne'): ?>
                                                           

                                                            <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> <?php echo e($listeprospectioncreated_el['commentaires'][0]['resultat']); ?></span>

                                                         <?php endif; ?>


                                                         <?php if($listeprospectioncreated_el['commentaires'][0]['resultat']== 'rdvsouscription'): ?>
                                                            <span class="badge badge-label bg-secondary"><i class="mdi mdi-circle-medium"></i> <?php echo e($listeprospectioncreated_el['commentaires'][0]['resultat']); ?></span>

                                                         <?php endif; ?>

                                                     <?php else: ?>

                                                      <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> Opportunité Nouvelle</span>


                                                      <?php endif; ?>
                                                  </td>
                                                <td>
                                                    


                                                    <div class="dropdown">
                                                                <a href="#" role="button" id="<?php echo e($listeprospectioncreated_el['id']); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                                  Afficher     <i class="ri-eye-fill"></i>
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="<?php echo e($listeprospectioncreated_el['id']); ?>" style="padding: 10px;min-width: 300px;border: solid 2px #40518959;">
                                                                    <?php echo e($listeprospectioncreated_el['observation']); ?>

                                                                </div>
                                                            </div>



                                                </td>
                                                <?php if(!is_null($listeprospectioncreated_el['agent_enligne'])): ?>
                                                    
                                              
                                                <td><?php echo e($listeprospectioncreated_el['agent_enligne']['firstname'] .' '.$listeprospectioncreated_el['agent_enligne']['lastname']); ?></td>
                                                <?php else: ?>
                                                <td>-</td>
                                                  <?php endif; ?>
                                               
                                                
                                                
                                                <td>

                                                    <div class="dropdown">
                                                                <a href="#" role="button" id="<?php echo e($listeprospectioncreated_el['id']); ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i style="font-size: 16px;" class="ri-settings-4-line"></i>
                                                                </a>

                                                                <ul class="dropdown-menu" aria-labelledby="<?php echo e($listeprospectioncreated_el['id']); ?>">
                                                                    <li> <a class="dropdown-item" href="/enregister_note_propection/<?php echo e($listeprospectioncreated_el['id']); ?>"> <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Commenter</a></li>
                                                                    <li><a class="dropdown-item attrib_btn" href="#" data-bs-toggle="modal" data-type-aff="1"  data-opp="<?php echo e($listeprospectioncreated_el['id']); ?>"><i class=" ri-arrow-left-right-line align-bottom me-2 text-muted"></i> Affecter</a></li>
                                                                    
                                                                </ul>
                                                            </div>

                                                   
                                                </td>

                                                

                                            </tr>
                                             <?php endif; ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->


                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


                                        <div>
                                            <div id="agentdispo" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Affectation</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="content_liv_pop">
                                                           
                                                            <table class="table table-nowrap">
                                                            <tr style="background:#e2e2e2;">
                                                                <td style="padding: 5px 10px;">
                                                                    <span style="display:block;font-weight: bold">Veuillez patienter...</span>
                                                                </td>
                                                               
                                                            </tr>
                                                            
                                                        </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                           
                                                        </div>

                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        </div>



                                        <div>
                                            <div id="show_histo_rn" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Historique RN</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="content_histo_rn">
                                                           
                                                            <table class="table table-nowrap">
                                                            <tr style="background:#e2e2e2;">
                                                                <td style="padding: 5px 10px;">
                                                                    <span style="display:block;font-weight: bold">Veuillez patienter...</span>
                                                                </td>
                                                               
                                                            </tr>
                                                            
                                                        </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                           
                                                        </div>

                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        </div>



                                         <div>
                                            <div id="agentdispo_mass" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Affectation</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body" id="content_liv_pop_mass">
                                                           
                                                            <table class="table table-nowrap">
                                                            <tr style="background:#e2e2e2;">
                                                                <td style="padding: 5px 10px;">
                                                                    <span style="display:block;font-weight: bold;text-align:center">Veuillez patienter...</span>
                                                                   
                                                                </td>
                                                                
                                                            </tr>
                                                           
                                                        </table>
                                                        </div>
                                                        <div class="modal-footer">
                                                           
                                                        </div>

                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        </div>



                                        <!-- Static Backdrop -->
                                        
                                        <!-- staticBackdrop Modal -->
                                        <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center p-5">
                                                        <lord-icon
                                                            src="https://cdn.lordicon.com/lupuorrc.json"
                                                            trigger="loop"
                                                            colors="primary:#121331,secondary:#08a88a"
                                                            style="width:120px;height:120px">
                                                        </lord-icon>
                                                        
                                                        <div class="mt-4">
                                                            <h4 class="mb-3">Opération réussie!</h4>
                                                            <p class="text-muted mb-4"> L'affectation s'est effectuées avec succès </p>
                                                            <div class="hstack gap-2 justify-content-center">
                                                                <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Fermer</a>
                                                                <a href="javascript:void(0);" class="btn btn-success">OK</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                     <div class="modal fade" id="firstmodal" aria-hidden="true" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center p-5">
                                                            <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#red,secondary:#405189" style="width:130px;height:130px"></lord-icon>
                                                            <div class="mt-4 pt-4">
                                                                <h4>Supprimer l'opportunité.</h4>
                                                                <p class="text-muted"> Voulez vraiment faire cette suppression ?</p>
                                                                <!-- Toogle to second dialog -->
                                                                <button class="btn btn-warning" data-bs-dismiss="modal">
                                                                    Non
                                                                </button>
                                                                <button id="canceller" class="btn btn-danger" >
                                                                    Oui 
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
   


                

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © Velzon.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by Themesbrand
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
     <?php $__env->stopSection(); ?>



    

    <!-- JAVASCRIPT -->
    <?php $__env->startSection('footerCss'); ?>
        <!-- JAVASCRIPT -->

    <script type="text/javascript">
         var affibtn = '<?php echo $affbtnexp;?>';
        </script>
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>
    <script src="/assets/libs/feather-icons/feather.min.js"></script>
    <script src="/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="/assets/js/plugins.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="/assets/js/pages/datatables.init.js"></script>
    <!-- App js -->
    <script src="/assets/js/app.js"></script>
        <script src="/assets/js/app.js"></script>


        <script>

            var check_reaf_aff = 1;// 1 pour affectation 2 pour reaffecation

            var currentOpp =0;
             $(document).on('click','.attrib_btn', function(e){
                   e.preventDefault();  
                 currentOpp = $(this).attr('data-opp');
                 check_reaf_aff = $(this).attr('data-type-aff');

                console.log(check_reaf_aff);
                   
               $.ajax({
                type : "GET",
                url : '/find_available_agent',
                // data: {donnee:donnee},   
                success : function(r) {
                  $('#content_liv_pop').html(r);
                  $('#agentdispo').modal('show');
                  $('#numcom').html(currentOpp);
                }
              })
            });  


            $(document).on('click','.histo_rn_btn', function(e){
                   e.preventDefault();  
                 currentOpp = $(this).attr('data-opp');

             $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                   
               $.ajax({
                type : "POST",
                url : '/find_histo_rn',
                data: {idopp:currentOpp},   
                success : function(r) {
                  $('#content_histo_rn').html(r);
                  $('#show_histo_rn').modal('show');
                  // $('#numcom').html(currentOpp);
                }
              })
            });  



             $(document).on('click','.setliv', function(e){
                   e.preventDefault();  
                   // var numcmd = $(this).attr('data-com');
                   var id_agent = $(this).attr('data-idagent');
                   var dateaffect = $('input[name="dateaffect"]').val();
                   var btnclicked = $(this);


                   console.log(check_reaf_aff);


                         $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                          });

                          if (check_reaf_aff == 2){
                           $.ajax({
                            type : "POST",
                            data: {numopp:currentOpp, id_agent: id_agent, dateaffect: dateaffect},
                            url : '/reaff_newnote',
                            // data: {donnee:donnee},   
                            success : function(r) {
                              if(r=='inserted') {
                                $('#agentdispo').modal('hide');
                                $('#successModal').modal('show');
                                setTimeout(function(){
                                   location.reload(true);
                                }, 3000);
                                
                              }
                                
                            }
                          });
                       }

                           if (check_reaf_aff == 1){
                        $.ajax({
                            type : "POST",
                            data: {numopp:currentOpp, id_agent: id_agent},
                            url : '/attrib_opportunite',
                            // data: {donnee:donnee},   
                            beforeSend: function() {
                                        btnclicked.addClass('not-active').html('Patienter...'); 
                                                
                                            },
                            success : function(r) {
                              if(r=='inserted') {
                                $('#agentdispo').modal('hide');
                                $('#successModal').modal('show');

                                // setTimeout(function(){
                                //    location.reload(true);
                                // }, 3000);
                                
                              }
                                
                            }
                          })
                       }
              });   
                    
          $('#selectfiltre').on('change', function(e) {
               typefiltre = $(this).val();
           
              if (typefiltre == 'tel') {
                  $("#formtelfield").css('display','block');  
                   $("#formagentfield").css('display','none'); 
                  $("#formdatefield").css('display','none');   
                   $("#formnamefield").css('display','none');  
                  $("#formdate_ech_field").css('display','none');  
                  $("#form_agent_date_ech").css('display','none');  
                    
                  
                  //datasend ={tel:inputTel};
              }
              if (typefiltre == 'date') {
                  $("#formtelfield").css('display','none');  
                   $("#formagentfield").css('display','none'); 
                  $("#formdatefield").css('display','block');
                   $("#formnamefield").css('display','none');   
                  $("#formdate_ech_field").css('display','none'); 
                  $("#form_agent_date_ech").css('display','none');   
              } 

              if (typefiltre == 'agent') {
                  $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','none'); 
                  $("#formagentfield").css('display','block'); 
                  $("#formnamefield").css('display','none');
                  $("#formdate_ech_field").css('display','none'); 
                  $("#form_agent_date_ech").css('display','none');      
                  
              } 


               if (typefiltre == 'clientname') {
                  $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','none'); 
                 $("#formagentfield").css('display','none'); 
                  $("#formnamefield").css('display','block');   
                  $("#formdate_ech_field").css('display','none');   
                  $("#form_agent_date_ech").css('display','none'); 
              } 


               if (typefiltre == 'clientname') {
                  $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','none'); 
                  $("#formagentfield").css('display','none'); 
                  $("#formnamefield").css('display','block');   
                  $("#formdate_ech_field").css('display','none');  
                  $("#form_agent_date_ech").css('display','none'); 
              }   

              

               if (typefiltre == 'date_ech') {
                  $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','none'); 
                  $("#formagentfield").css('display','none'); 
                  $("#formnamefield").css('display','none');   
                  $("#formdate_ech_field").css('display','block'); 
                  $("#form_agent_date_ech").css('display','none');   
                  
              }

              if(typefiltre == 'agent_ech'){

                 $("#form_agent_date_ech").css('display','block'); 
                 $("#formtelfield").css('display','none');  
                  $("#formdatefield").css('display','none'); 
                  $("#formagentfield").css('display','none'); 
                  $("#formnamefield").css('display','none');   
                  $("#formdate_ech_field").css('display','none'); 
              }


              
          })     


        
         var liste_opp = [];
         var liste_opp_reaf= [];
         var affUrl ='/reaff_newnote_mass';
        $(document).on('click','#massaffectation', function(e){
                $.ajax({
                        type : "GET",
                        url : '/find_available_agent_mass',
                        success : function(r) {
                          $('#content_liv_pop_mass').html(r);
                        }
                      })

             $('#agentdispo_mass').modal('show');

        })

      

        

            $('#cardtableChecker').change(function() {
                if(this.checked) {
                     $('.checkboxOpp:visible').prop('checked', true);
                     $('.checkboxOppaff:visible').prop('checked', true);
                      // liste_opp.push($(this).val());
                         liste_opp = [];
                         liste_opp_reaf = [];
                        $('.checkboxOpp:visible').each(function() {
                             liste_opp.push($(this).val());
                        });

                         $('.checkboxOppaff:visible').each(function() {
                             liste_opp_reaf.push($(this).val());
                        });

                         console.log(liste_opp.length + liste_opp_reaf.length);

                         $("#nbppopp").html(liste_opp.length + liste_opp_reaf.length);
                      $("#massaffectationbloc").css("display",'block'); 
                }else{
                    liste_opp = [];
                    liste_opp_reaf = [];
                 $('.checkboxOpp:visible').prop('checked', false);  
                 $('.checkboxOppaff:visible').prop('checked', false);  
                 $("#massaffectationbloc").css("display",'none');     
                }
            });

            $('.checkboxOpp').each(function() {
                var el =$(this);

            el.on('change', function(e) {
                var element =  $(this).val();
                         if(this.checked) {
                            liste_opp.push($(this).val());

                            
                            
                            affUrl='reaff_newnote_mass'


                            if(liste_opp.length > 0){
                                $("#massaffectationbloc").css("display",'block');
                                $("#nbppopp").html(liste_opp.length + liste_opp_reaf.length);
                            }else
                             $("#massaffectationbloc").css("display",'none');
                         }else{
                            liste_opp = jQuery.grep(liste_opp, function (value) {
                                return value != element;
                            });
                            $("#nbppopp").html(liste_opp.length + liste_opp_reaf.length);
                            if(liste_opp.length + liste_opp_reaf.length <= 1){
                                $("#massaffectationbloc").css("display",'none');
                                $("#nbppopp").html(0);

                            }

                         }
                })
            })


            $('.checkboxOppaff').each(function() {
                var el =$(this);

            el.on('change', function(e) {
                var element =  $(this).val();
                         if(this.checked) {
                            liste_opp_reaf.push($(this).val());

                             
                             affUrl='attrib_opportunite_mass';

                            if(liste_opp_reaf.length > 0){
                                $("#massaffectationbloc").css("display",'block');
                                $("#nbppopp").html(liste_opp_reaf.length + liste_opp.length);
                            }else
                             $("#massaffectationbloc").css("display",'none');
                         }else{
                            liste_opp_reaf = jQuery.grep(liste_opp_reaf, function (value) {
                                return value != element;
                            });
                            $("#nbppopp").html(liste_opp_reaf.length+ + liste_opp.length);
                            if(liste_opp_reaf.length + liste_opp.length <= 1){
                                $("#massaffectationbloc").css("display",'none');
                                $("#nbppopp").html(0);

                            }

                         }
                })
            })

            



        $(document).on('click','.setlivmass', function(e){
            console.log(affUrl);
                   e.preventDefault();  
                   // var numcmd = $(this).attr('data-com');
                   var id_agent = $(this).attr('data-idagent');
                   var btnclicked = $(this);
                   var dateaffect = $('input[name="dateaffect"]').val();

                         $.ajaxSetup({
                              headers: {
                                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                          });

                         if (liste_opp.length > 0 ){
                           $.ajax({
                            type : "POST",
                            data: {arraylist:liste_opp, id_agent: id_agent,dateaffect: dateaffect},
                            url : '/reaff_newnote_mass',
                            // data: {donnee:donnee},   
                            beforeSend: function() {
                                                btnclicked.addClass('not-active').html('Patienter...'); 
                                            },
                            success : function(r) {
                              if(r=='inserted') {
                                liste_opp = [];
                                $('#agentdispo_mass').modal('hide');
                                $('#successModal').modal('show');
                                setTimeout(function(){
                                   location.reload(true);
                                }, 3000);
                                
                              }
                                
                            }
                          })

                        }
                       if (liste_opp_reaf.length > 0 ){

                            $.ajax({
                                    type : "POST",
                                    data: {arraylist:liste_opp_reaf, id_agent: id_agent},
                                    url : '/attrib_opportunite_mass',
                                    // data: {donnee:donnee},   
                                    success : function(r) {
                                      if(r=='inserted') {
                                        liste_opp = [];
                                        $('#agentdispo_mass').modal('hide');
                                        $('#successModal').modal('show');
                                        setTimeout(function(){
                                           location.reload(true);
                                        }, 3000);
                                        
                                      }
                                        
                                    }
                                  })

                        }



              }); 



             $(document).on('click','.delete_btn', function(e){
                   e.preventDefault();  
                // currentOpp = $(this).attr('data-opp');
                  var elmt= $(this);
                  $("#firstmodal").modal('show');
                  var selectedOpp=elmt.attr('data-opp');
                  console.log(selectedOpp);
                 $("#canceller").attr("data-delete",selectedOpp); 
            }); 


            

               $(document).on('click','#canceller', function(e){
               e.preventDefault();
      
                var elmt= $(this);
                var todelete=elmt.attr('data-delete');
               // var datas='todelete='+todelete;

                 $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                      });
                  $.ajax({
                          type: "post",
                          url: "/removeopp",
                          data: {data_rem :todelete},
                          success: function (data) {
                               $('#firstmodal').modal('hide');
                               if(data =='inserted'){
                               location.reload();
                              }
                          }
                  });

                });

        
        </script>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/zekotch/development/laravel_projets/backofficeassurance/resources/views/liste_opportunite_admin.blade.php ENDPATH**/ ?>