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
use Cake\I18n\Time;

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
		$this->Auth->allow(['index', 'add', 'addsubscribe', 'contactservice', 'notifications', 'packagerewart', 'featuredartist', 'featuredjob']);
		//$this->loadComponent('Flash');  Include the FlashComponent
	}


	public function featuredartist($innerfunct = null)
	{

		$this->loadModel('Users');
		$this->loadModel('Profile');
		$uid = $this->request->session()->read('Auth.User.id');
		$userdetail = $this->Profile->find('all')->where(['Profile.user_id' => $uid])->first();
		$lat = $userdetail['lat'];
		$lng = $userdetail['longs'];
		$cur_lat = $userdetail['current_lat'];
		$cur_lng = $userdetail['current_long'];
		$currentdate = date('Y-m-d H:m:s');

		// Update users whose featured_expiry has passed
		$this->Users->updateAll(
			[
				'featured_expiry' => null,
				'feature_by_admin' => 'N'
			],
			[
				'featured_expiry <' => $currentdate,
			]
		);



		$conn = ConnectionManager::get('default');

		// $featuredartist = "SELECT 1.609344 * 6371 * acos( cos( radians('" . $cur_lat . "') ) 
		// * cos( radians(Profile.current_lat) ) 
		// * cos( radians(Profile.current_long) - radians('" . $cur_lng . "') ) + sin( radians('" . $cur_lat . "') ) 
		// * sin( radians(Profile.current_lat) ) ) AS cdistance,1.609344 * 6371 
		// * acos( cos( radians('" . $lat . "') ) * cos( radians(Profile.lat) ) 
		// * cos( radians(Profile.longs) - radians('" . $lng . "') ) + sin( radians('" . $lat . "') ) 
		// * sin( radians(Profile.lat) ) ) AS fdistance, Users.id, 
		// Users.profilepack_id, 
		// Users.email, 
		// Users.password, 
		// Users.user_name, 
		// Users.phone, 
		// Users.featured_expiry, 
		// Profile.id AS `Profile__id`, 
		// Profile.name AS `Profile__name`, 
		// Profile.profile_image, 
		// Profile.gender, 
		// Profile.dob,Profile.user_id, 
		// Profile.created, 
		// Profile.city_id, 
		// Profile.state_id, 
		// Profile.location, 
		// Profile.phonecode, 
		// Profile.phonecountry, 
		// Profile.countrycode, 
		// Country.id, 
		// Country.name, 
		// Profilepack.id, 
		// Profilepack.proiorties,
		// Profilepack.featured,  
		// Profilepack.price, 
		// Profilepack.validity_days,

		// (SELECT subscriptions.package_id FROM subscriptions
		// 	WHERE subscriptions.package_type='PR' and subscriptions.user_id=Profile.user_id and subscriptions.status='Y') as p_package,

		// (Select subscriptions.package_id  FROM subscriptions
		// 	WHERE subscriptions.package_type='RC' and subscriptions.status='Y' and subscriptions.user_id=Profile.user_id) as r_package,

		// (SELECT visibility_matrix.ordernumber FROM `visibility_matrix` where visibility_matrix.profilepack_id=p_package and visibility_matrix.recruiter_id=r_package) as order_num


		// FROM users Users 
		// INNER JOIN personal_profile Profile ON Users.id = (Profile.user_id) 
		// LEFT JOIN country Country ON Country.id = (Profile.country_ids) 
		// LEFT JOIN profile_package Profilepack ON Profilepack.id = (Users.profilepack_id) 
		// WHERE (Users.featured_expiry >= '" . $currentdate . "' AND Users.role_id = '" . TALANT_ROLEID . "') having fdistance < " . SEARCH_DISTANCE . "  and cdistance < " . SEARCH_DISTANCE . " OR order_num > 0 ORDER BY cdistance ASC, order_num ASC";


		// update query 30-03-2024
		$featuredartist =
			"SELECT 
		 1.609344 * 6371 * ACOS( COS( RADIANS('" . $cur_lat . "') ) 
		 * COS( RADIANS(Profile.current_lat) ) 
		 * COS( RADIANS(Profile.current_long) - RADIANS('" . $cur_lng . "') ) + SIN( RADIANS('" . $cur_lat . "') ) 
		 * SIN( RADIANS(Profile.current_lat) ) ) AS cdistance,
		 
		 1.609344 * 6371 * ACOS( COS( RADIANS('" . $lat . "') ) 
		 * COS( RADIANS(Profile.lat) ) 
		 * COS( RADIANS(Profile.longs) - RADIANS('" . $lng . "') ) + SIN( RADIANS('" . $lat . "') ) 
		 * SIN( RADIANS(Profile.lat) ) ) AS fdistance, 
		 
		 Users.id, 
		 Users.profilepack_id, 
		 Users.email, 
		 Users.password, 
		 Users.user_name, 
		 Users.phone, 
		 Users.featured_expiry, 
		 Profile.id AS `Profile__id`, 
		 Profile.name AS `Profile__name`, 
		 Profile.profile_image, 
		 Profile.gender, 
		 Profile.dob,
		 Profile.user_id, 
		 Profile.created, 
		 Profile.city_id, 
		 Profile.state_id, 
		 Profile.location, 
		 Profile.phonecode, 
		 Profile.phonecountry, 
		 Profile.countrycode, 
		 Country.id, 
		 Country.name, 
		 Profilepack.id, 
		 Profilepack.proiorties,
		 Profilepack.featured,  
		 Profilepack.price, 
		 Profilepack.validity_days,
		 
		 (SELECT 
			 MAX(subscriptions.package_id) 
		  FROM 
			 subscriptions
		  WHERE 
			 subscriptions.package_type='PR' 
			 AND subscriptions.user_id=Profile.user_id 
			 AND subscriptions.status='Y') AS p_package,
		 
		 (SELECT 
			 MAX(subscriptions.package_id)  
		  FROM 
			 subscriptions
		  WHERE 
			 subscriptions.package_type='RC' 
			 AND subscriptions.status='Y' 
			 AND subscriptions.user_id=Profile.user_id) AS r_package,
		 
		 (SELECT 
			 visibility_matrix.ordernumber 
		  FROM 
			 visibility_matrix 
		  WHERE 
			 visibility_matrix.profilepack_id = (
				 SELECT 
					 MAX(subscriptions.package_id)
				 FROM 
					 subscriptions
				 WHERE 
					 subscriptions.package_type='PR' 
					 AND subscriptions.user_id=Profile.user_id 
					 AND subscriptions.status='Y'
			 )
			 AND visibility_matrix.recruiter_id = (
				 SELECT 
					 MAX(subscriptions.package_id)  
				 FROM 
					 subscriptions
				 WHERE 
					 subscriptions.package_type='RC' 
					 AND subscriptions.status='Y' 
					 AND subscriptions.user_id=Profile.user_id
			 )
		  LIMIT 1) AS order_num
			FROM 
				users Users 
				INNER JOIN personal_profile Profile ON Users.id = Profile.user_id
				LEFT JOIN country Country ON Country.id = Profile.country_ids
				LEFT JOIN profile_package Profilepack ON Profilepack.id = Users.profilepack_id
			WHERE 
				Users.featured_expiry >= '" . $currentdate . "' 
				AND Users.role_id = '" . TALANT_ROLEID . "' 
			HAVING 
				fdistance < " . SEARCH_DISTANCE . "  
				AND cdistance < " . SEARCH_DISTANCE . " 
				OR order_num > 0 
			ORDER BY 
				cdistance ASC, 
				order_num ASC;
			";



		$allfeaturedartist = $conn->execute($featuredartist);
		$viewfeaturedartist = $allfeaturedartist->fetchAll('assoc');

		$this->set('viewfeaturedartist', $viewfeaturedartist);

		if ($innerfunct == 1) {
			return $viewfeaturedartist;
		}
	}

	public function featuredjob($infunc = null)
	{
		$this->loadModel('Profile');
		$this->loadModel('Savejobs');
		$this->loadModel('Likejobs');
		$this->loadModel('Blockjobs');
		$this->loadModel('Requirement');

		$uid = $this->request->session()->read('Auth.User.id');
		$userdetail = $this->Profile->find('all')->where(['Profile.user_id' => $uid])->first();
		$currentdate = date('Y-m-d H:m:s');

		// Update users whose featured_expiry has passed
		$this->Requirement->updateAll(
			[
				'featured' => null,
				'expiredate' => null,
				'feature_job_days' => 0
			],
			[
				'expiredate <' => $currentdate,
			]
		);
		// pr($data);exit;

		$cur_lat = $userdetail['current_lat'];
		$cur_lng = $userdetail['current_long'];
		$lat = $userdetail['lat'];
		$lng = $userdetail['longs'];
		$conn = ConnectionManager::get('default');
		$requirement = "SELECT Profile.name, 1.609344 * 6371 * acos( cos( radians('" . $cur_lat . "') ) 
		* cos( radians(Requirement.latitude) ) 
		* cos( radians(Requirement.longitude) - radians('" . $cur_lng . "') ) + sin( radians('" . $cur_lat . "') ) 
		* sin( radians(Requirement.latitude) ) ) AS cdistance,1.609344 * 6371 * acos( cos( radians('" . $lat . "') ) 
		* cos( radians(Requirement.latitude) ) 
		* cos( radians(Requirement.longitude) - radians('" . $lng . "') ) + sin( radians('" . $lat . "') ) 
		* sin( radians(Requirement.latitude) ) ) AS fdistance, Requirement.id AS `Requirement__id`, 
		Requirement.title AS `Requirement__title`, Requirement.telent_type AS `Requirement__telent_type`, 
		Requirement.talent_requirement_description AS `Requirement__talent_requirement_description`, 
		Requirement.payment_frequency AS `Requirement__payment_frequency`, 
		Requirement.continous_requirement AS `Requirement__continous_requirement`, 
		Requirement.number_attendees AS `Requirement__number_attendees`, 
		Requirement.event_from_date AS `Requirement__event_from_date`, 
		Requirement.event_to_date AS `Requirement__event_to_date`, 
		Requirement.venue_type AS `Requirement__venue_type`, 
		Requirement.venue_description AS `Requirement__venue_description`, 
		Requirement.venue_address AS `Requirement__venue_address`, 
		Requirement.country_id AS `Requirement__country_id`, 
		Requirement.state_id AS `Requirement__state_id`, 
		Requirement.city_id AS `Requirement__city_id`, 
		Requirement.latitude AS `Requirement__latitude`, 
		Requirement.longitude AS `Requirement__longitude`, 
		Requirement.landmark AS `Requirement__landmark`, 
		Requirement.requirement_desc AS `Requirement__requirement_desc`, 
		Requirement.questionmarelink AS `Requirement__questionmarelink`, 
		Requirement.user_id AS `Requirement__user_id`, 
		Requirement.talent_id AS `Requirement__talent_id`, 
		Requirement.image AS `Requirement__image`, 
		Requirement.location AS `Requirement__location`, 
		Requirement.last_date_app AS `Requirement__last_date_app`, 
		Requirement.talent_required_fromdate AS `Requirement__talent_required_fromdate`, 
		Requirement.talent_required_todate AS `Requirement__talent_required_todate`, 
		Requirement.event_type AS `Requirement__event_type`, 
		Requirement.time AS `Requirement__time`, 
		Requirement.payment_description AS `Requirement__payment_description`, 
		Requirement.featured AS `Requirement__featured`, 
		Requirement.expiredate AS `Requirement__expiredate`, 
		Requirement.status AS `Requirement__status`, 
		Requirement.created AS `Requirement__created`,

		(SELECT subscriptions.package_id FROM subscriptions
		WHERE subscriptions.package_type='PR' and subscriptions.user_id=Requirement.user_id ORDER BY id desc
		LIMIT 1) as p_package,

		(Select subscriptions.package_id  FROM subscriptions
		WHERE subscriptions.package_type='RC' and subscriptions.user_id=Requirement.user_id ORDER BY id desc
		LIMIT 1) as r_package,

		(SELECT visibility_matrix.ordernumber FROM `visibility_matrix` where visibility_matrix.profilepack_id=p_package and visibility_matrix.recruiter_id=r_package) as order_num

		FROM requirement Requirement INNER JOIN personal_profile Profile ON Profile.user_id = (Requirement.user_id) 
		WHERE (Requirement.expiredate >= '" . $currentdate . "' AND Requirement.last_date_app >= '" . $currentdate . "' AND Requirement.status = 'Y') having fdistance < " . SEARCH_DISTANCE . "  and cdistance < " . SEARCH_DISTANCE . " OR order_num > 0 ORDER BY cdistance ASC, order_num ASC ";
		//pr($requirement); die;
		$allrequirement = $conn->execute($requirement);
		$viewrequirement = $allrequirement->fetchAll('assoc');
		//pr($viewrequirement); die;
		$this->set('viewrequirement', $viewrequirement);
		if ($infunc == 1) {
			return $viewrequirement;
		}

		$user_id = $this->request->session()->read('Auth.User.id');
		$Savejobsdata = $this->Savejobs->find('all')->where(['Savejobs.user_id' => $user_id])->order(['Savejobs.id' => 'ASC'])->toarray();
		$likejobsdata = $this->Likejobs->find('all')->where(['Likejobs.user_id' => $user_id])->order(['Likejobs.id' => 'ASC'])->toarray();
		$Blockjobsdata = $this->Blockjobs->find('all')->where(['Blockjobs.user_id' => $user_id])->order(['Blockjobs.id' => 'ASC'])->toarray();

		foreach ($Savejobsdata as $key => $value) {
			$savejobarray[] = $value['job_id'];
		}

		foreach ($Blockjobsdata as $key => $value) {
			$blockjobarray[] = $value['job_id'];
		}
		foreach ($likejobsdata as $key => $value) {
			$likejobarray[] = $value['job_id'];
		}
		$this->set('savejobarray', $savejobarray);
		$this->set('likejobarray', $likejobarray);
		$this->set('blockjobarray', $blockjobarray);
	}

	public function index()
	{

		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Static');
		$this->loadModel('Banner');
		$this->loadModel('Profilepack');
		$this->loadModel('RequirementPack');
		$this->loadModel('RecuriterPack');
		$this->loadModel('Requirement');

		$session = $this->request->session();
		$session->delete('Refinejobfilter');
		$session = $this->request->session();
		$currentdate = date('Y-m-d H:m:s');
		$session->delete('advanceprofiesearchdata');
		$this->Users->recursive = 3;
		// pr($this->request->data);exit;

		$country = $this->Country->find('list')->select(['id', 'name'])->toarray();
		$this->set('country', $country);

		$phonecodess = $this->Country->find('list', ['keyField' => 'id', 'valueField' => 'cntcode'])->toarray();
		$this->set('phonecodess', $phonecodess);

		$banner = $this->Banner->find('all')->where(['Banner.status' => 'Y', 'Banner.banner_date_from <=' => $currentdate, 'Banner.banner_date_to >=' => $currentdate])->order(['RAND()'])->toarray();

		$sitesetting = $this->Sitesettings->get(1);
		$this->set(compact('banner', 'sitesetting'));

		$talent = $this->Users->find('all')->contain(['Skillset' => ['Skill'], 'Profile' => ['Country'], 'Profilepack'])->where(['Users.role_id' => TALANT_ROLEID, 'Users.featured_expiry >=' => $currentdate, 'Users.feature_pro_status' => 'Y'])->order(['Users.id' => 'DESC'])->toarray();
		$this->set(compact('talent'));

		$Profilepack = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y'])->order(['Profilepack.Visibility_Priority' => 'ASC'])->toarray();
		$this->set(compact('Profilepack'));

		$RequirementPack = $this->RequirementPack->find('all')->where(['RequirementPack.status' => 'Y'])->order(['RequirementPack.priorites' => 'ASC'])->toarray();
		$this->set('RequirementPack', $RequirementPack);

		$RecuriterPack = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y'])->order(['RecuriterPack.priorites' => 'ASC'])->toarray();
		$this->set(compact('RecuriterPack'));
		// if ($_SESSION['Auth']['User']['id']) {
		$featuredReuirment = $this->featuredjob(1);
		$viewfeaturedartist = $this->featuredartist(1);
		// }
		$default_banner = $this->Banner->find('all')->where(['Banner.is_default_image' => 1])->order(['Banner.id' => 'Desc'])->first();
		$how_it_work = $this->Static->find('all')->where(['Static.id' => 4, 'Static.status' => 'Y'])->first();
		$this->set(compact('featuredReuirment', 'viewfeaturedartist', 'default_banner', 'how_it_work'));
	}


	public function addsubscribe()
	{
		$this->viewBuilder()->layout('front');

		//$this->request->session()->read('Subscrib');
		$subscribe = $this->Subscribes->newEntity();
		if ($this->request->is('post')) {
			$subscribe = $this->Subscribes->patchEntity($subscribe, $this->request->data);
			if ($this->Subscribes->save($subscribe)) {
				$this->request->session()->write('Subscrib', 'subscribes');
				$this->Flash->success(__('Your subscription has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				if ($subscribe->errors()) {
					$error_msg = [];
					foreach ($subscribe->errors() as $errors) {
						if (is_array($errors)) {
							foreach ($errors as $error) {
								$error_msg[]    =   $error;
							}
						} else {
							$error_msg[]    =   $errors;
						}
					}

					if (!empty($error_msg)) {
						$this->Flash->error(
							__("Please fix the following error(s): " . implode("\n \r", $error_msg))
						);
					}
				}

				return $this->redirect(['action' => 'index']);
			}
		}
	}


	// public function notifications()
	// {
	// 	$this->loadModel('Users');
	// 	$this->loadModel('Packfeature');
	// 	$this->loadModel('Messages');
	// 	$this->loadModel('JobApplication');
	// 	$this->loadModel('Notification');
	// 	$this->loadModel('JobQuote');
	// 	$this->loadModel('Contactrequest');
	// 	$this->autoRender = false;
	// 	$uid = $this->request->session()->read('Auth.User.id');
	// 	$role_id = $this->request->session()->read('Auth.User.role_id');
	// 	if ($uid) {
	// 		$user_data['last_login'] = date('Y-m-d H:i:s');
	// 		$Pack = $this->Users->get($uid);
	// 		$department = $this->Users->patchEntity($Pack, $user_data);
	// 		$this->Users->save($department);
	// 	}

	// 	if ($uid > 0) {
	// 		$notifications['friendreq'] = '';
	// 		$notifications['messages'] = '';

	// 		$packfeature = $this->Packfeature->find('all')
	// 		->where([
	// 			'user_id' => $uid,
	// 			'OR' => [
	// 				['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
	// 				['package_status' => 'default']
	// 			]
	// 		])
	// 		->order(['id' => 'DESC'])
	// 		->first();


	// 		// Contact Request Notifications
	// 		if ($role_id == TALANT_ROLEID) {
	// 			$friendreq = $this->Contactrequest->find('all')->where(['to_id' => $uid])->count();
	// 			if ($packfeature['number_of_introduction_recived'] >= $friendreq) {
	// 				$friendreq = $this->Contactrequest->find('all')->where(['viewedstatus' => 'N', 'to_id' => $uid])->count();
	// 				$notifications['friendreq'] = $friendreq;
	// 			} else {
	// 				$notifications['flag'] = '0';
	// 			}
	// 		}

	// 		if ($role_id == TALANT_ROLEID) {
	// 			$appplications = 0;
	// 			$quotes = 0;
	// 			// Message Received Notifications
	// 			$messages = $this->Messages->find('all')->where(['to_viewed_status' => 'N', 'to_id' => $uid])->count();
	// 			$notifications['messages'] = $messages;
	// 			// Booking Request received
	// 			$appplications = $this->JobApplication->find('all')->where(['viewedstatus' => 'N', 'user_id' => $uid, 'talent_accepted_status' => 'N'])->count();
	// 			// Ask quote request received

	// 			$quotes = $this->JobQuote->find('all')->where(['viewedstatus' => 'N', 'user_id' => $uid])->count();

	// 			if ($appplications > 0 || $quotes > 0) {
	// 				$alerts = $quotes + $appplications;
	// 				$notifications['total_alerts'] = $alerts;
	// 			}
	// 		}

	// 		$totalnotifications = $this->Notification->find('all')
	// 			->contain(['Users' => ['Profile']])
	// 			->where(['view_status' => 'N', 'notification_receiver' => $uid])
	// 			->count();

	// 		if ($totalnotifications > 0) {
	// 			$notifications['flag'] = $totalnotifications;
	// 		}
	// 		// pr($totalnotifications);die;

	// 		echo json_encode($notifications);
	// 	} 
	// 	exit;
	// }

	// Rupam Singh 24 Jan 2025
	public function notifications()
	{
		$this->loadModel('Users');
		$this->loadModel('Packfeature');
		$this->loadModel('Messages');
		$this->loadModel('JobApplication');
		$this->loadModel('Notification');
		$this->loadModel('JobQuote');
		$this->loadModel('Contactrequest');

		$this->autoRender = false;

		$uid = $this->request->session()->read('Auth.User.id');
		$role_id = $this->request->session()->read('Auth.User.role_id');

		if (!$uid) {
			echo json_encode([]);
			exit;
		}

		// Update user's last login
		$this->Users->updateAll(['last_login' => date('Y-m-d H:i:s')], ['id' => $uid]);

		$notifications = [
			'friendreq' => 0,
			'messages' => 0,
			'total_alerts' => 0,
			'flag' => 0,
		];

		// Get user's active package or default package
		$packfeature = $this->Packfeature->find()
			->where([
				'user_id' => $uid,
				'OR' => [
					['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
					['package_status' => 'default']
				]
			])
			->order(['id' => 'DESC'])
			->first();

		// Contact Request Notifications
		if ($role_id == TALANT_ROLEID) {
			$friendreqCount = $this->Contactrequest->find()
				->where(['to_id' => $uid])
				->count();

			if ($packfeature && $packfeature['number_of_introduction_recived'] >= $friendreqCount) {
				$notifications['friendreq'] = $this->Contactrequest->find()
					->where(['viewedstatus' => 'N', 'to_id' => $uid])
					->count();
			} else {
				$notifications['flag'] = 0;
			}

			// Messages, Applications, and Quotes
			$notifications['messages'] = $this->Messages->find()
				->where(['to_viewed_status' => 'N', 'to_id' => $uid])
				->count();

			$appplications = $this->JobApplication->find()
				->where([
					'viewedstatus' => 'N',
					'user_id' => $uid,
					'talent_accepted_status' => 'N'
				])
				->count();


			$quotes = $this->JobQuote->find()
				->where(['viewedstatus' => 'N', 'user_id' => $uid])
				->count();

			$jobAlerts = count($this->jobalertscheckv1());
			// pr($jobAlerts);exit;
			if ($appplications > 0 || $quotes > 0 || $jobAlerts > 0) {
				$notifications['total_alerts'] = $appplications + $quotes + $jobAlerts;
			}
		}

		// General Notifications
		$totalnotifications = $this->Notification->find()
			->where(['view_status' => 'N', 'notification_receiver' => $uid])
			->count();

		if ($totalnotifications > 0) {
			$notifications['flag'] = $totalnotifications;
		}

		echo json_encode($notifications);
		exit;
	}

	public function getnotifications()
	{
		$this->loadModel('Notification');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Subscription');
		$this->loadModel('Profilepack');
		$this->loadModel('JobApplication');
		$this->loadModel('Professinal_info');
		$this->loadModel('Requirement');
		$this->loadModel('BookingRequest');
		$this->loadModel('JobQuote');
		$this->loadModel('Userjobanswer');
		$this->loadModel('Jobquestion');
		$this->loadModel('Skill');
		$this->loadModel('RecuriterPack');
		$uid = $this->request->session()->read('Auth.User.id');
		// सभी नोटिफिकेशन्स प्राप्त करें
		$notification = $this->Notification->find('all')
			->contain(['Users' => ['Profile']])
			->where(['notification_receiver' => $uid])
			->order(['Notification.id' => 'DESC'])
			->toArray();
		// pr($notification);exit;

		$this->set('notification', $notification);

		// view_status को 'Y' में अपडेट करें जहां view_status 'Y' नहीं है
		$notificationTable = TableRegistry::get("Notification");
		$notificationTable->updateAll(
			['view_status' => 'Y'],
			['view_status !=' => 'Y', 'notification_receiver' => $uid]
		);


		$today_brithday = $this->Profile->find('all')->contain(['Users'])->where(['MONTH(dob)' => date('m'), 'DAY(dob)' => date('d')])->toarray();
		$this->set('today_brithday', $today_brithday);

		// $profile_pack = $this->Subscription->find('all')->contain(['Users' => ['Profile']])->where(['Subscription.user_id' => $uid, 'Subscription.package_type' => 'PR'])->order(['Subscription.id' => 'desc'])->first();
		// //pr($profile_pack); die;

		// $recruiter_pack = $this->Subscription->find('all')->contain(['Users' => ['Profile']])->where(['Subscription.user_id' => $uid, 'Subscription.package_type' => 'RC'])->order(['Subscription.id' => 'desc'])->first();

		// $this->set('profile_pack', $profile_pack);
		// $this->set('recruiter_pack', $recruiter_pack);

		$requirementfeatured = $this->JobApplication->find('all')->contain(['Requirement', 'Skill', 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']])->where(['JobApplication.nontalent_aacepted_status' => 'Y', 'JobApplication.talent_accepted_status' => 'Y', 'Requirement.user_id' => $uid])->order(['JobApplication.id' => 'DESC'])->toarray();
		$this->set('requirementfeatured', $requirementfeatured);


		$currentdate = date('Y-m-d H:i:s'); // old code 
		// $subscriptions = $this->Subscription->find('all')
		// 	->where(['Subscription.user_id' => $uid, 'Subscription.package_type' => 'PR', 'DATE(Subscription.expiry_date) >=' => $currentdate])
		// 	->orWhere(['Subscription.user_id' => $uid, 'Subscription.package_type' => 'RC'])
		// 	->order(['Subscription.id' => 'DESC'])
		// 	->toarray();


		// Get latest valid PR or RC  By Rupam Singh 11/04/2025
		$prSubscription = $this->Subscription->find()
			->where([
				'Subscription.user_id' => $uid,
				'Subscription.package_type' => 'PR',
				'Subscription.expiry_date >=' => $currentdate
			])
			->order(['Subscription.id' => 'DESC'])
			->first();

		if (!$prSubscription) {
			$prSubscription = $this->Subscription->find()
				->where([
					'Subscription.user_id' => $uid,
					'Subscription.package_type' => 'PR',
					'Subscription.package_id' => 1
				])
				->order(['Subscription.id' => 'ASC'])
				->first();
		}

		// Get latest valid RC or fallback to package_id = 1
		$rcSubscription = $this->Subscription->find()
			->where([
				'Subscription.user_id' => $uid,
				'Subscription.package_type' => 'RC',
				'Subscription.expiry_date >=' => $currentdate
			])
			->order(['Subscription.id' => 'DESC'])
			->first();

		if (!$rcSubscription) {
			$rcSubscription = $this->Subscription->find()
				->where([
					'Subscription.user_id' => $uid,
					'Subscription.package_type' => 'RC',
					'Subscription.package_id' => 1
				])
				->order(['Subscription.id' => 'ASC'])
				->first();
		}

		// Final result with PR first, RC second
		$subscriptions = [
			'PR' => $prSubscription,
			'RC' => $rcSubscription
		];

		// pr($subscriptions);
		// exit;
		// pr($subscriptions['RC']['package_id']);
		// exit;


		$profile_pack = $this->Subscription->find('all')
			->contain(['Users' => ['Profile']])
			->where(['Subscription.user_id' => $uid, 'Subscription.id' => $subscriptions['PR']['id'], 'Subscription.package_type' => 'PR'])->first();
		// pr($profile_pack); die;

		$recruiter_pack = $this->Subscription->find('all')
			->contain(['Users' => ['Profile']])
			->where(['Subscription.user_id' => $uid, 'Subscription.id' => $subscriptions['RC']['id'], 'Subscription.package_type' => 'RC'])->first();

		$this->set('profile_pack', $profile_pack);
		$this->set('recruiter_pack', $recruiter_pack);



		// $currentpackanme=array();

		foreach ($subscriptions as $key => $value) {
			if ($value['package_type'] == 'PR') {
				$Profilepackcurrent = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => $value['package_id']])->first();
				$currentpackanme['PR'] = $Profilepackcurrent['name'];
				$currentpackanmess = $value['expiry_date'];
			}

			if ($value['package_type'] == 'RC') {
				$recruiterpackcurrent = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y', 'RecuriterPack.id' => $value['package_id']])->first();
				$currentpackanme['RC'] = $recruiterpackcurrent['title'];
				$currentpackanmess = $value['expiry_date'];
			}

			array_push($currentpackanme, $currentpackanmess);
		}
		// pr($currentpackanme); die;

		$this->set(compact('currentpackanme', 'subscriptions'));
	}

	public function updatenotification()
	{
		$this->loadModel('Notification');
		//pr($this->request->data); 

		$notificationtable = TableRegistry::get("Notification");
		$query = $notificationtable->query();
		$result = $query->update()
			->set(['view_status' => 'Y'])
			->where(['id' => $this->request->data['id']])
			->execute();
		die;
	}

	public function packagerewart()
	{
		$this->loadModel('Subscription');
		$this->loadModel('Profilepack');
		$currentdatetime = date('Y-m-d H:i:s a');
		$data = $this->Subscription->find('all')->where(['expiry_date >' => '2018-09-08 07:52:05'])->toarray();

		foreach ($data as $value) {

			if ($value->package_type == "PR") {
				$this->assigndefaultprofilepackage($value->user_id, $value->id);
			}
			if ($value->package_type == "RC") {
				$this->assigndefaultrecpack($value->user_id, $value->id);
			}
		}
		die;
	}


	public function assigndefaultprofilepackage($user_id, $sub_id)
	{
		// Assigning default package
		$this->loadModel('Packfeature');

		$feature_info['user_id'] = $user_id;
		$this->loadModel('Profilepack');

		$pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => PROFILE_PACKAGE])->order(['Profilepack.id' => 'ASC'])->first();

		$feature_info['number_categories'] = $pcakgeinformation['number_categories'];
		$feature_info['number_audio'] = $pcakgeinformation['number_audio'];
		$feature_info['number_video'] = $pcakgeinformation['number_video'];
		$feature_info['website_visibility'] = $pcakgeinformation['website_visibility'];
		$feature_info['private_individual'] = $pcakgeinformation['private_individual'];
		$feature_info['access_job'] = $pcakgeinformation['access_job'];
		$feature_info['number_job_application'] = $pcakgeinformation['number_job_application'];
		$feature_info['number_search'] = $pcakgeinformation['number_search'];
		$feature_info['ads_free'] = $pcakgeinformation['ads_free'];
		$feature_info['number_albums'] = $pcakgeinformation['number_albums'];
		$feature_info['message_folder'] = $pcakgeinformation['message_folder'];
		$feature_info['privacy_setting_access'] = $pcakgeinformation['privacy_setting_access'];
		$feature_info['access_to_ads'] = $pcakgeinformation['access_to_ads'];
		$feature_info['number_of_jobs_alerts'] = $pcakgeinformation['number_of_jobs_alerts'];
		$feature_info['number_of_introduction'] = $pcakgeinformation['number_of_introduction'];
		$feature_info['number_of_intorduction_send'] = $pcakgeinformation['number_of_intorduction_send'];
		$feature_info['search_of_other_profile'] = $pcakgeinformation['search_of_other_profile'];
		$feature_info['nubmer_of_jobs_month'] = $pcakgeinformation['nubmer_of_jobs'];
		$feature_info['introduction_sent'] = $pcakgeinformation['introduction_sent'];
		$feature_info['profile_likes'] = $pcakgeinformation['profile_likes'];
		$feature_info['job_alerts_month'] = $pcakgeinformation['job_alerts_month'];
		$feature_info['job_alerts'] = $pcakgeinformation['job_alerts'];
		$feature_info['packge'] = $pcakgeinformation['packge'];
		$feature_info['page_id'] = $pcakgeinformation['page_id'];
		$feature_info['persanalized_url'] = $pcakgeinformation['persanalized_url'];
		$feature_info['number_of_free_quote_month'] = $pcakgeinformation['number_of_free_quote_month'];
		$feature_info['number_of_free_day'] = $pcakgeinformation['number_of_free_day'];
		$feature_info['number_of_free_job'] = $pcakgeinformation['number_of_free_job'];
		$feature_info['number_of_booking'] = $pcakgeinformation['number_of_booking'];
		$feature_info['number_of_introduction_recived'] = $pcakgeinformation['number_of_introduction_recived'];
		$feature_info['number_of_photo'] = $pcakgeinformation['number_of_photo'];
		$feature_info['number_job_application_month'] = $pcakgeinformation['number_job_application'];
		$feature_info['number_job_application_daily'] = $pcakgeinformation['number_of_application_day'];
		$feature_info['number_of_quote_daily'] = $pcakgeinformation['number_of_quote_daily'];
		$feature_info['ask_for_quote_request_per_job'] = $pcakgeinformation['ask_for_quote_request_per_job'];
		$feature_info['number_job_application_daily'] = $pcakgeinformation['number_of_application_day'];



		$daysofprofile = $pcakgeinformation['validity_days'];

		$this->loadModel('Subscription');
		$subscription = $this->Subscription->get($sub_id);
		$subscription_info['package_id'] = PROFILE_PACKAGE;
		$subscription_info['user_id'] =  $user_id;
		$subscription_info['package_type'] = "PR";
		$subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofprofile . " days"));
		$subscription_info['subscription_date'] = date('Y-m-d H:i:s a');

		$subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
		$savedata = $this->Subscription->save($subscription_arr);



		// Non Telent data
		$this->loadModel('Settings');
		$pcakgeinformation = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();
		$feature_info['non_telent_number_of_audio'] = $pcakgeinformation['non_telent_number_of_audio'];
		$feature_info['non_telent_number_of_video'] = $pcakgeinformation['non_telent_number_of_video'];
		$feature_info['non_telent_number_of_album'] = $pcakgeinformation['non_telent_number_of_album'];
		$feature_info['non_telent_number_of_folder'] = $pcakgeinformation['non_telent_number_of_folder'];
		$feature_info['non_telent_number_of_jobalerts'] = $pcakgeinformation['non_telent_number_of_jobalerts'];
		$feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging'];
		$feature_info['non_telent_number_of_search_profile'] = $pcakgeinformation['non_telent_number_of_search_profile'];
		$feature_info['non_telent_number_of_private_message'] = $pcakgeinformation['non_telent_number_of_private_message'];
		$feature_info['non_telent_ask_quote'] = $pcakgeinformation['non_telent_ask_quote'];
		$feature_info['non_telent_number_of_job_post'] = $pcakgeinformation['non_telent_number_of_job_post'];
		$daysofnontalent = $pcakgeinformation['non_talent_validity_days'];
		$feature_info['non_telent_expire'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofnontalent . " days"));
		$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
		$packfeature_id = $packfeature['id'];
		$packfeature = $this->Packfeature->get($packfeature_id);

		$packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
		$this->Packfeature->save($packfeatures);
		return true;
	}


	public function assigndefaultrecpack($user_id, $sub_id)
	{


		// RecuriterPack data
		$this->loadModel('RecuriterPack');
		$this->loadModel('Packfeature');

		$pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y', 'RecuriterPack.id' => RECUITER_PACKAGE])->order(['RecuriterPack.id' => 'DESC'])->first();
		$feature_info['number_of_job_post'] = $pcakgeinformation['number_of_job_post'];
		$feature_info['number_of_job_simultancney'] = $pcakgeinformation['number_of_job_simultancney'];
		$feature_info['nubmer_of_site'] = $pcakgeinformation['nubmer_of_site'];
		$feature_info['number_of_message'] = $pcakgeinformation['number_of_message'];
		$feature_info['number_of_contact_details'] = $pcakgeinformation['number_of_contact_details'];
		$feature_info['number_of_talent_search'] = $pcakgeinformation['number_of_talent_search'];
		$feature_info['lengthofpackage'] = $pcakgeinformation['lengthofpackage'];
		$feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging'];
		$feature_info['number_of_email'] = $pcakgeinformation['number_of_email'];
		$feature_info['multipal_email_login'] = $pcakgeinformation['multipal_email_login'];
		$daysofrecur = $pcakgeinformation['validity_days'];
		$daysofprofile = $pcakgeinformation['validity_days'];
		$subscription = $this->Subscription->get($sub_id);
		$subscription_info['package_id'] = RECUITER_PACKAGE;
		$subscription_info['user_id'] =  $user_id;
		$subscription_info['package_type'] = "RC";
		$subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofprofile . " days"));
		$subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
		$subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
		$savedata = $this->Subscription->save($subscription_arr);
		$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
		$packfeature_id = $packfeature['id'];
		$packfeature = $this->Packfeature->get($packfeature_id);

		$packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
		$this->Packfeature->save($packfeatures);
		return true;
	}


	// rupam singh 
	public function jobalertscheckv1()
	{
		// Load required models
		$this->loadModel('Profile');
		$this->loadModel('Requirement');
		$this->loadModel('Skillset');
		$this->loadModel('Packfeature');
		$this->loadModel('Subscription');
		$this->loadModel('Skill');
		$this->loadModel('Users');
		$this->loadModel('RequirmentVacancy');

		// Get user ID from session
		$user_id = $this->request->session()->read('Auth.User.id');
		$userdetail = $this->Profile->find('all')->where(['Profile.user_id' => $user_id])->first();
		// Fetch skillset data for the user
		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $user_id])->order(['Skillset.id' => 'DESC'])->toArray();

		// Prepare skills as a comma-separated string
		$skill_array = [];
		foreach ($contentadminskillset as $skillvalue) {
			$skill_array[] = $skillvalue['skill_id'];
		}
		$skills = implode(",", $skill_array);

		// Get user location and other details
		$cur_lat = $userdetail['current_lat'];
		$cur_lng = $userdetail['current_long'];
		$lat = $userdetail['lat'];
		$lng = $userdetail['longs'];
		$gender = $userdetail['gender'];
		$country = $userdetail['country_ids'];
		$state = $userdetail['state_id'];
		$city = $userdetail['city_id'];


		// Fetch the user subscription data
		$user_sub_data = $this->Subscription->find('all')
			->where(['Subscription.user_id' => $user_id, 'Subscription.package_type' => 'PR'])
			->order(['id' => 'DESC'])
			->first();

		// Fetch the pack feature data
		$packfeature = $this->Packfeature->find('all')
			->where([
				'user_id' => $user_id,
				'OR' => [
					['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
					['package_status' => 'default']
				]
			])
			->order(['id' => 'DESC'])
			->first();

		// Date range for the subscription
		$datestart = date_format($user_sub_data['subscription_date'], "Y-m-d");
		$dateend = date_format($user_sub_data['expiry_date'], "Y-m-d");

		// Prepare the date range for fetching job alerts
		$start = strtotime($datestart);
		$end = strtotime($dateend);
		$current = $start;
		$ret = [];
		while ($current < $end) {
			$next = date('Y-m-01', $current) . "+1 month";
			$current = strtotime($next);
			$next = explode("+", $next);
			$ret[] = $next[0];
		}
		// Loop through each month in the date range
		foreach ($ret as $value) {
			$selectedmonth = explode("-", $value);

			$conditions = [
				'YEAR(Requirement.last_date_app)' => $selectedmonth[0],
				'MONTH(Requirement.last_date_app)' => $selectedmonth[1],
				'Requirement.user_id !=' => $user_id,
				'Requirement.status =' => 'Y'
			];

			// Conditionally add country, state, and city conditions
			if (!empty($country)) {
				$conditions['Requirement.country_id'] = $country;
			}
			if ($state != 0) {
				$conditions['Requirement.state_id'] = $state;
			}
			if ($city != 0) {
				$conditions['Requirement.city_id'] = $city;
			}

			$query = $this->Requirement->find()
				// ->select(['Requirement.id','Requirement.image','Requirement.title','Requirement.location','Requirement.created','RequirementVacancy.sex'])
				->contain(['Users', 'RequirmentVacancy' => ['Skill']])
				->matching('RequirmentVacancy', function ($q) use ($skills, $gender) {
					$whereConditions = [];
					if (!empty($gender)) {
						if ($gender == 'm') {
							$whereConditions['RequirmentVacancy.sex IN'] = ['m', 'a', 'bmf'];
						} elseif ($gender == 'f') {
							$whereConditions['RequirmentVacancy.sex IN'] = ['f', 'a', 'bmf'];
						} elseif ($gender == 'bmf') {
							$whereConditions['RequirmentVacancy.sex IN'] = ['m', 'f', 'a', 'bmf'];
						} elseif ($gender == 'o') {
							$whereConditions['RequirmentVacancy.sex'] = 'o';
						}
					}

					// Handle skills condition
					if (!empty($skills)) {
						$whereConditions['RequirmentVacancy.telent_type IN'] = explode(',', $skills);
					}

					// Apply the conditional WHERE clauses
					if (!empty($whereConditions)) {
						return $q->where($whereConditions);
					}

					// If no gender or skills, no need to add additional conditions
					return $q;
				})
				->where($conditions)
				->group('Requirement.id')
				->order(['Requirement.id' => 'DESC'])
				->limit($packfeature['number_of_jobs_alerts'])
				->toArray();

			foreach ($query as $key => $dataValue) {
				// Setting data from Requirement
				$data[$key]['id'] = $dataValue['id'];
				$data[$key]['req_id'] = $dataValue['id'];
				$data[$key]['postedby'] = $dataValue['user']['user_name'];
				$data[$key]['telent_type'] = $dataValue['telent_type'];
				$data[$key]['skillname'] = $dataValue['telent_type'];
				$data[$key]['name'] = $dataValue['telent_type'];
				$data[$key]['image'] = $dataValue['image'];
				$data[$key]['title'] = $dataValue['title'];
				$data[$key]['location'] = $dataValue['location'];
				$data[$key]['created'] = date('Y-m-d H:i:s', strtotime($dataValue['created']));

				if (!empty($dataValue['requirment_vacancy']) && is_array($dataValue['requirment_vacancy'])) {
					$sexArray = [];
					foreach ($dataValue['requirment_vacancy'] as $vacancy) {
						if (isset($vacancy['sex'])) {
							$sexArray[] = $vacancy['sex'];
						}
					}
					$data[$key]['sex'] = implode(',', $sexArray);
				} else {
					$data[$key]['sex'] = '';
				}
			}


			// here get all Requirement.id 
			$requirementIds = array_column($query, 'id');
			$job_ids_fetch_alert = implode(",", $requirementIds);
			// pr($job_ids_fetch_alert);exit;
			return $requirementIds;
		}

		// Return the job IDs as a comma-separated string
	}
}
