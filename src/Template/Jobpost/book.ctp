<?php if ($packlimit['number_of_booking'] <= 0) { ?>
  <span style="font-weight: 600;">You cannot send any more booking requests for this job.</span>
<?php } else { ?>

  <?php

  foreach ($bookjob as $value) {
    $app[] = $value['job_id'];
  }
  ?>

  <section id="">

    <div class="post-talant-form">
      <div class="m-top-10 container-fluid">
        <div id="booknowinvited" style="display: none">

          <?php foreach ($_SESSION['booknownotinvite'] as $key => $result) { ?>
            <?php echo $result; ?> Vacancy are filled <?php echo $key; ?>.

          <?php  } ?>
        </div>
        <!-- code changed for booknow  -->
        <!-- ?php  echo $this->Form->create($requirement,array('url' => array('controller' => 'jobpost', 'action' => 'insBook'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'booknowsubmit','autocomplete'=>'off')); ?> -->
        <?php echo $this->Form->create($requirement, array('url' => array('controller' => 'jobpost', 'action' => 'insBook'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'booknowsubmitddd', 'autocomplete' => 'off')); ?>
        <span id="booknownoselect" style="display: none">Select Atleast one Job</span>
        <input type="hidden" name="user_id" value="<?php echo $userid ?>" class="singlebooknowchekprofileid">
        <div class="">
          <?php if (count($activejobs) > 0) { ?>



            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Job</th>
                  <th>Skills</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($activejobs as $jobs) { //pr($jobs);

                ?>
                  <tr>
                    <?php if (!in_array($jobs['id'], $app)) { ?>
                      <td>
                        <input type="checkbox" name="job_id[<?php echo $jobs['id']; ?>]" value="<?php echo $jobs['id']; ?>" id="bookingselectsingle<?php echo $jobs['id']; ?>" class="bookingselectsingle">
                      <?php } ?>
                      <?php if (!in_array($jobs['id'], $app)) {
                        $pendingjob[] = $job['id']; ?>

                        <a href="<?php echo SITE_URL ?>/applyjob/<?php echo $jobs['id'] ?>" target="_blank">
                          <?php echo $jobs['title']; ?>
                        </a>

                      </td>
                    <?php  } ?>
                    <?php if (!in_array($jobs['id'], $app)) { ?>
                      <td>

                        <select required class="form-control bookingselectsingle<?php echo $jobs['id']; ?>" disabled required name="job_id[<?php echo $jobs['id']; ?>][]">
                          <option value="">--Select--</option>
                          <?php foreach ($jobs['requirment_vacancy'] as $skillsreq) { //pr($skillsreq);
                          ?>

                            <option value="<?php echo $skillsreq['skill']['id']; ?>"><?php echo $skillsreq['skill']['name']; ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    <?php } ?>
                  </tr>
                <?php } ?>
                <?php if ($pendingjob) { ?>

                <?php } else { ?>
                  <td colspan="2" rowspan="2" style="text-align: center;"><?php echo "No Jobs Available For Booking"; ?></td>
                <?php } ?>
              </tbody>

            </table>

          <?php
          } ?>



          <!-- <?php if ($pendingjob) { ?>  <button type="submit" class="btn btn-default " id="booknowsave">Book Now</button>  <?php } ?> -->
          <?php if ($pendingjob && count($activejobs) > 0) { ?>
            <div style="text-align:center;">
              <button type="submit" class="btn btn-default booknowsavesingle ">Book Now</button>
            </div>
          <?php } ?>
        </div>
        </form>
      </div>

    </div>


  </section>


<?php } ?>


<!-- <script>
var SITE_URL='<?php echo SITE_URL; ?>/';
	$('#booknowsave').click(function(e) { //alert();
	e.preventDefault();
    $.ajax({
	type: "POST",
	 url: SITE_URL + 'search/mutiplebooknow',
	data: $('#booknowsubmit').serialize(),
	cache:false,
	success:function(data){
	
 var myObj = JSON.parse(data);  
      if(myObj.success=='booknownoselect'){
       $("#booknownoselect").css("display","block");
       setTimeout(function() {$("#booknownoselect").fadeOut('fast');}, 1000); 
     }else if(myObj.success=='bookingrequestnotsent'){

      $('input:checkbox').removeAttr('checked');
      location.reload();
      $('input:checkbox').removeAttr('checked');
    }else if (myObj.success=='bookingrequestsent'){
      $('input:checkbox').removeAttr('checked');
      location.reload();
    }
    //
    //$("#multiplebooknow").modal('toggle');
           // $('input:checkbox').removeAttr('checked');
//location.reload();
	}
    });
});




</script> -->
<!-- <script>
  var SITE_URL = '<?php echo SITE_URL; ?>/';
  $('.booknowsave').click(function(e) { //alert();
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: SITE_URL + 'search/mutiplebooknow',
      data: $('#booknowsubmit').serialize(),
      cache: false,
      success: function(data) {
        var myObj = JSON.parse(data);
        if (myObj.success == 'booknownoselect') {
          $("#booknownoselect").css("display", "block");
          setTimeout(function() {
            $("#booknownoselect").fadeOut('fast');
          }, 1000);
        } else if (myObj.success == 'bookingrequestnotsent') {

          $('input:checkbox').removeAttr('checked');
          location.reload();
          $('input:checkbox').removeAttr('checked');
        } else if (myObj.success == 'bookingrequestsent') {
          $('input:checkbox').removeAttr('checked');
          location.reload();
        }
        //
        //$("#multiplebooknow").modal('toggle');
        // $('input:checkbox').removeAttr('checked');
        //location.reload();

      }
    });
  });


  $('.booknowsavesingle').click(function(e) { //alert();
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: SITE_URL + 'search/mutiplebooknow',
      data: $('#booknowsubmitddd').serialize(),
      cache: false,
      success: function(data) {
        var myObj = JSON.parse(data);
        if (myObj.success == 'booknownoselect') {
          $("#booknownoselect").css("display", "block");
          setTimeout(function() {
            $("#booknownoselect").fadeOut('fast');
          }, 1000);
        } else if (myObj.success == 'bookingrequestnotsent') {

          $('input:checkbox').removeAttr('checked');
          location.reload();
          $('input:checkbox').removeAttr('checked');
        } else if (myObj.success == 'bookingrequestsent') {
          $('input:checkbox').removeAttr('checked');
          location.reload();
        }
        //
        //$("#multiplebooknow").modal('toggle');
        // $('input:checkbox').removeAttr('checked');
        //location.reload();

      }
    });
  });
</script> -->




<script>
  $(".bookingselectsingle").click(function(evt) {
    var id = $(this).attr("id");
    if ($(this).is(":checked")) {
      $("." + id).removeAttr('disabled');
    } else {
      //$("."+id).removeAttr('disabled');
      $("." + id).prop('disabled', 'disabled');
    }
  });
</script>
<script>
  var SITE_URL = '<?php echo SITE_URL; ?>/';
  // $('.booknowsave').click(function(e) { //alert();
  //   e.preventDefault();
  //   $.ajax({
  //     type: "POST",
  //     url: SITE_URL + 'search/multiplebooknow',
  //     data: $('#booknowsubmit').serialize(),
  //     cache: false,
  //     success: function(data) {

  //       var myObj = JSON.parse(data);
  //       // console.log(myObj);
  //       // return false;
  //       if (myObj.success == 'booknownoselect') {
  //         $("#booknownoselect").css("display", "block");
  //         setTimeout(function() {
  //           $("#booknownoselect").fadeOut('fast');
  //         }, 1000);
  //       } else if (myObj.success == 'bookingrequestnotsent') {
  //         $('input:checkbox').removeAttr('checked');
  //         location.reload();
  //         $('input:checkbox').removeAttr('checked');
  //       } else if (myObj.success == 'bookingrequestsent') {
  //         $('input:checkbox').removeAttr('checked');
  //         window.location.href = 'viewprofile.php?code=' + myObj.code;
  //       }
  //       //
  //       //$("#multiplebooknow").modal('toggle');
  //       // $('input:checkbox').removeAttr('checked');
  //       //location.reload();

  //     }
  //   });
  // });


  $('.booknowsavesingle').click(function(e) { //alert();
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: SITE_URL + 'search/multiplebooknow',
      data: $('#booknowsubmitddd').serialize(),
      cache: false,
      success: function(data) {
        var myObj = JSON.parse(data);
        if (myObj.success == 'booknownoselect') {
          $("#booknownoselect").css("display", "block");
          setTimeout(function() {
            $("#booknownoselect").fadeOut('fast');
          }, 1000);
        } else if (myObj.success == 'bookingrequestnotsent') {

          $('input:checkbox').removeAttr('checked');
          location.reload();
          // window.location.href = 'https://www.bookanartiste.com/viewprofile/<?php echo $user_id; ?>';
          $('input:checkbox').removeAttr('checked');
        } else if (myObj.success == 'bookingrequestsent') {
          $('input:checkbox').removeAttr('checked');
          // window.location.href = 'https://www.bookanartiste.com/viewprofile/' + ;
          // window.location.href = 'https://www.bookanartiste.com/viewprofile/<?php echo $user_id; ?>';

          location.reload();


          // window.location.href = 'viewprofile.php?code=' + myObj.code;
        }
        //
        //$("#multiplebooknow").modal('toggle');
        // $('input:checkbox').removeAttr('checked');
        //location.reload();

      }
    });
  });
</script>