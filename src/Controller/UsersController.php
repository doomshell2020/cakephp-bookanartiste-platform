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
use League\OAuth2\Client\Provider\LinkedIn;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use PHPMailer\PHPMailer\PHPMailer;
use tidy;
// require 'vendor/autoload.php';


include(ROOT . DS . "vendor" . DS  . "PHPMailer/" . DS . "PHPMailerAutoload.php");
//  require_once 'path/to/PHPMailer/PHPMailerAutoload.php';

// RUpam 


class UsersController extends AppController
{

	public function initialize()
	{
		parent::initialize();
		// $this->loadComponent('Cookie');
		$this->loadComponent('Cookie', [
			'expires' => '+1 month',
			'httpOnly' => true
		]);
		$this->loadModel('Users');
		$this->loadComponent('Email');
		$this->Auth->allow(['_setPassword', 'signup', 'findUsername', 'login', 'logout', 'verify', 'getphonecode', 'forgotpassword', 'forgetCpass', 'sociallogin', 'appointmailsend']);
	}

	public function currentlocation()
	{
		$this->loadModel('Profile');
		$id = $this->request->session()->read('Auth.User.id');
		$profile = $this->Profile->find('all')->where(['user_id' => $id])->first();
		$this->set('profile', $profile);
		if ($this->request->is(['post', 'put'])) {
			$Pack = $this->Profile->get($profile['id']);
			$Pack->current_location = $this->request->data['current_location'];
			$Pack->current_lat = $this->request->data['current_lat'];
			$Pack->current_long = $this->request->data['current_long'];
			if ($this->Profile->save($Pack)) {
				$this->Flash->success(__('Update Current Location Successcfully'));
				return $this->redirect(['action' => 'currentlocation']);
			}
		}
	}
	public  function _setPassword($password)
	{
		return (new DefaultPasswordHasher)->hash($password);
	}
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow();
	}

	public function changepassword()
	{
		$this->loadModel('Users');
		$id = $this->request->session()->read('Auth.User.id');
		if ($this->request->is(['post', 'put'])) {
			$this->request->data['email'] = $this->request->data['email'];
			$user = $this->Auth->identify($this->request->data);
			if ($user) {

				$Pack = $this->Users->get($id);
				$pass = $this->_setPassword($this->request->data['newpassword']);
				$chpass['password'] = $pass;
				$chpass['cpassword'] = $this->request->data['confirmpassword'];
				$changepass = $this->Users->patchEntity($Pack, $chpass);
				if ($this->Users->save($changepass)) {
					$this->loadmodel('Profile');
					$guardianprofile = $this->Profile->find('all')->where(['user_id' => $id])->first();
					$guardianname = $guardianprofile['guadian_name'];
					$usermail = $Pack['email'];
					$user = $Pack['user_name'];
					$userpass = $chpass['cpassword'];
					$guardianemail = $guardianprofile['guardian_email'];
					$usergender = $guardianprofile['gender'];
					if ($usergender == 'm') {
						$usergendername = 'Mr';
					} else if ($usergender == 'f') {
						$usergendername = 'Ms';
					}
					if ($usergender == 'o') {
						$usergendername = 'Mr/Ms';
					}
					if ($usergender == 'm') {
						$usergenderhis = 'his';
					} else if ($usergender == 'f') {
						$usergenderhis = 'her';
					}
					if ($usergender == 'o') {
						$usergenderhis = 'his/her';
					}
					$birthdate = date("Y-m-d", strtotime($guardianprofile['dob']));
					$from = new \DateTime($birthdate);
					$to   = new \DateTime('today');
					$age_diff = $from->diff($to)->y;
					if ($age_diff > 1 && $age_diff < 18) {

						$this->loadmodel('Templates');
						$profile = $this->Templates->find('all')->where(['Templates.id' => GUARDIANMAILCHANGEPASS])->first();
						$subject = $profile['subject'];
						$from = $profile['from'];
						$fromname = $profile['fromname'];
						$to  = $guardianemail;
						$formats = $profile['description'];
						$site_url = SITE_URL;
						$message1 = str_replace(
							array('{Name}', '{user}', '{usermail}', '{userpass}', '{site_url}', '{Useractivation}'),
							array($guardianname, $user, $usermail, $userpass, $site_url, $useractivation),
							$formats
						);
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
						</html>';
						$headers = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
						$emailcheck = mail($to, $subject, $message, $headers);
					}
					$this->Auth->logout();
					$this->Flash->success(__('Password Changed Successfully'));
					return $this->redirect(['action' => 'login']);
				}
			} else {
				$this->Flash->error(__('Current Passowrd Is Wrong!!'));
				return $this->redirect(['action' => 'changepassword']);
			}
		}
	}

	public function getphonecode()
	{
		$this->request->data['id'];
		$this->loadModel('Country');
		$phonecode = array();
		if (isset($this->request->data['id'])) {
			$phonecode = $this->Country->find('list', ['keyField' => 'id', 'valueField' => 'cntcode'])->where(['Country.id' => $this->request->data['id']])->toarray();
		}
		header('Content-Type: application/json');
		echo json_encode($phonecode);
		exit();
	}

	public function keepAlive()
	{
		$this->autoRender = false; // Disable view rendering for AJAX requests
		// Check if the user session is active
		$user = $this->request->session()->read('Auth.User');
		if ($user) {
			// Return a success response if the user is logged in
			return $this->response
				->withType('application/json')
				->withStringBody(json_encode(['status' => 'success']));
		} else {
			// Return an error response if the session has expired
			return $this->response
				->withType('application/json')
				->withStringBody(json_encode(['status' => 'error', 'message' => 'Session expired']));
		}
	}


	// Rupam 4-2-2025 :
	public function login($email = null, $pass = null)
	{
		$this->loadModel('TalentAdmin');
		$this->loadModel('Settings');
		$this->loadModel('Packfeature');
		$this->loadModel('Report');
		$this->loadModel('Loginusercheck');
		$this->loadModel('Subscription');
		$this->loadModel('RecuriterPack');
		$this->loadModel('Profilepack');
		$session = $this->request->session();
		$data_log['user_id'] = $this->request->session()->read('Auth.User.id');
		$userLoginInfo = $this->request->session()->read('Auth.User');
		$current_year = date('Y');


		if ($userLoginInfo['id']) {
			return $this->redirect(['controller' => 'profile', 'action' => 'viewprofile']);
		}


		if ($this->request->is('post')) {
			// pr($this->request->data);exit;
			$userIP = $this->request->clientIp();
			$reqData = $this->request->data;
			$currentIp = $_SERVER['REMOTE_ADDR'];

			$check_email = $this->Users->find('all')->where(['Users.email' => $reqData['email']])->first();

			if (empty($check_email)) {
				$this->Flash->error(__('Invalid Email Address'));
				return $this->redirect(['controller' => 'users', 'action' => 'login']);
			}

			if ($check_email['user_delete'] === 'Y') {
				$this->Flash->error(__('Your account has been deleted'));
				return $this->redirect(['controller' => 'users', 'action' => 'login']);
			}

			$user = $this->Auth->identify();

			if (empty($user)) {
				$this->Flash->error(__('Invalid Password'));
				return $this->redirect(['controller' => 'users', 'action' => 'login']);
			}

			// For admin
			if ($user['role_id'] == 1) {
				$this->Auth->setUser($user);
				return $this->redirect(['controller' => 'admin/dashboards', 'action' => 'index']);
			}

			if ($user['status'] != "Y") {
				$this->Flash->error(__('Your account has been deactivated by admin. Please contact to admin for activation.'));
				return $this->redirect(['controller' => 'users', 'action' => 'login']);
			}

			$user_pack = $this->Packfeature->find()
				->where([
					'user_id' => $user['id'],
					'OR' => [
						['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
						['package_status' => 'default']
					]
				])
				->order(['id' => 'DESC'])
				->first();


			if (!empty($reqData['remember_me'])) {
				$this->Cookie->write('remember_me', true);
				$this->Cookie->write('email', $reqData['email']);
				$this->Cookie->write('password', $reqData['password']);
			} else {
				$this->Cookie->delete('remember_me');
				$this->Cookie->delete('email');
				$this->Cookie->delete('password');
			}


			$this->bdnotification($user['id']);
			$this->isUserBlocked($user_pack, $user);

			if (empty($user_pack)) {
				$this->assigndefaultpackage($user['id']);
			}

			if (!$this->canLogin($user_pack, $user)) {
				return $this->redirect($this->referer());
			}

			$user_id = $user['id'];
			$session = $this->request->session();
			// End Non Talent data
			if (in_array($user['role_id'], [NONTALANT_ROLEID, TALANT_ROLEID])) {

				if ($user['is_talent_admin_accept'] == 1 && $user['is_talent_admin'] == 'Y' && $this->talentadminterms($user_id)) {
					$userEntity = $this->Users->get($user_id);
					$userEntity = $this->Users->patchEntity($userEntity, ['is_talent_admin_accept' => 2]);
					$this->Users->save($userEntity);
				}

				if (strtotime($user['blocked_expiry']) > time()) {
					$blockedDays = round((strtotime($user['blocked_expiry']) - time()) / (60 * 60 * 24));
					$this->Flash->error(__('Your Profile is Blocked for ' . $blockedDays . ' days'));
					return $this->redirect(['controller' => 'users', 'action' => 'login']);
				}

				if ($user['is_talent_admin_accept'] == 1 && $user['is_talent_admin'] == 'Y') {

					$talentadminterms = $this->talentadminterms($user['id']);
					if ($talentadminterms == 1) {
						$userss = $this->Users->get($user['id']);
						$user_dataa['is_talent_admin_accept'] = 2;
						$usersa = $this->Users->patchEntity($userss, $user_dataa);
						$updateuser = $this->Users->save($usersa);
					}
				}

				// Load settings
				$this->loadModel('Settings');
				$settings = $this->Settings->find()->order(['id' => 'DESC'])->first();
				$session->write('settings', $settings);

				// Update last login time
				$userEntity = $this->Users->get($user['id']);
				$userEntity = $this->Users->patchEntity($userEntity, ['last_login' => time()]);
				$this->Users->save($userEntity);
				$this->Auth->setUser($user);

				// Login check data insert
				$this->loadModel('Loginusercheck');
				$loginCheck = $this->Loginusercheck->find()->where(['user_id' => $user['id'], 'ip' => $currentIp])->first() ?? $this->Loginusercheck->newEntity();
				$sessionToken = bin2hex(random_bytes(32)); // Generate a unique token
				$userAgent = $_SERVER['HTTP_USER_AGENT'];
				$session->write('session_token', $sessionToken);
				$session->write('login_user_ip', $currentIp);
				$loginCheck = $this->Loginusercheck->patchEntity($loginCheck, [
					'session_id' => session_id(),
					'user_id' => $user['id'],
					'user_agent' => $userAgent,
					'session_token' => $sessionToken,
					'ip' => $currentIp
				]);
				$this->Loginusercheck->save($loginCheck);

				// Handle redirection
				$redirectUrl = $reqData['action'] ? '/' . $reqData['action'] : SITE_URL . '/viewprofile';
				if ($user['is_talent_admin'] == 'Y') {
					$session->write('talentadmin', $this->TalentAdmin->find()->where(['user_id' => $user['id']])->first());
				}
				return $this->redirect($redirectUrl == '/' ? ['controller' => 'profile', 'action' => 'viewprofile'] : $redirectUrl);
			}
		}

		$remember_me = $this->Cookie->read('remember_me');
		$email = $this->Cookie->read('email');
		$password = $this->Cookie->read('password');
		$this->set(compact('email', 'password', 'remember_me'));
	}

	private function canLogin($user_pack, $user)
	{
		$userId = $user['id'];
		// Get the number of current login attempts
		$loginAttempts = $this->Loginusercheck->find()
			->where(['user_id' => $userId])
			->count();

		/** === 1. Allow Login if No Previous Logins or Same IP === */
		if ($loginAttempts == 0) {
			return true;
		}

		/** === 2. Restrict Non-Talent Users (role_id = 3) from Multiple Logins === */
		if ($user['role_id'] == 3 && $loginAttempts > 0) {
			$session = $this->request->session();
			$session->write('login_fail_user_id', $userId);

			$this->Flash->error(__('You cannot log in on multiple devices. Please log out from another device before attempting to log in again.'), ['key' => 'login_fail_non_talent']);

			return false;
		}

		/** === 3. Restrict Based on Recruiter Package Settings === */
		if ($user_pack['multipal_email_login'] == 'N') {
			// $this->Flash->error(__('Purchase a recruiter package to use multiple logins.'));
			$session = $this->request->session();
			$session->write('login_fail_user_id', $userId);
			$this->Flash->error(__('You cannot log in on multiple devices. Please log out from another device before attempting to log in again.'), ['key' => 'login_fail_non_talent']);
			return false;
		}

		/** === 4. Check if User Exceeds Allowed Login Count === */
		$userCountLogged = $loginAttempts + 1;

		if ($userCountLogged > $user_pack['number_of_email']) {
			$session = $this->request->session();
			$session->write('login_fail_user_id', $userId);

			$this->Flash->error(__('You cannot log in on multiple devices. Please log out from another device before attempting to log in again.'), ['key' => 'login_fail_non_talent']);

			return false;
		}

		return true;
	}

	// private function canLogin($user_pack, $user)
		// {
		// 	$userId = $user['id'];
		// 	$currentIp = $_SERVER['REMOTE_ADDR'];
		// 	$sessionToken = bin2hex(random_bytes(32)); // Generate a unique token
		// 	$userAgent = $_SERVER['HTTP_USER_AGENT'];

		// 	// Get login attempts
		// 	$loginAttempts = $this->Loginusercheck->find()
		// 		->where(['user_id' => $userId])
		// 		->count();

		// 	$lastLogin = $this->Loginusercheck->find()
		// 		->where(['user_id' => $userId, 'ip' => $currentIp])
		// 		->first();

		// 	// If no login attempts or same IP, allow login
		// 	if ($loginAttempts == 0 || $lastLogin['id']) {
		// 		return true;
		// 	}

		// 	// Restrict non-talent users from multiple logins
		// 	if ($user['role_id'] == 3 && $loginAttempts > 0) {
		// 		$session = $this->request->session();
		// 		$session->write('login_fail_user_id', $userId);
		// 		$this->Flash->error(__('You cannot log in on multiple devices. Please log out from another device before attempting to log in again.'), ['key' => 'login_fail_non_talent']);
		// 		return false;
		// 		return $this->redirect($this->referer());
		// 	}

		// 	// Calculate the allowed login count
		// 	$userCountLogged = $loginAttempts + 1;
		// 	// pr($userCountLogged);
		// 	// pr($user_pack['number_of_email']);
		// 	// pr($user_pack['multipal_email_login']);exit;
		// 	// Check multiple login restrictions
		// 	if ($user_pack['multipal_email_login'] == 'N') {
		// 		$this->Flash->error(__('Purchase a recruiter package to use multiple logins.'));
		// 		return false;
		// 		return $this->redirect(['controller' => 'users', 'action' => 'login']);
		// 	} elseif ($userCountLogged > $user_pack['number_of_email']) {
		// 		$session = $this->request->session();
		// 		$session->write('login_fail_user_id', $userId);
		// 		$this->Flash->error(__('You cannot log in on multiple devices. Please log out from another device before attempting to log in again.'), ['key' => 'login_fail_non_talent']);
		// 		return false;
		// 		return $this->redirect($this->referer());
		// 	}
		// 	return true;
	// }

	private function isUserBlocked($user_pack, $user)
	{
		$blockLimit = $user_pack['block_after_report'];
		$unblockDays = $user_pack['unblock_within'];

		// Fetch pending reports for the user
		$pendingReportsQuery = $this->Report->find()
			->where(['profile_id' => $user_pack['user_id'], 'action_taken' => 'N'])
			->order(['id' => 'desc']);

		$check_report_count = $pendingReportsQuery->count();
		$latestReport = $pendingReportsQuery->first();


		if ($check_report_count >= $blockLimit && $latestReport) {
			$datetime1 = date('Y-m-d');
			$datetime2 = date("Y-m-d", strtotime($latestReport['created']));

			$dateTimeObject1 = date_create($datetime1);
			$dateTimeObject2 = date_create($datetime2);
			$interval = date_diff($dateTimeObject1, $dateTimeObject2);
			$min = $interval->days * 24 * 60;
			$day1 = $interval->days;
			$min += $interval->h * 60;
			$min += $interval->i;
			$datetime11 = date('Y-m-d');
			$datetime22 = Date('Y-m-d', strtotime('-' . $unblockDays . ' days'));
			$dateTimeObject11 = date_create($datetime11);
			$dateTimeObject22 = date_create($datetime22);
			$interval1 = date_diff($dateTimeObject11, $dateTimeObject22);
			$min1 = $interval1->days * 24 * 60;
			$day2 = $interval1->days;
			$min1 += $interval1->h * 60;
			$min1 += $interval1->i;
			$hours = ($min1 - $min) / 60;
			if (($day2 - $day1) <= 0) {
				$reporttable = TableRegistry::get("Report");
				$query = $reporttable->query();
				$result = $query->update()->set(['action_taken' => 'Y'])->where(['Report.profile_id' => $user_pack['user_id']])->execute();
			}
		}

		// Re-check report count after possible update
		$check_report_count = $this->Report->find()
			->where(['profile_id' => $user_pack['user_id'], 'action_taken' => 'N'])
			->count();
		if ($check_report_count >= $blockLimit) {
			$session = $this->request->session();
			$session->write('user_data', $user);
			return $this->redirect(['controller' => 'Static', 'action' => 'info']);
		}
	}


	// function used for duplicate users login:
	public function login_backup($email = null, $pass = null)
	{
		$this->loadModel('TalentAdmin');
		$this->loadModel('Settings');
		$this->loadModel('Packfeature');
		$this->loadModel('Report');

		if ($this->request->is('post')) {
			// pr($this->request->data);exit;
			$userIP = $this->request->clientIp();
			$reqData = $this->request->data;

			$check_email = $this->Users->find('all')->where(['Users.email' => $this->request->data['email']])->first();
			if (empty($check_email)) {
				$this->Flash->error(__('Invalid Email Address'));
				return $this->redirect(['controller' => 'users', 'action' => 'login']);
			}
			// check user verify email or not if not then give message first verify your email you get verifycantion email opn your email
			// if ($check_email['isvarify'] == 'N') {
			// 	$this->Flash->error(__('Please verify your email first'));
			// 	return $this->redirect(['controller' => 'users', 'action' => 'login']);
			// }
			if ($check_email['user_delete'] == 'Y') {
				$this->Flash->error(__('Your account has been deleted'));
				// $this->Flash->error(__('Your'));
				return $this->redirect(['controller' => 'users', 'action' => 'login']);
			}

			$user = $this->Auth->identify();

			if (empty($user)) {
				$this->Flash->error(__('Invalid Password'));
				return $this->redirect(['controller' => 'users', 'action' => 'login']);
			}

			// For admin
			if ($user['role_id'] == 1) {
				$this->Auth->setUser($user);
				$this->set('user', $user['user_name']);
				return $this->redirect(['controller' => 'admin/dashboards', 'action' => 'index']);
			}

			if (!empty($reqData['remember_me'])) {
				$this->Cookie->write('remember_me', true);
				$this->Cookie->write('email', $reqData['email']);
				$this->Cookie->write('password', $reqData['password']);
			} else {
				$this->Cookie->delete('remember_me');
				$this->Cookie->delete('email');
				$this->Cookie->delete('password');
			}

			$check_report_count = $this->Report->find('all')->where(['Report.profile_id' => $user['id'], 'action_taken' => 'N'])->count();

			$check_report = $this->Report->find('all')->where(['Report.profile_id' => $user['id'], 'action_taken' => 'N'])->order(['Report.id' => 'desc'])->first();

			$settingdetails = $this->Settings->find('all')->first();

			if ($check_report_count >= $settingdetails['block_after_report']) {
				$datetime1 = date('Y-m-d');
				$datetime2 = date("Y-m-d", strtotime($check_report['created']));

				$dateTimeObject1 = date_create($datetime1);
				$dateTimeObject2 = date_create($datetime2);
				$interval = date_diff($dateTimeObject1, $dateTimeObject2);
				$min = $interval->days * 24 * 60;
				$day1 = $interval->days;
				$min += $interval->h * 60;
				$min += $interval->i;
				$datetime11 = date('Y-m-d');
				$datetime22 = Date('Y-m-d', strtotime('-' . $settingdetails['unblock_within'] . ' days'));
				$dateTimeObject11 = date_create($datetime11);
				$dateTimeObject22 = date_create($datetime22);
				$interval1 = date_diff($dateTimeObject11, $dateTimeObject22);
				$min1 = $interval1->days * 24 * 60;
				$day2 = $interval1->days;
				$min1 += $interval1->h * 60;
				$min1 += $interval1->i;
				$hours = ($min1 - $min) / 60;
				if (($day2 - $day1) <= 0) {
					$reporttable = TableRegistry::get("Report");
					$query = $reporttable->query();
					$result = $query->update()->set(['action_taken' => 'Y'])->where(['Report.profile_id' => $user['id']])->execute();
				}
			}

			$check_report_count = $this->Report->find('all')->where(['Report.profile_id' => $user['id'], 'action_taken' => 'N'])->count();

			if ($check_report_count >= $settingdetails['block_after_report']) {
				$session = $this->request->session();
				$session->write('user_data', $user);
				return $this->redirect(['controller' => 'Static', 'action' => 'info']);
			}

			$registed_year = date('Y', strtotime($user['created']));
			$current_year = date("Y");

			$user_pack = $this->Packfeature->find()
				->where([
					'user_id' => $user['id'],
					'OR' => [
						['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
						['package_status' => 'default']
					]
				])
				->order(['id' => 'DESC'])
				->first();

			if ($current_year > $registed_year) {
				$pcakgeinformation = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();
				// $user_pack = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'ASC'])->first();

				$feature_info['non_telent_number_of_job_post'] = $pcakgeinformation['non_telent_number_of_job_post'];
				$packfeatures = $this->Packfeature->patchEntity($user_pack, $feature_info);
				$this->Packfeature->save($packfeatures);
			}

			$talentprofile = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $user['id']])->first();
			if ($talentprofile['appointment'] == 1) {
				$newappointMail = $this->appointmailsend($user['id']);
			}

			$this->bdnotification($user['id']);

			// $talent_admin_pack = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'ASC'])->first();
			if (empty($user_pack)) {
				$this->assigndefaultpackage($user['id']);
			}

			$this->loadModel('Loginusercheck');
			$this->loadModel('Subscription');
			$this->loadModel('RecuriterPack');
			$user_id = $user['id'];
			$subscription = $this->Subscription->find('all')->select('package_id')->where(['user_id' => $user_id, 'package_type' => 'RC', 'status' => 'Y'])->order(['id' => 'DESC'])->first();
			// pr($user);exit;
			$recurte = $this->RecuriterPack->find('all')->select(['number_of_email', 'multipal_email_login'])->where(['id' => $subscription['package_id']])->first();

			$usersff = $this->Loginusercheck->find('all')->where(['user_id' => $user_id])->count();
			$usersffss = $this->Loginusercheck->find('all')->where(['user_id' => $user_id])->order(['Loginusercheck.id' => 'DESC'])->first();
			// pr($usersff);
			// pr($user);exit;

			if ($usersff == 0 || $usersffss['ip'] == $_SERVER['REMOTE_ADDR']) {
			} else {
				if ($user['role_id'] == 3 && $usersff > 0) { // non-talent user cannot log in multiple times
					// pr($user['role_id']);exit;
					$session = $this->request->session();
					// pr('sdfs');exit;
					$session->write('login_fail_user_id', $user_id);
					$this->Flash->error(__('You cannot log in on multiple devices. Please log out from another device before attempting to log in again.'), ['key' => 'login_fail_non_talent']);
					return $this->redirect($this->referer());
				}
				$usercountlogeed = $usersff + 1;
				if ($recurte['multipal_email_login'] == 'N') {
					$this->Flash->error(__('purchase recruiter package using multiple login'));
					return $this->redirect(['controller' => 'users', 'action' => 'login']);
				} elseif ($usercountlogeed > $recurte['number_of_email']) {
					// pr($this->request->data); die;
					$session = $this->request->session();
					$session->write('login_fail_email', $this->request->data['email']);
					$session->write('login_fail_password', $this->request->data['password']);
					$user = $this->Auth->identify();
					$session->write('login_fail_user_id', $user['id']);
					$this->Flash->error(__('These credentials are already logged in'), ['key' => 'login_fail']);
					//$this->Flash->error(__('Maximum limit of multiple logins has been reached. Please ask a person to logout to continue'));
					return $this->redirect(['controller' => 'users', 'action' => 'login']);
				}
			}

			if (!$user) {
				$pass = md5($this->request->data['password']);
				$user = $this->Users->find('all')->where(['Users.guardianemailaddress' => $this->request->data['email'], 'Users.guardianpassword' => $pass])->first();
				$this->Auth->setUser($user);
			}

			// End Non Talent data
			if ($user && $user['role_id'] == NONTALANT_ROLEID || $user['role_id'] == TALANT_ROLEID) {

				if ($user['is_talent_admin_accept'] == '1' && $user['is_talent_admin'] == 'Y') {

					$talentadminterms = $this->talentadminterms($user['id']);
					if ($talentadminterms == 1) {
						$userss = $this->Users->get($user['id']);
						$user_dataa['is_talent_admin_accept'] = 2;
						$usersa = $this->Users->patchEntity($userss, $user_dataa);
						$updateuser = $this->Users->save($usersa);
					}
				}

				$this->loadModel('Subscription');
				$this->loadModel('Profilepack');


				// For Profile data update
				$subscriptiondata = $this->Subscription->find('all')
					->where(['Subscription.user_id' => $user['id'], 'Subscription.package_type' => 'PR'])
					->order(['id' => 'DESC'])
					->first();

				if ($subscriptiondata && time() > strtotime($subscriptiondata['expiry_date'])) {

					$subscriptionid = $subscriptiondata['id'];
					// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'DESC'])->first();

					$packfeature = $this->Packfeature->find()
						->where([
							'user_id' => $user['id'],
							'OR' => [
								['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
								['package_status' => 'default']
							]
						])
						->order(['id' => 'DESC'])
						->first();

					$packfeature_id = $packfeature['id'];
					$packfeature = $this->Packfeature->get($packfeature_id);
					$pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => PROFILE_PACKAGE])->order(['Profilepack.id' => 'DESC'])->first();
					$feature_info['number_categories'] = $pcakgeinformation['number_categories'];
					$feature_info['number_audio'] = $pcakgeinformation['number_audio'];
					$feature_info['number_video'] = $pcakgeinformation['number_video'];
					$feature_info['website_visibility'] = $pcakgeinformation['website_visibility'];
					$feature_info['private_individual'] = $pcakgeinformation['private_individual'];
					$feature_info['access_job'] = $pcakgeinformation['access_job'];
					$feature_info['number_job_application'] = $pcakgeinformation['number_job_application'];
					$feature_info['number_job_application_month'] = $pcakgeinformation['number_job_application'];
					$feature_info['number_job_application_daily'] = $pcakgeinformation['number_of_application_day'];
					$feature_info['number_search'] = $pcakgeinformation['number_search'];
					$feature_info['ads_free'] = $pcakgeinformation['ads_free'];
					$feature_info['number_albums'] = $pcakgeinformation['number_albums'];
					$feature_info['message_folder'] = $pcakgeinformation['message_folder'];
					$feature_info['privacy_setting_access'] = $pcakgeinformation['privacy_setting_access'];
					$feature_info['access_to_ads'] = $pcakgeinformation['access_to_ads'];
					$feature_info['number_of_jobs_alerts'] = $pcakgeinformation['number_of_jobs_alerts'];
					$feature_info['number_of_introduction'] = $pcakgeinformation['number_of_introduction'];
					$introsentdaycheck = explode(",", $packfeature['number_of_intorduction_send']);
					if ($introsentdaycheck[0] != date("Y-m-d")) {
						$feature_info['number_of_intorduction_send'] = date("Y-m-d") . ',' . $pcakgeinformation['number_of_intorduction_send'];
					} else {
						$feature_info['number_of_intorduction_send'] = $packfeature['number_of_intorduction_send'];
					}

					$feature_info['search_of_other_profile'] = $pcakgeinformation['search_of_other_profile'];
					$feature_info['ask_for_quote_request_per_job'] = $pcakgeinformation['ask_for_quote_request_per_job'];
					$feature_info['number_of_quote_daily'] = $pcakgeinformation['number_of_free_quote'];
					$introsentdaycheck = explode(",", $packfeature['introduction_sent']);
					if ($introsentdaycheck[0] != date("Y-m-d")) {
						$feature_info['introduction_sent'] = date("Y-m-d") . ',' . $pcakgeinformation['introduction_sent'];
					} else {
						$feature_info['introduction_sent'] = $packfeature['introduction_sent'];
					}
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
					$daysofprofile = $pcakgeinformation['validity_days'];

					$subscription = $this->Subscription->get($subscriptionid);
					$subscription_info['package_id'] = PROFILE_PACKAGE;
					$subscription_info['user_id'] =  $user['id'];
					$subscription_info['package_type'] = "PR";
					$subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofprofile . " days"));
					$subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
					$subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
					$savedata = $this->Subscription->save($subscription_arr);
					$packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
					$this->Packfeature->save($packfeatures);
				}

				$subscriptiondata = $this->Subscription->find('all')->where(['Subscription.user_id' => $user['id'], 'Subscription.package_type' => 'RC'])->order(['id' => 'DESC'])->first();


				if (time() > strtotime($subscriptiondata['expiry_date'])) {
					// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'DESC'])->first();
					$packfeature = $this->Packfeature->find()
						->where([
							'user_id' => $user['id'],
							'OR' => [
								['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
								['package_status' => 'default']
							]
						])
						->order(['id' => 'DESC'])
						->first();

					$packfeature_id = $packfeature['id'];
					$packfeature = $this->Packfeature->get($packfeature_id);
					$subscriptionid = $subscriptiondata['id'];
					$this->loadModel('RecuriterPack');
					$pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y', 'RecuriterPack.id' => RECUITER_PACKAGE])->order(['RecuriterPack.id' => 'DESC'])->first();
					$feature_info['number_of_job_post'] = $pcakgeinformation['number_of_job_post'];
					$feature_info['number_of_job_simultancney'] = $pcakgeinformation['number_of_job_simultancney'];
					$feature_info['nubmer_of_site'] = $pcakgeinformation['nubmer_of_site'];
					$feature_info['number_of_message'] = $pcakgeinformation['number_of_message'];
					$feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging'];
					$feature_info['number_of_contact_details'] = $pcakgeinformation['number_of_contact_details'];
					$feature_info['number_of_talent_search'] = $pcakgeinformation['number_of_talent_search'];
					// $feature_info['lengthofpackage'] = $pcakgeinformation['lengthofpackage'];
					$feature_info['number_of_email'] = $pcakgeinformation['number_of_email'];
					$feature_info['multipal_email_login'] = $pcakgeinformation['multipal_email_login'];
					$daysofrecur = $pcakgeinformation['validity_days'];
					$subscription = $this->Subscription->get($subscriptionid);
					$subscription_info['package_id'] = RECUITER_PACKAGE;
					$subscription_info['user_id'] = $user['id'];

					$subscription_info['package_type'] = "RC";
					$subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofprofile . " days"));
					$subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
					$subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
					$savedata = $this->Subscription->save($subscription_arr);
					$packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
					$this->Packfeature->save($packfeatures);
				}
				//end 


				// Non talent data
				// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'DESC'])->first();

				$packfeature = $this->Packfeature->find()
					->where([
						'user_id' => $user['id'],
						'OR' => [
							['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
							['package_status' => 'default']
						]
					])
					->order(['id' => 'DESC'])
					->first();

				// this code we have used for extend dailiy limit of job application
				$currentdat = strtotime(date('m/d/y'));
				$updatedate = strtotime($packfeature['applicationdate']);

				if ($currentdat != $updatedate) {

					// $packappl = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'DESC'])->first();

					$pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => $subscriptiondata->package_id])->order(['Profilepack.id' => 'DESC'])->first();

					$packfeature_idappli = $packfeature['id'];
					$packfeatureapplication = $this->Packfeature->get($packfeature_idappli);
					$application['number_job_application_daily'] = $pcakgeinformation['number_of_application_day'];
					//$application['applicationdate']=date('Y-m-d'); 
					$packfeaturesapp = $this->Packfeature->patchEntity($packfeatureapplication, $application);
					$result = $this->Packfeature->save($packfeaturesapp);
				}
				//end

				// this code we have used for extend dailiy limit of job application
				$updatedateintroducation = strtotime($packfeature['intorducation_send_date']);

				if ($updatedateintroducation != $updatedate) {

					// $packappl = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'DESC'])->first();
					$pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => $subscriptiondata->package_id])->order(['Profilepack.id' => 'DESC'])->first();

					$packfeature_idappli = $packfeature['id'];
					$packfeatureapplication = $this->Packfeature->get($packfeature_idappli);

					$introsentdaycheck = explode(",", $packfeatureapplication['introduction_sent']);
					if ($introsentdaycheck[0] != date("Y-m-d")) {
						$application['introduction_sent'] = date("Y-m-d") . ',' . $pcakgeinformation['introduction_sent'];
					} else {
						$application['introduction_sent'] = $packfeatureapplication['introduction_sent'];
					}

					//$application['applicationdate']=date('Y-m-d');
					$packfeaturesapp = $this->Packfeature->patchEntity($packfeatureapplication, $application);

					$result = $this->Packfeature->save($packfeaturesapp);
				}

				//end
				if (time() > strtotime($packfeature['non_telent_expire'])) {
					$pcakgeinformation = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();
					$feature_info['non_telent_number_of_audio'] = $pcakgeinformation['non_telent_number_of_audio'];
					$feature_info['non_telent_number_of_video'] = $pcakgeinformation['non_telent_number_of_video'];
					$feature_info['non_telent_number_of_album'] = $pcakgeinformation['non_telent_number_of_album'];
					$feature_info['non_telent_number_of_folder'] = $pcakgeinformation['non_telent_number_of_folder'];
					$feature_info['non_telent_number_of_jobalerts'] = $pcakgeinformation['non_telent_number_of_jobalerts'];
					$feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging'];
					$feature_info['non_telent_number_of_search_profile'] = $pcakgeinformation['non_telent_number_of_search_profile'];
					$feature_info['	non_telent_number_of_private_message'] = $pcakgeinformation['	non_telent_number_of_private_message'];
					$feature_info['non_telent_ask_quote'] = $pcakgeinformation['non_telent_ask_quote'];
					$feature_info['ask_for_quote_request_per_job'] = $pcakgeinformation['ask_for_quote_request_per_job'];
					$feature_info['non_telent_number_of_job_post'] = $pcakgeinformation['non_telent_number_of_job_post'];
					$daysofnontalent = $pcakgeinformation['non_talent_validity_days'];
					// $feature_info['non_telent_expire'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofnontalent . " days"));
					$packfeature_id = $packfeature['id'];

					$packfeature = $this->Packfeature->get($packfeature_id);

					$packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);

					$this->Packfeature->save($packfeatures);
				}

				$blocked_expiry = strtotime($user['blocked_expiry']);
				$current_time = time();

				if ($blocked_expiry > $current_time) {
					$datediff = $blocked_expiry - $current_time;
					$blocked_days = round($datediff / (60 * 60 * 24));
					$this->Flash->error(__('Your Profile is Blocked for ' . $blocked_days . ' days'));
					return $this->redirect(['controller' => 'users', 'action' => 'login']);
				} else {

					if ($user['status'] == "Y") {

						$this->loadModel('Settings');
						$settingdetails = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->toarray();
						$session = $this->request->session();
						$session->write('settings', $settingdetails[0]);
						// Update
						$user_id = $user['id'];
						$users = $this->Users->find('all')->where(['id' => $user_id])->first();
						$user_data['last_login'] = time();
						$users = $this->Users->patchEntity($users, $user_data);
						$updateuser = $this->Users->save($users);
						$this->Auth->setUser($user);

						//login check data insert .........
						$this->loadModel('Loginusercheck');
						$usersff = $this->Loginusercheck->find('all')->where(['user_id' => $user_id, 'ip' => $_SERVER['REMOTE_ADDR']])->count();
						if ($usersff > 0) {
							$loginusercheck = $this->Loginusercheck->find('all')->where(['user_id' => $user_id, 'ip' => $_SERVER['REMOTE_ADDR']])->first();
						} else {
							$loginusercheck = $this->Loginusercheck->newEntity();
						}

						$sessionId = session_id(); // Start PHP session to get session ID
						$data_log['session_id'] = $sessionId;
						$data_log['user_id'] = $this->request->session()->read('Auth.User.id');
						$data_log['ip'] = $_SERVER['REMOTE_ADDR'];
						$option_arr_log = $this->Loginusercheck->patchEntity($loginusercheck, $data_log);

						$this->Loginusercheck->save($option_arr_log);
						//login check data insert ......
						// pr($this->Auth->redirectUrl());exit;

						if ($this->request->data['action']) {
							$redirect_url = '/' . $this->request->data['action'];
						} else {
							$redirect_url = SITE_URL . '/viewprofile';
						}
						if ($user['is_talent_admin'] == 'Y') {
							$this->loadModel('TalentAdmin');
							$user_id = $user['id'];
							$talentadmin = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $user_id])->first();
							$this->request->session()->write('talentadmin', $talentadmin);
						}
						if ($redirect_url == '/') {
							return $this->redirect(['controller' => 'profile', 'action' => 'viewprofile']);
						} else {
							return $this->redirect($redirect_url);
						}
					} else {
						$this->Flash->error(__('Your profile has been deactivated'));
						return $this->redirect(['controller' => 'users', 'action' => 'login']);
					}
				}
			} else {
				$chackmail = $this->Users->find('all')->where(['Users.email' => $this->request->data['email']])->first();
				if ($this->request->data['email'] != $chackmail['email']) {
					$this->Flash->error(__('The ' . $this->request->data['email'] . ' does not exist. Please Sign up to enter'));
				} else {
					$this->Flash->error(__('Your password ' . $this->request->data['password'] . ' is incorrect, try again'));
				}
				return $this->redirect(['controller' => 'users', 'action' => 'login']);
			}
		} else if ($this->Auth->user('id')) {
			$this->redirect(Router::url($this->referer(), true));
		}
		$remember_me = $this->Cookie->read('remember_me');
		$email = $this->Cookie->read('email');
		$password = $this->Cookie->read('password');
		// pr($remember_me);
		// pr($password);
		// pr($email);exit;
		$this->set(compact('email', 'password', 'remember_me'));
	}

	public function signup($key = null)
	{
		$this->loadComponent('Email');
		$this->loadModel('Profile');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Users');
		$this->loadModel('Country');
		$country = $this->Country->find('list')->select(['id', 'name'])->toarray();
		$this->set('country', $country);
		$phonecodess = $this->Country->find('list', ['keyField' => 'id', 'valueField' => 'cntcode'])->toarray();
		$this->set('phonecodess', $phonecodess);
		$this->set('ref_by', $key);

		$users = $this->Users->newEntity();

		if ($this->request->is(['post', 'put'])) {
			// pr($this->request->data);exit;

			if (isset($this->request->data['g-recaptcha-response'])) {
				$captcha = $this->request->data['g-recaptcha-response'];
			}
			$secretKey = "6LcQUZwpAAAAAPDM1dYqNuazsa7Bl6MlP1KucN7r";
			$ip = $_SERVER['REMOTE_ADDR'];
			$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
			$response = file_get_contents($url);
			$responseKeys = json_decode($response, true);

			if (!$responseKeys["success"]) {
				$this->Flash->error(__('Captcha entry is incorrect, try again'));
				// return $this->redirect(['action' => 'login']);
				return $this->redirect($this->referer());
			}

			if ($this->request->data['password'] != $this->request->data['cpassword']) {
				$this->Flash->error(__('The passwords do not match. Please ensure the "Confirm Password" field matches the "Password" field.'));
				return $this->redirect($this->referer());
			}



			$name = ucwords(strtolower($this->request->data['name']));
			$email = $this->request->data['email'];
			$this->request->data['user_name'] = $name;
			$password = $this->request->data['password'];
			// $phone = $this->request->data['phone'];
			$this->request->data['password'] = $this->_setPassword($password);
			$this->request->data['cpassword'] = $this->request->data['cpassword'];
			$site_url = SITE_URL;
			$useractivation = $this->request->data['user_activation_key'];
			// Check if any required field is empty
			if (empty($name) || empty($email) || empty($password)) {
				$this->Flash->error(__('Please fill in all required fields.'));
				// return $this->redirect(['controller' => 'Users', 'action' => 'signup']);
				return $this->redirect($this->referer());
			}

			// Validate email format
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$this->Flash->error(__('Please enter a valid email address.'));
				// return $this->redirect(['controller' => 'Users', 'action' => 'signup']);
				return $this->redirect($this->referer());
			}

			// Check if the user already exists
			$existingUser = $this->Users->findByEmail($email)->first();
			if ($existingUser['user_delete'] == 'Y') {
				$this->Flash->error(__('Your email is suspended contact to support.'));
				// return $this->redirect(['controller' => 'Users', 'action' => 'signup']);
				return $this->redirect($this->referer());
			} else if ($existingUser) {
				$this->Flash->error(__('User already exists. Please log in.'));
				// return $this->redirect(['controller' => 'Users', 'action' => 'signup']);
				return $this->redirect($this->referer());
			}

			if (!empty($this->request->data['ref_by'])) {
				$this->loadModel('Talent_admin');
				$talentadmin = $this->Talent_admin->find('all')->where(['Talent_admin.referal_code' => $this->request->data['ref_by']])->first();
				if ($talentadmin) {
					$ref_by = $talentadmin['user_id'];
					$referal_code = $talentadmin['referal_code'];
				}
			} else {
				$this->loadModel('Refers');
				$refers = $this->Refers->find('all')->where(['Refers.email' => $this->request->data['email']])->first();
				if ($refers) {
					$ref_by = $refers['ref_by'];
					//$this->Refers->deleteAll(['Refers.email' => $this->request->data['email']]);
					$refertable = TableRegistry::get("Refers");
					$query = $refertable->query();
					$result = $query->update()->set(['name' => $name, 'status' => 'Y'])->where(['Refers.email' => $this->request->data['email']])->execute();
				}
			}

			$this->request->data['ref_by'] = $ref_by;
			$department = $this->Users->patchEntity($users, $this->request->data);
			if ($register = $this->Users->save($department)) {

				$this->loadModel('Refers');
				$refers = $this->Refers->find('all')->where(['Refers.email' => $this->request->data['email']])->first();
				if ($refers) {
					$refertable = TableRegistry::get("Refers");
					$query = $refertable->query();
					$result = $query->update()->set(['user_id' => $register['id']])->where(['Refers.email' => $this->request->data['email']])->execute();
				}

				$talent = $this->TalentAdmin->find('all')->where(['TalentAdmin.email' => $this->request->data['email']])->first();
				$created = date('M d, Y', strtotime($talent['created_date']));
				$talenttable = TableRegistry::get("TalentAdmin");
				$query = $talenttable->query();
				$result = $query->update()->set(['user_id' => $register['id'], 'user_name' => $register['user_name']])->where(['TalentAdmin.id' => $talent['id']])->execute();

				if (!empty($talent)) {
					$usertable = TableRegistry::get("Users");
					$query = $usertable->query();
					$result = $query->update()->set(['is_talent_admin' => 'Y'])->where(['Users.id' => $register['id']])->execute();
					$userid = $register['id'];
					$name = $register['user_name'];
					$this->loadmodel('Templates');
					$temprofile = $this->Templates->find('all')->where(['Templates.id' => APPOINTMENTPARTNER])->first();
					$subject = $temprofile['subject'];
					$from = $temprofile['from'];
					$fromname = $temprofile['fromname'];
					$to  = $register['email'];
					$formats = $temprofile['description'];
					$site_url = SITE_URL;
					$commision = $talent['commision'];
					$message1 = str_replace(array('{Name}', '{site_url}', '{commision}', '{created}', '{subject}'), array($name, $site_url, $commision, $created, $subject), $formats);
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

					$headers = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
					// $emailcheck = mail($to, $subject, $message, $headers);
					$mail = $this->Email->send($to, $subject, $message);
				}

				$this->loadmodel('Refers');
				$user_id = $register->id;
				if ($referal_code) {
					$refers = $this->Refers->updateAll(array('status' => 'Y'), array('Refers.email' => $email, 'Refers.ref_by' => $ref_by));
				}

				$this->assigndefaultpackage($user_id);

				$this->loadmodel('Templates');
				$profile = $this->Templates->find('all')->where(['Templates.id' => REGISTRATION])->first();

				$subject = $profile['subject'];
				$from = $profile['from'];
				$fromname = $profile['fromname'];
				$to  = $email;
				$formats = $profile['description'];
				$site_url = SITE_URL;
				$message1 = str_replace(array('{Name}', '{phone}', '{Email}', '{Password}', '{site_url}', '{Useractivation}'), array($name, $phone, $email, $password, $site_url, $useractivation), $formats);
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
				</html>';

				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
				// $emailcheck = mail($to, $subject, $message, $headers);
				$mail = $this->Email->send($to, $subject, $message);
				$profile = $this->Profile->newEntity();
				$user_id = $department->id;
				$profess = $this->Users->find('all')->where(['id' => $user_id])->first();
				$this->request->data['name'] = $profess['user_name'];
				$this->request->data['user_id'] = $user_id;
				if ($talent) {
					$this->request->data['country_ids'] = $talent['country_id'];
					$this->request->data['state_id'] = $talent['state_id'];
					$this->request->data['city_id'] = $talent['city_id'];
				}
				// code of add field profiletietel

				$this->request->data['phonecode'] = $this->request->data['phonecode'];
				$profiles = $this->Profile->patchEntity($profile, $this->request->data);
				$this->Profile->save($profiles);

				// $this->Auth->setUser($profess);
				$this->Flash->success(__('Verification Link Sent To Your Email, Go To Your Email and Please Verify'));
				// return $this->redirect(['controller' => 'profile', 'action' => 'profile']);
				// return $this->redirect(['controller' => 'Users', 'action' => 'signup']);
				return $this->redirect(['action' => 'login']);
			}
		}
	}

	public function assigndefaultpackage($user_id)
	{
		$this->loadModel('Packfeature');
		$packfeature = $this->Packfeature->newEntity();
		$feature_info['user_id'] = $user_id;
		$this->loadModel('Profilepack');
		$pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => PROFILE_PACKAGE])->order(['Profilepack.id' => 'ASC'])->first();

		$feature_info['number_audio'] = $pcakgeinformation['number_audio'];
		$feature_info['talent_audio_list_total'] = $pcakgeinformation['number_audio'];
		$feature_info['number_video'] = $pcakgeinformation['number_video'];
		$feature_info['talent_video_list_total'] = $pcakgeinformation['number_video'];
		$feature_info['website_visibility'] = $pcakgeinformation['website_visibility'];
		$feature_info['access_job'] = $pcakgeinformation['access_job'];
		$feature_info['privacy_setting_access'] = $pcakgeinformation['privacy_setting_access'];
		$feature_info['access_to_ads'] = $pcakgeinformation['access_to_ads'];
		$feature_info['number_job_application'] = $pcakgeinformation['number_job_application'];
		$feature_info['number_job_application_month'] = $pcakgeinformation['number_job_application'];
		$feature_info['number_job_application_daily'] = $pcakgeinformation['number_of_application_day'];
		$feature_info['ads_free'] = $pcakgeinformation['ads_free'];
		$feature_info['number_albums'] = $pcakgeinformation['number_albums'];
		$feature_info['number_of_jobs_alerts'] = $pcakgeinformation['number_of_jobs_alerts'];
		$feature_info['number_of_introduction'] = $pcakgeinformation['number_of_introduction'];
		$feature_info['introduction_sent'] = $pcakgeinformation['introduction_sent'];
		$feature_info['number_of_introduction_recived'] = $pcakgeinformation['number_of_introduction_recived'];
		$feature_info['number_of_photo'] = $pcakgeinformation['number_of_photo'];
		$feature_info['ask_for_quote_request_per_job'] = $pcakgeinformation['ask_for_quote_request_per_job'];
		$feature_info['number_of_quote_daily'] = $pcakgeinformation['number_of_quote_daily'];
		$feature_info['job_alerts'] = $pcakgeinformation['job_alerts'];
		$feature_info['number_of_booking'] = $pcakgeinformation['number_of_booking'];
		$feature_info['persanalized_url'] = $pcakgeinformation['persanalized_url'];
		$feature_info['number_categories'] = $pcakgeinformation['number_categories'];
		$feature_info['personal_page'] = $pcakgeinformation['personal_page'];


		// package validity
		$daysofprofile = $pcakgeinformation['validity_days'];
		$this->loadModel('Subscription');
		$subscription = $this->Subscription->newEntity();
		$subscription_info['package_id'] = PROFILE_PACKAGE;
		$subscription_info['user_id'] =  $user_id;
		$subscription_info['package_type'] = "PR";
		$subscription_info['expiry_date'] = date('Y-m-d H:i:s', strtotime("+" . $daysofprofile . " days"));
		$subscription_info['subscription_date'] = date('Y-m-d H:i:s');
		$subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
		$savedata = $this->Subscription->save($subscription_arr);


		// RecuriterPack data
		$this->loadModel('RecuriterPack');
		$pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y', 'RecuriterPack.id' => RECUITER_PACKAGE])->order(['RecuriterPack.id' => 'DESC'])->first();
		$feature_info['number_of_job_post'] = $pcakgeinformation['number_of_job_post'];
		$feature_info['number_of_job_simultancney'] = $pcakgeinformation['number_of_job_simultancney'];
		$feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging']; // Y,N
		$feature_info['number_of_message'] = $pcakgeinformation['number_of_message'];
		$feature_info['number_of_contact_details'] = $pcakgeinformation['number_of_contact_details'];
		$feature_info['number_of_talent_search'] = $pcakgeinformation['number_of_talent_search'];
		$feature_info['nubmer_of_site'] = $pcakgeinformation['nubmer_of_site'];
		$feature_info['number_of_email'] = $pcakgeinformation['number_of_email'];
		$feature_info['multipal_email_login'] = $pcakgeinformation['multipal_email_login'];

		
		$feature_info['non_telent_number_of_private_message'] = $pcakgeinformation['non_telent_number_of_private_message'];
		$feature_info['number_of_email'] = $pcakgeinformation['number_of_email'];
		$feature_info['multipal_email_login'] = $pcakgeinformation['multipal_email_login'];






		// recruiter validity
		$daysofrecur = $pcakgeinformation['validity_days'];
		$subscription = $this->Subscription->newEntity();
		$subscription_info['package_id'] = RECUITER_PACKAGE;
		$subscription_info['user_id'] =  $user_id;
		$subscription_info['package_type'] = "RC";
		$subscription_info['expiry_date'] = date('Y-m-d H:i:s', strtotime("+" . $daysofrecur . " days"));
		$subscription_info['subscription_date'] = date('Y-m-d H:i:s');
		$subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
		$savedata = $this->Subscription->save($subscription_arr);


		// Non Telent data
		$this->loadModel('Settings');
		$pcakgeinformation = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();
		$feature_info['number_of_talent_free_jobpost'] = $pcakgeinformation['number_of_talent_free_jobpost'];
		$feature_info['number_of_days_free_jobpost'] = $pcakgeinformation['number_of_days_free_jobpost'];
		$feature_info['number_of_days_free_jobpost_talent'] = $pcakgeinformation['number_of_days_free_jobpost_talent'];
		$feature_info['non_telent_number_of_job_post'] = $pcakgeinformation['non_telent_number_of_job_post'];
		$feature_info['non_telent_ask_quote'] = $pcakgeinformation['non_telent_ask_quote'];
		$feature_info['non_talent_number_of_free_booking_req'] = $pcakgeinformation['number_of_free_booking_req'];
		$feature_info['non_telent_number_of_audio'] = $pcakgeinformation['non_telent_number_of_audio'];
		$feature_info['non_telent_number_of_video'] = $pcakgeinformation['non_telent_number_of_video'];
		$feature_info['non_telent_number_of_album'] = $pcakgeinformation['non_telent_number_of_album'];
		$feature_info['non_telent_number_of_folder'] = $pcakgeinformation['non_telent_number_of_folder'];
		$feature_info['non_telent_number_of_search_profile'] = $pcakgeinformation['non_telent_number_of_search_profile'];
		$feature_info['non_telent_number_of_private_message'] = $pcakgeinformation['non_telent_number_of_private_message'];
		$feature_info['non_talent_video_list_total'] = $pcakgeinformation['non_telent_number_of_video'];
		$feature_info['non_talent_audio_list_total'] = $pcakgeinformation['non_telent_number_of_audio'];
		$feature_info['non_telent_totalnumber_of_images'] = $pcakgeinformation['non_telent_number_of_folder'];

		$feature_info['block_after_report'] = $pcakgeinformation['block_after_report'];
		$feature_info['block_after_days'] = $pcakgeinformation['block_after_days'];
		$feature_info['unblock_within'] = $pcakgeinformation['unblock_within'];
		$feature_info['featured_artist_days'] = $pcakgeinformation['featured_artist_days'];
		$feature_info['ping_amt'] = $pcakgeinformation['ping_amt'];
		$feature_info['quote_amt'] = $pcakgeinformation['quote_amt'];

		$daysofnontalent = $pcakgeinformation['non_talent_validity_days'];
		$feature_info['non_telent_expire'] = date('Y-m-d H:i:s', strtotime("+" . $daysofnontalent . " days"));
		$packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
		$this->Packfeature->save($packfeatures);
		return true;
	}

	public function verify($token = null)
	{
		$this->loadModel('Users');
		///$detl=$this->User->find('all',array('conditions'=>array('User.user_activation_key'=>$token)));
		$profess = $this->Users->find('all')->where(['Users.user_activation_key' => $token])->first();
		$name = $profess['user_name'];
		$email = $profess['email'];
		$password = $profess['confirmpass'];
		$useractivation	= $profess['user_activation_key'];
		if ($useractivation = $profess['user_activation_key']) {
			$status = "Y";
			$con = ConnectionManager::get('default');
			$detail = 'UPDATE `users` SET `isvarify` ="' . $status . '",`user_activation_key` =" " WHERE `users`.`id` = ' . $profess['id'];
			$results = $con->execute($detail);

			$this->Flash->success(__('Email Verified Successfully'));
			// Auto login to user
			$professssagain = $this->Users->find('all')->where(['id' => $profess['id']])->first();
			$this->Auth->setUser($professssagain);
			return $this->redirect(['controller' => 'profile', 'action' => 'profile']);
		} else {
			$this->Flash->error(__('Subscription Link unavailable!!'));
			return $this->redirect(['controller' => 'Users', 'action' => 'login']);
		}
	}

	// function used for dupicate email check:
	public function findUsername($username = null)
	{
		$username = $this->request->data['username'];
		$user = $this->Users->find('all')->where(['Users.email' => $username])->toArray();
		echo $user[0]['id'];
		die;
	}

	public function talentadminterms($id = null)
	{
		$this->loadModel('Users');
		$this->loadModel('TalentAdmin');
		if ($id) {
			$useremail = $this->Users->find('all')->where(['Users.id' => $id, 'Users.is_talent_admin_accept' => 1, 'Users.is_talent_admin' => 'Y'])->first();
			$talent = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $id])->first();
			$commision = $talent['commision'];
			$created = date('M d, Y', strtotime($talent['created_date']));

			if (count($useremail) == 0) {
				$this->Flash->error(__('Invalid Email. Please input a valid Email'));
				return $this->redirect(['controller' => 'users', 'action' => 'forgotpassword']);
			} else {
				$userid = $useremail['id'];
				$name = $useremail['user_name'];

				$this->loadmodel('Templates');
				$profile = $this->Templates->find('all')->where(['Templates.id' => APPOINTMENTPARTNER])->first();

				$subject = $profile['subject'];
				$from = $profile['from'];
				$fromname = $profile['fromname'];
				$to  = $useremail['email'];
				$formats = $profile['description'];
				$site_url = SITE_URL;

				$message1 = str_replace(array('{Name}', '{site_url}', '{commision}', '{created}', '{subject}'), array($name, $site_url, $commision, $created, $subject), $formats);
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
				/*if ($emailcheck) {
				echo "string"; die;
			}else{
				echo "not sent"; die;
			}*/
				return $emailcheck;
			}
		}
	}

	//function use for send appointment main after first login
	public function appointmailsend($id = null)
	{
		$this->loadmodel('Templates');
		$this->loadmodel('TalentAdmin');

		$talentprofile = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $id])->first();
		$profile = $this->Templates->find('all')->where(['Templates.id' => APPOINTMENTPARTNER])->first();
		$created = date('M d, Y', strtotime($talentprofile['created_date']));
		$commision = $talentprofile['commision'];
		$subject = $profile['subject'];
		$from = $profile['from'];
		$fromname = $profile['fromname'];
		$to  = $talentprofile['email'];
		$name  = $talentprofile['user_name'];
		$formats = $profile['description'];
		$visit_site_url = SITE_URL . "/login";
		$site_url = SITE_URL;

		$message1 = str_replace(array('{Name}', '{site_url}', '{commision}', '{created}', '{subject}', '{visit_site_url}'), array($name, $site_url, $commision, $created, $subject, $visit_site_url), $formats);
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
		$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
		$emailcheck = mail($to, $subject, $message, $headers);
		if ($emailcheck) {
			$users = TableRegistry::get('TalentAdmin');
			$query = $users->query();
			$query->update()
				->set(['appointment' => 0])
				->where(['id' => $talentprofile['id']])
				->execute();
		}
	}

	public function logout()
	{
		$this->loadModel('Loginusercheck');
		$this->autoRender = false;
		// Get user ID
		$userId = $this->Auth->user('id');
		$loginUserIp = $_SESSION['login_user_ip'] ?? null;
		$session_token = $_SESSION['session_token'] ?? null;

		$session = $this->request->session();
		if (!$userId) {
			$this->Flash->error('Invalid session or user not found.');
			return $this->redirect(['controller' => 'users', 'action' => 'login']);
		}
		$this->Cookie->delete('remember_me');
		$this->Cookie->delete('email');
		$this->Cookie->delete('password');
		// Perform logout
		$logout = $this->Auth->logout();
		if ($logout) {
			$userLoginRecord = $this->Loginusercheck->find()
				->where(['user_id' => $userId, 'session_token' => $session_token])
				->first();
			if (!$userLoginRecord) {
				$userLoginRecord = $this->Loginusercheck->find()
				->where(['user_id' => $userId,'session_token' => ''])
				->first();
			}
			if ($userLoginRecord) {
				$this->Loginusercheck->delete($userLoginRecord);
			}
		}
		$session->destroy();
		$this->Flash->success('You are now logged out.');
		return $this->redirect(['controller' => 'users', 'action' => 'login']);
	}

	public function logoutall()
	{
		$this->loadModel('Loginusercheck');
		$session = $this->request->session();
		$login_fail_user_id = $session->read('login_fail_user_id');
		$userId = $login_fail_user_id;

		if (!$userId) {
			$this->Flash->error(__('Invalid session or user not found.'));
			return $this->redirect(['controller' => 'users', 'action' => 'login']);
		}
		// Perform logout
		$logout = $this->Auth->logout();
		if ($logout) {
			try {
				$this->Loginusercheck->deleteAll(['user_id' => $userId]);
			} catch (\Exception $e) {
				echo "Error deleting records: " . $e->getMessage();
				die;
			}
			$session->destroy();
			return $this->redirect(['controller' => 'users', 'action' => 'login']);
		}
	}


	public function logoutallbackup()
	{
		// session_start();
		$this->loadModel('Loginusercheck');
		$session = $this->request->session();
		$login_fail_user_id  = $this->request->session()->read('login_fail_user_id');
		// Get user ID
		$userId = $login_fail_user_id;
		// Retrieve user's IP address from database
		$userIP = $this->Loginusercheck->find()->select(['ip'])->where(['user_id' => $userId])->first()->ip;
		// Logout the user
		$logout = $this->Auth->logout();
		// pr($_SESSION);exit;
		if ($logout) {
			// Find and delete the user's login record based on user ID and stored IP address
			$userLoginRecord = $this->Loginusercheck->find()->where(['user_id' => $userId, 'ip' => $userIP])->first();
			if ($userLoginRecord) {
				try {
					$deleteResult = $this->Loginusercheck->delete($userLoginRecord);
				} catch (\Exception $e) {
					echo "Error deleting record: " . $e->getMessage();
					die;
				}
			}
			// Destroy session
			$session = $this->request->session();
			$session->destroy();
			// Redirect to home page
			return $this->redirect(['controller' => 'users', 'action' => 'login']);
		}
	}

	public function forgotpassword()
	{
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadComponent('Email');
		if ($this->request->is('post')) {
			$email = $this->request->data['email'];
			$to = $email;
			$useremail = $this->Users->find('all')->where(['Users.email' => $email])->first();

			if (count($useremail) == 0) {
				$this->Flash->error(__('Invalid e mail. Please input a valid e mail'));
				return $this->redirect(['controller' => 'users', 'action' => 'forgotpassword']);
			} else {

				$userid = $useremail['id'];
				$name = $useremail['user_name'];
				$site_url = SITE_URL;
				$fkey = rand(1, 10000);
				$Pack = $this->Users->get($userid);
				$Pack->fkey = $fkey;
				$this->Users->save($Pack);
				$mid = base64_encode(base64_encode($userid . '/' . $fkey));
				$url = SITE_URL . "/users/forget_cpass/" . $mid;


				// email send templete

				$this->loadModel('Templates');

				// Find the template based on the ID
				$profile = $this->Templates->find('all')->where(['Templates.id' => 14])->first();

				// Check if template is found
				if ($profile) {
					$subject = $profile->subject;
					$from = $profile->from;
					$fromname = $profile->fromname;
					$to = $email;
					$formats = $profile->description;
					$site_url = SITE_URL;

					// Prepare message with placeholders replaced
					$message1 = str_replace(array('{Name}', '{site_url}', '{url}'), array($name, $site_url, $url), $formats);
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
					// 	//$headers .= 'To: <'.$to.'>' . "\r\n";
					$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
					$mail = $this->Email->send($to, $subject, $message);
				} else {
					echo "Template not found.";
				}
				// by rupam sir
				// 	$this->loadmodel('Templates');
				// 	$profile = $this->Templates->find('all')->where(['Templates.id' => FORGOTPASSWORD])->first();
				// 	$subject = $profile['subject'];
				// 	$from = $profile['from'];
				// 	$fromname = $profile['fromname'];
				// 	$to  = $email;
				// 	$formats = $profile['description'];
				// 	$site_url = SITE_URL;

				// 	$message1 = str_replace(array('{Name}', '{site_url}', '{url}'), array($name, $site_url, $url), $formats);
				// 	$message = stripslashes($message1);

				// 	$message = '
				// <!DOCTYPE HTML>
				// <html>
				// <head>
				// 	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				// 	<title>Mail</title>
				// </head>
				// <body style="padding:0px; margin:0px;font-family:Arial,Helvetica,sans-serif; font-size:13px;">
				// 	' . $message1 . '
				// </body>
				// </html>
				// ';

				// 	$headers = 'MIME-Version: 1.0' . "\r\n";
				// 	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				// 	//$headers .= 'To: <'.$to.'>' . "\r\n";
				// 	$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";

				// 	$emailcheck =$this->Email->send($to, $subject, $message, $headers);

				// end code


				$personal_pro = $this->Profile->find('all')->where(['Profile.user_id' => $useremail['id']])->first();
				$age_diff = (date('Y') - date('Y', strtotime($personal_pro['dob'])));

				if ($age_diff > 1 && $age_diff < 18) {
					$to  = $personal_pro['guardian_email'];
					$name = $personal_pro['guadian_name'];

					$message1 = str_replace(array('{Name}', '{site_url}', '{url}'), array($name, $site_url, $url), $formats);
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
					// $emailcheck = mail($to, $subject, $message, $headers);
					$mail = $this->Email->send($to, $subject, $message);
				}




				$this->Flash->success(__(' Link to change password has been successfully sent to Your Email'));
			}
		}
	}

	public function forgetcpass($mid = '', $userid = '')
	{
		if (!empty($userid)) {
			$id = $userid;
		} else {
			$mix = explode("/", base64_decode(base64_decode($mid)));
			$id = $mix[0];
			$fkey = $mix[1];
			$user = $this->Users->find('all')->select(['id', 'fkey'])->where(['Users.id' => $id])->first();
			$usrfkey = $user['fkey'];
			if ($usrfkey == $fkey) {
				$ftyp = 1;
			} else {
				$ftyp = 0;
			}
			$this->set('ftyp', $ftyp);
			$this->set('usrid', $id);
		}
		if ($this->request->is('post')) {
			$Pack = $this->Users->get($id);

			$updpass = $this->_setPassword($this->request->data['password']);
			$userpass['password'] = $updpass;
			$userpass['cpassword'] = $this->request->data['cpassword'];
			$savepass = $this->Users->patchEntity($Pack, $userpass);
			if ($this->Users->save($savepass)) {
				$this->loadmodel('Profile');
				$guardianprofile = $this->Profile->find('all')->where(['user_id' => $id])->first();
				$guardianname = $guardianprofile['guadian_name'];
				$usermail = $Pack['email'];
				$user = $Pack['user_name'];
				$userpass = $Pack['cpassword'];
				$guardianemail = $guardianprofile['guardianemailaddress'];

				$usergender = $guardianprofile['gender'];

				if ($usergender == 'm') {
					$usergendername = 'Mr';
				} else if ($usergender == 'f') {
					$usergendername = 'Ms';
				}
				if ($usergender == 'o') {
					$usergendername = 'Mr/Ms';
				}

				if ($usergender == 'm') {
					$usergenderhis = 'his';
				} else if ($usergender == 'f') {
					$usergenderhis = 'her';
				}
				if ($usergender == 'o') {
					$usergenderhis = 'his/her';
				}

				$age_diff = (date('Y') - date('Y', strtotime($guardianprofile['dob'])));
				if ($age_diff > 1 && $age_diff < 18) {
					$this->loadmodel('Templates');
					$profile = $this->Templates->find('all')->where(['Templates.id' => GUARDIANMAILFORGETPASS])->first();
					$subject = $profile['subject'];
					$from = $profile['from'];
					$fromname = $profile['fromname'];
					$to  = $guardianprofile['guardian_email'];
					$formats = $profile['description'];
					$site_url = SITE_URL;
					$message1 = str_replace(
						array('{Name}', '{user}', '{usermail}', '{userpass}', '{usergendername}', '{usergenderhis}', '{site_url}', '{Useractivation}'),
						array($guardianname, $user, $usermail, $userpass, $usergendername, $usergenderhis, $site_url, $useractivation),
						$formats
					);
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
				</html>';
					$headers = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					//$headers .= 'To: <'.$to.'>' . "\r\n";
					$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
					$emailcheck = mail($to, $subject, $message, $headers);
					/*   sending email to guardian end */
				}
				//echo "tesdsdt"; die;
				$Pack = $this->Users->get($id);
				$Pack->fkey = 0;
				$this->Users->save($Pack);
				$useremail = $this->Users->find('all')->where(['Users.id' => $id])->first();
				$email = $useremail['email'];
				$name = $useremail['user_name'];
				$password = $this->request->data['password'];
				$this->loadmodel('Templates');
				$profile = $this->Templates->find('all')->where(['Templates.id' => FORGOTPASSWORDCHANGED])->first();
				$subject = $useremail['subject'];
				$from = $useremail['from'];
				$fromname = $useremail['fromname'];
				$to  = $email;
				$formats = $profile['description'];
				$site_url = SITE_URL;
				$message1 = str_replace(array('{Name}', '{Email}', '{Password}', '{site_url}'), array($name, $email, $password, $site_url), $formats);
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
				if ($useremail['email'] == '1') {
					$this->Flash->success(__('Password Changed Successfully'));
					$this->redirect(array('controller' => 'Logins', 'action' => 'index/' . $email . '/' . $pass));
				} else {
					//$this->redirect(array('controller'=>'Users','action'=>'login/'.$email.'/'.$pass));
					$this->Flash->success(__('Password Changed Successfully'));
					$this->redirect(array('controller' => 'Users', 'action' => 'login'));
				}
			}
		}
	}

	public function linkedinlogin()
	{
		// Set the API endpoint and parameters
		// print_r($_GET); die;
		$endpoint = 'https://www.linkedin.com/oauth/v2/accessToken';
		// echo $_GET['code']; die;
		$params = [
			'grant_type' => 'authorization_code',
			'code' => $_GET['code'],
			'redirect_uri' => 'https://www.bookanartiste.com/users/linkedinlogin',
			'client_id' => '77cerboa6bsg7y',
			'client_secret' => '4H2Ectuflfc0VaEv'
		];

		// Send a POST request to exchange the authorization code for an access token
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
		$response = curl_exec($ch);
		curl_close($ch);
		// pr(json_decode($response)); die;
		// Parse the response to retrieve the access token
		$token = json_decode($response)->access_token;
		// pr($token); die;
		// Set the API endpoint and parameters to retrieve the user's profile data
		$endpoint = 'https://api.linkedin.com/v2/me';
		$params = [
			'projection' => '(id,firstName,lastName,profilePicture(displayImage~:playableStreams))'
		];

		// Send a GET request to retrieve the user's profile data
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $endpoint . '?' . http_build_query($params));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			'Authorization: Bearer ' . $token,
			'Connection: Keep-Alive',
			'Content-Type: application/json'
		]);
		$response = curl_exec($ch);
		curl_close($ch);

		// Parse the response to retrieve the user's profile data
		$user = json_decode($response);
		// if(empty($firstName)){
		// 	return $this->redirect(['controller' => 'users','action'=>'login']);
		// }
		$firstName = $user->firstName->localized->en_US;
		$lastName = $user->lastName->localized->en_US;
		echo 'Welcome, ' . $firstName . ' ' . $lastName . '!';
		die;
		// $profilePicture = $user->profilePicture->localized->en_US;

		// pr($user); die;
		// Use the user's profile data to personalize their experience on your website or application
		// echo 'Welcome, ' . $user->firstName->localized->en_US . '!';

	}

	function generateRandomPassword($length)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$password = '';
		$charactersLength = strlen($characters);
		for ($i = 0; $i < $length; $i++) {
			$password .= $characters[rand(0, $charactersLength - 1)];
		}
		return $password;
	}

	public function sociallogin()
	{

		$this->loadmodel('Users');
		$this->loadmodel('Profile');
		$this->loadmodel('Profilepack');
		$this->loadmodel('Packfeature');
		if ($this->request->is('post')) {

			// correct this messsgae
			$this->Flash->error(__('Social media login has been disabled by the admin. Please use the custom login option.'));
			return $this->redirect(['controller' => 'users', 'action' => 'login']);

			// pr($this->request->data);exit;
			$users = $this->Users->newEntity();
			$email = $this->request->data['email'];
			$name = $this->request->data['name'];
			$google_id = $this->request->data['google_id'];
			$fbid = $this->request->data['fbid'];

			if ($this->request->data['fbid']) {
				$user = $this->Users->find('all')->where(['fbid' => $fbid])->first();
			} else {
				$user = $this->Users->find('all')->where(['email' => $email])->first();
			}


			if ($user) {
				if ($user && $user['role_id'] == NONTALANT_ROLEID || $user['role_id'] == TALANT_ROLEID) {
					$this->loadModel('Subscription');
					$this->loadModel('Profilepack');
					$this->loadModel('Packfeature');
					$this->loadModel('Subscription');

					$subscriptiondata = $this->Subscription->find('all')->where(['Subscription.user_id' => $user['id'], 'Subscription.package_type' => 'PR'])->first();

					if (time() > strtotime($subscriptiondata['expiry_date'])) {
						$subscriptionid = $subscriptiondata['id'];
						$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'ASC'])->first();
						$packfeature_id = $packfeature['id'];
						$packfeature = $this->Packfeature->get($packfeature_id);
						$pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => PROFILE_PACKAGE])->order(['Profilepack.id' => 'ASC'])->first();
						$feature_info['number_categories'] = $pcakgeinformation['number_categories'];
						$feature_info['number_audio'] = $pcakgeinformation['number_audio'];
						$feature_info['ask_for_quote_request_per_job'] = $pcakgeinformation['ask_for_quote_request_per_job'];
						$feature_info['number_video'] = $pcakgeinformation['number_video'];
						$feature_info['website_visibility'] = $pcakgeinformation['website_visibility'];
						$feature_info['private_individual'] = $pcakgeinformation['private_individual'];
						$feature_info['access_job'] = $pcakgeinformation['access_job'];
						$feature_info['number_job_application'] = $pcakgeinformation['number_job_application'];
						$feature_info['number_job_application_month'] = $pcakgeinformation['number_job_application'];
						$feature_info['number_job_application_daily'] = $pcakgeinformation['number_of_application_day'];
						$feature_info['number_of_quote_daily'] = $pcakgeinformation['number_of_quote_daily'];
						$feature_info['number_search'] = $pcakgeinformation['number_search'];
						$feature_info['ads_free'] = $pcakgeinformation['ads_free'];
						$feature_info['number_albums'] = $pcakgeinformation['number_albums'];
						$feature_info['message_folder'] = $pcakgeinformation['message_folder'];
						$feature_info['privacy_setting_access'] = $pcakgeinformation['privacy_setting_access'];
						$feature_info['access_to_ads'] = $pcakgeinformation['access_to_ads'];
						$feature_info['number_of_jobs_alerts'] = $pcakgeinformation['number_of_jobs_alerts'];
						$feature_info['number_of_introduction'] = $pcakgeinformation['number_of_introduction'];
						$feature_info['number_of_intorduction_send'] = date("Y-m-d") . ',' . $pcakgeinformation['number_of_intorduction_send'];
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
						$daysofprofile = $pcakgeinformation['validity_days'];
						$this->loadModel('Subscription');
						$subscription = $this->Subscription->get($subscriptionid);
						$subscription_info['package_id'] = PROFILE_PACKAGE;
						$subscription_info['user_id'] =  $user['id'];
						$subscription_info['package_type'] = "P";
						$subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofprofile . " days"));
						$subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
						$subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
						$savedata = $this->Subscription->save($subscription_arr);
						$packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
						$this->Packfeature->save($packfeatures);
					}

					$subscriptiondata = $this->Subscription->find('all')->where(['Subscription.user_id' => $user['id'], 'Subscription.package_type' => 'RC'])->first();

					if (time() > strtotime($subscriptiondata['expiry_date'])) {
						$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'ASC'])->first();
						$packfeature_id = $packfeature['id'];
						$packfeature = $this->Packfeature->get($packfeature_id);
						$subscriptionid = $subscriptiondata['id'];
						$this->loadModel('RecuriterPack');
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
						$subscription = $this->Subscription->get($subscriptionid);
						$subscription_info['package_id'] = RECUITER_PACKAGE;
						$subscription_info['user_id'] = $user['id'];
						$subscription_info['package_type'] = "RC";
						$subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofprofile . " days"));
						$subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
						$subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
						$savedata = $this->Subscription->save($subscription_arr);
						$packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
						$this->Packfeature->save($packfeatures);
					}

					$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'ASC'])->first();
					$currentdat = strtotime(date('m/d/y'));
					$updatedate = strtotime($packfeature['applicationdate']);
					if ($currentdat != $updatedate) {
						$packappl = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'ASC'])->first();
						$pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => PROFILE_PACKAGE])->order(['Profilepack.id' => 'ASC'])->first();
						$packfeature_idappli = $packappl['id'];
						$packfeatureapplication = $this->Packfeature->get($packfeature_idappli);
						$application['number_job_application_daily'] = $pcakgeinformation['number_of_application_day'];
						$application['applicationdate'] = date('Y-m-d');
						$packfeaturesapp = $this->Packfeature->patchEntity($packfeatureapplication, $application);
						$result = $this->Packfeature->save($packfeaturesapp);
					}

					if (time() > strtotime($packfeature['non_telent_expire'])) {
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

						$packfeature_id = $packfeature['id'];
						$packfeature = $this->Packfeature->get($packfeature_id);
						$packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
						$this->Packfeature->save($packfeatures);
					}

					$blocked_expiry = strtotime($user['blocked_expiry']);
					$current_time = time();

					if ($blocked_expiry > $current_time) {
						$datediff = $blocked_expiry - $current_time;
						$blocked_days = round($datediff / (60 * 60 * 24));
						$this->Flash->error(__('Your Profile is Blocked for ' . $blocked_days . ' days'));
						return $this->redirect(['controller' => 'users', 'action' => 'login']);
					} else {
						if ($user['status'] == "Y") {
							$this->loadModel('Settings');
							$settingdetails = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->toarray();
							$session = $this->request->session();
							$session->write('settings', $settingdetails[0]);
							$user_id = $user['id'];
							$users = $this->Users->find('all')->where(['id' => $user_id])->first();
							$user_data['last_login'] = date('Y-m-d H:i:s', time());
							$users = $this->Users->patchEntity($users, $user_data);
							$updateuser = $this->Users->save($users);
							$this->Auth->setUser($user);
							$response['redirect_url'] = $this->Auth->redirectUrl();
						} else {
							$this->Flash->error(__('Your Profile is Deactivated by admin'));
							$response['redirect_url'] = 'http://bookanartiste.com/login';
						}
					}
				}
			} else {

				$randomPass = $this->generateRandomPassword(10);
				$this->request->data['cpassword'] = $randomPass;
				$this->request->data['password'] = $this->_setPassword($randomPass);
				$this->request->data['role_id'] = NONTALANT_ROLEID;
				$this->request->data['profilepack_id'] = PROFILE_PACKAGE;
				// $this->request->data['fbid'] = $this->request->data['fbid'];
				$this->request->data['isvarify'] = "Y";
				$this->request->data['status'] = "Y";
				$randomNumber = rand(1000, 9999);
				$user_activation_key = 'KEY-' . $randomNumber;
				$this->request->data['user_activation_key'] = $user_activation_key;
				// pr($this->request->data);exit;

				$department = $this->Users->patchEntity($users, $this->request->data);
				// pr($department);exit;
				if ($register = $this->Users->save($department)) {
					$user_id = $register->id;
					$this->assigndefaultpackage($user_id);

					if ($department['fbid']) {
						$profess = $register;
						$response['success'] = 1;
					} else {

						$this->loadmodel('Templates');
						$profile = $this->Templates->find('all')->where(['Templates.id' => REGISTRATION])->first();
						$subject = $profile['subject'];
						$from = $profile['from'];
						$fromname = $profile['fromname'];
						$to  = $email;
						$formats = $profile['description'];
						$site_url = SITE_URL;
						$message1 = str_replace(array('{Name}', '{Phone}', '{Email}', '{Password}', '{site_url}', '{Useractivation}'), array($register['user_name'], $phone, $email, $this->request->data['cpassword'], $site_url, $user_activation_key), $formats);
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
						</html>';

						$headers = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
						// $emailcheck = mail($to, $subject, $message, $headers);
						$profess = $this->Users->find('all')->where(['email' => $email])->first();
						$response['success'] = 1;
					}
					$profile = $this->Profile->newEntity();
					$this->request->data['name'] = $profess['user_name'];
					$this->request->data['user_id'] = $user_id;
					$this->request->data['phonecode'] = $this->request->data['phonecode'];
					$this->request->data['social'] = 1;
					$this->request->data['profile_image'] = $this->request->data['picture'];
					$profiles = $this->Profile->patchEntity($profile, $this->request->data);
					$this->Profile->save($profiles);

					$response['success'] = 1;
					if ($profess) {
						$this->Auth->setUser($profess);
						$response['redirect_url'] = $this->Auth->redirectUrl();
					}

					if ($profess) {
						$this->Auth->setUser($profess);
						$response['redirect_url'] = $this->Auth->redirectUrl();
					}
				}
			}

			$user_id =  $this->request->session()->read('Auth.User.id');
			$this->loadModel('Loginusercheck');
			$usersff = $this->Loginusercheck->find('all')->where(['user_id' => $user_id, 'ip' => $_SERVER['REMOTE_ADDR']])->count();
			if ($usersff > 0) {
				$loginusercheck = $this->Loginusercheck->find('all')->where(['user_id' => $user_id, 'ip' => $_SERVER['REMOTE_ADDR']])->first();
			} else {
				$loginusercheck = $this->Loginusercheck->newEntity();
			}
			$data_log['user_id'] = $user_id;
			$data_log['ip'] = $_SERVER['REMOTE_ADDR'];
			$option_arr_log = $this->Loginusercheck->patchEntity($loginusercheck, $data_log);
			$this->Loginusercheck->save($option_arr_log);
			// by rupam sir 
			// if ($response['redirect_url'] == '/') {
			// 	$response['redirect_url'] = 'http://bookanartiste.com/profile';
			// } else {
			// 	// $response['redirect_url'] = $this->Auth->redirectUrl();
			// 	$response['redirect_url'] = 'http://bookanartiste.com/profile';
			// }
			if (empty($response['redirect_url'])) {
				$response['redirect_url'] = 'http://bookanartiste.com/profile';
			} else {
				$response['redirect_url'] = $this->Auth->redirectUrl();
				// $response['redirect_url'] = 'http://bookanartiste.com/profile';
			}
			echo json_encode($response);
		}
		die;
	}

	public function bdnotification($id = null)
	{
		$this->loadModel('Contactrequest');
		$this->loadModel('Profile');
		$this->loadModel('Notification');
		if (!empty($id)) {
			$bduser = $this->Contactrequest->find('all')->where(['OR' => ['from_id' => $id, 'to_id' => $id], 'accepted_status' => 'Y'])->toarray();
			$currentdate = date("Y-m-d");
			foreach ($bduser as $value) {
				if ($value['from_id'] == $id) {
					$dob = $this->Profile->find('all')->select(['dob', 'user_id'])->where(['user_id' => $value['to_id']])->first();
					if (isset($dob)) {
						if (date("Y-m-d", strtotime($dob['dob'])) == $currentdate) {
							$senderid = $dob['user_id'];
							$recieverid = $id;
							$noti = $this->Notification->newEntity();
							$notification['notification_sender'] = $senderid;
							$notification['notification_receiver'] = $recieverid;
							$notification['type'] = "birthday";
							$notification = $this->Notification->patchEntity($noti, $notification);
							$this->Notification->save($notification);
						}
					}
				}
				if ($value['to_id'] == $id) {
					$dob = $this->Profile->find('all')->select(['dob', 'user_id'])->where(['user_id' => $value['from_id']])->first();
					if (isset($dob)) {
						if (date("Y-m-d", strtotime($dob['dob'])) == $currentdate) {
							$senderid = $dob['user_id'];
							$recieverid = $id;
							$noti = $this->Notification->newEntity();
							$notification['notification_sender'] = $senderid;
							$notification['notification_receiver'] = $recieverid;
							$notification['type'] = "birthday";
							$notification = $this->Notification->patchEntity($noti, $notification);
							$this->Notification->save($notification);
						}
					}
				}
			}
		}
		return true;
	}

	// public function logout()
	// {
	// 	$user = $this->Auth->user('id');
	// 	if ($this->Auth->logout()) {

	// 		$this->loadModel('Loginusercheck');
	// 		// $usersff = $this->Loginusercheck->find('all')->where(['user_id' => $user, 'ip' => $_SERVER['REMOTE_ADDR']])->first();
	// 		// $this->Loginusercheck->deleteAll(['Loginusercheck.id' => $usersff['id']]);
	// 		// new code loginusercheck delete the record
	// 		$usersff = $this->Loginusercheck->find('all')->where(['user_id' => $user, 'ip' => $_SERVER['REMOTE_ADDR']])->first();

	// 		if ($usersff) {
	// 			try {
	// 				$this->Loginusercheck->delete($usersff);
	// 				// or if deleteAll is preferred:
	// 				// $this->Loginusercheck->deleteAll(['id' => $usersff->id]);
	// 			} catch (\Exception $e) {
	// 				// Handle any errors that occur during deletion
	// 				echo "Error deleting record: " . $e->getMessage();
	// 			}
	// 		}
	// 		// end loginusercheck
	// 		// unset($_SESSION['jobquotesdata']);
	// 		// unset($_SESSION['jobapplicationdata']);
	// 		// unset($_SESSION['jobalertsdata']);
	// 		// unset($_SESSION['jobsearchdata']);
	// 		// unset($_SESSION['Auth']);
	// 		// unset($_SESSION['Flash']);
	// 		// unset($_SESSION['settings']);
	// 		// unset($_SESSION['usercheck']);
	// 		$session = $this->request->session();
	// 		$session->destroy();
	// 		// $session = $this->request->session();
	// 		// $session->delete('session');
	// 		return $this->redirect(['controller' => 'homes', 'action' => 'index']);
	// 	}
	// }

	// public function logout()
	// {
	// 	$this->loadModel('Loginusercheck');

	// 	$user = $this->Auth->user('id');

	// 	$log = $this->Auth->logout();
	// 	if ($log) {

	// 		$usersff = $this->Loginusercheck->find()->where(['user_id' => $user, 'ip' => $_SERVER['REMOTE_ADDR']])->first();

	// 		if ($usersff) {
	// 			try {
	// 				$deleteData = $this->Loginusercheck->delete($usersff);
	// 			} catch (\Exception $e) {
	// 				echo "Error deleting record: " . $e->getMessage();
	// 				die;
	// 			}
	// 		}
	// 		// Destroy session
	// 		$session = $this->request->session();
	// 		$session->destroy();
	// 		// Redirect to home page
	// 		return $this->redirect(['controller' => 'homes', 'action' => 'index']);
	// 	}
	// }

	// public function frontlogin()
	// {
	// 	$this->loadModel('Users');
	// 	$this->autoRender = false;
	// }


	// public function sociallogin()
	// {

	// 	$this->loadmodel('Users');
	// 	$this->loadmodel('Profile');
	// 	$this->loadmodel('Profilepack');
	// 	$this->loadmodel('Packfeature');
	// 	if ($this->request->is('post')) {
	// 		$users = $this->Users->newEntity();
	// 		$email = $this->request->data['email'];
	// 		$name = $this->request->data['name'];
	// 		$user = $this->Users->find('all')->where(['email' => $email])->first();
	// 		if ($user) {
	// 			if ($user && $user['role_id'] == NONTALANT_ROLEID || $user['role_id'] == TALANT_ROLEID) {
	// 				$this->loadModel('Subscription');
	// 				$this->loadModel('Profilepack');
	// 				$this->loadModel('Packfeature');
	// 				$this->loadModel('Subscription');

	// 				$subscriptiondata = $this->Subscription->find('all')->where(['Subscription.user_id' => $user['id'], 'Subscription.package_type' => 'PR'])->first();

	// 				if (time() > strtotime($subscriptiondata['expiry_date'])) {
	// 					$subscriptionid = $subscriptiondata['id'];
	// 					$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'ASC'])->first();
	// 					$packfeature_id = $packfeature['id'];
	// 					$packfeature = $this->Packfeature->get($packfeature_id);
	// 					$pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => PROFILE_PACKAGE])->order(['Profilepack.id' => 'ASC'])->first();
	// 					$feature_info['number_categories'] = $pcakgeinformation['number_categories'];
	// 					$feature_info['number_audio'] = $pcakgeinformation['number_audio'];
	// 					$feature_info['ask_for_quote_request_per_job'] = $pcakgeinformation['ask_for_quote_request_per_job'];
	// 					$feature_info['number_video'] = $pcakgeinformation['number_video'];
	// 					$feature_info['website_visibility'] = $pcakgeinformation['website_visibility'];
	// 					$feature_info['private_individual'] = $pcakgeinformation['private_individual'];
	// 					$feature_info['access_job'] = $pcakgeinformation['access_job'];
	// 					$feature_info['number_job_application'] = $pcakgeinformation['number_job_application'];
	// 					$feature_info['number_job_application_month'] = $pcakgeinformation['number_job_application'];
	// 					$feature_info['number_job_application_daily'] = $pcakgeinformation['number_of_application_day'];
	// 					$feature_info['number_of_quote_daily'] = $pcakgeinformation['number_of_quote_daily'];
	// 					$feature_info['number_search'] = $pcakgeinformation['number_search'];
	// 					$feature_info['ads_free'] = $pcakgeinformation['ads_free'];
	// 					$feature_info['number_albums'] = $pcakgeinformation['number_albums'];
	// 					$feature_info['message_folder'] = $pcakgeinformation['message_folder'];
	// 					$feature_info['privacy_setting_access'] = $pcakgeinformation['privacy_setting_access'];
	// 					$feature_info['access_to_ads'] = $pcakgeinformation['access_to_ads'];
	// 					$feature_info['number_of_jobs_alerts'] = $pcakgeinformation['number_of_jobs_alerts'];
	// 					$feature_info['number_of_introduction'] = $pcakgeinformation['number_of_introduction'];
	// 					$feature_info['number_of_intorduction_send'] = date("Y-m-d") . ',' . $pcakgeinformation['number_of_intorduction_send'];
	// 					$feature_info['search_of_other_profile'] = $pcakgeinformation['search_of_other_profile'];
	// 					$feature_info['nubmer_of_jobs_month'] = $pcakgeinformation['nubmer_of_jobs'];
	// 					$feature_info['introduction_sent'] = $pcakgeinformation['introduction_sent'];
	// 					$feature_info['profile_likes'] = $pcakgeinformation['profile_likes'];
	// 					$feature_info['job_alerts_month'] = $pcakgeinformation['job_alerts_month'];
	// 					$feature_info['job_alerts'] = $pcakgeinformation['job_alerts'];
	// 					$feature_info['packge'] = $pcakgeinformation['packge'];
	// 					$feature_info['page_id'] = $pcakgeinformation['page_id'];
	// 					$feature_info['persanalized_url'] = $pcakgeinformation['persanalized_url'];
	// 					$feature_info['number_of_free_quote_month'] = $pcakgeinformation['number_of_free_quote_month'];
	// 					$feature_info['number_of_free_day'] = $pcakgeinformation['number_of_free_day'];
	// 					$feature_info['number_of_free_job'] = $pcakgeinformation['number_of_free_job'];
	// 					$feature_info['number_of_booking'] = $pcakgeinformation['number_of_booking'];
	// 					$feature_info['number_of_introduction_recived'] = $pcakgeinformation['number_of_introduction_recived'];
	// 					$feature_info['number_of_photo'] = $pcakgeinformation['number_of_photo'];
	// 					$daysofprofile = $pcakgeinformation['validity_days'];
	// 					$this->loadModel('Subscription');
	// 					$subscription = $this->Subscription->get($subscriptionid);
	// 					$subscription_info['package_id'] = PROFILE_PACKAGE;
	// 					$subscription_info['user_id'] =  $user['id'];
	// 					$subscription_info['package_type'] = "P";
	// 					$subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofprofile . " days"));
	// 					$subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
	// 					$subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
	// 					$savedata = $this->Subscription->save($subscription_arr);
	// 					$packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
	// 					$this->Packfeature->save($packfeatures);
	// 				}

	// 				$subscriptiondata = $this->Subscription->find('all')->where(['Subscription.user_id' => $user['id'], 'Subscription.package_type' => 'RC'])->first();
	// 				if (time() > strtotime($subscriptiondata['expiry_date'])) {
	// 					$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'ASC'])->first();
	// 					$packfeature_id = $packfeature['id'];
	// 					$packfeature = $this->Packfeature->get($packfeature_id);
	// 					$subscriptionid = $subscriptiondata['id'];
	// 					$this->loadModel('RecuriterPack');
	// 					$pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y', 'RecuriterPack.id' => RECUITER_PACKAGE])->order(['RecuriterPack.id' => 'DESC'])->first();
	// 					$feature_info['number_of_job_post'] = $pcakgeinformation['number_of_job_post'];
	// 					$feature_info['number_of_job_simultancney'] = $pcakgeinformation['number_of_job_simultancney'];
	// 					$feature_info['nubmer_of_site'] = $pcakgeinformation['nubmer_of_site'];
	// 					$feature_info['number_of_message'] = $pcakgeinformation['number_of_message'];
	// 					$feature_info['number_of_contact_details'] = $pcakgeinformation['number_of_contact_details'];
	// 					$feature_info['number_of_talent_search'] = $pcakgeinformation['number_of_talent_search'];
	// 					$feature_info['lengthofpackage'] = $pcakgeinformation['lengthofpackage'];
	// 					$feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging'];
	// 					$feature_info['number_of_email'] = $pcakgeinformation['number_of_email'];
	// 					$feature_info['multipal_email_login'] = $pcakgeinformation['multipal_email_login'];
	// 					$daysofrecur = $pcakgeinformation['validity_days'];
	// 					$subscription = $this->Subscription->get($subscriptionid);
	// 					$subscription_info['package_id'] = RECUITER_PACKAGE;
	// 					$subscription_info['user_id'] = $user['id'];
	// 					$subscription_info['package_type'] = "RC";
	// 					$subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofprofile . " days"));
	// 					$subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
	// 					$subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
	// 					$savedata = $this->Subscription->save($subscription_arr);
	// 					$packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
	// 					$this->Packfeature->save($packfeatures);
	// 				}

	// 				$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'ASC'])->first();
	// 				$currentdat = strtotime(date('m/d/y'));
	// 				$updatedate = strtotime($packfeature['applicationdate']);
	// 				if ($currentdat != $updatedate) {
	// 					$packappl = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user['id']])->order(['Packfeature.id' => 'ASC'])->first();
	// 					$pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => PROFILE_PACKAGE])->order(['Profilepack.id' => 'ASC'])->first();
	// 					$packfeature_idappli = $packappl['id'];
	// 					$packfeatureapplication = $this->Packfeature->get($packfeature_idappli);
	// 					$application['number_job_application_daily'] = $pcakgeinformation['number_of_application_day'];
	// 					$application['applicationdate'] = date('Y-m-d');
	// 					$packfeaturesapp = $this->Packfeature->patchEntity($packfeatureapplication, $application);
	// 					$result = $this->Packfeature->save($packfeaturesapp);
	// 				}

	// 				if (time() > strtotime($packfeature['non_telent_expire'])) {
	// 					$this->loadModel('Settings');
	// 					$pcakgeinformation = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();
	// 					$feature_info['non_telent_number_of_audio'] = $pcakgeinformation['non_telent_number_of_audio'];
	// 					$feature_info['non_telent_number_of_video'] = $pcakgeinformation['non_telent_number_of_video'];
	// 					$feature_info['non_telent_number_of_album'] = $pcakgeinformation['non_telent_number_of_album'];
	// 					$feature_info['non_telent_number_of_folder'] = $pcakgeinformation['non_telent_number_of_folder'];
	// 					$feature_info['non_telent_number_of_jobalerts'] = $pcakgeinformation['non_telent_number_of_jobalerts'];
	// 					$feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging'];
	// 					$feature_info['non_telent_number_of_search_profile'] = $pcakgeinformation['non_telent_number_of_search_profile'];
	// 					$feature_info['	non_telent_number_of_private_message'] = $pcakgeinformation['	non_telent_number_of_private_message'];
	// 					$feature_info['non_telent_ask_quote'] = $pcakgeinformation['non_telent_ask_quote'];
	// 					$feature_info['non_telent_number_of_job_post'] = $pcakgeinformation['non_telent_number_of_job_post'];
	// 					$daysofnontalent = $pcakgeinformation['non_talent_validity_days'];
	// 					$feature_info['non_telent_expire'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofnontalent . " days"));
	// 					$packfeature_id = $packfeature['id'];
	// 					$packfeature = $this->Packfeature->get($packfeature_id);
	// 					$packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
	// 					$this->Packfeature->save($packfeatures);
	// 				}

	// 				$blocked_expiry = strtotime($user['blocked_expiry']);
	// 				$current_time = time();

	// 				if ($blocked_expiry > $current_time) {
	// 					$datediff = $blocked_expiry - $current_time;
	// 					$blocked_days = round($datediff / (60 * 60 * 24));
	// 					$this->Flash->error(__('Your Profile is Blocked for ' . $blocked_days . ' days'));
	// 					return $this->redirect(['controller' => 'users', 'action' => 'login']);
	// 				} else {
	// 					if ($user['status'] == "Y") {
	// 						$this->loadModel('Settings');
	// 						$settingdetails = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->toarray();
	// 						$session = $this->request->session();
	// 						$session->write('settings', $settingdetails[0]);
	// 						$user_id = $user['id'];
	// 						$users = $this->Users->find('all')->where(['id' => $user_id])->first();
	// 						$user_data['last_login'] = date('Y-m-d H:i:s', time());
	// 						$users = $this->Users->patchEntity($users, $user_data);
	// 						$updateuser = $this->Users->save($users);
	// 						$this->Auth->setUser($user);
	// 						$response['redirect_url'] = $this->Auth->redirectUrl();
	// 					} else {
	// 						$this->Flash->error(__('Your Profile is Deactivated by admin'));
	// 						$response['redirect_url'] = 'http://bookanartiste.com/login';
	// 					}
	// 				}
	// 			}
	// 		} else {
	// 			$this->request->data['password'] = $this->_setPassword('12345');
	// 			$this->request->data['cpassword'] = 12345;
	// 			$this->request->data['role_id'] = NONTALANT_ROLEID;
	// 			$this->request->data['profilepack_id'] = PROFILE_PACKAGE;
	// 			$this->request->data['status'] = "Y";
	// 			$department = $this->Users->patchEntity($users, $this->request->data);
	// 			if ($register = $this->Users->save($department)) {
	// 				$user_id = $register->id;
	// 				$pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => PROFILE_PACKAGE])->order(['Profilepack.id' => 'ASC'])->first();
	// 				$feature_info['number_categories'] = $pcakgeinformation['number_categories'];
	// 				$feature_info['number_audio'] = $pcakgeinformation['number_audio'];
	// 				$feature_info['number_video'] = $pcakgeinformation['number_video'];
	// 				$feature_info['website_visibility'] = $pcakgeinformation['website_visibility'];
	// 				$feature_info['private_individual'] = $pcakgeinformation['private_individual'];
	// 				$feature_info['access_job'] = $pcakgeinformation['access_job'];
	// 				$feature_info['number_job_application_month'] = $pcakgeinformation['number_job_application'];
	// 				$feature_info['number_job_application_daily'] = $pcakgeinformation['number_of_application_day'];
	// 				$feature_info['number_of_quote_daily'] = $pcakgeinformation['number_of_quote_daily'];
	// 				$feature_info['number_search'] = $pcakgeinformation['number_search'];
	// 				$feature_info['ads_free'] = $pcakgeinformation['ads_free'];
	// 				$feature_info['number_albums'] = $pcakgeinformation['number_albums'];
	// 				$feature_info['message_folder'] = $pcakgeinformation['message_folder'];
	// 				$feature_info['privacy_setting_access'] = $pcakgeinformation['privacy_setting_access'];
	// 				$feature_info['access_to_ads'] = $pcakgeinformation['access_to_ads'];
	// 				$feature_info['number_of_jobs_alerts'] = $pcakgeinformation['number_of_jobs_alerts'];
	// 				$feature_info['number_of_introduction'] = $pcakgeinformation['number_of_introduction'];
	// 				$feature_info['number_of_intorduction_send'] = date("Y-m-d") . ',' . $pcakgeinformation['number_of_intorduction_send'];
	// 				$feature_info['search_of_other_profile'] = $pcakgeinformation['search_of_other_profile'];
	// 				$feature_info['nubmer_of_jobs_month'] = $pcakgeinformation['nubmer_of_jobs'];
	// 				$introsentdaycheck = explode(",", $packfeature['introduction_sent']);
	// 				if ($introsentdaycheck[0] != date("Y-m-d")) {
	// 					$feature_info['introduction_sent'] = date("Y-m-d") . ',' . $pcakgeinformation['introduction_sent'];
	// 				} else {
	// 					$feature_info['introduction_sent'] = $packfeature['introduction_sent'];
	// 				}
	// 				$feature_info['profile_likes'] = $pcakgeinformation['profile_likes'];
	// 				$feature_info['job_alerts_month'] = $pcakgeinformation['job_alerts_month'];
	// 				$feature_info['job_alerts'] = $pcakgeinformation['job_alerts'];
	// 				$feature_info['packge'] = $pcakgeinformation['packge'];
	// 				$feature_info['page_id'] = $pcakgeinformation['page_id'];
	// 				$feature_info['persanalized_url'] = $pcakgeinformation['persanalized_url'];
	// 				$feature_info['number_of_free_quote_month'] = $pcakgeinformation['number_of_free_quote_month'];
	// 				$feature_info['number_of_free_day'] = $pcakgeinformation['number_of_free_day'];
	// 				$feature_info['ask_for_quote_request_per_job'] = $pcakgeinformation['ask_for_quote_request_per_job'];
	// 				$feature_info['number_of_free_job'] = $pcakgeinformation['number_of_free_job'];
	// 				$feature_info['number_of_booking'] = $pcakgeinformation['number_of_booking'];
	// 				$feature_info['number_of_introduction_recived'] = $pcakgeinformation['number_of_introduction_recived'];
	// 				$feature_info['number_of_photo'] = $pcakgeinformation['number_of_photo'];
	// 				$daysofprofile = $pcakgeinformation['validity_days'];
	// 				$this->loadModel('Subscription');
	// 				$subscription = $this->Subscription->newEntity();
	// 				$subscription_info['package_id'] = PROFILE_PACKAGE;
	// 				$subscription_info['user_id'] =  $user_id;
	// 				$subscription_info['package_type'] = "PR";
	// 				$subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofprofile . " days"));
	// 				$subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
	// 				$subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
	// 				$savedata = $this->Subscription->save($subscription_arr);
	// 				$this->loadModel('RecuriterPack');
	// 				$pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y', 'RecuriterPack.id' => RECUITER_PACKAGE])->order(['RecuriterPack.id' => 'DESC'])->first();
	// 				$feature_info['number_of_job_post'] = $pcakgeinformation['number_of_job_post'];
	// 				$feature_info['number_of_job_simultancney'] = $pcakgeinformation['number_of_job_simultancney'];
	// 				$feature_info['nubmer_of_site'] = $pcakgeinformation['nubmer_of_site'];
	// 				$feature_info['number_of_message'] = $pcakgeinformation['number_of_message'];
	// 				$feature_info['number_of_contact_details'] = $pcakgeinformation['number_of_contact_details'];
	// 				$feature_info['number_of_talent_search'] = $pcakgeinformation['number_of_talent_search'];
	// 				$feature_info['lengthofpackage'] = $pcakgeinformation['lengthofpackage'];
	// 				$feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging'];
	// 				$feature_info['number_of_email'] = $pcakgeinformation['number_of_email'];
	// 				$feature_info['multipal_email_login'] = $pcakgeinformation['multipal_email_login'];
	// 				$daysofrecur = $pcakgeinformation['validity_days'];
	// 				$subscription = $this->Subscription->newEntity();
	// 				$subscription_info['package_id'] = RECUITER_PACKAGE;
	// 				$subscription_info['user_id'] =  $user_id;
	// 				$subscription_info['package_type'] = "RC";
	// 				$subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofprofile . " days"));
	// 				$subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
	// 				$subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
	// 				$savedata = $this->Subscription->save($subscription_arr);
	// 				$this->loadModel('Settings');
	// 				$pcakgeinformation = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();
	// 				$feature_info['non_telent_number_of_audio'] = $pcakgeinformation['non_telent_number_of_audio'];
	// 				$feature_info['user_id'] = $user_id;
	// 				$feature_info['non_telent_number_of_video'] = $pcakgeinformation['non_telent_number_of_video'];
	// 				$feature_info['non_telent_number_of_album'] = $pcakgeinformation['non_telent_number_of_album'];
	// 				$feature_info['non_telent_number_of_folder'] = $pcakgeinformation['non_telent_number_of_folder'];
	// 				$feature_info['non_telent_number_of_jobalerts'] = $pcakgeinformation['non_telent_number_of_jobalerts'];
	// 				$feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging'];
	// 				$feature_info['non_telent_number_of_search_profile'] = $pcakgeinformation['non_telent_number_of_search_profile'];
	// 				$feature_info['	non_telent_number_of_private_message'] = $pcakgeinformation['	non_telent_number_of_private_message'];
	// 				$feature_info['non_telent_ask_quote'] = $pcakgeinformation['non_telent_ask_quote'];
	// 				$feature_info['non_telent_number_of_job_post'] = $pcakgeinformation['non_telent_number_of_job_post'];
	// 				$daysofnontalent = $pcakgeinformation['non_talent_validity_days'];
	// 				$feature_info['non_telent_expire'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofnontalent . " days"));
	// 				$packfeature = $this->Packfeature->newEntity();
	// 				$packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
	// 				$this->Packfeature->save($packfeatures);
	// 				$profile = $this->Profile->newEntity();
	// 				$profess = $this->Users->find('all')->select(['id', 'user_name'])->where(['id' => $user_id])->first();
	// 				$this->request->data['name'] = $profess['user_name'];
	// 				$this->request->data['user_id'] = $user_id;
	// 				$this->request->data['phonecode'] = $this->request->data['phonecode'];
	// 				$this->request->data['social'] = 1;
	// 				$this->request->data['profile_image'] = $this->request->data['picture'];
	// 				$profiles = $this->Profile->patchEntity($profile, $this->request->data);
	// 				$profess = $this->Users->find('all')->where(['email' => $email])->first();
	// 				$this->Profile->save($profiles);
	// 				$response['success'] = 1;
	// 				if ($profess) {
	// 					$this->Auth->setUser($profess);
	// 					$response['redirect_url'] = $this->Auth->redirectUrl();
	// 				}
	// 			}
	// 		}
	// 		$user_id =  $this->request->session()->read('Auth.User.id');
	// 		$this->loadModel('Loginusercheck');
	// 		$usersff = $this->Loginusercheck->find('all')->where(['user_id' => $user_id, 'ip' => $_SERVER['REMOTE_ADDR']])->count();
	// 		if ($usersff > 0) {
	// 			$loginusercheck = $this->Loginusercheck->find('all')->where(['user_id' => $user_id, 'ip' => $_SERVER['REMOTE_ADDR']])->first();
	// 		} else {
	// 			$loginusercheck = $this->Loginusercheck->newEntity();
	// 		}
	// 		$data_log['user_id'] = $user_id;
	// 		$data_log['ip'] = $_SERVER['REMOTE_ADDR'];
	// 		$option_arr_log = $this->Loginusercheck->patchEntity($loginusercheck, $data_log);
	// 		$this->Loginusercheck->save($option_arr_log);
	// 		if ($response['redirect_url'] == '/') {
	// 			$response['redirect_url'] = 'http://bookanartiste.com/profile';
	// 		} else {
	// 			$response['redirect_url'] = $this->Auth->redirectUrl();
	// 		}
	// 		echo json_encode($response);
	// 	}
	// 	die;
	// }
}
