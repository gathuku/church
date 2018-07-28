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
    <a  href="/profile" class="w3-bar-item w3-button"><i class="fa fa-user-circle"></i> Main Details</a>
    <a href="/profile/1/edit" class="w3-bar-item w3-button"><i class="fa fa-address-card"></i> Other Details</a>
  </div>
  <a href="/tithe" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fab fa-bitbucket"></i> Tithe</a>
    <a href="/announ" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fa fa-bell"></i> Announcement</a>
    <a onclick="" href="#" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fa fa-inbox"></i> Message</a>



  </div>

  <!-- Page Content -->
  <div class="w3-container">
    <div class="w3-green">
      <div class="w3-half">
    <button class="w3-button w3-green w3-xlarge " onclick="w3_open()">☰</button>
      </div>
      <div class="w3-half">
     <!--<h4 class=" w3-text-orange w3-xxlarge"><b>Access All Your Information</b></h4> -->
      </div>
    </div>

      <div id="display" class="w3-panel">


         <div class="w3-container">
           <div class="w3-card-4 w3-panel  w3-cente w3-padding-left-64" >
             <br>
                  <legend class="w3-border w3-border-green">Personal Information
           <div class="w3-panel w3-large" style="margin-left:25%">
             @foreach($users as $user)
             <label class="" for=""><b>Full Name:</b></label>
             {{$user->name}}
             <p>
               <label for=""> <b>Email Address:</b> </label>
               {{$user->email}}
             </p>

             @endforeach

            <p><b> Category:</b> {{$user->category}}</p>
            <p> <b>Gender:</b>  {{$user->gender}}</p>
            <p><b>Member No:</b>  {{$user->member_no}}</p>
            <p><b>phone: </b> {{$user->phone}}</p>
            <p><b>Birth Date:</b>  {{$user->birth_date}}</p>


            <a href="/profile/{{$user->id}}/edit"><button class="w3-button w3-border w3-border w3-green " type="button" name="button">Edit </button></a>

           </div>
         </legend>
        </div>
        </div>

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




  function w3_open() {
      document.getElementById("mySidebar").style.display = "block";
  }
  function w3_close() {
      document.getElementById("mySidebar").style.display = "none";
  }
  </script>


@endsection
