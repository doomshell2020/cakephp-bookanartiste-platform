  <?php echo  $this->element('viewprofile'); ?>
  <style>
    .video_caption {
      margin-top: 20px;
      font-weight: bold !important;
      line-height: 25px;
    }
  </style>
  <div class="col-sm-9">
    <div class="col-sm-12 prsnl-det">
      <?php echo $this->element('viewgalleryprofile') ?>
      <h4><span> Videos</span></h4>
      <div class="row">
        <?php
        if (count($videos) > 0) {
          foreach ($videos as $videos_data) { //pr($videos_data); 
        ?>
            <div class="col-sm-4 video_Box" style="text-align:center">
              <a data-toggle="modal" class='m-top-5 videos' href="<?php echo SITE_URL ?>/profile/videosonline/<?php echo $videos_data['id']; ?>">
                <?php if (!empty($videos_data['thumbnail'])) { ?>
                  <img src="<?php echo SITE_URL ?>/videothumb/<?php echo $videos_data['thumbnail'];  ?>" height="auto" width="100%">
                <?php } else { ?>
                  <img src="<?php echo SITE_URL ?>/videothumb/vid-ico.png" height="185px" width="100%" style="border:1px solid black">
                <?php } ?>
              </a>

              <div class="video_caption videomycap<?php echo $videos_data['id']; ?>">
                <h5 class="video_Heading"><?php echo $videos_data['video_name']; ?></h5>
              </div>

            </div>
          <?php }
        } else { ?>
          <div class="col-sm-12">No Videos available</div>
        <?php } ?>
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



  <div id="myModal" class="modal">
    <div class="modal-dialog">

      <div class="modal-content">
        <button type="button" class="videopopclo close" data-dismiss="modal">&times;</button>
        <div class="modal-body" id="videosearch"></div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

  </div>
  <!-- /.modal -->

  <script>
    $('.videos').click(function(e) {
      e.preventDefault();
      $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
    });
  </script>
  <style>
    .modal-dialog {
      width: 80%;
    }

    button.close {
      z-index: 99999 !important;
      right: 0px !important;
      top: -1px !important;
      position: absolute !important;
    }

    .close {
      opacity: 1;
    }

    #images .modal-dialog {
      overflow: initial !important;
    }

    img.single_image:hover {
      cursor: pointer;
    }
  </style>

  <!-- Modal -->

  <div id="myModallikesvideo" class="modal fade">
    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-body" id="likesvideosearch"></div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

  </div>
  <!-- /.modal -->

  <script>
    $(".videopopclo").click(function() { //alert();
      $(".modal-backdrop").removeClass("modal-backdrop fade in");
    });
  </script>


  <!-- Modal -->

  <div id="myModalreportvideo" class="modal fade">
    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-body" id="videosreportuser"></div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

  </div>
  <!-- /.modal -->