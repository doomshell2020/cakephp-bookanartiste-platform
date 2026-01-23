

<span id="message" style= "display: none; color: green"> Report Spam Sent Successfully...</span>
<span id="wrongmessage" style= "display: none; color: red"> Report Spam Not Sent...</span>
<?php echo $this->Form->create('',array('url' => ['controller' => 'profile', 'action' => 'reportspam'],'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'submit-formimages','autocomplete'=>'off')); ?>

<?php $reportoptionimages = array('Abusive Content'=>'Abusive Content','Pornographic Content'=>'Pornographic Content','Child Pornography'=>'Child Pornography','Violence'=>'Violence','Extremism'=>'Extremism','Spam'=>'Spam','Violation of Terms and Conditions'=>'Violation of Terms and Conditions','Others'=>'Others'); ?>


	<?php echo $this->Form->input('reportoption',array('class'=>'','id'=>'radiocheck','required'=>true,'label' =>false,'type'=>'radio','options'=>$reportoptionimages)); ?>
<?php echo $this->Form->input('description',array('class'=>'form-control','placeholder'=>'Describe Your Reasons for Reporting','maxlength'=>'25','type'=>'textarea','label' =>false)); ?>

<?php echo 
$this->Form->input('type',array('class'=>'form-control','type'=>'hidden','label' =>false,'value'=>$vitype)); ?>
<?php echo 
$this->Form->input('profile_id',array('class'=>'form-control','type'=>'hidden','label' =>false,'value'=>$imageid));  ?>
<?php echo 
$this->Form->input('user_id',array('class'=>'form-control','type'=>'hidden','label' =>false,'value'=>$profileid)); ?>

<div class="text-right m-top-20"><button class="btn btn-default radioclass" id="bn_subscribeimages">Submit</button></div>

<?php echo $this->Form->end(); ?>


<script type="text/javascript">
/*  Report spam for profile*/
$('#bn_subscribeimages').click(function() { //alert();

	var isChecked = $("input[name='reportoption']:checked"). val();    
	if(isChecked){
	    $.ajax({
		type: "POST",
		url: '<?php echo SITE_URL;?>/profile/reportspam',
		data: $('#submit-formimages').serialize(),
		cache:false,
		success:function(data){  //alert(data);
		    obj = JSON.parse(data);
		    if(obj.status!=1)
		    {
			$('#reportsingleimages').modal('toggle');
			showerror(obj.error);
		    }
		    else
		    {
			$('#reportsingleimages').modal('toggle');
			success = "You have been reported for this user Successfully.";
			showerror(success);
		    }
		}
	    });
	}else{
			
	}
});

function showerror(error)
{
    BootstrapDialog.alert({
	size: BootstrapDialog.SIZE_SMALL,
	title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
	message: "<h5>"+error+"</h5>"
	});
    return false;
}
</script>

