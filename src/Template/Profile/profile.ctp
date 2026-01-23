<script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
<link href=https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
<!-- stylis alert box design -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- stylis alert box design -->

<style>
    .input-file-container {
        position: relative;
        display: inline-block;
    }

    .input-file-trigger {
        border: 1px solid #ccc;
        background-color: #f9f9f9;
        padding: 8px 15px;
        cursor: pointer;
        display: block;
        width: 100%;
    }

    #fileInput {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
</style>

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

    .swal-button:active {
        background-color: #0075c5 !important;
    }
</style>

<style>
    .example button {
        float: left;
        background-color: #4E3E55;
        color: white;
        border: none;
        box-shadow: none;
        font-size: 17px;
        font-weight: 500;
        font-weight: 600;
        border-radius: 3px;
        padding: 15px 35px;
        margin: 26px 5px 0 5px;
        cursor: pointer;
    }

    .example button:focus {
        outline: none;
    }

    .example button:hover {
        background-color: #33DE23;
    }

    .example button:active {
        background-color: #81ccee;
    }

    .profile_imgdiv {
        width: 180px;
        position: relative;
    }
</style>

<?php
// pr($profile['city_id']);exit;

foreach ($languageknow as $key => $value) {
    $languagearray[] = $value['language_id'];
    //pr($tes); 
}

foreach ($skillofcontaint as $key => $value) {
    $array[] = $value['skill_id'];
    $array1[] = $value['skill']['name'];
}

?>

<link href="<?php echo SITE_URL; ?>/css/imgareaselect-default.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="<?php echo SITE_URL; ?>/css/jquery.awesome-cropper.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<section id="edit_profile" class="editProfileContainer Personal_tab">
    <div class="container">
        <?php //if($user_check['checkuser']==1) { 
        // pr($profile);exit;
        ?>

        <?php // if(count($skillofcontaint) > 0){ 
        ?>
        <!-- <h2>Edit<span> Profile</span></h2>

        <?php // } 
        ?> -->
        <div class="h_group">
            <?php if ($user_check['role_id'] == NONTALANT_ROLEID) { ?>
                <h2>Non Talent <span>Profile</span></h2>
            <?php  } else { ?>
                <h2>Edit <span>Profile</span></h2>
            <?php } ?>

        </div>

        <?php $purl =  $this->request->here() ?>
        <?php if ($purl == "/bookanartiste/profile") { ?>
            <p class="m-bott-50">Edit and Update your profile. Provide latest, accurate and detailed information</p>
        <?php } else { ?>
            <p class="m-bott-50">Create an impressive profile by providing all your updated information</p>
        <?php } ?>
        <div class="row">

            <?php echo $this->element('editprofile'); ?>

            <div class="tab-content">
                <div class="profile-bg m-top-20">
                    <?php echo $this->Flash->render(); ?>
                    <div id="Personal" class="tab-pane fade in active">
                        <div class="container m-top-60">
                            <?php echo $this->Form->create($profile, array('url' => array('controller' => 'profile', 'action' => 'profile'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'class' => 'form-horizontal', 'id' => 'profile_form', 'autocomplete' => 'off')); ?>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Profile image :</label>
                                <!-- code by rupam sir -->
                                <!-- <div class="col-sm-10 upload-img text-center">
                                    <div class="profile_imgdiv">
                                        <?php if ($profile['social'] == 1) { ?>

                                            <img class="" id="profile_picture" height="128" data-src="default.jpg" data-holder-rendered="true" style="width: 100%; height: 140px;" src="<?php echo $profile['profile_image']; ?>" />

                                        <?php } else if ($profile['profile_image'] != '') { ?>

                                            <img class="" id="profile_picture" height="128" data-src="default.jpg" data-holder-rendered="true" style="width: 100%; height: 140px;" src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile['profile_image']; ?>" />
                                            <div class="deleteProfileBtn">
                                                <div class="pro_new_img"><a href="#" style="display: block;">
                                                        <a href="<?php echo SITE_URL; ?>/profile/removeimage/<?php echo $profile['id']; ?>/<?php echo $profile['profile_image']; ?>" class="input-file-trigger"><i class="fa fa-trash" aria-hidden="true"></i> Remove Image</a>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php } else { ?>

                                            <img class="browseimg" id="profile_picture" height="128" data-src="default.jpg" data-holder-rendered="true" style="width: 100%; height: 140px;" src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                                            <div style="height:50px;">

                                                <div class="pro_new_img"><a href="#" style="display: block;">
                                                        <div class="input-file-container">
                                                            <input id="sample_input" type="hidden" name="profile_image">
                                                            <label tabindex="0" for="my-file" class="input-file-trigger">Upload Image</label>
                                                            <span id="ncpyss" style="display: none; color: red"> Image
                                                                Extension Allow .jpg|.jpeg|.png... Format Only</span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php  } ?>
                                    </div>
                                </div> -->
                                <div class="col-sm-10 upload-img text-center">
                                    <div class="profile_imgdiv">
                                        <?php if ($profile['social'] == 1) { ?>
                                            <img class="" id="profile_picture" height="128" data-src="default.jpg" data-holder-rendered="true" style="width: 100%; height: 140px;" src="<?php echo $profile['profile_image']; ?>" />

                                        <?php } else if ($profile['profile_image'] != '') { ?>
                                            <img class="" id="profile_picture" height="128" data-src="default.jpg" data-holder-rendered="true" style="width: 100%; height: 140px;" src="<?php echo SITE_URL; ?>/profileimages/<?php echo $profile['profile_image']; ?>" />
                                            <div class="deleteProfileBtn">
                                                <div class="pro_new_img"><a href="#" style="display: block;">
                                                        <a href="<?php echo SITE_URL; ?>/profile/removeimage/<?php echo $profile['id']; ?>/<?php echo $profile['profile_image']; ?>" class="input-file-trigger"><i class="fa fa-trash" aria-hidden="true"></i> Remove Image</a>
                                                    </a>
                                                </div>
                                            <?php } else { ?>
                                                <img class="browseimg" id="profile_picture" height="128" data-src="default.jpg" data-holder-rendered="true" style="width: 100%; height: 140px;" src="<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg" />
                                                <div style="height:50px;">
                                                    <div class="pro_new_img">
                                                        <div class="input-file-container">
                                                            <label tabindex="0" class="input-file-trigger" for="fileInput">Upload Image</label>
                                                            <input type="file" name="profile_image" id="fileInput" accept=".jpg, .jpeg, .png" onchange="previewImage(this)">
                                                            <!-- </div> -->
                                                            <span id="ncpyss" style="display: none; color: red;">Image Extension Allow .jpg|.jpeg|.png... Format Only</span>

                                                            <script>
                                                                function validateImage(input) {
                                                                    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
                                                                    if (!allowedExtensions.exec(input.value)) {
                                                                        document.getElementById('ncpyss').style.display = 'block';
                                                                        input.value = '';
                                                                    } else {
                                                                        document.getElementById('ncpyss').style.display = 'none';
                                                                    }
                                                                }
                                                            </script>

                                                        </div>
                                                    </div>
                                                <?php  } ?>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <p class="file-return"></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Member Name :<span class="jobpostrequired">*</span></label>
                                    <div class="col-sm-10">
                                        <?php
                                        echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Member Name', 'id' => 'name', 'required' => true, 'type' => 'text', 'label' => false, 'value' => $profile['user']['user_name'])); ?>
                                    </div>
                                </div>
                                <!-- change the skill code -->
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Skills :</label>
                                    <div class="col-sm-8">
                                        <?php echo $this->Form->input('skillshow', array('class' => 'longinput skillsdata form-control', 'maxlength' => '20', 'placeholder' => 'Skills', 'readonly' => 'readonly', 'label' => false, 'value' => implode(", ", $array1))); ?>
                                        <?php if (empty($array1)) { ?>
                                            <span class="skill-text" style="color:red">If you are creative, select skills you
                                                want to be booked for</span>
                                        <?php } ?>

                                        <!--    <input type="text" class="form-control" placeholder="Skills">-->
                                    </div>
                                    <?php $uid = $this->request->session()->read('Auth.User.id'); ?>
                                    <div class="col-sm-2 text-left p-left-0">
                                        <a type="button" class="skill btn btn-success" data-toggle="modal" data-target="#skillrequirement">ADD Skill</a>
                                        <input type="hidden" id="elegible_category" value="<?php echo  count($array); ?>" />
                                    </div>
                                    <input type="hidden" name="skill" id="skill" value="<?php echo  implode(",", $array); ?>" />

                                    <div class="col-sm-1"></div>
                                </div>
                                <!-- javascript use for add skill and open pop up  -->
                                <script>
                                    $('.skillsdata').click(function(e) {
                                        e.preventDefault();
                                        $('#skillrequirement').modal('show').find('.modal-body');
                                    });
                                </script>

                                <div class="modal fade" id="skillrequirement" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <input id="myInput" onkeyup="myFunction(this)" placeholder="Search from list..." type="text">
                                            <div class="modal-body clearfix" id="skillsetsearch">
                                                <section class="content-header hide" id="error_message">
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                        <p id="skill_error"></p>
                                                    </div>
                                                </section>

                                                <ul id="myUL" class="list-inline form-group col-sm-12 m-ad-req">
                                                    <?php
                                                    $i = 0;
                                                    foreach ($Skill as $value) {
                                                        $isChecked = in_array($value['id'], array_column($skillofcontaint, 'skill_id')) ? 'checked' : '';
                                                    ?>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" name="requirement" value="<?php echo $value['id']; ?>"
                                                                    onclick="addSkill(this)" class="rooms" id="silkk<?php echo $i; ?>"
                                                                    data-skill-type="<?php echo $value['name']; ?>"
                                                                    data-val="<?php echo $value['name']; ?>" <?php echo $isChecked; ?> />
                                                                <?php echo $value['name']; ?>
                                                            </label>
                                                        </li>
                                                    <?php
                                                        $i++;
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <?php
                                // $sitesettings = $this->Comman->sitesettings();
                                $currentUserPackage = $this->Comman->currentprpackv1();
                                $number_skills_limit = $currentUserPackage['number_categories'] ?? 0;
                                ?>

                                <script>
                                    function addSkill(ele) {
                                        const maxSkills = <?php echo json_encode($number_skills_limit); ?>;
                                        const errorMessageElement = document.getElementById('error_message');
                                        const skillErrorElement = document.getElementById('skill_error');
                                        const checkboxes = document.querySelectorAll('input.rooms');
                                        const checkedSkills = document.querySelectorAll('input.rooms:checked').length;

                                        if (checkedSkills > maxSkills) {
                                            // Display error message and uncheck the checkbox
                                            errorMessageElement.classList.remove('hide');
                                            skillErrorElement.textContent = `You can only add ${maxSkills} skills.`;
                                            ele.checked = false;
                                        } else {
                                            // Hide error message
                                            errorMessageElement.classList.add('hide');
                                        }

                                        // Disable unchecked checkboxes if the limit is reached
                                        checkboxes.forEach((checkbox) => {
                                            checkbox.disabled = checkedSkills >= maxSkills && !checkbox.checked;
                                        });

                                        const selectedSkills = [];
                                        const skillTypes = [];

                                        document.querySelectorAll('input.rooms:checked').forEach((checkbox) => {
                                            selectedSkills.push(checkbox.value);
                                            skillTypes.push(` ${checkbox.dataset.skillType}`);
                                        });

                                        document.getElementById('skill').value = selectedSkills.join(',');
                                        document.getElementById('skillshow').value = skillTypes.join(',');
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
                                <!-- end the skill code -->


                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Profile Title :</label>
                                    <div class="col-sm-10">

                                        <?php echo $this->Form->input('profiletitle', array('class' => 'form-control', 'autocomplete' => 'off', 'id' => 'altemail', 'label' => false, 'type' => 'text', 'value' => $profile['user']['profiletitle'])); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Personal E-mail :<span class="jobpostrequired">*</span></label>

                                    <div class="col-sm-10" style="position:relative">
                                        <?php echo $this->Form->email('altemail', array('class' => 'form-control', 'required' => true, 'autocomplete' => 'off', 'id' => 'altemail', 'label' => false, 'type' => 'email', 'value' => $this->request->session()->read('Auth.User.email'), 'readonly' => 'readonly')); ?>
                                        <?php if ($profile['user']['isvarify'] == "Y") { ?>
                                            <i title="Verified Email" class="verified fa fa-check-circle" aria-hidden="true" style="position : absolute; right:25px; top:14px; z-index:9; color: green;"></i>
                                        <?php } ?>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php
                                    // $gen = array('m' => 'Male', 'f' => 'Female', 'o' => 'Other', 'bmf' => 'Male And Female');
                                    $gen = array('m' => 'Male', 'f' => 'Female', 'o' => 'Other');
                                    ?>
                                    <label for="" class="col-sm-2 control-label">Gender :</label>
                                    <div class="col-sm-10">
                                        <?php
                                        echo $this->Form->input('gender', array(
                                            'id' => 'gender',
                                            'type' => 'radio',
                                            'options' => $gen,
                                            'label' => false,
                                            'legend' => false,
                                            'default' => 'm', // Set 'm' (Male) as the default
                                            'required' => true, // Make it a required field
                                            'templates' => ['radioWrapper' => '<label class="radio-inline">{{label}}</label>']
                                        ));
                                        ?>

                                        <div class="question_popupdiv" style="position: absolute;top: 17px;right: 29px;">
                                            <span class="pop-cnt" style="position:relative;">
                                                <a href="javascript:void(0)" data-toggle="popover" data-placement="bottom" data-content="Some content inside the popover">
                                                    <i class="fa fa-question"></i>
                                                </a>
                                            </span>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                $('[data-toggle="popover"]').popover();
                                            });
                                        </script>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?php if ($profile['dob'] != '') { ?>
                                        <label for="" class="col-sm-2 control-label">Date Of Birth :</label>
                                        <div class="col-sm-5">

                                            <?php $dateget = date_format($profile['dob'], 'Y-m-d'); ?>
                                            <?php echo $this->Form->input('dobdate', array('class' => 'form-control', 'placeholder' => 'Date Of Birth', 'type' => 'text', 'id' => 'dobpicker', 'label' => false, 'value' => (!empty($profile['dob'])) ? $dateget : '', 'data-readonly')); ?>
                                        </div>
                                        <label for="" class="col-sm-1 control-label">Age :</label>
                                        <div class="col-sm-4">
                                            <div class="form-control" id="age"></div>
                                            <!-- <input type="text" class="form-control" >-->
                                        </div>
                                    <?php } else { ?>

                                        <label for="" class="col-sm-2 control-label">Date Of Birth :</label>
                                        <div class="col-sm-5">

                                            <?php echo $this->Form->input('dobdate', array('class' => 'form-control', 'placeholder' => 'Date Of Birth', 'type' => 'text', 'id' => 'dobpicker', 'label' => false, 'value' => (!empty($profile['dob'])) ? $dateget : '')); ?>

                                        </div>
                                        <label for="" class="col-sm-1 control-label">Age :</label>
                                        <div class="col-sm-4">
                                            <div class="form-control" id="age"></div>
                                            <!-- <input type="text" class="form-control" >-->
                                        </div>
                                    <?php } ?>
                                    <div class="col-sm-1"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Ethnicity : </label>
                                <div class="col-sm-10">
                                    <?php echo $this->Form->input('ethnicity', array('class' => 'form-control', 'placeholder' => 'State', 'id' => '', 'label' => false, 'empty' => '--Select Ethnicity--', 'options' => $ethnicity, 'selected' => 'selected')); ?>
                                </div>

                            </div>
                            <!-- <div class="form-group">
                          <label for="" class="col-sm-2 control-label">Country:</label>
                          <div class="col-sm-10">
                            <?php // echo $this->Form->input('phonecountry',array('class'=>'form-control','placeholder'=>'Country','label' =>false,'id'=>'country_phone','empty'=>'--Select Country--','options'=>$country)); 
                            ?>
                          </div>
                        </div> -->

                            <!-- <div class="form-group">
                           <label for="" class="col-sm-2 control-label">Phone Code:</label>
                           <div class="col-sm-10">
                             <?php // echo $this->Form->input('phonecode',array('type'=>'select','class'=>'form-control','placeholder'=>'Country','label' =>false,'id'=>'country_phone','empty'=>'--Select Phone Code--','options'=>$cntcode)); 
                                ?>
                            </div>
                          </div> -->

                            <!-- <div class="form-group">
                          <label for="" class="col-sm-2 control-label">Currency:</label>
                          <div class="col-sm-10">
                            <?php //echo $this->Form->input('currency_id',array('class'=>'form-control','placeholder'=>'Currency','label' =>false,'id'=>'currency','empty'=>'--Select Currency--','options'=>$currency)); 
                            ?>
                          </div>
                        </div> -->

                            <div class="form-group">
                                <label for="" class="col-sm-2 col-xs-12 control-label">Fixed Landline Number :</label>

                                <!-- <div class="col-sm-5 col-xs-6">
                              <?php //echo $this->Form->input('phonecode',array('class'=>'form-control phonecode','placeholder'=>'Phone Code','id'=>'phonecode','label' =>false,'type'=>'text','readonly'=>true)); 
                                ?>
                            </div> -->
                                <div class="col-sm-10">
                                    <?php echo $this->Form->input('phone', array('class' => 'form-control', 'placeholder' => 'Write the country code starting with + and multiple phone numbers seperated by comma (,)', 'id' => 'altnumber fixed-lnumber', 'label' => false, 'type' => 'tel', 'onkeypress' => 'return isNumberKey(event)')); ?>
                                </div>
                            </div>




                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Mobile Number :</label>

                                <!--<div class="col-sm-4">
                              <?php //echo $this->Form->input('phonecode',array('class'=>'form-control phonecode','placeholder'=>'Phone Code','id'=>'phonecode','label' =>false,'type'=>'text','readonly'=>true)); 
                                ?>
                              <div class="form-control" id="phonecode"></div>-->
                                <!--    <input type="text" id="phonecode" placeholder="Skills">
                          </div>-->
                                <div class="col-sm-10">
                                    <?php echo $this->Form->input('altnumber', array('class' => 'form-control', 'placeholder' => 'Write the country code starting with + and multiple phone numbers seperated by comma (,)', 'id' => 'altnumber', 'label' => false, 'type' => 'tel', 'onkeypress' => 'return isNumberKey(event)')); ?>
                                    <!-- ,'pattern'=>'^\d{10}$' -->
                                </div>
                            </div>

                            <script>
                                function isNumberKey(evt) {
                                    var charCode = (evt.which) ? evt.which : event.keyCode;
                                    //alert(charCode);
                                    if (charCode > 57)
                                        return false;

                                    return true;
                                }
                            </script>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Language(s) known :</label>
                                <div class="col-sm-10 leng_box languagePicker">
                                    <select id="dates-field2" class="form-control" style="height: auto;" multiple="multiple" name="languageknow[]" size="6">
                                        <option value="" <?php if (empty($languagearray)) { ?> selected <?php } ?>>Select Language</option>
                                        <?php foreach ($lang as $key => $value) { ?>
                                            <option value="<?php echo $value['id']; ?>" <?php if (in_array($value['id'], $languagearray)) { ?> selected <?php } ?>>
                                                <?php echo $value['name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Current Location :</label>
                                <div class="col-sm-10">

                                    <?php echo $this->Form->input('current_location', array('class' => 'longinput form-control', 'placeholder' => 'Location', 'label' => false, 'id' => 'pac-inputss')); ?>
                                    <!-- <input id="pac-input" type="text" class="form-control" placeholder="Location" required  value=""name="location">-->
                                    <div id="map"></div>
                                    <?php echo $this->Form->input('current_lat', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'latitudecurrent', 'label' => false)); ?>
                                    <?php echo $this->Form->input('current_long', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'longitudecurrent', 'label' => false)); ?>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">From Location :</label>
                                <div class="col-sm-10">

                                    <?php echo $this->Form->input('location', array('class' =>
                                    'longinput form-control', 'placeholder' => 'Location', 'label' => false, 'id' => 'pac-input')); ?>
                                    <!-- <input id="pac-input" type="text" class="form-control" placeholder="Location" required  value=""name="location">-->
                                    <div id="map"></div>
                                    <?php echo $this->Form->input('lat', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'latitude', 'label' => false)); ?>
                                    <?php echo $this->Form->input('longs', array('class' => 'form-control', 'type' => 'hidden', 'id' => 'longitude', 'label' => false)); ?>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Address location:</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-4">
                                            <?php echo $this->Form->input('country_ids', array('class' => 'form-control', 'placeholder' => 'Country', 'id' => 'country_ids', 'label' => false, 'empty' => '--Select Country--', 'options' => $country)); ?>

                                        </div>
                                        <div class="col-sm-4 col-xs-4">
                                            <?php
                                            echo $this->Form->input('state_id', array(
                                                'class' => 'form-control',
                                                'placeholder' => 'State',
                                                // 'required' => true,
                                                'id' => 'state',
                                                'label' => false,
                                                'empty' => '--Select State--',
                                                'options' => $states,
                                                'default' => $profile['state_id'] ?? null
                                            ));
                                            ?>
                                        </div>
                                        <div class="col-sm-4 col-xs-4">
                                            <?php
                                            echo $this->Form->input('city_id', array(
                                                'class' => 'form-control',
                                                'placeholder' => 'City',
                                                // 'required' => true,
                                                'id' => 'city',
                                                'label' => false,
                                                'empty' => '--Select City--',
                                                'options' => $cities ?? null,
                                                'default' => 448
                                            ));
                                            ?>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Skype id :</label>
                                <div class="col-sm-10">
                                    <?php echo $this->Form->input('skypeid', array('class' => 'form-control', 'placeholder' => 'Skype id', 'id' => 'skypeid', 'label' => false, 'type' => 'text', 'pattern' => '[a-zA-Z]*')); ?>

                                </div>

                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Alternate E-mail :</label>
                                <div class="col-sm-10">
                                    <?php echo $this->Form->email('altemail', array('class' => 'form-control', 'placeholder' => 'Alternate Email', 'autocomplete' => 'off', 'id' => 'altemail', 'label' => false, 'type' => 'email', 'multiple' => true)); ?>
                                    <span id="dividhere" style="display:none;color:red;">Email Already Exist</span>
                                </div>

                            </div>
                            <script>
                                function myFunction() {
                                    var x = document.getElementById("altemail").multiple;
                                }
                            </script>



                            <!--<div class="form-group">
                          <label for="" class="col-sm-2 control-label">Alternate Mobile :</label>
                          <div class="col-sm-9">
                            <?php //echo $this->Form->input('altnumber',array('class'=>'form-control','placeholder'=>'Alternate Number', 'id'=>'altnumber','label' =>false,'type'=>'tel','pattern'=>'^\d{10}$')); 
                            ?>
                          </div>
                          <div class="col-sm-1"></div>
                        </div>-->


                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label">Alternate Skype id :</label>
                                <div class="col-sm-10">
                                    <?php echo $this->Form->input('altskypeid', array('class' => 'form-control', 'placeholder' => 'Alternate Skype id', 'id' => 'altskypeid', 'label' => false, 'type' => 'text', 'pattern' => '[a-zA-Z,0-9]*', 'multiple' => true)); ?>

                                </div>

                            </div>
                            <script>
                                function myFunction() {
                                    var x = document.getElementById("altskypeid").multiple;
                                }
                            </script>

                            <div id="ncpy" style="display: none;">
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Guardian Name :</label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('guadian_name', array('class' => 'form-control', 'placeholder' => 'Guardian Name', 'id' => 'guardianname', 'label' => false, 'type' => 'text')); ?>

                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Guardian Email Address :</label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('guardian_email', array('class' => 'form-control', 'placeholder' => 'Guardian Email Address', 'id' => 'guardianemail', 'label' => false, 'type' => 'email')); ?>
                                        <span id="dividhere" style="display:none;color:red;">Email Already Exist</span>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label">Guardian Phone Number:</label>
                                    <div class="col-sm-10">
                                        <?php echo $this->Form->input('guardian_phone', array('class' => 'form-control', 'placeholder' => 'Guardian Phone Number', 'id' => 'guardianphone', 'label' => false, 'type' => 'tel', 'pattern' => '^\d{10}$')); ?>

                                    </div>

                                </div>
                                <?php /*
                            <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Guardian Password :</label>
                            <div class="col-sm-4">
                            <?php echo $this->Form->input('guardianpassword',array('class'=>'form-control','placeholder'=>'Password','maxlength'=>'11','type'=>'password','autocomplete'=>'off','id'=>'p1','label' =>false)); ?>
                            <!--<div class="form-control" id="phonecode"></div>-->
                            <!--    <input type="text" id="phonecode" placeholder="Skills">-->
                        </div>
                        <div class="col-sm-5">
                            <input type="password" name="guardianconfirmpassword" class="form-control" id="registration"
                                placeholder="Confirm Password"
                                onfocus="validatePass(document.getElementById('p1'), this);"
                                oninput="validatePass(document.getElementById('p1'), this);">
                        </div>
                    </div>
                    */ ?>
                            </div>


                            <?php if ($user_check['checkuser'] == 0) { ?>
                                <div class="form-group">
                                    <div class="col-sm-11">
                                        <label>
                                            <input type="checkbox" required> Please agree with <a href="<?php echo SITE_URL; ?>/termsandconditions" target="_blank">Terms and
                                                Conditions</a> to proceed
                                        </label>
                                    </div>
                                    <div class="col-sm-1"></div>
                                </div>
                            <?php } ?>



                            <div class="d-flex justify-content-center p" style="text-align: center;">
                                <button id="btn" type="submit" class="btn btn-default mr" onclick='this.form.action="profile/profile/<?php echo $uid; ?>/save";'>Save</button>
                                <button id="btn" type="submit" class="btn btn-default mr" onclick='this.form.action="profile/profile/<?php echo $uid; ?>/submit";'>Submit</button>
                            </div>
                            <!-- <div class="form-group">
                    <div class="col-sm-4 text-left">
                        <button id="btn" type="submit" class="btn btn-default"
                            onclick='this.form.action="profile/profile/<?php //echo $uid; 
                                                                        ?>/save";'>Save</button>
                    </div>
                    <div class="col-sm-4 text-center">

                    </div>
                    <div class="col-sm-4 text-right">
                        <button id="btn" type="submit" class="btn btn-default"
                            onclick='this.form.action="profile/profile/<?php //echo $uid; 
                                                                        ?>/submit";'>Submit</button>
                    </div>
                </div> -->
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function myFunction(inputElement) {
        var filter = inputElement.value.toUpperCase();

        var skillsetContainer = document.getElementById("skillsetsearch");
        var ul = document.getElementById("myUL");
        var li = ul.getElementsByTagName("li");

        for (var i = 0; i < li.length; i++) {
            var label = li[i].getElementsByTagName("label")[0];
            var skillName = label.textContent || label.innerText;

            if (skillName.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
</script>

<script>
    $(document).ready(function() { //alert();
        $('#guardianemail').change(function() { //alert();
            var guardian = $('#guardianemail').val();
            //alert(username);
            $.ajax({
                type: 'POST',
                url: '<?php echo SITE_URL; ?>/profile/find_username',
                data: {
                    'username': guardian
                },
                success: function(data) {
                    if (data > 0) {
                        $('#guardianemail').val('');
                        $('#dividhere').show();
                    } else {
                        $('#dividhere').hide();
                    }
                },
            });
        });
    });

    function validatePass(p1, p2) {

        if (p1.value != p2.value) {

            p2.setCustomValidity('Password incorrect');

        } else {

            p2.setCustomValidity('');

        }
    }
</script>

<script>
    $('#dobpicker').datepicker({ //alert();
        onSelect: function(value, ui) {
            calculatedate(value);
        },
        dateFormat: 'yy-mm-dd',
        maxDate: '+0d',
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+0",
        defaultDate: '-18yr',
    });
    $('.ui-datepicker').addClass('notranslate');

    function calculatedate(dob) { //alert(date);
        //dob='1988-04-07';
        dob = new Date(dob);
        var today = new Date();
        var age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
        //	age = today.getFullYear() - date;
        if (age < 18) {
            var guardianvalue = $("#guardianemail").val();

            $("#ncpy").css("display", "block");
            if (guardianvalue == '') {
                swal("Please Fill Your Guardian Name, Guardian Email, Guardian Number");
            }
            $('#guardianname').attr('required', 'required');
            $('#guardianemail').attr('required', 'required');
            $('#guardianphone').attr('required', 'required');

        } else {
            $("#ncpy").css("display", "none");
            $("#guardianname").val('');
            $("#guardianemail").val('');
            $("#guardianphone").val('');
            $('#guardianname').removeAttr('required');
            $('#guardianemail').removeAttr('required');
            $('#guardianphone').removeAttr('required');
        }

        if (age) {
            $('#age').text(age);
            $('#age').html(age + ' years');

        }

    }
    bdate = '<?php echo $dateget; ?>';
    calculatedate(bdate);
</script>

<!-- <script>
    $('.skill').click(function(e) {
        e.preventDefault();
        $('#myModal').modal('show').find('.modal-body').load($(this).attr('href'));
    });
</script> -->

<script type="text/javascript">
    $(document).ready(function() {
        $("#country_phone").on('change', function() {
            var id = $(this).val();
            $("#phonecode").find('option').remove();
            if (id) {
                var dataString = 'id=' + id;
                $.ajax({
                    type: "POST",
                    url: '<?php echo SITE_URL; ?>/profile/getphonecode',
                    data: dataString,
                    cache: false,
                    success: function(html) {
                        $.each(html, function(key, value) {
                            //$('<option>').val(key).text(value).appendTo($("#phonecode"));
                            $('.phonecode').val(value);
                            //$('#phonecode').html('+'+value);
                            //$('#phonecode').html('+'+value);
                        });
                    }
                });
            }
        });
    });
</script>

<!-- country state and city  -->
<script type="text/javascript">
    $(document).ready(function() {
        var defaultCountryId = parseInt('<?= $profile['country_ids'] ?? 101; ?>', 10); // Ensure integer value
        var defaultStateId = <?= isset($profile['state_id']) ? (int)$profile['state_id'] : null; ?>;
        var defaultCityId = <?= isset($profile['city_id']) ? (int)$profile['city_id'] : null; ?>;

        console.log('>>>>>>>>>>>>', defaultCountryId, defaultStateId, defaultCityId);


        // Function to populate states based on the country ID
        function loadStates(countryId) {
            $("#state").find('option').remove();
            $("#city").find('option').remove();
            if (countryId) {
                var dataString = 'id=' + countryId;
                $.ajax({
                    type: "POST",
                    url: '<?php echo SITE_URL; ?>/profile/getStates',
                    data: dataString,
                    cache: false,
                    success: function(html) {
                        $('<option>').val('0').text('--Select State--').appendTo($("#state"));
                        $('<option>').val('0').text('--Select City--').appendTo($("#city"));
                        $.each(html, function(key, value) {
                            $('<option>').val(key).text(value).appendTo($("#state"));
                        });

                        // Pre-select the default state if available
                        if (defaultStateId) {
                            $("#state").val(defaultStateId).trigger('change');
                            loadCities(defaultStateId); // Load cities for the default state
                        }
                    }
                });
            }
        }

        // Function to populate cities based on the state ID
        function loadCities(stateId) {
            $("#city").find('option').remove();
            if (stateId) {
                var dataString = 'id=' + stateId;
                $.ajax({
                    type: "POST",
                    url: '<?php echo SITE_URL; ?>/profile/getcities',
                    data: dataString,
                    cache: false,
                    success: function(html) {
                        $('<option>').val('0').text('--Select City--').appendTo($("#city"));
                        $.each(html, function(key, value) {
                            $('<option>').val(key).text(value).appendTo($("#city"));
                        });
                        console.log('>>>>>>>>>>>>>>>>>>>', defaultCityId);

                        // Ensure defaultCityId is checked properly
                        if (defaultCityId !== null && defaultCityId !== undefined) {
                            $("#city").val(defaultCityId);
                        }
                    }
                });
            }
        }

        // Set default country and load states
        $("#country_ids").val(defaultCountryId).trigger('change');
        loadStates(defaultCountryId);

        // On country change, load states
        $("#country_ids").on('change', function() {
            var id = $(this).val();
            defaultStateId = null; // Reset defaultStateId on country change
            defaultCityId = null; // Reset defaultCityId on country change
            loadStates(id);
        });

        // On state change, load cities
        $("#state").on('change', function() {
            var id = $(this).val();
            defaultCityId = null; // Reset defaultCityId on state change
            loadCities(id);
        });

    });
</script>


<!-- <script>
$('#dates-field2').change(function(e) {
    e.preventDefault();
    var selectedOptions = $('#dates-field2 option:selected');
    // alert(selectedOptions.length);
    if (selectedOptions.length >= 7) {
                // Disable all other checkboxes.
                var nonSelectedOptions = $('#dates-field2 option').filter(function() {
                    return !$(this).is(':selected');
                });

                nonSelectedOptions.each(function() { 
                    var input = $('input[value=' + $(this).val() + ']');
                    // alert(input);
                    input.attr('disabled', true);
                    input.parent('li').addClass('disabled');
                });
            } else {
                // Enable all checkboxes.
                $('#dates-field2 option').each(function() { //alert('testing');
                    // alert($(this).val())
                    var input = $('input[value="' + $(this).val() + '"]');
                    // alert(input.prop())
                    input.attr('disabled', false);
                    input.parent('li').addClass('disabled');
                });
            }

})
    </script> -->
<!-- <script type="text/javascript">
$(document).ready(function() {
    $('.multiselect-ui').multiselect({
        onChange: function(option, checked) {
            // Get selected options.
            var selectedOptions = $('.multiselect-ui option:selected');
            // alert(selectedOptions.length);
            if (selectedOptions.length >= 7) {
                // Disable all other checkboxes.
                var nonSelectedOptions = $('.multiselect-ui option').filter(function() {
                    return !$(this).is(':selected');
                });

                nonSelectedOptions.each(function() { //alert('test');
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', true);
                    input.parent('li').addClass('disabled');
                });
            } else {
                // Enable all checkboxes.
                $('.multiselect-ui option').each(function() { //alert('testing');
                    var input = $('input[value="' + $(this).val() + '"]');
                    input.prop('disabled', false);
                    input.parent('li').addClass('disabled');
                });
            }
        }
    });
});
</script> -->
<!-- code by rupam sir -->
<!-- <script type="text/javascript">
    function fileValidation() {

        var fileInput = document.getElementById('file');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
        //alert(allowedExtensions);
        if (!allowedExtensions.exec(filePath)) {
            $("#ncpyss").css("display", "block");
            fileInput.value = '';
            return false;
        } else {
            //Image preview
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').innerHTML = '<img src="' + e.target.result + '"/>';
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    }
</script> -->
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#profile_picture').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Function to validate file extension
    function fileValidation() {
        var fileInput = document.getElementById('file');
        var filePath = fileInput.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
        if (!allowedExtensions.exec(filePath)) {
            $('#ncpyss').show();
            fileInput.value = '';
            $('#profile_picture').attr('src', '<?php echo SITE_URL; ?>/images/edit-pro-img-upload.jpg');
            return false;
        } else {
            $('#ncpyss').hide();
        }
    }
</script>

<script src="<?php echo SITE_URL; ?>/js/jquery.imgareaselect.js"></script>
<script src="<?php echo SITE_URL; ?>/js/jquery.awesome-cropper.js"></script>

<script>
    $(document).ready(function() {

        $('#sample_input').awesomeCropper({
                width: 150,
                height: 150,
                debug: true
            }

        );

    });
</script>

<script>
    var somethingChanged = false;
    $(document).ready(function() {
        $("form :input").change(function() {
            if ($(this).closest('form').data('changed')) {
                // console.log("change value");
            } else {
                // console.log("valuenot change");
            }
        });
        //$('#Personal.input').change(function() { 
        //   somethingChanged = true; 
        //  console.log("Hello world!");
        //  }); 
    });
</script>

<?php
/*
// pr();exit;
if ($datapackage == '1') { ?>
    <script>
        let PackName = '<?php echo $packName; ?>'
        console.log("🚀 ~ file: profile.ctp:828 ~ PackName:", PackName)
        swal(`${PackName} Profile package has been expired renew your package`);
    </script>
<?php } */ ?>

<script type="text/javascript">
    /*
$(document).ready(function(){ //alert('test');
 $('.editprofilechecker').click(function(e){ 
  e.preventDefault();
   $('#pop_msg_tab').modal('show');
});
});
*/
</script>
<div id="pop_msg_tab" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <p>Do you want to leave this page? Changes that you made may not be saved.</p>
            </div>
        </div>
    </div>
</div>
<style>
    input[data-readonly] {
        pointer-events: none;
    }
</style>


<script>
    var $form = $('form'),
        origForm = $form.serialize();
    // $('.popcheckconfirm').on('click', function() {
    //     if ($form.serialize() !== origForm) {
    //         var result = confirm('Do you want to leave this page? Changes that you made may not be saved');
    //         if (result) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     }
    // });
</script>