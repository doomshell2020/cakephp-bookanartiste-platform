<?php if (count($messages) > 0) { ?>
     <ul class="message_notification">
          <?php foreach ($messages as $messages_data) { ?>
               <li class="notification-item">
                    <a href="<?php echo SITE_URL; ?>/message/view/<?php echo $messages_data['id']; ?>" class="notification-link">
                         <img
                              class="img-circle"
                              src="<?php echo !empty($messages_data->user->profile['profile_image']) ? SITE_URL . '/profileimages/' . $messages_data->user->profile['profile_image'] : SITE_URL . '/images/noimage.jpg'; ?>"
                              alt="Profile Image" />
                         <div class="message-details">
                              <strong><?php echo $messages_data->user->profile['name']; ?></strong>
                              <span>sent you a message</span>
                         </div>
                    </a>
               </li>
          <?php } ?>
     </ul>
<?php } else { ?>
     No new messages available
<?php } ?>

<a href="<?php echo SITE_URL; ?>/message/inbox/" class="view-all-messages">View all Messages</a>