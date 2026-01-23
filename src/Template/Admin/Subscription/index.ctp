 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
   <section class="content-header">
     <h1>
       Subscription Manager
     </h1>
     <ol class="breadcrumb">
       <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
       <li><a href="#"> Subscription Manager</a></li>
     </ol>
   </section>

   <!-- Main content -->
   <section class="content">
     <div class="row">
       <div class="col-xs-12">

         <div class="box">
           <div class="box-header">
             <?php echo $this->Flash->render(); ?>


             <h3 class="box-title"> Advance Search </h3>
           </div>
           <!-- /.box-header -->
           <div class="box-body">

             <div class="manag-stu">

               <script inline="1">
                 //<![CDATA[
                 $(document).ready(function() {
                   $("#loading").hide();
                   $("#TaskAdminCustomerForm").bind("submit", function(event) {
                     $.ajax({
                       async: true,
                       data: $("#TaskAdminCustomerForm").serialize(),
                       dataType: "html",
                       beforeSend: function() {
                         $("#loading").show();
                       },
                       success: function(data, textStatus) {
                         $("#loading").hide();
                         $("#example2").html(data);
                       },
                       type: "POST",
                       url: "<?php echo ADMIN_URL; ?>subscription/search"
                     });
                     return false;
                   });
                 });
                 //]]>
               </script>
               <?php echo $this->Form->create('Task', array('url' => array('controller' => 'subscription', 'action' => 'search'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm', 'class' => 'form-horizontal')); ?>


               <div class="form-group">
                 <div class="col-sm-3">
                   <label>From</label>
                   <input type="text" class="form-control" id="datepicker1" name="from_date" placeholder="Date From" autocomplete="off" readonly="readonly">
                 </div>

                 <div class="col-sm-3">
                   <label>To</label>
                   <input type="text" class="form-control" id="datepicker2" name="to_date" placeholder="To Date" autocomplete="off" readonly="readonly">
                 </div>
                 <div class="col-sm-3">
                   <label>Name</label>
                   <input type="text" class="form-control" name="name" placeholder="Enter Name">
                 </div>

                 <div class="col-sm-3">
                   <label>Email</label>
                   <input type="text" class="form-control" name="email" placeholder="Enter Email">
                 </div>
               </div>
               <div class="form-group">
                 <div class="col-sm-3">
                   <label>Package type</label>

                   <select class="form-control" name="packtype">
                     <option value="" selected="selected">-Select-</option>
                     <option value="PR">Profile</option>
                     <option value="RC">Recruiter</option>
                     <option value="RE">Requirement</option>
                   </select>
                 </div>

                 <div class="col-sm-3">
                   <label>Status</label>

                   <select class="form-control" name="status">
                     <option value="" selected="selected">-Select-</option>
                     <option value="Y">Active</option>
                     <option value="N">Expired</option>
                   </select>
                 </div>
                 <div class="col-sm-6">

                   </br>
                   <button type="submit" class="btn btn-success">Search</button>
                   <button type="reset" class="btn btn-primary">Reset</button>
                   <button id="loading" class="btn btn-warning">loading...</button>
                   <a href="<?php echo ADMIN_URL; ?>subscription/exportSubscription" class="btn btn-success">Export Excel</a>

                 </div>
               </div>
               <?php
                echo $this->Form->end();
                ?>
             </div>
           </div>
         </div>
       </div>
     </div>
     <div class="row">
       <div class="col-xs-12">
         <div class="box">
           <!-- /.box-header -->
           <div class="box-body  table-responsive">
             <table id="" class="table table-bordered table-striped">
               <thead>
                 <tr>
                   <th>S.no</th>
                   <th>Name</th>
                   <th>Package Type</th>
                   <th>Package Name</th>
                   <th>Subscription Date</th>
                   <th>Subscription Expiry</th>
                   <th>Status</th>
                 </tr>
               </thead>

               <style>
                 #example2 .pne {
                   position: relative;
                   overflow: hidden;
                 }

                 #example2 .pne .p_new {
                   width: 87px;
                   height: 71px;
                   position: absolute;
                   background: url(../images/newarrival-icon.PNG) no-repeat;
                   z-index: 9999;
                   left: -5px;
                   top: -3px;
                 }
               </style>
               <tbody id="example2">
                 <?php
                  $counter = 1;
                  if (isset($subscription) && !empty($subscription)) {
                    foreach ($subscription as $subscriptiondata) {

                      $packagedetails = $this->Comman->packagedetails($subscriptiondata['package_type'], $subscriptiondata['package_id']);
                      // pr($packagedetails);
                  ?>
                     <tr>
                       <td><?php echo $counter; ?></td>
                       <td>

                         <!-- <a data-toggle="modal" class='data' href="<?php //echo ADMIN_URL 
                                                                        ?>profile/details/<?php //echo $subscriptiondata['user_id']; 
                                                                                                                  ?>" style="color:blue;"> -->
                         <a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $subscriptiondata['user_id']; ?>" target="_blank" style="color:#278eda;">
                           <?php echo ($subscriptiondata['user']['user_name']) ? $subscriptiondata['user']['user_name'] : "N/A"; ?></a>
                       </td>
                       <td>
                         <?php if ($subscriptiondata['package_type'] == 'PR') {
                            echo "Profile";
                          } elseif ($subscriptiondata['package_type'] == 'RC') {
                            echo "Recruiter";
                          } elseif ($subscriptiondata['package_type'] == 'RE') {
                            echo "Requirement";
                          } else {
                          } ?>
                       </td>
                       <td>
                         <?php
                          if ($packagedetails['title']) {
                            echo $packagedetails['title'];
                          } else {
                            echo $packagedetails['name'];
                          }
                          ?></td>
                       <td>
                         <?php echo date("d M Y h:i a", strtotime($subscriptiondata['subscription_date']));  ?>
                       </td>
                       <td>
                         <?php echo date("d M Y h:i a", strtotime($subscriptiondata['expiry_date']));  ?>
                       </td>
                       <td>
                         <?php
                          $expriydate = date("Y-m-d", strtotime($subscriptiondata['expiry_date']));
                          $curdate = date("Y-m-d");
                          if ($expriydate >= $curdate) { ?>
                           <a data-toggle="modal" class='label label-success' href="Javascript:void(0)" style="color:blue;">
                             Active</a>
                         <?php
                          } else { ?>
                           <a data-toggle="modal" class='label label-danger' href="Javascript:void(0)" style="color:red;">
                             Expired</a>
                         <?php
                          }
                          ?>
                       </td>
                     </tr>
                   <?php $counter++;
                    }
                  } else { ?>
                   <tr>
                     <td colspan="11" align="center">No Data Available</td>
                   </tr>
                 <?php } ?>
               </tbody>

             </table>
           </div>
           <!-- /.box-body -->
           <script>
             $(document).ready(function() {
               //prepare the dialog

               //respond to click event on anything with 'overlay' class
               $(".globalModals").click(function(event) {



                 $('.modal-content').load($(this).attr("href")); //load content from href of link

               });
             });
           </script>
           <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-body">
                   <div class="loader">
                     <div class="es-spinner">
                       <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>

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




 <!-- Daynamic modal -->
 <div id="myModal" class="modal fade">
   <div class="modal-dialog">

     <div class="modal-content">
       <div class="modal-body"></div>
     </div>
     <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->

 </div>
 <!-- /.modal -->



 <script>
   $('.data').click(function(e) {
     e.preventDefault();
     $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
   });
 </script>


 <script src="https://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
 <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
 <script>
   $(function() {

     var dateFormat = 'dd-mm-yy',
       from = $("#datepicker1")
       .datepicker({
         dateFormat: 'dd-mm-yy',

         changeMonth: true,
         numberOfMonths: 1
       })
       .on("change", function() {
         to.datepicker("option", "minDate", getDate(this));
       }),
       to = $("#datepicker2").datepicker({
         dateFormat: 'dd-mm-yy',

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