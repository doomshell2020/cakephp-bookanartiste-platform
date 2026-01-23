   <!-- ------------------slider ------------------------>
   <div id="inner_slider">
        <div class="container">
            <hgroup>
                <h1 style="text-align: center;" class="site_heading">FAQs</h1>
            </hgroup>
        </div>
    </div>
    <!-- ====================================about slider -->
    <section id="Request_form_sec" style="padding:60px 0px; " class="accordianSec">
        <div class="container">
           
        <h2>Frequently Asked Questions</h2>
<p class="m-bott-50" style="text-align: center;
    margin-left: auto;">General Information</p>

<div class="faq_background">
  <?php if(count($Faq_cat)>0){
   $k=1; $i=1; foreach($Faq_cat as $value){
// pr($value); die;
    $faq_cat_question = $this->Comman->get_fat_cat($value['id']);
 
      if(count($faq_cat_question)>0){
          ?>
            <div class="accordion" id="accordionExample<?php echo $i; ?>">
            <p class="text-left"><?php echo $value['name']; ?></p>

             <?php $sr=1; $i=$k; foreach($faq_cat_question as $values){ ?>
                <div class="card ">
                    <div class="card-header" id="heading001<?php echo $j; ?>">
                        <a href="javascript:void(0)" type="button" class="collapsed d-flex align-items-center"
                            data-toggle="collapse" data-target="#collapse001<?php echo $j; ?>" aria-expanded="true"
                            aria-controls="collapse001<?php echo $j; ?>">
                            <i class="fas fa-plus mr-3 ic_show"></i>
                            <i class="fas fa-minus mr-3 ic_hide"></i>
                            <?php echo $sr; ?>.  <?php echo $values['question']; ?>
                        </a>
                    </div>

                    <div id="collapse001<?php echo $j; ?>" class="collapse"
                        aria-labelledby="heading001<?php echo $j; ?>" data-parent="#accordionExample<?php echo $i; ?>">
                        <div class="card-body">
                        <?php echo $values['answer']; ?>
                        </div>
                    </div>
                </div>
            <?php $j++; $sr++; } ?>

                <div class="clearfix"></div>
            </div>
<?php $k=$j; }} }else{?>
    No FAQ' categories added yet
<?php } ?>




        </div>
        </div>

    </section>
    <!-- ------------------------------------------about--contant------------- -->


    <style>

element.style {
    padding: 60px 0px;
}

article, aside, figcaption, figure, footer, header, hgroup, main, nav, section {
    display: block;
}

.container {
    max-width: 1170px;
    padding: 0px 15px;
    margin: auto;
    width: auto;
}
#Request_form_sec .accordion {
    width: 770px;
    margin: auto;
}
.accordion {
    overflow-anchor: none;
}

#Request_form_sec .accordion .card {
    border: none;
    margin-bottom: 15px;
    border-bottom: none;
}

.accordion>.card {
    overflow: hidden;
}

#Request_form_sec .accordion>.card>.card-header {
    padding: 0px;
    background: #e14d4d10;
    border: 0px;
}

.accordion>.card>.card-header {
    border-radius: 0;
    margin-bottom: -1px;
}

a, a:hover, a:active, a:visited, a:focus {
    text-decoration: none;
    color: #333;
}

        </style>