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
            height: 345,
	    codemirror: {
		"theme": "ambiance"
	    },callbacks: {
    onBlur: function() {
     savedraft(); 
    }
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
        
    });
</script>

<script src="<?php echo SITE_URL; ?>/js/typeahead.js"></script>
   
   
  <section id="page_Messaging">

<div class="mess-box-container">
      <div class="container">
      <h2><span>Messaging</span></h2>
      
        <div class="row profile-bg m-top-20">
        
           <?php echo  $this->element('messaginmenuleft') ?>
          <div class="col-sm-9">
          <h4 class="text-left">New Message</h4>
            <div class="messaging-cntnt-box">
             <div class="msz-frm">
             <?php //pr($messages); die; ?>
             
              <?php echo $this->Form->create($messagess,array('url' => array('controller' => 'message', 'action' => 'compose'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off'));
	
	
	        if($this->request->params['pass'][0]=='reply')
	    { ?>
		
		<input type="hidden" id="to_id" name="to_id" value="<?php echo ($messages['from_id'] > 0)?$messages['from_id']:'0'; ?>" />
		<input type="hidden" name="message_id" id="message_id" value="0">
		<input type="hidden" id="thread_id" name="thread_id" value="<?php echo ($messages['thread_id'] > 0)?$messages['thread_id']:'0'; ?>" />
		<?php 
	    }
	    elseif($this->request->params['pass'][0]=='forward')
	    {
		echo $this->Form->input('to',array('class'=>'form-control','placeholder'=>'To','id'=>'asearch-box','required'=>true,'label' =>false,'type'=>'text' )); ?>
		<input type="hidden" id="to_id" name="to_id" value="0" />
		<input type="hidden" name="message_id" id="message_id" value="0">
	    <?php 
	    }
	    elseif($this->request->params['pass'][0]=='draft')
	    {
		echo $this->Form->input('to',array('class'=>'form-control','placeholder'=>'To','id'=>'asearch-box','required'=>true,'label' =>false,'type'=>'text' ,'value'=>($messages)?$messages['to_name']:'')); ?>
		<input type="hidden" id="to_id" name="to_id" value="<?php echo ($messages['to_id'] > 0)?$messages['to_id']:'0'; ?>" />
		<input type="hidden" name="message_id" id="message_id" value="<?php echo ($messages['id'] > 0)?$messages['id']:'0'; ?>">
		<?php 
	    }
	    else
	    {
		echo $this->Form->input('to',array('class'=>'form-control','placeholder'=>'To','id'=>'asearch-box','required'=>true,'label' =>false,'type'=>'text' ,'value'=>($messages)?$messages['to_name']:'')); ?>
		<input type="hidden" id="to_id" name="to_id" value="<?php echo ($messages['to_id'] > 0)?$messages['to_id']:'0'; ?>" />
		<input type="hidden" name="message_id" id="message_id" value="<?php echo ($messages['id'] > 0)?$messages['id']:'0'; ?>">
		<?php 
	    }
	    ?>
	    
	    
	    <div id="suggesstion-box"></div>
            <?php 
             if($this->request->params['pass'][0]=='reply')
             { ?>
             
             
             <?php 
             }else{?>
             <?php echo $this->Form->input('subject',array('class'=>'form-control','placeholder'=>'Subject','id'=>'subject','required'=>true,'label' =>false,'type'=>'text','value'=>($messages['subject'])?$messages['subject']:'')); ?>
             <?php }?>
             
             
             
             
             
             <div class="msz-bx">
             
             
             <textarea name="description" class="form-control" placeholder="Description" id="description" required="required" rows="20" style="display: none;">
             <?php echo ($messages['description'])?$messages['description']:''; ?>
             </textarea>
             
             
             <?php //echo $this->Form->input('description',array('class'=>'form-control','placeholder'=>'Description','id'=>'description','required'=>true,'label' =>false,'type'=>'textarea','rows'=>'20', 'value'=>($messages['description'])?$messages['description']:'')); ?>
             
             </div>
             <button type="submit" class="btn btn-default">Send</button>
             </form>
             </div> 
            </div>
          </div>
        </div>
      </div>
</div>
  </section>
  
<script>



    $(document).ready(function() { 
	$("#subject").change(function() { 
	    savedraft(); 
	}); 

    });
    
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

    function selectUser(val,text) {
	//alert(val,text)
	$("#asearch-box").val(text);
	$("#to_id").val(val);
	$("#suggesstion-box").hide();
	savedraft();
    }
    
    // Saving Message to draft
    function savedraft()
    {
	to_id = $("#to_id").val();
	message_id = $("#message_id").val();
	subject = $("#subject").val();
	description = $("#description").val();
	$.ajax({
	type: "POST",
	url: "<?php echo SITE_URL; ?>/message/savetodraft",
	data:'to_id='+to_id+'&message_id='+message_id+'&subject='+subject+'&description='+description,
	success: function(data){
	    obj = JSON.parse(data);
	    if(obj.message_id > 0)
	    {
		$("#message_id").val(obj.message_id);
	    }
	}
	});
    }
    
    function validateform()
    {
	
    }
    
    
    
    
</script>