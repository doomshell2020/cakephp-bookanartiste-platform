<style>
    .overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        transition: .5s ease;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .my_img .overlay i {
        position: static;
        top: inherit;
        left: inherit;
        color: #fff;
        font-size: 16px;
        z-index: 9;

        transform: none !important;
    }
</style>
<?php //pr($packfeature); 
//   if($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID){

//   	$audioLimit = $packfeature['non_talent_audio_list_total'];
//   }else{

//   	$audioLimit = $packfeature['talent_audio_list_total'];
//   }
$audioLimit = 100;
?>
<!----------------------editprofile-strt------------------------>
<section id="edit_profile" class="gallery_tab">
    <div class="container">
        <h2> <span>Audio</span></h2>
        <p class="m-bott-50">Here You Can Manage Your Audio</p>
        <?php echo $this->Flash->render(); ?>
        <div class="row">
            <?php echo  $this->element('editprofile') ?>
            <div class="tab-content">
                <div id="Gallery" class="galleryTabContainer">
                    <div class="container m-top-60">
                        <div class="galleryTopBar pva_tab">
                            <?php echo  $this->element('galleryprofile') ?>
                            <?php $uid = $this->request->session()->read('Auth.User.id'); ?>
                                
                                <a class="btn btn-primary" style="margin-left:15px;" data-toggle="modal"
                                data-target="#addaudio">Add
                                Audio</a>
                                
                                <a class="btn btn-default" href="<?php echo SITE_URL; ?>/viewaudios/<?php echo $uid; ?>">
                                    Already uploaded audios
                                </a>
                            <a class="btn btn-primary"
                                style="margin-left:11px; background:#f4434d !important" data-toggle="modal"
                                data-target="#audiolist"> 
                                Audio Sites List</a>
                        </div>
                        <div class="tab-content">
                            <div id="picture" class="tab-pane fade in active">
                                <div class="">
                                    <div class="row">
                                        <?php $i = 1;
                                        foreach ($audioprofile as $gall) {  //pr($gall);  die;
                                        ?>
                                            <div id="div1<?php echo $gall['id'] ?>">
                                                <div class="col-xs-6 col-sm-4 col-md-2 my-album-images" data-src="">
                                                    <div class="my_img">
                                                        <?php if ($i > $audioLimit) {  ?>
                                                            <div class="invisble_audi"
                                                                style="position: absolute;left: 0;right: 0; bottom: 0; top: 0; z-index: 99; background-color: rgba(0,0,0,0.7);">
                                                                <img src="<?php echo SITE_URL ?>/images/invisible.png">
                                                            </div>
                                                            <img src="<?php echo SITE_URL ?>/images/Audio-icon.png">
                                                        <?php } else {  ?>
                                                            <img src="<?php echo SITE_URL ?>/images/Audio-icon.png">
                                                        <?php } ?>
                                                        <div class="overlay">
                                                            <a data-toggle="modal" class='data editButton'
                                                                href="<?php echo SITE_URL ?>/profile/audiodetail/<?php echo $gall['id']; ?>" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a
                                                                href="<?php echo SITE_URL ?>/profile/deleteaudio/<?php echo $gall['id']; ?>"
                                                                class="deleteButton" data-toggle="tooltip"
                                                                data-placement="top" title="Delete"
                                                                onclick="if(!confirm('Are You Sure You Want To Delete <?php echo $gall['audio_type']; ?> Audio?')) return false;">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </a>
                                                        </div>
                                                        <div class="text-center">
                                                            <h4><?php echo $gall['audio_type']; ?></h4>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        <?php $i++;
                                        } ?>
                                        <?php if (empty($audioprofile)) { ?>
                                            <span style="margin-left:12px;">No Audio Found</span>
                                        <?php } ?>
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                                    <div class="clearfix">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<div id="audiolist" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Audio Sites List</h4>
            </div>
            <div class="modal-body">

                <?php $videolist = array('jiosaavn.com','soundcloud.com', 'pandora.com', 'reverbnation.com', 'tidal.com', 'music.yandex.ru', 'itunes', ' amazon music', 'google play', 'spotify.com', 'playlist.com', 'myspace.com', 'hypem.com', 'youtube.com', 'tindeck.com', 'freesound.org', 'archive.org', 'discogs.com', 'musica.com', 'mp3.zing.vn', 'deezer.com', 'zaycev.net', 'bandcamp.com', 'nhaccuatui.com', 'letras.mus.br', 'pitchfork.com', 'last.fm', 'zamunda.net', 'xiami.com', 'palcomp3.com', 'cifraclub.com.br', 'biqle.ru', 'suamusica.com.br', 'ulub.pl');
                $count = 1;
                for ($i = 0; $i < count($videolist); $i++) {

                ?>
                    <p>(<?php echo $count ?>) <?php echo $videolist[$i]; ?></p>

                <?php $count++;
                } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>






<div id="addaudio" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Audio</h4>
            </div>
            <div class="modal-body">

                <?php echo $this->Form->create($Audio, array('url' => array('controller' => 'profile', 'action' => 'audio'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'user_form', 'autocomplete' => 'off')); ?>
                <span style="color:red;display:none; margin:0px 0px 12px 120px" id="videonotable">Click on Audio Sites List to view acceptable sites list. </span>

                <div class="form-group">
                    <label class="control-label col-sm-2">Title :</label>
                    <div class="col-sm-10">
                        <?php echo $this->Form->input('audio_type', array('class' => 'form-control', 'placeholder' => 'Title', 'maxlength' => '25', 'id' => 'name', 'required', 'label' => false)); ?>

                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-sm-2">Url :</label>
                    <div class="col-sm-10">
                        <?php echo $this->Form->input('audio_link', array('class' => 'form-control audiourl', 'placeholder' => 'Url', 'id' => 'audiourl', 'required', 'label' => false, 'type' => 'url')); ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="text-center col-sm-12">
                        <button id="btn" type="submit" class="btn btn-default submitbtn"><?php echo __('Submit'); ?></button>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    var site_url = '<?php echo SITE_URL; ?>/';
    $(document).ready(function() {
        $(".audiourl").change(function() {
            var value = $(this).val();
            $.ajax({
                type: "post",
                url: site_url + 'profile/getAudio',
                data: {
                    url: value
                },
                success: function(data) {
                    var obj = JSON.parse(data);
                    if (obj.status == 1) {
                        // $('.imgupdate').css('display', 'block');
                        // $('.imgupdate').attr('src', obj.image);
                        // $('.uploadbutton').css('display', 'none');
                        // $('.imgupdate').css('display', 'block');
                        // $('.input-file').removeAttr('required');
                        // $("input[name~='imagesrc']").val(obj.image);
                        $('#btn').removeAttr('disabled');
                        $('#videonotable').css('display', 'none');
                        $('.submitbtn').show();
                    } else {
                        $('#btn').attr('disabled', 'true');
                        $('#videonotable').css('display', 'block');
                        // $('.imgupdate').css('display', 'none');
                        $('.submitbtn').css('display', 'none');
                    }
                }

            });
        });
    });
</script>

<!-- Daynamic modal -->
<div id="dynamyModal" class="modal fade">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Audio</h4>
            </div>
            <div class="modal-body"></div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->

</div>
<!-- /.modal -->



<script>
    $('.data').click(function(e) {
        e.preventDefault();
        $('#dynamyModal').modal('show').find('.modal-body').load($(this).attr('href'));
    });
</script>