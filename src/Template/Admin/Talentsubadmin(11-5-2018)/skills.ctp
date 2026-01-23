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
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";

        }
    }
}
	</script>
