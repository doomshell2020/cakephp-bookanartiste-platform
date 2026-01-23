<style>
	.container{
		position: relative;
	}
</style>
<!-- <div class="container">
<span id="message" style= "display: none; color: green"> Report Spam Sent Successfully...</span>
<span id="wrongmessage" style= "display: none; color: red"> Report Spam Not Sent...</span>

<?php echo $this->Form->create('',array('url' => ['controller' => 'profile', 'action' => 'reportspam'],'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'submit-form','autocomplete'=>'off')); ?>
<?php $reportoption = array('Pornography'=>'Pornography','Offensive Behaviour'=>'Offensive Behaviour','Fake Profile'=>'Fake Profile','Terms and Conditions Violation'=>'Terms and Conditions Violation','Spam'=>'Spam','Wrong Information displayed'=>'Wrong Information displayed','Public Display of Contact Information'=>'Public Display of Contact Information'); ?>

	<?php echo $this->Form->input('reportoption',array('class'=>'form-control','placeholder'=>'Country','maxlength'=>'25','required'=>true,'label' =>false,'type'=>'radio','options'=>$reportoption)); ?>

<?php echo $this->Form->input('description',array('class'=>'form-control','placeholder'=>'description','maxlength'=>'25','type'=>'textarea','required','label' =>false)); ?>
<?php 
echo $this->Form->input('type',array('class'=>'form-control','type'=>'hidden','label' =>false,'value'=>'profile')); ?>
<?php 
echo $this->Form->input('profile_id',array('class'=>'form-control','type'=>'hidden','label' =>false,'value'=>$profile_id)); ?>
<div class="text-right m-top-20"><button class="btn btn-default" id="bn_subscribereport">Submit</button></div>
<?php echo $this->Form->end(); ?>
</div> -->
<style>
    .container {
        position: relative;
    }

    /* Checkbox and radio inputs */
    .container .checkbox input[type="checkbox"],
    .container .checkbox-inline input[type="checkbox"],
    .container .radio input[type="radio"],
    .container .radio-inline input[type="radio"] 
	{
        position: relative ;
		margin-left: auto;
		height: 34px;
   
       
        /* Add any other styles you need */
    }

    /* Text and textarea inputs */
    .container input[type="text"],
    .container textarea {
        position: static;
        /* Add any other styles you need */
    }
</style>

<div class="container">
    <span id="message" style="display: none; color: green"> Report Spam Sent Successfully...</span>
    <span id="wrongmessage" style="display: none; color: red"> Report Spam Not Sent...</span>

    <?php echo $this->Form->create('', array('url' => ['controller' => 'profile', 'action' => 'reportspam'], 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'submit-form', 'autocomplete' => 'off')); ?>
    <?php $reportoption = array('Pornography' => 'Pornography', 'Offensive Behaviour' => 'Offensive Behaviour', 'Fake Profile' => 'Fake Profile', 'Terms and Conditions Violation' => 'Terms and Conditions Violation', 'Spam' => 'Spam', 'Wrong Information displayed' => 'Wrong Information displayed', 'Public Display of Contact Information' => 'Public Display of Contact Information'); ?>

    <?php echo $this->Form->input('reportoption', array('class' => 'form-control', 'placeholder' => 'Country', 'maxlength' => '25', 'required' => true, 'label' => false, 'type' => 'radio', 'options' => $reportoption)); ?>

    <?php echo $this->Form->input('description', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'type' => 'textarea', 'required', 'label' => false)); ?>
    <?php echo $this->Form->input('type', array('class' => 'form-control', 'type' => 'hidden', 'label' => false, 'value' => 'profile')); ?>
    <?php echo $this->Form->input('profile_id', array('class' => 'form-control', 'type' => 'hidden', 'label' => false, 'value' => $profile_id)); ?>
    <div class="text-right m-top-20" style="text-align: center;"><button class="btn btn-default" id="bn_subscribereport">Submit</button></div>
    <?php echo $this->Form->end(); ?>
</div>


<script type="text/javascript">
$(document).ready(function(){
    $('#imagegallery').lightGallery();
});
</script>

<script type="text/javascript">
/*  Report spam for profile*/
$('#bn_subscribereport').click(function() { alert(); 
    $.ajax({
	type: "POST",
	url: '<?php echo SITE_URL;?>/profile/reportspam',
	data: $('#submit-form').serialize(),
	cache:false,
	success:function(data){ 
	    obj = JSON.parse(data);
	    if(obj.status!=1)
	    {
		$('#reportuser').modal('toggle');
		showerror(obj.error);
	    }
	    else
	    {
		$('#reportuser').modal('toggle');
		success = "You have been reported for this user Successfully.";
		showerror(success);
	    }
	}
    });
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