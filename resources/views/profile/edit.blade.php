



@extends('layouts.app')

@section('content')



<link rel="stylesheet" href="/css/w3css.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">



  <!-- Sidebar -->
  <div class="w3-sidebar w3-bar-block w3-border-right  w3-large" style="display:" id="mySidebar">
    <button onclick="w3_close()" class="w3-bar-item w3-large">Close &times;</button>
    <a onclick="drop()" href="#" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fa fa-user"></i> Profile</a>
    {{-- Expandable Accordion--}}

    <div id="profiledrop" class="w3-hide w3-white w3-card w3-center">
    <a id="maindetails" href="/profile" class="w3-bar-item w3-button"><i class="fa fa-user-circle"></i> Main Details</a>
    <a href="#" class="w3-bar-item w3-button"><i class="fa fa-address-card"></i> Other Details</a>
  </div>


    <a href="/tithe" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fab fa-bitbucket"></i> Tithe</a>
    <a href="/announ" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fa fa-bell"></i> Announcement</a>
    <a onclick="" href="/message" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fa fa-inbox"></i> Message</a>


  </div>

  <!-- Page Content -->
  <div class="w3-container">
    <div class="">
      <div class="w3-green">
        <div class="w3-half">
      <button class="w3-button w3-green w3-xlarge " onclick="w3_open()">☰</button>
        </div>
        <div class="w3-half">
       <!--<h4 class=" w3-text-orange w3-xxlarge"><b>Access All Your Information</b></h4> -->
        </div>
      </div>

      <div id="display" class="w3-panel">

				<div class="container">

				<hr>

				<div class="row">
					<aside class="col-sm-6">

				<article class="">
          <legend class="w3-border-green w3-border">
				<div class="card-body p-5">

          @foreach($users as $user)
          @endforeach
				<form role="form" method="post" action="/profile/update">
        {{csrf_field()}}
          <input type="hidden" name="_method" value="put">

				<div class="form-group">
				<label for="username">Full name</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fa fa-user"></i></span>
					</div>
					<input value="{{$user->name}}" type="text" class="form-control" name="name" placeholder="" required="">
				</div> <!-- input-group.// -->
				</div> <!-- form-group.// -->

				<div class="form-group">
				<label for="cardNumber">Member Number</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fa fa-credit-card"></i></span>
					</div>
					<input value="{{$user->member_no}}" type="text" class="form-control" name="member_no" placeholder="">
				</div> <!-- input-group.// -->
				</div> <!-- form-group.// -->


				<div class="form-group">
				<label for="cardNumber">Phone Number</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fa fa-credit-card"></i></span>
					</div>

					<input value="{{$user->phone}}" type="text" class="form-control" name="phone" placeholder="">
				</div> <!-- input-group.// -->
				</div> <!-- form-group.// -->

				<div class="form-group">
						<label><span class="hidden-xs">Category</span> </label>
					<div class="form-inline">
						<select class="form-control" style="width:100%" name="category" value="{{$user->category}}">
					<option value="Member">Member</option>
					<option value="Visitor">Visitor</option>
					<option value="Ex Member">Ex Member</option>

				</select>

					</div>
				</div>
				<div class="row">
				    <div class="col-sm-12">
				        <div class="form-group">
				            <label><span class="hidden-xs">Gender</span> </label>
				        	<div class="form-inline">
				        		<select class="form-control" style="width:100%" name="gender" >

								  <option value="Male">Male</option>
								  <option value="Female">Female</option>

								</select>

				        	</div>

								</div>

				        </div>
				    </div>

      <label class="col-md-4 control-label" for="date"> Birth Date </label>
      <div class="form-group">
       <div class="">

       </div>
       <input class="form-control" id="date" value="{{$user->birth_date}}" name="birth_date" placeholder="MM/DD/YYYY" type="text">
       </div>

                 <br>
                   <div class="form-group w3-center">
                     <input class="w3-button w3-green w3-border w-border-orange w3-round " type="submit" name="" value=" Save Changes">
                   </div>
				</form>
				</div> <!-- card-body.// -->
        </legend>
				</article> <!-- card.// -->


					</aside> <!-- col.// -->
					<aside class="col-sm-6">


				<article class="">
          <legend class="w3-border w3-border-green">

					<div class="w3-container">
				  <h2>Personal Image</h2>

				  <div class="w3-car w3-center" style="width:50%">
            <br>
				    <img class="w3-round" src="/uploads/avatars/{{$user->avatar}}" alt="Person" style="width:150px;height:150px ">
                <br>
                <br>
            <div class="w3-container">
              <form enctype="multipart/form-data" class=" " action="/profile/update_avatar" method="post">
                <input class="" type="file" name="avatar" value="">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <br>
                <br>
                <input class=" w3-button w3-green" type="submit" name="" value="Change">

              </form>
<br>
				    </div>
				  </div>
				</div>
				<br>
        </legend>
				</article> <!-- card.// -->


					</aside> <!-- col.// -->
				</div> <!-- row.// -->

				</div>
				<!--container end.//-->







      </div>
  </div>


  <script>

  function drop() {
      var x = document.getElementById("profiledrop");
      if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
          x.previousElementSibling.className += " w3-text-green";
      } else {
          x.className = x.className.replace(" w3-show", "");
          x.previousElementSibling.className =
          x.previousElementSibling.className.replace(" w3-text-green", "");
      }
  }

  function messagedrop() {
      var x = document.getElementById("messagedrop");
      if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
          x.previousElementSibling.className += " w3-text-green";
      } else {
          x.className = x.className.replace(" w3-show", "");
          x.previousElementSibling.className =
          x.previousElementSibling.className.replace(" w3-text-green", "");
      }
  }


  function w3_open() {
      document.getElementById("mySidebar").style.display = "block";
  }
  function w3_close() {
      document.getElementById("mySidebar").style.display = "none";
  }
  </script>


@endsection
