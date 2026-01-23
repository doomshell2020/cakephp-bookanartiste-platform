<style>
    #edit_profile .nav-tabs>li>a img {
        display: block;
        text-align: center;
        margin: auto;
        width: 24px !important;
        margin-top: 20px;
        height: auto !important;
    }
</style>

<?php $dfg = $this->Comman->skills();
$skillcount = count($dfg);
if ($dfg) { ?>
    <ul class="nav nav-tabs nav-justified" role="tablist">
        <?php     //pr($this->request->params); 
        ?>
        <li <?php if ($this->request->params['action'] == 'profile') { ?> class="active" <?php } ?>><a href="<?php echo SITE_URL; ?>/profile" class="popcheckconfirm"><img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic1_personal_black.png"> <img class="hover" src="<?php echo SITE_URL; ?>/images/ic1_personal_blue.png">Personal</a></li>

        <li <?php if ($this->request->params['action'] == 'galleries' || $this->request->params['action'] == 'video' || $this->request->params['action'] == 'audio') { ?> class="active" <?php } ?>><a href="<?php echo SITE_URL; ?>/galleries" class="popcheckconfirm"><img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_gallery_black.jpg"> <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_gallery_blue.png">Gallery</a></li>

        <?php if ($user_check['role_id'] == TALANT_ROLEID) { ?>
            <li <?php if ($this->request->params['action'] == 'professionalsummary') { ?> class="active" <?php } ?>><a href="<?php echo SITE_URL; ?>/professionalsummary" class="popcheckconfirm"><img class="tb-img" src="<?php echo SITE_URL; ?>/images/Profile-icn_2.png"> <img class="hover" src="<?php echo SITE_URL; ?>/images/Profile-icn-hover_2.png">Professional Summary</a></li>

            <li <?php if ($this->request->params['action'] == 'performance') { ?> class="active" <?php } ?>><a href="<?php echo SITE_URL; ?>/performance" class="popcheckconfirm"><img class="tb-img" src="<?php echo SITE_URL; ?>/images/Profile-icn_3.png"> <img class="hover" src="<?php echo SITE_URL; ?>/images/Profile-icn-hover_3.png">Work,Charges Description</a></li>

            <?php if ($skillcount > 0) { ?>
                <li <?php if ($this->request->params['action'] == 'vitalstatistics') { ?> class="active" <?php } ?>><a href="<?php echo SITE_URL; ?>/vitalstatistics" class="popcheckconfirm"><img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_staristics_black.png" height="44px"> <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_staristics_blue.png" height="44px">Vital Statistics Parameters</a></li>

            <?php } ?>
        <?php } ?>
    </ul>
<?php } else { ?>
    <ul class="nav nav-tabs nav-justified" role="tablist">
        <?php     //pr($this->request->params); 
        ?>
        <li <?php if ($this->request->params['action'] == 'profile') { ?> class="active" <?php } ?>><a href="<?php echo SITE_URL; ?>/profile" class="popcheckconfirm"><img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_personal_black.png"> <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_personal_blue.png">Personal</a></li>
        <li <?php if ($this->request->params['action'] == 'galleries' || $this->request->params['action'] == 'video' || $this->request->params['action'] == 'audio') { ?> class="active" <?php } ?>><a href="<?php echo SITE_URL; ?>/galleries" class="popcheckconfirm"><img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_gallery_black.png"> <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_gallery_blue.png">Gallery</a></li>
        <?php if ($user_check['role_id'] == TALANT_ROLEID) { ?>
            <li <?php if ($this->request->params['action'] == 'professionalsummary') { ?> class="active" <?php } ?>><a href="javascript:void(0);" class="popcheckconfirm" data-toggle="modal" data-target="#myModaltab"><img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic-professional_black.png"> <img class="hover" src="<?php echo SITE_URL; ?>/images/ic-professional_black.png">Professional Summary</a></li>

            <li <?php if ($this->request->params['action'] == 'performance') { ?> class="active" <?php } ?>><a href="javascript:void(0);" class="popcheckconfirm" data-toggle="modal" data-target="#myModaltab"><img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_charges_black.png"> <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_charges_blue.png">Work,Charges Description</a></li>
            <?php if ($skillcount > 0) { ?>
                <li <?php if ($this->request->params['action'] == 'vitalstatistics') { ?> class="active" <?php } ?>><a href="javascript:void(0);" class="popcheckconfirm" data-toggle="modal" data-target="#myModal"><img class="tb-img" src="<?php echo SITE_URL; ?>/images/ic_staristics_black.png" height="44px"> <img class="hover" src="<?php echo SITE_URL; ?>/images/ic_staristics_blue.png" height="44px">Vital Statistics
                        Parameters</a></li>
            <?php } ?>
        <?php } ?>
    </ul>

    <div class="container">

        <!-- Modal -->
        <div class="modal fade" id="myModaltab" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <p> You Are a Non-Talent As You Haven't Selected Any Skills. Please Select At least One Skills to
                            Become a Talent</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>