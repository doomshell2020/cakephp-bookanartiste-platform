  
<div class="container">
  <?php  if($requirement_data){ 

    ?>
    <p align="center"><img src="<?php echo SITE_URL ?>/job/<?php  echo $requirement_data['image'] ?>"/ height="200"></p>   

    <table class="table table-hover">

      <tbody>
        <tr>
          <td>Title of Job/Event:</td>
          <td><?php echo $requirement_data['title'] ?></td>

        </tr>
        <tr>
          <td colspan="2">Talent Requirement <br>
            <table width="100%">
              <?php foreach ($requirement_data['requirment_vacancy'] as $key => $value) {   ?>


              <tr>
                <td><?php echo $value['skill']['name'] ?>

                  <table border="1" width="100%" class="viewTable">

                    <tr>
                      <th>Vacancy</th>
                      <th>Gender</th>
                      <th>Payment Frequency</th>
                      <th>Payment Currency</th>
                      <th>Payment Amount</th>
                    </tr>

                    <tr>
                      <td><?php echo $value['number_of_vacancy'] ?></td>

                      <td><?php if($value['sex']=="m"){ echo "Male"; }elseif($value['sex']=="f"){ echo "Female"; }else if($value['sex']=="bmf"){ echo "Both Male and Female"; }else if($value['sex']=="a"){ echo "All"; }else { echo "Other";} ?></td>
                      <td><?php echo $value['payment_freq'] ?></td>
                      <td><?php echo $value['currency']['name'] ?></td>
                      <td><?php echo $value['payment_amount'] ?></td>
                    </tr>
                  </table>

                </td>
              </tr>
              <?php   } ?>
            </table>
          </td>


        </tr>


        <tr>
          <td>Venu  Description </td>
          <td><?php echo $requirement_data['venue_description'] ?></td>

        </tr>
        <tr>
          <td>Payment Description </td>
          <td><?php echo $requirement_data['payment_description'] ?></td>

        </tr>
        <tr>
          <td>Time </td>
          <td><?php echo $requirement_data['time'] ?></td>

        </tr>
        <tr>
          <td>Job / Event Type : </td>
          <td><?php echo $requirement_data['event_type']; ?></td>

        </tr>
        <tr>
          <td> Number of Attendees : </td>
          <td><?php echo $requirement_data['number_attendees']; ?></td>

        </tr>

         <tr>
          <td>Last Date of Application Date/Time: </td>
          <td><?php echo date('m/d/Y h:i:s',strtotime($requirement_data['last_date_app'])); ?></td>

        </tr>
        <?php if ($requirement_data['continuejob']=='N') { ?>
        <tr>
          <td>Event Start Date/Time: </td>
          <td><?php echo date('m/d/Y h:i:s',strtotime($requirement_data['event_from_date'])); ?></td>

        </tr>
        <tr>
          <td>Event End Date/Time:</td>
          <td><?php echo date('m/d/Y h:i:s',strtotime($requirement_data['event_to_date'])); ?></td>

        </tr>
       
        <tr>
          <td>Talent Required Date/Time To: </td>
          <td><?php echo date('m/d/Y h:i:s',strtotime($requirement_data['talent_required_fromdate'])); ?></td>

        </tr>
        <tr>
          <td>Talent Required Date/Time From:</td>
          <td><?php echo date('m/d/Y h:i:s',strtotime($requirement_data['talent_required_todate'])); ?></td>

        </tr>
        <?php } ?>
        <tr>
          <td> Vanue Type </td>
          <td><?php echo $requirement_data['venue_type']; ?></td>

        </tr>


        <tr>
          <td> Vanue Address </td>
          <td><?php echo $requirement_data['venue_address']; ?></td>

        </tr>

        <tr>
          <td> Country  </td>
          <td><?php echo $requirement_data['country']['name']; ?></td>

        </tr>


        <tr>
          <td> State</td>
          <td><?php echo $requirement_data['state']['name']; ?></td>

        </tr>

        <tr>
          <td> City</td>
          <td><?php echo $requirement_data['city']['name']; ?></td>

        </tr>

        <tr>
          <td> Requirement Description:</td>
          <td><?php echo $requirement_data['talent_requirement_description']; ?></td>

        </tr>
        <tr>
          <td> Landmark:</td>
          <td><?php echo $requirement_data['landmark']; ?></td>

        </tr>
        <tr>
          <td> Location:</td>
          <td><?php echo $requirement_data['location']; ?></td>

        </tr>

      </tbody>
    </table>
    <?php } else{

      echo "No data Available";
    } ?>
  </div>

