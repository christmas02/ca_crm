{{--  @php
    $currentPage = Route::getFacadeRoot()->current()->uri();
    // dd($currentPage);
 @endphp --}}

 <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                       @if (Session::get('userprivilege') == 'niveau1') 
                            <li class="menu-title"><span data-key="t-menu">General</span></li>
                            <li class="nav-item">
                                <a @if ($currentPage == 'createuserform' ||$currentPage == 'create_agent_enligne' || $currentPage == 'liste_agent_enligne' || $currentPage == 'liste_agent_terrain' ||  $currentPage == 'edit_online_operator/{idop}' ||  $currentPage == 'edit_terrain_operator/{idop}') class="nav-link menu-link active" aria-expanded="true" @else class="nav-link menu-link collapsed" aria-expanded="false" @endif href="#sidebarDashboards" data-bs-toggle="collapse" role="button"  aria-controls="sidebarDashboards">
                                    <i class="ri-account-circle-line"></i> <span data-key="t-dashboards" style="font-weight: bold;">AGENTS BACKOFFICE</span>
                                </a>
                                <div @if ($currentPage == 'createuserform' ||$currentPage == 'create_agent_enligne' || $currentPage == 'liste_agent_enligne' || $currentPage == 'liste_agent_terrain' ||  $currentPage == 'edit_online_operator/{idop}' ||  $currentPage == 'edit_terrain_operator/{idop}' ) class="collapse menu-dropdown show" @else class="collapse menu-dropdown " @endif id="sidebarDashboards">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="/createuserform" @if ($currentPage == 'createuserform') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Créer un agent Terrain </a>
                                        </li>


                                         <li class="nav-item">
                                            <a href="/create_agent_enligne" @if ($currentPage == 'create_agent_enligne') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Créer Agent en ligne</a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="/liste_agent_enligne" @if ($currentPage == 'liste_agent_enligne') class=" nav-link active" @else class="nav-link" @endif data-key="t-ecommerce"> Liste des agents en ligne </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="/liste_agent_terrain" @if ($currentPage == 'liste_agent_terrain') class=" nav-link active" @else class="nav-link" @endif data-key="t-ecommerce"> Liste des agents Terrain </a>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </li> <!-- end Dashboard Menu -->
                            @endif
                            
                          
                            <li class="nav-item">
                                <a  @if ($currentPage == 'createcanal' ||$currentPage == 'enregister_propection' || $currentPage == 'listeprosprection' || $currentPage == 'importopportunites'|| $currentPage == 'listeprosprection_doublon'|| $currentPage == 'listeprosprectionbyteldoublon' || $currentPage == 'listeprosprection_doublonbydate'  ) class="nav-link menu-link active" aria-expanded="true" @else class="nav-link menu-link collapsed" aria-expanded="false" @endif href="#sidebarApps" data-bs-toggle="collapse" role="button"  aria-controls="sidebarApps">
                                    <i class="ri-apps-2-line"></i> <span data-key="t-apps" style="font-weight: bold;">OPPORTUNITES</span>
                                </a>
                                <div @if ($currentPage == 'createcanal' ||$currentPage == 'enregister_propection' || $currentPage == 'listeprosprection' || $currentPage == 'importopportunites'|| $currentPage == 'listeprosprection_doublon' || $currentPage == 'listeprosprectionbyteldoublon' || $currentPage == 'listeprosprection_doublonbydate') class="collapse menu-dropdown show" @else class="collapse menu-dropdown " @endif id="sidebarApps">
                                    <ul class="nav nav-sm flex-column">

                                        <li class="nav-item">
                                            <a href="/enregister_propection" @if ($currentPage == 'enregister_propection') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto"> Creér une opportunité </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="/importopportunites" @if ($currentPage == 'importopportunites') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto">Importer des opportunités</a>
                                        </li>

                                        @if (Session::get('userprivilege') == 'niveau1' || Session::get('userprivilege') == 'niveau2') 
                                        
                                            <li class="nav-item">
                                                <a href="/createcanal" @if ($currentPage == 'createcanal') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Creer un canal </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="/listeprosprection" @if ($currentPage == 'listeprosprection') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto"> Opportunités remontées </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="/listeprosprection_doublon" @if ($currentPage == 'listeprosprection_doublon' || $currentPage == 'listeprosprectionbyteldoublon' || $currentPage == 'listeprosprection_doublonbydate') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto"> Opportunités doublons </a>
                                            </li>
                                        @endif
                                      

                                        

                                    </ul>
                                </div>
                            </li>
                       
                        @if (Session::get('userprivilege') != 'niveau1') 
                            {{-- expr --}}
                       



                        <li class="nav-item">
                            <a @if ($currentPage == 'liste_prospection_byagent' || $currentPage == 'liste_prospection_byagent_relance' || $currentPage == 'liste_prospection_byagent_ferme' || $currentPage == 'liste_contrat_byagent' || $currentPage == 'liste_contrat_byagent_admin' || $currentPage == 'filter_contrat_byagent_admin'|| $currentPage == 'filter_contrat_byclientname_admin'|| $currentPage == 'filter_contrat_bytel_admin'|| $currentPage == 'filter_contrat_echeance_admin'|| $currentPage == 'filter_contrat_relance_admin'|| $currentPage == 'liste_prospection_groupee' || $currentPage=='findoppbytel'|| $currentPage=='findoppbyname'|| $currentPage=='findoppbyimmatricul' ||  $currentPage=='retrouver_opportunite') class="nav-link menu-link active" aria-expanded="true" @else class="nav-link menu-link collapsed" @endif href="#sidebarLayouts" data-bs-toggle="collapse" role="button"  aria-controls="sidebarLayouts">
                                <i class="ri-layout-3-line"></i> <span data-key="t-layouts" style="font-weight: bold;">DOSSIERS EN COURS</span> 
                            </a>
                            <div @if ($currentPage == 'liste_prospection_byagent' || $currentPage == 'liste_prospection_byagent_relance' || $currentPage == 'liste_prospection_byagent_ferme' || $currentPage == 'liste_contrat_byagent' || $currentPage == 'liste_contrat_byagent_admin'|| $currentPage == 'filter_contrat_byagent_admin'|| $currentPage == 'filter_contrat_byclientname_admin'|| $currentPage == 'filter_contrat_bytel_admin' || $currentPage == 'filter_contrat_echeance_admin'|| $currentPage == 'filter_contrat_relance_admin'|| $currentPage == 'liste_prospection_groupee' || $currentPage=='retrouver_opportunite' || $currentPage=='findoppbytel'|| $currentPage=='findoppbyname'|| $currentPage=='findoppbyimmatricul' ) class="collapse menu-dropdown show" @else class="collapse menu-dropdown " @endif id="sidebarLayouts">
                                <ul class="nav nav-sm flex-column">



                                     @if (Session::get('userprivilege') == 'niveau2')

                                        <li class="nav-item">
                                            <a href="/liste_prospection_groupee" @if ($currentPage == 'liste_prospection_groupee') class=" nav-link active" @else class="nav-link" @endif data-key="t-ecommerce"> Nouvelles opportunités</a>
                                        </li>

                                    @endif



                                    
                                     @if (Session::get('userprivilege') == 'niveau3')

                                    <li class="nav-item">
                                        <a href="/liste_prospection_byagent" @if ($currentPage == 'liste_prospection_byagent') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm"> Nouvelles Opportunités</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="/liste_prospection_byagent_relance" @if ($currentPage == 'liste_prospection_byagent_relance') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Relances</a>
                                    </li>
                                    @endif

                                     @if (Session::get('userprivilege') == 'niveau2')
                                     <li class="nav-item">
                                        <a href="/liste_prospection_byagent_relance_admin" @if ($currentPage == 'liste_prospection_byagent_relance_admin' || $currentPage =='filter_relance_admin') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Relances en cours</a>
                                    </li>
                                    @endif




                                    <li class="nav-item">
                                        <a href="/liste_prospection_byagent_ferme" @if ($currentPage == 'liste_prospection_byagent_ferme' || $currentPage =='filter_prospection_ferme_tel'|| $currentPage == 'filter_prospection_ferme_nom') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Opportunités Perdues</a>
                                    </li>

                                 @if (Session::get('userprivilege') == 'niveau2')
                                     {{-- expr --}}
                               
                                    <li class="nav-item">
                                        <a href="/liste_contrat_byagent_admin" @if ($currentPage == 'liste_contrat_byagent_admin') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Renouvellements</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="/retrouver_opportunite" @if ($currentPage == 'retrouver_opportunite' || $currentPage=='findoppbytel'|| $currentPage=='findoppbyname'|| $currentPage=='findoppbyimmatricul') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Retrouver une opportunité</a>
                                    </li>
                            
                                @endif

                                 @if (Session::get('userprivilege') == 'niveau3')

                                    <li class="nav-item">
                                        <a href="/liste_contrat_byagent" @if ($currentPage == 'liste_contrat_byagent' || $currentPage == 'filter_contrat_byagent_admin'|| $currentPage == 'filter_contrat_byclientname_admin'|| $currentPage == 'filter_contrat_bytel_admin'|| $currentPage == 'filter_contrat_echeance_admin'|| $currentPage == 'filter_contrat_relance_admin') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Renouvellements</a>
                                    </li>
                                 @endif


                                </ul>
                            </div>
                        </li> <!-- end Dashboard Menu -->

                         @endif



                          @if (Session::get('userprivilege') == 'niveau1') 
                            {{-- expr --}}
                       
                        <li class="nav-item">
                            <a @if ($currentPage == 'liste_prospection_groupee' || $currentPage == 'liste_prospection_byagent_relance_admin' || $currentPage == 'liste_prosprection_created_online'|| $currentPage == 'liste_contrat_byagent_admin'  || $currentPage == 'filter_contrat_byagent_admin'|| $currentPage == 'filter_contrat_byclientname_admin'|| $currentPage == 'filter_contrat_bytel_admin'|| $currentPage == 'retrouver_opportunite' || $currentPage=='findoppbytel'|| $currentPage=='findoppbyname'|| $currentPage=='findoppbyimmatricul') class="nav-link menu-link active" aria-expanded="true" @else class="nav-link menu-link collapsed" @endif href="#sidebarLayouts" data-bs-toggle="collapse" role="button"  aria-controls="sidebarLayouts">
                                <i class="ri-layout-3-line"></i> <span data-key="t-layouts" style="font-weight: bold;">DOSSIERS EN COURS</span> 
                            </a> 
                            <div @if ($currentPage == 'liste_prospection_groupee' || $currentPage == 'liste_prospection_byagent_relance_admin' || $currentPage == 'liste_prosprection_created_online'|| $currentPage == 'liste_contrat_byagent_admin' || $currentPage == 'filter_contrat_byagent_admin'|| $currentPage == 'filter_contrat_byclientname_admin'|| $currentPage == 'filter_contrat_bytel_admin' || $currentPage=='findoppbytel'|| $currentPage=='findoppbyname'|| $currentPage=='findoppbyimmatricul' || $currentPage=='retrouver_opportunite' ) class="collapse menu-dropdown show" @else class="collapse menu-dropdown " @endif id="sidebarLayouts">
                                <ul class="nav nav-sm flex-column">


                                 @if (Session::get('userprivilege') == 'niveau1') 

                                    <li class="nav-item">
                                        <a href="/liste_prospection_groupee" @if ($currentPage == 'liste_prospection_groupee') class=" nav-link active" @else class="nav-link" @endif data-key="t-ecommerce"> Nouvelles opportunités</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="/liste_prospection_byagent_relance_admin" @if ($currentPage == 'liste_prospection_byagent_relance_admin' || $currentPage =='filter_relance_admin') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Relances en cours</a>
                                    </li>


                                    <li class="nav-item">
                                        <a href="/liste_prosprection_created_online" @if ($currentPage == 'liste_prosprection_created_online') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto"> Opportunités créees par agent</a>
                                    </li>

                                     


                                @endif

                                {{-- @if (Session::get('userprivilege') == 'niveau1'|| Session::get('userprivilege') == 'niveau2')  --}}

                                     <li class="nav-item">
                                        <a href="/liste_contrat_byagent_admin" @if ($currentPage == 'liste_contrat_byagent_admin' || $currentPage == 'filter_contrat_byagent_admin'|| $currentPage == 'filter_contrat_byclientname_admin'|| $currentPage == 'filter_contrat_bytel_admin') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Renouvellements</a>
                                    </li>

                                {{-- @endif --}}
                                    <li class="nav-item">
                                        <a href="/retrouver_opportunite" @if ($currentPage == 'retrouver_opportunite' ) class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Retrouver une opportunité</a>
                                    </li>

                                   

                                </ul>
                            </div>
                        </li> <!-- end Dashboard Menu -->

                         @endif




                         {{-- <li class="nav-item">
                            <a @if ($currentPage == 'liste_prospection_byagent' || $currentPage == 'liste_prospection_byagent_relance' || $currentPage == 'liste_prospection_byagent_ferme' || $currentPage == 'liste_contrat_byagent' ) class="nav-link menu-link active" aria-expanded="true" @else class="nav-link menu-link collapsed" @endif href="#sidebarLayouts" data-bs-toggle="collapse" role="button"  aria-controls="sidebarLayouts">
                                <i class="ri-layout-3-line"></i> <span data-key="t-layouts" style="font-weight: bold;">DOSSIERS EN COURS</span> 
                            </a>
                            <div @if ($currentPage == 'liste_prospection_byagent' || $currentPage == 'liste_prospection_byagent_relance' || $currentPage == 'liste_prospection_byagent_ferme' || $currentPage == 'liste_contrat_byagent') class="collapse menu-dropdown show" @else class="collapse menu-dropdown " @endif id="sidebarLayouts">
                                <ul class="nav nav-sm flex-column">

                                    <li class="nav-item">
                                        <a href="/liste_prospection_byagent" @if ($currentPage == 'liste_prospection_byagent') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Opportunités Nouvelles</a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a href="/liste_prospection_byagent_relance" @if ($currentPage == 'liste_prospection_byagent_relance') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Opportunités relances</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="/liste_prospection_byagent_ferme" @if ($currentPage == 'liste_prospection_byagent_ferme') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Opportunités Perdues</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="/liste_contrat_byagent" @if ($currentPage == 'liste_contrat_byagent') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Renouvellements</a>
                                    </li>

                                </ul>
                            </div>
                        </li>  --}}<!-- end Dashboard Menu -->







                      @if (Session::get('userprivilege') == 'niveau1') 
                        <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Admin</span></li>

                        <li class="nav-item">
                            <a @if ($currentPage == 'liste_contrat' || $currentPage == 'liste_prospection_ferme'|| $currentPage == 'bordereaux_contrat_condense' || $currentPage == 'bordereaux_rapport_operateur'|| $currentPage == 'details_contrats_byagent/{idop}' ) class="nav-link menu-link active" aria-expanded="true" @else class="nav-link menu-link collapsed" @endif href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                                <i class="ri-pie-chart-line"></i> <span data-key="t-authentication" style="font-weight: bold;">BORDEREAUX</span>
                            </a>
                            

                            <div @if ($currentPage == 'liste_contrat' || $currentPage == 'bordereaux_rapport_operateur' || $currentPage == 'bordereaux_contrat_condense' || $currentPage == 'bordereaux_contrat_condense'|| $currentPage == 'filter_contrat_condenses'|| $currentPage == 'filter_bordereau_rapport_operateur' || $currentPage == 'liste_prospection_ferme' || $currentPage == 'details_contrats_byagent/{idop}'|| $currentPage == 'details_contrats_byagent/{idop}/{datedebut}/{datefin}'|| $currentPage == 'details_remontes_agent/{idop}'|| $currentPage == 'bordereaux_opp_agent_terrain'|| $currentPage == 'qualification_agent_terrain' || $currentPage== 'filter_bordereau_ag_terrain' || $currentPage == 'filter_qualif_ag_terrain'|| $currentPage == 'cg_non_verif'|| $currentPage =='filter_prospection_ferme_tel'|| $currentPage =='filter_prospection_ferme_nom') class="collapse menu-dropdown show" @else class="collapse menu-dropdown " @endif id="sidebarAuth">
                                <ul class="nav nav-sm flex-column">

                                     <li class="nav-item">
                                        <a href="/bordereaux_opp_agent_terrain" @if ($currentPage == 'bordereaux_opp_agent_terrain' || $currentPage == 'details_remontes_agent/{idop}'|| $currentPage == 'filter_bordereau_ag_terrain') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Bordereau Agent Terrain</a>
                                    </li>


                                     <li class="nav-item">
                                        <a href="/qualification_agent_terrain" @if ($currentPage == 'qualification_agent_terrain'|| $currentPage == 'filter_qualif_ag_terrain' ) class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Taux Qualif Agent Terrain</a>
                                    </li>


                                    <li class="nav-item">
                                        <a href="/bordereaux_rapport_operateur" @if ($currentPage == 'bordereaux_rapport_operateur' || $currentPage == 'filter_bordereau_rapport_operateur' ) class=" nav-link active" @else class="nav-link" @endif data-key="t-ecommerce"> Bordereau Operateur</a>
                                    </li>


                                    <li class="nav-item">
                                        <a href="/bordereaux_contrat_condense" @if ($currentPage == 'bordereaux_contrat_condense'|| $currentPage == 'filter_contrat_condenses'|| $currentPage == 'details_contrats_byagent/{idop}'|| $currentPage == 'details_contrats_byagent/{idop}/{datedebut}/{datefin}' ) class=" nav-link active" @else class="nav-link" @endif data-key="t-starter">Contrats AN/RN Résumés </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/liste_contrat" @if ($currentPage == 'liste_contrat') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto"> Contrats AN/RN detaillés </a>
                                    </li>


                                     <li class="nav-item">
                                        <a href="/cg_non_verif" @if ($currentPage == 'cg_non_verif') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto"> Cartes grises non verfiées</a>
                                    </li>

                                     <li class="nav-item">
                                        <a href="/liste_prospection_ferme" @if ($currentPage == 'liste_prospection_ferme'||$currentPage =='filter_prospection_ferme_tel'|| $currentPage =='filter_prospection_ferme_nom') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto"> Opportunites fermées</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a @if ($currentPage == 'stat_du_jour' || $currentPage== 'filter_stat'  ) class="nav-link menu-link active" aria-expanded="true" @else class="nav-link menu-link collapsed" @endif href="#sidebarPages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPages">
                                <i class="ri-pages-line"></i> <span data-key="t-pages" style="font-weight: bold;">STATISTIQUES</span>
                            </a>
                            <div @if ($currentPage == 'stat_du_jour' || $currentPage == 'filter_stat') class="collapse menu-dropdown show" @else class="collapse menu-dropdown " @endif id="sidebarPages">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="/stat_du_jour" @if ($currentPage == 'stat_du_jour' ||$currentPage == 'filter_stat' ) class=" nav-link active" @else class="nav-link" @endif data-key="t-starter"> Stats du jour</a>
                                    </li>

                                    {{-- <li class="nav-item">
                                        <a href="#" class="nav-link" data-key="t-starter"> Stat 2</a>
                                    </li> --}}
                                    
                                </ul>
                            </div>
                        </li>
                        @endif

                       
                       
                    </ul>
                </div>
    <!-- Sidebar -->
 </div>

