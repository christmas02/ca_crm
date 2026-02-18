 @php
    $currentPage = Route::getFacadeRoot()->current()->uri();
 @endphp

<div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link collapsed active" href="#" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="sidebarDashboards">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Menu</span>
                            </a>
                            <div class="collapse menu-dropdown show" id="sidebarDashboard">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link" data-key="t-analytics"> Dashboard </a>
                                    </li>

                                 @if (Session::get('userprivilege') == 'niveau1') 
                                    {{-- expr --}}
                               
                                    <li class="nav-item">
                                        <a href="/createuserform" @if ($currentPage == 'createuserform') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Créer un agent Terrain </a>
                                    </li>


                                     <li class="nav-item">
                                        <a href="/create_agent_enligne" @if ($currentPage == 'create_agent_enligne') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Créer Agent en ligne</a>
                                    </li>




                                    <li class="nav-item">
                                        <a href="/createcanal" @if ($currentPage == 'createcanal') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Creer un canal </a>
                                    </li>

                                    @endif

                                     <li class="nav-item">
                                        <a href="/enregister_propection" @if ($currentPage == 'enregister_propection') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto"> Creér une opportunité </a>
                                    </li>


                                    <li class="nav-item">
                                        <a href="/importopportunites" @if ($currentPage == 'importopportunites') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto">Importer des opportunités</a>
                                    </li>


{{-- 
                                     <li class="nav-item">
                                        <a href="/liste_renouvellement" @if ($currentPage == 'liste_renouvellement') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Renouvellement</a>
                                    </li> --}}


                                     <li class="nav-item">
                                        <a href="/liste_contrat_byagent" @if ($currentPage == 'liste_contrat_byagent') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Renouvellements</a>
                                    </li>

                                    


                                    <li class="nav-item">
                                        <a href="/liste_prospection_byagent" @if ($currentPage == 'liste_prospection_byagent') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Opportunités Nouvelles</a>
                                    </li>

                                     @if (Session::get('userprivilege') != 'niveau1') 

                                    <li class="nav-item">
                                        <a href="/liste_prospection_byagent_relance" @if ($currentPage == 'liste_prospection_byagent_relance') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Opportunités relances</a>
                                    </li>

                                    


                                    <li class="nav-item">
                                        <a href="/liste_prospection_byagent_ferme" @if ($currentPage == 'liste_prospection_byagent_ferme') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Opportunités Perdues</a>
                                    </li>

                                    @endif

                                    

                                    

                                @if (Session::get('userprivilege') == 'niveau1') 


                                     <li class="nav-item">
                                        <a href="/liste_prospection_byagent_relance_admin" @if ($currentPage == 'liste_prospection_byagent_relance_admin') class=" nav-link  active" @else class="nav-link" @endif  data-key="t-crm">Opportunités relances</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="/liste_agent_enligne" @if ($currentPage == 'liste_agent_enligne') class=" nav-link active" @else class="nav-link" @endif data-key="t-ecommerce"> Liste des agents en ligne </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="/liste_prospection_groupee" @if ($currentPage == 'liste_prospection_groupee') class=" nav-link active" @else class="nav-link" @endif data-key="t-ecommerce"> Opportunités par Agents</a>
                                    </li>
                                
                               
                                    <li class="nav-item">
                                        <a href="/listeprosprection" @if ($currentPage == 'listeprosprection') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto"> Liste des opportunitées </a>
                                    </li>


                                    <li class="nav-item">
                                        <a href="/liste_nvelle_opp_gagnee" @if ($currentPage == 'liste_nvelle_opp_gagnee') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto"> Bordereau opportunite gagnee</a>
                                    </li>


                                    <li class="nav-item">
                                        <a href="/liste_contrat" @if ($currentPage == 'liste_contrat') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto">  Bordereau renouvellement gagnes</a>
                                    </li>


                                    <li class="nav-item">
                                        <a href="/liste_prosprection_created_online" @if ($currentPage == 'liste_prosprection_created_online') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto"> Opportunités crées par agent</a>
                                    </li>


                                    {{-- <li class="nav-item">
                                        <a href="#" @if ($currentPage == '#') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto"> Bordereau renouvellement gagnes</a>
                                    </li> --}}


                                     <li class="nav-item">
                                        <a href="/liste_prospection_ferme" @if ($currentPage == 'liste_prospection_ferme') class=" nav-link active" @else class="nav-link" @endif data-key="t-crypto"> Bordereau opportunites fermées</a>
                                    </li>

                                    
                                 @endif

                                </ul>
                            </div>
                        </li> <!-- end Dashboard Menu -->
                        

                    </ul>
                </div>
                <!-- Sidebar -->
</div>