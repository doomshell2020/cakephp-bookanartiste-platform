<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
<style type="text/css">
#skillsetsearch #myUL li{ 
  float:left; 
  width:33%;
}

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
<script>
function addskill(ele){
var fruits = [];
var other = [];

$("input:checkbox[class=chk]").each(function () {
          if($(this).is(":checked")){
             fruits.push($(this).val());
             other.push(' '+$(this).attr("data-skill-type"));   
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
