
<?php echo $this->element('viewprofile') ?>

    <div class="col-sm-9 my-info" id="conatact-all">
	<div class="col-sm-12 prsnl-det">
	
	
	<div class="row">
	<div class="col-sm-12">
    <form><input type="text" class="form-control" placeholder="search..." /></form>
    </div>	
      
	    
	

		
		
		
	</div>
    
    <div class="row">
    
    <ul class="nav nav-pills">
   
    <li class="active"><a data-toggle="tab" href="#Contactsall">Contacts (<?php echo count($friends); ?>)</a></li>
    <li><a data-toggle="tab" href="#Mutual">Mutual Contacts (10)</a></li>
    <li><a data-toggle="tab" href="#Online">Online Contacts (30)</a></li>
     <li><a data-toggle="tab" href="#Following">Following (15)</a></li>
      <li><a data-toggle="tab" href="#Followers">Followers (20)</a></li>
     <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Refine Contacts<span class="caret"></span></a>
     <ul class="dropdown-menu">
      <li><div class="col-sm-12">
      <form class="form-horizontal">
      <div class="form-group">
    
    <div class="col-sm-12">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
    </div>
  </div>
  
  <div class="form-group">
 
    <div class="col-sm-12">
      <input type="password" class="form-control" id="inputEmail3" placeholder="pwd">
    </div>
  </div>
  
   <div class="form-group">
 
    <div class="col-sm-12">
      <button type="submit" class="btn btn-default">Sign in</button>
    </div>
  </div>
       </form>
      
      
   
      
      
      </div></li>
       
    </ul>
     
     </li>
  </ul>

    <div class="tab-content">
    <div id="Contactsall" class="tab-pane fade in active">
     <div class="col-sm-12">
     <div class="row">
     <?php  foreach($friends as $friendss){   ?>
		 <?php //pr($friendss); ?>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
   <img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $friendss['profile_image'];  ?>">
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center"><?php echo $friendss['name']; ?></h5>
    <!-- <p class="text-center">Singer</p>-->
     <p class="text-center"><?php echo $friendss['location']; ?></p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     
     
     <?php } ?>
   
  
   
     
   
   
    
    
     </div>
     
     </div>
     

     
    </div>
    <div id="Mutual" class="tab-pane fade">
      <div class="col-sm-12">
     <div class="row">
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-2.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-3.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/profile_det-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     

     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-3.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/profile_det-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     </div>
     
     
     </div>
    </div>
    <div id="Online" class="tab-pane fade">
      <div class="col-sm-12">
     <div class="row">
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-2.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-3.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/profile_det-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     

     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-3.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/profile_det-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     <div class="col-sm-3 profile-det">
     <div class="profile-det-img">
     <div class="hvr-icon"><a href="#" class="fa fa-save"></a> <a href="#" class="fa fa-remove"></a></div>
     <img src="images/artistes-1.jpg" />
     <div class="img-top-bar"> <a href="#" class="fa fa-user"></a>  </div>
     
     </div>
     <div class="allcontact-social">
     <a href="#" class="fa fa-user"></a>
     <a href="#" class="fa fa-thumbs-up"></a>
     <a href="#" class="fa fa fa-share"></a>
     <a href="#" class="fa fa-comment"></a>
          <a href="#" class="fa fa-send"></a>
         <a href="#" class="fa fa-download"></a>
     <a href="#" class="fa fa-file"></a>
     <a href="#" class="fa fa-ban"></a>
     
     
     
     </div>
   <div class="all-cnt-det"><h5 class="text-center">John Deo</h5>
     <p class="text-center">Singer</p>
     <p class="text-center">New York, USA</p></div>
     
     <div class="btn-book text-center">
     <a href="#" class="btn btn-default">Book</a>
      <a href="#" class="btn btn-primary">Ask For Quote</a>
     </div>
     </div>
     </div>
     
     
     </div>
    </div>
    <div id="Following" class="tab-pane fade">
      <div class="container"></div>
    </div>
    <div id="Followers" class="tab-pane fade">
            <div class="container"></div>
    </div>
    
  </div>

    
    
    
    </div>
	</div>
	
	     <div class="text-center m-top-20 view-all-cnt-but"><a href="#"  class="btn btn-primary">View All</a></div>

	
	
    </div>
    </div>
</div>
</div>



</div>
</div>


</section>
  
  








  
  <!-------------------------------------------------->
