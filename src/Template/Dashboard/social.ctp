<!----------------------editprofile-strt----------------------->
 <section id="page_signup">
 <div class="container">
 <div class="visitor_dash">
 <div class="row">
 
 
 <div class="signup-popup">
 <h2>Profile<span> Social</span></h2>
     <?php echo $this->Flash->render(); ?>     
<div class="clearfix">

</div><br>
<div class="col-sm-12">
<div id="dailyvisitor" style="height: 300px; width: 100%;"></div>
</div>
<div class="col-sm-12">
<div id="talentwise" style="height: 300px; width: 100%;"></div>
</div>

<div class="col-sm-12">
<div id="likes" style="height: 300px; width: 100%;"></div>
</div>

<div class="col-sm-12">
<div id="shares" style="height: 300px; width: 100%;"></div>
</div>

<div class="col-sm-12">
<div class="row">
<div class="col-sm-6"><div id="connections_country" style="height: 300px; width: 100%;"></div></div>
<div class="col-sm-6"><div id="connections_city" style="height: 300px; width: 100%;"></div></div>
<div class="col-sm-6"><div id="connections_talentwise_sent" style="height: 300px; width: 100%;"></div></div>
<div class="col-sm-6"><div id="connections_talentwise_received" style="height: 300px; width: 100%;"></div></div>
</div>
</div>
<div class="col-sm-12">
<div id="messages_distrubution" style="height: 300px; width: 100%;"></div>
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
 
    $messages = '';
    for($d=1;$d<=$todayd;$d++){
	$messages['received'][$d] = rand('200','600');
	$messages['sent'][$d] = rand('200','600');
	$messages['total'][$d] = $messages['received'][$d]+$messages['sent'][$d];
    }
 
 $month_arr = array('Jan','Feb','March','April','May','June','Jul','Aug','Sep','Oct','Nov','Dec');
 
 // Likes 
 foreach($month_arr as $key=>$month)
 {
    // Audio
    $alikes['label'] = $month;
    $alikes['y'] = rand('200','600');
    $alikes_data[] = $alikes;
    
    //Video
    $vlikes['label'] = $month;
    $vlikes['y'] = rand('200','600');
    $vlikes_data[] = $vlikes;

    //Profile
    $plikes['label'] = $month;
    $plikes['y'] = rand('200','600');
    $plikes_data[] = $plikes;

    //Photos
    $phlikes['label'] = $month;
    $phlikes['y'] = rand('200','600');
    $phlikes_data[] = $phlikes;

    //Total
    $tlikes['label'] = $month;
    $tlikes['y'] = $alikes['y']+$vlikes['y']+$plikes['y']+$phlikes['y'];
    $tlikes_data[] = $tlikes;
 }

 $alikes_data = json_encode($alikes_data);
 $vlikes_data = json_encode($vlikes_data);
 $plikes_data = json_encode($plikes_data);
 $phlikes_data = json_encode($phlikes_data);
 $tlikes_data = json_encode($tlikes_data);
 
 // Likes End
 
 // Shares Start 
 foreach($month_arr as $key=>$month)
 {
    // Audio
    $ashare['label'] = $month;
    $ashare['y'] = rand('200','600');
    $ashare_data[] = $ashare;
    
    //Video
    $vshare['label'] = $month;
    $vshare['y'] = rand('200','600');
    $vshare_data[] = $vshare;

    //Profile
    $pshare['label'] = $month;
    $pshare['y'] = rand('200','600');
    $pshare_data[] = $pshare;

    //Photos
    $phshare['label'] = $month;
    $phshare['y'] = rand('200','600');
    $phshare_data[] = $phshare;

    //Total
    $tshare['label'] = $month;
    $tshare['y'] = $ashare['y']+$vshare['y']+$pshare['y']+$phshare['y'];
    $tshare_data[] = $tshare;
 }

 $ashare_data = json_encode($ashare_data);
 $vshare_data = json_encode($vshare_data);
 $pshare_data = json_encode($pshare_data);
 $phshare_data = json_encode($phshare_data);
 $tshare_data = json_encode($tshare_data);
 // Shares End
 
  // Messages Start 
 foreach($month_arr as $key=>$month)
 {
    // Message Received
    $rmessage['label'] = $month;
    $rmessage['y'] = rand('200','600');
    $rmessage_data[] = $rmessage;
    
    //Message Sent
    $smessage['label'] = $month;
    $smessage['y'] = rand('200','600');
    $smessage_data[] = $smessage;

    //Total
    $tmessages['label'] = $month;
    $tmessages['y'] = $rmessage['y']+$smessage['y'];
    $tmessage_data[] = $tmessages;
 }

$rmessage_data = json_encode($rmessage_data);
$smessage_data = json_encode($smessage_data);
$tmessage_data = json_encode($tmessage_data);
 // Messages End
 
 
?>

<script>
window.onload = function () { 
// Daily Visitor Graph Start
var chart = new CanvasJS.Chart("dailyvisitor", {
	title: {
		text: "Contacts",
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
	axisY2: {
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
			    { x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo rand('200','600'); ?> },
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
			    { x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo rand('200','600'); ?> },
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
			    { x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo rand('200','600'); ?> },
			    <?php } ?>
			    
		    ]
		},
	]
});
chart.render();
// Daily Visitor Graph end

var talentwise = new CanvasJS.Chart("talentwise", {
	animationEnabled: true,
	title:{
		text: "Talent wise Distribution of Contacts",
		fontColor: "#000",
		fontSize: 14,
		padding: 10,
		fontWeight: "400",
		horizontalAlign: "center",
	},
	
	axisX: {
		 interval: 1,
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



// Monthly Social (Likes) Start
var likes = new CanvasJS.Chart("likes", {

animationEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Likes",
		fontColor: "#000",
		fontSize: 14,
		padding: 10,
		fontWeight: "400",
		horizontalAlign: "center",
	},
	axisX: {
		title: "Month",
		interval: 1,
	},
	axisY: {
		title: "Likes"
	},
	data: [
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Total",
		dataPoints: <?php echo $tlikes_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Audio",
		dataPoints: <?php echo $alikes_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Video",
		dataPoints: <?php echo $vlikes_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Photographs",
		dataPoints: <?php echo $phlikes_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Profile",
		dataPoints: <?php echo $plikes_data; ?>
	    }
	]
	
	
});

likes.render();
// Monthly Social (Likes) End


// Monthly Social (Shares) Start
var shares = new CanvasJS.Chart("shares", {

	animationEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Shares",
		fontColor: "#000",
		fontSize: 14,
		padding: 10,
		fontWeight: "400",
		horizontalAlign: "center",
	},
	axisX: {
		title: "Month",
		interval: 1,
	},
	axisY: {
		title: "Shares"
	},
	data: [
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Total",
		dataPoints: <?php echo $tshare_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Audio",
		dataPoints: <?php echo $ashare_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Video",
		dataPoints: <?php echo $vshare_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Photographs",
		dataPoints: <?php echo $phshare_data; ?>
	    },
	    {        
		type: "line",  
		showInLegend: true, 
		legendMarkerColor: "grey",
		legendText: "Profile",
		dataPoints: <?php echo $pshare_data; ?>
	    }
	]
	
	
});

shares.render();
// Monthly Social (Shared) End

// Connection Distribution start Country wise

var connections_country = new CanvasJS.Chart("connections_country", {
	animationEnabled: true,
	title: {
		text: "Country wise Distribution",
		fontColor: "#000",
		fontSize: 14,
		padding: 10,
		fontWeight: "400",
		horizontalAlign: "center",
	},
	data: [{
		type: "pie",
		startAngle: 240,
		yValueFormatString: "##0.00\"%\"",
		indexLabel: "{label} {y}",
		dataPoints: [
			{y: 40, label: "Own Country"},
			{y: 20, label: "Other Top 5 Countries"},
			{y: 40, label: "Other Countries"},
		]
	}]
});
connections_country.render();

// Connection Distribution end Country wise

// Connection Distribution start City Wise

var connections_city = new CanvasJS.Chart("connections_city", {
	animationEnabled: true,
	title: {
		text: "City wise Distribution",
		fontColor: "#000",
		fontSize: 14,
		padding: 10,
		fontWeight: "400",
		horizontalAlign: "center",
	},
	data: [{
		type: "pie",
		startAngle: 240,
		yValueFormatString: "##0.00\"%\"",
		indexLabel: "{label} {y}",
		dataPoints: [
			{y: 40, label: "Own City"},
			{y: 20, label: "Other Top 5 City"},
			{y: 40, label: "Other City"},
		]
	}]
});
connections_city.render();

// Connection Distribution end City Wise

// Connection Distribution start

var connections_talentwise_received = new CanvasJS.Chart("connections_talentwise_received", {
	animationEnabled: true,
	title: {
		text: "Talent type wise Contact Request Received",
		fontColor: "#000",
		fontSize: 14,
		padding: 10,
		fontWeight: "400",
		horizontalAlign: "center",
	},
	data: [{
		type: "pie",
		startAngle: 240,
		yValueFormatString: "##0.00\"%\"",
		indexLabel: "{label} {y}",
		dataPoints: [
			{y: 40, label: "Skill- 1"},
			{y: 20, label: "Skill- 2"},
			{y: 40, label: "Skill- 3"},
		]
	}]
});
connections_talentwise_received.render();

// Connection Distribution end

// Connection Distribution start

var connections_talentwise_sent = new CanvasJS.Chart("connections_talentwise_sent", {
	animationEnabled: true,
	title: {
		text: "Talent type wise Contact Request Sent",
		fontColor: "#000",
		fontSize: 14,
		padding: 10,
		fontWeight: "400",
		horizontalAlign: "center",
	},
	data: [{
		type: "pie",
		startAngle: 240,
		yValueFormatString: "##0.00\"%\"",
		indexLabel: "{label} {y}",
		dataPoints: [
			{y: 40, label: "Skill- 1"},
			{y: 20, label: "Skill- 2"},
			{y: 40, label: "Skill- 3"},
		]
	}]
});
connections_talentwise_sent.render();
// Connection Distribution end





// Monthly Messages Start
var messages_distrubution = new CanvasJS.Chart("messages_distrubution", {

	animationEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Messaging",
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
		title: "Messages"
	},
	data: [
	    {
		type:"line",
		axisYType: "primary",
		name: "Total Messages",
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
		name: "Number of No Contacts whom Messages Received",
		showInLegend: true,
		markerSize: 0,
    
		//yValueFormatString: "$#,###k",
		dataPoints: [		
			<?php for($d=1;$d<=$todayd;$d++){  ?>
			{ x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $messages['received'][$d]; ?> },
			<?php } ?>
		]
	    },
	    {
		type:"line",
		axisYType: "primary",
		name: "Number of No Contacts to whom message sent",
		showInLegend: true,
		markerSize: 0,
		//yValueFormatString: "$#,###k",
		dataPoints: [		
			<?php for($d=1;$d<=$todayd;$d++){  ?>
			{ x: new Date(<?php echo $todayy; ?>, <?php echo $todaym; ?>, <?php echo $d; ?>), y: <?php echo $messages['sent'][$d]; ?> },
			<?php } ?>
		]
	    },
	]
});

messages_distrubution.render();
// Monthly Messages End

}
</script>
 
<script src="<?php echo SITE_URL; ?>/js/admin/canvasjs.min.js"></script>

