

<section id="page_signup">
 <div class="container">
   <div class="row">
     <div class="col-sm-2">
     </div>

     <div class="col-sm-12">
       <div class="signup-popup">
         <h2>My Previously Advertised Jobs</h2>
         <p>Details of the my earlier advertised jobs in the last 180 days</p>
         <?php echo $this->Flash->render(); ?>

         <div class="box-body">

           <div class="manag-stu">


<div class="clearfix">

   </div><br>

   <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width: 10% !important;"></th>
        <th>Job Title</th>
        <th>Ad Date From</th>
        <th>Ad Date To</th>
        <th>Number of Days</th>
        <th>Amount Spent</th>
        <th>Status</th>
      </tr>

    </thead>
    <tbody id="example2">
              <?php 
              $counter = 1;
              if(isset($Job) && !empty($Job)){ 
		              foreach($Job as $admin){  //pr($admin); 
                    $currentdate=date('Y-m-d H:m:s');
                $todates= date('Y-m-d H:m:s',strtotime($admin['ad_date_to'])); 

                $fromdate= date('Y-m-d',strtotime($admin['ad_date_from'])); 
                $todate= date('Y-m-d',strtotime($admin['ad_date_to'])); 
                $date1 = date_create($fromdate);
                $date2 = date_create($todate);
                $diff = date_diff($date1,$date2);
                $bannerdays=$diff->days;

                $date3 = date_create($currentdate);

                $toaldays = date_diff($date2,$date3);
                $totaldays=$toaldays->days;
                   // echo $admin['feature_job_date'];
                if ($totaldays < 180) {
                 
                    ?>
                    <tr>
                      <td><?php //echo $counter; 
                      if ($admin['job_image_change']) {
                      ?>
                        <img src="<?php echo SITE_URL; ?>/job/<?php echo $admin['job_image_change']; ?>">
                        <?php }else{ ?>
                        <img src="<?php echo SITE_URL; ?>/images/job.jpg"/>
                        <?php } ?>
                      </td>
                      <td>
                      <?php if ($admin['requirement']['status']=='Y') { ?>
                       <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $admin['id']; ?>" target="_blank"><?php echo $admin['requirement']['title']; ?></a>
                       <?php }else{ ?>
                          <?php echo $admin['requirement']['title']; ?>
                       <?php } ?>
                       </td>
                       <!-- <td>
                        <?php //if(isset($admin->user->user_name)){ echo ucfirst($admin->user->user_name); }else{ echo 'N/A'; } ?>
                      </td> -->
                      <!-- <td><?php //echo $admin['user']['email']; ?></td> -->
                      <td><?php if($admin['ad_date_from']){ echo $fromdate; }else{ echo "N/A"; } ?></td>
                      <td><?php if($admin['ad_date_to']){ echo $todate; }else{ echo "N/A"; } ?></td>                      
                      <td>
                        <?php 
                          echo $bannerdays." Days";
                         ?> 
                      </td>
                      <td>
                        <?php if ($admin['req_ad_total']) {
                          echo "$".$admin['req_ad_total'];
                          }else{
                          echo "0";
                          }
                        ?> 
                      </td>
                       <td><?php if($todates>=$currentdate){ ?>
                    <span class="label label-info"> Ad Active</span>
                    <?php }else{ ?>
                      <span class="label label-success">Ad Inactive</span>
                      <?php } ?>
                    </td>
                      
                      
                    </tr>
                    <?php $counter++; } } }

                    else{ ?>
                    <tr>
                      <td colspan="11" align="center">You do not have any featured requirements
                      </td>
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
        $("#country_ids").on('change',function() {
          var id = $(this).val();
          $("#state").find('option').remove();
      //$("#city").find('option').remove();
      if (id) {
        var dataString = 'id='+ id;
        $.ajax({
          type: "POST",
          url: '<?php echo SITE_URL;?>/talentadmin/getStates',
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

        $("#state").on('change',function() {
          var id = $(this).val();
          $("#city").find('option').remove();
          if (id) {
            var dataString = 'id='+ id;
            $.ajax({
              type: "POST",
              url: '<?php echo SITE_URL;?>/talentadmin/getcities',
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



    <script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
    <script>
      $( function() {

        var dateFormat = 'dd-mm-yy',
        from = $( "#datepicker1" )
        .datepicker({
          dateFormat: 'dd-mm-yy',

          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
        to = $( "#datepicker2" ).datepicker({
          dateFormat: 'dd-mm-yy',

          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          from.datepicker( "option", "maxDate", getDate( this ) );
        });

        function getDate( element ) {
          var date;
          try {
            date = $.datepicker.parseDate( dateFormat, element.value );
          } catch( error ) {
            date = null;
          }

          return date;
        }
      } );
    </script>

    <script>
     $(function () {
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


