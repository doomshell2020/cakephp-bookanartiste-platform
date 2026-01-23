<?php 
//pr($this->request->params);
if($this->request->params['controller']=="Homes" && $this->request->params['action']=="index"){ ?>

<?= $this->element('homeheader') ?>
<?php }else{ ?>

<?= $this->element('loginheader') ?>


<?php } ?>

        <?= $this->fetch('content') ?>
 
    <?= $this->element('footer') ?>
