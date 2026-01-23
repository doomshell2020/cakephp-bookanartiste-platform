 <!--------------------------------------------------> 
  <footer>
    <div id="footer">
      <div class="container">
        <div class="row">
          <div class="col-sm-3">
            <h3>Book An Artiste </h3>
            <div class="col-sm-12 foot-social"> <a href="#" class="fa fa-facebook"></a> <a href="#" class="fa fa-twitter"></a> <a href="#" class="fa fa-pinterest"></a> <a href="#" class="fa fa-linkedin"></a> </div>
          </div>
          <div class="col-sm-3">
            <h4>Quick Links</h4>
            <ul class="list-unstyled">
              <li><a href="#">Home</a></li>
              <li><a href="#">Artist</a></li>
              <li><a href="#">Jobs</a></li>
               <li><a href="#">FAQ</a></li>
            </ul>
          </div>
          <div class="col-sm-3">
            <h4>Information</h4>
            <ul class="list-unstyled">
              <li><a href="#">How it Work</a></li>
              <li><a href="#">Packages</a></li>
              <li><a href="#">Contact Us</a></li>
            </ul>
          </div>
          <div class="col-sm-3">
            <h4>Useful Links</h4>
            <ul class="list-unstyled">
              <li><a href="<?php echo SITE_URL; ?>/profile">Profile</a></li>
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
<script>

document.querySelector("html").classList.add('js');

var fileInput  = document.querySelector( ".input-file" ),  
    button     = document.querySelector( ".input-file-trigger" ),
    the_return = document.querySelector(".file-return");
      
button.addEventListener( "keydown", function( event ) {  
    if ( event.keyCode == 13 || event.keyCode == 32 ) {  
        fileInput.focus();  
    }  
});
button.addEventListener( "click", function( event ) {
   fileInput.focus();
   return false;
});  
fileInput.addEventListener( "change", function( event ) {  
    the_return.innerHTML = this.value;  
});
</script> 
<script>
$('.slider').owlCarousel({
    loop:true,
	autoplay:true,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:1,
            nav:false
        },
        1000:{
            items:1,
            nav:false,
            loop:false
        }
    }
})

$('.featured-list-carousal').owlCarousel({
    loop:true,
   
	autoplay:true,
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:3,
            nav:false
        },
		 1000:{
            items:5,
            nav:false
        },
        1200:{
            items:6,
            nav:false,
            loop:false
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
$(document).ready(function(){
   $("button").click(function(){
       $(".job-box-inner").addClass("show");
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
$(".but").click(function(){
    $(".upload").addClass("show");
});
</script>
</body>
</html>
