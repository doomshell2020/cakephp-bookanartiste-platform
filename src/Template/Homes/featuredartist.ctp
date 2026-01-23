<style type="text/css">
	.fa.fa-save {
		position: absolute;
		top: 0;
		left: 0;
		color: #000;
		font-size: 16px;
		background-color: #fff;
		padding: 4px;
	}

	.contact-detail-social-icon ul li a {
		color: white;
		font-size: 12px;
	}

	.contact-detail-social-icon ul li {
		/* display: inline-block; */
		position: relative;
		padding-bottom: 15px;
		float: left;
	}

	.all-cnt-det {
		min-height: auto;
	}

	.all-cnt-det p {
		margin-bottom: 15px;
	}
</style>

<!----------------------editprofile-strt------------------------>
<section id="edit_profile" class="profiles_info">
	<div class="container">
		<h2>Featured<span> Profiles</span></h2>
		<p class="m-bott-50">Here You Can See</p>
		<div class="row">


			<div class="tab-content">
				<div class="profile-bg ">
					<?php echo $this->Flash->render(); ?>
					<div id="Personal" class="tab-pane fade in active">
						<div class="container m-top-60">

							<?php //////////////-Following------------
							?>
							<div id="" class="">
								<div class="col-sm-12">
									<div class="row">
										<?php
										$role_id = $this->request->session()->read('Auth.User.role_id');
										$login_user_id = $this->request->session()->read('Auth.User.id');
										// pr($user_id);exit;
										$count = 1;
										?>
										<?php foreach ($viewfeaturedartist as $featuredartist) { //pr($featuredartist);  
										?>
											<?php
											$userid = $featuredartist['user_id'];
											$profile = $this->Comman->profiledetail($userid); //pr($profile); die; 
											$profilepackage = $this->Comman->profilepackage($userid); //pr($profilepackage); die; 
											?>

											<?php
											$totaluserlikes = $this->Comman->likess($userid);
											$profilesave = $this->Comman->profilesave($userid);
											?>

											<script>
												var loginId = parseInt('<?= $login_user_id; ?>', 10);

												//   $(".profilecount<?php echo $count; ?>").click(function(){
												//                                       window.location=$(this).find("a").attr("href"); return false;
												//                                     });
											</script>

											<div class="col-sm-3 ">

												<div class="profile-det profilecount<?php echo $count; ?>">
													<div class="box-info"></div>
													<div class="profile-det-img">
														<div class="hvr-icon profile_action">
															<!--<a href="#" class="fa fa-save"></a> -->
															<?php $saveprofile = $this->Comman->userprofilesave(); ?>

															<a href="javascript:void(0)" id="saveprofile<?php echo $count; ?>" class="fa fa-save <?php echo (isset($saveprofile) && $saveprofile > 0) ? 'active' : ''; ?>" data-val="<?php echo ($userid) ? $userid : '0' ?>" title="Save"></a>

															<script>
																/* Saved profile */
																$('#saveprofile<?php echo $count; ?>').click(function() {
																	error_text = "You cannot saved yourself";
																	user_id = $(this).data('val');

																	if (user_id == loginId) {
																		showerror('You can not saved yourself');
																		return false
																	}

																	if (user_id > 0) {
																		$.ajax({
																			type: "POST",
																			url: '<?php echo SITE_URL; ?>/profile/saveprofile',
																			data: {
																				user_id: user_id
																			},
																			cache: false,
																			success: function(data) {
																				obj = JSON.parse(data);

																				if (obj.success == '1') {
																					$("#saveprofile<?php echo $count; ?>").addClass('active');
																				} else {
																					$("#saveprofile<?php echo $count; ?>").removeClass('active');
																				}
																				//$("#totallikes").html(obj.count);

																			}
																		});
																	} else {
																		showerror(error_text);
																	}
																});
															</script>

															<a href="#" class="fa fa-remove"></a>

														</div>
														<?php if ($featuredartist['profile_image']) { ?>
															<img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $featuredartist['profile_image']; ?> ">
														<?php } else { ?>
															<img src="<?php echo SITE_URL; ?>/profileimages/edit-pro-img-upload.jpg">
														<?php } ?>
														<?php
														$prpackdatestart = date("Y-m-d h:i:s", strtotime($profilepackage['subscription_date']));
														$prpackdateend = date("Y-m-d h:i:s", strtotime($profilepackage['expiry_date']));
														$currentdate = date("Y-m-d h:i:s");
														if ($prpackdatestart < $currentdate && $prpackdateend > $currentdate) { ?>
															<div class="img-top-bar"> <a href="<?php echo SITE_URL; ?>/package/allpackages" class="fa fa-user"></a> </div>
														<?php } ?>
													</div>
													<!-- <div class="allcontact-social">
													<ul class="list-unstyled list-inline">
														<li>
															<a href="javascript:void(0)" class="bg-blue <?php // echo (isset($totaluserlikes) && $totaluserlikes >0)?'active':'';
																										?>" id="likeprofile" data-toggle="tooltip" data-val="<?php // echo ($userid)?$userid:'0' 
																																								?>" title="Like"><i class="fa fa-thumbs-up"></i></a>

															<div class="like"><a href="<?php // echo SITE_URL
																						?>/profile/profilelikedusers/<?php // echo ($userid)?$userid:'0' 
																														?>" data-toggle="modal" class="m-top-5 singlelikeprofile  likeprofile" id="totallikes"><?php // echo $totallikes; 
																																																				?></a></div>
														</li>

														
														
													</ul>     
													
													
														<a href="#" class="fa fa-thumbs-up"></a>
														<a href="#" class="fa fa fa-share"></a>
														<a href="#" class="fa fa-comment"></a>
														<a href="#" class="fa fa-send"></a>
														<a href="#" class="fa fa-download"></a>
														<a href="#" class="fa fa-file"></a>
														<a href="#" class="fa fa-ban"></a>
													</div> -->
													<?php //if($profile['user']['id'] > 0 && $profile['user']['id']!=$id){ 
													?>
													<div class="contact-detail-social-icon profile_action">
														<ul class="list-unstyled">

															<li>
																<?php

																$contactrequest = $this->Comman->contactreqstatus($userid); //pr($contactrequest); die; 
																?>
																<span class="dropdown">
																	<?php if ($contactrequest == 'R') { ?>
																		<a href="javascript:void(0)" style="color: yellow" class="fa fa-user-plus bg-blue bg-blue" title="Request Received"></a>

																	<?php } elseif ($contactrequest == 'S') { ?>
																		<a href="javascript:void(0)" style="color: yellow" class="fa fa-user-plus bg-blue" title="Request Sent"></a>

																	<?php } elseif ($contactrequest == 'C') { ?>
																		<a id="add_friend<?php echo $profile['user']['id']; ?>" class="managefriends fa fa-handshake-o bg-blue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0)" data-val="<?php echo $profile['user']['id']; ?>" data-action="connect"></a>

																	<?php } else { ?>
																		<a id="add_friend<?php echo $profile['user']['id']; ?>" class="dropdown-toggle managefriends fa fa-user-plus bg-blue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0)" data-val="<?php echo $profile['user']['id']; ?>" data-action="connect"> </a>
																	<?php
																	}

																	?>
															</li>
															<?php /* if($contactrequest=='R'){ ?>
																	<li>
																		<a href="javascript:void(0)" style="color: yellow" class="fa fa-user-plus bg-blue bg-blue" title="Request Received"></a>
																	</li>
																<?php }elseif($contactrequest=='S'){ ?>
																	<li>
																		<a href="javascript:void(0)" style="color: yellow" class="fa fa-user-plus bg-blue" title="Request Sent"></a>
																	</li>
																<?php }elseif($contactrequest=='C'){ ?>
																	<li>
																		<a  id="add_friend<?php echo $profile['user']['id'];?>" class="btn btn-default dropdown-toggle  managefriends fa fa-handshake-o bg-blue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0)" data-val="<?php echo $profile['user']['id'];?>" data-action="connect">ddddddddd</a>
																		
																	</li>
																	<?php }elseif($contactrequest=='N'){ ?>
																	<li>
																		<a class="fa fa-user-plus bg-blue" href="javascript:void(0)" onclick="showerror('You are not authorize to make connections.');" data-val="<?php echo $profile['user']['id'];?>"></a>
																		
																	
																	</li>
																	<?php } */ ?>
															<li>
																<a href="javascript:void(0)" class="bg-blue <?php echo (isset($totaluserlikes) && $totaluserlikes > 0) ? 'active' : ''; ?> likeprofile" id="likeprofile<?php echo $userid; ?>" data-toggle="tooltip" data-val="<?php echo ($userid) ? $userid : '0' ?>" title="Like"><i class="fa fa-thumbs-up"></i></a>

																<!-- <div class="like"><a href="<?php //echo SITE_URL
																								?>/profile/profilelikedusers/<?php //echo ($userid)?$userid:'0' 
																																?>" data-toggle="modal" class="m-top-5 singlelikeprofile<?php echo $count; ?>  likeprofile" id="totallikes"><?php //echo $totallikes; 
																																																											?></a></div> -->
															</li>

															<script>
																$('.singlelikeprofile<?php echo $count; ?>').click(function(e) { //alert();
																	e.preventDefault();
																	$('#myModallikesvideo').modal('show').find('.modal-body').load($(this).attr('href'));
																});
																$('#closemodal').click(function() {
																	$('#myModallikesvideo').modal('hide');
																});
															</script>
															<li>
																<!-- <a data-toggle="tooltip" href="javascript:void(0)" class="bg-blue profileshare<?php echo $count; ?>" data-toggle="tooltip" title="Share"><i class="fa fa-share"></i></a> -->

																<div class="share_button profileshare-toggle share-toggle<?php echo $count; ?>" style="display: none;">
																	<ul class="list-unstyled list-inline text-center">
																		<li>
																			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" class="fb-share-button"
																				data-href="<?php echo SITE_URL; ?>/gallery/<?php echo $videos_data['video_name']; ?>" target="_blank"> <i class="fa fa-facebook fa-lg"></i>
																			</a>
																		</li>
																		<li>


																			<a href="https://plus.google.com/share?url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,height=600,width=600');return false;"><i class="fa fa-google-plus fa-lg"></i></a>



																		</li>
																		<li>
																			<a href="http://twitter.com/share?url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" target="_blank"><i class="fa fa-twitter fa-lg"></i></a>
																		</li>

																		<li>
																			<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" target="_blank" title="Share to LinkedIn" class="fa fa-linkedin fa-lg">

																			</a>
																		</li>


																		<li> <a href="javascript:void(0)" class="fa fa-whatsapp fa-lg whatsapps" data-wh="<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>"></a></li>

																	</ul>
																</div>




																<!--<div class="like"><a href="#">18</a></div>-->
															</li>
															<script>
																$(document).ready(function() {
																	$(".profileshare<?php echo $count; ?>").click(function() {
																		$(".share-toggle<?php echo $count; ?>").slideToggle();
																	});
																});
															</script>

															<li> <a href="javascript:void(0)" data-val="<?php echo ($userid) ? $userid : '0' ?>" class="sendmessage bg-blue" data-toggle="tooltip" title="Send Message"><i class="fa fa-envelope"></i></a></li>


															<!--<li><a href="#" class="bg-blue" data-toggle="tooltip" title="Send"><i class="fa fa-paper-plane-o"></i></a></li> -->

															<li>
																<a href="javascript:void(0)"
																	<?php if ($userid > 0 && $userid != $login_user_id) { ?>
																	data-toggle="modal" data-target="#reportuser"
																	<?php } else { ?>
																	onclick="showerror('You cannot report yourself.')"
																	<?php } ?>
																	class="bg-blue"
																	data-toggle="tooltip"
																	title="Report">
																	<i class="fa fa-flag"></i>
																</a>

															</li>


															<?php $userblock = $this->Comman->blockuser($userid); //pr($userblock); 
															?>
															<li><a href="javascript:void(0)" id="blockprofile<?php echo $count; ?>" data-blockid="<?php echo (isset($userblock) && $userblock > 0) ? 'idblocked' : ''; ?>" data-name="<?php echo $profile->name; ?>" data-val="<?php echo ($userid) ? $userid : '0' ?>" class="bg-blue <?php echo (isset($userblock) && $userblock > 0) ? 'active' : ''; ?> " data-toggle="tooltip" title="Block"><i class="fa fa-ban"></i></a></li>

															<script>
																/*  Block Profile profile*/
																$('#blockprofile<?php echo $count; ?>').click(function() {
																	//alert("hello");
																	error_text = "You cannot Block yourself";
																	user_id = $(this).data('val');

																	if (user_id == loginId) {
																		showerror('You can not block yourself');
																		return false
																	}


																	if (user_id > 0) {
																		$.ajax({
																			type: "POST",
																			url: '<?php echo SITE_URL; ?>/profile/blockprofile',
																			data: {
																				user_id: user_id
																			},
																			cache: false,
																			success: function(data) {
																				obj = JSON.parse(data);
																				if (obj.error == 1) {
																					showerror(error_text);
																				} else {
																					if (obj.status == 'block') {
																						$("#blockprofile<?php echo $count; ?>").addClass('active');
																					} else {
																						$("#blockprofile<?php echo $count; ?>").removeClass('active');
																					}
																				}
																			}
																		});
																	} else {
																		showerror(error_text);
																	}
																});
															</script>

															<?php $downloadprofilecheck = $this->Comman->downloadprofile(($userid) ? $userid : '0'); ?>
															<?php if ($downloadprofilecheck != 0) { ?>
																<li> <a href="<?php echo SITE_URL; ?>/profile/profilePdf/<?php echo ($userid) ? $userid : '0' ?>" class="fa fa-download bg-blue" title="Download"></a></li>
															<?php } ?>

															<div class="clearfix"> </div>
														</ul>
													</div>

													<?php $skills = $this->Comman->userskills($featuredartist['user_id']);

													?>



													<div class="all-cnt-det">
														<h5 class="text-center"><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $featuredartist['user_id']; ?>"><?php echo $featuredartist['Profile__name']; ?></a></h5>

														<p class="text-center">
															<?php if ($skills) {
																$knownskills = '';
																foreach ($skills as $skillquote) {
																	if (!empty($knownskills)) {
																		$knownskills = $knownskills . ', ' . $skillquote['skill']['name'];
																	} else {
																		$knownskills = $skillquote['skill']['name'];
																	}
																}
																$output .= str_replace(',', ' ', $knownskills) . ',';
																//$output.=$knownskills.",";	
																echo $knownskills;
															}	?>
														</p>
														<?php
														//echo $profile['current_location']; die;
														if (!empty($profile['current_location'])) { ?>
															<p><?php echo $profile['current_location']; ?></p>
														<?php } ?>
													</div>

													<?php
													if ($featuredartist['user_id'] != $login_user_id) { ?>
														<div class="btn-book text-center">
															<a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $featuredartist['user_id'] ?>" id="booknows" class="btn btn-default">Book Now</a>
															<a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $featuredartist['user_id'] ?>" id="askquot" class="btn btn-primary">Ask For Quote</a>
														</div>

													<?php } ?>
												</div>
											</div>

										<?php $count++;
										} ?>



									</div>


								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</section>

<div class="modal fade" id="reportuser" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Report for this User</h4>
			</div>
			<div class="modal-body">
				<span id="message" style="display: none; color: green"> Report Spam Sent Successfully...</span>
				<span id="wrongmessage" style="display: none; color: red"> Report Spam Not Sent...</span>

				<?php echo $this->Form->create('', array('url' => ['controller' => 'profile', 'action' => 'reportspam'], 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'submit-form', 'autocomplete' => 'off')); ?>

				<?php $reportoption = array('Pornography' => 'Pornography', 'Offensive Behaviour' => 'Offensive Behaviour', 'Fake Profile' => 'Fake Profile', 'Terms and Conditions Violation' => 'Terms and Conditions Violation', 'Spam' => 'Spam', 'Wrong Information displayed' => 'Wrong Information displayed', 'Public Display of Contact Information' => 'Public Display of Contact Information'); ?>
				<?php echo $this->Form->input('reportoption', array('placeholder' => 'Country', 'maxlength' => '25', 'required', 'label' => false, 'type' => 'radio', 'options' => $reportoption)); ?>
				<?php echo $this->Form->input('description', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'type' => 'textarea', 'required', 'label' => false)); ?>
				<?php echo
				$this->Form->input('type', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'required', 'type' => 'hidden', 'label' => false, 'value' => 'profile')); ?>
				<?php echo $this->Form->input('profile_id', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'required', 'type' => 'hidden', 'label' => false, 'value' => $profile['user_id'])); ?>
				<div class="text-right m-top-20"><button class="btn btn-default" id="bn_subscribe">Submit</button>
				</div>
				<?php echo $this->Form->end(); ?>
				<script type="text/javascript">
					$(document).ready(function() {
						$('#imagegallery').lightGallery();
					});
				</script>
			</div>

		</div>
	</div>
</div>


<script type="text/javascript">
	$('#booknows').click(function() {
		var fieldValues = 1;
		sessionStorage.setItem('booknowss', fieldValues);
	});

	$('#askquot').click(function() {
		var fieldValue = 2;
		sessionStorage.setItem('booknowss', fieldValue);
	});
</script>

<script>
	/*  Like Profile profile*/
	$('.likeprofile').click(function() {
		var profile = $(this).data('val');

		if (profile == loginId) {
			showerror('You can not like your own profile');
			return false
		}

		//alert(profile); 
		event.preventDefault();
		$.ajax({
			dataType: "html",
			type: "post",
			evalScripts: true,
			url: '<?php echo SITE_URL; ?>/profile/likeprofile',
			data: {
				user_id: profile
			},
			beforeSend: function() {},
			success: function(response) {
				var myObj = JSON.parse(response);
				//console.log(myobj); 
				if (myObj.status == 'like') {
					$('#likeprofile' + profile).attr('style', 'color: red !important');
				} else {
					$('#likeprofile' + profile).attr('style', 'color: white !important');
				}
			},
			complete: function() {},
			error: function(data) {
				alert(JSON.stringify(data));

			}

		});

	});

	//profile counter
	function profilecounter(obj) {
		$.ajax({
			type: "post",
			url: '<?php echo SITE_URL; ?>/profile/profilecounter',
			data: {
				data: obj
			},
			success: function(data) {
				obj = JSON.parse(data);
				if (obj.status == 1) {
					var div = document.getElementById("newpost");
					div.style.display = "block";
				} else {
					showerror(obj.error);
				}
			}
		});
	}

	function showerror(error) {
		BootstrapDialog.alert({
			size: BootstrapDialog.SIZE_SMALL,
			title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
			message: "<h5>" + error + "</h5>"
		});
		return false;
	}
</script>
<script>
	$(document).ready(function() {
		$("#flip").click(function() {
			var text = $(this).text();
			if (text == "View All") {
				$(this).text("Show Less");
			} else {

				$(this).text("View All");
			}
			$("#panel").slideToggle("slow");
		});
	});
</script>
<script>
	$('.report').click(function(e) {
		e.preventDefault();
		$('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
	});
</script>

<script>
	var site_url = '<?php echo SITE_URL; ?>/';
	/*  Manage friends  */
	$('.managefriends').click(function() {
		user_id = $(this).data('val');
		action = $(this).data('action');

		// console.log('>>>>>>>>',loginId);
		// return false

		if (user_id == loginId) {
			showerror('You can not like your own profile');
			return false
		}

		if (user_id > 0) {
			$.ajax({
				type: "POST",
				url: '<?php echo SITE_URL; ?>/profile/managefriends',
				data: {
					user_id: user_id,
					action: action
				},
				cache: false,
				success: function(data) {
					obj = JSON.parse(data);
					if (obj.status == 0) {
						showerror(obj.error);
					} else {
						location.reload();
					}
				}
			});
		} else {
			showerror(error_text);
		}
	});
</script>



<div id="sendmessage" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body"></div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script>
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
<script>
	$('.sendmessage').click(function(e) {
		e.preventDefault();
		userid = $(this).data('val');

		if (userid == loginId) {
			showerror('You can not like your own profile');
			return false
		}

		messagingurl = '<?php echo SITE_URL; ?>/message/sendmessage/' + userid;
		$('#sendmessage').modal('show').find('.modal-body').load(messagingurl);
	});
</script>

<div id="myModal" class="modal fade">
	<div class="modal-dialog">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Report for this User</h4>
			</div>
			<div class="modal-body"></div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->

</div>
<!-- /.modal -->