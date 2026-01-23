<div class="content-wrapper">
   <!--breadcrumb -->
   <section class="content-header">
      <h1>
         Image Gallery
      </h1>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <div class="box">

               <?php echo $this->Flash->render(); ?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-xs-12">
            <div class="box">

               <!-- /.box-header -->
               <?php if ($Galleryimage) { ?>
                  <div class="box-header">
                     <h3 class="">Gallery image</h3>
                  </div>
                  <div class="box-body">

                     <div id="light_box">
                        <ul class="list-inline admin-gall">
                           <?php foreach ($Galleryimage as $gallvalue) { ?>

                              <li <?php if ($i == 0) { ?> class="hide_p" <?php  } ?>>
                                 <a href="javascript:void(0);" class="lboximg">
                                    <img data-src="<?php echo SITE_URL ?>/gallery/<?php echo $gallvalue['imagename'];  ?>" src="<?php echo SITE_URL ?>/gallery/<?php echo $gallvalue['imagename'];  ?>" height="200" width="200" /></a>

                                 <a href="<?php echo SITE_URL; ?>/admin/profile/gallerydelete/<?php echo $gallvalue['id'] ?>/<?php echo $id ?>/<?php echo $value['name'] ?>" class="fa fa-remove" onClick="javascript:return confirm('Are you sure do you want to delete this')"></a>

                              </li>

                           <?php } ?>
                        </ul>
                     </div>


                  </div>
                  <!-- /.box-body -->
               <?php } ?>

               <div class="box-header">
                  <h3 class="">Images Albums</h3>
               </div>
               <div class="box-body">
                  <?php foreach ($Gallery as $value) {

                     echo "<h4>";
                     echo $value['name'];
                     echo "<br>";
                     echo "</h4>";
                  ?>

                     <div id="light_box">
                        <ul class="list-inline admin-gall">
                           <?php
                           for ($i = 0; $i < count($value['galleryimage']); $i++) { ?>
                              <li <?php if ($i == 0) { ?> class="hide_p" <?php  } ?>>
                                 <a href="javascript:void(0);" class="lboximg">
                                    <img data-src="<?php echo SITE_URL ?>/gallery/<?php echo $value['galleryimage'][$i]['imagename']  ?>" src="<?php echo SITE_URL ?>/gallery/<?php echo $value['galleryimage'][$i]['imagename']  ?>" height="200" width="200" /></a>

                                 <a href="<?php echo SITE_URL; ?>/admin/profile/gallerydelete/<?php echo $value['galleryimage'][$i]['id'] ?>/<?php echo $id ?>/<?php echo $value['name'] ?>" class="fa fa-remove" onClick="javascript:return confirm('Are you sure do you want to delete this')"></a>


                              </li>

                           <?php  } ?>

                        </ul>
                     </div>

                  <?php } ?>

               </div>
               <!-- /.box-body -->

            </div>
            <!-- /.box -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>