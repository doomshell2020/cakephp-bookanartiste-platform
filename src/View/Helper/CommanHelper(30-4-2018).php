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
	return $articles->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $current_user_id])->first();
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
    
    
	
    
    
}
?>
