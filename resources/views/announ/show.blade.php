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
    <a onclick="" href="/message" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fa fa-inbox"></i> Message</a>



  </div>

  <!-- Page Content -->
  <div class="w3-container ">
    <div class="w3-green">
      <div class="w3-half">
    <button class="w3-button w3-green w3-xlarge " onclick="w3_open()">☰</button>
      </div>
      <div class="w3-half">
     <!--<h4 class=" w3-text-orange w3-xxlarge"><b>Access All Your Information</b></h4> -->
      </div>

    </div>


      <div id="display" class="w3-container" style="margin-left:6%">
           <h2 class="w3-center">Announcements</h2>
        @foreach($announs as $announ)

        <div onclick="myFunction('Demo1')" class=" w3-block w3-light-green w3-left-align">

          <div class="w3-quarter">
            <img class="w3-circle w3-right" src="/uploads/avatars/{{$announ->avatar}}" alt="Sender Image" style="width:80px;height:80px">
          </div>
          <div class="w3-threequarter">
            <h5>{{Auth::user()->name}}<span class="w3-text-green" > ({{$announ->created_at}})</span> </h5>


                <div class="" style="width:80%">
                    {{$announ->message}}
                </div>

          </div>

        </div>

        {{--
        <div id="Demo1" class="w3-container w3-hide">
          <h4>Comments</h4>
          @foreach($comments as $comment)
          @if($comment->commentable_id = $announ->id)

          <div class="w3-quarter">
            <img class="w3-circle w3-right" src="/uploads/avatars/{{$announ->avatar}}" alt="Sender Image" style="width:80px;height:80px">
          </div>
          <div class="w3-threequarter">
            <h5>{{$announ->name}} </h5>

                {{$comment->comment_body}}

          </div>

           @endif
          @endforeach
          <p>Add a new Comment</p>
          <div class="">
            <form class="" action="/comment/store" method="post">
              <input type="hidden" name="commentable_id" value="{{$announ->id}}">
              <textarea class="w3-input" placeholder="Type your Comment" name="comment-body" rows="8" cols="80"></textarea>
              <input class="w3-button w3-green" type="submit" name="" value="Comment">
            </form>

          </div>
        </div>
        --}}


          @endforeach

      </div>
  </div>


  <script>

  function myFunction(id) {
      var x = document.getElementById(id);
      if (x.className.indexOf("w3-show") == -2) {
          x.className += " w3-show";
      } else {
          x.className = x.className.replace(" w3-show", "");
      }

  }

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
