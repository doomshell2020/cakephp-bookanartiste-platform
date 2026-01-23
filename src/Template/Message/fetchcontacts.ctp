<ul class="message-contacts">
    <li class="heading"><strong>Contacts</strong>
    <ul>
    <?php if(count($friends) > 0){ //pr($friends); ?>
    <?php foreach($friends as $friends_data){
	if($friends_data['user_id']!=$this->request->session()->read('Auth.User.id')){
    ?>
	    <li onClick="selectUser('<?php echo $friends_data['user_id']; ?>','<?php echo $friends_data['name'];  ?>');">
	    <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $friends_data['profile_image']; ?>" class=" img-circle pull-left">
	    <span class="message_to_name"><?php echo $friends_data['name'];  ?></span> <br><?php echo $friends_data['location'];  ?></li>
    <?php }
    }
    }else{?>
     <li>No Contacts available</li>
    <?php }?>
	    
	</ul>
    </li>

    <li class="heading"><strong>Not in Contacts</strong>
    <ul>
    <?php if(count($others) > 0){ ?>
    <?php foreach($others as $others_data){
	if($others_data['user_id']!=$this->request->session()->read('Auth.User.id')){
    ?>
	    <li onClick="selectUser('<?php echo $others_data['user_id']; ?>','<?php echo $others_data['name'];  ?>');">
	     <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $others_data['profile_image']; ?>" class=" img-circle pull-left">
	    <span class="message_to_name"><?php echo $others_data['name'];  ?></span> <br><?php echo $others_data['location'];  ?></li>
    <?php 
    }
    } 
    }else{?>
     <li>No Contacts available</li>
    <?php }?>
	    
	</ul>
    </li>
<ul>
