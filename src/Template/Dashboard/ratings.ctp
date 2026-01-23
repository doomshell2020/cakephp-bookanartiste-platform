<!----------------------editprofile-strt----------------------->
 <section id="page_signup">
 <div class="container">
 <div class="visitor_dash">
 <div class="row">

 <div class="signup-popup">
 <h2>My<span> Ratings</span></h2>
     <?php echo $this->Flash->render(); ?>     
<div class="clearfix">
</div><br>
 <div class="col-sm-12">
<div id="ratings" style="height: 300px; width: 100%;"></div>
</div>
 </div>
 
 </div>
 </div>
 </div>
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
 
 
 

?>

<script>
window.onload = function () { 
var ratings = new CanvasJS.Chart("ratings", {
	animationEnabled: true,
	title:{
		text: "Ratings",
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
		title: "Average Ratings",
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
		legendText: "Rating",
		dataPoints: <?php echo $jobpost_data1; ?>
	    },
	    
	
	]
});
ratings.render();
}
</script>
 
<script src="<?php echo SITE_URL; ?>/js/admin/canvasjs.min.js"></script>

