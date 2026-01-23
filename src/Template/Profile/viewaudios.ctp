<?php echo  $this->element('viewprofile'); ?>
<div class="col-sm-9">

  <div class="col-sm-12 prsnl-det">
    <?php echo $this->element('viewgalleryprofile') ?>
    <h4><span> Audios</span></h4>
    <div class="row">

      <?php
      if (count($audios) > 0) {
        foreach ($audios as $audios_data) { //pr($audios_data);  
      ?>
          <div class="col-sm-4 clearfix text-center audio_sec">
            <div class="audio_img">
              <a data-toggle="modal" 
              class='m-top-5 audio' 
              href="<?php echo SITE_URL ?>/profile/audiosonline/<?php echo $audios_data['id']; ?>" data-val="<?php echo $audios_data['audio_link']; ?>">
              <img src="<?php echo SITE_URL; ?>/images/Audio-icon.png">
            </a>

              <!-- <div><span>Date : </span><?php echo date("d-m-Y", strtotime($audios_data['created'])); ?></div> -->
            </div>
            <div class="audio_name">
              <ul class="list-unstyled">
                <li>
                  <a data-toggle="modal" 
                  class='m-top-5 audio' 
                  href="<?php echo SITE_URL ?>/profile/audiosonline/<?php echo $audios_data['id']; ?>" data-val="<?php echo $audios_data['audio_link']; ?>">
                    <h5 class="video_Heading">
                      <?php echo $audios_data['audio_type']; ?>
                    </h5>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        <?php }
      } else { ?>
        <div class="col-sm-12">No Audios available</div>
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
  $('.audio').click(function(e) {
    e.preventDefault();
    var val = $(this).data('val');
    // window.open(val, '_blank');
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


<div id="myModallikesaudio" class="modal fade">
  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-body" id="skillsetsearch"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->

</div>
<!-- /.modal -->