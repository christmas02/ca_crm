

 <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">


                       

                        <?php
                            $usersprivileges = Session::get('userprivilege_list');
                             // dd($usersprivileges);
                            $menu_agent_bo = array(1, 2, 3, 4);
                            $menu_opp = array(5, 6, 7, 8,9);
                            $menu_bordereau = array(17, 18, 19, 20 ,21 ,22 ,24);
                            $menu_dossier_encours = array(10, 11, 12, 13 ,14 ,15 ,16, 30, 31);
                            $menu_stat = array(23);
                            $menu_tarif = array(27);
                             $menu_argus = array(33, 34, 35, 36);
                            // if(count(array_intersect($menu_agent_bo, $usersprivileges))>0){
                            //     echo 'kdkfkdj';
                            // }
                        ?>

                       
                     <?php if(count(array_intersect($menu_agent_bo, $usersprivileges))>0): ?>
                        
                       <li class="menu-title"><span data-key="t-menu">General</span></li>
                            <li class="nav-item">
                                <a <?php if($currentPage == 'createuserform' ||$currentPage == 'create_agent_enligne' || $currentPage == 'liste_agent_enligne' || $currentPage == 'liste_agent_terrain' ||  $currentPage == 'edit_online_operator/{idop}' ||  $currentPage == 'edit_terrain_operator/{idop}'): ?> class="nav-link menu-link active" aria-expanded="true" <?php else: ?> class="nav-link menu-link collapsed" aria-expanded="false" <?php endif; ?> href="#sidebarDashboards" data-bs-toggle="collapse" role="button"  aria-controls="sidebarDashboards">
                                    <i class="ri-account-circle-line"></i> <span data-key="t-dashboards" style="font-weight: bold;">AGENTS BACKOFFICE</span>
                                </a>
                                <div <?php if($currentPage == 'createuserform' ||$currentPage == 'create_agent_enligne' || $currentPage == 'liste_agent_enligne' || $currentPage == 'liste_agent_terrain' ||  $currentPage == 'edit_online_operator/{idop}' ||  $currentPage == 'edit_terrain_operator/{idop}' ): ?> class="collapse menu-dropdown show" <?php else: ?> class="collapse menu-dropdown " <?php endif; ?> id="sidebarDashboards">
                                    <ul class="nav nav-sm flex-column">

                                         <?php if(in_array(1, $usersprivileges)): ?> 
                                        <li class="nav-item">
                                            <a href="/createuserform" <?php if($currentPage == 'createuserform'): ?> class=" nav-link  active" <?php else: ?> class="nav-link" <?php endif; ?>  data-key="t-crm">Créer un agent Terrain </a>
                                        </li>
                                        <?php endif; ?>

                                         <?php if(in_array(2, $usersprivileges)): ?> 
                                        <li class="nav-item">
                                            <a href="/create_agent_enligne" <?php if($currentPage == 'create_agent_enligne'): ?> class=" nav-link  active" <?php else: ?> class="nav-link" <?php endif; ?>  data-key="t-crm">Créer Agent en ligne</a>
                                        </li>
                                        <?php endif; ?>

                                        <li class="nav-item">
                                            <a href="/create_assureur" <?php if($currentPage == 'create_assureur'): ?> class=" nav-link  active" <?php else: ?> class="nav-link" <?php endif; ?>  data-key="t-crm">Créer un assureur</a>
                                        </li>

                                         <?php if(in_array(3, $usersprivileges)): ?> 
                                        <li class="nav-item">
                                            <a href="/liste_agent_enligne" <?php if($currentPage == 'liste_agent_enligne'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-ecommerce"> Liste des agents en ligne </a>
                                        </li>
                                        <?php endif; ?>
                                         <?php if(in_array(4, $usersprivileges)): ?> 
                                        <li class="nav-item">
                                            <a href="/liste_agent_terrain" <?php if($currentPage == 'liste_agent_terrain'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-ecommerce"> Liste des agents Terrain </a>
                                        </li>
                                        <?php endif; ?>
                                        <li class="nav-item">
                                            <a href="/liste_assureur" <?php if($currentPage == 'liste_assureur'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-ecommerce"> Liste Assureurs </a>
                                        </li>
                                    </ul>
                                </div>
                            </li> <!-- end Dashboard Menu -->
                            <?php endif; ?>
                            
                            <?php if(count(array_intersect($menu_opp, $usersprivileges))>0): ?> 
                            <li class="nav-item">
                                <a  <?php if($currentPage == 'createcanal' ||$currentPage == 'enregister_propection' || $currentPage == 'listeprosprection' || $currentPage == 'importopportunites'|| $currentPage == 'listeprosprection_doublon'|| $currentPage == 'listeprosprectionbyteldoublon' || $currentPage == 'listeprosprection_doublonbydate'  ): ?> class="nav-link menu-link active" aria-expanded="true" <?php else: ?> class="nav-link menu-link collapsed" aria-expanded="false" <?php endif; ?> href="#sidebarApps" data-bs-toggle="collapse" role="button"  aria-controls="sidebarApps">
                                    <i class="ri-apps-2-line"></i> <span data-key="t-apps" style="font-weight: bold;">OPPORTUNITES</span>
                                </a>
                                <div <?php if($currentPage == 'createcanal' ||$currentPage == 'enregister_propection' || $currentPage == 'listeprosprection' || $currentPage == 'importopportunites'|| $currentPage == 'listeprosprection_doublon' || $currentPage == 'listeprosprectionbyteldoublon' || $currentPage == 'listeprosprection_doublonbydate'): ?> class="collapse menu-dropdown show" <?php else: ?> class="collapse menu-dropdown " <?php endif; ?> id="sidebarApps">
                                    <ul class="nav nav-sm flex-column">


                                    <?php if(in_array(5, $usersprivileges)): ?> 
                                        
                                        <li class="nav-item">
                                            <a href="/enregister_propection" <?php if($currentPage == 'enregister_propection'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-crypto"> Creér une opportunité </a>
                                        </li>
                                    <?php endif; ?>

                                      <?php if(in_array(6, $usersprivileges)): ?> 
                                        <li class="nav-item">
                                            <a href="/importopportunites" <?php if($currentPage == 'importopportunites'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-crypto">Importer des opportunités</a>
                                        </li>

                                     <?php endif; ?>

                                     <?php if(in_array(7, $usersprivileges)): ?> 
                                        <li class="nav-item">
                                            <a href="/createcanal" <?php if($currentPage == 'createcanal'): ?> class=" nav-link  active" <?php else: ?> class="nav-link" <?php endif; ?>  data-key="t-crm">Creer un canal </a>
                                        </li>
                                     <?php endif; ?>


                                     <?php if(in_array(8, $usersprivileges)): ?> 

                                        <li class="nav-item">
                                            <a href="/listeprosprection" <?php if($currentPage == 'listeprosprection'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-crypto"> Opportunités remontées </a>
                                        </li>

                                     <?php endif; ?>

                                    <?php if(in_array(9, $usersprivileges)): ?> 
                                        <li class="nav-item">
                                            <a href="/listeprosprection_doublon" <?php if($currentPage == 'listeprosprection_doublon' || $currentPage == 'listeprosprectionbyteldoublon' || $currentPage == 'listeprosprection_doublonbydate'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-crypto"> Opportunités doublons </a>
                                        </li>
                                    <?php endif; ?>
                                    </ul>
                                </div>
                            </li>
                            <?php endif; ?>
                       
               
         
                       


                            
                        <?php if(count(array_intersect($menu_dossier_encours, $usersprivileges))>0): ?> 
                        <li class="nav-item">
                            <a <?php if($currentPage == 'liste_prospection_byagent' || $currentPage == 'liste_prospection_byagent_relance' || $currentPage == 'liste_prospection_byagent_ferme' || $currentPage == 'liste_contrat_byagent' || $currentPage == 'liste_contrat_byagent_admin' || $currentPage == 'filter_contrat_byagent_admin'|| $currentPage == 'filter_contrat_byclientname_admin'|| $currentPage == 'filter_contrat_bytel_admin'|| $currentPage == 'filter_contrat_echeance_admin'|| $currentPage == 'filter_contrat_relance_admin'|| $currentPage == 'liste_prospection_groupee' || $currentPage=='findoppbytel'|| $currentPage=='findoppbyname'|| $currentPage=='findoppbyimmatricul' ||  $currentPage=='retrouver_opportunite' || $currentPage=='opportunite_admin' || $currentPage == 'opportunite_agent' || $currentPage=='filter_opp_agent_relance_admin'||  $currentPage=='filter_opp_tel_admin'|| $currentPage=='filter_opp_name_admin' || $currentPage=='filter_opp_echeance_admin' || $currentPage=='filter_opp_relance_admin'|| $currentPage == 'filter_opp_agent_echeance_admin'): ?> class="nav-link menu-link active" aria-expanded="true" <?php else: ?> class="nav-link menu-link collapsed" <?php endif; ?> href="#sidebarLayouts" data-bs-toggle="collapse" role="button"  aria-controls="sidebarLayouts">
                                <i class="ri-layout-3-line"></i> <span data-key="t-layouts" style="font-weight: bold;">DOSSIERS EN COURS</span> 
                            </a>
                            <div <?php if($currentPage == 'liste_prospection_byagent' || $currentPage == 'liste_prospection_byagent_relance' || $currentPage == 'liste_prospection_byagent_ferme' || $currentPage == 'liste_contrat_byagent' || $currentPage == 'liste_contrat_byagent_admin'|| $currentPage == 'filter_contrat_byagent_admin'|| $currentPage == 'filter_contrat_byclientname_admin'|| $currentPage == 'filter_contrat_bytel_admin' || $currentPage == 'filter_contrat_echeance_admin'|| $currentPage == 'filter_contrat_relance_admin'|| $currentPage == 'liste_prospection_groupee' || $currentPage=='retrouver_opportunite' || $currentPage=='findoppbytel'|| $currentPage=='findoppbyname'|| $currentPage=='findoppbyimmatricul' ||  $currentPage=='liste_prospection_byagent_relance_admin' || $currentPage=='liste_reaffectation_datee_admin'|| $currentPage=='liste_reaffectation_datee_byagent'|| $currentPage=='filter_reaffectation_bydate'|| $currentPage=='liste_reaffectation_datee_byagent'|| $currentPage=='opportunite_admin' || $currentPage=='filter_opp_tel_admin'|| $currentPage=='filter_opp_name_admin' || $currentPage=='filter_opp_echeance_admin' || $currentPage=='filter_opp_relance_admin'|| $currentPage == 'opportunite_agent' || $currentPage == 'filter_opp_agent_echeance_admin'|| $currentPage=='filter_opp_echeance_agent' ||$currentPage=='filter_opp_relance_agent'|| $currentPage=='filter_opp_tel_agent'|| $currentPage=='filter_opp_name_agent'|| $currentPage=='liste_contrat_byagent_bydate'): ?> class="collapse menu-dropdown show" <?php else: ?> class="collapse menu-dropdown " <?php endif; ?> id="sidebarLayouts">
                                <ul class="nav nav-sm flex-column">





                                    <?php if(in_array(13, $usersprivileges)): ?> 

                                      

                                         <li class="nav-item">
                                            <a href="/opportunite_admin" <?php if($currentPage == 'opportunite_admin' || $currentPage =='opportunite_admin'|| $currentPage=='opportunite_admin' || $currentPage=='filter_opp_tel_admin'|| $currentPage=='filter_opp_name_admin' || $currentPage=='filter_opp_echeance_admin' || $currentPage=='filter_opp_relance_admin' || $currentPage=='filter_opp_agent_relance_admin' || $currentPage=='filter_opp_agent_echeance_admin' ): ?> class=" nav-link  active" <?php else: ?> class="nav-link" <?php endif; ?>  data-key="t-crm"> Opportunites </a>
                                        </li>

                                    <?php endif; ?>

                                    

                                   

                                    <?php if(in_array(15, $usersprivileges)): ?> 
                                    <li class="nav-item">
                                        <a href="/liste_contrat_byagent_admin" <?php if($currentPage == 'liste_contrat_byagent_admin'): ?> class=" nav-link  active" <?php else: ?> class="nav-link" <?php endif; ?>  data-key="t-crm">Affectation RN</a>
                                    </li>
                                    <?php endif; ?>


                                     <?php if(in_array(10, $usersprivileges)): ?> 
                                     

                                    <li class="nav-item">
                                        <a href="/opportunite_agent" <?php if($currentPage == 'opportunite_agent' || $currentPage=='filter_opp_echeance_agent' ||$currentPage=='filter_opp_relance_agent'|| $currentPage=='filter_opp_tel_agent'|| $currentPage=='filter_opp_name_agent'): ?> class=" nav-link  active" <?php else: ?> class="nav-link" <?php endif; ?>  data-key="t-crm">Mes Opportunites</a>
                                    </li>


                                    <?php endif; ?>

                                   

                                    

                                     <?php if(in_array(12, $usersprivileges)): ?> 
                                    <li class="nav-item">
                                        <a href="/liste_contrat_byagent" <?php if($currentPage == 'liste_contrat_byagent' || $currentPage == 'filter_contrat_byagent_admin'|| $currentPage == 'filter_contrat_byclientname_admin'|| $currentPage == 'filter_contrat_bytel_admin'|| $currentPage == 'filter_contrat_echeance_admin'|| $currentPage == 'filter_contrat_relance_admin'|| $currentPage == 'liste_contrat_byagent_bydate'): ?> class=" nav-link  active" <?php else: ?> class="nav-link" <?php endif; ?>  data-key="t-crm">Renouvellements</a>
                                    </li>
                                     <?php endif; ?>

                                      <?php if(in_array(16, $usersprivileges)): ?> 
                                      <li class="nav-item">
                                        <a href="/retrouver_opportunite" <?php if($currentPage == 'retrouver_opportunite' || $currentPage=='findoppbytel'|| $currentPage=='findoppbyname'|| $currentPage=='findoppbyimmatricul'): ?> class=" nav-link  active" <?php else: ?> class="nav-link" <?php endif; ?>  data-key="t-crm">Retrouver une opportunité</a>
                                    </li>
                                    <?php endif; ?>


                                    <?php if(in_array(24, $usersprivileges)): ?> 
                                    <li class="nav-item">
                                        <a href="/liste_prospection_byagent_ferme" <?php if($currentPage == 'liste_prospection_byagent_ferme' || $currentPage =='filter_prospection_ferme_tel'|| $currentPage == 'filter_prospection_ferme_nom'): ?> class=" nav-link  active" <?php else: ?> class="nav-link" <?php endif; ?>  data-key="t-crm">Opportunités Perdues</a>
                                    </li>
                                    <?php endif; ?>


                                     <?php if(in_array(16, $usersprivileges)): ?> 
                                     <li class="nav-item">
                                        <a href="/liste_prosprection_created_online" <?php if($currentPage == 'liste_prosprection_created_online'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-crypto"> Opportunités créees par agent</a>
                                    </li>
                                    <?php endif; ?>

                                     <?php if(in_array(31, $usersprivileges)): ?> 
                                     
                                    <?php endif; ?>

                                     <?php if(in_array(30, $usersprivileges)): ?>  
                                    
                                    <?php endif; ?>


                                </ul>
                            </div>
                        </li> <!-- end Dashboard Menu -->

                         <?php endif; ?>



                        


                      
                       <?php if(count(array_intersect($menu_bordereau, $usersprivileges))>0): ?> 
                        <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Admin</span></li>

                        <li class="nav-item">
                            <a <?php if($currentPage == 'liste_contrat' || $currentPage == 'liste_prospection_ferme'|| $currentPage == 'bordereaux_contrat_condense' || $currentPage == 'bordereaux_rapport_operateur'|| $currentPage == 'details_contrats_byagent/{idop}' ): ?> class="nav-link menu-link active" aria-expanded="true" <?php else: ?> class="nav-link menu-link collapsed" <?php endif; ?> href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                                <i class="ri-pie-chart-line"></i> <span data-key="t-authentication" style="font-weight: bold;">BORDEREAUX</span>
                            </a>
                            


                            <div <?php if($currentPage == 'liste_contrat' || $currentPage == 'bordereaux_rapport_operateur' || $currentPage == 'bordereaux_contrat_condense' || $currentPage == 'bordereaux_contrat_condense'|| $currentPage == 'filter_contrat_condenses'|| $currentPage == 'filter_bordereau_rapport_operateur' || $currentPage == 'liste_prospection_ferme' || $currentPage == 'details_contrats_byagent/{idop}'|| $currentPage == 'details_contrats_byagent/{idop}/{datedebut}/{datefin}'|| $currentPage == 'details_remontes_agent/{idop}'|| $currentPage == 'bordereaux_opp_agent_terrain'|| $currentPage == 'qualification_agent_terrain' || $currentPage== 'filter_bordereau_ag_terrain' || $currentPage == 'filter_qualif_ag_terrain'|| $currentPage == 'cg_non_verif'|| $currentPage =='filter_prospection_ferme_tel'|| $currentPage =='filter_prospection_ferme_nom' || $currentPage =='recap_stat_opp'|| $currentPage =='filter_recap_stat_opp' || $currentPage =='opportunite_supprimees' ): ?> class="collapse menu-dropdown show" <?php else: ?> class="collapse menu-dropdown " <?php endif; ?> id="sidebarAuth">
                                <ul class="nav nav-sm flex-column">

                                     <?php if(in_array(17, $usersprivileges)): ?> 

                                     
                                     <?php endif; ?>

                                     <?php if(in_array(18, $usersprivileges)): ?> 
                                     <li class="nav-item">
                                        <a href="/qualification_agent_terrain" <?php if($currentPage == 'qualification_agent_terrain'|| $currentPage == 'filter_qualif_ag_terrain' ): ?> class=" nav-link  active" <?php else: ?> class="nav-link" <?php endif; ?>  data-key="t-crm">Bordereau Agent Terrain</a>
                                    </li>
                                     <?php endif; ?>

                                     <?php if(in_array(19, $usersprivileges)): ?> 
                                    <li class="nav-item">
                                        <a href="/bordereaux_rapport_operateur" <?php if($currentPage == 'bordereaux_rapport_operateur' || $currentPage == 'filter_bordereau_rapport_operateur' ): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-ecommerce"> Bordereau Operateur</a>
                                    </li>
                                     <?php endif; ?>

                                     <?php if(in_array(20, $usersprivileges)): ?> 
                                    <li class="nav-item">
                                        <a href="/bordereaux_contrat_condense" <?php if($currentPage == 'bordereaux_contrat_condense'|| $currentPage == 'filter_contrat_condenses'|| $currentPage == 'details_contrats_byagent/{idop}'|| $currentPage == 'details_contrats_byagent/{idop}/{datedebut}/{datefin}' ): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-starter">Contrats AN/RN Résumés </a>
                                    </li>
                                     <?php endif; ?>

                                    <?php if(in_array(21, $usersprivileges)): ?> 
                                    <li class="nav-item">
                                        <a href="/liste_contrat" <?php if($currentPage == 'liste_contrat'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-crypto"> Contrats AN/RN detaillés </a>
                                    </li>

                                    <?php endif; ?>


                                     <?php if(in_array(22, $usersprivileges)): ?> 
                                     <li class="nav-item">
                                        <a href="/cg_non_verif" <?php if($currentPage == 'cg_non_verif'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-crypto"> Cartes grises non verifiées</a>
                                    </li>
                                     <?php endif; ?>

                                     <?php if(in_array(24, $usersprivileges)): ?> 
                                     <li class="nav-item">
                                        <a href="/liste_prospection_ferme" <?php if($currentPage == 'liste_prospection_ferme'||$currentPage =='filter_prospection_ferme_tel'|| $currentPage =='filter_prospection_ferme_nom'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-crypto"> Opportunites fermées</a>
                                    </li>
                                     <?php endif; ?>


                                     <li class="nav-item">
                                        <a href="/recap_stat_opp" <?php if($currentPage == 'recap_stat_opp'||$currentPage =='filter_recap_stat_opp'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-crypto"> Bordereau statut Opp.</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="/opportunite_supprimees" <?php if($currentPage == 'opportunite_supprimees'||$currentPage =='filter_opportunite_supprimees'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-crypto"> Bordereau Opp. Supp.</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <?php endif; ?>


                        
                         <?php if(count(array_intersect($menu_stat, $usersprivileges))>0): ?> 
                        <li class="nav-item">
                            <a <?php if($currentPage == 'stat_du_jour' || $currentPage== 'filter_stat'|| $currentPage== 'stat_diagram' || $currentPage == 'stat_compagnie' ): ?> class="nav-link menu-link active" aria-expanded="true" <?php else: ?> class="nav-link menu-link collapsed" <?php endif; ?> href="#sidebarAdvanceUI" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAdvanceUI">
                                <i class="ri-pages-line"></i> <span data-key="t-pages" style="font-weight: bold;">STATISTIQUES</span>
                            </a>
                            <div <?php if($currentPage == 'stat_du_jour' || $currentPage == 'filter_stat'|| $currentPage == 'stat_diagram'||  $currentPage =='stat_renouvellement'||  $currentPage =='filter_stat_renouvellemnt'|| $currentPage == 'stat_compagnie'): ?> class="collapse menu-dropdown show" <?php else: ?> class="collapse menu-dropdown " <?php endif; ?> id="sidebarAdvanceUI">
                                <ul class="nav nav-sm flex-column">
 

                                     <?php if(in_array(23, $usersprivileges)): ?> 
                                    <li class="nav-item">
                                        <a href="/stat_du_jour" <?php if($currentPage == 'stat_du_jour' ||$currentPage == 'filter_stat' ): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-starter"> Stats du jour</a>
                                    </li>
                                      <?php endif; ?>

                                     <li class="nav-item">
                                       
                                        <a href="/stat_renouvellement" <?php if($currentPage == 'stat_renouvellement' ||$currentPage == 'filter_stat_renouvellemnt'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?>  data-key="t-starter"> Stats RN</a>
                                    </li> 

                                     <li class="nav-item">
                                       
                                        <a href="/stat_compagnie" <?php if($currentPage == 'stat_compagnie' ||$currentPage == 'stat_compagnie'): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?>  data-key="t-starter"> Stats Assureur</a>
                                    </li> 

                                    <li class="nav-item">
                                       
                                        <a href="/stat_diagram" <?php if($currentPage == 'stat_diagram' ||$currentPage == 'stat_diagram' ): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?>  data-key="t-starter"> Diagramme</a>
                                    </li> 


                                   
                                    
                                </ul>
                            </div>
                        </li>
                        <?php endif; ?>
                      

                        <?php if(count(array_intersect($menu_tarif, $usersprivileges))>0): ?> 
                        <li class="nav-item">
                            <a <?php if($currentPage == 'formulaire_cotation' || $currentPage =='calcul_cotation' || $currentPage =='lecteur_carte_grise'  ): ?> class="nav-link menu-link active" aria-expanded="true" <?php else: ?> class="nav-link menu-link collapsed" <?php endif; ?> href="#sidebarPages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPages">
                                <i class="ri-stack-line"></i> <span data-key="t-pages" style="font-weight: bold;">TARIFICATEUR</span>
                            </a>
                            <div <?php if($currentPage == 'formulaire_cotation' || $currentPage == 'calcul_cotation' || $currentPage =='lecteur_carte_grise'): ?> class="collapse menu-dropdown show" <?php else: ?> class="collapse menu-dropdown " <?php endif; ?> id="sidebarPages">
                                <ul class="nav nav-sm flex-column">
 

                                     <?php if(in_array(27, $usersprivileges)): ?> 
                                    <li class="nav-item">
                                        <a href="/formulaire_cotation" <?php if($currentPage == 'formulaire_cotation' || $currentPage =='calcul_cotation'  ): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-starter"> Simulation Cotation</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="/formulaire_cotation_sc" <?php if($currentPage == 'formulaire_cotation_sc' || $currentPage =='calcul_cotation'  ): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-starter"> Simulation Manuelle</a>
                                    </li>
                                      <?php endif; ?>

                                  <li class="nav-item">
                                        <a href="/lecteur_carte_grise" <?php if($currentPage == 'lecteur_carte_grise' || $currentPage =='lecteur_carte_grise'  ): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-starter"> Lecteur Carte grise</a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </li>
                      <?php endif; ?>



                       <?php if(count(array_intersect($menu_argus, $usersprivileges))>0): ?> 
                      <li class="nav-item">
                            <a <?php if($currentPage == 'create_car_brand' || $currentPage =='create_car_model' || $currentPage =='create_vehicule'  ): ?> class="nav-link menu-link active" aria-expanded="true" <?php else: ?> class="nav-link menu-link collapsed" <?php endif; ?>  href="#sidebarIcons" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarIcons">
                                <i class="ri-compasses-2-line"></i> <span data-key="t-icons" style="font-weight: bold;">ARGUS</span>
                            </a>
                            <div <?php if($currentPage == 'create_car_brand' || $currentPage == 'create_car_model'|| $currentPage == 'create_vehicule'|| $currentPage == 'vehicule_list'): ?> class="collapse menu-dropdown show" <?php else: ?> class="collapse menu-dropdown " <?php endif; ?> id="sidebarIcons">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="/create_car_brand" <?php if($currentPage == 'create_car_brand' ): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-remix">Ajouter une marque</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/create_car_model" <?php if($currentPage == 'create_car_model' ): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-boxicons">Ajouter un model </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/create_vehicule" <?php if($currentPage == 'create_vehicule' ): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-material-design">Ajouter un vehicule</a>
                                    </li>

                                     <li class="nav-item">
                                        <a href="/vehicule_list" <?php if($currentPage == 'vehicule_list' ): ?> class=" nav-link active" <?php else: ?> class="nav-link" <?php endif; ?> data-key="t-material-design">Liste des vehicules</a>
                                    </li>
                                    
                                </ul>
                            </div>
                        </li>
                        <?php endif; ?>
                       
                    </ul>
                </div>
    <!-- Sidebar -->
 </div>

<?php /**PATH /Users/zekotch/development/laravel_projets/backofficeassurance/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>