<?php 
$counter=1;
if(isset($alladvtpro) && !empty($alladvtpro)){ 
  foreach($alladvtpro as $pack){
    $mytransactions=$this->Comman->myjobadtransactions($pack['id']);
              	//pr($mytransactions); die;
              	$crdate=date("M d, Y",strtotime($mytransactions['created']));
              	$invoicenum="INV-".$mytransactions['description']."-".$crdate."-".$mytransactions['id'];

                $currentdate=date('M d, Y H:m:s');
                $todates= date('M d, Y H:m:s',strtotime($pack['ad_date_to'])); 

                $fromdate= date('M d, Y',strtotime($pack['ad_date_from'])); 
                $todate= date('M d, Y',strtotime($pack['ad_date_to'])); 
                $date1 = date_create($fromdate);
                $date2 = date_create($todate);
                $diff = date_diff($date1,$date2);
                $bannerdays=$diff->days;
                ?>
                <tr>
                  <td>
                      <?php if(!empty($pack['job_image_change'])){ ?>
                      <img src="<?php echo SITE_URL; ?>/job/<?php echo $pack['job_image_change']; ?>" alt="" width="150" hight="150"> </td>
                      <?php }else{ ?>
                        <img src="<?php echo SITE_URL; ?>/images/job.jpg">
                      <?php } ?>
                  <td><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $pack['user_id']; ?>" target="_blank">
                  <?php echo $pack['user']['user_name']; ?></a>
                      </td>
                  <td><?php echo $pack['user']['email']; ?></td>
                  <td>
                  <a target="_blank" href="<?php echo ADMIN_URL; ?>transcation/billpdf/<?php echo $mytransactions['id']; ?>/1">
                  <?php if($mytransactions['id']){ echo $invoicenum; }else{ echo "N/A"; } ?>
                    </a>
                  </td>
                  <td><a href="<?php echo SITE_URL; ?>/applyjob/<?php echo $pack['requirement']['id']; ?>" target="_blank">
                  <?php echo $pack['requirement']['title']; ?></a></td>
                  <td><?php echo date('M d, Y',strtotime($pack['created'])); ?></td>
                  <td><?php echo $fromdate; ?></td>
                  <td><?php echo $todate; ?></td>
                  <td><?php echo $bannerdays."days"; ?></td>                  
                  <td><?php if($mytransactions['before_tax_amt']){ echo "$".$mytransactions['before_tax_amt']." USD"; }else{ echo "$0 USD";} ?></td>               
                  <td><?php echo "$".$mytransactions['amount']." USD"; ?></td>                  
                 
                    <td><?php if($pack['status']=='Y'){ ?>
                    <span class="label label-info"> Ad Active</span>
                    
                    <?php
                      echo $this->Html->link('Deactivate Ad', [
                          'action' => 'status',
                            $pack['id'],
                           $pack['status']  
                      ],['class'=>'label label-success']); ?>
                    
                    <?php }else{ ?>
                      <span class="label label-success">Ad Inactive</span>
                    <?php } ?>
                    </td>
                   
                    </tr>
      <?php $counter++; } } else{ ?>
      <tr>
        <td>NO Data Available</td>
      </tr>
<?php } ?>