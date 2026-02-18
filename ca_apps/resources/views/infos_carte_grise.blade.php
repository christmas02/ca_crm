
<img src="{{$image_to_display}}" style="width: 50%;margin: 0 auto; display: block;" alt="">
<!-- Striped Rows -->
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">CHAMP </th>
            <th scope="col">VALEUR</th>
          
        </tr>
    </thead>
    <tbody>

        {{-- {{dd($cg_datas['nom_proprietaire'])}} --}}
        <tr>
            <td>Propriétaire</td>
            <td>{{$cg_datas['nom_proprietaire'] ?? 'ND'}}</td>
        </tr>

        <tr>
            <td>Numero immatriculation</td> 

            <td>{{$cg_datas['numero_immatriculation'] ?? $cg_datas['immatriculation'] ?? 'ND'}}</td>
        </tr>

        <tr>
            <td>Numero Carte grise</td>
            <td>{{$cg_datas['numero_carte_grise']  ?? 'ND'}}</td>
        </tr>

        <tr>
            <td>Mise en cirulation</td>
            <td>{{$cg_datas['date_premiere_circulation']  ?? $cg_datas['date_premiere_immatriculation']?? $cg_datas['date_mise_en_circulation']  ?? 'ND'}}</td>
        </tr>

        <tr>
            <td>Marque</td>
            <td>{{$cg_datas['marque']  ?? $cg_datas['marque_vehicule'] ?? 'ND'}}</td>
        </tr>

        <tr>
            <td>Modele</td>
            <td>{{$cg_datas['modele']  ??$cg_datas['type_commercial']?? $cg_datas['modele_vehicule']?? 'ND'}}</td>
        </tr>

        <tr>
            <td>Couleur</td>
            <td>{{$cg_datas['couleur']  ?? 'ND'}}</td>
        </tr>

        <tr>
            <td>Carosserie</td>
            <td>{{$cg_datas['carrosserie']  ?? 'ND'}}</td>
        </tr>
        <tr>
            <td>Energie</td>
            <td>{{$cg_datas['carburant']  ?? $cg_datas['energie']  ?? 'ND'}}</td>
        </tr>

        <tr>
            <td>Nombre de place</td> 
            <td>{{$cg_datas['nombre_places_assises'] ?? $cg_datas['places_assises'] ?? $cg_datas['nombre_places']  ?? 'ND'}}</td>
        </tr>

         <tr>
            <td>Puissance fiscale</td> 
            <td>{{$cg_datas['puissance_fiscale'] ?? $cg_datas['puissance_fiscale_cv']?? $cg_datas['puissance_admin']?? $cg_datas['puissance_adm']?? $cg_datas['puissance_cv']?? $cg_datas['puissance_fiscale_CV'] ?? $cg_datas['puissance_administrative'] ?? $cg_datas['puissance'] ?? 'ND'}}</td>
        </tr>
        
        
    </tbody>
</table>

<div class="row">
    <form action="/create_client_frcg" class="col-md-6" method="POST">
    @csrf
    <input type="hidden" name="nomclient_cg" value="{{$cg_datas['nom_proprietaire']}}">
     <input type="hidden" name="num_matricule_cg" value="{{$cg_datas['numero_immatriculation'] ?? $cg_datas['immatriculation']}}">

    <button id="idnext" type="submit" class="btn btn-primary">Creer une fiche client</button>

</form>


<form action="/create_cotation_frcg"  class="col-md-6"  method="POST">
    @csrf
    <input type="hidden" name="mise_circulation_cg" value="{{$cg_datas['date_premiere_circulation']  ?? $cg_datas['date_premiere_immatriculation']?? $cg_datas['date_mise_en_circulation'] ?? ''}}">
    <input type="hidden" name="marque_cg" value="{{$cg_datas['marque']  ?? $cg_datas['marque_vehicule'] ?? ''}}">
    <input type="hidden" name="energie_cg" value="{{$cg_datas['carburant']  ?? $cg_datas['energie'] ?? ''}}">

      <input type="hidden" name="model_cg" value="{{$cg_datas['modele']  ??$cg_datas['type_commercial']?? $cg_datas['modele_vehicule']?? 'ND'}}">
    <input type="hidden" name="num_matricule_cg" value="{{$cg_datas['numero_immatriculation'] ?? $cg_datas['immatriculation'] ?? ''}}">
    <input type="hidden" name="nbre_place_cg" value="{{$cg_datas['nombre_places_assises'] ?? $cg_datas['places_assises'] ?? $cg_datas['nombre_places'] ?? ''}}">
    <input type="hidden" name="puissance_cg" value="{{$cg_datas['puissance_fiscale'] ?? $cg_datas['puissance_fiscale_cv']?? $cg_datas['puissance_admin']?? $cg_datas['puissance_adm']?? $cg_datas['puissance_cv']?? $cg_datas['puissance_fiscale_CV'] ?? $cg_datas['puissance_administrative'] ?? ''}}">
     
    <button id="idnext" type="submit" class="btn btn-dark">Faire une cotation</button>

</form>
    
</div>

<script
  src="https://code.jquery.com/jquery-3.7.0.min.js"
  integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
  crossorigin="anonymous"></script>
<script>
       
       $("#updateOppbtn").click(function(e) {

       })


</script>
