  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile Package
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php $show_on_home_page = unserialize($packentity['show_on_home_page']);
        ?>
        <?php $show_on_package_page = unserialize($packentity['show_on_package_page']);
        ?>
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php if (isset($packentity['id'])) {
                                      echo 'Edit Profile Package';
                                    } else {
                                      echo 'Add Profile package';
                                    } ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <?php echo $this->Flash->render(); ?>


            <?php echo $this->Form->create($packentity, array(

              'class' => 'form-horizontal',
              'id' => 'sevice_form',
              'enctype' => 'multipart/form-data'
            )); ?>

            <div class="box-body">


              <div class="form-group">
                <label class="col-sm-3 control-label">Package Name</label>
                <div class="field col-sm-5">
                  <?php echo $this->Form->input('name', array('class' =>
                  'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Package Name', 'required', 'label' => false)); ?>
                </div>

              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">Valid for(Number of Days)</label>
                <div class="field col-sm-5">
                  <?php echo $this->Form->input('validity_days', array('class' =>
                  'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Days', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                </div>
              </div>


              <div class="form-group">
                <label class="col-sm-3 control-label">Price($)</label>
                <div class="field col-sm-5">
                  <?php echo $this->Form->input('price', array('class' =>
                  'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Price', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">Package Text</label>
                <div class="field col-sm-5">
                  <?php echo $this->Form->input('packagetext', array('class' =>
                  'longinput form-control', 'maxlength' => '20', 'placeholder' => 'Package Text', 'label' => false, 'type' => 'text')); ?>
                </div>
              </div>




              <div class="form-group">
                <label class="col-sm-3 control-label">Number and Permission to Upload Audio</label>
                <div class="field col-sm-5">

                  <?php echo $this->Form->input('number_audio', array('class' =>
                  'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of audio', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="number_audio" <?php if (in_array('number_audio', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>

                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="number_audio" <?php if (in_array('number_audio', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-3 control-label">Number and Permission to Upload Video</label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('number_video', array('class' =>
                  'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number Of Video', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="number_video" <?php if (in_array('number_video', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="number_video" <?php if (in_array('number_video', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-3 control-label">Visibility of personal websites</label>

                <div class="field col-sm-5">

                  <?php

                  $status = array('Y' => 'Yes', 'N' => 'No');
                  echo $this->Form->input('website_visibility', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Access job', 'required', 'label' => false, 'type' => 'select', 'options' => $status)); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="website_visibility" <?php if (in_array('website_visibility', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="website_visibility" <?php if (in_array('website_visibility', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>

              </div>
              <?php /* ?>
            <div class="form-group">

                    <label class="col-sm-3 control-label">Number of Private Messages to New Individuals per month </label>
                    
                    <div class="field col-sm-5">
                    
                    <?php echo $this->Form->input('private_individual', array('class' => 'longinput form-control','maxlength'=>'20','required','placeholder'=>' Number of Private Individual','required','label'=>false,'type'=>'number','patten'=>'^[0-9]*$')); ?>
                    
                    </div>
                    
                    <div class="field col-sm-2">
					
					<input type="checkbox" name="show_on_home_page[]" value="private_individual"<?php if(in_array('private_individual',$show_on_home_page)){ ?> checked="checked" <?php }?>> Show on Home Page
					</div>
					
					   <div class="field col-sm-2">
						<input type="checkbox" name="show_on_package_page[]" value="private_individual"<?php if(in_array('private_individual',$show_on_package_page)){ ?> checked="checked" <?php }?>> Show on Package Page
						</div>
						
				

             </div>
             <?php */ ?>
              <div class="form-group">

                <label class="col-sm-3 control-label">Access to number Of Job Opportunities/Openings</label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('access_job', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Access job', 'required', 'label' => false, 'type' => 'number', 'options' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="access_job" <?php if (in_array('access_job', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="access_job" <?php if (in_array('access_job', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>
              <div class="form-group">

                <label class="col-sm-3 control-label">Privacy Setting Access</label>

                <div class="field col-sm-5">

                  <?php
                  $status = array('Y' => 'Yes', 'N' => 'No');
                  echo $this->Form->input('privacy_setting_access', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Access job', 'required', 'label' => false, 'type' => 'select', 'options' => $status)); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="privacy_setting_access" <?php if (in_array('privacy_setting_access', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="privacy_setting_access" <?php if (in_array('privacy_setting_access', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>

              <div class="form-group">

                <label class="col-sm-3 control-label">Access to Advertise </label>

                <div class="field col-sm-5">

                  <?php
                  $status = array('Y' => 'Yes', 'N' => 'No');
                  echo $this->Form->input('access_to_ads', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Access job', 'required', 'label' => false, 'type' => 'select', 'options' => $status)); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="access_to_ads" <?php if (in_array('access_to_ads', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="access_to_ads" <?php if (in_array('access_to_ads', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>
              <div class="form-group">

                <label class="col-sm-3 control-label">Number of Job Applications per month</label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('number_job_application', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Application', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="number_job_application" <?php if (in_array('number_job_application', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="number_job_application" <?php if (in_array('number_job_application', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>

              <div class="form-group">

                <label class="col-sm-3 control-label">Number of Job Applications Daily</label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('number_of_application_day', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Application Per day', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="number_of_application_day" <?php if (in_array('number_of_application_day', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="number_of_application_day" <?php if (in_array('number_of_application_day', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>
              <?php /* ?>
              <div class="form-group">

                    <label class="col-sm-3 control-label">Number of  Searches other Profile</label>
                    
                    <div class="field col-sm-5">
                    
                    <?php echo $this->Form->input('number_search', array('class' => 'longinput form-control','maxlength'=>'20','required','placeholder'=>' Number of Search','required','label'=>false,'type'=>'number','patten'=>'^[0-9]*$')); ?>
                    
                    </div>
                    <div class="field col-sm-2">
					
					<input type="checkbox" name="show_on_home_page[]" value="number_search"<?php if(in_array('number_search',$show_on_home_page)){ ?> checked="checked" <?php }?>> Show on Home Page
					</div>
					<div class="field col-sm-2">
						<input type="checkbox" name="show_on_package_page[]" value="number_search"<?php if(in_array('number_search',$show_on_package_page)){ ?> checked="checked" <?php }?>> Show on Package Page
						</div>
						

             </div>
             <?php */ ?>

              <div class="form-group">

                <label class="col-sm-3 control-label">Ad Free Experience</label>

                <div class="field col-sm-5">

                  <?php

                  $status = array('Y' => 'Yes', 'N' => 'No');
                  echo $this->Form->input('ads_free', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Access job', 'required', 'label' => false, 'type' => 'select', 'options' => $status)); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="ads_free" <?php if (in_array('ads_free', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="ads_free" <?php if (in_array('ads_free', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>

              <div class="form-group">

                <label class="col-sm-3 control-label">Number of Albums</label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('number_albums', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of albums', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="number_albums" <?php if (in_array('number_albums', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="number_albums" <?php if (in_array('number_albums', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>
              <?php /* ?>
              <div class="form-group">

                    <label class="col-sm-3 control-label">Number of Message Folder</label>
                    
                    <div class="field col-sm-5">
                    
                    <?php echo $this->Form->input('message_folder', array('class' => 'longinput form-control','maxlength'=>'20','required','placeholder'=>' Number of folder','required','label'=>false,'type'=>'number','patten'=>'^[0-9]*$')); ?>
                    
                    </div>
                    <div class="field col-sm-2">
					
					<input type="checkbox" name="show_on_home_page[]" value="message_folder"<?php if(in_array('message_folder',$show_on_home_page)){ ?> checked="checked" <?php }?>> Show on Home Page
					</div>
					<div class="field col-sm-2">
						<input type="checkbox" name="show_on_package_page[]" value="message_folder"<?php if(in_array('message_folder',$show_on_package_page)){ ?> checked="checked" <?php }?>> Show on Package Page
						</div>
						

             </div>
             <?php */ ?>

              <div class="form-group">

                <label class="col-sm-3 control-label">Number of Job Alerts per Month</label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('number_of_jobs_alerts', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Jobs alerts', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="number_of_jobs_alerts" <?php if (in_array('number_of_jobs_alerts', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="number_of_jobs_alerts" <?php if (in_array('number_of_jobs_alerts', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>
              <div class="form-group">

                <!-- <label class="col-sm-3 control-label">Total No of introductions sent </label> -->
                <label class="col-sm-3 control-label">Total No of Connect Requests sent </label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('number_of_introduction', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Introduction', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="number_of_introduction" <?php if (in_array('number_of_introduction', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="number_of_introduction" <?php if (in_array('number_of_introduction', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>

              <div class="form-group">

                <!-- <label class="col-sm-3 control-label">Total No of introductions sent per day </label> -->
                <label class="col-sm-3 control-label">Total No of Connect Requests sent per day </label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('introduction_sent', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Introduction', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="introduction_sent" <?php if (in_array('introduction_sent', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="introduction_sent" <?php if (in_array('introduction_sent', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>

              <div class="form-group">

                <!-- <label class="col-sm-3 control-label">Total No of introductions Received </label> -->
                <label class="col-sm-3 control-label">Total No of Connect Requests Received </label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('number_of_introduction_recived', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Introduction', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="number_of_introduction_recived" <?php if (in_array('number_of_introduction_recived', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="number_of_introduction_recived" <?php if (in_array('number_of_introduction_recived', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>
              <?php /* ?>
               <div class="form-group">

                    <label class="col-sm-3 control-label">Number of Jobs</label>
                    
                    <div class="field col-sm-5">
                    
                    <?php echo $this->Form->input('nubmer_of_jobs', array('class' => 'longinput form-control','maxlength'=>'20','required','placeholder'=>' Number of Introduction','required','label'=>false,'type'=>'number','patten'=>'^[0-9]*$')); ?>
                    
                    </div>
                    <div class="field col-sm-2">
					
					<input type="checkbox" name="show_on_home_page[]" value="nubmer_of_jobs"<?php if(in_array('nubmer_of_jobs',$show_on_home_page)){ ?> checked="checked" <?php }?>> Show on Home Page
					</div>
					<div class="field col-sm-2">
						<input type="checkbox" name="show_on_package_page[]" value="nubmer_of_jobs"<?php if(in_array('nubmer_of_jobs',$show_on_package_page)){ ?> checked="checked" <?php }?>> Show on Package Page
						</div>
						

             </div>
<?php */ ?>
              <div class="form-group">

                <label class="col-sm-3 control-label">Number of Photographs</label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('number_of_photo', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Introduction', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="number_of_photo" <?php if (in_array('number_of_photo', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="number_of_photo" <?php if (in_array('number_of_photo', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>

              <div class="form-group">

                <label class="col-sm-3 control-label">Ask for Quote’ request per job </label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('ask_for_quote_request_per_job', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Introduction', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="number_of_free_job" <?php if (in_array('number_of_free_job', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="number_of_free_job" <?php if (in_array('number_of_free_job', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>






              <div class="form-group">

                <label class="col-sm-3 control-label">Daily limit to Send Quote </label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('number_of_quote_daily', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Introduction', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="number_of_quote_daily" <?php if (in_array('number_of_quote_daily', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="number_of_quote_daily" <?php if (in_array('number_of_quote_daily', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>


              <div class="form-group">

                <label class="col-sm-3 control-label">Total No. of Jobs Alerts for Package period</label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('job_alerts', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of job  Alerts', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="job_alerts" <?php if (in_array('job_alerts', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="job_alerts" <?php if (in_array('job_alerts', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>
              <?php /* ?>
              <div class="form-group">

                    <label class="col-sm-3 control-label">Proiorties</label>
                    
                    <div class="field col-sm-5">
                    
                    <?php echo $this->Form->input('proiorties', array('class' => 'longinput form-control','maxlength'=>'20','required','placeholder'=>' Number of job  Alerts','required','label'=>false,'type'=>'number','patten'=>'^[0-9]*$')); ?>
                    
                    </div>
                    <div class="field col-sm-2">
					
					<input type="checkbox" name="show_on_home_page[]" value="proiorties"<?php if(in_array('proiorties',$show_on_home_page)){ ?> checked="checked" <?php }?>> Show on Home Page
					</div>
					<div class="field col-sm-2">
						<input type="checkbox" name="show_on_package_page[]" value="proiorties"<?php if(in_array('proiorties',$show_on_package_page)){ ?> checked="checked" <?php }?>> Show on Package Page
						</div>
						

             </div>
             
             <div class="form-group">

                    <label class="col-sm-3 control-label">Number of Free Quote </label>
                    
                    <div class="field col-sm-5">
                    
                    <?php echo $this->Form->input('number_of_free_quote', array('class' => 'longinput form-control','maxlength'=>'20','required','placeholder'=>' Number of Free quote month','required','label'=>false,'type'=>'number','patten'=>'^[0-9]*$')); ?>
                    
                    </div>
                    <div class="field col-sm-4">
					
					<input type="checkbox" name="show_on_home_page[]" value="number_of_free_quote"<?php if(in_array('number_of_free_quote',$show_on_home_page)){ ?> checked="checked" <?php }?>> Show on Home Page
					</div>

             </div>
             
                <div class="form-group">

                    <label class="col-sm-3 control-label">Ask for Quote’ request per day</label>
                    
                    <div class="field col-sm-5">
                    
                    <?php echo $this->Form->input('number_of_free_day', array('class' => 'longinput form-control','maxlength'=>'20','required','placeholder'=>' Number of free day','required','label'=>false,'type'=>'number','patten'=>'^[0-9]*$')); ?>
                    
                    </div>
                    <div class="field col-sm-4">
					
					<input type="checkbox" name="show_on_home_page[]" value="number_of_free_day"<?php if(in_array('number_of_free_day',$show_on_home_page)){ ?> checked="checked" <?php }?>> Show on Home Page
					</div>

             </div><?php */ ?>




              <div class="form-group">

                <label class="col-sm-3 control-label">Number of Booking Requests send per job</label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('number_of_booking', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of folder', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="number_of_booking" <?php if (in_array('number_of_booking', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="number_of_booking" <?php if (in_array('number_of_booking', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>
              <?php /* ?>
               <div class="form-group">

                    <label class="col-sm-3 control-label">Total no of profile likes given per day</label>
                    
                    <div class="field col-sm-5">
                    
                    <?php echo $this->Form->input('profile_likes', array('class' => 'longinput form-control','maxlength'=>'20','required','placeholder'=>' Number of folder','required','label'=>false,'type'=>'number','patten'=>'^[0-9]*$')); ?>
                    
                    </div>
                    <div class="field col-sm-2">
					
					<input type="checkbox" name="show_on_home_page[]" value="profile_likes"<?php if(in_array('profile_likes',$show_on_home_page)){ ?> checked="checked" <?php }?>> Show on Home Page
					</div>
					<div class="field col-sm-2">
						<input type="checkbox" name="show_on_package_page[]" value="profile_likes"<?php if(in_array('profile_likes',$show_on_package_page)){ ?> checked="checked" <?php }?>> Show on Package Page
						</div>
						

             </div>
<?php */ ?>
              <div class="form-group">

                <label class="col-sm-3 control-label">Icon</label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('Icon', array('class' => 'longinput form-control', 'label' => false, 'type' => 'file')); ?>

                </div>

              </div>




              <div class="form-group">

                <label class="col-sm-3 control-label">Personalized url</label>

                <div class="field col-sm-5">
                  <?php $status = array('Y' => 'Yes', 'N' => 'No'); ?>
                  <?php echo $this->Form->input('persanalized_url', array('class' => 'longinput form-control', 'required', 'placeholder' => ' Personalized Url', 'required', 'label' => false, 'type' => 'select', 'options' => $status)); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="persanalized_url" <?php if (in_array('persanalized_url', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="persanalized_url" <?php if (in_array('persanalized_url', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>

              <div class="form-group">

                <label class="col-sm-3 control-label">Selection of Number of Categories while registering</label>

                <div class="field col-sm-5">

                  <?php echo $this->Form->input('number_categories', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of categories', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="number_categories" <?php if (in_array('number_categories', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="number_categories" <?php if (in_array('number_categories', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>
              <?php /* 
                          <div class="form-group">

                              <label class="col-sm-3 control-label">Visibility Priority </label>

                              <div class="field col-sm-5">

                                  <?php echo $this->Form->input('Visibility_Priority', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of categories', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>

                              </div>



                              <div class="field col-sm-2">

                                  <input type="checkbox" name="show_on_home_page[]" value="Visibility_Priority" <?php if (in_array('Visibility_Priority', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                              </div>
                              <div class="field col-sm-2">
                                  <input type="checkbox" name="show_on_package_page[]" value="Visibility_Priority" <?php if (in_array('Visibility_Priority', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                              </div>


                          </div>
              */ ?>
              <div class="form-group">

                <label class="col-sm-3 control-label">Create a Personal page</label>

                <div class="field col-sm-5">

                  <?php

                  $status = array('Y' => 'Yes', 'N' => 'No');
                  echo $this->Form->input('personal_page', array('class' => 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number of Access job', 'required', 'label' => false, 'type' => 'select', 'options' => $status)); ?>

                </div>
                <div class="field col-sm-2">

                  <input type="checkbox" name="show_on_home_page[]" value="personal_page" <?php if (in_array('personal_page', $show_on_home_page)) { ?> checked="checked" <?php } ?>> Show on Home Page
                </div>
                <div class="field col-sm-2">
                  <input type="checkbox" name="show_on_package_page[]" value="personal_page" <?php if (in_array('personal_page', $show_on_package_page)) { ?> checked="checked" <?php } ?>> Show on Package Page
                </div>


              </div>







            </div><!--content-->




            <!-- /.form group -->

          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <?php
            echo $this->Html->link('Back', [
              'action' => 'index'

            ], ['class' => 'btn btn-default']); ?>

            <?php
            if (isset($packentity['id'])) {
              echo $this->Form->submit(
                'Update',
                array('class' => 'btn btn-info pull-right', 'title' => 'Update')
              );
            } else {
              echo $this->Form->submit(
                'Add',
                array('class' => 'btn btn-info pull-right', 'title' => 'Add')
              );
            }
            ?>
          </div>
          <!-- /.box-footer -->
          <?php echo $this->Form->end(); ?>
        </div>

      </div>
      <!--/.col (right) -->
  </div>
  <!-- /.row -->
  </section>
  <!-- /.content -->
  </div>