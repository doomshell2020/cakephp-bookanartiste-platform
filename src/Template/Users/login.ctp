<style>
  svg {
    border-right: 1px solid #ccc;
    padding: 12px 0;
    width: 50px;
    height: 43px;
    vertical-align: -16px;
    text-align: center;
  }

  .bg-face {
    background-color: #fff;
  }

  .signup-social-inner a {

    color: #000;

  }

  .bg-g-plus {
    background-color: #fff;
  }
</style>

<section id="page_login">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <div class="login-popup">
          <h2>Log <span>in</span></h2>

          <?php echo $this->Form->create('Users', array('url' => array('controller' => 'Users', 'action' => 'login'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'LoginsIndexForm', 'autocomplete' => 'off')); ?>

          <?php echo $this->Flash->render(); ?>
          <?php
          if ($this->Flash->render('login_fail_non_talent')) {
          ?>
            <span style="color: red;">You are already logged in another devices. <a href="<?php echo SITE_URL; ?>/users/logoutall">Log out</a> from another device before continuing.</span>

          <?php } else if ($this->Flash->render('login_fail')) {  ?>
            <span style="color: red;">Maximum limit of multiple logins has been reached.If you need to log in, please <a href="<?php echo SITE_URL; ?>/users/logoutall">Log out</a> of all other windows</span>
          <?php } ?>
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-12 control-label">Email Address</label>
            <div class="col-sm-12">
              <?php echo $this->Form->input('email', array('class' => 'form-control', 'value' => $email, 'placeholder' => 'Enter Your Email', 'id' => 'inputEmail3', 'required' => true, 'label' => false, 'type' => 'email')); ?>

            </div>
          </div>
          <div class="form-group">

            <label for="inputPassword3" class="col-sm-12 control-label">Password</label>
            <div class="col-sm-12" style="position:relative">
              <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Password', 'maxlength' => '25', 'id' => 'inputPassword3', 'value' => $password, 'required' => true, 'label' => false, 'type' => 'password')); ?>
              <a href="javascript:void(0)"><i class="fa fa-eye" id="togglePassword" style="position : absolute; right:25px; top:14px; z-index:9;"></i></a>

            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6 ">
              <div class="checkbox">
                <label>
                  <?php
                  echo $this->Form->input('remember_me', array('type' => 'checkbox', 'value' => 1, 'checked' => ($remember_me == 1) ? true : false)); ?>
                </label>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="forgot">
                <a href="<?php echo SITE_URL; ?>/forgotpassword" style="font-size: 14px; color: #c4432e; font-weight: 500;">Forgot your password?</a>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-12">
              <button type="submit" class="btn btn-default" style="border-radius: 5px;"><?php echo __('Log In'); ?></button>
            </div>
          </div>
          <?php echo $this->Form->end();   ?>

        </div>

      </div>


      <div class="col-sm-4">

        <div class="sign-up-with">

          <div class="signup-popup2">
            <div class="">
              <h2 class="m-bott-20">Sign in<span>With</span></h2>


              <div class="signup-social-inner">
                <div class="row">

                  <div class="col-sm-12">
                    <a href="javascript:void(0)" class="bg-face fblogin" onclick="signInWithFacebook()">
                      <!-- <i class="fa fa-facebook"></i> -->
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">

                        <defs>
                        </defs>
                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                          <path d="M 85.033 90 C 87.776 90 90 87.776 90 85.033 V 4.967 C 90 2.223 87.776 0 85.033 0 H 4.967 C 2.223 0 0 2.223 0 4.967 v 80.066 C 0 87.776 2.223 90 4.967 90 H 85.033 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(60,90,153); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                          <path d="M 50.916 83.204 V 48.351 h 11.699 l 1.752 -13.583 h -13.45 v -8.672 c 0 -3.933 1.092 -6.612 6.731 -6.612 l 7.193 -0.003 V 7.332 c -1.244 -0.166 -5.513 -0.535 -10.481 -0.535 c -10.37 0 -17.47 6.33 -17.47 17.954 v 10.017 H 25.16 v 13.583 h 11.729 v 34.853 H 50.916 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        </g>
                      </svg>
                      <span>Sign in With Facebook</span>
                    </a>

                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12">
                    <a href="javascript:void(0)" class="bg-g-plus googlelogin" onclick="signInWithGoogle()">
                      <!-- <i class="fa fa-google"></i> -->
                      <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48">
                        <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path>
                        <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path>
                        <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path>
                        <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                      </svg>
                      <span>Sign in With Gmail</span>
                    </a>
                  </div>
                </div>


                <script type="text/javascript">
                  $(document).ready(function() {
                    $(".bg-vk").on('click', function() {
                      // alert()
                      $('#vk_auth').css("display", 'block');

                    });
                  });
                </script>
                <script type="text/javascript" src="https://vk.com/js/api/openapi.js?158"></script>
                <script type="text/javascript">
                  VK.init({
                    apiId: 6642699
                  });
                </script>

                <div id="vk_auth" style="position: absolute;display: none;width: 200px;height: 116px;background: none;top: -80px;left: -334px"></div>
                <script type="text/javascript">
                  VK.Widgets.Auth("vk_auth", {
                    "authUrl": "/dev/Login"
                  });
                </script>

                <!-- <div class="row">
                  <div class="col-sm-12"><a href="javascript:void(0)" class="bg-vk">
                      <i class="fa fa-vk"></i><span>Sign in With VK</span>
                    </a>
                  </div>
                </div> -->
                <!-- <div class="row">
                  <div class="col-sm-12">
                    <a href="https://www.linkedin.com/uas/oauth2/authorization?client_id=77cerboa6bsg7y&redirect_uri=https://www.bookanartiste.com/users/linkedinlogin&response_type=code&scope=r_liteprofile+r_emailaddress" class="bg-twt linkedin" ><i class="fa fa-linkedin" aria-hidden="true"></i><span>Sign in With Linkedin</a>
                  </div>
                </div> -->
              </div>
            </div>
          </div>

        </div>

      </div>


    </div>
  </div>
  </div>
</section>

<script src="https://apis.google.com/js/api:client.js"></script>

<!-- new implement by Rupam Google login  -->
<script>
  function signInWithGoogle() {
    AmagiLoader.show();
    setTimeout(() => {
      gapi.load('auth2', function() {
        gapi.auth2.init({
          client_id: '462164991513-a64hp9v767rcme4a4ulual1tugpkti9i.apps.googleusercontent.com',
          cookiepolicy: 'single_host_origin',
        }).then(function(auth2) {
          auth2.signIn().then(function(googleUser) {
            var profile = googleUser.getBasicProfile();
            // console.log(googleUser.getAuthResponse().id_token);
            var googleurl = "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=" + googleUser.getAuthResponse().id_token;
            $.getJSON(googleurl, function(result) {
              // console.log(result, 'Rupam');
              // return false;

              $.ajax({
                url: "<?php echo SITE_URL ?>/users/sociallogin",
                type: 'POST',
                data: {
                  "google_id": result.sub,
                  'email': result.email,
                  'user_name': result.given_name,
                  'picture': result.picture,
                },
                success: function(result2) {
                  // console.log("🚀 ~ file: login.ctp:168 ~ $.getJSON ~ result2:", result2)
                  AmagiLoader.hide();
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
          }, function(error) {
            AmagiLoader.hide();
            parsed_error = JSON.stringify(error, undefined, 2);
            parsed_error = JSON.parse(parsed_error);
            if (popup_closed_by_user != 'popup_closed_by_user') {
              alert(popup_closed_by_user);
            }
          });
        });
      });
    }, 1000);
  }
</script>

<!-- Add Facebook SDK by Rupam Facebook Login (This appId is on the rupam@doomshell.com) -->
<!-- 
X2CQ IVWL UIFS BQCY WNTL ASYB DOBK MUJF 
Two-factor authentication is save on the the iphone 
-->
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<script>
  // Initialize the Facebook SDK with your App ID
  window.fbAsyncInit = function() {
    FB.init({
      appId: '6596026000426373',
      xfbml: true,
      version: 'v16.0'
    });
    FB.AppEvents.logPageView();
  };

  // Function to handle the Facebook login process
  function signInWithFacebook() {
    AmagiLoader.show();

    setTimeout(() => {

      FB.login(
        function(response) {
          if (response.authResponse) {
            // console.log('User is logged in:', response.authResponse);
            getUserData();
          } else {
            AmagiLoader.hide();
            console.log('User canceled login or did not authorize the app.');
          }
        }, {
          scope: 'public_profile,email'
        }
      );

    }, 1000);
  }

  // Function to fetch the user's name and profile picture
  function getUserData() {
    FB.api('/me', {
      fields: 'id,email,first_name,name,picture'
    }, function(response) {
      if (response && !response.error) {
        console.log('>>>>>>>>>>>>>>>>>>>>>facebook', response);
        // return false;
        $.ajax({
          url: "<?php echo SITE_URL ?>/users/sociallogin",
          type: 'POST',
          data: {
            "fbid": response.id,
            "email": response.email,
            "user_name": response.name,
            "fname": response.first_name,
            "picture": response.picture.data.url
          },
          success: function(result) {
            AmagiLoader.hide();
            obj = JSON.parse(result);
            if (obj.redirect_url) {
              window.location.href = obj.redirect_url;
            }
          }
        });

        // Now you can use 'name' and 'pictureUrl' in your application as needed.
        // For example, you can display the user's name and profile picture on the page.
        // document.getElementById('user-name').innerText = 'Name: ' + name;
        // document.getElementById('profile-picture').src = pictureUrl;
      } else {
        AmagiLoader.hide();
        console.log('Error fetching user data:', response.error);
      }
    });
  }
</script>


<!-- New Fb Login Start -->


<!-- <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId: '349136458272230',
      cookie: true,
      xfbml: true,
      version: 'v19.0'
    });

    FB.AppEvents.logPageView();

  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
      return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));


  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });


  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }
</script> -->

<!-- New Fb login End-->




<!-- <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{your-app-id}',
      cookie     : true,
      xfbml      : true,
      version    : '{api-version}'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));


FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
});


<fb:login-button 
  scope="public_profile,email"
  onlogin="checkLoginState();">
</fb:login-button>


function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}


{
    status: 'connected',
    authResponse: {
        accessToken: '...',
        expiresIn:'...',
        signedRequest:'...',
        userID:'...'
    }
}

</script> -->
<!--  -->



<!-- <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId: '176670368409903',
      xfbml: true,
      version: 'v16.0'
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
      return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script> -->

<!-- <script type="text/javascript">
  // function signInWithFacebook() {}

  function loginCheck() {
    FB.getLoginStatus(function(response) {
      console.log('loginCheck', response);
      statusCheck(response);
      getUser();
    });
  }

  // Check login status
  function statusCheck(response) {
    console.log('statusCheck', response.status);
    if (response.status === 'connected') {
      console.log("connected");
    } else if (response.status === 'not_authorized') {
      // User logged into facebook, but not to our app.
    } else {
      // User not logged into Facebook.
    }
  }

  $('.fblogin').on('click', function() { //alert();
    FB.login(function() {
      loginCheck();
    }, {
      scope: 'email'
    });
  });


  function getUser() {
    FB.api('/me/?fields=id,name,email,first_name,picture', function(response) {
      // console.log('getUser', response);
      // console.log('responseid', response.id);
      // console.log('email', response.email);
      // console.log('pic', response.picture.data.url);
      // return false;
      $.ajax({
        url: "<?php //echo SITE_URL 
              ?>/users/sociallogin",
        type: 'POST',
        data: {
          "fbid": response.id,
          "email": response.email,
          "user_name": response.name,
          "fname": response.first_name,
          "picture": response.picture.data.url
        },
        success: function(result) {

          obj = JSON.parse(result);
          // console.log("🚀 ~ file: login.ctp:208 ~ FB.api ~ obj:", obj);

          if (obj.redirect_url) {
            // console.log('Result testing',obj.redirect_url);
            // return false;
            window.location.href = obj.redirect_url;
          }
        }
      });
    });
  }
</script> -->

<!-- client_id: '462164991513-a64hp9v767rcme4a4ulual1tugpkti9i.apps.googleusercontent.com', -->
<!-- <script>
  var googleUser = {};

  var startApp = function() {
    gapi.load('auth2', function() {
      auth2 = gapi.auth2.init({
        client_id: '462164991513-a64hp9v767rcme4a4ulual1tugpkti9i.apps.googleusercontent.com',
        cookiepolicy: 'single_host_origin',
      });
      $("body").on("click", ".googlelogin", function(e) {
        e.preventDefault(); // Prevent default click behavior
        var button = document.getElementsByClassName("googlelogin")[0];
        button.disabled = true; // Disable the button to prevent multiple clicks
        attachSignin(button);
      });
    });
  };

  function attachSignin(element) {
    console.log(element);
    auth2.attachClickHandler(element, {},
      function(googleUser) {
        var profile = googleUser.getBasicProfile();
        console.log(googleUser.getAuthResponse().id_token);
        var googleurl = "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=" + googleUser.getAuthResponse().id_token;
        $.getJSON(googleurl, function(result) {
          console.log(result);

          $.ajax({
            url: "<?php //echo SITE_URL 
                  ?>/users/sociallogin",
            type: 'POST',
            data: {
              "google_id": result.sub,
              'email': result.email,
              'user_name': result.given_name,
              'picture': result.picture,
            },
            success: function(result2) {
              if (result2) {
                obj = JSON.parse(result2);

                if (obj.redirect_url) {
                  console.log(obj.redirect_url);
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
        element.disabled = false; // Re-enable the button in case of an error
      }
    );
  }
</script> -->

<script>
  // startApp();
</script>
<script type="text/javascript">
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#inputPassword3');
  togglePassword.addEventListener('click', function(e) {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('bi-eye');
  });

  // setInterval(function() {
  //   fetch('/keep-alive'); // A dummy route to keep the session alive
  // }, 5000); // Every 5 minutes
</script>