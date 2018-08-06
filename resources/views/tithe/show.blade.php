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
    <a href="/profile/1/edit" class="w3-bar-item w3-button"><i class="fa fa-address-card"></i> Other Details</a>
  </div>


    <a href="/tithe" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fab fa-bitbucket"></i> Tithe</a>
    <a href="/announ" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fa fa-bell"></i> Announcement</a>
    <a  href="/message" class="w3-bar-item w3-button w3-text-green w3-border w3-border-black"><i class="fa fa-inbox"></i> Message</a>

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




         <link rel="stylesheet" href="/css/w3css.css">
         <div class="w3-container">
           <div class=" w3-panel  w3-cente w3-padding-left-64" >
             <br>
                  <legend class="w3-border w3-border-green">Tithe Information
           <div class="w3-panel w3-large" >
              <div class="w3-half -card-4 w3-center">
               <h4 class="w3-text-green" >My Tithe contribution</h4>
               <i class="fab fa-bitbucket fa-5x"></i>
               <h6>Total Amount</h6>
                 <div class="">
                    <button style="width:100px" class="w3-xxlarge w3-border w3-border-green w3-round-large" type="button" name="button">{{$tithes}}</button>

                 </div>
                   <br>
                   <h6>Records</h6>
                 <div class="w3-container">
                   <table class="w3-table-all w3-border w3-border-black">
                     <th class="w3-green">Mode</th>
                     <th class="w3-green">Amount</th>
                     <th class="w3-green">Date</th>
                     @foreach($records as $record)
                     @if($tithes==0)
                     <tr>
                       <td>No records Found</td>

                     </tr>
                     @endif
                     <tr>
                       <td>{{$record->mode}}</td>
                       <td>{{$record->amount}}</td>
                       <td>{{$record->created_at}}</td>
                     </tr>
                     @endforeach

                   </table>
                 </div>

              </div>
              <div class="w3-half">
               <h4 class="w3-text-green" >Contribute With Mpesa</h4>
               
              <h3>1.Using Mpesa STK Push</h3>
              <p>How it works</p> 
              <p>When you initiate payment, a popup will appear in your phone requesting
               you to enter your Mpesa pin.You only need to enter a valid amount in the form
               below and click initiate button</p>
               <p>NB: Before initiating payment make sure:-</p>

               <h4 class="w3-text-green">Confirm your Phone Number {{Auth::user()->phone}}</h4>
                 <div>
                   @include('partials.mpesa')
                 </div>
               <form action="{{url('mpesa')}}" method="post">
                  {{@csrf_field()}}
                 <input class="w3-round-large" type="text" name="amount" placeholder="Enter Amout">
                 <input class="w3-button w3-green" type="submit" name="submit" value="Initite Payment">
               </form>
               
               <br>
               <h3>2. Procedures Option(Without STK push)</h3>
               <ol>
                 <li> Go to the MPESA menu,</li>
                 <li>Select payment services</li>
                 <li>Choose Pay Bill option</li>
                 <li>Enter XXXX as the business number</li>
                 <li>Enter your full name as the account number</li>
                 <li>Enter the amount</li>
                 <li>Enter your pin and press Ok</li>

                    </ol>
              </div>

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
