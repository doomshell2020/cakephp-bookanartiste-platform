 <div class="col-sm-3">
 	<div class="dropdown mess">
 		<button class="btn message-links btn-cstm-drp dropdown-toggle text-left" type="button" data-toggle="dropdown">Links
 			<span class="caret pull-right"></span></button>
 		<ul class="dropdown-menu">
 			<li><a href="<?php echo SITE_URL; ?>/message/compose/new">Compose</a></li>
 			<li><a href="<?php echo SITE_URL; ?>/message/inbox">Inbox</a></li>
 			<li><a href="<?php echo SITE_URL; ?>/message/sentbox">Sent</a></li>
 			<li><a href="<?php echo SITE_URL; ?>/message/draft">Drafts</a></li>
 			<li><a href="<?php echo SITE_URL; ?>/message/createfolder">Create folder</a></li>
 			<li><a href="<?php echo SITE_URL; ?>/message/folders">Folders</a></li>
 			<li><a href="<?php echo SITE_URL; ?>/message/trash">Deleted message</a></li>
 			<li><a href="<?php echo SITE_URL; ?>/message/inbox/r">Read message</a></li>
 			<li><a href="<?php echo SITE_URL; ?>/message/inbox/u">Unread message</a></li>
 			<li><a href="<?php echo SITE_URL; ?>/message/creategroup">Create a group</a></li>
 		</ul>
 	</div>

 	<div class="side-bar mess-list">
 		<ul class="list-unstyled">
 			<?php
				$menuItems = [
					['action' => 'compose', 'label' => 'Compose', 'url' => '/message/compose/new'],
					['action' => 'inbox', 'label' => 'Inbox', 'url' => '/message/inbox', 'count' => $this->Comman->inboxcount(), 'margin' => 139, 'condition' => $this->request->params['action'] == 'inbox' && empty($this->request->params['pass'][0])],
					['action' => 'sentbox', 'label' => 'Sent', 'url' => '/message/sentbox', 'count' => $this->Comman->sentboxcount(), 'margin' => 140],
					['action' => 'draft', 'label' => 'Drafts', 'url' => '/message/draft', 'count' => $this->Comman->deraft(), 'margin' => 145],
					['action' => 'createfolder', 'label' => 'Create folder', 'url' => '/message/createfolder'],
					['action' => 'folders', 'label' => 'Folders', 'url' => '/message/folders', 'count' => $this->Comman->folder(), 'margin' => 139],
					['action' => 'trash', 'label' => 'Deleted message', 'url' => '/message/trash', 'count' => $this->Comman->trash(), 'margin' => 69],
					['action' => 'inbox', 'label' => 'Read message', 'url' => '/message/inbox/r', 'count' => $this->Comman->readmessage(), 'margin' => 90, 'condition' => $this->request->params['action'] == 'inbox' && $this->request->params['pass'][0] == 'r'],
					['action' => 'inbox', 'label' => 'Unread message', 'url' => '/message/inbox/u', 'count' => $this->Comman->inboxcount(), 'margin' => 90, 'condition' => $this->request->params['action'] == 'inbox' && $this->request->params['pass'][0] == 'u'],
					['action' => 'creategroup', 'label' => 'Create a group', 'url' => '/message/creategroup'],
					['action' => 'groupmessage', 'label' => 'Group Messages', 'url' => '/message/groupmessage'],
				];

				foreach ($menuItems as $item) {
					$isActive = $item['condition'] ?? ($this->request->params['action'] == $item['action']);
					$count = !empty($item['count']) ? count($item['count']) : '';
				?>
 				<li class="<?= $isActive ? 'active' : ''; ?>">
 					<a href="<?= SITE_URL . $item['url']; ?>">
 						<?= $item['label']; ?>
 						<?php if ($count) : ?>
 							<span style="margin-left: <?= $item['margin'] ?? 0; ?>px;"><?= $count; ?></span>
 						<?php endif; ?>
 					</a>
 				</li>
 			<?php } ?>
 		</ul>
 	</div>

 </div>

 <div class="col-sm-9 inbox-search">
 	<div class="row">
 		<div class="col-sm-3">
 			<select name="search_type" class="search-mesage-type">
 				<option value="all" <?php if ($type == 'all') { ?> selected="selected" <?php } ?>>In All Folders</option>
 				<option value="inbox" <?php if ($type == 'inbox') { ?> selected="selected" <?php } ?>>In Inbox</option>
 				<option value="sent" <?php if ($type == 'sent') { ?> selected="selected" <?php } ?>>In Sent</option>
 				<option value="draft" <?php if ($type == 'draft') { ?> selected="selected" <?php } ?>>In Drafts</option>
 				<option value="pfolders" <?php if ($type == 'pfolders') { ?> selected="selected" <?php } ?>>In Personal Folders</option>
 				<option value="deleted" <?php if ($type == 'deleted') { ?> selected="selected" <?php } ?>>In Deleted Items</option>
 			</select>
 		</div>
 		<div class="col-sm-7">
 			<input type="text" id="search-mesage" name="search_keyword" class="form-control search-mesage" onkeypress="searchbyenter();" value="<?php echo $search_keyword; ?>">
 		</div>
 		<div class="col-sm-2"> <a href="Javascript:void(0)" id="search" class="btn btn-primary btn-block">Search</a> </div>
 	</div>

 </div>


 <script>
 	$(document).ready(function() {
 		$("#search").click(function() {
 			search();
 		});
 	});

 	function search() {
 		$("#action").val('search');
 		$('#folder_form').attr('action', 'search');
 		$("#folder_form").submit();
 	}

 	function searchbyenter() {
 		var key = window.event.keyCode;
 		// If the user has pressed enter
 		if (key === 13) {
 			search();
 			return false;
 		} else {
 			return true;
 		}
 	}
 </script>