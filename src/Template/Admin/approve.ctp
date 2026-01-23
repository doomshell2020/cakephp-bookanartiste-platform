<?php echo $this->Form->create('',array('url' => ['controller' => 'banner', 'action' => 'banneramount'],'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','autocomplete'=>'off')); ?>
 
 <?php //pr($revisedquote); ?>
   <div class="form-group">
                  <label for="" class="col-sm-3 control-label">Banner Amount :</label>
                  <div class="col-sm-6">
                   <?php echo $this->Form->input('amount',array('class'=>'form-control','placeholder'=>'Amount','required'=>true,'label' =>false,'type'=>'Number','value'=> $revisedquote['amt'])); ?>
                   <?php //pr($revisedquote); ?>
                   <input type="hidden" name="bannerid" value="<?php  echo $bannerapprove['id']; ?>">
                  </div>
                  <div class="col-sm-3"></div>
                </div>
 
 <div class="form-group">
                  <div class="col-sm-12 text-center m-top-20">
					  <button class="btn btn-default" id="bn_subscribe">Submit</button>
                  </div>
                </div>
     <?php echo $this->Form->end(); ?>
