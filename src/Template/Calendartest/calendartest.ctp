<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL; ?>/css/calendar.css"/>
<?php $id = $this->request->session()->read('Auth.User.id'); ?>
<section id="page_alert">
    <div class="container">
      <h2>My Calendar</h2>
      <p class="m-bott-50">An Effective Time Management Tool</p>
    </div>
    
    <div class="refine-search">
      <div class="container">
        <div class="row m-top-20 profile-bg">
         
          
          
          <div class="col-sm-8">
	
            <div class="panel-right">
              <form>
				  
              <div class="box member-detail row alerts jobalertss">
				
			
                <div class="col-sm-12 boc_gap">
                  <div class="row">
  <div id="calendar_div">
	<?php echo get_calender_full(); ?>
</div>


</div>
                </div>
             
              </div>
         
              </form>
            </div>
          </div>
		  
		  <div class="col-sm-4">
            <div class="panel panel-left">
            <ul class="schedule-categry list-unstyled navff" >

			
<li class=""> <a  class="btn schedule-default" href="javascript:;" onclick="add_event_information();"><i class="fa fa-plus" aria-hidden="true"></i> Add to Calender</a> </li>

<!--<a  href="#" class="schedule" href="javascript:;" onclick="add_event_information();">Upcoming Schedule</a>-->

				

			</ul>
  <ul class=" schedule-categrysec list-unstyled navff" >
			
			<?php foreach($schedule as $value){ //pr($value); ?>
			<li class=""><a href="#"class="jobalerts" data-action="alerts"><?php echo $value['publisheddate']; ?></a></li>
<ul class="" >			
<li class=""><a href="#"class="jobalerts" data-action="alerts">Reminder()</a></li>
<li class=""><a href="#"class="jobalerts" data-action="alerts">To Do()</a></li>
<li class=""><a href="#"class="jobalerts" data-action="alerts">Event()</a></li>
</ul>



					<?php } ?>
</ul>

   

              
            </div>
		
          </div> 
		  
		  
        </div>
      </div>
    </div>
  </section>
  
   
<?php use Cake\Datasource\ConnectionManager; ?>

<?php
/*
 * This function create By Jignesh Patel	 
 * Function requested by Ajax
 */
if(isset($_REQUEST['fun_type']) && !empty($_REQUEST['fun_type'])){
	switch($_REQUEST['fun_type']){
		case 'get_calender_full':
			get_calender_full($_REQUEST['year'],$_REQUEST['month']);
			break;
		case 'get_events_information':
			get_events_information($_REQUEST['date']);
			break;
		//For Add Event with date wise.
		case 'add_event_information':
			add_event_information($_REQUEST['date'],$_REQUEST['title']);
			break;
		default:
			break;
	}
}

/*
 * Get Full calendar in html
 */
function get_calender_full($year = '',$month = '')
{
	$date_Year = ($year != '')?$year:date("Y");
	$date_Month = ($month != '')?$month:date("m");
	$date = $date_Year.'-'.$date_Month.'-01';
	$current_Month_First_Day = date("N",strtotime($date));
	$total_Days_ofMonth = cal_days_in_month(CAL_GREGORIAN,$date_Month,$date_Year);
	$total_Days_ofMonthDisplay = ($current_Month_First_Day == 7)?($total_Days_ofMonth):($total_Days_ofMonth + $current_Month_First_Day);
	$boxDisplay = ($total_Days_ofMonthDisplay <= 35)?35:42;
?>


	<div id="calender_section">
		<h2>
        	<!--<a href="javascript:void(0);" onclick="get_calendar_data('calendar_div','<?php //echo date("Y",strtotime($date.' - 1 Month')); ?>','<?php //echo date("m",strtotime($date.' - 1 Month')); ?>');">&lt;</a>-->
            <select name="month_dropdown" class="month_dropdown dropdown"><?php echo get_all_months__of_year($date_Month); ?></select>
			<select name="year_dropdown" class="year_dropdown dropdown"><?php echo get_year($date_Year); ?></select>
           <!-- <a href="javascript:void(0);" onclick="get_calendar_data('calendar_div','<?php //echo date("Y",strtotime($date.' + 1 Month')); ?>','<?php //echo date("m",strtotime($date.' + 1 Month')); ?>');">&gt;</a>-->
        </h2>
        <!-- event_list is used for view event with popup -->
		<div id="event_list" class="modal"></div>
		<!-- End of event list popup -->

        <!--Below Code for Event Add-->

        <!-- Popup div start here -->
		  <?php $rem = array('RE'=>'Remdnder','TD'=>'ToDo') ?>
        
		<div id="event_add" class="modal">
		  <div class="modal-content">
		    <span class="close"><a href="#" onclick="close_popup('event_add')">×</a></span>
		    		<!--<p>Add Event on <span id="eventDateView"></span></p>-->
		    		    <form class="form-horizontal">
               <div class="form-group">
                  <label for="" class="col-sm-2 control-label"> <b>Event Type :</b></label>
                  <div class="col-sm-8">
                    <label class="radio-inline">
                      <input type="radio" name="eventrem" id="eventreminder" value="RE" >
                      Reminder </label>
                    <label class="radio-inline">
                      <input type="radio" name="eventrem" id="eventtd" value="TD">
                      ToDo </label>
                    <label class="radio-inline">
                      <input type="radio" name="eventrem" id="eventev" value="EV">
                      Event </label>
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label"><b>Event Title :</b></label>
                  <div class="col-sm-6">
                    <input class="form-control" type="text" id="eventTitle" value="" required>
                  </div>
                  <div class="col-sm-4"></div>
                </div>
                
                 <div class="form-group">
                  <label for="" class="col-sm-2 control-label"><b>Description :</b></label>
                  <div class="col-sm-6">
                 <input class="form-control" type="text" id="eventdesc" value="" required>
                  </div>
                  <div class="col-sm-4"></div>
                </div>
                
                
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label"><b>Event Date :</b></label>
                  <div class="col-sm-6">
                 <input class="form-control" type="text" id="datetimepicker1" value="" placeholder="DD-MM-YYYY" required>
                  </div>
                  <div class="col-sm-4"></div>
                </div>
                
                
                <div id= "loca" class="form-group" style="display: none;">
                  <label for="" class="col-sm-2 control-label"><b>Location :</b></label>
                  <div class="col-sm-6">
                 <input class="form-control" type="text" id="location" value="" required>
                  </div>
                  <div class="col-sm-4"></div>
                </div>
                
                
               
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                      <input  type="hidden" id="eventDate" value=""/>
		            <input type="button" class="btn btn-default" id="add_event_informationBtn" value="Add"/>
                  </div>
                </div>
            
		            
		          
		              </form>
		  </div>
		</div>
		<!-- Popup hmmt end. -->
<script>
$(document).ready(function(){
    $("#eventev").click(function(){
        $("#loca").css("display", "block");
       
    });
});
</script>

<script>
$(document).ready(function(){
    $("#eventreminder").click(function(){
        $("#loca").css("display", "none");
       
    });
     $("#eventtd").click(function(){
        $("#loca").css("display", "none");
       
    });
});
</script>

        <div id="calender_section_top">
			<ul>
				<li>SUN</li>
				<li>MON</li>
				<li>TUE</li>
				<li>WED</li>
				<li>THU</li>
				<li>FRI</li>
				<li>SAT</li>
			</ul>
		</div>
		<div id="calender_section_bot">
		<ul>
			<?php 

			// this is for create calendra and view add event and view event and number of Events
				$dayCount = 1; 
				for($cb=1;$cb<=$boxDisplay;$cb++){
					if(($cb >= $current_Month_First_Day+1 || $current_Month_First_Day == 7) && $cb <= ($total_Days_ofMonthDisplay)){
						
						// Below javascript code for get current date
						
						$currentDate = $date_Year.'-'.$date_Month.'-'.$dayCount;
						//$eventNum = 0;
					//	$this->Post = ClassRegistry::init(‘calendar’);
						

						$conn = ConnectionManager::get('default');
						$frnds = "SELECT from_date FROM calendar WHERE `user_id` ='".$_SESSION['Auth']['User']['id']."' and  STR_TO_DATE(`from_date`,'%Y-%m-%d')  = '".$currentDate."' OR STR_TO_DATE(`to_date`,'%Y-%m-%d')  >= '".$currentDate."' ";
						$onlines = $conn->execute($frnds);	
						$onlines = $onlines ->fetchAll('assoc');
					//$CalendarController->calendar($currentDate); 
						// Below query useing for getting number of events in current date
 
					//$result = $db->query("SELECT from_date FROM calendar WHERE date = '".$currentDate."'");
						$eventNum = count($onlines);
						
						//Define date cell color
						if(strtotime($currentDate) == strtotime(date("Y-m-d"))){
							echo '<li date="'.$currentDate.'" class="grey date_cell">';
						}elseif($eventNum > 0){
							echo '<li date="'.$currentDate.'" class="light_sky date_cell">';
						}else{
							echo '<li date="'.$currentDate.'" class="date_cell">';
						}
						//Date cell
						echo '<span>';
						echo $dayCount;
						echo '</span>';
						
						//Hover event popup
						echo '<div id="date_popup_'.$currentDate.'" class="date_popup_wrap none">';
						echo '<div class="date_window">';
						echo '<div class="popup_event">Events ('.$eventNum.')</div>';
						echo ($eventNum > 0)?'<a href="javascript:;" onclick="get_events_information(\''.$currentDate.'\');">View Events</a><br/>':'';
						//For Add Event
						//echo '<a href="javascript:;" onclick="add_event_information(\''.$currentDate.'\');">Add Event</a>';
						echo '</div></div>';
						
						echo '</li>';
						$dayCount++;
			?>
			<?php }else{ ?>
				<li><span>&nbsp;</span></li>
			<?php } } ?>
			</ul>
		</div>
	</div>
	<?php 
	} 
	function get_all_months__of_year($selected = ''){
	$options = '';
	for($i=1;$i<=12;$i++)
	{
		$value = ($i < 01)?'0'.$i:$i;
		$selectedOpt = ($value == $selected)?'selected':'';
		$options .= '<option value="'.$value.'" '.$selectedOpt.' >'.date("F", mktime(0, 0, 0, $i+1, 0, 0)).'</option>';
	}
	return $options;
}

/*
 * below function with get all year list
 * optional parameter >> $selected
 */
function get_year($selected = ''){
	$options = '';
	for($i=2015;$i<=2025;$i++)
	{
		$selectedOpt = ($i == $selected)?'selected':'';
		$options .= '<option value="'.$i.'" '.$selectedOpt.' >'.$i.'</option>';
	}
	return $options;
}
	?>
	<script type="text/javascript">
			var site_url='<?php echo SITE_URL;?>/';
	// ajax call to get event detail from database.
		function get_calendar_data(target_div,year,month){
			$.ajax({
				type:'POST',
				url: site_url+'calendar/calendarset',
				data:'fun_type=get_calender_full&year='+year+'&month='+month,
				success:function(html){
					$('#'+target_div).html(html);
				}
			});
		}
		
		function get_events_information(date){
			$.ajax({
				type:'POST',
				url: site_url+'calendar/calendarinformation',
				data:'fun_type=get_events_information&date='+date,
				success:function(html){ //alert(html);
					$('#event_list').html(html);
					$('#event_add').slideUp('slow');
					$('#event_list').slideDown('slow');
				}
			});
		}
		
		/*
		* function name add_event_information
		* Description :- Add Event inforation as per date wise
		* parameter :- date
		*/
		function add_event_information(date){
			$('#eventDate').val(date);
			$('#eventDateView').html(date);
			$('#event_list').slideUp('slow');
			$('#event_add').slideDown('slow');
		}

		/*
		*  below code used for save event information into databse. and set message event created successfully.
		*/
		$(document).ready(function(){

			$('#add_event_informationBtn').on('click',function(){
				var date = "2018-04-03";
				//alert(date);
				var title = $('#eventTitle').val();
			var radioValue = $("input[name='eventrem']:checked").val();
			//	var reminder = $('#eventreminder').val();
			//	var todo = $('#eventtd').val();
				var desc = $('#eventdesc').val();
				var eventdate = $('#datetimepicker1').val();
				var location = $('#location').val();
				$.ajax({
					type:'POST',
					url: site_url+'calendar/eventadd',
					data:'fun_type=add_event_information&date='+date+'&title='+title+'&reminder='+radioValue+'&desc='+desc+'&eventdate='+eventdate+'&location='+location,
					success:function(msg){
						if(msg == 'ok'){
							var dateSplit = date.split("-");
							$('#eventTitle').val('');
							
							success = "Event Created Successfully";
							showerror(success);
							setTimeout(function(){
   window.location.reload(1);
}, 1000);
							get_calendar_data('calendar_div',dateSplit[0],dateSplit[1]);
							
						}else{
							alert('Sorry some issues please try again later.');
						}
					}
				});
			});
		});
		
		$(document).ready(function(){
		    
		    $( ".date_cell" ).on( "click", function() {
		    
				date = $(this).attr('date');
				$(".date_popup_wrap").fadeOut();
				$("#date_popup_"+date).fadeIn();	
			});
			$('.date_cell').mouseleave(function(){
				$(".date_popup_wrap").fadeOut();		
			});
			$('.month_dropdown').on('change',function(){
				get_calendar_data('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
			});
			$('.year_dropdown').on('change',function(){
				get_calendar_data('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
			});
			$(document).click(function(){
				$('#event_list').slideUp('slow');
			});

		});

		
		// Closed popup string	
		function close_popup(event_id)
		{
			$('#'+event_id).css('display','none');
		}
	</script>
 <script type="text/javascript"> 
        $(function() { 
	    var today = new Date();
	   
	    
	    $('#datetimepicker1').datetimepicker({
			format: "dd-mm-yyyy h:mm",
		    language: 'en', 
		    pickTime: false,
		    pick12HourFormat: true,
		    startDate: today,
		    endDate:0, 
		}); 
		 }); 
		</script>
		<script>
function showerror(error)
{
    BootstrapDialog.alert({
	size: BootstrapDialog.SIZE_SMALL,
	title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Event !!",
	message: "<h5>"+error+"</h5>"
	});
	

    return false;
    	
}

</script>

  <!-------------------------------------------------->
