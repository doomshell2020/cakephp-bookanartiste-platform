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
	public function initialize(array $config) {}

	public function sitesettings()
	{
		$articles = TableRegistry::get('Settings');
		return $articles->find('all')->order(['Settings.id' => 'DESC'])->first();
	}


	public function gettimetable($ttid, $weekday, $classectionid)
	{
		// Use the HTML helper to output
		// Formatted data:
		$articles = TableRegistry::get('ClasstimeTabs');
		// Start a new query.
		return $articles->find('all')->contain(['Employees', 'Subjects'])->where(['ClasstimeTabs.weekday' => $weekday, 'ClasstimeTabs.tt_id' => $ttid, 'ClasstimeTabs.class_id' => $classectionid])->toArray();
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

	public function getSkillname($skillid)
	{

		$articles = TableRegistry::get('Skill');
		// Start a new query.
		return $articles->find('all')->where(['Skill.id' => $skillid])->first();
	}

	public function getEventname($eventid)
	{

		$articles = TableRegistry::get('Eventtype');
		// Start a new query.
		return $articles->find('all')->where(['Eventtype.id' => $eventid])->first();
	}

	public function findfeesallocation($qua, $id)
	{
		// pr ($rout); die;
		// Use the HTML helper to output
		// Formatted data:
		$articles = TableRegistry::get('Studentfees');
		// Start a new query.
		return $articles->find('all')->where(['Studentfees.quarter' => $qua, 'Studentfees.student_id' => $id])->first()->toArray();
	}


	public function findtransportfeesallocation($qua, $id)
	{
		// pr ($rout); die;
		// Use the HTML helper to output
		// Formatted data:
		$articles = TableRegistry::get('StudentTransfees');
		// Start a new query.
		return $articles->find('all')->where(['StudentTransfees.quarter' => $qua, 'StudentTransfees.student_id' => $id])->first()->toArray();
	}


	public function skills()
	{
		$articles = TableRegistry::get('Skillset');
		$uid = $this->request->session()->read('Auth.User.id');
		return $articles->find('all')->where(['Skillset.user_id' => $uid])->first();
	}


	public function jobpostrequirement()
	{
		$articles = TableRegistry::get('Users');
		$uid = $this->request->session()->read('Auth.User.id');
		return $articles->find('all')->where(['Users.id' => $uid])->first();
	}



	public function contactrequestcount()
	{
		$articles = TableRegistry::get('Contactrequest');
		$uid = $this->request->session()->read('Auth.User.id');

		return $articles->find('all')->where(['viewedstatus' => 'N', 'to_id' => $uid])->count();
	}


	public function contactreqstatus($userid)
	{
		$articles = TableRegistry::get('Contactrequest');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$connect_status =  $articles->find('all')
			->where(['from_id' => $userid, 'to_id' => $current_user_id])
			->orWhere(['from_id' => $current_user_id, 'to_id' => $userid])
			->first();
		if (count($connect_status) > 0) {
			// if ($connect_status['deletestatus'] == 'Y') {
			// 	$status = 'RR';  // request rejected
			// }else 

			if ($connect_status['accepted_status'] == 'Y') {
				$status = 'C';  // connected
			} else {
				if ($connect_status['from_id'] == $current_user_id) {
					$status = 'S';  // request sent
				} else {
					$status = 'R';  // request received
				}
			}
		} else {
			$status = 'N';  // Not Connected
		}

		return $status;
	}


	public function applicationcount($job_id)
	{

		$articles = TableRegistry::get('JobApplication');
		return $articles->find('all')->contain(['Users' => ['Profile', 'Professinal_info']])->where(['JobApplication.job_id' => $job_id, 'JobApplication.nontalent_aacepted_status' => 'N', 'JobApplication.	talent_accepted_status' => 'Y', 'JobApplication.ping' => 0])->order(['JobApplication.id' => 'DESC'])->count();

		//return $articles ->find('all')->where(['job_id' =>])->count();
	}

	public function quote_requestcount($job_id)
	{

		$articles = TableRegistry::get('JobQuote');
		return $articles->find('all')->contain(['Users' => ['Profile', 'Professinal_info']])->where(['JobQuote.job_id' => $job_id, 'JobQuote.amt' => '0'])->order(['JobQuote.id' => 'DESC'])->count();
	}

	public function sel_receivecount($job_id)
	{
		$articles = TableRegistry::get('JobApplication');
		return $articles->find()
			// ->contain(['Users' => ['Profile', 'Professinal_info']])
			->contain(['Requirement', 'Skill', 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']])
			->select(['JobApplication.id'])
			->where([
				'JobApplication.job_id' => $job_id,
				'JobApplication.nontalent_aacepted_status' => 'Y',
				'JobApplication.talent_accepted_status' => 'Y'
			])
			->order(['JobApplication.id' => 'DESC'])
			->count();
	}

	public function booking_sentcount($job_id)
	{
		$articles = TableRegistry::get('JobApplication');
		return $articles->find('all')->contain(['Users' => ['Profile', 'Professinal_info']])->where(['JobApplication.job_id' => $job_id, 'JobApplication.nontalent_aacepted_status' => 'Y', 'JobApplication.ping' => 0, 'JobApplication.talent_accepted_status' => 'N'])->order(['JobApplication.id' => 'DESC'])->count();
	}

	public function quote_receivecount($job_id)
	{
		$articles = TableRegistry::get('JobQuote');
		return $articles->find('all')->contain(['Users' => ['Profile', 'Professinal_info']])->where(['JobQuote.job_id' => $job_id, 'JobQuote.amt >' => '0', 'JobQuote.revision' => '0', 'JobQuote.status' => 'N'])->order(['JobQuote.id' => 'DESC'])->count();
	}


	public function quote_revisedcount($job_id)
	{
		$articles = TableRegistry::get('JobQuote');
		return $articles->find('all')->contain(['Users' => ['Profile', 'Professinal_info']])->where(['JobQuote.job_id' => $job_id, 'JobQuote.amt >' => '0', 'JobQuote.revision >' => '0', 'JobQuote.status' => 'N'])->order(['JobQuote.id' => 'DESC'])->count();
	}

	public function reject_receivecount($job_id)
	{
		$articles = TableRegistry::get('JobApplication');
		// return $articles->find('all')->contain(['Users' => ['Profile', 'Professinal_info']])->where(['JobApplication.job_id' => $job_id, 'JobApplication.nontalent_aacepted_status' => 'R'])->orWhere(['JobApplication.talent_accepted_status' => 'R'])->order(['JobApplication.id' => 'DESC'])->count();
		return $articles->find()
			->contain(['Users' => ['Profile', 'Professinal_info']])
			->where([
				'JobApplication.job_id' => $job_id,
				'OR' => [
					['JobApplication.nontalent_aacepted_status' => 'R'],
					['JobApplication.talent_accepted_status' => 'R']
				]
			])
			->order(['JobApplication.id' => 'DESC'])
			->count();
	}

	public function ping_receivecount($job_id)
	{
		$articles = TableRegistry::get('JobApplication');
		return $articles->find('all')->contain(['Users' => ['Profile', 'Professinal_info']])->where(['JobApplication.job_id' => $job_id, 'JobApplication.nontalent_aacepted_status' => 'N', 'JobApplication.ping' => 1])->order(['JobApplication.id' => 'DESC'])->count();
	}

	public function profileheader()
	{
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$articles = TableRegistry::get('Profile');
		return $articles->find('all')->contain(['Users', 'Enthicity', 'City', 'Country'])->where(['user_id' => $current_user_id])->first();
	}


	public function packagedetails($type, $packageid)
	{
		$pcakgeinformation = '';
		if ($type == 'PR') {
			$pcakge = TableRegistry::get('Profilepack');
			$pcakgeinformation = $pcakge->find('all')->where(['Profilepack.id' => $packageid])->first();
		} elseif ($type == 'RC') {
			$pcakge = TableRegistry::get('RecuriterPack');
			$pcakgeinformation = $pcakge->find('all')->where(['RecuriterPack.id' => $packageid])->first();
		} elseif ($type == 'RE') {
			$pcakge = TableRegistry::get('RequirementPack');
			$pcakgeinformation = $pcakge->find('all')->where(['RequirementPack.id' => $packageid])->first();
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
		$total_reports = $report->find('all')->where(['Report.profile_id' => $userid, 'Report.type' => 'profile'])->count();
		return $total_reports;
	}

	public function userskills($userid)
	{
		$articles = TableRegistry::get('Skillset');

		$userskills = $articles->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $userid])->toArray();
		return $userskills;
	}

	public function events($date)
	{

		$articles = TableRegistry::get('Calendar');

		$events = $articles->find('all')->where(['Calendar.from_date' => $date])->toarray();
		return $events;
	}

	public function reviews($job_id, $artist_id)
	{

		$articles = TableRegistry::get('Review');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$events = $articles->find('all')->where(['Review.job_id' => $job_id, 'Review.artist_id' => $artist_id, 'Review.nontalent_id' => $current_user_id])->count();
		return $events;
	}


	public function performainglanguage($user_id)
	{

		$articles = TableRegistry::get('Performancelanguage');

		$events = $articles->find('all')->contain(['Language'])->where(['Performancelanguage.user_id' => $user_id])->toarray();
		return $events;
	}

	public function languageknown($user_id)
	{

		$articles = TableRegistry::get('Languageknown');

		$events = $articles->find('all')->contain(['Language'])->where(['Languageknown.user_id' => $user_id])->toarray();
		return $events;
	}

	public function paymentfaq($user_id)
	{

		$articles = TableRegistry::get('Performancedesc2');

		$events = $articles->find('all')->contain(['Paymentfequency'])->where(['Performancedesc2.user_id' => $user_id])->toarray();
		return $events;
	}

	public function mypaymentfaq($id)
	{

		$articles = TableRegistry::get('Paymentfequency');

		$events = $articles->find('all')->where(['Paymentfequency.id' => $id])->first()->toarray();
		return $events;
	}

	public function getPaymentCurrencyAndFreq($freqId = null, $currencyId = null)
	{
		$paymentTable = TableRegistry::get('Paymentfequency');
		$currencyTable = TableRegistry::get('Currency');

		$result = [
			'currency' => null,
			'frequency' => null
		];

		if (!empty($currencyId)) {
			$currency = $currencyTable->find()
				->select(['currencycode', 'symbol','name'])
				->where(['Currency.id' => $currencyId])
				->first();

			if ($currency) {
				// $result['currency'] = $currency->symbol . ' (' . $currency->currencycode . ')';
				$result['currency'] = $currency->name . ' (' . $currency->currencycode .' - ' . $currency->symbol . ')';

			}
		}

		if (!empty($freqId)) {
			$frequency = $paymentTable->find()
				->select(['name'])
				->where(['Paymentfequency.id' => $freqId])
				->first();

			if ($frequency) {
				$result['frequency'] = $frequency->name;
			}
		}

		return $result;
	}



	public function video($id = null)
	{
		// echo $user_id;
		if ($id > 0) {
			$user_id = $id;
		} else {
			$user_id = $this->request->session()->read('Auth.User.id');
		}

		$articles = TableRegistry::get('Video');

		$events = $articles->find('all')->where(['Video.user_id' => $user_id])->count();
		//	echo $events;
		return $events;
	}
	public function audio($id = null)
	{
		if ($id > 0) {
			$user_id = $id;
		} else {
			$user_id = $this->request->session()->read('Auth.User.id');
		}
		//	$user_id = $this->request->session()->read('Auth.User.id');
		$articles = TableRegistry::get('Audio');

		$events = $articles->find('all')->where(['Audio.user_id' => $user_id])->count();
		return $events;
	}
	public function gallery($id = null)
	{

		if ($id > 0) {
			$user_id = $id;
		} else {
			$user_id = $this->request->session()->read('Auth.User.id');
		}
		//	$user_id = $this->request->session()->read('Auth.User.id');
		$articles = TableRegistry::get('Gallery');

		$events = $articles->find('all')->where(['Gallery.user_id' => $user_id])->count();
		return $events;
	}
	public function gallerysingimg($id = null)
	{
		if ($id > 0) {
			$user_id = $id;
		} else {
			$user_id = $this->request->session()->read('Auth.User.id');
		}
		//	$user_id = $this->request->session()->read('Auth.User.id');
		$articles = TableRegistry::get('Galleryimage');

		$events = $articles->find('all')->where(['Galleryimage.user_id' => $user_id])->count();
		return $events;
	}

	public function vital($id = null)
	{

		if ($id > 0) {
			$user_id = $id;
		} else {
			$user_id = $this->request->session()->read('Auth.User.id');
		}

		$articles = TableRegistry::get('Uservital');

		$events = $articles->find('all')->contain(['Vques', 'Voption'])->where(['Uservital.user_id' => $user_id])->toarray();
		return $events;
	}
	public function subscriprpack($user_id_get)
	{
		if ($user_id_get) {
			$userid = $user_id_get;
		} else {
			$userid = $this->request->session()->read('Auth.User.id');
		}
		$datetime = date('Y-m-d H:i:s');
		$articles = TableRegistry::get('Subscription');
		// $events = $articles->find('all')->contain(['Profilepack'])->select(['Profilepack.name'])->where(['Subscription.user_id' => $userid, 'Subscription.subscription_date <=' => $datetime, 'Subscription.expiry_date >=' => $datetime, 'Subscription.package_type' => 'PR'])->first();
		$events = $articles->find('all')->contain(['Profilepack'])->select(['Profilepack.name'])->where(['Subscription.user_id' => $userid, 'Subscription.subscription_date <=' => $datetime, 'Subscription.expiry_date >=' => $datetime, 'Subscription.package_type' => 'PR'])->order(['package_id' => 'DESC'])->first();
		return $events;
	}


	public function currentprpack()
	{
		$user_id = $this->request->session()->read('Auth.User.id');
		$articles = TableRegistry::get('Subscription');
		$events = $articles->find('all')->where(['Subscription.user_id' => $user_id, 'Subscription.package_type' => 'PR'])->order(['Subscription.id' => 'DESC'])->first();

		$proarticles = TableRegistry::get('Profilepack');
		$eventspro = $proarticles->find('all')
			->where(['Profilepack.id' => $events['package_id']])
			->order(['Profilepack.id' => 'DESC'])
			->first();

		return $eventspro;
	}

	// Rupam Singh 10 Jan 2025
	public function currentprpackv1()
	{
		$user_id = $this->request->session()->read('Auth.User.id');
		$proarticles = TableRegistry::get('Packfeature');
		$eventspro = $proarticles->find('all')
			->where([
				'user_id' => $user_id,
				'OR' => [
					['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
					['package_status' => 'default']
				]
			])
			->order(['id' => 'DESC'])
			->first();
		return $eventspro;
	}


	public function currentpackagefeature()
	{
		$user_id = $this->request->session()->read('Auth.User.id');
		$articles = TableRegistry::get('Packfeature');
		$events = $articles->find('all')
			->where(['Packfeature.user_id' => $user_id])
			->order(['id' => 'DESC'])
			->first();
		return $events;
	}
	public function requirementcount()
	{
		$user_id = $this->request->session()->read('Auth.User.id');
		$articles = TableRegistry::get('Requirement');
		$events = $articles->find('all')
			->where(['Requirement.user_id' => $user_id, 'Requirement.status' => 'Y'])
			->count();
		return $events;
	}

	public function activePackage($packageType = 'PR')
	{
		// Retrieve the user ID from the session
		$userId = $this->request->session()->read('Auth.User.id');
		if (!$userId) {
			return null;
		}
		// Load models using TableRegistry
		$Packfeature = TableRegistry::get('Packfeature');
		$Users = TableRegistry::get('Users');
		$userRole = $Users->find()
			->select(['role_id'])
			->where(['id' => $userId])
			->first();

		if (!$userRole) {
			return null;
		}

		// Build the query for active packages
		$query = $Packfeature->find()
			->where(['user_id' => $userId]);

		// Add conditions based on the user's role
		if ($userRole->role_id == 3) {
			$query->andWhere(['package_status' => 'default']);
		} else {
			$query->andWhere([
				'OR' => [
					['package_status' => $packageType, 'expire_date >=' => date('Y-m-d H:i:s')],
					['package_status' => 'default']
				]
			]);
		}

		// Retrieve the most recent active package
		return $query->order(['id' => 'DESC'])->first();
	}

	public function getTodayPostJob($packageId)
	{
		// Retrieve the user ID from the session
		$userId = $this->request->session()->read('Auth.User.id');
		if (!$userId) {
			return null;
		}
		$requirement = TableRegistry::get('Requirement');
		$requirecount = $requirement->find('all')
			->where([
				'user_id' => $userId,
				'package_id' => $packageId,
				// 'user_role_id' => $roleType,
				'status' => 'Y',
				'is_paid_post' => 'N',
				'DATE(created)' => date('Y-m-d')
			])
			->count();
		return $requirecount;
	}

	public function getActivePostJob()
	{
		// Retrieve the user ID from the session
		$userId = $this->request->session()->read('Auth.User.id');
		if (!$userId) {
			return null;
		}
		$requirement = TableRegistry::get('Requirement');
		$requirecount = $requirement->find('all')
			->where([
				'user_id' => $userId,
				'status' => 'Y'
			])
			->count();
		return $requirecount;
	}


	public function subscrirepack($user_id_get)
	{
		if ($user_id_get) {
			$userid = $user_id_get;
		} else {
			$userid = $this->request->session()->read('Auth.User.id');
		}

		$datetime = date('Y-m-d H:i:s');
		$articles = TableRegistry::get('Subscription');

		// $events = $articles->find('all')->contain(['RequirementPack'])->select(['RequirementPack.name'])->where(['Subscription.user_id' => $userid, 'Subscription.subscription_date <=' => $datetime, 'Subscription.expiry_date >=' => $datetime, 'Subscription.package_type' => 'RC'])->first();
		// show this recuriter package name
		$events = $articles->find('all')->contain(['RecuriterPack'])->select(['RecuriterPack.title'])->where(['Subscription.user_id' => $userid, 'Subscription.subscription_date <=' => $datetime, 'Subscription.expiry_date >=' => $datetime, 'Subscription.package_type' => 'RC'])->order(['package_id' => 'DESC'])->first();

		return $events;
	}
	public function icon($user_id)
	{

		$articles = TableRegistry::get('Subscription');
		$ppack = PROFILE_PACKAGE;
		$rpack = PROFILE_PACKAGE;
		$events = $articles->find('all')->where(['Subscription.user_id' => $user_id, 'Subscription.package_type' => 'PR', 'Subscription.package_id !=' => $ppack, 'Subscription.package_type !=' => 'RE'])->orWhere(['Subscription.package_type' => 'RC', 'Subscription.package_id !=' => $rpack, 'Subscription.user_id' => $user_id,])->toarray();


		return $events;
	}

	public function profilepack($packid)
	{

		$articles = TableRegistry::get('Profilepack');

		$events = $articles->find('all')->where(['Profilepack.id' => $packid])->first();

		return $events;
	}


	public function recpack($packid, $isPaid = null)
	{
		$recruiterPackTable = TableRegistry::get('RecuriterPack');
		$requirementPackTable = TableRegistry::get('RequirementPack');

		if ($isPaid) {
			// If paid, fetch from RequirementPack
			$event = $requirementPackTable->find('all')->where(['id' => $packid])->first();
		} else {
			// If not paid, fetch from RecuriterPack
			$event = $recruiterPackTable->find('all')->where(['id' => $packid])->first();
		}

		return $event;
	}



	public function proff()
	{
		$articles = TableRegistry::get('Users');
		$uid = $this->request->session()->read('Auth.User.id');
		return $articles->find('all')->contain(['Profile', 'Professinal_info'])->where(['Users.id' => $uid])->first();
	}

	public function userprofileskills()
	{

		$articles = TableRegistry::get('Skillset');
		$uid = $this->request->session()->read('Auth.User.id');

		$userskills = $articles->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $uid])->toArray();
		return $userskills;
	}

	public function appliedjob($jobid)
	{
		$articles = TableRegistry::get('JobApplication');
		$uid = $this->request->session()->read('Auth.User.id');

		$userskills = $articles->find('all')->where(['JobApplication.user_id' => $uid, 'JobApplication.job_id' => $jobid])->first();
		return $userskills;
	}
	public function bookjob($nontalent_id)
	{
		$articles = TableRegistry::get('JobApplication');
		$uid = $this->request->session()->read('Auth.User.id');
		$userskills = $articles->find('all')->where(['JobApplication.user_id' => $nontalent_id, 'JobApplication.nontalent_id' => $uid])->first();
		return $userskills;
	}
	public function askquote($nontalent_id)
	{
		$articles = TableRegistry::get('JobQuote');
		$uid = $this->request->session()->read('Auth.User.id');
		$userskills = $articles->find('all')->where(['JobQuote.user_id' => $nontalent_id, 'JobQuote.nontalentuser_id' => $uid])->first();
		return $userskills;
	}


	public function likess($id)
	{
		$articles = TableRegistry::get('Likes');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$content_type = "profile";

		$uid = $this->request->session()->read('Auth.User.id');
		$userskills = $articles->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id, 'Likes.user_id' => $current_user_id])->count();
		return $userskills;
	}


	public function sentquote($jobid)
	{

		$articles = TableRegistry::get('JobQuote');
		$uid = $this->request->session()->read('Auth.User.id');

		$userskills = $articles->find('all')->where(['JobQuote.user_id' => $uid, 'JobQuote.job_id' => $jobid])->first();
		return $userskills;
	}
	public function repeatbooking($job_id)
	{

		$articles = TableRegistry::get('Requirement');
		$uid = $this->request->session()->read('Auth.User.id');

		$details = $articles->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Eventtype'])->where(['Requirement.id' => $job_id])->first();
		return $details;
	}

	public function bookingalready($job_id, $kill_id)
	{

		$articles = TableRegistry::get('JobApplication');
		$uid = $this->request->session()->read('Auth.User.id');
		$details = $articles->find('all')->where(['JobApplication.job_id' => $job_id, 'JobApplication.skill_id' => $kill_id])->count();
		return $details;
	}

	public function repeatalreadybooking($job_id)
	{
		$articles = TableRegistry::get('JobApplication');
		$uid = $this->request->session()->read('Auth.User.id');
		$details = $articles->find('all')->contain(['Users' => ['Profile', 'Professinal_info'], 'Skill', 'Requirement'])->where(['JobApplication.job_id' => $job_id])->first();
		return $details;
	}

	public function repeatalreadyjob($job_id)
	{
		$articles = TableRegistry::get('JobQuote');
		$uid = $this->request->session()->read('Auth.User.id');
		$details = $articles->find('all')->contain(['Users' => ['Profile', 'Professinal_info'], 'Skill', 'Requirement'])->where(['JobQuote.job_id' => $job_id])->first();
		return $details;
	}

	public function repeatjob($job_id)
	{

		$articles = TableRegistry::get('Requirement');
		$uid = $this->request->session()->read('Auth.User.id');
		$details = $articles->find('all')->where(['Requirement.id' => $job_id])->first();
		return $details;
	}


	public function quoteuserdetail($reqid, $user_id)
	{

		$articles = TableRegistry::get('JobQuote');
		$uid = $this->request->session()->read('Auth.User.id');

		$details = $articles->find('all')->contain(['Requirement', 'Skill', 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']])->where(['JobQuote.job_id' => $reqid, 'JobQuote.user_id' => $user_id, 'JobQuote.amt >' => '0', 'JobQuote.revision' => '0', 'JobQuote.status' => 'N'])->order(['JobQuote.id' => 'DESC'])->first();
		return $details;
	}

	public function vacanydetails($reqid, $skill)
	{

		$articles = TableRegistry::get('RequirmentVacancy');
		$uid = $this->request->session()->read('Auth.User.id');

		$details = $articles->find('all')->contain(['Skill', 'Currency', 'Requirement'])->where(['RequirmentVacancy.requirement_id' => $reqid, 'RequirmentVacancy.telent_type' => $skill])->first();
		return $details;
	}


	public function selectedProfile($reqid)
	{

		$articles = TableRegistry::get('JobQuote');

		$details = $articles->find('all')->contain(['Skill', 'Requirement' => ['JobApplication', 'RequirmentVacancy' => ['Skill', 'Currency'], 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']]])
			->where([
				'JobQuote.job_id' => $reqid,
				'JobQuote.status' => 'S'
			])->first();
		return $details;
	}

	public function selectedProfileAnother($reqid, $userId)
	{

		$articles = TableRegistry::get('JobQuote');

		$details = $articles->find('all')->contain(['Skill', 'Requirement' => ['JobApplication', 'RequirmentVacancy' => ['Skill', 'Currency'], 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']]])
			->where([
				'JobQuote.job_id' => $reqid,
				'JobQuote.user_id' => $userId,
				'JobQuote.status' => 'S'
			])->first();
		return $details;
	}


	public function cnt($cid)
	{
		$articles = TableRegistry::get('Country');
		$userskills = $articles->find('all')->where(['Country.id' => $cid])->first();
		return $userskills;
	}

	public function state($sid)
	{
		$articles = TableRegistry::get('State');
		$userskills = $articles->find('all')->where(['State.id' => $sid])->first();
		return $userskills;
	}
	public function city($city)
	{
		$articles = TableRegistry::get('City');
		$userskills = $articles->find('all')->where(['City.id' => $city])->first();
		return $userskills;
	}


	public function package($city)
	{
		$articles = TableRegistry::get('Subscription');
		$userspackage = $articles->find('all')->where(['Subscription.user_id' => $city])->toArray();
		return $userspackage;
	}


	public function editstate($sid)
	{
		$articles = TableRegistry::get('State');



		$userskills = $articles->find('list')->select(['id', 'name'])->where(['State.	country_id' => $sid])->toarray();
		return $userskills;
	}
	public function editcity($city)
	{
		$articles = TableRegistry::get('City');
		$userskills = $articles->find('all')->select(['id', 'name'])->where(['City.	state_id' => $city])->toarray();


		return $userskills;
	}


	public function profilepackagename($city)
	{
		$articles = TableRegistry::get('Profilepack');
		$userskills = $articles->find('all')->select(['id', 'name'])->where(['Profilepack.	id' => $city])->first();


		return $userskills;
	}

	public function recpackagename($city)
	{
		$articles = TableRegistry::get('RecuriterPack');
		$userskills = $articles->find('all')->select(['id', 'title'])->where(['RecuriterPack.	id' => $city])->first();


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





		$test = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . urlencode($start) . "&destinations=" . urlencode($finish) . "&departure_time=now&key=AIzaSyC27M5hfywTEJa5_l-g0KHWe8m8lxu-rSI";

		$json = file_get_contents($test);

		$details = json_decode($json, TRUE);

		return  $details['rows']['0']['elements']['0']['distance']['text'];
	}



	function inboxcount()
	{
		$where = " where 1=1 ";
		$uid = $this->request->session()->read('Auth.User.id');
		$where .= " and m.read_status = 'N'";
		$where .= " and m.to_id = '" . $uid . "'";
		$where .= " and m.to_box = 'I'";
		$conninbox = ConnectionManager::get('default');
		$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where . " group by m.thread_id";
		//echo $message_qry; die;
		$message_qe = $conninbox->execute($message_qry);
		return $messages = $message_qe->fetchAll('assoc');
		//pr($messages);
	}

	function sentboxcount()
	{

		$uid = $this->request->session()->read('Auth.User.id');
		$where = " where 1=1 ";
		$where .= " and m.from_id = '" . $uid . "'";
		$where .= " and m.from_box = 'S'";

		$conn = ConnectionManager::get('default');
		$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where . " group by m.thread_id";
		$message_qe = $conn->execute($message_qry);
		return $messages = $message_qe->fetchAll('assoc');
		//pr($messages);
	}
	function deraft()
	{
		$uid = $this->request->session()->read('Auth.User.id');
		$where = " where 1=1 ";
		$where .= " and m.from_id = '" . $uid . "'";
		$where .= " and m.from_box = 'D'";

		$conn = ConnectionManager::get('default');
		$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where . " group by m.thread_id";
		$message_qe = $conn->execute($message_qry);
		return $messages = $message_qe->fetchAll('assoc');
		//pr($messages);
	}

	function folder()
	{


		$articles = TableRegistry::get('Messagegroup');
		$uid = $this->request->session()->read('Auth.User.id');
		return $userskills = $articles->find('all')->where(['user_id' => $uid])->toarray();
	}


	function trash()
	{


		$uid = $this->request->session()->read('Auth.User.id');
		$where = " where 1=1 ";
		$where .= " and (m.from_id = '" . $uid . "' and m.from_box = 'T') OR (m.to_id = '" . $uid . "' and m.to_box = 'T')";
		//$where.= " ";
		$conn = ConnectionManager::get('default');
		$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where . " group by m.thread_id";

		//echo $message_qry; die;
		$message_qe = $conn->execute($message_qry);
		return $messages = $message_qe->fetchAll('assoc');
	}


	function readmessage()
	{


		$where = " where 1=1 ";
		$uid = $this->request->session()->read('Auth.User.id');
		$where .= " and m.read_status= 'Y'";
		$where .= " and m.to_id = '" . $uid . "'";
		$where .= " and m.to_box = 'I'";
		$conninbox = ConnectionManager::get('default');
		$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where . " group by m.thread_id";
		//echo $message_qry; die;
		$message_qe = $conninbox->execute($message_qry);
		return $messages = $message_qe->fetchAll('assoc');
	}



	public function userdeails($job_id)
	{

		$articles = TableRegistry::get('users');
		$details = $articles->find('all')->where(['users.id' => $job_id])->first();
		return $details;
	}

	public function findlikedislike($id = null, $user_id = null)
	{
		$articles = TableRegistry::get('Galleryimagelike');
		$details = $articles->find('all')->select(['image_like', 'caption'])->where(['image_gallery_id' => $id])->first();
		return $details;
	}

	public function findvideolikedislike($id, $user_id)
	{
		$articles = TableRegistry::get('Videolike');
		$details = $articles->find('all')->select(['video_like', 'caption'])->where(['video_id' => $id, 'user_id' => $user_id])->first();
		return $details;
	}


	public function findaudioikedislike($id, $user_id)
	{
		$articles = TableRegistry::get('Audiolike');
		$details = $articles->find('all')->select(['audio_like', 'caption'])->where(['audio_id' => $id, 'user_id' => $user_id])->first();
		return $details;
	}

	public function findlikecount($id)
	{
		$articles = TableRegistry::get('Galleryimagelike');
		$details = $articles->find('all')->where(['image_like' => '1', 'image_gallery_id' => $id])->count();
		return $details;
	}

	public function findvideolikecount($id)
	{
		$articles = TableRegistry::get('Videolike');
		$details = $articles->find('all')->where(['video_like' => '1', 'video_id' => $id])->count();
		return $details;
	}



	public function findaudiolikecount($id)
	{
		$articles = TableRegistry::get('Audiolike');
		$details = $articles->find('all')->where(['audio_like' => '1', 'audio_id' => $id])->count();
		return $details;
	}




	public function findprofileimage($id)
	{
		$articles = TableRegistry::get('Profile');
		$details = $articles->find('all')->select(['profile_image', 'location', 'user_id', 'name'])->where(['user_id' => $id])->first();
		return $details;
	}

	public function checktalent($id)
	{
		$articles = TableRegistry::get('Skillset');
		$uid = $this->request->session()->read('Auth.User.id');
		$userskills = $articles->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id])->toArray();
		return $userskills;
	}

	public function findvideocaption($id)
	{
		$articles = TableRegistry::get('Videolike');
		$details = $articles->find('all')->select(['caption'])->where(['video_id' => $id])->first();
		return $details;
	}


	public function userjobsave($job_id)
	{
		$articles = TableRegistry::get('Savejobs');
		$uid = $this->request->session()->read('Auth.User.id');
		$details = $articles->find('all')->where(['Savejobs.user_id' => $uid, 'Savejobs.job_id' => $job_id])->count();
		return $details;
	}

	public function userprofilesave()
	{
		$articles = TableRegistry::get('Saveprofile');
		$uid = $this->request->session()->read('Auth.User.id');
		$details = $articles->find('all')->where(['Saveprofile.user_id' => $uid])->count();
		return $details;
	}

	public function profilesave($content_id)
	{
		//   pr($content_id);
		$articles = TableRegistry::get('Saveprofile');
		$uid = $this->request->session()->read('Auth.User.id');
		$details = $articles->find('all')->where(['Saveprofile.user_id' => $uid, 'Saveprofile.p_id' => $content_id])->count();
		return $details;
	}

	public function totalimagelike($content_id)
	{
		$content_type = 'image';
		$articles = TableRegistry::get('Likes');
		$details = $articles->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $content_id])->count();

		return $details;
	}

	public function totalvideolike($content_id)
	{
		$content_type = 'video';
		$articles = TableRegistry::get('Likes');
		$details = $articles->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $content_id])->count();

		return $details;
	}

	public function totalaudiolike($content_id)
	{
		$content_type = 'audio';
		$articles = TableRegistry::get('Likes');
		$details = $articles->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $content_id])->count();

		return $details;
	}

	public function totaluserimagelike($content_id)
	{
		$user_det_id = $this->request->session()->read('Auth.User.id');
		$content_type = 'image';
		$articles = TableRegistry::get('Likes');
		$details = $articles->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $content_id, 'Likes.user_id' => $user_det_id])->count();

		return $details;
	}

	public function totaluseraudiolike($content_id)
	{
		$user_det_id = $this->request->session()->read('Auth.User.id');
		$content_type = 'audio';
		$articles = TableRegistry::get('Likes');
		$details = $articles->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $content_id, 'Likes.user_id' => $user_det_id])->count();

		return $details;
	}

	public function totaluservideolike($content_id)
	{
		$user_det_id = $this->request->session()->read('Auth.User.id');
		$content_type = 'video';
		$articles = TableRegistry::get('Likes');
		$details = $articles->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $content_id, 'Likes.user_id' => $user_det_id])->count();

		return $details;
	}


	public function calendardatacheckbydate($id)
	{
		$date = date('Y-m-d');
		$id = $this->request->session()->read('Auth.User.id');
		$conn = ConnectionManager::get('default');
		$frnds = "SELECT count(*) as totalcalendarcount FROM calendar WHERE `user_id` ='" . $id . "' and  STR_TO_DATE(`from_date`,'%Y-%m-%d')  = '" . $date . "' AND STR_TO_DATE(`to_date`,'%Y-%m-%d')  = '" . $date . "' ";
		$onlines = $conn->execute($frnds);

		$event = $onlines->fetchAll('assoc');
		// pr($event);die;
		return $event;
	}

	public function downloadprofile($profile_id)
	{
		$articles = TableRegistry::get('Users');
		$requirementtab = TableRegistry::get('Requirement');
		$jobquotetab = TableRegistry::get('JobQuote');
		$jobapptab = TableRegistry::get('JobApplication');
		$jobapptab = TableRegistry::get('JobApplication');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$current_user = $articles->find('all')->where(['Users.id' => $current_user_id])->first();
		$role_id = $current_user['role_id'];
		$conn = ConnectionManager::get('default');

		if ($role_id == TALANT_ROLEID) {
			$show_contactinfo = 1;
		} else if ($role_id == NONTALANT_ROLEID) {
			$job_quotes = 0;
			$jobapplication = 0;

			$requirementfeatured = $requirementtab->find('list')->where(['Requirement.user_id' => $current_user_id])->order(['Requirement.id' => 'DESC'])->toarray();
			foreach ($requirementfeatured as $jobkey => $value) {
				$job_array[] = $jobkey;
			}
			if (count($job_array) > 0) {
				//$jobposts = 
				$job_quotes = $jobquotetab->find('all')->where(['JobQuote.job_id IN' => $job_array, 'JobQuote.user_id' => $profile_id])->count();
				$jobapplication = $jobapptab->find('all')->where(['JobApplication.job_id IN' => $job_array, 'JobApplication.user_id' => $profile_id])->count();
			}
			$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $current_user_id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $current_user_id . "' and c.accepted_status='Y'";
			$stmt = $conn->execute($fquery);
			$friends = $stmt->fetchAll('assoc');

			if ($job_quotes > 0 || $jobapplication > 0) {
				$show_contactinfo = 1;
			} else if ($friends) {
				$show_contactinfo = 1;
			} else {
				$show_contactinfo = 0;
				$error = 'You are not authorized to access the contact details of this user.';
			}
		} else {
			$show_contactinfo = 0;
		}
		//pr($show_contactinfo);
		return $show_contactinfo;
	}

	// for showing activities when user doing this....
	public function unlikeimage($id = null, $img = null)
	{

		$articles = TableRegistry::get('Galleryimage');

		$events = $articles->find('all')->where(['Galleryimage.id' => $img])->first();
		return $events;
	}
	public function unlikevideo($id = null, $vdo = null)
	{

		$articles = TableRegistry::get('Video');

		$events = $articles->find('all')->where(['Video.id' => $vdo])->first();
		return $events;
	}
	public function unlikeaudio($id = null, $ado = null)
	{

		$articles = TableRegistry::get('Audio');

		$events = $articles->find('all')->where(['Audio.id' => $ado])->first();
		return $events;
	}
	public function unlikejob($id = null, $job = null)
	{

		$articles = TableRegistry::get('Requirement');

		$events = $articles->find('all')->where(['Requirement.id' => $job])->first();
		return $events;
	}

	public function jobliike($job = null)
	{
		$user_id = $this->request->session()->read('Auth.User.id');
		$articles = TableRegistry::get('Likejobs');
		$events = $articles->find('all')->where(['Likejobs.user_id' => $user_id, 'Likejobs.job_id' => $job])->first();
		return $events;
	}


	public function reportcheck($job = null)
	{
		$user_id = $this->request->session()->read('Auth.User.id');
		$articles = TableRegistry::get('Report');
		$events = $articles->find('all')->where(['Report.reported_by_id' => $user_id, 'Report.profile_id' => $job, 'Report.type' => 'job'])->first();
		return $events;
	}

	public function facebookiddata($job = null)
	{
		$articles = TableRegistry::get('Requirement');

		$events = $articles->find('all')->where(['Requirement.id' => $job])->first();
		return $events;
	}


	public function userjobanswers($job_id = null, $user_id = null)
	{
		$articles = TableRegistry::get('Jobquestion');
		$details = $articles->find('all')->contain(['Userjobanswer'])->where(['Jobquestion.job_id' => $job_id])->toarray();
		return $details;
	}


	public function talentadminname($user_id = null)
	{
		$articles = TableRegistry::get('Users');
		$details = $articles->find('all')->contain(['Profile'])->where(['Users.id' => $user_id])->first();
		return $details;
	}

	public function refersbyuser($user_id = null)
	{
		$articles = TableRegistry::get('Users');
		$details = $articles->find('all')->where(['Users.id' => $user_id])->first();
		return $details;
	}

	public function talentpartnersrefers($user_id = null)
	{
		$articles = TableRegistry::get('Refers');
		$details = $articles->find('all')->where(['Refers.ref_by' => $user_id])->toarray();
		return $details;
	}


	public function bannercount()
	{
		$articles = TableRegistry::get('Banner');
		$details = $articles->find('all')->where(['Banner.notifi' => 2])->toarray();
		return $details;
	}

	public function bannercountfront($userid = null)
	{
		$articles = TableRegistry::get('Banner');
		$details = $articles->find('all')->where(['Banner.notifi' => 1, 'Banner.user_id' => $userid])->toarray();
		return $details;
	}


	public function isaccessadds($userid = null)
	{
		$articles = TableRegistry::get('Users');
		$details = $articles->find('all')->where(['Users.id' => $userid])->first();
		return $details;
	}

	public function mytransactions($id)
	{
		$articles = TableRegistry::get('Transcation');
		$details = $articles->find('all')->where(['advrt_profile_id' => $id])->first();
		return $details;
	}

	public function myjobadtransactions($id)
	{
		$articles = TableRegistry::get('Transcation');
		$details = $articles->find('all')->where(['advrt_job_id' => $id])->first();
		return $details;
	}


	// public function advertisedprofile($uid = null)
	// {

	// 	$articles = TableRegistry::get('Profile');

	// 	$userdetail = $articles->find('all')->where(['Profile.user_id' => $uid])->first();
	// 	$lat = $userdetail['lat'];
	// 	$lng = $userdetail['longs'];
	// 	$cur_lat = $userdetail['current_lat'];
	// 	$cur_lng = $userdetail['current_long'];
	// 	$prgender = $userdetail['gender'];
	// 	$profilerole = $userdetail['user']['role_id'];
	// 	$currentdate = date('Y-m-d H:m:s');

	// 	$conn = ConnectionManager::get('default');
	// 	$featuredartist = "SELECT 1.609344 * 6371 * acos( cos( radians('" . $cur_lat . "') ) 
	//     * cos( radians(Profileadvertpack.current_lat) ) 
	//     * cos( radians(Profileadvertpack.current_long) - radians('" . $cur_lng . "') ) + sin( radians('" . $cur_lat . "') ) 
	//     * sin( radians(Profileadvertpack.current_lat) ) ) AS cdistance,1.609344 * 6371 
	//     * acos( cos( radians('" . $lat . "') ) 
	//      * cos( radians(Profileadvertpack.current_lat) ) 
	//     * cos( radians(Profileadvertpack.current_long) - radians('" . $lng . "') ) + sin( radians('" . $lat . "') ) 
	//     * sin( radians(Profileadvertpack.current_lat) ) ) AS fdistance, 

	//      Profile.name, 
	//      Profile.gender, 
	//      Profile.location,
	//      Profileadvertpack.id AS `advrtpro__id`, 
	//      Profileadvertpack.rname AS `advrtpro__title`, 
	//      Profileadvertpack.user_id AS `pro_id`, 
	//      Profileadvertpack.job_image_change AS `advrt_image`, 
	//      Profileadvertpack.gender, 
	//      Profileadvertpack.ad_for, 
	//      Profileadvertpack.current_location
	//      FROM advrt_profile_pack Profileadvertpack INNER JOIN personal_profile Profile ON Profile.user_id = (Profileadvertpack.user_id)
	//     WHERE ((Profileadvertpack.ad_date_to >= '" . $currentdate . "' AND Profileadvertpack.user_id != '" . $uid . "') AND (Profileadvertpack.gender ='" . $prgender . "' OR Profileadvertpack.ad_for ='" . $profilerole . "')) having fdistance < " . SEARCH_DISTANCE . "  and cdistance < " . SEARCH_DISTANCE . "  ORDER BY cdistance ASC";
	// 	$allfeaturedartist = $conn->execute($featuredartist);
	// 	$viewfeaturedartist = $allfeaturedartist->fetchAll('assoc');
	// 	//pr($viewfeaturedartist); die;

	// 	return $viewfeaturedartist;
	// }
	// new advertise code
	public function advertisedprofile($uid = null)
	{

		$articles = TableRegistry::get('Profile');

		$userdetail = $articles->find('all')->where(['Profile.user_id' => $uid])->first();
		$lat = $userdetail['lat'];
		$lng = $userdetail['longs'];
		$cur_lat = $userdetail['current_lat'];
		$cur_lng = $userdetail['current_long'];
		$prgender = $userdetail['gender'];
		$profilerole = $userdetail['user']['role_id'];
		$currentdate = date('Y-m-d H:m:s');

		$conn = ConnectionManager::get('default');
		$featuredartist = "SELECT 1.609344 * 6371 * acos( cos( radians('" . $cur_lat . "') ) 
	    * cos( radians(Profileadvertpack.current_lat) ) 
	    * cos( radians(Profileadvertpack.current_long) - radians('" . $cur_lng . "') ) + sin( radians('" . $cur_lat . "') ) 
	    * sin( radians(Profileadvertpack.current_lat) ) ) AS cdistance,1.609344 * 6371 
	    * acos( cos( radians('" . $lat . "') ) 
	     * cos( radians(Profileadvertpack.current_lat) ) 
	    * cos( radians(Profileadvertpack.current_long) - radians('" . $lng . "') ) + sin( radians('" . $lat . "') ) 
	    * sin( radians(Profileadvertpack.current_lat) ) ) AS fdistance, 

	     Profile.name, 
	     Profile.gender, 
	     Profile.location,
	     Profileadvertpack.id AS `advrtpro__id`, 
	     Profileadvertpack.rname AS `advrtpro__title`, 
	     Profileadvertpack.user_id AS `pro_id`, 
	     Profileadvertpack.job_image_change AS `advrt_image`, 
	     Profileadvertpack.gender, 
	     Profileadvertpack.ad_for, 
	     Profileadvertpack.current_location
	     FROM advrt_profile_pack Profileadvertpack INNER JOIN personal_profile Profile ON Profile.user_id = (Profileadvertpack.user_id)
	    WHERE ((Profileadvertpack.ad_date_to >= '" . $currentdate . "' AND Profileadvertpack.user_id != '" . $uid . "') ) 
		ORDER BY cdistance ASC";
		$allfeaturedartist = $conn->execute($featuredartist);
		$viewfeaturedartist = $allfeaturedartist->fetchAll('assoc');
		//pr($viewfeaturedartist); die;

		return $viewfeaturedartist;
	}


	//for talent admin menu panel
	public function talentadmin($id = null)
	{
		$articles = TableRegistry::get('TalentAdmin');
		$userdetail = $articles->find('all')->select(['enable_create_subadmin'])->where(['TalentAdmin.user_id' => $id])->first();
		return $userdetail;
	}

	//Find currency name to show in artist manager
	public function currencyname($id = null)
	{
		$articles = TableRegistry::get('Currency');
		$curr = $articles->find('all')->select(['currencycode', 'symbol'])->where(['Currency.id' => $id])->first();
		return $curr;
	}

	public function referuserno($email = null)
	{
		$articles = TableRegistry::get('Users');
		$curr = $articles->find('all')->where(['Users.email' => $email])->first();
		//echo $curr; die;
		if (!empty($curr)) {
			$articles = TableRegistry::get('Profile');
			$userp = $articles->find('all')->contain(['Country'])->select(['Profile.phone', 'Country.cntcode'])->where(['Profile.user_id' => $curr['id']])->first();
		}
		return $userp;
	}

	public function profilemails($id)
	{
		//echo $id;
		$articles = TableRegistry::get('Profile');
		$userp = $articles->find('all')->select(['altemail'])->where(['Profile.user_id' => $id])->first();
		return $userp;
	}

	public function checkuserexist($mail)
	{
		$articles = TableRegistry::get('Users');
		$curr = $articles->find('all')->select(['id'])->where(['Users.email' => $mail])->first();
		return $curr;
	}

	public function profilphone($id)
	{
		//echo $id;
		$articles = TableRegistry::get('Profile');
		$userp = $articles->find('all')->contain(['Country', 'State', 'City'])->select(['Country.name', 'State.name', 'City.name', 'country_ids', 'state_id', 'city_id', 'phone', 'phonecode', 'altnumber'])->where(['Profile.user_id' => $id])->first();
		return $userp;
	}

	public function managetalentpartner($id)
	{
		//echo $id;
		$articles = TableRegistry::get('Users');
		$userp = $articles->find('all')->contain(['Profile', 'Refers'])->where(['Users.id' => $id, 'Users.is_talent_admin' => 'Y'])->first();
		return $userp;
	}

	public function jobdetail($id)
	{
		//echo $id;
		$articles = TableRegistry::get('Jobadvertpack');
		$Job = $articles->find('all')->where(['Jobadvertpack.requir_id' => $id])->order(['id' => 'Desc'])->first();
		return $Job;
	}

	public function requiredetail($id)
	{
		//echo $id;
		$articles = TableRegistry::get('RequirmentVacancy');
		$Job = $articles->find('all')->contain(['Skill'])->where(['RequirmentVacancy.requirement_id' => $id])->toarray();
		return $Job;
	}

	public function profiledetail($id)
	{
		//echo $id;
		$articles = TableRegistry::get('Profile');
		$profile = $articles->find('all')->contain(['Users', 'Enthicity', 'City', 'Country'])->where(['user_id' => $id])->first();
		return $profile;
	}

	public function blockuser($id)
	{
		//echo $id;
		$articles = TableRegistry::get('Blocks');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$content_type = 'profile';
		$blockuser = $articles->find('all')->where(['Blocks.content_type' => $content_type, 'Blocks.content_id' => $id, 'Blocks.user_id' => $current_user_id])->count();
		return $blockuser;
	}

	public function profilepackage($userid)
	{
		$articles = TableRegistry::get('Subscription');
		$userspackage = $articles->find('all')->where(['Subscription.user_id' => $userid, 'Subscription.package_type' => 'PR'])->order(['Subscription.id' => 'DESC'])->first();
		return $userspackage;
	}

	public function videodetail($videourl)
	{
		$articles = TableRegistry::get('Video');
		$userspackage = $articles->find('all')->where(['video_type' => $videourl])->first();
		return $userspackage;
	}

	public function notisenderdetail($userid)
	{
		$articles = TableRegistry::get('Users');
		$notification = $articles->find('all')->contain(['Profile'])->where(['Users.id' => $userid])->first();
		return $notification;
	}

	public function jobtitle($jobid)
	{
		$articles = TableRegistry::get('Requirement');
		$events = $articles->find('all')->select(['title'])->where(['Requirement.id' => $jobid])->first();
		return $events;
	}

	public function subscriptionpr($userid)
	{
		$articles = TableRegistry::get('Subscription');
		$datetime = date('Y-m-d H:i:s');
		$events = $articles->find('all')->contain(['Profilepack'])->select(['Profilepack.name'])->where(['Subscription.user_id' => $userid, 'Subscription.subscription_date <=' => $datetime, 'Subscription.expiry_date >=' => $datetime, 'Subscription.package_type' => 'PR'])->first();
		return $events;
	}

	public function finddesignation($userid)
	{
		$articles = TableRegistry::get('Prof_exprience');
		$events = $articles->find('all')->select(['role'])->where(['Prof_exprience.user_id' => $userid])->order(['Prof_exprience.id' => 'DESC'])->first();
		return $events;
	}

	public function transactions($userid)
	{
		$articles = TableRegistry::get('Transcation');
		$details = $articles->find()->select(['sum' => 'SUM(amount)'])->where(['user_id' => $userid])->first();
		return $details;
	}

	public function lasttransaction($userid)
	{
		$articles = TableRegistry::get('Transcation');
		$details = $articles->find('all')->select(['created'])->where(['user_id' => $userid])->order(['id' => 'DESC'])->first();
		return $details;
	}

	public function admindata()
	{
		$articles = TableRegistry::get('Sitesettings');
		return $articles->find('all')->where(['Sitesettings.id' => 1])->first();
	}

	public function getGalleryImagesCount($userid, $gallery_id)
	{
		$articles = TableRegistry::get('Galleryimage');
		return $articles->find('all')->where(['Galleryimage.status' => 1, 'Galleryimage.user_id' => $userid, 'Galleryimage.gallery_id' => $gallery_id])->count();
	}

	public function galleryImagesCount()
	{
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$articles = TableRegistry::get('Galleryimage');
		return $articles->find('all')->where(['Galleryimage.status' => 1, 'Galleryimage.user_id' => $current_user_id, 'Galleryimage.gallery_id !=' => 0])->count();
	}


	public function allnotificationcounts($userid)
	{
		$articles = TableRegistry::get('Users');
		$result = $articles->find('all')->where(['Users.id' => $userid])->first();
		return $result;
	}



	public function todaybrithday()
	{
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$articles = TableRegistry::get('Profile');

		$result = $articles->find('all')->contain(['Users'])->where(['MONTH(dob)' => date('m'), 'DAY(dob)' => date('d')])->toarray();

		return $result;
	}

	public function packdetail($packageid)
	{

		$pcakge = TableRegistry::get('Profilepack');
		$pcakgeinformation = $pcakge->find('all')->where(['Profilepack.id' => $packageid])->first();
		return $pcakgeinformation;
	}

	public function getPackageNameById($packageid)
	{
		$pcakge = TableRegistry::get('Profilepack');
		$pcakgeinformation = $pcakge->find('all')
			->select(['Profilepack.name'])
			->where(['Profilepack.id' => $packageid])
			->first();
		return $pcakgeinformation;
	}

	public function get_fat_cat($id)
	{
		$articles = TableRegistry::get('FaqCatQuestion');
		$result = $articles->find('all')->where(['FaqCatQuestion.faq_cat_id' => $id, 'FaqCatQuestion.status' => 'Y'])->toarray();
		return $result;
	}
}
