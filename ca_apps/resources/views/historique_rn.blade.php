@if (count($histo_rnlist) >0)
    {{-- expr --}}

<table id="buttons-datatables" class="display table table-bordered" style="width:100%">
                                        <thead>



                                        {{--     @if (!empty($foundagent) && !empty($filtre) )
                                      <tr style="background:lightgray;">
                                                <td  colspan="13"><h4 style="text-align:center;">Opportunites - Filtre - [ {{$foundagent[0]['firstname'].' '.$foundagent[0]['lastname']}}]<span style="font-weight:bold">{{$filtre}} DEBUT:</span> <span>{{\Carbon\Carbon::parse($datedebut)->format('d-m-Y')}}</span> <span style="font-weight:bold">{{$filtre}} FIN: </span> <span>{{\Carbon\Carbon::parse($datefin)->format('d-m-Y')}}</span></h4></td>
                                            </tr>

                                        @elseif (!empty($selectedagent) && $selectedagent == 'tous' && !empty($filtre))
                                      <tr style="background:lightgray;">
                                                <td  colspan="13"><h4 style="text-align:center;">Opportunites - Filtre - [Tous] <span style="font-weight:bold">{{$filtre}} DEBUT:</span> <span>{{\Carbon\Carbon::parse($datedebut)->format('d-m-Y')}}</span> <span style="font-weight:bold">{{$filtre}} FIN: </span> <span>{{\Carbon\Carbon::parse($datefin)->format('d-m-Y')}}</span></h4></td>
                                            </tr>


                                        @elseif (!empty($telfiltre) )
                                            <tr style="background:lightgray;">
                                                    <td  colspan="13"><h4 style="text-align:center;">Opportunites - Filtre - [Telephone] : <span style="font-weight:bold">{{$telfiltre}}</span></h4></td>
                                                </tr> 


                                         @elseif (!empty($namefilter) )
                                            <tr style="background:lightgray;">
                                                    <td  colspan="13"><h4 style="text-align:center;">Opportunites - Filtre - [Nom ou Prénom] : <span style="font-weight:bold">{{$namefilter}}</span></h4></td>
                                                </tr>

                                        
                                         @elseif (!empty($plaquefilter) )
                                            <tr style="background:lightgray;">
                                                    <td  colspan="13"><h4 style="text-align:center;">Opportunites - Filtre - [Plaque] : <span style="font-weight:bold">{{$plaquefilter}}</span></h4></td>
                                                </tr>

                                         @else  --}}

                                         <tr style="background:lightgray;">
                                                {{-- <td  colspan="13"><h3 style="text-align:center;">Opportunites</h3></td> --}}

                                                 <td  colspan="13"><h3 style="text-align:center;">{{$histo_rnlist[0]['opportunite']['nom'].' '.$histo_rnlist[0]['opportunite']['prenoms']}}</h3></td>
                                            </tr>

                                        {{-- @endif --}}

                                            <tr>
                                                 <th>Date de souscription</th>
                                                 <th>Période souscrite</th>
                                                 <th>Prime Nette souscrite </th>
                                                 <th>Prime Ttc</th>
                                                 <th>Assureur</th>
                                                 <th>Statut</th>
                                                 <th>conseiller(re)</th>
                                                 
                                                
                                                 {{-- <th>Reaffecter</th> --}}

                                            </tr>
                                        </thead>
                                        <tbody>

                                               
                                          @foreach ($histo_rnlist as $histo_rnlist_el)

                                          
                                           
                                          
                                            <tr>
                                                
                                                
                                                
                                                

                                                
                                                <td>{{\Carbon\Carbon::parse($histo_rnlist_el['created_at'])->format('d-m-Y H:i');}}</td>
                                                <td>{{$histo_rnlist_el['periode_soucription'].' Mois';}}</td>
                                                 <td>{{$histo_rnlist_el['primenet']}}</td>
                                                
                                                 <td>{{$histo_rnlist_el['primettc']}}</td>
                                               <td>{{$histo_rnlist_el['assureur_actuel']}}</td>

                                                  <td> 

                                                         @if ($histo_rnlist_el['resultat'] == 'horscible'|| $histo_rnlist_el['resultat'] == 'horscible_rn')
                                                            <span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i> {{$histo_rnlist_el['resultat']}}</span>
                                                          @endif

                                                           @if ($histo_rnlist_el['resultat'] == 'reporte'||$histo_rnlist_el['resultat'] == 'reporte_rn')
                                                            <span class="badge badge-label bg-warning"><i class="mdi mdi-circle-medium"></i> {{$histo_rnlist_el['resultat']}}</span>

                                                         @endif


                                                          @if ($histo_rnlist_el['resultat']== 'perdu'||$histo_rnlist_el['resultat']== 'perdu_rn')
                                                            <span class="badge badge-label bg-danger"><i class="mdi mdi-circle-medium"></i> {{$histo_rnlist_el['resultat']}}</span>

                                                         @endif



                                                          @if ($histo_rnlist_el['resultat']== 'poursuivre'||$histo_rnlist_el['resultat']== 'poursuivre_rn')
                                                            <span class="badge badge-label bg-dark"><i class="mdi mdi-circle-medium"></i> {{$histo_rnlist_el['resultat']}}</span>

                                                         @endif


                                                         @if ($histo_rnlist_el['resultat']== 'gagne')
                                                            <span class="badge badge-label bg-success"><i class="mdi mdi-circle-medium"></i> {{$histo_rnlist_el['resultat']}}</span>

                                                         @endif

                                                         @if ($histo_rnlist_el['resultat']== 'rdvsouscription'||$histo_rnlist_el['resultat']== 'rdvsouscription_rn')
                                                            <span class="badge badge-label bg-secondary"><i class="mdi mdi-circle-medium"></i> {{$histo_rnlist_el['resultat']}}</span>

                                                         @endif

                                                </td>
                                               
                                               

                                                <td>{{$histo_rnlist_el['agent_backoffice']['firstname'].' '.$histo_rnlist_el['agent_backoffice']['lastname']}}</td>
                                               {{--  <td>

                                                     <div class="dropdown">
                                                                <a href="#" role="button" id="{{$liste_relances_element['opportunite']['id']}}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i style="font-size: 16px;" class="ri-settings-4-line"></i>
                                                                </a>

                                                                <ul class="dropdown-menu" aria-labelledby="{{$liste_relances_element['opportunite']['id']}}">
                                                                    <li> <a class="dropdown-item" href="/enregister_note_propection/{{$liste_relances_element['opportunite']['id']}}"> <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Commenter</a></li>
                                                                    <li><a class="dropdown-item attrib_btn" href="#" data-bs-toggle="modal"  data-opp="{{$liste_relances_element['opportunite']['id'] .'|'. $liste_relances_element['opportunite']['echeance'] .'|'. \Carbon\Carbon::parse($liste_relances_element['daterelance'])->format('d-m-Y') .'|'.\Carbon\Carbon::parse($liste_relances_element['heure_relance'])->format('H:i:s') .'|'. $liste_relances_element['primenet'].'|'. $liste_relances_element['primettc'].'|'. $liste_relances_element['periode_soucription'].'|'. $liste_relances_element['assureur_actuel']}}">  <i class=" ri-arrow-left-right-line align-bottom me-2 text-muted"></i> Reaffecter</a></li>

                                                                     <li> <a class="dropdown-item histo_rn_btn"  data-opp="{{$liste_relances_element['opportunite']['id']}}"> <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Historique RN</a></li>

                                                                     @if (in_array(37, $privarray))
                                                                       
                                                                  
                                                                     <li class="dropdown-divider"></li>

                                                                    <li><a class="dropdown-item delete_btn " href="#" data-bs-toggle="modal"  data-opp="{{$liste_relances_element['idopportunite']}}">  <i class=" ri-delete-bin-fill align-bottom me-2 text-muted"></i> Supprimer</a></li>
                                                                      @endif
                                                                   
                                                                </ul>
                                                            </div>


                                                </td> --}}

                                            </tr>
                                            {{-- @endif --}}
                                            {{-- @endif --}}
                                          @endforeach


                                      </tbody>
                                  </table>
                                  @else

                                    <p style="text-align:center">Cette opportunité n'a jamais été gagné</p>
                                  @endif