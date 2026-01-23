
<?php 
foreach($country as $country_data)
{
  $country_id = $country_data['Country']['id'];
  $countryarr[$country_id] = $country_data['Country']['name'];
}
?>
<section id="page_signup">
 <div class="container">
   <div class="row">
     <div class="col-sm-2">
     </div>

     <div class="col-sm-12">
       <div class="signup-popup">
         <h2>Feature <span>My Requirements</span></h2>
         <p>Select a job to feature</p>
         <?php echo $this->Flash->render(); ?>

         <div class="box-body">

           <div class="manag-stu">

            <script inline="1">
//<![CDATA[
$(document).ready(function () {
  $("#TaskAdminCustomerForm").bind("submit", function (event) {
    $('#loading-image').show();
    $.ajax({
      async:true,
      data:$("#TaskAdminCustomerForm").serialize(),
      dataType:"html", 
      success:function (data, textStatus) {
       $('#loading-image').hide();
        $("#example2").html(data);}, 
        type:"POST", 
        url:"<?php echo SITE_URL; ?>/requirement/requirsearch"});
    return false;
  });
});
//]]>
</script>
<?php  echo $this->Form->create('Task',array('type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>

<div class="form-group">
 
 <div class="col-sm-2">
   <label>Job Name</label>
   <input type="text" class="form-control" name="name" placeholder="Enter Job Name" autocomplete="off">
 </div> 

 <div class="col-sm-1">
   <label><span style="color:white">.</span></label>
   <button type="submit" class="btn btn-success form-control">Search</button>
 </div> 

 <div class="col-sm-1" style="margin-left:-22px">
   <label><span style="color:white">.</span></label>
   <button type="reset" class="btn btn-danger form-control">Reset</button>
 </div> 

 <div class="col-sm-2" style="margin-left:-22px; width: auto;">
   <label><span style="color:white">.</span></label>
  <a class="btn btn-warning form-control" href="<?php echo SITE_URL; ?>/requirement/requirexcel">Export Excel</a>
 </div> 

</div>

<div class="form-group">



<!--  <div class="col-sm-2">

   <select class="form-control" name="status" >
    <option value="" selected="selected">-Select Status-</option>
    <option value="Y">Active</option>
    <option value="N">Inactive</option>
  </select>
</div>  -->



<!-- <div class="col-sm-4">
  <button type="submit" class="btn btn-success">Search</button>
  <button type="reset" class="btn">Reset</button>
  <a class="btn btn-warning" href="<?php echo SITE_URL; ?>/requirement/requirexcel">Export Excel</a>
</div> -->

</div>
<?php
echo $this->Form->end();
?> 

<div class="clearfix">

   </div><br>

   <div class="table-div">
   <div id="loading-image" style="display:none;">
  <img src="<?php echo SITE_URL; ?>/images/tenor.gif" class="loaderimg img-responsive" />
</div>

   <table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width: 10% !important;"></th>
        <th>Job Title</th>
        <th>Last Date of Application</th>
        <th>Talent</th>
        <th>Location</th>
        <th>Job Status</th>
        <th>Action</th>
      </tr>

    </thead>

    <tbody id="example2">
              <?php 
              $counter = 1;
              if(isset($Job) && !empty($Job)){ 
		              foreach($Job as $admin){  //pr($admin); 
                    $featstart=date('Y-m-d H:m:s',strtotime($admin['feature_job_date']));
                    $last_date_app=date('Y-m-d H:m:s',strtotime($admin['last_date_app']));
                    $expiredate=date('Y-m-d H:m:s',strtotime($admin['expiredate']));
                    $currntdate=date('Y-m-d H:m:s');
                   // echo $admin['feature_job_date'];
                    ?>
                    <tr>
                      <td><?php //echo $counter; 
                      if ($admin['image']) {
                      ?>
                        <img src="<?php echo SITE_URL; ?>/job/<?php echo $admin['image']; ?>">
                        <?php }else{ ?>
                        <img src="<?php echo SITE_URL; ?>/images/job.jpg"/>
                        <?php } ?>
                      </td>
                      <td>
                       <a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $admin['id']; ?>" target="_blank"><?php echo $admin['title']; ?></a>
                       </td>
                 
                      <td><?php if($admin['last_date_app']){ echo date('M d,Y',strtotime($last_date_app)); }else{ echo "N/A"; } ?></td>                      
                      <td>
                      <?php 
                        if(isset($admin['requirment_vacancy'])){
                          foreach($admin['requirment_vacancy'] as $skills){
                            //pr($skills); 
                            echo $skills['skill']['name'].'</br>'; 
                          }
                        }
                      ?>
                      </td>
                      <td>
                        <?php 
                          echo $admin['location'];
                          
                        ?> 
                      </td>
                      <td>
                        <span class="label label-success">
                          <?php if($admin['status']=='Y'){ echo "Active"; }else{ echo "Inactive"; } ?>
                        </span>
                      </td>
                      
                      <td>
                        <?php if($expiredate<$currntdate){ 
                          echo $this->Html->link('Make It Featured', [
                            'action' => 'suggestedprofile',
                            $admin->id,
                            ],['class'=>'label label-warning']);

                        }else{ ?>
                        
                        <span class="label label-primary"><?php  echo "Featured"; ?></span>

                        <?php } ?>

                      </td>
                    </tr>
                    <?php $counter++;} }

                    else{ ?>
                    <tr>
                      <td colspan="11" align="center">You do not have any active jobs. Please 
                     Post a Requirment to Feature it
                      </td>
                    </tr>
                    <?php } ?>
                    <tr>
                      <td colspan="11" align="center"> <a href="<?php echo SITE_URL; ?>/jobpost">
                        <button class="btn btn-success">Post A Requirement </button>
                        </a>
                      <a href="<?php echo SITE_URL; ?>/requirement/featured-requirment" data-toggle="modal" class="serviceview">
                        <button class=" btn btn-success">View Featured Requirement</button>
                        </a> 
                      </td>
                    </tr>
                  </tbody>

                </table>
  </div>
              </div>
            </div>


          </div>
        </div>
      </div>
    </section>

<div class="modal fade" id="servicedetail">
<div class="modal-dialog" style="width: 88% !important; max-width: 1200px;">
  <div class="modal-content">

    <!-- Modal Header -->
    <div class="modal-header">
      
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>

    <!-- Modal body -->
    <div class="modal-body">


    </div>


  </div>
</div>
</div>

<script type="text/javascript">
   $('.serviceview').click(function(e){ 
  e.preventDefault();
  $('#servicedetail').modal('show').find('.modal-body').load($(this).attr('href'));
});
</script>



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

   <style>
     .table-div{
      position: relative;
     }

     #loading-image{
      position: absolute;
    left: 0px;
    right: 0px;
    top: 0px;
    bottom: 0px;
    text-align: center;
    z-index: 99;
    background-color: rgba(256,256,256,.8);
     }

     .loaderimg{
      display: inline-block;
      width: 117px;
    margin-top: 46px;
     }
     
     </style>


