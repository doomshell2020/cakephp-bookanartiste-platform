  <?php echo  $this->element('viewprofile'); ?>
  <div class="col-sm-9">

    <div class="col-sm-12 prsnl-det summ-det">
      <h4 class="">Professional<span> Summary</span></h4>
      <?php if ($proff->profile_title != '') { ?>
        <div class="form-group">
          <!-- <label for="" class="col-sm-4 control-label">Profile Title </label> -->

          <!-- <div class="col-sm-6">
            <p> <?php
                // echo $proff->profile_title; 
                ?> </p>
          </div> -->

          <div class="col-sm-2"></div>
        </div>
      <?php } ?>
      <?php if ($proff->agency_name != '') { ?>
        <div class="form-group">
          <label for="" class="col-sm-4 control-label">Agency Name </label>
          <div class="col-sm-6">
            <p><?php echo $proff->agency_name; ?></p>

          </div>
          <div class="col-sm-2"></div>
        </div>
      <?php } ?>

      <div class="form-group">
        <?php if ($proff->talent_manager != '') { ?>

          <label for="" class="col-sm-4 control-label">Talent Manager Name </label>
          <div class="col-sm-6">
            <p><?php echo $proff->talent_manager; ?></p>
          </div>
        <?php } ?>

        <div class="col-sm-2"></div>
      </div>
    </div>

    <!-- by rupam sir -->
    <!-- <div class="col-sm-12 prsnl-det m-top-20">
      <h4 class="">Currently <span>Working At</span></h4>
      <?php if (count($currentworking) > 0) { ?>
        <?php foreach ($currentworking as $current) { //pr($current);
        ?>
          <div class="working-det">


            <div class="form-group">
              <div class="col-sm-6">
                <p> <?php echo $current['role']; ?> </p>
              </div>
              <div class="col-sm-2"></div>
            </div>


            <div class="form-group">
              <div class="col-sm-6">
                <?php if ($current['bookenartist'] != '') { ?>
                  <p> <a href="<?php echo $current['bookenartist']; ?>"> <?php echo $current['name']; ?></a></p>
                <?php } else { ?>
                  <P> <?php echo $current['name']; ?></p>
                <?php } ?>
              </div>
              <div class="col-sm-2"></div>
            </div>

            <div class="form-group">
              <div class="col-sm-6">
                <p> <?php echo $current['location']; ?> </p>
              </div>
              <div class="col-sm-2"></div>
            </div>
            <div class="form-group">
              <div class="col-sm-6">
                <p> <?php echo date("d-M-Y", strtotime($current['created'])); ?> </p>
              </div>
              <div class="col-sm-2"></div>
            </div>


            <div class="form-group">
              <label for="" class="col-sm-4 control-label descrptn">Description </label>

            </div>

            <div class="form-group">
              <div class="col-sm-12 li_discription_dtl">
                <p> <?php echo $current['description']; ?> </p>
              </div>

            </div>
          </div>

      <?php }
      } else {

        echo "No currently working available";
      } ?>

    </div> -->
    <!-- end this code  -->

    <?php if (!empty($currentworking) && count($currentworking) > 0) { ?>
      <div class="col-sm-12 prsnl-det m-top-20">
        <h4 class="">Currently <span>Working At</span></h4>
        <?php foreach ($currentworking as $current) { ?>
          <div class="working-det">
            <div class="form-group">
              <div class="col-sm-6">
                <p><?php echo $current['role']; ?></p>
              </div>
              <div class="col-sm-2"></div>
            </div>
            <div class="form-group">
              <div class="col-sm-6">
                <?php if (!empty($current['bookenartist'])) { ?>
                  <p><a href="<?php echo $current['bookenartist']; ?>"><?php echo $current['name']; ?></a></p>
                <?php } else { ?>
                  <p><?php echo $current['name']; ?></p>
                <?php } ?>
              </div>
              <div class="col-sm-2"></div>
            </div>
            <div class="form-group">
              <div class="col-sm-6">
                <p><?php echo $current['location']; ?></p>
              </div>
              <div class="col-sm-2"></div>
            </div>
            <div class="form-group">
              <div class="col-sm-6">
                <p><?php echo date("M-Y", strtotime($current['date_from'])); ?></p>
              </div>
              <div class="col-sm-2"></div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-4 control-label descrptn">Description </label>
            </div>
            <div class="form-group">
              <div class="col-sm-12 li_discription_dtl">
                <p><?php echo $current['description']; ?></p>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    <?php } else { ?>
      <!-- <div class="col-sm-12">No currently working available</div> -->
    <?php } ?>






    <!-- by rupam sir -->
    <!-- <div class="col-sm-12 prsnl-det m-top-20">
      <h4 class="">Earlier <span>Experience</span></h4>
      <?php if (count($profexp) > 0) { ?>

        <?php
        //pr($profexp); die;
        foreach ($profexp as $profexperience) { //pr($profexperience);
        ?>
          <div class="working-det">

            <div class="form-group">
              <div class="col-sm-6">
                <p> <?php echo $profexperience['role']; ?> </p>
              </div>
              <div class="col-sm-2"></div>
            </div>

            <div class="form-group">
              <div class="col-sm-6">


                <?php if ($profexperience['bookenartist'] != '') { ?>
                  <p> <a href="<?php echo $profexperience['bookenartist']; ?>"><?php echo $profexperience['name']; ?></a></p>
                <?php } else { ?>
                  <P> <?php echo $profexperience['name']; ?></p>
                <?php } ?>

              </div>
              <div class="col-sm-2"></div>
            </div>

            <div class="form-group">
              <div class="col-sm-6">
                <p> <?php echo $profexperience['location']; ?> </p>
              </div>
              <div class="col-sm-2"></div>
            </div>

            <div class="form-group">
              <div class="col-sm-6">
                <p><?php echo date("M, Y", strtotime($profexperience['from_date'])); ?> To <?php echo date("M, Y", strtotime($profexperience['to_date'])); ?></p>
              </div>
              <div class="col-sm-2"></div>
            </div>

            <div class="form-group">
              <label for="" class="col-sm-4 control-label descrptn">Description </label>

            </div>

            <div class="form-group">
              <div class="col-sm-12 li_discription_dtl">
                <p> <?php echo $profexperience['description']; ?> </p>
              </div>

            </div>

          </div>

        <?php } ?>

      <?php } else { ?>
        <div class="col-sm-12">No Previous Experience available.</div>
      <?php } ?>
    </div> -->
    <!-- end code  -->

    <?php if (!empty($profexp) && count($profexp) > 0) { ?>
      <div class="col-sm-12 prsnl-det m-top-20">
        <h4 class="">Earlier <span>Experience</span></h4>
        <div class="working-det">
          <?php foreach ($profexp as $profexperience) { ?>
            <div class="form-group">
              <div class="col-sm-6">
                <p><?php echo $profexperience['role']; ?></p>
              </div>
              <div class="col-sm-2"></div>
            </div>
            <div class="form-group">
              <div class="col-sm-6">
                <?php if (!empty($profexperience['bookenartist'])) { ?>
                  <p><a href="<?php echo $profexperience['bookenartist']; ?>"><?php echo $profexperience['name']; ?></a></p>
                <?php } else { ?>
                  <p><?php echo $profexperience['name']; ?></p>
                <?php } ?>
              </div>
              <div class="col-sm-2"></div>
            </div>
            <div class="form-group">
              <div class="col-sm-6">
                <p><?php echo $profexperience['location']; ?></p>
              </div>
              <div class="col-sm-2"></div>
            </div>
            <div class="form-group">
              <div class="col-sm-6">
                <p><?php echo date("M, Y", strtotime($profexperience['from_date'])); ?> To <?php echo date("M, Y", strtotime($profexperience['to_date'])); ?></p>
              </div>
              <div class="col-sm-2"></div>
            </div>
            <div class="form-group">
              <label for="" class="col-sm-4 control-label descrptn">Description </label>
            </div>
            <div class="form-group">
              <div class="col-sm-12 li_discription_dtl">
                <p><?php echo $profexperience['description']; ?></p>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    <?php } else { ?>
      <!-- <div class="col-sm-12">No Previous Experience available.</div> -->
    <?php } ?>

    <!-- by rupam sir  -->
    <!-- <div class="col-sm-12 prsnl-det m-top-20">
      <h4 class=""><span>Website PortFolio</span></h4>
      <?php
      $typ = array('S' => 'Social', 'C' => 'Company', 'P' => 'Personal', 'B' => 'Blog');
      if (count($videoprofile) > 0) { ?>
        <div class="working-det">
          <?php foreach ($videoprofile as $portFolio) { ?>
                    <div class="form-group">
              <label for="" class="col-sm-4 control-label"><?php echo $typ[$portFolio->web_type]; ?> Link </label>
              <div class="col-sm-6">
                <p> <a href="<?php echo $portFolio->web_link; ?>">PortFolio</a></p>
              </div>
              <div class="col-sm-2"></div>
            </div>
         <?php } ?>
        </div>
      <?php } else { ?>
        <div class="col-sm-12">No Website PortFolio available.</div>
      <?php } ?>

    </div>  -->
    <!-- end code -->

    <!-- colums is visible and not visible -->

    <?php
    $currentpackage = $this->Comman->currentprpackv1();

    $typ = array('S' => 'Social', 'C' => 'Company', 'P' => 'Personal', 'B' => 'Blog');
    if (count($videoprofile) > 0 && $currentpackage['website_visibility'] == 'Y') { ?>
      <div class="col-sm-12 prsnl-det m-top-20">
        <h4 class=""><span>Website PortFolio</span></h4>
        <div class="working-det">
          <?php foreach ($videoprofile as $portFolio) { ?>
            <div class="form-group">
              <label for="" class="col-sm-4 control-label"><?php echo $typ[$portFolio->web_type]; ?> Link </label>
              <div class="col-sm-6">
                <p>
                  <a target="_blank" href="<?php echo $portFolio->web_link; ?>">
                    <?php echo $portFolio->web_link; ?>
                  </a>
                </p>
              </div>
              <div class="col-sm-2"></div>
            </div>
          <?php } ?>
        </div>
      </div>
    <?php } else { ?>
      <!-- <div class="col-sm-12">No Website PortFolio available.</div> -->
    <?php } ?>


    <!-- by rupam sir -->
    <!-- <div class="col-sm-12 prsnl-det m-top-20">
      <h4 class=""><span>Talent PortFolio</span></h4>
      <?php
      if (count($videoprofiletalentpro) > 0) { ?>
        <div class="working-det">
          <?php foreach ($videoprofiletalentpro as $portFoliotalent) { ?>
            <div class="form-group">
              <div class="col-sm-6">
                <p> <a href="<?php echo $portFoliotalent['url']; ?>"><?php echo $portFoliotalent['name']; ?> </a></p>
              </div>
              <div class="col-sm-2"></div>
            </div>
          <?php } ?>
        </div>
      <?php } else { ?>
        <div class="col-sm-12">No Talent PortFolio.</div>
      <?php } ?>

    </div> -->
    <!-- end code -->

    <!-- colums is visible and not visible -->
    <?php
    //pr($videoprofiletalentpro);exit;
    if (!empty($videoprofiletalentpro)) {
      if (count($videoprofiletalentpro) > 0) { ?>
        <div class="col-sm-12 prsnl-det m-top-20">
          <h4 class=""><span>Talent PortFolio</span></h4>
          <div class="working-det">
            <?php foreach ($videoprofiletalentpro as $portFoliotalent) { ?>
              <div class="form-group">
                <div class="col-sm-6">
                  <p><a href="<?php echo $portFoliotalent['url']; ?>"><?php echo $portFoliotalent['name']; ?> </a></p>
                </div>
                <div class="col-sm-2"></div>
              </div>
            <?php } ?>
          </div>
        </div>
      <?php } else { ?>
        <div class="col-sm-12">No Talent PortFolio.</div>
    <?php }
    } ?>


    <!-- by rupam sir -->
    <!-- <div class="col-sm-12 prsnl-det m-top-20">
      <h4 class=""><span>Personnel Details</span></h4>
      <?php
      $typ = array('S' => 'Social', 'C' => 'Company', 'P' => 'Personal', 'B' => 'Blog');
      if (count($videoprofilepersoneeldet) > 0) { ?>
        <div class="working-det">
          <?php foreach ($videoprofilepersoneeldet as $portFoliopersonnel) { ?>


            <div class="form-group">

              <div class="col-sm-6">
                <p> <a href="<?php echo $portFoliopersonnel['url']; ?>"><?php echo $portFoliopersonnel['name']; ?> </a></p>
              </div>
              <div class="col-sm-2"></div>
            </div>


          <?php } ?>
        </div>
      <?php } else { ?>
        <div class="col-sm-12">No Personnel Details.</div>
      <?php } ?>

    </div> -->
    <!-- end code  -->


    <!-- colums is visible and not visible -->

    <?php
    if (!empty($videoprofilepersoneeldet)) { // Check if $videoprofilepersoneeldet is not empty
      $typ = array('S' => 'Social', 'C' => 'Company', 'P' => 'Personal', 'B' => 'Blog');
      if (count($videoprofilepersoneeldet) > 0) { ?>
        <div class="col-sm-12 prsnl-det m-top-20">
          <h4 class=""><span>Personnel Details</span></h4>
          <div class="working-det">
            <?php foreach ($videoprofilepersoneeldet as $portFoliopersonnel) { ?>
              <div class="form-group">
                <div class="col-sm-6">
                  <p><a href="<?php echo $portFoliopersonnel['url']; ?>"><?php echo $portFoliopersonnel['name']; ?> </a></p>
                </div>
                <div class="col-sm-2"></div>
              </div>
            <?php } ?>
          </div>
        </div>
      <?php } else { ?>
        <div class="col-sm-12 prsnl-det m-top-20">
          <h4 class=""><span>Personnel Details</span></h4>
          <div class="col-sm-12">No Personnel Details.</div>
        </div>
      <?php } ?>
    <?php } ?>
    <!-- end code  -->


  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </section>