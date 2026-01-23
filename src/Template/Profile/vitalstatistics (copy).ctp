<!----------------------editprofile-strt----------------------->
  <section id="edit_profile">
    <div class="container">
      <h2>Edit <span>Profile</span></h2>
      <p class="m-bott-50">Here You Can Create Your Profile</p>
      <div class="row">
          <?php echo  $this->element('editprofile') ?>
        <div class="tab-content">
     
           <?php echo $this->Flash->render(); ?>
          <div id="Perfo-Des" class="">
            <div class="container m-top-60">
                      <?php echo $this->Form->create($proff,array('url' => array('controller' => 'profile', 'action' => 'performance'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
                <?php foreach($vitalsquestion as $vitalss){// pr($vitalss);  ?>
                
                 <div class="form-group">
                  <label for="" class="col-sm-2 control-label"><?php echo $vitalss->question; ?>:</label>
                  <div class="col-sm-6">
		<?php 
		/// Dropdown
		if($vitalss->vs_question->option_type_id=='1'){ ?>
		
		<?php }else if($vitalss->vs_question->option_type_id=='2'){?>
		

		<?php }else if($vitalss->vs_question->option_type_id=='3'){?>
		
		<?php }else if($vitalss->vs_question->option_type_id=='4'){?>
		
		
		
		<?php }else if($vitalss->vs_question->option_type_id=='5'){?>
		    <select>
			<option>s<option>
			<option>s<option>
			<option>s<option>
		    </select>
		<?php }else{?>
		
		<?php }?>
		
		
		
		
		
		
                  </div>
                  <div class="col-sm-4"></div>
                </div>
                
                <?php }?>
                

                <div class="form-group">
                  <div class="col-sm-8 text-center">
                    <button type="submit" class="btn btn-default">Submit</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
