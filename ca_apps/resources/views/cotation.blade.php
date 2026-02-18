@extends('layouts.master')
    @section('headerCss')
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
    @stop

     @section('content')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">


                    <div class="row justify-content-center mt-5">
                        <div class="col-lg-4">
                            <div class="text-center mb-4 pb-2">
                                <h4 class="fw-semibold fs-22">Proposition de Cotation Annuelle</h4>
                                @php
                                  $array=  explode('-',$model);
                                @endphp
                                <h4 class="fw-semibold fs-22">{{$marque .' '.$array[0] }}</h4>
                                <p class=" mb-4 fs-15">{{ 'Energie : '.$energie.' | Puissance :'.$puissance.' | Mise en circulation: '.$mise_circulation.' | Age Vehicule: '.$agevehicule .' ans '}}</p>
                                <h6 class="fw-semibold fs-22"> Valeur Venale : {{number_format($valeur_venale, 0, '.', ' ')  }} Fcfa</h6>
                                <h6 class="fw-semibold fs-22"> Valeur Neuve : {{ number_format($valeur_neuve, 0, '.', ' ')}} Fcfa</h6>

                            </div>






                        @isset ($nodata)
                            {{-- <h1>Aucune correspondance avec l'argus. les dates maximales de mise en circulation dans l'argus s'etendent à 2020</h1> --}}
                       
                            <div class="alert alert-light alert-dismissible alert-additional fade show" role="alert">
                                <div class="alert-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="ri-error-warning-line fs-16 align-middle"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="alert-heading">Oops aucune correspondance!</h5>
                                            <h4 class="mb-0">Aucune correspondance avec l'argus. les dates maximales de mise en circulation dans l'argus s'etendent à 2020</h4>
                                        </div>
                                    </div>
                                </div>

                        </div>
                         <a style="margin: 0 auto;display: block;" href="/formulaire_cotation" class="btn btn-primary waves-effect waves-light">Faire une autre cotation</a>
                         <br/>
                           <a style="margin: 0 auto;display: block;" href="/create_car_brand" class="btn btn-success waves-effect waves-light">Ajouter un vehicule</a>
                                @endisset
                        <!--end col-->
                         <a id="showcotationfield" style="margin: 0 auto;display: block;" href="#" class="btn btn-success waves-effect waves-light">Modifier les champs de la cotation</a>
                         <br/>
                        <div id="cotationfield" class="card" style="display: none">
                           <div class="card-body">
                                    <p class="text-muted"></p>
                                    <div class="live-preview">
                                        <div class="alert alert-success" role="alert" style="display:none">
                                                    <strong> Commentaire enregistré avec succès! </strong>  <b> <a href=""></a>
                                                </div>
                                        <form id="simul" method="POST" action="/calcul_cotation">
                                               @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="compnayNameinput" class="form-label">Marque </label>
                                                        <input type="text" name="marque" class="form-control " value="{{$marque}}" placeholder="Marque" id="compnayNameinput" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="compnayNameinput" class="form-label">Model </label>
                                                        <input type="text" name="model" class="form-control" value="{{$model}}" placeholder="model" id="compnayNameinput" required>
                                                    </div>
                                                </div>

                                                <!--end col-->
                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="ForminputState" class="form-label">Carburant</label>
                                                        <select name="energie" id="ForminputState" class="form-select" data-choices data-choices-sorting="true" required>
                                                            <option selected value="">Choisir...</option>
                                                            <option @if($energie =='essence') selected @endif value="essence">Essence</option>
                                                            <option @if($energie =='diesel') selected @endif value="diesel">Diesel</option>
                                                        </select>
                                                    </div>
                                                </div> 

                                                <!--end col-->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="compnayNameinput" class="form-label">Date Mise en circulation</label>
                                                        <input type="date" name="mise_circulation" class="form-control maxlength10" placeholder="mise en circulation" value="{{$mise_circulation}}" id="compnayNameinput" required>
                                                    </div>
                                                </div>

                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="compnayNameinput" class="form-label">Nombre de places</label>
                                                        <input type="text" name="nbreplace" class="form-control numberonly" placeholder="Nombre de place " value="{{$nbreplace}}" id="compnayNameinput" required>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="puissance" class="form-label">Puissance</label>
                                                        <input type="text" name="puissance" class="form-control numberonly" placeholder="5" id="puissance"  value="{{$puissance}}" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="bns" class="form-label">BNS %</label>
                                                        <input type="text" name="bns" class="form-control numberonly" placeholder="" id="bns" value="19" required>
                                                    </div>
                                                </div>


                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="csp" class="form-label">CSP</label>
                                                        <input type="text" name="csp" class="form-control numberonly" placeholder="csp" id="csp" value="95" required>
                                                    </div>
                                                </div>


                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="redcom" class="form-label">RED COM</label>
                                                        <input type="text" name="redcom" class="form-control numberonly" placeholder="reduction commercial" id="redcom" value="25" required>
                                                    </div>
                                                </div>

                                                 <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="valeurneuve" class="form-label">Valeur Neuve</label>
                                                        <input type="text" name="valeurneuve" class="form-control numberonly" placeholder="reduction " id="valeurneuve" value="{{$valeur_neuve}}" required >
                                                    </div>
                                                </div>

                                                <!--end col-->
                                            
                                                <div style="margin-bottom:10px"></div>

                                                <!--end col-->
                                                <div class="col-lg-12">
                                                    <div class="text-end">
                                                        <button id="idnext" type="submit" class="btn btn-primary">Refaire la cotation</button>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end row-->
                                        </form>
                                    </div>
                                    <div class="d-none code-view">
                                        
                                    </div>
                           </div>

                        </div>

                    </div>
                    <!--end row-->







                    @php
                        // dd($agevehicule)
                    @endphp

                    <div class="row justify-content-center">

                        @if ($prime_finale_tout_risque >0 && $agevehicule < 5 && !isset($nodata))
                           
                        <div class="col-lg-12">
                            <div class="card pricing-box text-center" style="background: #d4e7ff;">
                                <div class="row g-0">
                                    <div class="col-lg-6">
                                        <div class="card-body h-100">
                                            <div>
                                                <h5 class="mb-1">Tous risques </h5>
                                                <p class="text-muted">Formule de souscription</p>
                                            </div>
                                            <div class="py-4">
                                                <h2>{{number_format($prime_finale_tout_risque,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted">/An </span></h2>
                                            </div>

                                            <div class="py-4">
                                                <h2>{{number_format($prime_finale_tout_risque *0.56,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted">/6mois</span></h2>
                                            </div>

                                            <div class="py-4">
                                                <h2>{{number_format($prime_finale_tout_risque *0.6,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted">/3mois</span></h2>
                                            </div>



                                            <div class="text-center plan-btn mt-2">
                                                <a href="javascript:void(0);" class="btn btn-success w-sm waves-effect waves-light">Souscrire</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="card-body border-start mt-4 mt-lg-0">
                                            <div class="card-header bg-light">
                                                <h5 class="fs-15 mb-0">Liste des garanties :</h5>
                                            </div>
                                            <div class="card-body pb-0">
                                                <ul class="list-unstyled vstack gap-3 mb-0" style="text-align:left;">
                                                    <li>Responsabilité Civile: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Défense & Recours: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Recours Anticipé: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Incendie & Explosion: <span class="text-success fw-semibold">Non</span></li>
                                                     <li>Vol & Agression: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Vol Accessoire: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Brise de glasse: <span class="text-success fw-semibold">Oui</span></li>

                                                    <li>Dommage tout accident: <span class="text-success fw-semibold">Non</span></li>

                                                    <li>Dommage collision: <span class="text-success fw-semibold">Non</span></li>
                                                    <li>Personnes transportées: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Assistance automobile : <span class="text-success fw-semibold">Oui</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                        </div>

                        @endif


                         @if (($prime_finale_tiers_simple >0 && $agevehicule >12) ||( $agevehicule <5 && $agevehicule !=0) && !isset($nodata))
                        <div class="col-lg-6">
                            <div class="card pricing-box text-center">
                                <div class="row g-0">
                                    <div class="col-lg-6">
                                        <div class="card-body h-100">
                                            <div>
                                                <h5 class="mb-1">Tiers simple</h5>
                                                <p class="text-muted">Formule de souscription</p>
                                            </div>

                                            <div class="py-4">
                                                <h2>{{number_format($prime_finale_tiers_simple,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted"> /An</span></h2>
                                            </div>

                                            <div class="py-4">
                                                <h2>{{number_format($prime_finale_tiers_simple *0.56,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted">/6mois</span></h2>
                                            </div>

                                            <div class="py-4">
                                                <h2>{{number_format($prime_finale_tiers_simple *0.6,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted">/3mois</span></h2>
                                            </div>


                                            <div class="text-center plan-btn mt-2">
                                                <a href="javascript:void(0);" class="btn btn-success w-sm waves-effect waves-light">Souscrire</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="card-body border-start mt-4 mt-lg-0">
                                            <div class="card-header bg-light">
                                                <h5 class="fs-15 mb-0">Liste des garanties :</h5>
                                            </div>
                                            <div class="card-body pb-0">
                                                <ul class="list-unstyled vstack gap-3 mb-0" style="text-align:left;">
                                                    <li>Responsabilité Civile: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Défense & Recours: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Recours Anticipé: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Incendie & Explosion: <span class="text-success fw-semibold">Non</span></li>
                                                     <li>Vol & Agression: <span class="text-success fw-semibold">Non</span></li>
                                                    <li>Vol Accessoire: <span class="text-success fw-semibold">Non</span></li>
                                                    <li>Brise de glasse: <span class="text-success fw-semibold">Non</span></li>

                                                    <li>Dommage tout accident: <span class="text-success fw-semibold">Non</span></li>

                                                    <li>Dommage collision: <span class="text-success fw-semibold">Non</span></li>
                                                    <li>Personnes transportées: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Assistance automobile : <span class="text-success fw-semibold">Oui</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                        </div>
                         @endif
                        <!--end row-->

                        @if ($prime_finale_tiers_complet >0  && $agevehicule >=5 && $agevehicule <=12 && !isset($nodata))
                        <div class="col-lg-6">
                            <div class="card pricing-box ribbon-box ribbon-fill text-center">
                                <div class="ribbon ribbon-primary">Reco</div>
                                <div class="row g-0">
                                    <div class="col-lg-6">
                                        <div class="card-body h-100">
                                            <div>
                                                <h5 class="mb-1">Tiers Complet</h5>
                                                <p class="text-muted">Formule de souscription</p>
                                            </div>

                                            <div class="py-4">
                                                <h2>{{number_format($prime_finale_tiers_complet,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted">/An</span></h2>
                                            </div>

                                             <div class="py-4">
                                                <h2>{{number_format($prime_finale_tiers_complet *0.56,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted">/6mois</span></h2>
                                            </div>

                                            <div class="py-4">
                                                <h2>{{number_format($prime_finale_tiers_complet *0.6,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted">/3mois</span></h2>
                                            </div>

                                            <div class="text-center plan-btn mt-2">
                                                <a href="javascript:void(0);" class="btn btn-success w-sm waves-effect waves-light">Souscrire</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="card-body border-start mt-4 mt-lg-0">
                                            <div class="card-header bg-light">
                                                <h5 class="fs-15 mb-0">Liste des garanties :</h5>
                                            </div>
                                            <div class="card-body pb-0">
                                                <ul class="list-unstyled vstack gap-3 mb-0" style="text-align:left;">
                                                    <li>Responsabilité Civile: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Défense & Recours: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Recours Anticipé: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Incendie & Explosion: <span class="text-success fw-semibold">Non</span></li>
                                                     <li>Vol & Agression: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Vol Accessoire: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Brise de glasse: <span class="text-success fw-semibold">Oui</span></li>

                                                    <li>Dommage tout accident: <span class="text-success fw-semibold">Non</span></li>

                                                    <li>Dommage collision: <span class="text-success fw-semibold">Non</span></li>
                                                    <li>Personnes transportées: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Assistance automobile : <span class="text-success fw-semibold">Oui</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                        </div>
                         @endif
                        <!--end row-->
                         @if ($prime_finale_tiers_ameliore >0  && $agevehicule <=12 && !isset($nodata))
                        <div class="col-lg-6">
                            <div class="card pricing-box ribbon-box ribbon-fill text-center">
                                <div class="ribbon ribbon-primary">Reco</div>
                                <div class="row g-0">
                                    <div class="col-lg-6">
                                        <div class="card-body h-100">
                                            <div>
                                                <h5 class="mb-1">Tiers Amelioré</h5>
                                                <p class="text-muted">Formule de souscription</p>
                                            </div>

                                            <div class="py-4">
                                                <h2>{{number_format($prime_finale_tiers_ameliore,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted">/An</span></h2>
                                            </div>

                                            <div class="py-4">
                                                <h2>{{number_format($prime_finale_tiers_ameliore *0.56,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted">/6mois</span></h2>
                                            </div>

                                            <div class="py-4">
                                                <h2>{{number_format($prime_finale_tiers_ameliore *0.6,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted">/3mois</span></h2>
                                            </div>


                                            <div class="text-center plan-btn mt-2">
                                                <a href="javascript:void(0);" class="btn btn-success w-sm waves-effect waves-light">Souscrire</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="card-body border-start mt-4 mt-lg-0">
                                            <div class="card-header bg-light">
                                                <h5 class="fs-15 mb-0">Liste des garanties :</h5>
                                            </div>
                                            <div class="card-body pb-0">
                                                <ul class="list-unstyled vstack gap-3 mb-0" style="text-align:left;">
                                                    <li>Responsabilité Civile: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Défense & Recours: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Recours Anticipé: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Incendie & Explosion: <span class="text-success fw-semibold">Non</span></li>
                                                     <li>Vol & Agression: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Vol Accessoire: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Brise de glasse: <span class="text-success fw-semibold">Non</span></li>

                                                    <li>Dommage tous accidents: <span class="text-success fw-semibold">Non</span></li>

                                                    <li>Dommage collision: <span class="text-success fw-semibold">Non</span></li>
                                                    <li>Personnes transportées: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Assistance automobile : <span class="text-success fw-semibold">Oui</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                        </div>
                         @endif
                        <!--end col-->
                         @if ($prime_finale_tiers_collision >0 && $agevehicule <=5 && !isset($nodata))
                        <div class="col-lg-6">
                            <div class="card pricing-box text-center">
                                <div class="row g-0">
                                    <div class="col-lg-6">
                                        <div class="card-body h-100">
                                            <div>
                                                <h5 class="mb-1">Tierce Collision</h5>
                                                <p class="text-muted">Formule de souscription</p>
                                            </div>
                                            <div class="py-4">
                                                <h2>{{number_format($prime_finale_tiers_collision,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted">/An </span></h2>
                                            </div>

                                            <div class="py-4">
                                                <h2>{{number_format($prime_finale_tiers_collision *0.56,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted">/6mois</span></h2>
                                            </div>

                                            <div class="py-4">
                                                <h2>{{number_format($prime_finale_tiers_collision *0.6,0, '.', ' ')}} <sup><small> FCFA</small></sup><span class="fs-13 text-muted">/3mois</span></h2>
                                            </div>


                                            <div class="text-center plan-btn mt-2">
                                                <a href="javascript:void(0);" class="btn btn-success w-sm waves-effect waves-light">Souscrire</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="card-body border-start mt-4 mt-lg-0">
                                            <div class="card-header bg-light">
                                                <h5 class="fs-15 mb-0">Liste des garanties :</h5>
                                            </div>
                                            <div class="card-body pb-0">
                                                <ul class="list-unstyled vstack gap-3 mb-0" style="text-align:left;">
                                                     <li>Responsabilité Civile: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Défense & Recours: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Recours Anticipé: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Incendie & Explosion: <span class="text-success fw-semibold">Non</span></li>
                                                     <li>Vol & Agression: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Vol Accessoire: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Brise de glasse: <span class="text-success fw-semibold">Oui</span></li>

                                                    <li>Dommage tout accident: <span class="text-success fw-semibold">Non</span></li>

                                                    <li>Dommage collision: <span class="text-success fw-semibold">Non</span></li>
                                                    <li>Personnes transportées: <span class="text-success fw-semibold">Oui</span></li>
                                                    <li>Assistance automobile : <span class="text-success fw-semibold">Oui</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                        </div>
                        <!--end col-->
                        @endif
                       
                        <!--end col-->
                    </div>
                    <!--end row-->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

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
    @stop

    @section('footerCss')





    <!-- JAVASCRIPT -->
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>
    <script src="/assets/libs/feather-icons/feather.min.js"></script>
    <script src="/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="/assets/js/plugins.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="/assets/js/pages/pricing.init.js"></script>

    <!-- App js -->
    <script src="/assets/js/app.js"></script>


    <script>
    



        $(document).on('click','#showcotationfield', function(e){
                
                console.log($(this).text());

                if ($(this).text() == "Modifier les champs de la cotation"){
                   $(this).text("Masquer les champs de la cotation");
                   $(this).addClass('btn-dark');
                     $(this).removeClass('btn-success');
                }
                else{
                   $(this).text("Modifier les champs de la cotation");
                    $(this).removeClass('btn-dark');
                    $(this).addClass('btn-success');
                }
                 
                 $("#cotationfield").toggle();

        })
        
    </script>
     @stop