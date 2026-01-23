

<section id="page_signup">
 <div class="container">
   <div class="row">
     <div class="col-sm-2">
     </div>

     <div class="col-sm-12">
       <div class="signup-popup">
         <h2>My Earlier Feature Profile</h2>
         <?php echo $this->Flash->render(); ?>

         <div class="box-body">
  
           <div class="manag-stu">


<div class="clearfix">

   </div><br>

   <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width: 10% !important;">S.R.</th>
        <th>User Name</th>
        <th>User Email Id</th>
        <th>Feature Start Date</th>
        <th>Feature End Date</th>
        <th>Number Of Days</th>
        <th>Total Price Paid</th>
      </tr>

    </thead>
    <tbody id="example2">
              <?php 
              $counter = 1;
              if(isset($fprofile) && !empty($fprofile)){ 
		              foreach($fprofile as $admin){  //pr($admin); 
                    $featstart=date('Y-m-d H:m:s',strtotime($admin['startdate']));
                    $expiredate=date('Y-m-d H:m:s',strtotime($admin['expirydate']));
                   // echo $admin['feature_job_date'];
                    ?>
                    <tr>
                    <td>
                        <?php echo $counter ?>
                      </td>
                      <td>
                        <?php echo $admin['user']['user_name']; ?>
                      </td>
                      <td>
                        <?php echo $admin['user']['email']; ?>
                       </td>
                      <td><?php if($admin['startdate']){ echo $featstart; }else{ echo "N/A"; } ?></td>
                      <td><?php if($admin['expirydate']){ echo $expiredate; }else{ echo "N/A"; } ?></td>                      
                      
                      <td>
                        <?php echo $admin['number_of_days']; ?> 
                      </td>                     
                      <td>
                        <?php echo "$".$admin['amount']; ?> 
                      </td>                     
                      
                    </tr>
                    <?php $counter++;} }

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


