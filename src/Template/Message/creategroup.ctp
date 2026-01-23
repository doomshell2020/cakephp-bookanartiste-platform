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
          
    <div class="col-sm-8">
        <div class="input text required">
            <label>Group Name </label>
        <input type="text" name="to" class="form-control" placeholder="Enter Group Name" id="asearch-box" required="required" value=""></div>
    </div>


   <div class="col-sm-8">
        <div class="input text required">
            <label>Add Group Member's </label>
        <input type="text" name="to" class="form-control" placeholder="Enter Group Name" id="asearch-box" required="required" value=""></div>
    </div>
<div class="col-sm-8">
    <input type="submit" value="Create Group"  class="btn btn-default"/>

       </div>
<?php echo $this->Form->end(); ?>
              
            </div>
          </div>  
          </div>
        </div>
      </div>
</div>
  </section>
  
 

  <script type="text/javascript">
    
 $(document).ready(function(){
  $("#asearch-box").keyup(function(){
      $.ajax({
      type: "POST",
      url: "<?php echo SITE_URL; ?>/message/fetchcontacts",
      data:'keyword='+$(this).val(),
      beforeSend: function(){
        $("#asearch-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
      },
      success: function(data){
        $("#suggesstion-box").show();
        $("#suggesstion-box").html(data);
        $("#search-box").css("background","#FFF");
      }
      });
  });
    });

  </script>