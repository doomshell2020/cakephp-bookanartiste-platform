<style>
    #page_alert .member-detail .btn-primary {
        margin-top: 0;
    }

    .member-detail .btn-default {
        margin-top: 0;
    }
</style>
<script src="<?php echo SITE_URL; ?>/js/app.min.js"></script>

<section id="page_alert">
    <div class="container">
        <div class="job_search_heading">

            <h2> selected <span>Job Result</span></h2>
        </div>
    </div>

    <div class="refine-search">
    <div class="container">
        <div class="row m-top-20 profile-bg">
            <div class="col-12">
                <?php
                if (count($sendquotedata) > 0 || count($pingdata) > 0 || count($sendreviseddata) > 0 || count($jobdata) > 0 || count($paidquotedata) > 0) {
                    // Display job alerts
                } else {
                    echo "No Alerts for you at the moment";
                }
               ?>
                <div class="panel-right">
                    <form>
                        <?php
                        if (count($jobdata) > 0) {
                            foreach ($jobdata as $value) {
                                if (!in_array($value['id'], $jobarray) &&!in_array($value['id'], $_SESSION['jobsearchdata'])) {
                       ?>
                                    <div id="<?php echo $value['id'];?>" class="box member-detail alerts jobalertss <?php if ($applicationrec['viewedstatus'] == 'Y') {?>jobviewed<?php } else {?>jobnotviewed <?php }?>">
                                        <div class="row">
                                            <div class="profile-bg job_rslt_bg">
                                                <div class="clearfix">
                                                    <div class="col-sm-12">
                                                        <div class="clearfix job-box">
                                                            <div class="col-sm-2">
                                                                <div class="profile-det-img1">
                                                                    <img src="<?php echo SITE_URL;?>/job/<?php echo $value['requirement']['image']?>" onerror="this.onerror=null;this.src='<?php echo SITE_URL?>/images/job.jpg';">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <div class="box_dtl_text">
                                                                    <h3 class="heading">
                                                                        <a href="<?php echo SITE_URL;?>/applyjob/<?php echo $value['job_id']?>"><?php echo $value['requirement']['title']?></a>
                                                                        <span><?php echo date('d M Y', strtotime($value['requirement']['last_date_app']));?></span>
                                                                    </h3>
                                                                    <p><?php echo $value['location']?></p>
                                                                    <ul class="list-unstyled job-r-skill">
                                                                        <li><a href="#" class="fa fa-user"></a>
                                                                            Job Posted By <a href="<?php echo SITE_URL;?>/viewprofile/<?php echo $value['requirement']['user']['id']?>"><?php echo $value['requirement']['user']['user_name']?></a>
                                                                        </li>
                                                                        <li><a href="#" class="fa fa-braille"></a>
                                                                            <?php
                                                                            $skill = $this->Comman->requimentskill($value['job_id']);
                                                                            $max = 0;
                                                                            foreach ($skill as $vacancy) {
                                                                                $skillarray = array();
                                                                                if ($max < $vacancy['payment_amount']) {
                                                                                    $max = $vacancy['payment_amount'];
                                                                                }
                                                                                echo $vacancy['skill']['name'];
                                                                            }
                                                                           ?>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }
                       ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<script>
    $(document).ready(function() {
        var site_url = '<?php echo SITE_URL; ?>/';
        $('.delete_jobalerts').click(function() {
            var job_id = $(this).data('val');
            // $("#"+job_id).remove();
            var job_action = $(this).data('action');
            $.ajax({
                type: "post",
                url: site_url + 'myalerts/alertsjob',
                data: {
                    job: job_id,
                    action: job_action
                },
                success: function(data) {
                    $("." + job_id).remove();
                }

            });


        });
    });
</script>


<script>
    $(document).ready(function() {
        $(".jobalerts").click(function() {
            var val = $(this).data('action');
            $(".alerts").hide();
            $("." + val).show();
        });

        var selector = '.navff li';

        $(selector).on('click', function() {
            $(selector).removeClass('active');
            $(this).addClass('active');
        });

    });
</script>