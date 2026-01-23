
<section id="add_to_cal">
  <div class="container">
  <h2> <span> Add Calendar</span></h2>
    <div class="calendar_info">
		   <?php echo $this->Form->create('',array('url' => array('controller' => 'calendar', 'action' => 'addtocalendar'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'profile_form','autocomplete'=>'off')); ?>
               <div class="form-group">
                  <label for="" class="col-sm-3 control-label"> <b>Type :<span class="requirfild">*</span></b></label>
                  <div class="col-sm-9">
                      
                    <?php $gen= array('EV'=>'Event','RE'=>'Reminder','TD'=>'To Do'); ?>

                   <?php echo $this->Form->input('type',array('class'=>'form-control', 'id'=>'gender','type'=>'radio','required','options'=>$gen,'label' =>false,'legend'=>false,'templates' => ['radioWrapper' => '<label class="radio-inline">{{label}}</label>'],'required'=>true)); ?>
                   
                  </div>
                  
                </div>
               
                    
                      <div class="form-group talentevent">
         <label for="" class="col-sm-3 control-label"><b>Date/Time:</b><span class="requirfild">*</span></label>
                  <div class="col-sm-9">
          <div class="row">
          <div class="col-sm-5 date">
        <input class="form-control" type="text" id="datetimepicker1" placeholder="DD-MM-YYYY" required="true" name="from_date">
        </div>
    <label for="" class="col-sm-2 control-label todolabel" style="text-align:center"><b>TO</b> :</label>
    <div class="col-sm-5 date">
     <input class="form-control ertdate" type="text" id="datetimepicker2" value="" placeholder="DD-MM-YYYY" required="true" name="to_date">
        </div>
        </div>
        </div>
        
                </div>
                  <div class="form-group">
                  <label for="" class="col-sm-3 control-label"><b><span id="selectedcalen" style="font-weight: bold;">Event</span> Title:</b></label>
                  <div class="col-sm-9">
                    <input class="form-control" type="text" id="eventTitle"  name="title">
                  </div>
                 
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label"><b><span id="selectedcalentype" style="font-weight: bold;">Event</span> <span id="tdtyperem" style="font-weight: bold;">Type </span> : </b><span class="requirfild">*</span></label>
                  <div class="col-sm-9">
                 <input class="form-control" type="text" id="eventtype" name="eventtype" required>
                  </div>
                  
                </div>
                
                <div id= "loca" class="form-group">
                  <label for="" class="col-sm-3 control-label"><b>Location :</b></label>
                  <div class="col-sm-9">
                 <input class="form-control" type="text" id="location"  name="location">
                  </div>
                  
                </div>
                
                 <div class="form-group">
                  <label for="" class="col-sm-3 control-label"><b>Description :</b></label>
                  <div class="col-sm-9">
                 <input class="form-control" type="text" id="eventdesc"  name="description">
                  </div>
                  
                </div>
                
                <div class="form-group">
                  <label for="" class="col-sm-3 control-label"><b>Remark:</b></label>
                  <div class="col-sm-9">
                 <input class="form-control" type="text" id="eventremark" name="remark">
                  </div>
                  
                </div>
                
                
                
        
              <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
            <button id="btn" type="submit" class="btn btn-default">Add</button>
          </div>
        </div>
            
            
		            <?php echo $this->Form->end(); ?>
                </div>
                </div>
</section>
	    <script>
	    $('#type-ev').attr('checked', true);
	    </script>
	    
	    <script>
   $(document).ready(function(){
    $("#type-ev").click(function(){
       $("#datetimepicker2").css("display", "block");
       $(".todolabel").css("display", "block");
       $("#selectedcalen").text('Event');
              $("#selectedcalentype").text('Event');

                     $("#tdtyperem").css("display", "block");

       $('.ertdate').removeAttr('disabled');
    });
});

$(document).ready(function(){
    $("#type-re").click(function(){
        $("#datetimepicker2").css("display", "block");
        $(".todolabel").css("display", "block");
              $("#selectedcalen").text('Reminder');
              $("#selectedcalentype").text('Reminder');
              $("#tdtyperem").css("display", "block");
              $('.ertdate').removeAttr('disabled');

    });
     $("#type-td").click(function(){
        //$("#loca").css("display", "none");
           $("#datetimepicker2").css("display", "none");
           $(".todolabel").css("display", "none");
           $("#selectedcalen").text('ToDo');
           $("#tdtyperem").css("display", "none");
                         $("#selectedcalentype").text('Task');

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
  format: 'MM dd,yyyy hh:ii',
  startDate : start,
  //endDate   : end
}).on('changeDate', function(){

    $('#datetimepicker2').datetimepicker('setStartDate',new Date($(this).val()));


  
         $(this).datetimepicker('hide');
       }); 

$('#datetimepicker2').datetimepicker({
  format: 'MM dd,yyyy hh:ii',
  startDate : start,
 // endDate   : end
// update "fromDate" defaults whenever "toDate" changes
}).on('changeDate', function(){
    // set the "fromDate" end to not be later than "toDate" starts:
    $('#datetimepicker1').datetimepicker('setEndDate', new Date($(this).val()));
    
     $(this).datetimepicker('hide');
   });
   
  }); 
   </script>







<?php /* ?>
	    <script type="text/javascript"> 
        $(function() { 
	    var today = new Date();
	   
	    
	    $('#datetimepicker1').datetimepicker({
		// format: 'dd-m-yyyy hh:ii',
		    language: 'en', 
		    pick12HourFormat: true,
		    startDate: today
		}).on('changeDate', function(){
    // set the "fromDate" end to not be later than "toDate" starts:
    $('.datetimepicker2').datetimepicker('setStartDate',new Date($(this).val()));
    $(this).datetimepicker('hide');
  }); 
		
		  $('#datetimepicker2').datetimepicker({
		 //format: 'dd-m-yyyy hh:ii',
		    language: 'en', 
		    pick12HourFormat: true,
		    startDate: today
		 
		}).on('changeDate', function(){
    // set the "fromDate" end to not be later than "toDate" starts:
        $('.datetimepicker1').datetimepicker('setEndDate', new Date($(this).val()));

    $(this).datetimepicker('hide');
  });
		
		 }); 
		</script>
	    <?php */ ?>