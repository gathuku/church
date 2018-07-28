@extends('layouts.app')

@section('content')



<link rel="stylesheet" href="/css/w3css.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
<link rel="stylesheet" href="/css/style.css">


  <!-- Sidebar -->
  <div class="w3-sidebar w3-bar-block w3-border-right  w3-large" style="display:" id="mySidebar">
    <button onclick="w3_close()" class="w3-bar-item w3-large">Close &times;</button>
    <a onclick="drop()" href="#" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fa fa-user"></i> Profile</a>
    {{-- Expandable Accordion--}}

    <div id="profiledrop" class="w3-hide w3-white w3-card w3-center">
    <a id="maindetails" href="/profile" class="w3-bar-item w3-button"><i class="fa fa-user-circle"></i> Main Details</a>
    <a href="/profile/edit" class="w3-bar-item w3-button"><i class="fa fa-address-card"></i> Other Details</a>
  </div>

    <a href="/tithe" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fab fa-bitbucket"></i> Tithe</a>
    <a href="/announ" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fa fa-bell"></i> Announcement</a>
    <a onclick="messagedrop()" href="/message" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fa fa-inbox"></i> Message</a>


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


      <div  class="w3-panel" style="margin-left:20px; text-transform:uppercase;">
        <h1 class="w3-center w3-xxlarge ">servanthood center portal</h1>
<br>
        @if(Auth::user())
        <h3 class="w3-center">Welcome <br> you are logged in</h3>
        @if(Auth::user()->role ==2)
        <h3 class="w3-center">As administrator</h3>
        <div class="w3-panel w3-center">
          <h6 >Admin Operation</h6>
        <a href="/excell/users"><button  class="w3-button w3-green w3-round" type="button" name="button"><i class="fas fa-file-excel fa-2x"></i> Users</button></a>
          <a href="/excell/tithes"><button  class="w3-button w3-green w3-round" type="button" name="button"><i class="fas fa-file-excel fa-2x"></i> Tithes</button></a>

        </div>
        @endif
        @endif
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
