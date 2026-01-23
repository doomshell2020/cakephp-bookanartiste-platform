<?php 
foreach($Eventtype as $value){
	//pr($value);
	$array[]=$value['skill_id'];
}
$myarray=explode(",", $_SESSION['advancejobsearch']['eventshow']);

?>
<div class="">										
<section class="content-header hide" id="error_message">
    <div class="alert alert-danger alert-dismissible">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <p id="skill_error"></p>
    </div>
</section>
  <div class="table-responsive">  
<ul id="myUL"  class="list-inline form-group col-sm-12">
<?php if($Eventtype) { 
	$i=1; foreach($Eventtype as $key=> $value){ 
 ?>
  <li class=""> 
              <div>
                <label class="radio-inline">
					
					
					
<input type="checkbox" value="<?php echo $key; ?>" onclick="addskill(this)" class="chk" id="silkk<?php echo $i; ?>" data-skill-type="<?php echo $value ?>" <?php if(in_array($value,array_values($myarray))) { echo "checked"; } ?> ><?php echo $value; ?></li>
<?php $i++; } echo "</ul>";

 } else {   echo "No Data Found"; } ?>
</label>
              </div>
           
  </div>
</div>
<script>
    function addskill(ele){
	
	var fruits = [];
	var other = [];
//	$("#error_message").addClass("hide");
	$("input:checkbox[class=chk]").each(function () {
	    if($(this).is(":checked")){
	    	console.log($(this).val());
		var checkedskills = $('input:checkbox[class=chk]:checked').length;

		    fruits.push($(this).val());
		    other.push(' '+$(this).attr("data-skill-type"));   

	    }else{
	    }
	});
	$('#event').val(fruits);
	$('#eventshow').val(other);
    }
</script>
<script>
function myFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("label")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";

        }
    }
}
	</script>
