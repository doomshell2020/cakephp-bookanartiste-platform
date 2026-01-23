<?php

use Cake\Datasource\ConnectionManager; ?>
<?php echo $this->element('viewprofile') ?>
<link type="text/css" rel="stylesheet" href="<?php echo SITE_URL; ?>/css/calendar.css" />




<div class="col-sm-9 my-info">
  <div class="col-sm-12 prsnl-det">
    <div class="clearfix">
      <h4 class="pull-left">Event<span> Calendar</span></h4>

      <table class="table table-hover">
        <tr>
          <th><strong>S.NO</strong></th>
          <th><strong>From Date</th>
          <th><strong>To Date</strong></th>
          <th><strong>Event Type</strong></th>
          <th><strong>Location</strong></th>
          <?php /* ?>  <th><strong>Title</strong></th>
    <th><strong>Descripation</strong></th>
    
    <th><strong>Remark</strong></th>
 <th><strong>Action</strong></th> <?php */ ?>
        </tr>

        <?php if ($event) { ?>
          <?php $i = 1;
          foreach ($event as $key => $value) { ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo date("M d,Y", strtotime($value['from_date'])); ?></td>
              <td><?php echo date("M d,Y", strtotime($value['to_date'])); ?></td>
              <td><?php echo $value['eventtype']; ?></td>
              <td><?php echo $value['location']; ?></td>
              <?php /* ?> <td><?php echo $value['title']; ?></td>
    <td><?php echo $value['description']; ?></td>
    
    <td><?php echo $value['remark']; ?></td>
    
    <td>
    <a href="<?php echo SITE_URL; ?>calendar/delete/<?php echo $value['id']; ?>"onClick="javascript:return confirm('Are you sure do you want to delete this')"><i class="fa fa-trash" ></i></a>
  <a  data-toggle="modal" class='btn schedule-default skill' href="<?php echo SITE_URL; ?>calendar/edit/<?php echo $value['id']; ?>/<?php echo $typeevent ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
    </td>
<?php */ ?>
            </tr>
          <?php $i++;
          } ?>
        <?php } else {  ?>
          <td colspan="8" style="text-align:center;"><strong><?php echo "No Event";
                                                            }
                                                              ?></strong></td>
      </table>



      <?php /////////////////////////////job alerts//////////////////////////
      ?>




      <script>
        $(document).ready(function() {
          $(".allevents").click(function() {
            var val = $(this).data('action');
            $(".allevent").hide();
            $("." + val).show();
          });



        });
      </script>

    </div>

  </div>
</div>
</div>
</div>
</div>



</div>
</div>
</div>
</section>

<!-------------------------------------------------->

<style>
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  td,
  th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }
</style>