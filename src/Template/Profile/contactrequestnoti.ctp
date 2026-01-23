<?php
// pr($contatrequest); die;
if ($msg) { ?>
   <li class="row request_one" style="color: #000;">
      <ul>
         <li class="request_left col-sm-12">
            <?php echo trim($msg); ?>
         </li>
      </ul>
   </li>
<?php } else { ?>

   <?php if (count($contatrequest) > 0) {
      foreach ($contatrequest as $contact) {
   ?>

         <li class="row request_one frnd-rq">
            <ul>
               <li class="request_left1 col-sm-4">
                  <ul class="row">
                     <?php if ($contact['profile_image'] != '') { ?>
                        <li class="col-sm-4 rqst_pro_img">
                           <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $contact['id']; ?>">
                              <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $contact['profile_image']; ?>" alt="profile_image">
                        </a>
                        </li>
                     <?php } else { ?>
                        <li class="profile_img_cercle1 profile_slidedown"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $contact['id']; ?>"><img src="<?php echo SITE_URL; ?>/images/noimage.jpg" alt="profile_image"></a><span class="caret"></span></li>
                     <?php } ?>

                  </ul>
               </li>
               <li class="request_right1 col-sm-8">
                  <ul class="row">
                     <li class="col-sm-12"><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $contact['id']; ?>"><?php echo $contact['name'];  ?> </a><span style="color: black;"> has sent you a connection request</span>
                     </li>
                  </ul>
                  <ul class="row">
                     <li class="col-sm-5">
                        <a href="javascript:void(0);" class="reqcnf btn_confirm" id="cnfuser<?php echo $contact['id']; ?>" data-id="<?php echo $contact['from_id']; ?>" onclick="confirmuser(this,'<?php echo $contact['from_id']; ?>');"><span class="reqcnfyes<?php echo $contact['id'];  ?>" style="display:none;"><i class="fa fa-check" aria-hidden="true"></i>Friends</span> <span class="reqcnfno<?php echo $contact['id'];  ?>">Accept</span></a>
                     </li>
                     <li class="col-sm-7">
                        <a style="width: 65%;" href="javascript:void(0);" class="reqdel btn_delete" id="dltuser<?php echo $contact['id'];  ?>" onclick="deleteuser(this);"><span class="reqdelyes<?php echo $contact['id'];  ?>" style="display:none;">Request Rejected</span> <span class="reqdelno<?php echo $contact['id'];  ?>">Decline</span></a>

                     </li>
                  </ul>
               </li>
            </ul>
         </li>

      <?php }
   } else { ?>
      <li class="row request_one" style="color: #000;">
         <ul>
            <li class="request_left col-sm-6">
               No Request Found
            </li>
         </ul>
      </li>
<?php }
} ?>