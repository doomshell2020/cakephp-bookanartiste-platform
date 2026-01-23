  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>
  <script>
    $(document).ready(function() {
      $('#summernote').summernote();
    });
  </script>
  <!----------------------editprofile-strt----------------------->
  <section id="edit_profile">
    <div class="container">
      <h2>Personal <span>Page</span></h2>
      <div class="row">


        <div class="tab-content">
          <div class="profile-bg m-top-20">
            <?php echo $this->Flash->render(); ?>
            <div id="Personal" class="tab-pane fade in active">
              <div class="container m-top-60">
                <?php echo $this->Form->create($pagepersonal, array('url' => array('controller' => 'profile', 'action' => 'personalpage'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>


                <?php   //pr($pagepersonal); 
                ?>

                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Title:</label>
                  <div class="col-sm-9">

                    <?php echo $this->Form->input('pagetitle', array('class' => 'form-control', 'placeholder' => 'Title', 'id' => 'name', 'required' => true, 'label' => false)); ?>

                  </div>
                  <div class="col-sm-1"></div>
                </div>

                <div class="form-group">
                  <label for="" class="col-sm-2 control-label">Content:</label>
                  <div class="col-sm-9">

                    <textarea name="description" id="summernote" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                      <?php 
                      if ($pagepersonal->description) {
                        echo $pagepersonal->description;
                      }
                      ?>
                      </textarea>
                  </div>
                  <div class="col-sm-1"></div>
                </div>


                <div class="form-group">
                  <div class="col-sm-8 text-center">
                    <button id="btn" type="submit" class="btn btn-default">Submit</button>
                  </div>
                </div>
                <?php echo $this->Form->end(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>