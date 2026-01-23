<style>
  .packageTbl input {
    width: 100%;
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Visibility Matrix

    </h1>
    <?php echo $this->Flash->render(); ?>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title"> Visibility Matrix</h3>
          </div>

          <!-- /.box-header -->
          <div class="row">
            <!-- show notes here  -->
            <div class="col-xs-12">
              <div class="box">
                <div class="box-body">
                  <p class="priorities-list">
                    <strong><a target="_blank" href="<?= SITE_URL . '/admin/requirement' ?>">Requirement Manager Priorities Used:</a></strong> <?php echo $prioritiesText ?: 'No priorities found'; ?>
                  </p>
                </div>

                <?php echo $this->Flash->render(); ?>

                <?php echo $this->Form->create('', array(
                  'url' => array('action' => 'index'),
                  'class' => 'form-horizontal',
                  'id' => 'content_admin',
                  'enctype' => 'multipart/form-data',
                  // 'onsubmit' => 'return checkpass()',
                  'autocomplete' => 'off'
                )); ?>

                <div class="box-body">
                  <?php
                  $profileCount = count($profilepack);
                  $recruiterCount = count($recruiterpack);

                  $checkeduser = array(); // Initialize the checkeduser array

                  foreach ($matrix as $matrixvalue) {
                    $rec_id = $matrixvalue['recruiter_id'];
                    $p_id = $matrixvalue['profilepack_id'];
                    $id = $matrixvalue['id'];

                    $vs['id'] = $id;
                    $vs['ordernumber'] = $matrixvalue['ordernumber'];
                    $checkeduser[$rec_id][$p_id] = $vs; // Assign values to checkeduser array
                  }

                  ?>

                  <table id="" class="table table-bordered table-striped packageTbl" width="100%">
                    <tbody>
                      <tr>
                        <th style="width: 14%; font-size: 16px; font-weight: bold;">
                          Recruiter <span style="font-size: 18px;">&#8595;</span> | Profile <span style="font-size: 18px;">&#8594;</span>
                        </th>

                        <?php foreach ($profilepack as $profile) { ?>
                          <th width="14%"><?php echo $profile['name']; ?></th>
                        <?php } ?>
                      </tr>
                      <?php foreach ($recruiterpack as $recruiter) {
                        $recruiterId = $recruiter['id'];
                      ?>
                        <tr>
                          <th><?php echo $recruiter['title']; ?></th>
                          <?php foreach ($profilepack as $profile) {
                            $profileId = $profile['id'];
                            $defaultValue = isset($checkeduser[$recruiterId][$profileId]['ordernumber']) ? $checkeduser[$recruiterId][$profileId]['ordernumber'] : 0;
                          ?>
                            <td>
                              <input name="hid[<?php echo $recruiterId; ?>][<?php echo $profileId; ?>]" type="hidden" value="<?php echo $checkeduser[$recruiterId][$profileId]['id']; ?>">
                              <input name="Visibilitymatrix[<?php echo $recruiterId; ?>][<?php echo $profileId; ?>]" type="text" value="<?php echo $defaultValue; ?>" required>
                            </td>
                          <?php } ?>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  <br><br>
                  <div align="center">
                    <button type="submit" class="btn add-paymentfield btn-danger btn-block"><i class="fa fa-add"></i>Save</button>
                  </div>
                </div>
                <!-- /.box-body -->
                <?php echo $this->Form->end(); ?>
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>

          <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(function() {
    var prioritiesText = "<?= $prioritiesText ?>"; // Get priorities list from PHP
    var priorityNumbers = prioritiesText.split(',').map(num => num.trim()); // Convert to array

    $('#content_admin').submit(function() {
      var len = $('input[type="text"]').length;
      var i, k;

      console.log("🚀 Total Inputs:", len);

      $('input[type="text"]').css({
        'border': 'solid 1px #888'
      });

      for (i = 0; i < len; i++) {
        var v = $('input[type="text"]:eq(' + i + ')').val().trim();

        // Check for duplicate values in the form
        for (k = 0; k < i; k++) {
          var s = $('input[type="text"]:eq(' + k + ')').val().trim();
          if (s == v) {
            $('input[type="text"]:eq(' + i + ')').css({
              'border': 'solid 1px #F00'
            });
            $('input[type="text"]:eq(' + k + ')').css({
              'border': 'solid 1px #F00'
            });
            alert("Duplicate Values found in the form. Please check and correct.");
            return false;
          }
        }

        // Check if value is in the priority list (from Requirement Manager)
        if (priorityNumbers.includes(v)) {
          $('input[type="text"]:eq(' + i + ')').css({
            'border': 'solid 1px #F00'
          });
          alert("The number '" + v + "' is already used in Requirement Manager priorities. Please choose a different number.");
          return false;
        }
      }
    });
  });

  // $(function() {
  //   $('#content_admin').submit(function() {
  //     var len = $('input').length,
  //       i, k;
  //     console.log("🚀 ~ file: index.ctp:108 ~ $ ~ len:", len)

  //     $('input').css({
  //       'border': 'solid 1px #888'
  //     })

  //     for (i = 0; i < len; i++) {
  //       var v = $('input:eq(' + i + ')').val();
  //       for (k = 0; k < i; k++) {
  //         var s = $('input:eq(' + k + ')').val();
  //         if (s == v) {
  //           $('input:eq(' + i + ')').css({
  //             'border': 'solid 1px #F00'
  //           })
  //           $('input:eq(' + k + ')').css({
  //             'border': 'solid 1px #F00'
  //           })
  //           alert("Duplicate Values found in the form. Please check and correct. ")
  //           return false;
  //         }
  //       }
  //     }
  //   })
  // })
</script>


<?php /* 
<div class="row">
  <div class="col-xs-12">
    <div class="box">

      <?php echo $this->Flash->render(); ?>
      <?php echo $this->Form->create('', array(
        'url' => array('action' => 'index'),
        'class' => 'form-horizontal',
        'id' => 'content_admin',
        'enctype' => 'multipart/form-data',
        'onsubmit' => ' return checkpass()', 'autocomplete' => 'off'
      )); ?>



      <?php foreach ($matrix as $matrixvalue) {
        $rec_id = $matrixvalue['recruiter_id'];
        $p_id = $matrixvalue['profilepack_id'];
        $id = $matrixvalue['id'];

        $vs['id'] = $id;
        $vs['ordernumber'] = $matrixvalue['ordernumber'];
        $rec[$rec_id] = $vs;
        $checkeduser[$p_id] = $rec;

        echo $checkeduser['pid'][$p_id];
      }
      //pr($checkeduser);

      ?>
      <div class="box-body">
        <?php
        $profile = count($profilepack);
        $recruiter = count($recruiterpack);

        ?>
        <table id="" class="table table-bordered table-striped">
          <tbody>

            <tr>
              <th></th>
              <?php for ($p = 0; $p < $profile; $p++) { ?>
                <th><?php echo $profilepack[$p]['name']; ?></th>
              <?php } ?>

            </tr>
            <tr>
              <?php for ($p = 0; $p < $profile; $p++) {

                $pid = $profilepack[$p]['id'];
              ?>
            <tr>

              <?php for ($r = 0; $r < $recruiter; $r++) {
                  $rid = $recruiterpack[$r]['id'];
              ?>

                <?php if ($r == 0) { ?>
                  <th><?php echo $recruiterpack[$p]['title']; ?></th>
                <?php } ?>

                <td>
                  <input name="hid[<?php echo $rid; ?>][<?php echo $pid; ?>]" type="hidden" value="<?php echo $checkeduser[$rid][$pid]['id'] ?>">
                  <input name="Visibilitymatrix[<?php echo $rid; ?>][<?php echo
                                                                      $pid; ?>]" type="text" value="<?php echo
                                                                                                              $checkeduser[$rid][$pid]['ordernumber'] ?>" required>
                </td>

              <?php } ?>

            </tr>
          <?php } ?>
          </tbody>
        </table>
        <br><br>
        <div align="center">
          <button type="submit" class="btn add-paymentfield btn-danger btn-block"><i class="fa fa-add"></i>Save</button>
        </div>

      </div>
      <!-- /.box-body -->

      <?php echo $this->Form->end(); ?>
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
*/ ?>