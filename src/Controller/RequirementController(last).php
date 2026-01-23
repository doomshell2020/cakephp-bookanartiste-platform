<?php
namespace App\Controller;
use App\Controller;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
class RequirementController extends AppController
{
	
	public function initialize()
	{
        parent::initialize();
       	$this->loadModel('Users');
       // $this->Auth->allow(['_setPassword','signup','findUsername','login','logout','verify','getphonecode','forgotpassword','forgetCpass','sociallogin']);
    }
    
    public function overallrating()
    {
		$overallrating =$this->request->data['avgtotal'];
		$overrating= round($overallrating/8,1); 
		echo json_encode($overrating); 
		die;
	}
    
 public function talentrating($job_id,$artist_id)
    {
		$overallrating =$this->request->data['avgtotal'];
		$this->loadModel('JobApplication');
		$this->set('job_id', $job_id);
				$jobdetail = $this->JobApplication->find('all')->contain(['Requirement','Skill','Users'=>['Skillset'=>['Skill'],'Profile','Professinal_info']])->where(['JobApplication.job_id'=>$job_id])->order(['JobApplication.id' => 'DESC'])->first();
				//pr($jobdetail);
$this->set('jobdetail', $jobdetail);
		
		$this->set('artist_id', $artist_id);
	$this->loadModel('Review');
	$id = $this->request->session()->read('Auth.User.id');
	$review = $this->Review->newEntity();
	if ($this->request->is(['post', 'put']))
		{ 
			$this->request->data['nontalent_id']= $id;
			$reviews = $this->Review->patchEntity($review, $this->request->data);
			if($this->Review->save($reviews)){
			$this->Flash->success(__('Talent  Review successfully saved!!'));
			return $this->redirect(['action' => 'requirement']);
		}
		}




    }  
 public function deleteapplication($id)
    {
		$this->autoRender=false;
			$this->loadModel('JobApplication');
        $JobQuote = $this->JobApplication->get($id);
       if ($this->JobApplication->delete($JobQuote)){
		   $this->Flash->success(__('Job Deleted Successfully'));
		return $this->redirect(['action' => 'requirement']);  
	  }
             
	}   
	
	public function deletequotes($id)
    {
		$this->autoRender=false;
			$this->loadModel('JobQuote');
        $JobQuote = $this->JobQuote->get($id);
       if ($this->JobQuote->delete($JobQuote)){
		return $this->redirect(['action' => 'requirement']);  
	  }
             
	} 
	
 public function applicationreject($id)
    {
			$this->autoRender=false;
			$this->loadModel('JobApplication');
				$status = 'R';
                $Pack = $this->JobApplication->get($id);
                $Pack->nontalent_aacepted_status = $status;
                if ($this->JobApplication->save($Pack)) {
					$this->eventreject($id);
                    return $this->redirect(['action' => 'requirement']);  
                }
	}	
	
	 public function eventreject($id)
    {
		$this->loadModel('JobApplication');
		$this->loadModel('Calendar');
		$this->autoRender=false;
		$bookingreceived = $this->JobApplication->find('all')->contain(['Skill','Requirement'=>['RequirmentVacancy'=>['Skill','Currency']]])->where(['JobApplication.id' =>$id])->first();
		$job_id = $bookingreceived['job_id'];
		$calendarrec = $this->Calendar->find('all')->where(['Calendar.event_id' => $job_id])->first();
		$cal = $this->Calendar->get($calendarrec['id']);
		$this->Calendar->delete($cal);
		

	}
    public function applicationselect($id)
    {
	$this->autoRender=false;
	$this->loadModel('JobApplication');
	$status = 'Y';
	$Pack = $this->JobApplication->get($id);
	$Pack->nontalent_aacepted_status = $status;
	$Pack->talent_accepted_status = $status;
	$result= $this->JobApplication->save($Pack);
	if($result){
	$this->eventselect($id);
	return $this->redirect(['action' => 'requirement']);  
}
    }
	 public function eventselect($id)
    {
		$this->autoRender=false;
		$this->loadModel('JobApplication');
		$this->loadModel('Calendar');
		$bookingreceived = $this->JobApplication->find('all')->contain(['Skill','Requirement'=>['RequirmentVacancy'=>['Skill','Currency']]])->where(['JobApplication.id' =>$id])->first();
	
		$eventfrom= $bookingreceived['requirement']['event_from_date'];
		$eventto= $bookingreceived['requirement']['event_to_date'];
		$job_id = $bookingreceived['job_id'];
		$location = $bookingreceived['requirement']['location'];
		$user_id = $bookingreceived['user_id'];
		$type = "RQ";
	$calendarrec = $this->Calendar->find('all')->where(['Calendar.event_id' => $job_id])->count();
	
	if($calendarrec >0){

			}else{
					$proff = $this->Calendar->newEntity();
				$this->request->data['from_date'] = $eventfrom;
				$this->request->data['to_date'] = $eventto;
				$this->request->data['type'] =$type;
				$this->request->data['user_id'] = $user_id;
				$this->request->data['event_id'] = $job_id;
				$this->request->data['location'] = $location;
				$eventadd = $this->Calendar->patchEntity($proff,$this->request->data);
				$this->Calendar->save($eventadd);
			}
	}
	
	
public function quoteselect($id,$status)
    {
	
	$this->autoRender=false;
	$this->loadModel('JobQuote');
	$this->loadModel('JobApplication');
	$this->loadModel('JobQuote');
	$jobfind= $this->JobQuote->find('all')->where(['JobQuote.id'=>$id])->order(['JobQuote.id' => 'DESC'])->first();	

	if($status=='S'){
				$status = 'S';
                $Pack = $this->JobQuote->get($id);
                $Pack->status = $status;
                if ($this->JobQuote->save($Pack)) {
					$applicationstatus='Y';
					 $job_application['nontalent_aacepted_status'] = $applicationstatus;
					 $job_application['talent_accepted_status'] = $applicationstatus;
					 $job_application['user_id'] = $jobfind['user_id'];
					 $job_application['job_id'] = $jobfind['job_id'];
                                          $job_application['skill_id'] = $jobfind['skill_id'];
					 $jobappfind= $this->JobApplication->find('all')->where(['JobApplication.user_id'=>$jobfind['user_id'],'JobApplication.job_id'=>$jobfind['job_id']])->order(['JobQuote.id' => 'DESC'])->count();	
					
					 if($jobappfind > 0)
					{
					$con = ConnectionManager::get('default');
					
					$detail = 'UPDATE `job_application` SET `nontalent_aacepted_status` ="' .$applicationstatus. '" WHERE `job_application`.`job_id` = ' . $jobfind['job_id'].' AND `job_application`.`user_id` = ' . $jobfind['user_id'];
					
					
					$results = $con->execute($detail);
					}else{
					$proff = $this->JobApplication->newEntity();
					$blockp = $this->JobApplication->patchEntity($proff, $job_application);
					$savelike = $this->JobApplication->save($blockp);

					}
					 
					 
                    return $this->redirect(['action' => 'requirement']);  
                }
			}
	}	
public function quotereject($id,$status)
    {
	
	$this->autoRender=false;
	$this->loadModel('JobQuote');
	$this->loadModel('JobApplication');
	$this->loadModel('JobQuote');
	$jobfind= $this->JobQuote->find('all')->where(['JobQuote.id'=>$id])->order(['JobQuote.id' => 'DESC'])->first();	

	if($status=='R'){
				$status = 'R';
                $Pack = $this->JobQuote->get($id);
                $Pack->status = $status;
                if ($this->JobQuote->save($Pack)) {
					 $job_application['nontalent_aacepted_status'] = $status;
                                      $job_application['talent_accepted_status'] = $status;
					 $job_application['user_id'] = $jobfind['user_id'];
					 $job_application['job_id'] = $jobfind['job_id'];
                                  $job_application['skill_id'] = $jobfind['skill_id'];
					  $jobappfind= $this->JobApplication->find('all')->where(['JobApplication.user_id'=>$jobfind['user_id'],'JobApplication.job_id'=>$jobfind['job_id']])->order(['JobQuote.id' => 'DESC'])->count();	
					  if($jobappfind > 0)
					{
					$con = ConnectionManager::get('default');
					
					$detail = 'UPDATE `job_application` SET `nontalent_aacepted_status` ="' .$status. '" WHERE `job_application`.`job_id` = ' . $jobfind['job_id'].' AND `job_application`.`user_id` = ' . $jobfind['user_id'];
					
					
					$results = $con->execute($detail);
					}else{
					 
					 $proff = $this->JobApplication->newEntity();
					  $blockp = $this->JobApplication->patchEntity($proff, $job_application);
						$savelike = $this->JobApplication->save($blockp);
					}
                    return $this->redirect(['action' => 'requirement']);  
                }
			}
	}	
	
	
public function requirement()
    {


		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Professinal_info');
		$this->loadModel('Requirement');
		$this->loadModel('BookingRequest');
		$this->loadModel('JobQuote');
		$this->loadModel('JobApplication');
		$this->loadModel('JobView');
		

		$id = $this->request->session()->read('Auth.User.id');
		$profile = $this->Profile->find('all')->contain(['Users'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);
		
		
		$this->loadModel('Requirement');
		$id = $this->request->session()->read('Auth.User.id');
		$currentdate=date('Y-m-d H:m:s');
		
	    $requirementfeatured = $this->Requirement->find('all')->contain(['JobView','BookingRequest','JobQuote','JobApplication'])->where(['Requirement.featured' =>'Y','Requirement.user_id'=>$id])->order(['Requirement.id' => 'DESC'])->toarray();
		$this->set(compact('requirementfeatured'));
   
	   $quoterevised= $this->JobQuote->find('all')->contain(['Users'=>['Profile','Professinal_info']])->where(['JobQuote.revision !='=>0])->order(['JobQuote.id' => 'DESC'])->count();
	   $this->set(compact('quoterevised'));	
   
    }

public function delete($id){
            $this->loadModel('Requirement');
            $Requirement = $this->Requirement->get($id);
            if ($this->Requirement->delete($Requirement)) {

           $this->Flash->success(__('Job Deleted Successfully '));
            return $this->redirect(['action' => 'requirement']);
            }
          }
	public function amountquote($id){
	$this->loadModel('JobQuote');
	$this->set('revisedid', $id);
	$revisedquote = $this->JobQuote->find('all')->where(['JobQuote.id'=>$id])->order(['JobQuote.id' => 'DESC'])->first();	
	$this->set('revisedquote', $revisedquote);
	$nontalent_id = $this->request->session()->read('Auth.User.id');
	$error = '';
	$rstatus = '';
	if ($this->request->is(['post', 'put']))
	{
		$requirementfeatured = $this->JobQuote->find('all')->where(['JobQuote.revision'=>0,'JobQuote.id'=>$this->request->data['revisedid']])->order(['JobQuote.id' => 'DESC'])->count();	
		if($requirementfeatured>0)
		{
			$Pack = $this->JobQuote->get($this->request->data['revisedid']);
			$Pack->nontalent_id	=$nontalent_id;
			$Pack->revision = $this->request->data['revisedquote'];
			$this->JobQuote->save($Pack);
			$rstatus = 1;
		}  else{
			$this->Flash->success(__('Quote Already Sent'));
			return $this->redirect(['action' => 'requirement']);
		}
			$this->Flash->success(__('Quote sent Successfully '));
			return $this->redirect(['action' => 'requirement']);
	}
	}
	public function updatequote(){

	$job_id	= $this->request->data['job'];
	$quote = $this->request->data['action'];
	$session = $this->request->session();
	$session->write('quote', $quote);
	$session->write('job_id', $job_id);
	$this->set(compact('quote'));	
	$this->loadModel('Users');
	$this->loadModel('JobApplication');
	$this->loadModel('Profile');
	$this->loadModel('Professinal_info');
	$this->loadModel('Requirement');
	$this->loadModel('BookingRequest');
	$this->loadModel('JobQuote');
		$this->loadModel('Skill');
	if($this->request->data['action']=='application'){
		$requirementfeatured = $this->JobApplication->find('all')->contain(['Requirement','Skill','Users'=>['Skillset'=>['Skill'],'Profile','Professinal_info']])->where(['JobApplication.job_id'=>$this->request->data['job'],'JobApplication.nontalent_aacepted_status' => 'N','JobApplication.	talent_accepted_status' => 'Y','JobApplication.ping'=>0])->order(['JobApplication.id' => 'DESC'])->toarray();
		//pr($requirementfeatured);
	}elseif($this->request->data['action']=='quote_receive'){
		$requirementfeatured = $this->JobQuote->find('all')->contain(['Requirement','Skill','Users'=>['Skillset'=>['Skill'],'Profile','Professinal_info']])->where(['JobQuote.job_id'=>$this->request->data['job'],'JobQuote.amt >'=>'0','JobQuote.revision'=>'0','JobQuote.status'=>'N'])->order(['JobQuote.id' => 'DESC'])->toarray();
	}elseif($this->request->data['action']=='ping_receive'){
		$requirementfeatured = $this->JobApplication->find('all')->contain(['Requirement','Skill','Users'=>['Skillset'=>['Skill'],'Profile','Professinal_info']])->where(['JobApplication.job_id'=>$this->request->data['job'],'JobApplication.nontalent_aacepted_status' => 'N','JobApplication.ping'=>1])->order(['JobApplication.id' => 'DESC'])->toarray();
	}elseif($this->request->data['action']=='sel_receive'){
		$requirementfeatured = $this->JobApplication->find('all')->contain(['Requirement','Skill','Users'=>['Skillset'=>['Skill'],'Profile','Professinal_info']])->where(['JobApplication.job_id'=>$this->request->data['job'],'JobApplication.nontalent_aacepted_status' => 'Y','JobApplication.talent_accepted_status' => 'Y'])->order(['JobApplication.id' => 'DESC'])->toarray();
	}elseif($this->request->data['action']=='booking_sent'){
		$requirementfeatured = $this->JobApplication->find('all')->contain(['Requirement','Skill','Users'=>['Skillset'=>['Skill'],'Profile','Professinal_info']])->where(['JobApplication.job_id'=>$this->request->data['job'],'JobApplication.nontalent_aacepted_status'=>'Y','JobApplication.ping'=>0,'JobApplication.talent_accepted_status'=>'N'])->order(['JobApplication.id' => 'DESC'])->toarray();
	}elseif($this->request->data['action']=='quote_request'){
		$requirementfeatured = $this->JobQuote->find('all')->contain(['Requirement','Skill','Users'=>['Skillset'=>['Skill'],'Profile','Professinal_info']])->where(['JobQuote.job_id'=>$this->request->data['job'],'JobQuote.amt'=>'0'])->order(['JobQuote.id' => 'DESC'])->toarray();
	}elseif($this->request->data['action']=='quote_revised'){
		$requirementfeatured = $this->JobQuote->find('all')->contain(['Requirement','Skill','Users'=>['Skillset'=>['Skill'],'Profile','Professinal_info']])->where(['JobQuote.job_id'=>$this->request->data['job'],'JobQuote.amt >'=>'0','JobQuote.revision >'=>'0','JobQuote.status'=>'N'])->order(['JobQuote.id' => 'DESC'])->toarray();
	}elseif($this->request->data['action']=='reject_receive'){
		$requirementfeatured = $this->JobApplication->find('all')->contain(['Requirement','Skill','Users'=>['Skillset'=>['Skill'],'Profile','Professinal_info']])->where(['JobApplication.job_id'=>$this->request->data['job'],'JobApplication.nontalent_aacepted_status' => 'R'])->orWhere(['JobApplication.talent_accepted_status' =>'R'])->order(['JobApplication.id' => 'DESC'])->toarray();
	}
	//json_encode($requirementfeatured);
	$this->set(compact('requirementfeatured'));	
	}
	public function jobcsv($id)
	{
		$this->autoRender=false;
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Professinal_info');
		$this->loadModel('Requirement');
		$this->loadModel('BookingRequest');
		$this->loadModel('JobQuote');
		$this->loadModel('JobApplication');
		$requirementfeatured = $this->Requirement->find('all')->contain(['BookingRequest','JobQuote'=>['Users'=>['Skillset'=>['Skill'],'Profile'=>['Country','State','City','Enthicity'],'Professinal_info']],'JobApplication'=>['Users'=>['Skillset'=>['Skill'],'Profile'=>['Country','State','City','Enthicity'],'Professinal_info']]])->where(['Requirement.featured' =>'Y','Requirement.id'=>$id])->order(['Requirement.id' => 'DESC'])->first();
	    
		//pr($requirementfeatured); die;
	
	$blank="NA";
	
	
		$conn = ConnectionManager::get('default');
		$output="";
		$output .= '"Sr Number",';
		$output .= '"Name",';
		$output .= '"Date Of Birth",';
		$output .= '"Age",';
		$output .= '"Gender",';
		$output .= '"Email Id",';
		$output .= '"Phone Number",';
		$output .= '"skype Id",';
		$output .= '"Guardian E-mail",';
		$output .= '"Guardian PhoneNumber",';
		$output .= '"Skill",';
		$output .= '"Ethnicity",';
		$output .= '"Current Location",';
		$output .= '"Country",';
		$output .= '"State",';
		$output .= '"City",';
		$output .= '"Action By Applicant",';
		$output .= '"Quote Receive",';
		$output .= '"Quote Sent By Me",';
		$output .="\n";
			 //pr($job); die;
				$str="";
				$cnt=1; foreach($requirementfeatured['job_application'] as $jobed){ //pr($jobed); die;
					
					$output .=$cnt.",";
					$output.=$jobed['user']['profile']['name'].",";
					$dateOfBirth = date('d-M-Y',strtotime($jobed['user']['profile']['dob']));
					$today = date("d-M-Y");
					$diff = date_diff(date_create($dateOfBirth), date_create($today));
					$age = $diff->format('%y');
					$output .=date('d-M-Y',strtotime($jobed['user']['profile']['dob'])).',';
					$output .=$age.',';
					$output.=$jobed['user']['profile']['gender'].",";
					$output.=$jobed['user']['email'].",";
					$output.='('.$jobed['user']['profile']['phonecode'].')'.$jobed['user']['profile']['phone'].",";
					if($jobed['user']['profile']['skypeid']!=''){
					$output.=$jobed['user']['profile']['skypeid'].",";
					}else{
				$output .=$blank.",";
						}
				if($jobed['user']['profile']['guardian_email']!=''){
				$output.=$jobed['user']['profile']['guardian_email'].",";
				}else{
					$output .=$blank.",";
				}
				if($jobed['user']['profile']['guardian_phone']!=''){
				$output.=$jobed['user']['profile']['guardian_phone'].",";
				}else{
					$output .=$blank.",";
				}
				
					
				if($jobed['user']['skillset'])
					{
					$knownskills = '';
					foreach($jobed['user']['skillset'] as $skillquote)
					{
					if(!empty($knownskills))
					{
						$knownskills = $knownskills.', '.$skillquote['skill']['name'];
					}
					else
					{
						$knownskills = $skillquote['skill']['name'];
					}
					}
					$output.=str_replace(',',' ',$knownskills).',';
					//$output.=$knownskills.",";	
				   // echo $knownlanguages;
					}	
					$output.=$jobed['user']['profile']['enthicity']['title'].",";
					$output.=str_replace(',',' ',$jobed['user']['profile']['location']).',';
					$output.=$jobed['user']['profile']['country']['name'].",";
					$output.=$jobed['user']['profile']['state']['name'].",";
					$output.=$jobed['user']['profile']['city']['name'].",";
					if($jobed['nontalent_aacepted_status']=='N' && $jobed['talent_accepted_status']=='Y' && $jobed['ping']==0){
					$output.="Applied".",";
					}elseif($jobed['nontalent_aacepted_status']=='N'  && $jobed['ping']==1){
					$output.="Ping".",";
					}elseif($jobed['nontalent_aacepted_status']=='Y' && $jobed['talent_accepted_status']=='Y'){
					$output.="Selected".",";
					}elseif($jobed['nontalent_aacepted_status']=='R' || $jobed['talent_accepted_status']=='R'){
					$output.="Reject".",";
					}elseif($jobed['nontalent_aacepted_status']=='Y' && $jobed['talent_accepted_status']=='N' && $jobed['ping']==0){
					$output.="Bookingsent".",";
					}
					$output .=$blank.",";
					$output .=$blank.",";
					$cnt++;
					$output .="\r\n";
				}
				
				 foreach($requirementfeatured['job_quote'] as $jobedquote){ //pr($jobed); die;
					
					$output .=$cnt.",";
					$output.=$jobedquote['user']['profile']['name'].",";
					$dateOfBirth = date('d-M-Y',strtotime($jobedquote['user']['profile']['dob']));
					$today = date("d-M-Y");
					$diff = date_diff(date_create($dateOfBirth), date_create($today));
					$age = $diff->format('%y');
					$output .=date('d-M-Y',strtotime($jobedquote['user']['profile']['dob'])).',';
					$output .=$age.',';
					$output.=$jobedquote['user']['profile']['gender'].",";
					$output.=$jobedquote['user']['email'].",";
					$output.='('.$jobedquote['user']['profile']['phonecode'].')'.$jobedquote['user']['profile']['phone'].",";
					if($jobedquote['user']['profile']['skypeid']!=''){
					$output.=$jobedquote['user']['profile']['skypeid'].",";
					}else{
						$output .=$blank.",";
						}
					if($jobedquote['user']['profile']['guardian_email']!=''){
					$output.=$jobedquote['user']['profile']['guardian_email'].",";
				}else{
					$output .=$blank.",";
				}
					if($jobedquote['user']['profile']['guardian_phone']!=''){
					$output.=$jobedquote['user']['profile']['guardian_phone'].",";
				}else{
					$output .=$blank.",";
				}
				
					if($jobedquote['user']['skillset'])
					{
					$knownskills = '';
					foreach($jobedquote['user']['skillset'] as $skillquote)
					{
					if(!empty($knownskills))
					{
						$knownskills = $knownskills.', '.$skillquote['skill']['name'];
					}
					else
					{
						$knownskills = $skillquote['skill']['name'];
					}
					}
					$output.=str_replace(',',' ',$knownskills).',';
				   // echo $knownlanguages;
					}
					$output.=$jobedquote['user']['profile']['enthicity']['title'].",";
					$output.=str_replace(',',' ',$jobed['user']['profile']['location']).',';
					$output.=$jobedquote['user']['profile']['country']['name'].",";
					$output.=$jobedquote['user']['profile']['state']['name'].",";
					$output.=$jobedquote['user']['profile']['city']['name'].",";
					$output .=$blank.",";
					$output.="Offered Amount: ($".$jobedquote['revision'].")Talent Quote: $".$jobedquote['amt'].",";
					$output.=$jobedquote['revision'].",";
				
				
				
					$cnt++;
					$output .="\r\n";
				}
				
				//$output.=$job["title"].",";
				
		$filename = "Requirement.xlsx";
		header('Content-type: application/xlsx');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
		die;
		$this->redirect($this->referer());
	}
	
	
	// Showing Suggested Profile and action to make job featured. 
	function suggestedprofile($jobid=null)
	{
	    $this->loadModel('Requirement');
	    $this->loadModel('RequirmentVacancy');
	    $this->loadModel('Skill');
	    $this->loadModel('Country');
	    $this->loadModel('State');
	    $this->loadModel('City');
	    $this->loadModel('Featuredjob');
	    
	    // Find featured job packages
	    $featuredjob = $this->Featuredjob->find('all')->where(['Featuredjob.status'=>'Y'])->order(['Featuredjob.priorites' => 'ASC'])->toarray();
	    $this->set('featuredjob', $featuredjob);
	    $this->set('job_id', $jobid);
	    $activejobs = $this->Requirement->find('all')->contain(['RequirmentVacancy'=>['Skill'],'Country','State','City'])->where(['Requirement.id' =>$jobid])->first();
	    $city = $activejobs['city_id'];
	    $state = $activejobs['state_id'];
	    $country = $activejobs['country_id'];
	    $loc_lat = $activejobs['latitude'];
	    $loc_long = $activejobs['longitude'];
	    
	    $sex = array();
	    $skills = array();
	    $current_time = time();
	    $currentdate=date('Y-m-d H:m:s');
	    $featured = 0;
	    if($activejobs['expiredate'] > $currentdate)
	    {
		$featured = 1;
	    }
	    $this->set('featured', $featured);
	    
	    foreach($activejobs->requirment_vacancy as $vacancies)
	    {
		if(!in_array($vacancies->sex,$sex))
		{
		    $sex[] = $vacancies->sex; 
		}
		if(!in_array($vacancies->skill->id,$skills))
		{
		    $skills[] = $vacancies->skill->id; 
		}
	    }
	    
	    $conn = ConnectionManager::get('default');
	    $user_qry = "SELECT professinal_info.performing_year, country.name as country, cities.name as city_name, states.name as state_name, users.id,personal_profile.*, skill.*, 1.609344 * 6371 * acos( cos( radians('".$loc_lat."') ) * cos( radians(personal_profile.current_lat) ) * cos( radians(personal_profile.current_long) - radians('".$loc_long."') ) + sin( radians('".$loc_lat."') ) * sin( radians(personal_profile.current_lat) ) ) AS cdistance, 1.609344 * 6371 * acos( cos( radians('".$loc_lat."') ) * cos( radians(personal_profile.lat) ) * cos( radians(personal_profile.longs) - radians('".$loc_long."') ) + sin( radians('".$loc_lat."') ) * sin( radians(personal_profile.lat) ) ) AS fdistance FROM `users` LEFT JOIN personal_profile on users.id=personal_profile.user_id LEFT JOIN skill on users.id=skill.user_id LEFT JOIN professinal_info on users.id=professinal_info.user_id LEFT JOIN country on personal_profile.country_ids=country.id LEFT JOIN states on personal_profile.state_id=states.id LEFT JOIN cities on personal_profile.city_id=cities.id where users.role_id='".TALANT_ROLEID."' and personal_profile.gender IN ('".implode(",",$sex)."') and skill.skill_id IN ('".implode(",",$skills)."') and personal_profile.country_ids='".$country."' and personal_profile.state_id='".$state."' and personal_profile.city_id='".$city."' having cdistance < ".SEARCH_DISTANCE." and fdistance < ".SEARCH_DISTANCE;
	    
	    $qryexes = $conn->execute($user_qry);
	    $profiles = $qryexes->fetchAll('assoc');
	    
	  //  pr($profiles); die;
	    
	    
	    $this->set(compact('profiles'));	
	}


}


