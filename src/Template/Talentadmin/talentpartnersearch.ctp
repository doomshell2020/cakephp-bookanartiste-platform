                <?php if ($status == 1) {
                  //echo "hello"; die;
                  $counter = 1;
                  if (isset($contentadmin) && !empty($contentadmin)) {
                    $checkdata = 0;
                    foreach ($contentadmin as $admin) { //pr($admin); 
                      $rcount = $this->Comman->managetalentpartner($admin['user_id']);
                      if (!empty($admin['user_id'])) {  ?>
                        <tr>
                          <td><?php echo $counter; ?></td>
                          <td><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $admin['user_id']; ?>" target="_blank">
                              <?php if (isset($admin->user_name)) {
                                echo ucfirst($admin->user_name);
                                if ($admin['user_id'] == "") {
                                  echo "<br>(Not Registered)";
                                }
                              } else {
                                echo 'N/A';
                              } ?></a>
                          </td>
                          <td><?php if (isset($admin->email)) {
                                echo $admin->email;
                                if (!empty($admin['user_id'])) {
                                  $mails = $this->Comman->profilemails($admin['user_id']);

                                  if (!empty($mails['altemail'])) {
                                    echo '</br>' . str_replace(",", "</br>", $mails['altemail']);
                                  }
                                }
                              } else {
                                echo 'N/A';
                              } ?></td>
                          <td><?php if (!empty($admin['user_id'])) {
                                $data = $this->Comman->managetalentpartner($admin['user_id']);
                                //pr($data); 
                                if ($data['profile']['phone']) {
                                  echo "+" . $data['profile']['phonecode'] . "-" . $data['profile']['phone'];
                                  if (!empty($data['profile']['altnumber'])) {
                                    $removespace = str_replace(' ', '', $data['profile']['altnumber']);
                                    $altphone = explode(",", $removespace);
                                    foreach ($altphone as $altphonevalue) {
                                      $altp[] = $altphonevalue;
                                    }
                                    echo implode(", ", $altp);
                                  }
                                } else {
                                  echo 'N/A';
                                }
                              } else {
                                echo 'N/A';
                              }
                              ?></td>
                          <td><?php
                              if (!empty($admin['user_id'])) {
                                $refercount = $this->Comman->managetalentpartner($admin['user_id']);
                                //pr($refercount); die;
                                echo count($refercount['refers']);
                              } else {
                                echo 'N/A';
                              }
                              ?>

                          </td>
                          <td><?php
                              if (!empty($admin['user_id'])) {
                                $i = 0;
                                $v = 0;


                                $refers = $this->Comman->managetalentpartner($admin['user_id']);

                                foreach ($refers['refers'] as $key => $referValue) {
                                  if ($referValue['status'] == 'Y') {
                                    $i++;
                                  } else {
                                    $v++;
                                  }
                                }

                                echo $i;
                              } else {
                                echo 'N/A';
                              }
                              ?>

                          </td>

                          <td>
                            <?php if (!empty($admin['user_id'])) {
                              $v = 0;

                              $referss = $this->Comman->managetalentpartner($admin['user_id']);
                              foreach ($referss['refers'] as $key => $referValues) {
                                if ($referValues['status'] == 'N') {
                                  $v++;
                                }
                              }


                              echo $v;
                            } else {
                              echo 'N/A';
                            }
                            ?>
                          </td>
                          <?php if ($this->request->session()->read('talentadmin.enable_delete_subadmin') == 'Y') { ?>
                            <td>
                              <?php /* if($admin->user->status=='Y'){ 
                    echo $this->Html->link('Active', [
                      'action' => 'status',
                      $admin->user->id,
                      $admin->user->status  
                      ],['class'=>'label label-success']);
  
                  }else{ 
                   echo $this->Html->link('Inactive', [
                    'action' => 'status',
                    $admin->user->id,
                    $admin->user->status
                    ],['class'=>'label label-primary']);
  
                  } */ ?>

                              <?php
                              echo $this->Html->link('Edit', [
                                'action' => 'addsubadmin',
                                $admin->id
                              ], ['class' => 'label label-primary']); ?>


                              <?php
                              echo $this->Html->link('Delete', [
                                'action' => 'delete',
                                $admin->id,
                                $i
                              ], ['class' => 'label label-danger', "onClick" => "javascript: return confirm('Are you sure do you want to delete this')"]); ?>
                              <br>

                            </td>
                          <?php } ?>
                          <script>
                            // function confirmFunction(){
                            //   var name = '<?php echo $admin['user_name']; ?>';
                            //   return confirm("Are you sure you want to delete "+name);
                            // }
                          </script>
                        </tr>
                      <?php
                        $checkdata++;
                      }

                      $counter++;
                    }
                    if ($checkdata == 0) { ?>
                      <tr>
                        <td colspan="11" align="center">No Registered Talent Partner</td>
                      </tr>
                    <?php }
                  } else { ?>
                    <tr>
                      <td colspan="11" align="center">You have not created any Talent Partner yet</td>
                    </tr>
                    <?php }
                } elseif ($status == 2) {
                  //echo "hello"; die;
                  $counter = 1;
                  if (isset($contentadmin) && !empty($contentadmin)) {
                    $checkdata = 0;
                    foreach ($contentadmin as $admin) { //pr($admin); 
                      $rcount = $this->Comman->managetalentpartner($admin['user_id']);
                      if (empty($admin['user_id'])) {  ?>
                        <tr>
                          <td><?php echo $counter; ?></td>
                          <td><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $admin['user_id']; ?>" target="_blank">
                              <?php if (isset($admin->user_name)) {
                                echo ucfirst($admin->user_name);
                                if ($admin['user_id'] == "") {
                                  echo "<br>(Not Registered)";
                                }
                              } else {
                                echo 'N/A';
                              } ?></a>
                          </td>

                          <td><?php if (isset($admin->email)) {
                                echo $admin->email;
                                if (!empty($admin['user_id'])) {
                                  $mails = $this->Comman->profilemails($admin['user_id']);

                                  if (!empty($mails['altemail'])) {
                                    echo '</br>' . str_replace(",", "</br>", $mails['altemail']);
                                  }
                                }
                              } else {
                                echo 'N/A';
                              } ?></td>
                          <td><?php if (!empty($admin['user_id'])) {
                                $data = $this->Comman->managetalentpartner($admin['user_id']);
                                //pr($data); 
                                if ($data['profile']['phone']) {
                                  echo "+" . $data['profile']['phonecode'] . "-" . $data['profile']['phone'];
                                  if (!empty($data['profile']['altnumber'])) {
                                    $removespace = str_replace(' ', '', $data['profile']['altnumber']);
                                    $altphone = explode(",", $removespace);
                                    foreach ($altphone as $altphonevalue) {
                                      echo ", +" . $data['profile']['phonecode'] . "-" . $altphonevalue;
                                    }
                                  }
                                } else {
                                  echo 'N/A';
                                }
                              } else {
                                echo 'N/A';
                              }
                              ?></td>
                          <td><?php
                              if (!empty($admin['user_id'])) {
                                $refercount = $this->Comman->managetalentpartner($admin['user_id']);
                                //pr($refercount); die;
                                echo count($refercount['refers']);
                              } else {
                                echo 'N/A';
                              }
                              ?>

                          </td>
                          <td><?php
                              if (!empty($admin['user_id'])) {
                                $i = 0;
                                $v = 0;


                                $refers = $this->Comman->managetalentpartner($admin['user_id']);

                                foreach ($refers['refers'] as $key => $referValue) {
                                  if ($referValue['status'] == 'Y') {
                                    $i++;
                                  } else {
                                    $v++;
                                  }
                                }

                                echo $i;
                              } else {
                                echo 'N/A';
                              }
                              ?>

                          </td>

                          <td>
                            <?php if (!empty($admin['user_id'])) {
                              $v = 0;

                              $referss = $this->Comman->managetalentpartner($admin['user_id']);
                              foreach ($referss['refers'] as $key => $referValues) {
                                if ($referValues['status'] == 'N') {
                                  $v++;
                                }
                              }


                              echo $v;
                            } else {
                              echo 'N/A';
                            }
                            ?>
                          </td>
                          <?php if ($this->request->session()->read('talentadmin.enable_delete_subadmin') == 'Y') { ?>
                            <td>
                              <?php /* if($admin->user->status=='Y'){ 
                    echo $this->Html->link('Active', [
                      'action' => 'status',
                      $admin->user->id,
                      $admin->user->status  
                      ],['class'=>'label label-success']);
  
                  }else{ 
                   echo $this->Html->link('Inactive', [
                    'action' => 'status',
                    $admin->user->id,
                    $admin->user->status
                    ],['class'=>'label label-primary']);
  
                  } */ ?>

                              <?php
                              echo $this->Html->link('Edit', [
                                'action' => 'addsubadmin',
                                $admin->id
                              ], ['class' => 'label label-primary']); ?>


                              <?php
                              echo $this->Html->link('Delete', [
                                'action' => 'delete',
                                $admin->id,
                                $i
                              ], ['class' => 'label label-danger', "onClick" => "javascript: return confirm('Are you sure do you want to delete this')"]); ?>
                              <br>


                            </td>
                          <?php } ?>
                        </tr>
                      <?php
                        $checkdata++;
                      }

                      $counter++;
                    }
                    if ($checkdata == 0) { ?>
                      <tr>
                        <td colspan="11" align="center">No Not Register Talent Partner</td>
                      </tr>
                    <?php }
                  } else { ?>
                    <tr>
                      <td colspan="11" align="center">You have not created any Talent Partner yet</td>
                    </tr>
                    <?php }
                } elseif ($status == 3) {
                  $counter = 1;
                  if (isset($contentadmin) && !empty($contentadmin)) {
                    $checkdata = 0;
                    foreach ($contentadmin as $admin) { //pr($admin); 
                      $rcount = $this->Comman->managetalentpartner($admin['user_id']);
                      if (count($rcount['refers']) > 0) {  ?>
                        <tr>
                          <td><?php echo $counter; ?></td>
                          <td><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $admin['user_id']; ?>" target="_blank">
                              <?php if (isset($admin->user_name)) {
                                echo ucfirst($admin->user_name);
                                if ($admin['user_id'] == "") {
                                  echo "<br>(Not Registered)";
                                }
                              } else {
                                echo 'N/A';
                              } ?></a>
                          </td>
                          <td><?php if (isset($admin->email)) {
                                echo $admin->email;
                                if (!empty($admin['user_id'])) {
                                  $mails = $this->Comman->profilemails($admin['user_id']);

                                  if (!empty($mails['altemail'])) {
                                    echo '</br>' . str_replace(",", "</br>", $mails['altemail']);
                                  }
                                }
                              } else {
                                echo 'N/A';
                              } ?></td>
                          <td><?php if (!empty($admin['user_id'])) {
                                $data = $this->Comman->managetalentpartner($admin['user_id']);
                                //pr($data); 
                                if ($data['profile']['phone']) {
                                  echo "+" . $data['profile']['phonecode'] . "-" . $data['profile']['phone'];
                                  if (!empty($data['profile']['altnumber'])) {
                                    $removespace = str_replace(' ', '', $data['profile']['altnumber']);
                                    $altphone = explode(",", $removespace);
                                    foreach ($altphone as $altphonevalue) {
                                      echo ", +" . $data['profile']['phonecode'] . "-" . $altphonevalue;
                                    }
                                  }
                                } else {
                                  echo 'N/A';
                                }
                              } else {
                                echo 'N/A';
                              }
                              ?></td>
                          <td><?php
                              if (!empty($admin['user_id'])) {
                                $refercount = $this->Comman->managetalentpartner($admin['user_id']);
                                //pr($refercount); die;
                                echo count($refercount['refers']);
                              } else {
                                echo 'N/A';
                              }
                              ?>

                          </td>
                          <td><?php
                              if (!empty($admin['user_id'])) {
                                $i = 0;
                                $v = 0;


                                $refers = $this->Comman->managetalentpartner($admin['user_id']);

                                foreach ($refers['refers'] as $key => $referValue) {
                                  if ($referValue['status'] == 'Y') {
                                    $i++;
                                  } else {
                                    $v++;
                                  }
                                }

                                echo $i;
                              } else {
                                echo 'N/A';
                              }
                              ?>

                          </td>

                          <td>
                            <?php if (!empty($admin['user_id'])) {
                              $v = 0;

                              $referss = $this->Comman->managetalentpartner($admin['user_id']);
                              foreach ($referss['refers'] as $key => $referValues) {
                                if ($referValues['status'] == 'N') {
                                  $v++;
                                }
                              }


                              echo $v;
                            } else {
                              echo 'N/A';
                            }
                            ?>
                          </td>
                          <?php if ($this->request->session()->read('talentadmin.enable_delete_subadmin') == 'Y') { ?>
                            <td>
                              <?php /* if($admin->user->status=='Y'){ 
                    echo $this->Html->link('Active', [
                      'action' => 'status',
                      $admin->user->id,
                      $admin->user->status  
                      ],['class'=>'label label-success']);
  
                  }else{ 
                   echo $this->Html->link('Inactive', [
                    'action' => 'status',
                    $admin->user->id,
                    $admin->user->status
                    ],['class'=>'label label-primary']);
  
                  } */ ?>

                              <?php
                              echo $this->Html->link('Edit', [
                                'action' => 'addsubadmin',
                                $admin->id
                              ], ['class' => 'label label-primary']); ?>


                              <?php
                              echo $this->Html->link('Delete', [
                                'action' => 'delete',
                                $admin->id,
                                $i
                              ], ['class' => 'label label-danger', "onClick" => "javascript: return confirm('Are you sure do you want to delete this')"]); ?>
                              <br>


                            </td>
                          <?php } ?>
                        </tr>
                      <?php $checkdata++;
                      }
                      $counter++;
                    }
                    if ($checkdata == 0) { ?>
                      <tr>
                        <td colspan="11" align="center">No active Talent Partner</td>
                      </tr>
                    <?php }
                  } else { ?>
                    <tr>
                      <td colspan="11" align="center">You have not created any Talent Partner yet</td>
                    </tr>
                    <?php }
                } elseif ($status == 4) {
                  $counter = 1;
                  if (isset($contentadmin) && !empty($contentadmin)) {
                    $checkdata = 0;
                    foreach ($contentadmin as $admin) { //pr($admin); 
                      $rcount = $this->Comman->managetalentpartner($admin['user_id']);
                      if (count($rcount['refers']) == 0 && !empty($admin['user_id'])) {  ?>
                        <tr>
                          <td><?php echo $counter; ?></td>
                          <td><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $admin['user_id']; ?>" target="_blank">
                              <?php if (isset($admin->user_name)) {
                                echo ucfirst($admin->user_name);
                                if ($admin['user_id'] == "") {
                                  echo "<br>(Not Registered)";
                                }
                              } else {
                                echo 'N/A';
                              } ?></a>
                          </td>
                          <td><?php if (isset($admin->email)) {
                                echo $admin->email;
                                if (!empty($admin['user_id'])) {
                                  $mails = $this->Comman->profilemails($admin['user_id']);

                                  if (!empty($mails['altemail'])) {

                                    echo '</br>' . str_replace(",", "</br>", $mails['altemail']);
                                  }
                                }
                              } else {
                                echo 'N/A';
                              } ?></td>
                          <td><?php if (!empty($admin['user_id'])) {
                                $data = $this->Comman->managetalentpartner($admin['user_id']);
                                //pr($data); 
                                if ($data['profile']['phone']) {
                                  echo "+" . $data['profile']['phonecode'] . "-" . $data['profile']['phone'];
                                  if (!empty($data['profile']['altnumber'])) {
                                    $removespace = str_replace(' ', '', $data['profile']['altnumber']);
                                    $altphone = explode(",", $removespace);
                                    foreach ($altphone as $altphonevalue) {
                                      echo ", +" . $data['profile']['phonecode'] . "-" . $altphonevalue;
                                    }
                                  }
                                } else {
                                  echo 'N/A';
                                }
                              } else {
                                echo 'N/A';
                              }
                              ?></td>
                          <td><?php
                              if (!empty($admin['user_id'])) {
                                $refercount = $this->Comman->managetalentpartner($admin['user_id']);
                                //pr($refercount); die;
                                echo count($refercount['refers']);
                              } else {
                                echo 'N/A';
                              }
                              ?>

                          </td>
                          <td><?php
                              if (!empty($admin['user_id'])) {
                                $i = 0;
                                $v = 0;
                                $refers = $this->Comman->managetalentpartner($admin['user_id']);
                                foreach ($refers['refers'] as $key => $referValue) {
                                  if ($referValue['status'] == 'Y') {
                                    $i++;
                                  } else {
                                    $v++;
                                  }
                                }

                                echo $i;
                              } else {
                                echo 'N/A';
                              }
                              ?>

                          </td>

                          <td>
                            <?php if (!empty($admin['user_id'])) {
                              $v = 0;

                              $referss = $this->Comman->managetalentpartner($admin['user_id']);
                              foreach ($referss['refers'] as $key => $referValues) {
                                if ($referValues['status'] == 'N') {
                                  $v++;
                                }
                              }

                              echo $v;
                            } else {
                              echo 'N/A';
                            }
                            ?>
                          </td>
                          <?php if ($this->request->session()->read('talentadmin.enable_delete_subadmin') == 'Y') { ?>
                            <td>
                              <?php /* if($admin->user->status=='Y'){ 
                    echo $this->Html->link('Active', [
                      'action' => 'status',
                      $admin->user->id,
                      $admin->user->status  
                      ],['class'=>'label label-success']);
  
                  }else{ 
                   echo $this->Html->link('Inactive', [
                    'action' => 'status',
                    $admin->user->id,
                    $admin->user->status
                    ],['class'=>'label label-primary']);
  
                  } */ ?>

                              <?php
                              echo $this->Html->link('Edit', [
                                'action' => 'addsubadmin',
                                $admin->id
                              ], ['class' => 'label label-primary']); ?>


                              <?php
                              echo $this->Html->link('Delete', [
                                'action' => 'delete',
                                $admin->id,
                                $i
                              ], ['class' => 'label label-danger', "onClick" => "javascript: return confirm('Are you sure do you want to delete this')"]); ?>
                              <br>


                            </td>
                          <?php } ?>
                        </tr>
                      <?php
                        $checkdata++;
                      }
                      $counter++;
                    }
                    if ($checkdata == 0) { ?>
                      <tr>
                        <td colspan="11" align="center">No Inactive Talent Partner</td>
                      </tr>
                    <?php }
                  } else { ?>
                    <tr>
                      <td colspan="11" align="center">You have not created any Talent Partner yet</td>
                    </tr>
                    <?php }
                } else {
                  $counter = 1;
                  if (isset($contentadmin) && !empty($contentadmin)) {
                    $checkdata = 0;
                    foreach ($contentadmin as $admin) { //pr($admin); 
                      $rcount = $this->Comman->managetalentpartner($admin['user_id']);
                    ?>
                      <tr>
                        <td><?php echo $counter; ?></td>
                        <td><a href="<?php echo SITE_URL; ?>/viewprofile/<?php echo $admin['user_id']; ?>" target="_blank">
                            <?php if (isset($admin->user_name)) {
                              echo ucfirst($admin->user_name);
                              if ($admin['user_id'] == "") {
                                echo "<br>(Not Registered)";
                              }
                            } else {
                              echo 'N/A';
                            } ?></a>
                        </td>
                        <td><?php if (isset($admin->email)) {
                              echo $admin->email;
                              if (!empty($admin['user_id'])) {
                                $mails = $this->Comman->profilemails($admin['user_id']);

                                if (!empty($mails['altemail'])) {
                                  echo '</br>' . str_replace(",", "</br>", $mails['altemail']);
                                }
                              }
                            } else {
                              echo 'N/A';
                            } ?></td>
                        <td><?php if (!empty($admin['user_id'])) {
                              $data = $this->Comman->managetalentpartner($admin['user_id']);
                              //pr($data); 
                              if ($data['profile']['phone']) {
                                echo "+" . $data['profile']['phonecode'] . "-" . $data['profile']['phone'];
                                if (!empty($data['profile']['altnumber'])) {
                                  $removespace = str_replace(' ', '', $data['profile']['altnumber']);
                                  $altphone = explode(",", $removespace);
                                  foreach ($altphone as $altphonevalue) {
                                    echo ", +" . $data['profile']['phonecode'] . "-" . $altphonevalue;
                                  }
                                }
                              } else {
                                echo 'N/A';
                              }
                            } else {
                              echo 'N/A';
                            }
                            ?></td>
                        <td><?php
                            if (!empty($admin['user_id'])) {
                              $refercount = $this->Comman->managetalentpartner($admin['user_id']);
                              //pr($refercount); die;
                              echo count($refercount['refers']);
                            } else {
                              echo 'N/A';
                            }
                            ?>

                        </td>
                        <td><?php
                            if (!empty($admin['user_id'])) {
                              $i = 0;
                              $v = 0;


                              $refers = $this->Comman->managetalentpartner($admin['user_id']);

                              foreach ($refers['refers'] as $key => $referValue) {
                                if ($referValue['status'] == 'Y') {
                                  $i++;
                                } else {
                                  $v++;
                                }
                              }

                              echo $i;
                            } else {
                              echo 'N/A';
                            }
                            ?>

                        </td>

                        <td>
                          <?php if (!empty($admin['user_id'])) {
                            $v = 0;

                            $referss = $this->Comman->managetalentpartner($admin['user_id']);
                            foreach ($referss['refers'] as $key => $referValues) {
                              if ($referValues['status'] == 'N') {
                                $v++;
                              }
                            }


                            echo $v;
                          } else {
                            echo 'N/A';
                          }
                          ?>
                        </td>
                        <?php if ($this->request->session()->read('talentadmin.enable_delete_subadmin') == 'Y') { ?>
                          <td>
                            <?php /* if($admin->user->status=='Y'){ 
                    echo $this->Html->link('Active', [
                      'action' => 'status',
                      $admin->user->id,
                      $admin->user->status  
                      ],['class'=>'label label-success']);
  
                  }else{ 
                   echo $this->Html->link('Inactive', [
                    'action' => 'status',
                    $admin->user->id,
                    $admin->user->status
                    ],['class'=>'label label-primary']);
  
                  } */ ?>

                            <?php
                            echo $this->Html->link('Edit', [
                              'action' => 'addsubadmin',
                              $admin->id
                            ], ['class' => 'label label-primary']); ?>


                            <?php
                            echo $this->Html->link('Delete', [
                              'action' => 'delete',
                              $admin->id,
                              $i
                            ], ['class' => 'label label-danger', "onClick" => "javascript: return confirm('Are you sure do you want to delete this')"]); ?>
                            <br>


                          </td>
                        <?php } ?>
                      </tr>
                    <?php

                      $counter++;
                    }
                  } else { ?>
                    <tr>
                      <td colspan="11" align="center">You have not created any Talent Partner yet</td>
                    </tr>
                <?php }
                }
                ?>