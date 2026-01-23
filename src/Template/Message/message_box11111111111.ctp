  
             <?php if(count($messages) > 0){ 
		foreach($messages as $messages_data){  //pr($messages_data); 
             ?>
            <?php if($messages_data['from_id']!=$this->request->session()->read('Auth.User.id')){ ?>
            
            <div class="row inbox-row box leftcontent" id="row_<?php echo $messages_data['id']; ?>">
             <div class="col-sm-2"><img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $messages_data['from_image']; ?>" class=" img-circle pull-left"><p class="pull-right">aaa<a href="<?php echo SITE_URL; ?>/message/view/<?php echo $messages_data['id']; ?>"><strong><?php echo $messages_data['from_name']; ?></strong></a></p></div>
             <div class="col-sm-7"><p><a href="<?php echo SITE_URL; ?>/message/view/<?php echo $messages_data['id']; ?>"><?php echo $messages_data['description']; ?></a></p>
             <br>
             <p><?php echo date("d M Y h:i",strtotime($messages_data['created'])); ?></p>
             </div>
             </div>
            <?php }else{?>
	
            <div class="row inbox-row box rightcontent" id="row_<?php echo $messages_data['id']; ?>">
             
             <div class="col-sm-7"><p><a href="<?php echo SITE_URL; ?>/message/view/<?php echo $messages_data['id']; ?>"><?php echo $messages_data['description']; ?></a></p>
             <br>
             <p><?php echo date("d M Y h:i",strtotime($messages_data['created'])); ?></p>
             </div>
             <div class="col-sm-2"><p class="pull-right">Me</p></div>
             </div>
             <?php }?>
             <?php 
             $messages_id = $messages_data['id'];
             }
             }else{     ?>
             No Message available
             <?php } ?>
             
             