<section id="page_job_detail">
  <div class="container">
    <h2>My <span>Requirement</span></h2>
    <p class="m-bott-50">Manage All Requirements Posted By You</p>
  </div>

  <div class="refine-search">
    <div class="container">

      <div class="row m-top-20">

        <div class="col-sm-12">
          <?php echo $this->Flash->render(); ?>
          <div class="panel panel-right">
            <div class="clearfix job-box box-1">

              <?php echo $requirement['id']; ?>
              <?php if (count($requirementfeatured) > 0) { ?>
                <?php $i = 1;
                foreach ($requirementfeatured as $requirement) { //pr($requirement);exit; 
                ?>

                  <div class="col-sm-12 job-card">
                    <div class="col-sm-2 ad-job-image">
                      <?php if ($requirement['image'] != '') { ?>
                        <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $requirement['id']; ?>"> <img src="<?php echo SITE_URL; ?>/job/<?php echo $requirement['image'];  ?>"></a>
                    </div>

                  <?php } else { ?>
                    <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $requirement['id']; ?>">
                      <img src="<?php echo SITE_URL; ?>/images/job.jpg" />
                    </a>
                  </div>
                <?php } ?>
                <div class="col-sm-10">
                  <h3 class="heading"><?php echo $i . '.'; ?> <a target="_blank" href="<?php echo SITE_URL; ?>/applyjob/<?php echo $requirement['id']; ?>"><?php echo $requirement['title']; ?></a><span title="Last Date, Time of Application"><?php echo date('M d,Y H:m', strtotime($requirement['last_date_app'])); ?></span></h3>

                  <div class="row">
                    <div class="col-lg-10 col-md-12 col-sm-12 req-jb my-job-but">
                      <div class="row">
                        <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-default btn-block" data-val="<?php echo $requirement['id']; ?>" data-action="application"> Application Received ( <?php echo $job_application = $this->Comman->applicationcount($requirement['id']); ?>)</a></div>
                        <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-primary btn-block" data-val="<?php echo $requirement['id']; ?>" data-action="quote_receive"> Quote Received (<?php echo $job_application = $this->Comman->quote_receivecount($requirement['id']); ?>)</a></div>
                        <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-success btn-block" data-val="<?php echo $requirement['id']; ?>" data-action="ping_receive"> Ping Received (<?php echo $job_application = $this->Comman->ping_receivecount($requirement['id']); ?>)</a></div>
                        <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-info btn-block" data-val="<?php echo $requirement['id']; ?>" data-action="sel_receive"> Selected (<?php echo $job_application = $this->Comman->sel_receivecount($requirement['id']); ?>) </a></div>
                      </div>
                      <div class="row m-top-20">
                        <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-info btn-block" data-val="<?php echo $requirement['id']; ?>" data-action="booking_sent"> Booking Request sent (<?php echo $job_application = $this->Comman->booking_sentcount($requirement['id']); ?>)</a></div>

                        <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-warning btn-block" data-val="<?php echo $requirement['id']; ?>" data-action="quote_request"> Quote Requested (<?php echo $job_application = $this->Comman->quote_requestcount($requirement['id']); ?>)</a></div>
                        <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-default btn-block" data-val="<?php echo $requirement['id']; ?>" data-action="quote_revised"> Revised Quote Sent (<?php echo $job_application = $this->Comman->quote_revisedcount($requirement['id']); ?>) </a></div>
                        <div class="col-sm-3"><a href="javascript:void(0);" class="btn btn-primary btn-block" data-val="<?php echo $requirement['id']; ?>" data-action="reject_receive"> Rejected (<?php echo $job_application = $this->Comman->reject_receivecount($requirement['id']); ?>) </a></div>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12">
                      <div class="text-right">
                        <p>No Of Views : <?php echo count($requirement['job_view']); ?></p>
                      </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 job-det-icon job-req-a">


                      <span><a href="<?php echo SITE_URL; ?>/requirement/jobcsv/<?= $requirement['id']; ?>" data-toggle="tooltip" data-placement="top" title="Export to CSV"><i class="fa fa-file-excel-o"></i>Export to Excel</a></span>

                      <?php
                      $currentdate = date("Y-m-d H:i:s");
                      $lastdate_app = date('Y-m-d H:i:s', strtotime($requirement['last_date_app']));

                      $status = ($requirement['status'] == 'N') ? 'Y' : 'N';
                      $actionText = ($requirement['status'] == 'N') ? 'Activate Job' : 'Deactivate Job';
                      $tooltipTitle = ($requirement['status'] == 'N') ? 'Activate Job' : 'Deactivate Job';
                      $style = ($requirement['status'] == 'N') ? '' : 'color: black; background-color: #e2d5d5;';
                      ?>

                      <a href="<?php echo SITE_URL; ?>/requirement/status/<?php echo $requirement['id']; ?>/<?php echo $status; ?>"
                        data-toggle="tooltip" data-placement="top" title="<?php echo $tooltipTitle; ?>"
                        style="<?php echo $style; ?>">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php echo $actionText; ?>
                      </a>


                      <a href="<?php echo SITE_URL; ?>/requirement/suggestedprofile/<?php
                                                                                    echo $requirement['id']; ?>" data-toggle="tooltip" data-placement="top" title="Suggested Profiles"><i class="fa fa-user-o"></i>Suggested Profiles</a>
                      <?php
                      $simultaneously = $this->Comman->currentpackagefeature();
                      $requirecount = $this->Comman->requirementcount();
                      if ($requirecount >= $simultaneously['number_of_job_simultancney']) { ?>


                        <a href="#" data-toggle="modal" data-target="#simultaneouslyss" title="Make A Copy"><i class="fa fa-clone"></i>Make A Copy</a>

                        <div class="modal fade" id="simultaneouslyss" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">

                              <div class="modal-body" style="text-align: center;">
                                <strong>Please convert any of your active job to Inactive to Post Requirement</strong>
                              </div>

                            </div>

                          </div>
                        </div>

                      <?php } else { ?>
                        <a target="_blank" href="<?php echo SITE_URL; ?>/jobpost/jobpost/<?php
                                                                                          echo $requirement['id'] ?>" data-toggle="tooltip" data-placement="top" title="Make A Copy"><i class="fa fa-clone"></i>Make A Copy</a>
                      <?php } ?>



                      <!--button type="button" data-toggle="tooltip" data-placement="top" title="clone"><i class="fa fa-clone"></i>-->


                      <a href="<?php echo SITE_URL; ?>/requirement/delete/<?php
                                                                          echo $requirement['id'] ?>" data-toggle="tooltip" data-placement="top" title="delete" onClick="javascript:return confirm('Are you sure do you want to delete this Job')"><i class="fa fa-remove" aria-hidden="true"></i>Delete Job</a>
                      <!-- comment this because editjob is not working -->
                      <!-- <a href="<?php echo SITE_URL; ?>/requirement/editjob/<?php
                                                                                echo $requirement['id'] ?>" data-toggle="tooltip" data-placement="top" title="delete" onClick="javascript:return confirm('Are you sure do you want to edit this Job')"><i class="fa fa-edit" aria-hidden="true"></i>Edit Job</a> -->

                      <!-- <button type="button" data-toggle="tooltip" data-placement="top" title="delete" ><i class="fa fa-remove" aria-hidden="true"></i></button>-->

                    </div>
                  </div>
                  <div class="row">
                    <div class="exp-cntre col-sm-12" id="exp_<?php echo $requirement['id'] ?>">

                    </div>
                  </div>
                </div>
            </div>



          <?php $i++;
                }
              } else { ?>
          <h5 style="text-align:center;"><?php echo "You have not posted any Job"; ?>&nbsp;<a href="<?php echo SITE_URL; ?>/package/jobposting/"> POST YOUR JOB </a> &nbsp;Now
          </h5>
        <?php } ?>

          </div>

        </div>
      </div>
    </div>
  </div>
  </div>
</section>

<!-------------------------------------------------->

</div>
<input type="hidden" id="currentaction" value="">
<script>
  $(document).ready(function() {
    $(".btn").click(function() {
      var val = $(this).data('val');
      var action = $(this).data('action');
      var currentaction = $("#currentaction").val();

      //console.log(currentaction);
      //console.log(action);
      //console.log(val);

      openTab(val, action, currentaction);
      $("#currentaction").val(action + val);
    });
  });

  function openTab(val, action, currentaction) {

    if ($('.exp-cnt:visible').length == 0) {
      $("#exp_" + val).addClass("show1");

    } else {
      $(".exp-cnt").removeClass("show1");
      if (action + val != currentaction) {
        $("#exp_" + val).addClass("show1");
      }
    }
    // Ajax
    $.ajax({
      type: "POST",
      url: '<?php echo SITE_URL; ?>/requirement/updatequote',
      data: ({
        job: val,
        action: action
      }),
      cache: false,
      success: function(data) {
        $(".exp-cntre").html("");
        $("#exp_" + val).html(data);
      }
    });
  }

  var actions = '<?php echo $_SESSION['quote']; ?>';
  var value = '<?php echo $_SESSION['job_id']; ?>';
  setTimeout(function() {
    openTab(value, actions, '')
  }, 1000);
</script>