<?php 
            $counter=1;
            if(isset($alladvtpro) && !empty($alladvtpro)){ 
              foreach($alladvtpro as $pack){
                $mytransactions=$this->Comman->mytransactions($pack['id']);
                //pr($mytransactions); die;
                $crdate=date("d-M-Y",strtotime($mytransactions['created']));
                $invoicenum="INV-".$mytransactions['description']."-".$crdate."-".$mytransactions['id'];
                $fromdate= date('Y-m-d',strtotime($pack['ad_date_from'])); 
                $todate= date('Y-m-d',strtotime($pack['ad_date_to'])); 
                $date1 = date_create($fromdate);
                $date2 = date_create($todate);
                $diff = date_diff($date1,$date2);
                $bannerdays=$diff->days;
                ?>
                <tr>
                  <td><?php echo $counter; ?></td>
                  <td><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $pack['user']['id']; ?>" target="_blank">
                  <?php echo $pack['user']['user_name']; ?>
                  </a></td>
                  <td><?php echo $pack['user']['email']; ?></td>
                  <td>
                  <a target="_blank" href="<?php echo ADMIN_URL; ?>transcation/billpdf/<?php echo $mytransactions['id']; ?>/1">
                  <?php if($mytransactions['id']){ echo $invoicenum; }else{ echo "N/A"; } ?>
                    </a>
                  </td>
                  <td><?php echo date('d-M-Y',strtotime($pack['created'])); ?></td>
                  <td><?php echo $fromdate; ?></td>
                  <td><?php echo $todate; ?></td>
                  <td><?php echo $bannerdays."days"; ?></td>                  
                  <td><?php if($mytransactions['amount']){ echo "$".$mytransactions['amount']." USD"; }else{ echo "$0 USD";} ?></td>                  
                 
                    <td><?php if($pack['status']=='Y'){ ?>
                    <span class="label label-info">Deactivate</span>
                    <?php }else{ ?>
                      <span class="label label-success">Activate</span>
                      <?php } ?>
                    </td>

                   
                    </tr>
                    <?php $counter++; } } else{ ?>
                    <tr>
                      <td>NO Data Available</td>
                    </tr>
                    <?php } ?>