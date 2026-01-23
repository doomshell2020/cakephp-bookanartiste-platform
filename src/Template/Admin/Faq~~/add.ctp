<script>
function checkextension() {
    var file = document.querySelector("#fUpload");
    if (/\.(jpe?g|png|gif)$/i.test(file.files[0].name) === false) {
        alert("not an image please choose a image!");
        $('#fUpload').val('');
    }
    return false;
}
</script>
<style type="text/css">
.text {
    color: red;
    font-size: 12px;
}

label {
    font-weight: 400;
    margin-bottom: 8px !important;
}
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Faq Manager
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="<?php echo SITE_URL; ?>admin/faq">Faq</a></li>
            <?php if(isset($companies['id'])){ ?>
            <li class="active"><a href="javascript:void(0)">Edit Faq</a></li>
            <?php } else { ?>
            <li class="active"><a href="javascript:void(0)">Add Faq</a></li>
            <?php } ?>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <?php echo $this->Flash->render(); ?>
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i>
                            <?php if(isset($faq['id'])){ echo 'Edit Faq'; }else{ echo 'Create Faq';} ?></h3>
                    </div>

                    <?php echo $this->Form->create($faq, array(
           'class'=>'form-horizontal',
           'enctype' => 'multipart/form-data',
           'validate'
         )); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="inputEmail3" class="control-label">Question</label>
                                <?php echo $this->Form->input('question', array('class' => 'form-control','required','label'=>false,'placeholder'=>'Question','autofocus','autocomplete'=>'off')); ?>
                            </div>
                            <div class="col-sm-12">
                                <label for="inputEmail3" class="control-label">Answer</label>
                                <?php echo $this->Form->input('answer', array('class' => 'form-control','required','label'=>false,'placeholder'=>'Answer','autofocus','autocomplete'=>'off','type'=>'textarea')); ?>
                            </div>
                            <div class="col-sm-3">
                                <label style="color:white;">.</label>
                                <?php echo $this->Form->submit('Add',array('class' => 'btn btn-success pull-left', 'title' => 'Add')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </section>
</div>