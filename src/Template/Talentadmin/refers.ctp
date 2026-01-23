<!----------------------editprofile-strt------------------------>
<section id="page_signup">
  <div class="container">
    <div class="row">

      <div class="col-sm-12">
        <div class="signup-popup">
          <h2>Profiles<span> Uploaded</span></h2>
          <?php echo $this->Flash->render(); ?>
          <div class="clearfix">
            <a href="<?php echo SITE_URL; ?>/talent-partner/upload-profile">
              <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                Upload Profile</button></a>
          </div><br>

          <script inline="1">
            //<![CDATA[
            $(document).ready(function() {
              $("#TaskAdminCustomerForm").bind("submit", function(event) {
                $.ajax({
                  async: true,
                  data: $("#TaskAdminCustomerForm").serialize(),
                  dataType: "html",
                  success: function(data, textStatus) {

                    $("#example1").html(data);
                  },
                  type: "POST",
                  url: "<?php echo SITE_URL; ?>/talentadmin/uploadedprofilesearch"
                });
                return false;
              });
            });
            //]]>
          </script>
          <?php echo $this->Form->create('Task', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm', 'class' => 'form-horizontal')); ?>

          <div class="form-group">
            <div class="col-sm-3">
              <label>Update On - Date From</label>
              <input type="text" class="form-control" id="datepicker1" name="from_date" placeholder="Date From" autocomplete="off" readonly="readonly">
            </div>

            <div class="col-sm-3">
              <label>Date To</label>
              <input type="text" class="form-control" id="datepicker2" name="to_date" placeholder="To Date" autocomplete="off" readonly="readonly">
            </div>

            <div class="col-sm-3">
              <label>Name</label>
              <input type="text" class="form-control" name="name" placeholder="Enter Name" autocomplete="off">
            </div>

            <div class="col-sm-3">
              <label>Email</label>
              <input type="text" class="form-control" name="email" placeholder="Enter Email" autocomplete="off">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-2">
              <!-- <label>Country</label> -->
              <?php echo $this->Form->input('country_id', array('class' => 'form-control', 'placeholder' => 'Country', 'id' => 'country_ids', 'label' => false, 'empty' => '-Select Country-', 'options' => $country)); ?>
            </div>

            <div class="col-sm-2">
              <!-- <label>State</label> -->
              <?php echo $this->Form->input('state_id', array('class' => 'form-control', 'placeholder' => 'State', 'id' => 'state', 'label' => false, 'empty' => '-Select State-')); ?>
            </div>
            <div class="col-sm-2">
              <!-- <label>City</label> -->
              <?php echo $this->Form->input('city_id', array('class' => 'form-control', 'placeholder' => 'City', 'id' => 'city', 'label' => false, 'empty' => '-Select City-')); ?>
            </div>

            <div class="col-sm-2">

              <select class="form-control" name="status">
                <option value="" selected="selected">All</option>
                <option value="Y">Registered</option>
                <option value="N">Non Registered</option>
              </select>
            </div>

            <div class="col-sm-2">
              <select class="form-control" name="transaction">
                <option value="" selected="selected">All </option>
                <option value="Y">Transaction Done</option>
                <option value="N">No Transaction Done</option>
              </select>
            </div>
            <button type="submit" class="btn btn-success">Search</button>
            <button type="reset" class="btn reset">Reset</button>
          </div>


          <div class="row">
            <div class="col-sm-4">

              <a href="<?php echo SITE_URL; ?>/talentadmin/uploadedprofilexcel" class="btn btn-warning">Export Excel</a>
            </div>

            <script>
              $(".reset").click(function() {
                $.ajax({
                  async: true,
                  dataType: "html",
                  success: function(data, textStatus) {
                    $('#TaskAdminCustomerForm').trigger("reset");
                    $("#example1").html(data);
                  },
                  type: "POST",
                  url: "<?php echo SITE_URL; ?>/talentadmin/uploadedprofilesearch"
                });
                return false;
              });
            </script>

          </div>
          <?php
          echo $this->Form->end();
          ?>


          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>S.no</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Uploaded On</th>
                <th>Transaction Amount incl Tax</th>
                <th>Last Transaction Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="example1">
              <?php
              $counter = 1;
              if (isset($contentadmin) && !empty($contentadmin)) {
                foreach ($contentadmin as $admin) { //pr($admin); //die;
              ?>
                  <tr>
                    <td><?php echo $counter; ?></td>
                    <td>
                      <?php if (isset($admin['name'])) {
                        echo $admin['name'];
                      } else {
                        echo 'N/A';
                      } ?>
                      </a>
                    </td>
                    <td><?php if (isset($admin['email'])) {
                          echo $admin['email'];
                          $user_exist = $this->Comman->checkuserexist($admin['email']);

                          if (!empty($user_exist)) {
                            $mails = $this->Comman->profilemails($user_exist['id']);

                            if (!empty($mails['altemail'])) {
                              echo '</br>' . str_replace(",", "</br>", $mails['altemail']);
                            }
                          }
                        } else {
                          echo 'N/A';
                        } ?></td>
                    <?php $var = $this->Comman->referuserno($admin['email']); //pr($var); 
                    ?>
                    <td>
                      <?php
                      $user_exist = $this->Comman->checkuserexist($admin['email']);
                      //pr($user_exist);
                      if (isset($user_exist)) {
                        $referphone = $this->Comman->profilphone($user_exist['id']);
                        //pr($referphone);
                        if ($referphone['phone']) {
                          echo $referphone['phone'];
                          if (!empty($referphone['altnumber'])) {
                            $removespace = str_replace(' ', '', $referphone['altnumber']);
                            $altphone = explode(",", $removespace);
                            foreach ($altphone as $altphonevalue) {
                              if (strpos($altphonevalue, '+') !== false) {
                                echo ", " . $altphonevalue;
                              } else {
                                echo ", " . $altphonevalue;
                              }
                            }
                          } else {
                            echo '-';
                          }
                        } else {
                          if (!empty($admin['mobile'])) {
                            echo $admin['mobile'];
                          } else {
                            echo '-';
                          }
                        }
                      } else {
                        if (!empty($admin['mobile'])) {
                          echo $admin['mobile'];
                        } else {
                          echo '-';
                        }
                      }
                      ?>

                    </td>
                    <td><?php if (isset($admin['created'])) {
                          echo date('M d, Y', strtotime($admin['created']));
                        } else {
                          echo 'N/A';
                        } ?> </td>

                    <td>
                      <?php $transaction = $this->Comman->transactions($user_exist['id']); //pr($transaction); 
                      ?>
                      <?php if (!empty($transaction['sum'])) {
                        echo number_format($transaction['sum'], 2);
                      } else {
                        echo "No Transactions";
                      } ?>
                    </td>

                    <td>
                      <?php $lasttransaction = $this->Comman->lasttransaction($user_exist['id']); //pr($transaction); 
                      ?>
                      <?php if (!empty($lasttransaction['created'])) {
                        echo date("d-M-Y h:i:s A", strtotime($lasttransaction['created']));
                      } else {
                        echo "-";
                      } ?>
                    </td>

                    <td><?php if ($admin['status'] == 'Y') { ?>
                        <span class="label label-success">Registered</span>
                      <?php } else { ?>
                        <span class="label label-primary">Not Registered</span>

                        <?php
                          echo $this->Html->link('Delete', [
                            'action' => 'referdelete',
                            $admin->id
                          ], ['class' => 'label label-danger', "onClick" => "javascript: return confirm('Are you sure do you want to delete this')"]); ?>

                      <?php } ?>
                      <script>
                        // function confirmFunction(){
                        //   var name = '<?php //echo $admin['name']; 
                                          ?>';
                        //   return confirm("Are you sure you want to delete "+name);
                        // }
                      </script>
                    </td>
                  </tr>
                  </td>
                  </tr>
                <?php $counter++;
                }
              } else { ?>
                <tr>
                  <td colspan="11" align="center">You have not uploaded any profile yet</td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>

<script type="text/javascript">
  $(document).ready(function() {
    $("#country_ids").on('change', function() {
      var id = $(this).val();
      $("#state").find('option').remove();
      //$("#city").find('option').remove();
      if (id) {
        var dataString = 'id=' + id;
        $.ajax({
          type: "POST",
          url: '<?php echo SITE_URL; ?>/talentadmin/getStates',
          data: dataString,
          cache: false,
          success: function(html) {
            $('<option>').val("").text("-Select State-").appendTo($("#state"));
            $.each(html, function(key, value) {
              $('<option>').val(key).text(value).appendTo($("#state"));
            });
          }
        });
      }
    });

    $("#state").on('change', function() {
      var id = $(this).val();
      $("#city").find('option').remove();
      if (id) {
        var dataString = 'id=' + id;
        $.ajax({
          type: "POST",
          url: '<?php echo SITE_URL; ?>/talentadmin/getcities',
          data: dataString,
          cache: false,
          success: function(html) {
            $('<option>').val("").text("-Select City-").appendTo($("#city"));
            $.each(html, function(key, value) {
              $('<option>').val(key).text(value).appendTo($("#city"));
            });
          }
        });
      }
    });
  });
</script>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $(function() {

    var dateFormat = 'yy-mm-dd',
      from = $("#datepicker1")
      .datepicker({
        dateFormat: 'M d,yy',
        changeYear: true,
        changeMonth: true,
        numberOfMonths: 1
      })
      .on("change", function() {
        to.datepicker("option", "minDate", getDate(this));
      }),
      to = $("#datepicker2").datepicker({
        dateFormat: 'M d,yy',
        changeYear: true,
        changeMonth: true,
        numberOfMonths: 1
      })
      .on("change", function() {
        from.datepicker("option", "maxDate", getDate(this));
      });

    function getDate(element) {
      var date;
      try {
        date = $.datepicker.parseDate(dateFormat, element.value);
      } catch (error) {
        date = null;
      }

      return date;
    }
  });
</script>

<script>
  $(function() {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>