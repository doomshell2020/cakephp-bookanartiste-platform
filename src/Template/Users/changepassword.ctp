 <!----------------------editprofile-strt----------------------->
 <section id="edit_profile">
   <div class="container">
     <h2>Change<span> Password</span></h2>
     <div class="row">
       <div class="tab-content">
         <div class="profile-bg m-top-20">
           <?php echo $this->Flash->render(); ?>
           <div id="Personal" class="tab-pane fade in active">
             <div class="container m-top-30">
               <?php echo $this->Form->create($pagepersonal, array('url' => array('controller' => 'users', 'action' => 'changepassword'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>
               <div class="form-group">
                 <label for="" class="col-sm-2 control-label">Current Password:</label>
                 <div class="col-sm-9">
                   <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Current Password', 'id' => 'name', 'required' => true, 'label' => false, 'type' => 'password')); ?>
                   <input type="hidden" name="email" value="<?php echo $_SESSION['Auth']['User']['email']; ?>">
                 </div>
                 <div class="col-sm-1"></div>
               </div>
               <div class="form-group">
                 <label for="" class="col-sm-2 control-label">New Password:</label>
                 <div class="col-sm-9">
                   <?php echo $this->Form->input('newpassword', array('class' => 'form-control', 'placeholder' => 'New Password', 'id' => 'p1', 'required' => true, 'label' => false, 'type' => 'password')); ?>
                 </div>
                 <div class="col-sm-1"></div>
               </div>
               <div class="form-group">
                 <label for="" class="col-sm-2 control-label">Confirm Password:</label>
                 <div class="col-sm-9">
                   <input type="password" name="confirmpassword" required="" class="form-control" id="registration" placeholder="Confirm Password" onfocus="validatePass(document.getElementById('p1'), this);" oninput="validatePass(document.getElementById('p1'), this);">
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
 <script>
   function validatePass(p1, p2) {

     if (p1.value != p2.value) {

       p2.setCustomValidity('Password incorrect');

     } else {

       p2.setCustomValidity('');

     }
   }
 </script>