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

class MyalertsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		//$this->loadComponent('Flash');  Include the FlashComponent
	}


	public function alertsjob()
	{
		$this->autoRender = false;

		$jobapplicationdata = array();
		$jobquotesdata = array();
		$jobalertsdata = array();
		$jobsearchdata = array();
		$profilesearch = array();

		if ($_SESSION['jobapplicationdata']) {
			$jobapplicationdata = $_SESSION['jobapplicationdata'];
		}

		if ($_SESSION['jobquotesdata']) {
			$jobquotesdata = $_SESSION['jobquotesdata'];
		}

		if ($_SESSION['jobalertsdata']) {
			$jobalertsdata = $_SESSION['jobalertsdata'];
		}
		if ($_SESSION['jobsearchdata']) {
			$jobsearchdata = $_SESSION['jobsearchdata'];
		}

		if ($_SESSION['profilesearch']) {
			$profilesearch = $_SESSION['profilesearch'];
		}



		$session = $this->request->session();
		$response = array();
		$removealertsid = $this->request->data['job'];
		$jobaction  = $this->request->data['action'];
		if ($jobaction == 'jobapplication') {
			if (in_array($this->request->data['job'], $jobapplicationdata)) {
				//$removealertsid= $this->request->data['data'];
			} else {
				array_push($jobapplicationdata, $this->request->data['job']);
				$arraywrite = $session->write('jobapplicationdata', $jobapplicationdata);
			}
		} elseif ($jobaction == 'jobquote') {
			if (in_array($this->request->data['job'], $jobquotesdata)) {
				//$removealertsid= $this->request->data['data'];
			} else {
				array_push($jobquotesdata, $this->request->data['job']);
				$arraywrite = $session->write('jobquotesdata', $jobquotesdata);
			}
		} elseif ($jobaction == 'jobalerts') {
			if (in_array($this->request->data['job'], $jobalertsdata)) {
				//$removealertsid= $this->request->data['data'];
			} else {
				array_push($jobalertsdata, $this->request->data['job']);
				$arraywrite = $session->write('jobalertsdata', $jobalertsdata);
			}
		} elseif ($jobaction == 'search') {


			if (in_array($this->request->data['jobsearch'], $jobsearchdata)) {
				//$removealertsid= $this->request->data['data'];
			} else {
				//$jobsearchdata[]=$this->request->data['jobsearch'];
				array_push($jobsearchdata, $this->request->data['jobsearch']);

				$arraywrite = $session->write('jobsearchdata', $jobsearchdata);
			}
		} elseif ($jobaction == 'prosearch') {


			if (in_array($this->request->data['job'], $profilesearch)) {
			} else {
				//$jobsearchdata[]=$this->request->data['jobsearch'];
				array_push($profilesearch, $this->request->data['job']);

				$arraywrite = $session->write('profilesearch', $profilesearch);
			}
		}
		//	$session->write('job_id', $job_id);
	}

	public function jobalertscheck()
	{

		// $this->autoRender = false;
		$this->loadModel('Profile');
		$this->loadModel('Requirement');
		$this->loadModel('Skillset');
		$this->loadModel('Packfeature');
		$user_id = $this->request->session()->read('Auth.User.id');
		$userdetail = $this->Profile->find('all')->where(['Profile.user_id' => $user_id])->first();
		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $user_id])->order(['Skillset.id' => 'DESC'])->toarray();

		foreach ($contentadminskillset as $skillkey => $skillvalue) {
			$skill_array[] = $skillvalue['skill_id'];
		}
		$skills = implode(",", $skill_array);
		// pr($skills);exit;

		$cur_lat = $userdetail['current_lat'];
		$cur_lng = $userdetail['current_long'];
		$lat = $userdetail['lat'];
		$lng = $userdetail['longs'];
		$gender = $userdetail['gender'];
		$country = $userdetail['country_ids'];
		$state = $userdetail['state_id'];
		$city = $userdetail['city_id'];
		$currentdate = date("Y-m-d H:m:s");

		$this->loadModel('Subscription');
		$this->loadModel('Requirement');
		$user_sub_data = $this->Subscription->find('all')
			->where(['Subscription.user_id' => $user_id, 'Subscription.package_type' => 'PR'])
			->order(['id' => 'DESC'])
			->first();
		// pr($user_sub_data);

		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();

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


		$datestart =  date_format($user_sub_data['subscription_date'], "Y-m-d");
		$dateend =  date_format($user_sub_data['expiry_date'], "Y-m-d");

		$start = strtotime($datestart);
		$end = strtotime($dateend);
		$current = $start;
		$ret = array();
		while ($current < $end) {
			$next = date('Y-m-01', $current) . "+1 month";
			$current = strtotime($next);
			$next = explode("+", $next);
			$ret[] = $next[0];
		}
		//pr($_SESSION['jobalertsdata']);
		foreach ($ret as $value) {
			$selectedmonth =  explode("-", $value);
			$requirementfeatured = "SELECT group_concat(`Skills`.`name`) as skillname, 1.609344 * 6371 * acos( cos( radians('" . $cur_lat . "') ) * cos( radians(Requirement.latitude) ) * cos( radians(Requirement.longitude) - radians('" . $cur_lng . "') ) + sin( radians('" . $cur_lat . "') ) * sin( radians(Requirement.latitude) ) ) AS cdistance,1.609344 * 6371 * acos( cos( radians('" . $lat . "') ) * cos( radians(Requirement.latitude) ) * cos( radians(Requirement.longitude) - radians('" . $lng . "') ) + sin( radians('" . $lat . "') ) * sin( radians(Requirement.latitude) ) ) AS fdistance, Skills.name,Requirement.image ,RequirementVacancy.telent_type,RequirementVacancy.sex,RequirementVacancy.id as req_id, Requirement.id, Requirement.title, Requirement.location, Requirement.created FROM requirement Requirement  LEFT JOIN requirement_vacancy AS RequirementVacancy ON RequirementVacancy.requirement_id = Requirement.id LEFT JOIN skill_type AS Skills ON Skills.id = RequirementVacancy.telent_type WHERE  (YEAR(Requirement.last_date_app) = '" . $selectedmonth[0] . "'AND Month(Requirement.last_date_app) = '" . $selectedmonth[1] . "') AND Requirement.country_id = " . $country . " AND Requirement.state_id = " . $state . " AND Requirement.city_id = " . $city . " AND RequirementVacancy.sex='" . $gender . "' AND  Requirement.user_id NOT IN (" . $user_id . ") AND RequirementVacancy.telent_type IN (" . $skills . ")   GROUP BY Requirement.id  having fdistance < " . SEARCH_DISTANCE . "  and cdistance < " . SEARCH_DISTANCE . " ORDER BY Requirement.id DESC LIMIT " . $packfeature['number_of_jobs_alerts'] . "";
			// pr($requirementfeatured);die;
			$data_mont =  $selectedmonth[1];
			$conn = ConnectionManager::get('default');
			$alljobalerts = $conn->execute($requirementfeatured);
			$viewjobalerts[$data_mont] = $alljobalerts->fetchAll('assoc');
		}

		foreach ($viewjobalerts as $ne_val) {
			foreach ($ne_val as $last_job_id) {
				$res_job[] = $last_job_id['id'];
			}
		}
		$job_ids_fetch_alert = implode(",", $res_job);
		return ($job_ids_fetch_alert);
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
		$this->loadModel('Eventtype');

		// Get user ID from session
		$user_id = $this->request->session()->read('Auth.User.id');

		// Fetch user details
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
				->contain(['Users', 'Eventtype', 'RequirmentVacancy' => ['Skill']])
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
				// pr($dataValue);exit;
				// Setting data from Requirement
				$data[$key]['id'] = $dataValue['id'];
				$data[$key]['req_id'] = $dataValue['id'];
				$data[$key]['postedby'] = $dataValue['user']['user_name'];
				$data[$key]['user_id'] = $dataValue['user_id'];
				$data[$key]['telent_type'] = $dataValue['telent_type'];
				$data[$key]['skillname'] = $dataValue['telent_type'];
				$data[$key]['event_type'] = $dataValue['eventtype']['name'];
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
			$requirementIds = array_column($data, 'id');
			$job_ids_fetch_alert = implode(",", $requirementIds);
			// pr($job_ids_fetch_alert);exit;
			return $data;
		}

		// Return the job IDs as a comma-separated string
	}

	// Rupam
	public function index()
	{
		$this->loadModel('Savejobs');
		$this->loadModel('Likejobs');
		$this->loadModel('Blockjobs');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Requirement');
		$this->loadModel('JobApplication');
		$this->loadModel('Skillset');
		$this->loadModel('JobQuote');
		$this->loadModel('JobAlert');
		$this->loadModel('RequirmentVacancy');

		$uid = $this->request->session()->read('Auth.User.id');
		$role_id = $this->request->session()->read('Auth.User.role_id');
		$currentdate = date('Y-m-d H:m:s');

		$Savejobsdata = $this->Savejobs->find('all')->where(['Savejobs.user_id' => $uid])->order(['Savejobs.id' => 'ASC'])->toarray();
		$Blockjobsdata = $this->Blockjobs->find('all')->where(['Blockjobs.user_id' => $uid])->order(['Blockjobs.id' => 'ASC'])->toarray();
		$likejobsdata = $this->Likejobs->find('all')->where(['Likejobs.user_id' => $uid])->order(['Likejobs.id' => 'ASC'])->toarray();

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

		$requirementfeatured = $this->Requirement->find('list')->where(['Requirement.last_date_app <' => $currentdate, 'Requirement.user_id' => $uid, 'Requirement.status' => 'Y'])->order(['Requirement.id' => 'DESC'])->toarray();
		foreach ($requirementfeatured as $jobkey => $value) {
			$job_array[] = $jobkey;
		}

		// pr($uid);exit;

		//Wrong code

		// $details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill']])->toarray();
		// foreach ($details as $reqjob) {
		// 	foreach ($reqjob['requirment_vacancy']  as $detailreq) { //pr($detailreq);
		// 		// echo $detailreq['skill']['id'];
		// 	}
		// }

		/*
				if($_SESSION['jobalertsdata']){
				$jobalerts = $this->JobAlert->find('all')->contain(['Requirement'=>['RequirmentVacancy'=>['Skill','Currency']]])->where(['JobAlert.user_id' =>$uid,'JobAlert.id NOT IN'=>$_SESSION['jobalertsdata']])->toarray();
			$this->set('jobalerts',$jobalerts);
					}else{
				$jobalerts = $this->JobAlert->find('all')->contain(['Requirement'=>['RequirmentVacancy'=>['Skill','Currency']]])->where(['JobAlert.user_id' =>$uid])->toarray();
			$this->set('jobalerts',$jobalerts);
						//pr($bookingreceived);
					}
				*/
		//LEFT JOIN `cms_job_items` AS `JobItem` ON (`JobItem`.`id` = `JobRole`.`jobitem_id`)

		$userdetail = $this->Profile->find('all')->where(['Profile.user_id' => $uid])->first();
		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $uid])->order(['Skillset.id' => 'DESC'])->toarray();

		foreach ($contentadminskillset as $skillkey => $skillvalue) {
			$skill_array[] = $skillvalue['skill_id'];
		}
		$skills = implode(",", $skill_array);

		// pr($contentadminskillset);exit;

		$this->loadModel('Packfeature');


		$cur_lat = $userdetail['current_lat'];
		$cur_lng = $userdetail['current_long'];
		$lat = $userdetail['lat'];
		$lng = $userdetail['longs'];
		$gender = $userdetail['gender'];
		$country = $userdetail['country_ids'];
		$state = $userdetail['state_id'];
		$city = $userdetail['city_id'];
		$currentdate = date("Y-m-d H:m:s");

		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $uid])->order(['Packfeature.id' => 'ASC'])->first();

		$packfeature = $this->Packfeature->find('all')
			->where([
				'user_id' => $uid,
				'OR' => [
					['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
					['package_status' => 'default']
				]
			])
			->order(['id' => 'DESC'])
			->first();

		// pr($packfeature);
		// exit;
		$this->set('month', $packfeature['number_job_application_month']);
		$this->set('daily', $packfeature['number_job_application_daily']);
		$this->set('quote', $packfeature['number_of_quote_daily']);
		$job_ids = 	$this->jobalertscheckv1();

		// $conn = ConnectionManager::get('default');
		// // pr($job_ids);die;
		// $jobalert = "SELECT GROUP_CONCAT(Skills.name) AS skillname,Skills.name,Requirement.image,RequirementVacancy.telent_type,RequirementVacancy.sex,RequirementVacancy.id AS req_id,Requirement.id,Requirement.title,Requirement.location,Requirement.created FROM requirement Requirement LEFT JOIN requirement_vacancy AS RequirementVacancy ON RequirementVacancy.requirement_id = Requirement.id LEFT JOIN skill_type AS Skills ON Skills.id = RequirementVacancy.telent_type WHERE Requirement.id IN ($job_ids) GROUP BY Requirement.id ORDER BY Requirement.id DESC LIMIT $packfeature[number_of_jobs_alerts]";

		// $alljobalerts = $conn->execute($jobalert);
		// $viewjobalerts = $alljobalerts->fetchAll('assoc');
		// pr($job_ids);
		// die;
		// exit;
		$this->set('viewjobalerts', $job_ids);

		//bookingreceived 
		if ($_SESSION['jobapplicationdata']) {
			$bookingreceived = $this->JobApplication->find('all')
				->contain(['Skill', 'Requirement' => ['RequirmentVacancy' => ['Skill', 'Currency']]])
				->where(['JobApplication.user_id' => $uid, 'JobApplication.nontalent_aacepted_status' => 'Y', 'JobApplication.ping' => 0, 'JobApplication.id NOT IN' => $_SESSION['jobapplicationdata'], 'JobApplication.talent_accepted_status' => 'N', 'Requirement.last_date_app >=' => $currentdate])
				->toarray();
			$this->set('bookingreceived', $bookingreceived);
		} else {
			$bookingreceived = $this->JobApplication->find('all')->contain(['Skill', 'Requirement' => ['RequirmentVacancy' => ['Skill', 'Currency']]])->where(['JobApplication.user_id' => $uid, 'JobApplication.nontalent_aacepted_status' => 'Y', 'JobApplication.ping' => 0, 'JobApplication.talent_accepted_status' => 'N', 'Requirement.status' => 'Y', 'Requirement.last_date_app >=' => $currentdate])->toarray();
			$this->set('bookingreceived', $bookingreceived);
		}
		// pr($bookingreceived);die;

		//quotereceive
		if ($_SESSION['jobquotesdata']) {
			$quotereceive = $this->JobQuote->find('all')->contain(['Skill', 'Requirement' => ['RequirmentVacancy' => ['Skill', 'Currency'], 'Users']])->where(['JobQuote.user_id' => $uid, 'JobQuote.amt >' => 0, 'JobQuote.revision >' => 0, 'JobQuote.status' => 'N', 'JobQuote.id NOT IN' => $_SESSION['jobquotesdata'], 'Requirement.status' => 'Y', 'Requirement.last_date_app >=' => $currentdate])->toarray();
			$this->set('quotereceive', $quotereceive);
		} else {
			$quotereceive = $this->JobQuote->find('all')
				->contain(['Skill', 'Requirement' => ['RequirmentVacancy' => ['Skill', 'Currency'], 'Users']])
				->where([
					'JobQuote.user_id' => $uid,
					'JobQuote.amt >' => 0,
					'JobQuote.revision >' => 0,
					'JobQuote.status' => 'N',
					'Requirement.status' => 'Y',
					'Requirement.last_date_app >=' => $currentdate
				])
				->toarray();
			// pr($quotereceive);
			// exit;
			$this->set('quotereceive', $quotereceive);
		}


		if ($_SESSION['jobquotesdata']) {
			$quoteapplicationalerts = $this->JobQuote->find('all')
				->contain(['Skill', 'Requirement' => ['RequirmentVacancy' => ['Skill', 'Currency']]])
				->where([
					'JobQuote.user_id' => $uid,
					'JobQuote.id NOT IN' => $_SESSION['jobquotesdata'],
					'JobQuote.amt' => 0,
					'Requirement.status' => 'Y',
					'Requirement.last_date_app >=' => $currentdate
				])
				->order(['JobQuote.id' => 'DESC'])
				->toarray();
			$this->set('quoteapplicationalerts', $quoteapplicationalerts);
		} else {

			$quoteapplicationalerts = $this->JobQuote->find('all')
				->contain(['Skill', 'Requirement' => ['RequirmentVacancy' => ['Skill', 'Currency']]])
				->where([
					'JobQuote.user_id' => $uid,
					'JobQuote.amt' => 0,
					'Requirement.status' => 'Y',
					'Requirement.last_date_app >=' => $currentdate
				])
				->order(['JobQuote.id' => 'DESC'])
				->toarray();
			// pr($quoteapplicationalerts);
			// exit;
			$this->set('quoteapplicationalerts', $quoteapplicationalerts);
		}
		// pr(count($quoteapplicationalerts));exit;


		// ping sent

		if ($_SESSION['jobapplicationdata']) {
			$pingsent =	$this->JobApplication->find('all')->contain(['Requirement'])->where(['JobApplication.user_id IN' => $uid, 'JobApplication.nontalent_aacepted_status' => 'N', 'JobApplication.id NOT IN' => $_SESSION['jobapplicationdata'], 'JobApplication.ping' => 1])->order(['JobApplication.id' => 'DESC'])->toarray();
			$this->set('pingsent', $pingsent);
		} else {
			$pingsent =	$this->JobApplication->find('all')->contain(['Requirement'])->where(['JobApplication.user_id IN' => $uid, 'JobApplication.nontalent_aacepted_status' => 'N', 'JobApplication.ping' => 1])->order(['JobApplication.id' => 'DESC'])->toarray();
			$this->set('pingsent', $pingsent);
		}
	}


	public function indexv()
	{
		$this->loadModel('Savejobs');
		$this->loadModel('Likejobs');
		$this->loadModel('Blockjobs');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Requirement');
		$this->loadModel('JobApplication');
		$this->loadModel('Skillset');
		$this->loadModel('JobQuote');
		$this->loadModel('JobAlert');
		$this->loadModel('RequirmentVacancy');
		$quotes = '';
		$applications = '';
		$uid = $this->request->session()->read('Auth.User.id');
		$role_id = $this->request->session()->read('Auth.User.role_id');
		$currentdate = date('Y-m-d H:m:s');

		$Savejobsdata = $this->Savejobs->find('all')->where(['Savejobs.user_id' => $uid])->order(['Savejobs.id' => 'ASC'])->toarray();
		$Blockjobsdata = $this->Blockjobs->find('all')->where(['Blockjobs.user_id' => $uid])->order(['Blockjobs.id' => 'ASC'])->toarray();
		$likejobsdata = $this->Likejobs->find('all')->where(['Likejobs.user_id' => $uid])->order(['Likejobs.id' => 'ASC'])->toarray();

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

		$requirementfeatured = $this->Requirement->find('list')->where(['Requirement.last_date_app <' => $currentdate, 'Requirement.user_id' => $uid, 'Requirement.status' => 'Y'])->order(['Requirement.id' => 'DESC'])->toarray();
		foreach ($requirementfeatured as $jobkey => $value) {
			$job_array[] = $jobkey;
		}

		// pr($uid);exit;

		//Wrong code

		// $details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill']])->toarray();
		// foreach ($details as $reqjob) {
		// 	foreach ($reqjob['requirment_vacancy']  as $detailreq) { //pr($detailreq);
		// 		// echo $detailreq['skill']['id'];
		// 	}
		// }

		/*
			if($_SESSION['jobalertsdata']){
			$jobalerts = $this->JobAlert->find('all')->contain(['Requirement'=>['RequirmentVacancy'=>['Skill','Currency']]])->where(['JobAlert.user_id' =>$uid,'JobAlert.id NOT IN'=>$_SESSION['jobalertsdata']])->toarray();
		$this->set('jobalerts',$jobalerts);
				}else{
			$jobalerts = $this->JobAlert->find('all')->contain(['Requirement'=>['RequirmentVacancy'=>['Skill','Currency']]])->where(['JobAlert.user_id' =>$uid])->toarray();
		$this->set('jobalerts',$jobalerts);
					//pr($bookingreceived);
				}
			*/
		//LEFT JOIN `cms_job_items` AS `JobItem` ON (`JobItem`.`id` = `JobRole`.`jobitem_id`)

		$userdetail = $this->Profile->find('all')->where(['Profile.user_id' => $uid])->first();
		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $uid])->order(['Skillset.id' => 'DESC'])->toarray();

		foreach ($contentadminskillset as $skillkey => $skillvalue) {
			$skill_array[] = $skillvalue['skill_id'];
		}
		$skills = implode(",", $skill_array);

		// pr($contentadminskillset);exit;

		$this->loadModel('Packfeature');


		$cur_lat = $userdetail['current_lat'];
		$cur_lng = $userdetail['current_long'];
		$lat = $userdetail['lat'];
		$lng = $userdetail['longs'];
		$gender = $userdetail['gender'];
		$country = $userdetail['country_ids'];
		$state = $userdetail['state_id'];
		$city = $userdetail['city_id'];
		$currentdate = date("Y-m-d H:m:s");

		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $uid])->order(['Packfeature.id' => 'ASC'])->first();

		$packfeature = $this->Packfeature->find('all')
			->where([
				'user_id' => $uid,
				'OR' => [
					['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
					['package_status' => 'default']
				]
			])
			->order(['id' => 'DESC'])
			->first();

		// pr($packfeature);
		// exit;
		$this->set('month', $packfeature['number_job_application_month']);
		$this->set('daily', $packfeature['number_job_application_daily']);
		$this->set('quote', $packfeature['number_of_quote_daily']);
		$job_ids = 	$this->jobalertscheckv1();

		$conn = ConnectionManager::get('default');
		// pr($_SESSION);die;
		if ($_SESSION['jobalertsdata']) {

			$jobalertsids = implode(",", $_SESSION['jobalertsdata']);
			$jobalert = "
					SELECT 
						GROUP_CONCAT(Skills.name) AS skillname,
						1.609344 * 6371 * ACOS(
							COS(RADIANS('$cur_lat')) * COS(RADIANS(Requirement.latitude)) 
							* COS(RADIANS(Requirement.longitude) - RADIANS('$cur_lng')) 
							+ SIN(RADIANS('$cur_lat')) * SIN(RADIANS(Requirement.latitude))
						) AS cdistance,
						1.609344 * 6371 * ACOS(
							COS(RADIANS('$lat')) * COS(RADIANS(Requirement.latitude)) 
							* COS(RADIANS(Requirement.longitude) - RADIANS('$lng')) 
							+ SIN(RADIANS('$lat')) * SIN(RADIANS(Requirement.latitude))
						) AS fdistance,
						Skills.name,
						Requirement.image,
						RequirementVacancy.telent_type,
						RequirementVacancy.sex,
						RequirementVacancy.id AS req_id,
						Requirement.id,
						Requirement.title,
						Requirement.location,
						Requirement.created,
						Users.user_name as postedby
					FROM 
						requirement Requirement
					LEFT JOIN 
						requirement_vacancy RequirementVacancy ON RequirementVacancy.requirement_id = Requirement.id
					LEFT JOIN 
						skill_type Skills ON Skills.id = RequirementVacancy.telent_type
					LEFT JOIN 
						users Users ON Users.id = Requirement.user_id
					WHERE 
						Requirement.id IN ($job_ids)
						AND Requirement.id NOT IN ($jobalertsids)
					ORDER BY 
						Requirement.id DESC;
				";

			$alljobalerts = $conn->execute($jobalert);
			$viewjobalerts = $alljobalerts->fetchAll('assoc');
		} else {

			if (!empty($job_ids)) {
				$jobalert = "
					SELECT 
						GROUP_CONCAT(Skills.name) AS skillname,
						1.609344 * 6371 * ACOS(
							COS(RADIANS('$cur_lat')) * COS(RADIANS(Requirement.latitude)) 
							* COS(RADIANS(Requirement.longitude) - RADIANS('$cur_lng')) 
							+ SIN(RADIANS('$cur_lat')) * SIN(RADIANS(Requirement.latitude))
						) AS cdistance,
						1.609344 * 6371 * ACOS(
							COS(RADIANS('$lat')) * COS(RADIANS(Requirement.latitude)) 
							* COS(RADIANS(Requirement.longitude) - RADIANS('$lng')) 
							+ SIN(RADIANS('$lat')) * SIN(RADIANS(Requirement.latitude))
						) AS fdistance,
						Skills.name,
						Requirement.image,
						RequirementVacancy.telent_type,
						RequirementVacancy.sex,
						RequirementVacancy.id AS req_id,
						Requirement.id,
						Requirement.title,
						Requirement.location,
						Requirement.created,
						Requirement.user_id,
						Users.user_name as postedby
					FROM 
						requirement Requirement
					LEFT JOIN 
						requirement_vacancy RequirementVacancy ON RequirementVacancy.requirement_id = Requirement.id
					LEFT JOIN 
						skill_type Skills ON Skills.id = RequirementVacancy.telent_type
					LEFT JOIN 
						users Users ON Users.id = Requirement.user_id
					WHERE 
						Requirement.id IN ($job_ids)
						AND Requirement.country_id = $country
						AND Requirement.state_id = $state
						AND Requirement.city_id = $city
						AND Requirement.last_date_app >= '$currentdate'
						AND RequirementVacancy.telent_type IN ($skills)
					ORDER BY 
						Requirement.id DESC
				";
			} else {

				//	$jobalert= "SELECT group_concat(`Skills`.`name`) as skillname, 1.609344 * 6371 * acos( cos( radians('".$cur_lat."') ) * cos( radians(Requirement.latitude) ) * cos( radians(Requirement.longitude) - radians('".$cur_lng."') ) + sin( radians('".$cur_lat."') ) * sin( radians(Requirement.latitude) ) ) AS cdistance,1.609344 * 6371 * acos( cos( radians('".$lat."') ) * cos( radians(Requirement.latitude) ) * cos( radians(Requirement.longitude) - radians('".$lng."') ) + sin( radians('".$lat."') ) * sin( radians(Requirement.latitude) ) ) AS fdistance, Skills.name,Requirement.image ,RequirementVacancy.telent_type,RequirementVacancy.sex,RequirementVacancy.id as req_id, Requirement.id, Requirement.title, Requirement.location, Requirement.created FROM requirement Requirement  LEFT JOIN requirement_vacancy AS RequirementVacancy ON RequirementVacancy.requirement_id = Requirement.id LEFT JOIN skill_type AS Skills ON Skills.id = RequirementVacancy.telent_type WHERE  Requirement.id NOT IN (".$jobalertsids.")  ORDER BY Requirement.id DESC  LIMIT"; 

				// Optimize by Rupam 7/12/2023 with location based
				$jobalert = "
					SELECT 
						GROUP_CONCAT(Skills.name) AS skillname,
						1.609344 * 6371 * ACOS(
							COS(RADIANS('$cur_lat')) * COS(RADIANS(Requirement.latitude)) 
							* COS(RADIANS(Requirement.longitude) - RADIANS('$cur_lng')) 
							+ SIN(RADIANS('$cur_lat')) * SIN(RADIANS(Requirement.latitude))
						) AS cdistance,
						1.609344 * 6371 * ACOS(
							COS(RADIANS('$lat')) * COS(RADIANS(Requirement.latitude)) 
							* COS(RADIANS(Requirement.longitude) - RADIANS('$lng')) 
							+ SIN(RADIANS('$lat')) * SIN(RADIANS(Requirement.latitude))
						) AS fdistance,
						Skills.name,
						Requirement.image,
						RequirementVacancy.telent_type,
						RequirementVacancy.sex,
						RequirementVacancy.id AS req_id,
						Requirement.id,
						Requirement.title,
						Requirement.location,
						Requirement.created,
						Requirement.user_id,
						Users.user_name as postedby
					FROM 
						requirement Requirement
					LEFT JOIN 
						requirement_vacancy RequirementVacancy ON RequirementVacancy.requirement_id = Requirement.id
					LEFT JOIN 
						skill_type Skills ON Skills.id = RequirementVacancy.telent_type
					LEFT JOIN 
						users Users ON Users.id = Requirement.user_id
					WHERE 
						Requirement.country_id = $country
						AND Requirement.state_id = $state
						AND Requirement.city_id = $city
						AND Requirement.last_date_app >= '$currentdate'
						AND RequirementVacancy.sex IN ('$gender', 'a')
						AND Requirement.user_id NOT IN ($uid)
						AND RequirementVacancy.telent_type IN ($skills)
						AND Requirement.last_date_app >= '$currentdate'
					GROUP BY 
						Requirement.id
					HAVING 
						fdistance < " . SEARCH_DISTANCE . " 
						AND cdistance < " . SEARCH_DISTANCE . "
					ORDER BY 
						Requirement.id DESC
					LIMIT 
						" . $packfeature['number_of_jobs_alerts'] . ";
				";
			}

			// pr($jobalert);exit;


			// Optimize by Rupam 7/12/2023
			$jobalert = "
			SELECT
				GROUP_CONCAT(Skills.name) AS skillname,
				Skills.name,
				Requirement.image,
				RequirementVacancy.telent_type,
				RequirementVacancy.sex,
				RequirementVacancy.id AS req_id,
				Requirement.id,
				Requirement.title,
				Requirement.location,
				Requirement.created
			FROM
				requirement Requirement
				LEFT JOIN requirement_vacancy AS RequirementVacancy ON RequirementVacancy.requirement_id = Requirement.id
				LEFT JOIN skill_type AS Skills ON Skills.id = RequirementVacancy.telent_type
			WHERE
				Requirement.country_id = $country
				AND Requirement.state_id = $state
				AND Requirement.last_date_app >= '$currentdate'
				AND Requirement.city_id = $city
				AND RequirementVacancy.sex IN ('$gender', 'a')
				AND Requirement.user_id NOT IN ($uid)
				AND RequirementVacancy.telent_type IN ($skills)
			GROUP BY
				Requirement.id
			ORDER BY
				Requirement.id DESC
			LIMIT
			 $packfeature[number_of_jobs_alerts]";
		}

		// pr($jobalert);exit;


		$alljobalerts = $conn->execute($jobalert);
		$viewjobalerts = $alljobalerts->fetchAll('assoc');
		// pr($viewjobalerts);exit;
		$this->set('viewjobalerts', $viewjobalerts);

		//bookingreceived 
		if ($_SESSION['jobapplicationdata']) {
			$bookingreceived = $this->JobApplication->find('all')
				->contain(['Skill', 'Requirement' => ['RequirmentVacancy' => ['Skill', 'Currency']]])
				->where(['JobApplication.user_id' => $uid, 'JobApplication.nontalent_aacepted_status' => 'Y', 'JobApplication.ping' => 0, 'JobApplication.id NOT IN' => $_SESSION['jobapplicationdata'], 'JobApplication.talent_accepted_status' => 'N', 'Requirement.last_date_app >=' => $currentdate])
				->toarray();
			$this->set('bookingreceived', $bookingreceived);
		} else {
			$bookingreceived = $this->JobApplication->find('all')->contain(['Skill', 'Requirement' => ['RequirmentVacancy' => ['Skill', 'Currency']]])->where(['JobApplication.user_id' => $uid, 'JobApplication.nontalent_aacepted_status' => 'Y', 'JobApplication.ping' => 0, 'JobApplication.talent_accepted_status' => 'N', 'Requirement.status' => 'Y', 'Requirement.last_date_app >=' => $currentdate])->toarray();
			$this->set('bookingreceived', $bookingreceived);
		}
		// pr($bookingreceived);die;

		//quotereceive
		if ($_SESSION['jobquotesdata']) {
			$quotereceive = $this->JobQuote->find('all')->contain(['Skill', 'Requirement' => ['RequirmentVacancy' => ['Skill', 'Currency'], 'Users']])->where(['JobQuote.user_id' => $uid, 'JobQuote.amt >' => '0', 'JobQuote.revision >' => '0', 'JobQuote.status' => 'N', 'JobQuote.id NOT IN' => $_SESSION['jobquotesdata'], 'Requirement.status' => 'Y', 'Requirement.last_date_app >=' => $currentdate])->toarray();
			$this->set('quotereceive', $quotereceive);
		} else {
			$quotereceive = $this->JobQuote->find('all')->contain(['Skill', 'Requirement' => ['RequirmentVacancy' => ['Skill', 'Currency'], 'Users']])->where(['JobQuote.user_id' => $uid, 'JobQuote.amt >' => '0', 'JobQuote.revision >' => '0', 'JobQuote.status' => 'N', 'Requirement.status' => 'Y', 'Requirement.last_date_app >=' => $currentdate])->toarray();
			$this->set('quotereceive', $quotereceive);
			// pr($quoteapplicationalerts);exit;
		}


		if ($_SESSION['jobquotesdata']) {
			$quoteapplicationalerts = $this->JobQuote->find('all')->contain(['Skill', 'Requirement' => ['RequirmentVacancy' => ['Skill', 'Currency']]])->where(['JobQuote.user_id' => $uid, 'JobQuote.id NOT IN' => $_SESSION['jobquotesdata'], 'JobQuote.amt' => '0', 'Requirement.status' => 'Y', 'Requirement.last_date_app >=' => $currentdate])->order(['JobQuote.id' => 'DESC'])->toarray();
			$this->set('quoteapplicationalerts', $quoteapplicationalerts);
		} else {

			$quoteapplicationalerts = $this->JobQuote->find('all')->contain(['Skill', 'Requirement' => ['RequirmentVacancy' => ['Skill', 'Currency']]])->where(['JobQuote.user_id' => $uid, 'JobQuote.amt' => 0, 'Requirement.status' => 'Y', 'Requirement.last_date_app >=' => $currentdate])->order(['JobQuote.id' => 'DESC'])->toarray();
			$this->set('quoteapplicationalerts', $quoteapplicationalerts);
		}
		// pr(count($quoteapplicationalerts));exit;


		// ping sent

		if ($_SESSION['jobapplicationdata']) {
			$pingsent =	$this->JobApplication->find('all')->contain(['Requirement'])->where(['JobApplication.user_id IN' => $uid, 'JobApplication.nontalent_aacepted_status' => 'N', 'JobApplication.id NOT IN' => $_SESSION['jobapplicationdata'], 'JobApplication.ping' => 1])->order(['JobApplication.id' => 'DESC'])->toarray();
			$this->set('pingsent', $pingsent);
		} else {
			$pingsent =	$this->JobApplication->find('all')->contain(['Requirement'])->where(['JobApplication.user_id IN' => $uid, 'JobApplication.nontalent_aacepted_status' => 'N', 'JobApplication.ping' => 1])->order(['JobApplication.id' => 'DESC'])->toarray();
			$this->set('pingsent', $pingsent);
		}
	}
}
