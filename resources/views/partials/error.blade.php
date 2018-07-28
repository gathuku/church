
@if(isset($errors)&&count($errors)>0)
<div class="alert alert-warning alert-dismissible " role="alert">

  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    @foreach($errors -> all() as $error)
    <li><strong> {!! $error!!}</strong> </li>
   @endforeach
  </button>
</div>
@endif
