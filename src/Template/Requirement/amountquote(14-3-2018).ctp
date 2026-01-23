<?php echo $this->Form->create('',array('url' => ['controller' => 'requirement', 'action' => 'amountquote'],'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','autocomplete'=>'off')); ?>
 
 <?php //pr($revisedquote); ?>
   <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Revised Quote Amount :</label>
                  <div class="col-sm-6">
                   <?php echo $this->Form->input('revisedquote',array('class'=>'form-control','placeholder'=>'Number','required'=>true,'label' =>false,'type'=>'Number','value'=> $revisedquote['amt'])); ?>
                   <?php //pr($revisedquote); ?>
                   <input type="hidden" name="revisedid" value="<?php  echo $revisedquote['id']; ?>">
                  </div>
                  <div class="col-sm-3"></div>
                </div>
 
 <div class="form-group">
                  <div class="col-sm-12 text-center m-top-20">
					  <button class="btn btn-default" id="bn_subscribe">Submit</button>
                  </div>
                </div>
     <?php echo $this->Form->end(); ?>




<script>
/*
$('#bn_subscribesss').click(function(e) { //alert();
	e.preventDefault();
    $.ajax({
	type: "POST",
	url: '<?php echo SITE_URL;?>/requirement/amountquote',
	data: $('#submit-formdd').serialize(),
	cache:false,
	success:function(data){  //alert(data);
	    obj = JSON.parse(data);
	    if(obj.status!=1)
	    {
		//$('#reportuser').modal('toggle');
		showerror(obj.error);
	    }
	    else
	    {
		//$('#reportuser').modal('toggle');
		success = "Revised quote amount sent successfully.";
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
*/
</script>
