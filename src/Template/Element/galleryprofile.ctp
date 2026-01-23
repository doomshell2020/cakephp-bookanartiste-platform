  <ul class="nav nav-pills" style="flex:1;">
          <li <?php if ($this->request->params['action'] == 'galleries') { ?> class="active" <?php } ?>><a
                          href="<?php echo SITE_URL; ?>/galleries" class=""><i class="fa fa-picture-o" aria-hidden="true"></i> Photos</a></li>
          <li <?php if ($this->request->params['action'] == 'video') { ?> class="active" <?php } ?>><a
                          href="<?php echo SITE_URL; ?>/galleries/video" class=""><i class="fa fa-video-camera" aria-hidden="true"></i> Video</a></li>
          <li <?php if ($this->request->params['action'] == 'audio') { ?> class="active" <?php } ?>><a
                          href="<?php echo SITE_URL; ?>/galleries/audio" class=""><i class="fa fa-volume-up" aria-hidden="true"></i> Audio</a></li>
  </ul>