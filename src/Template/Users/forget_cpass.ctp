<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Fresh Rush</title>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>

<script>
 var site_url="<?php echo SITE_URL;?>";
</script>
<script src="<?php echo SITE_URL; ?>js/jquery.min.js"></script>
<script src="<?php echo SITE_URL; ?>js/owl.carousel.min.js"></script>

<!-- Bootstrap CSS and JS -->
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/bootstrap.min.css" type="text/css">
<script src="<?php echo SITE_URL; ?>js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/easyzoom.css" />
<link rel="stylesheet" href="<?php echo SITE_URL;?>css/responsive.css" type="text/css">
<script src="<?php echo SITE_URL;?>js/other.js"></script>
<script src="<?php echo SITE_URL;?>js/easyzoom.js"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- Owl Carousel JS and CSS -->
<!-- Owl Carousel JS and CSS -->
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/owl.carousel.min.css">


<!-- Offside CSS -->
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/offside.css">

<!-- Custom and Other CSS -->
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/font-awesome.min.css" type="text/css">
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/style.css" type="text/css">
<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/responsive.css" type="text/css">
<body id="body-spce">
<header  class="text-center">

<!--<a href="<?php echo SITE_URL;?>store"><img src="<?php echo SITE_URL; ?>images/~logo.png" alt="logo"></a>-->
<div class="clear"></div>
</header>
<script type="text/javascript">
function validate(){
	
	if($('#pass').val()!=$('#cpass').val()){
		alert("Password and confirm password should be same");
		return false;
	}else
	return true;
}

</script>

<section class="page checkout-p">
  <div class="container">
    <div class="">
      <div class="row">
   <div class="col-sm-12">
 <div class="chek-loguser text-justify">	

<div class="f-bordr">   <h2 class="dsh-h text-center">Password Reset form</h2>  <?php echo $this->Form->create('User',array('url'=>array('controller'=>'Users','action'=>'forget_cpass/kp/'.$usrid),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'cont-form','role'=>'form','onsubmit'=>'return validate();')); ?>
     <?php if($ftyp==1) { 
		  //if(1==1) { 
		 ?>    
    <div class="form-group">
      <div class="col-xs-6"><!--<label class="control-label col-sm-5" for="email">New Password:</label>-->
     
       <?php echo $this->Form->password('password',array('required','id'=>'pass','class'=>'form-control', 'placeholder'=>'New Password')); ?></div>
       <div class="col-xs-6"><!--<label class="control-label col-sm-5" for="pwd">Confirm Password:</label>-->
                
<?php echo $this->Form->password('cpassword',array('required','id'=>'cpass','class'=>'form-control', 'placeholder'=>'Confirm Password')); ?>
     </div>
    
    </div>
    
       <div class="form-group">        
      <div class="s-btn">
        <button type="submit" class="btn btn-primary text-center">Submit</button>
      </div>
    </div>
   
     <?php } else {
 echo("<span style='color:red;align:center;margin-left:110px'>Invalid Key or Expired link</span>");    
 }
  
  ?>
   
  </form></div>
 </div>
        </div>
        </div>
        </div>
        </div>
        <!--<ul class="list-inline botm-links">
<li><a href="#">Privacy policy</a></li>
<li><a href="#">Refund policy</a></li>
<li><a href="#">Terms of service</a></li>
</ul>-->
        </section>
        

