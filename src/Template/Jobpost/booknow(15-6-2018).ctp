
   
   <?php 

   foreach($askquote as $value){
   	$app[]=$value['job_id'];

   
   }
    ?>


    <section id="page_post-req">

    <div class="post-talant-form">
    <div class="m-top-10 container-fluid">
    <h4 class="text-center">My Active Jobs</h4>
    <?php echo $this->Form->create($requirement,array('url' => array('controller' => 'jobpost', 'action' => 'askQuote'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'class'=>'form-horizontal','id'=>'user_form','autocomplete'=>'off')); ?>
    <input type="hidden" name="user_id" value="<?php echo $userid ?>">
	<div class="">
	<?php if(count($activejobs) > 0){ ?>
            
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Job</th>
        <th>Skills</th>
      </tr>
    </thead>
    <tbody>
		<?php  $count=1;foreach($activejobs as $jobs){ //pr($jobs);

	?>
      <tr>
		  <?php if(! in_array($jobs['id'], $app)) { ?>
        <td>	


	
 
		<?php
    if($count>$numberofaskquoteperjob){
    echo"<a href=''> Buy Quote </a>";
    }else{ ?>
  <input type="checkbox" name="job_id[<?php echo $jobs['id']; ?>]" value="<?php echo $jobs['id']; ?>">
    <?php }


     } ?>

		<?php if(! in_array($jobs['id'], $app)) {  $pendingjob[]=$job['id']; ?>
		

		<a href="<?php echo SITE_URL ?>/applyjob/<?php  echo $jobs['id'] ?>" target="_blank"> <?php echo $jobs['title']; ?> </a> 
		</td>
		<?php  }?>
		  <?php if(! in_array($jobs['id'], $app)) {?>
        <td>
			
			<select name="job_id[<?php echo $jobs['id']; ?>][]" onchange="return myfunction(this)" data-req="<?php echo $jobs['id'] ?>" >
				<option value="">--Select--</option>
				<?php foreach ($jobs['requirment_vacancy'] as $skillsreq) { //pr($skillsreq);?>
			
    <option value="<?php echo $skillsreq['skill']['id']; ?>"><?php echo $skillsreq['skill']['name']; ?></option>
<?php } ?>
  </select>  
  <input type="text" id="currency<?php echo $jobs['id']; ?>" style="width: 29%" placeholder="Currency" readonly />
  <input type="text" id="offeramt<?php echo $jobs['id']; ?>" style="width: 38%" placeholder=" Offer Payment" readonly/>
 </td>
<?php } ?>
      </tr>
      <?php  $count++;} ?>
      <?php if($pendingjob) { ?>
	
	  <?php }else{?>
		  <td colspan="2" rowspan="2" style="text-align: center;"><?php echo "No Jobs Available For Quote "; ?></td>	
		  <?php } ?>
    </tbody>
    
  </table>


<?php }?>
	
	
	<?php if($pendingjob) { 
			
	 ?>  
     <input type="submit" name="submit" class="form-control" value="Ask for Quote">	
      <?php } ?>
    </div>
    </form>
    </div>

    </div>


    </section>



       

<script type="text/javascript">
	 var site_url='<?php echo SITE_URL;?>/';

	 function myfunction(x){
	 var reqid=x.getAttribute('data-req');	
var skillid=x.value;
$(this).data("req");

   


	 	      $.ajax({
       dataType: "html",
            type: "post",
            evalScripts: true,
            url: site_url + 'search/myfunctiondata',
            data: {skill:skillid,reqid:reqid},
       beforeSend: function() {
            $('#clodder').css("display", "block");

      },
      
            success:function(response){

    	var obj = JSON.parse(response);
    	
    	$('#offeramt'+reqid).val(obj.payment_currency);
    	$('#currency'+reqid).val(obj.currency);


            },
       complete: function() {
            $('#clodder').css("display", "none");
      

        },
        error: function(data) {
            alert(JSON.stringify(data));

        }
           
        });




	 }
</script>