<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
<style type="text/css">

#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 12px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}
.swal-button {
    background-color: #0075c5 !important;
    }
.swal-button:active{
  background-color: #0075c5 !important;
}
</style>

<?php 
foreach($skillset as $value){
	$array[]=$value['skill_id'];
}
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



							<input type="checkbox" value="<?php echo $value['id'] ?>" onclick="addskill(this)" class="chk" id="silkk<?php echo $i; ?>" data-skill-type="<?php echo $value['name'] ?>" <?php if(in_array($value['id'],$array)) { echo "checked"; } ?>/><?php echo $value['name'] ?></li>
							<?php $i++; } echo "</ul>"; } else {   echo "No Data Found"; } ?>
						</label>
					</div>

				</div>
			</div>




			<div class="row m-top-20">
				<div class="col-sm-6 text-center">
				<button id="profile_form" type="submit"  data-dismiss="modal" class="btn btn-default" onclick="updateskills()">Update</button>
					<!-- <button id="btn" type="button" onclick="updateskills()" class="btn btn-default">Update Skills</button>
				</div> -->
				<div class="col-sm-6 text-center">
					<button id="myModal" type="button" onclick="cancel(); " class="btn btn-default">Cancel</button>
				</div>
			</div>

			<script>

				function addskill(ele){
					var total_elegible_skills = '<?php echo $total_elegible_skills ?>';
					var fruits = [];
					var other = [];
					$("#error_message").addClass("hide");
					var checked = document.getElementById(ele.id);
					var ckName = document.getElementsByName(ele.name);
					$("input:checkbox[class=chk]").each(function () {
						if($(this).is(":checked")){
							var checkedskills = $('input:checkbox[class=chk]:checked').length;
							if(checkedskills > total_elegible_skills)
							{
		  
		    skill_error = "You can only Select "+total_elegible_skills+" skill categories for your profile"; 
		    $("#skill_error").html(skill_error);
		    $("#error_message").removeClass("hide");
		  // $("#"+ele.id).prop('checked', false);
		//   $(checked).removeAttr('checked');
		checked.checked = false;
		  // return false;
		}
		
		
		for(var i=0; checkedskills > total_elegible_skills; i++){
			if(!ckName[i].checked){
				ckName[i].disabled = true;

			}else{
				ckName[i].disabled = false;

			}
		} 
		fruits.push($(this).val());
		other.push(' '+$(this).attr("data-skill-type"));
	}else{

		for(var i=0; i < ckName.length; i++){
			ckName[i].disabled = false;
		} 
	}
});


					$('#skill').val(fruits);
					$('#skillshow').val(other);
				}

// Update Skills (submitting the form on clicking on update skills)
function updateskills(inputvalue)
{ 
   
	var checkeduserskills = $('input:checkbox[class=chk]:checked').length;
	if(checkeduserskills>0) {
		alert("Skills updated successfully!");
		$("#profile_form").submit();
	}else{
    
//var checkstr= confirm("Are you sure you want to remove all skills. You will loose all your talent rights including Contacts, Right to Search for work and Right to Apply, Send quote etc ?");

var checkstr= confirm("Are you sure you want to convert into Non-Talent profile ? If yes You will loose all your talent rights");


		if(checkstr==true){
			return false;
			$("#profile_form").submit();

		}else{
			location.reload();
			return false;
		}
	}

}



function tets(){
    
    
}

// function cancel()
// {
// 	$("#myModal").modal('hide');
// 	location.reload();
// 	return false;
// }
 function cancel() {
    var confirmCancel = confirm("Are you sure you want to cancel? Any unsaved changes will be lost.");

    if (confirmCancel) {
        $("#myModal").modal('hide');
		window.location.href = '/profile';
    }

    return false;
}
// function confirmm(){
// 	if (window.confirm("Are you sure wants to convert Talent to Non-Talent profile ? If yes you will lose your talent writes")) {
// }else{
// 	location.reload();
// }
// }



/*
    function addskill(ele){
	var total_elegible_skills = '<?php echo $total_elegible_skills ?>';
	var fruits = [];
	var other = [];
	$("#error_message").addClass("hide");
	$("input:checkbox[class=chk]").each(function () {
	    if($(this).is(":checked")){
		var checkedskills = $('input:checkbox[class=chk]:checked').length;
		if(checkedskills > total_elegible_skills)
		{
		   skill_error = "You can only add "+total_elegible_skills+" Skills in your Profile. To increase this limit please upgrade your Profile Package"; 
		   $("#skill_error").html(skill_error);
		   $("#error_message").removeClass("hide");
		   $("#"+ele.id).prop('checked', false);
		   return false;
		}
		else
		{
		    fruits.push($(this).val());
		    other.push(' '+$(this).attr("data-skill-type"));   
		}
	    }else{
	    }
	});
	$('#skill').val(fruits);
	$('#skillshow').val(other);
    }
    */
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

