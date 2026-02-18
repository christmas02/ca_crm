 <option selected value="">Choisir...</option>
@foreach ($carmodel as $model)

     @if(array_key_exists('model', $model))
     <option value="{{$model['model'].'-'.$model['car_code']}}">{{$model['model']}}</option>
     @endif

     @if(array_key_exists('libelle', $model))
     <option value="{{$model['libelle'].'-'.$model['marque']}}">{{$model['libelle']}}</option>
     @endif

@endforeach