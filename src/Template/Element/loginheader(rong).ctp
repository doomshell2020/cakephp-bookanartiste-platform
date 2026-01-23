<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Book An Artiste</title>
  <!--<link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700" rel="stylesheet">-->
  <link href="<?php echo SITE_URL; ?>/css/fontcss.css" rel="stylesheet">
  <script src="<?php echo SITE_URL; ?>/js/jquery.min.js"></script>
  <!-- bootstrap -->
  <script src="<?php echo SITE_URL; ?>/js/jquery-2.0.3.min.js"></script> 
  <script src="<?php echo SITE_URL; ?>/js/bootstrap.min.js"></script>
  <!-- Google Login -->

  <?php if (ENVIOREMENT=='devlopment'){ ?>
  <script src="<?php echo SITE_URL; ?>/js/platform.js" async defer></script>
  <?php }else{ ?>
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <meta name="google-signin-client_id" content="781092659219-aa2tl98jol29mc7488q7thv76rr6pd69.apps.googleusercontent.com">
  <?php } ?>
  <!--  END Google Login -->

  <link href="<?php echo SITE_URL; ?>/css/bootstrap-editable.css" rel="stylesheet"/>
  <script src="<?php echo SITE_URL; ?>/js/bootstrap-editable.min.js"></script>

  <script src="<?php echo SITE_URL; ?>/main.js"></script>
  <link href="<?php echo SITE_URL; ?>/css/bootstrap.min.css" rel="stylesheet">
  <script src="<?php echo SITE_URL; ?>/js/bootstrap-datetimepicker.js"></script>

  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script> -->
  <script src="<?php echo SITE_URL; ?>/js/bootstrap-datepicker.js"></script>

  <!--<link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/jquery-ui.css"> -->

  <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
  <!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  -->


  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--owl-carousel -->
    <link href="<?php echo SITE_URL; ?>/css/owl.carousel.css" rel="stylesheet" type="text/css">

    <link href="<?php echo SITE_URL; ?>/css/custom.css" rel="stylesheet" type="text/css">
    <link href="<?php echo SITE_URL; ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/admin/datepicker3.css"/> 

    <!--<script src="<?php echo SITE_URL; ?>/js/lightgallery-all.min.js"></script> -->
    <script src="<?php echo SITE_URL; ?>/js/owl.carousel.js"></script>
    <link href="<?php echo SITE_URL; ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--<link href="<?php echo SITE_URL; ?>/css/lightgallery.css" rel="stylesheet" type="text/css">-->
    <link href="<?php echo SITE_URL; ?>/css/style.css" rel="stylesheet" type="text/css">


    <link href="<?php echo SITE_URL; ?>/css/responsive.css" rel="stylesheet" type="text/css">
    <script src="<?php echo SITE_URL; ?>/js/bootstrapmultipleselect.js"></script>


<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js"></script> 
-->
<script src="<?php echo SITE_URL; ?>/css/bootstrap-dialog.min.css"></script>
<script src="<?php echo SITE_URL; ?>/js/bootstrap-dialog.min.js"></script>
<link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/jquery-ui.css">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.0&appId=148076566015718&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<input type="hidden" name ="culathead" id="culathead">
<input type="hidden" name ="culonghead" id="culonghead">

<script>
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">







if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function (p) {
        var LatLng = new google.maps.LatLng(p.coords.latitude, p.coords.longitude);
      
   $("#culathead").val(p.coords.latitude);
 $("#culonghead").val(p.coords.longitude);
       initMap(p.coords.latitude,p.coords.longitude)
    });
} 






      function initMap() {
var uluru = {lat: 26.9572835, lng: 75.7778347};
var map = new google.maps.Map(document.getElementById('map'), {
  center: uluru,
  zoom: 15
});
var card = document.getElementById('pac-card');
var input = document.getElementById('pac-input');
var curinput = document.getElementById('pac-inputss');
var types = document.getElementById('type-selector');
var strictBounds = document.getElementById('strict-bounds-selector');

map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

var autocomplete = new google.maps.places.Autocomplete(input);
var autocompletecurrent = new google.maps.places.Autocomplete(curinput);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);
        autocompletecurrent.bindTo('bounds', map);
        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          position: uluru,
          map: map,
          anchorPoint: new google.maps.Point(0, -29)

        });
        autocomplete.addListener('place_changed', function() { 
          infowindow.open();
          marker.setVisible(false);
          var place = autocomplete.getPlace(); 
          changelatlong(place.geometry.location);
         // alert(place);
         if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
            (place.address_components[0] && place.address_components[0].short_name || ''),
            (place.address_components[1] && place.address_components[1].short_name || ''),
            (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindowContent.children['place-icon'].src = place.icon;
          infowindowContent.children['place-name'].textContent = place.name;
          infowindowContent.children['place-address'].textContent = address;
          infowindow.open(map, marker);
        });

//current location 
autocompletecurrent.addListener('place_changed', function() { 
  infowindow.open();
  marker.setVisible(false);
  var place = autocompletecurrent.getPlace(); 
  changelatlongcurrent(place.geometry.location);
         // alert(place);
         if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
            (place.address_components[0] && place.address_components[0].short_name || ''),
            (place.address_components[1] && place.address_components[1].short_name || ''),
            (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindowContent.children['place-icon'].src = place.icon;
          infowindowContent.children['place-name'].textContent = place.name;
          infowindowContent.children['place-address'].textContent = address;
          infowindow.open(map, marker);
        });

function changelatlongcurrent(location)
{
  latitudecurrent = location.lat(); 
  longitudecurrent = location.lng(); 
  if(document.getElementById('latitudecurrent')!=undefined)
  {
    document.getElementById('latitudecurrent').value = latitudecurrent; 
  }
  if(document.getElementById('longitudecurrent')!=undefined)
  {
    document.getElementById('longitudecurrent').value = longitudecurrent; 
  }
}

function changelatlong(location)
{
  latitude = location.lat(); 
  longitude = location.lng(); 
  if(document.getElementById('latitude')!=undefined)
  {
    document.getElementById('latitude').value = latitude; 
  }
  if(document.getElementById('longitude')!=undefined)
  {
    document.getElementById('longitude').value = longitude; 
  }
}


        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);

        document.getElementById('use-strict-bounds')
        .addEventListener('click', function() {
          console.log('Checkbox clicked! New state=' + this.checked);
          autocomplete.setOptions({strictBounds: this.checked});
        });
      }
    </script>


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC27M5hfywTEJa5_l-g0KHWe8m8lxu-rSI&libraries=places&callback=initMap"
    async defer></script>
    <style type="text/css">


    .translate-inmenu .switcher .selected a {border:1px solid #CCCCCC;
      background:url(.../../flag/arrow_down.png) 
      146px center no-repeat;color:#ffffff;padding:9px 5px;width:151px; margin-top:10px;}
      .switcher .selected a.open {background-image:url(.../../flag/arrow_up.png)}
      .switcher .selected a:hover {background:transparent url(.../../flag/arrow_down.png) 146px center no-repeat;}
      .switcher .option {position:absolute;z-index:9998;border-left:1px solid #CCCCCC;border-right:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC;background-color:#EEEEEE;display:none;width:161px;max-height:198px;-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;overflow-y:auto;overflow-x:hidden;}
      .switcher .option a {color:#000;padding:3px 5px;}
      .switcher .option a:hover {background:#FFC;}
      .switcher .option a.selected {background:#FFC;}
      #selected_lang_name {float: none;}


    </style>
  </head>
  <body class="page-login" onLoad="initMap()" style="margin:0px; border:0px; padding:0px;" id="md">

    <div id="page-wrapper"> 
      <header class="header-2">
        <div class="container">
          <div class="row">
            <div class="col-sm-2 text-left"><a href="<?php echo SITE_URL; ?>"><img src="<?php echo SITE_URL; ?>/images/book-an-artiste-logosecond.png" alt="logo"></a></div>
            <div class="col-sm-10">
              <ul class="text-right">
                <!--<li><a href="#"><i class="fa fa-user-plus" aria-hidden="true"></i>Join For Free</a></li>-->


                <?php  $rolepresent=$this->request->session()->read('Auth.User.role_id'); 
                if($rolepresent==''||$rolepresent=='1'){ ?>

                <li><a href="<?php echo SITE_URL; ?>/signup" class="btn btn-primary"><i class="fa fa-user-plus" aria-hidden="true"></i>Join for free</a></li>
                <?php  } ?>




                <?php $rolepresent=$this->request->session()->read('Auth.User.role_id'); 
                //pr($rolepresent);
                if($rolepresent==''||$rolepresent=='1'){ ?>

                <li><a href="<?php echo SITE_URL; ?>/login" class="btn btn-default"><i class="fa fa-sign-in" aria-hidden="true"></i>Login</a></li>
                <?php }else{ ?>
                <li class="dropdown">
                  <a href="<?php echo SITE_URL; ?>/package/allpackages/" class="btn btn-primary">Packages</a></li>

                </li>   
                <li><a href="<?php echo SITE_URL?>/jobpost" class="btn btn-default">Post Requirement</a></li>
                <li class="badges">
                  <a href="<?php echo SITE_URL;?>/calendar/">
                    <img src="<?php echo SITE_URL ?>/images/icon_calender.png" alt="calender"> &nbsp;Calender
                    <span class="badge_icon"><?php $cald_ate= $this->Comman->calendardatacheckbydate();
               echo  $cald_ate[0]['totalcalendarcount']; ?>
                    </span>
                  </a>
                  </li>
                <li class="dropdown"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php echo SITE_URL ?>/images/icon_search.png" alt="search"></a>
                 <!--<span class="count_no">10</span>--> 
                 <div class="dropdown-menu search_drop_form drop-menu">
                  <form enctype="multipart/form-data" method="get" accept-charset="utf-8" inputdefaults=" " class="form-horizontal" id="searchmyform" action="/search/search">
                    <ul>
                      <li>
                        <ul class="search_line">
                          <li class="srch_line">
                           <?php echo $this->Form->input('name',array('class'=>'form-control','label' =>false,'placeholder'=>'What are you looking for...','autocomplete'=>'off')); ?>
                           <!-- <input type="text" class="form-control" placeholder="What are you looking for..." name="email" autocomplete="off">-->
                         </li>
                         <li class="srch_titl">
                          <?php $opt= array('1'=>'Job','2'=>'Talent'); ?>
                          <?php echo $this->Form->input('optiontype',array('class'=>'srch_titl typesearch','required'=>true,'label' =>false,'options'=>$opt,'autocomplete'=>'off')); ?>



                        </li>
                        <li class="adv_srch">
                          <a href="<?php echo SITE_URL  ?>/search/advanceJobsearch" id="dynlink">Advance Job Search</a><br>
                          <a href="<?php echo SITE_URL  ?>/search/advanceProfilesearch" id="dynlink">Advance Profile Search</a>
                        </li>
                      </ul>
                    </li>
                    <li class="srch_btn"> <button type="submit" class="btn btn-default">Submit</button> </li>
                  </ul>
                  <?php echo $this->Form->end(); ?>
                </div>
              </li>
              <li class="dropdown"><a href="javascript:void(0)" onclick="checkmessagenotification(this);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php echo SITE_URL ?>/images/icon_message.png" alt="message"><span id="messages" class="num hide"></span></a>
                <div class="dropdown-menu msg_popup" id="message_request">

                </div>

              </li>
              <?php $profile_detail= $this->Comman->profileheader(); 

              // print_r($profile_detail);
              ?>

              <?php if($profile_detail['user']['role_id']== TALANT_ROLEID){ ?>


              <li class="dropdown"><a href="<?php echo SITE_URL; ?>/myalerts" class="dropdown-toggle"  role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php echo SITE_URL; ?>/images/bell.png" alt="ny" /><span id="total_alerts" class="num hide"></span></a>
                <div class="dropdown-menu bell_popup" id="job_request"></div>
              </li>
              <?php } ?>
              <li class="dropdown">
                <a onclick="checkfriendnotification(this);" class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><img src="<?php echo SITE_URL; ?>/images/user.png" alt="ny" /><span id="friend_req" class="num hide"></span>
                </a>
                <div class="dropdown-menu request_popup">
                  <ul class="main_request" id="main_request">
                    <li class="view_all_request">View All</li>
                  </ul>
                </div>

              </li>  
              <li class="dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?php echo SITE_URL; ?>/images/flag.png" alt="ny" /></a>

                <ul class="dropdown-menu flag_popup ">

                  <li><a href="#">1 Notification</a></li>
                  <li><a href="#">1 Notification</a></li>
                </ul>
              </li>
              <?php $profile_detail= $this->Comman->profileheader();  ?>


              <?php if ($profile_detail['social']==1){ ?>

              <li class="profile_img_cercle profile_slidedown"><a href="javascript:void(0)"><img src="<?php echo $profile_detail['profile_image']; ?>" alt="profile_image"></a><span class="caret"></span></li>

              <?php } else if($profile_detail['profile_image']!=''){ ?>

              <li class="profile_img_cercle profile_slidedown"><a href="javascript:void(0)"><img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile_detail['profile_image']; ?>" alt="profile_image"></a><span class="caret"></span></li>

              <?php } else{ ?>

              <li class="profile_img_cercle profile_slidedown"><a href="javascript:void(0)"><img src="<?php echo SITE_URL; ?>/images/noimage.jpg" alt="profile_image"></a><span class="caret"></span></li>
              <?php } ?>
              <li class="profile_drop_form">
                <ul class="profile_drop_form_cntent">
                  <!--<li></li>-->

                  <li><a href="<?php echo SITE_URL?>/dashboard"><img src="<?php echo SITE_URL ?>/images/dashboard.png" alt="edit_profile_icon">Dashboard</a></li>

                  <!--<li><a href="<?php echo SITE_URL?>/profile"><img src="<?php echo SITE_URL ?>/images/icon_edit_profile.png" alt="edit_profile_icon"><?php echo $this->request->session()->read('Auth.User.user_name'); ?></a></li> -->
                  <?php if($this->request->session()->read('Auth.User.is_talent_admin')=='Y'){ ?>
                  <li class="talent_admin_menu">
                    <a href="javascript:voide(0);" class="menu_heading">Talent Admin <span class="pull-right"><i class="fa fa-angle-down"></i></span></a>
                    <ul class="talent_admin_menu_open">
                      <?php if($this->request->session()->read('talentadmin.enable_create_subadmin')=='Y'){ ?>
                      <li><a href="<?php echo SITE_URL?>/talentadmin/subadmins"><img src="<?php echo SITE_URL ?>/images/Manage-Talent-Partners.png" alt="edit_profile_icon">Manage Talent Partners</a></li>
                      <li><a href="<?php echo SITE_URL?>/talentadmin/refertalent"><img src="<?php echo SITE_URL ?>/images/Upload-Talent-Profile.png" alt="edit_profile_icon">Upload Talent Profile</a></li>
                      <li><a href="<?php echo SITE_URL?>/talentadmin/addsubadmin"><img src="<?php echo SITE_URL ?>/images/Upload-Talent-Profile.png" alt="edit_profile_icon">Create Talent Partner</a></li>
                      <li><a href="<?php echo SITE_URL?>/talentadmin/refers"><img src="<?php echo SITE_URL ?>/images/Profile-Uploaded.png" alt="edit_profile_icon">Profile Uploaded</a></li>
                      <?php }?>


                      <li><a href="<?php echo SITE_URL?>/talentadmin/mytranscations"><img src="<?php echo SITE_URL ?>/images/My-Transcation.png" alt="edit_profile_icon">My Transcation</a></li>
                      <li><a href="<?php echo SITE_URL?>/talentadmin/personaldetail"><img src="<?php echo SITE_URL ?>/images/icon_view_profile.png" alt="edit_profile_icon">personal Detail</a></li>
                      <li><a href="<?php echo SITE_URL?>/talentadmin/bankinformation"><img src="<?php echo SITE_URL ?>/images/Banking-Information.png" alt="edit_profile_icon">Banking Information</a></li>
                    </ul>
                  </li>
                  <?php }?>

                  <?php if($this->request->session()->read('Auth.User.is_content_admin')=='Y'){ ?>
                  <li class="content_admin_menu">
                    <a href="javascript:voide(0);" class="menu_heading">Content Admin <span class="pull-right"><i class="fa fa-angle-down"></i></span></a>
                    <ul class="content_admin_menu_open">
                     <li><a href="<?php echo SITE_URL?>/contentadmin/blockedusers"><img src="<?php echo SITE_URL ?>/images/Blocked-Users.png" alt="edit_profile_icon">Blocked Users</a></li>
                   </ul>
                 </li>
                 <?php }?>  


                 <li class="my_menu">
                  <a href="javascript:voide(0);" class="menu_heading">My Menu <span class="pull-right"><i class="fa fa-angle-down"></i></span></a>
                  <ul class="my_menu_open">
                    <?php if($this->request->session()->read('Auth.User.role_id')==TALANT_ROLEID || $this->request->session()->read('Auth.User.role_id')==NONTALANT_ROLEID){ ?>
                    <li><a href="<?php echo SITE_URL?>/profile"><img src="<?php echo SITE_URL ?>/images/icon_edit_profile.png" alt="edit_profile_icon">Edit Profile</a></li>
                    <li><a href="<?php echo SITE_URL?>/allcontacts"><img src="<?php echo SITE_URL ?>/images/All-Contacts.png" alt="edit_profile_icon">All Contacts</a></li>
                    <li><a href="<?php echo SITE_URL?>/myrequirement"><img src="<?php echo SITE_URL ?>/images/My-Requirement.png" alt="edit_profile_icon">My Requirement</a></li>
                    <li><a href="<?php echo SITE_URL?>/personalpage"><img src="<?php echo SITE_URL ?>/images/Personal-Page.png" alt="edit_profile_icon">Personal Page</a></li>
                    <li><a href="<?php echo SITE_URL?>/banner"><img src="<?php echo SITE_URL ?>/images/Personal-Page.png" alt="edit_profile_icon">HomPageBanner</a></li>

                    <li><a href="<?php echo SITE_URL?>/viewprofile"><img src="<?php echo SITE_URL ?>/images/View-Profile.png" alt="edit_profile_icon">View Profile</a></li>
                    <li><a href="<?php echo SITE_URL?>/featuredartist"><img src="<?php echo SITE_URL ?>/images/View-Profile.png" alt="edit_profile_icon">View Featured Artistes</a></li>
                    <li><a href="<?php echo SITE_URL?>/featuredjob"><img src="<?php echo SITE_URL ?>/images/View-Profile.png" alt="edit_profile_icon">View Featured Jobs</a></li>
                    <?php }?>
                    <li><a href="<?php echo SITE_URL?>/savejobs"><img src="<?php echo SITE_URL ?>/images/My-Requirement.png" alt="edit_profile_icon">Saved Jobs</a></li>
                    <li><a href="<?php echo SITE_URL?>/saveprofile"><img src="<?php echo SITE_URL ?>/images/My-Requirement.png" alt="edit_profile_icon">Saved Profile</a></li>
                    <li><a href="<?php echo SITE_URL?>/showjob/applied"><img src="<?php echo SITE_URL ?>/images/My-Requirement.png" alt="edit_profile_icon">Applied Jobs</a></li>

                    <li><a href="<?php echo SITE_URL?>/showjob/selected"><img src="<?php echo SITE_URL ?>/images/My-Requirement.png" alt="edit_profile_icon">Selected Jobs</a></li>

                    <li><a href="<?php echo SITE_URL?>/changepassword"><img src="<?php echo SITE_URL ?>/images/icon_change_password.png" alt="edit_profile_icon">Change Password</a></li>
                    <?php if($this->request->session()->read('Auth.User.role_id')==TALANT_ROLEID || $this->request->session()->read('Auth.User.role_id')==NONTALANT_ROLEID){ ?>
                    <li><a href="<?php echo SITE_URL; ?>/currentlocation"><img src="<?php echo SITE_URL ?>/images/icon_location.png" alt="edit_profile_icon">Update Current Location</a></li>

                    <li><a href="<?php echo SITE_URL; ?>/profile/featureprofile"><img src="<?php echo SITE_URL ?>/images/icon_location.png" alt="edit_profile_icon">Feature My Profile</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/search/refinejobshow"><img src="<?php echo SITE_URL ?>/images/icon_location.png" alt="edit_profile_icon">Saved Job Search Result
                    </a></li>

                    <li><a href="<?php echo SITE_URL; ?>/search/refineprofileshow"><img src="<?php echo SITE_URL ?>/images/icon_location.png" alt="edit_profile_icon">Saved Profile Search Result</a></li>

                    <?php }?>
                    <li><a href="<?php echo SITE_URL?>/users/logout"><img src="<?php echo SITE_URL ?>/images/icon_logout.png" alt="edit_profile_icon">Logout</a></li>


                  </ul>
                </li>

              </ul>
            </li>

            <?php } ?>

            <script>
              $(document).ready(function(){
                $(".talent_admin_menu").click(function(){
                  $(".talent_admin_menu_open").slideToggle();
                });

                $(".my_menu").click(function(){
                  $(".my_menu_open").slideToggle();
                });

                $(".content_admin_menu").click(function(){
                  $(".content_admin_menu_open").slideToggle();
                });
              });
            </script> 


            <script>





              $('.dropdown-menu').click(function(event){
                event.stopPropagation();
              });
              var site_url='<?php echo SITE_URL;?>/';

              function confirmuser(obj){ 
                var id=obj.id.match(/\d+/);
                id=parseInt(id);
                $.ajax({
                  dataType: "html",
                  type: "post",
                  evalScripts: true,
                  url: site_url+'profile/confirmuser',
                  data: ({profile:id}),
                  success:function(response){
                    $('#'+obj.id).addClass('active');
                    $('#dltuser'+id).css("display", "none");
                    $('.reqcnfyes'+id).css("display", "block");
                    $('.reqcnfno'+id).css("display", "none");
                    location.reload();
                  }
                });
              }
            </script>     
            <script>

  function deleteuser(obj){ //alert(obj);
    var id=obj.id.match(/\d+/);

    id=parseInt(id);
    $.ajax({
      dataType: "html",
      type: "post",
      evalScripts: true,
      url: site_url+'profile/deleteuser',
      data: ({profile:id}),
      success:function(response){
        $('#'+obj.id).addClass('active');
        $('#cnfuser'+id).css("display", "none");
        $('.reqdelyes'+id).css("display", "block");
        $('.reqdelno'+id).css("display", "none");
      }

    });
  }
</script>    
<script>


  function checkfriendnotification(){
    $.ajax({
      type: "post",
      url: site_url+'profile/contactrequestnoti',
      success:function(data){ 
        $("#main_request").html(data);
      }
    });
  }

  function checkmessagenotification(){
    $.ajax({
      type: "post",
      url: site_url+'message/messagesnoti',
      success:function(data){ 
        $("#message_request").html(data);
      }
    });
  }
    /*
    function checkjobnotification(){
  $.ajax({
      type: "post",
      url: site_url+'jobpost/jobnotification',
      success:function(data){ 
      $("#job_request").html(data);
  }
  });
    }
    */

    function checkfornotification(){
      $.ajax({
        type: "post",
        url: site_url+'homes/notifications',
        success:function(data){ 
          parsed_data = JSON.parse(data);


          if(parsed_data.total_alerts  > 0)
          {
    // friend req notification
    $("#total_alerts").removeClass("hide");
    $("#total_alerts").html(parsed_data.total_alerts);
  }
  else
  {
    $("#total_alerts").addClass("hide");
  }


  if(parsed_data.friendreq  > 0)
  {
    // friend req notification
    $("#friend_req").removeClass("hide");
    $("#friend_req").html(parsed_data.friendreq);
  }
  else
  {
    $("#friend_req").addClass("hide");
  }
  if(parsed_data.messages  > 0)
  {
    // message 
    $("#messages").removeClass("hide");
    $("#messages").html(parsed_data.messages);
  }
  else
  {
    $("#messages").addClass("hide");
  }
     // $("#main_request").html(data);
   }
 });
    }
    
    <?php if($this->request->session()->read('Auth.User.id')){ ?>
      setInterval(function(){ checkfornotification(); }, 5000);
      <?php } ?>

    </script>




    <script>
      $(document).ready(function(){
        $(".profile_slidedown").click(function(e){

        e.preventDefault(); // stops link from making page jump to the top
        e.stopPropagation(); // when you click the button, it stops the page from seeing it as clicking the body too

        $(".profile_drop_form").slideToggle();
      });
        $('.profile_drop_form').click( function(e) {

        e.stopPropagation(); // when you click within the content area, it stops the page from seeing it as clicking the body too
        
      });
        $('body').click( function() {

          $('.profile_drop_form').hide();

        });

      });



    </script>
    <script>
      $(document).ready(function(){
        $(".search_slidedown").click(function(){
          $(".search_drop_form").slideToggle();
        });
      });
    </script>
    <script>
      $(document).ready(function(){
        $(".msg_dropdown").click(function(){
          $(".msg_popup").slideToggle();
        });
      });
    </script>
    <script>
      $(document).ready(function(){
        $(".bell_dropdown").click(function(){
          $(".bell_popup").slideToggle();
        });
      });
    </script>
    <script>
      $(document).ready(function(){
        $(".flag_dropdown").click(function(){
          $(".flag_popup").slideToggle();
        });
      });
    </script>
    <script>
      $(document).ready(function(){
        $(".request_form").click(function(){
          $(".request_popup").slideToggle();
        });
      });
    </script>

    <script type="text/javascript">

      $(".typesearch").change(function(){

        var site_url='http://bookanartiste.com/';
        var type=$(".typesearch").val();

        if(type==1){

          $('#searchmyform').attr('action',site_url+'search/search');

        }else{

          $('#searchmyform').attr('action',site_url+'search/profilesearch');

        }
      });

    </script>
    <script>

      $('.drop-menu').click(function(event){
        event.stopPropagation();
      });
    </script>
    <li><div class="translate-inmenu"><!-- GTranslate: https://gtranslate.io/ -->

      <div class="switcher notranslate">
        <div class="selected">
          <a href="#" onclick="return false;"><img src="<?php echo SITE_URL; ?>/images/flags/16/en.png" height="16" width="16" alt="en" /> English</a>
        </div>
        <div class="option">

          <a href="#" onclick="doGTranslate('en|af');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Afrikaans" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/af.png" height="16" width="16" alt="af" /> Afrikaans</a><a href="#" onclick="doGTranslate('en|sq');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Albanian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/sq.png" height="16" width="16" alt="sq" /> Albanian</a><a href="#" onclick="doGTranslate('en|am');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Amharic" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/am.png" height="16" width="16" alt="am" /> Amharic</a><a href="#" onclick="doGTranslate('en|ar');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Arabic" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ar.png" height="16" width="16" alt="ar" /> Arabic</a><a href="#" onclick="doGTranslate('en|hy');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Armenian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/hy.png" height="16" width="16" alt="hy" /> Armenian</a><a href="#" onclick="doGTranslate('en|az');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Azerbaijani" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/az.png" height="16" width="16" alt="az" /> Azerbaijani</a><a href="#" onclick="doGTranslate('en|eu');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Basque" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/eu.png" height="16" width="16" alt="eu" /> Basque</a><a href="#" onclick="doGTranslate('en|be');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Belarusian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/be.png" height="16" width="16" alt="be" /> Belarusian</a><a href="#" onclick="doGTranslate('en|bn');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Bengali" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/bn.png" height="16" width="16" alt="bn" /> Bengali</a><a href="#" onclick="doGTranslate('en|bs');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Bosnian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/bs.png" height="16" width="16" alt="bs" /> Bosnian</a><a href="#" onclick="doGTranslate('en|bg');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Bulgarian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/bg.png" height="16" width="16" alt="bg" /> Bulgarian</a><a href="#" onclick="doGTranslate('en|ca');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Catalan" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ca.png" height="16" width="16" alt="ca" /> Catalan</a><a href="#" onclick="doGTranslate('en|ceb');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Cebuano" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ceb.png" height="16" width="16" alt="ceb" /> Cebuano</a><a href="#" onclick="doGTranslate('en|ny');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Chichewa" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ny.png" height="16" width="16" alt="ny" /> Chichewa</a><a href="#" onclick="doGTranslate('en|zh-CN');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Chinese (Simplified)" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/zh-CN.png" height="16" width="16" alt="zh-CN" /> Chinese (Simplified)</a><a href="#" onclick="doGTranslate('en|zh-TW');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Chinese (Traditional)" class="nturl"><img src="<?php echo 
            SITE_URL; ?>/images/flags/16/zh-TW.png" height="16" width="16" alt="zh-TW" /> Chinese (Traditional)</a><a href="#" onclick="doGTranslate('en|co');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Corsican" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/co.png" height="16" width="16" alt="co" /> Corsican</a><a href="#" onclick="doGTranslate('en|hr');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Croatian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/hr.png" height="16" width="16" alt="hr" /> Croatian</a><a href="#" onclick="doGTranslate('en|cs');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Czech" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/cs.png" height="16" width="16" alt="cs" /> Czech</a><a href="#" onclick="doGTranslate('en|da');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Danish" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/da.png" height="16" width="16" alt="da" /> Danish</a><a href="#" onclick="doGTranslate('en|nl');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Dutch" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/nl.png" height="16" width="16" alt="nl" /> Dutch</a><a href="#" onclick="doGTranslate('en|en');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="English" class="nturl selected"><img src="<?php echo SITE_URL; ?>/images/flags/16/en-us.png" height="16" width="16" alt="en" /> English</a><a href="#" onclick="doGTranslate('en|eo');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Esperanto" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/eo.png" height="16" width="16" alt="eo" /> Esperanto</a><a href="#" onclick="doGTranslate('en|et');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Estonian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/et.png" height="16" width="16" alt="et" /> Estonian</a><a href="#" onclick="doGTranslate('en|tl');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Filipino" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/tl.png" height="16" width="16" alt="tl" /> Filipino</a><a href="#" onclick="doGTranslate('en|fi');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Finnish" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/fi.png" height="16" width="16" alt="fi" /> Finnish</a><a href="#" onclick="doGTranslate('en|fr');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="French" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/fr-qc.png" height="16" width="16" alt="fr" /> French</a><a href="#" onclick="doGTranslate('en|fy');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Frisian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/fy.png" height="16" width="16" alt="fy" /> Frisian</a><a href="#" onclick="doGTranslate('en|gl');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Galician" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/gl.png" height="16" width="16" alt="gl" /> Galician</a><a href="#" onclick="doGTranslate('en|ka');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Georgian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ka.png" height="16" width="16" alt="ka" /> Georgian</a><a href="#" onclick="doGTranslate('en|de');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="German" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/de.png" height="16" width="16" alt="de" /> German</a><a href="#" onclick="doGTranslate('en|el');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Greek" 
            class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/el.png" height="16" width="16" alt="el" /> Greek</a><a href="#" onclick="doGTranslate('en|gu');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Gujarati" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/gu.png" height="16" width="16" alt="gu" /> Gujarati</a><a href="#" onclick="doGTranslate('en|ht');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Haitian Creole" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ht.png" height="16" width="16" alt="ht" /> Haitian Creole</a><a href="#" onclick="doGTranslate('en|ha');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Hausa" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ha.png" height="16" width="16" alt="ha" /> Hausa</a><a href="#" onclick="doGTranslate('en|haw');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Hawaiian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/haw.png" height="16" width="16" alt="haw" /> Hawaiian</a><a href="#" onclick="doGTranslate('en|iw');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Hebrew" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/iw.png" height="16" width="16" alt="iw" /> Hebrew</a><a href="#" onclick="doGTranslate('en|hi');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Hindi" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/hi.png" height="16" width="16" alt="hi" /> Hindi</a><a href="#" onclick="doGTranslate('en|hmn');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Hmong" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/hmn.png" height="16" width="16" alt="hmn" /> Hmong</a><a href="#" onclick="doGTranslate('en|hu');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Hungarian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/hu.png" height="16" width="16" alt="hu" /> Hungarian</a><a href="#" onclick="doGTranslate('en|is');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Icelandic" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/is.png" height="16" width="16" alt="is" /> Icelandic</a><a href="#" onclick="doGTranslate('en|ig');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Igbo" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ig.png" height="16" width="16" alt="ig" /> Igbo</a><a href="#" onclick="doGTranslate('en|id');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Indonesian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/id.png" height="16" width="16" alt="id" /> Indonesian</a><a href="#" onclick="doGTranslate('en|ga');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Irish" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ga.png" height="16" width="16" alt="ga" /> Irish</a><a href="#" onclick="doGTranslate('en|it');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Italian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/it.png" height="16" width="16" alt="it" /> Italian</a><a href="#" onclick="doGTranslate('en|ja');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Japanese" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ja.png" height="16" width="16" alt="ja" /> Japanese</a><a href="#" onclick="doGTranslate('en|jw');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Javanese" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/jw.png" height="16" width="16" alt="jw" /> Javanese</a><a href="#" onclick="doGTranslate('en|kn');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" 
            title="Kannada" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/kn.png" height="16" width="16" alt="kn" /> Kannada</a><a href="#" onclick="doGTranslate('en|kk');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Kazakh" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/kk.png" height="16" width="16" alt="kk" /> Kazakh</a><a href="#" onclick="doGTranslate('en|km');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Khmer" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/km.png" height="16" width="16" alt="km" /> Khmer</a><a href="#" onclick="doGTranslate('en|ko');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Korean" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ko.png" height="16" width="16" alt="ko" /> Korean</a><a href="#" onclick="doGTranslate('en|ku');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Kurdish (Kurmanji)" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ku.png" height="16" width="16" alt="ku" /> Kurdish (Kurmanji)</a><a href="#" onclick="doGTranslate('en|ky');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Kyrgyz" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ky.png" height="16" width="16" alt="ky" /> Kyrgyz</a><a href="#" onclick="doGTranslate('en|lo');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Lao" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/lo.png" height="16" width="16" alt="lo" /> Lao</a><a href="#" onclick="doGTranslate('en|la');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Latin" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/la.png" height="16" width="16" alt="la" /> Latin</a><a href="#" onclick="doGTranslate('en|lv');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Latvian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/lv.png" height="16" width="16" alt="lv" /> Latvian</a><a href="#" onclick="doGTranslate('en|lt');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Lithuanian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/lt.png" height="16" width="16" alt="lt" /> Lithuanian</a><a href="#" onclick="doGTranslate('en|lb');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Luxembourgish" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/lb.png" height="16" width="16" alt="lb" /> Luxembourgish</a><a href="#" onclick="doGTranslate('en|mk');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Macedonian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/mk.png" height="16" width="16" alt="mk" /> Macedonian</a><a href="#" onclick="doGTranslate('en|mg');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Malagasy" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/mg.png" height="16" width="16" alt="mg" /> Malagasy</a><a href="#" onclick="doGTranslate('en|ms');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Malay" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ms.png" height="16" width="16" alt="ms" /> Malay</a><a href="#" onclick="doGTranslate('en|ml');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Malayalam" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ml.png" height="16" width="16" alt="ml" /> Malayalam</a><a href="#" onclick="doGTranslate('en|mt');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Maltese" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/mt.png" height="16" width="16" alt="mt" /> Maltese</a><a href="#" onclick="doGTranslate('en|mi');jQuery('div.switcher div.selected a').html(jQuery(
              this).html());return false;" title="Maori" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/mi.png" height="16" width="16" alt="mi" /> Maori</a><a href="#" onclick="doGTranslate('en|mr');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Marathi" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/mr.png" height="16" width="16" alt="mr" /> Marathi</a><a href="#" onclick="doGTranslate('en|mn');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Mongolian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/mn.png" height="16" width="16" alt="mn" /> Mongolian</a><a href="#" onclick="doGTranslate('en|my');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Myanmar (Burmese)" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/my.png" height="16" width="16" alt="my" /> Myanmar (Burmese)</a><a href="#" onclick="doGTranslate('en|ne');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Nepali" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ne.png" height="16" width="16" alt="ne" /> Nepali</a><a href="#" onclick="doGTranslate('en|no');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Norwegian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/no.png" height="16" width="16" alt="no" /> Norwegian</a><a href="#" onclick="doGTranslate('en|ps');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Pashto" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ps.png" height="16" width="16" alt="ps" /> Pashto</a><a href="#" onclick="doGTranslate('en|fa');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Persian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/fa.png" height="16" width="16" alt="fa" /> Persian</a><a href="#" onclick="doGTranslate('en|pl');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Polish" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/pl.png" height="16" width="16" alt="pl" /> Polish</a><a href="#" onclick="doGTranslate('en|pt');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Portuguese" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/pt-br.png" height="16" width="16" alt="pt" /> Portuguese</a><a href="#" onclick="doGTranslate('en|pa');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Punjabi" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/pa.png" height="16" width="16" alt="pa" /> Punjabi</a><a href="#" onclick="doGTranslate('en|ro');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Romanian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ro.png" height="16" width="16" alt="ro" /> Romanian</a><a href="#" onclick="doGTranslate('en|ru');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Russian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ru.png" height="16" width="16" alt="ru" /> Russian</a><a href="#" onclick="doGTranslate('en|sm');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Samoan" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/sm.png" height="16" width="16" alt="sm" /> Samoan</a><a href="#" onclick="doGTranslate('en|gd');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Scottish Gaelic" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/gd.png" height="16" width="16" alt="gd" /> Scottish Gaelic</a><a href="#" onclick="doGTranslate('en|sr');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Serbian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/sr.png" height="16" width="16" alt="sr" /> Serbian</a><a href="#" onclick="doGTranslate('en|st');jQuery(
            'div.switcher div.selected a').html(jQuery(this).html());return false;" title="Sesotho" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/st.png" height="16" width="16" alt="st" /> Sesotho</a><a href="#" onclick="doGTranslate('en|sn');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Shona" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/sn.png" height="16" width="16" alt="sn" /> Shona</a><a href="#" onclick="doGTranslate('en|sd');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Sindhi" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/sd.png" height="16" width="16" alt="sd" /> Sindhi</a><a href="#" onclick="doGTranslate('en|si');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Sinhala" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/si.png" height="16" width="16" alt="si" /> Sinhala</a><a href="#" onclick="doGTranslate('en|sk');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Slovak" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/sk.png" height="16" width="16" alt="sk" /> Slovak</a><a href="#" onclick="doGTranslate('en|sl');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Slovenian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/sl.png" height="16" width="16" alt="sl" /> Slovenian</a><a href="#" onclick="doGTranslate('en|so');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Somali" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/so.png" height="16" width="16" alt="so" /> Somali</a><a href="#" onclick="doGTranslate('en|es');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Spanish" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/es-mx.png" height="16" width="16" alt="es" /> Spanish</a><a href="#" onclick="doGTranslate('en|su');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Sudanese" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/su.png" height="16" width="16" alt="su" /> Sudanese</a><a href="#" onclick="doGTranslate('en|sw');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Swahili" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/sw.png" height="16" width="16" alt="sw" /> Swahili</a><a href="#" onclick="doGTranslate('en|sv');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Swedish" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/sv.png" height="16" width="16" alt="sv" /> Swedish</a><a href="#" onclick="doGTranslate('en|tg');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Tajik" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/tg.png" height="16" width="16" alt="tg" /> Tajik</a><a href="#" onclick="doGTranslate('en|ta');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Tamil" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ta.png" height="16" width="16" alt="ta" /> Tamil</a><a href="#" onclick="doGTranslate('en|te');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Telugu" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/te.png" height="16" width="16" alt="te" /> Telugu</a><a href="#" onclick="doGTranslate('en|th');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Thai" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/th.png" height="16" width="16" alt="th" /> Thai</a><a href="#" onclick="doGTranslate('en|tr');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Turkish" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/tr.png" height="16" width="16" alt="tr" /> Turkish</a><a href="#" onclick="doGTranslate('en|uk');jQuery('div.switcher 
            div.selected a').html(jQuery(this).html());return false;" title="Ukrainian" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/uk.png" height="16" width="16" alt="uk" /> Ukrainian</a><a href="#" onclick="doGTranslate('en|ur');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Urdu" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/ur.png" height="16" width="16" alt="ur" /> Urdu</a><a href="#" onclick="doGTranslate('en|uz');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Uzbek" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/uz.png" height="16" width="16" alt="uz" /> Uzbek</a><a href="#" onclick="doGTranslate('en|vi');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Vietnamese" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/vi.png" height="16" width="16" alt="vi" /> Vietnamese</a><a href="#" onclick="doGTranslate('en|cy');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Welsh" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/cy.png" height="16" width="16" alt="cy" /> Welsh</a><a href="#" onclick="doGTranslate('en|xh');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Xhosa" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/xh.png" height="16" width="16" alt="xh" /> Xhosa</a><a href="#" onclick="doGTranslate('en|yi');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Yiddish" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/yi.png" height="16" width="16" alt="yi" /> Yiddish</a><a href="#" onclick="doGTranslate('en|yo');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Yoruba" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/yo.png" height="16" width="16" alt="yo" /> Yoruba</a><a href="#" onclick="doGTranslate('en|zu');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Zulu" class="nturl"><img src="<?php echo SITE_URL; ?>/images/flags/16/zu.png" height="16" width="16" alt="zu" /> Zulu</a>
          </div>
          <script type="text/javascript">
            jQuery('.switcher .selected').click(function() {jQuery('.switcher .option a img').each(function() {if(!jQuery(this)[0].hasAttribute('src'))jQuery(this).attr('src', jQuery(this).attr('data-gt-lazy-src'))});if(!(jQuery('.switcher .option').is(':visible'))) {jQuery('.switcher .option').stop(true,true).delay(100).slideDown(500);jQuery('.switcher .selected a').toggleClass('open')}});
            jQuery('.switcher .option').bind('mousewheel', function(e) {var options = jQuery('.switcher .option');if(options.is(':visible'))options.scrollTop(options.scrollTop() - e.originalEvent.wheelDelta);return false;});
            jQuery('body').not('.switcher').click(function(e) {if(jQuery('.switcher .option').is(':visible') && e.target != jQuery('.switcher .option').get(0)) {jQuery('.switcher .option').stop(true,true).delay(100).slideUp(500);jQuery('.switcher .selected a').toggleClass('open')}});
          </script>


          <div id="google_translate_element2"></div>
          <?php if (ENVIOREMENT=='devlopment'){ ?>

          <?php }else{ ?>
          <script type="text/javascript">
            function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: 'en',autoDisplay: false}, 'google_translate_element2');}
          </script>
          <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>

          <?php } ?>

          <script type="text/javascript">
            function GTranslateGetCurrentLang() {var keyValue = document['cookie'].match('(^|;) ?googtrans=([^;]*)(;|$)');return keyValue ? keyValue[2].split('/')[2] : null;}
            function GTranslateFireEvent(element,event){try{if(document.createEventObject){var evt=document.createEventObject();element.fireEvent('on'+event,evt)}else{var evt=document.createEvent('HTMLEvents');evt.initEvent(event,true,true);element.dispatchEvent(evt)}}catch(e){}}
            function doGTranslate(lang_pair){if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];if(GTranslateGetCurrentLang() == null && lang == lang_pair.split('|')[0])return;var teCombo;var sel=document.getElementsByTagName('select');for(var i=0;i<sel.length;i++)if(/goog-te-combo/.test(sel[i].className)){teCombo=sel[i];break;}if(document.getElementById('google_translate_element2')==null||document.getElementById('google_translate_element2').innerHTML.length==0||teCombo.length==0||teCombo.innerHTML.length==0){setTimeout(function(){doGTranslate(lang_pair)},500)}else{teCombo.value=lang;GTranslateFireEvent(teCombo,'change');GTranslateFireEvent(teCombo,'change')}}
            if(GTranslateGetCurrentLang() != null)jQuery(document).ready(function() {var lang_html = jQuery('div.switcher div.option').find('img[alt="'+GTranslateGetCurrentLang()+'"]').parent().html();if(typeof lang_html != 'undefined')jQuery('div.switcher div.selected a').html(lang_html.replace('data-gt-lazy-', ''));});
          </script>
          <script>jQuery(document).ready(function() {var allowed_languages = ["ar","zh-CN","nl","en","fr","de","it","pt","ru","es"];var accept_language = navigator.language.toLowerCase() || navigator.userLanguage.toLowerCase();switch(accept_language) {case 'zh-cn': var preferred_language = 'zh-CN'; break;case 'zh': var preferred_language = 'zh-CN'; break;case 'zh-tw': var preferred_language = 'zh-TW'; break;case 'zh-hk': var preferred_language = 'zh-TW'; break;default: var preferred_language = accept_language.substr(0, 2); break;}if(preferred_language != 'en' && GTranslateGetCurrentLang() == null && document.cookie.match('gt_auto_switch') == null && allowed_languages.indexOf(preferred_language) >= 0){doGTranslate('en|'+preferred_language);document.cookie = 'gt_auto_switch=1; expires=Thu, 05 Dec 2030 08:08:08 UTC; path=/;';var lang_html = jQuery('div.switcher div.option').find('img[alt="'+preferred_language+'"]').parent().html();if(typeof lang_html != 'undefined')jQuery('div.switcher div.selected a').html(lang_html.replace('data-gt-lazy-', ''));}});</script></div></li>


        </ul>
      </div>
    </div>
  </div>
</header>
