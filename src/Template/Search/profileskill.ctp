<?php 
foreach($skillset as $value){
	$array[]=$value['skill_id'];
}

//pr($_SESSION['advancejobsearch']);
$myarray=explode(",", $_SESSION['advanceprofiesearchdata']['skill'])
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
<?php if($Skill) { $i=1; foreach($Skill as $value){
 ?>
  <li class=""> 
              <div>
                <label class="radio-inline">
					
					
					
<input type="checkbox" value="<?php echo $value['id'] ?>" onclick="addskill(this)" class="chk" id="silkk<?php echo $i; ?>" data-skill-type="<?php echo $value['name'] ?>" <?php if(in_array($value['id'],$myarray)) { echo "checked"; } ?>/><?php echo $value['name'] ?></li>
<?php $i++; } echo "</ul>"; } else {   echo "No Data Found"; } ?>
</label>
              </div>
           
  </div>
</div>
<script>
    function addskill(ele){
	var total_elegible_skills = '<?php echo $total_elegible_skills ?>';
	var fruits = [];
	var other = [];
	$("#error_message").addClass("hide");
	$("input:checkbox[class=chk]").each(function () {
	    if($(this).is(":checked")){
		var checkedskills = $('input:checkbox[class=chk]:checked').length;
		//if(checkedskills > total_elegible_skills)
		//{
		  // skill_error = "You can only add "+total_elegible_skills+" Skills in your Profile. To increase this limit please upgrade your Profile Package"; 
		 //  $("#skill_error").html(skill_error);
		 //  $("#error_message").removeClass("hide");
		  // $("#"+ele.id).prop('checked', false);
		  // return false;
		//}
		//else
		//{
		    fruits.push($(this).val());
		    other.push(' '+$(this).attr("data-skill-type"));   
		//}
	    }else{
	    }
	});
	$('#skill').val(fruits);
	$('#skillshow').val(other);
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
