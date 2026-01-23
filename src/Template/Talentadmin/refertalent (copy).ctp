<!----------------------editprofile-strt----------------------->
<?php 
foreach ($skillofcontaint as $key => $value) {
    $array[]=$value['skill_id'];
    $array1[]=$value['skill']['name'];
}
?>
 
<section id="page_signup">
  <div class="container">
    <div class="row">
      
      <div class="col-sm-12">
        <div class="signup-popup">
          <h2>Refer Talent Profile</h2>
    <p class="m-bott-50">Build your own business income stream and generate opportunities by creating a global community of performing arts</p>
          
          
          <?php echo $this->Form->create($packentity, array(
'class'=>'form-horizontal',
'id' => 'content_admin',
'enctype' => 'multipart/form-data',
'onsubmit'=>' return checkpass()','autocomplete'=>'off')); ?>
          <div class="box-body">
        
        
         <div class="form-group">
            <label class="col-sm-3 control-label">
            </label>
            <div class="field col-sm-6">
             <span id="dse"><a href="<?php echo SITE_URL; ?>/refer_talent.xlsx">Download Sample Excel Sheet</a></span>
            </div>
          </div>


         <div class="form-group">
            <label class="col-sm-3 control-label">Refer Talent through
            </label>
            <div class="field col-sm-6">
             <input type="radio" name="refer_type" id="usp" onclick="changerefertype(this)" class="refer_type" value="I" > Upload Single Profile<br>
             <input type="radio" name="refer_type" id="ump"onclick="changerefertype(this)" class="refer_type" value="C" checked> Upload Multiple Profiles
            </div>
          </div>
           
         <div id="csv_upload" class="">
         <div class="form-group">
            <label class="col-sm-3 control-label">Excel sheet upload
            </label>
	<div class="field col-sm-6">
	    <input class="input-file" type="file" name="csv_file" id="csv_file" required onchange="return fileValidation();" required accept=".xlsx, .xls">
	    <label tabindex="0" for="my-file" class="input-file-trigger">Upload Excel File</label>
	</div>
	 <span id="ncpyss" style= "display: none; color: red"> Image Extension Allow .xls|.xlsx Format Only</span>

          </div>
         </div>
        
        <div id="refer_form">
          <div class="form-group">
            <label class="col-sm-3 control-label">Name
            </label>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('name', array('class' => 
'longinput form-control','id'=>'user_name','maxlength'=>'20','','placeholder'=>'Name','required','label'=>false,'disabled'=>true)); ?>
 <input type="hidden" name="ref_by" value="<?php echo $this->request->session()->read('Auth.User.id'); ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Email
            </label>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('email', array('class' => 
'longinput form-control','maxlength'=>'20','','placeholder'=>'Email','required','label'=>false,'disabled'=>true)); ?>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-3 control-label">Phone No
            </label>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('mobile', array('class' => 
'longinput form-control','maxlength'=>'20','','placeholder'=>'Phone No','required','label'=>false,'disabled'=>true	)); ?>
            </div>
          </div>
        </div>
    
          <div class="form-group">
            <label class="col-sm-3 control-label">Skills
            </label>
            <div class="field col-sm-6">
              <?php echo $this->Form->input('skillshow', array('class' => 
'longinput form-control','maxlength'=>'200',''=>true,'placeholder'=>'Skills','required','label'=>false,'value'=>implode(", ",$array1))); ?>
            </div>
            <a  data-toggle="modal" class='m-top-5 skill btn btn-success ' href="<?php echo SITE_URL?>/admin/talentsubadmin/skills/<?php echo $packentity['id']; ?>">Add Skills
            </a>
            <input type="hidden" name="skill" id="skill"  value="<?php echo  implode(",",$array); ?>"/> 
          </div>
          
          
          
	<div class="form-group">
	    <div class="col-sm-12 text-center">
		
							  <button class="btn btn-primary" id="bn_subscribesss">Submit</button>

		</div>
	    </div>
	</div>
    
        <!--content-->
        <!-- Modal -->
        <div id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content" >
              <input id="myInput" onkeyup="myFunction(this)" placeholder="Search from list..." type="text">
              <div class="modal-body" id="skillsetsearch">
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <script>
          $('.skill').click(function(e){
            e.preventDefault();
            $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
          }
                           );
        </script>
        <!-- /.form group -->
      </div>
      <!-- /.box-body -->

      <!-- /.box-footer -->
      <?php echo $this->Form->end(); ?>
    </div>
  </div>
  
  </div>
</div>
</section>


  <div class="modal fade" id="irefer" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
		<?php echo $this->Flash->render('refer_error'); ?>
     <?php pr($invited); foreach($invited as $key=>$value){ ?>
      <tr>
        <td><?php echo $key; ?></td>
        <td><?php echo $value; ?></td>
       
      </tr>
     <?php } ?>
    </tbody>
  </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>


    <script type="text/javascript">
    
    
    function fileValidation(){
	var fileInput = document.getElementById('file');
	var filePath = fileInput.value;
	var allowedExtensions = /(\.xls|\.xlsx)$/i;
	//alert(allowedExtensions);
	if(!allowedExtensions.exec(filePath)){
	    $("#ncpyss").css("display", "block");
	    fileInput.value = '';
	    return false;
	}else{
	   
	}
    }
    
    // Change refer type
    function changerefertype(values)
	{
	    type = values.value;
	    //alert(type);
	    if(type=='C')
	    {
		$('#csv_file').removeAttr('disabled');
		$('#user_name').attr('disabled','disabled');
		$('#email').attr('disabled','disabled');
		$('#mobile').attr('disabled','disabled');
		$("#csv_upload").show();
		$("#refer_form").hide();
		$("#dse").show();
	    }
	    else
	    {
		$('#user_name').removeAttr('disabled');
		$('#email').removeAttr('disabled');
		$('#mobile').removeAttr('disabled');
		$('#csv_file').attr('disabled','disabled');
		$("#csv_upload").hide();
		$("#refer_form").show();
		$("#dse").hide();
	    }
	}
	  $("#refer_form").hide();
	
	
	
  
    $(document).ready(function() {
		
	$("#country_ids").on('change',function() {
		var id = $(this).val();
		$("#state").find('option').remove();
		//$("#city").find('option').remove();
		if (id) {
			var dataString = 'id='+ id;
			$.ajax({
				type: "POST",
				url: '<?php echo SITE_URL;?>/talentadmin/getStates',
				data: dataString,
				cache: false,
				success: function(html) {
					$.each(html, function(key, value) {        
						$('<option>').val(key).text(value).appendTo($("#state"));
					});
				} 
			});
		}
	});

	$("#state").on('change',function() {
		var id = $(this).val();
		$("#city").find('option').remove();
		if (id) {
			var dataString = 'id='+ id;
			$.ajax({
				type: "POST",
				url: '<?php echo SITE_URL;?>/talentadmin/getcities',
				data: dataString,
				cache: false,
				success: function(html) {
					$.each(html, function(key, value) {              
						$('<option>').val(key).text(value).appendTo($("#city"));
					});
				} 
			});
		}	
	});
    });
    </script>
<script type="text/javascript">
$('#bn_subscribesss').click(function(e) { alert();
	e.preventDefault();
    $.ajax({
	type: "POST",
	url: '<?php echo SITE_URL;?>/talentadmin/refertalent',
	data: $('#content_admin').serialize(),
	cache:false,
	success:function(data){  //alert(data);

	}
    });
});
</script>

<script>
<?php if($this->Flash->render('refer_fail')!=''){  ?>
  $(document).ready(function() { //alert();
$('#irefer').modal('show');
});
  <?php } ?>
</script>
	

