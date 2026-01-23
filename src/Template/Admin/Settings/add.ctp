<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Common Settings
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">

            <!-- right column -->
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">

                    <!-- /.box-header -->
                    <!-- form start -->

                    <?php echo $this->Flash->render(); ?>

                    <?php echo $this->Form->create($packentity, array(

                        'class' => 'form-horizontal',
                        'id' => 'sevice_form',
                        'enctype' => 'multipart/form-data'
                    )); ?>

                    <div class="row">
                    <div class="col-sm-12">

                    <div class="box-header with-border">
                        <h3 class="box-title">Site Settings</h3>
                    </div>
                    <div class="box-body">

             
                            <div class="field col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                            <label class="control-label">Google Analytics</label>
                                <?php echo $this->Form->textarea('ga_code', array('class' => 'longinput form-control', 'label' => false, 'type' => 'textarea')); ?>

                            </div>
                        </div>
                    </div>

                    </div>
                   
                    
                    <div class="col-sm-12">

                    <div class="box-header with-border">
                        <h3 class="box-title">Profile Blocking</h3>
                    </div>
                    <div class="box-body">

                        <div class="form-group">
                           
                            <div class="field col-lg-6 col-md-6 col-sm-6 col-12">
                            <label class="control-label">Block Profile after number of report by users</label>
                                <?php echo $this->Form->input('block_after_report', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of reports', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                    
                           
                            <div class="field col-lg-6 col-md-6 col-sm-6 col-12">
                            <label class="control-label">Unblock Profile If Content admin don't any action(In Days)</label>
                                <?php echo $this->Form->input('unblock_within', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Days', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                
                          
                            <div class="field col-lg-6 col-md-6 col-sm-6 col-12">
                            <label class="control-label">Block Profile after number of attempts for single Profile</label>
                                <?php echo $this->Form->input('block_after_days', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of attempts', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                        </div>

                    </div>
                    </div>

                    <!--                             
                    <div class="box-header with-border">
                    <h3 class="box-title">Job Posting</h3>
                 </div>
                            <div class="box-body">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Number of Free Job Post</label>
                                    <div class="field col-sm-6">
                                        <?php
                                        //  echo $this->Form->input('non_telent_number_of_job_post', array('class' =>
                                        // 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Job Post', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$'));
                                         ?>
                                    </div>
                                </div>
                            </div>
                     -->
                    <!--                             
                                <div class="box-header with-border">
                    <h3 class="box-title">Free Jobposting</h3>
                  </div>
                            <div class="box-body">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Number of Days Free Job Post</label>
                                    <div class="field col-sm-6">
                                        <?php 
                                        // echo $this->Form->input('number_of_days_free_jobpost', array('class' =>
                                        // 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Job Post', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$'));
                                        ?>
                                    </div>
                                </div>
                                
                                
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Number of Talent Free Job Post</label>
                                    <div class="field col-sm-6">
                                        <?php 
                                        
                                        // echo $this->Form->input('number_of_talent_free_jobpost', array('class' =>
                                        // 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Job Post', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); 
                                        
                                        ?>
                                    </div>
                                </div>
                                
                            </div> -->



                    <!-- <div class="box-header with-border">
                    <h3 class="box-title">Quotes</h3>
                     </div>
                            <div class="box-body">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Number of Free Quotes</label>
                                    <div class="field col-sm-6">
                                        <?php 
                                        // echo $this->Form->input('non_telent_ask_quote', array('class' =>
                                        // 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Free Quotes', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); 
                                        ?>
                                    </div>
                                </div>
                            </div> -->





                    <!-- <div class="box-header with-border">
                    <h3 class="box-title">Booking Request</h3>
                    </div>
                            <div class="box-body">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"> Number of Booking Request</label>
                                    <div class="field col-sm-6">
                                        <?php 
                                        // echo $this->Form->input('number_of_free_booking_req', array('class' =>
                                        // 'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Number of Booking request', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); 
                                        ?>
                                    </div>
                                </div>
                            </div>
                            -->
                            <div class="col-sm-6">

                    <div class="box-header with-border">
                        <h3 class="box-title">Artiste Featured Settings</h3>
                    </div>
                    <div class="box-body">

                        <div class="form-group">
                           
                            <div class="field col-lg-12 col-md-12 col-sm-12 col-12">
                            <label class=" control-label"> Featured Artiste will automatically un-featured(In Days)</label>
                                <?php echo $this->Form->input('featured_artist_days', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Days', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-sm-6">

                    <div class="box-header with-border">
                        <h3 class="box-title">Job Featured Settings</h3>
                    </div>
                    <div class="box-body">

                        <div class="form-group">
                          
                            <div class="field col-lg-12 col-md-12 col-sm-12 col-12">
                            <label class=" control-label"> Featured Job will automatically un-featured(In Days)</label>
                                <?php echo $this->Form->input('featured_job_days', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Days', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                        </div>
                    </div>
                    </div>


                    <div class="col-sm-12">
                    <div class="box-header with-border">
                        <h3 class="box-title">Non-Talent Profile Settings</h3>
                    </div>
                    <div class="box-body">

                        <div class="form-group">
                          
                            <div class="field col-sm-6 col-12">
                            <label class=" control-label"> Number Of Audio </label>
                                <?php echo $this->Form->input('non_telent_number_of_audio', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => ' Number Of Audio', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                      
                          
                            <div class="field col-sm-6 col-12">
                            <label class=" control-label">Number Of Video </label>
                                <?php echo $this->Form->input('non_telent_number_of_video', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number Of Video', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                       
                           
                            <div class="field col-sm-6 col-12">
                            <label class="control-label">Number Of Albums </label>
                                <?php echo $this->Form->input('non_telent_number_of_album', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number Of Albums', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                     
                           
                            <div class="field col-sm-6 col-12">
                            <label class="control-label">Number Of Photos </label>
                                <?php echo $this->Form->input('non_telent_number_of_folder', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number Of Folder', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                      
                        <?php /* ?>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Number Of jobs Alerts </label>
                                                                    <div class="field col-sm-6">
                                                <?php echo $this->Form->input('non_telent_number_of_jobalerts', array('class' => 
                                                    'longinput form-control','maxlength'=>'20','required','placeholder'=>'Number Of jobs Alerts','required','label'=>false,'type'=>'number','patten'=>'^[0-9]*$')); ?>
                                                                    </div>
                                                                </div>
                                <?php */ ?>
                                                        <?php /* ?>
                                                                <div class="form-group">
                                                                    <label class="col-sm-3 control-label">Number Of Search Profile </label>
                                                                    <div class="field col-sm-6">
                                            <?php echo $this->Form->input('non_telent_number_of_search_profile', array('class' => 
                                                    'longinput form-control','maxlength'=>'20','required','placeholder'=>'Number Of Search Profile','required','label'=>false,'type'=>'number','patten'=>'^[0-9]*$')); ?>
                                                                    </div>
                                                                </div>
                                <?php */ ?>
                       
                           
                            <div class="field col-sm-6 col-12">
                            <label class="control-label">Number of Persons (For Private Message) Per Month</label>
                                <?php echo $this->Form->input('non_telent_number_of_private_message', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Job Applications per month', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                        
                        <?php /* ?>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Number of Ask Quote </label>
                                                        <div class="field col-sm-6 col-12">
                        <?php echo $this->Form->input('non_telent_ask_quote', array('class' => 
                                        'longinput form-control','maxlength'=>'20','required','placeholder'=>'Number of Job Applications per month','required','label'=>false,'type'=>'number','patten'=>'^[0-9]*$')); ?>
                                                        </div>



                                </div>


                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Number of Job Post </label>
                                    <div class="field col-sm-6 col-12">
                                <?php echo $this->Form->input('non_telent_number_of_job_post', array('class' => 
                                                'longinput form-control','maxlength'=>'20','required','placeholder'=>'Number of Job Applications per month','required','label'=>false,'type'=>'number','patten'=>'^[0-9]*$')); ?>
                                                                </div>
                                                            </div>
                                <?php */ ?>
                       
                         
                            <div class="field col-sm-6 col-12">
                            <label class=" control-label"> Number of Free Job Post Annual</label>
                                <?php echo $this->Form->input('non_telent_number_of_job_post', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Job Post', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                    
                            <!-- <label class="col-sm-3 control-label"> Number of Free Quotes</label> -->
                         
                            <div class="field col-sm-6 col-12">
                            <label class=" control-label">Ask For Quotes Per Persons</label>
                                <?php echo $this->Form->input('non_telent_ask_quote', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Free Quotes', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                     
                          
                            <div class="field col-sm-6 col-12">
                            <label class=" control-label"> Number of Days Free Job Post</label>
                                <?php echo $this->Form->input('number_of_days_free_jobpost', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Job Post', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                      
                           
                            <div class="field col-sm-6 col-12">
                            <label class=" control-label"> Number of Talent Free Job Post(Total Number Of Skill Add)</label>
                                <?php echo $this->Form->input('number_of_talent_free_jobpost', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Job Post', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                        </div>

                        <!-- <div class="form-group">
                                    <label class="col-sm-3 control-label"> Number of Booking Request Per Job Monthly</label>
                                    <div class="field col-lg-4 col-md-4 col-sm-6 col-12">
                                        <?php echo $this->Form->input('number_of_free_booking_req', array('class' =>
                                        'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Number of Booking request', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                                    </div>
                                </div>      -->



                    </div>

                    </div>

                    <div class="col-sm-6">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ping Job Amount</h3>
                    </div>
                    <div class="box-body">

                        <div class="form-group">
                           
                            <div class="field  col-sm-12 col-12">
                            <label class="control-label"> Ping Amount</label>
                                <?php echo $this->Form->input('ping_amt', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Days', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                        </div>
                    </div>
                    </div>


                    <div class="col-sm-6">
                    <div class="box-header with-border">
                        <h3 class="box-title">Send Quote </h3>
                    </div>
                    <div class="box-body">

                        <div class="form-group">
                         
                            <div class="field  col-sm-12 col-12">
                            <label class="control-label"> Send Quote Amount</label>
                                <?php echo $this->Form->input('quote_amt', array('class' =>
                                'longinput form-control', 'maxlength' => '20', 'required', 'placeholder' => 'Number of Days', 'required', 'label' => false, 'type' => 'number', 'patten' => '^[0-9]*$')); ?>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <?php
                    if (isset($transports['id'])) {
                        echo $this->Form->submit(
                            'Update',
                            array('class' => 'btn btn-info pull-right', 'title' => 'Update')
                        );
                    } else {
                        echo $this->Form->submit(
                            'Add',
                            array('class' => 'btn btn-info pull-right', 'title' => 'Sumit')
                        );
                    }
                    ?>
                </div>
                <!-- /.box-footer -->
                <?php echo $this->Form->end(); ?>
            </div>

        </div>
    </section> <!--/.col (right) -->
</div>
<!-- /.row -->