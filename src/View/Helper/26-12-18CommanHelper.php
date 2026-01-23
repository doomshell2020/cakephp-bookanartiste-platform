<?php 
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
class CommanHelper extends Helper
{

    // initialize() hook is available since 3.2. For prior versions you can
    // override the constructor if required.
    public function initialize(array $config)
    {

     
    }
    
    public function gettimetable($ttid, $weekday, $classectionid)
    {
	// Use the HTML helper to output
	// Formatted data:
	$articles = TableRegistry::get('ClasstimeTabs');
	// Start a new query.
	return $articles->find('all')->contain(['Employees','Subjects'])->where(['ClasstimeTabs.weekday' => $weekday,'ClasstimeTabs.tt_id' =>$ttid,'ClasstimeTabs.class_id' => $classectionid])->toArray();
    }
    
    
    public function findlocation($id)
    {
	// pr ($rout); die;
	// Use the HTML helper to output
	// Formatted data:
	$articles = TableRegistry::get('Locations');
	// Start a new query.
	return $articles->find('all')->where(['Locations.id' => $id])->first()->toArray();
    }

    public function getSkillname($skillid){

$articles = TableRegistry::get('Skill');
	// Start a new query.
	return $articles->find('all')->where(['Skill.id' => $skillid])->first();
    }
    
    public function findfeesallocation($qua,$id)
    {
	// pr ($rout); die;
	// Use the HTML helper to output
	// Formatted data:
	$articles = TableRegistry::get('Studentfees');
	// Start a new query.
	return $articles->find('all')->where(['Studentfees.quarter' => $qua,'Studentfees.student_id' => $id])->first()->toArray();
    }
    

    public function findtransportfeesallocation($qua,$id)
    {
	// pr ($rout); die;
	// Use the HTML helper to output
	// Formatted data:
	$articles = TableRegistry::get('StudentTransfees');
	// Start a new query.
	return $articles->find('all')->where(['StudentTransfees.quarter' => $qua,'StudentTransfees.student_id' => $id])->first()->toArray();
    }
    
    
    public function skills()
    {
	$articles = TableRegistry::get('Skillset');
	$uid=$this->request->session()->read('Auth.User.id');
	return $articles->find('all')->where(['Skillset.user_id'=>$uid])->first();
    }
    

    public function jobpostrequirement()
    {
	$articles = TableRegistry::get('Users');
	$uid=$this->request->session()->read('Auth.User.id');
	return $articles->find('all')->where(['Users.id'=>$uid])->first();
    }
 

    
    public function contactrequestcount()
    {
	$articles = TableRegistry::get('Contactrequest');
	$uid=$this->request->session()->read('Auth.User.id');
	
	return $articles ->find('all')->where(['viewedstatus' => 'N','to_id' =>$uid])->count();
    }

    
    public function contactreqstatus($userid)
    {	
	$articles = TableRegistry::get('Contactrequest');
	$current_user_id = $this->request->session()->read('Auth.User.id');
	$connect_status =  $articles->find('all')->where(['from_id' => $userid,'to_id' =>$current_user_id])->orWhere(['from_id' => $current_user_id,'to_id' =>$userid])->first();    
	if(count($connect_status) > 0)
	{
	    if($connect_status['accepted_status']=='Y')
	    {
		$status = 'C';  // connected
	    }
	    else
	    {
		if($connect_status['from_id']==$current_user_id)
		{
		    $status = 'S';  // request sent
		}
		else
		{
		    $status = 'R';  // request received
		}
	    }
	}
	else
	{
	    $status = 'N';  // Not Connected
	}

	return $status;
    }
    
    
     public function applicationcount($job_id)
    {

	$articles = TableRegistry::get('JobApplication');
return $articles->find('all')->contain(['Users'=>['Profile','Professinal_info']])->where(['JobApplication.job_id'=>$job_id,'JobApplication.nontalent_aacepted_status' => 'N','JobApplication.	talent_accepted_status' => 'Y','JobApplication.ping'=>0])->order(['JobApplication.id' => 'DESC'])->count();
	
	//return $articles ->find('all')->where(['job_id' =>])->count();
    }
    
    public function quote_requestcount($job_id)
    {

	$articles = TableRegistry::get('JobQuote');
return $articles->find('all')->contain(['Users'=>['Profile','Professinal_info']])->where(['JobQuote.job_id'=>$job_id,'JobQuote.amt'=>'0'])->order(['JobQuote.id' => 'DESC'])->count();
    }
    
    public function sel_receivecount($job_id)
    {
	$articles = TableRegistry::get('JobApplication');
	return $articles->find('all')->contain(['Users'=>['Profile','Professinal_info']])->where(['JobApplication.job_id'=>$job_id,'JobApplication.nontalent_aacepted_status' => 'Y','JobApplication.talent_accepted_status' => 'Y'])->order(['JobApplication.id' => 'DESC'])->count();
    }
    
    public function booking_sentcount($job_id)
    {
	$articles = TableRegistry::get('JobApplication');
	return $articles->find('all')->contain(['Users'=>['Profile','Professinal_info']])->where(['JobApplication.job_id'=>$job_id,'JobApplication.nontalent_aacepted_status'=>'Y','JobApplication.ping'=>0,'JobApplication.talent_accepted_status'=>'N'])->order(['JobApplication.id' => 'DESC'])->count();
    }
   
   public function quote_receivecount($job_id)
    {
	$articles = TableRegistry::get('JobQuote');
	return $articles->find('all')->contain(['Users'=>['Profile','Professinal_info']])->where(['JobQuote.job_id'=>$job_id,'JobQuote.amt >'=>'0','JobQuote.revision'=>'0','JobQuote.status'=>'N'])->order(['JobQuote.id' => 'DESC'])->count();
    }
    
    
    public function quote_revisedcount($job_id)
    {
	$articles = TableRegistry::get('JobQuote');
	return $articles->find('all')->contain(['Users'=>['Profile','Professinal_info']])->where(['JobQuote.job_id'=>$job_id,'JobQuote.amt >'=>'0','JobQuote.revision >'=>'0','JobQuote.status'=>'N'])->order(['JobQuote.id' => 'DESC'])->count();
    }
    
    public function reject_receivecount($job_id)
    {
	$articles = TableRegistry::get('JobApplication');
	return $articles->find('all')->contain(['Users'=>['Profile','Professinal_info']])->where(['JobApplication.job_id'=>$job_id,'JobApplication.nontalent_aacepted_status' => 'R'])->orWhere(['JobApplication.talent_accepted_status' =>'R'])->order(['JobApplication.id' => 'DESC'])->count();
    }
    
    public function ping_receivecount($job_id)
    {
	$articles = TableRegistry::get('JobApplication');
	return $articles->find('all')->contain(['Users'=>['Profile','Professinal_info']])->where(['JobApplication.job_id'=>$job_id,'JobApplication.nontalent_aacepted_status' => 'N','JobApplication.ping'=>1])->order(['JobApplication.id' => 'DESC'])->count();
    }
    
public function profileheader()
    {
   $current_user_id = $this->request->session()->read('Auth.User.id');
	$articles = TableRegistry::get('Profile');

	return $articles->find('all')->contain(['Users','Enthicity','City','Country'])->where(['user_id' => $current_user_id])->first();
    }
    
    
    public function packagedetails($type,$packageid)
    {
	$pcakgeinformation = '';
	if($type=='P'){
	    $pcakge = TableRegistry::get('Profilepack');
	    $pcakgeinformation = $pcakge->find('all')->where(['Profilepack.id'=>$packageid])->first();
	}elseif($type=='RE'){
	    $pcakge = TableRegistry::get('RecuriterPack');
	    $pcakgeinformation = $pcakge->find('all')->where(['RecuriterPack.id'=>$packageid])->first();
	}elseif($type=='R'){
	    $pcakge = TableRegistry::get('RequirementPack');
	    $pcakgeinformation = $pcakge->find('all')->where(['RequirementPack.id'=>$packageid])->first();
	}
	return $pcakgeinformation;
    }


    public function requimentskill($recid)
    {
	$current_user_id = $this->request->session()->read('Auth.User.id');
	$RequirmentVacancy = TableRegistry::get('RequirmentVacancy');
	return $RequirmentVacancy->find('all')->contain(['Skill'])->where(['RequirmentVacancy.requirement_id' => $recid])->toArray();
    }
	
    public function totalprofilereports($userid)
    {
	$report = TableRegistry::get('Report');
	$total_reports = $report->find('all')->where(['Report.profile_id'=>$userid, 'Report.type'=>'profile'])->count();
	return $total_reports;
    }
    
    public function userskills($userid)
    {
	$articles = TableRegistry::get('Skillset');
	
	$userskills = $articles->find('all')->contain(['Skill'])->where(['Skillset.user_id'=>$userid])->toArray();
	return $userskills;
    }
     public function events($date)
    {
		
	$articles = TableRegistry::get('Calendar');
	
	$events = $articles->find('all')->where(['Calendar.from_date' => $date])->toarray();
	return $events;
    }
     
       public function reviews($job_id,$artist_id)
    {
		
	$articles = TableRegistry::get('Review');
	$current_user_id = $this->request->session()->read('Auth.User.id');
	$events = $articles->find('all')->where(['Review.job_id' =>$job_id,'Review.artist_id' =>$artist_id,'Review.nontalent_id' =>$current_user_id])->count();
	return $events;
    }


        public function performainglanguage($user_id)
    {
		
	$articles = TableRegistry::get('Performancelanguage');
	
	$events = $articles->find('all')->contain(['Language'])->where(['Performancelanguage.user_id' =>$user_id])->toarray();
	return $events;
    }

    public function languageknown($user_id)
    {
		
	$articles = TableRegistry::get('Languageknown');
	
	$events = $articles->find('all')->contain(['Language'])->where(['Languageknown.user_id' =>$user_id])->toarray();
	return $events;
    }

    public function paymentfaq($user_id)
    {
		
	$articles = TableRegistry::get('Performancedesc2');
	
	$events = $articles->find('all')->contain(['Paymentfequency'])->where(['Performancedesc2.user_id' =>$user_id])->toarray();
	return $events;
    }

     public function mypaymentfaq($id)
    {
		
	$articles = TableRegistry::get('Paymentfequency');
	
	$events = $articles->find('all')->where(['Paymentfequency.id' =>$id])->first()->toarray();
	return $events;
    }
    
    public function video()
    {
		$user_id = $this->request->session()->read('Auth.User.id');
	$articles = TableRegistry::get('Video');
	
	$events = $articles->find('all')->where(['Video.user_id' =>$user_id])->count();
	return $events;
    }
    public function audio()
    {
		$user_id = $this->request->session()->read('Auth.User.id');
	$articles = TableRegistry::get('Audio');
	
	$events = $articles->find('all')->where(['Audio.user_id' =>$user_id])->count();
	return $events;
    }
    public function gallery()
    {
		$user_id = $this->request->session()->read('Auth.User.id');
	$articles = TableRegistry::get('Gallery');
	
	$events = $articles->find('all')->where(['Gallery.user_id' =>$user_id])->count();
	return $events;
    }

    public function vital($user_id){
    

    	$articles = TableRegistry::get('Uservital');
	
	$events = $articles->find('all')->contain(['Vques','Voption'])->where(['Uservital.user_id' =>$user_id])->toarray();
	return $events;
    }


    public function icon($user_id){
    	
    	$articles = TableRegistry::get('Subscription');
	$ppack=PROFILE_PACKAGE;
	$rpack=PROFILE_PACKAGE;
	$events = $articles->find('all')->where(['Subscription.user_id' =>$user_id,'Subscription.package_type'=>'PR','Subscription.package_id !=' =>$ppack,'Subscription.package_type !=' =>'RE'])->orWhere(['Subscription.package_type'=>'RC','Subscription.package_id !=' =>$rpack,'Subscription.user_id' =>$user_id,])->toarray();

	
		return $events;
    }

       public function profilepack($packid)
    {
		
	$articles = TableRegistry::get('Profilepack');
	
	$events = $articles->find('all')->where(['Profilepack.id' =>$packid])->first();

	return $events;
    }


   public function recpack($packid)
    {
		
	$articles = TableRegistry::get('RecuriterPack');
	
	$events = $articles->find('all')->where(['RecuriterPack.id' =>$packid])->first();
	return $events;
    }

    
     public function proff()
    {
	$articles = TableRegistry::get('Users');
	$uid=$this->request->session()->read('Auth.User.id');
	return $articles->find('all')->contain(['Profile','Professinal_info'])->where(['Users.id'=>$uid])->first();
    }
	
      public function userprofileskills()
    {
	$articles = TableRegistry::get('Skillset');
		$uid=$this->request->session()->read('Auth.User.id');

	$userskills = $articles->find('all')->contain(['Skill'])->where(['Skillset.user_id'=>$uid])->toArray();
	return $userskills;
    }

    public function appliedjob($jobid)
    {
	$articles = TableRegistry::get('JobApplication');
		$uid=$this->request->session()->read('Auth.User.id');

	$userskills = $articles->find('all')->where(['JobApplication.user_id'=>$uid,'JobApplication.job_id'=>$jobid])->first();
	return $userskills;
    }
      public function bookjob($nontalent_id)
    {
	$articles = TableRegistry::get('JobApplication');
	$uid=$this->request->session()->read('Auth.User.id');
	$userskills = $articles->find('all')->where(['JobApplication.user_id'=>$nontalent_id,'JobApplication.nontalent_id'=>$uid])->first();
	return $userskills;
    }
     public function askquote($nontalent_id)
    {
	$articles = TableRegistry::get('JobQuote');
	$uid=$this->request->session()->read('Auth.User.id');
	$userskills = $articles->find('all')->where(['JobQuote.user_id'=>$nontalent_id,'JobQuote.nontalentuser_id'=>$uid])->first();
	return $userskills;
    }


 public function likess($id)
    {
	$articles = TableRegistry::get('Likes');
	$current_user_id = $this->request->session()->read('Auth.User.id');
	$content_type="profile";
	
	$uid=$this->request->session()->read('Auth.User.id');
	$userskills = $articles->find('all')->where(['Likes.content_type'=>$content_type, 'Likes.content_id'=>$id, 'Likes.user_id'=>$current_user_id])->count();
	return $userskills;
    }


       public function sentquote($jobid)
    {
    	
	$articles = TableRegistry::get('JobQuote');
		$uid=$this->request->session()->read('Auth.User.id');

	$userskills = $articles->find('all')->where(['JobQuote.user_id'=>$uid,'JobQuote.job_id'=>$jobid])->first();
	return $userskills;
    }
 public function repeatbooking($job_id)
    {
    	
	$articles = TableRegistry::get('Requirement');
		$uid=$this->request->session()->read('Auth.User.id');

	$details = $articles->find('all')->contain(['RequirmentVacancy'=>['Skill','Currency'],'Eventtype'])->where(['Requirement.id'=>$job_id])->first();
	return $details;
    }

public function bookingalready($job_id,$kill_id)
    {
    	
	$articles = TableRegistry::get('JobApplication');
	$uid=$this->request->session()->read('Auth.User.id');
	$details = $articles->find('all')->where(['JobApplication.job_id'=>$job_id,'JobApplication.skill_id'=>$kill_id])->count();
	return $details;
    }
    
       public function repeatalreadybooking($job_id)
    {
	$articles = TableRegistry::get('JobApplication');
	$uid=$this->request->session()->read('Auth.User.id');
	$details = $articles->find('all')->contain(['Users'=>['Profile','Professinal_info'],'Skill','Requirement'])->where(['JobApplication.job_id'=>$job_id])->first();
	return $details;
    }
    
      public function repeatalreadyjob($job_id)
    {
	$articles = TableRegistry::get('JobQuote');
	$uid=$this->request->session()->read('Auth.User.id');
	$details = $articles->find('all')->contain(['Users'=>['Profile','Professinal_info'],'Skill','Requirement'])->where(['JobQuote.job_id'=>$job_id])->first();
	return $details;
    }
    
       public function repeatjob($job_id)
    {
    	
	$articles = TableRegistry::get('Requirement');
	$uid=$this->request->session()->read('Auth.User.id');
	$details = $articles->find('all')->where(['Requirement.id'=>$job_id])->first();
	return $details;
    }


   public function quoteuserdetail($reqid,$user_id)
    {
    	
	$articles = TableRegistry::get('JobQuote');
		$uid=$this->request->session()->read('Auth.User.id');

	$details = $articles->find('all')->contain(['Requirement','Skill','Users'=>['Skillset'=>['Skill'],'Profile','Professinal_info']])->where(['JobQuote.job_id'=>$reqid,'JobQuote.user_id'=>$user_id,'JobQuote.amt >'=>'0','JobQuote.revision'=>'0','JobQuote.status'=>'N'])->order(['JobQuote.id' => 'DESC'])->first();
	return $details;
    }

       public function vacanydetails($reqid,$skill)
    {
    	
	$articles = TableRegistry::get('RequirmentVacancy');
		$uid=$this->request->session()->read('Auth.User.id');

	$details = $articles->find('all')->contain(['Skill','Currency'])->where(['RequirmentVacancy.requirement_id'=>$reqid,'RequirmentVacancy.telent_type'=>$skill])->first();
	return $details;
    }


public function cnt($cid){
		$articles = TableRegistry::get('Country');
	$userskills = $articles->find('all')->where(['Country.id'=>$cid])->first();
	return $userskills;
}

public function state($sid){
		$articles = TableRegistry::get('State');
	$userskills = $articles->find('all')->where(['State.id'=>$sid])->first();
	return $userskills;
}
public function city($city){
		$articles = TableRegistry::get('City');
	$userskills = $articles->find('all')->where(['City.id'=>$city])->first();
	return $userskills;

}


public function package($city){
		$articles = TableRegistry::get('Subscription');
	$userspackage = $articles->find('all')->where(['Subscription.user_id'=>$city])->toArray();
	return $userspackage;

}


public function editstate($sid){
		$articles = TableRegistry::get('State');

	

	$userskills = $articles->find('list')->select(['id','name'])->where(['State.	country_id'=>$sid])->toarray();
	return $userskills;
}
public function editcity($city){
		$articles = TableRegistry::get('City');
			$userskills = $articles->find('all')->select(['id','name'])->where(['City.	state_id'=>$city])->toarray();


	return $userskills;

}


public function profilepackagename($city){
		$articles = TableRegistry::get('Profilepack');
			$userskills = $articles->find('all')->select(['id','name'])->where(['Profilepack.	id'=>$city])->first();


	return $userskills;

}

public function recpackagename($city){
		$articles = TableRegistry::get('RecuriterPack');
			$userskills = $articles->find('all')->select(['id','title'])->where(['RecuriterPack.	id'=>$city])->first();


	return $userskills;

}


	function file_get_contents_curl($url) 
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return  $data;
}


function get_driving_information($start, $finish, $raw = false)
{
  




$test="https://maps.googleapis.com/maps/api/distancematrix/json?origins=".urlencode($start)."&destinations=".urlencode($finish)."&departure_time=now&key=AIzaSyC27M5hfywTEJa5_l-g0KHWe8m8lxu-rSI";

  $json = file_get_contents($test);

    $details = json_decode($json, TRUE);

    return  $details['rows']['0']['elements']['0']['distance']['text'];
}



function inboxcount(){
	$where = " where 1=1 ";
	$uid = $this->request->session()->read('Auth.User.id');
$where.= " and m.read_status = 'N'";
$where.= " and m.to_id = '".$uid."'";
	$where.= " and m.to_box = 'I'";
		$conninbox = ConnectionManager::get('default');
 $message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id ".$where." group by m.thread_id";
	//echo $message_qry; die;
	$message_qe = $conninbox->execute($message_qry);
	return $messages = $message_qe ->fetchAll('assoc');
	//pr($messages);
}

function sentboxcount(){

	$uid = $this->request->session()->read('Auth.User.id');
	$where = " where 1=1 ";
	$where.= " and m.from_id = '".$uid."'";
	$where.= " and m.from_box = 'S'";
	
	$conn = ConnectionManager::get('default');
	$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id ".$where." group by m.thread_id";
	$message_qe = $conn->execute($message_qry);
	 return $messages = $message_qe ->fetchAll('assoc');
//pr($messages);
}
function deraft(){
$uid = $this->request->session()->read('Auth.User.id');
		$where = " where 1=1 ";
	$where.= " and m.from_id = '".$uid."'";
	$where.= " and m.from_box = 'D'";
	
	$conn = ConnectionManager::get('default');
	$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id ".$where." group by m.thread_id";
	$message_qe = $conn->execute($message_qry);
	return $messages = $message_qe ->fetchAll('assoc');
//pr($messages);
}

function folder(){


$articles = TableRegistry::get('Messagegroup');
$uid = $this->request->session()->read('Auth.User.id');
return $userskills = $articles->find('all')->where(['user_id' => $uid])->toarray();

}


function trash(){


	$uid = $this->request->session()->read('Auth.User.id');
	$where = " where 1=1 ";
	$where.= " and (m.from_id = '".$uid."' and m.from_box = 'T') OR (m.to_id = '".$uid."' and m.to_box = 'T')";
	//$where.= " ";
	$conn = ConnectionManager::get('default');
	$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id ".$where." group by m.thread_id";
	
	//echo $message_qry; die;
	$message_qe = $conn->execute($message_qry);
	return $messages = $message_qe ->fetchAll('assoc');

}


function readmessage(){


	$where = " where 1=1 ";
	$uid = $this->request->session()->read('Auth.User.id');
$where.= " and m.read_status= 'Y'";
$where.= " and m.to_id = '".$uid."'";
	$where.= " and m.to_box = 'I'";
		$conninbox = ConnectionManager::get('default');
 $message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id ".$where." group by m.thread_id";
	//echo $message_qry; die;
	$message_qe = $conninbox->execute($message_qry);
	return $messages = $message_qe ->fetchAll('assoc');

}
    


           public function userdeails($job_id)
    {
    	
	$articles = TableRegistry::get('users');
	
	$details = $articles->find('all')->where(['users.id'=>$job_id])->first();
	return $details;
    }
    
    public function findlikedislike($id,$user_id)
    {
	$articles = TableRegistry::get('Galleryimagelike');	
	$details = $articles->find('all')->select(['image_like','caption'])->where(['image_gallery_id'=>$id])->first();
	return $details;
	}
	
	public function findvideolikedislike($id,$user_id)
    {
	$articles = TableRegistry::get('Videolike');	
	$details = $articles->find('all')->select(['video_like','caption'])->where(['video_id'=>$id,'user_id'=>$user_id])->first();
	return $details;
	}
	
	
	public function findaudioikedislike($id,$user_id)
    {
	$articles = TableRegistry::get('Audiolike');	
	$details = $articles->find('all')->select(['audio_like','caption'])->where(['audio_id'=>$id,'user_id'=>$user_id])->first();
	return $details;
	}
	
	public function findlikecount($id)
    {
	$articles = TableRegistry::get('Galleryimagelike');	
	$details = $articles->find('all')->where(['image_like'=>'1','image_gallery_id'=>$id])->count();	
	return $details;
	}
	
	public function findvideolikecount($id)
    {
	$articles = TableRegistry::get('Videolike');	
	$details = $articles->find('all')->where(['video_like'=>'1','video_id'=>$id])->count();	
	return $details;
	}
	
	
	public function findaudiolikecount($id)
    {
	$articles = TableRegistry::get('Audiolike');	
	$details = $articles->find('all')->where(['audio_like'=>'1','audio_id'=>$id])->count();	
	return $details;
	}
	
	
	public function findprofileimage($id)
    {
	$articles = TableRegistry::get('Profile');	
	$details = $articles->find('all')->select(['profile_image','location'])->where(['user_id'=>$id])->first();	
	return $details;
	}	
	
	public function checktalent($id)
    {
	$articles = TableRegistry::get('Skillset');
	$uid=$this->request->session()->read('Auth.User.id');
	$userskills = $articles->find('all')->contain(['Skill'])->where(['Skillset.user_id'=>$uid])->toArray();
	return $userskills;
    }
    
    public function findvideocaption($id)
    {
	$articles = TableRegistry::get('Videolike');	
	$details = $articles->find('all')->select(['caption'])->where(['video_id'=>$id])->first();	
	return $details;
    }
	
}
?>
