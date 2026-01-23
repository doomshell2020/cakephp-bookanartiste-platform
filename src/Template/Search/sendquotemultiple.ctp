
<div id="job-<?php echo $id ?>">
<input type="hidden" value="<?php echo $id ?>" name="job_id[]"/>
<div class="form-group">
    <label for="email"><a href="<?php echo SITE_URL?>/applyjob/<?php echo $requirement_data['id']; ?>" target="_blank"><?php echo $requirement_data['title']; ?></a></label>
    <select class="form-control" name="skill[]" onchange="return myfunction(this)" data-req="<?php echo $id ?>">
<?php  foreach($requirement_data['requirment_vacancy'] as $value){ ?>
<option value="<?php  echo $value['skill']['id'] ?>"><?php  echo $value['skill']['name'] ?></option>
<?php } ?>
</select>
  </div>


<div class="form-group">
    <label for="email">Currency Name</label>
   <input type="text" class="form-control" id="currency<?php echo $id ?>" name="currency[]" readonly value="<?php echo $requirement_data['requirment_vacancy'][0]['currency']['name']  ?>">
  </div>

<div class="form-group">
    <label for="email">Offer Amount</label>
   <input type="text" class="form-control" id="offeramt<?php echo $id ?>"  name="offerecamt[]" readonly value="<?php echo $requirement_data['requirment_vacancy'][0]['payment_amount']  ?>">
  </div>



<div class="form-group">
    <label for="email">Your Quote</label>
   <input type="number" class="form-control" id="email" patten="^[0-9]*$" name="amt[]" required>
  </div>




</div>

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