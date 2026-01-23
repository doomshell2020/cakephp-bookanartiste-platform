
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

class AdvertismentController extends AppController
{


	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['buy']);
	}

	//=========================================advertise my job====================================
	//	============================================================================================
	//	===========================================================================================
	public function advrtjobsearching()
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


		$this->request->session()->write('advrtjobsearch', $cond);

		$Job = $this->Requirement->find('all')->contain(['Users', 'Jobadvertpack'])->where([$cond, 'DATE(Requirement.last_date_app) >=' => $currentdate, 'Requirement.status' => 'Y', 'Requirement.user_id' => $user_id])->order(['Requirement.id' => 'DESC'])->toarray();
		$this->set('Job', $Job);
	}

	public function advrtiseMyRequirment()
	{

		$this->loadModel('Requirement');
		$this->loadModel('Users');
		$this->loadModel('Jobadvertpack');
		$currentdate = date('Y-m-d H:m:s');
		$session = $this->request->session();
		$session->delete('advrtjobsearch');

		$user_id = $this->request->session()->read('Auth.User.id');

		$Job = $this->Requirement->find('all')->contain(['Users', 'Jobadvertpack'])->where(['DATE(Requirement.last_date_app) >=' => $currentdate, 'Requirement.status' => 'Y', 'Requirement.user_id' => $user_id])->order(['Requirement.id' => 'DESC'])->toarray();
		//pr($Job);
		$this->set('Job', $Job);
	}


	public function advertisejob($jid = null)
	{

		$this->loadModel('Requirement');
		$this->loadModel('Jobadvertpack');
		$bannerpackid = $this->Jobadvertpack->find('all')->where(['status' => 'Y'])->order(['id' => ASC])->first();

		$this->set('bannerpackid', $bannerpackid);

		$myjobs = $this->Requirement->find('all')->where(['Requirement.status' => 'Y', 'Requirement.id' => $jid])->first();
		$this->set('myjobs', $myjobs);

		$serviceDelete = $this->Jobadvertpack->deleteAll(['requir_id' => $jid, 'status' => 'N']);
		$jobadvertpack = $this->Jobadvertpack->newEntity();

		//$this->set('banner', $banner);
		$id = $this->request->session()->read('Auth.User.id');
		if ($this->request->is(['post', 'put'])) {
			//pr($this->request->data); die;

			if ($this->request->data['job_image_change']['name'] != '') {
				$k = $this->request->data['job_image_change'];
				$galls = $this->move_images($k);

				// automatically create the dimensionally file
				$this->FcCreateThumbnail("trash_image", "job/", $galls[0], $galls[0], "500", "400");

				$this->request->data['job_image_change'] = $galls[0];
				unlink('trash_image/' . $galls[0]);
			} else {
				$this->request->data['job_image_change'] = $this->request->data['jobimg'];
			}


			$this->request->data['user_id'] = $id;
			$this->request->data['status'] = 'N';
			$this->request->data['ad_date_from'] = date('Y-m-d H:i', strtotime($this->request->data['ad_date_from']));
			$this->request->data['ad_date_to'] = date('Y-m-d H:i', strtotime($this->request->data['ad_date_to']));
			$banners = $this->Jobadvertpack->patchEntity($jobadvertpack, $this->request->data);
			//pr($this->request->data); die;
			$savedbanners = $this->Jobadvertpack->save($banners);
			if ($savedbanners) {

				return $this->redirect(['action' => 'advertisejobpayment/', $savedbanners['id']]);
			} else {
				$this->Flash->error(__('Ad not published'));
				return $this->redirect(['action' => 'advertisejob']);
			}
		}
	}



	public function advertisejobpayment($adid = null)
	{

		$this->loadModel('Jobadvertpack');

		$bannerpackid = $this->Jobadvertpack->find('all')->where(['id' => $adid])->first();
		//pr($bannerpackid); die;
		$this->set('bannerpackid', $bannerpackid);

		$fromdate = date('Y-m-d', strtotime($bannerpackid['ad_date_from']));
		$todate = date('Y-m-d', strtotime($bannerpackid['ad_date_to']));
		/*echo $fromdate;*/
		$date1 = date_create($fromdate);
		$date2 = date_create($todate);
		$diff = date_diff($date1, $date2);
		$bannerdays = $diff->days;

		$this->set('number_of_days', $bannerdays);
	}

	// Process advertise Job payment
	public  function proadjobpay()
	{
		//pr($this->request->data); die;
		$user_id = $this->request->session()->read('Auth.User.id');
		$number_of_days = $this->request->data['number_of_days'];
		$job_id = $this->request->data['job_id'];
		$package_id = $this->request->data['package_id'];
		$transcation_data['payment_method'] = 'Paypal';
		$transcation_data['amount'] = $this->request->data['package_price'];
		//$transcation_data['amount'] = $pcakgeinformation['price'];
		$transcation_data['user_id'] = $user_id;
		$transcation_data['number_of_days'] = $number_of_days;
		$transcation_data['advrt_job_id'] = $job_id;
		$this->loadModel('Transcation');
		$transcation = $this->Transcation->newEntity();
		$transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
		$savetranscation = $this->Transcation->save($transcation_arr);
		$transcation_id = $savetranscation->id;
		$this->confirmadjobpay($package_id, $transcation_id);
	}


	// Confirm advertise job payment
	public function confirmadjobpay($package_id, $transcation_id)
	{

		$user_id = $this->request->session()->read('Auth.User.id');
		$ref_id = $this->request->session()->read('Auth.User.ref_by');
		$this->loadModel('Transcation');
		$transcation = $this->Transcation->get($transcation_id);

		$transcation_data['status'] = 'Y';
		$transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
		$savetranscation = $this->Transcation->save($transcation_arr);

		// Adding Talent admin transcation
		if ($ref_id > 0) {
			$this->loadModel('TalentAdmin');
			$this->loadModel('Talentadmintransc');
			$checkrefdata = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $ref_id])->first();
			$commision_per = $checkrefdata['commision'];
			$total_trans = $transcation['amount'];
			$commision_amt = ($commision_per / 100) * $total_trans;
			$atranscation = $this->Talentadmintransc->newEntity();
			$atranscation_data['user_id'] = $user_id;
			$atranscation_data['talent_admin_id'] = $ref_id;
			$atranscation_data['amount'] = $commision_amt;
			$atranscation_data['transcation_amount'] = $total_trans;

			// Package Name
			$description = "Job Advertisement";
			$atranscation_data['description'] = $description;
			$atranscation_data['transaction_id'] = $savetranscation['id'];
			$atranscation_arr = $this->Talentadmintransc->patchEntity($atranscation, $atranscation_data);
			$savetranscations = $this->Talentadmintransc->save($atranscation_arr);
		}

		// Setting advertise job. 
		$this->loadModel('Jobadvertpack');

		$requirement = $this->Jobadvertpack->get($package_id);
		$myrequirement['status'] = 'Y';

		$requirementsave = $this->Jobadvertpack->patchEntity($requirement, $myrequirement);
		$this->Jobadvertpack->save($requirementsave);

		$this->Flash->success(__('Your advertisement has been published.'));
		return $this->redirect(['action' => 'advrtiseMyRequirment']);
	}





	//=========================================advertise my profile====================================
	//	============================================================================================
	//	===========================================================================================

	public function advertiseprofile()
	{
		$this->loadModel('Banner');
		$this->loadModel('Profileadvertpack');
		$bannerpackid = $this->Profileadvertpack->find('all')->where(['status' => 'Y'])->first();
		$this->set('bannerpackid', $bannerpackid);


		$jobadvertpack = $this->Profileadvertpack->newEntity();

		//$this->set('banner', $banner);
		$id = $this->request->session()->read('Auth.User.id');
		if ($this->request->is(['post', 'put'])) {
			//pr($this->request->data); die;

			if ($this->request->data['job_image_change']['name'] != '') {
				$k = $this->request->data['job_image_change'];
				$galls = $this->move_images($k);

				// automatically create the dimensionally file
				$this->FcCreateThumbnail("trash_image", "job/", $galls[0], $galls[0], "500", "400");

				$this->request->data['job_image_change'] = $galls[0];
				unlink('trash_image/' . $galls[0]);
			} else {
				$this->request->data['job_image_change'] = $this->request->data['jobimg'];
			}


			$this->request->data['user_id'] = $id;
			$this->request->data['status'] = 'N';
			$this->request->data['ad_date_from'] = date('Y-m-d H:i', strtotime($this->request->data['ad_date_from']));
			$this->request->data['ad_date_to'] = date('Y-m-d H:i', strtotime($this->request->data['ad_date_to']));
			$banners = $this->Profileadvertpack->patchEntity($jobadvertpack, $this->request->data);
			//pr($this->request->data); die;
			$savedbanners = $this->Profileadvertpack->save($banners);
			if ($savedbanners) {
				return $this->redirect(['action' => 'advertiseprofilepayment/', $savedbanners['id']]);
			} else {
				$this->Flash->error(__('Ad not published'));
				return $this->redirect(['action' => 'advertiseprofile']);
			}
		}
	}



	public function advertiseprofilepayment($adid = null)
	{

		$this->loadModel('Profileadvertpack');

		$bannerpackid = $this->Profileadvertpack->find('all')->where(['id' => $adid])->first();
		//pr($bannerpackid); die;
		$this->set('bannerpackid', $bannerpackid);

		$fromdate = date('Y-m-d', strtotime($bannerpackid['ad_date_from']));
		$todate = date('Y-m-d', strtotime($bannerpackid['ad_date_to']));
		/*echo $fromdate;*/
		$date1 = date_create($fromdate);
		$date2 = date_create($todate);
		$diff = date_diff($date1, $date2);
		$bannerdays = $diff->days;

		$this->set('number_of_days', $bannerdays);
	}

	// Process advertise Job payment
	public  function proadprofilepay()
	{
		//pr($this->request->data); die;
		$user_id = $this->request->session()->read('Auth.User.id');
		$number_of_days = $this->request->data['number_of_days'];
		$job_id = $this->request->data['job_id'];
		$package_id = $this->request->data['package_id'];
		$transcation_data['payment_method'] = 'Paypal';
		$transcation_data['amount'] = $this->request->data['package_price'];
		//$transcation_data['amount'] = $pcakgeinformation['price'];
		$transcation_data['user_id'] = $user_id;
		$transcation_data['number_of_days'] = $number_of_days;
		$transcation_data['advrt_profile_id'] = $job_id;
		$this->loadModel('Transcation');
		$transcation = $this->Transcation->newEntity();
		$transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
		$savetranscation = $this->Transcation->save($transcation_arr);
		$transcation_id = $savetranscation->id;
		$this->confirmadprofilepay($package_id, $transcation_id);
	}


	// Confirm advertise job payment
	public function confirmadprofilepay($package_id, $transcation_id)
	{

		$user_id = $this->request->session()->read('Auth.User.id');
		$ref_id = $this->request->session()->read('Auth.User.ref_by');
		$this->loadModel('Transcation');
		$transcation = $this->Transcation->get($transcation_id);

		$transcation_data['status'] = 'Y';
		$transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
		$savetranscation = $this->Transcation->save($transcation_arr);

		// Adding Talent admin transcation
		if ($ref_id > 0) {
			$this->loadModel('TalentAdmin');
			$this->loadModel('Talentadmintransc');
			$checkrefdata = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $ref_id])->first();
			$commision_per = $checkrefdata['commision'];
			$total_trans = $transcation['amount'];
			$commision_amt = ($commision_per / 100) * $total_trans;
			$atranscation = $this->Talentadmintransc->newEntity();
			$atranscation_data['user_id'] = $user_id;
			$atranscation_data['talent_admin_id'] = $ref_id;
			$atranscation_data['amount'] = $commision_amt;
			$atranscation_data['transcation_amount'] = $total_trans;

			// Package Name
			$description = "Job Advertisement";
			$atranscation_data['description'] = $description;
			$atranscation_data['transaction_id'] = $savetranscation['id'];
			$atranscation_arr = $this->Talentadmintransc->patchEntity($atranscation, $atranscation_data);
			$savetranscations = $this->Talentadmintransc->save($atranscation_arr);
		}

		// Setting advertise job. 
		$this->loadModel('Profileadvertpack');

		$requirement = $this->Profileadvertpack->get($package_id);
		$myrequirement['status'] = 'Y';

		$requirementsave = $this->Profileadvertpack->patchEntity($requirement, $myrequirement);
		$this->Profileadvertpack->save($requirementsave);

		$this->Flash->success(__('Your advertisement has been published.'));
		return $this->redirect(['action' => 'advertiseprofile']);
	}
}
