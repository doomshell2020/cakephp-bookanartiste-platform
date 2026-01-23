<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>
<link rel="stylesheet" href="http://cdn.jsdelivr.net/emojione/1.5.0/assets/css/emojione.min.css" />
<script src="http://cdn.jsdelivr.net/emojione/1.5.0/lib/js/emojione.min.js"></script>
<script src="<?php echo SITE_URL; ?>/tam-emoji/js/config.js"></script>
<script src="<?php echo SITE_URL; ?>/tam-emoji/js/tam-emoji.js"></script>
<link href="<?php echo SITE_URL; ?>/tam-emoji/css/emoji.css" rel="stylesheet">
<script>
    $(document).ready(function () {
//      document.emojiType = 'unicode'; // default: image
        document.emojiSource = '<?php echo SITE_URL; ?>/tam-emoji/img/';
        $("#description").summernote({
            height: 200,
	    codemirror: {
		"theme": "ambiance"
	    },
            toolbar: [
                ['insert', ['emoji']],
               // ['tool', ['undo', 'redo']],
		['style', ['bold', 'italic', 'underline', 'clear']],
		//['font', ['strikethrough', 'superscript', 'subscript']],
		['fontsize', ['fontsize']],
		['color', ['color']],
		['para', ['paragraph']],
            ]
        });
        
        
	$('#description').on('summernote.enter', function() {
		var enter_send = $('#enter_send:checkbox:checked').length;
		if (enter_send > 0) {
		$("#folder_form").submit();  
		    //document.getElementById("txtArea").value = document.getElementById("txtArea").value + "\n*";
		    $('#description').summernote('reset');
		    return false;
		}
	});
    });
</script>

  <section id="page_Messaging">
    <div class="container">
      <h2><span>Messaging</span></h2>
    </div>
<div class="mess-box-container">
      <div class="container">
        <div class="row profile-bg m-top-20">
        <h4 class="text-center"><?php echo $messages[0]['subject']; ?></h4>
           <?php echo  $this->element('messaginmenuleft') ?>
          <div class="col-sm-9">
          <div class="row">
            <div class="messaging-cntnt-box">
             <div class="msz-inbox" id="message_box">
             </div>
             <?php echo $this->Form->create($messagess,array('url' => array('controller' => 'message', 'action' => 'reply'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'folder_form','autocomplete'=>'off')); ?>
    <div class="col-sm-12">
	<input type="hidden" name="message_id" id="message_id" value="<?php echo $messages_id; ?>">
	<input type="hidden" name="parent_id" id="parent_id" value="<?php echo ($messages[0]['parent_id'])?$messages[0]['parent_id']:$messages[0]['id']; ?>">
	<input type="hidden" name="thread_id" id="thread_id" value="<?php echo ($messages[0]['thread_id'])?$messages[0]['thread_id']:$messages[0]['id']; ?>">
	<?php echo $this->Form->input('description',array('class'=>'form-control','placeholder'=>'Description','id'=>'description','required'=>true,'label' =>false,'type'=>'textarea','rows'=>'20', "onkeypress"=>"onTestChange();")); ?>
    </div>
    <div class="col-sm-12">
    <input type="hidden" name="enter_send" value="0">
    Send Message on Enter <input type="checkbox" name="enter_send" id="enter_send" value="1" <?php if($this->request->session()->read('enter_send')>0){ ?> checked="checked"  <?php   }?>>
    <br>

	<button type="submit" class="btn btn-default">Send</button>
    </div>
<?php echo $this->Form->end(); ?>
              
            </div>
          </div>  
          </div>
        </div>
      </div>
</div>
  </section>
  
  <script>
  
  $(document).ready(function () {
  $("#folder_form").bind("submit", function (event) {
    $.ajax({
      async:true,
      data:$("#folder_form").serialize(),
      dataType:"html", 

      success:function (data, textStatus) {
	//$("#description").val("");
	refreshmessage();
        }, 
        type:"POST", 
        url:"<?php echo SITE_URL ;?>/message/groupreply"});
    return false;
  });
});

// Detect enter key
    function onTestChange() { // alert('1');
	var key = window.event.keyCode;
	// If the user has pressed enter
	var enter_send = $('#enter_send:checkbox:checked').length;
	if (key === 13 && enter_send > 0) {
	  $("#folder_form").submit();  
	    //document.getElementById("txtArea").value = document.getElementById("txtArea").value + "\n*";
	return false;
	}
	else {
	return true;
	}
    }


  
  function refreshmessage()
  {
       message_id = '<?php echo $this->request->params['pass'][0]; ?>';
      $.ajax({
	    type: "POST",
	    url: '<?php echo SITE_URL;?>/message/messageboxgroup',
	    data: {message_id: message_id},
	    cache:false,
	    success:function(data){ 
		$("#message_box").html(data);
	    }
	});
  }
  
  refreshmessage();

  setInterval(function(){ refreshmessage(); }, 3000);

  
  </script>