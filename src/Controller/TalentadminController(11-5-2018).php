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
use Cake\Log\Log;


include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

class TalentadminController extends AppController
{


	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['excelimport']);
	}


	public  function _setPassword($password)
	{
		return (new DefaultPasswordHasher)->hash($password);
	}

	// this function used for get states according country	
	public function index() {}

	// Refers list
	public function refers($id = null)
	{
		$this->loadModel('Refers');
		$contentadmin = $this->Refers->find('all')->contain([])->where(['Refers.ref_by' => $this->request->session()->read('Auth.User.id')])->order(['Refers.id' => 'DESC'])->toarray();
		$this->set(compact('contentadmin'));
	}

	// Refer talents
	public function refertalent($id = null)
	{
		$this->loadModel('Users');
		$this->loadModel('Refers');
		$this->loadModel('Skill');
		$this->loadModel('TalentAdmin');
		$userid = $this->request->session()->read('Auth.User.id');
		$talentadmin = $this->TalentAdmin->find('all')->first();
		$referal_code = $talentadmin['referal_code'];
		$this->set('referal_code', $referal_code);
		//pr($talentadmin); die;
		if ($this->request->is(['post', 'put'])) {
			// pr($this->request->data); die;
			// Adding Individual Talents
			if ($this->request->data['refer_type'] == 'I') {
				if (!$this->checkinvited($this->request->data['email'])) {
					$users = $this->Refers->newEntity();
					$contentadmin = $this->Refers->patchEntity($users, $this->request->data);
					$savedata = $this->Refers->save($contentadmin);
					$this->sendingrefemail($this->request->data['name'], $this->request->data['email'], $referal_code);
				} else {
					$invited[] = $this->request->data['email'];
				}
			} else {
				$csv = $this->request->data['csv_file'];
				$csv_array = $this->get_csv_data($csv['tmp_name']);
				foreach ($csv_array as $refer_data) {
					$refers = $this->Refers->newEntity();
					$referdata['ref_by'] = $this->request->session()->read('Auth.User.id');
					$referdata['name'] = $refer_data['name'];
					$referdata['email'] = $refer_data['email'];
					$referdata['mobile'] = $refer_data['mobile'];
					$referdata['talenttype'] = $this->request->data['talenttype'];
					if (!$this->checkinvited($refer_data['email'])) {
						$contentadmin = $this->Refers->patchEntity($refers, $referdata);
						$savedata = $this->Refers->save($contentadmin);
						$this->sendingrefemail($refer_data['name'], $refer_data['email'], $referal_code);
					} else {
						$invited[] = $refer_data['email'];
					}
				}
			}
			if ($invited) {
				$error = "Email " . implode(",", $invited) . " already Invited.";
				$this->Flash->error(__($error));
				return $this->redirect(['action' => 'refertalent']);
			} else {
				$this->Flash->success(__('Refer has been added successfully'));
				return $this->redirect(['action' => 'refers']);
			}
			die;
		}
		//$this->set('packentity', $users);
	}

	// Checking if user already invited
	public function checkinvited($email)
	{
		$refers = $this->Refers->find('all')->where(['Refers.email' => $email])->first();
		if ($refers) {
			return true;
		} else {
			return false;
		}
	}


	// CSV Data
	function get_csv_data($inputfilename)
	{
		if ($_POST) {
			//$inputfilename = $_FILES['file']['tmp_name']; 
			try {
				$objPHPExcel = \PHPExcel_IOFactory::load($inputfilename);
			} catch (Exception $e) {
				die('Error loading file "' . pathinfo($inputfilename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
			}
			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			$c = 0;
			for ($row = 2; $row <= $highestRow; $row++) {
				$filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
				$exceldata['name'] = $filesop[0][1];
				$exceldata['email'] = $filesop[0][2];
				$exceldata['mobile'] = $filesop[0][3];
				$csv_data[] = $exceldata;
			}
			return $csv_data;
		} else {
		}
	}


	// Sending Referal Email
	function sendingrefemail($name, $email, $referal_code)
	{
		//$useractivation	=$profess['user_activation_key'];
		$this->loadmodel('Templates');
		$profile = $this->Templates->find('all')->where(['Templates.id' => REFERALINVITATION])->first();
		$subject = $profile['subject'];
		$from = $profile['from'];
		$fromname = $profile['fromname'];
		$to  = $email;
		$formats = $profile['description'];
		$site_url = SITE_URL;
		$message1 = str_replace(array('{Name}', '{Useractivation}', '{site_url}'), array($name, $referal_code, $site_url), $formats);
		$message = stripslashes($message1);
		$message = '
	<!DOCTYPE HTML>
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Mail</title>
	</head>
	<body style="padding:0px; margin:0px;font-family:Arial,Helvetica,sans-serif; font-size:13px;">
	' . $message1 . '
	</body>
	</html>
	';
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		//$headers .= 'To: <'.$to.'>' . "\r\n";
		$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
		$emailcheck = mail($to, $subject, $message, $headers);
	}


	// Subadmin list
	public function subadmins($id = null)
	{
		$this->loadModel('Users');
		$this->loadModel('TalentAdmin');
		$userid = $this->request->session()->read('Auth.User.id');
		$contentadmin = $this->TalentAdmin->find('all')->contain(['Users'])->where(['Users.is_talent_admin' => 'Y', 'TalentAdmin.talentdadmin_id' => $userid])->toarray();
		$this->set(compact('contentadmin'));
	}


	public function status($id, $status)
	{
		$this->loadModel('Users');
		if (isset($id) && !empty($id)) {
			if ($status == 'N') {
				$status = 'Y';
				$Pack = $this->Users->get($id);
				$Pack->status = $status;
				if ($this->Users->save($Pack)) {
					$this->Flash->success(__('Users status has been updated.'));
					return $this->redirect(['action' => 'subadmins']);
				}
			} else {
				$status = 'N';
				$Pack = $this->Users->get($id);
				$Pack->status = $status;
				if ($this->Users->save($Pack)) {
					$this->Flash->success(__('Users status has been updated.'));
					return $this->redirect(['action' => 'subadmins']);
				}
			}
		}
	}

	// Add Subadmin 
	public function addsubadmin($id = null)
	{
		$this->loadModel('Users');
		$this->loadModel('Country');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Talentadminskill');
		$this->loadModel('Skill');

		//$telantadmin = $this->Users->find('all')->where(['Users.is_talent_admin'=>'Y'])->order(['Users.id' => 'DESC'])->toarray();
		//$this->set('telantadmin',$telantadmin);
		$contentadminskillset = $this->Talentadminskill->find('all')->contain(['Skill'])->where(['Talentadminskill.user_id' => $id])->toarray();
		$this->set('skillofcontaint', $contentadminskillset);
		$talentsubadmin = $this->Users->find('all')->contain(['TalentAdmin', 'Talentadminskill'])->where(['Users.id' => $id])->first();
		$this->set('talentsubadmin', $talentsubadmin);
		if (isset($id) && !empty($id)) {
			$users = $this->Users->get($id);
			$talent = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $id])->first();
		} else {
			$users = $this->Users->newEntity();
			$talent = $this->TalentAdmin->newEntity();
		}
		$country = $this->Country->find('list')->select(['id', 'name'])->toarray();
		$this->set('country', $country);
		$cities = $this->City->find('list')->where(['City.state_id' => $users['state_id']])->toarray();
		$this->set('cities', $cities);
		$states = $this->State->find('list')->where(['State.country_id' => $users['country_id']])->toarray();
		$this->set('states', $states);

		if ($this->request->is(['post', 'put'])) {
			//pr($this->request->data); die;
			if (!empty($this->request->data['passedit'])) {
				$this->request->data['password'] = $this->_setPassword($this->request->data['passedit']);
			} else if (!empty($this->request->data['password'])) {
				$this->request->data['password'] = $this->_setPassword($this->request->data['password']);
			}
			$this->request->data['role_id'] = NONTALANT_ROLEID;
			$this->request->data['is_talent_admin'] = 'Y';

			try {
				$contentadmin = $this->Users->patchEntity($users, $this->request->data);
				$savedata = $this->Users->save($contentadmin);

				$user_id = $savedata->id;
				$userscon = new UsersController;
				$userscon->assigndefaultpackage($user_id);
				if ($savedata) {
					$last_user_id = $savedata->id;
					$prop_data = array();
					$prop_data['talentdadmin_id'] = $this->request->data['talent_admin'];
					$prop_data['country_id'] = $this->request->data['country_id'];
					$prop_data['state_id'] = $this->request->data['state_id'];
					$prop_data['city_id'] = $this->request->data['city_id'];
					$prop_data['commision'] = $this->request->data['commission'];
					$prop_data['user_id'] = $last_user_id;
					$prop_data['referal_code'] = md5(uniqid(rand(), true));
					$skillcheck	= $this->request->data['skill'];
					$skillcount = explode(",", $this->request->data['skill']);

					$contenttalent_admin = $this->TalentAdmin->patchEntity($talent, $prop_data);
					$savedata = $this->TalentAdmin->save($contenttalent_admin);
					if ($skillcheck) {
						$prop_skills = array();
						$this->Talentadminskill->deleteAll(['Talent_adminskills.user_id' => $id]);
						for ($i = 0; $i < count($skillcount); $i++) {
							$contentadminskill = $this->Talentadminskill->newEntity();
							$prop_skills['user_id'] = $last_user_id;
							$prop_skills['skill_id'] = $skillcount[$i];
							$contentadminskillsave = $this->Talentadminskill->patchEntity($contentadminskill, $prop_skills);
							$skilldata = $this->Talentadminskill->save($contentadminskillsave);
						}
					}
					$this->Flash->success(__('Talent admin has been added successfully'));
					return $this->redirect(['action' => 'subadmins']);
				}
			} catch (\PDOException $e) {
				$this->Flash->error(__('User Name Already Exits'));
				$this->set('error', $error);
				return $this->redirect(['action' => 'addsubadmin']);
			}
		}
		$this->set('packentity', $users);
	}



	public function getStates()
	{
		$this->loadModel('Country');
		$this->loadModel('State');
		$states = array();
		if (isset($this->request->data['id'])) {
			$states = $this->Country->State->find('list')->select(['id', 'name'])->where(['State.country_id' => $this->request->data['id']])->toarray();
		}
		header('Content-Type: application/json');
		echo json_encode($states);
		exit();
	}

	// This Function used for get city according states
	public function getcities()
	{
		$this->loadModel('City');
		$cities = array();
		if (isset($this->request->data['id'])) {
			$cities = $this->City->find('list')->select(['id', 'name'])->where(['City.state_id' => $this->request->data['id']])->toarray();
		}
		header('Content-Type: application/json');
		echo json_encode($cities);
		exit();
	}


	public function delete($id)
	{
		$this->loadModel('TalentAdmin');
		$this->loadModel('Users');
		$this->loadModel('Talentadminskill');
		$talentadmin = $this->TalentAdmin->get($id);
		if ($this->TalentAdmin->delete($talentadmin)) {
			// Change User status
			$users = $this->Users->get($talentadmin['user_id']);
			$user_info['is_talent_admin'] = 'N';
			$contentadmin = $this->Users->patchEntity($users, $user_info);
			$savedata = $this->Users->save($contentadmin);

			// Delete Talent admin skills
			$this->Talentadminskill->deleteAll(['Talent_adminskills.user_id' => $id]);
			$this->Flash->success(__('The TalentAdmin with id: {0} has been deleted.', h($id)));
			return $this->redirect(['action' => 'subadmins']);
		}
	}

	// All Transcations
	public function mytranscations()
	{
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Skillset');
		$this->loadModel('Skill');
		$this->loadModel('Talentadmintransc');
		$id = $this->request->session()->read('Auth.User.id');
		$where = " where talentadmintransc.talent_admin_id='" . $id . "'";
		$this->request->session()->write('talent_admin_transcation', $where);
		$conn = ConnectionManager::get('default');
		$talent_qry = " SELECT talentadmintransc.*, users.user_name as talent_name, users.email, GROUP_CONCAT(skill_type.name) as skill_name from talentadmintransc left join users on users.id=user_id left join personal_profile on personal_profile.user_id=talentadmintransc.user_id LEFT JOIN skill on talentadmintransc.user_id=skill.user_id LEFT JOIN skill_type ON skill.skill_id=skill_type.id  " . $where . " group by talentadmintransc.id";
		$talent = $conn->execute($talent_qry);
		$transcations = $talent->fetchAll('assoc');
		$this->set(compact('transcations'));
	}

	// All Transcations filters
	public function searchtranscation()
	{
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Skillset');
		$this->loadModel('Skill');
		$this->loadModel('Talentadmintransc');
		$id = $this->request->session()->read('Auth.User.id');

		$from_date = $this->request->data['from_date'];
		$to_date = $this->request->data['to_date'];

		$where = " where talentadmintransc.talent_admin_id='" . $id . "'";
		$cond = [];
		if (!empty($from_date) && !empty($to_date)) {
			$where .= " AND STR_TO_DATE(talentadmintransc.created_date,'%Y-%m-%d') between '" . $from_date . "' and '" . $to_date . "'";
		}

		$this->request->session()->write('talent_admin_transcation', $where);
		$conn = ConnectionManager::get('default');
		$talent_qry = " SELECT talentadmintransc.*, users.user_name as talent_name, users.email, GROUP_CONCAT(skill_type.name) as skill_name from talentadmintransc left join users on users.id=user_id left join personal_profile on personal_profile.user_id=talentadmintransc.user_id LEFT JOIN skill on talentadmintransc.user_id=skill.user_id LEFT JOIN skill_type ON skill.skill_id=skill_type.id  " . $where . " group by talentadmintransc.id";

		$talent = $conn->execute($talent_qry);
		$transcations = $talent->fetchAll('assoc');
		$this->set(compact('transcations'));
	}

	// export transcations
	public function exporttalentadmin()
	{
		$this->autoRender = false;
		$blank = "NA";
		$conn = ConnectionManager::get('default');
		$output = "";

		$output .= '"Sr Number",';
		$output .= '"Date",';
		$output .= '"Name",';
		$output .= '"Email",';
		$output .= '"Skills",';
		$output .= '"Transcation Carried out",';
		$output .= '"Commission Earned",';
		$output .= '"Payout Amount",';
		$output .= "\n";
		//pr($job); die;
		$str = "";

		//$where = " where users.is_talent_admin = 'Y'";
		$where = $this->request->session()->read('talent_admin_transcation');
		$conn = ConnectionManager::get('default');
		$talent_qry = " SELECT talentadmintransc.*, users.user_name as talent_name, users.email, GROUP_CONCAT(skill_type.name) as skill_name from talentadmintransc left join users on users.id=user_id left join personal_profile on personal_profile.user_id=talentadmintransc.user_id LEFT JOIN skill on talentadmintransc.user_id=skill.user_id LEFT JOIN skill_type ON skill.skill_id=skill_type.id  " . $where . " group by talentadmintransc.id";

		//echo $talent_qry; die;
		$talent = $conn->execute($talent_qry);
		$talents = $talent->fetchAll('assoc');
		$cnt = 1;
		foreach ($talents as $talent_data) {

			$skills = str_replace(",", " ", $talent_data['skill_name']);
			$output .= $cnt . ",";
			$output .= $talent_data['created_date'] . ",";
			$output .= $talent_data['talent_name'] . ",";
			$output .= $talent_data['email'] . ",";
			$output .= $skills . ",";
			$output .= $talent_data['description'] . ",";
			$output .= $talent_data['amount'] . ",";
			$output .= $talent_data['payout_amount'] . ",";
			//$output .=$blank.",";
			//$output .=$blank.",";
			$cnt++;
			$output .= "\r\n";
		}

		$filename = "Talent_admins_trans.xlsx";
		header('Content-type: application/xlsx');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		die;
		$this->redirect($this->referer());
	}



	// Banking information 
	public function bankinformation()
	{
		$this->loadModel('Users');
		$this->loadModel('Country');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('TalentAdmin');

		$country = $this->Country->find('list')->select(['id', 'name'])->toarray();
		$this->set('country', $country);

		$id = $this->request->session()->read('Auth.User.id');

		$talentadmin = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $id])->first();
		$talentadmin_id = $talentadmin['id'];
		$this->set('bankinginformation', $talentadmin);
		if ($this->request->is(['post', 'put'])) {
			$talent_admin_data = $this->TalentAdmin->get($talentadmin_id);
			$talent_admin_datas = $this->TalentAdmin->patchEntity($talent_admin_data, $this->request->data);
			if ($this->TalentAdmin->save($talent_admin_datas)) {
				$this->Flash->success(__('Banking information has been updated successfully'));
				return $this->redirect(['action' => 'bankinformation']);
			}
		}
	}


	public function skills($id = null)
	{
		$this->loadModel('Users');
		$this->loadModel('Talentadminskill');
		$this->loadModel('Skill');
		if ($id != null) {
			$contentadminskillset = $this->Talentadminskill->find('all')->contain(['Skill'])->where(['Talentadminskill.user_id' => $id])->order(['Talentadminskill.id' => 'DESC'])->toarray();
		}
		$Skill = $this->Skill->find('all')->select(['id', 'name'])->where(['Skill.status' => 'Y'])->toarray();
		$this->set('Skill', $Skill);
		$this->set('skillset', $contentadminskillset);
	}
}
