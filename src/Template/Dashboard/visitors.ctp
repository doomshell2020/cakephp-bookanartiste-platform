<!----------------------editprofile-strt----------------------->
 <section id="page_signup">
 <div class="container">
 <div class="visitor_dash">
 <div class="row">
 <div class="col-sm-12">
 <div class="signup-popup">
 <h2>Profile<span> Visitors</span></h2>
     <?php echo $this->Flash->render(); ?>     
<div class="clearfix">

</div><br>
<div id="dailyvisitor" style="height: 300px; width: 100%;"></div>

<div id="talentwise" style="height: 300px; width: 100%;"></div>
      
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
 
 $currentweek = strtotime('this week');
 $week_start =  date("d",$currentweek);
$random = '';
for($d=1;$d<=$todayd;$d++){
    $random['talents'][$d] = rand('200','600');
    $random['nontalents'][$d] = rand('200','600');
    $random['total'][$d] = $random['talents'][$d]+$random['nontalents'][$d];
}
?>

<script>
window.onload = function () { 
// Daily Visitor Graph Start
var dailyvisitor = new CanvasJS.Chart("dailyvisitor", {
	title: {
		text: "Profile Visitors of this month",
		fontColor: "#000",
		fontSize: 18,
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
		title: "Visitors",
		//prefix: "$",
		//suffix: "K"
	},
	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		verticalAlign: "top",
		horizontalAlign: "center",
		dockInsidePlotArea: true,
		//itemclick: toogleDataSeries
	},
	data: [{
		    type:"line",
		    axisYType: "primary",
		    name: "Total Visit",
		    showInLegend: true,
		    markerSize: 0,
		    //yValueFormatString: "$#,###k",
		    dataPoints: [		
			    <?php for($d=1;$d<=$todayd;$d++){  ?>
			    { x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $random['total'][$d]; ?> },
			    <?php } ?>
		    ]
		},
		{
		    type:"line",
		    axisYType: "primary",
		    name: "Talents",
		    showInLegend: true,
		    markerSize: 0,
		    //yValueFormatString: "$#,###k",
		    dataPoints: [		
			    <?php for($d=1;$d<=$todayd;$d++){  ?>
			    { x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $random['talents'][$d]; ?> },
			    <?php } ?>
		    ]
		},
		{
		    type:"line",
		    axisYType: "primary",
		    name: "Non Talents",
		    showInLegend: true,
		    markerSize: 0,
		    //yValueFormatString: "$#,###k",
		    dataPoints: [		
			    <?php for($d=1;$d<=$todayd;$d++){  ?>
			    { x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $random['nontalents'][$d]; ?> },
			    <?php } ?>
			    
		    ]
		},
	]
});
dailyvisitor.render();
// Daily Visitor Graph end

var talentwise = new CanvasJS.Chart("talentwise", {
	animationEnabled: true,
	title:{
		text: "Weekly Talent wise Profile Visitors",
		 fontColor: "#000",
	    fontSize: 18,
	    padding: 10,
	    fontWeight: "400",
	    horizontalAlign: "center",
	},	
	axisX: {
		title: "Dates",
		interval:1,
	},
	axisY: {
		title: "Number of Visitors",
		titleFontColor: "#4F81BC",
		lineColor: "#4F81BC",
		labelFontColor: "#4F81BC",
		tickColor: "#4F81BC"
	},
	toolTip: {
		shared: true
	},
	legend: {
		cursor:"pointer",
		//itemclick: toggleDataSeries
	},
	data: [{
	    type: "column",
	    name: "Skill-1",
	    legendText: "Skill-1",
	    showInLegend: true, 
	    dataPoints:[
		   <?php for($w=1;$w<=7;$w++){ ?>
		   { label: "<?php echo $w; ?>", y: <?php echo rand('200','600'); ?> },
		   <?php }?> 
	    ]
	},
	{
	    type: "column",	
	    name: "Skill2",
	    legendText: "Skill2",
	    axisYType: "primary",
	    showInLegend: true,
	    dataPoints:[
		    <?php for($w=1;$w<=7;$w++){ ?>
		   { label: "<?php echo $w; ?>", y: <?php echo rand('200','600'); ?> },
		   <?php }?> 
	    ]
	},
	{
	    type: "column",	
	    name: "Skill2",
	    legendText: "Skill2",
	    axisYType: "primary",
	    showInLegend: true,
	    dataPoints:[
		    <?php for($w=1;$w<=7;$w++){ ?>
		   { label: "<?php echo $w; ?>", y: <?php echo rand('200','600'); ?> },
		   <?php }?> 
	    ]
	}
	]
});
talentwise.render();

}
</script>
 
<script src="<?php echo SITE_URL; ?>/js/admin/canvasjs.min.js"></script>

