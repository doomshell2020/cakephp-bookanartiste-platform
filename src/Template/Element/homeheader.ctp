<!DOCTYPE HTML>
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
  <script src="<?php echo SITE_URL; ?>/js/bootstrap.min.js"></script>
  <link href="<?php echo SITE_URL; ?>/css/bootstrap.min.css" rel="stylesheet">
  <script src="<?php echo SITE_URL; ?>/js/bootstrap-datetimepicker.js"></script>

  <link href="<?php echo SITE_URL; ?>/css/owl.carousel.css" rel="stylesheet" type="text/css">
  <script src="<?php echo SITE_URL; ?>/js/owl.carousel.js"></script>
  <link href="<?php echo SITE_URL; ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo SITE_URL; ?>/css/style.css" rel="stylesheet" type="text/css">

  <link href="<?php echo SITE_URL; ?>/css/style_new.css" rel="stylesheet" type="text/css">
  <!-- <link href="<?php echo SITE_URL; ?>/css/design.css" rel="stylesheet" type="text/css"> -->
  <link href="<?php echo SITE_URL; ?>/css/responsive.css" rel="stylesheet" type="text/css">
  <link href="<?php echo SITE_URL; ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
  <!-- loader  -->
  <script src="https://cdn.jsdelivr.net/gh/AmagiTech/JSLoader/amagiloader.js"></script>
  
  <!-- <link href="<?php //echo SITE_URL; 
                    ?>/css/bootstrap_new.min.css" rel="stylesheet"> -->
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  <!--owl-carousel -->
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js"></script> -->

  <script src="<?php echo SITE_URL; ?>/css/bootstrap-dialog.min.css"></script>
  <script src="<?php echo SITE_URL; ?>/js/bootstrap-dialog.min.js"></script>

  <style type="text/css">
    .translate-inmenu .switcher .selected a {
      border: 1px solid #CCCCCC;
      background: url(.../../images/flags/arrow_down.png) 146px center no-repeat;
      color: #ffffff;
      padding: 9px 5px;
      width: 151px;
      margin-top: 10px;
    }

    .switcher .selected a.open {
      background-image: url(.../../images/flags/arrow_up.png)
    }

    .switcher .selected a:hover {
      background: transparent url(.../../images/flags/arrow_down.png) 146px center no-repeat;
    }

    .switcher .option {
      position: absolute;
      z-index: 9998;
      border-left: 1px solid #CCCCCC;
      border-right: 1px solid #CCCCCC;
      border-bottom: 1px solid #CCCCCC;
      background-color: #EEEEEE;
      display: none;
      width: 161px;
      max-height: 198px;
      -webkit-box-sizing: content-box;
      -moz-box-sizing: content-box;
      box-sizing: content-box;
      overflow-y: auto;
      overflow-x: hidden;
    }

    .switcher .option a {
      color: #000;
      padding: 3px 5px;
    }

    .switcher .option a:hover {
      background: #FFC;
    }

    .switcher .option a.selected {
      background: #FFC;
    }

    #selected_lang_name {
      float: none;
    }
  </style>

  <script>
    // setInterval(function() {
    //     $.ajax({
    //       type: "post",
    //       url: '<?php //echo SITE_URL; 
                    ?>/app/logincheck',
    //       success: function(data) {
    //         // alert('test');
    //       }
    //     });
    //   },
    //   3000 //60000
    // );
  </script>

  <script>
    navigator.geolocation.getCurrentPosition(
      function(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        document.cookie = 'latitude=' + latitude;
        document.cookie = 'longitude=' + longitude;

        sessionStorage.setItem('latitude', latitude);
        sessionStorage.setItem('longitude', longitude);
        console.log("Location updated successfully!", latitude, longitude, "Accuracy:", position.coords.accuracy);

        // $.ajax({
        //   type: "post",
        //   data: {
        //     latitude: latitude,
        //     longitude: longitude
        //   },
        //   url: '<?php //echo SITE_URL;
                    ?>search/user_location',
        //   success: function(data) {
        //     console.log(data);
        //   }
        // });


      },
      function(error) {
        console.error("Error fetching location:", error.message);
      }, {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
      }
    );


    // function() {
    //   var latitude = 0;
    //   var longitude = 0;
    //   $.ajax({
    //     type: "post",
    //     data: {
    //       latitude: latitude,
    //       longitude: longitude
    //     },
    //     url: '<?php //echo SITE_URL; 
                  ?>/search/user_location',
    //     success: function(data) {
    //       // alert('test');
    //     }
    //   });
    // });
  </script>

  <?php
  // Retrieve latitude and longitude from cookies
  $latitude = $_COOKIE['latitude'] ?? null;
  $longitude = $_COOKIE['longitude'] ?? null;
  $req_data['latitude'] = $latitude;
  $req_data['longitude'] = $longitude;
  $session = $this->request->session();
  $session->delete('user_location');
  $session->write("user_location", $req_data);
  // pr($_SESSION);exit;
  ?>


  <?php $sitedata = $this->Comman->sitesettings();
  $sitedata['ga_code'];
  ?>

</head>

<body class="home-page">
  <div id="page-wrapper">

    <header class="header-1">
      <div class="container">
        <div>
          <div class="pull-left text-left"><a href="<?php echo SITE_URL; ?>"><img src="<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png" alt="logo"></a></div>
          <div class="pull-right">
            <ul class="text-right">
              <?php

              // Get the active package details by Rupam 17 Jan 2025
              $user_id = $this->request->session()->read('Auth.User.id');
              $roleType = $this->request->session()->read('Auth.User.role_id');
              ?>
              <?php if (!empty($roleType) && !empty($user_id)) {
                $activePackage = $this->Comman->activePackage('RC');
                $totalUsedLimit = $this->Comman->getActivePostJob() ?? 0;
                // $totalUsedLimit = $this->Comman->getTodayPostJob($activePackage['id']) ?? 0;
                $totalPostSimultaneously = $activePackage['number_of_job_simultancney'] ?? 0;
                $isActive = false;
                if ($roleType == TALANT_ROLEID && $totalUsedLimit >= $totalPostSimultaneously) {
                  $isActive = true;
                }

              ?>

                <li class="dropdown">

                  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Welcome <?php echo $this->request->session()->read('Auth.User.user_name'); ?>
                    <span class="caret"></span>
                  </button>

                  <ul class=" login-els dropdown-menu">
                    <li><a href="<?php echo SITE_URL ?>/viewprofile">View Profile</a></li>
                    <li><a href="<?php echo SITE_URL ?>/profile">Edit Profile</a></li>
                    <?php
                    if ($isActive) { ?>
                      <li>
                        <a href="javascript:void(0)"
                          onclick="showError('Please convert any of your active job to Inactive to Post Requirement');"
                          class="">
                          Post Requirement</a>
                      </li>
                      <!-- <li><a href="javascript:void(0)" data-toggle="modal" data-target="#simultaneously">Post Requirement</a></li> -->
                    <?php } else { ?>
                      <li><a href="<?php echo SITE_URL ?>/package/jobposting">Post Requirement</a></li>
                    <?php } ?>
                  </ul>

                </li>

                <li><a href="<?php echo SITE_URL; ?>/users/logout" class="btn btn-default">Logout</a> </li>

              <?php } else { ?>
                <li>
                  <a href="<?php echo SITE_URL; ?>/signup" class="btn btn-primary"><i class="fa fa-user-plus" aria-hidden="true"></i>Join for free</a>
                </li>

                <li>
                  <a href="<?php echo SITE_URL; ?>/login" class="btn btn-default"><i class="fa fa-sign-in" aria-hidden="true"></i>Login</a>
                </li>

              <?php } ?>

              <li>
                <div class="translate-inmenu"><!-- GTranslate: https://gtranslate.io/ -->
                  <div class="switcher notranslate">
                    <div class="selected">
                      <a href="#" onclick="return false;"><img src="<?php echo SITE_URL; ?>/images/flags/16/en.png" height="16" width="16" alt="en" /> English</a>
                    </div>

                    <div class="option">
                      <a href="#" onclick="doGTranslate('en|af');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Afrikaans" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/af.png" height="16" width="16" alt="af" /> Afrikaans
                      </a>
                      <a href="#" onclick="doGTranslate('en|sq');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Albanian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/sq.png" height="16" width="16" alt="sq" /> Albanian
                      </a>
                      <a href="#" onclick="doGTranslate('en|am');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Amharic" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/am.png" height="16" width="16" alt="am" /> Amharic
                      </a>
                      <a href="#" onclick="doGTranslate('en|ar');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Arabic" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ar.png" height="16" width="16" alt="ar" /> Arabic
                      </a>
                      <a href="#" onclick="doGTranslate('en|hy');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Armenian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/hy.png" height="16" width="16" alt="hy" /> Armenian
                      </a>
                      <a href="#" onclick="doGTranslate('en|az');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Azerbaijani" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/az.png" height="16" width="16" alt="az" /> Azerbaijani
                      </a>
                      <a href="#" onclick="doGTranslate('en|eu');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Basque" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/eu.png" height="16" width="16" alt="eu" /> Basque
                      </a>
                      <a href="#" onclick="doGTranslate('en|be');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Belarusian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/be.png" height="16" width="16" alt="be" /> Belarusian
                      </a>
                      <a href="#" onclick="doGTranslate('en|bn');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Bengali" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/bn.png" height="16" width="16" alt="bn" /> Bengali
                      </a>
                      <a href="#" onclick="doGTranslate('en|bs');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Bosnian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/bs.png" height="16" width="16" alt="bs" /> Bosnian
                      </a>
                      <a href="#" onclick="doGTranslate('en|bg');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Bulgarian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/bg.png" height="16" width="16" alt="bg" /> Bulgarian
                      </a>
                      <a href="#" onclick="doGTranslate('en|ca');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Catalan" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ca.png" height="16" width="16" alt="ca" /> Catalan
                      </a>
                      <a href="#" onclick="doGTranslate('en|ceb');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Cebuano" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ceb.png" height="16" width="16" alt="ceb" /> Cebuano
                      </a>
                      <a href="#" onclick="doGTranslate('en|ny');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Chichewa" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ny.png" height="16" width="16" alt="ny" /> Chichewa
                      </a>
                      <a href="#" onclick="doGTranslate('en|zh-CN');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Chinese (Simplified)" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/zh-CN.png" height="16" width="16" alt="zh-CN" /> Chinese (Simplified)
                      </a>
                      <a href="#" onclick="doGTranslate('en|zh-TW');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Chinese (Traditional)" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/zh-TW.png" height="16" width="16" alt="zh-TW" /> Chinese (Traditional)
                      </a>
                      <a href="#" onclick="doGTranslate('en|co');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Corsican" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/co.png" height="16" width="16" alt="co" /> Corsican
                      </a>
                      <a href="#" onclick="doGTranslate('en|hr');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Croatian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/hr.png" height="16" width="16" alt="hr" /> Croatian
                      </a>
                      <a href="#" onclick="doGTranslate('en|cs');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Czech" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/cs.png" height="16" width="16" alt="cs" /> Czech
                      </a>
                      <a href="#" onclick="doGTranslate('en|da');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Danish" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/da.png" height="16" width="16" alt="da" /> Danish
                      </a>
                      <a href="#" onclick="doGTranslate('en|nl');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Dutch" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/nl.png" height="16" width="16" alt="nl" /> Dutch
                      </a>
                      <a href="#" onclick="doGTranslate('en|en');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="English" class="nturl selected">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/en-us.png" height="16" width="16" alt="en" /> English
                      </a>
                      <a href="#" onclick="doGTranslate('en|eo');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Esperanto" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/eo.png" height="16" width="16" alt="eo" /> Esperanto
                      </a>
                      <a href="#" onclick="doGTranslate('en|et');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Estonian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/et.png" height="16" width="16" alt="et" /> Estonian
                      </a>
                      <a href="#" onclick="doGTranslate('en|tl');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Filipino" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/tl.png" height="16" width="16" alt="tl" /> Filipino
                      </a>
                      <a href="#" onclick="doGTranslate('en|fi');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Finnish" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/fi.png" height="16" width="16" alt="fi" /> Finnish
                      </a>
                      <a href="#" onclick="doGTranslate('en|fr');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="French" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/fr-qc.png" height="16" width="16" alt="fr" /> French
                      </a>
                      <a href="#" onclick="doGTranslate('en|fy');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Frisian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/fy.png" height="16" width="16" alt="fy" /> Frisian
                      </a>
                      <a href="#" onclick="doGTranslate('en|gl');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Galician" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/gl.png" height="16" width="16" alt="gl" /> Galician
                      </a>
                      <a href="#" onclick="doGTranslate('en|ka');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Georgian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ka.png" height="16" width="16" alt="ka" /> Georgian
                      </a>
                      <a href="#" onclick="doGTranslate('en|de');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="German" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/de.png" height="16" width="16" alt="de" /> German
                      </a>
                      <a href="#" onclick="doGTranslate('en|el');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Greek" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/el.png" height="16" width="16" alt="el" /> Greek
                      </a>
                      <a href="#" onclick="doGTranslate('en|gu');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Gujarati" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/gu.png" height="16" width="16" alt="gu" /> Gujarati
                      </a>
                      <a href="#" onclick="doGTranslate('en|ht');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Haitian Creole" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ht.png" height="16" width="16" alt="ht" /> Haitian Creole
                      </a>
                      <a href="#" onclick="doGTranslate('en|ha');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Hausa" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ha.png" height="16" width="16" alt="ha" /> Hausa
                      </a>
                      <a href="#" onclick="doGTranslate('en|haw');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Hawaiian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/haw.png" height="16" width="16" alt="haw" /> Hawaiian
                      </a>
                      <a href="#" onclick="doGTranslate('en|iw');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Hebrew" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/iw.png" height="16" width="16" alt="iw" /> Hebrew
                      </a>
                      <a href="#" onclick="doGTranslate('en|hi');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Hindi" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/hi.png" height="16" width="16" alt="hi" /> Hindi
                      </a>
                      <a href="#" onclick="doGTranslate('en|hmn');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Hmong" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/hmn.png" height="16" width="16" alt="hmn" /> Hmong
                      </a>
                      <a href="#" onclick="doGTranslate('en|hu');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Hungarian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/hu.png" height="16" width="16" alt="hu" /> Hungarian
                      </a>
                      <a href="#" onclick="doGTranslate('en|is');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Icelandic" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/is.png" height="16" width="16" alt="is" /> Icelandic
                      </a>
                      <a href="#" onclick="doGTranslate('en|ig');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Igbo" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ig.png" height="16" width="16" alt="ig" /> Igbo
                      </a>
                      <a href="#" onclick="doGTranslate('en|id');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Indonesian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/id.png" height="16" width="16" alt="id" /> Indonesian
                      </a>
                      <a href="#" onclick="doGTranslate('en|ga');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Irish" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ga.png" height="16" width="16" alt="ga" /> Irish
                      </a>
                      <a href="#" onclick="doGTranslate('en|it');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Italian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/it.png" height="16" width="16" alt="it" /> Italian
                      </a>
                      <a href="#" onclick="doGTranslate('en|ja');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Japanese" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ja.png" height="16" width="16" alt="ja" /> Japanese
                      </a>
                      <a href="#" onclick="doGTranslate('en|jw');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Javanese" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/jw.png" height="16" width="16" alt="jw" /> Javanese
                      </a>
                      <a href="#" onclick="doGTranslate('en|kn');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Kannada" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/kn.png" height="16" width="16" alt="kn" /> Kannada
                      </a>
                      <a href="#" onclick="doGTranslate('en|kk');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Kazakh" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/kk.png" height="16" width="16" alt="kk" /> Kazakh
                      </a>
                      <a href="#" onclick="doGTranslate('en|km');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Khmer" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/km.png" height="16" width="16" alt="km" /> Khmer
                      </a>
                      <a href="#" onclick="doGTranslate('en|ko');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Korean" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ko.png" height="16" width="16" alt="ko" /> Korean
                      </a>
                      <a href="#" onclick="doGTranslate('en|ku');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Kurdish (Kurmanji)" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ku.png" height="16" width="16" alt="ku" /> Kurdish (Kurmanji)
                      </a>
                      <a href="#" onclick="doGTranslate('en|ky');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Kyrgyz" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ky.png" height="16" width="16" alt="ky" /> Kyrgyz
                      </a>
                      <a href="#" onclick="doGTranslate('en|lo');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Lao" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/lo.png" height="16" width="16" alt="lo" /> Lao
                      </a>
                      <a href="#" onclick="doGTranslate('en|la');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Latin" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/la.png" height="16" width="16" alt="la" /> Latin
                      </a>
                      <a href="#" onclick="doGTranslate('en|lv');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Latvian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/lv.png" height="16" width="16" alt="lv" /> Latvian
                      </a>
                      <a href="#" onclick="doGTranslate('en|lt');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Lithuanian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/lt.png" height="16" width="16" alt="lt" /> Lithuanian
                      </a>
                      <a href="#" onclick="doGTranslate('en|lb');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Luxembourgish" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/lb.png" height="16" width="16" alt="lb" /> Luxembourgish
                      </a>
                      <a href="#" onclick="doGTranslate('en|mk');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Macedonian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/mk.png" height="16" width="16" alt="mk" /> Macedonian
                      </a>
                      <a href="#" onclick="doGTranslate('en|mg');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Malagasy" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/mg.png" height="16" width="16" alt="mg" /> Malagasy
                      </a>
                      <a href="#" onclick="doGTranslate('en|ms');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Malay" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ms.png" height="16" width="16" alt="ms" /> Malay
                      </a>
                      <a href="#" onclick="doGTranslate('en|ml');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Malayalam" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ml.png" height="16" width="16" alt="ml" /> Malayalam
                      </a>
                      <a href="#" onclick="doGTranslate('en|mt');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Maltese" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/mt.png" height="16" width="16" alt="mt" /> Maltese
                      </a>
                      <a href="#" onclick="doGTranslate('en|mi');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Maori" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/mi.png" height="16" width="16" alt="mi" /> Maori
                      </a>
                      <a href="#" onclick="doGTranslate('en|mr');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Marathi" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/mr.png" height="16" width="16" alt="mr" /> Marathi
                      </a>
                      <a href="#" onclick="doGTranslate('en|mn');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Mongolian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/mn.png" height="16" width="16" alt="mn" /> Mongolian
                      </a>
                      <a href="#" onclick="doGTranslate('en|my');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Myanmar (Burmese)" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/my.png" height="16" width="16" alt="my" /> Myanmar (Burmese)
                      </a>
                      <a href="#" onclick="doGTranslate('en|ne');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Nepali" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ne.png" height="16" width="16" alt="ne" /> Nepali
                      </a>
                      <a href="#" onclick="doGTranslate('en|no');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Norwegian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/no.png" height="16" width="16" alt="no" /> Norwegian
                      </a>
                      <a href="#" onclick="doGTranslate('en|ps');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Pashto" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ps.png" height="16" width="16" alt="ps" /> Pashto
                      </a>
                      <a href="#" onclick="doGTranslate('en|fa');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Persian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/fa.png" height="16" width="16" alt="fa" /> Persian
                      </a>
                      <a href="#" onclick="doGTranslate('en|pl');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Polish" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/pl.png" height="16" width="16" alt="pl" /> Polish
                      </a>
                      <a href="#" onclick="doGTranslate('en|pt');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Portuguese" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/pt-br.png" height="16" width="16" alt="pt" /> Portuguese
                      </a>
                      <a href="#" onclick="doGTranslate('en|pa');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Punjabi" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/pa.png" height="16" width="16" alt="pa" /> Punjabi
                      </a>
                      <a href="#" onclick="doGTranslate('en|ro');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Romanian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ro.png" height="16" width="16" alt="ro" /> Romanian
                      </a>
                      <a href="#" onclick="doGTranslate('en|ru');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Russian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ru.png" height="16" width="16" alt="ru" /> Russian
                      </a>
                      <a href="#" onclick="doGTranslate('en|sm');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Samoan" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/sm.png" height="16" width="16" alt="sm" /> Samoan
                      </a>
                      <a href="#" onclick="doGTranslate('en|gd');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Scottish Gaelic" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/gd.png" height="16" width="16" alt="gd" /> Scottish Gaelic
                      </a>
                      <a href="#" onclick="doGTranslate('en|sr');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Serbian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/sr.png" height="16" width="16" alt="sr" /> Serbian
                      </a>
                      <a href="#" onclick="doGTranslate('en|st');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Sesotho" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/st.png" height="16" width="16" alt="st" /> Sesotho
                      </a>
                      <a href="#" onclick="doGTranslate('en|sn');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Shona" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/sn.png" height="16" width="16" alt="sn" /> Shona
                      </a>
                      <a href="#" onclick="doGTranslate('en|sd');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Sindhi" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/sd.png" height="16" width="16" alt="sd" /> Sindhi
                      </a>
                      <a href="#" onclick="doGTranslate('en|si');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Sinhala" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/si.png" height="16" width="16" alt="si" /> Sinhala
                      </a>
                      <a href="#" onclick="doGTranslate('en|sk');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Slovak" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/sk.png" height="16" width="16" alt="sk" /> Slovak
                      </a>
                      <a href="#" onclick="doGTranslate('en|sl');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Slovenian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/sl.png" height="16" width="16" alt="sl" /> Slovenian
                      </a>
                      <a href="#" onclick="doGTranslate('en|so');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Somali" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/so.png" height="16" width="16" alt="so" /> Somali
                      </a>
                      <a href="#" onclick="doGTranslate('en|es');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Spanish" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/es-mx.png" height="16" width="16" alt="es" /> Spanish
                      </a>
                      <a href="#" onclick="doGTranslate('en|su');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Sudanese" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/su.png" height="16" width="16" alt="su" /> Sudanese
                      </a>
                      <a href="#" onclick="doGTranslate('en|sw');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Swahili" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/sw.png" height="16" width="16" alt="sw" /> Swahili
                      </a>
                      <a href="#" onclick="doGTranslate('en|sv');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Swedish" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/sv.png" height="16" width="16" alt="sv" /> Swedish
                      </a>
                      <a href="#" onclick="doGTranslate('en|tg');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Tajik" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/tg.png" height="16" width="16" alt="tg" /> Tajik
                      </a>
                      <a href="#" onclick="doGTranslate('en|ta');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Tamil" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ta.png" height="16" width="16" alt="ta" /> Tamil
                      </a>
                      <a href="#" onclick="doGTranslate('en|te');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Telugu" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/te.png" height="16" width="16" alt="te" /> Telugu
                      </a>
                      <a href="#" onclick="doGTranslate('en|th');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Thai" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/th.png" height="16" width="16" alt="th" /> Thai
                      </a>
                      <a href="#" onclick="doGTranslate('en|tr');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Turkish" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/tr.png" height="16" width="16" alt="tr" /> Turkish
                      </a>
                      <a href="#" onclick="doGTranslate('en|uk');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Ukrainian" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/uk.png" height="16" width="16" alt="uk" /> Ukrainian
                      </a>
                      <a href="#" onclick="doGTranslate('en|ur');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Urdu" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/ur.png" height="16" width="16" alt="ur" /> Urdu
                      </a>
                      <a href="#" onclick="doGTranslate('en|uz');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Uzbek" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/uz.png" height="16" width="16" alt="uz" /> Uzbek
                      </a>
                      <a href="#" onclick="doGTranslate('en|vi');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Vietnamese" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/vi.png" height="16" width="16" alt="vi" /> Vietnamese
                      </a>
                      <a href="#" onclick="doGTranslate('en|cy');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Welsh" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/cy.png" height="16" width="16" alt="cy" /> Welsh
                      </a>
                      <a href="#" onclick="doGTranslate('en|xh');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Xhosa" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/xh.png" height="16" width="16" alt="xh" /> Xhosa
                      </a>
                      <a href="#" onclick="doGTranslate('en|yi');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Yiddish" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/yi.png" height="16" width="16" alt="yi" /> Yiddish
                      </a>
                      <a href="#" onclick="doGTranslate('en|yo');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Yoruba" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/yo.png" height="16" width="16" alt="yo" /> Yoruba
                      </a>
                      <a href="#" onclick="doGTranslate('en|zu');jQuery('div.switcher div.selected a').html(jQuery(this).html());return false;" title="Zulu" class="nturl">
                        <img src="<?php echo SITE_URL; ?>/images/flags/16/zu.png" height="16" width="16" alt="zu" /> Zulu
                      </a>
                    </div>


                    <script type="text/javascript">
                      jQuery('.switcher .selected').click(function() {
                        jQuery('.switcher .option a img').each(function() {
                          if (!jQuery(this)[0].hasAttribute('src')) jQuery(this).attr('src', jQuery(this).attr('data-gt-lazy-src'))
                        });
                        if (!(jQuery('.switcher .option').is(':visible'))) {
                          jQuery('.switcher .option').stop(true, true).delay(100).slideDown(500);
                          jQuery('.switcher .selected a').toggleClass('open')
                        }
                      });
                      jQuery('.switcher .option').bind('mousewheel', function(e) {
                        var options = jQuery('.switcher .option');
                        if (options.is(':visible')) options.scrollTop(options.scrollTop() - e.originalEvent.wheelDelta);
                        return false;
                      });
                      jQuery('body').not('.switcher').click(function(e) {
                        if (jQuery('.switcher .option').is(':visible') && e.target != jQuery('.switcher .option').get(0)) {
                          jQuery('.switcher .option').stop(true, true).delay(100).slideUp(500);
                          jQuery('.switcher .selected a').toggleClass('open')
                        }
                      });
                    </script>

                    <div id="google_translate_element2"></div>

                    <?php if (ENVIOREMENT == 'devlopment') { ?>

                    <?php } else { ?>
                      <script type="text/javascript">
                        function googleTranslateElementInit2() {
                          new google.translate.TranslateElement({
                            pageLanguage: 'en',
                            autoDisplay: false
                          }, 'google_translate_element2');
                        }
                      </script>
                      <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>

                    <?php } ?>


                    <script type="text/javascript">
                      function GTranslateGetCurrentLang() {
                        var keyValue = document['cookie'].match('(^|;) ?googtrans=([^;]*)(;|$)');
                        return keyValue ? keyValue[2].split('/')[2] : null;
                      }

                      function GTranslateFireEvent(element, event) {
                        try {
                          if (document.createEventObject) {
                            var evt = document.createEventObject();
                            element.fireEvent('on' + event, evt)
                          } else {
                            var evt = document.createEvent('HTMLEvents');
                            evt.initEvent(event, true, true);
                            element.dispatchEvent(evt)
                          }
                        } catch (e) {}
                      }

                      function doGTranslate(lang_pair) {
                        if (lang_pair.value) lang_pair = lang_pair.value;
                        if (lang_pair == '') return;
                        var lang = lang_pair.split('|')[1];
                        if (GTranslateGetCurrentLang() == null && lang == lang_pair.split('|')[0]) return;
                        var teCombo;
                        var sel = document.getElementsByTagName('select');
                        for (var i = 0; i < sel.length; i++)
                          if (/goog-te-combo/.test(sel[i].className)) {
                            teCombo = sel[i];
                            break;
                          } if (document.getElementById('google_translate_element2') == null || document.getElementById('google_translate_element2').innerHTML.length == 0 || teCombo.length == 0 || teCombo.innerHTML.length == 0) {
                          setTimeout(function() {
                            doGTranslate(lang_pair)
                          }, 500)
                        } else {
                          teCombo.value = lang;
                          GTranslateFireEvent(teCombo, 'change');
                          GTranslateFireEvent(teCombo, 'change')
                        }
                      }
                      if (GTranslateGetCurrentLang() != null) jQuery(document).ready(function() {
                        var lang_html = jQuery('div.switcher div.option').find('img[alt="' + GTranslateGetCurrentLang() + '"]').parent().html();
                        if (typeof lang_html != 'undefined') jQuery('div.switcher div.selected a').html(lang_html.replace('data-gt-lazy-', ''));
                      });
                    </script>

                    <script>
                      jQuery(document).ready(function() {
                        var allowed_languages = ["ar", "zh-CN", "nl", "en", "fr", "de", "it", "pt", "ru", "es"];
                        var accept_language = navigator.language.toLowerCase() || navigator.userLanguage.toLowerCase();
                        switch (accept_language) {
                          case 'zh-cn':
                            var preferred_language = 'zh-CN';
                            break;
                          case 'zh':
                            var preferred_language = 'zh-CN';
                            break;
                          case 'zh-tw':
                            var preferred_language = 'zh-TW';
                            break;
                          case 'zh-hk':
                            var preferred_language = 'zh-TW';
                            break;
                          default:
                            var preferred_language = accept_language.substr(0, 2);
                            break;
                        }
                        if (preferred_language != 'en' && GTranslateGetCurrentLang() == null && document.cookie.match('gt_auto_switch') == null && allowed_languages.indexOf(preferred_language) >= 0) {
                          doGTranslate('en|' + preferred_language);
                          document.cookie = 'gt_auto_switch=1; expires=Thu, 05 Dec 2030 08:08:08 UTC; path=/;';
                          var lang_html = jQuery('div.switcher div.option').find('img[alt="' + preferred_language + '"]').parent().html();
                          if (typeof lang_html != 'undefined') jQuery('div.switcher div.selected a').html(lang_html.replace('data-gt-lazy-', ''));
                        }
                      });
                    </script>

                  </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </header>

    <div class="modal fade" id="simultaneously" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content">
          <div class="modal-body" style="text-align: center;">
            <strong>
              You have reached your simultaneous job posting limit.<br>
              <br>
              <u>Limit Details:</u><br>
              - Total allowed posts: <b><?= $totalPostSimultaneously ?></b><br>
              - Currently used: <b><?= $totalUsedLimit ?></b><br>
              <br>
              To post more, please delete or deactivate an existing job.
            </strong>
          </div>
        </div>
      </div>
    </div>


    <!-- Login and Signup Popup Start -->

    <div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="loginmodal">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title text-center" id="captionmodal">Register for a FREE Book an Artiste Account</h4>
          </div>
          <div class="modal-body">

            <div class="row sgn-lgn-pp">

              <div class="col-md-6">
                <div class="signup-popup">
                  <h2>Sign <span>Up</span></h2>
                  <?php
                  echo $this->Form->create($users, array('url' => array('controller' => 'users', 'action' => 'signup'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>

                  <!--<form class="form-horizontal">  -->
                  <div class="form-group">

                    <div class="col-sm-6">
                      <?php echo $this->Form->input('user_name', array('class' => 'form-control', 'placeholder' => 'Enter Your Name', 'pattern' => '[a-zA-Z ]*', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'text')); ?>
                    </div>
                    <div class="col-sm-6">
                      <?php echo $this->Form->email('email', array('class' => 'form-control', 'placeholder' => 'Enter Your Email', 'required' => true, 'autocomplete' => 'off', 'id' => 'username', 'label' => false)); ?>
                      <span id="dividhere" style="display:none;color:red;">Email Already Exist</span>

                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-6">
                          <?php echo $this->Form->input('phonecountry', array('class' => 'form-control', 'placeholder' => 'Country', 'required' => true, 'label' => false, 'id' => 'country_phone', 'empty' => '--Select Country--', 'options' => $country)); ?>
                        </div>
                        <div class="col-sm-6">
                          <?php //echo $this->Form->input('phonecode',array('class'=>'form-control','placeholder'=>'Phonecode','id'=>'','label' =>false,'empty'=>'--Code--','readonly'=>true)); 
                          ?>
                          <?php echo $this->Form->input('phonecode', array('class' => 'form-control', 'placeholder' => 'Phone Code', 'id' => 'phonecode', 'required' => true, 'label' => false, 'type' => 'text', 'readonly' => true)); ?>
                        </div>

                      </div>
                    </div>
                    <div class="col-sm-4"></div>
                  </div>

                  <div class="form-group">

                    <div class="col-sm-12">
                      <?php echo $this->Form->input('phone', array('class' => 'form-control telnumber', 'maxlength' => '12', 'required' => true, 'placeholder' => 'Enter Your Number', 'label' => false, 'type' => 'tel', 'pattern' => '^\d{10}$')); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-6">
                      <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Password', 'maxlength' => '11', 'type' => 'password', 'autocomplete' => 'off', 'id' => 'p1', 'label' => false, 'required' => true)); ?>
                    </div>

                    <div class="col-sm-6">
                      <input type="password" name="confirmpassword" required="" class="form-control" id="registration" placeholder="Confirm Password" onfocus="validatePass(document.getElementById('p1'), this);" oninput="validatePass(document.getElementById('p1'), this);">
                      <input type="hidden" name="user_activation_key" class="form-control" id="registration" value="<?php echo md5(uniqid(rand(), true)); ?>">
                    </div>
                  </div>
                  <div class="form-group">
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12 ">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" required> I Agree with <a href="<?php echo SITE_URL; ?>/termsandconditions" target="_blank">Terms and Conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-default" onClick="validatePassword();"><?php echo __('Submit'); ?></button>
                    </div>
                  </div>
                  <?php echo $this->Form->end(); ?>
                </div>
              </div>
              <div class="col-md-1">
                <div class="line_center">
                  <div class="or">
                    or </div>
                </div>
              </div>

              <div class="col-md-5">
                <div class="login-popup">
                  <h2>Log <span>in</span></h2>

                  <?php echo $this->Form->create('Users', array('url' => array('controller' => 'Users', 'action' => 'login'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'LoginsIndexForm', 'autocomplete' => 'off')); ?>
                  <?php echo $this->Flash->render(); ?>
                  <div class="form-group">

                    <div class="col-sm-12">
                      <?php echo $this->Form->input('email', array('class' => 'form-control', 'placeholder' => 'Enter Your Email', 'maxlength' => '25', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'email')); ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Password', 'maxlength' => '25', 'id' => 'inputPassword3', 'required' => true, 'label' => false, 'type' => 'password')); ?>
                      <input type="hidden" name="action" id="action" value="profile">
                    </div>
                  </div>
                  <div class="">
                    <div class="">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> Remember me
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="">
                      <div class="checkbox">
                        <label>
                          <a href="<?php echo SITE_URL; ?>/forgotpassword">Forgot Password</a>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-default"><?php echo __('Sign in'); ?></button>
                    </div>
                  </div>
                  <?php echo $this->Form->end();   ?>
                  <div class="pop-up-sosl">
                    <h4>Log in With</h4>
                    <a href="#" class="fblogin"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="googlelogin"><i class="fa fa-google-plus"></i></a>
                    <a href="#" class=""><i class="fa fa-vk"></i></a>
                    <a href="#" class=""><i class="fa fa-twitter"></i></a>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Login and Signup Popup End -->

    <script>
      function showError(error) {
        BootstrapDialog.alert({
          size: BootstrapDialog.SIZE_SMALL,
          title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Alert !",
          message: "<h5>" + error + "</h5>",
          callback: function() {
            window.location.href = "<?php echo SITE_URL; ?>/myrequirement"; // Redirect after clicking "OK"
          }
        });
      }
    </script>

    <script>
      function assignloginaction(action) {
        $('#action').val(action);
      }
    </script>

    <script type="text/javascript">
      $(document).ready(function() {
        $("#country_phone").on('change', function() {
          var id = $(this).val();
          $("#phonecode").find('option').remove();
          if (id) {
            var dataString = 'id=' + id;
            $.ajax({
              type: "POST",
              url: '<?php echo SITE_URL; ?>/users/getphonecode',
              data: dataString,
              cache: false,
              success: function(html) {
                $.each(html, function(key, value) {
                  $('#phonecode').val(value);
                });
              }
            });
          }
        });
      });
    </script>

    <script>
      $(document).ready(function() { //alert();
        $('#username').change(function() { //alert();
          var username = $('#username').val();
          //alert(username);
          $.ajax({
            type: 'POST',
            url: '<?php echo SITE_URL; ?>/users/find_username',
            data: {
              'username': username
            },
            success: function(data) {
              if (data > 0) {
                $('#username').val('');
                $('#dividhere').show();
              } else {
                $('#dividhere').hide();
              }
            },
          });
        });
      });

      function validatePass(p1, p2) {

        if (p1.value != p2.value) {

          p2.setCustomValidity('Password incorrect');

        } else {

          p2.setCustomValidity('');

        }
      }
    </script>

    <script type="text/javascript">
      window.fbAsyncInit = function() {
        FB.init({
          appId: '148076566015718',
          status: true,
          cookie: true,
          xfbml: true
        });
      };



      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
          return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/pl_PL/all.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));

      $('.fblogin').on('click', function() {
        FB.login(function() {
          loginCheck();
        }, {
          scope: 'email,user_photos,publish_actions'
        });
      });



      // Get login status
      function loginCheck() {
        FB.getLoginStatus(function(response) {
          // console.log('loginCheck', response);
          statusCheck(response);
          getUser();
        });
      }

      // Check login status
      function statusCheck(response) {
        // console.log('statusCheck', response.status);
        if (response.status === 'connected') {
          // console.log("connected");
          // $('.login').hide();
          // $('.form').fadeIn();
        } else if (response.status === 'not_authorized') {
          // User logged into facebook, but not to our app.
        } else {
          // User not logged into Facebook.
        }
      }

      // Here we run a very simple test of the Graph API after login is
      // successful.  See statusChangeCallback() for when this call is made.
      function getUser() {
        FB.api('/me/?fields=id,name,email,first_name', function(response) {
          // console.log('getUser', response);
          // console.log('responseid', response.id);
          // console.log('email', response.email);
          $.ajax({
            url: "<?php echo SITE_URL ?>/users/sociallogin",
            type: 'POST',
            data: {
              "fbid": response.id,
              "email": response.email,
              "user_name": response.name,
              "fname": response.first_name
            },
            success: function(result) {

              obj = JSON.parse(result);

              if (obj.redirect_url) {
                // console.log(obj.redirect_url);
                window.location.href = obj.redirect_url;
              }
            }
          });
        });
      }



      // Google login
    </script>


    <script src="https://apis.google.com/js/api:client.js"></script>
    <!-- <!— GOOGLE API KEY, login authentication key —> -->
    <script>
      var googleUser = {};
      var startApp = function() {
        gapi.load('auth2', function() {
          // Retrieve the singleton for the GoogleAuth library and set up the client.
          auth2 = gapi.auth2.init({
            client_id: '781092659219-aa2tl98jol29mc7488q7thv76rr6pd69.apps.googleusercontent.com',
            cookiepolicy: 'single_host_origin',
            // Request scopes in addition to 'profile' and 'email'
            //scope: 'additional_scope'
          });
          $("body").on("click", ".googlelogin", function(e) {
            attachSignin(document.getElementsByClassName("googlelogin")[0]);
          });

        });

      };

      function attachSignin(element) {
        // console.log(element);

        auth2.attachClickHandler(element, {},
          function(googleUser) {
            var profile = googleUser.getBasicProfile();
            // console.log(googleUser.getAuthResponse().id_token);
            var googleurl = "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=" + googleUser.getAuthResponse().id_token
            $.getJSON(googleurl, function(result) {

              $.ajax({
                url: "<?php echo SITE_URL ?>/users/sociallogin",
                type: 'POST',
                data: {
                  "google_id": result.sub,
                  'email': result.email,
                  'name': result.given_name,
                },
                success: function(result2) {
                  if (result2) {
                    obj = JSON.parse(result2);

                    if (obj.redirect_url) {
                      // console.log(obj.redirect_url);
                      window.location.href = obj.redirect_url;
                    }
                  }
                }
              });

            });

          },
          function(error) {
            parsed_error = JSON.stringify(error, undefined, 2);
            parsed_error = JSON.parse(parsed_error);
            if (popup_closed_by_user != 'popup_closed_by_user') {
              alert(popup_closed_by_user);
            }
          });
      }
    </script>

    <script>
      startApp();
    </script>