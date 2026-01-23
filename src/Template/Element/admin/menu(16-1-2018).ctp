        <?php 
        //pr($this->request->params['controller']);  die;


        ?>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">

        <div class="pull-left image">

        <br/><br/>
        <p></p>
        </div>
        <div class="pull-left info">
        <p><?php echo ucfirst($this->request->session()->read('Auth.User.user_name'));?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> On line</a>
        </div>
        </div>


        <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>	
        <li class="<?php if($this->request->params['controller'] == 'Dashboards'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/dashboards/'); ?>">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>

        </a>

        </li>
        <li class="<?php if($this->request->params['controller'] == 'profile'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/profile/'); ?>">
        <i class="fa fa-user"></i> <span>Artist Person's List</span>

        </a>

        </li>
        <li class="<?php if($this->request->params['controller'] == 'profile'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/nontelent/'); ?>">
        <i class="fa fa-user"></i> <span>Non Talent Person's List</span>

        </a>

        </li>

        <li class="<?php if($this->request->params['controller'] == 'profile'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/profile/'); ?>">
        <i class="fa fa-paypal" aria-hidden="true"></i>
        <span>Packages</span>

        </a>

        <ul class="treeview-menu" <?php if($this->request->params['controller']=='Profilepack') {  ?> style="display: block" <?php } ?>>
        <li>  <a href="<?php echo $this->Url->build('/admin/profilepack/'); ?>" <?php if($this->request->params['controller']=='Profilepack' && $this->request->params['action']=='index') {  ?> style="color:#fff" <?php   }?>>
        <i class="fa fa-files-o"></i>
        <span>Profile Package</span>

        </a>

        <li> <a href="<?php echo $this->Url->build('/admin/quotepack/'); ?>" <?php if($this->request->params['controller']=='Quotepack' && $this->request->params['action']=='index') {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i>Quote Package</a></li>

        <li> <a href="<?php echo $this->Url->build('/admin/recuriterpack'); ?>" <?php if($this->request->params['controller']=='Recuriterpack' && $this->request->params['action']=='index') {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i> Recruiter package</a></li>
        
        <li> <a href="<?php echo $this->Url->build('/admin/bannerpack/'); ?>" <?php if($this->request->params['controller']=='ActualExp' && $this->request->params['action']=='index') {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i>Banner Package</a></li>

        <li> <a href="<?php echo $this->Url->build('/admin/requirement/'); ?>" <?php if($this->request->params['controller']=='ActualExp' && $this->request->params['action']=='index') {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i> Requirement Package</a></li>


        </ul>

        </li>

        </li>
        <li class="<?php if($this->request->params['controller'] == 'profile'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/contentadmin/'); ?>">
        <i class="fa fa-user"></i> <span>Content Admin</span>

        </a>

        </li>

        <li class="<?php if($this->request->params['controller'] == 'profile'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/settings/add/1'); ?>">
        <i class="fa fa-cog" aria-hidden="true"></i>
        </i> <span>Setting Manger</span>

        </a>

        </li>

      
 <li class="<?php if($this->request->params['controller'] == 'Skill' || $this->request->params['controller'] == 'Country'||  $this->request->params['controller'] == 'Enthcity' || $this->request->params['controller'] == 'Currency' || $this->request->params['controller'] == 'Language' || $this->request->params['controller'] == 'Templates') { echo 'active';} ?> treeview ">
        <a href="<?php echo $this->Url->build('/admin/profile/'); ?>">
        <i class="fa fa-cc-mastercard" aria-hidden="true"></i>
        <span>Master's Manager</span>

        </a>

        <ul class="treeview-menu" <?php if($this->request->params['controller']=='Skill') {  ?> style="display: block" <?php } ?>>
        <li class="<?php if($this->request->params['controller'] == 'Skill'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/skill'); ?>">
        <i class="fa fa-filter" aria-hidden="true"></i>
        </i> <span>Skill Set</span>

        </a>

        </li>
        <li> <a href="<?php echo $this->Url->build('/admin/country/'); ?>" <?php if($this->request->params['controller']=='Country') {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i>Country Manager</a></li>
   
        <li> <a href="<?php echo $this->Url->build('/admin/enthcity/'); ?>" <?php if($this->request->params['controller']=='Enthcity') {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i>Enthcity  Manager</a></li>
        <li> <a href="<?php echo $this->Url->build('/admin/currency/'); ?>" <?php if($this->request->params['controller']=='Currency' ) {  ?> style="color:#fff" <?php   }  ?> ><i class="fa fa-circle-o"></i>Currency Manager</a></li>
        <li> <a href="<?php echo $this->Url->build('/admin/language/'); ?>" <?php if($this->request->params['controller']=='Language' ) {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i>Language Manager</a></li>
          <li> <a href="<?php echo $this->Url->build('/admin/templates/index'); ?>" <?php if($this->request->params['controller']=='Templates' ) {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i> Eamil Template Manager</a></li>





        </ul>

        </li>




</li>

 <li class="<?php if($this->request->params['controller'] == 'Static'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/static/'); ?>">
        <i class="fa fa-certificate"></i> <span>Static Page Manager</span>

        </a>

        </li>

         <li class="<?php if($this->request->params['controller'] == 'Genre'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/genre/'); ?>">
        <i class="fa fa-info" aria-hidden="true"></i><span>Genre Manager</span>

        </a>

        </li>
        </ul>
        </section>

        </aside>
