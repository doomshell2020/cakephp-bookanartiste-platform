<?php use Cake\Datasource\ConnectionManager; ?>
<div id="eventmsg"></div>
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

       
<script>
$(document).ready(function(){
    $("#eventev").click(function(){
       // $("#loca").css("display", "block");
       $("#selectedcalen").text('Event');
    });
});
</script>

<script>
$(document).ready(function(){
    $("#eventreminder").click(function(){
     //   $("#loca").css("display", "none");
              $("#selectedcalen").text('Reminder');

    });
     $("#eventtd").click(function(){
        //$("#loca").css("display", "none");
                     $("#selectedcalen").text('ToDo');

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
						$frnds = "SELECT * FROM calendar WHERE `user_id` ='".$_SESSION['Auth']['User']['id']."' and  STR_TO_DATE(`from_date`,'%Y-%m-%d')  <= '".$currentDate."' AND STR_TO_DATE(`to_date`,'%Y-%m-%d')  >= '".$currentDate."'";
						//pr($frnds);
						$onlines = $conn->execute($frnds);	
						$onlines = $onlines ->fetchAll('assoc');
						$eventNum = count($onlines);
	
 $eventapplicationdata = array();
foreach($onlines as $eventcheck){
   
    if (in_array($eventcheck['type'],$eventapplicationdata))
		{
		    //$removealertsid= $this->request->data['data'];
		}
		else
		{
		    array_push($eventapplicationdata, $eventcheck['type']);

		}
}
//pr($eventapplicationdata);



					if($eventNum > 0){
						  if(count($eventapplicationdata)==1){
   if(in_array("EV", $eventapplicationdata)){
							echo '<li date="'.$currentDate.'" class="grey date_cell">';
						    }else if(in_array("RE", $eventapplicationdata )){
						    echo '<li date="'.$currentDate.'" class="Remindercheck date_cell" style="background-color: #e12e68;">';
						    
						    }else if(in_array("TD", $eventapplicationdata )){
						        echo '<li date="'.$currentDate.'" class="light_sky date_cell">';
						    }
}else if(count($eventapplicationdata)==2){
                            if(in_array("EV", $eventapplicationdata) && in_array('RE', $eventapplicationdata)){
						        echo '<li date="'.$currentDate.'" class="eventreminder date_cell">';
						        
						    }else if(in_array("EV", $eventapplicationdata) && in_array('TD', $eventapplicationdata)){
						        echo '<li date="'.$currentDate.'" class="todoevent date_cell">';
						        
						    }else if(in_array("TD", $eventapplicationdata) && in_array('RE', $eventapplicationdata)){
						        echo '<li date="'.$currentDate.'" class="todoreminder date_cell">';
						    }
                            }else if(count($eventapplicationdata)==3){
                              echo '<li date="'.$currentDate.'" class="tripleevent date_cell">';
                            }
						}else if(strtotime($currentDate) == strtotime(date("Y-m-d"))){
							echo '<li date="'.$currentDate.'" class="curdata date_cell" style="color:red; background-color: #22ae81;">';
						}else{
							echo '<li date="'.$currentDate.'" class="date_cell">';
						}
						//Date cell
						echo '<span>';
						echo $dayCount;
						echo '</span>';
					
				//event
					$frnds = "SELECT * FROM calendar WHERE `user_id` ='".$_SESSION['Auth']['User']['id']."' and  STR_TO_DATE(`from_date`,'%Y-%m-%d')  <= '".$currentDate."' AND STR_TO_DATE(`to_date`,'%Y-%m-%d')  >= '".$currentDate."' ";
					$conneventcheck = ConnectionManager::get('default');
						$evencheck = "
select ( select count(*)from calendar where Type = 'EV' AND `user_id` ='".$_SESSION['Auth']['User']['id']."' and  STR_TO_DATE(`from_date`,'%Y-%m-%d')  <= '".$currentDate."' AND STR_TO_DATE(`to_date`,'%Y-%m-%d')  >= '".$currentDate."' ) as eventcount, ( select count(*)from calendar where Type = 'TD' AND `user_id` ='".$_SESSION['Auth']['User']['id']."' and  STR_TO_DATE(`from_date`,'%Y-%m-%d')  <= '".$currentDate."' AND STR_TO_DATE(`to_date`,'%Y-%m-%d')  >= '".$currentDate."'  ) as todocount , ( select count(*)from calendar where Type = 'RE' AND `user_id` ='".$_SESSION['Auth']['User']['id']."' and  STR_TO_DATE(`from_date`,'%Y-%m-%d')  <= '".$currentDate."' AND STR_TO_DATE(`to_date`,'%Y-%m-%d')  >= '".$currentDate."'  ) as remindercount ";

						$eventcheckcount = $conneventcheck->execute($evencheck);
						$onlineseventcount = $eventcheckcount ->fetchAll('assoc');
		
					//   pr($onlineseventcount);
						echo '<div id="date_popup_'.$currentDate.'" class="date_popup_wrap none">';
						echo '<div class="date_window">'; 	?>
					<div class="popup_event"><a data-toggle="modal" class="calevent" href="<?php echo SITE_URL?>/calendar/calendardataevent/<?php echo $currentDate; ?>/VA"><span class="popupspan">View All</span><strong>(<?php echo $eventNum; ?>)</strong></a></div>	
					<div class="popup_event"><a data-toggle="modal" class="calevent" style="text-align:left !important; " href="<?php echo SITE_URL?>/calendar/calendardataevent/<?php echo $currentDate; ?>/EV"> <span class="popupspan">Event</span> <strong>(<?php  echo $onlineseventcount[0]['eventcount']; ?>)</strong></a></div>
					<div class="popup_event"><a data-toggle="modal" class="calevent" style="text-align:left !important;" href="<?php echo SITE_URL?>/calendar/calendardataevent/<?php echo $currentDate; ?>/RE"> <span class="popupspan">Reminder</span> <strong>(<?php  echo $onlineseventcount[0]['remindercount']; ?>)</strong> </a></div>
					<div class="popup_event"><a data-toggle="modal" class="calevent" style="text-align:left !important;" href="<?php echo SITE_URL?>/calendar/calendardataevent/<?php echo $currentDate; ?>/TD"> <span class="popupspan">To Do</span> <strong>(<?php  echo $onlineseventcount[0]['todocount']; ?>)</strong></a></div>
							<?php 
						//echo ($eventNum > 0)?'<a href="javascript:;" onclick="get_events_information(\''.$currentDate.'\');">View Events</a><br/>':'';
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

	
	</script>
 
		
<script>
 $('.calevent').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});
</script>
  <div id="myModal" class="modal fade">
   <div class="modal-dialog">
   
      <div class="modal-content" style="width: 141%;" >
     
         <div class="modal-body"></div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->

</div>
<!-- /.modal -->

<div id="addcal" class="modal fade">
 <div class="modal-dialog">

  <div class="modal-content" style="width: 124%;" >
 
   <div class="modal-body" id="skillsetsearch"></div>
 </div>
 <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

</div>
<!-- /.modal -->

<div id="calinform" class="modal fade">
 <div class="modal-dialog">

  <div class="modal-content" style="width: 124%;" >
 
   <div class="modal-body" id="skillsetsearch"></div>
 </div>
 <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

</div>
<!-- /.modal -->


</div>
<script>
 $('.skill').click(function(e){
  e.preventDefault();
  $('#addcal').modal('show').find('.modal-body').load($(this).attr('href'));
});
</script>

  <!-------------------------------------------------->