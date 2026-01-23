
 
 <?php if(count($messages) > 0){ 
   $i=0; foreach($messages as $messages_data){ 
    ?>
    <?php if($messages_data['from_id']!=$this->request->session()->read('Auth.User.id')){  ?>
     <div class="col-sm-12">
    <div class="inbox-row box leftcontent" id="row_<?php echo $messages_data['id']; ?>">
    <div class="row">
    <div class="col-sm-2 msgbox"><p style="width:80px; text-align:center;"><strong><?php echo $messages_data['from_name']; ?></strong></p> <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $messages_data['from_image']; ?>" class=" img-circle pull-right"></div>
    <div class="col-sm-8 msgbox" title="<?php echo date("d M Y h:i a",strtotime($messages_data['created'])); ?>"><p><?php echo $messages_data['description']; ?>
    <i class="fa fa-caret-left" aria-hidden="true"></i>
    </p>
    <br>
    </div>
    <div class="col-sm-2"></div> 
    </div>
    </div>
    </div>
    <?php }else{?>
    <div class="col-sm-12">
    <div class="inbox-row box rightcontent" id="row_<?php echo $messages_data['id']; ?>">
  <!--<div class="col-sm-1 msgbox"><p class="pull-right">Me</p></div>-->
    <div class="row">
    <div class="col-sm-2 msgbox"><img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $messages_data['from_image']; ?>" class=" img-circle pull-left"><p style="width:80px; text-align:center;">&nbsp;&nbsp;<strong>You</strong></p></div>
    <div class="col-sm-8 msgbox " title="<?php echo date("d M Y h:i a",strtotime($messages_data['created'])); ?>"><?php if($i==0){ ?><p><?php echo $messages_data['description']; ?>    
    </p> <?php } else{ ?> <?php echo $messages_data['description']; ?><?php } ?>
    <br>
        <i class="fa fa-caret-right" aria-hidden="true"></i>
    </div>
    <div class="col-sm-2"></div>
    </div>
    </div>
    </div>
    <?php }?>
    <?php 
    $messages_id = $messages_data['id'];
   $i++; }
}else{     ?>
    No Message available
    <?php } ?>

