<!----------------------editprofile-strt----------------------->
 <section id="page_signup">
 <div class="container">
 <div class="visitor_dash">
 <div class="row">

 
 <div class="signup-popup">
 <h2>Work<span> Alerts</span></h2>
     <?php echo $this->Flash->render(); ?>     
<div class="clearfix">

</div><br>
<div class="col-sm-12">
<div id="requirement_summery" style="height: 300px; width: 100%;"></div>
</div>
<div class="col-sm-12">
<div id="quote_summery" style="height: 300px; width: 100%;"></div>
</div>
<div class="col-sm-12">
<div id="booking_summery" style="height: 300px; width: 100%;"></div>
</div>
 </div>

 
  
 </div>
 </div>
 </div>
 </div>
 </section>
<?php 
    $todayd = date("d");
    $todaym = date("m");
    $todayy = date("Y");
    $messages = '';
    for($d=1;$d<=$todayd;$d++){
	$messages['job_applied'][$d] = rand('200','600');
	$messages['job_pinged'][$d] = rand('200','600');
	$messages['job_sent_quote'][$d] = rand('200','600');
	$messages['total'][$d] = $messages['job_applied'][$d]+$messages['job_pinged'][$d]+$messages['job_sent_quote'][$d];
    }
 
?>

<script>
window.onload = function () { 

// Action on Taken on Requirements Start
var requirement_summery = new CanvasJS.Chart("requirement_summery", {

	animationEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Action on Taken on Requirements",
		fontColor: "#000",
		fontSize: 14,
		padding: 10,
		fontWeight: "400",
		horizontalAlign: "center",
	},
	axisX: {
		valueFormatString: "D",
		title: "Date",
		interval: 1,
		intervalType: "day",
	},
	axisY: {
		title: "Actions"
	},
	data: [
	    {
		type:"line",
		axisYType: "primary",
		name: "Total Jobs acted Upon",
		showInLegend: true,
		markerSize: 0,
		//yValueFormatString: "$#,###k",
		dataPoints: [		
			<?php for($d=1;$d<=$todayd;$d++){  ?>
			{ x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $messages['total'][$d]; ?> },
			<?php } ?>
			
		]
	    },
	    {
		type:"line",
		axisYType: "primary",
		name: "Jobs Applied to",
		showInLegend: true,
		markerSize: 0,
    
		//yValueFormatString: "$#,###k",
		dataPoints: [		
			<?php for($d=1;$d<=$todayd;$d++){  ?>
			{ x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $messages['job_applied'][$d]; ?> },
			<?php } ?>
		]
	    },
	    {
		type:"line",
		axisYType: "primary",
		name: "Jobs Pinged for",
		showInLegend: true,
		markerSize: 0,
		//yValueFormatString: "$#,###k",
		dataPoints: [		
			<?php for($d=1;$d<=$todayd;$d++){  ?>
			{ x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $messages['job_pinged'][$d]; ?> },
			<?php } ?>
		]
	    },
	    {
		type:"line",
		axisYType: "primary",
		name: "Jobs Sent Quote to",
		showInLegend: true,
		markerSize: 0,
		//yValueFormatString: "$#,###k",
		dataPoints: [		
			<?php for($d=1;$d<=$todayd;$d++){  ?>
			{ x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $messages['job_sent_quote'][$d]; ?> },
			<?php } ?>
		]
	    },
	]
});

requirement_summery.render();
// Action on Taken on Requirements Start

// Quote Summery Start
var quote_summery = new CanvasJS.Chart("quote_summery", {

	animationEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Quote Summery",
		fontColor: "#000",
		fontSize: 14,
		padding: 10,
		fontWeight: "400",
		horizontalAlign: "center",
	},
	axisX: {
		valueFormatString: "D",
		title: "Date",
		 interval: 1,
		intervalType: "day",
	},
	axisY: {
		title: "Actions"
	},
	data: [
	    {
		type:"line",
		axisYType: "primary",
		name: "Number of Quote Sent",
		showInLegend: true,
		markerSize: 0,
    
		//yValueFormatString: "$#,###k",
		dataPoints: [		
			<?php for($d=1;$d<=$todayd;$d++){  ?>
			{ x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $messages['job_applied'][$d]; ?> },
			<?php } ?>
		]
	    },
	    {
		type:"line",
		axisYType: "primary",
		name: "Number of Request for Quote Received",
		showInLegend: true,
		markerSize: 0,
		//yValueFormatString: "$#,###k",
		dataPoints: [		
			<?php for($d=1;$d<=$todayd;$d++){  ?>
			{ x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $messages['job_pinged'][$d]; ?> },
			<?php } ?>
		]
	    },
	    {
		type:"line",
		axisYType: "primary",
		name: "Number of Request Unanswered/Declined",
		showInLegend: true,
		markerSize: 0,
		//yValueFormatString: "$#,###k",
		dataPoints: [		
			<?php for($d=1;$d<=$todayd;$d++){  ?>
			{ x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $messages['job_sent_quote'][$d]; ?> },
			<?php } ?>
		]
	    },
	]
});

quote_summery.render();
// Quote Summery end

// Action on Taken on Requirements Start
var booking_summery = new CanvasJS.Chart("booking_summery", {

	animationEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Booking Summery",
		fontColor: "#000",
		fontSize: 14,
		padding: 10,
		fontWeight: "400",
		horizontalAlign: "center",
	},
	axisX: {
		valueFormatString: "D",
		title: "Date",
		 interval: 1,
		intervalType: "day",
	},
	axisY: {
		title: "Actions"
	},
	data: [
	    {
		type:"line",
		axisYType: "primary",
		name: "Number of Booking Request Received",
		showInLegend: true,
		markerSize: 0,
		//yValueFormatString: "$#,###k",
		dataPoints: [		
			<?php for($d=1;$d<=$todayd;$d++){  ?>
			{ x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $messages['total'][$d]; ?> },
			<?php } ?>
			
		]
	    },
	    {
		type:"line",
		axisYType: "primary",
		name: "Number of Booking Accepted",
		showInLegend: true,
		markerSize: 0,
    
		//yValueFormatString: "$#,###k",
		dataPoints: [		
			<?php for($d=1;$d<=$todayd;$d++){  ?>
			{ x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $messages['job_applied'][$d]; ?> },
			<?php } ?>
		]
	    },
	    {
		type:"line",
		axisYType: "primary",
		name: "Number of Booking Request Unanswered/Declined",
		showInLegend: true,
		markerSize: 0,
		//yValueFormatString: "$#,###k",
		dataPoints: [		
			<?php for($d=1;$d<=$todayd;$d++){  ?>
			{ x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $messages['job_pinged'][$d]; ?> },
			<?php } ?>
		]
	    },
	]
});

booking_summery.render();
// Action on Taken on Requirements Start

}
</script>
 
<script src="<?php echo SITE_URL; ?>/js/admin/canvasjs.min.js"></script>

