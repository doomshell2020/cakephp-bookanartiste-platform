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
use Cake\Routing\Router;

class RequirementController extends AppController
{

	public function initialize()
	{
		parent::initialize();
		$this->loadModel('Users');
		//$this->Auth->allow(['jobunfeaturecron']);
	}

	/*public function jobunfeaturecron()
	{
		$isServicedone=$this->Requirement->updateAll(array('amt_pending' =>'0','amt_released'=>$amt_released,'status'=>'C','service_status'=>'Y'),array('id' => $servieid));
	}
*/
	//wget -q -O - https://www.propertybull.com/alert_mail_cron.php/ >/dev/null 2>&1

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


		$currentDate = date('Y-m-d H:m:s');
		$id = $this->request->session()->read('Auth.User.id');
		$profile = $this->Profile->find('all')->contain(['Users'])->where(['user_id' => $id])->first();

		$requirementfeatured = $this->Requirement->find('all')
			->contain(['JobView', 'BookingRequest', 'JobQuote', 'JobApplication'])
			->where(['Requirement.user_id' => $id])
			->order(['Requirement.id' => 'DESC'])
			->toarray();

		foreach ($requirementfeatured as $value) {
			if (strtotime($value['last_date_app']) < strtotime($currentDate)) {
				$Requirement = $this->Requirement->get($value['id']);
				$Requirement->status = 'N';
				$this->Requirement->save($Requirement);
			}
		}

		$quoterevised = $this->JobQuote->find('all')->contain(['Users' => ['Profile', 'Professinal_info']])->where(['JobQuote.revision !=' => 0])->order(['JobQuote.id' => 'DESC'])->count();

		$this->set(compact('quoterevised', 'profile', 'requirementfeatured'));
	}


	public function status($id, $status)
	{
		$this->loadModel('Users');
		$this->loadModel('Requirement');
		$this->loadModel('Packfeature');
		$Job = $this->Requirement->find('all')->where(['jobdelete_status' => 'N', 'id' => $id])->first();
		// pr($Job); exit;
		$currentdate = date('Y-m-d H:m:s');
		if ($Job) {
			$talent = $this->Requirement->get($id);
			// pr($talent);exit;
			if ($status == 'N') {
				$talent->status = $status;
				if ($this->Requirement->save($talent)) {
					$this->Flash->success(__('Job has been successfully deactivated'));
					$this->redirect(Router::url($this->referer(), true));
				}
			} else {
				$packfeature = $this->Packfeature->find('all')
					// ->where(['user_id' => $talent['user_id'], 'id' => $Job['package_id']])
					->where(['user_id' => $talent['user_id']])
					->first();

				$total_active_requirement = $this->Requirement->find('all')
					->where([
						'Requirement.user_id' => $talent['user_id'],
						'status' => 'Y'
					])
					->count();

				// Fetch the requirements with expired last_date_app
				$expired_requirements = $this->Requirement->find('all')
					->where([
						'Requirement.id' => $id,
						'DATE(Requirement.last_date_app) < ' => $currentdate, // Expired
					])
					->count();
				// pr($packfeature);
				// pr($expired_requirements);
				// exit;

				if ($expired_requirements > 0) {
					$this->Flash->error(__('This job has expired'));
					$this->redirect(Router::url($this->referer(), true));
				} elseif ($total_active_requirement >= $packfeature['number_of_job_simultancney']) {
					$this->Flash->error(__('You cannot make this job active as you can post ' . $packfeature['number_of_job_simultancney'] . ' simultaneously. Please make an active job inactive to take this action'));
					$this->redirect(Router::url($this->referer(), true));
				} else {
					$talent->status = $status;

					if ($this->Requirement->save($talent)) {
						$this->Flash->success(__('Job has been successfully activated'));
					} else {
						$errors = $this->Requirement->getErrors();
						$this->Flash->error(__($errors));
					}

					$this->redirect(Router::url($this->referer(), true));
				}
			}
		} else {
			$this->Flash->error(__('Job has been deactivated by admin.'));
			$this->redirect(Router::url($this->referer(), true));
		}
	}

	// new created by rupam singh 
	public function statusv1($id, $status)
	{
		$this->loadModel('Users');
		$this->loadModel('Requirement');
		$this->loadModel('Packfeature');

		$Job = $this->Requirement->find('all')->where(['jobdelete_status' => 'N', 'id' => $id])->first();
		if ($Job) {
			$talent = $this->Requirement->get($id);

			// Fetch package features for the user
			$packfeature = $this->Packfeature->find('all', [
				'conditions' => [
					'user_id' => $talent['user_id'],
					'id' => $talent['package_id']
				],
				'order' => ['Packfeature.id' => 'DESC'],
				'limit' => 1
			])->first();

			if ($packfeature) {
				// Determine the field to update based on user role
				$fieldToUpdate = $talent['user_role_id'] == NONTALANT_ROLEID
					? 'non_telent_number_of_job_post_used'
					: 'number_of_job_post_used';

				$jobLimit = $talent['user_role_id'] == NONTALANT_ROLEID
					? $packfeature['non_telent_number_of_job_post']
					: $packfeature['number_of_job_post'];

				// **Check if the limit is reached before updating the job**
				if ($status == 'Y' && $packfeature[$fieldToUpdate] >= $jobLimit) {
					$this->Flash->error(__('Job posting limit reached.'));
					return $this->redirect($this->referer());
				}

				// ✅ Only update the job if the limit is not exceeded
				$talent->status = $status;

				if ($this->Requirement->save($talent)) {
					// Increment or decrement based on status
					if ($status == 'Y') {
						// Increment the usage count
						$packfeature = $this->Packfeature->patchEntity($packfeature, [
							$fieldToUpdate => $packfeature[$fieldToUpdate] + 1
						]);
						// $limitChangeMessage = __(
						// 	'Limit has been increased for {0}.',
						// 	$talent['user_role_id'] == NONTALANT_ROLEID ? 'Non-Talent Profile' : 'Talent Profile'
						// );
					} else {
						// Decrement the usage count safely
						$packfeature = $this->Packfeature->patchEntity($packfeature, [
							$fieldToUpdate => max(0, $packfeature[$fieldToUpdate] - 1) // Prevent negative values
						]);
						// $limitChangeMessage = __(
						// 	'Limit has been decreased for {0}.',
						// 	$talent['user_role_id'] == NONTALANT_ROLEID ? 'Non-Talent Profile' : 'Talent Profile'
						// );
					}

					$this->Packfeature->save($packfeature);

					// Set success message based on status and limit change
					$message = $status == 'N'
						? __('Job has been successfully deactivated.')
						: __('Job has been successfully activated.');

					$this->Flash->success($message);
				} else {
					$errors = $this->Requirement->getErrors();
					$this->Flash->error(__('Error: Unable to update job status. {0}', json_encode($errors)));
				}
			}

			return $this->redirect($this->referer());
		} else {
			$this->Flash->error(__('Job has been deactivated by admin.'));
			$this->redirect(Router::url($this->referer(), true));
		}
	}

	public function status_backup($id, $status)
	{
		$this->loadModel('Users');
		$this->loadModel('Requirement');
		$this->loadModel('Packfeature');
		$Job = $this->Requirement->find('all')->where(['jobdelete_status' => 'N', 'id' => $id])->first();
		// pr($Job);exit;
		$currentdate = date('Y-m-d H:m:s');
		if ($Job) {
			$talent = $this->Requirement->get($id);
			if ($status == 'N') {
				$talent->status = $status;
				if ($this->Requirement->save($talent)) {
					$this->Flash->success(__('Job has been successfully deactivated'));
					$this->redirect(Router::url($this->referer(), true));
				}
			} else {
				$packfeature = $this->Packfeature->find('all')
					->where(['user_id' => $talent['user_id'], 'id' => $Job['package_id']])
					->first();

				$total_active_requirement = $this->Requirement->find('all')->where(['Requirement.user_id' => $talent['user_id'], 'DATE(Requirement.last_date_app) >=' => $currentdate, 'status' => 'Y'])->count();

				if ($total_active_requirement >= $packfeature['number_of_job_simultancney']) {
					$this->Flash->error(__('You cannot make this job active as you can post ' . $packfeature['number_of_job_simultancney'] . ' simultaneously. Please make an active job inactive to take this action'));
					$this->redirect(Router::url($this->referer(), true));
				} else {
					$talent->status = $status;
					// pr($talent);exit;
					if ($this->Requirement->save($talent)) {
						$this->Flash->success(__('Job has been successfully activated'));
						$this->redirect(Router::url($this->referer(), true));
					} else {
						$errors = $this->Requirement->getErrors();
						$this->Flash->error(__($errors));
						// pr($errors);  // Check if there are any validation errors
						// exit;
					}
				}
			}
		} else {
			$this->Flash->error(__('Job has been deactivated by admin.'));
			$this->redirect(Router::url($this->referer(), true));
		}
	}

	public function overallrating()
	{
		$overallrating = $this->request->data['avgtotal'];
		$overrating = round($overallrating / 8, 1);
		echo json_encode($overrating);
		die;
	}

	//feature jobs functionality...
	public function featureRequirment()
	{

		$this->loadModel('Requirement');
		$this->loadModel('Users');
		$currentdate = date('Y-m-d H:m:s');
		$session = $this->request->session();
		$session->delete('featurejobsearching');

		$user_id = $this->request->session()->read('Auth.User.id');

		$Job = $this->Requirement->find('all')->contain(['Eventtype', 'Users', 'Featuredjob', 'RequirmentVacancy' => ['Skill']])->where(['DATE(Requirement.last_date_app) >=' => $currentdate, 'Requirement.status' => 'Y', 'Requirement.user_id' => $user_id])->order(['Requirement.id' => 'DESC'])->toarray();

		$this->set('Job', $Job);
	}

	public function featuredRequirment()
	{

		$this->loadModel('Requirement');
		$this->loadModel('Users');
		$currentdate = date('Y-m-d H:m:s');

		//$session = $this->request->session(); 
		//$session->delete('featurejobsearching');

		$user_id = $this->request->session()->read('Auth.User.id');

		$Job = $this->Requirement->find('all')->contain(['Eventtype', 'Users', 'Featuredjob'])->where(['DATE(Requirement.expiredate) >=' => $currentdate, 'Requirement.status' => 'Y', 'Requirement.user_id' => $user_id])->order(['Requirement.id' => 'DESC'])->toarray();
		$this->set('Job', $Job);
	}

	public function requirsearch()
	{
		$this->loadModel('Users');
		$this->loadModel('Requirement');
		//pr($this->request->data); die;
		$currentdate = date('Y-m-d H:m:s');
		$status = $this->request->data['status'];
		$name = $this->request->data['name'];
		/*$email = $this->request->data['email'];
	    $from_date = $this->request->data['from_date'];
	    $to_date = $this->request->data['to_date'];*/
		$user_id = $this->request->session()->read('Auth.User.id');
		$cond = [];


		if (!empty($name)) {
			$cond['Requirement.title LIKE'] = "%" . $name . "%";
		}


		$this->request->session()->write('featurejobsearching', $cond);

		$Job = $this->Requirement->find('all')->contain(['Eventtype', 'Users', 'Featuredjob', 'RequirmentVacancy' => ['Skill']])->where([$cond, 'DATE(Requirement.last_date_app) >=' => $currentdate, 'Requirement.status' => 'Y', 'Requirement.user_id' => $user_id])->order(['Requirement.id' => 'DESC'])->toarray();
		$this->set('Job', $Job);
	}

	public function requirexcel()
	{

		$currentdate = date('Y-m-d H:m:s');
		$this->loadModel('Users');
		$this->loadModel('Requirement');
		$this->autoRender = false;
		$user_id = $this->request->session()->read('Auth.User.id');
		$blank = "NA";
		$output = "";

		$output .= '"Sr Number",';
		$output .= '"Job Title",';
		$output .= '"User Name",';
		$output .= '"User Email Id",';
		$output .= '"Feature Start Date",';
		$output .= '"Feature End Date",';
		$output .= '"Number of Days",';
		$output .= '"Total Price Paid",';
		$output .= '"Status",';
		$output .= "\n";
		//pr($job); die;
		$str = "";

		$cond = $this->request->session()->read('featurejobsearching');


		$banners = $this->Requirement->find('all')->contain(['Eventtype', 'Users', 'Featuredjob'])->where([$cond, 'Requirement.status' => 'Y', 'Requirement.user_id' => $user_id])->order(['Requirement.id' => 'DESC'])->toarray();
		//pr($talents); die;
		$cnt = 1;
		foreach ($banners as $admin) {
			$fromdate = date('Y-m-d', strtotime($admin['feature_job_date']));
			$todate = date('Y-m-d', strtotime($admin['expiredate']));

			$output .= $cnt . ",";
			$output .= $admin['title'] . ",";
			$output .= $admin['user']['user_name'] . ",";
			$output .= $admin['user']['email'] . ",";
			if ($admin['feature_job_date']) {
				$output .= $fromdate . ",";
			} else {
				$output .= "NA,";
			}

			if ($admin['expiredate']) {
				$output .= $todate . ",";
			} else {
				$output .= "NA,";
			}

			$output .= $admin['feature_job_days'] . "days ,";
			$output .= "$" . $admin['feature_job_days'] * $admin['featuredjob']['price'] . ",";

			if ($admin['featured'] == 'Y') {
				$output .= "Featured";
			} else {
				$output .= "NA,";
			}

			$cnt++;
			$output .= "\r\n";
		}

		$filename = "Feature-Job.xlsx";
		header('Content-type: application/xlsx');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		die;
		$this->redirect($this->referer());
	}
	//feature jobs functionality ends ...


	public function talentrating($job_id = null, $artist_id = null)
	{
		$this->set('job_id', $job_id);
		$this->set('artist_id', $artist_id);
		$this->loadModel('Review');

		if (isset($this->request->data['job_id'])) {
			$profiled = $this->Review->find('all')->where(['Review.job_id' => $this->request->data['job_id']])->first();
		} else {

			$profiled = $this->Review->find('all')->where(['Review.job_id' => $job_id])->first();
		}
		$jobreview = count($profiled);
		$id = $profiled['id'];
		if ($jobreview > 0) {
			$review  = $this->Review->find('all')->where(['Review.id' => $id])->first();
		} else {
			$review = $this->Review->newEntity();
		}
		$this->set('review', $review);
		$this->loadModel('JobApplication');

		$jobdetail = $this->JobApplication->find('all')->contain(['Requirement', 'Skill', 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']])->where(['JobApplication.job_id' => $job_id])->order(['JobApplication.id' => 'DESC'])->first();
		$this->set('jobdetail', $jobdetail);
		$id = $this->request->session()->read('Auth.User.id');

		if ($this->request->is(['post', 'put'])) {

			if (empty($this->request->data['avgrating'])) {
				$rating = $this->request->data['r1'] + $this->request->data['r2'] + $this->request->data['r3'] + $this->request->data['r4'] + $this->request->data['r5'] + $this->request->data['r6'] + $this->request->data['r7'] + $this->request->data['r8'];
				$this->request->data['avgrating'] = $rating / 8;
			}
			$this->request->data['avgrating'] = number_format($this->request->data['avgrating'], 1);
			// pr($this->request->data); die;

			$currentdate = date("Y-m-d H:m:s");
			$lastreviewdate = date('Y-m-d H:m:s', strtotime($profiled['created']));
			if ($currentdate > $lastreviewdate) {
				//   pr($this->request->data); die;
				$this->request->data['nontalent_id'] = $id;
				$reviews = $this->Review->patchEntity($review, $this->request->data);
				if ($this->Review->save($reviews)) {
					$this->Flash->success(__('Talent  Review successfully saved!!'));
					return $this->redirect(['action' => 'requirement']);
				}
			} else {
				$this->Flash->success(__('Review Time is closed!!'));
				return	$this->redirect($this->referer());
			}
		}
	}

	public function deleteapplication($id)
	{
		$this->autoRender = false;
		$this->loadModel('JobApplication');
		$JobQuote = $this->JobApplication->get($id);
		if ($this->JobApplication->delete($JobQuote)) {
			$this->Flash->success(__('Job Deleted Successfully'));
			return $this->redirect(['action' => 'requirement']);
		}
	}

	public function deletequotes($id)
	{
		$this->autoRender = false;
		$this->loadModel('JobQuote');
		$JobQuote = $this->JobQuote->get($id);
		if ($this->JobQuote->delete($JobQuote)) {
			return $this->redirect(['action' => 'requirement']);
		}
	}

	public function applicationreject($id)
	{
		$this->autoRender = false;
		$this->loadModel('JobApplication');
		$status = 'R';
		$Pack = $this->JobApplication->get($id);
		$Pack->nontalent_aacepted_status = $status;
		$Pack->jobstatus = "SR";
		if ($this->JobApplication->save($Pack)) {
			$this->eventreject($id);
			return $this->redirect(['action' => 'requirement']);
		}
	}

	public function eventreject($id)
	{
		$this->loadModel('JobApplication');
		$this->loadModel('Calendar');
		$this->autoRender = false;
		$bookingreceived = $this->JobApplication->find('all')->contain(['Skill', 'Requirement' => ['RequirmentVacancy' => ['Skill', 'Currency']]])->where(['JobApplication.id' => $id])->first();
		$job_id = $bookingreceived['job_id'];
		$calendarrec = $this->Calendar->find('all')->where(['Calendar.event_id' => $job_id])->first();
		if ($calendarrec) {
			$cal = $this->Calendar->get($calendarrec['id']);
			$this->Calendar->delete($cal);
		}
	}

	public function applicationselect($id, $skill, $jobid)
	{

		$this->autoRender = false;
		$this->loadModel('JobApplication');
		$this->loadModel('RequirmentVacancy');


		$numberofVcountdata = $this->RequirmentVacancy->find('all')->contain(['Requirement'])->where(['RequirmentVacancy.requirement_id' => $jobid, 'RequirmentVacancy.telent_type' => $skill])->first()->toarray();

		$numberofvcount = $numberofVcountdata['number_of_vacancy'];
		$selectedcount = $this->JobApplication->find('all')->where(['JobApplication.job_id' => $jobid, 'JobApplication.nontalent_aacepted_status' => 'Y', 'JobApplication.talent_accepted_status' => 'Y'])->count();

		// pr($numberofvcount);
		// pr($selectedcount);exit;
		if ($selectedcount < $numberofvcount) {
			$status = 'Y';
			$Pack = $this->JobApplication->get($id);
			$Pack->nontalent_aacepted_status = $status;
			$Pack->talent_accepted_status = $status;
			$Pack->viewedstatus = $status;
			$Pack->jobstatus = "SR";
			// pr($Pack);exit;
			$result = $this->JobApplication->save($Pack);
			if ($result) {
				$this->eventselect($id);
				return $this->redirect(['action' => 'requirement']);
			}
		} else {
			$this->Flash->error(__('You Can select only vacancies Limited Talent'));
			return $this->redirect(['action' => 'requirement']);
		}
	}

	public function eventselect($id)
	{
		$this->autoRender = false;
		$this->loadModel('JobApplication');
		$this->loadModel('Calendar');
		$bookingreceived = $this->JobApplication->find('all')->contain(['Skill', 'Requirement' => ['Eventtype']])->where(['JobApplication.id' => $id])->first();
		//pr($bookingreceived); die;
		$eventfrom = date('Y-m-d H:i', strtotime($bookingreceived['requirement']['event_from_date']));
		$eventto = date('Y-m-d H:i', strtotime($bookingreceived['requirement']['event_to_date']));
		$job_id = $bookingreceived['job_id'];
		$title = $bookingreceived['requirement']['title'];
		$location = $bookingreceived['requirement']['location'];
		$eventtype = $bookingreceived['requirement']['eventtype']['name'];
		$req_dis = $bookingreceived['requirement']['talent_requirement_description'];
		$user_id = $bookingreceived['user_id'];
		$type = "EV";
		$calendarrec = $this->Calendar->find('all')->where(['Calendar.event_id' => $job_id])->count();

		if ($calendarrec > 0) {
		} else {
			$proff = $this->Calendar->newEntity();
			$this->request->data['from_date'] = $eventfrom;
			$this->request->data['to_date'] = $eventto;
			$this->request->data['type'] = $type;
			$this->request->data['user_id'] = $user_id;
			$this->request->data['event_id'] = $job_id;
			$this->request->data['title'] = $title;
			$this->request->data['location'] = $location;
			$this->request->data['eventtype'] = $eventtype;
			$this->request->data['description'] = $req_dis;
			$eventadd = $this->Calendar->patchEntity($proff, $this->request->data);
			$this->Calendar->save($eventadd);
		}
	}

	public function quoteselect($id, $status)
	{

		$this->autoRender = false;
		$this->loadModel('JobQuote');
		$this->loadModel('JobApplication');
		$this->loadModel('JobQuote');
		$jobfind = $this->JobQuote->find('all')->where(['JobQuote.id' => $id])->order(['JobQuote.id' => 'DESC'])->first();

		if ($status == 'S') {
			$status = 'S';
			$Pack = $this->JobQuote->get($id);
			$Pack->status = $status;
			if ($this->JobQuote->save($Pack)) {
				$applicationstatus = 'Y';
				$job_application['nontalent_aacepted_status'] = $applicationstatus;
				$job_application['talent_accepted_status'] = $applicationstatus;
				$job_application['user_id'] = $jobfind['user_id'];
				$job_application['job_id'] = $jobfind['job_id'];
				$job_application['skill_id'] = $jobfind['skill_id'];
				$jobappfind = $this->JobApplication->find('all')->where(['JobApplication.user_id' => $jobfind['user_id'], 'JobApplication.job_id' => $jobfind['job_id']])->order(['JobQuote.id' => 'DESC'])->count();

				if ($jobappfind > 0) {
					$con = ConnectionManager::get('default');

					$detail = 'UPDATE `job_application` SET `nontalent_aacepted_status` ="' . $applicationstatus . '" WHERE `job_application`.`job_id` = ' . $jobfind['job_id'] . ' AND `job_application`.`user_id` = ' . $jobfind['user_id'];
					$results = $con->execute($detail);
				} else {
					$proff = $this->JobApplication->newEntity();
					$blockp = $this->JobApplication->patchEntity($proff, $job_application);
					$savelike = $this->JobApplication->save($blockp);
				}
				return $this->redirect(['action' => 'requirement']);
			}
		}
	}

	public function quotereject($id, $status)
	{

		$this->autoRender = false;
		$this->loadModel('JobQuote');
		$this->loadModel('JobApplication');
		$this->loadModel('JobQuote');
		$jobfind = $this->JobQuote->find('all')->where(['JobQuote.id' => $id])->order(['JobQuote.id' => 'DESC'])->first();

		if ($status == 'R') {
			$status = 'R';
			$Pack = $this->JobQuote->get($id);
			$Pack->status = $status;
			if ($this->JobQuote->save($Pack)) {
				$job_application['nontalent_aacepted_status'] = $status;
				$job_application['talent_accepted_status'] = $status;
				$job_application['user_id'] = $jobfind['user_id'];
				$job_application['job_id'] = $jobfind['job_id'];
				$job_application['skill_id'] = $jobfind['skill_id'];
				$jobappfind = $this->JobApplication->find('all')->where(['JobApplication.user_id' => $jobfind['user_id'], 'JobApplication.job_id' => $jobfind['job_id']])->order(['JobQuote.id' => 'DESC'])->count();
				if ($jobappfind > 0) {
					$con = ConnectionManager::get('default');

					$detail = 'UPDATE `job_application` SET `nontalent_aacepted_status` ="' . $status . '" WHERE `job_application`.`job_id` = ' . $jobfind['job_id'] . ' AND `job_application`.`user_id` = ' . $jobfind['user_id'];


					$results = $con->execute($detail);
				} else {

					$proff = $this->JobApplication->newEntity();
					$blockp = $this->JobApplication->patchEntity($proff, $job_application);
					$savelike = $this->JobApplication->save($blockp);
				}
				return $this->redirect(['action' => 'requirement']);
			}
		}
	}

	public function delete($id)
	{
		$this->loadModel('Requirement');
		$this->loadModel('JobQuote');
		$this->loadModel('JobApplication');
		$this->loadModel('Packfeature');

		$user_id = $this->request->session()->read('Auth.User.id');
		$jobquotefind = $this->JobQuote->find('all')->where(['JobQuote.job_id' => $id])->first();
		$jobappfind = $this->JobApplication->find('all')->where(['JobApplication.job_id' => $id])->first();

		if ($jobquotefind || $jobappfind) {
			$this->Flash->error(__('Job not deleted someone action this job'));
			return $this->redirect(['action' => 'requirement']);
		} else {
			$Requirement = $this->Requirement->get($id);

			if (!empty($Requirement->image)) {
				$imagePath = "job/" . $Requirement->image;
				// Check if image exists before deleting
				if (file_exists($imagePath)) {
					unlink($imagePath);
				}
			}

			// $status['jobdelete_status']='N';
			//  $updatestatus = $this->Requirement->patchEntity($Requirement, $status);
			//  $this->JobApplication->delete($JobQuote)
			if ($this->Requirement->delete($Requirement)) {
				$packfeature = $this->Packfeature->find('all', [
					'conditions' => [
						// 'user_id' => $user_id,
						'id' => $Requirement['package_id']
					],
					'order' => ['Packfeature.id' => 'DESC'],
					'limit' => 1 // Fetch only the most recent entry
				])->first();

				if ($packfeature) {
					// Determine which field to decrement based on user role
					$fieldToUpdate = $Requirement['user_role_id'] == NONTALANT_ROLEID
						? 'non_telent_number_of_job_post_used'
						: 'number_of_job_post_used';

					// Safely decrement the usage count
					$packfeature = $this->Packfeature->patchEntity($packfeature, [
						$fieldToUpdate => max(0, $packfeature[$fieldToUpdate] - 1) // Prevent negative values
					]);

					$this->Packfeature->save($packfeature);
				}

				$this->Flash->success(__('Job Deleted Successfully.'));
				// return $this->redirect(['action' => 'requirement']);
				return $this->redirect($this->referer());
			}
		}
	}

	public function amountquote($id = null)
	{
		$this->loadModel('JobQuote');
		$this->loadModel('Currency');
		$this->loadModel('Paymentfequency');
		$this->set('revisedid', $id);
		$revisedquote = $this->JobQuote->find('all')->where(['JobQuote.id' => $id])->order(['JobQuote.id' => 'DESC'])->first();
		$this->set('revisedquote', $revisedquote);

		$payfreq = $this->Paymentfequency->find('list')
			->select(['id', 'name'])
			->order(['name' => 'ASC', 'id' => 'ASC'])
			->all()
			->toarray();
		$this->set('payfreq', $payfreq);

		$currencies_list = $this->Currency->find('all')
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
		$this->set('currencies_list', $currencies_list);

		$nontalent_id = $this->request->session()->read('Auth.User.id');

		if ($this->request->is(['post', 'put'])) {

			// pr($this->request->data);exit;
			$revisedId = $this->request->data['revisedid'];
			$revision  = $this->request->data['revision'];
			$revised_payment_currency  = $this->request->data['revised_payment_currency'];
			$revised_payment_frequency  = $this->request->data['revised_payment_frequency'];

			$quoteExists = $this->JobQuote->exists(['id' => $revisedId]);

			if ($quoteExists) {
				$quote = $this->JobQuote->get($revisedId);
				$quote->nontalent_id = $nontalent_id;
				$quote->revision = $revision;
				$quote->revised_payment_currency = $revised_payment_currency;
				$quote->revised_payment_frequency = $revised_payment_frequency;

				if ($this->JobQuote->save($quote)) {
					$this->Flash->success(__('Quote sent successfully.'));
				} else {
					$this->Flash->error(__('Failed to send quote. Please try again.'));
				}
			} else {
				$this->Flash->info(__('Quote already sent.'));
			}

			return $this->redirect(['action' => 'requirement']);
		}
	}

	public function updatequote()
	{

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
		$this->loadModel('Userjobanswer');
		$this->loadModel('Jobquestion');
		$this->loadModel('Skill');

		// pr($this->request->data);
		if ($this->request->data['action'] == 'application') {
			$requirementfeatured = $this->JobApplication->find('all')->contain(['Requirement', 'Skill', 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']])->where(['JobApplication.job_id' => $this->request->data['job'], 'JobApplication.nontalent_aacepted_status' => 'N', 'JobApplication.	talent_accepted_status' => 'Y', 'JobApplication.ping' => 0])->order(['JobApplication.id' => 'DESC'])->toarray();
			$status = "Application";
		} elseif ($this->request->data['action'] == 'quote_receive') {
			$requirementfeatured = $this->JobQuote->find('all')->contain(['Requirement', 'Skill', 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']])->where(['JobQuote.job_id' => $this->request->data['job'], 'JobQuote.amt >' => '0', 'JobQuote.revision' => '0', 'JobQuote.status' => 'N'])->order(['JobQuote.id' => 'DESC'])->toarray();
			$status = "Quote Received";
		} elseif ($this->request->data['action'] == 'ping_receive') {
			$requirementfeatured = $this->JobApplication->find('all')->contain(['Requirement', 'Skill', 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']])->where(['JobApplication.job_id' => $this->request->data['job'], 'JobApplication.nontalent_aacepted_status' => 'N', 'JobApplication.ping' => 1])->order(['JobApplication.id' => 'DESC'])->toarray();
			$status = "Ping Recived";
		} elseif ($this->request->data['action'] == 'sel_receive') {
			$requirementfeatured = $this->JobApplication->find('all')
				->contain(['Requirement', 'Skill', 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']])->where(['JobApplication.job_id' => $this->request->data['job'], 'JobApplication.nontalent_aacepted_status' => 'Y', 'JobApplication.talent_accepted_status' => 'Y'])->order(['JobApplication.id' => 'DESC'])->toarray();
			// pr($requirementfeatured);exit;
			$status = "Selected";
		} elseif ($this->request->data['action'] == 'booking_sent') {
			$requirementfeatured = $this->JobApplication->find('all')->contain(['Requirement', 'Skill', 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']])->where(['JobApplication.job_id' => $this->request->data['job'], 'JobApplication.nontalent_aacepted_status' => 'Y', 'JobApplication.ping' => 0, 'JobApplication.talent_accepted_status' => 'N'])->order(['JobApplication.id' => 'DESC'])->toarray();
			$status = "Booked";
		} elseif ($this->request->data['action'] == 'quote_request') {
			$requirementfeatured = $this->JobQuote->find('all')->contain(['Requirement', 'Skill', 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']])->where(['JobQuote.job_id' => $this->request->data['job'], 'JobQuote.amt' => '0'])->order(['JobQuote.id' => 'DESC'])->toarray();
			$status = "Quote Requested";
		} elseif ($this->request->data['action'] == 'quote_revised') {
			$requirementfeatured = $this->JobQuote->find('all')->contain(['Requirement', 'Skill', 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']])->where(['JobQuote.job_id' => $this->request->data['job'], 'JobQuote.amt >' => '0', 'JobQuote.revision >' => '0', 'JobQuote.status' => 'N'])->order(['JobQuote.id' => 'DESC'])->toarray();
			$status = "Quote Revised";
		} elseif ($this->request->data['action'] == 'reject_receive') {

			$requirementfeatured = $this->JobApplication->find('all')
				->contain(['Requirement', 'Skill', 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']])
				->where([
					'JobApplication.job_id' => $this->request->data['job'],
					'OR' => [
						['JobApplication.nontalent_aacepted_status' => 'R'],
						['JobApplication.talent_accepted_status' => 'R']
					]
				])
				->order(['JobApplication.id' => 'DESC'])
				->toArray();
			// pr($requirementfeatured);exit;
			$status = "Rejected";
		}
		// pr($requirementfeatured); die;
		//$jobanswer=$this->Userjobanswer->find('all')->where(['job_id'=>$job_id])->toarray();

		$jobquestion = $this->Jobquestion->find('all')->contain(['Questionmare_options_type', 'Jobanswer', 'Userjobanswer'])->where(['Jobquestion.job_id' => $job_id])->toarray();

		// pr($requirementfeatured);
		// pr($status);exit;
		//pr($jobquestion); die;
		// $this->set('jobquestion', $jobquestion);
		//pr($jobanswer); die;
		//json_encode($requirementfeatured);
		$this->set(compact('requirementfeatured', 'jobanswer', 'status', 'jobquestion'));
	}

	public function jobcsv($id)
	{
		$this->autoRender = false;
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Professinal_info');
		$this->loadModel('Requirement');
		$this->loadModel('BookingRequest');
		$this->loadModel('JobQuote');
		$this->loadModel('JobApplication');
		$this->loadModel('Userjobanswer');
		$this->loadModel('Jobquestion');
		$requirementfeatured = $this->Requirement->find('all')->contain([
			'RequirmentVacancy' => ['Currency'],
			'BookingRequest',
			'JobQuote' => ['Users' => ['Skillset' => ['Skill'], 'Profile' => ['Country', 'State', 'City', 'Enthicity'], 'Professinal_info', 'Subscription']],
			'JobApplication' => ['Skill', 'Users' => ['Skillset' => ['Skill'], 'Profile' => ['Country', 'State', 'City', 'Enthicity'], 'Professinal_info', 'Subscription']]
		])->where(['Requirement.featured' => 'Y', 'Requirement.id' => $id])->order(['Requirement.id' => 'DESC'])->first();

		//pr($requirementfeatured); die;

		$blank = "NA";

		$conn = ConnectionManager::get('default');
		$output = "";
		$output .= 'Sr Number,';
		$output .= 'Name,';
		$output .= 'Date Of Birth,';
		$output .= 'Age,';
		$output .= 'Gender,';
		$output .= 'Email Id,';
		$output .= 'Phone Number,';
		$output .= 'Skype Id,';
		$output .= 'Guardian E-mail,';
		$output .= 'Guardian Phone Number,';
		$output .= 'Guardian Skype Id,';
		$output .= 'Skill,';
		$output .= 'Ethnicity,';
		$output .= 'Current Location,';
		$output .= 'Originally From,';
		$output .= 'Country,';
		$output .= 'State,';
		$output .= 'City,';
		$output .= 'Membership Type,';
		$output .= 'Applied For (talent),';
		$output .= 'Action By Applicant,';
		$output .= 'Date of Action,';
		$output .= 'Quote Received,';
		$output .= 'Quote Sent By Me,';
		$output .= 'Status,';
		$output .= "\n";
		//pr($job); die;
		$cnt = 1;
		foreach ($requirementfeatured['job_application'] as $jobed) {
			$currencySymbol = $requirementfeatured['requirment_vacancy'][0]['currency']['symbol'];

			$output .= $cnt . ",";
			$output .= $jobed['user']['profile']['name'] . ",";
			$dateOfBirth = date('d-m-Y', strtotime($jobed['user']['profile']['dob']));
			$today = date("d-m-Y");
			$diff = date_diff(date_create($dateOfBirth), date_create($today));
			$age = $diff->format('%y');
			$output .= date_format($jobed['user']['profile']['dob'], 'd-m-Y') . ',';
			$output .= $age . ',';

			if ($jobed['user']['profile']['gender'] == 'm') {
				$output .= 'Male' . ",";
			} elseif ($jobed['user']['profile']['gender'] == 'f') {
				$output .= 'Female' . ",";
			} elseif ($jobed['user']['profile']['gender'] == 'bmf') {
				$output .= 'Both male and female' . ",";
			} elseif ($jobed['user']['profile']['gender'] == 'o') {
				$output .= 'Other' . ",";
			} else {
				$output .= $blank . ",";
			}
			$output .= $jobed['user']['email'] . " " . str_replace(',', ' ', $jobed['user']['profile']['altemail']) . ",";
			if ($jobed['user']['profile']['phone']) {
				$output .= '(' . $jobed['user']['profile']['phonecode'] . ')' . $jobed['user']['profile']['phone'] . " " . str_replace(',', ' ', $jobed['user']['profile']['altnumber']) . ",";
			} else {
				$output .= $blank . ",";
			}

			if ($jobed['user']['profile']['skypeid'] != '') {
				$output .= $jobed['user']['profile']['skypeid'] . ",";
			} else {
				$output .= $blank . ",";
			}
			if ($jobed['user']['profile']['guardian_email'] != '') {
				$output .= $jobed['user']['profile']['guardian_email'] . ",";
			} else {
				$output .= $blank . ",";
			}

			if ($jobed['user']['profile']['guardian_phone'] != '') {
				$output .= $jobed['user']['profile']['guardian_phone'] . ",";
			} else {
				$output .= $blank . ",";
			}
			if ($jobed['user']['profile']['altskypeid'] != '') {
				$output .= str_replace(',', ' ', $jobed['user']['profile']['altskypeid']) . ",";
			} else {
				$output .= $blank . ",";
			}

			if ($jobed['user']['skillset']) {
				$knownskills = '';
				foreach ($jobed['user']['skillset'] as $skillquote) {
					if (!empty($knownskills)) {
						$knownskills = $knownskills . ', ' . $skillquote['skill']['name'];
					} else {
						$knownskills = $skillquote['skill']['name'];
					}
				}
				$output .= str_replace(',', ' ', $knownskills) . ',';
				//$output.=$knownskills.",";	
				// echo $knownlanguages;
			}

			if ($jobed['user']['profile']['enthicity']['title']) {
				$output .= $jobed['user']['profile']['enthicity']['title'] . ",";
			} else {
				$output .= $blank . ",";
			}
			if ($jobed['user']['profile']['current_location']) {
				$output .= str_replace(',', ' ', $jobed['user']['profile']['current_location']) . ',';
			} else {
				$output .= $blank . ",";
			}
			if ($jobed['user']['profile']['location']) {
				$output .= str_replace(',', ' ', $jobed['user']['profile']['location']) . ',';
			} else {
				$output .= $blank . ",";
			}

			if ($jobed['user']['profile']['country']['name']) {
				$output .= $jobed['user']['profile']['country']['name'] . ",";
			} else {
				$output .= $blank . ",";
			}

			if ($jobed['user']['profile']['state']['name']) {
				$output .= $jobed['user']['profile']['state']['name'] . ",";
			} else {
				$output .= $blank . ",";
			}
			if ($jobed['user']['profile']['city']['name']) {
				$output .= $jobed['user']['profile']['city']['name'] . ",";
			} else {
				$output .= $blank . ",";
			}

			foreach ($jobed['user']['subscription'] as $key => $mambertype) {
				if ($mambertype['package_type'] == 'PR') {
					$mmtype = "Profile Package";
				} elseif ($mambertype['package_type'] == 'RE') {
					$mmtype = "Requirement Package";
				} elseif ($mambertype['package_type'] == 'RC') {
					$mmtype = "Recruiter Package";
				} else {
					$output .= $blank . ",";
				}
				$output .= $mmtype . " ";
			}
			$output .= ",";
			$output .= $jobed['skill']['name'] . ",";
			if ($jobed['nontalent_aacepted_status'] == 'N' && $jobed['talent_accepted_status'] == 'Y' && $jobed['ping'] == 0) {
				$output .= "Applied" . ",";
			} elseif ($jobed['nontalent_aacepted_status'] == 'N'  && $jobed['ping'] == 1) {
				$output .= "Ping" . ",";
			} elseif ($jobed['nontalent_aacepted_status'] == 'Y' && $jobed['talent_accepted_status'] == 'Y') {
				$output .= "Selected" . ",";
			} elseif ($jobed['nontalent_aacepted_status'] == 'R' || $jobed['talent_accepted_status'] == 'R') {
				$output .= "Reject" . ",";
			} elseif ($jobed['nontalent_aacepted_status'] == 'Y' && $jobed['talent_accepted_status'] == 'N' && $jobed['ping'] == 0) {
				$output .= "Bookingsent" . ",";
			}
			$output .= date('d-m-Y', strtotime($jobed['created'])) . ",";
			$output .= $blank . ",";
			$output .= $blank . ",";
			$output .= $blank . ",";

			$output .= "\r\n";
			$cnt++;
		}

		foreach ($requirementfeatured['job_quote'] as $jobedquote) {
			$currencySymbol = $requirementfeatured['requirment_vacancy'][0]['currency']['symbol'];

			$output .= $cnt++ . ",";
			$output .= $jobedquote['user']['profile']['name'] . ",";
			$dateOfBirth = date('d-m-Y', strtotime($jobedquote['user']['profile']['dob']));
			$today = date("d-m-Y");
			$diff = date_diff(date_create($dateOfBirth), date_create($today));
			$age = $diff->format('%y');
			$output .= date('d-m-Y', strtotime($jobedquote['user']['profile']['dob'])) . ',';
			$output .= $age . ',';
			if ($jobedquote['user']['profile']['gender'] == 'm') {
				$output .= 'Male' . ",";
			} elseif ($jobedquote['user']['profile']['gender'] == 'f') {
				$output .= 'Female' . ",";
			} elseif ($jobedquote['user']['profile']['gender'] == 'bmf') {
				$output .= 'Both male and female' . ",";
			} elseif ($jobedquote['user']['profile']['gender'] == 'o') {
				$output .= 'Other' . ",";
			} else {
				$output .= $blank . ",";
			}
			$output .= $jobedquote['user']['email'] . " " . str_replace(',', ' ', $jobedquote['user']['profile']['altemail']) . ",";

			if ($jobedquote['user']['profile']['phone']) {
				$output .= '(' . $jobedquote['user']['profile']['phonecode'] . ')' . $jobedquote['user']['profile']['phone'] . " " . str_replace(',', ' ', $jobedquote['user']['profile']['altnumber']) . ",";
			} else {
				$output .= $blank . ",";
			}

			if ($jobedquote['user']['profile']['skypeid'] != '') {
				$output .= $jobedquote['user']['profile']['skypeid'] . ",";
			} else {
				$output .= $blank . ",";
			}

			if ($jobedquote['user']['profile']['guardian_email'] != '') {
				$output .= $jobedquote['user']['profile']['guardian_email'] . ",";
			} else {
				$output .= $blank . ",";
			}

			if ($jobedquote['user']['profile']['guardian_phone'] != '') {
				$output .= $jobedquote['user']['profile']['guardian_phone'] . ",";
			} else {
				$output .= $blank . ",";
			}
			if ($jobedquote['user']['profile']['altskypeid'] != '') {
				$output .= str_replace(',', ' ', $jobedquote['user']['profile']['altskypeid']) . ",";
			} else {
				$output .= $blank . ",";
			}

			if ($jobedquote['user']['skillset']) {
				$knownskills = '';
				foreach ($jobedquote['user']['skillset'] as $skillquote) {
					if (!empty($knownskills)) {
						$knownskills = $knownskills . ', ' . $skillquote['skill']['name'];
					} else {
						$knownskills = $skillquote['skill']['name'];
					}
				}
				$output .= str_replace(',', ' ', $knownskills) . ',';
			}


			if ($jobedquote['user']['profile']['enthicity']['title']) {
				$output .= $jobedquote['user']['profile']['enthicity']['title'] . ",";
			} else {
				$output .= $blank . ",";
			}

			if ($jobedquote['user']['profile']['current_location']) {
				$output .= str_replace(',', ' ', $jobedquote['user']['profile']['current_location']) . ',';
			} else {
				$output .= $blank . ",";
			}

			if ($jobedquote['user']['profile']['location']) {
				$output .= str_replace(',', ' ', $jobedquote['user']['profile']['location']) . ',';
			} else {
				$output .= $blank . ",";
			}

			if ($jobedquote['user']['profile']['country']['name']) {
				$output .= $jobedquote['user']['profile']['country']['name'] . ",";
			} else {
				$output .= $blank . ",";
			}

			if ($jobedquote['user']['profile']['state']['name']) {
				$output .= $jobedquote['user']['profile']['state']['name'] . ",";
			} else {
				$output .= $blank . ",";
			}

			if ($jobedquote['user']['profile']['city']['name']) {
				$output .= $jobedquote['user']['profile']['city']['name'] . ",";
			} else {
				$output .= $blank . ",";
			}

			foreach ($jobedquote['user']['subscription'] as $key => $mambertype) {
				if ($mambertype['package_type'] == 'PR') {
					$mmtype = "Profile Package";
				} elseif ($mambertype['package_type'] == 'RE') {
					$mmtype = "Requirement Package";
				} elseif ($mambertype['package_type'] == 'RC') {
					$mmtype = "Recruiter Package";
				}
				$output .= $mmtype . " ";
			}
			$output .= ",";

			$output .= $blank . ",";
			$output .= $blank . ",";
			$output .= date('d-m-Y', strtotime($jobedquote['created'])) . ",";
			if ($jobedquote['revision']) {
				$amount = $jobedquote['revision'];
			} else {
				$amount = $requirementfeatured['requirment_vacancy'][0]['payment_amount'];
			}
			//pr($currencySymbol.$amount); die;

			$output .= 'Offered Amount: (' . $amount . ')Talent Quote: ' . $currencySymbol . ' ' . $jobedquote['amt'] . ",";
			//	pr($outp); die;
			$output .= $jobedquote['revision'] . ",";
			if ($jobedquote['revision'] != '') {
				$output .= "Revised Quote Sent By Me" . ",";
			} else {
				$output .= $blank . ",";
			}

			$output .= "\r\n";
		}
		/// echo $output."\r\n";  die;
		$filename = "Requirement.xlsx";
		header('Content-type: application/xlsx');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		die;
		$this->redirect($this->referer());
	}

	// Showing Suggested Profile and action to make job featured. 
	function suggestedprofile($jobid = null)
	{
		$this->loadModel('Requirement');
		$this->loadModel('RequirmentVacancy');
		$this->loadModel('Skill');
		$this->loadModel('Country');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Featuredjob');
		$user_id = $this->request->session()->read('Auth.User.id');

		// Find featured job packages
		$featuredjob = $this->Featuredjob->find('all')
			->where(['Featuredjob.status' => 'Y'])
			->order(['Featuredjob.priorites' => 'ASC'])
			->toarray();
		$this->set('featuredjob', $featuredjob);
		$this->set('job_id', $jobid);
		$activejobs = $this->Requirement->find('all')
			->contain(['RequirmentVacancy' => ['Skill'], 'Country', 'State', 'City'])
			->where(['Requirement.id' => $jobid])
			->first();
		$packfeature = $this->activePackage('RC');
		// pr($packfeature);exit;
		$totalLimitSuggestProfile = $packfeature['nubmer_of_site'];
		$city = $activejobs['city_id'];
		$state = $activejobs['state_id'];
		$country = $activejobs['country_id'];
		$loc_lat = $activejobs['latitude'];
		$loc_long = $activejobs['longitude'];
		$this->set('activejobs', $activejobs);

		$sex = array();
		$skills = array();
		$current_time = time();
		$currentdate = date('Y-m-d H:m:s');
		$featured = 0;
		if ($activejobs['expiredate'] > $currentdate) {
			$featured = 1;
		}
		$this->set('featured', $featured);

		foreach ($activejobs->requirment_vacancy as $vacancies) {
			if (!in_array($vacancies->sex, $sex)) {
				if ($vacancies->sex == 'bmf') {
					$sex[] = "'m'";
					$sex[] = "'f'";
				} else if ($vacancies->sex == 'a') {
					$sex[] = "'m'";
					$sex[] = "'f'";
					$sex[] = "'o'";
					$sex[] = "'bmf'";
				} else {
					$sex[] = "'$vacancies->sex'";
				}
			}
			if (!in_array($vacancies->skill->id, $skills)) {
				$skills[] = $vacancies->skill->id;
			}
		}


		// $sexx = array_unique($sex);
		// $conn = ConnectionManager::get('default');
		// $user_qry = "SELECT professinal_info.performing_year, country.name as country, cities.name as city_name, states.name as state_name, users.id,personal_profile.*, skill.*, 1.609344 * 6371 * acos( cos( radians('" . $loc_lat . "') ) * cos( radians(personal_profile.current_lat) ) * cos( radians(personal_profile.current_long) - radians('" . $loc_long . "') ) + sin( radians('" . $loc_lat . "') ) * sin( radians(personal_profile.current_lat) ) ) AS cdistance, 1.609344 * 6371 * acos( cos( radians('" . $loc_lat . "') ) * cos( radians(personal_profile.lat) ) * cos( radians(personal_profile.longs) - radians('" . $loc_long . "') ) + sin( radians('" . $loc_lat . "') ) * sin( radians(personal_profile.lat) ) ) AS fdistance FROM `users` LEFT JOIN personal_profile on users.id=personal_profile.user_id LEFT JOIN skill on users.id=skill.user_id LEFT JOIN professinal_info on users.id=professinal_info.user_id LEFT JOIN country on personal_profile.country_ids=country.id LEFT JOIN states on personal_profile.state_id=states.id LEFT JOIN cities on personal_profile.city_id=cities.id where users.role_id='" . TALANT_ROLEID . "' and personal_profile.gender IN (" . implode(",", $sexx) . ") and personal_profile.user_id != " . $user_id . " group by personal_profile.user_id  having cdistance < " . SEARCH_DISTANCE . " and fdistance < " . SEARCH_DISTANCE;
		// $qryexes = $conn->execute($user_qry);
		// $profiles = $qryexes->fetchAll('assoc');

		// Rupam refine code 
		$sexx = array_unique($sex);
		$skillIdsArray = $skills;
		$conn = ConnectionManager::get('default');

		$user_qry = "
			SELECT 
				pi.performing_year, 
				c.name AS country, 
				ct.name AS city_name, 
				s.name AS state_name, 
				u.id, 
				pp.*, 
				sk.*, 
				(1.609344 * 6371 * ACOS( 
					COS(RADIANS(:loc_lat)) * COS(RADIANS(pp.current_lat)) * 
					COS(RADIANS(pp.current_long) - RADIANS(:loc_long)) + 
					SIN(RADIANS(:loc_lat)) * SIN(RADIANS(pp.current_lat)) 
				)) AS cdistance,
				(1.609344 * 6371 * ACOS( 
					COS(RADIANS(:loc_lat)) * COS(RADIANS(pp.lat)) * 
					COS(RADIANS(pp.longs) - RADIANS(:loc_long)) + 
					SIN(RADIANS(:loc_lat)) * SIN(RADIANS(pp.lat)) 
				)) AS fdistance
			FROM users u
			LEFT JOIN personal_profile pp ON u.id = pp.user_id
			LEFT JOIN skill sk ON u.id = sk.user_id
			LEFT JOIN professinal_info pi ON u.id = pi.user_id
			LEFT JOIN country c ON pp.country_ids = c.id
			LEFT JOIN states s ON pp.state_id = s.id
			LEFT JOIN cities ct ON pp.city_id = ct.id
			WHERE 
				u.role_id = :talant_roleid
				AND pp.gender IN (" . implode(",", $sexx) . ") 
				AND sk.skill_id IN (" . implode(",", $skillIdsArray) . ")
				AND pp.user_id != :user_id
			GROUP BY pp.user_id
			HAVING 
				cdistance < :search_distance 
				AND fdistance < :search_distance
				    LIMIT " . (int) $totalLimitSuggestProfile;

		// pr($user_qry);exit;
		$qryexes = $conn->execute($user_qry, [
			'loc_lat' => $loc_lat,
			'loc_long' => $loc_long,
			'talant_roleid' => TALANT_ROLEID,
			'user_id' => $user_id,
			'search_distance' => SEARCH_DISTANCE
		]);

		$profiles = $qryexes->fetchAll('assoc');
		// pr($profiles);exit;
		$this->set('profiles', $profiles);
		$Job = $this->Requirement->find('all')->contain(['Eventtype', 'Users', 'Featuredjob'])->where(['Requirement.featured' => 'Y', 'Requirement.user_id' => $user_id])->order(['Requirement.id' => 'DESC'])->toarray();
		$this->set('Job', $Job);
	}

	function editjob()
	{
		$this->autoRender = false;

		$this->Flash->success(__('We are working at this module'));
		$this->redirect($this->referer());
	}
}
