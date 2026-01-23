<footer class="main-footer">
    

    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="<?php echo SITE_URL;?>">Book an Artiste</a>.</strong> All rights
    reserved.
  </footer>

  
  
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->


<!-- jQuery UI 1.11.4 -->

<!--<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>-->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->


<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>


<!-- Sparkline -->
<?= $this->Html->script('admin/jquery.sparkline.min.js') ?>

<!-- jvectormap -->
<?= $this->Html->script('admin/jquery-jvectormap-1.2.2.min.js') ?>
<?= $this->Html->script('admin/jquery-jvectormap-world-mill-en.js') ?>

<!-- jQuery Knob Chart -->
<?= $this->Html->script('admin/jquery.knob.js') ?>

<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<?= $this->Html->script('admin/daterangepicker.js') ?>

<!-- datepicker -->
<?= $this->Html->script('admin/bootstrap-datepicker.js') ?>

<!-- Bootstrap WYSIHTML5 -->
<?= $this->Html->script('admin/bootstrap3-wysihtml5.all.min.js') ?>

<!-- Slimscroll -->
<?= $this->Html->script('admin/jquery.slimscroll.min.js') ?>

<!-- FastClick -->
<?= $this->Html->script('admin/fastclick.js') ?>
<?= $this->Html->script('admin/jquery.dataTables.min.js') ?>
<?= $this->Html->script('admin/dataTables.bootstrap.min.js') ?>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<!-- Commented the following line 60 and used the line 61 following it instead -->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
<?php echo $this->Html->css('admin/jquery-ui.css'); ?>

<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>
<!-- Select2 -->


<?= $this->Html->css('select2/select2.min.css') ?>

<?= $this->Html->script('select2/select2.full.min.js') ?>

<!-- input date -->
<?= $this->Html->script('input-mask/jquery.inputmask.js') ?>
<?= $this->Html->script('input-mask/jquery.inputmask.date.extensions.js') ?>
<?= $this->Html->script('input-mask/jquery.inputmask.extensions.js') ?>
<script>
   $('#datepicksd123').datepicker();
</script>

<script>

  $('#dp1').datepicker();
  $('#dp2').datepicker();

  // To use in EmployeeAttendance/index.ctp
  $('#dp3').datepicker({
    
    dateFormat: 'dd-mm-yy',
    minDate: 0,
    maxDate: 0

  }).datepicker("setDate", new Date());

  // To use in EmployeeAttendance/manage.ctp
  $('#dp4').datepicker({
    
    dateFormat: 'dd-mm-yy'
    
  }).datepicker("setDate", new Date());

</script>

<script>

  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
    //Datemask dd/mm/yyyy
   	var date = new Date();

  $('#datepick').datepicker({"changeMonth":true,'maxDate':'0',"changeYear":true,"autoSize":true}).on('change',function(){
			
		
            today = new Date();
            eighteenYearBefore = new Date().setYear(new Date().getFullYear() -18);
            selecteds = new Date($('#datepick').val());
     
           if(selecteds>eighteenYearBefore) {
			   $('#datepick').val('')
            $(".display_errors").show();   
           } else {
               $(".display_errors").hide();
           }
            });
    $('#datepick1').datepicker({ 	
		"changeMonth":true,   minDate: 0,"changeYear":true,"autoSize":true,"dateFormat":"dd-mm-yy"});
  $('.joindates').datepicker({"changeMonth":true,'minDate':'0',"changeYear":true,"autoSize":true,"dateFormat":"dd-mm-yy"});
  $('#datepicks').datepicker({
	  "beforeShowDay": function(date){ return [date.getDay() == 1,""]},
	  
	  "changeMonth":true,'maxDate':'0',"changeYear":true,"autoSize":true,"dateFormat":"dd-mm-yy"});
    // $("[data-mask]").inputmask();
 });
 
</script>
  
<!-- AdminLTE App -->
<?= $this->Html->script('admin/app.min.js') ?>



<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<?= $this->Html->script('admin/dashboard.js') ?>



<!-- AdminLTE for demo purposes -->
<?= $this->Html->script('admin/demo.js') ?>
<?= $this->Html->script('admin/morris.min.js') ?>


<script>

$(document).ready(function(){

 var current;//variable to store current image
//creating elements dynamically

  var li_box = $("<div></div>");
  li_box.addClass("lightBox");
  var bg = $("<div></div>");
  bg.addClass("bg");
  li_box.append(bg);
  var show =  $("<div></div>");
  show.addClass("show");
  var image = $("<img>");
  show.append(image);
  li_box.append(show);
  //now appending all items to body
$("body").append(li_box);
//capturing image width and height
  var s_width = $(".show img").outerWidth();
  var s_height = $(".show img").outerHeight();
//targeting image in center by capturing windows width
  var left = ($(window).width() - s_width)/2;
   var top = ($(window).height() - s_height)/2;
   $(".show").css({top:top,left:left});


//things we need to do to toggle previous and next button
  //if current image has class hide_p or hide_n than hide button according to class
  function check_p(){
    return current.hasClass("hide_p");
  }

  function check_n(){
    return current.hasClass("hide_n");
  }

//tasks we need to perform when an user click on image i.e. any li the element will be created dynamically in our page
$("#light_box li a.lboximg").click(function(){
  //capturing location
    current = $(this);

//now here we're just switching the show/hide for next & previous button with nested if
  if(check_p()){ 

    $(".previous").hide();
    $(".next").show();
    var src = $(this).children().attr("src");
    image.attr("src",src);
    $(".lightBox").show();
  } else if(check_n()){
    $(".next").hide();
    $(".previous").show();
    var src = $(this).children().attr("src");
    image.attr("src",src);
    $(".lightBox").show();
  }else{
    $(".previous").show();
    $(".next").show();
    var src = $(this).children().attr("src");
    image.attr("src",src);
    $(".lightBox").show();
  }
})


$(".bg").click(function(){
  $(".lightBox").hide();
})

})







</script>


</body>
</html>
