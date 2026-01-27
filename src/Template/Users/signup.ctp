<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include jQuery Validation plugin -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<style>
  .error {
    color: red;
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

  svg {
    border-right: 1px solid #ccc;
    padding: 12px 0;
    width: 50px;
    height: 43px;
    vertical-align: -16px;
    text-align: center;
  }
</style>

<script>
  $(document).ready(function() {
    $("#user_form").validate({
      rules: {
        user_name: "required",
        email: {
          required: true,
          email: true
        },
        password: {
          required: true,
          minlength: 6
        },
        cpassword: {
          equalTo: "#password"
        },
        agree: "required"
      },
      messages: {
        user_name: "Please enter your name",
        email: {
          required: "Please enter your email address",
          email: "Please enter a valid email address"
        },
        password: {
          required: "Please enter a password",
          minlength: "Your password must be at least 6 characters long"
        },
        cpassword: {
          equalTo: "Please enter the same password as above"
        },
        agree: "Please accept the Terms and Conditions"
      },
      errorPlacement: function(error, element) {
        if (element.attr("name") == "agree") {
          error.insertAfter(element.closest(".checkbox"));
        } else {
          error.insertAfter(element);
        }
      }
    });
  });
</script>

<section id="page_signup">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <div class="signup-popup">
          <h2>Sign <span>Up</span></h2>
          <?php echo $this->Flash->render(); ?>
          <?php
          echo $this->Form->create($users, array('url' => array('controller' => 'users', 'action' => 'signup'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>
          <div class="form-group">
            <div class="col-sm-6 col-xs-6">
              <?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Enter Your Name', 'required' => true, 'label' => false, 'type' => 'text')); ?>
            </div>
            <div class="col-sm-6 col-xs-6">
              <?php echo $this->Form->email('email', array('class' => 'form-control', 'placeholder' => 'Enter Your Email', 'required' => true, 'autocomplete' => 'off', 'label' => false)); ?>
              <span id="dividhere" style="display:none;color:red;">This email already exists.</span>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6 col-xs-6">
              <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Password', 'type' => 'password', 'autocomplete' => 'off', 'label' => false, 'required' => true)); ?>
            </div>
            <div class="col-sm-6 col-xs-6">
              <?php echo $this->Form->input('cpassword', array('class' => 'form-control', 'placeholder' => 'Confirm Password', 'type' => 'password', 'autocomplete' => 'off', 'label' => false, 'required' => true)); ?>
              <?php echo $this->Form->hidden('user_activation_key', array('value' => md5(uniqid(rand(), true)))); ?>
              <?php echo $this->Form->hidden('ref_by', array('value' => (isset($ref_by)) ? $ref_by : '')); ?>
            </div>
          </div>

          <?php if ($_SERVER['HTTP_HOST'] != 'localhost') { ?>
            <div id="html_element" class="login_capcher"></div>
          <?php } ?>

          <div class="form-group">
            <div class="col-sm-12">
              <div class="checkbox">
                <label>
                  <?php echo $this->Form->checkbox('agree', array('required' => true)); ?>
                  I agree with the <a href="<?php echo SITE_URL; ?>/termsandconditions" target="_blank">Terms and Conditions</a> of Book An Artiste
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <button type="submit" class="btn btn-default"><?php echo __('Submit'); ?></button>
            </div>
          </div>
          <?php echo $this->Form->end(); ?>
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
                    <a href="#" class="bg-face fblogin">
                      <!-- <i class="fa fa-facebook"></i> -->
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">

                        <defs>
                        </defs>
                        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                          <path d="M 85.033 90 C 87.776 90 90 87.776 90 85.033 V 4.967 C 90 2.223 87.776 0 85.033 0 H 4.967 C 2.223 0 0 2.223 0 4.967 v 80.066 C 0 87.776 2.223 90 4.967 90 H 85.033 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(60,90,153); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                          <path d="M 50.916 83.204 V 48.351 h 11.699 l 1.752 -13.583 h -13.45 v -8.672 c 0 -3.933 1.092 -6.612 6.731 -6.612 l 7.193 -0.003 V 7.332 c -1.244 -0.166 -5.513 -0.535 -10.481 -0.535 c -10.37 0 -17.47 6.33 -17.47 17.954 v 10.017 H 25.16 v 13.583 h 11.729 v 34.853 H 50.916 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
                        </g>
                      </svg>
                      <span>Sign in With Facebook</span></a>
                  </div>
                  <div class="col-sm-12">
                    <a href="#" class="bg-g-plus googlelogin" onclick="signInWithGoogle()">
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
                      //  apiId: 51563627
                    });
                  </script>
                  <div id="vk_auth" style="position: absolute;display: none;width: 200px;height: 116px;background: none;top: -80px;left: -334px"></div>
                  <script type="text/javascript">
                    VK.Widgets.Auth("vk_auth", {
                      "authUrl": "/dev/Login"
                    });
                  </script>
                  <!-- <div class="col-sm-12"><a href="javascript:void(0)" class="bg-vk"><i class="fa fa-vk"></i><span>Sign in With VK</span></a></div> -->
                  <!-- <div class="col-sm-12">
                  <a href="javascript:void(0)" class="bg-twt"><i class="fa fa-twitter"></i><span>Sign in linkedin</a>
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

<script type="text/javascript">
  //  $(document).ready(function() {
  //    $("#country_phone").on('change', function() {
  //      var id = $(this).val();
  //      $("#phonecode").find('option').remove();
  //      if (id) {
  //        var dataString = 'id=' + id;
  //        $.ajax({
  //          type: "POST",
  //          url: '<?php //echo SITE_URL; 
                    ?>/users/getphonecode',
  //          data: dataString,
  //          cache: false,
  //          success: function(html) {
  //            $.each(html, function(key, value) {
  //              $('#phonecode').val(value);
  //            });
  //          }
  //        });
  //      }
  //    });
  //  });



  $(document).ready(function() {
    $('#username').change(function() {
      var username = $('#username').val();
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

  // Get login status
  function loginCheck() {
    FB.getLoginStatus(function(response) {
      console.log('loginCheck', response.status);
      statusCheck(response);
      getUser();
    });
  }



  function checkLoginState() { // Called when a person is finished with the Login Button.
    FB.getLoginStatus(function(response) { // See the onlogin handler
      statusChangeCallback(response);
    });
  }


  // Check login status
  function statusCheck(response) {
    if (response.status === 'connected') {
      // User is logged in and authorized your app
    } else if (response.status === 'not_authorized') {
      // User is logged into Facebook, but not authorized your app
    } else {

    }
  }

  $('.fblogin').on('click', function() {
    FB.login(function() {
      loginCheck();
    }, {
      scope: 'email'
    });
  });

  // Here we run a very simple test of the Graph API after login is
  // successful. See statusChangeCallback() for when this call is made.
  function getUser() {
    FB.api('/me/?fields=id,name,email,first_name,picture', function(response) {
      // console.log("🚀 ~ file: signup.ctp:292 ~ FB.api ~ response:", response);
      // return false;

      // Create a FormData object to send the data via AJAX
      var formData = new FormData();
      formData.append("fbid", response.id);
      formData.append("email", response.email);
      formData.append("user_name", response.name);
      formData.append("fname", response.first_name);
      formData.append("picture", response.picture.data.url);

      // Send the AJAX request
      $.ajax({
        url: "<?php echo SITE_URL ?>/users/sociallogin",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(result) {
          obj = JSON.parse(result);
          // console.log("🚀 ~ file: signup.ctp:294 ~ FB.api ~ obj:", obj)

          if (obj.redirect_url) {
            window.location.href = obj.redirect_url;
          }
        },
        error: function(xhr, status, error) {
          console.error("AJAX request error:", error);
        }
      });
    });
  }
</script>

<!-- // Google login -->
<script src="https://apis.google.com/js/api:client.js"></script>
<script src="https://cdn.jsdelivr.net/gh/AmagiTech/JSLoader/amagiloader.js"></script>

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
            console.log(googleUser.getAuthResponse().id_token);
            var googleurl = "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=" + googleUser.getAuthResponse().id_token;
            $.getJSON(googleurl, function(result) {
              // console.log(result);
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
                  AmagiLoader.hide();
                  if (result2) {
                    obj = JSON.parse(result2);
                    // console.log(obj);
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

</script>

<!-- GOOGLE API KEY, login authentication key -->

<!-- 
<script>
  var googleUser = {};
  var startApp = function() {
    gapi.load('auth2', function() {
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: '462164991513-a64hp9v767rcme4a4ulual1tugpkti9i.apps.googleusercontent.com',
        cookiepolicy: 'single_host_origin',
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
        var googleurl = "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=" + googleUser.getAuthResponse().id_token
        $.getJSON(googleurl, function(result) {
          $.ajax({
            url: "<?php //echo SITE_URL; 
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
                  window.location.href = obj.redirect_url;
                }
              }
            }
          });
        });
      },
      function(error) {

      });
  }

  startApp();
</script> -->

<style>
  #g-recaptcha-response {
    display: block !important;
    position: absolute;
    margin: -78px 0 0 0 !important;
    width: 302px !important;
    height: 76px !important;
    z-index: -999999;
    opacity: 0;
  }
</style>

<!-- ================================= -->
<script type="text/javascript">
  var onloadCallback = function() {
    grecaptcha.render('html_element', {
      'sitekey': '6LcQUZwpAAAAAK5D23oJ2doWpEguufY41ZlJCLYM'
    });
  };

  window.onload = function() {
    var $recaptcha = document.querySelector('#g-recaptcha-response');

    if ($recaptcha) {
      $recaptcha.setAttribute("required", "required");
    }
  };
</script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>