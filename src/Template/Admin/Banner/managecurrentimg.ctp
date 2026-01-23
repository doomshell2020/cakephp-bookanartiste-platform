
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content-header">
    <h1>
   Manage Current Images
   </h1>
   <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
    <li><a href="#"> Manage Current Images</a></li>
  </ol> 
</section>

<!-- Main content -->
<section class="content">



  <div class="row">
    <div class="col-xs-12">

     <div class="box">
      <div class="box-header">
        <h3 class="box-title">List</h3>
       <a href="<?php echo ADMIN_URL; ?>banner/createbanner" type="reset" class="btn btn-success pull-right">Create A Banner</a>
       <a href="<?php echo ADMIN_URL; ?>banner/index" type="reset" class="btn btn-success pull-right">Got To Banner Manger</a>
      </div>
      <!-- /.box-header -->
      <?php echo $this->Flash->render(); ?>


      <div class="box-body  table-responsive" >
       <table id="example" class="table table-bordered table-striped">
        <thead>
         <tr>
          <th>S.no</th>
          <th>Image</th>
          <th>Banner Title</th>
          <th>Banner URL</th>
          <th>From Date</th>
          <th>End Date</th>
          <th>Total Price</th>
          <th>Requested By</th>
          <th>Requested By EMail id</th>
          <th width="103px;">Action</th>
        </tr>
      </thead>

      <style>
        #example2 .pne{ position:relative; overflow:hidden;}
        #example2 .pne .p_new{    
          width: 87px;
          height: 71px;
          position: absolute;
          background: url(../images/newarrival-icon.PNG) no-repeat;
          z-index: 9999; left:-5px; top:-3px; 
        } 
      </style>        
      <tbody id="example2">
        <?php 
        $counter=1;
        if(isset($banner) && !empty($banner)){ 
         foreach($banner as $bannerdata){    //pr($bannerdata);
          $fromdate=date('Y-m-d H:m:s',strtotime($bannerdata['banner_date_from']));
          $todate=date('Y-m-d H:m:s',strtotime($bannerdata['banner_date_to']));
          
          $date1 = date_create($fromdate);
          $date2 = date_create($todate);
          $diff = date_diff($date1,$date2);

          ?>
         <tr>
           <td><?php echo $counter;?></td>
           <td>
           <a target="_blank" href="<?php echo SITE_URL; ?>/bannerimages/<?php echo $bannerdata['banner_image']; ?>" style="color:blue;">
            <img class="" id="profile_picture" data-src="default.jpg" data-holder-rendered="true" style="width: 140px; height: auto;" src="<?php echo SITE_URL; ?>/bannerimages/<?php echo $bannerdata['banner_image']; ?>"/>
            </a>
          </td>
          <td> <?php echo $bannerdata['title']; ?></td>
          <td> <?php echo $bannerdata['bannerurl']; ?></td>

          <td><?php echo $fromdate; ?></td>
          <td><?php echo $todate; ?></td>
          <td><?php echo "$".$bannerdata['bannerpack']['cost_per_day']*$diff->days; ?></td>
          <td><a target="_blank" href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $bannerdata['user_id']; ?>">
            <?php if($bannerdata['user_id']!=1){ echo $bannerdata['user']['user_name']; }else{ echo "Admin"; }?>
          </a></td>

          <td><?php echo $bannerdata['user']['email']; ?></td>

          <td>
            <?php if($bannerdata['status']=='R' || $bannerdata['status']=='Y'){ ?>
            <a onClick="javascript: return confirm('Are you sure do you want to delete this banner')" class='label label-warning' href="<?php echo ADMIN_URL ?>banner/parmanentdelete/<?php echo $bannerdata['id']; ?>" >Delete</a>
            <?php } ?>

            <a class='label label-danger' href="<?php echo ADMIN_URL ?>banner/editbanner/<?php echo $bannerdata['id']; ?>" >Edit</a>
          </td>

        </tr>

        <?php $counter++;} }else{ ?>
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
    $(".globalModals").click(function(event){
      $('.modal-content').load($(this).attr("href"));
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
 $('.order_details').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>

<script>
 $('.performance').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>

<script>
 $('.skill').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>

<script>
 $('.data').click(function(e){
  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
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