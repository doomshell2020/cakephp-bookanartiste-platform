<script>
	$(document).ready(function() { // on document ready
		var dropselvalues = parseInt(sessionStorage.getItem("booknowss"));
		if (dropselvalues === 1) {
			sessionStorage.removeItem('booknowss');
			$(".book").click();
		}
	});

	$(document).ready(function() { // on document ready
		var dropselvalue = parseInt(sessionStorage.getItem("booknowss"));
		if (dropselvalue === 2) {
			sessionStorage.removeItem('booknowss');
			$(".booknow").click();
		}
	});
</script>

<div class="col-sm-3 profile-det">

	<?php
	$id = $this->request->session()->read('Auth.User.id');
	$role_id = $this->request->session()->read('Auth.User.role_id');
	$downloadprofilecheck = $this->Comman->downloadprofile(($userid) ? $userid : '0');
	$contactrequest = $this->Comman->contactreqstatus($userid);

	// pr($profile['user']['role_id']);
	// exit;

	?>

	<div class="profile-det-img">

		<?php if ($profile['social'] == 1 && $profile['profile_image'] != '') { ?>
			<img src="<?php echo $profile['profile_image']; ?>" title="<?php echo $profile->name; ?>">
		<?php } else if ($profile['profile_image'] != '') { ?>
			<img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile->profile_image; ?>" title="<?php echo $profile->name; ?>">
		<?php } else { ?>
			<img src="<?php echo SITE_URL; ?>/images/noimage.jpg" title="<?php echo $profile->name; ?>">
		<?php } ?>

		<div class="img-top-bar">
			<?php $subprpa = $this->Comman->subscriprpack(null); ?>
			<?php if ($subprpa) { ?>
				<a href="<?php echo SITE_URL; ?>/profilepackage" title="<?php echo $subprpa['Profilepack']['name'] . " Profile Package"; ?>"><img src="<?php echo SITE_URL; ?>/images/profile-package.png"></a>
			<?php } ?>
			<?php $subrepa = $this->Comman->subscrirepack(null); ?>

			<?php if ($subrepa) { ?>
				<!-- <a href="<?php echo SITE_URL; ?>/recruiterepackage" title="<?php echo $subrepa['RequirementPack']['name'] . " Recruiter Package"; ?>"><img src="<?php echo SITE_URL; ?>/images/recruiter-package-.png"></a> -->
				<a href="<?php echo SITE_URL; ?>/recruiterepackage" title="<?php echo $subrepa['RecuriterPack']['title'] . " Recruiter Package"; ?>"><img src="<?php echo SITE_URL; ?>/images/recruiter-package-.png"></a>

			<?php } ?>

		</div>
	</div>

	<?php if ($profile['user']['id'] > 0 && $profile['user']['id'] != $id && $profile['user']['role_id'] == TALANT_ROLEID) { ?>
		<a
			href="javascript:void(0)"
			data-val="<?php echo $profile->user_id; ?>"
			data-action="book"
			class="btn btn-default book">Book
			<?php echo $profile->name; ?>
		</a>
		<a
			href="javascript:void(0)"
			data-val="<?php echo $profile->user_id; ?>"
			data-action="askforquote"
			class="btn btn-default booknow">
			Ask for Quote
		</a>

		<!-- <a href="<?php echo SITE_URL; ?>/jobpost/book/<?php echo $profile->user_id; ?>" data-val="<?php echo $profile->user_id; ?>" data-action="book" class="btn btn-default ">Book <?php echo $profile->name; ?> </a> -->
		<!-- <a href="<?php echo SITE_URL; ?>/jobpost/booknow/<?php echo $profile->user_id; ?>" data-val="<?php echo $profile->user_id; ?>" data-action="askforquote" class="btn btn-default">Ask for Quote</a> -->

		<!-- <a href="#" data-toggle="modal" data-target="#booknow<?php echo $profile->user_id; ?>" class="btn btn-default">Ask for Quote</a> -->
		<?php
		// $contactrequest = $this->Comman->contactreqstatus($userid);
		// pr($contactrequest);
		// die;
		?>

		<span class="dropdown">
			<?php if ($contactrequest == 'R') { ?>
				<a href="javascript:void(0)" id="req_rec" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Request Received<span class="caret"></span></a>
				<ul class="dropdown-menu conf-cnt" aria-labelledby="dropdownMenu1">
					<li><a href="javascript:void(0)" class="managefriends" data-val="<?php echo $profile['user']['id']; ?>" data-action="confirm">Accept</a></li>
					<li><a href="javascript:void(0)" class="managefriends" data-val="<?php echo $profile['user']['id']; ?>" data-action="reject">Decline</a></li>
				</ul>
			<?php } elseif ($contactrequest == 'S') { ?>
				<a href="javascript:void(0)" id="add_friend<?php echo $profile['user']['id']; ?>" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Request Sent<span class="caret"></span></a>
				<ul class="dropdown-menu conf-cnt" aria-labelledby="dropdownMenu1">
					<li><a href="javascript:void(0)" class="managefriends" data-val="<?php echo $profile['user']['id']; ?>" data-action="cancel">Cancel</a></li>
				</ul>
			<?php } elseif ($contactrequest == 'C') { ?>
				<a href="javascript:void(0)" id="add_friend<?php echo $profile['user']['id']; ?>" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Connections<span class="caret"></span></a>
				<ul class="dropdown-menu conf-cnt" aria-labelledby="dropdownMenu1">
					<li><a href="javascript:void(0)" class="managefriends" data-val="<?php echo $profile['user']['id']; ?>" data-action="remove">Remove</a></li>
				</ul>
			<?php } else { ?>
				<a id="add_friend<?php echo $profile['user']['id']; ?>" class="btn btn-default dropdown-toggle managefriends" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0)" data-val="<?php echo $profile['user']['id']; ?>" data-action="connect"> Connect</a>
			<?php } ?>
		</span>

	<?php } ?>

	<?php if ($profile['user']['id'] > 0 && $profile['user']['id'] != $id) { ?>
		<div class="contact-detail-social-icon profile_action">
			<ul class="list-unstyled">

				<li>
					<?php
					if ($role_id == TALANT_ROLEID) {
					?>
						<span class="dropdown">
							<?php if ($contactrequest == 'R') { ?>
								<a href="javascript:void(0)" style="color: yellow" class="fa fa-user-plus bg-blue bg-blue" title="Request Received"></a>

							<?php } elseif ($contactrequest == 'S') { ?>
								<a href="javascript:void(0)" style="color: yellow" class="fa fa-user-plus bg-blue" title="Request Sent"></a>

							<?php } elseif ($contactrequest == 'RR') { ?>

								<a class="dropdown-toggle fa fa-user-plus bg-blue" data-toggle="dropdown" title="Request Rejected" aria-haspopup="true" aria-expanded="true" href="javascript:void(0)" style="color: red">
								</a>
								<!-- <a href="javascript:void(0)" style="color: red" class="fa fa-user-times bg-red" title="Request Rejected"></a> -->
							<?php } elseif ($contactrequest == 'C') { ?>
								<a id="add_friend<?php echo $profile['user']['id']; ?>" class="managefriends fa fa-handshake-o bg-blue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0)" data-val="<?php echo $profile['user']['id']; ?>" data-action="connected"></a>

							<?php } else { ?>
								<a id="add_friend<?php echo $profile['user']['id']; ?>" class="dropdown-toggle managefriends fa fa-user-plus bg-blue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" href="javascript:void(0)" data-val="<?php echo $profile['user']['id']; ?>" data-action="connect"> </a>
							<?php
							}
						} else { ?>

							<!-- <a class="fa fa-user-plus bg-blue" href="javascript:void(0)" onclick="showerror('You are not authorize to make connections.');" data-val="<?php echo $profile['user']['id']; ?>"></a> -->

						<?php }
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
					<a href="javascript:void(0)" class="bg-blue <?php echo (isset($totaluserlikes) && $totaluserlikes > 0) ? 'active' : ''; ?>" id="likeprofile" data-toggle="tooltip" data-val="<?php echo ($userid) ? $userid : '0' ?>" title="Like"><i class="fa fa-thumbs-up"></i></a>

					<div class="like"><a href="<?php echo SITE_URL ?>/profile/profilelikedusers/<?php echo ($userid) ? $userid : '0' ?>" data-toggle="modal" class="m-top-5 singlelikeprofile  likeprofile" id="totallikes"><?php echo $totallikes; ?></a></div>
				</li>

				<script>
					$('.singlelikeprofile').click(function(e) { //alert();
						e.preventDefault();
						$('#myModallikesvideo').modal('show').find('.modal-body').load($(this).attr('href'));
					});
					$('#closemodal').click(function() {
						$('#myModallikesvideo').modal('hide');
					});
				</script>
				<li> <a data-toggle="tooltip" href="javascript:void(0)" class="bg-blue profileshare" data-toggle="tooltip" title="Share"><i class="fa fa-share"></i></a>

					<div class="share_button profileshare-toggle" style="display: none;">
						<ul class="list-unstyled list-inline text-center">
							<li>
								<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo SITE_URL; ?>/viewprofile/<?php echo ($userid) ? $userid : '0' ?>" class="fb-share-button" data-href="<?php echo urlencode(SITE_URL . '/gallery/' . $videos_data['video_name']); ?>" target="_blank"> <i class="fa fa-facebook fa-lg"></i>
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
					<div class="like"><a href="#"></a></div>
				</li>

				<script>
					$(document).ready(function() {
						$(".profileshare").click(function() {
							$(".profileshare-toggle").slideToggle();
						});
					});
				</script>

				<li>
					<!-- by rupam sir -->
					<a href="javascript:void(0)" data-val="<?php echo ($userid) ? $userid : '0' ?>" class="sendmessage bg-blue" data-toggle="tooltip" title="Send Message"><i class="fa fa-envelope"></i></a>
					<!-- <a href="<?php echo SITE_URL; ?>/message/sendmessage/<?php echo $value['user_id']; ?>"  data-toggle="tooltip" title="Send message" class="bg-blue"><i class="fa fa-envelope"></i></a> -->
				</li>


				<!--<li><a href="#" class="bg-blue" data-toggle="tooltip" title="Send"><i class="fa fa-paper-plane-o"></i></a></li> -->

				<li> <a href="javascript:void(0)" <?php if ($userid > 0) { ?> data-toggle="modal" data-target="#reportuser" <?php } else { ?> onclick="showerror('You cannot Report for yourself.')" <?php } ?> class="bg-blue" data-toggle="tooltip" title="Report"><i class="fa fa-flag"></i></a></li>


				<li>
					<?php if ($userblock) { ?>
						<a href="javascript:void(0)" id="blockprofile" data-blockid="<?php echo (isset($userblock) && $userblock > 0) ? 'idblocked' : ''; ?>" data-name="<?php echo $profile->name; ?>" data-val="<?php echo ($userid) ? $userid : '0' ?>" class="bg-blue <?php echo (isset($userblock) && $userblock > 0) ? 'active' : ''; ?> " data-toggle="tooltip" title="Unblock"><i class="fa fa-ban"></i></a>
					<?php } else { ?>
						<a href="javascript:void(0)" id="blockprofile" data-blockid="<?php echo (isset($userblock) && $userblock > 0) ? 'idblocked' : ''; ?>" data-name="<?php echo $profile->name; ?>" data-val="<?php echo ($userid) ? $userid : '0' ?>" class="bg-blue <?php echo (isset($userblock) && $userblock > 0) ? 'active' : ''; ?> " data-toggle="tooltip" title="Block"><i class="fa fa-ban"></i></a>
					<?php } ?>
				</li>

				<?php if ($downloadprofilecheck != 0) { ?>
					<li>
						<a href="<?php echo SITE_URL; ?>/profile/profilePdf/<?php echo ($userid) ? $userid : '0' ?>" class="fa fa-download bg-blue" title="Download">

						</a>
					</li>
				<?php } ?>

				<?php $saveprofile = $this->Comman->userprofilesave(); ?>

				<li>
					<a href="javascript:void(0)" id="saveprofile" class="fa fa-floppy-o bg-blue <?php echo (isset($saveprofile) && $saveprofile > 0) ? 'active' : ''; ?>" data-val="<?php echo ($userid) ? $userid : '0' ?>" title="Save">
					</a>
				</li>

				<div class="clearfix"> </div>
			</ul>
		</div>
	<?php } ?>

	<script>
		var site_url = '<?php echo SITE_URL; ?>';
		/*  Manage friends  */
		$('.managefriends').click(function() {
			user_id = $(this).data('val');
			action = $(this).data('action');
			if (action == 'connected') {
				showerror('You are already friend');
				return true;
			}
			// const conf = confirm(`Are you sure you want to send request ${action}?`);

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
							showerror(obj.error_text);
						} else {
							showerror(obj.error_text);
							setTimeout(() => {
								location.reload();
							}, 2000);
						}
					}
				});
			}
		});
	</script>



	<div class="contact-friend">
		<h4>Contacts</h4>(<a class="viewallcontact_brn" href="<?php echo SITE_URL; ?>/allcontacts/<?php echo $userid;  ?>">See Network</a>)
		<?php
		if (count($friends) > 0) { ?>
			<ul class="list-unstyled">
				<?php
				foreach ($friends as $friendss) {
				?>
					<?php if ($friendss['profile_image'] != '') { ?>
						<li><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $friendss['user_id'];  ?>" title="<?php echo $friendss['name'];  ?>"><img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $friendss['profile_image'];  ?>"></a></li>
					<?php  } else { ?>
						<li><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $friendss['user_id'];  ?>" title="<?php echo $friendss['name'];  ?>"><img src="<?php echo SITE_URL; ?>/images/noimage.jpg"></a></li>

					<?php } ?>
				<?php
				}
				?>
			</ul>
		<?php } ?>
		<?php //pr($profile); die;
		//echo $this->request->session()->read('Auth.User.id'); 
		if ($profile['user_id'] == $this->request->session()->read('Auth.User.id')) { ?>
			<a href="javascript:void(0)" id="button" class="btn btn-default" onclick="profilecounter(<?php echo $profile['user']['id']; ?>);">Contact Detail</a>
			<?php } else {
			if ($downloadprofilecheck != 0) {
				if (count($profile) > 0) { ?>
					<a href="javascript:void(0)" id="button" class="btn btn-default" onclick="profilecounter(<?php echo $profile['user']['id']; ?>);">Contact Detail</a>
		<?php }
			}
		} ?>


	</div>
	<?php // $userid =  $this->request->session()->read('Auth.User.id'); 
	?>
	<div class="contact-detail" id="newpost" style="display: none;">
		<ul>
			<?php if ($profile->user->email != '') { ?>
				<li style="position:relative;">
					<i class="fa fa-user"></i>
					<?php echo $profile->user->email; ?>
					<?php if ($profile->user->isvarify == "Y") { ?>
						<!-- <img src="<?php echo SITE_URL; ?>/images/correct.png" style="width:12px; height:12px; position:absolute; top:10px; right:15px;"> -->
						<i title="Verified Email" class="verified fa fa-check-circle" aria-hidden="true" style="position : absolute; right:4px; top:10px; z-index:9; color: green;"></i>
						<!-- <i class="fa fa-check" aria-hidden="true" style="color:green;"></i> -->
					<?php } ?>
				</li>
			<?php } ?>
			<?php if ($profile->country->name != '') { ?>
				<li><i class="fa fa-map-marker"></i><?php echo $profile->country->name; ?> </li>
			<?php } ?>
			<?php if ($profile->state->name != '') { ?>
				<li><i class="fa fa-map-marker"></i><?php echo $profile->state->name; ?> </li>
			<?php } ?>

			<?php if ($profile->city->name != '') { ?>
				<li><i class="fa fa-map-marker"></i><?php echo $profile->city->name; ?></li>
			<?php } ?>
			<?php /* ?>
			<?php if ($profile['user']['id']==$id){ ?>
			<?php if($profile->phone!=''){ ?>
		<li><i class="fa fa-phone"></i><a href="javascript:void(0);" id="editphone" data-name="phone" data-model="Profile" data-type="text" data-pk="<?php echo $profile['id']; ?>"data-defaultvalue="<?php echo $profile->phone; ?>" data-url="<?php echo SITE_URL?>/profile/editableprofile/" data-title="Mobile"><?php echo $profile->phone; ?> 
		<?php $id = $this->request->session()->read('Auth.User.id'); ?>
		
		<span class="editphone"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>	
		
		<?php } } ?></a>
		</li>
		
		<?php */ ?>
			<?php  /* -------------this data url not wroking not editable then change the href url and direct the open profile page  */ ?>

			<?php if ($profile->phone != '') { ?>
				<li><i class="fa fa-phone"></i>
					<!-- <a href="javascript:void(0);" id="editphone" data-name="phone" data-model="Profile" data-type="text" data-pk="<?php echo $profile['id']; ?>" data-url="<?php echo SITE_URL; ?>/profile/editableprofile/" data-title="Mobile"><?php echo $profile->phone; ?>
						<?php $id = $this->request->session()->read('Auth.User.id'); ?>
						<?php if ($profile['user']['id'] == $id) { ?>
							<span class="editphone"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>
						<?php } ?></a> -->
					<!-- its direct link add edit profile -->
					<a href="<?php echo SITE_URL; ?>/profile" id="editphone" data-name="phone" data-model="Profile" data-type="text" data-pk="<?php echo $profile['id']; ?>" data-url="<?php echo SITE_URL; ?>/profile/editableprofile/" data-title="Mobile"><?php echo $profile->phone; ?>
						<?php $id = $this->request->session()->read('Auth.User.id'); ?>
						<?php if ($profile['user']['id'] == $id) { ?>
							<span class="editphone"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>
						<?php } ?></a>


				</li>
			<?php } ?>


			<?php if ($profile->altemail != '') { ?>

				<li><i class="fa fa-envelope"></i>
					<!-- <a href="javascript:void(0);" id="altemail" data-name="altemail" data-model="Profile" data-type="email" data-pk="<?php echo $profile['id']; ?>" data-url="<?php echo SITE_URL ?>/profile/editableprofile/" data-title="Email"><?php echo str_replace(',', ',<br />', $profile['altemail']); ?>
						<?php $id = $this->request->session()->read('Auth.User.id'); ?>
						<?php if ($profile['user']['id'] == $id) { ?>
							<span class="edittablealtemail"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>
						<?php } ?></a> -->
					<a href="<?php echo SITE_URL ?>/profile" id="altemail" data-name="altemail" data-model="Profile" data-type="email" data-pk="<?php echo $profile['id']; ?>" data-url="<?php echo SITE_URL ?>/profile/editableprofile/" data-title="Email"><?php echo str_replace(',', ',<br />', $profile['altemail']); ?>
						<?php $id = $this->request->session()->read('Auth.User.id'); ?>
						<?php if ($profile['user']['id'] == $id) { ?>
							<span class="edittablealtemail"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>
						<?php } ?></a>
				</li>
			<?php } ?>

			<?php if ($profile->altnumber != '') { ?>
				<li>
					<i class="fa fa-phone"></i>
					<!-- by rupam sir -->
					<!-- this code not edit  -->
					<!-- <a href="javascript:void(0);" id="altnumber" data-name="altnumber" data-model="Profile" data-type="text" data-pk="<?php echo $profile['id']; ?>" data-url="<?php echo SITE_URL ?>/profile/editableprofile/" data-title="Alternate Mobile"><?php echo $profile->altnumber; ?>
						<?php $id = $this->request->session()->read('Auth.User.id'); ?>
						<?php if ($profile['user']['id'] == $id) { ?>
							<span class="editaltnumber"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>
						<?php } ?></a> -->
					<!-- new code -->
					<a href="<?php echo SITE_URL; ?>/profile" id="altnumber" data-name="altnumber" data-model="Profile" data-type="text" data-pk="<?php echo $profile['id']; ?>" data-url="<?php echo SITE_URL ?>/profile/editableprofile/" data-title="Alternate Mobile"><?php echo $profile->altnumber; ?>
						<?php $id = $this->request->session()->read('Auth.User.id'); ?>
						<?php if ($profile['user']['id'] == $id) { ?>
							<span class="editaltnumber"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>
						<?php } ?></a>
					<!-- end code -->

				</li>
			<?php } ?>

			<?php if ($profile->guadian_name != '') { ?>
				<li>
					<i class="fa fa-user"></i>
					<!-- <a href="javascript:void(0);" id="guadian_name" data-name="guadian_name" data-model="Profile" data-type="text" data-pk="<?php echo $profile['id']; ?>" data-url="<?php echo SITE_URL ?>/profile/editableprofile/" data-title="Guardian Email"><?php echo $profile->guadian_name; ?>
						<?php $id = $this->request->session()->read('Auth.User.id'); ?>
						<?php if ($profile['user']['id'] == $id) { ?>
							<span class="editableguaname"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>
						<?php } ?></a> -->
					<a href="<?php echo SITE_URL ?>/profile" id="guadian_name" data-name="guadian_name" data-model="Profile" data-type="text" data-pk="<?php echo $profile['id']; ?>" data-url="<?php echo SITE_URL ?>/profile/editableprofile/" data-title="Guardian Email"><?php echo $profile->guadian_name; ?>
						<?php $id = $this->request->session()->read('Auth.User.id'); ?>
						<?php if ($profile['user']['id'] == $id) { ?>
							<span class="editableguaname"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>
						<?php } ?></a>

				</li>
			<?php } ?>

			<?php if ($profile->guardian_email != '') { ?>


				<li>
					<i class="fa fa-user"></i>
					<!-- <a href="javascript:void(0);" id="guardian_email" data-name="guardian_email" data-model="Profile" data-type="email" data-pk="<?php echo $profile['id']; ?>" data-url="<?php echo SITE_URL ?>/profile/editableprofile/" data-title="Guardian Email"><?php echo $profile->guardian_email; ?>
						<?php $id = $this->request->session()->read('Auth.User.id'); ?>
						<?php if ($profile['user']['id'] == $id) { ?>
							<span class="editableguaemail"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>
						<?php } ?></a> -->
					<a href="<?php echo SITE_URL ?>/profile" id="guardian_email" data-name="guardian_email" data-model="Profile" data-type="email" data-pk="<?php echo $profile['id']; ?>" data-url="<?php echo SITE_URL ?>/profile/editableprofile/" data-title="Guardian Email"><?php echo $profile->guardian_email; ?>
						<?php $id = $this->request->session()->read('Auth.User.id'); ?>
						<?php if ($profile['user']['id'] == $id) { ?>
							<span class="editableguaemail"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>
						<?php } ?></a>
				</li>
			<?php } ?>

			<?php if ($profile->guardian_phone != '') { ?>
				<li><i class="fa fa-phone"></i>
					<!-- <a href="javascript:void(0);" id="guardian_phone" data-name="guardian_phone" data-model="Profile" data-type="text" data-pk="<?php echo $profile['id']; ?>" data-url="<?php echo SITE_URL ?>/profile/editableprofile/" data-title="Alternate Mobile"><?php echo $profile->guardian_phone; ?>
						<?php $id = $this->request->session()->read('Auth.User.id'); ?>
						<?php if ($profile['user']['id'] == $id) { ?>
							<span class="editguanumber"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>
						<?php } ?></a> -->
					<a href="<?php echo SITE_URL ?>/profile" id="guardian_phone" data-name="guardian_phone" data-model="Profile" data-type="text" data-pk="<?php echo $profile['id']; ?>" data-url="<?php echo SITE_URL ?>/profile/editableprofile/" data-title="Alternate Mobile"><?php echo $profile->guardian_phone; ?>
						<?php $id = $this->request->session()->read('Auth.User.id'); ?>
						<?php if ($profile['user']['id'] == $id) { ?>
							<span class="editguanumber"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>
						<?php } ?></a>

				</li>
			<?php } ?>

			<?php if ($profile->skypeid != '') { ?>
				<li><i class="fa fa-skype"></i>
					<!-- <a href="javascript:void(0);" id="skypeid" data-name="skypeid" data-model="Profile" data-type="text" data-pk="<?php echo $profile['id']; ?>" data-url="<?php echo SITE_URL ?>/profile/editableprofile/" data-title="Skype ID"><?php echo $profile->skypeid; ?>
						<?php $id = $this->request->session()->read('Auth.User.id'); ?>
						<?php if ($profile['user']['id'] == $id) { ?>
							<span class="editableskypeid"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>
						<?php } ?></a> -->
					<a href="<?php echo SITE_URL ?>/profile/" id="skypeid" data-name="skypeid" data-model="Profile" data-type="text" data-pk="<?php echo $profile['id']; ?>" data-url="<?php echo SITE_URL ?>/profile/editableprofile/" data-title="Skype ID"><?php echo $profile->skypeid; ?>
						<?php $id = $this->request->session()->read('Auth.User.id'); ?>
						<?php if ($profile['user']['id'] == $id) { ?>
							<span class="editableskypeid"><i class="edit fa fa-pencil" aria-hidden="true"></i></span>
						<?php } ?></a>


				</li>
			<?php } ?>

			<li><?php //echo $profile->location; 
				?></li>

		</ul>
		<?php  /* -------------end code ------------  */ ?>
	</div>
	<!--
		<div> <a href="<?php //echo SITE_URL; 
						?>/profile" class="btn btn-default">Edit Profile</a> <a href="#" data-toggle="tooltip" title="Download Profile" class="fa fa-download fa-2x m-left-10"></a> </div> -->

	<?php
	$id = $this->request->session()->read('Auth.User.id');
	$advrtprofile = $this->Comman->advertisedprofile($id);
	$access_adds = $this->Comman->isaccessadds($id);
	//pr($advrtprofile); die; 
	if ($access_adds['access_adds'] == 'Y') { ?>
		<div class="owl-carousel owl-theme owl-loaded advrtpro" id="adproprofile">
			<?php foreach ($advrtprofile as $key => $value) {
				$userskills = $this->Comman->userskills($value['pro_id']);

			?>
				<div class="owl-item proadmain">
					<a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $value['pro_id']; ?>" target="_blank">
						<div>
							<?php if ($value['advrt_image']) { ?>
								<img src="<?php echo SITE_URL; ?>/profileimages/<?php echo $value['advrt_image']; ?>">
							<?php } else { ?>
								<img src="<?php echo SITE_URL; ?>/images/noimage.jpg">
							<?php } ?>
						</div>
						<div class="advrttext">
							<?php
							echo $value['advrtpro__title'] . "<br>";
							foreach ($userskills as $key => $skillvalue) {
								echo $skillvalue['skill']['name'] . ",";
							}
							echo "<br>" . $value['location'] . "<br>";
							?>
						</div>

					</a>
					<?php if ($access_adds['role_id'] == TALANT_ROLEID) { ?>
						<a href="<?php echo SITE_URL; ?>/advertiseprofile" target="_blank" class="admyreqr" data-toggle="popover" data-trigger="hover" title="Advertise My Profile">+</a>
					<?php } ?>

				</div>
			<?php } ?>
		</div>
	<?php } ?>

</div>

<script>
	$('#adproprofile').owlCarousel({
		loop: false,
		margin: 10,
		nav: true,
		dots: false,
		responsive: {
			0: {
				items: 1
			},
			600: {
				items: 1
			},
			1000: {
				items: 1
			}
		}
	})
</script>


<style type="text/css">
	.advrtpro.owl-carousel .owl-nav .owl-next,
	.advrtpro.owl-carousel .owl-nav .owl-prev {
		font-size: 0px;
		position: absolute;
		top: 42%;
	}


	.advrtpro.owl-carousel .owl-nav .owl-prev:before {
		content: '\f104';
		color: #0c8fe7;
		font: normal normal normal 28px/1 FontAwesome;
		font-weight: bold;
	}

	.advrtpro.owl-carousel .owl-nav .owl-prev {
		left: 5px;
		background-color: rgba(176, 170, 170, 0.6);
		padding: 2px 8px;
	}

	.advrtpro.owl-carousel .owl-nav .owl-next:before {
		content: '\f105';
		color: #0c8fe7;
		font: normal normal normal 28px/1 FontAwesome;
		font-weight: bold;
	}

	.advrtpro.owl-carousel .owl-nav .owl-next {
		right: 5px;
		background-color: rgba(176, 170, 170, 0.6);
		padding: 2px 8px;
	}

	.proadmain {
		margin-top: 15px;
		width: 100%;
		position: relative;

	}

	.proadmain img {
		min-height: 265px !important;
		border-bottom: 4px #1a8fe4 solid;
	}

	.advrtpro {
		box-shadow: 1px 1px 11px 0px #a2a2a2;
	}

	.proadmain a {
		width: 100%;
	}

	.proadmain img {
		width: 100%;
	}

	.advrttext {
		text-align: center;
		color: #000000;
		font-size: 16px;
	}

	.admyreqr {
		display: none;
	}

	.container {
		position: relative;
	}

	/* Checkbox and radio inputs */
	.container .checkbox input[type="checkbox"],
	.container .checkbox-inline input[type="checkbox"],
	.container .radio input[type="radio"],
	.container .radio-inline input[type="radio"] {
		position: relative;
		margin-left: auto;
		height: 34px;


		/* Add any other styles you need */
	}

	/* Text and textarea inputs */
	.container input[type="text"],
	.container textarea {
		position: static;
		/* Add any other styles you need */
	}
</style>

<script>
	function profilecounter(obj) {
		$.ajax({
			type: "post",
			url: '<?php echo SITE_URL; ?>/profile/profilecounter',
			data: {
				data: obj
			},
			success: function(data) {
				obj = JSON.parse(data);
				// console.log('>>>>>>>>>>>',obj);
				if (obj.status == 1) {
					$("#newpost").slideToggle("fast");
				} else {
					showerror(obj.error);
				}
			}
		});
	}
</script>

<!-- Modal -->
<div id="bookbooking" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="text-align: center;">Select Job's To Send Request</h4>
			</div>
			<div class="modal-body"></div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal -->
<div id="booknow" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="text-align: center;">Select Job's To Send Request</h4>
			</div>
			<div class="modal-body"></div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- new modal ask for quote -->
<div id="booknow<?php echo $profile->user_id; ?>" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="text-align: center;">Select Job's To Send Request</h4>
			</div>
			<div class="modal-body"></div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- ask for quote -->

<!-- Modal -->
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
				<?php echo $this->Form->input('reportoption', array('class' => 'form-control', 'placeholder' => 'Country', 'maxlength' => '25', 'required', 'label' => false, 'type' => 'radio', 'options' => $reportoption)); ?>
				<?php echo $this->Form->input('description', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'type' => 'textarea', 'required', 'label' => false)); ?>
				<?php echo
				$this->Form->input('type', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'required', 'type' => 'hidden', 'label' => false, 'value' => 'profile')); ?>
				<?php echo $this->Form->input('profile_id', array('class' => 'form-control', 'placeholder' => 'description', 'maxlength' => '25', 'required', 'type' => 'hidden', 'label' => false, 'value' => $profile['user_id'])); ?>

				<div class="text-right m-top-20" style="text-align: center;"><button class="btn btn-default" id="bn_subscribe">Submit</button></div>
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
<!-- Booking request  -->
<script>
	$('.booknow').click(function(e) {
		e.preventDefault();
		action = $(this).data('action');

		userid = $(this).data('val');
		bookingurl = '<?php echo SITE_URL; ?>/jobpost/booknow/' + userid + '/' + action;
		$('#booknow').modal('show').find('.modal-body').load(bookingurl);
	});
</script>

<!-- Booking request  -->
<script>
	$('.book').click(function(e) {
		e.preventDefault();
		action = $(this).data('action');
		userid = $(this).data('val');
		bookingurl = '<?php echo SITE_URL; ?>/jobpost/book/' + userid + '/' + action;
		$('#bookbooking').modal('show').find('.modal-body').load(bookingurl);
	});
</script>

<!-- Send Message  -->
<script>
	$('.sendmessage').click(function(e) {
		e.preventDefault();
		userid = $(this).data('val');
		messagingurl = '<?php echo SITE_URL; ?>/message/sendmessage/' + userid;
		$('#sendmessage').modal('show').find('.modal-body').load(messagingurl);
	});
</script>

<script type="text/javascript">
	/*  Report spam for profile*/
	$('#bn_subscribe').click(function() {
		$.ajax({
			type: "POST",
			url: '<?php echo SITE_URL; ?>/profile/reportspam',
			data: $('#submit-form').serialize(),
			cache: false,
			success: function(data) {
				obj = JSON.parse(data);
				if (obj.status != 1) {
					$('#reportuser').modal('toggle');
					showerror(obj.error);
				} else {
					$('#reportuser').modal('toggle');
					success = "You have been reported for this user successfully.";
					showerror(success);
				}
			}
		});
	});
	/* Saved profile */
	$('#saveprofile').click(function() {
		error_text = "You cannot saved yourself";
		user_id = $(this).data('val');
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
						$("#saveprofile").addClass('active');
					} else {
						$("#saveprofile").removeClass('active');
					}
					//$("#totallikes").html(obj.count);

				}
			});
		} else {
			showerror(error_text);
		}
	});
	/*  Like Profile profile*/
	$('#likeprofile').click(function() {
		error_text = "You cannot Like yourself";
		user_id = $(this).data('val');
		user_id = $(this).data('val');
		if (user_id > 0) {
			$.ajax({
				type: "POST",
				url: '<?php echo SITE_URL; ?>/profile/likeprofile',
				data: {
					user_id: user_id
				},
				cache: false,
				success: function(data) {
					obj = JSON.parse(data);
					if (obj.error == 1) {
						showerror(error_text);
					} else {
						if (obj.status == 'like') {
							$("#likeprofile").addClass('active');
						} else {
							$("#likeprofile").removeClass('active');
						}
						$("#totallikes").html(obj.count);
					}
				}
			});
		} else {
			showerror(error_text);
		}
	});
	/*  Block Profile profile*/
	$('#blockprofile').click(function() {
		error_text = "You cannot Block yourself";
		user_id = $(this).data('val');
		user_name = $(this).data('name');
		blockcheck = $(this).data('blockid');

		if (blockcheck) {
			var answer = confirm('Are you sure you want to unblock ?');
		} else {
			var answer = confirm('Are you sure you want to block ' + user_name);
		}

		if (answer) {
			$(this).attr('data-blockid', 'idblocked');
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
								$("#blockprofile").addClass('active');
								showerror(obj.msg);
								setTimeout(() => {
									location.reload();
								}, 3000);
							} else {
								$("#blockprofile").removeClass('active');
								showerror(obj.msg);
								setTimeout(() => {
									location.reload();
								}, 3000);
							}
						}
					}
				});
			} else {
				showerror(error_text);
			}
		} else {
			$(this).attr('data-blockid', '');
		}

	});

	function showerror(error) {
		BootstrapDialog.alert({
			size: BootstrapDialog.SIZE_SMALL,
			title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !",
			message: "<h5>" + error + "</h5>"
		});
		return false;
	}
</script>

<script type="text/javascript">
	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};

	$(document).on("click", '.whatsapps', function() {

		if (isMobile.any()) {
			var text = $(this).attr("data-wh");
			var whatsapp_url = "whatsapp://send?text=" + text;
			window.location.href = whatsapp_url;
		} else {
			alert("whatsup sharing allow only in mobile device");
		}
	});
</script>

<script>
	// BootstrapDialog.alert('I want banana!');
	// .modal - backdrop {
	// 	display: none;
	// }
	// $(".bootstrap-dialog").css("display", "block")
	// success = "You have been reported for this user Successfully.";

	// showerror('gfdgfd');

	// function showerrorrrr(error) {
	// 	BootstrapDialog.alert({
	// 		size: BootstrapDialog.SIZE_SMALL,
	// 		title: "<img title='Book an Artiste' src='<?php //echo SITE_URL;
															// 													
															?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
	// 		message: "<h5>" + error + "</h5>"
	// 	});
	// 	return false;
	// }
</script>