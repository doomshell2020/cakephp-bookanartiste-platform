   <script type="text/javascript">
     function initialize() {
       var latlng = new google.maps.LatLng(<?php echo $profile['current_lat'] ?>, <?php echo $profile['current_long'] ?>);
       var map = new google.maps.Map(document.getElementById('map'), {
         center: latlng,
         zoom: 13
       });
       var marker = new google.maps.Marker({
         map: map,
         position: latlng,
         draggable: false,
         anchorPoint: new google.maps.Point(0, -29)
       });
       var infowindow = new google.maps.InfoWindow();
       google.maps.event.addListener(marker, 'click', function() {
         var iwContent = '<div id="iw_container">' +
           '<div class="iw_title"><b>Location</b> : <?php echo $profile["current_location"]; ?></div></div>';
         // including content to the infowindow
         infowindow.setContent(iwContent);
         // opening the infowindow in the current map and at the current marker location
         infowindow.open(map, marker);
       });
     }
     google.maps.event.addDomListener(window, 'load', initialize);
   </script>
   <!----------------------editprofile-strt----------------------->
   <section id="edit_profile">
     <div class="container">
       <h2>Current<span> Location</span></h2>
       <p class="m-bott-50">We recommend you to keep your current location updated for more visibility</p>

       <div class="row">


         <div class="tab-content">
           <div class="profile-bg m-top-20">
             <?php echo $this->Flash->render(); ?>
             <div id="Personal" class="tab-pane fade in active">
               <div class="container m-top-60">
                 <?php echo $this->Form->create($profile, array('url' => array('controller' => 'users', 'action' => 'currentlocation'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>


                 <?php   //pr($profile); 
                  ?>

                 <div class="form-group">
                   <label for="" class="col-sm-2 control-label">Current Location:</label>
                   <button id="btn" type="submit" class="btn btn-default">Submit</button>
                   <div class="col-sm-9">

                     <?php echo $this->Form->input('current_location', array('class' =>
                      'longinput form-control', 'maxlength' => '20', 'placeholder' => 'Location', 'label' => false, 'id' => 'pac-input', 'required' => true)); ?>

                     <?php echo $this->Form->input('current_lat', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'latitude', 'label' => false)); ?>
                     <?php echo $this->Form->input('current_long', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'longitude', 'label' => false)); ?>
                   </div>
                   <div class="col-sm-1"></div>
                 </div>
                 <div id="map"></div>

                 <!-- <div class="form-group">
                  <div class="col-sm-8 text-center">
                    <button id="btn" type="submit" class="btn btn-default">Submit</button>
                  </div>
                </div> -->
                 <?php echo $this->Form->end(); ?>
               </div>
             </div>
           </div>
         </div>
       </div>
     </div>
   </section>

   <style>
     /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
     #map {
       height: 40%;
     }

     /* Optional: Makes the sample page fill the window. */
     html,
     body {
       height: 100%;
       margin: 0;
       padding: 0;
     }

     #description {
       font-family: Roboto;
       font-size: 15px;
       font-weight: 300;
     }

     #infowindow-content .title {
       font-weight: bold;
     }

     #infowindow-content {
       display: none;
     }

     #map #infowindow-content {
       display: inline;
     }

     .pac-card {
       margin: 10px 10px 0 0;
       border-radius: 2px 0 0 2px;
       box-sizing: border-box;
       -moz-box-sizing: border-box;
       outline: none;
       box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
       background-color: #fff;
       font-family: Roboto;
     }

     #pac-container {
       padding-bottom: 12px;
       margin-right: 12px;
     }

     .pac-controls {
       display: inline-block;
       padding: 5px 11px;
     }

     .pac-controls label {
       font-family: Roboto;
       font-size: 13px;
       font-weight: 300;
     }

     #pac-input:focus {
       border-color: #4d90fe;
     }

     #title {
       color: #fff;
       background-color: #4d90fe;
       font-size: 25px;
       font-weight: 500;
       padding: 6px 12px;
     }

     #target {
       width: 345px;
     }

     .btn-default {
       padding: 10px 24px;
     }
   </style>

   <script>
     function validatePass(p1, p2) {
       if (p1.value != p2.value) {
         p2.setCustomValidity('Password incorrect');
       } else {
         p2.setCustomValidity('');
       }
     }
   </script>