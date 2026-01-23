<?php foreach ($pgallerydetail as $key=>$iteam){ ?>
<div style="display:inline-block; position:relative;">
				<? $roimg=SITE_URL.'images/thumbimage/'.$iteam['img'];
				echo "<br> &nbsp;";
				echo $this->Html->image($roimg,array('height'=>70,'width'=>70));?>
				<br>
				<a href="javascript:void(0);" class="close" id="phto<?php echo $iteam['id'] ?>" style="position:absolute; right: 0px; top: 9px; color:red;opacity: 30;">&times;</a>
				</div>	

      <script>
			$('#phto<?php echo $iteam['id'] ?>').click(function() { 
  var delid =<?php echo $iteam['id'] ?>;
  var product_id =<?php echo $pro_id ?>;

   $.ajax({ 
        type: 'POST', 
        url: '<?php echo ADMIN_URL;?>products/deletegallery',
          data: {'delid':delid,'product_id':product_id},
        success: function(data){  
  $('#update').html(data);
        }, 
        
    }); 
});	
				
		</script>	
      <?php } ?>
