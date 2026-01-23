<?php
namespace App\Controller;

use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use brain\brain;
use brain\Exception;
use Cake\Routing\Router;
use Cake\Log\Log;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
class ProfileController extends AppController{
	public function initialize()
	{
	    parent::initialize();
	  //  $this->Auth->allow(['index', 'getStates', 'getcities', 'reportspam', 'reportprofile','viewprofile','viewvitalstatistics','viewprofessionalsummary','viewperformance','viewgalleries','viewimages','viewaudios','viewvideos','viewschedule']);
	}
	 public function viewrating($job_review)
    {
		$this->loadModel('Review');
	$current_user_id = $this->request->session()->read('Auth.User.id');
	
	$review = $this->Review->find('all')->contain(['Requirement'])->where(['Review.id' => $job_review])->toarray();
	$this->set('review', $review);
  
    
    }
	
	
	 public function calendar()
    {

    }
	
	
	public function calendarinformation()
    {
		$this->autoRender=false;
		$eventListHTML = '';
		$type = $this->request->data['fun_type'];
		$informationdate = $this->request->data['date'];
	//$currentDate = $date_Year.'-'.$date_Month.'-'.$dayCount;
		$currentdate=date('Y-m-d');
	$this->loadModel('Calendar');
	
	$conn = ConnectionManager::get('default');
						$frnds = "SELECT from_date,title FROM calendar WHERE `user_id` ='".$_SESSION['Auth']['User']['id']."' and   STR_TO_DATE(`from_date`,'%Y-%m-%d')  = '".$informationdate."'";
						$onlines = $conn->execute($frnds);	
						$event = $onlines ->fetchAll('assoc');
	
	//$event = $this->Calendar->find('all')->where(['Calendar.from_date' => $informationdate])->toarray();
	$events = count($event);
if($events > 0){
		$eventListHTML .= '<div class="modal-content">';
		$eventListHTML .= '<span class="close"><a href="#" onclick="close_popup("event_list")">×</a></span>';
		$eventListHTML .= '<h2>Events on '.date("l, d M Y",strtotime($informationdate)).'</h2>';
		$eventListHTML .= '<ul>';
		foreach($event as $eventrec){ 
			//pr($eventrec);
            $eventListHTML .= '<li>'.$eventrec['title'].'</li>';
        }
		$eventListHTML .= '</ul>';
		$eventListHTML .= '</div>';
	}
	echo $eventListHTML;
    }
	public function viewpersonalpage()
    {
	$id = $this->request->session()->read('Auth.User.id');
	$this->loadModel('PersonalPage');
	$viewpage = $this->PersonalPage->find('all')->where(['user_id' => $id])->first();
    $this->set('viewpage', $viewpage);
}
public function findUsername($username = null)
	{
		$this->loadModel('Users');
		$username=$this->request->data['username'];
		echo $username;
		$user = $this->Users->find('all')->where(['Users.guardianemailaddress' =>$username])->toArray();
		pr($user);
		echo $user[0]['id'];
		die;
	}

public function tabget()
    {
		$name = $this->request->data['action'];
		header('Content-Type: application/json');
		echo json_encode($name);
		exit();

	}

public function search($id)
    {
    $name = $this->request->data['name'];

     $tab = $this->request->data['tab'];
    
	  if($id > 0)
	    {
		$id = $id;
	    }
	    else
	    {
		$id = $this->request->session()->read('Auth.User.id');
	    }
	    
	    $current_user_id = $this->request->session()->read('Auth.User.id'); 
	if($tab=='contacts'){
    if(!empty($name))
	    {
		$res	= "p.name LIKE '%$name%'";
	    }	
    	$conn = ConnectionManager::get('default');
	    $frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='".$id."' and c.accepted_status='Y' and $res UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y' and $res";
	    $friends = $conn->execute($frnds);
	    $this->set('friends', $friends);
    }
   if($tab=='mutual'){
    if(!empty($name))
	    {
		$res	= "p.name LIKE '%$name%'";
	    }	
    	$conn = ConnectionManager::get('default');
	    $frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='".$current_user_id."' and c.accepted_status='Y' and $res UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$current_user_id."' and c.accepted_status='Y' and $res and p.user_id IN (SELECT p.user_id FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT p.user_id FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y')";
	    $friends = $conn->execute($frnds);
	    $this->set('friends', $friends);
    }
    
    
    
     if($tab=='online'){
    if(!empty($name))
	    {
		$res	= "p.name LIKE '%$name%'";
	    }	
    	$conn = ConnectionManager::get('default');
	    $frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location, u.last_login FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='".$id."' and c.accepted_status='Y' and $res and TIMESTAMPDIFF(MINUTE,u.last_login,NOW()) < 5 UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location,u.last_login FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y' and $res and TIMESTAMPDIFF(MINUTE,u.last_login,NOW()) < 5";
	    $friends = $conn->execute($frnds);
	    $this->set('friends', $friends);
    }
    
    
    if($tab=='following'){
    if(!empty($name))
	    {
		$res	= "p.name LIKE '%$name%'";
	    }	
    	$conn = ConnectionManager::get('default');
	    $frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location, u.last_login FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='".$id."' and c.accepted_status='N' and $res";
	    $friends = $conn->execute($frnds);
	    $this->set('friends', $friends);
    }
    
    
    if($tab=='followers'){
    if(!empty($name))
	    {
		$res	= "p.name LIKE '%$name%'";
	    }	
    	$conn = ConnectionManager::get('default');
	    $frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location,u.last_login FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='N' and $res";
	    $friends = $conn->execute($frnds);
	    $this->set('friends', $friends);
    }
    
    
    
    
    
    
    
    
    
}
public function imagecrop()
    {

    }

			public function personalpage()
			{
				$id = $this->request->session()->read('Auth.User.id');
				$this->loadModel('PersonalPage');
				$profiled = $this->PersonalPage->find('all')->where(['user_id' => $id])->first();
				$idcheck = count($profiled);
					if ($idcheck > 0)
					{
						$pagepersonal = $this->PersonalPage->find('all')->first();
					}
					else
					{
						$pagepersonal = $this->PersonalPage->newEntity();
					}
				$this->set('pagepersonal', $pagepersonal);
				if ($this->request->is(['post', 'put']))
				{ 
					//pr($this->request->data); die;
					$this->request->data['user_id']= $id;
					$pagepersonals = $this->PersonalPage->patchEntity($pagepersonal, $this->request->data);
					$savedprofile = $this->PersonalPage->save($pagepersonals);

					if ($savedprofile)
					{
						$this->Flash->success(__('Saved Successfully'));
						return $this->redirect(['action' => 'personalpage']);
					}
				}
			}

	public function allcontacts($id)
	{
	    $this->loadModel('Audio');
	    $this->loadModel('Users');
	    $this->loadModel('Enthicity');
	    $this->loadModel('City');
	    $this->loadModel('State');
	    $this->loadModel('Country');
	    if($id > 0)
	    {
		$id = $id;
	    }
	    else
	    {
		$id = $this->request->session()->read('Auth.User.id');
	    }
	    
	    $current_user_id = $this->request->session()->read('Auth.User.id');
    //echo $current_user_id; die;
	    $profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	    $this->set('profile', $profile);
	    $videoprofile = $this->Audio->find('all')->where(['user_id' => $id])->toarray();
	    $this->set('videoprofile', $videoprofile);
	    $userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
	    $session = $this->request->session();
	    $session->write('usercheck', $userpack_check);
	    $this->set('user_check', $userpack_check);


		//contacts
	    $conn = ConnectionManager::get('default');
	    $frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";
	    $friends = $conn->execute($frnds);
	    $this->set('friends', $friends);
    		//mutual friends
	    $conn = ConnectionManager::get('default');
	    //$mutual = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";
	    
	    
	    $mutual = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='".$current_user_id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$current_user_id."' and c.accepted_status='Y' and p.user_id IN (SELECT p.user_id FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT p.user_id FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y')";
	    
	    $mutualfrnd = $conn->execute($mutual);
	    $this->set('mutualfrnd', $mutualfrnd);
	     
	    // Online friends
	    $conn = ConnectionManager::get('default');
	    $online_qry = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location, u.last_login FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='".$id."' and c.accepted_status='Y' and TIMESTAMPDIFF(MINUTE,u.last_login,NOW()) < 5 UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location,u.last_login FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y' and TIMESTAMPDIFF(MINUTE,u.last_login,NOW()) < 5";
	   	   
	   
	   // echo $online_qry; die;
	    $onlines = $conn->execute($online_qry);
	    $onlines = $onlines ->fetchAll('assoc');
	    $this->set('onlines', $onlines);
	    
	    
	    // friends following
	    $conn = ConnectionManager::get('default');
	    $following= "SELECT c.*, p.user_id, p.name, p.profile_image, p.location, u.last_login FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='".$id."' and c.accepted_status='N'";
	    $follower = $conn->execute($following);
	    $following = $follower->fetchAll('assoc');   
	    $this->set('following', $following);
	    
	   
	    // friends followers
	    $id = $this->request->session()->read('Auth.User.id');
	    $conn = ConnectionManager::get('default');
	    $follow = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location,u.last_login FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='N'";
	    $followers = $conn->execute($follow);
	    $followerd = $followers ->fetchAll('assoc');
	    $this->set('followerd', $followerd);
	   
	}
  
	public function deleteuser()
    {
		//pr($this->request->data); die;
		$this->autoRender=false;
		$users= TableRegistry::get('Contactrequest');
		$status="Y";
		$con = ConnectionManager::get('default');
		$id = $this->request->session()->read('Auth.User.id');
		$detail = 'UPDATE `contactrequest` SET `deletestatus` ="'.$status.'" WHERE `contactrequest`.`id` = '.$this->request->data['profile'];
		$results = $con->execute($detail);
	}
	
	public function confirmuser()
	{
	    //pr($this->request->data); die;
	    $this->autoRender=false;
	    $users= TableRegistry::get('Contactrequest');
	    $status="Y";
	    $con = ConnectionManager::get('default');
	    $id = $this->request->session()->read('Auth.User.id');
	    $detail = 'UPDATE `contactrequest` SET `accepted_status` ="'.$status.'" WHERE `contactrequest`.`id` = '.$this->request->data['profile'];
	    $results = $con->execute($detail);
	}
	
	public function checknotification()
	{
	    $this->autoRender=false;
	    $users= TableRegistry::get('Contactrequest');
	    $status="Y";
	    $con = ConnectionManager::get('default');
	    $id = $this->request->session()->read('Auth.User.id');
	    $detail = 'UPDATE `contactrequest` SET `viewedstatus` ="'.$status.'" WHERE `contactrequest`.`to_id` = '. $id;
	    $results = $con->execute($detail);
	}
	
	// Contact Request
	public function contactrequest()
	{
	    $error = '';
	    $rstatus = '';
	    $this->autoRender=false;
	    $this->loadModel('Contactrequest');
	    $id = $this->request->session()->read('Auth.User.id');
	    $this->request->data['to_id'] = $this->request->data['profile'];
	    $this->request->data['from_id'] = $id;
	    $contactrequest = 
	    $this->Contactrequest->find('all')->where(['Contactrequest.from_id'=>$id, 'Contactrequest.to_id'=>$this->request->data['profile']])->count();
	    //pr($contactrequest);
	    $this->set('contactrequest', $contactrequest);
	    if($contactrequest > 0)
	    {
		$this->Contactrequest->deleteAll(['Contactrequest.to_id'=>$this->request->data['profile'], 'Contactrequest.from_id'=>$id]);
		$error = 'Contact Request Cancelled.';
		$rstatus = 0;
	    }
	    else
	    {
		$userrequest = $this->Contactrequest->newEntity();
		$user_req = $this->Contactrequest->patchEntity($userrequest, $this->request->data);
		if ($this->Contactrequest->save($user_req))
		{
		    $rstatus = 1;
		}
	    }
	    $response['error']= $error;
	    $response['status']=$rstatus;
	    echo json_encode($response); die;
	    die;
	}
	
	// Show contact information and Update Profile Visit counter
	public function profilecounter()
	{
	    $this->loadModel('Requirement');
	    $this->loadModel('Users');
	    $this->loadModel('JobQuote');
	    $this->loadModel('JobApplication');
	    $this->autoRender=false;
	    $error = '';
	    $current_user_id = $this->request->session()->read('Auth.User.id');
	    $current_user = $this->Users->find('all')->where(['Users.id'=>$current_user_id])->first(); 
	    $profile_id = $this->request->data['data'];
	    $role_id = $current_user['role_id'];
	    if($role_id==TALANT_ROLEID)
	    {
		$show_contactinfo = 1;	
	    }
	    else if($role_id==NONTALANT_ROLEID)
	    {
		$job_quotes = 0;
		$jobapplication = 0;
		$requirementfeatured = $this->Requirement->find('list')->contain([])->where(['Requirement.user_id'=>$current_user_id])->order(['Requirement.id' => 'DESC'])->toarray();
		$this->set('requirementfeatured', $requirementfeatured);
		foreach($requirementfeatured as $jobkey=>$value)
		{
		    $job_array[] = $jobkey;
		}
		if(count($job_array)>0)
		{
		    //$jobposts = 
		    $job_quotes = $this->JobQuote->find('all')->where(['JobQuote.job_id IN'=>$job_array,'JobQuote.user_id'=>$profile_id])->count();
		    $jobapplication = $this->JobApplication->find('all')->where(['JobApplication.job_id IN'=>$job_array,'JobApplication.user_id' => $profile_id])->count();
		}
		if($job_quotes > 0 || $jobapplication > 0)
		{
		    $show_contactinfo = 1;	
		}
		else
		{
		    $show_contactinfo = 0;
		    $error = 'You are not authorized to access the contact details of this user.';
		}
	    }
	    else
	    {
		$show_contactinfo = 0;
	    }
	    
	    if($show_contactinfo=='1')
	    {
		$this->loadModel('Profilecounter');
		$count = $this->Profilecounter->find('all')->where(['Profilecounter.user_id' => $current_user_id,'Profilecounter.profile_id' => $this->request->data['data']])->first();
		if($count==0 && $current_user_id !=$this->request->data['data'])
		{
		$this->request->data['user_id']=$current_user_id;
		$this->request->data['profile_id']=$this->request->data['data'];
		$options = $this->Profilecounter->newEntity();
		$option_arr = $this->Profilecounter->patchEntity($options, $this->request->data);
		$savedata = $this->Profilecounter->save($option_arr);
		}
		$users= TableRegistry::get('Profilecounter');
		$counteradd= 'counter + 1';
		$con = ConnectionManager::get('default');
		$detail = 'UPDATE `profilecounter` SET `counter` ='.$counteradd.' WHERE `profilecounter`.`profile_id` = ' . $this->request->data['data'];
		$results = $con->execute($detail);
	    }
	    $response['error']= $error;
	    $response['status']=$show_contactinfo;
	    echo json_encode($response); die;
	}
	
	
	
	public function editableprofile()
	
    {
		
				$this->autoRender = false;
				$model = $this->request->data['model'];
				$id = $this->request->data['pk'];
				$value = $this->request->data['value'];
				$field = $this->request->data['name'];
                $Pack = $this->$model->get($id);
                $Pack->$field = $value;
				$this->$model->save($Pack);
				
    }
	
	
		public function resizeImage($image, $width, $height, $scale)
		{
			$newImageWidth = ceil($width * $scale);
			$newImageHeight = ceil($height * $scale);
			$newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
			switch ($ext)
			{
				case 'jpg':
				case 'jpeg':
				$source = imagecreatefromjpeg($image);
				break;

				case 'gif':
				$source = imagecreatefromgif($image);
				break;

				case 'png':
				$source = imagecreatefrompng($image);
				break;

				default:
				$source = false;
				break;
			}
			 //imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
			//imagejpeg($newImage,$image,90);
			 chmod($image, 0777);
			// return $image;
		}
		
		public function changeimage()
		{
			$post = isset($_POST) ? $_POST: array();
			switch($post['action']) 
			{
				case 'save' :
				$this->saveProfilePic();
				$this->saveProfilePicTmp();
				break;
				default:
				changeProfilePic();
			}	
		}

/* Function to handle profile pic update in database*/
	public function saveProfilePic()
	{
		$post = isset($_POST) ? $_POST: array();
		if($post['id'])
		{
			$prop_bookanartist_data = array();
			$profiled = $this->Profile->find('all')->where(['user_id' => $post['id']])->first();
			$idcheck = count($profiled);
			if ($idcheck > 0)
			{
				$options = $this->Profile->get($profiled['id']);
				$prop_bookanartist_data['profile_image']=$post['image_name'];
				$option_arr = $this->Profile->patchEntity($options,$prop_bookanartist_data);
				$savedata = $this->Profile->save($option_arr);
			}
		}
	}

/* Function to handle profile pic update in frontend*/
	public function saveProfilePicTmp() 
	{
		$post = isset($_POST) ? $_POST: array();
		$userId = isset($post['id']) ? intval($post['id']) : 0;
		$path ='\\profileimages\tmp';
		$t_width = 300; // Maximum thumbnail width
		$t_height = 300; // Maximum thumbnail height
		
		
		if(isset($_POST['t']) and $_POST['t'] == "ajax")
		{
			extract($_POST);
			//pr($_POST); 
			
			$w1=$_POST['w1'];
			$x1=$_POST['x1'];
			$h1=$_POST['h1'];
			$y1=$_POST['y1'];
			//$_POST['x2'];
			//$_POST['y2'];
			
			$imagePath = 'profileimages/tmp/'.$_POST['image_name'];
			$ratio = ($t_width/$w1);
			$nw = ceil($w1 * $ratio);
			$nh = ceil($h1 * $ratio);
			$nimg = imagecreatetruecolor($nw,$nh);
			$im_src = imagecreatefromjpeg($imagePath);
		
			
			imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w1,$h1);
			imagejpeg($nimg,$imagePath,90);
			
			
		}
		echo $imagePath.'?'.time();
		exit(0);
	}
	
	/* Function to change profile picture */
public function changeProfilePic() {
	$post = isset($_POST) ? $_POST: array();
	$max_width = "500"; 
	$userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
	$path = 'profileimages/tmp';
	$valid_formats = array("jpg", "png", "gif", "jpeg");
	$name = $_FILES['profile-pic']['name'];
	$size = $_FILES['profile-pic']['size'];
	if(strlen($name)) {
		list($txt, $ext) = explode(".", $name);
		$ext = strtolower($ext);
		if(in_array($ext,$valid_formats)) {
			if($size<(1024*1024)) {
				$actual_image_name = 'avatar' .'_'.$userId .'.'.$ext;
				$filePath = $path .'/'.$actual_image_name;
				$tmp = $_FILES['profile-pic']['tmp_name'];
				if(move_uploaded_file($tmp, $filePath)) {
					$width = $this->getWidth($filePath);
					$height = $this->getHeight($filePath);
					//Scale the image if it is greater than the width set above
					if ($width > $max_width){
						$scale = $max_width/$width;
						$uploaded = $this->resizeImage($filePath,$width,$height,$scale, $ext);
					} else {
						$scale = 1;
						$uploaded = $this->resizeImage($filePath,$width,$height,$scale, $ext);
					}					
					echo "<img id='photo' file-name='".$actual_image_name."' class='' src='".$filePath.'?'.time()."' class='preview'/>";
				}
				else
				echo "failed";
			}
			else
			echo "Image file size max 1 MB"; 
		}
		else
		echo "Invalid file format.."; 
	}
	else
	echo "Please select image..!";
	exit;
}
	public function getHeight($image)
	{
		$sizes = getimagesize($image);
		$height = $sizes[1];
		return $height;
	}
	public function getWidth($image)
	{
		$sizes = getimagesize($image);
		$width = $sizes[0];
		return $width;
	}
	// This Function used for saved video
	public function deletedirectory($dirname, $id)

		{
		$this->loadModel('Gallery');
		$this->loadModel('Galleryimage');
		$this->autoRender = false;
		$path = WWW_ROOT . 'gallery' . DS . $dirname . DS;
		rmdir($path);
		$this->Galleryimage->deleteAll(['Galleryimage.gallery_id' => $id]);
		$gallery = $this->Gallery->get($id);
		if ($this->Gallery->delete($gallery))
			{
			$this->Flash->success(__('Album Deleted Successfully!!'));
			return $this->redirect(['action' => 'galleries']);
			}
		}
	public function getphonecode()

		{
		$this->request->data['id'];
		$this->loadModel('Country');
		$phonecode = array();
		if (isset($this->request->data['id']))
			{
			$phonecode = $this->Country->find('list', ['keyField' => 'id', 'valueField' => 'cntcode'])->where(['Country.id' => $this->request->data['id']])->toarray();
			}
		header('Content-Type: application/json');
		echo json_encode($phonecode);
		exit();
		}
	
	public function deleteimages($image_id='',$album_id='')
	{
	    $this->autoRender = false;
	    $this->loadModel('Galleryimage');
	    // $imageid = $this->request->data['imageid'];
	    //  $id = $this->request->data['datadd'];
	    $galleryimage = $this->Galleryimage->get($image_id);
	    $galldel = $this->Galleryimage->delete($galleryimage);
	    if ($galldel)
	    {
		$this->Flash->success(__('Image Deleted Successfully!!'));
		if(!empty($album_id))
		{
		    $this->redirect(['action' => 'profile/images/' . $album_id]);
		}
		else
		{	
		    $this->redirect(['action' => '/galleries/']);
		}
	    }
	    
	}
		
		
		
		
	
	public function audio()
	{
	    $this->loadModel('Audio');
	    $this->loadModel('Users');
	    $this->loadModel('Enthicity');
	    $this->loadModel('City');
	    $this->loadModel('State');
	    $this->loadModel('Country');
	    $id = $this->request->session()->read('Auth.User.id');
	    $profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	    $this->set('profile', $profile);
	    $userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
	    $session = $this->request->session();
	    $session->write('usercheck', $userpack_check);
	    $this->set('user_check', $userpack_check);
	    $user = $_SESSION['Auth']['User']['id'];
	    $audioprofile = $this->Audio->find('all')->where(['user_id' => $user])->toarray();
	    $this->set('audioprofile', $audioprofile);
		if ($this->request->is(['post', 'put'])){
		    $id=$this->request->data['id'];
			//pr($this->request->data); die;
		if(isset($id) && !empty($id)){
		    $Audio = $this->Audio->get($id);
		}else{
		    $Audio = $this->Audio->newEntity();
		}
		try { 
		    // Checking Image uploading Limit
		    $this->loadModel('Packfeature');
		    $user_id = $this->request->session()->read('Auth.User.id');
		    $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();
		    $packfeature_id = $packfeature['id'];
		    $number_audio = $packfeature['number_audio'];
			if($id){
				$prop_data['audio_type'] = $this->request->data['audio_type'];
			    $prop_data['audio_link'] = $this->request->data['audio_link'];
			    $prop_data['user_id'] = $user;		 				
			$option_arr = $this->Audio->patchEntity($Audio, $prop_data);
			$savedata = $this->Audio->save($option_arr);
		$this->Flash->success(__('Audio updated Successfully!!'));
			return $this->redirect(SITE_URL.'/galleries/audio');
			}else{
		    if ($number_audio > 0){
			    $prop_data['audio_type'] = $this->request->data['audio_type'];
			    $prop_data['audio_link'] = $this->request->data['audio_link'];
			    $prop_data['user_id'] = $user;		 				
			$option_arr = $this->Audio->patchEntity($Audio, $prop_data);
			$savedata = $this->Audio->save($option_arr);
			
			// Update Audio uploading limit
			$packfeature = $this->Packfeature->get($packfeature_id);
			$feature_info['number_audio'] = $number_audio-1;
			$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
			$this->Packfeature->save($features_arr);
			
			return $this->redirect(SITE_URL.'/galleries/audio');
		    }else{
			$this->Flash->error(__("You have exceed the Audio upload limit. Please upgrade your profile Package."));
			return $this->redirect(SITE_URL.'/galleries/audio');
		    }}
		}
		catch (\PDOException $e) {
		    $this->Flash->error(__('Error in Uploading Audio'));
		    $this->set('error', $error);
		    return $this->redirect(SITE_URL.'/galleries/audio');
		}
	    }
            $this->set('Audio', $Audio);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function video()
	{
	    $this->loadModel('Video');
	    $this->loadModel('Users');
	    $this->loadModel('Enthicity');
	    $this->loadModel('City');
	    $this->loadModel('State');
	    $this->loadModel('Country');
	    $id = $this->request->session()->read('Auth.User.id');
	    $profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	    $this->set('profile', $profile);
	    $userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
	    $session = $this->request->session();
	    $session->write('usercheck', $userpack_check);
	    $this->set('user_check', $userpack_check);
	    $user = $_SESSION['Auth']['User']['id'];
	    $videoprofile = $this->Video->find('all')->where(['user_id' => $user])->toarray();
	    $this->set('videoprofile', $videoprofile);
		if ($this->request->is(['post', 'put'])){
		    $id=$this->request->data['id'];
		if(isset($id) && !empty($id)){
		    $Video = $this->Video->get($id);
		}else{
		    $Video = $this->Video->newEntity();
		}
		try { 
		    // Checking Image uploading Limit
		    $this->loadModel('Packfeature');
		    $user_id = $this->request->session()->read('Auth.User.id');
		    $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();
		    $packfeature_id = $packfeature['id'];
		    $number_video = $packfeature['number_video'];
		    if ($number_video > 0){
			if($this->request->data['imagename']['error']==4){
			    $prop_data['video_name'] = $this->request->data['video_name'];
			    $prop_data['video_type'] = $this->request->data['videourl'];
			    $prop_data['user_id'] = $user;

			    $url = $this->request->data['imagesrc'];	
			    echo $ext=  end(explode('.', $url));
			    $name = md5(time($filename));
			    $rnd=mt_rand();
			    $imagename=trim($name.$rnd.$i.'.'.$ext," ");
			    $img = WWW_ROOT . 'videothumb/'.$imagename;
			    file_put_contents($img, file_get_contents($url));
			    $prop_data['thumbnail']=$imagename;
			}
			else{
			    if ($this->request->data['imagename']['name'] != ''){
				$prop_data['video_name'] = $this->request->data['video_name'];
				$prop_data['user_id'] = $user;
				$ks = $this->request->data['imagename'];
				$gall = $this->mimages($ks);
				//pr($gall);
				$pathThumb = 'videothumb/';
				$this->FcCreateThumbnail("trash_image", $pathThumb, $gall[0], $gall[0], "300", "100");
				$prop_data['thumbnail'] = $gall[0];
			    }
			    else{
				$prop_data['thumbnail']= 'noimage.jpg';
			    }
			}
			//pr($prop_data); die;
			if($this->request->data['imagesrc']=='' &&$this->request->data['imagename']['error']==4){
			    $prop_data['thumbnail']= $Video['thumbnail'];
			}			
			$option_arr = $this->Video->patchEntity($Video, $prop_data);
			$savedata = $this->Video->save($option_arr);
			
			// Update Audio uploading limit
			$packfeature = $this->Packfeature->get($packfeature_id);
			$feature_info['number_video'] = $number_video-1;
			$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
			$this->Packfeature->save($features_arr);
			
			return $this->redirect(SITE_URL.'/galleries/video');
		    }else{
			$this->Flash->error(__("You have exceed the Video upload limit. Please upgrade your profile Package."));
			return $this->redirect(SITE_URL.'/galleries/video');
		    }
		}
		catch (\PDOException $e) {
		    $this->Flash->error(__('Error in Uploading Videos'));
		    $this->set('error', $error);
		    return $this->redirect(SITE_URL.'/galleries/video');
		}
	    }
            $this->set('Video', $Video);
	}
	// This Function used for deleted video
	
	public function deleteaudio($id)

		{
		$this->autoRender = false;
		$this->loadModel('Audio');
		$audio = $this->Audio->get($id);
		$this->Audio->delete($audio);
		$this->Flash->success(__('Audio Deleted Successfully!!'));
		return $this->redirect(SITE_URL.'/galleries/audio');
		}
	
	
	public function deletevideo($id)

		{
		$this->autoRender = false;
		$this->loadModel('Video');
		$video = $this->Video->get($id);
		$imagename=$video['thumbnail'];
		$img = WWW_ROOT . 'videothumb/'.$imagename;
		unlink($img);

		$this->Video->delete($video);
		$this->Flash->success(__('Video Deleted Successfully!!'));
		return $this->redirect(SITE_URL.'/galleries/video');
		}
	// This Function used for saved Audio

	// This Function used for get states according country
	public function getStates()

		{
		$this->loadModel('Country');
		$this->loadModel('State');
		$states = array();
		if (isset($this->request->data['id']))
			{
			$states = $this->Country->State->find('list')->select(['id', 'name'])->where(['State.country_id' => $this->request->data['id']])->toarray();
			}
		header('Content-Type: application/json');
		echo json_encode($states);
		exit();
		}
	// This Function used for get city according states
	public function getcities()

		{
		$this->loadModel('City');
		$cities = array();
		if (isset($this->request->data['id']))
			{
			$cities = $this->City->find('list')->select(['id', 'name'])->where(['City.state_id' => $this->request->data['id']])->toarray();
			}
		header('Content-Type: application/json');
		echo json_encode($cities);
		exit();
		}
		 public  function _setPassword($password)
    {
	return (new DefaultPasswordHasher)->hash($password);
    }
	// This Function used for edit and add profile
	public function profile($id = null)
		{
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Skillset');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Language');
		$this->loadModel('Languageknown');
		$this->loadModel('Enthicity');
		$ethnicity = $this->Enthicity->find('list')->select(['id', 'title'])->toarray();
		// pr($ethnicity);
		$this->set('ethnicity', $ethnicity);
		$id = $this->request->session()->read('Auth.User.id');
		
		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
	$this->Auth->setUser($userpack_check );
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
		$lang = $this->Language->find('all')->select(['id', 'name'])->toarray();
		$this->set('lang', $lang);
		
		$country = $this->Country->find('list')->select(['id', 'name'])->toarray();
		$this->set('country', $country);
		
		$languageknow = $this->Languageknown->find('all')->select(['id', 'language_id'])->where(['Languageknown.user_id' => $id])->order(['Languageknown.id' => 'DESC'])->toarray();
		$this->set('languageknow', $languageknow);
		
		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id])->order(['Skillset.id' => 'DESC'])->toarray();
		$this->set('skillofcontaint', $contentadminskillset);
		
		$profiled = $this->Profile->find('all')->where(['user_id' => $id])->first();
		$idcheck = count($profiled);
		if ($idcheck > 0)
		{
		    // using for edit
		    $profile = $this->Profile->find('all')->contain(['Users'])->where(['user_id' => $id])->first();
		   //pr( $profile);
		}
		else
		{
		    $profile = $this->Profile->newEntity();
		}
		$this->set('profile', $profile);
		$cities = $this->City->find('list')->where(['City.state_id' => $profile['state_id']])->toarray();
		$this->set('cities', $cities);
		$states = $this->State->find('list')->where(['State.country_id' => $profile['country_ids']])->toarray();
		$this->set('states', $states);
		$phonecodess = $this->Country->find('list', ['keyField' => 'id', 'valueField' => 'cntcode'])->toarray();
		$this->set('phonecodess', $phonecodess);
		if ($this->request->is(['post', 'put']))
		{ 
			
			//pr($this->request->data); die;
			$Pack = $this->Users->get($id);
			$pass= md5($this->request->data['guardianpassword']);
			$Pack->guardianpassword= $pass;
			$Pack->guardianemailaddress=$this->request->data['guardian_email'];
			$this->Users->save($Pack);
			
			
		    if (!empty($this->request->data['profile_image']))
		    {
		    // Saving Image
		    $profile_image = $this->request->data['profile_image'];
		    if (preg_match('/^data:image\/(\w+);base64,/', $profile_image, $type)) {
		    $profile_image = substr($profile_image, strpos($profile_image, ',') + 1);
		    $type = strtolower($type[1]); // jpg, png, gif

		    if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
			throw new \Exception('invalid image type');
		    }

		    $profile_image = base64_decode($profile_image);

		    if ($profile_image === false) {
			throw new \Exception('base64_decode failed');
		    }
		    } else {
			throw new \Exception('did not match data URI with image data');
		    }
		    $previmage = date(time());
		    $image_save_path =  WWW_ROOT.'/profileimages/'.$previmage;
		    file_put_contents($image_save_path.".{$type}", $profile_image);
		    
		    $this->request->data['profile_image'] = $previmage.".".$type;
		    
		    // Saving Image
		}else{
	$this->request->data['profile_image']=	 $profile['profile_image'];
		}
		    
			//pr($this->request->data); die;
			
			$this->request->data['dob'] = date('Y-m-d', strtotime($this->request->data['dob']));
			$this->request->data['user_id'] = $id;
			$prop_count = count($this->request->data['languageknow']);
			$prop_data = array();
			$this->Languageknown->deleteAll(['Languageknown.user_id' => $id]);
			for ($i = 0; $i < $prop_count; $i++)
				{
				if ($this->request->data['languageknow'][$i] > 0)
					{
					$peopleTable = TableRegistry::get('Languageknown');
					$oQuery = $peopleTable->query();
					$oQuery->insert(['language_id', 'user_id'])->values(['language_id' => $this->request->data['languageknow'][$i], 'user_id' => $id]);
					$d = $oQuery->execute();
					}
				}
			$skillcheck = $this->request->data['skill'];
			$skillcount = explode(",", $this->request->data['skill']);
			/*
			if ($this->request->data['profile_image']['name'] != '')
				{
				$gallery = $this->request->data['profile_image'];
				
				$gall = $this->move_images($gallery);
				$pathThumb = 'profileimages/';
				$filereturn = $this->upload_images($gall, array(
					1140,
					600
				) , $pathThumb);
				
				$this->request->data['profile_image'] = $filereturn;
				}
			  else
				{
				$profileimage = $this->Profile->find('all')->where(['user_id' => $id])->first();
				$previmage = $profileimage['profile_image'];
				$this->request->data['profile_image'] = $previmage;
				}
			*/
				//pr($this->request->data); die;
			$profiles = $this->Profile->patchEntity($profile, $this->request->data);
			
			$savedprofile = $this->Profile->save($profiles);
			if ($this->request->data['skill'] != '')
				{
				$this->Skillset->deleteAll(['Skillset.user_id' => $id]);
				for ($i = 0; $i < count($skillcount); $i++)
					{
					$contentadminskill = $this->Skillset->newEntity();
					$this->request->data['user_id'] = $id;
					$this->request->data['skill_id'] = $skillcount[$i];
					$contentadminskillsave = $this->Skillset->patchEntity($contentadminskill, $this->request->data);
					$skilldata = $this->Skillset->save($contentadminskillsave);
					if ($skilldata)
						{
						$con = ConnectionManager::get('default');
						$detail = 'UPDATE `users` SET `role_id` ="' . TALANT_ROLEID . '" WHERE `users`.`id` = ' . $id;
						$results = $con->execute($detail);
						}
					}
				}
			  else
				{
				$this->Skillset->deleteAll(['Skillset.user_id' => $id]);
				$con = ConnectionManager::get('default');
				$detail = 'UPDATE `users` SET `role_id` ="' . NONTALANT_ROLEID . '" WHERE `users`.`id` = ' . $id;
				$results = $con->execute($detail);
				}
			$this->addactivity($id, 'update_profile', '');
			$this->Flash->success(__('Profile  Has Been Updated Successfully!!'));
			return $this->redirect(['action' => 'index']);
			}
		}
	// This Function for show skills
	public function skills($id = null)
	{
	    $this->loadModel('Users');
	    $this->loadModel('Skillset');
	    $this->loadModel('Skill');
	    if ($id != null)
	    {
		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id, 'Skillset.status' => 'Y'])->order(['Skillset.id' => 'DESC'])->toarray();
	    }
	    $Skill = $this->Skill->find('all')->select(['id', 'name'])->where(['Skill.status' => 'Y'])->toarray();
	    $this->set('Skill', $Skill);
	    $this->set('skillset', $contentadminskillset);
	    
	    
	    $this->loadModel('Packfeature');
	    $user_id = $this->request->session()->read('Auth.User.id');
	    $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();
	    $this->set('total_elegible_skills', $packfeature['number_categories']);
	}
	
	// ************************ this fucntion call for ajax used for delete gallery *****************************//
	public function deletegallery($id = null, $tattoo_id)

		{
		$this->loadModel('Galleryimage');
		$id = $this->request->data['delid'];
		$pro_id = $this->request->data['product_id'];
		$gallery = $this->Galleryimage->find('all')->contain(['Gallery'])->order(['Galleryimage.id' => 'DESC'])->where(['Galleryimage.id' => $id])->first();
		unlink('gallery/' . $gallery['gallery']['name'] . '/' . $gallery['imagename']);
		$tattoo = $this->Galleryimage->get($id);
		$this->Galleryimage->delete($tattoo);
		return $this->redirect(['action' => 'images/' . $id]);
		}
	// This Function used for gallery album add images
	public function images($id)
	{
	    if(empty($id))
	    {
		$id=0;
	    }
	    $this->set('id', $id);
	    $userid = $this->request->session()->read('Auth.User.id');
	    $this->loadModel('Gallery');
	    $this->loadModel('Galleryimage');
	    $galleryimage = $this->Galleryimage->newEntity();
	    $this->set('galleryimage', $galleryimage);
	    $galleryalbumname = $this->Gallery->find('all')->where(['Gallery.id' => $id])->first();
	    $this->set('galleryalbumname', $galleryalbumname);
	    $galleryprofileimage = $this->Gallery->find('all')->contain(['Galleryimage'])->where(['Gallery.id' => $id])->first();
	    $galleryprofileimagescount = $this->Galleryimage->find('all')->where(['Galleryimage.gallery_id' => $id])->toarray();
	    $gallerycounting = count($galleryprofileimagescount);
	    $gallurl = $galleryprofileimage['name'];
	    $this->set('galleryprofileimage', $galleryprofileimage);
	    if ($this->request->is(['post', 'put']))
	    {
		    if($id=="0")
		    {
			$id = '';
		    }
		    $peopleTable = TableRegistry::get('Galleryimage');
		    //pr($this->request->data);die;
		    if ($this->request->data['imagename'][0]['name'] != '')
			    {
			    $this->request->data['gallery_id'] = $id;
			    $romm = count($this->request->data['imagename']);
			    for ($i = 0; $i < $romm; $i++)
			    {
				// Checking Image uploading Limit
				$this->loadModel('Packfeature');
				$user_id = $this->request->session()->read('Auth.User.id');
				$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();
				$packfeature_id = $packfeature['id'];
				$number_of_photo = $packfeature['number_of_photo'];
				if ($number_of_photo > 0)
				{
				    if ($this->request->data['imagename'][$i]['name'] != '')
				    {
					$ks = $this->request->data['imagename'][$i];
					$gall = $this->move_images($ks);
					$pathThumb = 'gallery/';
					$this->FcCreateThumbnail("trash_image", $pathThumb, $gall[0], $gall[0], "200", "200");
					$this->FcCreateThumbnail("trash_image", $pathThumb, $gall[0], $gall[0], "1500", "1500");
					$filennames = $gall[0];
				    }
				    else
				    {
					$filennames = 'noimage.jpg';
				    }
				    $image_data['gallery_id'] = $id;
				    $image_data['user_id'] = $userid;
				    $image_data['imagename'] = $filennames;
				    $images = $this->Galleryimage->newEntity();
				    $images = $this->Galleryimage->patchEntity($images, $image_data);
				    $result= $this->Galleryimage->save($images);
				    $last_id = $result->id;
				    // Add to activities
				    $this->addactivity($userid, 'update_photos', $last_id);
				    // Update Photo uploading limit
				    $packfeature = $this->Packfeature->get($packfeature_id);
				    $feature_info['number_of_photo'] = $number_of_photo-1;
				    $features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
				    $this->Packfeature->save($features_arr);
				}
				else
				{
				    $this->Flash->error(__("You have exceed the Image upload limit. Please upgrade your profile Package."));
				    if($id>0)
				    {
					return $this->redirect(['action' => 'images/' . $id]);
				    }
				    else
				    {
					return $this->redirect(['action' => 'galleries/']);
				    }
				}
			    }
			   
			    }
		    if($id>0)
		    {
			return $this->redirect(['action' => 'images/' . $id]);
		    }
		    else
		    {
			return $this->redirect(['action' => 'galleries/']);
		    }
			    }
		}
	// This Function used for Add gallery album
	public function galleries()
	{
	    $this->loadModel('Galleryimage');
	    $this->loadModel('Gallery');
	    $this->loadModel('Users');
	    $this->loadModel('Enthicity');
	    $this->loadModel('City');
	    $this->loadModel('State');
	    $this->loadModel('Country');
	    
	    $id = $this->request->session()->read('Auth.User.id');
	    $profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	    $this->set('profile', $profile);
	    $galleryprofile = $this->Gallery->find('all')->contain(['Galleryimage'])->where(['user_id' => $id])->toarray();
	    $galleryalbumcount = count($galleryprofile);
	    $this->set('galleryprofile', $galleryprofile);
	    $gallery = $this->Gallery->newEntity();
	    $this->set('gallery', $gallery);
	    $userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
	    $session = $this->request->session();
	    $session->write('usercheck', $userpack_check);
	    $this->set('user_check', $userpack_check);
	    $singleimages = $this->Galleryimage->find('all')->select(['id','imagename'])->where(['Galleryimage.user_id' => $id,'Galleryimage.gallery_id' =>'0'])->order(['Galleryimage.id' => 'DESC'])->toarray();
	    //pr($singleimages);
	    $this->set('singleimages', $singleimages);
	
	    if ($this->request->is(['post', 'put']))
	    {
		// Checking Folder creating Limit
		$this->loadModel('Packfeature');
		$user_id = $this->request->session()->read('Auth.User.id');
		$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();
		$packfeature_id = $packfeature['id'];
		$number_albums = $packfeature['number_albums'];
		if ($number_albums > 0)
		{
		    $this->request->data['Gallery']['user_id'] = $id;
		    $gallries = $this->Gallery->patchEntity($gallery, $this->request->data);
		    if ($this->Gallery->save($gallries))
		    {
			// Update Photo uploading limit
			$packfeature = $this->Packfeature->get($packfeature_id);
			$feature_info['number_albums'] = $number_albums-1;
			$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
			$this->Packfeature->save($features_arr);
			$this->Flash->success(__('Album Created Successfully!!'));
			return $this->redirect(['action' => 'galleries']);
		    }
		}
		else
		{
		    $this->Flash->error(__("You have exceed the Image upload limit. Please upgrade your profile Package."));
		    return $this->redirect(['action' => 'galleries']);
		}
	    }
	}
	
	// this function used for Report spam
	public function reportspammedia($imageid)
	{
	    $this->set('imageid', $imageid);
	}
	
	public function reportspam()
	{
	    $this->loadModel('Users');
	    $this->loadModel('Report');
	    $error = '';
	    $rstatus = '';
	    if ($this->request->is(['post', 'put']))
	    {
			
		$userid = $this->request->session()->read('Auth.User.id');
		$profile_id = $this->request->data['profile_id'];
		$this->request->data['reason'] = $this->request->data['reportoption'];
		$this->request->data['comments'] = $this->request->data['description'];
		$this->request->data['reported_by_id'] = $userid;
		$this->request->data['profile_id'] = $profile_id;
		$userreports = $this->Report->find('all')->where(['Report.profile_id'=>$profile_id, 'Report.reported_by_id'=>$userid])->count();
		if($userreports > 0)
		{
		    $error = 'You have already updated Report for this user.';
		    $rstatus = 0;
		}
		else
		{
			
		    $report = $this->Report->newEntity();
		    $report = $this->Report->patchEntity($report, $this->request->data);
		    if ($this->Report->save($report))
		    {
				$rstatus = 1;
				$totalreports = $this->Report->find('all')->where(['Report.profile_id'=>$profile_id])->count();
				$number_of_report_for_block = $this->request->session()->read('settings.block_after_report');
				$unblock_within = $this->request->session()->read('settings.unblock_within');
				if($totalreports >= $number_of_report_for_block)
				{
					$userreports = $this->Report->find('all')->where(['Report.profile_id'=>$profile_id, 'Report.type'=>'profile'])->count();
					if($userreports){
						$users = $this->Users->find('all')->where(['id' => $profile_id])->first();
						$blocked_expiry_str = strtotime('+'.$unblock_within.' days',time());
						$user_data['blocked_expiry'] = date('Y-m-d H:i:s',$blocked_expiry_str);
						$user_data['blocked_attempts'] = $users['blocked_attempts']+1;
						$users = $this->Users->patchEntity($users, $user_data);
						$updateuser = $this->Users->save($users);
					}
				}
		    }
		    else
		    {
				$error = 'Something wrong here.';
		    }
		  // echo $rstatus; die;
		}
		    $response['error']= $error;
		    $response['status']=$rstatus;
		    echo json_encode($response); die;
		    die;
	    }
	}
		
		
	public function professionalsummary()
	{
	    $this->loadModel('Professinal_info');
	    $this->loadModel('Prof_website');
	    $this->loadModel('Prof_exprience');
	    $this->loadModel('Current_working');
	    $this->loadModel('Users');
	    $this->loadModel('Enthicity');
	    $this->loadModel('City');
	    $this->loadModel('State');
	    $this->loadModel('Country');
	    $this->loadModel('Skillset');
	    $this->loadModel('Skill');
	    
	    $id = $this->request->session()->read('Auth.User.id');
	    $profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	    $this->set('profile', $profile);
		
		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id,'Skill.is_Portfolio'=>1])->order(['Skillset.id' => 'DESC'])->toarray();
		
		$this->set('skillofcontaint', $contentadminskillset);
		
		$videoprofile = $this->Prof_website->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofile', $videoprofile);
		$profexp = $this->Prof_exprience->find('all')->where(['user_id' => $id])->toarray();
		$this->set('profexp', $profexp);
		$currentworking = $this->Current_working->find('all')->where(['user_id' => $id])->toarray();
		$this->set('currentworking', $currentworking);
		$profess = $this->Professinal_info->find('all')->where(['user_id' => $id])->first();
		$idcheck = count($profess);
		if ($idcheck > 0)
		{
		    // using for edit
		    $proff = $this->Professinal_info->find('all')->where(['user_id' => $id])->first();
		}
		else
		{
		    $proff = $this->Professinal_info->newEntity();
		}
		$this->set('proff', $proff);
		 $userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
		if ($this->request->is(['post', 'put']))
			{
			//pr($this->request->data);die;
			$this->request->data['user_id'] = $id;
			$prop_bookanartist_count = count($this->request->data['current']['bookenartist']);
			$prop_bookanartist_data = array();
			for ($i = 0; $i < $prop_bookanartist_count; $i++)
			{
			$from_date = $this->request->data['current']['date_from'][$i];
			$prop_bookanartist_data['name'] = $this->request->data['current']['name'][$i];
			$prop_bookanartist_data['bookenartist'] = $this->request->data['current']['bookenartist'][$i];
			$prop_bookanartist_data['date_from'] = $from_date.':01';
			//$prop_bookanartist_data['date_to'] = $this->request->data['datas']['date_to'][$i];
			$prop_bookanartist_data['role'] = $this->request->data['current']['role'][$i];
			$prop_bookanartist_data['location'] = $this->request->data['current']['location'][$i];
			$prop_bookanartist_data['description'] = $this->request->data['current']['description'][$i];
			$prop_bookanartist_data['user_id'] = $id;
			//pr($prop_bookanartist_data); 
			if ($this->request->data['current']['hid'][$i] > 0)
				{
				$options = $this->Current_working->get($this->request->data['current']['hid'][$i]);
			    $option_arr = $this->Current_working->patchEntity($options,$prop_bookanartist_data);
			    $savedata = $this->Current_working->save($option_arr);
				}
			    else
				{
					$options = $this->Current_working->newEntity();
					$option_arr = $this->Current_working->patchEntity($options, $prop_bookanartist_data);
					$savedata = $this->Current_working->save($option_arr);
				}
			}
			$prop_desc_count = count($this->request->data['exp']['description']);
			$prop_desc_data = array();
			$from_date = '';
			$to_date = '';
			for ($i = 0; $i < $prop_desc_count; $i++)
			{
			    $from_date = $this->request->data['exp']['date_from'][$i];
			    $to_date = $this->request->data['exp']['date_to'][$i];
			    $prop_desc_data['description'] = $this->request->data['exp']['description'][$i];
			    $prop_desc_data['bookenartist'] = $this->request->data['exp']['bookenartist'][$i];
			    $prop_desc_data['name'] = $this->request->data['exp']['name'][$i];
			    $prop_desc_data['location'] = $this->request->data['exp']['location'][$i];
			    $prop_desc_data['role'] = $this->request->data['exp']['role'][$i];
			    $prop_desc_data['from_date'] = $from_date.':01';
			    $prop_desc_data['to_date'] = $to_date.':01';
			    $prop_desc_data['user_id'] = $id;
			    if ($this->request->data['exp']['hid'][$i] > 0)
				    {  
					$optionsprof = $this->Prof_exprience->get($this->request->data['exp']['hid'][$i]);
			    $option_prof = $this->Prof_exprience->patchEntity($optionsprof,$prop_desc_data);
			    $savedata = $this->Prof_exprience->save($option_prof);
				    }
				else
				    {
					$optionsprof = $this->Prof_exprience->newEntity();
					$option_prof = $this->Prof_exprience->patchEntity($optionsprof, $prop_desc_data);
					$savedata = $this->Prof_exprience->save($option_prof);
				    }
			
			}
			$prop_count = count($this->request->data['data']['weblink']);
			$prop_data = array();
			for ($i = 0; $i < $prop_count; $i++)
				{
				$prop_data['web_link'] = $this->request->data['data']['weblink'][$i];
				$prop_data['web_type'] = $this->request->data['data']['webtype'][$i];
				$prop_data['user_id'] = $id;
				if ($this->request->data['data']['hid'][$i] > 0)
					{
					$optionsweb = $this->Prof_website->get($this->request->data['data']['hid'][$i]);
					$option_web = $this->Prof_website->patchEntity($optionsweb,$prop_data);
					$savedata = $this->Prof_website->save($option_web);
					}
				  else
					{
						$optionsweb = $this->Prof_website->newEntity();
						$option_web = $this->Prof_website->patchEntity($optionsweb, $prop_data);
						$savedata = $this->Prof_website->save($option_web);
					}
				}
			$profiles = $this->Professinal_info->patchEntity($proff, $this->request->data);
			$savedprofile = $this->Professinal_info->save($profiles);
			if ($savedprofile)
				{
				$this->Flash->success(__('Proffessional Summary Saved Successfully!!'));
				 //pr($this->request->data);die;
				//die;
				return $this->redirect(['action' => 'professionalsummary']);
				}
			}
		}
	public function deleteproffessionalexp()

		{
		$this->autoRender = false;
		$this->loadModel('Prof_exprience');
		$id = $this->request->data['datadd'];
		$video = $this->Prof_exprience->get($id);
		$this->Prof_exprience->delete($video);
		}
	public function deleteproffessional()

		{
		$this->autoRender = false;
		$this->loadModel('Prof_website');
		$id = $this->request->data['datadd'];
		$video = $this->Prof_website->get($id);
		$this->Prof_website->delete($video);
		}
	public function deleteproffessionalcurrent()

		{
		$this->autoRender = false;
		$this->loadModel('Current_working');
		$id = $this->request->data['datadd'];
		$video = $this->Current_working->get($id);
		$this->Current_working->delete($video);
		}
	public function deletepersonal()

		{
		$this->autoRender = false;
		$this->loadModel('Performance_personaldetails');
		$id = $this->request->data['datadd'];
		$video = $this->Performance_personaldetails->get($id);
		$this->Performance_personaldetails->delete($video);
		}
	public function deletepayment()
	{
	    $this->autoRender = false;
	    $this->loadModel('Performancedesc2');
	    $id = $this->request->data['datadd'];
	    $video = $this->Performancedesc2->get($id);
	    $this->Performancedesc2->delete($video);
	}
	public function performance()
	{
	    $this->loadModel('Skillset');
	    $this->loadModel('Skill');
	    $this->loadModel('Genre');
	    $this->loadModel('Genreskills');
	    $this->loadModel('Users');
	    $this->loadModel('Enthicity');
	    $this->loadModel('City');
	    $this->loadModel('State');
	    $this->loadModel('Country');
	    $id = $this->request->session()->read('Auth.User.id');
	     $profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	    $this->set('profile', $profile);
		$skills_set = $this->Skillset->find('all')->select(['skill_id'])->where(['Skillset.user_id' => $id])->order(['Skillset.id' => 'DESC'])->toarray();
		//pr($contentadminskillset); die;
		foreach($skills_set as $skills)
		{
		    $userskills[] = $skills['skill_id'];
		    
		}
		//pr($userskills);
		$genre = $this->Genreskills->find('all')->select(['Genre.id','Genre.name'])->contain(['Genre'])->where(['Genreskills.skill_id IN' => $userskills, 'Genre.parent' => 0, 'Genre.status' => 'Y'])->group('Genreskills.genre_id')->toarray();
		
		$this->set('genre', $genre);
		foreach($genre as $gemreres)
		{
		    $gens_id[] = $gemreres['Genre']['id'];
		}
		//pr($gens_id);
		$subgenre = $this->Genre->find('all')->where(['Genre.parent IN' => $gens_id, 'status' => 'Y'])->toarray();
		//pr($subgenre);
		$this->set('subgenre', $subgenre);
			 $userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
		$this->loadModel('Currency');
		$this->loadModel('Performance_desc');
		$this->loadModel('Performance_genre');
		$this->loadModel('Performance_personaldetails');
		$this->loadModel('Performancedesc2');
		$this->loadModel('Performance_language');
		$this->loadModel('Language');
		$this->loadModel('Payment_fequency');
		$id = $this->request->session()->read('Auth.User.id');
		$lang = $this->Language->find('all')->select(['id', 'name'])->toarray();
		$this->set('lang', $lang);
		$pay_freq = $this->Payment_fequency->find('list')->select(['id', 'name'])->toarray();
		$this->set('pay_freq', $pay_freq);
		$videoprofile = $this->Performance_personaldetails->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofile', $videoprofile);
		$languageknow = $this->Performance_language->find('all')->select(['id', 'language_id'])->where(['Performance_language.user_id' => $id])->order(['Performance_language.id' => 'DESC'])->toarray();
		$this->set('languageknow', $languageknow);
		$performance_genre = $this->Performance_genre->find('all')->select(['id', 'genre_id'])->where(['Performance_genre.user_id' => $id, 'Performance_genre.subgenre_id' => 0])->order(['Performance_genre.id' => 'DESC'])->toarray();
		$this->set('performance_genre', $performance_genre);
		$performance_subgenre = $this->Performance_genre->find('all')->select(['id', 'subgenre_id'])->where(['Performance_genre.user_id' => $id, 'Performance_genre.genre_id' => 0])->order(['Performance_genre.id' => 'DESC'])->toarray();
		$this->set('performance_subgenre', $performance_subgenre);
		$payfrequency = $this->Performancedesc2->find('all')->where(['user_id' => $id])->toarray();
		$this->set('payfrequency', $payfrequency);
		$currency = $this->Currency->find('list')->select(['id', 'name', 'symbol'])->order(['Currency.id' => 'DESC'])->toarray();
		$this->set('currency', $currency);
		$profess = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$idcheck = count($profess);
		if ($idcheck > 0)
		{
		    // using for edit
		    $proff = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		}
	    else
		{
		    $proff = $this->Performance_desc->newEntity();
		}
		$this->set('proff', $proff);
		if ($this->request->is(['post', 'put']))
			{
		
		 	$this->request->data['acceptassignment'] = $this->request->data['acceptassignment'];
			$this->request->data['user_id'] = $id;
			$prop_count = count($this->request->data['data']['url']);
			$prop_data = array();
			for ($i = 0; $i < $prop_count; $i++)
				{
				$prop_data['name'] = $this->request->data['data']['name'][$i];
				$prop_data['url'] = $this->request->data['data']['url'][$i];
				$prop_data['user_id'] = $id;
				if ($this->request->data['data']['hid'][$i] > 0)
					{
					$options = $this->Performance_personaldetails->get($this->request->data['data']['hid'][$i]);
			    $option_arr = $this->Performance_personaldetails->patchEntity($options,$prop_data);
			    $savedata = $this->Performance_personaldetails->save($option_arr);
					}
				  else
					{
					$options = $this->Performance_personaldetails->newEntity();
					$option_arr = $this->Performance_personaldetails->patchEntity($options, $prop_data);
					$savedata = $this->Performance_personaldetails->save($option_arr);
					}
				}
			$pay_count = count($this->request->data['datas']['payment_frequency']);
			$pay_data = array();
			for ($i = 0; $i < $pay_count; $i++)
				{
				$pay_data['payment_frequency'] = $this->request->data['datas']['payment_frequency'][$i];
				$pay_data['currency_id'] = $this->request->data['datas']['currency'][$i];
				$pay_data['amount'] = $this->request->data['datas']['amount'][$i];
				$pay_data['user_id'] = $id;
			//	pr($pay_data);
				if ($this->request->data['datas']['hid'][$i] > 0)
					{
				$optionspay = $this->Performancedesc2->get($this->request->data['datas']['hid'][$i]);
			    $option_pay = $this->Performancedesc2->patchEntity($optionspay,$pay_data);
			    $savedata = $this->Performancedesc2->save($option_pay);
					}
				  else
					{
					
					$optionspay = $this->Performancedesc2->newEntity();
					$option_pay = $this->Performancedesc2->patchEntity($optionspay,$pay_data);
					$savedata = $this->Performancedesc2->save($option_pay);
					}
				} 
			$language_count = count($this->request->data['languageknow']);
			if ($language_count > 0)
				{
				$language_data = array();
				$this->Performance_language->deleteAll(['Languageknown.user_id' => $id]);
				for ($i = 0; $i < $language_count; $i++)
					{
					if ($this->request->data['languageknow'][$i] > 0)
						{
						$peopleTable = TableRegistry::get('Performance_language');
						$oQuery = $peopleTable->query();
						$oQuery->insert(['language_id', 'user_id'])->values(['language_id' => $this->request->data['languageknow'][$i], 'user_id' => $id]);
						$d = $oQuery->execute();
						}
					}
				}
			$genre_count = count($this->request->data['genre']);
			if ($genre_count > 0)
				{
				$genre_data = array();
				$this->Performance_genre->deleteAll(['Performance_genre.user_id' => $id,'Performance_genre.genre_id >'=>'0']);
				for ($i = 0; $i < $genre_count; $i++)
					{
					if ($this->request->data['genre'][$i] > 0)
						{
						$subgen = '0';
						$peopleTable = TableRegistry::get('Performance_genre');
						$oQuery = $peopleTable->query();
						$oQuery->insert(['genre_id', 'user_id', 'subgenre_id'])->values(['genre_id' => $this->request->data['genre'][$i], 'user_id' => $id, 'subgenre_id' => $subgen]);
						$d = $oQuery->execute();
						}
					}
				}
			$subgenre_count = count($this->request->data['subgenre']);
			if ($subgenre_count > 0)
				{
				$subgenre_data = array();
				$this->Performance_genre->deleteAll(['Performance_genre.user_id' => $id,'Performance_genre.subgenre_id >'=>'0']);
				for ($i = 0; $i < $subgenre_count; $i++)
					{
					if ($this->request->data['subgenre'][$i] > 0)
						{
						$genre = '0';
						$peopleTable = TableRegistry::get('Performance_genre');
						$oQuery = $peopleTable->query();
						$oQuery->insert(['genre_id', 'user_id', 'subgenre_id'])->values(['genre_id' => $genre, 'user_id' => $id, 'subgenre_id' => $this->request->data['subgenre'][$i]]);
						$d = $oQuery->execute();
						}
					}
				}
			$profiles = $this->Performance_desc->patchEntity($proff, $this->request->data);
			$savedprofile = $this->Performance_desc->save($profiles);
			if ($savedprofile)
				{
				$this->Flash->success(__('performance Saved Successfully!!'));
				return $this->redirect(['action' => 'performance']);
				}
			}
	}
	public function vitalstatistics()
	{
	    $this->loadModel('Skillset');
	    $this->loadModel('Profile');
	    $this->loadModel('Vques');
	    $this->loadModel('Vitalskills');
	    $this->loadModel('Vs_option_type');
	    $this->loadModel('Voption');
	    $this->loadModel('Skill');
	    $this->loadModel('Uservital');
	    $this->loadModel('Users');
	    $this->loadModel('Enthicity');
	    $this->loadModel('City');
	    $this->loadModel('State');
	    $this->loadModel('Country');
	    
	    $id = $this->request->session()->read('Auth.User.id');
	    $profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	    $this->set('profile', $profile);
		 $userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id])->order(['Skillset.id' => 'DESC'])->toarray();
		$skills_set = $this->Skillset->find('all')->select(['skill_id'])->where(['Skillset.user_id' => $id])->order(['Skillset.id' => 'DESC'])->toarray();
			foreach($skills_set as $skills)
			{
				$userskills[] = $skills['skill_id'];
			}
		$vitals = '';	
		$skillfind  =  $this->Skill->find('all')->select(['id'])->where(['Skill.id IN' =>$userskills,'is_vital'=>1])->toarray();
		if(count($skillfind) > 0)
		{
			foreach($skillfind as $skillvalue)
			{
				$skillsvalue[] = $skillvalue['id'];
			}
		
		//		pr($skillsvalue); die;
		// to be removed
		$vitals = $this->Vitalskills->find('all')->contain(['Skill'])->where(['Vitalskills.skills_id IN' =>$skillsvalue,'Vitalskills.status' => 'Y'])->toarray();
		$this->set('vitals', $vitals);
		}
		
		// to be removed
		
		
		$profile = $this->Profile->find('all')->select(['gender'])->where(['user_id' => $id])->first();
			if($profile['gender']==m||$profile['gender']==f)
			{
				$vitalsquestion = $this->Vques->find('all')->contain(['Voption','Vs_option_type'])->where(['Vques.gender' =>$profile['gender']])->order(['Vques.orderstrcture' => 'ASC'])->toarray();
				$this->set('vitalsquestion', $vitalsquestion);
			}else{
				$vitalsquestion = $this->Vques->find('all')->contain(['Voption','Vs_option_type'])->order(['Vques.orderstrcture' => 'ASC'])->toarray();
				$this->set('vitalsquestion', $vitalsquestion);
			}
			
		$uservitaled = $this->Uservital->find('all')->where(['user_id' => $id])->toarray();
		$idcheck = count($uservitaled);
			if ($idcheck > 0)
			{
			$uservitals = $uservitaled;
			}
			else
			{
			$uservitals = $this->Uservital->newEntity();
			}
			$this->set('uservitals', $uservitals);
		if ($this->request->is(['post', 'put']))
		{
		//pr($this->request->data); die;
			$prop_count = count($this->request->data['data']);
			$prop_data = array();
			for ($i = 0; $i < $prop_count; $i++)
			{
				$prop_data['vs_question_id'] = $this->request->data['data'][$i]['vs_question_id'];
				$prop_data['option_type_id'] = $this->request->data['data'][$i]['vs_option_id'];
					if($this->request->data['data'][$i]['vs_option_id']==1||$this->request->data['data'][$i]['vs_option_id']==2||$this->request->data['data'][$i]['vs_option_id']==5)
					{
						$prop_data['option_value_id'] = $this->request->data['data'][$i]['value'];
						$prop_data['value'] ='';
					}else{
						$prop_data['value'] = $this->request->data['data'][$i]['value'];
						$prop_data['option_value_id'] ='';
					}
						$prop_data['user_id'] = $id;
					if ($this->request->data['data'][$i]['vitalid']!='')
					{
						$optionsweb= $this->Uservital->get($this->request->data['data'][$i]['vitalid']);
						$option_web = $this->Uservital->patchEntity($optionsweb,$prop_data);
						$savedata = $this->Uservital->save($option_web);
					}
					else
					{
						$optionsweb = $this->Uservital->newEntity();
						$option_web = $this->Uservital->patchEntity($optionsweb, $prop_data);
						$savedata = $this->Uservital->save($option_web);
					}
			}
			$this->Flash->success(__('Vital Statistics Saved Successfully!!'));
			return $this->redirect(['action' => 'vitalstatistics']);
		}
	}
	
	
	
	// vital statistics
    public function viewvitalstatistics($id = null)
    {
	$this->loadModel('State');
	$this->loadModel('City');
	$this->loadModel('Skillset');
	$this->loadModel('Country');
	$this->loadModel('Users');
	$this->loadModel('Profile');
	$this->loadModel('Vques');
	//$this->loadModel('Skillset');
	$this->loadModel('Contactrequest');
	$this->loadModel('Likes');
	$this->loadModel('Activities');
	$this->loadModel('Blocks');
	$this->loadModel('Professinal_info');
	$this->loadModel('Voption');
	$this->loadModel('Vques');
	$this->loadModel('Performance_desc');
	$this->loadModel('Uservital');
	
	$this->loadModel('Voption');
	$this->loadModel('Skill');
	
		
	$current_user_id = $this->request->session()->read('Auth.User.id');
	if($current_user_id!=$id)
	{
	    $this->set('userid', $id);
	}
	
	$content_type = 'profile';
	if(empty($id))
	{
	    $id = $current_user_id;
	}
	else
	{
	    $totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id, 'Likes.user_id'=>$current_user_id])->count();
	    $this->set('totaluserlikes', $totaluserlikes);
	    $blocks = $this->Blocks->find('all')->where(['Blocks.content_type'=>$content_type, 'Blocks.content_id'=>$id, 'Blocks.user_id'=>$current_user_id])->count();
	    $this->set('userblock', $blocks);
	}
	$totallikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id])->count();
	$this->set('totallikes', $totallikes);
	$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
	$session = $this->request->session();
	$session->write('usercheck', $userpack_check);
	$this->set('user_check', $userpack_check);
	
	$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
	$session = $this->request->session();
	$session->write('usercheck', $userpack_check);
    
	
	$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id])->order(['Skillset.id' => 'DESC'])->toarray();
	$this->set('skillofcontaint', $contentadminskillset);
	$conn = ConnectionManager::get('default');
	$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";
	$stmt = $conn->execute($fquery);
	$friends = $stmt ->fetchAll('assoc');
	$this->set('friends', $friends);
	
	// Checking Tabs to show
	$profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	$this->set('profile', $profile);
	
	$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title','Professinal_info.areyoua','Professinal_info.performing_month','Professinal_info.performing_year'])->where(['user_id' => $id])->first();
	$this->set('profile_title', $profile_title); 

	$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
	$this->set('perdes', $perdes);
	
	$uservitals = $this->Uservital->find('all')->contain(['Vques','Voption'])->where(['user_id' => $current_user_id])->toarray();
	$this->set('uservitals', $uservitals);
	
    }
	
	
    // View Persoanal Profile
    public function viewprofile($id = null)
    {
	$this->loadModel('State');
	$this->loadModel('City');
	$this->loadModel('Skillset');
	$this->loadModel('Country');
	$this->loadModel('Users');
	$this->loadModel('Profile');
	$this->loadModel('Language');
	$this->loadModel('Languageknown');
	$this->loadModel('Enthicity');
	$this->loadModel('Galleryimage');
	$this->loadModel('Skillset');
	$this->loadModel('Contactrequest');
	$this->loadModel('Likes');
	$this->loadModel('Activities');
	$this->loadModel('Blocks');
	$this->loadModel('Professinal_info');
	$this->loadModel('Performance_desc');
	$this->loadModel('Performance_desc');
	$current_user_id = $this->request->session()->read('Auth.User.id');
	$this->loadModel('Voption');
	$this->loadModel('Vques');
	$this->loadModel('Uservital');
	
	if($current_user_id!=$id)
	{
	    $this->set('userid', $id);
	}
	
	$content_type = 'profile';
	if(empty($id))
	{
	    $id = $current_user_id;
	}
	else
	{
	    $totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id, 'Likes.user_id'=>$current_user_id])->count();
	    $this->set('totaluserlikes', $totaluserlikes);
	    $blocks = $this->Blocks->find('all')->where(['Blocks.content_type'=>$content_type, 'Blocks.content_id'=>$id, 'Blocks.user_id'=>$current_user_id])->count();
	    $this->set('userblock', $blocks);
	}
    
    		
    
	//$contactrequest = $this->Contactrequest->find('all')->where(['Contactrequest.to_id'=>$id, 'Contactrequest.from_id'=>$current_user_id])->count();
	//$this->set('contactrequest', $contactrequest);
	$totallikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id])->count();
	$this->set('totallikes', $totallikes);
	
	$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
	$session = $this->request->session();
	$session->write('usercheck', $userpack_check);
	    $this->set('user_check', $userpack_check);
	
	$languageknow = $this->Languageknown->find('all')->select(['id', 'language_id','Language.name'])->contain(['Language'])->where(['Languageknown.user_id' => $id])->order(['Languageknown.id' => 'DESC'])->toarray();
	// pr($languageknow);
	$this->set('languageknow', $languageknow);
	
	// Images
	$galleryimages = $this->Galleryimage->find('all')->select(['imagename'])->where(['Galleryimage.user_id' => $id])->order(['Galleryimage.id' => 'DESC'])->limit(6)->toarray();
	$this->set('galleryimages', $galleryimages);
	
	$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id])->order(['Skillset.id' => 'DESC'])->toarray();
	$this->set('skillofcontaint', $contentadminskillset);
	
	
	$conn = ConnectionManager::get('default');
	$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";
	$stmt = $conn->execute($fquery);
	$friends = $stmt ->fetchAll('assoc');
	$this->set('friends', $friends);
	// Activities
	$activities = $this->Activities->find('all')->contain(['Galleryimage','Users'])->where(['Activities.user_id' => $id])->order(['Activities.id' => 'DESC'])->limit(10)->toarray();
	$this->set('activities', $activities);
	
	// Checking Tabs to show
	$profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	$this->set('profile', $profile);
	
	$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title','Professinal_info.areyoua','Professinal_info.performing_month','Professinal_info.performing_year'])->where(['user_id' => $id])->first();
	$this->set('profile_title', $profile_title); 

	$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
	$this->set('perdes', $perdes);
	
	$uservitals = $this->Uservital->find('all')->contain(['Vques','Voption'])->where(['user_id' => $current_user_id])->toarray();
	$this->set('uservitals', $uservitals);
    }
	
	
	
    // View Professional summery
    public function viewprofessionalsummary($id = null)
    {
	$this->loadModel('Profile');
	$this->loadModel('Contactrequest');
	$this->loadModel('Enthicity');
	$this->loadModel('State');
	$this->loadModel('City');
	$this->loadModel('Country');
	$this->loadModel('Users');
	$this->loadModel('Likes');
	$this->loadModel('Blocks');
	$this->loadModel('Professinal_info');
	$current_user_id = $this->request->session()->read('Auth.User.id');
	$this->loadModel('Voption');
	$this->loadModel('Vques');
	$this->loadModel('Uservital');
	$this->loadModel('Performance_desc');
	
	if($current_user_id!=$id)
	{
	$this->set('userid', $id);
	}
	
	$content_type = 'profile';
	if(empty($id))
	{
	    $id = $current_user_id;
	}
	else
	{
	    $totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id, 'Likes.user_id'=>$current_user_id])->count();
	    $this->set('totaluserlikes', $totaluserlikes);
	    $blocks = $this->Blocks->find('all')->where(['Blocks.content_type'=>$content_type, 'Blocks.content_id'=>$id, 'Blocks.user_id'=>$current_user_id])->count();
	    $this->set('userblock', $blocks);
	}
	$totallikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id])->count();
	$this->set('totallikes', $totallikes);
	$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
	$session = $this->request->session();
	$session->write('usercheck', $userpack_check);
	$this->set('user_check', $userpack_check);    
	$conn = ConnectionManager::get('default');
	$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";
	$stmt = $conn->execute($fquery);
	$friends = $stmt ->fetchAll('assoc');
	$this->set('friends', $friends);
		
	$this->loadModel('Prof_website');
	$this->loadModel('Prof_exprience');
	$this->loadModel('Current_working');
	
	$videoprofile = $this->Prof_website->find('all')->where(['user_id' => $id])->toarray();
	$this->set('videoprofile', $videoprofile);
	$profexp = $this->Prof_exprience->find('all')->where(['user_id' => $id])->toarray();
	$this->set('profexp', $profexp);
	$currentworking = $this->Current_working->find('all')->where(['user_id' => $id])->toarray();
	$this->set('currentworking', $currentworking);
	$profess = $this->Professinal_info->find('all')->where(['user_id' => $id])->first();
	$this->set('proff', $profess);
	
	// Checking Tabs to show
	$profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	$this->set('profile', $profile);
	
	$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title','Professinal_info.areyoua','Professinal_info.performing_month','Professinal_info.performing_year'])->where(['user_id' => $id])->first();
	$this->set('profile_title', $profile_title); 

$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
	$this->set('perdes', $perdes);
	
	$uservitals = $this->Uservital->find('all')->contain(['Vques','Voption'])->where(['user_id' => $current_user_id])->toarray();
	$this->set('uservitals', $uservitals);
    }
    
    
    public function viewperformance($id = null)
    {
	$this->loadModel('Profile');
	$this->loadModel('Contactrequest');
	$this->loadModel('Enthicity');
	$this->loadModel('Skillset');
	$this->loadModel('Skill');
	$this->loadModel('Genre');
	$this->loadModel('State');
	$this->loadModel('City');
	$this->loadModel('Country');
	$this->loadModel('Users');
	$this->loadModel('Likes');
	$this->loadModel('Blocks');
	$this->loadModel('Professinal_info');
	$this->loadModel('Genreskills');
	$current_user_id = $this->request->session()->read('Auth.User.id');
	$this->loadModel('Voption');
	$this->loadModel('Vques');
	$this->loadModel('Uservital');

	if($current_user_id!=$id)
	{
	    $this->set('userid', $id);
	}
	$content_type = 'profile';
	if(empty($id))
	{
	    $id = $current_user_id;
	}
	else
	{
	    $totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id, 'Likes.user_id'=>$current_user_id])->count();
	    $this->set('totaluserlikes', $totaluserlikes);
	    $blocks = $this->Blocks->find('all')->where(['Blocks.content_type'=>$content_type, 'Blocks.content_id'=>$id, 'Blocks.user_id'=>$current_user_id])->count();
	    $this->set('userblock', $blocks);
	}
	$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
	$session = $this->request->session();
	$session->write('usercheck', $userpack_check);
	$this->set('user_check', $userpack_check);
	
	
	$totallikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id])->count();
	$this->set('totallikes', $totallikes);
	
	$conn = ConnectionManager::get('default');
	$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";
	$stmt = $conn->execute($fquery);
	$friends = $stmt ->fetchAll('assoc');
	$this->set('friends', $friends);
		
	
	$skills_set = $this->Skillset->find('all')->select(['skill_id'])->where(['Skillset.user_id' => $id])->order(['Skillset.id' => 'DESC'])->toarray();
	//pr($contentadminskillset); die;
	foreach($skills_set as $skills)
	{
	    $userskills[] = $skills['skill_id'];

	}
	//pr($userskills);
	$genre = $this->Genreskills->find('all')->select(['Genre.id','Genre.name'])->contain(['Genre'])->where(['Genreskills.skill_id IN' => $userskills, 'Genre.parent' => 0, 'Genre.status' => 'Y'])->group('Genreskills.genre_id')->toarray();

	$this->set('genre', $genre);
	foreach($genre as $gemreres)
	{
	$gens_id[] = $gemreres['Genre']['id'];
	}
	//pr($gens_id);
	$subgenre = $this->Genre->find('all')->where(['Genre.parent IN' => $gens_id, 'status' => 'Y'])->toarray();
	//pr($subgenre);
	$this->set('subgenre', $subgenre);
	$this->loadModel('Currency');
	$this->loadModel('Performance_desc');
	$this->loadModel('Performance_genre');
	$this->loadModel('Performance_personaldetails');
	$this->loadModel('Performancedesc2');
	$this->loadModel('Performancelanguage');
	$this->loadModel('Language');
	$this->loadModel('Payment_fequency');
	$id = $this->request->session()->read('Auth.User.id');
	$lang = $this->Language->find('all')->select(['id', 'name'])->toarray();
	$this->set('lang', $lang);
	$pay_freq = $this->Payment_fequency->find('list')->select(['id', 'name'])->toarray();
	$this->set('pay_freq', $pay_freq);
	$videoprofile = $this->Performance_personaldetails->find('all')->where(['user_id' => $id])->toarray();
	$this->set('videoprofile', $videoprofile);
	
	$languageknow = $this->Performancelanguage->find('all')->select(['id', 'language_id','Language.name'])->contain(['Language'])->where(['Performancelanguage.user_id' => $id])->order(['Performancelanguage.id' => 'DESC'])->toarray();
	
	$this->set('languageknow', $languageknow);
	$performance_genre = $this->Performance_genre->find('all')->select(['id', 'genre_id'])->where(['Performance_genre.user_id' => $id, 'Performance_genre.subgenre_id' => 0])->order(['Performance_genre.id' => 'DESC'])->toarray();
	$this->set('performance_genre', $performance_genre);
	$performance_subgenre = $this->Performance_genre->find('all')->select(['id', 'subgenre_id'])->where(['Performance_genre.user_id' => $id, 'Performance_genre.genre_id' => 0])->order(['Performance_genre.id' => 'DESC'])->toarray();
	$this->set('performance_subgenre', $performance_subgenre);
	$payfrequency = $this->Performancedesc2->find('all')->contain(['Currency'])->where(['user_id' => $id])->toarray();
	//pr($payfrequency);die;
	$this->set('payfrequency', $payfrequency);
	$currency = $this->Currency->find('list')->select(['id', 'name', 'symbol'])->order(['Currency.id' => 'DESC'])->toarray();
	$this->set('currency', $currency);
    
	// Checking Tabs to show
	$profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	$this->set('profile', $profile);
	
	$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title','Professinal_info.areyoua','Professinal_info.performing_month','Professinal_info.performing_year'])->where(['user_id' => $id])->first();
	$this->set('profile_title', $profile_title); 

	
	$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
	$this->set('perdes', $perdes);
	
	
	$uservitals = $this->Uservital->find('all')->contain(['Vques','Voption'])->where(['user_id' => $current_user_id])->toarray();
	$this->set('uservitals', $uservitals);
    }
    
    // View Gallery Albums
    public function viewgalleries($id = null)
    {
	$this->loadModel('Profile');
	$this->loadModel('Contactrequest');
	$this->loadModel('Enthicity');
	$this->loadModel('Galleryimage');
	$this->loadModel('State');
	$this->loadModel('City');
	$this->loadModel('Country');
	$this->loadModel('Users');
	$this->loadModel('Likes');
	$this->loadModel('Gallery');
	$this->loadModel('Blocks');
	$this->loadModel('Professinal_info');
	$this->loadModel('Video');
	$this->loadModel('Audio');
	$this->loadModel('Performance_desc');
	
	$current_user_id = $this->request->session()->read('Auth.User.id');
	$this->loadModel('Voption');
	$this->loadModel('Vques');
	$this->loadModel('Uservital');
	if($current_user_id!=$id)
	{
	    $this->set('userid', $id);
	}
	$content_type = 'profile';
	if(empty($id))
	{
	    $id = $current_user_id;
	}
	else
	{
	    $totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id, 'Likes.user_id'=>$current_user_id])->count();
	    $this->set('totaluserlikes', $totaluserlikes);
	    $blocks = $this->Blocks->find('all')->where(['Blocks.content_type'=>$content_type, 'Blocks.content_id'=>$id, 'Blocks.user_id'=>$current_user_id])->count();
	    $this->set('userblock', $blocks);
	}
	$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
	$session = $this->request->session();
	$session->write('usercheck', $userpack_check);
	$this->set('user_check', $userpack_check);
	
	$totallikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id])->count();
	$this->set('totallikes', $totallikes);
	
	$conn = ConnectionManager::get('default');
	$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";
	$stmt = $conn->execute($fquery);
	$friends = $stmt ->fetchAll('assoc');
	$this->set('friends', $friends);
		
	// Total Photos counts
	$total_photos = $this->Galleryimage->find('all')->where(['user_id' => $id,'gallery_id'=>0])->count();
	$this->set('total_photos', $total_photos);
	//echo $total_photos;
	// Total Video counts
	$total_videos = $this->Video->find('all')->where(['user_id' => $id])->count();
	$this->set('total_videos', $total_videos);
	// Total Audios counts
	$total_audios = $this->Audio->find('all')->where(['user_id' => $id])->count();
	$this->set('total_audios', $total_audios);
    
	// Albums
	$galleryprofile = $this->Gallery->find('all')->contain(['Galleryimage'])->where(['user_id' => $id])->toarray();
	
	//pr($galleryprofile);
	
	$this->set('galleryprofile', $galleryprofile);
	
	$singleimages = $this->Galleryimage->find('all')->select(['id','imagename'])->where(['Galleryimage.user_id' => $id,'Galleryimage.gallery_id' =>'0'])->order(['Galleryimage.id' => 'DESC'])->toarray();
	//pr($singleimages);
	$this->set('singleimages', $singleimages);
	
	// Checking Tabs to show
	$profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	$this->set('profile', $profile);
	
	$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title','Professinal_info.areyoua','Professinal_info.performing_month','Professinal_info.performing_year'])->where(['user_id' => $id])->first();
	$this->set('profile_title', $profile_title); 

	$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
	$this->set('perdes', $perdes);
	
	$uservitals = $this->Uservital->find('all')->contain(['Vques','Voption'])->where(['user_id' => $current_user_id])->toarray();
	$this->set('uservitals', $uservitals);
    }
    
    // View Gallery Images
    public function viewimages($id = null,$album_id=null)
    {
	$this->loadModel('Profile');
	$this->loadModel('Contactrequest');
	$this->loadModel('Enthicity');
	$this->loadModel('Galleryimage');
	$this->loadModel('State');
	$this->loadModel('City');
	$this->loadModel('Country');
	$this->loadModel('Users');
	$this->loadModel('Likes');
	$this->loadModel('Blocks');
	$this->loadModel('Gallery');
	$this->loadModel('Professinal_info');
	$this->loadModel('Video');
	$this->loadModel('Audio');
	$this->loadModel('Voption');
	$this->loadModel('Vques');
	$this->loadModel('Uservital');
	$this->loadModel('Performance_desc');
	
	$galleryalbumname = $this->Gallery->find('all')->where(['Gallery.id' => $album_id])->first();
	$this->set('galleryalbumname', $galleryalbumname);
	
	$current_user_id = $this->request->session()->read('Auth.User.id');
	if($current_user_id!=$id)
	{
	$this->set('userid', $id);
	}
	$content_type = 'profile';
	if(empty($id))
	{
	    $id = $current_user_id;
	}
	else
	{
	    $totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id, 'Likes.user_id'=>$current_user_id])->count();
	    $this->set('totaluserlikes', $totaluserlikes);
	    $blocks = $this->Blocks->find('all')->where(['Blocks.content_type'=>$content_type, 'Blocks.content_id'=>$id, 'Blocks.user_id'=>$current_user_id])->count();
	    $this->set('userblock', $blocks);
	}
	
	$totallikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id])->count();
	$this->set('totallikes', $totallikes);
	
	$conn = ConnectionManager::get('default');
	$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";
	$stmt = $conn->execute($fquery);
	$friends = $stmt ->fetchAll('assoc');
	$this->set('friends', $friends);
	    
	$this->set('album_id', $album_id);
	
	$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
	
	// Albums Photos
	$galleryimages = $this->Galleryimage->find('all')->select(['imagename','caption'])->where(['Galleryimage.gallery_id' => $album_id])->order(['Galleryimage.id' => 'DESC'])->toarray();
	$this->set('galleryimages', $galleryimages);
	
	$userimages = $this->Galleryimage->find('all')->select(['imagename','caption'])->where(['Galleryimage.gallery_id' => $album_id])->order(['Galleryimage.id' => 'DESC'])->toarray();
	$this->set('galleryimages', $galleryimages);
	
	// Total Photos counts
	$total_photos = $this->Galleryimage->find('all')->where(['user_id' => $id,'gallery_id'=>0])->count();
	$this->set('total_photos', $total_photos);
	//echo $total_photos;
	// Total Video counts
	$total_videos = $this->Video->find('all')->where(['user_id' => $id])->count();
	$this->set('total_videos', $total_videos);
	// Total Audios counts
	$total_audios = $this->Audio->find('all')->where(['user_id' => $id])->count();
	$this->set('total_audios', $total_audios);
	
	
	// Checking Tabs to show
	$profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	$this->set('profile', $profile);
	
	$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title','Professinal_info.areyoua','Professinal_info.performing_month','Professinal_info.performing_year'])->where(['user_id' => $id])->first();
	$this->set('profile_title', $profile_title); 

	$proff = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
	$this->set('proff', $proff);
	
	$uservitals = $this->Uservital->find('all')->contain(['Vques','Voption'])->where(['user_id' => $current_user_id])->toarray();
	$this->set('uservitals', $uservitals);
	
	
    }
    
    // View Gallery Audios
    public function viewaudios($id = null)
    {
	$this->loadModel('Profile');
	$this->loadModel('Contactrequest');
	$this->loadModel('Enthicity');
	$this->loadModel('Galleryimage');
	$this->loadModel('State');
	$this->loadModel('City');
	$this->loadModel('Country');
	$this->loadModel('Users');
	$this->loadModel('Likes');
	$this->loadModel('Audio');
	$this->loadModel('Video');
	$this->loadModel('Blocks');
	$this->loadModel('Professinal_info');
	$this->loadModel('Voption');
	$this->loadModel('Vques');
	$this->loadModel('Uservital');
	$this->loadModel('Performance_desc');
	$this->set('userid', $id);
	$current_user_id = $this->request->session()->read('Auth.User.id');
	if($current_user_id!=$id)
	{
	    $this->set('profile_id', $id);
	}
	$content_type = 'profile';
	if(empty($id))
	{
	    $id = $current_user_id;
	}
	else
	{
	    $totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id, 'Likes.user_id'=>$current_user_id])->count();
	    $this->set('totaluserlikes', $totaluserlikes);
	    $blocks = $this->Blocks->find('all')->where(['Blocks.content_type'=>$content_type, 'Blocks.content_id'=>$id, 'Blocks.user_id'=>$current_user_id])->count();
	    $this->set('userblock', $blocks);
	}
	
	$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
	$session = $this->request->session();
	$session->write('usercheck', $userpack_check);
	$this->set('user_check', $userpack_check);
	$totallikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id])->count();
	$this->set('totallikes', $totallikes);
	 
	$conn = ConnectionManager::get('default');
	$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";
	$stmt = $conn->execute($fquery);
	$friends = $stmt ->fetchAll('assoc');
	$this->set('friends', $friends);
		
	// Photos
	$galleryimages = $this->Galleryimage->find('all')->select(['imagename','caption'])->where(['Galleryimage.user_id' => $id])->order(['Galleryimage.id' => 'DESC'])->toarray();
	$this->set('galleryimages', $galleryimages);
	
	// Audios
	$audios = $this->Audio->find('all')->select(['audio_link','audio_type'])->where(['Audio.user_id' => $id])->order(['Audio.id' => 'DESC'])->limit(6)->toarray();
	$this->set('audios', $audios);
	
	// Videos
	$videos = $this->Video->find('all')->select(['video_name','video_type','thumbnail'])->where(['Video.user_id' => $id])->order(['Video.id' => 'DESC'])->limit(6)->toarray();
	$this->set('videos', $videos);
	
	
	// Total Photos counts
	$total_photos = $this->Galleryimage->find('all')->where(['user_id' => $id,'gallery_id'=>0])->count();
	$this->set('total_photos', $total_photos);
	//echo $total_photos;
	// Total Video counts
	$total_videos = $this->Video->find('all')->where(['user_id' => $id])->count();
	$this->set('total_videos', $total_videos);
	// Total Audios counts
	$total_audios = $this->Audio->find('all')->where(['user_id' => $id])->count();
	$this->set('total_audios', $total_audios);
	
	// Checking Tabs to show
	$profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	$this->set('profile', $profile);
	
	$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title','Professinal_info.areyoua','Professinal_info.performing_month','Professinal_info.performing_year'])->where(['user_id' => $id])->first();
	$this->set('profile_title', $profile_title); 

	$proff = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
	$this->set('proff', $proff);
	
	$uservitals = $this->Uservital->find('all')->contain(['Vques','Voption'])->where(['user_id' => $current_user_id])->toarray();
	$this->set('uservitals', $uservitals);
    }
    
    // View Gallery Videos
    public function viewvideos($id = null)
    {
	$this->loadModel('Profile');
	$this->loadModel('Contactrequest');
	$this->loadModel('Enthicity');
	$this->loadModel('Galleryimage');
	$this->loadModel('State');
	$this->loadModel('City');
	$this->loadModel('Country');
	$this->loadModel('Users');
	$this->loadModel('Likes');
	$this->loadModel('Audio');
	$this->loadModel('Video');
	$this->loadModel('Blocks');
	$this->loadModel('Professinal_info');
	$this->loadModel('Performance_desc');
	
	$current_user_id = $this->request->session()->read('Auth.User.id');
	if($current_user_id!=$id)
	{
	    $this->set('userid', $id);
	}
	$content_type = 'profile';
	if(empty($id))
	{
	    $id = $current_user_id;
	}
	else
	{
	    $totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id, 'Likes.user_id'=>$current_user_id])->count();
	    $this->set('totaluserlikes', $totaluserlikes);
	    $blocks = $this->Blocks->find('all')->where(['Blocks.content_type'=>$content_type, 'Blocks.content_id'=>$id, 'Blocks.user_id'=>$current_user_id])->count();
	    $this->set('userblock', $blocks);
	}
	$this->loadModel('Voption');
	$this->loadModel('Vques');
	$this->loadModel('Uservital');
    
	$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
	$session = $this->request->session();
	$session->write('usercheck', $userpack_check);
	$this->set('user_check', $userpack_check);
	$totallikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id])->count();
	$this->set('totallikes', $totallikes);
	
	$conn = ConnectionManager::get('default');
	$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";
	$stmt = $conn->execute($fquery);
	$friends = $stmt ->fetchAll('assoc');
	$this->set('friends', $friends);
		
	// Photos
	$galleryimages = $this->Galleryimage->find('all')->select(['imagename','caption'])->where(['Galleryimage.user_id' => $id])->order(['Galleryimage.id' => 'DESC'])->toarray();
	$this->set('galleryimages', $galleryimages);
	
	// Audios
	$audios = $this->Audio->find('all')->select(['audio_link','audio_type'])->where(['Audio.user_id' => $id])->order(['Audio.id' => 'DESC'])->limit(6)->toarray();
	$this->set('audios', $audios);
	
	// Videos
	$videos = $this->Video->find('all')->select(['video_name','video_type','thumbnail','id'])->where(['Video.user_id' => $id])->order(['Video.id' => 'DESC'])->limit(6)->toarray();
	$this->set('videos', $videos);
	
	// Total Photos counts
	$total_photos = $this->Galleryimage->find('all')->where(['user_id' => $id,'gallery_id'=>0])->count();
	$this->set('total_photos', $total_photos);
	//echo $total_photos;
	// Total Video counts
	$total_videos = $this->Video->find('all')->where(['user_id' => $id])->count();
	$this->set('total_videos', $total_videos);
	// Total Audios counts
	$total_audios = $this->Audio->find('all')->where(['user_id' => $id])->count();
	$this->set('total_audios', $total_audios);
	
	// Checking Tabs to show
	$profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	$this->set('profile', $profile);
	
	$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title','Professinal_info.areyoua','Professinal_info.performing_month','Professinal_info.performing_year'])->where(['user_id' => $id])->first();
	$this->set('profile_title', $profile_title); 

	$proff = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
	$this->set('proff', $proff);
	
	$uservitals = $this->Uservital->find('all')->contain(['Vques','Voption'])->where(['user_id' => $current_user_id])->toarray();
	$this->set('uservitals', $uservitals);
    }
    
    
    
    
    
    // Like Profile
    public function likeprofile()
    {
	$this->loadModel('Users');
	$this->loadModel('Likes');
	$error='';
	if ($this->request->is(['post', 'put']))
	{
	    $id = $this->request->session()->read('Auth.User.id');
	    $user_id = $this->request->data['user_id'];
	    if($id==$user_id)
	    {
		$error='1';
	    }
	    else
	    {
		$content_type = 'profile';
		$likedata['content_id'] = $user_id;
		$likedata['user_id'] = $id;
		$likedata['content_type'] = $content_type;
		$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$user_id, 'Likes.user_id'=>$id])->count();
		if($totaluserlikes > 0)
		{
		    $this->Likes->deleteAll(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$user_id, 'Likes.user_id'=>$id]);
		    $status='dislike';
		    $this->addactivity($userid, 'unlike_profile', $user_id);
		}
		else
		{
		    $proff = $this->Likes->newEntity();
		    $likes = $this->Likes->patchEntity($proff, $likedata);
		    $savelike = $this->Likes->save($likes);
		    $status='like';
		    $this->addactivity($userid, 'like_profile', $user_id);
		}
		$totallikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$user_id])->count();
	    }
	    $response['error'] = $error;
	    $response['status']=$status;
	    $response['count']=$totallikes;
	    echo json_encode($response); die;
	}
    }
    



     // Like Job
    public function likejob()
    {
	$this->loadModel('Users');
	$this->loadModel('Likes');
	$error='';
	if ($this->request->is(['post', 'put']))
	{
	    $id = $this->request->session()->read('Auth.User.id');
	    $user_id = $this->request->data['user_id'];
	    if($id==$user_id)
	    {
		$error='1';
	    }
	    else
	    {
		$content_type = 'job_profile';
		$likedata['content_id'] = $user_id;
		$likedata['user_id'] = $id;
		$likedata['content_type'] = $content_type;
		$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$user_id, 'Likes.user_id'=>$id])->count();
		if($totaluserlikes > 0)
		{
		    $this->Likes->deleteAll(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$user_id, 'Likes.user_id'=>$id]);
		    $status='dislike';
		    $this->addactivity($userid, 'unlike_job_profile', $user_id);
		}
		else
		{
		    $proff = $this->Likes->newEntity();
		    $likes = $this->Likes->patchEntity($proff, $likedata);
		    $savelike = $this->Likes->save($likes);
		    $status='like';
		    $this->addactivity($userid, 'like_job_profile', $user_id);
		}
		$totallikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$user_id])->count();
	    }
	    $response['error'] = $error;
	    $response['status']=$status;
	    $response['count']=$totallikes;
	    echo json_encode($response); die;
	}
    }
    // Like Profile
    public function blockprofile()
    {
	$this->loadModel('Users');
	$this->loadModel('Blocks');
	$error = '';
	if ($this->request->is(['post', 'put']))
	{
	    $id = $this->request->session()->read('Auth.User.id');
	    $user_id = $this->request->data['user_id'];
	   // echo $id.'---'.$user_id;
	    if($id==$user_id)
	    {
		$error = "1";
	    }
	    else
	    {
		$content_type = 'profile';
		$blockdata['content_id'] = $user_id;
		$blockdata['user_id'] = $id;
		$blockdata['content_type'] = $content_type;
		$blocks = $this->Blocks->find('all')->where(['Blocks.content_type'=>$content_type, 'Blocks.content_id'=>$user_id, 'Blocks.user_id'=>$id])->count();
		if($blocks > 0)
		{
		    $this->Blocks->deleteAll(['Blocks.content_type'=>$content_type, 'Blocks.content_id'=>$user_id, 'Blocks.user_id'=>$id]);
		    $status='unblock';
		    $this->addactivity($id, 'unblock_profile', $user_id);
		}
		else
		{
		    $proff = $this->Blocks->newEntity();
		    $blockp = $this->Blocks->patchEntity($proff, $blockdata);
		    $savelike = $this->Blocks->save($blockp);
		    $status='block';
		    $this->addactivity($id, 'block_profile', $user_id);
		}
	    }
	    $response['error']= $error;
	    $response['status']=$status;
	    echo json_encode($response); die;
	}
    }
    
    // Add activity
    public function addactivity($user_id, $activity_type, $content_id)
    {
	$this->loadModel('Activities');
	$activity_data['activity_type'] = $activity_type;
	$activity_data['user_id'] = $user_id;
	if($activity_type='update_photos')
	{
	    $activity_data['photo_id'] = $content_id;
	}
	else if($activity_type='update_profile')
	{
	    
	}
	else if($activity_type='block_profile')
	{
	    $activity_data['profile_id'] = $content_id;
	}
	else if($activity_type='like_profile')
	{
	    $activity_data['profile_id'] = $content_id;
	}
	else if($activity_type='unlike_profile')
	{
	   $activity_data['profile_id'] = $content_id;
	}
	
	$activity = $this->Activities->newEntity();
	$activity = $this->Activities->patchEntity($activity, $activity_data);
	$savelike = $this->Activities->save($activity);
	return true;
    }
    
   
    
    
    // Update captions
    public function updateimagecaption()
    {
	//$this->set('id', $id);
	$this->autoRender=false;
	$userid = $this->request->session()->read('Auth.User.id');
	$this->loadModel('Galleryimage');
	if ($this->request->is(['post', 'put']))
	{
	    if($this->request->data['image_id'] != '')
	    {
		$cpation['image_id'] = $this->request->data['image_id'];
		$cpation['album_id'] = $this->request->data['album_id'];
		$cpation['caption'] = $this->request->data['caption'];
		$galleryimage = $this->Galleryimage->get($cpation['image_id']);
		$transports = $this->Galleryimage->patchEntity($galleryimage, $cpation);
		if ($resu=$this->Galleryimage->save($transports)) {
		    $this->Flash->success(__('Caption for the image has been uploaded Successfully!!'));
		    return $this->redirect(['action' => 'images/' . $cpation['album_id']]);
		}
	    }
	}
    }
    
    
     public function showalbumimages($id = null,$album_id=null)
     {
	$this->loadModel('Profile');
	$this->loadModel('Contactrequest');
	$this->loadModel('Enthicity');
	$this->loadModel('Galleryimage');
	$this->loadModel('State');
	$this->loadModel('City');
	$this->loadModel('Country');
	$this->loadModel('Users');
	$this->loadModel('Likes');
	$this->loadModel('Blocks');
	$this->loadModel('Gallery');
	$this->loadModel('Professinal_info');
	$this->set('album_id', $album_id);
	$galleryalbumname = $this->Gallery->find('all')->where(['Gallery.id' => $album_id])->first();
	$this->set('galleryalbumname', $galleryalbumname);
	
	$current_user_id = $this->request->session()->read('Auth.User.id');
	if($current_user_id!=$id)
	{
	    $this->set('userid', $id);
	}
	$content_type = 'profile';
	if(empty($id))
	{
	    $id = $current_user_id;
	}
	else
	{
	}
		
	// Photos
	$galleryimages = $this->Galleryimage->find('all')->select(['id','imagename','caption'])->where(['Galleryimage.gallery_id' => $album_id])->order(['Galleryimage.id' => 'DESC'])->toarray();
	$this->set('galleryimages', $galleryimages);
     }
     
     
    public function showsingleimages($id = null, $imageid = null)
    {
	$this->loadModel('Profile');
	$this->loadModel('Contactrequest');
	$this->loadModel('Enthicity');
	$this->loadModel('Galleryimage');
	$this->loadModel('State');
	$this->loadModel('City');
	$this->loadModel('Country');
	$this->loadModel('Users');
	$this->loadModel('Likes');
	$this->loadModel('Blocks');
	$this->loadModel('Gallery');
	$this->loadModel('Professinal_info');
	$current_user_id = $this->request->session()->read('Auth.User.id');
	if($current_user_id!=$id)
	{
	    $this->set('userid', $id);
	}
	if(empty($id))
	{
	    $id = $current_user_id;
	}
	else
	{
	}
	// Photos
	$this->set('imageid', $imageid);
	$singleimages = $this->Galleryimage->find('all')->select(['id','imagename'])->where(['Galleryimage.user_id' => $id,'Galleryimage.gallery_id' =>'0'])->order(['Galleryimage.id' => 'DESC'])->toarray();
	//pr($singleimages);die;
	$this->set('singleimages', $singleimages);
    }
    
      public function viewschedule($id=null)
    {
	$this->loadModel('Profile');
	$this->loadModel('Contactrequest');
	$this->loadModel('Enthicity');
	$this->loadModel('Galleryimage');
	$this->loadModel('State');
	$this->loadModel('City');
	$this->loadModel('Country');
	$this->loadModel('Users');
	$this->loadModel('Likes');
	$this->loadModel('Gallery');
	$this->loadModel('Blocks');
	$this->loadModel('Professinal_info');
	$this->loadModel('Calendar');
	$current_user_id = $this->request->session()->read('Auth.User.id');
	$this->loadModel('Voption');
	$this->loadModel('Vques');
	$this->loadModel('Uservital');
	$this->loadModel('Performance_desc');
	   
	if($current_user_id!=$id)
	{
	    $this->set('userid', $id);
	}
	$content_type = 'profile';
	if(empty($id))
	{
	    $id = $current_user_id;
	}
	else
	{
	    $totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id, 'Likes.user_id'=>$current_user_id])->count();
	    $this->set('totaluserlikes', $totaluserlikes);
	    $blocks = $this->Blocks->find('all')->where(['Blocks.content_type'=>$content_type, 'Blocks.content_id'=>$id, 'Blocks.user_id'=>$current_user_id])->count();
	    $this->set('userblock', $blocks);
	}
	
	$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
	$totallikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id])->count();
	$this->set('totallikes', $totallikes);
	$conn = ConnectionManager::get('default');
	$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";
	$stmt = $conn->execute($fquery);
	$friends = $stmt ->fetchAll('assoc');
	$this->set('friends', $friends);
	// Checking Tabs to show
	$profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	//pr($profile); die;
	$this->set('profile', $profile);
	$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title','Professinal_info.areyoua','Professinal_info.performing_month','Professinal_info.performing_year'])->where(['user_id' => $id])->first();
	$this->set('profile_title', $profile_title); 

	$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
	$this->set('perdes', $perdes);
	
	
	$uservitals = $this->Uservital->find('all')->contain(['Vques','Voption'])->where(['user_id' => $current_user_id])->toarray();
	$this->set('uservitals', $uservitals);
	
		//pr($currentdate);
	
	
	
	//Reminder
	$reminderevent = $this->Calendar->find('all')->where(['Calendar.type' =>'RE','Calendar.user_id' =>$current_user_id ])->toarray();
	$this->set('reminderevent', $reminderevent);
	
	//ToDo
	$todoevent = $this->Calendar->find('all')->where(['Calendar.type' =>'TD','Calendar.user_id' => $current_user_id])->toarray();
	$this->set('todoevent', $todoevent);
	
	//Events
	$userevent = $this->Calendar->find('all')->where(['Calendar.type' =>'EV','Calendar.user_id' =>$current_user_id])->toarray();
	$this->set('userevent', $userevent);
	
	//Bookings
	$bookingevent = $this->Calendar->find('all')->where(['Calendar.type' =>'RQ','Calendar.user_id' => $current_user_id])->toarray();
	$this->set('bookingevent', $bookingevent);
	
	
    }
    
    
    public function viewreviews($id=null)
    {
	$this->loadModel('Profile');
	$this->loadModel('Contactrequest');
	$this->loadModel('Enthicity');
	$this->loadModel('Galleryimage');
	$this->loadModel('State');
	$this->loadModel('City');
	$this->loadModel('Country');
	$this->loadModel('Users');
	$this->loadModel('Likes');
	$this->loadModel('Gallery');
	$this->loadModel('Blocks');
	$this->loadModel('Professinal_info');
	$current_user_id = $this->request->session()->read('Auth.User.id');
	$this->loadModel('Voption');
	$this->loadModel('Vques');
	$this->loadModel('Uservital');
	$this->loadModel('Performance_desc');
	$this->loadModel('Review');
	$this->loadModel('JobApplication');
if($id > 0)
	    {
		$us_id = $id;
	    }
	    else
	    {
		$us_id = $this->request->session()->read('Auth.User.id');
	    }
	    
	    
	    
	if($current_user_id!=$id)
	{
	    $this->set('userid', $id);
	}
	$content_type = 'profile';
	if(empty($id))
	{
	    $id = $current_user_id;
	}
	else
	{
	    $totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id, 'Likes.user_id'=>$current_user_id])->count();
	    $this->set('totaluserlikes', $totaluserlikes);
	    $blocks = $this->Blocks->find('all')->where(['Blocks.content_type'=>$content_type, 'Blocks.content_id'=>$id, 'Blocks.user_id'=>$current_user_id])->count();
	    $this->set('userblock', $blocks);
	}
	//Excellent Review
	$excellentreviews = array('8.8','8.9','9.0','9.1','9.2','9.3','9.4','9.6','9.7','9.8','9.9','10');
	$excellentreview = $this->Review->find('all')->contain(['Requirement','Users'=>['Profile']])->where(['Review.artist_id' => $us_id,'Review.avgrating IN'=>$excellentreviews])->count();
	$this->set('excellentreview', $excellentreview);
	//Good
	$goodreviews = array('6.8','6.9','7.0','7.1','7.2','7.3','7.4','7.5','7.6','7.7','7.8','7.9','8.0','8.1','8.2','8.3','8.4','8.5','8.6','8.7');
	$goodreview = $this->Review->find('all')->contain(['Requirement','Users'=>['Profile']])->where(['Review.artist_id' => $us_id,'Review.r1 IN'=>$goodreviews,'Review.avgrating IN'=>$goodreviews])->count();
    $this->set('goodreview', $goodreview);
	//Average
	$averagereviews = array('4.8','4.9','5.0','5.1','5.2','5.3','5.4','5.5','5.6','5.7','5.8','5.9','6.0','6.1','6.2','6.3','6.4','6.5','6.5','6.5','6.5','6.5','6.5','6.0','6.1','6.2','6.3','6.4','6.5','6.6','6.7');
	$averagereview = $this->Review->find('all')->contain(['Requirement','Users'=>['Profile']])->where(['Review.artist_id' => $us_id,'Review.avgrating IN'=>$averagereviews])->count();
	$this->set('averagereview', $averagereview);

	//Below Average
	$belowavgreviews = array('2.8','2.9','3.0','3.1','3.2','3.3','3.4','3.5','3.6','3.7','3.8','3.9','4.0','4.1','4.2','4.3','4.4','4.5','4.6','4.7',);
	$belowavgreview = $this->Review->find('all')->contain(['Requirement','Users'=>['Profile']])->where(['Review.artist_id' =>$us_id,'Review.avgrating IN'=>$belowavgreviews])->count();
	$this->set('belowavgreview', $belowavgreview);

	//Bad
	$badreviews = array('0.5','0.6','0.7','0.8','0.9','1.0','1.1','1.2','1.3','1.4','1.5','1.6','1.7','1.8','1.9','2.0','2.1','2.2','2.3','2.4','2.5','2.6','2.7');
	$badreview = $this->Review->find('all')->contain(['Requirement','Users'=>['Profile']])->where(['Review.artist_id' => $us_id,'Review.avgrating IN'=>$badreviews])->count();
	$this->set('badreview', $badreview);

	//,'Review.r2 IN'=>$badreviews,'Review.r3 IN'=>$badreviews,'Review.r4 IN'=>$badreviews,'Review.r5 IN'=>$badreviews,'Review.r6 IN'=>$badreviews,'Review.r7 IN'=>$badreviews,'Review.r8 IN'=>$badreviews

	$review = $this->Review->find('all')->contain(['Requirement','Users'=>['Profile']])->where(['Review.artist_id' =>$us_id])->toarray();
	$this->set('review', $review);
	$totaljobcount = count($review);
	  foreach($review as $rev)
	  {
		$totalrating[]= $rev['avgrating']; 
	  }
$totalreviewcount=  array_sum($totalrating);
$alljobcount = $totalreviewcount/ $totaljobcount; 
//echo $alljobcount;
$jobavgreview= round($alljobcount,1); 
$this->set('jobavgreview', $jobavgreview);
	
	
	$totallikes = $this->Likes->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id])->count();
	$this->set('totallikes', $totallikes);
	$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
	 $conn = ConnectionManager::get('default');
	    $fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";
	    $stmt = $conn->execute($fquery);
	    $friends = $stmt ->fetchAll('assoc');
	    $this->set('friends', $friends);
		
	$profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	$this->set('profile', $profile);
	
	// Checking Tabs to show
	$profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $id])->first();
	$this->set('profile', $profile);
	
	$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title','Professinal_info.areyoua','Professinal_info.performing_month','Professinal_info.performing_year'])->where(['user_id' => $id])->first();
	$this->set('profile_title', $profile_title); 

	$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
	$this->set('perdes', $perdes);
	
	$uservitals = $this->Uservital->find('all')->contain(['Vques','Voption'])->where(['user_id' => $current_user_id])->toarray();
	$this->set('uservitals', $uservitals);
	
	
	$jobdetail = $this->JobApplication->find('all')->contain(['Requirement','Skill','Users'=>['Skillset'=>['Skill'],'Profile','Professinal_info']])->where(['JobApplication.user_id'=>$us_id])->order(['JobApplication.id' => 'DESC'])->first();
		$this->set('jobdetail', $jobdetail);
	//	pr($jobdetail);
	
    }
    
	
	
	
	public function getAudio(){
	$response=array();
	//pr($this->request->data); 
		$url=$this->request->data['url'];	
		
		$videourls=array('soundcloud.com','www.pandora.com','www.reverbnation.com','tidal.com','music.yandex.ru','itunes',' amazon music','google play','spotify.com','playlist.com','myspace.com','hypem.com','youtube.com','tindeck.com','freesound.org','archive.org','discogs.com','musica.com','mp3.zing.vn','deezer.com','zaycev.net','bandcamp.com','nhaccuatui.com','letras.mus.br','pitchfork.com','last.fm','zamunda.net','xiami.com','palcomp3.com','cifraclub.com.br','biqle.ru','suamusica.com.br','ulub.pl');
		$parurl=parse_url($url);
		if(in_array($parurl['host'],$videourls)){
		$response['status']=1;
	}else{
		$response['status']=0;
	}
		echo json_encode($response); 
		die;
	}	  

	
    public function getVideo(){
	$response=array();
	$url=$this->request->data['url'];	$videourls=array('www.youtube.com','vimeo.com','www.dailymotion.com','www.veoh.com','myspace.com','vine.co','www.ustream.tv','www.kankan.com','www.break.com','www.metacafe.com','wwitv.com','www.tv.com','www.vh1.com','www.iqiyi.com','www.pptv.com','tv.sohu.com','yandex.com','youku.com','www.ku6.com','www.nicovideo.jp','www.pandora.tv','www.vbox7.com','tu.tv','fc2.com','www.babble.com');
	$parurl=parse_url($url);
	if(in_array($parurl['host'],$videourls)){
	if($parurl['host']==$videourls[0]){
	function getYouTubeThumbnailImage($video_id) {
	return  "https://img.youtube.com/vi/$video_id/hqdefault.jpg"; 
	}
	preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$url,$matches);
	$id = $matches[1]; 
	$response['image']=getYouTubeThumbnailImage($id);
	$response['status']=1;
	}
	else if($parurl['host']==$videourls[1])
	{
	function getVimeoThumb($id){
	$arr_vimeo = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"));
	return $arr_vimeo[0]['thumbnail_medium'];
	}
	$vid=end(explode('/', $parurl['path']));
	$response['image']=getVimeoThumb($vid);
	$response['status']=1;
	}
	else if($parurl['host']==$videourls[2])
	{


	function getDailymotionThumb($id) {
	    $thumbnail_medium_url='https://api.dailymotion.com/video/'.$id.'?fields=thumbnail_medium_url'; 
	    $json_thumbnail = file_get_contents($thumbnail_medium_url);
	    $arr_dailymotion = json_decode($json_thumbnail, TRUE);
	    $thumb=$arr_dailymotion['thumbnail_medium_url'];
	    return  $thumb;   
	}

	$daily=end(explode('/', $parurl['path']));
	getDailymotionThumb($daily);
	$response['image']=getDailymotionThumb($daily);
	$response['status']=1;
	}

	else if($parurl['host']==$videourls[5])
	{
	    function get_vine_thumbnail( $id )
	    {
		$vine = file_get_contents("http://vine.co/v/{$id}");
		preg_match('/property="og:image" content="(.*?)"/', $vine, $matches);
		return ($matches[1]) ? $matches[1] : false;
	    }
	    $vinevideo=explode('/', $parurl['path']);
	    $response['image']=get_vine_thumbnail($vinevideo[2]);
	    $response['status']=1;
	}
	}else{
	    $response['status']=0;
	}
	echo json_encode($response); 
	die;

	}	  

public function audiodetail($id){
	$this->loadModel('Audio');
	try {
	    $audio = $this->Audio->find('all')->where(['Audio.id'=>$id])->first()->toarray();
	    $this->set('audio',$audio);
	}
	catch (FatalErrorException $e) {
	    $this->log("Error Occured", 'error');
	}
    }

    public function detail($id){
	$this->loadModel('Video');
	try {
	    $video = $this->Video->find('all')->where(['Video.id'=>$id])->first()->toarray();
	    $this->set('video',$video);
	}
	catch (FatalErrorException $e) {
	    $this->log("Error Occured", 'error');
	}
    }
	
	
	
	
	
	
    public function contactrequestnoti()
    {
	$this->loadModel('Contactrequest');
	$this->loadModel('Users');
	$this->loadModel('Profile');

	$uid = $this->request->session()->read('Auth.User.id');

	$conn = ConnectionManager::get('default');
	$frnds = "SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$uid."' and c.accepted_status='N' and c.deletestatus='N'";
	$frnds_data = $conn->execute($frnds);
	$notifications = $frnds_data->fetchAll('assoc');   
	
	$this->set('contatrequest',$notifications);
	$users= TableRegistry::get('Contactrequest');
	$status="Y";
	$con = ConnectionManager::get('default');
	$detail = 'UPDATE `contactrequest` SET `viewedstatus` ="'.$status.'" WHERE `contactrequest`.`to_id` = '. $uid;
	$results = $con->execute($detail);
    }
	
	
    // Manager frirneds
    public function managefriends()
    {
	$this->loadModel('Contactrequest');
	
	$response['status'] = "1";
	$response['error_text'] = "";
	if ($this->request->is(['post', 'put']))
	{
	    $current_user_id = $this->request->session()->read('Auth.User.id');
	    $user_id = $this->request->data['user_id'];
	    $action = $this->request->data['action'];
	    if($current_user_id==$user_id)
	    {
		$response['status'] = "0";
		$response['error_text'] = "error in script";
	    }
	    else
	    {
		$connect_status =  $this->Contactrequest->find('all')->where(['from_id' => $user_id,'to_id' =>$current_user_id])->orWhere(['from_id' => $current_user_id,'to_id' =>$user_id])->first(); 
		if(count($connect_status) > 0)
		{
		   // echo $connect_status['id'];
		    $connects = $this->Contactrequest->get($connect_status['id']);
		    if($action=='confirm')
		    {
			$connect_data['accepted_status'] = 'Y';
			$connection_data = $this->Contactrequest->patchEntity($connects, $connect_data);
			$savedata = $this->Contactrequest->save($connection_data);
		    }
		    elseif($action=='reject')
		    {
			$this->Contactrequest->delete($connects);
		    }
		    elseif($action=='cancel')
		    {
			$this->Contactrequest->delete($connects);
		    }
		    elseif($action=='remove')
		    {
			$this->Contactrequest->delete($connects);
		    }
		    $response['status'] = "1";
		    $response['error_text'] = "";
		}
		else
		{
		    $connect_status['from_id'] = $current_user_id;
		    $connect_status['to_id'] = $user_id;
		    $connects = $this->Contactrequest->newEntity();
		    $connection_data = $this->Contactrequest->patchEntity($connects, $connect_status);
		    $savedata = $this->Contactrequest->save($connection_data);
		    $response['status'] = "1";
		    $response['error_text'] = "";
		}
	    }
	    echo json_encode($response); die;
	}
    }
	
	
	public function videosonline($id)

		{
		$this->loadModel('Video');
		$videos = $this->Video->find('all')->where(['Video.id'=>$id])->toarray();
		$this->set('videos', $videos);
		}
	
	
	
	
	// Showing Plans for making profile as featured profiles. 
	function featureprofile()
	{
	    $this->loadModel('Featuredprofile');
	    
	    $current_user_id = $this->request->session()->read('Auth.User.id');
	    // Find featured job packages
	    $featuredprofile = $this->Featuredprofile->find('all')->where(['Featuredprofile.status'=>'Y'])->order(['Featuredprofile.priorites' => 'ASC'])->toarray();
	    $this->set('featuredprofile', $featuredprofile);
	    $this->set('profile_id', $current_user_id);
	    
	    /*$activeprofiles = $this->Users->find('all')->contain(['RequirmentVacancy'=>['Skill'],'Country','State','City'])->where(['Requirement.id' =>$jobid])->first();
	    $city = $activeprofiles['city_id'];
	    $state = $activeprofiles['state_id'];
	    $country = $activeprofiles['country_id'];
	    $loc_lat = $activeprofiles['latitude'];
	    $loc_long = $activeprofiles['longitude'];
	    
	    $sex = array();
	    $skills = array();
	    $current_time = time();
	    $currentdate=date('Y-m-d H:m:s');
	    $featured = 0;
	    if($activeprofiles['expiredate'] > $currentdate)
	    {
		$featured = 1;
	    }
	    $this->set('featured', $featured);
	    
	    foreach($activeprofiles->requirment_vacancy as $vacancies)
	    {
		if(!in_array($vacancies->sex,$sex))
		{
		    $sex[] = $vacancies->sex; 
		}
		if(!in_array($vacancies->skill->id,$skills))
		{
		    $skills[] = $vacancies->skill->id; 
		}
	    } */
	}
	
	

} 
