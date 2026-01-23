        <?php //pr($this->request->params);  die; ?>
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
        <li class="<?php if($this->request->params['controller'] == 'Profile'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/profile/'); ?>">
        <i class="fa fa-user"></i> <span>Artiste Manager</span>

        </a>

        </li>
        
        
        </li>
        <li class="<?php if($this->request->params['controller'] == 'Profile'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/banner/'); ?>">
        <i class="fa fa-user"></i> <span>Banner Manager 
        <?php $bannercount=$this->Comman->bannercount();
            echo "( ".count($bannercount)." )";
        ?></span>

        </a>

        </li>
        
        
        <li class="<?php if($this->request->params['controller'] == 'visibilitymatrix'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/visibilitymatrix/'); ?>">
        <i class="fa fa-user"></i> <span>Visibility Matrix</span>

        </a>

        </li>
        
        
        
        <li class="<?php if($this->request->params['controller'] == 'Nontelent'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/nontelent/'); ?>">
        <i class="fa fa-user"></i> <span>Non Talent Manager</span>

        </a>

        </li>
        
        </li>
        <li class="<?php if($this->request->params['controller'] == 'Subscription'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/subscription/'); ?>">
        <i class="fa fa-user"></i> <span>Subscription Manager</span>
        </a>
        </li>
       


        <li class="<?php if($this->request->params['controller'] == 'Invoicereceipt' || $this->request->params['controller'] == 'Transcation'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/profile/'); ?>">
        <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
        <span>Transaction Managers</span>

        </a>

        <ul class="treeview-menu" <?php if($this->request->params['controller']=='Invoicereceipt' || $this->request->params['controller']=='Transcation') {  ?> style="display: block" <?php } ?>>
        

        <li class="<?php if($this->request->params['controller'] == 'Invoicereceipt'){ echo 'active';} ?>">
            <a href="<?php echo $this->Url->build('/admin/invoicereceipt/'); ?>" <?php if($this->request->params['controller']=='Invoicereceipt' && $this->request->params['action']=='index') {  ?> style="color:#fff" <?php   }?>>
                <i class="fa fa-circle-o"></i> <span>Manage Invoice, Receipt</span>
            </a>
        </li>

        <li class="<?php if($this->request->params['controller'] == 'Transcation'){ echo 'active';} ?>">
            <a href="<?php echo $this->Url->build('/admin/transcation/'); ?>" <?php if($this->request->params['controller']=='Transcation' && $this->request->params['action']=='index') {  ?> style="color:#fff" <?php   }?>>
                <i class="fa fa-circle-o"></i><span>Payment Transaction Manager</span>
            </a>
        </li>

        <li class="<?php if($this->request->params['controller'] == 'Transcation' && $this->request->params['action'] == 'receipt'){ echo 'active';} ?>">
            <a href="<?php echo $this->Url->build('/admin/transcation/receipt'); ?>" <?php if($this->request->params['controller']=='Transcation' && $this->request->params['action']=='receipt') {  ?> style="color:#fff" <?php   }?>>
                <i class="fa fa-circle-o"></i><span>Receipt Manager</span>
            </a>
        </li>

        <li class="<?php if($this->request->params['controller'] == 'Transcation' && $this->request->params['action'] == 'invoice'){ echo 'active';} ?>">
            <a href="<?php echo $this->Url->build('/admin/transcation/invoice'); ?>" <?php if($this->request->params['controller']=='Transcation' && $this->request->params['action']=='invoice') {  ?> style="color:#fff" <?php   }?>>
                <i class="fa fa-circle-o"></i><span>Invoice Manager</span>
            </a>
        </li>

        </ul>
        </li>





        <li class="<?php if($this->request->params['controller'] == 'Profilepack' || $this->request->params['controller'] == 'Quotepack' || $this->request->params['controller'] == 'Recuriterpack' || $this->request->params['controller'] == 'Bannerpack' || $this->request->params['controller'] == 'Requirement'){ echo 'active';} ?> treeview">
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
        
        <li> <a href="<?php echo $this->Url->build('/admin/bannerpack/'); ?>" <?php if($this->request->params['controller']=='Bannerpack' && $this->request->params['action']=='index') {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i>Banner Package</a></li>

        <li> <a href="<?php echo $this->Url->build('/admin/requirement/'); ?>" <?php if($this->request->params['controller']=='Requirement' && $this->request->params['action']=='index') {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i> Requirement Package</a></li>
        
        <li> <a href="<?php echo $this->Url->build('/admin/featurejobpack/'); ?>" <?php if($this->request->params['controller']=='Featurejobpack' && $this->request->params['action']=='index') {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i> Feature Job Package</a></li>
        
        <li> <a href="<?php echo $this->Url->build('/admin/featureprofilepack/'); ?>" <?php if($this->request->params['controller']=='Featureprofilepack' && $this->request->params['action']=='index') {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i> Feature Profile Package</a></li>

        <li> <a href="<?php echo $this->Url->build('/admin/jobadvertpack/'); ?>" <?php if($this->request->params['controller']=='Job advert pack' && $this->request->params['action']=='index') {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i> Manage Job Advertisement</a></li>

        <li> <a href="<?php echo $this->Url->build('/admin/profileadvertpack/'); ?>" <?php if($this->request->params['controller']=='Profile advert pack' && $this->request->params['action']=='index') {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i> Manage Profile Advertisement</a></li>
        
        </ul>
        </li>
        </li>
        <li class="<?php if($this->request->params['controller'] == 'Contentadmin'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/contentadmin/'); ?>">
        <i class="fa fa-user"></i> <span>Content Admin</span>
        </a>
        </li>
        <li class="<?php if($this->request->params['controller'] == 'Settings'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/settings/add/1'); ?>">
        <i class="fa fa-cog" aria-hidden="true"></i>
        </i> <span>Setting Manager</span>
        </a>
        </li>

 <li class="<?php if($this->request->params['controller'] == 'Skill' || $this->request->params['controller'] == 'Country'||  $this->request->params['controller'] == 'Enthcity' || $this->request->params['controller'] == 'Currency' || $this->request->params['controller'] == 'Language' || $this->request->params['controller'] == 'Templates' || $this->request->params['controller'] == 'Genre') { echo 'active';} ?> treeview ">
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
          <li> <a href="<?php echo $this->Url->build('/admin/eventtype/'); ?>" <?php if($this->request->params['controller']=='eventtype' ) {  ?> style="color:#fff" <?php   }  ?> ><i class="fa fa-circle-o"></i>Event type  Manager</a></li>
        <li> <a href="<?php echo $this->Url->build('/admin/language/'); ?>" <?php if($this->request->params['controller']=='Language' ) {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i>Language Manager</a></li>
          <li> <a href="<?php echo $this->Url->build('/admin/templates/index'); ?>" <?php if($this->request->params['controller']=='Templates' ) {  ?> style="color:#fff" <?php   }?>><i class="fa fa-circle-o"></i>Email Template Manager</a></li>
          <li class="<?php if($this->request->params['controller'] == 'Genre'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/genre/'); ?>">
        <i class="fa fa-info" aria-hidden="true"></i><span>Genre Manager</span>

        </a>
        </li>
        
        <li class="<?php if($this->request->params['controller'] == 'Vitalstats'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/vitalstats/'); ?>">
        <i class="fa fa-info" aria-hidden="true"></i><span>Vitals  </span></a>
    </li>
        
        </ul>
        </li>
</li>
        <li class="<?php if($this->request->params['controller'] == 'Faq'){ echo 'active';} ?> treeview">
            <a href="<?php echo $this->Url->build('/admin/faq/'); ?>">
                <i class="fa fa-certificate"></i> <span>FAQ Manager</span>
            </a>
        </li>

        <li class="<?php if($this->request->params['controller'] == 'Static'){ echo 'active';} ?> treeview">
            <a href="<?php echo $this->Url->build('/admin/static/'); ?>">
                <i class="fa fa-certificate"></i> <span>Static Page Manager</span>
            </a>
        </li>

        <li class="<?php if($this->request->params['controller'] == 'Job'){ echo 'active';} ?> treeview">
            <a href="<?php echo $this->Url->build('/admin/job/'); ?>">
                <i class="fa fa-info" aria-hidden="true"></i><span>Job Manager</span>
            </a>
        </li>

        <li class="<?php if($this->request->params['controller'] == 'featurejobpack'){ echo 'active';} ?> treeview">
            <a href="<?php echo $this->Url->build('/admin/featurejobpack/featurerequirment'); ?>">
                <i class="fa fa-info" aria-hidden="true"></i><span>Featured Jobs</span>
            </a>
        </li>

        <li class="<?php if($this->request->params['controller'] == 'featureprofilepack'){ echo 'active';} ?> treeview">
            <a href="<?php echo $this->Url->build('/admin/featureprofilepack/featureprofiles'); ?>">
                <i class="fa fa-info" aria-hidden="true"></i><span>Featured Profiles</span>
            </a>
        </li>

        <li class="<?php if($this->request->params['controller'] == 'Talentadmin'){ echo 'active';} ?> treeview">
            <a href="<?php echo $this->Url->build('/admin/talentadmin/'); ?>">
                <i class="fa fa-info" aria-hidden="true"></i><span>Talent Partners</span></a>
        </li>

   <!--<li class="<?php if($this->request->params['controller'] == 'Talentsubadmin'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/talentsubadmin/'); ?>">
        <i class="fa fa-info" aria-hidden="true"></i><span>View Talent Partners</span></a>
    </li>
    -->

 
 <li class="<?php if($this->request->params['controller'] == 'Vitalstatistics'){ echo 'active';} ?> treeview">
        <a href="<?php echo $this->Url->build('/admin/vitalstatistics/'); ?>">
        <i class="fa fa-info" aria-hidden="true"></i><span>Form Parts Visibility</span></a>
    </li>



        </ul>
        </section>

        </aside>
