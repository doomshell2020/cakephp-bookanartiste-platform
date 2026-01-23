  
  <script src="<?php echo SITE_URL; ?>/js/typeahead.js"></script>
   
   
  <section id="page_Messaging">
    <div class="container">
      <h2><span>Messaging</span></h2>
    </div>
<div class="mess-box-container">
      <div class="container">
        <div class="row profile-bg m-top-20">
        <h4 class="text-center">Create Folder</h4>
           <?php echo  $this->element('messaginmenuleft') ?>
          <div class="col-sm-9">
            <div class="messaging-cntnt-box">
             <div class="msz-frm">
              <?php 
              echo $this->Form->create($messages,array('url' => array('controller' => 'message', 'action' => 'createfolder'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
             <!--<input type="text" placeholder="Search.." name="search" class="form-control srch">  -->
	    <?php echo $this->Form->input('folder_name',array('class'=>'form-control','placeholder'=>'Folder Name','required'=>true,'label' =>false,'type'=>'text' ,'value'=>($messages['user'])?$messages['user']['user_name']:'')); ?>
             <button type="submit" class="btn btn-default">Submit</button>
             </form>
             </div> 
            </div>
          </div>
        </div>
      </div>
</div>
  </section>