
<?php //pr($this->request->data()); ?>	



<section id="job_profile" class="edit_profile">

<div class="container">
	<div class="row">

<div class="col-sm-8">
<h2>Video <span>Profile</span></h2>
	<?php echo $this->Form->create('Video',array('url' => array('controller' => 'profile', 'action' => 'gallery'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>

		
<div class="exp_detail">
<div class="multi-field-wrapper">
      <div class="multi-fields">
        <div class="multi-field">



<div class="row form-group">
<div class="product_details_container">	
	<?php if(count($videoprofile)>0)
								{ ?>
      <?php            
foreach($videoprofile as $prop){
//	pr($prop);
		?>	

      <div class="product_details">	
<div class="col-sm-5 f-style">
	<div class="row">
<div class="col-sm-6 text-left">Url</div>
</div>

<?php echo $this->Form->input('video_name', array('value'=>$prop['video_name'],'class' => 'form-control','type'=>'text','required'=>'true','label' =>false,'name'=>'data[video_name][]',)); ?>
<input type="hidden" value="<?php echo $prop['id'] ?>" name="data[hid][]"/>
</div>

<div class="col-sm-5 f-style">
		<div class="row">
<div class="col-sm-6 text-left">Caption</div>
</div>
<?php echo $this->Form->input('video_type', array('value'=>$prop['video_type'],'class' => 'form-control','type'=>'text','required'=>'true','label' =>false,'name'=>'data[video_type][]')); ?>
</div>



<div class="col-sm-2 f-style">
<button type="button" onclick="delete_detials(<?php echo $prop['id'] ?>);" class="remove-field pull-right"><i class="fa fa-times" aria-hidden="true"></i>Delete</button>
</div>
</div>

</div>
</div>

</div>
      </div>
      
<button type="button" class="btn-primary add-field pull-right">Add </button>
</div>
</div><!--exp_detail-->
  <?php             
}
		?>	
		<?php } else { ?>
			<div class="product_details">	
<div class="col-sm-5 f-style">
	<div class="row">
<div class="col-sm-6 text-left">Url</div>
</div>

<?php echo $this->Form->input('video_name', array('value'=>$prop['video_name'],'class' => 'form-control','type'=>'text','required'=>'true','label' =>false,'name'=>'data[video_name][]',)); ?>
<input type="hidden" value="<?php echo $prop['id'] ?>" name="data[hid][]"/>
</div>

<div class="col-sm-5 f-style">
		<div class="row">
<div class="col-sm-6 text-left">Caption</div>
</div>
<?php echo $this->Form->input('video_type', array('value'=>$prop['video_type'],'class' => 'form-control','type'=>'text','required'=>'true','label' =>false,'name'=>'data[video_type][]')); ?>
</div>



<div class="col-sm-2 f-style">
<button type="button" onclick="delete_detials(<?php echo $prop['id'] ?>);" class="remove-field pull-right"><i class="fa fa-times" aria-hidden="true"></i>Delete</button>
</div>
</div>

</div>
</div>

</div>
      </div>
      
<button type="button" class="btn-primary add-field pull-right">Add </button>
</div>
</div><!--exp_detail-->
			
			
			<?php } ?>
		
		
		
<input type="submit" value="Save" class="btn-primary pull-right">   
<?php echo $this->Form->end();?>   



</div><!--container-->
</div>
</div>
</section><!--edit_profile-->
<script>
		var site_url='<?php echo SITE_URL;?>/';

function delete_detials(obj){

        $.ajax({
        type: "post",
        url: site_url+'profile/deletevideo',
        data:{datadd:obj},
       
        success:function(data){ //alert('data');
				if(data==1){
			//Router::connect('/', ['controller' => 'Profile', 'action' => 'gallery']);	   
			  }
	   
	 	    }
           
        });
   }
</script>



<script>
	
    
	
	
$('.multi-field-wrapper').each(function() { //alert();
    var $wrapper = $('.product_details_container', this);
    $(".add-field", $(this)).click(function(e) {
        $('.product_details:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
    });
    $('.remove-field', $wrapper).click(function() {
        if ($('.product_details', $wrapper).length > 1)
            $(this).closest('.product_details').remove();
    });
});
	</script>
<script type="text/javascript" language="javascript">
$('form#btn').submit(function() {
   $(window).unbind('beforeunload');
});
               window.onbeforeunload = function() {
                   var Ans = confirm("Are you sure you want change page!");
                   if(Ans==true)
                       return true;
                   else
                       return false;
               };
            
    </script>



