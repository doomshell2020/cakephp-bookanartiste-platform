<style>
#add_to_cal .radio-inline, #add_to_cal .checkbox-inline {
    height: 40px;
    background-color: #f8f8f8;
    padding: 10px 36px;
    border: 1px solid #ccc;
}
</style>


<section id="add_to_cal">
    <?php //pr($calenedit); ?>
		   <?php echo $this->Form->create('',array('url' => array('controller' => '/calendar', 'action' => 'edit/'.$calenedit['id']),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'profile_form','autocomplete'=>'off')); ?>
		   <input type="hidden" name="type" value="<?php echo $typeevent; ?>">
		   <?php /* ?>
               <div class="form-group">
                  <label for="" class="col-sm-2 control-label"> <b>Type :</b></label>
                  <div class="col-sm-8">
                      
                    <?php $gen= array('EV'=>'Event','RE'=>'Reminder','TD'=>'To Do'); ?>

                   <?php echo $this->Form->input('type',array('class'=>'form-control', 'id'=>'gender','type'=>'radio','required','options'=>$gen,'label' =>false,'legend'=>false,'templates' => ['radioWrapper' => '<label class="radio-inline">{{label}}</label>'],'required'=>true,'checked'=>true)); ?>
                   
                  </div>
                  <div class="col-sm-2"></div>
                </div>
               <?php */ ?>
                    
                      <div class="form-group talentevent">
         <label for="" class="col-sm-2 control-label"><b>Date/Time: </b></label>
                  <div class="col-sm-8">
          <div class="row">
          <div class="col-sm-5 date">
        <input class="form-control" type="text" id="datetimepicker1" placeholder="DD-MM-YYYY" value="<?php echo (!empty($calenedit['from_date']))?date('Y-m-d H:m',strtotime($calenedit['from_date'])):''; ?>" required="true" name="from_date" >
        

        
        </div>
        <?php if($typeevent=='EV'||$typeevent=='RE'){ ?>
  <label for="" class="col-sm-2 control-label todolabel" style="text-align:center"><b>TO</b> :</label>
    <div class="col-sm-5 date">
     <input class="form-control ertdate" type="text" id="datetimepicker2" value="<?php echo (!empty($calenedit['to_date']))?date('Y-m-d H:m',strtotime($calenedit['to_date'])):''; ?>" placeholder="DD-MM-YYYY" required="true" name="to_date">
        </div>
         <?php } ?>
        </div>
       
        </div>
        <div class="col-sm-2"></div>
                </div>
                
                  <div class="form-group">
                  <label for="" class="col-sm-2 control-label"><b><span id="selectedcalen" style="font-weight: bold;">Event</span> Title :</b></label>
                  <div class="col-sm-8">
                    <input class="form-control" type="text" id="eventTitle"  required="true" name="title" value="<?php echo $calenedit['title']; ?>">
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label"><b>Event Type :</b></label>
                  <div class="col-sm-8">
                 <input class="form-control" type="text" id="eventtype" required="true" name="eventtype" value="<?php echo $calenedit['eventtype']; ?>">
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                
                <div id= "loca" class="form-group">
                  <label for="" class="col-sm-2 control-label"><b>Location :</b></label>
                  <div class="col-sm-8">
                 <input class="form-control" type="text" id="location" required="true" name="location" value="<?php echo $calenedit['location']; ?>">
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                
                 <div class="form-group">
                  <label for="" class="col-sm-2 control-label"><b>Description :</b></label>
                  <div class="col-sm-8">
                 <input class="form-control" type="text" id="eventdesc" required="true" name="description" value="<?php echo $calenedit['description']; ?>">
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-2 control-label"><b>Remark:</b></label>
                  <div class="col-sm-8">
                 <input class="form-control" type="text" id="eventremark" name="remark" value="<?php echo $calenedit['remark']; ?>">
                  </div>
                  <div class="col-sm-2"></div>
                </div>
                
                
                
        
              <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button id="btn" type="submit" class="btn btn-default  savedataevent">Add</button>
          </div>
        </div>
            
            
		            <?php echo $this->Form->end(); ?>
	<section>
	    
	
	    
	    <script>
$(document).ready(function(){
    $("#type-ev").click(function(){
       $("#datetimepicker2").css("display", "block");
       $(".todolabel").css("display", "block");
       $("#selectedcalen").text('Event');
       $('.ertdate').removeAttr('disabled');
    });
});

$(document).ready(function(){
    $("#type-re").click(function(){
        $("#datetimepicker2").css("display", "block");
        $(".todolabel").css("display", "block");
              $("#selectedcalen").text('Reminder');
              $('.ertdate').removeAttr('disabled');

    });
     $("#type-td").click(function(){
        //$("#loca").css("display", "none");
           $("#datetimepicker2").css("display", "none");
           $(".todolabel").css("display", "none");
           $("#selectedcalen").text('ToDo');
           $('.ertdate').prop('disabled', 'disabled');

    });
});
</script>
	<script type="text/javascript"> 
  $(function() { 
   var start = new Date();
// set end date to max one year period:
var end = new Date(new Date().setYear(start.getFullYear()+1));
$('#datetimepicker1').datetimepicker({
  //format: 'MM dd,yyyy hh:ii',
  startDate : start,
  //endDate   : end
}).on('changeDate', function(){

    $('#datetimepicker2').datetimepicker('setStartDate',new Date($(this).val()));

         $(this).datetimepicker('hide');
       }); 

$('#datetimepicker2').datetimepicker({
  startDate : start,
}).on('changeDate', function(){
    $('#datetimepicker1').datetimepicker('setEndDate', new Date($(this).val()));
    
     $(this).datetimepicker('hide');
   });
   
  }); 
   </script>
