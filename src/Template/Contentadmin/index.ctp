<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>

<?php foreach ($talent as $key=> $value){  
echo $value['user_name'];
?>

 <a data-toggle="modal" class='report_details' href="<?php echo SITE_URL?>/Contentadmin/reportspamdata/<?php echo $value['id']; ?>" style="color:blue;">Report Spam Details</a>
                        

<?php } ?>



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
 $('.report_details').click(function(e){

  e.preventDefault();
  $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
});

</script>
