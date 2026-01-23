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

class JobpostController extends AppController
{


	public function initialize()
	{
		parent::initialize();
	}

	public function social($job_id) {}

	public function likejobs($job_id)
	{
		$this->loadModel('Users');
		$this->loadModel('Likejobs');
		$totallikes = $this->Likejobs->find('all')->where(['Likejobs.job_id' => $job_id])->toarray();
		$this->set('findall', $totallikes);
	}

	public function getStates()
	{
		$this->loadModel('Country');
		$this->loadModel('State');

		$states = array();

		if (isset($this->request->data['id'])) {

			$states = $this->Country->State->find('list')->select(['id', 'name'])->where(['State.country_id' => $this->request->data['id']])->toarray();
		}
		$states['0'] = '--Selectstate--';
		ksort($states);
		// $dd = array_push($states,$data);
		//array_unshift($states,"Select State");

		header('Content-Type: application/json');
		echo json_encode($states);
		exit();
	}

	public function getcities()
	{
		$this->loadModel('City');
		$cities = array();
		if (isset($this->request->data['id'])) {
			$cities = $this->City->find('list')->select(['id', 'name'])->where(['City.state_id' => $this->request->data['id']])->toarray();
		}
		// array_unshift($cities,"Select city");
		$cities['0'] = '--Selectcity--';
		ksort($cities);

		header('Content-Type: application/json');
		echo json_encode($cities);
		exit();
	}

	// Check if user is Elegible for posting the job or not. 
	function jobpostability()
	{
		$this->loadModel('Packfeature');
		$user_id = $this->request->session()->read('Auth.User.id');
		$user_role = $this->request->session()->read('Auth.User.role_id');

		if ($user_role == TALANT_ROLEID) {
			$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'DESC'])->first();
			$status['id'] = $packfeature['id'];
			$status['number_of_job_post_used'] = $packfeature['number_of_job_post_used'];
			$status['requirement_package_jobs'] = $packfeature['requirement_package_jobs'];
			$status['number_of_booking'] = $packfeature['number_of_booking']; //number_of_booking
			$status['askquote_request_job'] = $packfeature['ask_for_quote_request_per_job'];
			$status['non_telent_number_of_job_post_used'] = $packfeature['non_telent_number_of_job_post_used'];

			if ($packfeature['number_of_job_post'] > 0) {
				$status['status'] = 'RC';
			} else {
				$status['status'] = 'RE';
			}
		} elseif ($user_role == NONTALANT_ROLEID) {
			$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'DESC'])->first();
			$status['id'] = $packfeature['id'];
			$status['number_of_job_post_used'] = $packfeature['number_of_job_post_used'];
			$status['requirement_package_jobs'] = $packfeature['requirement_package_jobs'];
			$status['non_telent_number_of_job_post_used'] = $packfeature['non_telent_number_of_job_post_used'];
			$status['number_of_booking'] = $packfeature['number_of_booking']; //number_of_booking
			$status['askquote_request_job'] = $packfeature['non_telent_ask_quote'];
			$status['status'] = 'NT';
		}
		return $status;
	}

	public function jobpost($job_id = null)
	{
		$this->loadModel('Skill');
		$this->loadModel('Currency');
		$this->loadModel('Requirement');
		$this->loadModel('RequirmentVacancy');
		$this->loadModel('Questionmare_options_type');
		$this->loadModel('Jobquestion');
		$this->loadModel('Job_answer');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Enthicity');
		$this->loadModel('Paymentfequency');
		$this->loadModel('Packfeature');
		$this->loadModel('Eventtype');
		$this->loadModel('Settings');
		$this->loadModel('Subscription');
		$this->loadModel('Transcation');
		$this->loadModel('Profilepack');
		$this->loadModel('RecuriterPack');
		$this->loadModel('RequirementPack');

		$id = $this->request->session()->read('Auth.User.id');
		$user_role_id = $this->request->session()->read('Auth.User.role_id');
		$packfeature = $this->activePackage('RC'); // if purches any recuruter packages else default package limit comes 
		// pr($packfeature);exit;
		$daily_limit = $packfeature['number_of_job_simultancney'];
		$totalUsedLimit = 0;
		if ($user_role_id == NONTALANT_ROLEID) {
			$totalLimitJobPost = $packfeature['non_telent_number_of_job_post'];
			$totalUsedLimit = $packfeature['non_telent_number_of_job_post_used'];
		} else {
			$totalLimitJobPost = $packfeature['number_of_job_post'];
			$totalUsedLimit = $packfeature['number_of_job_post_used'];
		}

		$currentdate = date('Y-m-d H:m:s');
		$requirecount = $this->Requirement->find('all')
			->where([
				'Requirement.user_id' => $id,
				'DATE(Requirement.last_date_app) >=' => $currentdate,
				'status' => 'Y'
			])
			->count();

		$existing_subscription = $this->Transcation->find('all')
			->contain(['Subscription'])
			->where([
				'Subscription.user_id' => $id,
				'Subscription.package_type' => 'RE',
				'Subscription.is_used' => 'N',
			])
			->select(['Subscription.id', 'Subscription.package_id', 'Transcation.number_of_days', 'Transcation.number_of_talent_type', 'Transcation.post_priorites'])
			->first();

		$this->set('existing_subscription', $existing_subscription);
		$this->set('packfeature', $packfeature);

		if (empty($existing_subscription)) {
			// Validation checks for job posting limits
			if ($totalLimitJobPost <= $totalUsedLimit) {
				return $this->redirect('/package/jobposting');
			}

			if ($user_role_id == TALANT_ROLEID && $requirecount >= $daily_limit) {
				$this->Flash->error(__(
					'You have reached your daily job posting limit of {0}. Jobs posted today: {1}. Please try again tomorrow or upgrade your package.',
					$daily_limit,
					$requirecount
				));
				return $this->redirect($this->referer());
			}
		}

		$packfeature_id = $packfeature['id'];
		$jobposterror = "You do not have any Package for Posting this job Please purchase Recruiter or Requirement Package for posting job";
		//pr($this->request->session()->read('posttype'));
		$payfreq = $this->Paymentfequency->find('list')->toarray();
		$this->set('payfreq', $payfreq);

		$eventtype = $this->Eventtype->find('all')->toarray();

		$this->set('eventtype', $eventtype);

		$requirement = $this->Requirement->find('all')->where(['Requirement.id' => $job_id])->first();
		// pr($requirement);exit;
		$this->set('requirement', $requirement);

		$jobquestion = $this->Jobquestion->find('all')->where(['Jobquestion.job_id' => $job_id])->toarray();
		$this->set('jobquestion', $jobquestion);

		$details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City', 'Users', 'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']])->where(['Requirement.id' => $job_id])->first();
		$this->set('requirement_data', $details);

		$requirementvacancy = $this->RequirmentVacancy->find('all')->where(['RequirmentVacancy.requirement_id' => $job_id])->toarray();
		$this->set('requirementvacancy', $requirementvacancy);

		$this->set('job_id', $job_id);
		//pr($this->request->data); die;

		$requi = $this->Requirement->newEntity();
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'State', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);
		$Currency = $this->Currency->find('all')
			->select(['id', 'name', 'currencycode', 'symbol'])
			->order(['name' => 'ASC', 'id' => 'ASC'])
			->all()
			->combine(
				'id',
				function ($row) {
					return $row->name . ' (' . $row->currencycode . ' - ' . $row->symbol . ')';
				}
			)
			->toArray();
		$this->set('Currency', $Currency);
		$symbol = $this->Currency->find('list', ['keyField' => 'id', 'valueField' => 'symbol'])->order(['name' => 'ASC'])->toarray();
		$this->set('symbol', $symbol);
		$country = $this->Country->find('list')->select(['id', 'name'])->order(['name' => 'ASC'])->toarray();
		$this->set('country', $country);
		$Skill = $this->Skill->find('all')->select(['id', 'name'])->order(['name' => 'ASC'])->toarray();
		$this->set('Skill', $Skill);

		$cities = $this->City->find('list')->where(['City.state_id' => $details['state_id']])->order(['name' => 'ASC'])->toarray();
		$this->set('cities', $cities);
		$states = $this->State->find('list')->where(['State.country_id' => $details['country_id']])->toarray();
		$this->set('states', $states);
		$questionnare = $this->Questionmare_options_type->find('list')->toarray();
		$this->set('questionnare', $questionnare);


		if ($this->request->is(['post', 'put'])) {
			$this->request->data['user_id'] = $id; // do not remove this Rupam
			// pr($this->request->data);
			// exit;
			// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<Active Package Start>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$currentdate = date('Y-m-d');
			$user_id = $this->request->session()->read('Auth.User.id');
			// Fetch subscriptions, excluding PR & RC packages with package_id = 1
			$subscriptions = $this->Subscription->find()
				->where([
					'Subscription.user_id' => $user_id,
					'Subscription.package_id !=' => 1 // Exclude default package first
				])
				->order(['Subscription.id' => 'DESC']) // Get latest first
				->toArray();

			// pr($subscriptions);exit;
			$currentPackages = ['PR' => null, 'RC' => null, 'RE' => null];
			if (!empty($subscriptions)) {
				foreach ($subscriptions as $subscription) {
					$packageType = $subscription['package_type'];
					$package = null;

					if ($packageType === 'PR') {
						// Profilepack ke liye
						$package = $this->Profilepack->find('all')
							->where(['id' => $subscription['package_id']])
							->first();

						if ($package && !$currentPackages['PR'] && strtotime($subscription['expiry_date']) >= strtotime($currentdate)) {
							$currentPackages['PR'] = [
								'package_type' => 'PR',
								'package_id' => $subscription['package_id'],
								'package_name' => $package->name,
								'is_used' => $subscription['status'],
								'expiry_date' => $subscription['expiry_date']->format('Y-m-d H:i:s')
							];
						}
					} elseif ($packageType === 'RC') {
						// RecruiterPack ke liye
						$package = $this->RecuriterPack->find('all')
							->where(['id' => $subscription['package_id']])
							->first();

						if ($package && !$currentPackages['RC'] && strtotime($subscription['expiry_date']) >= strtotime($currentdate)) {
							$currentPackages['RC'] = [
								'package_type' => 'RC',
								'package_id' => $subscription['package_id'],
								'package_name' => $package->name,
								'is_used' => $subscription['status'],
								'expiry_date' => $subscription['expiry_date']->format('Y-m-d H:i:s')
							];
						}
					} elseif ($packageType === 'RE') {
						// RE type ke liye (expiry check nahi karna)
						$package = $this->RequirementPack->find('all')
							->where(['id' => $subscription['package_id']])
							->first();
						if ($package && !$currentPackages['RE']) {
							$currentPackages['RE'] = [
								'package_type' => 'RE',
								'package_id' => $subscription['package_id'],
								'package_name' => $package->name,
								'is_used' => $subscription['status'],
								'expiry_date' => null // RE ke liye expiry_date nahi hoti
							];
						}
					}
				}
			}

			// If no valid package was found, fetch the default (package_id = 1)
			foreach (['PR', 'RC'] as $type) {
				if (!$currentPackages[$type]) {
					$defaultSubscription = $this->Subscription->find()
						->where([
							'Subscription.user_id' => $user_id,
							'Subscription.package_type' => $type,
							'Subscription.package_id' => 1 // Default package
						])
						->first();

					$defaultPackage = $this->{$type == 'PR' ? 'Profilepack' : 'RecuriterPack'}->find()
						->where(['id' => 1])
						->first();

					// pr($defaultSubscription);
					$currentPackages[$type] = [
						'package_type' => $type,
						'package_id' => $defaultSubscription ? $defaultSubscription->package_id : 1,
						'package_name' => $defaultPackage ? $defaultPackage->name : 'Default',
						'is_used' => $defaultSubscription['status'],
						'expiry_date' => $defaultSubscription ? $defaultSubscription->expiry_date->format('Y-m-d H:i:s') : 'N/A'
					];
				}
			}
			$activePack = array_values($currentPackages);
			// pr($user_role_id);
			// exit;

			// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<Active Package End>>>>>>>>>>>>>>>>>>>>>>>>>>>>>


			if ($existing_subscription) {
				$this->request->data['Posting_type'] = 'Recruiter Paid Package';
				// skip 
			} else if ($user_role_id == TALANT_ROLEID) {
				$feature_info['number_of_job_post_used'] = $packfeature['number_of_job_post_used'] + 1;
			} elseif ($user_role_id == NONTALANT_ROLEID) {
				$feature_info['non_telent_number_of_job_post_used'] = $packfeature['non_telent_number_of_job_post_used'] + 1;
			} else {
				$this->Flash->error($jobposterror);
				return $this->redirect(['action' => 'jobpost']);
			}

			// // end the code 
			if (!empty($this->request->data['image']['name'])) {
				unlink("job/{$profile['image']}");
				$filename = $this->request->data['image']['name'];
				$name = md5(time() . $filename);
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$imagename = $name . '.' . $ext;
				$dest = "job/";
				$newfile = $dest . $imagename;
				if (move_uploaded_file($this->request->data['image']['tmp_name'], $newfile)) {
					$this->request->data['image'] = $imagename;
				} else {
					$this->request->data['image'] =	 $profile['profile_image'];
				}
			} else {
				// If job_id exists, clone the old image
				if ($job_id && !empty($details['image'])) {
					$oldFile = "job/" . $details['image'];

					if (file_exists($oldFile)) {
						// Generate a new cloned image name
						$newCloneName = md5(time() . $details['image']) . '.' . pathinfo($details['image'], PATHINFO_EXTENSION);
						$newClonePath = "job/" . $newCloneName;

						// pr($newClonePath);exit;
						// Copy the old image to a new file
						if (copy($oldFile, $newClonePath)) {
							$this->request->data['image'] = $newCloneName; // Set cloned image name
						} else {
							$this->request->data['image'] = $details['image']; // Fallback to old image if copy fails
						}
					} else {
						// pr('else');exit;
						$this->request->data['image'] = $details['image']; // If old image doesn't exist, keep original name
					}
				}
			}

			$dateFields = [
				'event_from_date',
				'event_to_date',
				'last_date_app',
				'talent_required_fromdate',
				'talent_required_todate'
			];
			
			foreach ($dateFields as $field) {
				if (!empty($this->request->data[$field])) {
					$this->request->data[$field] = date('Y-m-d H:i', strtotime($this->request->data[$field]));
				} else {
					$this->request->data[$field] = null;
				}
			}
			

			$this->request->data['talent_requirement'] = $packfeature['requirement_package_jobs'];

			if ($user_role_id == TALANT_ROLEID) {
				$feature_info['number_of_job_post_used'] = $packfeature['number_of_job_post_used'] + 1;
				$this->request->data['askquotedata'] = $packfeature['ask_for_quote_request_per_job'];
				$this->request->data['askquoteactualdata'] = $packfeature['ask_for_quote_request_per_job'];
				$this->request->data['booknowdata'] = $packfeature['number_of_booking'];
			} elseif ($user_role_id == NONTALANT_ROLEID) {
				$feature_info['non_telent_number_of_job_post_used'] = $packfeature['non_telent_number_of_job_post_used'] + 1;
				$this->request->data['askquotedata'] = $packfeature['non_telent_ask_quote'];
				$this->request->data['askquoteactualdata'] = $packfeature['non_telent_ask_quote'];
				$this->request->data['booknowdata'] = $packfeature['number_of_booking'];
			}


			$this->request->data['package_id'] = $packfeature_id;
			$this->request->data['user_role_id'] = $user_role_id;


			// pr($this->request->data);
			// exit;
			if ($existing_subscription) {
				$this->request->data['package_id'] = $existing_subscription['subscription']['id'];
				$this->request->data['is_paid_post'] = 'Y';
				$this->request->data['jobpost_time_profile_pack_id'] = $activePack[0]['package_id'];
				$this->request->data['jobpost_time_req_pack_id'] = $existing_subscription['subscription']['package_id'];
			} else {
				$this->request->data['jobpost_time_profile_pack_id'] = $activePack[0]['package_id'];
				$this->request->data['jobpost_time_rec_pack_id'] = $activePack[1]['package_id'];
				$this->request->data['Posting_type'] = $packfeature['package_status'];
			}


			$requirementsave = $this->Requirement->patchEntity($requi, $this->request->data);
			$requirementdatasave = $this->Requirement->save($requirementsave);
			$requirementlastid = $requirementdatasave->id;
			// pr($requirementdatasave);exit;
			$this->sendnotification($requirementlastid);
			// Decreasing the values from limit
			$skillcount = count($this->request->data['data']['requirementskills']);
			$prop_data = array();
			// $skillcountevent = explode(",", $this->request->data['data']['talent_requirement'][0]);
			$skillcountevent = explode(",", $this->request->data['data']['telent_type'][0]);

			for ($i = 0; $i < $skillcount; $i++) {
				$contentadminskill = $this->RequirmentVacancy->newEntity();
				// $prop_data['talent_requirement'] = $skillcountevent[$i];
				$prop_data['user_id'] = $id;
				$prop_data['requirement_id'] = $requirementlastid;
				$prop_data['telent_type'] = $skillcountevent[$i];
				$prop_data['number_of_vacancy'] = $this->request->data['data']['number_of_vacancy'][$i];
				$prop_data['sex'] = $this->request->data['data']['sex'][$i];
				$prop_data['payment_freq'] = $this->request->data['data']['payment_freq'][$i];
				$prop_data['payment_currency'] = $this->request->data['data']['payment_currency'][$i];
				$prop_data['payment_amount'] = $this->request->data['data']['payment_amount'][$i];
				$contentadminskillsave = $this->RequirmentVacancy->patchEntity($contentadminskill, $prop_data);
				$skilldata = $this->RequirmentVacancy->save($contentadminskillsave);
			}

			if ($skilldata) {
				$questioncount = count($this->request->data['questions']['name']);
				$question_data = array();
				for ($i = 0; $i < $questioncount; $i++) {
					if ($this->request->data['questions']['name'][$i] != '') {
						$contentquestion = $this->Jobquestion->newEntity();
						$question_data['question_title'] = $this->request->data['questions']['name'][$i];
						$question_data['option_type'] = $this->request->data['questions']['optiontype'][$i];
						$question_data['job_id'] = $requirementlastid;
						$contentquestionsave = $this->Jobquestion->patchEntity($contentquestion, $question_data);
						$jbques = $this->Jobquestion->save($contentquestionsave);
						$q_last_id = $jbques->id;
						$answercount = 4;
						$answer_data = array();
						for ($p = 0; $p < $answercount; $p++) {
							if ($this->request->data['questions']['answer'][$p][$i] != '') {
								$contentanswer = $this->Job_answer->newEntity();
								$answer_data['question_id'] = $q_last_id;
								$answer_data['answervalue'] = $this->request->data['questions']['answer'][$p][$i];
								$contentanswersave = $this->Job_answer->patchEntity($contentanswer, $answer_data);
								$jbques = $this->Job_answer->save($contentanswersave);

								// $pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status'=>'Y','Profilepack.id'=>$package_id])->order(['Profilepack.id' => 'ASC'])->first();
							}
						}
					}
				}

				// this function for add notification 
				// $type = "Requirement";
				// $this->notification($id,$type,$requirementdatasave['id']);

				if ($feature_info) {
					$packfeature = $this->Packfeature->get($packfeature_id);
					$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
					$this->Packfeature->save($features_arr);
				}

				// update is_used = Y if purches any requirement package 
				if ($existing_subscription) {
					$subscriptions = $this->Subscription->get($existing_subscription['subscription']['id']);
					$subscriptions->is_used = 'Y';
					$saved = $this->Subscription->save($subscriptions);
				}

				// pr($packfeature);
				// exit;
				$this->Flash->success(__('Your Requirement Has Been Posted Successfully.'));
				return $this->redirect('/requirement/suggestedprofile/' . $requirementlastid);
			}
		}
	}


	public function jobpostv1($job_id = null)
	{
		$this->loadModel('Skill');
		$this->loadModel('Currency');
		$this->loadModel('Requirement');
		$this->loadModel('RequirmentVacancy');
		$this->loadModel('Questionmare_options_type');
		$this->loadModel('Jobquestion');
		$this->loadModel('Job_answer');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Enthicity');
		$this->loadModel('Paymentfequency');
		$this->loadModel('Packfeature');
		$this->loadModel('Eventtype');
		$this->loadModel('Settings');
		$this->loadModel('Subscription');
		$this->loadModel('Transcation');
		$this->loadModel('Profilepack');
		$this->loadModel('RecuriterPack');
		$this->loadModel('RequirementPack');

		$id = $this->request->session()->read('Auth.User.id');
		$user_role_id = $this->request->session()->read('Auth.User.role_id');
		// pr($user_role_id);exit;
		// $requirecount = $this->Requirement->find('all')->where(['Requirement.user_id' => $id, 'Requirement.status' => 'Y'])->count();

		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();

		// $settingManager = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();
		$packfeature = $this->activePackage('RC'); // if purches any recuruter packages else default package limit comes 
		// pr($packfeature);exit;
		$daily_limit = $packfeature['number_of_job_simultancney'];
		$totalUsedLimit = 0;
		if ($user_role_id == NONTALANT_ROLEID) {
			$totalLimitJobPost = $packfeature['non_telent_number_of_job_post'];
			$totalUsedLimit = $packfeature['non_telent_number_of_job_post_used'];
		} else {
			$totalLimitJobPost = $packfeature['number_of_job_post'];
			$totalUsedLimit = $packfeature['number_of_job_post_used'];
		}
		// pr($packfeature);
		// exit;
		$currentdate = date('Y-m-d H:m:s');

		// $requirecount = $this->Requirement->find('all')
		// 	->where([
		// 		'user_id' => $id,
		// 		'package_id' => $packfeature['id'],
		// 		'user_role_id' => $user_role_id,
		// 		'status' => 'Y',
		// 		'is_paid_post' => 'N',
		// 		'DATE(created)' => date('Y-m-d')
		// 	])
		// 	->count();

		$requirecount = $this->Requirement->find('all')
			->where([
				'Requirement.user_id' => $id,
				'DATE(Requirement.last_date_app) >=' => $currentdate,
				'status' => 'Y'
			])
			->count();

		$existing_subscription = $this->Transcation->find('all')
			->contain(['Subscription'])
			->where([
				'Subscription.user_id' => $id,
				'Subscription.package_type' => 'RE',
				'Subscription.is_used' => 'N',
			])
			->select(['Subscription.id', 'Subscription.package_id', 'Transcation.number_of_days', 'Transcation.number_of_talent_type', 'Transcation.post_priorites'])
			->first();

		$this->set('existing_subscription', $existing_subscription);
		$this->set('packfeature', $packfeature);
		// pr($existing_subscription);exit;
		// pr($existing_subscription);exit;
		// pr($totalLimitJobPost);
		// pr($totalUsedLimit);
		// pr($packfeature);
		// exit;

		if (empty($existing_subscription)) {
			// Validation checks for job posting limits
			if ($totalLimitJobPost <= $totalUsedLimit) {
				return $this->redirect('/package/jobposting');
			}

			if ($user_role_id == TALANT_ROLEID && $requirecount >= $daily_limit) {
				$this->Flash->error(__(
					'You have reached your daily job posting limit of {0}. Jobs posted today: {1}. Please try again tomorrow or upgrade your package.',
					$daily_limit,
					$requirecount
				));
				return $this->redirect($this->referer());
			}
		}

		$jobpost_e = $this->jobpostability();
		$packfeature_id = $packfeature['id'];
		$jobposterror = "You do not have any Package for Posting this job Please purchase Recruiter or Requirement Package for posting job";
		//pr($this->request->session()->read('posttype'));
		$payfreq = $this->Paymentfequency->find('list')->toarray();
		$this->set('payfreq', $payfreq);

		$eventtype = $this->Eventtype->find('all')->toarray();

		$this->set('eventtype', $eventtype);

		$requirement = $this->Requirement->find('all')->where(['Requirement.id' => $job_id])->first();
		// pr($requirement);exit;
		$this->set('requirement', $requirement);

		$jobquestion = $this->Jobquestion->find('all')->where(['Jobquestion.job_id' => $job_id])->toarray();
		$this->set('jobquestion', $jobquestion);

		$details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City', 'Users', 'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']])->where(['Requirement.id' => $job_id])->first();
		$this->set('requirement_data', $details);

		$requirementvacancy = $this->RequirmentVacancy->find('all')->where(['RequirmentVacancy.requirement_id' => $job_id])->toarray();
		$this->set('requirementvacancy', $requirementvacancy);

		$this->set('job_id', $job_id);
		//pr($this->request->data); die;

		$requi = $this->Requirement->newEntity();
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'State', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);
		$Currency = $this->Currency->find('all')
			->select(['id', 'name', 'currencycode', 'symbol'])
			->order(['name' => 'ASC', 'id' => 'ASC'])
			->all()
			->combine(
				'id',
				function ($row) {
					return $row->name . ' (' . $row->currencycode . ' - ' . $row->symbol . ')';
				}
			)
			->toArray();
		$this->set('Currency', $Currency);
		$symbol = $this->Currency->find('list', ['keyField' => 'id', 'valueField' => 'symbol'])->order(['name' => 'ASC'])->toarray();
		$this->set('symbol', $symbol);
		$country = $this->Country->find('list')->select(['id', 'name'])->order(['name' => 'ASC'])->toarray();
		$this->set('country', $country);
		$Skill = $this->Skill->find('all')->select(['id', 'name'])->order(['name' => 'ASC'])->toarray();
		$this->set('Skill', $Skill);

		$cities = $this->City->find('list')->where(['City.state_id' => $details['state_id']])->order(['name' => 'ASC'])->toarray();
		$this->set('cities', $cities);
		$states = $this->State->find('list')->where(['State.country_id' => $details['country_id']])->toarray();
		$this->set('states', $states);
		$questionnare = $this->Questionmare_options_type->find('list')->toarray();
		$this->set('questionnare', $questionnare);


		if ($this->request->is(['post', 'put'])) {
			$this->request->data['user_id'] = $id; // do not remove this Rupam
			// pr($this->request->data);
			// exit;

			// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<Active Package Start>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			$currentdate = date('Y-m-d');
			$user_id = $this->request->session()->read('Auth.User.id');
			// Fetch subscriptions, excluding PR & RC packages with package_id = 1
			$subscriptions = $this->Subscription->find()
				->where([
					'Subscription.user_id' => $user_id,
					'Subscription.package_id !=' => 1 // Exclude default package first
				])
				->order(['Subscription.id' => 'DESC']) // Get latest first
				->toArray();

			$currentPackages = ['PR' => null, 'RC' => null, 'RE' => null];
			foreach ($subscriptions as $subscription) {
				$packageType = $subscription['package_type'];
				$package = null;

				if ($packageType === 'PR') {
					// Profilepack ke liye
					$package = $this->Profilepack->find('all')
						->where(['id' => $subscription['package_id']])
						->first();

					if ($package && !$currentPackages['PR'] && strtotime($subscription['expiry_date']) >= strtotime($currentdate)) {
						$currentPackages['PR'] = [
							'package_type' => 'PR',
							'package_id' => $subscription['package_id'],
							'package_name' => $package->name,
							'expiry_date' => $subscription['expiry_date']->format('Y-m-d H:i:s')
						];
					}
				} elseif ($packageType === 'RC') {
					// RecruiterPack ke liye
					$package = $this->RecuriterPack->find('all')
						->where(['id' => $subscription['package_id']])
						->first();

					if ($package && !$currentPackages['RC'] && strtotime($subscription['expiry_date']) >= strtotime($currentdate)) {
						$currentPackages['RC'] = [
							'package_type' => 'RC',
							'package_id' => $subscription['package_id'],
							'package_name' => $package->name, // 🔹 FIX: 'title' ke jagah 'name' use karein
							'expiry_date' => $subscription['expiry_date']->format('Y-m-d H:i:s')
						];
					}
				} elseif ($packageType === 'RE') {
					// RE type ke liye (expiry check nahi karna)
					$package = $this->RequirementPack->find('all')
						->where(['id' => $subscription['package_id']])
						->first();
					if ($package && !$currentPackages['RE']) {
						$currentPackages['RE'] = [
							'package_type' => 'RE',
							'package_id' => $subscription['package_id'],
							'package_name' => $package->name,
							'expiry_date' => null // RE ke liye expiry_date nahi hoti
						];
					}
				}
			}
			// pr($currentPackages);exit;

			// If no valid package was found, fetch the default (package_id = 1)
			foreach (['PR', 'RC', 'RE'] as $type) {
				if (!$currentPackages[$type]) {
					$defaultSubscription = $this->Subscription->find()
						->where([
							'Subscription.user_id' => $user_id,
							'Subscription.package_type' => $type,
							'Subscription.package_id' => 1 // Default package
						])
						->first();

					$defaultPackage = $this->{$type === 'PR' ? 'Profilepack' : 'RecuriterPack'}->find()
						->where(['id' => 1])
						->first();

					$currentPackages[$type] = [
						'package_type' => $type,
						'package_id' => $defaultSubscription ? $defaultSubscription->package_id : 1,
						'package_name' => $defaultPackage ? $defaultPackage->name : 'Default',
						'expiry_date' => $defaultSubscription ? $defaultSubscription->expiry_date->format('Y-m-d H:i:s') : 'N/A'
					];
				}
			}
			$activePack = array_values($currentPackages);
			// pr($activePack);exit;
			// pr($existing_subscription['subscription']['package_id']);
			// exit;
			// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<Active Package End>>>>>>>>>>>>>>>>>>>>>>>>>>>>>


			$subscriptions = $this->Subscription->find('all')->where(['user_id' => $id, 'package_type' => 'RC'])->first();

			if ($existing_subscription) {
				$this->request->data['Posting_type'] = 'Recruiter Paid Package';
				// skip 
			} else if ($jobpost_e['status'] == 'RC' && $this->request->session()->read('Auth.User.role_id') == TALANT_ROLEID) {
				$feature_info['number_of_job_post_used'] = $jobpost_e['number_of_job_post_used'] + 1;
			} elseif ($jobpost_e['status'] == 'NT' && $this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
				$feature_info['non_telent_number_of_job_post_used'] = $jobpost_e['non_telent_number_of_job_post_used'] + 1;
			} else if ($jobpost_e['status'] == 'RC' && $subscriptions['package_id'] == 1) {
				$feature_info['number_of_job_post_used'] = $jobpost_e['number_of_job_post_used'] + 1;
			} elseif ($jobpost_e['status'] == 'NT' && $subscriptions['package_id'] == 1) {
				$feature_info['non_telent_number_of_job_post_used'] = $jobpost_e['non_telent_number_of_job_post_used'] + 1;
			} else {
				$this->Flash->error($jobposterror);
				return $this->redirect(['action' => 'jobpost']);
			}

			// end the code 
			if (!empty($this->request->data['image']['name'])) {
				unlink("job/{$profile['image']}");
				$filename = $this->request->data['image']['name'];
				$name = md5(time() . $filename);
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$imagename = $name . '.' . $ext;
				$dest = "job/";
				$newfile = $dest . $imagename;
				if (move_uploaded_file($this->request->data['image']['tmp_name'], $newfile)) {
					$this->request->data['image'] = $imagename;
				} else {
					$this->request->data['image'] =	 $profile['profile_image'];
				}
			} else {
				// If job_id exists, clone the old image
				if ($job_id && !empty($details['image'])) {
					$oldFile = "job/" . $details['image'];

					if (file_exists($oldFile)) {
						// Generate a new cloned image name
						$newCloneName = md5(time() . $details['image']) . '.' . pathinfo($details['image'], PATHINFO_EXTENSION);
						$newClonePath = "job/" . $newCloneName;

						// pr($newClonePath);exit;
						// Copy the old image to a new file
						if (copy($oldFile, $newClonePath)) {
							$this->request->data['image'] = $newCloneName; // Set cloned image name
						} else {
							$this->request->data['image'] = $details['image']; // Fallback to old image if copy fails
						}
					} else {
						// pr('else');exit;
						$this->request->data['image'] = $details['image']; // If old image doesn't exist, keep original name
					}
				}
			}

			// pr($this->request->data);exit;

			$this->request->data['event_from_date'] = date('Y-m-d H:i', strtotime($this->request->data['event_from_date']));
			$this->request->data['event_to_date'] = date('Y-m-d H:i', strtotime($this->request->data['event_to_date']));
			$this->request->data['last_date_app'] = date('Y-m-d H:i', strtotime($this->request->data['last_date_app']));
			$this->request->data['talent_required_fromdate'] = date('Y-m-d H:i', strtotime($this->request->data['talent_required_fromdate']));
			$this->request->data['talent_required_todate'] = date('Y-m-d H:i', strtotime($this->request->data['talent_required_todate']));
			// pr($this->request->data);exit;

			$this->request->data['talent_requirement'] = $jobpost_e['talent_requiremnt_request_job'];
			$this->request->data['askquotedata'] = $jobpost_e['askquote_request_job'];
			$this->request->data['askquoteactualdata'] = $jobpost_e['askquote_request_job'];

			$this->request->data['askquotedata'] = $jobpost_e['askquote_request_job'];
			$this->request->data['askquoteactualdata'] = $jobpost_e['askquote_request_job'];
			$this->request->data['booknowdata'] = $jobpost_e['number_of_booking'];


			$this->request->data['package_id'] = $packfeature_id;
			$this->request->data['user_role_id'] = $user_role_id;

			if ($existing_subscription) {
				$this->request->data['package_id'] = $existing_subscription['subscription']['id'];
				$this->request->data['is_paid_post'] = 'Y';
				$this->request->data['jobpost_time_profile_pack_id'] = $activePack[0]['package_id'];
				$this->request->data['jobpost_time_req_pack_id'] = $existing_subscription['subscription']['package_id'];
			} else {
				$this->request->data['jobpost_time_profile_pack_id'] = $activePack[0]['package_id'];
				$this->request->data['jobpost_time_rec_pack_id'] = $activePack[1]['package_id'];
				$this->request->data['Posting_type'] = $packfeature['package_status'];
			}



			$requirementsave = $this->Requirement->patchEntity($requi, $this->request->data);
			$requirementdatasave = $this->Requirement->save($requirementsave);
			$requirementlastid = $requirementdatasave->id;
			// pr($requirementdatasave);exit;
			$this->sendnotification($requirementlastid);
			// Decreasing the values from limit
			//echo $packfeature_id;die;
			$skillcount = count($this->request->data['data']['requirementskills']);
			$prop_data = array();
			// $skillcountevent = explode(",", $this->request->data['data']['talent_requirement'][0]);
			$skillcountevent = explode(",", $this->request->data['data']['telent_type'][0]);

			for ($i = 0; $i < $skillcount; $i++) {
				$contentadminskill = $this->RequirmentVacancy->newEntity();
				$prop_data['user_id'] = $id;
				$prop_data['requirement_id'] = $requirementlastid;
				$prop_data['telent_type'] = $skillcountevent[$i];
				// $prop_data['talent_requirement'] = $skillcountevent[$i];
				$prop_data['number_of_vacancy'] = $this->request->data['data']['number_of_vacancy'][$i];
				$prop_data['sex'] = $this->request->data['data']['sex'][$i];
				$prop_data['payment_freq'] = $this->request->data['data']['payment_freq'][$i];
				$prop_data['payment_currency'] = $this->request->data['data']['payment_currency'][$i];
				$prop_data['payment_amount'] = $this->request->data['data']['payment_amount'][$i];
				$contentadminskillsave = $this->RequirmentVacancy->patchEntity($contentadminskill, $prop_data);
				$skilldata = $this->RequirmentVacancy->save($contentadminskillsave);
			}

			if ($skilldata) {
				$questioncount = count($this->request->data['questions']['name']);
				$question_data = array();
				for ($i = 0; $i < $questioncount; $i++) {
					if ($this->request->data['questions']['name'][$i] != '') {
						$contentquestion = $this->Jobquestion->newEntity();
						$question_data['question_title'] = $this->request->data['questions']['name'][$i];
						$question_data['option_type'] = $this->request->data['questions']['optiontype'][$i];
						$question_data['job_id'] = $requirementlastid;
						$contentquestionsave = $this->Jobquestion->patchEntity($contentquestion, $question_data);
						$jbques = $this->Jobquestion->save($contentquestionsave);
						$q_last_id = $jbques->id;
						$answercount = 4;
						$answer_data = array();
						for ($p = 0; $p < $answercount; $p++) {
							if ($this->request->data['questions']['answer'][$p][$i] != '') {
								$contentanswer = $this->Job_answer->newEntity();
								$answer_data['question_id'] = $q_last_id;
								$answer_data['answervalue'] = $this->request->data['questions']['answer'][$p][$i];
								$contentanswersave = $this->Job_answer->patchEntity($contentanswer, $answer_data);
								$jbques = $this->Job_answer->save($contentanswersave);

								// $pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status'=>'Y','Profilepack.id'=>$package_id])->order(['Profilepack.id' => 'ASC'])->first();
							}
						}
					}
				}

				// this function for add notification 
				// $type = "Requirement";
				// $this->notification($id,$type,$requirementdatasave['id']);

				if ($feature_info) {
					$packfeature = $this->Packfeature->get($packfeature_id);
					$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
					$this->Packfeature->save($features_arr);
				}

				// update is_used = Y if purches any requirement package 
				if ($existing_subscription) {
					$subscriptions = $this->Subscription->get($existing_subscription['subscription']['id']);
					$subscriptions->is_used = 'Y';
					$saved = $this->Subscription->save($subscriptions);
				}

				$this->Flash->success(__('Your Requirement Has Been Posted Successfully.'));
				return $this->redirect('/requirement/suggestedprofile/' . $requirementlastid);
			}
		}
	}

	// Check redirection on job posting. 
	function checkredirection()
	{
		$user_role = $this->request->session()->read('Auth.User.role_id');
		$user_id = $this->request->session()->read('Auth.User.id');
		$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'DESC'])->first();
		$status['id'] = $packfeature['id'];
		// echo $this->request->session()->read('eligible.jobpost'); die;
		if ($this->request->session()->read('eligible.jobpost') == 0) {

			if ($user_role == TALANT_ROLEID) {

				if ($packfeature['number_of_job_post'] > 0) {
					$this->loadModel('Subscription');
					$subscriptiondata = $this->Subscription->find('all')
						->where(['Subscription.user_id' => $user_id, 'Subscription.package_type' => 'RC'])
						->order(['Subscription.id' => 'DESC'])
						->first();
					if ($subscriptiondata['package_id'] == RECUITER_PACKAGE) {
						$eligible['jobpostcredit'] = 1;
						$eligible['clone_id'] = $this->request->session()->read('eligible.clone_id');
						$this->request->session()->write('eligible', $eligible);
						$redirect_url = '/package/jobposting';
						return $this->redirect($redirect_url);
					} else {
						return true;
					}
				} else {
					$redirect_url = '/package/jobposting/N';
					return $this->redirect($redirect_url);
				}
			} else if ($packfeature['non_telent_number_of_job_post'] > 0) {
				// echo "test"; die;
				$this->loadModel('Subscription');
				$subscriptiondata = $this->Subscription->find('all')->where(['Subscription.user_id' => $user_id, 'Subscription.package_type' => 'RC'])->order(['id' => 'desc'])->first();
				//pr($subscriptiondata);die;
				if ($subscriptiondata['package_id'] == RECUITER_PACKAGE) {
					$eligible['jobpostcredit'] = 1;
					$eligible['clone_id'] = $this->request->session()->read('eligible.clone_id');
					$this->request->session()->write('eligible', $eligible);
					$redirect_url = '/package/jobposting';
					return $this->redirect($redirect_url);
				} else {
					$eligible['jobpostcredit'] = 1;
					$eligible['clone_id'] = $this->request->session()->read('eligible.clone_id');
					$this->request->session()->write('eligible', $eligible);
					$redirect_url = '/package/jobposting/N';
					return $this->redirect($redirect_url);
				}
				//$redirect_url = '/jobpost/';
			} else {
				$redirect_url = '/package/jobposting/N';
				return $this->redirect($redirect_url);
			}
		}
	}

	function notification_sent($recieverId, $messageType, $message)
	{
		$this->autoRender = false;
		$this->loadModel('Notification');
		$id = $this->request->session()->read('Auth.User.id');
		$notification['notification_sender'] = $id;
		$notification['notification_receiver'] = $recieverId;
		$notification['type'] = $messageType;
		$notification['content'] = $message;
		$noti = $this->Notification->newEntity();
		$articles = $this->Notification->patchEntity($noti, $notification);
		$save = $this->Notification->save($articles);
		return true;
	}

	function sendnotification($jobid)
	{
		$this->autoRender = false;
		$this->loadModel('Contactrequest');
		$this->loadModel('Notification');
		$id = $this->request->session()->read('Auth.User.id');
		if (!empty($jobid)) {
			$bduser = $this->Contactrequest->find('all')->where(['OR' => ['from_id' => $id, 'to_id' => $id], 'accepted_status' => 'Y'])->toarray();
			//send like notification  
			foreach ($bduser as $notidata) {
				$noti = $this->Notification->newEntity();
				if ($notidata['from_id'] == $id) {
					$recieverid = $notidata['to_id'];
				} else {
					$recieverid = $notidata['from_id'];
				}
				$senderid = $id;

				$notification['notification_sender'] = $senderid;
				$notification['notification_receiver'] = $recieverid;
				$notification['type'] = "job post";
				$notification['content'] = $jobid;
				//$notimultiple[]=$notification;

				$articles = $this->Notification->patchEntity($noti, $notification);
				$save = $this->Notification->save($articles);
			}
			// $articles = TableRegistry::get('Notification');
			// $entities = $articles->newEntities($notimultiple);

			// foreach ($entities as $entity) {
			//     // Save entity
			//     $articles->save($entity);
			// }
			//die;

		}
		return true;
	}


	public function booknow($userid = '', $action = '')
	{
		$this->set('action', $action);
		$this->set('userid', $userid);
		$this->loadModel('Packfeature');
		$id = $this->request->session()->read('Auth.User.id');

		$packlimit = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $this->request->session()->read('Auth.User.id')])->first();
		$numberofaskquoteperjob = $packlimit['ask_for_quote_request_per_job'];

		$this->loadModel('Requirement');
		$this->loadModel('JobQuote');
		$currentdate = date('Y-m-d H:m:s');
		// $activejobs = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency']])->where(['user_id' => $id])->toarray();
		$activejobs = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency']])->where(['user_id' => $id, 'Requirement.last_date_app >=' => $currentdate, 'Requirement.status' => 'Y'])->toarray();
		// pr($activejobs);exit;
		$this->set('activejobs', $activejobs);
		$this->set('numberofaskquoteperjob', $numberofaskquoteperjob);
	}

	public function book($userid = '', $action = '')
	{
		// echo "test"; die;
		$this->set('action', $action);
		$this->set('userid', $userid);
		$id = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Requirement');
		$this->loadModel('JobApplication');
		$this->loadModel('Packfeature');
		$currentdate = date('Y-m-d H:m:s');

		$packlimit = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $this->request->session()->read('Auth.User.id')])->first();
		$this->set('packlimit', $packlimit);
		//$packlimit['number_of_booking'] = 0;


		// $activejobs = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency']])->where(['user_id' => $id])->toarray();
		$activejobs = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency']])->where(['user_id' => $id, 'Requirement.last_date_app >=' => $currentdate, 'Requirement.status' => 'Y'])->toarray();
		$this->set('activejobs', $activejobs);
		$bookjob = $this->JobApplication->find('all')->where(['user_id' => $userid])->toarray();
		$this->set('bookjob', $bookjob);
	}


	// this fucntion for save multiple ask quote 
	public function mutipleaskQuote($invited = null)
	{
		unset($_SESSION['askquoteinvitealreadyask']);
		unset($_SESSION['askquoteinvite']);

		$this->autoRender = false;
		$this->loadModel('Requirement');
		$this->loadModel('JobQuote');
		$nontalentuser_id = $this->request->session()->read('Auth.User.id');
		if ($this->request->is(['post', 'put'])) {
			// pr($this->request->data); exit;

			$this->request->data['user_id'];
			$profilecount	= explode(",", $this->request->data['user_id']);
			$user_id = $this->request->data['user_id'];
			count($this->request->data['job_id']);

			$askquoteavb = $this->askquotechecked($this->request->data['job_id'], $this->request->data['user_id']);

			for ($i = 0; $i < count($profilecount); $i++) {
				$profilecountarray	= explode(",", $this->request->data['user_id']);
				foreach ($this->request->data['job_id'] as $key => $value) {
					if ($this->request->data['job_id'][$key][0] != '') {
						$details = $this->Requirement->find('all')->where(['Requirement.id' => $key])->first();
						if ($details['askquoteactualdata'] >= count($profilecount)) {
							$access = 1;
						} else {
							$access = 0;
						}

						if ($access == 1) {
							$jobidcount = $this->JobQuote->find('all')->where(['JobQuote.job_id' => $key, 'JobQuote.user_id' => $profilecountarray[$i]])->count();

							if ($jobidcount <= 0) {
								if ($details['askquotedata'] > 0) {
									$JobQuote = $this->JobQuote->newEntity();
									$user_id = $this->request->data['user_id'];
									$user_Datacheck['status'] = $id;
									$user_Datacheck['user_id'] = $profilecountarray[$i];
									$user_Datacheck['job_id'] = $key;
									$user_Datacheck['nontalentuser_id'] = $nontalentuser_id;
									$user_Datacheck['skill_id'] = $value[0];
									$usersavedata = $this->JobQuote->patchEntity($JobQuote, $user_Datacheck);
									$jbques = $this->JobQuote->save($usersavedata);
									$Package = $this->Requirement->get($key);
									$askdata = $details['askquotedata'] - count($profilecountarray[$i]);
									$Package->askquotedata	= $askdata;
									$this->Requirement->save($Package);
								}
							} else {
								$refernamealreadyask = $key;
								$invitedalreadyask[] = $refernamealreadyask;
								$session = $this->request->session();
								$session->write('askquoteinvitealreadyask', $invitedalreadyask);
							}
						} else {
							$this->Flash->error(__('The following profiles have already been uploaded'), ['key' => 'job_fail']);
						}
					} else {
					}
				}
			}

			//message for ask quote already
			if ($_SESSION['askquoteinvitealreadyask']) {

				$n = 0;
				foreach ($_SESSION['askquoteinvitealreadyask'] as $key => $value) {
					$profilecountarray	= explode(",", $_SESSION['jobselectedprofile']['profile']);
					$jobdetailalready = $this->JobQuote->find('all')->contain(['Users' => ['Profile', 'Professinal_info'], 'Skill', 'Requirement'])->where(['JobQuote.job_id' => $value, 'JobQuote.user_id' => $profilecountarray[$n]])->first();
					$this->Flash->error(__('You have asked for quote from ' . $jobdetailalready['user']['profile']['name'] . ' for ' . $jobdetailalready['requirement']['title'] . ' on ' . date('Y-m-d h:m A', strtotime($jobdetailalready['created']))));

					$n++;
				}
			}


			$x = 0;
			foreach ($this->request->data['job_id'] as $key => $value) {
				if ($this->request->data['job_id'][$key][0] != '') {
					$profilecount	= explode(",", $this->request->data['user_id']);
					$jobidcountnew = $this->JobQuote->find('all')->where(['JobQuote.job_id' => $key])->toarray();
					$actauldatasakqquotereomve = $jobidcountnew[0]['job_id'];
					$actauldatasakqquotereomveddd[$actauldatasakqquotereomve] = count($jobidcountnew);
					$session = $this->request->session();
					$session->write('actauldatasakqquotereomvess', $actauldatasakqquotereomveddd);



					if ($jobidcountnew <= 0 || $_SESSION['askquoteinvite']) {
						$details = $this->Requirement->find('all')->where(['Requirement.id' => $key])->first();
						if ($details['askquoteactualdata'] >= count($profilecount)) {
							$Package = $this->Requirement->get($key);
							$askdata = $details['askquoteactualdata'] - count($_SESSION['askquoteinvite']);
							$Package->askquoteactualdata	= $askdata;
							$Package->askquotedata	= $askdata;
							$this->Requirement->save($Package);
						} else {
							//$access = '0';
						}
					}
				}
				$x++;
			}

			if ($_SESSION['askquoteinvite']) {
				$this->Flash->success(__('Quote Request  Sent Successfully'));
				unset($_SESSION['askquoteinvite']);
			} else {
				$this->Flash->error(__('Quote Request Cannot be Initiated'));
			}
			return $this->redirect(SITE_URL . '/viewprofile/' . $user_id);
			//die;
		}
	}

	public function askquotechecked($job_id, $user_idcount)
	{
		$this->loadModel('Requirement');
		$this->loadModel('JobQuote');
		$profilecount	= explode(",", $user_idcount);
		for ($i = 0; $i < count($profilecount); $i++) {
			foreach ($job_id as $key => $value) {
				if ($job_id[$key][0] != '') {
					$details = $this->Requirement->find('all')->where(['Requirement.id' => $key])->first();
					$jobidcount = $this->JobQuote->find('all')->where(['JobQuote.job_id' => $key, 'JobQuote.user_id' => $profilecount[$i]])->count();
					if (count($profilecount) <= $details['askquotedata'] &&  $jobidcount <= 0) {

						$invited[] = $key;
						$session = $this->request->session();
						$session->write('askquoteinvite', $invited);
					} else {
						$refernamess = $key;
						$invitedss[$refernamess] = $value[0];
						$session = $this->request->session();
						$session->write('askquotenotinvite', $invitedss);
					}
				}
			}
		}
		$invitedsssss['profile'] = $user_idcount;
		$session = $this->request->session();
		$session->write('jobselectedprofile', $invitedsssss);
	}

	public function askquoterpeat()
	{
		$this->autoRender = false;
		$this->loadModel('Requirement');
		$this->loadModel('JobQuote');
		$nontalentuser_id = $this->request->session()->read('Auth.User.id');
		$profilecount	= explode(",", $this->request->data['jobselectedprofile']);
		//	pr($this->request->data); die;

		for ($i = 0; $i < count($profilecount); $i++) {
			$profilecountarray	= explode(",", $this->request->data['jobselectedprofile']);
			foreach ($this->request->data['job_idss'] as $key => $value) {
				$jobidcount = $this->JobQuote->find('all')->where(['JobQuote.job_id' => $key, 'JobQuote.user_id' => $profilecountarray[$i]])->count();
				if ($jobidcount <= 0) {
					if ($this->request->data['job_idss'][$key][0] != '') {
						$details = $this->Requirement->find('all')->where(['Requirement.id' => $key])->first();
						if ($details['askquotedata'] > 0) {
							$JobQuote = $this->JobQuote->newEntity();
							$user_id = $this->request->data['user_id'];
							$user_Datacheck['status'] = $id;
							$user_Datacheck['user_id'] = $profilecountarray[$i];
							$user_Datacheck['job_id'] = $key;
							$user_Datacheck['nontalentuser_id'] = $nontalentuser_id;
							$user_Datacheck['skill_id'] = $value[0];
							$usersavedata = $this->JobQuote->patchEntity($JobQuote, $user_Datacheck);
							$jbques = $this->JobQuote->save($usersavedata);
							$Package = $this->Requirement->get($key);
							$askdata = $details['askquotedata'] - count($profilecountarray[$i]);
							$askdatasss = $details['askquoteactualdata'] - count($profilecountarray[$i]);
							$Package->askquoteactualdata	= $askdatasss;
							$Package->askquotedata	= $askdata;
							$this->Requirement->save($Package);
						}
					}
				} else {
					$refernamealreadyask = $key;
					$invitedalreadyask[] = $refernamealreadyask;
					$session = $this->request->session();
					$session->write('askquoteinvitealreadyask', $invitedalreadyask);
				}
			}
		}
		if ($_SESSION['askquoteinvitealreadyask']) {
			$n = 0;
			foreach ($_SESSION['askquoteinvitealreadyask'] as $key => $value) {
				$profilecountarray	= explode(",", $_SESSION['jobselectedprofile']['profile']);
				$jobdetailalready = $this->JobQuote->find('all')->contain(['Users' => ['Profile', 'Professinal_info'], 'Skill', 'Requirement'])->where(['JobQuote.job_id' => $value, 'JobQuote.user_id' => $profilecountarray[$n]])->first();
				$this->Flash->error(__('You have asked for quote from ' . $jobdetailalready['user']['profile']['name'] . ' for ' . $jobdetailalready['requirement']['title'] . ' on ' . date('Y-m-d H:m:s', strtotime($jobdetailalready['created']))));

				$n++;
			}
		}

		unset($_SESSION['askquoteinvite']);
		unset($_SESSION['askquotenotinvite']);
		unset($_SESSION['jobselectedprofile']);
	}


	public function advertisedjob($infunc = null, $curjobid = null)
	{
		$this->loadModel('Profile');
		$uid = $this->request->session()->read('Auth.User.id');
		$userdetail = $this->Profile->find('all')->contain(['Users'])->where(['Profile.user_id' => $uid])->first();

		$cur_lat = $userdetail['current_lat'];
		$cur_lng = $userdetail['current_long'];
		$lat = $userdetail['lat'];
		$lng = $userdetail['longs'];
		$prgender = $userdetail['gender'];
		$profilerole = $userdetail['user']['role_id'];
		$currentdate = date('Y-m-d H:m:s');

		$conn = ConnectionManager::get('default');
		$requirement = "SELECT Profile.name, 1.609344 * 6371 * acos( cos( radians('" . $cur_lat . "') ) 
		* cos( radians(Jobadvertpack.current_lat) ) 
		* cos( radians(Jobadvertpack.current_long) - radians('" . $cur_lng . "') ) + sin( radians('" . $cur_lat . "') ) 
		* sin( radians(Jobadvertpack.current_lat) ) ) AS cdistance,

		1.609344 * 6371 * acos( cos( radians('" . $lat . "') ) 
		* cos( radians(Jobadvertpack.current_lat) ) 
		* cos( radians(Jobadvertpack.current_long) - radians('" . $lng . "') ) + sin( radians('" . $lat . "') ) 
		* sin( radians(Jobadvertpack.current_lat) ) ) AS fdistance, 
		Jobadvertpack.id AS `advrtjob__id`, 
		Jobadvertpack.rname AS `advrtjob__title`, 
		Jobadvertpack.requir_id AS `job_id`, 
		Jobadvertpack.job_image_change AS `advrt_image`, 
		Jobadvertpack.gender, 
		Jobadvertpack.ad_for AS ad_for, 
		Jobadvertpack.current_location, 
		Requirement.title AS `job_title`,
		Requirement.event_type AS `event_type`,
		Requirement.continuejob AS `continuejob`,
		Eventtype.name AS `event_type`,
		Requirement.location AS `job_location`

		FROM advrt_job_pack Jobadvertpack INNER JOIN personal_profile Profile ON Profile.user_id = (Jobadvertpack.user_id)
		LEFT JOIN requirement Requirement ON Requirement.id = (Jobadvertpack.requir_id)
		LEFT JOIN eventtypes Eventtype ON Eventtype.id = (Requirement.event_type) 
		WHERE ((Jobadvertpack.ad_date_to >= '" . $currentdate . "' AND Jobadvertpack.requir_id != '" . $curjobid . "') )
		ORDER BY cdistance ASC";
		$allrequirement = $conn->execute($requirement);
		$viewrequirement = $allrequirement->fetchAll('assoc');
		// pr($viewrequirement); die;
		$this->set('viewrequirads', $viewrequirement);
		if ($infunc == 1) {
			return $viewrequirement;
		}
		// $where = WHERE ((Jobadvertpack.ad_date_to >= '" . $currentdate . "' AND Jobadvertpack.requir_id != '" . $curjobid . "') AND (Jobadvertpack.gender ='" . $prgender . "' OR Jobadvertpack.ad_for ='" . $profilerole . "')) having fdistance < " . SEARCH_DISTANCE . "  and cdistance < " . SEARCH_DISTANCE . "  
	}


	// show job 
	public function applyjob($id)
	{
		$this->loadModel('Subscription');
		$this->loadModel('Likejobs');
		$this->loadModel('Report');
		$this->loadModel('Profilepack');
		$this->loadModel('Requirement');
		$this->loadModel('JobView');
		$this->loadModel('Userjobanswer');
		$this->loadModel('JobApplication');
		$this->loadModel('Settings');
		$this->loadModel('JobQuote');
		$this->loadModel('Packfeature');

		$this->set('job_id', $id);
		$requirementdatacheck = $this->Requirement->find('all')->contain(['Users'])->where(['Requirement.id' => $id])->first();
		$this->set('requirementdatacheck', $requirementdatacheck);

		$user_id = $this->request->session()->read('Auth.User.id');
		$totallikes = $this->Likejobs->find('all')->where(['Likejobs.job_id' => $id])->count();
		$this->set('totallikes', $totallikes);

		$totalreports = $this->Report->find('all')->where(['Report.profile_id' => $id, 'Report.type' => 'job'])->count();
		$this->set('totalreports', $totalreports);

		$sub_data_pr = $this->Subscription->find()
			->contain(['Profilepack'])
			->where([
				'Subscription.user_id' => $requirementdatacheck['user_id'],
				'Subscription.package_type' => 'PR',
				'OR' => [
					['Subscription.expiry_date >=' => date('Y-m-d')], // Check if not expired
					['Subscription.package_id' => 1] // Fallback to package_id = 1
				]
			])
			->order(['Subscription.id' => 'DESC'])
			->first();


		$sub_data_re = $this->Subscription->find()
			->contain(['RecuriterPack'])
			->where([
				'Subscription.user_id' => $requirementdatacheck['user_id'],
				'Subscription.package_type' => 'RC',
				'OR' => [
					['Subscription.expiry_date >=' => date('Y-m-d')], // Not expired
					['Subscription.package_id' => 1] // Fallback if no valid subscription exists
				]
			])
			->order(['Subscription.id' => 'DESC'])
			->first();


		$this->set('sub_data_pr', $sub_data_pr);
		$this->set('sub_data_re', $sub_data_re);


		$packlimit = $this->activePackage(); // Fetch package details
		$packfeature = $this->Packfeature->find('all')->where(['id' => $packlimit['id']])->first();

		if ($packfeature['number_of_quote_daily'] == 0) {
			$this->Flash->error(__('You cannot send more free quotes today. You can now Send Paid quotes.'));
		}

		$this->set('packfeature', $packfeature);

		$access_job = $packlimit['access_job'];
		$remainingLimit = $access_job - $packlimit['access_job_used'];

		// pr($id);
		// pr($access_job);
		// pr($packlimit['access_job_used']);
		// pr($access_job - $packlimit['access_job_used']);
		// exit;

		if ($remainingLimit < 0 || $remainingLimit == 0) {
			$alertjobaccess = 'Your limit to view Job Openings has reched 100 percent. Please upgrade your profile package to view more openings.';
			$this->set('alertjobaccess', $alertjobaccess);
		} else if ($remainingLimit <= ($access_job * 0.5)) {
			$alertjobaccess = 'You have viewed 50 percent of the total Job openings allowed to be viewed';
			$this->set('alertjobaccess', $alertjobaccess);
			// Agar 50% limit use ho chuki hai to warning dikhayein
		}


		$jobdataeapryxits = $this->JobApplication->find('all')->where(['JobApplication.job_id' => $id, 'JobApplication.user_id' => $user_id])->first();

		$this->set('mydata', $jobdataeapryxits);
		$setting = $this->Settings->find('all')->first();

		$this->set('ping_amt', $setting['ping_amt']);
		$this->set('paid_quotes_amt', $setting['quote_amt']);

		$packfeature_id = $packlimit['id'];
		$number_quotemonth = $packlimit['number_job_application_month'];
		$number_of_application = $packlimit['number_job_application_daily'];
		$number_of_applicationmonth = $packlimit['number_job_application_month'];


		if ($number_quotemonth == 0) {
			$this->Flash->error(__('You have reached your monthly limit of job applications. You can now send Paid Pings.'));
		}

		if ($number_of_application == 0) {
			$this->Flash->error(__('You have reached your daily limit of job applications. You can now send Paid Pings.'));
		}

		$this->set('number_of_application', $number_of_application);
		$this->set('number_of_applicationmonth', $number_of_applicationmonth);
		$this->set('number_quotemonth', $number_quotemonth);
		$jobdquoteexit = $this->JobQuote->find('all')->where(['JobQuote.job_id' => $id, 'JobQuote.user_id' => $user_id])->first();

		$this->set('jobdquoteexit', $jobdquoteexit);
		$jobdataeapryxits = $this->JobApplication->find('all')->where(['JobApplication.job_id' => $id, 'JobApplication.user_id' => $user_id])->first();

		$this->set('applyjobid', $jobdataeapryxits['id']);
		$this->set('applyjobdata', $jobdataeapryxits);

		$this->set('selectedbystatus', $jobdataeapryxits['jobstatus']);
		if ($jobdataeapryxits['talent_accepted_status'] == 'Y' || $jobdataeapryxits['talent_accepted_status'] == 'R') {
			$booknowrequest = $jobdataeapryxits['nontalent_aacepted_status'];
			$jobid = $jobdataeapryxits['id'];
			$apply = 1;
			$this->set('apply', $apply);
			$this->set('booknowrequest', $booknowrequest);
			$this->set('talentstatus', $jobdataeapryxits['talent_accepted_status']);
			$this->set('jobid', $jobid);
		} else {
			$apply = 0;
			$booknowrequest = $jobdataeapryxits['nontalent_aacepted_status'];
			$this->set('talentstatus', $jobdataeapryxits['talent_accepted_status']);
			$jobid = $jobdataeapryxits['id'];
			$this->set('booknowrequest', $booknowrequest);
			$this->set('apply', $apply);
			$this->set('jobid', $jobid);
		}

		if ($jobdquoteexit) {
			$quoteid = $jobdquoteexit['id'];
			$jobquote = 1;
			$this->set('jobquote', $jobquote);
			$this->set('quoteid', $quoteid);
			$this->set('reviamt', $jobdquoteexit['revision']);
			$this->set('userind', $jobdquoteexit['user_id']);
		} else {
			$jobquote = 0;
			$this->set('jobquote', $jobquote);
		}

		$JobView = $this->JobView->newEntity();
		$jobview_Data['job_id'] = $id;
		$jobview_Data['user_id'] = $user_id;

		$jobdataexits = $this->JobView->find('all')->where(['JobView.job_id' => $id, 'JobView.user_id' => $user_id])->first();

		if ($requirementdatacheck['user_id'] != $user_id) {
			if (empty($jobdataexits)) {

				if ($remainingLimit <= 0 && $user_id != 1) {
					$this->Flash->error(__('Your limit to view Job Openings has expired. Please upgrade your profile package to view more openings.'));
					return $this->redirect(SITE_URL . '/package/allpackages/profilepackage/');
					//$this->redirect( Router::url( $this->referer(), true ));
				} else {
					$jobviewdatasave = $this->JobView->patchEntity($JobView, $jobview_Data);
					$jbques = $this->JobView->save($jobviewdatasave);
					// Update job feature value
					$packfeature = $this->Packfeature->get($packfeature_id);
					// $feature_info['access_job'] = $access_job - 1;
					$feature_info['access_job_used'] = $packlimit['access_job_used'] + 1;
					$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
					$this->Packfeature->save($features_arr);
				}
			}
		}
		// Update job quote status to viewedstatus

		if ($jobdquoteexit) {
			$jobqdata = $this->JobQuote->get($jobdquoteexit['id']);
			$job_qinfo['viewedstatus'] = 'Y';
			$job_qarr = $this->JobQuote->patchEntity($jobqdata, $job_qinfo);
			$this->JobQuote->save($job_qarr);
		}
		// Update job application status to viewedstatus

		if ($jobdataeapryxits) {
			$jobbdata = $this->JobApplication->get($jobdataeapryxits['id']);
			$job_binfo['viewedstatus'] = 'Y';
			$job_barr = $this->JobApplication->patchEntity($jobbdata, $job_binfo);
			$this->JobApplication->save($job_barr);
		}

		try {
			$details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Eventtype', 'Users', 'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']])->where(['Requirement.id' => $id])->first();
			$this->set('requirement_data', $details);
		} catch (FatalErrorException $e) {
			$this->log("Error Occured", 'error');
		}

		$Userjobanswer = $this->Userjobanswer->newEntity();

		if ($this->request->is(['post'])) {
			$c = 1;
			//pr($this->request->data); die;

			for ($i = 0; $i < $this->request->data['countquestion']; $i++) {
				if (!empty($this->request->data['radio' . $c]) || !empty($this->request->data['check' . $c])) {

					// $jobdataexits=$this->Userjobanswer->find('all')->where([])->first();

					$this->Userjobanswer->deleteAll(['question_id' => $this->request->data['questionid' . $c], 'user_id' => $this->request->session()->read('Auth.User.id')]);


					$Userjobanswerenty = $this->Userjobanswer->newEntity();
					$userid = $this->request->session()->read('Auth.User.id');


					$user_Data['job_id'] = $id;
					$user_Data['user_id'] = $userid;
					$user_Data['question_id'] = $this->request->data['questionid' . $c];
					$user_Data['option_id'] = $this->request->data['radio' . $c];
					$user_Data['isans'] = "Y";
					if ($this->request->data['check' . $c]) {
						for ($j = 0; $j < count($this->request->data['check' . $c]); $j++) {
							$Userjobanswercheck = $this->Userjobanswer->newEntity();
							$user_Datacheck['job_id'] = $id;
							$user_Datacheck['user_id'] = $this->request->session()->read('Auth.User.id');
							$user_Datacheck['question_id'] = $this->request->data['questionid' . $c];
							$user_Datacheck['option_id'] = $this->request->data['check' . $c][$j];
							$user_Datacheck['isans'] = "Y";
							$usersavedata = $this->Userjobanswer->patchEntity($Userjobanswercheck, $user_Datacheck);
							$jbques = $this->Userjobanswer->save($usersavedata);
						}
					} else {
						$jobviewdatasave = $this->Userjobanswer->patchEntity($Userjobanswerenty, $user_Data);
						$jbques = $this->Userjobanswer->save($jobviewdatasave);
					}
				}
				$c++;
			}

			$this->Flash->success(__('Your Answer  Post Successfully!!.'));
		}
		$viewrequirads = $this->advertisedjob(1, $id);
		$this->set('viewrequirads', $viewrequirads);
	}
	// end

	public function applyjobsave()
	{

		$this->loadModel('JobApplication');
		$this->loadModel('Packfeature');

		if ($this->request->is(['post'])) {

			$jobid = $this->request->data['job_id'];
			$user_id = $this->request->session()->read('Auth.User.id');

			$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();

			$packfeature_id = $packfeature['id'];
			$number_jobday = $packfeature['number_job_application_daily'];
			$number_jobmonth = $packfeature['number_job_application_month'];
			// pr($number_jobday);
			// die;
			$jobaplyperday = $this->JobApplication->find('all')
				->where(['JobApplication.user_id' => $user_id, 'JobApplication.created' => date('Y-m-d')])->count();

			if ($number_jobmonth > 0) {
				if ($jobaplyperday < $number_jobday) {

					$id = $this->request->data['job_idprimary'];

					if (isset($id) && !empty($id)) {

						$JobApplication = $this->JobApplication->get($id);
					} else {
						$JobApplication = $this->JobApplication->newEntity();
					}
					$jobid = $this->request->data['job_id'];
					$this->request->data['user_id'] = $user_id;
					$this->request->data['talent_accepted_status'] = "Y";
					$this->request->data['skill_id'] = $this->request->data['skill'];

					$JobApplicationdata = $this->JobApplication->patchEntity($JobApplication, $this->request->data);
					if ($resu = $this->JobApplication->save($JobApplicationdata)) {

						$packfeature = $this->Packfeature->get($packfeature_id);
						$feature_info['number_job_application_daily'] = $number_jobday - 1;
						$feature_info['number_job_application_month'] = $number_jobmonth - 1;
						$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
						//pr($features_arr); die;
						$this->Packfeature->save($features_arr);

						$this->Flash->success(__('Job Application data has been saved.'));
						return $this->redirect(SITE_URL . '/applyjob/' . $jobid);
					}
				} else {

					$this->Flash->error(__('Number of Apply Job Days Exceed '));
					return $this->redirect(SITE_URL . '/applyjob/' . $jobid);
				}
			} else {
				$this->Flash->error(__('Number of Apply Job Month Exceed '));
				return $this->redirect(SITE_URL . '/applyjob/' . $jobid);
			}
		}
	}

	public function aplysingleclone() // this funtion use on applyjob ctp page
	{
		$this->loadModel('JobApplication');
		$this->loadModel('Packfeature');
		$this->loadModel('Requirement');

		if ($this->request->is(['post'])) {
			$user_id = $this->request->session()->read('Auth.User.id');
			$roleId = $this->request->session()->read('Auth.User.role_id');
			$packfeature = $this->activePackage(); // Fetch package details
			$userName = $this->request->session()->read('Auth.User.user_name');
			$response = [];

			$jobDetails = $this->Requirement->find('all')->where(['Requirement.id' => $this->request->data['job_id']])->first();
			// pr($jobDetails);exit;

			// **Check if package data is available**
			if (!$packfeature) {
				$response['success'] = false;
				$response['message'] = "No active package found.";
				echo json_encode($response);
				// die;
				$this->Flash->error(__('No active package found.'));
				return $this->redirect($this->request->referer());
			}

			if (!$jobDetails) {
				$response['success'] = false;
				$response['message'] = "Invalid job";
				$this->Flash->error(__('Invalid job'));
				return $this->redirect($this->request->referer());
				echo json_encode($response);
				// die;
			}

			// **Check if the user has already applied for the same job**
			$existingApplication = $this->JobApplication->find()
				->where([
					'JobApplication.user_id' => $user_id,
					'JobApplication.job_id' => $this->request->data['job_id']
				])
				->first();

			if ($existingApplication) {
				$response['success'] = false;
				$response['message'] = "You have already applied for this job.";
				echo json_encode($response);
				// die;
				$this->Flash->error(__('You have already applied for this job.'));
				return $this->redirect($this->request->referer());
			}

			// **Extract limit values from package**
			$packfeature_id = $packfeature['id'];
			$number_jobmonth = $packfeature['number_job_application_month'];

			// **Count jobs applied today dynamically**
			$job_applied_today = $this->JobApplication->find()
				->where([
					'JobApplication.user_id' => $user_id,
					'DATE(JobApplication.created)' => date('Y-m-d')
				])
				->count();

			// **Check daily limit dynamically**
			if ($job_applied_today >= $packfeature['number_job_application_daily']) {
				$response['success'] = false;
				$response['message'] = "You Have Exceed the Daily Job Application Limit.";
				echo json_encode($response);
				// die;
				$this->Flash->error(__('You Have Exceed the Daily Job Application Limit.'));
				return $this->redirect($this->request->referer());
			}

			// **Check monthly limit**
			if ($packfeature['number_job_application_month_used'] >= $number_jobmonth) {
				$response['success'] = false;
				$response['message'] = "You have Exceed the Monthly Job Application Limit.";
				echo json_encode($response);
				// die;
				$this->Flash->error(__('You have Exceed the Monthly Job Application Limit.'));
				return $this->redirect($this->request->referer());
			}


			// **Create a new job application entry**
			$JobApplication = $this->JobApplication->newEntity();

			$this->request->data['user_type'] = $roleId;
			$this->request->data['package_id'] = $packfeature_id;
			$this->request->data['user_id'] = $user_id;
			$this->request->data['talent_accepted_status'] = "Y";
			$this->request->data['job_id'] = $this->request->data['job_id'];
			$this->request->data['skill_id'] = $this->request->data['skill'];

			$JobApplicationData = $this->JobApplication->patchEntity($JobApplication, $this->request->data);

			if ($this->JobApplication->save($JobApplicationData)) {
				// **Update only the monthly job count**
				$packfeature = $this->Packfeature->get($packfeature_id);
				$packfeature->number_job_application_month_used += 1;
				$this->Packfeature->save($packfeature);

				// Send notification for job application
				$this->notification_sent(
					$jobDetails['user_id'],
					$messageType = 'Job Application',
					$message = 'You have received a job application for the job titled "' . $jobDetails['title'] . '" from '
				);

				$this->Flash->sucess(__('Job application submitted successfully.'));
				return $this->redirect($this->request->referer());
				// $response['success'] = true;
				// $response['message'] = "Job application submitted successfully.";
			} else {
				$response['success'] = false;
				$response['message'] = "Failed to apply for the job. Please try again.";
				$this->Flash->sucess(__('Failed to apply for the job. Please try again.'));
				return $this->redirect($this->request->referer());
			}

			echo json_encode($response);
			die;
		}
	}

	public function aplysingle()
	{
		$this->loadModel('JobApplication');
		$this->loadModel('Packfeature');
		$this->loadModel('Requirement');

		if ($this->request->is(['post'])) {
			$user_id = $this->request->session()->read('Auth.User.id');
			$roleId = $this->request->session()->read('Auth.User.role_id');
			$packfeature = $this->activePackage(); // Fetch package details
			$userName = $this->request->session()->read('Auth.User.user_name');
			$response = [];

			// pr($this->request->data);
			// exit;
			// pr($user_id);exit;

			$jobDetails = $this->Requirement->find('all')->where(['Requirement.id' => $this->request->data['job_id']])->first();
			// pr($jobDetails);exit;

			// **Check if package data is available**
			if (!$packfeature) {
				$response['success'] = false;
				$response['message'] = "No active package found.";
				echo json_encode($response);
				die;
			}

			if (!$jobDetails) {
				$response['success'] = false;
				$response['message'] = "Invalid job";
				echo json_encode($response);
				die;
			}

			// **Check if the user has already applied for the same job**
			$existingApplication = $this->JobApplication->find()
				->where([
					'JobApplication.user_id' => $user_id,
					'JobApplication.job_id' => $this->request->data['job_id']
				])
				->first();

			if ($existingApplication) {
				$response['success'] = false;
				$response['message'] = "You have already applied for this job.";
				echo json_encode($response);
				die;
			}

			// **Extract limit values from package**
			$packfeature_id = $packfeature['id'];
			$number_jobmonth = $packfeature['number_job_application_month'];

			// **Count jobs applied today dynamically**
			$job_applied_today = $this->JobApplication->find()
				->where([
					'JobApplication.user_id' => $user_id,
					'DATE(JobApplication.created)' => date('Y-m-d')
				])
				->count();

			// **Check daily limit dynamically**
			if ($job_applied_today >= $packfeature['number_job_application_daily']) {
				$response['success'] = false;
				$response['message'] = "You Have Exceed the Daily Job Application Limit.";
				echo json_encode($response);
				die;
			}

			// **Check monthly limit**
			if ($packfeature['number_job_application_month_used'] >= $number_jobmonth) {
				$response['success'] = false;
				$response['message'] = "You have Exceed the Monthly Job Application Limit.";
				echo json_encode($response);
				die;
			}


			// **Create a new job application entry**
			$JobApplication = $this->JobApplication->newEntity();

			$this->request->data['user_type'] = $roleId;
			$this->request->data['package_id'] = $packfeature_id;
			$this->request->data['user_id'] = $user_id;
			$this->request->data['talent_accepted_status'] = "Y";
			$this->request->data['job_id'] = $this->request->data['job_id'];
			$this->request->data['skill_id'] = $this->request->data['skill'];

			$JobApplicationData = $this->JobApplication->patchEntity($JobApplication, $this->request->data);

			if ($this->JobApplication->save($JobApplicationData)) {
				// **Update only the monthly job count**
				$packfeature = $this->Packfeature->get($packfeature_id);
				$packfeature->number_job_application_month_used += 1;
				$this->Packfeature->save($packfeature);

				// Send notification for job application
				$this->notification_sent(
					$jobDetails['user_id'],
					$messageType = 'Job Application',
					$message = 'You have received a job application for the job titled "' . $jobDetails['title'] . '" from '
				);

				$response['success'] = true;
				$response['message'] = "Job application submitted successfully.";
			} else {
				$response['success'] = false;
				$response['message'] = "Failed to apply for the job. Please try again.";
			}

			echo json_encode($response);
			die;
		}
	}

	public function aplysendquotesingle()
	{
		$this->loadModel('JobQuote');
		$this->loadModel('Packfeature');

		if ($this->request->is(['post'])) {
			// pr($this->request->data);exit;

			$user_id = $this->request->session()->read('Auth.User.id');

			// Fetch active package for the user
			$packfeature = $this->activePackage(); // Fetches from Packfeature table
			if (!$packfeature) {
				echo json_encode(['success' => false, 'message' => 'No active package found.']);
				die;
			}

			$packfeature_id = $packfeature['id'];
			$totalDailyLimit = $packfeature['number_of_quote_daily'];
			$totalUsed = $packfeature['number_of_quote_daily_used'];
			$remaining = $totalDailyLimit - $totalUsed;
			$remaining = ($remaining > 0) ? $remaining : 0;
			// pr($packfeature);exit;

			// Check if user exceeded daily limit
			if ($totalUsed >= $totalDailyLimit) {
				echo json_encode([
					'success' => false,
					'message' => "You have exceeded your daily limit. You can send up to $totalDailyLimit quotes per day."
				]);
				die;
			}

			// Validate required fields
			if (empty($this->request->data['job_id']) || empty($this->request->data['amt']) || empty($this->request->data['skill'])) {
				echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
				die;
			}

			// Create a new job quote entry
			$JobQuote = $this->JobQuote->newEntity();
			$this->request->data['job_id'] = $this->request->data['job_id'];
			$this->request->data['user_id'] = $user_id;
			$this->request->data['talent_accepted_status'] = "Y";
			$this->request->data['amt'] = $this->request->data['amt'];
			$this->request->data['status'] = 'N';
			$this->request->data['nontalent_satus'] = 'Y';
			$this->request->data['skill_id'] = $this->request->data['skill'];

			$JobApplicationdata = $this->JobQuote->patchEntity($JobQuote, $this->request->data);

			if ($this->JobQuote->save($JobApplicationdata)) {
				// Update used limit count
				$packfeature = $this->Packfeature->get($packfeature_id);
				$packfeature->number_of_quote_daily_used += 1;
				$this->Packfeature->save($packfeature);

				echo json_encode(['success' => true, 'message' => 'Quote sent successfully.']);
				die;
			} else {
				echo json_encode(['success' => false, 'message' => 'Failed to send quote. Please try again.']);
				die;
			}
		}
	}



	public function applyjobbyid($jobid, $skill)
	{

		$this->loadModel('JobApplication');
		$this->loadModel('Packfeature');
		$this->loadModel('Requirement');

		// pr($this->request->data);exit;

		$user_id = $this->request->session()->read('Auth.User.id');
		// Get the active package
		$packfeature = $this->activePackage();
		if (!$packfeature) {
			$this->Flash->error(__('You have not purchased any package.'));
			return;
		}

		$monthlimit = $packfeature['number_job_application_month'];
		$dailylimit = $packfeature['number_job_application_daily'];

		// Get the current date
		$currentDate = date('Y-m-d');

		// Check how many applications the user has made today
		$dailyApplicationCount = $this->JobApplication->find()
			->where([
				'JobApplication.user_id' => $user_id,
				'DATE(JobApplication.created)' => $currentDate
			])
			->count();

		// Check how many applications the user has made this month
		$firstDayOfMonth = date('Y-m-01');
		$lastDayOfMonth = date('Y-m-t');

		$monthlyApplicationCount = $this->JobApplication->find()
			->where([
				'JobApplication.user_id' => $user_id,
				'JobApplication.created >=' => $firstDayOfMonth,
				'JobApplication.created <=' => $lastDayOfMonth
			])
			->count();

		// Check if the user has exceeded limits
		if ($monthlyApplicationCount >= $monthlimit) {
			$this->Flash->error(__('You have exceeded the monthly limit of job applications'));
			return;
		}

		if ($dailyApplicationCount >= $dailylimit) {
			$this->Flash->error(__('You have exceeded the daily limit of job applications'));
			return;
		}

		// Fetch job details
		$details = $this->Requirement->find()
			->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City', 'Users', 'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']])
			->where(['Requirement.id' => $jobid, 'Requirement.status' => 'Y'])
			->first();

		if (!$details) {
			$this->Flash->error(__('Job not found or inactive.'));
			return;
		}

		$packfeature_id = $packfeature['id'];

		if (isset($id) && !empty($id)) {
			$JobApplication = $this->JobApplication->get($id);
		} else {
			$JobApplication = $this->JobApplication->newEntity();
		}

		// pr($JobApplication);
		// exit;

		$this->request->data['job_id'] = $jobid;
		$this->request->data['user_id'] = $user_id;
		$this->request->data['talent_accepted_status'] = "Y";
		$this->request->data['skill_id'] = $skill;

		$JobApplicationdata = $this->JobApplication->patchEntity($JobApplication, $this->request->data);
		if ($resu = $this->JobApplication->save($JobApplicationdata)) {
			$packfeature = $this->Packfeature->get($packfeature_id);
			$feature_info['number_job_application_daily'] = $dailylimit - 1;
			$feature_info['number_job_application_month'] = $monthlimit - 1;
			$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
			$this->Packfeature->save($features_arr);
			$this->Flash->success(__('Job Application data has been saved.'));
		} else {
			$this->Flash->error(__('Unable to add job application.'));
		}
		$this->redirect(Router::url($this->referer(), true));
	}

	// public function SendQoute()
	// {
	// 	$this->loadModel('JobQuote');
	// 	$this->loadModel('Packfeature');


	// 	if ($this->request->is(['post', 'put'])) {
	// 		pr($this->request->data); die;
	// 		$user_id = $this->request->session()->read('Auth.User.id');
	// 		//echo $user_id; die;
	// 		$packfeature = $this->activePackage();
	// 		// pr($packfeature);exit;
	// 		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
	// 		$packfeature_id = $packfeature['id'];
	// 		$number_quotemonth = $packfeature['number_of_quote_daily'];
	// 		$number_of_free_quotes = $packfeature['number_of_free_quotes'];
	// 		$jobid = $this->request->data['job_id'];
	// 		$this->Set('number_quotemonth', $number_quotemonth);
	// 		$this->Set('number_of_free_quotes', $number_of_free_quotes);

	// 		$jobaplyperday = $this->JobQuote->find('all')->where(['JobQuote.user_id' => $this->request->session()->read('Auth.User.id'), 'JobQuote.created' => date('Y-m-d'), 'JobQuote.amt !=' => 0])->count();

	// 		// if ($number_of_free_quotes > 0 && $jobaplyperday < $jobaplyperday) {
	// 		if ($number_of_free_quotes > 0 && $jobaplyperday < $number_of_free_quotes) {
	// 			$id = $this->request->data['job_idprimary'];
	// 			if (isset($id) && !empty($id)) {
	// 				$JobQuote = $this->JobQuote->get($id);
	// 			} else {
	// 				$JobQuote = $this->JobQuote->newEntity();
	// 			}
	// 			$packfeature = $this->Packfeature->get($packfeature_id);
	// 			//$feature_info['number_of_quote_daily'] = $number_quotemonth-1;
	// 			$feature_info['number_of_free_quotes'] = $number_of_free_quotes - 1;
	// 			$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
	// 			$this->Packfeature->save($features_arr);
	// 			$this->request->data['status'] = 'N';
	// 			$this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');
	// 			$this->request->data['skill_id'] = $this->request->data['skill'];
	// 			$Jobquotedata = $this->JobQuote->patchEntity($JobQuote, $this->request->data);
	// 			if ($resu = $this->JobQuote->save($Jobquotedata)) {
	// 				$this->Flash->success(__('You Sent Quote on ' . date('d F Y')));
	// 			}
	// 			return $this->redirect(SITE_URL . '/applyjob/' . $jobid);
	// 		} else {
	// 			//$this->Flash->error(__('Limit reached. Buy Ask for Quote Rights For < Job Title>'));
	// 			$this->Flash->error(__('You cannot send more free quotes today. You can now Send Paid quotes'));
	// 			return $this->redirect(SITE_URL . '/applyjob/' . $jobid);
	// 		}
	// 	}
	// }

	public function askQuote()
	{

		$this->loadModel('JobQuote');
		if ($this->request->is(['post', 'put'])) {
			//$this->dd($this->request->data); die;
			$user_id = $this->request->data['user_id'];
			count($this->request->data['job_id']);
			$havefill = 0;
			foreach ($this->request->data['job_id'] as $key => $value) {
				if ($this->request->data['job_id'][$key][0] != '') {
					$havefill = 1;
				}
			}
			if ($havefill) {
				foreach ($this->request->data['job_id'] as $key => $value) {
					if ($this->request->data['job_id'][$key][0] != '') {
						$JobQuote = $this->JobQuote->newEntity();
						$Userjobanswercheck = $this->JobQuote->newEntity();
						$user_id = $this->request->data['user_id'];
						$user_Datacheck['status'] = $id;
						$user_Datacheck['user_id'] = $this->request->data['user_id'];
						$user_Datacheck['job_id'] = $key;
						$user_Datacheck['skill_id'] = $value[0];
						$usersavedata = $this->JobQuote->patchEntity($JobQuote, $user_Datacheck);
						$jbques = $this->JobQuote->save($usersavedata);
						if ($jbques) {
						}
					}
				}
				$this->Flash->success(__('Send Quote  has been Saved Successfully'));
			} else {
				$this->Flash->error(__('Quote request not send'));
			}
			//return $this->redirect(SITE_URL.'/viewprofile/'.$user_id);

		}
		//	echo 'http://bookanartiste.com/viewprofile/'.$user_id;
		return $this->redirect(SITE_URL . '/viewprofile/' . $user_id);
	}

	public function insBook()
	{

		$this->loadModel('JobApplication');
		if ($this->request->is(['post', 'put'])) {

			// pr($this->request->data);
			// exit;
			count($this->request->data['job_id']);
			$user_id = $this->request->data['user_id'];
			//$this->dd($this->request->data); die;
			//$JobApplication = $this->JobApplication->newEntity();
			$havefill = 0;
			foreach ($this->request->data['job_id'] as $key => $value) {
				if ($this->request->data['job_id'][$key][0] != '') {
					$havefill = 1;
				}
			}
			if ($havefill) {
				foreach ($this->request->data['job_id'] as $key => $value) {
					if ($this->request->data['job_id'][$key][0] != '') {
						$JobApplication = $this->JobApplication->newEntity();

						$user_Datacheck['status'] = $id;
						$user_Datacheck['user_id'] = $this->request->data['user_id'];
						$user_Datacheck['job_id'] = $key;
						$user_Datacheck['skill_id'] = $value[0];
						$user_Datacheck['nontalent_aacepted_status'] = "Y";
						$user_Datacheck['talent_accepted_status'] = "N";
						$usersavedata = $this->JobApplication->patchEntity($JobApplication, $user_Datacheck);
						$jbques = $this->JobApplication->save($usersavedata);
					}
				}

				$this->Flash->success(__('Booking request has been send Successfully'));
			} else {

				$this->Flash->error(__('Booking request not send'));
			}

			//echo 'http://bookanartiste.com/viewprofile/'.$user_id;
			//echo SITE_URL.'/viewprofile/'.$user_id; die;
			return $this->redirect(SITE_URL . '/viewprofile/' . $user_id);
			//return $this->redirect(['controller' => 'profile', 'action' => 'viewprofile']);
		}
	}

	public function jobreject($id, $jobid, $status)
	{

		$this->loadModel('JobApplication');

		$jobapplicatiion = $this->JobApplication->get($id);
		$user_Datacheck['talent_accepted_status'] = "R";
		$usersavedata = $this->JobApplication->patchEntity($jobapplicatiion, $user_Datacheck);
		$jbques = $this->JobApplication->save($usersavedata);
		$this->Flash->success(__('Job status changed Successfully'));
		return $this->redirect(SITE_URL . '/applyjob/' . $jobid);
	}

	public function quotereject($id, $jobid, $userid)
	{

		$this->loadModel('JobApplication');
		$this->loadModel('JobQuote');

		$JobQuote = $this->JobQuote->get($id);
		$user_Datacheckquote['status'] = "R";
		$usersavedataquote = $this->JobQuote->patchEntity($JobQuote, $user_Datacheckquote);
		$jbques = $this->JobQuote->save($usersavedataquote);

		$findJob = $this->JobApplication->find('all')
			->where(['id' => $jobid])
			->first();

		$con = ConnectionManager::get('default');
		$detail = "DELETE From job_application Where job_id='$jobid' And user_id='$userid'";
		$results = $con->execute($detail);

		$JobApplication = $this->JobApplication->newEntity();
		$user_Datacheck['talent_accepted_status'] = "R";
		$user_Datacheck['nontalent_aacepted_status'] = "Y";
		$user_Datacheck['job_id'] = $jobid;
		$user_Datacheck['user_id'] = $userid;
		$user_Datacheck['skill_id'] = $findJob['skill_id'];
		$usersavedata = $this->JobApplication->patchEntity($JobApplication, $user_Datacheck);
		$jbques = $this->JobApplication->save($usersavedata);
		$this->Flash->success(__('Quote status has been changed Successfully'));
		return $this->redirect(Router::url($this->referer(), true));
	}

	public function applyjobsavebyquote($qid, $jobid)
	{
		$this->loadModel('JobApplication');


		$this->loadModel('JobQuote');
		//$qid=$this->request->data['quoteid'];	
		$JobQuote = $this->JobQuote->get($qid);
		$user_Datacheckquote['status'] = "S";
		$usersavedataquote = $this->JobQuote->patchEntity($JobQuote, $user_Datacheckquote);
		$jbques = $this->JobQuote->save($usersavedataquote);
		//$this->dd($this->request->data); die;
		// pr($this->request->data);
		// exit;
		$con = ConnectionManager::get('default');
		$id = $this->request->session()->read('Auth.User.id');
		//$jobid=$this->request->data['job_id'];
		$user = $this->request->session()->read('Auth.User.id');
		$detail = "DELETE From job_application Where job_id='$jobid' And user_id='$user'";
		//die;
		$results = $con->execute($detail);
		$JobApplication = $this->JobApplication->newEntity();
		//$jobid=$this->request->data['job_id'];
		$jobdataeapryxits = $this->JobApplication->find('all')->where(['JobApplication.job_id' => $jobid, 'JobApplication.user_id' => $this->request->session()->read('Auth.User.id')])->first();
		if (!$jobdataeapryxits) {
			//$jobid=$this->request->data['job_id'];
			$this->request->data['job_id'] = $jobid;
			$this->request->data['skill_id'] = $JobQuote['skill_id'];
			$this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');
			$this->request->data['talent_accepted_status'] = "Y";
			$this->request->data['nontalent_aacepted_status'] = "Y";
			$JobApplicationdata = $this->JobApplication->patchEntity($JobApplication, $this->request->data);
			if ($resu = $this->JobApplication->save($JobApplicationdata)) {
				$this->Flash->success(__('You have Accepted Quote Request Successfully'));
				//return $this->redirect(SITE_URL.'/applyjob/'.$jobid);
				return $this->redirect(Router::url($this->referer(), true));
			}
		} else {
			$this->Flash->error(__('Error'));
			//  return $this->redirect(SITE_URL.'/applyjob/'.$jobid);
			return $this->redirect(Router::url($this->referer(), true));
		}
	}

	public function applyjobsaveping()
	{
		$this->loadModel('JobApplication');
		$this->loadModel('Packfeature');
		$this->loadModel('Pingpayment');
		if ($this->request->is(['post'])) {
			$id = $this->request->data['job_idprimary'];
			if (isset($id) && !empty($id)) {
				$JobApplication = $this->JobApplication->get($id);
			} else {
				$JobApplication = $this->JobApplication->newEntity();
			}
			$Pingpayment = $this->Pingpayment->newEntity();
			$jobdataeapryxits = $this->JobApplication->find('all')->where(['JobApplication.job_id' => $jobid, 'JobApplication.user_id' => $this->request->session()->read('Auth.User.id')])->first();
			if (!$jobdataeapryxits) {
				$con = ConnectionManager::get('default');
				$id = $this->request->session()->read('Auth.User.id');
				$detail = "DELETE From job_application Where job_id='$jobid' And user_id='$id'";
				//die;
				$results = $con->execute($detail);
				$jobid = $this->request->data['job_id'];
				$this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');
				$this->request->data['talent_accepted_status'] = "Y";
				$this->request->data['ping'] = 1;
				$JobApplicationdata = $this->JobApplication->patchEntity($JobApplication, $this->request->data);
				if ($resu = $this->JobApplication->save($JobApplicationdata)) {
					$pingpackdata['job_id'] = $jobid;
					$pingpackdata['user_id'] = $this->request->session()->read('Auth.User.id');
					$pingpackdata['amt'] = 250;
					$Pingpayment = $this->Pingpayment->patchEntity($Pingpayment, $pingpackdata);
					$resu = $this->Pingpayment->save($Pingpayment);
					$this->Flash->success(__('JobApplication data has been saved.'));
					return $this->redirect(SITE_URL . '/applyjob/' . $jobid);
				}
			} else {
				$this->Flash->error(__('Error'));
				return $this->redirect(SITE_URL . '/applyjob/' . $jobid);
			}
		}
	}

	public function jobnotification()
	{
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Requirement');

		$quotes = '';
		$applications = '';
		$uid = $this->request->session()->read('Auth.User.id');
		$role_id = $this->request->session()->read('Auth.User.role_id');

		if ($role_id == TALANT_ROLEID) {
			$this->loadModel('JobApplication');
			$booking_req = $this->JobApplication->find('all')->contain(['Requirement'])->where(['JobApplication.viewedstatus' => 'N', 'JobApplication.user_id' => $uid])->toarray();
			$this->set('booking_req', $booking_req);

			//pr($booking_req);

			// Ask quote request received
			$this->loadModel('JobQuote');
			$quote_req = $this->JobQuote->find('all')->contain(['Requirement'])->where(['JobQuote.viewedstatus' => 'N', 'JobQuote.user_id' => $uid])->toarray();
			$this->set('quote_req', $quote_req);
		}


		/*
	    
	    $notifications = $this->Messages->find('all')->contain(['Users'=>['Profile']])->where(['to_id' => $uid])->where(['viewedstatus' => 'N'])->toarray();
	    //pr($notifications);
	    $this->set('messages',$notifications);
	    $users= TableRegistry::get('Messages');
	    $status="Y";
	    $con = ConnectionManager::get('default');
	    $detail = 'UPDATE `messages` SET `viewedstatus` ="'.$status.'" WHERE `messages`.`to_id` = '. $uid;
	    $results = $con->execute($detail);
	    */
	}

	// This function  will work when non-talent will book directly 
	public function aplyrejectjob($recid = null, $status = null, $jobid = null)
	{
		$this->loadModel('JobApplication');
		$this->loadModel('Requirement');
		$this->loadModel('Packfeature');
		$this->loadModel('Calendar');
		$this->loadModel('Eventtype');

		// Add To calender 
		if ($status == "Y") {
			$recdata = $this->Requirement->get($jobid);
			$bookingreceived = $this->Requirement->find('all')->contain(['Eventtype'])->where(['Requirement.id' => $jobid])->first();
			if ($recdata['continuejob'] == "N") {
				$clender = $this->Calendar->newEntity();

				$mydata['from_date'] = date('Y-m-d H:i', strtotime($recdata['event_from_date']));
				$mydata['to_date'] = date('Y-m-d H:i', strtotime($recdata['event_to_date']));
				$mydata['type'] = "EV";
				$mydata['title'] = $recdata['title'];
				$mydata['user_id'] = $this->request->session()->read('Auth.User.id');
				$mydata['location'] = $recdata['location'];
				$eventtype = $bookingreceived['eventtype']['name'];
				$req_dis = $bookingreceived['talent_requirement_description'];
				$clenderdata = $this->Calendar->patchEntity($clender, $mydata);

				$this->Calendar->save($clenderdata);
			}
		}

		// End 
		$user_id = $this->request->session()->read('Auth.User.id');

		if (isset($recid) && !empty($recid)) {
			$JobApplication = $this->JobApplication->get($recid);
		} else {
			$JobApplication = $this->JobApplication->newEntity();
		}

		$this->request->data['user_id'] = $user_id;
		$this->request->data['talent_accepted_status'] = $status;
		$JobApplicationdata = $this->JobApplication->patchEntity($JobApplication, $this->request->data);
		if ($resu = $this->JobApplication->save($JobApplicationdata)) {
			$this->Flash->success(__('You have Applied Successfully.'));
		} else {
			$this->Flash->error(__('Unable to apply job.'));
		}
		return $this->redirect(Router::url($this->referer(), true));
	}



	// public function aplyrejectjob($recid = null, $status = null, $jobid = null)
	// {
	// 	$this->loadModel('JobApplication');
	// 	$this->loadModel('Requirement');
	// 	$this->loadModel('Packfeature');
	// 	$this->loadModel('Calendar');
	// 	$this->loadModel('Eventtype');

	// 	// Add To calender 
	// 	if ($status == "Y") {
	// 		$recdata = $this->Requirement->get($jobid);
	// 		$bookingreceived = $this->Requirement->find('all')->contain(['Eventtype'])->where(['Requirement.id' => $jobid])->first();
	// 		//pr($bookingreceived); die;
	// 		if ($recdata['continuejob'] == "N") {
	// 			$clender = $this->Calendar->newEntity();

	// 			$mydata['from_date'] = date('Y-m-d H:i', strtotime($recdata['event_from_date']));
	// 			$mydata['to_date'] = date('Y-m-d H:i', strtotime($recdata['event_to_date']));
	// 			$mydata['type'] = "EV";
	// 			$mydata['title'] = $recdata['title'];
	// 			$mydata['user_id'] = $this->request->session()->read('Auth.User.id');
	// 			$mydata['location'] = $recdata['location'];
	// 			$eventtype = $bookingreceived['eventtype']['name'];
	// 			$req_dis = $bookingreceived['talent_requirement_description'];
	// 			$clenderdata = $this->Calendar->patchEntity($clender, $mydata);

	// 			$this->Calendar->save($clenderdata);
	// 		}
	// 	}


	// 	// End 

	// 	$user_id = $this->request->session()->read('Auth.User.id');
	// 	$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
	// 	$packfeature_id = $packfeature['id'];
	// 	$number_jobmonth = $packfeature['nubmer_of_jobs_month'];
	// 	$number_jobday = $packfeature['number_job_application'];
	// 	$jobaplyperday = $this->JobApplication->find('all')->where(['JobApplication.user_id' => $user_id, 'JobApplication.created' => date('Y-m-d')])->count();
	// 	//	if($number_jobmonth>0)
	// 	//{
	// 	//	if($jobaplyperday<$number_jobday){

	// 	if (isset($recid) && !empty($recid)) {
	// 		$JobApplication = $this->JobApplication->get($recid);
	// 	} else {
	// 		$JobApplication = $this->JobApplication->newEntity();
	// 	}

	// 	$this->request->data['user_id'] = $user_id;
	// 	$this->request->data['talent_accepted_status'] = $status;

	// 	$JobApplicationdata = $this->JobApplication->patchEntity($JobApplication, $this->request->data);
	// 	if ($resu = $this->JobApplication->save($JobApplicationdata)) {

	// 		//$packfeature = $this->Packfeature->get($packfeature_id);
	// 		//$feature_info['nubmer_of_jobs_month'] = $number_jobmonth-1;
	// 		//$feature_info['number_job_application'] = $number_jobday-1;
	// 		//$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
	// 		//$this->Packfeature->save($features_arr);



	// 		$this->Flash->success(__('You have Applied Successfully.'));
	// 		//return $this->redirect(SITE_URL.'/jobpost/applyjob/'.$jobid);
	// 		return $this->redirect(Router::url($this->referer(), true));
	// 	}




	// 	// }else{

	// 	//	$this->Flash->error(__('Number of Apply Job Days Exceed '));
	// 	//	return $this->redirect(SITE_URL.'/jobpost/applyjob/'.$jobid);


	// 	//}



	// 	// }else{

	// 	//$this->Flash->error(__('Number of Apply Job Month Exceed '));
	// 	//	return $this->redirect(SITE_URL.'/jobpost/applyjob/'.$jobid);


	// 	//}	


	// }

	// This function  will work when talent will Aply Multiple 
	public function aplymultiple()
	{

		$this->loadModel('JobApplication');
		$this->loadModel('Packfeature');

		if ($this->request->is(['post'])) {

			pr($this->request->data);
			exit;

			$loprun = 0;
			foreach ($this->request->data['job_id'] as $key => $value) {
				$loprun++;
			}
			$user_id = $this->request->session()->read('Auth.User.id');
			$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();


			$response = array();
			if ($loprun > $packfeature['number_job_application_daily']) {
				$response['daily'] = 1;
				$response['message'] = "You have Exceed the Daily Limit You have left only " . $packfeature['number_job_application_daily'] . " Please De select job";
				echo json_encode($response);
				die;
			} else if ($loprun > $packfeature['number_job_application_month']) {
				$response['month'] = 1;
				$response['message'] = "You have Exceed the month Limit Please Deselect One job";
				echo json_encode($response);
				die;
			}

			$i = 0;

			foreach ($this->request->data['job_id'] as $key => $value) {
				$user_id = $this->request->session()->read('Auth.User.id');
				$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
				$packfeature_id = $packfeature['id'];
				$number_jobmonth = $packfeature['number_job_application_month'];
				$number_jobday = $packfeature['number_job_application_daily'];

				$jobaplyperday = $this->JobApplication->find('all')->where(['JobApplication.user_id' => $this->request->session()->read('Auth.User.id'), 'JobApplication.created' => date('Y-m-d')])->count();

				$JobApplication = $this->JobApplication->newEntity();

				$jobapplydata['user_id'] = $this->request->session()->read('Auth.User.id');
				$jobapplydata['talent_accepted_status'] = "Y";
				$jobapplydata['job_id'] = $this->request->data['job_id'][$i];
				$job[] = $this->request->data['job_id'][$i];
				//pr($job);
				$jobapplydata['skill_id'] = $this->request->data['skill'][$i];

				$JobApplicationdata = $this->JobApplication->patchEntity($JobApplication, $jobapplydata);
				if ($resu = $this->JobApplication->save($JobApplicationdata)) {

					$packfeature = $this->Packfeature->get($packfeature_id);
					$feature_info['number_job_application_daily'] = $number_jobday - 1;
					$feature_info['number_job_application_month'] = $number_jobmonth - 1;
					$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
					$this->Packfeature->save($features_arr);
				}

				//$Job[]=$this->request->data['job_id'.$i];

				$i++;
			}
			$response['success'] = 2;
			$response['jobarray'] = $job;
			echo json_encode($response);
			die;
			//return $this->redirect(SITE_URL.'/viewprofile');
		}
	}

	public function aplysendquotemultiple()
	{
		$this->loadModel('JobQuote');
		$this->loadModel('Packfeature');

		if ($this->request->is(['post'])) {
			pr($this->request->data);
			die;

			$loprun = count($this->request->data);
			// echo $loprun=round($loprun, 0);
			$count = 0;
			$i = 0;

			foreach ($this->request->data['job_id'] as $key => $value) {
				$count++;
			}

			$user_id = $this->request->session()->read('Auth.User.id');
			$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();

			$response = array();

			if ($count > $packfeature['number_of_quote_daily']) {
				$response['success'] = false;
				$response['message'] = "You have Exceed the Daily Limit You have left only " . $packfeature['number_of_quote_daily'] . " Please De select job";

				echo json_encode($response);
				die;
			}

			foreach ($this->request->data['job_id'] as $key => $value) {

				$user_id = $this->request->session()->read('Auth.User.id');
				$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
				$packfeature_id = $packfeature['id'];
				$number_day = $packfeature['number_of_quote_daily'];
				$JobQuote = $this->JobQuote->newEntity();
				$sendQuote['user_id'] = $user_id;
				$sendQuote['talent_accepted_status'] = "Y";
				$sendQuote['job_id'] = $this->request->data['job_id'][$i];
				$sendQuote['amt'] = $this->request->data['amt'][$i];
				$sendQuote['status'] = 'N';
				$sendQuote['nontalent_satus'] = 'Y';
				$job[] = $this->request->data['job_id'][$i];
				//pr($job);
				$sendQuote['skill_id'] = $this->request->data['skill'][$i];

				$JobApplicationdata = $this->JobQuote->patchEntity($JobQuote, $sendQuote);
				if ($resu = $this->JobQuote->save($JobApplicationdata)) {
					$packfeature = $this->Packfeature->get($packfeature_id);
					$feature_info['number_of_quote_daily'] = $number_day - 1;
					$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
					$this->Packfeature->save($features_arr);
				}
				$i++;
			}
			$response['success'] = true;
			$response['jobarray'] = $job;
			echo json_encode($response);
			die;

			//return $this->redirect(SITE_URL.'/viewprofile');
		}
	}

	public function showJobapplied($status)
	{

		$this->loadModel('JobApplication');
		$this->loadModel('JobQuote');
		$id = $this->request->session()->read('Auth.User.id');

		// applied job data
		$jobdata = $this->JobApplication->find('all')
			->contain(['Requirement' => array('Eventtype', 'Users', 'JobApplication')])
			->where(['JobApplication.user_id' => $id, 'JobApplication.nontalent_aacepted_status' => 'N', 'JobApplication.talent_accepted_status' => 'Y', 'JobApplication.ping' => 0])->toarray();
		$this->set('jobdata', $jobdata);

		//ping data 
		$pingdata = $this->JobApplication->find('all')->contain(['Requirement' => array('Eventtype', 'Users', 'JobApplication')])->where(['JobApplication.user_id' => $id, 'JobApplication.nontalent_aacepted_status' => 'N', 'JobApplication.talent_accepted_status' => 'Y', 'JobApplication.ping' => 1])->toarray();
		$this->set('pingdata', $pingdata);

		// sent quote data
		$sendquotedata = $this->JobQuote->find('all')->contain(['Skill', 'Requirement' => ['Eventtype', 'Users', 'RequirmentVacancy' => ['Skill', 'Currency']]])->where(['JobQuote.user_id' => $id, 'JobQuote.amt !=' => '0', 'JobQuote.status' => 'N', 'JobQuote.nontalent_satus' => 'Y'])->order(['JobQuote.id' => 'DESC'])->toarray();
		$this->set('sendquotedata', $sendquotedata);

		// sent quote data
		$sendreviseddata = $this->JobQuote->find('all')->contain(['Skill', 'Requirement' => ['Eventtype', 'Users', 'RequirmentVacancy' => ['Skill', 'Currency']]])->where(['JobQuote.user_id' => $id, 'JobQuote.revision !=' => 0, 'JobQuote.amt !=' => '0', 'JobQuote.status' => 'N', 'JobQuote.nontalent_satus' => 'Y'])->order(['JobQuote.id' => 'DESC'])->toarray();
		$this->set('sendreviseddata', $sendreviseddata);

		// paid quote data
		$paidquotedata = $this->JobQuote->find('all')->contain(['Skill', 'Requirement' => ['Eventtype', 'Users', 'RequirmentVacancy' => ['Skill', 'Currency']]])->where(['JobQuote.user_id' => $id, 'JobQuote.paid_quote' => 'Y'])->order(['JobQuote.id' => 'DESC'])->toarray();
		$this->set('paidquotedata', $paidquotedata);

		$this->set('status', $status);
	}


	public function jobquotereject($id, $jobid)
	{
		$this->loadModel('JobQuote');
		if (isset($id) && !empty($id)) {
			$status = 'R';
			$Country = $this->JobQuote->get($id);
			$Country->status = $status;
			if ($this->JobQuote->save($Country)) {
				$this->Flash->success(__('Quote  status has been updated.'));
				return $this->redirect(SITE_URL . "/applyjob/" . $jobid);
			}
		}
	}
	// selected jobs
	public function showJobselected()
	{
		$this->loadModel('JobApplication');
		$this->loadModel('JobQuote');
		$this->loadModel('RequirmentVacancy');
		$id = $this->request->session()->read('Auth.User.id');
		// pr($id);die;

		// get selected job data
		$jobdata = $this->JobApplication->find('all')
			->contain(['Users' => ['Profile', 'Professinal_info'], 'Skill', 'Requirement' => array('RequirmentVacancy' => ['Skill', 'Currency'], 'JobQuote', 'Eventtype', 'Users' => ['Profile', 'Professinal_info'])])
			->where([
				'JobApplication.user_id' => $id,
				// 'JobApplication.nontalent_aacepted_status' => 'R',
				'JobApplication.nontalent_aacepted_status' => 'Y',
				'JobApplication.talent_accepted_status' => 'Y',
				// 'JobApplication.viewedstatus' => 'Y',
				// 'JobApplication.jobstatus' => 'SR'
			])
			->toarray();
		// pr($jobdata);exit;

		$this->set('jobdata', $jobdata);
	}

	public function respondQuote($id)
	{
		$this->loadModel('Requirement');
		$this->loadModel('JobQuote');
		$this->loadModel('Currency');
		$this->loadModel('Paymentfequency');

		$details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City', 'Users', 'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']])->where(['Requirement.id' => $id])->first();
		// pr($details['requirment_vacancy']);exit;
		$this->set('requirement_data', $details);

		$Currency = $this->Currency->find('all')
			->select(['id', 'name', 'currencycode', 'symbol'])
			->order(['name' => 'ASC', 'id' => 'ASC'])
			->all()
			->combine(
				'id',
				function ($row) {
					return $row->name . ' (' . $row->currencycode . ' - ' . $row->symbol . ')';
				}
			)
			->toArray();
		$this->set('Currency', $Currency);

		$payfreq = $this->Paymentfequency->find('list')->toarray();
		$this->set('payfreq', $payfreq);

		$jobdquoteexit = $this->JobQuote->find('all')->where(['JobQuote.job_id' => $id, 'JobQuote.user_id' => $this->request->session()->read('Auth.User.id')])->first();
		$quoteid = $jobdquoteexit['id'];
		$skill_id = $jobdquoteexit['skill_id'];
		// pr($jobdquoteexit);exit;
		$this->set('quoteid', $quoteid);
		$this->set('skill_id', $skill_id);
		$this->set('jobdquoteexit', $jobdquoteexit);
	}

	public function SendQoute()
	{
		$this->loadModel('JobQuote');
		$this->loadModel('Packfeature');


		if ($this->request->is(['post', 'put'])) {
			// pr($this->request->data);
			// die;
			$user_id = $this->request->session()->read('Auth.User.id');
			$id = $this->request->data['job_idprimary'];
			//echo $user_id; die;
			$packfeature = $this->activePackage();
			$packfeature_id = $packfeature['id'];
			$number_quotemonth = $packfeature['number_of_quote_daily'];
			$number_of_free_quotes = $packfeature['number_of_free_quotes'];
			$jobid = $this->request->data['job_id'];
			$this->Set('number_quotemonth', $number_quotemonth);
			$this->Set('number_of_free_quotes', $number_of_free_quotes);

			// $jobaplyperday = $this->JobQuote->find('all')->where(['JobQuote.user_id' => $user_id, 'JobQuote.created' => date('Y-m-d'), 'JobQuote.amt !=' => 0])->count();
			// pr($jobaplyperday);exit;

			if ($id) {

				if (isset($id) && !empty($id)) {
					$JobQuote = $this->JobQuote->get($id);
				} else {
					$JobQuote = $this->JobQuote->newEntity();
				}

				$this->request->data['status'] = 'N';
				$this->request->data['user_id'] = $user_id;
				$this->request->data['skill_id'] = $this->request->data['skill'];
				$Jobquotedata = $this->JobQuote->patchEntity($JobQuote, $this->request->data);
				// pr($Jobquotedata);exit;
				if ($resu = $this->JobQuote->save($Jobquotedata)) {
					$this->Flash->success(__('You Sent Quote on ' . date('d F Y')));
				}
				return $this->redirect(SITE_URL . '/applyjob/' . $jobid);
			} else {
				//$this->Flash->error(__('Limit reached. Buy Ask for Quote Rights For < Job Title>'));
				$this->Flash->error(__('You cannot send more free quotes today. You can now Send Paid quotes'));
				return $this->redirect(SITE_URL . '/applyjob/' . $jobid);
			}
		}
	}

	// public function aplysingle()
	// {

	// 	$this->loadModel('JobApplication');
	// 	$this->loadModel('Packfeature');
	// 	if ($this->request->is(['post'])) {

	// 		$user_id = $this->request->session()->read('Auth.User.id');
	// 		$roleId = $this->request->session()->read('Auth.User.role_id');
	// 		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
	// 		$packfeature = $this->activePackage(); // comes from add controller data is from Packfeature table
	// 		pr($packfeature);exit;
	// 		$response = array();
	// 		if ($packfeature['number_job_application_daily'] == 0) {
	// 			$response['daily'] = 1;
	// 			$response['message'] = "You Have Exceed the Daily Limit You have left only " . $packfeature['number_job_application_daily'] . " Please De select job";
	// 			echo json_encode($response);
	// 			die;
	// 		} else if ($packfeature['number_job_application_month'] == 0) {
	// 			$response['month'] = 1;
	// 			$response['message'] = "You have Exceed the month Limit";
	// 			echo json_encode($response);
	// 			die;
	// 		}
	// 		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
	// 		$packfeature_id = $packfeature['id'];
	// 		$number_jobmonth = $packfeature['number_job_application_month'];
	// 		$number_jobday = $packfeature['number_job_application_daily'];

	// 		$number_jobday_used = $packfeature['number_job_application_daily_used'];
	// 		$number_jobmonth_used = $packfeature['number_job_application_month_used'];

	// 		$jobaplyperday = $this->JobApplication->find('all')->where(['JobApplication.user_id' => $user_id, 'JobApplication.created' => date('Y-m-d')])->count();

	// 		$JobApplication = $this->JobApplication->newEntity();

	// 		$this->request->data['user_type'] = $roleId;
	// 		$this->request->data['package_id'] = $packfeature_id;
	// 		$this->request->data['user_id'] = $user_id;
	// 		$this->request->data['talent_accepted_status'] = "Y";
	// 		$this->request->data['job_id'] = $this->request->data['job_id'];
	// 		$job[] = $this->request->data['job_id' . $i];
	// 		$this->request->data['skill_id'] = $this->request->data['skill'];

	// 		$JobApplicationdata = $this->JobApplication->patchEntity($JobApplication, $this->request->data);
	// 		if ($resu = $this->JobApplication->save($JobApplicationdata)) {
	// 			$packfeature = $this->Packfeature->get($packfeature_id);
	// 			$feature_info['number_job_application_daily_used'] = $number_jobday_used + 1;
	// 			$feature_info['number_job_application_month_used'] = $number_jobmonth_used + 1;
	// 			$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
	// 			$this->Packfeature->save($features_arr);
	// 		}

	// 		$response['success'] = 2;
	// 		$response['jobarray'] = $job;
	// 		echo json_encode($response);
	// 		die;
	// 	}
	// }



	// public function aplysendquotesingle()
	// {
	// 	$this->loadModel('JobQuote');
	// 	$this->loadModel('Packfeature');

	// 	if ($this->request->is(['post'])) {

	// 		$loprun = count($this->request->data);
	// 		// echo $loprun=round($loprun, 0);
	// 		$count = 1;
	// 		pr($this->request->data);

	// 		$user_id = $this->request->session()->read('Auth.User.id');
	// 		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();

	// 		$packfeature = $this->activePackage(); // comes from add controller data is from Packfeature table
	// 		$packfeature_id = $packfeature['id'];
	// 		$totalDatilyLimit = $packfeature['number_of_quote_daily'];
	// 		$totalUsed = $feature_info['number_of_quote_daily_used'];
	// 		pr($packfeature);exit;

	// 		$response = array();

	// 		if ($count > $packfeature['number_of_quote_daily']) {
	// 			$response['success'] = false;
	// 			$response['message'] = "You have Exceed the Daily Limit You have left only " . $packfeature['number_of_quote_daily'] . " Please deselect Job";

	// 			echo json_encode($response);
	// 			die;
	// 		}

	// 		for ($i = 0; $i < $count; $i++) {

	// 			$user_id = $this->request->session()->read('Auth.User.id');
	// 			$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();


	// 			$number_day = $packfeature['number_of_quote_daily'];

	// 			$JobQuote = $this->JobQuote->newEntity();

	// 			$this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');
	// 			$this->request->data['talent_accepted_status'] = "Y";
	// 			$this->request->data['job_id'] = $this->request->data['job_id'];
	// 			$this->request->data['amt'] = $this->request->data['amt'];
	// 			$this->request->data['status'] = 'N';
	// 			$this->request->data['nontalent_satus'] = 'Y';
	// 			$job[] = $this->request->data['job_id'];
	// 			//pr($job);
	// 			$this->request->data['skill_id'] = $this->request->data['skill'];

	// 			$JobApplicationdata = $this->JobQuote->patchEntity($JobQuote, $this->request->data);
	// 			if ($resu = $this->JobQuote->save($JobApplicationdata)) {
	// 				$packfeature = $this->Packfeature->get($packfeature_id);
	// 				$feature_info['number_of_quote_daily_used'] = $number_day + 1;
	// 				$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
	// 				$this->Packfeature->save($features_arr);
	// 			}
	// 			//$Job[]=$this->request->data['job_id'.$i];
	// 		}

	// 		$response['success'] = true;
	// 		echo json_encode($response);
	// 		die;

	// 		//return $this->redirect(SITE_URL.'/viewprofile');
	// 	}
	// }

}
