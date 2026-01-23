<?php

if(count($quote_req) > 0 || count($booking_req) > 0)
{?>
 <ul>   
<?php 
if(count($quote_req) > 0){
foreach($quote_req as $quote_req_data)  {
?>
     <li><a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $quote_req_data->requirement->id; ?>">You have received Quote request for job "<?php echo $quote_req_data->requirement->title; ?>"</a></li>
<?php } 
}?>    


<?php 
if(count($booking_req) > 0){
foreach($booking_req as $booking_req_data)  {
?>
     <li><a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $booking_req_data->requirement->id; ?>">You have received Booking request for job "<?php echo $booking_req_data->requirement->title; ?>"</a></li>
<?php }
}
?> 

 <li><a href="">View all Alerts</a></li>

 </ul> 
<?php   
}else{
?>
No New Alerts available
<?php 
}
?>


          