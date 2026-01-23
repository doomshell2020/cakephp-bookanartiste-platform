<?php if (count($requirementfeatured) > 0) {
  // pr($requirementfeatured);die;

  $vacancy = null;
?>
  <?php foreach ($requirementfeatured as $requirement) {
    // pr($requirement);
    // exit;
    $data = $this->Comman->vacanydetails($requirement['job_id'], $requirement['skill_id']);
    if ($quote == 'sel_receive') {
      // $getselectedprofile = $this->Comman->selectedProfile($requirement['job_id']);
      $getselectedprofile = $this->Comman->selectedProfileAnother($requirement['job_id'], $requirement['user_id']);
      $vacancy = $getselectedprofile['requirement']['requirment_vacancy'][0];
      // pr($requirement['user_id']);
      // pr($getselectedprofile);
      // die;

    }

    $recievedPaymentQuote =  $this->Comman->getPaymentCurrencyAndFreq($requirement['payment_freq'], $requirement['payment_currency']);
    // pr($recievedPaymentQuote);exit;
  ?>
    <!--  Modal For Questionnaire answers -->
    <div id="question<?php echo $requirement['user_id']; ?>" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" style="text-align:center;">Questionnaire Answers</h4>
          </div>

          <div class="modal-body">
            <?php
            if (!empty($jobquestion)) {
              $i = 1;
              foreach ($jobquestion as $valuejobanswr) {
                $questionTitle = $valuejobanswr['question_title'] ?? '';
                $jobAnswers = $valuejobanswr['jobanswer'] ?? [];
                $userAnswers = $valuejobanswr['userjobanswer'] ?? [];
                $userId = $requirement['user_id'];

                // Find the selected answer for the user
                $selectedAnswer = '';
                foreach ($userAnswers as $userAns) {
                  if ($userAns['user_id'] == $userId) {
                    foreach ($jobAnswers as $answerOption) {
                      if ($answerOption['id'] == $userAns['option_id']) {
                        $selectedAnswer = $answerOption['answervalue'];
                        break 2; // exit both loops
                      }
                    }
                  }
                }
            ?>
                <h4>
                  <small>
                    <strong>Question (<?= $i ?>):</strong> <?= htmlspecialchars($questionTitle) ?>?
                  </small>
                </h4>
                <h4>
                  <small>
                    <strong>Answer:</strong> <?= !empty($selectedAnswer) ? "<b>" . htmlspecialchars($selectedAnswer) . ".</b>" : "<i>No Answer Provided</i>" ?>
                  </small>
                </h4>
            <?php
                $i++;
              }
            } else {
              echo "<h3>No Data Available</h3>";
            }
            ?>
          </div>


        </div>

      </div>
    </div>

    <div class="requ_hide clearfix">
      <div class="row">
        <div class="col-sm-3">
          <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $requirement['user_id']; ?>" target="_blank">
            <img
              src="<?php echo SITE_URL; ?>/profileimages/<?php echo $requirement['user']['profile']['profile_image']; ?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL ?>/images/edit-pro-img-upload.jpg';">
          </a>
          <div class="contact-friend">

            <?php if (count($requirement) > 0) { //pr($requirement); 
            ?>
              <a href="javascript:void(0)" id="button" class="btn btn-default" style="width: 75%;" onclick="profilecounter(<?php echo $requirement['user_id']; ?>);">Contact Detail</a>

              <a href="#" data-toggle="modal" class="btn btn-primary" style="width: 75%;" data-target="#question<?php echo $requirement['user_id']; ?>">View Questionnaire</a>
            <?php } ?>
          </div>
          <div class="contact-detail ul_li" id="newpostt<?php echo $requirement['user_id']; ?>" style="display: none;">
            <ul class="list-unstyled">
              <?php if ($requirement['user']['profile']['profiletitle'] != '') { ?>
                <li><i class="fa fa-user"></i><?php echo $requirement['user']['profile']['profiletitle']; ?></li>
              <?php } ?>
              <?php if ($requirement->user->email != '') { ?>
                <li><i class="fa fa-envelope"></i><?php echo $requirement->user->email; ?></li>
              <?php } ?>
              <?php if ($requirement->user->phone != '') { ?>
                <li><i class="fa fa-phone"></i><?php echo $requirement->user->phone; ?></li>
              <?php } ?>
            </ul>
          </div>
        </div>
        <div class=" col-sm-9">
          <table class="table">


            <?php if ($quote == 'sel_receive') {  ?>


              <?php if ($data['requirement']['continuejob'] == 'N') { ?>
                <?php $currentdate = date("Y-m-d h:m A"); ?>
                <?php $lastdate_app = date('Y-m-d h:m A', strtotime($data['requirement']['last_date_app'])); ?>
                <?php if ($lastdate_app < $currentdate) { ?>
                  <a data-toggle="modal" target="_blank" class='btn btn-success btn-job' href="<?php echo SITE_URL ?>/requirement/talentrating/<?php echo $requirement['job_id']; ?>/<?php echo $requirement['user_id']; ?>">
                    Write Review </a>
                <?php }
              } else { ?>
                <?php $lastdate_app = date('Y-m-d h:m A', strtotime($data['requirement']['last_date_app'])); ?>
                <?php if ($lastdate_app < $currentdate) { ?>
                  <a data-toggle="modal" target="_blank" class='btn btn-success btn-job' href="<?php echo SITE_URL ?>/requirement/talentrating/<?php echo $requirement['job_id']; ?>/<?php echo $requirement['user_id']; ?>">
                    Write Review </a>
              <?php }
              } ?>
            <?php } ?>

            <?php /*if ($quote=='sel_receive'){ ?>
            <tr>
				
              <th>Select Skills </th>
              <td>:</td>
              <td><?php echo $requirement['skill']['name'] ; ?></td>
              </tr>
            <?php  } */ ?>

            <?php /*if ($quote=='reject_receive'){ ?>
                      <tr>
                  
              <th>Reject Skills </th>
              <td>:</td>
              <td><?php echo $requirement['skill']['name'] ; ?></td>
              </tr>
            <?php  } */ ?>

            <?php if ($quote == 'quote_revised') { ?>
              <!-- <tr>

                <th>Revised Quote Sent For </th>
                <td>:</td>
                <td><?php echo $requirement['skill']['name']; ?></td>
              </tr> -->
            <?php  } ?>
            <tr>
              <th>Name</th>
              <td>:</td>
              <td>
                <a href="<?= SITE_URL; ?>/viewprofile/<?= $requirement['user_id']; ?>" target="_blank">
                  <?= h($requirement['user']['profile']['name']); ?>
                </a>
                <?= $requirement['paid_quote'] == 'Y' ? ' (Paid Quote)' : ''; ?>
              </td>
            </tr>

            <tr>
              <th>Applied For</th>
              <td>:</td>
              <td>
                <?php if ($requirement['skill']) {
                  echo $requirement['skill']['name'];
                }  ?></td>
            </tr>

            <tr>
              <?php if ($requirement['user']['profile']['gender'] == '') { ?>

              <?php } else { ?>
                <th>Gender</th>
                <td>:</td>
              <?php } ?>

              <td>
                <?php if ($requirement['user']['profile']['gender'] == 'm') {
                  echo "Male";
                } elseif ($requirement['user']['profile']['gender'] == 'f') {
                  echo "Female";
                } elseif ($requirement['user']['profile']['gender'] == 'o') {
                  echo "Other";
                }  ?>
              </td>
            </tr>

            <?php if ($requirement['user']['profile']['location'] != '') { ?>
              <tr>
                <th>Location</th>
                <td>:</td>
                <td><?php echo $requirement['user']['profile']['location']; ?></td>
              </tr>
            <?php } ?>
            <tr>
              <th>Experience</th>
              <td>:</td>
              <?php
              $experienceyear = 'Not Updated';

              // Try first source
              if (!empty($requirement['user']['professinal_info']['performing_year'])) {
                $startYear = (int)date('Y', strtotime($requirement['user']['professinal_info']['performing_year']));
                $experienceyear = date("Y") - $startYear;
              }
              // Try fallback source if first not available
              elseif (!empty($getselectedprofile['requirement']['user']['professinal_info']['performing_year'])) {
                $startYear = (int)date('Y', strtotime($getselectedprofile['requirement']['user']['professinal_info']['performing_year']));
                $experienceyear = date("Y") - $startYear;
              }
              ?>

              <td>
                <?= is_numeric($experienceyear) ? $experienceyear . ' Years' : $experienceyear; ?>
              </td>

            </tr>

            <?php if ($quote == 'quote_revised') { ?>
              <tr>

                <th>Quote Recieve </th>
                <td>:</td>
                <td><?php
                    echo $requirement['skill']['name']; ?>
                </td>
              </tr>
            <?php  } ?>

            <tr>
              <th>Currency </th>
              <td>:</td>
              <td>
                <?php
                // if (!empty($data['currency'])) {
                //   echo $data['currency']['symbol'];
                // }

                if ($data['currency']['symbol']) {
                  echo $data['currency']['name'] . ' (' . $data['currency']['currencycode'] . ' - ' . $data['currency']['symbol'] . ')';
                } else {
                  echo '-';
                }

                ?>
              </td>
            </tr>

            <?php if (!empty($getselectedprofile)) {

              // $vacancy = $getselectedprofile['requirement']['requirment_vacancy'][0];
              $currencySymbol = $vacancy['currency']['symbol'];
            ?>
              <tr>
                <th>Payment Offered</th>
                <td>:</td>
                <td>
                  <?= (!empty($vacancy['payment_amount']) && $vacancy['payment_amount'] != 0)
                    ? h($currencySymbol . $vacancy['payment_amount'])
                    : 'Open to Negotiation'; ?>
                </td>
              </tr>


              <tr>
                <th>Quote Sent</th>
                <td>:</td>
                <td><?= h($currencySymbol . $getselectedprofile['amt']); ?></td>
              </tr>

              <tr>
                <th>Revised Quote Received</th>
                <td>:</td>
                <td><?= h($currencySymbol . $getselectedprofile['revision']); ?></td>
              </tr>

              <!-- <tr>
                <th>Requirement</th>
                <td>:</td>
                <td>
                  <?php
                  // $skills = array_column($getselectedprofile['requirement']['requirment_vacancy'], 'skill');
                  // $skillNames = array_column($skills, 'name');
                  // echo h(implode(', ', $skillNames));
                  ?>
                </td>
              </tr> -->

              <tr>
                <th>Location</th>
                <td>:</td>
                <td><?= h($getselectedprofile['requirement']['location']); ?></td>
              </tr>
            <?php } else { ?>

              <tr>
                <th>Payment Offered</th>
                <td>:</td>
                <td>
                  <?php echo ($data['payment_amount'] > 0) ? $data['payment_amount'] : 'Open to Negotiation'; ?>
                </td>
              </tr>

              <?php if ($quote == 'quote_receive' || $quote == 'quote_revised') { ?>
                <tr>
                  <th>Quote Received</th>
                  <td>:</td>
                  <td>
                    <?php
                    if (!empty($requirement['amt'])) {
                      echo (!empty($recievedPaymentQuote['currency']) ? $recievedPaymentQuote['currency'] . ' ' : '') . $requirement['amt'];
                      if (!empty($recievedPaymentQuote['frequency'])) {
                        echo ' / ' . $recievedPaymentQuote['frequency'];
                      }
                    } else {
                      echo 'Open to Negotiation';
                    }
                    ?>
                  </td>
                </tr>

              <?php } ?>
            <?php } ?>

            <?php if ($quote == 'quote_revised') {
              $quote_revised_fre_curre =  $this->Comman->getPaymentCurrencyAndFreq($requirement['revised_payment_frequency'], $requirement['revised_payment_currency']);
              // pr($requirement['revision']);exit;
            ?>
              <tr>
                <th>Revised Quote Sent Amount</th>
                <td>:</td>
                <td><?php
                    if (!empty($requirement['revision'])) {
                      echo (!empty($quote_revised_fre_curre['currency']) ? $quote_revised_fre_curre['currency'] . ' ' : '') . $requirement['revision'];
                      if (!empty($quote_revised_fre_curre['frequency'])) {
                        echo ' / ' . $quote_revised_fre_curre['frequency'];
                      }
                    } else {
                      echo '-';
                    }
                    ?></td>
              </tr>

            <?php  } ?>


            <tr>
              <th>Status </th>
              <td>:</td>
              <td><?php echo $status ?> on (<?php echo date("M-d,Y h:m A", strtotime($requirement['created'])); ?>) </td>
            </tr>

            <tr>
              <th>Event End Date & Time</th>
              <td>:</td>
              <td> <?php if ($data['requirement']['continuejob'] == 'N') { ?>
                  <?php echo date('M-d,Y h:m A', strtotime($data['requirement']['event_to_date'])); ?>
                <?php } else { ?>
                  <?php echo date('M-d,Y h:m A', strtotime($data['requirement']['last_date_app'])); ?>
                <?php } ?></td>
            </tr>


            <tr>
              <th>Action</th>
              <td>:</td>

              <?php if ($quote == 'application') { ?>

                <td>
                  <a href="<?php echo SITE_URL; ?>/requirement/applicationselect/<?php echo $requirement['id'] ?>/<?php echo $requirement['skill']['id']; ?>/<?php echo $requirement['job_id']; ?>" data-toggle="tooltip" data-placement="top" title="Select" class="btn btn-job">Select</a>
                  <a href="<?php echo SITE_URL; ?>/requirement/applicationreject/<?php echo $requirement['id'] ?>/R" data-toggle="tooltip" data-placement="top" title="Reject" class="btn btn-job">Reject</a>
                </td>

              <?php } elseif ($quote == 'quote_receive') { ?>

                <td>
                  <a data-toggle="modal" class='quote btn btn-success btn-job' href="<?php echo SITE_URL ?>/requirement/amountquote/<?php echo $requirement['id']; ?>">Send Revised Quote</a>

                  <a href="<?php echo SITE_URL; ?>/requirement/quoteselect/<?php echo $requirement['id'] ?>/S" data-toggle="tooltip" data-placement="top" title="Select" class="btn btn-job">Select</a>

                  <a href="<?php echo SITE_URL; ?>/requirement/quotereject/<?php echo $requirement['id'] ?>/R" data-toggle="tooltip" data-placement="top" title="Reject" class="btn btn-job">Reject</a>
                </td>

              <?php } elseif ($quote == 'quote_revised') { ?>

                <td><a href="<?php echo SITE_URL; ?>/requirement/quotereject/<?php echo $requirement['id'] ?>/R" data-toggle="tooltip" data-placement="top" title="Reject" class="btn btn-job" onClick="javascript:return confirm('Are you sure do you want to reject this job')">Reject</a> </td>

              <?php } elseif ($quote == 'reject_receive') { ?>

                <td>
                  <a href="<?php echo SITE_URL; ?>/requirement/applicationselect/<?php echo $requirement['id'] ?>/<?php echo $requirement['skill']['id']; ?>/<?php echo $requirement['job_id']; ?>" data-toggle="tooltip" data-placement="top" title="Select" class="btn btn-job">Select</a>
                </td>

              <?php } elseif ($quote == 'sel_receive') { ?>

                <td>
                  <a href="<?php echo SITE_URL; ?>/requirement/applicationreject/<?php echo $requirement['id'] ?>/R" data-toggle="tooltip" data-placement="top" title="Reject" class="btn btn-job" onClick="javascript:return confirm('Are you sure do you want to reject this job')">Reject</a>
                </td>

              <?php  } elseif ($quote == 'booking_sent') { ?>

                <td>
                  <a href="<?php echo SITE_URL; ?>/requirement/deleteapplication/<?php echo $requirement['id'] ?>" data-toggle="tooltip" data-placement="top" title="Cancel" class="btn btn-job" onClick="javascript:return confirm('Are you sure do you want to cancel this booking')">Cancel</a>
                </td>

              <?php } elseif ($quote == 'quote_request') { ?>

                <td>
                  <a href="<?php echo SITE_URL; ?>/requirement/deletequotes/<?php echo $requirement['id'] ?>" data-toggle="tooltip" data-placement="top" title="Cancel" class="btn btn-job" onClick="javascript:return confirm('Are you sure do you want to cancel this request')">Cancel</a>
                </td>

              <?php } elseif ($quote == 'ping_receive') { ?>

                <td>
                  <a href="<?php echo SITE_URL; ?>/requirement/applicationselect/<?php echo $requirement['id'] ?>/S" data-toggle="tooltip" data-placement="top" title="Select" class="btn btn-job">Select</a>
                  <a href="<?php echo SITE_URL; ?>/requirement/applicationreject/<?php echo $requirement['id'] ?>/R" data-toggle="tooltip" data-placement="top" title="Reject" class="btn btn-job">Reject</a>
                </td>

              <?php } ?>

            </tr>

          </table>
        </div>
      </div>



    </div>

  <?php } ?>
<?php } else { ?>
  <?php echo "No Data Found"; ?>
<?php } ?>

<style type="text/css">
  .ul_li ul li {
    padding: 10px 0 0 10px;
  }

  .ul_li ul li i {
    padding: 0 10px 0 0;
  }
</style>

<!-- Modal -->

<div id="myModal" class="modal fade">
  <div class="modal-dialog">

    <div class="modal-content">

      <div class="modal-body" id="skillsetsearch"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->

</div>
<!-- /.modal -->


<!-- Modal -->

<!-- reviews modal -->

<div id="reviews" class="modal fade">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" style="text-align: center;">Review & Rating</h4>
      </div>
      <div class="modal-body"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->

</div>
<!-- /.modal -->


<!-- Modal -->

<script>
  $('.reviewrate').click(function(e) {
    e.preventDefault();
    $('#reviews').modal('show').find('.modal-body').load($(this).attr('href'));
  });


  $('.quote').click(function(e) {
    e.preventDefault();
    $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
  });


  $('#selectjob').click(function() { //alert();
    job_id = $(this).data('val');
    if (job_id > 0) {
      $.ajax({
        type: "POST",
        url: '<?php echo SITE_URL; ?>/requirement/applicationselect',
        data: {
          job_id: job_id
        },
        cache: false,
        success: function(data) {}
      });
    }

  });
</script>


<!-- Trigger the modal with a button -->


<script>
  function profilecounter(obj) {

    $.ajax({
      type: "post",
      url: '<?php echo SITE_URL; ?>/profile/profilecounter',
      data: {
        data: obj
      },
      success: function(data) {
        objss = JSON.parse(data);
        if (objss.status == 1) {
          var div = document.getElementById("newpostt" + obj);

          div.style.display = "block";
        } else {
          showerror(objss.error);
        }
      }
    });
  }


  function showerror(error) {
    BootstrapDialog.alert({
      size: BootstrapDialog.SIZE_SMALL,
      title: "<img title='Book an Artiste' src='<?php echo SITE_URL; ?>/images/book-an-artiste-logo.png' alt='Book an Artiste' class='img-circle' height='26' width='26'> - Notification !!",
      message: "<h5>" + error + "</h5>"
    });
    return false;
  }
</script>