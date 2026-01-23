

<!----------------------editprofile-strt----------------------->
  <section id="edit_profile">
    <div class="container">
      <h2><?php echo $viewpage->pagetitle; ?> </h2>
      <div class="row">
          

        <div class="tab-content">
        <div class="profile-bg m-top-20">
	    <?php echo $this->Flash->render(); ?>
          <div id="Personal" class="tab-pane fade in active">
            <div class="container m-top-60">
       <?php //pr($viewpage); ?>
                <?php echo $viewpage->description;?>
                 
          
              
               
            </div>
          </div>
    </div>
        </div>
      </div>
    </div>
  </section>
  
