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


class HomesController extends AppController
{
	public function initialize()
    	{
	$this->loadModel('Contacts');
	$this->loadModel('Subscribes');
	$this->loadModel('Pages');
	$this->loadModel('Testimonials');

	$this->loadModel('Sitesettings');
        parent::initialize();
	$this->Auth->allow(['index', 'add','addsubscribe','contactservice','notifications']);
        //$this->loadComponent('Flash');  Include the FlashComponent
    	}

public function featuredartist()
    {
	$this->loadModel('Users');
	$this->loadModel('Profile');
	$uid = $this->request->session()->read('Auth.User.id');
	$userdetail = $this->Profile->find('all')->where(['Profile.user_id' =>$uid])->first();
	$lat= $userdetail['lat'];
	$lng= $userdetail['longs'];
	$cur_lat= $userdetail['current_lat'];
	$cur_lng= $userdetail['current_long'];
	

	$conn = ConnectionManager::get('default');
	$featuredartist ="SELECT 1.609344 * 6371 * acos( cos( radians('".$cur_lat."') ) * cos( radians(Profile.current_lat) ) * cos( radians(Profile.current_long) - radians('".$cur_lng."') ) + sin( radians('".$cur_lat."') ) * sin( radians(Profile.current_lat) ) ) AS cdistance,1.609344 * 6371 * acos( cos( radians('".$lat."') ) * cos( radians(Profile.lat) ) * cos( radians(Profile.longs) - radians('".$lng."') ) + sin( radians('".$lat."') ) * sin( radians(Profile.lat) ) ) AS fdistance, Users.id, Users.profilepack_id, Users.email, Users.password, Users.user_name, Users.phone, Profile.id AS `Profile__id`, Profile.name AS `Profile__name`, Profile.profile_image, Profile.gender, Profile.dob,Profile.user_id, Profile.created, Profile.city_id, Profile.state_id, Profile.location, Profile.phonecode, Profile.phonecountry, Profile.countrycode, Country.id, Country.name, Profilepack.id, Profilepack.proiorties,Profilepack.featured,  Profilepack.price, Profilepack.validity_days FROM users Users INNER JOIN personal_profile Profile ON Users.id = (Profile.user_id) INNER JOIN country Country ON Country.id = (Profile.country_ids) INNER JOIN profile_package Profilepack ON Profilepack.id = (Users.profilepack_id) WHERE Users.role_id = '".TALANT_ROLEID."' having fdistance < ".SEARCH_DISTANCE."  and cdistance < ".SEARCH_DISTANCE." ORDER BY Users.id DESC";
	    $allfeaturedartist= $conn->execute($featuredartist);
    $viewfeaturedartist= $allfeaturedartist->fetchAll('assoc');
    
    $this->set('viewfeaturedartist', $viewfeaturedartist);
	

    }
 public function featuredjob()
    {
		$this->loadModel('Profile');
	    $uid = $this->request->session()->read('Auth.User.id');
		$userdetail = $this->Profile->find('all')->where(['Profile.user_id' =>$uid])->first();
		$cur_lat= $userdetail['current_lat'];
		$cur_lng= $userdetail['current_long'];
		$lat= $userdetail['lat'];
		$lng= $userdetail['longs'];
	$currentdate=date('Y-m-d H:m:s');
		 $conn = ConnectionManager::get('default');
		$requirement = "SELECT Profile.name, 1.609344 * 6371 * acos( cos( radians('".$cur_lat."') ) * cos( radians(Requirement.latitude) ) * cos( radians(Requirement.longitude) - radians('".$cur_lng."') ) + sin( radians('".$cur_lat."') ) * sin( radians(Requirement.latitude) ) ) AS cdistance,1.609344 * 6371 * acos( cos( radians('".$lat."') ) * cos( radians(Requirement.latitude) ) * cos( radians(Requirement.longitude) - radians('".$lng."') ) + sin( radians('".$lat."') ) * sin( radians(Requirement.latitude) ) ) AS fdistance, Requirement.id AS `Requirement__id`, Requirement.title AS `Requirement__title`, Requirement.talent_requirement AS `Requirement__talent_requirement`, Requirement.talent_requirement_description AS `Requirement__talent_requirement_description`, Requirement.payment_frequency AS `Requirement__payment_frequency`, Requirement.continous_requirement AS `Requirement__continous_requirement`, Requirement.number_attendees AS `Requirement__number_attendees`, Requirement.event_from_date AS `Requirement__event_from_date`, Requirement.event_to_date AS `Requirement__event_to_date`, Requirement.venue_type AS `Requirement__venue_type`, Requirement.venue_description AS `Requirement__venue_description`, Requirement.venue_address AS `Requirement__venue_address`, Requirement.country_id AS `Requirement__country_id`, Requirement.state_id AS `Requirement__state_id`, Requirement.city_id AS `Requirement__city_id`, Requirement.latitude AS `Requirement__latitude`, Requirement.longitude AS `Requirement__longitude`, Requirement.landmark AS `Requirement__landmark`, Requirement.requirement_desc AS `Requirement__requirement_desc`, Requirement.questionmarelink AS `Requirement__questionmarelink`, Requirement.user_id AS `Requirement__user_id`, Requirement.talent_id AS `Requirement__talent_id`, Requirement.image AS `Requirement__image`, Requirement.location AS `Requirement__location`, Requirement.last_date_app AS `Requirement__last_date_app`, Requirement.talent_required_fromdate AS `Requirement__talent_required_fromdate`, Requirement.talent_required_todate AS `Requirement__talent_required_todate`, Requirement.event_type AS `Requirement__event_type`, Requirement.time AS `Requirement__time`, Requirement.payment_description AS `Requirement__payment_description`, Requirement.featured AS `Requirement__featured`, Requirement.expiredate AS `Requirement__expiredate`, Requirement.status AS `Requirement__status`, Requirement.created AS `Requirement__created` FROM requirement Requirement INNER JOIN personal_profile Profile ON Profile.user_id = (Requirement.user_id) WHERE (Requirement.expiredate >= '".$currentdate."' AND Requirement.last_date_app >= '".$currentdate."') having fdistance < ".SEARCH_DISTANCE."  and cdistance < ".SEARCH_DISTANCE." ORDER BY Requirement.id DESC";
		 $allrequirement = $conn->execute($requirement);
	    $viewrequirement = $allrequirement ->fetchAll('assoc');
	    $this->set('viewrequirement', $viewrequirement);
    }

    	public function index()
    	{
	    $this->loadModel('Country');
	    $this->loadModel('Users');
	    $this->loadModel('Profile');
	   // $this->loadModel('Users');
	    
	    $this->Users->recursive=3;
	    
	    $country = $this->Country->find('list')->select(['id','name'])->toarray();
	    $this->set('country', $country);
	    $phonecodess = $this->Country->find('list',['keyField'=>'id','valueField'=>'cntcode'])->toarray();
	    $this->set('phonecodess', $phonecodess);
	    
	    $talent = $this->Users->find('all')->contain(['Skillset'=>['Skill'],'Profile'=>['Country'],'Profilepack'])->where(['Users.role_id'=>TALANT_ROLEID])->order(['Users.id' => 'DESC'])->toarray();

	    $this->set(compact('talent'));
	    /*------------------profile packed start get code---------------------*/
	    $this->loadModel('Profilepack');
	    $Profilepack = $this->Profilepack->find('all')->where(['Profilepack.status'=>'Y'])->order(['Profilepack.Visibility_Priority' => 'ASC'])->toarray();
	    $this->set(compact('Profilepack'));

	    /*------------------profile packed end get code---------------------*/
	    $this->loadModel('RequirementPack');
	    $RequirementPack = $this->RequirementPack->find('all')->where(['RequirementPack.status'=>'Y'])->order(['RequirementPack.priorites' => 'ASC'])->toarray();
	    $this->set('RequirementPack', $RequirementPack);

	    /*------------------Recruiter packed start get code---------------------*/

	    $this->loadModel('RecuriterPack');
	    $RecuriterPack = $this->RecuriterPack->find('all')->where(['RecuriterPack.status'=>'Y'])->order(['RecuriterPack.priorites' => 'ASC'])->toarray();
	    $this->set(compact('RecuriterPack'));
	    /*------------------Recruiter packed end get code---------------------*/
		$this->loadModel('Requirement');
		$currentdate=date('Y-m-d H:m:s');
	    $requirementfeatured = $this->Requirement->find('all')->contain(['Users'=>['Profile']])->where(['Requirement.expiredate >='=>$currentdate,'Requirement.last_date_app >='=>$currentdate])->order(['Requirement.id' => 'DESC'])->toarray();
	    
	    $this->set(compact('requirementfeatured'));
        }
        
        
	public function addsubscribe(){
		$this->viewBuilder()->layout('front');
		
		//$this->request->session()->read('Subscrib');
		$subscribe = $this->Subscribes->newEntity();
		if ($this->request->is('post')) {
			 $subscribe = $this->Subscribes->patchEntity($subscribe, $this->request->data);
			if ($this->Subscribes->save($subscribe)) {
			    $this->request->session()->write('Subscrib', 'subscribes');
			    $this->Flash->success(__('Your subscription has been saved.'));
			    return $this->redirect(['action' => 'index']);
			}else{
				if($subscribe->errors()){
				    $error_msg = [];
				    foreach( $subscribe->errors() as $errors){
				    if(is_array($errors)){
					foreach($errors as $error){
					    $error_msg[]    =   $error;
					}
				    }else{
					$error_msg[]    =   $errors;
				    }
				}

				if(!empty($error_msg)){
				    $this->Flash->error(
					__("Please fix the following error(s): ".implode("\n \r", $error_msg))
				    );
				}
			    }

				return $this->redirect(['action' => 'index']);	
			}	
		}
		
	}	
    
	
	public function notifications()
	{
	    $uid = $this->request->session()->read('Auth.User.id');
	    $role_id = $this->request->session()->read('Auth.User.role_id');
	    if($uid > 0)
	    {
		$this->autoRender=false;
		$notifications['friendreq'] = '';
		$notifications['messages'] = '';
		
		// Contact Request Notifications
		if($role_id==TALANT_ROLEID)
		{
		    $this->loadModel('Contactrequest');
		    $friendreq = $this->Contactrequest->find('all')->where(['viewedstatus' => 'N','to_id' =>$uid])->count();
		    $notifications['friendreq'] = $friendreq;	    
		}
		
		if($role_id==TALANT_ROLEID)
		{ 
		    //$appplications = 0;
		    //$quotes = 0;
		    // Message Received Notifications
		    $this->loadModel('Messages');
		    $messages = $this->Messages->find('all')->where(['to_viewed_status' => 'N','to_id' =>$uid])->count();
		    $notifications['messages'] = $messages;
		    
		    // Booking Request received
		    /*
			$this->loadModel('JobApplication');
		    $appplications = $this->JobApplication->find('all')->where(['viewedstatus' => 'N','user_id' =>$uid])->where(['talent_accepted_status'=>'N'])->count();
			*/
		    // Ask quote request received
		    /*$this->loadModel('JobQuote');
		    $quotes = $this->JobQuote->find('all')->where(['viewedstatus' => 'N','user_id' =>$uid])->count();
		    
		    if($appplications > 0 || $quotes > 0)
		    {
			$alerts = $quotes+$appplications;
			$notifications['total_alerts'] = $alerts;
		    }
			*/
		}
		echo json_encode($notifications);
	    }
	    else
	    {
	    
	    
	    }
	}
}
