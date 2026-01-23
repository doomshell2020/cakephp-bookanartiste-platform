
<div class="container">
<?php  if($nontalentdetails){ ?>
  <p align="center"><img src="<?php echo SITE_URL ?>/profileimages/<?php  echo $nontalentdetails['profile_image'] ?>"/></p>   

  <table class="table table-hover">
   
    <tbody>
      <tr>
        <td>Name</td>
        <td><?php echo $nontalentdetails['name'] ?></td>
     
      </tr>

      <tr>
        <td>Email ID</td>
        <td><?php echo $talent['email']; ?></td>
     
      </tr>
      <tr>
        <td>Gender</td>
        <td><?php 

        		switch ($nontalentdetails['gender']) {
        			case 'm':
        				echo "Male";
        				break;
        			case 'f':
        				echo "Female";
        				break;
        			
        			default:
        				echo "Other";
        				break;
        		}
         ?></td>
        
      </tr>

       <tr>
        <td>Date of Birth </td>
        <td><?php echo date('m/d/Y',strtotime($nontalentdetails['dob'])); ?></td>
     
      </tr>
       <tr>
        <td>Enthicity </td>
        <td><?php echo $nontalentdetails['enthicity']['title']; ?></td>
     
      </tr>
       <tr>
        <td>Alternative Number </td>
        <td><?php echo $nontalentdetails['altnumber']; ?></td>
     
      </tr>
      <tr>
        <td> Country  </td>
        <td><?php echo $nontalentdetails['country']['name']; ?></td>
     
      </tr>
      <tr>
        <td>State </td>
        <td><?php echo $nontalentdetails['state']['name']; ?></td>
     
      </tr>
      <tr>
        <td>City</td>
        <td><?php echo $nontalentdetails['city']['name']; ?></td>
     
      </tr>
      <tr>
        <td>Location </td>
        <td><div id="myMap"></div></td>
     
      </tr>
      <tr>
        <td>Guardian Name </td>
        <td>
        	
        		<?php if($nontalentdetails['guadian_name']){ echo $nontalentdetails['guadian_name'];  }else {
        			echo "-";
        			}  ?>
        </td>
     
      </tr>
      <tr>
        <td>Guardian Email </td>
        <td><?php if($nontalentdetails['guardian_email']){ echo $nontalentdetails['guardian_email'];  }else {
        			echo "-";
        			}  ?></td>
     
      </tr>
   
    </tbody>
  </table>
  <?php } else{

    echo "No data Available";
    } ?>
</div>

 <?php
$lat=$nontalentdetails['lat'];
$long=$nontalentdetails['longs'];
?>
<script type="text/javascript">
var map;
var marker;
var myLatlng = new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $long; ?>);
var geocoder = new google.maps.Geocoder();
var infowindow = new google.maps.InfoWindow();
function initialize(){
var mapOptions = {
zoom: 14,
center: myLatlng,
mapTypeId: google.maps.MapTypeId.ROADMAP
};

map = new google.maps.Map(document.getElementById("myMap"), mapOptions);

marker = new google.maps.Marker({
map: map,
position: myLatlng,
draggable: true
});

geocoder.geocode({'latLng': myLatlng }, function(results, status) {
if (status == google.maps.GeocoderStatus.OK) {
if (results[0]) {
$('#latitude,#longitude').show();
$('#address').val(results[0].formatted_address);
$('#latitude').val(marker.getPosition().lat());
$('#longitude').val(marker.getPosition().lng());
infowindow.setContent(results[0].formatted_address);
infowindow.open(map, marker);
}
}
});

google.maps.event.addListener(marker, 'dragend', function() {

geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
if (status == google.maps.GeocoderStatus.OK) {
if (results[0]) {
$('#address').val(results[0].formatted_address);
$('#latitude').val(marker.getPosition().lat());
$('#longitude').val(marker.getPosition().lng());
infowindow.setContent(results[0].formatted_address);
infowindow.open(map, marker);
}
}
});
});

}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
