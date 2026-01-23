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
use PHPExcel_IOFactory;
use PHPExcel;


include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

class TalentadminController extends AppController
{


	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['excelimport']);
	}
	public function personaldetail()
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
			//	pr($this->request->data); die;
			$talent_admin_data = $this->TalentAdmin->get($talentadmin_id);
			$talent_admin_datas = $this->TalentAdmin->patchEntity($talent_admin_data, $this->request->data);
			if ($this->TalentAdmin->save($talent_admin_datas)) {
				$this->Flash->success(__('personaldetail information has been updated successfully'));
				return $this->redirect(['action' => 'personaldetail']);
			}
		}
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
		$this->loadModel('TalentAdmin');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Country');

		$session = $this->request->session();
		$session->delete('profile_filter');
		$talentadmin = $this->TalentAdmin->find('all')->where(['user_id' => $this->request->session()->read('Auth.User.id')])->first();
		// pr($talentadmin);exit;

		if ($talentadmin) {
			$contentadmin = $this->Refers->find('all')->where(['Refers.ref_by' => $this->request->session()->read('Auth.User.id')])->order(['Refers.id' => 'DESC'])->toarray();
			// pr($contentadmin);exit;
			$this->set(compact('contentadmin'));

			$referemail = $this->Refers->find('all')->select(['Refers.email'])->where(['Refers.ref_by' => $this->request->session()->read('Auth.User.id'), 'Refers.status' => 'Y'])->order(['Refers.id' => 'ASC'])->toarray();

			$emailid = []; // initialize emailid array
			foreach ($referemail as $emails) {
				$emailid[] = $emails['email'];
			}

			if (!empty($emailid)) { // check if emailid is not empty
				$countyids = $this->Users->find('list', ['keyField' => 'id', 'valueField' => 'Profile.country_ids'])->contain(['Profile'])->select(['Profile.country_ids'])->where(['Users.email IN' => $emailid])->order(['Users.id' => 'ASC'])->toarray();

				if (!empty($countyids)) {
					$country = $this->Country->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Country.id IN' => $countyids])->order(['Country.id' => 'ASC'])->toarray();
				}

				$this->set('country', $country);
			} else {
				$this->set('country', []);
			}
		} else {
			$this->Flash->error(__('You are not authorized to access that location.'));
			return $this->redirect($this->referer());
		}
	}


	public function referdelete($id)
	{

		$this->loadModel('Refers');
		$talent = $this->Refers->get($id);
		if ($this->Refers->delete($talent)) {

			//$this->Flash->success(__('The refer talent with id: {0} has been deleted.', ($id)));
			$this->Flash->success(__($talent['name'] . "'s Profile has been deleted successfully"));
			return $this->redirect($this->referer());
		}
	}

	// Refer talents
	public function refertalent($id = null)
	{
		$this->loadModel('Users');
		$this->loadModel('Refers');
		$this->loadModel('Skill');
		$this->loadModel('Profile');
		$this->loadModel('TalentAdmin');
		$userid = $this->request->session()->read('Auth.User.id');
		// pr($userid);die;
		$talentadmin = $this->TalentAdmin->find('all')->where(['user_id' => $userid])->first();
		$referal_code = $talentadmin['referal_code'];
		$this->set('referal_code', $referal_code);
		// pr($talentadmin); die;

		if (empty($talentadmin)) {
			$this->Flash->error(__('You are not authorized to access that location.'));
			return $this->redirect($this->referer());
		}

		if ($this->request->is(['post', 'put'])) {

			//pr($this->request->data); die;
			// Adding Individual Talents
			if ($this->request->data['refer_type'] == 'I') {
				// if(!$this->checkinvited($this->request->data['email']))
				// {
				$users = $this->Refers->newEntity();
				$contentadmin = $this->Refers->patchEntity($users, $this->request->data);
				$savedata = $this->Refers->save($contentadmin);
				$this->sendingrefemail($this->request->data['name'], $this->request->data['email'], $referal_code);
				// }
				// else
				// {	
				// 	//$invited[] = $this->request->data['email'];
				// 	$refername['name'] = $this->request->data['name'];
				// 	$refername['email'] = $this->request->data['email'];
				// 	$invited[]=$refername;

				// }
			} else {
				$csv = $this->request->data['csv_file'];
				$csv_array = $this->get_csv_data($csv['tmp_name']);
				$re = count($csv_array);
				//	pr($csv_array); die;
				foreach ($csv_array as $refer_data) {
					$refers = $this->Refers->newEntity();
					$referdata['ref_by'] = $this->request->session()->read('Auth.User.id');
					$referdata['mobile'] = $refer_data['mobile'];
					$referdata['talenttype'] = $this->request->data['talenttype'];
					if (!empty($refer_data['name']) && !empty($refer_data['email'])) {
						//echo "hello"; die;
						$referdata['name'] = $refer_data['name'];
						$referdata['email'] = $refer_data['email'];

						$emailformat = $referdata['email'];
						if (filter_var($emailformat, FILTER_VALIDATE_EMAIL)) {
							//echo $emailformat."</br>Valid"; die;
							if (!$this->checkinvited($refer_data['email'])) {
								$contentadmin = $this->Refers->patchEntity($refers, $referdata);
								$savedata = $this->Refers->save($contentadmin);
								$this->sendingrefemail($refer_data['name'], $refer_data['email'], $referal_code);
							} else {
								/*$refername[] = $refer_data['name'];
    						$invited[$refername] = $refer_data['email'];*/
								$refername['name'] = $refer_data['name'];
								$refername['email'] = $refer_data['email'];
								$invited[] = $refername;
							}
						} else {
							// echo $emailformat."</br>Invalid"; die;
							$invalidemail['name'] = $refer_data['name'];
							$invalidemail['email'] = $refer_data['email'];
							$invalid[] = $invalidemail;
						}
					} else {
						//echo "hii"; die;
						$blankfield['name'] = $refer_data['name'];
						$blankfield['email'] = $refer_data['email'];
						$blankfield['mobile'] = $refer_data['mobile'];
						$blank[] = $blankfield;
					}
				}
			}
			//pr($blank); die;

			$session = $this->request->session();
			$session->write('referinvited', $invited);
			$session->write('blank', $blank);
			$session->write('invalid', $invalid);
			$reject = count($_SESSION['referinvited']);
			$blankcount = count($_SESSION['blank']);
			$invalidcount = count($_SESSION['invalid']);
			//	echo $reject."<br>".$blankcount; die;
			$totalfaild = $reject + $blankcount + $invalidcount;
			$successcount = $re - $totalfaild;

			if (isset($invited) || isset($blank) || isset($invalid)) {
				//$error = "Email ".implode(",",$invited)." already Invited.";
				//$error = "The following profiles have already been uploaded";
				$this->Flash->error(__('The project has been saved.'), ['key' => 'refer_fail']);
				if ($successcount > 0) {
					$this->Flash->error(__('Profiles - ' . $successcount . ' out of ' . $re . ' profiles have been uploaded successfully.'), ['key' => 'count']);
				} else {
					$this->Flash->error(__('None of the profiles have been uploaded.'), ['key' => 'count']);
				}
				$this->Flash->error(__('The following have not been uploaded as they are already present in the site.'), ['key' => 'refer_error']);
				$this->Flash->error(__('The following have not been uploaded. Some detail is missing.'), ['key' => 'blank']);
				$this->Flash->error(__('The following have not been uploaded. the email detail is invalid.'), ['key' => 'invalid']);

				return $this->redirect(['action' => 'refertalent']);

				// 			}elseif($blank){
				// 				$this->Flash->error(__('The project has been saved.'), ['key' => 'refer_fail']);
				// 				$this->Flash->error(__($reject.' out of '.$re.' have been uploaded successfully, the following have not been uploaded as they are already represent in the site.'), ['key' => 'refer_error']);
				// 				return $this->redirect(['action' => 'refertalent']);
			} elseif ($csv_array) {
				$this->Flash->success(__('All profiles have been successfully uploaded'), ['key' => 'allsuc']);
				return $this->redirect(['action' => 'refertalent']);
			} else {
				$this->Flash->success(__("Profile has been uploaded successfully. Please inform " . $savedata['name']), ['key' => 'sucess']);
				return $this->redirect(['action' => 'refertalent']);
			}
			die;
		}
		//$this->set('packentity', $users);
	}

	// Checking if user already invited
	public function checkinvited($email)
	{
		$this->loadModel('Refers');
		//echo $email; die;
		//$this->loadModel('Profile');
		//$refid= $this->request->session()->read('Auth.User.id');

		//$refersoldid = $this->Refers->deleteAll(['Refers.email' =>$email,'Refers.ref_by' =>$refid,'status'=>'N']);

		$refers = $this->Refers->find('all')->where(['Refers.email' => $email])->first();
		$usertalent	= $this->Users->find('all')->where(['Users.email' => $email, 'Users.user_delete' => 'N'])->first();
		$talentadmin = $this->TalentAdmin->find('all')->where(['TalentAdmin.email' => $email, 'TalentAdmin.talentdadmin_id' => 1])->first();
		//pr($refers); die;

		//$this->checkAlertnetEmail($email);

		if ($refers || $usertalent || $talentadmin) {
			return true;
		} else {
			return false;
		}
	}


	/*public function checkAlertnetEmail($email){
		$alternetemail	= $this->Profile->find('all')->select(['id','altemail'])->where(['altemail !='=>''])->toarray();
		pr($alternetemail); die;
	}*/


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
			//pr($sheet); die;
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			$c = 0;

			$firstrow = 1;
			$firstsop = $sheet->rangeToArray('A' . $firstrow . ':' . $highestColumn . $firstrow, NULL, TRUE, FALSE);

			if ($firstsop[0][1] != 'Name*' && $firstsop[0][1] != 'Name') {
				$namee = 1;
			}
			if ($firstsop[0][2] != 'Email*' && $firstsop[0][2] != 'Email') {
				$emaile = 1;
			}
			if ($firstsop[0][3] != "Phone No (use country code)") {
				$phonee = 1;
			}

			if ($namee == 1 && $emaile == 1 && $phonee == 1) {
				$this->Flash->error(__('Please change column heading ' . $firstsop[0][1] . ' to Name and upload file again.'), ['key' => 'columnerror']);
				$this->Flash->error(__('Please change column heading ' . $firstsop[0][2] . ' to Email and upload file again.'), ['key' => 'columnerror']);
				$this->Flash->error(__('Please change column heading ' . $firstsop[0][3] . ' to Phone No (use country code) and upload file again.'), ['key' => 'columnerror']);
				return $this->redirect(['action' => 'refertalent']);
				die;
			} elseif ($namee == 1 && $emaile == 1) {
				$this->Flash->error(__('Please change column heading ' . $firstsop[0][1] . ' to Name and upload file again.'), ['key' => 'columnerror']);
				$this->Flash->error(__('Please change column heading ' . $firstsop[0][2] . ' to Email and upload file again.'), ['key' => 'columnerror']);
				return $this->redirect(['action' => 'refertalent']);
				die;
			} elseif ($namee == 1 && $phonee == 1) {
				$this->Flash->error(__('Please change column heading ' . $firstsop[0][1] . ' to Name and upload file again.'), ['key' => 'columnerror']);
				$this->Flash->error(__('Please change column heading ' . $firstsop[0][3] . ' to Phone No (use country code) and upload file again.'), ['key' => 'columnerror']);
				return $this->redirect(['action' => 'refertalent']);
				die;
			} elseif ($phonee == 1 && $emaile == 1) {
				$this->Flash->error(__('Please change column heading ' . $firstsop[0][2] . ' to Email and upload file again.'), ['key' => 'columnerror']);
				$this->Flash->error(__('Please change column heading ' . $firstsop[0][3] . ' to Phone No (use country code) and upload file again.'), ['key' => 'columnerror']);
				return $this->redirect(['action' => 'refertalent']);
				die;
			} elseif ($namee == 1) {
				$this->Flash->error(__('Please change column heading ' . $firstsop[0][1] . ' to Name and upload file again.'), ['key' => 'columnerror']);
				return $this->redirect(['action' => 'refertalent']);
				die;
			} elseif ($emaile == 1) {
				$this->Flash->error(__('Please change column heading ' . $firstsop[0][2] . ' to Email and upload file again.'), ['key' => 'columnerror']);
				return $this->redirect(['action' => 'refertalent']);
				die;
			} elseif ($phonee == 1) {
				$this->Flash->error(__('Please change column heading ' . $firstsop[0][3] . ' to Phone No (use country code) and upload file again.'), ['key' => 'columnerror']);
				return $this->redirect(['action' => 'refertalent']);
				die;
			}
			/*elseif($firstsop[0][4]!='Skills'){
				$this->Flash->error(__('Skills Columm is Not Correct!'));
				return $this->redirect(['action' => 'refertalent']);
		
			} */ else {



				for ($row = 2; $row <= $highestRow; $row++) {
					$filesop = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

					$colB = $objPHPExcel->getActiveSheet()->getCell('A' . $row)->getValue();

					if ($colB == NULL || $colB == '') {
						$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $objPHPExcel->getActiveSheet()->getCell('A' . ($row - 1))->getValue());
					}
					if ($filesop[0][1] != '') {
						$exceldata['name'] = $filesop[0][1];
					} else {
						//$this->Flash->error(__('Name is Missing!'));
						//return false;
						$exceldata['name'] = "";
					}
					if ($filesop[0][2] != '') {
						$exceldata['email'] = $filesop[0][2];
					} else {
						//$this->Flash->error(__('Email is Missing!'));
						//return false;
						$exceldata['email'] = "";
					}
					if ($filesop[0][3] != '') {
						$exceldata['mobile'] = $filesop[0][3];
					} else {
						//$this->Flash->error(__('mobile is Missing!'));
						//return false;
						$exceldata['mobile'] = "";
					}

					$csv_data[] = $exceldata;
				}
				//$this->Flash->success(__('Refer has been added successfully'));
			}
			return $csv_data;
		} else {
		}
	}


	// Sending Referral Email
	function sendingrefemail($name = null, $email = null, $referal_code = null)
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
		$this->loadModel('Country');
		$userid = $this->request->session()->read('Auth.User.id');
		$contentadmin = $this->TalentAdmin->find('all')->where(['TalentAdmin.talentdadmin_id' => $userid])->order(['TalentAdmin.id' => 'DESC'])->toarray();
		// pr($contentadmin); die;
		if ($contentadmin) {
			$this->set(compact('contentadmin'));

			//$talentcountry = $this->TalentAdmin->find('list',['keyField'=>'id','valueField'=>'country_id'])->select(['TalentAdmin.country_id'])->where(['TalentAdmin.talentdadmin_id'=>$userid,'TalentAdmin.user_id IS NOT'=>NULL])->toarray();
			$talentcountry = $this->TalentAdmin->find('list', ['keyField' => 'id', 'valueField' => 'country_id'])->select(['TalentAdmin.country_id'])->where(['TalentAdmin.talentdadmin_id' => $userid])->toarray();
			//pr($talentcountry);
			if (!empty($talentcountry)) {
				$country = $this->Country->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Country.id IN' => $talentcountry])->order(['Country.id' => 'ASC'])->toarray();
			}
			//pr($country);
			// $country = $this->TalentAdmin->find('all')->select(['Country.name','Country.id'])->contain(['Country'])->order(['Country.name' => 'ASC'])->toarray();
			$this->set('country', $country);
		} else {
			//$this->Flash->error(__('You have not created any Talent Partner Yet.'));
			//	return $this->redirect(['action' => 'index']);
			//return $this->redirect(['controller'=>'dashboard','action' => 'index']);
		}
	}

	public function talentpartnersearch()
	{
		$this->loadModel('Users');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Skill');
		$this->loadModel('Talentadminskill');
		$this->loadModel('Refers');

		//$this->request->session()->delete('Config.talent_admin_filter');

		$from_date = $this->request->data['from_date'];
		$to_date = $this->request->data['to_date'];
		$name = $this->request->data['name'];
		$email = $this->request->data['email'];
		$country_id = $this->request->data['country_id'];
		$state_id = $this->request->data['state_id'];
		$city_id = $this->request->data['city_id'];
		$status = $this->request->data['status'];
		if ($status == "") {
			$status = 0;
		}
		//echo $status; die;

		$userid = $this->request->session()->read('Auth.User.id');
		//pr($this->request->data); die;
		$refercount = $this->Users->find('all')->contain(['Refers'])->where(['Users.id' => $id, 'Users.is_talent_admin' => 'Y'])->first();
		$cond = [];
		//$cond['Users.is_talent_admin'] = "Y";	

		if (!empty($from_date)) {
			$cond['DATE(TalentAdmin.created_date) >='] = date('Y-m-d', strtotime($from_date));
		}

		if (!empty($to_date)) {
			$cond['DATE(TalentAdmin.created_date) <='] = date('Y-m-d', strtotime($to_date));
		}

		if (!empty($to_date)) {
			$cond['DATE(TalentAdmin.created_date) <='] = date('Y-m-d', strtotime($to_date));
		}

		if (!empty($name)) {
			$cond['TalentAdmin.user_name LIKE'] = "%" . $name . "%";
		}

		if (!empty($email)) {
			$cond['TalentAdmin.email LIKE'] = "%" . $email . "%";
		}

		if (!empty($country_id)) {
			$cond['TalentAdmin.country_id'] = $country_id;
		}

		if (!empty($state_id)) {
			$cond['TalentAdmin.state_id'] = $state_id;
		}

		if (!empty($city_id)) {
			$cond['TalentAdmin.city_id'] = $city_id;
		}

		//pr($cond); die;


		$this->request->session()->write('Config.talent_admin_filter', $cond);

		$contentadmin = $this->TalentAdmin->find('all')->where([$cond, 'TalentAdmin.talentdadmin_id' => $userid])->toarray();
		//pr($contentadmin); die;
		/*$conn = ConnectionManager::get('default');
	    $talent_qry = " SELECT talent_admin.*,talent_admin.created_date as talent_from, users.user_name, users.created as membership_from, GROUP_CONCAT(skill_type.name) as skill_name, users.is_talent_admin, country.name as country, states.name as state, cities.name as city from talent_admin INNER join users on users.id=talent_admin.user_id LEFT JOIN talentadminskill on talent_admin.id=talentadminskill.talent_admin_id  LEFT JOIN skill_type ON talentadminskill.skill_id=skill_type.id LEFT JOIN country on country.id=talent_admin.country_id left join states on states.id=talent_admin.state_id left join cities on cities.id=talent_admin.city_id ".$where."  group by users.id ";
	   // echo $talent_qry; die;
	    $talent = $conn->execute($talent_qry);
	    $contentadmin = $talent ->fetchAll('assoc');*/
		//pr($contentadmin); die;
		$this->set(compact('status', 'contentadmin'));
	}

	public function uploadedprofilesearch()
	{
		$this->loadModel('Users');
		$this->loadModel('Refers');
		$this->loadModel('Profile');
		$this->loadModel('Transcation');

		$from_date = $this->request->data['from_date'];
		$to_date = $this->request->data['to_date'];
		$name = $this->request->data['name'];
		$email = $this->request->data['email'];
		$country_id = $this->request->data['country_id'];
		$state_id = $this->request->data['state_id'];
		$city_id = $this->request->data['city_id'];
		$status = $this->request->data['status'];
		$transaction = $this->request->data['transaction'];
		$userid = $this->request->session()->read('Auth.User.id');
		// pr($this->request->data); die;

		$cond = [];

		if (!empty($from_date)) {
			$cond['DATE(Refers.created) >='] = date('Y-m-d', strtotime($from_date));
		}
		if (!empty($to_date)) {
			$cond['DATE(Refers.created) <='] = date('Y-m-d', strtotime($to_date));
		}


		if (!empty($name)) {
			$cond['Refers.name LIKE'] = "%" . $name . "%";
		}

		if (!empty($email)) {
			$cond['Refers.email LIKE'] = "%" . $email . "%";
		}

		if (!empty($status)) {
			$cond['Refers.status'] = $status;
		}

		// if(!empty($transaction))
		// {
		// 	if($transaction=="Y"){
		// 		$cond['Transaction.country_ids'] =$country_id;
		// 	}else{   

		// 	}
		// 	$cond['Refers.status']=$status;
		// }  

		if (!empty($country_id)) {
			$cond['Profile.country_ids'] = $country_id;
		}

		if (!empty($state_id)) {
			$cond['Profile.state_id'] = $state_id;
		}

		if (!empty($city_id)) {
			$cond['Profile.city_id'] = $city_id;
		}
		$referdata = $this->Refers->find('all')->where(['Refers.ref_by' => $userid])->toarray();
		foreach ($referdata as $value) {
			$tranaction = $this->Transcation->find('all')->where(['Transcation.user_id' => $value['user_id']])->first();
			if ($tranaction) {
				$data_tr[] = $tranaction['user_id'];
			} else {
				$data_re[] = $value['id'];
			}
		}


		if (!empty($transaction)) {
			if ($transaction == "Y") {
				$cond['Refers.user_id IN'] = $data_tr;
			} else {
				$cond['Refers.id IN'] = $data_re;
			}
		}

		$this->request->session()->write('profile_filter', $cond);
		$contentadmin = $this->Refers->find('all')->contain(['Users' => ['Profile']])->where(['Refers.ref_by' => $userid, $cond])->order(['Refers.id' => 'DESC'])->toarray();
		//pr($contentadmin); die;

		$this->set(compact('contentadmin'));
	}
	


	public function uploadedprofilexcel()
	{
		$this->loadModel('Users');
		$this->loadModel('Refers');
		$this->loadModel('Profile');
		$this->loadModel('Country');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Transcation');
		// Disable auto-rendering
		$this->autoRender = false;

		// Create a new instance of PHPExcel
		$objPHPExcel = new PHPExcel();

		// Set properties for the Excel file
		$objPHPExcel->getProperties()
			->setCreator("Your Name")
			->setLastModifiedBy("Your Name")
			->setTitle("Profiles Uploaded Export")
			->setSubject("Profiles Uploaded Export")
			->setDescription("Export of profiles uploaded data in Excel format.")
			->setKeywords("profiles uploaded export excel")
			->setCategory("Exported data");

		// Set column widths for better readability
		$columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
		foreach ($columns as $col) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}

		// Define the header row
		$headers = [
			'Sr Number',
			'Name',
			'Country',
			'State',
			'City',
			'Email',
			'Phone Number',
			'Uploaded On',
			'Transaction Total',
			'Last Transaction On',
			'Status'
		];
		$objPHPExcel->getActiveSheet()->fromArray($headers, null, 'A1');

		// Fetch data from database
		$userid = $this->request->session()->read('Auth.User.id');
		$cond = $this->request->session()->read('profile_filter');
		$contentadmin = $this->Refers->find('all')->contain(['Users' => ['Profile' => ['Country', 'State', 'City']]])->where(['Refers.ref_by' => $userid, $cond])->order(['Refers.id' => 'DESC'])->toArray();

		// Initialize row counter and Sr Number counter
		$row = 2;
		$cnt = 1;

		// Iterate through the data and populate the Excel sheet
		foreach ($contentadmin as $admin) {
			$rowData = [
				$cnt,
				$admin['name'],
				!empty($admin['user']['profile']['country']['name']) ? $admin['user']['profile']['country']['name'] : '-',
				!empty($admin['user']['profile']['state']['name']) ? $admin['user']['profile']['state']['name'] : '-',
				!empty($admin['user']['profile']['city']['name']) ? $admin['user']['profile']['city']['name'] : '-',
				$admin['email'],
				$admin['mobile'],
				//(!empty($admin['user']['profile']['phone']) ? str_replace('+', '', $admin['user']['profile']['phone']) : '-') .
				//(!empty($admin['user']['profile']['altnumber']) ? ' ' . str_replace('+', '', $admin['user']['profile']['altnumber']) : ''),
				date('M-d-Y', strtotime($admin['created'])),
				$admin['user'] ? (number_format($this->Transcation->find()->select(['sum' => 'SUM(amount)'])->where(['user_id' => $admin['user']['id']])->first()['sum'], 2)) : 'No Transaction',
				$admin['user'] ? (date('d-M-Y h:i:s A', strtotime($this->Transcation->find('all')->select(['created'])->where(['user_id' => $admin['user']['id']])->order(['id' => 'DESC'])->first()['created']))) : 'No Transaction',
				$admin['status'] == 'Y' ? 'Registered' : 'Not Registered',
			];

			// Write the row data to the Excel sheet
			$objPHPExcel->getActiveSheet()->fromArray($rowData, null, 'A' . $row);

			// Increment row counter and Sr Number counter
			$row++;
			$cnt++;
		}

		// Set the active sheet index to the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Set the file headers for downloading the Excel file
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Profiles_Uploaded.xlsx"');
		header('Cache-Control: max-age=0');

		// Create an Excel writer object
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		// Output the Excel file to the browser for downloading
		$objWriter->save('php://output');

		// End script execution
		exit();
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

	/*public function checktalent($username = null)
		{

			$name = '';
			$id = '';
			$this->loadModel('Users');
			$username=$this->request->data['username'];
			$user = $this->Users->find('all')->where(['Users.email' =>$username,'Users.is_talent_admin'=>'Y'])->first();
			//pr($user); die;
			if($user){
				$name="Y";
				$user_name=$user['user_name'];
			}else{
				$usertalent	= $this->Users->find('all')->where(['Users.email' =>$username])->first();
				
				$name = $usertalent['user_name'];
				$id =$usertalent['id'];
			}
			$response['name']=$name;
			$response['id']=$id;
			$response['user_name']=$user_name;
			echo json_encode($response); die;
		}*/

	public function checktalent($username = null)
	{

		$name = '';
		$id = '';
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Country');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Refers');
		$username = $this->request->data['username'];
		$userprofile = $this->request->data['userprofile'];
		// pr($this->request->data); die;
		if ($userprofile) {
			$users = $this->Users->find('all')->where(['Users.email' => $userprofile])->first();
			$talent = $this->TalentAdmin->find('all')->where(['TalentAdmin.email' => $userprofile, 'TalentAdmin.talentdadmin_id' => 1])->first();
			//pr($users); die;
			//$talentadmin = $this->TalentAdmin->find('all')->where(['TalentAdmin.email' =>$userprofile])->first();
			$refers = $this->Refers->find('all')->where(['Refers.email' => $userprofile])->first();

			if ($users) {
				$name = "Y";
				$user_name = $users['user_name'];
				$response['user_name'] = $user_name;
			} else if ($refers) {
				$name = "R";
				$user_name = $refers['name'];
				$response['user_name'] = $user_name;
			} else if ($talent) {
				$name = "T";
				$user_name = $talent['user_name'];
				$response['user_name'] = $user_name;
			}
			$response['name'] = $name;

			echo json_encode($response);
			die;
		} else {

			//$user = $this->Users->find('all')->where(['Users.email' =>$username,'Users.is_talent_admin'=>'Y'])->first();
			$user = $this->TalentAdmin->find('all')->where(['TalentAdmin.email' => $username])->first();
			//pr($user); die;
			if ($user) {
				$name = "Y";
				$user_name = $user['user_name'];
			} else {
				$usertalent	= $this->Users->find('all')->where(['Users.email' => $username])->first();
				$name = $usertalent['user_name'];
				$id = $usertalent['id'];
				$usersProfile = $this->Profile->find('all')->where(['user_id' => $id])->first();
				$country = $this->Country->find('all')->select(['id', 'name'])->where(['Country.id' => $usersProfile['country_ids']])->first();
				$states = $this->State->find('all')->where(['State.id' => $usersProfile['state_id']])->first();
				$cities = $this->City->find('all')->where(['City.id' => $usersProfile['city_id']])->first();

				$response['country'] = $country['id'];
				$response['state'] = $states['id'];
				$response['city'] = $cities['id'];
			}
			$response['name'] = $name;
			$response['id'] = $id;
			$response['user_name'] = $user_name;
			echo json_encode($response);
			die;
		}
	}

	public function randomPassword()
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}

	public function newTalentMailsend($user_name = null, $email = null)
	{

		/*sending email start */
		$this->loadmodel('Templates');
		$this->loadmodel('Users');

		//if ($user_name) {
		$profile = $this->Templates->find('all')->where(['Templates.id' => OLDTALENTPARTNER])->first();
		$subject = $profile['subject'];
		$from = $profile['from'];
		$fromname = $profile['fromname'];
		$to  = $email;
		//echo $email; die;
		$userexist = $this->Users->find('all')->where(['Users.email' => $email])->count();
		//pr($userexist); die;
		if ($userexist == 1) {
			$visit_site_url = SITE_URL . "/login";
		} else {
			$visit_site_url = SITE_URL . "/signup";
		}
		//echo $site_url;
		$site_url = SITE_URL;
		$formats = $profile['description'];



		$message1 = str_replace(array('{Name}', '{site_url}', '{visit_site_url}'), array($user_name, $site_url, $visit_site_url), $formats);
		$message = stripslashes($message1);
		$message = '
		<!DOCTYPE HTML>
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		</head>
		<body style="padding:0px; margin:0px;font-family:Arial,Helvetica,sans-serif; font-size:13px;">
		' . $message1 . '
		</body>
		</html>';
		//pr($message);
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		//$headers .= 'To: <'.$to.'>' . "\r\n";
		$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
		$emailcheck = mail($to, $subject, $message, $headers);

		// }else{
		// 		$profile = $this->Templates->find('all')->where(['Templates.id' =>OLDTALENTPARTNER])->first();
		// 		$subject = $profile['subject'];
		// 		$from= $profile['from'];
		// 		$fromname = $profile['fromname'];
		// 		$to  = $email;
		// 		$formats=$profile['description'];
		// 		$site_url=SITE_URL;

		// 		$message1 = str_replace(array('{Name}','{site_url}'), array($user_name,$site_url), $formats);
		// 		$message = stripslashes($message1);
		// 		$message='
		// 		<!DOCTYPE HTML>
		// 		<html>
		// 		<head>
		// 		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		// 		</head>
		// 		<body style="padding:0px; margin:0px;font-family:Arial,Helvetica,sans-serif; font-size:13px;">
		// 		'.$message1.'
		// 		</body>
		// 		</html>';	
		// 		//pr($message);
		// 		$headers = 'MIME-Version: 1.0' . "\r\n";
		// 		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		// 	//$headers .= 'To: <'.$to.'>' . "\r\n";
		// 		$headers .= 'From: '.$fromname.' <'.$from.'>' . "\r\n";
		// 		$emailcheck= mail($to, $subject, $message, $headers);
		//	}

		/*if($emailcheck){
	    echo "mail sent"; die;
	}else{
	   echo "no"; die;
	}*/
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
		$this->loadModel('Sitesettings');
		$this->loadModel('Skill');

		$tal_part_comm = $this->Sitesettings->find('all')->select(['tal_part_comm'])->first();
		$this->set('tal_part_comm', $tal_part_comm);

		$contentadminskillset = $this->Talentadminskill->find('all')->contain(['Skill'])->where(['Talentadminskill.user_id' => $id])->toarray();
		$this->set('skillofcontaint', $contentadminskillset);
		$talentsubadmin = $this->Users->find('all')->contain(['TalentAdmin', 'Talentadminskill'])->where(['Users.id' => $id])->first();

		$this->set('talentsubadmin', $talentsubadmin);

		$country = $this->Country->find('list')->select(['id', 'name'])->toarray();
		$this->set('country', $country);

		//pr($this->request->data); die;

		if (isset($id) && !empty($id)) {
			$users = $this->TalentAdmin->find('all')->contain(['Talentadminskill'])->where(['TalentAdmin.id' => $id])->first();
			$this->set('packentity', $users);
			//$talent = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $id])->first();
			$talent = $this->TalentAdmin->get($id);

			//pr($talent); die;

			$cities = $this->City->find('list')->where(['City.state_id' => $users['state_id']])->toarray();
			$this->set('cities', $cities);

			$states = $this->State->find('list')->where(['State.country_id' => $users['country_id']])->toarray();
			$this->set('states', $states);
		} elseif ($this->request->data['non_tp_id'] != '') {
			$userid = $this->request->data['non_tp_id'];

			$users = $this->Users->get($userid);
			$talent = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $userid])->first();

			if ($users['is_talent_admin'] == 'Y' && $talent) {
				$this->Flash->error(__($users['user_name'] . ' is already a Talent partner'));
				$this->set('error', $error);
				return $this->redirect(['action' => 'addsubadmin']);
			} else {
				$talent = $this->TalentAdmin->newEntity();
				// $this->request->data['is_talent_admin']= 'Y';
				// $this->request->data['is_talent_admin_accept']= 2;
			}
		} else {
			$email = $this->request->data['email'];
			$usersexsits = $this->Users->find('all')->where(['Users.email' => $email])->first();
			$talent = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $usersexsits['email']])->first();

			if ($usersexsits['is_talent_admin'] == 'Y' && $talent) {
				$this->Flash->error(__($usersexsits['user_name'] . ' is already a Talent partner'));
				$this->set('error', $error);
				return $this->redirect(['action' => 'addsubadmin']);
			} else {

				//$users = $this->Users->newEntity();
				$talent = $this->TalentAdmin->newEntity();
				//  	$this->request->data['role_id']= NONTALANT_ROLEID;
				// $this->request->data['is_talent_admin']= 'Y';
				// $this->request->data['is_talent_admin_accept']= 1;

				//  	$passwordr = $this->randomPassword();
				// $hasher = new DefaultPasswordHasher();
				// $password = $hasher->hash($passwordr);
				// $this->request->data['password']=$password;
			}
		}



		if ($this->request->is(['post', 'put'])) {


			// pr($this->request->data); die;

			if ($this->request->data['user_name']) {
				$this->request->data['user_name'] = $this->request->data['user_name'];
			} else {
				$this->request->data['user_name'] = $this->request->data['user_name2'];
			}

			// 	$contentadmin = $this->Users->patchEntity($users, $this->request->data);
			// 	$savedata=$this->Users->save($contentadmin);

			// 	if ($savedata)   
			// 	{
			// 	if ($passwordr) {
			// 		$user_id = $savedata->id;
			// 		$userscon = new UsersController;
			// 		$userscon->assigndefaultpackage($user_id);
			// 	}

			// pr($$id);exit;

			if ($id == "") {
				$newTalentMail = $this->newTalentMailsend($this->request->data['user_name'], $this->request->data['email']);
			}
			//$last_user_id= $savedata->id;
			$prop_data = array();
			$userexist = $this->Users->find('all')->where(['Users.email' => $this->request->data['email'], 'Users.user_delete' => 'N'])->first();
			$talentexist = $this->TalentAdmin->find('all')->where(['TalentAdmin.email' => $this->request->data['email']])->first();
			if ($userexist['is_talent_admin'] == 'N' && $talentexist) {
				$users = TableRegistry::get('Users');
				$user = $users->get($userexist['id']);
				$user->is_talent_admin = "Y";
				$users->save($user);

				$this->Flash->success(__('Talent Partner details submitted successfully. Please inform ' . $this->request->data['user_name'] . '.'));
				return $this->redirect(['action' => 'addsubadmin']);
			}

			//pr($userexist); die;
			if (!empty($userexist)) {
				$prop_data['user_id'] = $userexist['id'];
				$prop_data['status'] = $userexist['status'];
				$users = TableRegistry::get('Users');
				$user = $users->get($userexist['id']); // Return article with id = $id (primary_key of row which need to get updated)
				$user->is_talent_admin = "Y";
				$users->save($user);


				if ($userexist['altemail'] != "") {
					$prop_data['alternate_email'] = $userexist['altemail'];
				}
			}
			$prop_data['talentdadmin_id'] = $this->request->data['talent_admin'];
			$prop_data['email'] = $this->request->data['email'];
			$prop_data['user_name'] = $this->request->data['user_name'];
			$prop_data['country_id'] = $this->request->data['country_id'];
			$prop_data['state_id'] = $this->request->data['state_id'];
			$prop_data['city_id'] = $this->request->data['city_id'];
			$prop_data['commision'] = $this->request->data['commission'];
			$prop_data['enable_create_subadmin'] = $this->request->data['enable_create_subadmin'];
			$prop_data['referal_code'] = md5(uniqid(rand(), true));
			$skillcheck	= $this->request->data['skill'];
			$skillcount = explode(",", $this->request->data['skill']);


			$contenttalent_admin = $this->TalentAdmin->patchEntity($talent, $prop_data);
			$savedataTalent = $this->TalentAdmin->save($contenttalent_admin);
			if ($savedataTalent) {
				if ($id == "") {
					if (!empty($userexist)) {
						//$newappointMail = $this->appointmailsend($savedataTalent['user_name'],$savedataTalent['email'],$savedataTalent['created'],$this->request->data['commision']);

						$users = TableRegistry::get('TalentAdmin');
						$query = $users->query();
						$query->update()
							->set(['appointment' => 1])
							->where(['id' => $savedataTalent['id']])
							->execute();
					}
				} else {
					if ($this->request->data['commision'] != $talent['commision']) {
						//$newappointMail = $this->appointmailsend($talent['user_name'],$talent['email'],$talent['created'],$this->request->data['commision']);
						$users = TableRegistry::get('TalentAdmin');
						$query = $users->query();
						$query->update()
							->set(['appointment' => 1])
							->where(['id' => $savedataTalent['id']])
							->execute();
					}
				}
			}



			$last_ta_id = $savedataTalent->id;
			if ($skillcheck) {
				$prop_skills = array();
				$this->Talentadminskill->deleteAll(['Talent_adminskills.user_id' => $id]);
				for ($i = 0; $i < count($skillcount); $i++) {
					$contentadminskill = $this->Talentadminskill->newEntity();
					$prop_skills['talent_admin_id'] = $last_ta_id;
					$prop_skills['user_id'] = $last_user_id;
					$prop_skills['skill_id'] = $skillcount[$i];
					$contentadminskillsave = $this->Talentadminskill->patchEntity($contentadminskill, $prop_skills);
					$skilldata = $this->Talentadminskill->save($contentadminskillsave);
				}
			}
			$this->Flash->success(__('Talent Partner details submitted successfully. Please inform ' . $this->request->data['user_name'] . '.'));
			return $this->redirect(['action' => 'subadmins']);
			//	}

		}
	}

	public function getStates()
	{
		$this->loadModel('Country');
		$this->loadModel('State');
		$states = array();
		//pr($this->request->data); die;
		if (isset($this->request->data['id'])) {
			$states = $this->Country->State->find('list')->select(['id', 'name'])->where(['State.country_id' => $this->request->data['id']])->toarray();
			//pr($states); die;
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

	public function delete($id = null, $ref = null)
	{
		//	echo $ref; die;
		$this->loadModel('TalentAdmin');
		$this->loadModel('Users');
		$this->loadModel('Talentadminskill');
		$this->loadmodel('Templates');

		$talentadmin = $this->TalentAdmin->get($id);
		// pr($talentadmin); die;
		if (!empty($talentadmin['user_id'])) {
			$users = $this->Users->get($talentadmin['user_id']);
		}

		//pr($users); die;
		if ($ref == 0) {
			//echo "hello"; die;
			if ($this->TalentAdmin->delete($talentadmin)) {
				// Change User status
				if (isset($users)) {
					$user_info['is_talent_admin'] = 'N';
					$user_info['is_talent_admin_accept'] = 0;
					$contentadmin = $this->Users->patchEntity($users, $user_info);
					$savedata = $this->Users->save($contentadmin);

					// Delete Talent admin skills
					$this->Talentadminskill->deleteAll(['Talent_adminskills.user_id' => $id]);
				}
			}
		} else {
			if (isset($users)) {
				$user_info['is_talent_admin'] = 'N';
				$contentadmin = $this->Users->patchEntity($users, $user_info);
				$savedata = $this->Users->save($contentadmin);
			}
		}

		$profile = $this->Templates->find('all')->where(['Templates.id' => DELETETALENTADMIN])->first();
		//pr($profile); die;
		$subject = $profile['subject'];
		$from = $profile['from'];
		$fromname = $profile['fromname'];
		$to  = $talentadmin['email'];
		$formats = $profile['description'];
		$site_url = SITE_URL;
		$name = $talentadmin['user_name'];
		$userexist = $this->Users->find('all')->where(['Users.email' => $to])->count();
		//pr($userexist); die;
		if ($userexist == 1) {
			$visit_site_url = SITE_URL . "/login";
		} else {
			$visit_site_url = SITE_URL . "/signup";
		}
		//echo $site_url;
		$site_url = SITE_URL;
		$message1 = str_replace(array('{Name}', '{site_url}', '{visit_site_url}'), array($name, $site_url, $visit_site_url), $formats);
		$message = stripslashes($message1);
		$message = '
		<!DOCTYPE HTML>
		<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		</head>
		<body style="padding:0px; margin:0px;font-family:Arial,Helvetica,sans-serif; font-size:13px;">
			' . $message1 . '
		</body>
		</html>
		';

		//pr($message);
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		//$headers .= 'To: <'.$to.'>' . "\r\n";
		$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
		$emailcheck = mail($to, $subject, $message, $headers);

		$this->Flash->success(__($talentadmin['user_name'] . ' has been successfully deleted'), ['key' => 'td']);
		return $this->redirect(['action' => 'subadmins']);
		//die;
	}

	// All Transcations
	public function mytranscations()
	{
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Skillset');
		$this->loadModel('Skill');
		$this->loadModel('Talentadmintransc');
		$this->loadModel('TalentAdmin');
		$id = $this->request->session()->read('Auth.User.id');
		$where = " where talentadmintransc.talent_admin_id='" . $id . "'";
		$talentpartner = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $id])->first();
		$this->set(compact('talentpartner'));
		$this->request->session()->write('talent_admin_transcation', $where);
		$conn = ConnectionManager::get('default');
		if ($talentpartner) {
			$transcations = $this->Talentadmintransc->find('all')->contain(['Users' => ['Profile'], 'Transcation' => ['Subscription' => ['Profilepack'], 'Requirement']])->where(['Talentadmintransc.talent_admin_id' => $id])->order(['Talentadmintransc.id' => ASC])->toarray();
			// pr($transcations);exit;
			/*$talent_qry = " SELECT talentadmintransc.*, users.user_name as talent_name, users.email, GROUP_CONCAT(skill_type.name) as skill_name from talentadmintransc left join users on users.id=user_id left join transcations on transcations.id=transaction_id left join personal_profile on personal_profile.user_id=talentadmintransc.user_id LEFT JOIN skill on talentadmintransc.user_id=skill.user_id LEFT JOIN skill_type ON skill.skill_id=skill_type.id  ".$where." group by talentadmintransc.id";
		$talent = $conn->execute($talent_qry);
		$transcations = $talent ->fetchAll('assoc');*/
			//pr($transcations);  die;
			$this->set(compact('transcations'));
		} else {
			$this->Flash->error(__('You are not authorized to access that location.'));
			return $this->redirect($this->referer());
		}
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

		//$where = " where talentadmintransc.talent_admin_id='".$id."'";
		$cond = [];
		if (!empty($from_date)) {
			$cond['DATE(Talentadmintransc.created_date) >='] = date('Y-m-d', strtotime($from_date));
		}
		if (!empty($to_date)) {
			$cond['DATE(Talentadmintransc.created_date) <='] = date('Y-m-d', strtotime($to_date));
		}

		$this->request->session()->write('talent_admin_transcation', $cond);
		$transcations = $this->Talentadmintransc->find('all')->contain(['Users' => ['Profile'], 'Transcation' => ['Subscription' => ['Profilepack'], 'Requirement']])->where(['Talentadmintransc.talent_admin_id' => $id, $cond])->order(['Talentadmintransc.id' => ASC])->toarray();
		$this->set(compact('transcations'));
	}

	// export transcations
	// change on 27/04/2024
	// public function exporttalentadmin()
	// {
	// 	$this->autoRender = false;
	// 	$blank = "NA";
	// 	$conn = ConnectionManager::get('default');
	// 	$output = "";

	// 	$output .= '"Sr Number",';
	// 	$output .= '"Date",';
	// 	$output .= '"Name",';
	// 	$output .= '"Email",';
	// 	$output .= '"Skills",';
	// 	$output .= '"Transcation Carried out",';
	// 	$output .= '"Commission Earned",';
	// 	$output .= '"Payout Amount",';
	// 	$output .= "\n";
	// 	//pr($job); die;
	// 	$str = "";

	// 	//$where = " where users.is_talent_admin = 'Y'";
	// 	$where = $this->request->session()->read('talent_admin_transcation');
	// 	$conn = ConnectionManager::get('default');
	// 	$talent_qry = " SELECT talentadmintransc.*, users.user_name as talent_name, users.email, GROUP_CONCAT(skill_type.name) as skill_name from talentadmintransc left join users on users.id=user_id left join personal_profile on personal_profile.user_id=talentadmintransc.user_id LEFT JOIN skill on talentadmintransc.user_id=skill.user_id LEFT JOIN skill_type ON skill.skill_id=skill_type.id  " . $where . " group by talentadmintransc.id";

	// 	//echo $talent_qry; die;
	// 	$talent = $conn->execute($talent_qry);
	// 	$talents = $talent->fetchAll('assoc');
	// 	$cnt = 1;
	// 	foreach ($talents as $talent_data) {

	// 		$skills = str_replace(",", " ", $talent_data['skill_name']);
	// 		$output .= $cnt . ",";
	// 		$output .= $talent_data['created_date'] . ",";
	// 		$output .= $talent_data['talent_name'] . ",";
	// 		$output .= $talent_data['email'] . ",";
	// 		$output .= $skills . ",";
	// 		$output .= $talent_data['description'] . ",";
	// 		$output .= $talent_data['amount'] . ",";
	// 		$output .= $talent_data['payout_amount'] . ",";
	// 		//$output .=$blank.",";
	// 		//$output .=$blank.",";
	// 		$cnt++;
	// 		$output .= "\r\n";
	// 	}

	// 	// $filename = "Talent_admins_trans.csv";
	// 	// header('Content-type: application/csv');
	// 	$filename = "Talent_admins_trans.xlsx";
	// 	header('Content-type: application/xlsx');

	// 	header('Content-Disposition: attachment; filename=' . $filename);
	// 	echo $output;
	// 	die;
	// 	$this->redirect($this->referer());
	// }
	public function exporttalentadmin()
	{
		// Disable auto-rendering
		$this->autoRender = false;

		// Create a new instance of PHPExcel
		$objPHPExcel = new PHPExcel();

		// Set properties for the Excel file
		$objPHPExcel->getProperties()
			->setCreator("Your Name")
			->setLastModifiedBy("Your Name")
			->setTitle("Talent Admin Export")
			->setSubject("Talent Admin Export")
			->setDescription("Export of talent admin data in Excel format.")
			->setKeywords("talent admin export excel")
			->setCategory("Exported data");

		// Set column widths for better readability
		$columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
		foreach ($columns as $col) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}

		// Set the header row
		$headers = [
			'Sr Number',
			'Date',
			'Name',
			'Email',
			'Skills',
			'Transaction Carried Out',
			'Commission Earned',
			'Payout Amount'
		];
		$objPHPExcel->getActiveSheet()->fromArray($headers, null, 'A1');

		// Get database connection
		$conn = ConnectionManager::get('default');

		// Construct the SQL query
		$where = $this->request->session()->read('talent_admin_transcation');
		$talentQuery = "
        SELECT
            talentadmintransc.*,
            users.user_name AS talent_name,
            users.email,
            GROUP_CONCAT(skill_type.name SEPARATOR ' ') AS skill_name
        FROM
            talentadmintransc
            LEFT JOIN users ON users.id = user_id
            LEFT JOIN personal_profile ON personal_profile.user_id = talentadmintransc.user_id
            LEFT JOIN skill ON talentadmintransc.user_id = skill.user_id
            LEFT JOIN skill_type ON skill.skill_id = skill_type.id
        $where
        GROUP BY talentadmintransc.id
       ";

		// Execute the query and fetch the results
		$talentResult = $conn->execute($talentQuery);
		$talents = $talentResult->fetchAll('assoc');

		// Check if the query result is not empty
		if (!$talents) {
			throw new Exception('No data found in the database for export.');
		}

		// Initialize row counter starting from the second row
		$row = 2;
		$cnt = 1;

		// Iterate through the data and populate the Excel sheet
		foreach ($talents as $talentData) {
			// Prepare row data
			$rowData = [
				$cnt,
				$talentData['created_date'],
				$talentData['talent_name'],
				$talentData['email'],
				$talentData['skill_name'],
				$talentData['description'],
				$talentData['amount'],
				$talentData['payout_amount']
			];

			// Write the row data to the Excel sheet
			$objPHPExcel->getActiveSheet()->fromArray($rowData, null, 'A' . $row);

			// Increment row counter and Sr Number counter
			$row++;
			$cnt++;
		}

		// Set the active sheet index to the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Set the file headers for downloading the Excel file
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Talent_admins_trans.xlsx"');
		header('Cache-Control: max-age=0');

		// Create an Excel writer object
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		// Output the Excel file to the browser for downloading
		$objWriter->save('php://output');

		// End script execution
		exit();
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
	}

	public function bankinformationupdate()
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
		} else {
			$this->Flash->error(__('You are not authorized to access that location.'));
			return $this->redirect($this->referer());
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

	// change on 27/04/2024
	// public function exporttalentadminexcel()
	// {
	// 	$this->loadModel('Users');
	// 	$this->loadModel('Profile');
	// 	$this->loadModel('TalentAdmin');
	// 	$this->loadModel('Refers');
	// 	$userid = $this->request->session()->read('Auth.User.id');
	// 	$this->autoRender = false;
	// 	$blank = "NA";
	// 	$conn = ConnectionManager::get('default');
	// 	$output = "";

	// 	$output .= '"Sr Number",';
	// 	$output .= '"Name",';
	// 	$output .= '"Email",';
	// 	$output .= '"Telephone Number",';
	// 	$output .= '"Talent Admin From",';
	// 	$output .= '"Refered Profiles",';
	// 	$output .= '"Registered Profiles",';
	// 	$output .= '"Non Registered profiles",';
	// 	$output .= '"Talent partners created",';
	// 	$output .= '"Registered partners",';
	// 	$output .= '"Non Registered partners",';
	// 	$output .= '"Can create Talent partners",';
	// 	$output .= "\n";
	// 	//pr($job); die;
	// 	$str = "";

	// 	//$where = " where users.is_talent_admin = 'Y'";
	// 	$where = $this->request->session()->read('Config.talent_admin_filter');
	// 	//pr($where); die;
	// 	if (isset($where)) {
	// 		$contentadmin = $this->TalentAdmin->find('all')->where([$where, 'TalentAdmin.talentdadmin_id' => $userid])->toarray();
	// 	} else {
	// 		$contentadmin = $this->TalentAdmin->find('all')->where(['TalentAdmin.talentdadmin_id' => $userid])->toarray();
	// 	}
	// 	//pr($contentadmin); die;
	// 	$cnt = 1;
	// 	foreach ($contentadmin as $talent_data) { //pr($talent_data);
	// 		$userdata = $this->Users->find('all')->contain(['Profile', 'Refers'])->where(['Users.id' => $talent_data['user_id']])->first();
	// 		$registeredprofile = $this->Refers->find('all')->where(['Refers.status' => 'Y', 'Refers.ref_by' => $talent_data['user_id']])->first();
	// 		$nonregisteredprofile = $this->Refers->find('all')->where(['Refers.status' => 'N', 'Refers.ref_by' => $talent_data['user_id']])->first();
	// 		$registeredpartner = $this->TalentAdmin->find('all')->where(['TalentAdmin.talentdadmin_id' => $talent_data['user_id'], 'TalentAdmin.user_id !=' => ""])->toarray();
	// 		$nonregisteredpartner = $this->TalentAdmin->find('all')->where(['TalentAdmin.talentdadmin_id' => $talent_data['user_id'], 'TalentAdmin.user_id' => ""])->toarray();
	// 		$output .= $cnt . ",";
	// 		$output .= ucfirst($talent_data->user_name) . ",";
	// 		$output .= $talent_data->email . ",";
	// 		$output .= str_replace(",", " ", $userdata['profile']['phone']) . str_replace(",", " ", $userdata['profile']['altnumber']) . ",";
	// 		$output .= date("M-d-Y", strtotime($talent_data['created_date'])) . ",";
	// 		$output .= count($userdata['refers']) . ",";
	// 		$output .= count($registeredprofile['refers']) . ",";
	// 		$output .= count($nonregisteredprofile['refers']) . ",";
	// 		// if(isset($userdata)){
	// 		// 	$output.=date("d M Y h:i:s",strtotime($userdata['created'])).",";
	// 		// }else{
	// 		// 	$output.="Not Logged in Yet ,";
	// 		// }

	// 		$output .= count($registeredpartner) + count($nonregisteredpartner) . ",";
	// 		$output .= count($registeredpartner) . ",";
	// 		$output .= count($nonregisteredpartner) . ",";
	// 		if ($talent_data['enable_create_subadmin'] == "Y") {
	// 			$output .= "Yes ,";
	// 		} else {
	// 			$output .= "No ,";
	// 		}
	// 		//$output .=$blank.",";
	// 		$cnt++;
	// 		$output .= "\r\n";
	// 	}

	// 	// $filename = "Manage Talent Partners Details.csv";
	// 	// header('Content-type: application/csv');
	// 	$filename = "Manage Talent Partners Details.xlsx";
	// 	header('Content-type: application/xlsx');
	// 	header('Content-Disposition: attachment; filename=' . $filename);
	// 	echo $output;
	// 	die;
	// 	$this->redirect($this->referer());
	// }
	public function exporttalentadminexcel()
	{
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Refers');
		// Disable auto-rendering
		$this->autoRender = false;

		// Create a new instance of PHPExcel
		$objPHPExcel = new PHPExcel();

		// Set properties for the Excel file
		$objPHPExcel->getProperties()
			->setCreator("Your Name")
			->setLastModifiedBy("Your Name")
			->setTitle("Talent Admin Export")
			->setSubject("Talent Admin Export")
			->setDescription("Export of talent admin data in Excel format.")
			->setKeywords("talent admin export excel")
			->setCategory("Exported data");

		// Set column widths for better readability
		$columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
		foreach ($columns as $col) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}

		// Define the header row
		$headers = [
			'Sr Number',
			'Name',
			'Email',
			'Telephone Number',
			'Talent Admin From',
			'Referred Profiles',
			'Registered Profiles',
			'Non Registered Profiles',
			'Talent Partners Created',
			'Registered Partners',
			'Non Registered Partners',
			'Can Create Talent Partners'
		];
		$objPHPExcel->getActiveSheet()->fromArray($headers, null, 'A1');

		// Fetch data from database
		$userid = $this->request->session()->read('Auth.User.id');
		$where = $this->request->session()->read('Config.talent_admin_filter');

		if (isset($where)) {
			$contentadmin = $this->TalentAdmin->find('all')->where([$where, 'TalentAdmin.talentdadmin_id' => $userid])->toArray();
		} else {
			$contentadmin = $this->TalentAdmin->find('all')->where(['TalentAdmin.talentdadmin_id' => $userid])->toArray();
		}

		// Initialize row counter and Sr Number counter
		$row = 2;
		$cnt = 1;

		// Iterate through the data and populate the Excel sheet
		foreach ($contentadmin as $talentData) {
			$userData = $this->Users->find('all')->contain(['Profile', 'Refers'])->where(['Users.id' => $talentData['user_id']])->first();

			$registeredProfile = $this->Refers->find('all')->where(['Refers.status' => 'Y', 'Refers.ref_by' => $talentData['user_id']])->count();
			$nonRegisteredProfile = $this->Refers->find('all')->where(['Refers.status' => 'N', 'Refers.ref_by' => $talentData['user_id']])->count();

			$registeredPartner = $this->TalentAdmin->find('all')->where(['TalentAdmin.talentdadmin_id' => $talentData['user_id'], 'TalentAdmin.user_id !=' => ''])->count();
			$nonRegisteredPartner = $this->TalentAdmin->find('all')->where(['TalentAdmin.talentdadmin_id' => $talentData['user_id'], 'TalentAdmin.user_id' => ''])->count();

			// Prepare the row data
			$rowData = [
				$cnt,
				ucfirst($talentData->user_name),
				$talentData->email,
				str_replace(",", " ", $userData['profile']['phone']) . " " . str_replace(",", " ", $userData['profile']['altnumber']),
				date("M-d-Y", strtotime($talentData['created_date'])),
				count($userData['refers']),
				$registeredProfile,
				$nonRegisteredProfile,
				count($registeredPartner) + count($nonRegisteredPartner),
				count($registeredPartner),
				count($nonRegisteredPartner),
				$talentData['enable_create_subadmin'] == 'Y' ? 'Yes' : 'No',
			];

			// Write the row data to the Excel sheet
			$objPHPExcel->getActiveSheet()->fromArray($rowData, null, 'A' . $row);

			// Increment row counter and Sr Number counter
			$row++;
			$cnt++;
		}

		// Set the active sheet index to the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Set the file headers for downloading the Excel file
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Manage_Talent_Partners_Details.xlsx"');
		header('Cache-Control: max-age=0');

		// Create an Excel writer object
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		// Output the Excel file to the browser for downloading
		$objWriter->save('php://output');

		// End script execution
		exit();
	}




	public function uploadexcelsample()
	{
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Refers');
		// Disable auto-rendering
		$this->autoRender = false;

		// Create a new instance of PHPExcel
		$objPHPExcel = new PHPExcel();

		// Set properties for the Excel file
		$objPHPExcel->getProperties()
			->setCreator("Your Name")
			->setLastModifiedBy("Your Name")
			->setTitle("Talent Admin Export")
			->setSubject("Talent Admin Export")
			->setDescription("Export of talent admin data in Excel format.")
			->setKeywords("talent admin export excel")
			->setCategory("Exported data");

		// Set column widths for better readability
		$columns = ['A', 'B', 'C', 'D'];
		foreach ($columns as $col) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}

		// Define the header row
		$headers = [
			'Sr Number',
			'Name',
			'Email',
			'Phone No'
		];
		$objPHPExcel->getActiveSheet()->fromArray($headers, null, 'A1');

		// Fetch data from database
		// $userid = $this->request->session()->read('Auth.User.id');
		// $where = $this->request->session()->read('Config.talent_admin_filter');

		// if (isset($where)) {
		// 	$contentadmin = $this->TalentAdmin->find('all')->where([$where, 'TalentAdmin.talentdadmin_id' => $userid])->toArray();
		// } else {
		// 	$contentadmin = $this->TalentAdmin->find('all')->where(['TalentAdmin.talentdadmin_id' => $userid])->toArray();
		// }

		// Initialize row counter and Sr Number counter
		$row = 2;
		$cnt = 1;

		// Iterate through the data and populate the Excel sheet
		// foreach ($contentadmin as $talentData) {
		// 	$userData = $this->Users->find('all')->contain(['Profile', 'Refers'])->where(['Users.id' => $talentData['user_id']])->first();

		// 	$registeredProfile = $this->Refers->find('all')->where(['Refers.status' => 'Y', 'Refers.ref_by' => $talentData['user_id']])->count();
		// 	$nonRegisteredProfile = $this->Refers->find('all')->where(['Refers.status' => 'N', 'Refers.ref_by' => $talentData['user_id']])->count();

		// 	$registeredPartner = $this->TalentAdmin->find('all')->where(['TalentAdmin.talentdadmin_id' => $talentData['user_id'], 'TalentAdmin.user_id !=' => ''])->count();
		// 	$nonRegisteredPartner = $this->TalentAdmin->find('all')->where(['TalentAdmin.talentdadmin_id' => $talentData['user_id'], 'TalentAdmin.user_id' => ''])->count();

		// 	// Prepare the row data
		// 	$rowData = [
		// 		$cnt,
		// 		ucfirst($talentData->user_name),
		// 		$talentData->email,
		// 		str_replace(",", " ", $userData['profile']['phone']) . " " . str_replace(",", " ", $userData['profile']['altnumber']),
		// 		date("M-d-Y", strtotime($talentData['created_date'])),
		// 		count($userData['refers']),
		// 		$registeredProfile,
		// 		$nonRegisteredProfile,
		// 		count($registeredPartner) + count($nonRegisteredPartner),
		// 		count($registeredPartner),
		// 		count($nonRegisteredPartner),
		// 		$talentData['enable_create_subadmin'] == 'Y' ? 'Yes' : 'No',
		// 	];

		// 	// Write the row data to the Excel sheet
		// 	$objPHPExcel->getActiveSheet()->fromArray($rowData, null, 'A' . $row);

		// 	// Increment row counter and Sr Number counter
		// 	$row++;
		// 	$cnt++;
		// }

		// Set the active sheet index to the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Set the file headers for downloading the Excel file
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Upload_profile_sample_Details.xlsx"');
		header('Cache-Control: max-age=0');

		// Create an Excel writer object
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		// Output the Excel file to the browser for downloading
		$objWriter->save('php://output');

		// End script execution
		exit();
	}


	public function appointmailsend($name = null, $email = null, $creatdate = null, $commision = null)
	{
		$this->loadmodel('Templates');
		$profile = $this->Templates->find('all')->where(['Templates.id' => APPOINTMENTPARTNER])->first();
		$created = date('M d, Y', strtotime($creatdate));
		$subject = $profile['subject'];
		$from = $profile['from'];
		$fromname = $profile['fromname'];
		$to  = $email;
		$name  = $name;
		$formats = $profile['description'];
		$userexist = $this->Users->find('all')->where(['Users.email' => $to])->count();
		//pr($userexist); die;
		if ($userexist == 1) {
			$visit_site_url = SITE_URL . "/login";
		} else {
			$visit_site_url = SITE_URL . "/signup";
		}
		$site_url = SITE_URL;

		$message1 = str_replace(array('{Name}', '{site_url}', '{commision}', '{created}', '{subject}', '{visit_site_url}'), array($name, $site_url, $commision, $creatdate, $subject, $visit_site_url), $formats);
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

		//pr($message); 
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		//$headers .= 'To: <'.$to.'>' . "\r\n";
		$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
		$emailcheck = mail($to, $subject, $message, $headers);
	}
}
