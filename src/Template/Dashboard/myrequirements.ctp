<!----------------------editprofile-strt----------------------->
 <section id="page_signup">
 <div class="container">
  <div class="visitor_dash">
 <div class="row">
 
 <div class="signup-popup">
 <h2>My<span> Requirement</span></h2>
     <?php echo $this->Flash->render(); ?>     
<div class="clearfix">

</div><br>
<div class="col-sm-12">
<div id="talentwise" style="height: 300px; width: 100%;"></div>
</div>
<div class="col-sm-12">
<div id="response" style="height: 300px; width: 100%;"></div>
</div>
<div class="col-sm-12">
<div id="quote_distribution" style="height: 300px; width: 100%;"></div>
</div>
<div class="col-sm-12">
<div id="booking_distribution" style="height: 300px; width: 100%;"></div>
</div>      
 </div>
 
 
  
 </div>
  <!--<div class="visitor_dash">
 </div>-->
 </div>
 </section>
<?php 


$month_arr = array('Jan','Feb','March','April','May','June','Jul','Aug','Sep','Oct','Nov','Dec');
 
 // Job posting 
 foreach($month_arr as $key=>$month)
 {
    // Skill 1
    $jobpost1['label'] = $month;
    $jobpost1['y'] = rand('200','600');
    $jobpost_data1[] = $jobpost1;
    
    // Skill 2
    $jobpost2['label'] = $month;
    $jobpost2['y'] = rand('200','600');
    $jobpost_data2[] = $jobpost2;
    
    // Skill 3
    $jobpost3['label'] = $month;
    $jobpost3['y'] = rand('200','600');
    $jobpost_data3[] = $jobpost3;
    
 }
 
 $jobpost_data1 = json_encode($jobpost_data1);
 $jobpost_data2 = json_encode($jobpost_data2);
 $jobpost_data3 = json_encode($jobpost_data3);
 
 
 // Job Response
 foreach($month_arr as $key=>$month)
 {
    // Application Received
    $application_received['label'] = $month;
    $application_received['y'] = rand('200','600');
    $application_received_data[] = $application_received;
    
    // Ping Received
    $ping_received['label'] = $month;
    $ping_received['y'] = rand('200','600');
    $ping_received_data[] = $ping_received;
    
    // Quote Received
    $quote_received['label'] = $month;
    $quote_received['y'] = rand('200','600');
    $quote_received_data[] = $quote_received;
    
    // Totals
    $totals['label'] = $month;
    $totals['y'] = $application_received['y']+$ping_received['y']+$quote_received['y'];
    $totals_data[] = $totals;
    
 }
 
 $application_received_data = json_encode($application_received_data);
 $ping_received_data = json_encode($ping_received_data);
 $quote_received_data = json_encode($quote_received_data);
 $totals_data = json_encode($totals_data);

?>

<script>
window.onload = function () { 


var talentwise = new CanvasJS.Chart("talentwise", {
	animationEnabled: true,
	title:{
		text: "Talent wise Job Posting",
		fontColor: "#000",
		fontSize: 14,
		padding: 10,
		fontWeight: "400",
		horizontalAlign: "center",
	},
	axisX: {
		title: "Months",
		interval:1,
	},
	axisY: {
		title: "Number of Job Post",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	
	legend: {
		cursor:"pointer",
		//itemclick: toggleDataSeries
	},
	data: [
	    {        
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Skill 1",
		dataPoints: <?php echo $jobpost_data1; ?>
	    },
	    {        
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Skill 2",
		dataPoints: <?php echo $jobpost_data2; ?>
	    },
	    {        
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Skill 3",
		dataPoints: <?php echo $jobpost_data3; ?>
	    },
	
	]
});
talentwise.render();

// Job posting Responses Start
var response = new CanvasJS.Chart("response", {
	animationEnabled: true,
	title:{
		text: "Job Posting Response",
		fontColor: "#000",
		fontSize: 14,
		padding: 10,
		fontWeight: "400",
		horizontalAlign: "center",
	},
	axisX: {
		title: "Months",
		interval:1,
	},
	axisY: {
		title: "Number of Response",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	
	legend: {
		cursor:"pointer",
		//itemclick: toggleDataSeries
	},
	data: [
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Total Responses",
		dataPoints: <?php echo $totals_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Application Received",
		dataPoints: <?php echo $application_received_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Pings Received",
		dataPoints: <?php echo $ping_received_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Quotes Received",
		dataPoints: <?php echo $quote_received_data; ?>
	    },
	
	]
});
response.render();
// Job posting Responses End


// Quote Distribution Start
var quote_distribution = new CanvasJS.Chart("quote_distribution", {
	animationEnabled: true,
	title:{
		text: "Quote Distribution",
		fontColor: "#000",
		fontSize: 14,
		padding: 10,
		fontWeight: "400",
		horizontalAlign: "center",
	},
	axisX: {
		title: "Months",
		interval:1,
	},
	axisY: {
		title: "Number of Response",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	
	legend: {
		cursor:"pointer",
		//itemclick: toggleDataSeries
	},
	data: [
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Total Ask for Quote Request Sent",
		dataPoints: <?php echo $totals_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Number of Responses Received",
		dataPoints: <?php echo $application_received_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Number of No Responses",
		dataPoints: <?php echo $ping_received_data; ?>
	    },
	]
});
quote_distribution.render();
// Quote Distribution End

// Booking Distribution Start
var booking_distribution = new CanvasJS.Chart("booking_distribution", {
	animationEnabled: true,
	title:{
		text: "Booking Distribution",
		fontColor: "#000",
		fontSize: 14,
		padding: 10,
		fontWeight: "400",
		horizontalAlign: "center",
	},
	axisX: {
		title: "Months",
		interval:1,
	},
	axisY: {
		title: "Number of Response",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	
	legend: {
		cursor:"pointer",
		//itemclick: toggleDataSeries
	},
	data: [
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Total Booking Request Sent",
		dataPoints: <?php echo $totals_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Number of Total Booking Request Accepted",
		dataPoints: <?php echo $application_received_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Number of No Responses",
		dataPoints: <?php echo $ping_received_data; ?>
	    },
	]
});
booking_distribution.render();
// Booking Distribution End






}
</script>
 
<script src="<?php echo SITE_URL; ?>/js/admin/canvasjs.min.js"></script>

