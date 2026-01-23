<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class NontelentController extends AppController
{
	public function initialize()
	{
		parent::initialize();
	}
	// For Talent Index
	public function index()
	{
		$this->loadModel('Users');
		$this->loadModel('Country');
		$this->viewBuilder()->layout('admin');
		$nontalent = $this->Users->find('all')->contain(['Profile', 'Packfeature'])->where(['Users.role_id' => NONTALANT_ROLEID, 'user_delete' => 'N'])->order(['Users.id' => 'DESC'])->toarray();
		$this->set(compact('nontalent'));
		// $country = $this->Country->find('list')->select(['id','name'])->toarray();
		$country = $this->Users->find('all')->select(['Country.name', 'Country.id'])->contain(['Profile' => ['Country']])->where(['Users.role_id' => NONTALANT_ROLEID])->order(['Country.name' => 'ASC'])->toarray();
		$this->set('country', $country);
	}

	public function search()
	{
		//pr($this->request->data); die;
		$tcstatus = $this->request->data['tcstatus'];
		$status = $this->request->data['status'];
		$renewjob = $this->request->data['renewjob'];
		$name = $this->request->data['name'];
		$email = $this->request->data['email'];
		$country = $this->request->data['country'];
		$cond = [];

		if ($tcstatus == "TY") {
			$cond['Users.is_talent_admin'] = "Y";
		} elseif ($tcstatus == "TN") {
			$cond['Users.is_talent_admin'] = "N";
		}

		if (!empty($status)) {
			$cond['Users.status'] = $status;
		}

		if (!empty($renewjob)) {
			if ($renewjob == "N") {
				$cond['Packfeature.non_telent_number_of_job_post'] = "0";
			} else {
				$cond['Packfeature.non_telent_number_of_job_post'] != "0";
			}
		}

		if (!empty($name)) {
			$cond['Profile.name LIKE'] = "%" . $name . "%";
		}
		if (!empty($email)) {
			$cond['Users.email LIKE'] = "%" . $email . "%";
		}
		if (!empty($country)) {
			$cond['Profile.country_ids '] = $country;
		}
		$cond['Users.role_id'] = NONTALANT_ROLEID;
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$nontalent = $this->Users->find('all')->contain(['Profile', 'Packfeature'])->where([$cond, 'Users.user_delete' => 'N'])->order(['Users.id' => 'DESC'])->toarray();
		//$nontalent = $this->Users->find('all')->contain(['Skillset','Profile','Profilepack'])->where($cond)->order(['Users.id' => 'DESC'])->toarray();
		$this->set('nontalent', $nontalent);
		// $country = $this->Country->find('list')->select(['id','name'])->toarray();	    
	}


	public function nontalentexcel($id = null)
	{
		$this->autoRender = false;
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Professinal_info');
		$this->loadModel('Skillset');
		$this->loadModel('Requirement');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Refers');

		$artisteUser = $this->Users->find('all')->contain(['Skillset' => ['Skill'], 'Profile' => ['Country', 'State', 'City', 'Enthicity'], 'Professinal_info', 'Subscription' => ['Profilepack'], 'Packfeature', 'TalentAdmin'])->where(['Users.role_id' => NONTALANT_ROLEID, 'Users.user_delete' => 'N'])->order(['Users.id' => 'DESC'])->toarray();

		//pr($artisteUser); die;

		$blank = "-";

		$conn = ConnectionManager::get('default');
		$output = "";
		$output .= '"Sr No",';
		$output .= '"Name",';
		$output .= '"Email Id",';
		$output .= '"Contact Number",';
		$output .= '"Sex",';
		$output .= '"Country",';
		$output .= '"State",';
		$output .= '"City",';
		$output .= '"Membership Since",';
		$output .= '"Source",';
		$output .= '"Talent Partner Name",';
		$output .= '"Talent Partner Email ID",';
		$output .= "\n";
		//pr($job); die;

		$cnt = 1;
		foreach ($artisteUser as $artisteValue) { //pr($jobed); die;

			$contentadmin = $this->TalentAdmin->find('all')->contain(['Users' => ['Refers']])->where(['Users.is_talent_admin' => 'Y', 'TalentAdmin.talentdadmin_id' => $artisteValue['id']])->toarray();

			$referrUser = $this->Users->find('all')->select('id', 'user_name')->where(['Users.id' => $artisteValue['ref_by']])->first();

			$output .= $cnt . ",";
			if ($artisteValue['profile']['name']) {
				$output .= $artisteValue['profile']['name'] . ",";
			} else {
				$output .= $artisteValue['user_name'] . ",";
			}
			$output .= $artisteValue['email'] . " " . str_replace(',', ' ', $artisteValue['profile']['altemail']) . ",";

			if ($artisteValue['profile']['phone']) {
				$removespace = str_replace(' ', '', $artisteValue['profile']['altnumber']);
				//echo $removespace; die;
				$altphone = explode(",", $removespace);
				//pr($altphone); die;
				$output .= $artisteValue['profile']['phonecode'] . '-' . $artisteValue['profile']['phone'];
				foreach ($altphone as $altphonevalue) {
					//pr($altphonevalue); die;
					$output .= $artisteValue['profile']['phonecode'] . "-" . $altphonevalue;
				}
				$output .= ",";
			} else {
				$output .= $blank . ",";
			}

			if ($artisteValue['profile']['gender'] == 'm') {
				$output .= 'Male' . ",";
			} elseif ($artisteValue['profile']['gender'] == 'f') {
				$output .= 'Female' . ",";
			} elseif ($artisteValue['profile']['gender'] == 'bmf') {
				$output .= 'Both male and female' . ",";
			} elseif ($artisteValue['profile']['gender'] == 'o') {
				$output .= 'Other' . ",";
			} else {
				$output .= $blank . ",";
			}


			//if($artisteValue['profile']['country_ids']==""){
			//		$output.=$artisteValue['profile']['location'].",";
			//}else
			if ($artisteValue['profile']['country']['name']) {
				$output .= $artisteValue['profile']['country']['name'] . ",";
			} else {
				$output .= $blank . ",";
			}

			if ($artisteValue['profile']['state']['name']) {
				$output .= $artisteValue['profile']['state']['name'] . ",";
			} else {
				$output .= $blank . ",";
			}

			if ($artisteValue['profile']['city']['name']) {
				$output .= $artisteValue['profile']['city']['name'] . ",";
			} else {
				$output .= $blank . ",";
			}

			$output .= date('d-M-Y', strtotime($artisteValue['created'])) . ",";

			//$output .="Source".",";

			if ($artisteValue['ref_by'] != 0) {
				if (!empty($artisteValue['talent_admin'])) {
					$talentPartenrs = "Referred and Referred Talent";
				} else {
					$talentPartenrs = "Referred";
				}
			} elseif (strtotime($artisteValue['created']) < strtotime($artisteValue['talent_admin']['created_date'])) {
				$talentPartenrs = "Self";
			} elseif (!empty($artisteValue['talent_admin'])) {
				if ($artisteValue['talent_admin']['talentdadmin_id'] == 1) {
					$talentPartenrs = "Admin";
				} else {
					$talentPartenrs = "Referred (Talent Partner)";
				}
			} else {
				$talentPartenrs = "Self";
			}
			$output .= $talentPartenrs . ",";

			if ($talentPartenrs == "Self") {
				$output .= $blank . ",";
				$output .= $blank . ",";
			} else {

				if ($artisteValue['ref_by'] != 0) {
					$taletnrefer = $this->Users->find('all')->contain(['Profile'])->select(['id', 'user_name', 'email'])->where(['Users.id' => $artisteValue['ref_by']])->first();
					if ($taletnrefer['user_name'] == "Anirudh") {
						$output .= $taletnrefer['user_name'] . " (Admin) ,";
					} else {
						$output .= $taletnrefer['user_name'] . ",";
					}
					$output .= $taletnrefer['email'] . ",";
				} elseif (!empty($artisteValue['talent_admin']['talentdadmin_id'])) {
					$taletnrefer = $this->Users->find('all')->contain(['Profile'])->select(['id', 'user_name', 'email'])->where(['Users.id' => $artisteValue['talent_admin']['talentdadmin_id']])->first();
					if ($taletnrefer['user_name'] == "Anirudh") {
						$output .= $taletnrefer['user_name'] . " (Admin) ,";
					} else {
						$output .= $taletnrefer['user_name'] . ",";
					}

					$output .= $taletnrefer['email'] . ",";
				} else {
					$output .= $blank . ",";
					$output .= $blank . ",";
				}
			}


			//pr($contentadmin); die;
			// if ($contentadmin) {
			// 	foreach ($contentadmin as $key => $talentPartenr) {
			// 		if($talentPartenr['user']['user_name']){
			// 			$talentPartenrs= $talentPartenr['user']['user_name'];
			// 		}else{
			// 			$output .= $blank.",";
			// 		}

			// 		$output.=$talentPartenrs." ";
			// 	}
			// $output.=",";
			// }else{
			// 	$output .= $blank.",";
			// }

			// if ($contentadmin) {
			// 	foreach ($contentadmin as $key => $talentPartenre) {
			// 		if($talentPartenr['user']['email']){
			// 			$talentPartenrse= $talentPartenre['user']['email'];
			// 		}else{
			// 			$output .= $blank.",";
			// 		}

			// 		$output.=$talentPartenrse." ";
			// 	}
			// $output.=",";
			// }else{
			// 	$output .= $blank.",";
			// }

			$output .= "\r\n";
			$cnt++;
		}


		$filename = "Non Talent members.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		die;
		$this->redirect($this->referer());
	}
	// For  Non Talent Active
	public function status($id, $status)
	{
		$this->loadModel('Users');

		if (isset($id) && !empty($id)) {
			if ($status == 'N') {
				$status = 'Y';
				$talent = $this->Users->get($id);
				$talent->status = $status;
				if ($this->Users->save($talent)) {
					$this->Flash->success(__('Talent status has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {
				$status = 'N';
				$talent = $this->Users->get($id);
				$talent->status = $status;
				if ($this->Users->save($talent)) {
					$this->Flash->success(__('Talent status has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}

	// For Talent Delete
	public function delete($id)
	{
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Refers');
		$talent = $this->Users->get($id);
		$talentadmin = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $id])->count();
		$refers = $this->Refers->find('all')->where(['Refers.email' => $talent['email']])->count();
		// $talentdata = $this->Profile->find('all')->where(['Profile.user_id' => $id])->first()->toarray();
		// unlink('uploads/' . $talentdata['profile_image']);

		$usertable = TableRegistry::get("Users");
		$query = $usertable->query();
		$result = $query->update()
			->set(['user_delete' => 'Y'])
			->where(['id' => $id])
			->execute();

		if ($talentadmin > 0) {
			$this->TalentAdmin->deleteAll(['TalentAdmin.user_id' => $id]);
		}

		// if ($refers > 0) {
		// 	$this->Refers->deleteAll(['Refers.email' => $talent['email']]);
		// }

		$this->Flash->success(__('The Non Telent with id: {0} has been deleted.', h($id)));
		return $this->redirect(['action' => 'index']);
	}

	//for Skill
	public function details($id)
	{

		$this->loadModel('Profile');
		try {
			$details = $this->Profile->find('all')->contain(['Country', 'State', 'City', 'Enthicity'])->where(['Profile.id' => $id])->first();

			$this->set('nontalentdetails', $details);
		} catch (FatalErrorException $e) {
			$this->log("Error Occured", 'error');
		}

		// pr($details); die;
	}

	public function renewfreejob($id)
	{
		$this->loadModel('Settings');
		$this->loadModel('Packfeature');
		$this->loadModel('Users');

		$packfeature = $this->Packfeature->find('all')
			->where(['user_id' => $id])
			->andWhere(['OR' => [
				['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
				['package_status' => 'default']
			]])
			->select(['id', 'non_telent_number_of_job_post', 'user_id'])
			->order(['id' => 'DESC'])
			->first();
		// find users by id 
		$users_info = $this->Users->find('all')
			->where(['id' => $id])
			->select(['id', 'renew_job_time'])
			->first();
		
		$settingdetails = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();
		// pr($settingdetails['non_telent_number_of_job_post']); die;

		$totalTimeChange = $users_info['renew_job_time'] + 1 ?? 0;
		if ($users_info['renew_job_time'] == 0) {
			$users_info['renew_job_time'] = 1;
		} else {
			$users_info['renew_job_time'] = $totalTimeChange;
		}
		// $totalValue = ($packfeature['non_telent_number_of_job_post'] / $totalTimeChange);
		$totalValue = $settingdetails['non_telent_number_of_job_post'] ?? 0;
		// pr($totalValue);exit;

		if ($packfeature) {
			$packfeature = $this->Packfeature->get($packfeature['id']);
			$feature_info['non_telent_number_of_job_post'] = $packfeature['non_telent_number_of_job_post'] + $totalValue;
			$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
			$this->Packfeature->save($features_arr);
		}

		// **Users table को update करते समय renew_job_time में +1 करें**
		$tablename = TableRegistry::get("Users");
		$query = $tablename->query();
		$result = $query->update()
			->set([
				'renew_job' => 'Y',
				'renew_job_time = renew_job_time + 1', // `+1` update
			])
			->where(['id' => $id])
			->execute();

		$this->Flash->success(__('Free job renewed successfully'));
		return $this->redirect(['action' => 'index']);
	}


	// public function renewfreejob($id)
	// {
	// 	$this->loadModel('Settings');
	// 	$this->loadModel('Packfeature');
	// 	$this->loadModel('Users');

	// 	$packfeature = $this->Packfeature->find('all')
	// 	->where(['Packfeature.user_id' => $id])
	// 	->order(['Packfeature.id' => 'ASC'])
	// 	->first();

	// 	$settingdetails = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();
	// 	$packfeature_id = $packfeature['id'];
	// 	$packfeature = $this->Packfeature->get($packfeature_id);

	// 	$feature_info['non_telent_number_of_job_post'] = $settingdetails['non_telent_number_of_job_post'];
	// 	$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
	// 	$this->Packfeature->save($features_arr);

	// 	$tablename = TableRegistry::get("Users");
	// 	$query = $tablename->query();
	// 	$result = $query->update()
	// 		->set(['renew_job' => 'Y'])
	// 		->where(['id' => $id])
	// 		->execute();

	// 	$this->Flash->success(__('Free job renewd successfully'));
	// 	return $this->redirect(['action' => 'index']);
	// }
}
