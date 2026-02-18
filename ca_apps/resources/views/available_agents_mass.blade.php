<form class="tablelist-form" autocomplete="off">
    <div class="mb-3">
        <label for="date-field" class="form-label">Date affectation</label>
        <input type="date" id="date-field" name="dateaffect"class="form-control" data-provider="flatpickr" required data-date-format="d M, Y" data-enable-time required placeholder="Select date" value="{{date('Y-m-d')}}" />
    </div>
</form>
<table class="table table-nowrap">
    @foreach ($agents_dispo as $agents)
        <tr class="listagents_dispo">
            <td style="padding: 5px 10px;">
                <span style="display:block;font-weight: bold;text-transform: uppercase;">{{$agents['firstname'].' '.$agents['lastname']}} </span>
                <span style="display:block; color: #07630f;font-style: italic;font-size: 10px;"> <span style="color:red">{{count($agents['affectations'])}}</span>  Affectation(s) en cours</span>
            </td>
            <td style="text-align:right;padding-right: 10px;"><a class="btn btn-primary setlivmass" data-idagent="{{$agents['id']}}" style="font-weight: bold;" href="#">affecter</a></td>
        </tr>
    @endforeach
</table>



