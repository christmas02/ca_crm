  
@if (count($findOpportunity)>0)
  {{-- expr --}}
@endif
  @foreach ($findOpportunity as $element)
    {{-- expr --}}

  <div class="text-reset notification-item d-block dropdown-item position-relative">
    <div class="d-flex">
      <div class="avatar-xs me-3">
        <span class="avatar-title bg-soft-info text-info rounded-circle fs-16">
          <i class="bx bx-badge-check"></i>
        </span>
      </div>
      <div class="flex-1">
        <a href="tables-gridjs.html#!" class="stretched-link">
          <h6 class="mt-0 mb-2 lh-base"><b>Client : </b> {{$element['nom'].' ' .$element['prenoms']}} <span class="text-secondary">reward</span> is ready! </h6>
        </a>
        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
          <span>
            <i class="mdi mdi-clock-outline"></i> {{$element['created_at']}}</span>
        </p>
      </div>
     
    </div>
  </div>

  @endforeach
@else
 {{'pas de notifications '}}