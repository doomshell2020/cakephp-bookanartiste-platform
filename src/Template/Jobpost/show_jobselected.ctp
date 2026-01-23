<script src="<?php echo SITE_URL; ?>/js/app.min.js"></script>

<section id="page_alert">
    <div class="container">
        <div class="job_search_heading">
            <h2>Selected <span>Job Result</span></h2>
        </div>
    </div>

    <div class="refine-search">
        <div class="container">
            <div class="row m-top-20 profile-bg">
                <div class="col-sm-12">
                    <?php if (count($jobdata) > 0): ?>
                        <div class="panel-right">
                            <form>
                                <?php foreach ($jobdata as $value): ?>
                                    <?php
                                    if (!in_array($value['id'], $jobarray) && !in_array($value['id'], $_SESSION['jobsearchdata'])):
                                        $getselectedprofile = $this->Comman->selectedProfile($value['job_id']);
                                        $vacancyDetails = $getselectedprofile['requirement']['requirment_vacancy'][0];
                                        $currencySymbol = $vacancyDetails['currency']['symbol'];
                                    ?>
                                        <div id="<?= $value['id']; ?>" class="box member-detail alerts jobalertss <?= ($applicationrec['viewedstatus'] == 'Y') ? 'jobviewed' : 'jobnotviewed'; ?>">
                                            <div class="row">
                                                <div class="profile-bg job_rslt_bg">
                                                    <div class="clearfix">
                                                        <div class="col-sm-12">
                                                            <div class="clearfix job-box">
                                                                <div class="col-sm-2">
                                                                    <div class="profile-det-img1">
                                                                        <img src="<?= SITE_URL; ?>/job/<?= $value['requirement']['image']; ?>" onerror="this.onerror=null;this.src='<?= SITE_URL ?>/images/job.jpg';">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-10">
                                                                    <div class="box_dtl_text">
                                                                        <h3 class="heading">
                                                                            <a href="<?= SITE_URL; ?>/applyjob/<?= $value['job_id']; ?>"><?= htmlspecialchars($value['requirement']['title']); ?></a>
                                                                            <span><?= date('d M Y', strtotime($value['requirement']['last_date_app'])); ?></span>
                                                                        </h3>

                                                                        <div class="row job-r-skill">
                                                                            <div class="col-sm-6">
                                                                                <p><strong>Job Posted By :</strong>
                                                                                    <a href="<?= SITE_URL; ?>/viewprofile/<?= $value['requirement']['user']['id']; ?>">
                                                                                        <?= htmlspecialchars($value['requirement']['user']['user_name']); ?>
                                                                                    </a>
                                                                                </p>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <p><strong>Requirement :</strong>
                                                                                <?php
                                                                                    $skillNames = [];
                                                                                    $max = 0;
                                                                                    $skills = $this->Comman->requimentskill($value['job_id']);
                                                                                    foreach ($skills as $vacancy) {
                                                                                        if (!empty($vacancy['skill']['name'])) {
                                                                                            $skillNames[] = htmlspecialchars($vacancy['skill']['name']);
                                                                                        }
                                                                                        if ($max < $vacancy['payment_amount']) {
                                                                                            $max = $vacancy['payment_amount'];
                                                                                        }
                                                                                    }
                                                                                    echo implode(', ', $skillNames);
                                                                                    ?>
                                                                                </p>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <p><strong>Applied For :</strong> <?= htmlspecialchars($value['skill']['name']); ?></p>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <p><strong>Experience :</strong> <?= max(0, date("Y") - $value['user']['user']['professinal_info']['performing_year']); ?> Years</p>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <p><strong>Currency :</strong> <?= !empty($currencySymbol) ? htmlspecialchars($currencySymbol) : 'N/A'; ?></p>
                                                                            </div>

                                                                            <?php if (!empty($vacancyDetails['payment_amount'])): ?>
                                                                                <div class="col-sm-6">
                                                                                    <p><strong>Payment Offer :</strong> <?= htmlspecialchars($currencySymbol . $vacancyDetails['payment_amount']); ?></p>
                                                                                </div>
                                                                            <?php endif; ?>

                                                                            <?php if (!empty($getselectedprofile['amt'])): ?>
                                                                                <div class="col-sm-6">
                                                                                    <p><strong>Quote Sent :</strong> <?= htmlspecialchars($currencySymbol . $getselectedprofile['amt']); ?></p>
                                                                                </div>
                                                                            <?php endif; ?>

                                                                            <?php if (!empty($getselectedprofile['revision'])): ?>
                                                                                <div class="col-sm-6">
                                                                                    <p><strong>Revised Quote Received :</strong> <?= htmlspecialchars($currencySymbol . $getselectedprofile['revision']); ?></p>
                                                                                </div>
                                                                            <?php endif; ?>

                                                                            <div class="col-sm-6">
                                                                                <p><strong>Location :</strong> <?= htmlspecialchars($getselectedprofile['requirement']['location']); ?></p>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <p><strong>Status :</strong> Selected on (<?= date("M-d,Y h:i:s", strtotime("2025-04-22 11:04:00")); ?>)</p>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <p><strong>Event End Date & Time :</strong>
                                                                                    <?php
                                                                                    $endDate = ($getselectedprofile['requirement']['continuejob'] == 'N')
                                                                                        ? $getselectedprofile['requirement']['event_to_date']
                                                                                        : $getselectedprofile['requirement']['last_date_app'];
                                                                                    echo date('M-d,Y h:i:s', strtotime($endDate));
                                                                                    ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </form>
                        </div>
                    <?php else: ?>
                        <p>No Alerts for you at the moment</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</section>

<style>
    #page_alert .member-detail .btn-primary,
    .member-detail .btn-default {
        margin-top: 0;
    }

    .col-sm-10 {
        bottom: 20px;
        right: 30px;
    }

    .row {
        margin-right: 0;
        margin-left: 0;
    }
</style>

<script>
    $(document).ready(function() {
        const site_url = '<?php echo SITE_URL; ?>/';

        $('.delete_jobalerts').on('click', function() {
            const job_id = $(this).data('val');
            const job_action = $(this).data('action');

            $.post(site_url + 'myalerts/alertsjob', {
                job: job_id,
                action: job_action
            }, function() {
                $("." + job_id).remove();
            });
        });

        $(".jobalerts").on("click", function() {
            $(".alerts").hide();
            $("." + $(this).data("action")).show();
        });

        $('.navff li').on('click', function() {
            $('.navff li').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>