<?php if (!empty($messages)) { ?>
  <div class="chat-container" id="chat-container">
    <?php foreach ($messages as $index => $message) {
      $isSender = $message['from_id'] == $this->request->session()->read('Auth.User.id');
      $profileImage = !empty($message['from_image'])
        ? SITE_URL . '/profileimages/' . $message['from_image']
        : SITE_URL . '/images/noimage.jpg';
      $formattedDate = date("d M Y h:i a", strtotime($message['created']));
      $userLabel = $isSender ? "You" : $message['from_name'];
    ?>
      <div class="chat-message <?= $isSender ? 'sent' : 'received'; ?>">
        <?php if (!$isSender) { ?>
          <img src="<?= $profileImage; ?>" alt="Profile Image" class="profile-img">
        <?php } ?>
        <div class="message-content" title="<?= $userLabel; ?>">
          <div class="message-bubble <?= $isSender ? 'sent-bubble' : 'received-bubble'; ?>">
            <span class="message-text"><?= $message['description']; ?></span>
            <span class="message-time"><?= $formattedDate; ?></span>
          </div>
        </div>
        <?php if ($isSender) { ?>
          <img src="<?= $profileImage; ?>" alt="Profile Image" class="profile-img">
        <?php } ?>
      </div>
    <?php } ?>
  </div>
<?php } else { ?>
  <div class="no-messages text-center">
    <p>No messages available</p>
  </div>
<?php } ?>


<style>
  .chat-container {
    max-width: 855px;
    margin: auto;
    padding: 15px;
    background-color: #e5ddd5;
    border-radius: 10px;
    height: 500px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
  }

  .chat-message {
    display: flex;
    align-items: flex-end;
    margin-bottom: 10px;
  }

  .chat-message.sent {
    justify-content: flex-end;
  }

  .chat-message.received {
    justify-content: flex-start;
  }

  .profile-img {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    margin: 5px;
  }

  .message-content {
    display: flex;
    flex-direction: column;
  }

  .message-bubble {
    max-width: 76%;
    padding: 8px 12px;
    border-radius: 10px;
    font-size: 14px;
    position: relative;
    word-wrap: break-word;
  }

  .sent-bubble {
    background-color: #dcf8c6;
    align-self: flex-end;
    border-bottom-right-radius: 0;
  }

  .received-bubble {
    background-color: #ffffff;
    align-self: flex-start;
    border-bottom-left-radius: 0;
  }

  .message-time {
    font-size: 12px;
    color: #888;
    display: block;
    text-align: right;
    margin-top: 5px;
  }
</style>


<script>
  // Scroll to the bottom of the chat container when the page loads or when new messages are added
  const chatContainer = document.getElementById('chat-container');
  if (chatContainer) {
    chatContainer.scrollTop = chatContainer.scrollHeight; // Scroll to the bottom
  }
</script>



<?php /* if (count($messages) > 0) {
$i = 0;
foreach ($messages as $messages_data) {
// pr($messages_data);
// exit;
?>
<?php if ($messages_data['from_id'] != $this->request->session()->read('Auth.User.id')) {  ?>
<div class="col-sm-12">
<div class="inbox-row box leftcontent" id="row_<?php echo $messages_data['id']; ?>">
<div class="row">
<div class="col-sm-2 msgbox">
<!-- <p style="width:80px; text-align:center;"><strong><?php //echo $messages_data['from_name']; 
                                                       ?></strong></p> <img src="<?php //echo SITE_URL; 
                                                                                                                           ?>/profileimages/<?php //echo $messages_data['from_image']; 
                                                                                                                                                                   ?>" class=" img-circle pull-right"> -->

<img
 src="<?php echo !empty($messages_data['from_image'])
         ? SITE_URL . '/profileimages/' . $messages_data['from_image']
         : SITE_URL . '/path-to-placeholder-image.jpg'; ?>"
 style="width: 50px;"
 alt="Profile Image" />

</div>
<div class="col-sm-8 msgbox" title="<?php echo date("d M Y h:i a", strtotime($messages_data['created'])); ?>">
<p><?php echo $messages_data['description']; ?>
 <i class="fa fa-caret-left" aria-hidden="true"></i>
</p>
<br>
</div>
<div class="col-sm-2"></div>
</div>
</div>
</div>
<?php } else { ?>
<div class="col-sm-12">
<div class="inbox-row box rightcontent" id="row_<?php echo $messages_data['id']; ?>">
<!--<div class="col-sm-1 msgbox"><p class="pull-right">Me</p></div>-->
<div class="row">
<div class="col-sm-2 msgbox">
<img
 src="<?php echo !empty($messages_data['from_image']) ? SITE_URL . '/profileimages/' . $messages_data['from_image'] : SITE_URL . '/path-to-placeholder-image.jpg'; ?>"
 style="width: 50px;"
 alt="Profile Image"
 class=" img-circle pull-left">
<p style="width:80px; text-align:center;">&nbsp;&nbsp;<strong>You</strong></p>
</div>
<div class="col-sm-8 msgbox " title="<?php echo date("d M Y h:i a", strtotime($messages_data['created'])); ?>"><?php if ($i == 0) { ?><p><?php echo $messages_data['description']; ?>
 </p> <?php } else { ?> <?php echo $messages_data['description']; ?><?php } ?>
 <br>
 <i class="fa fa-caret-right" aria-hidden="true"></i>
</div>
<div class="col-sm-2"></div>
</div>
</div>
</div>
<?php } ?>
<?php
$messages_id = $messages_data['id'];
$i++;
}
} else {     ?>
No Message available
<?php } */ ?>