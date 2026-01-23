<?php 
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\ORM\TableRegistry;
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

    
}
?>
