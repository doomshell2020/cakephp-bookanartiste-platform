 <!-------------------------------------------------->
 <?php $admin_data = $this->Comman->admindata(); //pr($admin_data); die; 
    ?>

 <!-- here all element chatboat.ctp -->
 <?php //echo $this->element('chatboat') ?>

 <footer>
     <div id="footer">
         <div class="container">
             <div class="row">
                 <div class="col-sm-3 col-xs-6">
                     <div class="foot_socialdiv">
                         <h3>Book An Artiste </h3>
                         <div class="foot-social">
                             <a target="_blank" href="<?php echo $admin_data['facebook_url']; ?>" class="fa fa-facebook"></a>
                             <a target="_blank" href="<?php echo $admin_data['twitter_url']; ?>" class="fa fa-twitter"></a>
                             <a target="_blank" href="<?php echo $admin_data['instagram']; ?>" class="fa fa-instagram"></a>
                             <!-- <a href="<?php //echo $admin_data['facebook_url']; 
                                            ?>" class="fa fa-linkedin"></a>  -->
                         </div>
                     </div>
                 </div>
                 <div class="col-sm-3 col-xs-6">
                     <h4>Quick Links</h4>
                     <ul class="list-unstyled">
                         <li><a href="<?php echo SITE_URL; ?>">Home</a></li>
                         <!-- <li><a href="#">Artist</a></li> -->
                         <li><a href="<?php echo SITE_URL; ?>/jobpost/">Jobs</a></li>
                     </ul>
                 </div>
                 <div class="col-sm-3 col-xs-6">
                     <h4>Information</h4>
                     <ul class="list-unstyled">
                         <li><a href="<?php echo SITE_URL; ?>/#col_work_process">How it Work</a></li>
                         <li><a href="<?php echo SITE_URL; ?>/package/allpackages/">Packages</a></li>
                         <li><a href="<?php echo SITE_URL; ?>/static/contactus">Contact Us</a></li>

                     </ul>
                 </div>
                 <div class="col-sm-3 col-xs-6">
                     <h4>Useful Links</h4>
                     <ul class="list-unstyled">
                         <!-- <li><a href="<?php echo SITE_URL; ?>/profile">Profile</a></li> -->
                         <li><a href="<?php echo SITE_URL; ?>/static/faq">FAQ</a></li>
                         <li><a href="<?php echo SITE_URL; ?>/privacy">Privacy Policy</a></li>
                         <li><a href="<?php echo SITE_URL; ?>/termsandconditions">Terms of Conditions</a></li>
                     </ul>
                 </div>
             </div>
         </div>
     </div>
     <div id="footer-bottom"> &copy;<?php date('Y'); ?> Book An Artiste - All Rights Reserved</div>
 </footer>


 </div>

 <?php /* ?>
 <script src="<?php echo SITE_URL; ?>/js/lightgallery-all.min.js"></script>
 <?php */ ?>



 <!-- <script src="<?php //echo SITE_URL; 
                    ?>/js/bootstrap_new.bundle.min.js"></script> -->


 <script>
     document.querySelector("html").classList.add('js');

     var fileInput = document.querySelector(".input-file"),
         button = document.querySelector(".input-file-trigger"),
         the_return = document.querySelector(".file-return");

     button.addEventListener("keydown", function(event) {
         if (event.keyCode == 13 || event.keyCode == 32) {
             fileInput.focus();
         }
     });
     button.addEventListener("click", function(event) {
         fileInput.focus();
         return false;
     });
     fileInput.addEventListener("change", function(event) {
         the_return.innerHTML = this.value;
     });
 </script>
 <script>
     $('.slider').owlCarousel({
         loop: true,
         autoplay: true,
         responsiveClass: true,
         responsive: {
             0: {
                 items: 1,
                 nav: false
             },
             600: {
                 items: 1,
                 nav: false
             },
             1000: {
                 items: 1,
                 nav: false,
                 loop: false
             }
         }
     })

     $('.advrtjob').owlCarousel({
         loop: true,
         autoplay: true,
         nav: true,
         responsiveClass: true,
         stopOnHover: true,
         responsive: {
             0: {
                 items: 1,
                 nav: true
             },
             600: {
                 items: 1,
                 nav: true
             },
             1000: {
                 items: 1,
                 nav: true,
                 loop: true
             }
         }
     })


     $('.featured-list-carousal').owlCarousel({
         loop: true,

         autoplay: true,
         responsiveClass: true,
         responsive: {
             0: {
                 items: 1,
                 nav: false
             },
             600: {
                 items: 3,
                 nav: false
             },
             1000: {
                 items: 4,
                 nav: false
             },
             1200: {
                 items: 5,
                 nav: false,
                 loop: false
             }
         }
     })
 </script>
 <script>
     $(document).ready(function() {

         $('#popoverbtn').popover({
             trigger: 'manual',
             placement: 'bottom',
             html: true,

             content: function() {
                 return '<div><p><a href="#"><i class="fa fa-facebook icon icon-30 rad-5 bg-4f84c4"></i></a> <a href="#"><i class="fa fa-google icon icon-30 rad-5 bg-f2552c"></i></a> <a href="#"><i class="fa fa-twitter icon icon-30 rad-5 bg-95dee3"></i></a> <a href="#"><i class="fa fa-instagram icon icon-30 rad-5 bg-fe718b"></i></a></p></div>'
             }
         });
     });


     $(document).ready(function() {
         $(document).on("click", ".popover .close", function() {
             $(this).parents(".popover").popover('hide');
         });
     });
 </script>
 <script>
     $(document).ready(function() {
         $("button").click(function() {
             $(".job-box-inner").addClass("show");
         });
     });
 </script>

<script>
     $(document).ready(function() {
         $(".profile_slidedown a").click(function() {
             $(".dropdown.open").removeClass("open");
         });

         $(".dropdown").click(function() {
             $(".dropdown.open").removeClass("open");
         });

         $(".dropdown").click(function() {
             $(".profile_drop_form").slideUp();
         });
     });
 </script>
 <script>
     /*
   $(document).ready(function() {
    $('.popup-with-zoom-anim').magnificPopup({
    type: 'inline',
    fixedContentPos: false,
    fixedBgPos: true,
    overflowY: 'auto',
    closeBtnInside: true,
    preloader: false,
    midClick: true,
    removalDelay: 300,
    mainClass: 'my-mfp-zoom-in'
    });
														    
    });
    */
 </script>
 <script>
     $(".but").click(function() {
         $(".upload").addClass("show");
     });
 </script>
 <script>
     $(document).ready(function() {
         $('input,textarea').focus(function() {
             $(this).data('placeholder', $(this).attr('placeholder'))
                 .attr('placeholder', '');
         }).blur(function() {
             $(this).attr('placeholder', $(this).data('placeholder'));
         });
     });
 </script>
 <script>
     setInterval(function() {
         $.ajax({
             async: true,
             data: $("#auto_decline").serialize(),
             dataType: "html",
             type: "POST",
             url: "<?php echo SITE_URL; ?>/banner/autodecline",
             success: function(data, textStatus) {}
         });
     }, 30000);
 </script>
 <script>
     setInterval(function() {
         $.ajax({
             async: true,
             data: $("#auto_decline_for_payment_notdone").serialize(),
             dataType: "html",
             type: "POST",
             url: "<?php echo SITE_URL; ?>/banner/autodeclineforpaymentnotdone",
             success: function(data, textStatus) {}
         });
     }, 30000);
 </script>
 <script>
     setTimeout(function() {
         $('.alert-success').fadeOut('fast');
     }, 7000); // <-- time in milliseconds
 </script>
 <script>
     //  $(document).ready(function() {
     //      if (!$.browser.webkit) {
     //          $('.wrapper').html('<p>Sorry! Non webkit users. :(</p>');
     //      }
     //  });
 </script>

 </body>

 </html>