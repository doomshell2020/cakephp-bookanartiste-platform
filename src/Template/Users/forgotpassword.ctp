

<!-------forget-password-sec-start--------------->
<section id="forget_pass_sec">
<div class="container">
<h2>Forgot your password ?</h2>
<?php echo $this->Flash->render(); ?>
<div class="wraper_box forgot-popup">
<p>Please enter the email address registered on your account</p>
<?php
				echo $this->Form->create('Users',array('url' => array('controller' => 'Users', 'action' => 'forgotpassword'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'LoginsIndexForm')); ?>
  <form class="form-horizontal">
    <div class="form-group">
      <div class="col-xs-1"></div>
      <div class="col-xs-8">
        <input type="email" class="form-control" id="email"  name="email" placeholder="Email Address">
      </div>
      <div class="col-xs-2">
       <input type="submit" value="Reset Password" class="btn-default">
      </div>
      <div class="col-xs-1"></div>
    </div>
    
    
    
    
   <?php echo $this->Form->end();   ?></div>
</div><!--container-->
</section><!--forget_pass_sec-->
<!-------forget-password-sec-end--------------->

