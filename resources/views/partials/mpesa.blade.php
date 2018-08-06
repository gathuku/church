
@if(session()->has('mpesaAlert'))
<div class="alert alert-warning alert-dismissible" role="alert">
  <strong>
  {!! session()->get('mpesaAlert') !!}
  </strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
