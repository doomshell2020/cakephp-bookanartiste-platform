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


class MessageController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['privacy', 'termsandconditions', 'messagesnoti','sendmessage']);
	}

	// Sending job message to user from profile. 
	public function sendjobmessage($jobid = '')
	{
		$this->set('jobid', $jobid);
	}

	// Rupam 1 Feb 2025
	// public function sendmessage($userid = null)
	// {
	// 	$this->loadModel('Contactrequest');
	// 	$this->loadModel('Messages');
	// 	$id = $this->request->session()->read('Auth.User.id');
	// 	$role_id = $this->request->session()->read('Auth.User.role_id');
	// 	$error = null;

	// 	$packfeature = $this->activePackage('RC');

	// 	if (!$packfeature) {
	// 		$error = 'No active package found. Please purchase a package to send messages.';
	// 		$this->set('error', $error);
	// 		return;
	// 	}

	// 	$connect_status = $this->Contactrequest->find()
	// 		->where(['from_id' => $id, 'to_id' => $userid])
	// 		->select(['accepted_status'])
	// 		->first();

	// 	// Not a friend
	// 	if ($connect_status['accepted_status'] == 'N' || empty($connect_status)) {

	// 		if ($packfeature['Monthly_new_talent_messaging'] == 'Y') {
	// 			// Set message limit based on role
	// 			$message_limit = ($role_id == NONTALANT_ROLEID)
	// 				? $packfeature['non_telent_number_of_private_message']  // Non-Talent message limit
	// 				: $packfeature['number_of_message']; // Regular message limit

	// 			$number_of_message = ($role_id == NONTALANT_ROLEID)
	// 				? $packfeature['non_telent_number_of_private_message_used']
	// 				: $packfeature['number_of_message_used'];
	// 		} else {

	// 			$error = 'You are not eligible to send messages. Please upgrade your package to send  messages';
	// 			$this->set('error', $error);
	// 			return;
	// 		}


	// 		$startOfMonth = date('Y-m-01 00:00:00');
	// 		$endOfMonth = date('Y-m-t 23:59:59');

	// 		// Count messages sent this month by the user
	// 		$messageCount = $this->Messages->find()
	// 			->where([
	// 				'from_id' => $id,
	// 				'created >=' => $startOfMonth,
	// 				'created <=' => $endOfMonth
	// 			])
	// 			->count();

	// 		// Check if message limit is reached
	// 		if ($message_limit == 0) {
	// 			$error = 'You have 0 messages assinged to this packages.';
	// 			$this->set('error', $error);
	// 		} else if ($message_limit <= $messageCount) {
	// 			$error = 'Monthly message limit reached. You can send more messages next month.';
	// 			$this->set('error', $error);
	// 			return;
	// 		} else if ($number_of_message >= $message_limit) {
	// 			$error = 'Message limit reached. You can send messages to more talent in the next month.';
	// 			$this->set('error', $error);
	// 			return;
	// 		}
	// 	}


	// 	$this->loadModel('Users');
	// 	$userdetails = $this->Users->find('all')->where(['Users.id' => $userid])->first();
	// 	$this->set('userdetails', $userdetails);
	// 	$this->set('userid', $userid);

	// 	if ($this->request->is(['post', 'put'])) {

	// 		// pr(date('Y-m-d h:i:s'));exit;

	// 		// pr($this->request->data);
	// 		// exit;

	// 		$userid = $this->request->data['userid'];
	// 		$description = $this->request->data['message'];
	// 		$subject = $this->request->data['subject'];

	// 		// Validation for empty fields
	// 		if (empty($description) || empty($userid) || empty($subject)) {
	// 			echo json_encode(['status' => 0, 'error' => 'Please fill all fields']);
	// 			die;
	// 		}

	// 		$packfeature_id = $packfeature['id'];

	// 		// Set message limit based on role
	// 		$message_limit = ($role_id == NONTALANT_ROLEID)
	// 			? $packfeature['non_telent_number_of_private_message']  // Non-Talent message limit
	// 			: $packfeature['number_of_message']; // Regular message limit

	// 		$number_of_message = ($role_id == NONTALANT_ROLEID)
	// 			? $packfeature['non_telent_number_of_private_message_used']
	// 			: $packfeature['number_of_message_used'];

	// 		// Check if message limit is reached
	// 		if ($number_of_message >= $message_limit) {
	// 			echo json_encode(['status' => 0, 'error' => 'Message limit reached. You can send messages to more talent in the next month.']);
	// 			die;
	// 		}

	// 		// Load Packfeature model
	// 		$packfeature = $this->Packfeature->get($packfeature_id);
	// 		$feature_info = [];

	// 		if ($role_id == NONTALANT_ROLEID) {
	// 			$feature_info['non_telent_number_of_private_message_used'] = $number_of_message + 1;
	// 		} else {
	// 			$feature_info['number_of_message_used'] = $number_of_message + 1;
	// 		}

	// 		// Update message count
	// 		$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
	// 		$this->Packfeature->save($features_arr);

	// 		// Save Message
	// 		$mentity = $this->Messages->newEntity();

	// 		$message_data = [
	// 			'from_id' => $id,
	// 			'to_id' => $userid,
	// 			'subject' => $subject,
	// 			'description' => $description,
	// 			'to_box' => 'I',
	// 			'from_box' => 'S',
	// 			// 'created' => date('Y-m-d H:i:s')
	// 		];
	// 		// pr($message_data);exit;

	// 		$message_arr = $this->Messages->patchEntity($mentity, $message_data);
	// 		$savedata = $this->Messages->save($message_arr);

	// 		if ($savedata) {
	// 			$message_id = $savedata->id;
	// 			$mentity = $this->Messages->get($message_id);
	// 			$message_arr = $this->Messages->patchEntity($mentity, ['thread_id' => $message_id]);
	// 			$this->Messages->save($message_arr);
	// 		}

	// 		echo json_encode(['status' => 1, 'error_text' => '']);
	// 		die;
	// 	}
	// }

	public function sendmessage($userid = null)
	{
		$this->loadModel('Contactrequest');
		$this->loadModel('Messages');
		$this->loadModel('Users');
		$this->loadModel('Packfeature');

		$id = $this->request->session()->read('Auth.User.id');
		$role_id = $this->request->session()->read('Auth.User.role_id');

		if (empty($id)) {
			echo 'You are not logged in';
			die;
		}

		// ✅ If user ID is not passed via URL, get it from POST data
		if (!$userid && $this->request->is(['post', 'put'])) {
			$userid = $this->request->data['userid'];
		}

		$this->set('userid', $userid);
		$this->set('userdetails', $this->Users->find()->where(['Users.id' => $userid])->first());

		// Friend check (pre-check)
		$connect_status = $this->Contactrequest->find()
			->where([
				'OR' => [
					['from_id' => $id, 'to_id' => $userid],
					['from_id' => $userid, 'to_id' => $id]
				]
			])
			->select(['accepted_status'])
			->first();

		// pr($connect_status);exit;
		$isFriend = ($connect_status && $connect_status['accepted_status'] == 'Y');

		// If not friend, run pre-check for limits
		if (!$isFriend) {
			$packfeature = $this->activePackage('RC');

			if (!$packfeature) {
				$this->set('error', 'No active package found. Please purchase a package to send messages.');
				return;
			}

			if ($packfeature['Monthly_new_talent_messaging'] != 'Y') {
				$this->set('error', 'You are not eligible to send messages. Please upgrade your package to send  messages');
				return;
			}

			$message_limit = ($role_id == NONTALANT_ROLEID)
				? $packfeature['non_telent_number_of_private_message']
				: $packfeature['number_of_message'];

			$startOfMonth = date('Y-m-01 00:00:00');
			$endOfMonth = date('Y-m-t 23:59:59');

			$messageCount = $this->Messages->find()
				->where([
					'is_friendshiptime_msg' => 'N',
					'from_id' => $id,
					'created >=' => $startOfMonth,
					'created <=' => $endOfMonth
				])
				->count();
			// pr($messageCount);exit;

			if ($message_limit == 0 || $messageCount >= $message_limit) {
				$this->set('error', 'Message limit reached. You can send messages to more talent in the next month.');
				return;
			}
		}

		// Now process POST
		if ($this->request->is(['post', 'put'])) {
			$description = $this->request->data['message'];
			$subject = $this->request->data['subject'];

			// pr($this->request->data);
			// exit;

			if (empty($description) || empty($userid) || empty($subject)) {
				echo json_encode(['status' => 0, 'error' => 'Please fill all fields']);
				die;
			}

			// Not a friend? Check again for limit and update usage
			if (!$isFriend) {
				$packfeature = $this->activePackage('RC');
				$message_limit = ($role_id == NONTALANT_ROLEID)
					? $packfeature['non_telent_number_of_private_message']
					: $packfeature['number_of_message'];

				$number_of_message = ($role_id == NONTALANT_ROLEID)
					? $packfeature['non_telent_number_of_private_message_used']
					: $packfeature['number_of_message_used'];

				$startOfMonth = date('Y-m-01 00:00:00');
				$endOfMonth = date('Y-m-t 23:59:59');

				$messageCount = $this->Messages->find()
					->where([
						'is_friendshiptime_msg' => 'N',
						'from_id' => $id,
						'created >=' => $startOfMonth,
						'created <=' => $endOfMonth
					])
					->count();

				if ($message_limit == 0 || $messageCount >= $message_limit || $number_of_message >= $message_limit) {
					echo json_encode(['status' => 0, 'error' => 'Message limit reached. You can send messages to more talent in the next month.']);
					die;
				}

				// Update message usage count
				$packfeatureEntity = $this->Packfeature->get($packfeature['id']);
				if ($role_id == NONTALANT_ROLEID) {
					$packfeatureEntity->non_telent_number_of_private_message_used = $number_of_message + 1;
				} else {
					$packfeatureEntity->number_of_message_used = $number_of_message + 1;
				}
				$this->Packfeature->save($packfeatureEntity);
			}

			// ✅ Set message flag based on friendship status
			$isFriendFlag = $isFriend ? 'Y' : 'N';

			// Save message
			$messageEntity = $this->Messages->newEntity([
				'from_id' => $id,
				'to_id' => $userid,
				'subject' => $subject,
				'description' => $description,
				'to_box' => 'I',
				'from_box' => 'S',
				'is_friendshiptime_msg' => $isFriendFlag
			]);

			if ($this->Messages->save($messageEntity)) {
				$messageEntity->thread_id = $messageEntity->id;
				$this->Messages->save($messageEntity);
			}

			echo json_encode(['status' => 1, 'error' => '']);
			die;
		}
	}




	// Sending message to user from profile. 
	public function sendmessagev1($userid = '')
	{
		//echo "test"; die;
		$id = $this->request->session()->read('Auth.User.id');
		$role_id = $this->request->session()->read('Auth.User.role_id');
		//$uid = $this->request->session()->read('Auth.User.id');
		if ($this->request->is(['post', 'put'])) {

			// pr($this->request->data);
			// die;
			$userid = $this->request->data['userid'];
			$description = $this->request->data['message'];
			$subject = $this->request->data['subject'];
			$jobid = $this->request->data['jobid'];

			// validation here implemnt if empty then return 
			if (empty($description) || empty($userid) || empty($subject)) {
				$response['status'] = 0;
				$response['error'] = 'Please fill all fields';
				echo json_encode($response);
				die;
			}

			$packfeature = $this->activePackage('RC');


			$this->loadModel('Messages');
			$this->loadModel('Contactrequest');
			$this->loadModel('JobApplication');
			$mentity = $this->Messages->newEntity();


			$message_data['from_id'] = $id;
			$message_data['to_id'] = $userid;
			$message_data['subject'] = $subject;
			$message_data['description'] = $description;
			$message_data['to_box'] = 'I';
			$message_data['from_box'] = 'S';
			$message_arr = $this->Messages->patchEntity($mentity, $message_data);
			$savedata = $this->Messages->save($message_arr);
			$message_id = $savedata->id;
			// Saving message thread id
			$mentity = $this->Messages->get($message_id);
			$message_datathread['thread_id'] = $message_id;
			$message_arr = $this->Messages->patchEntity($mentity, $message_datathread);
			$savedata = $this->Messages->save($message_arr);



			$elegibility = $this->checkmessageeligibility($userid);

			if ($elegibility['package_type'] == 'RC') {
				$this->loadModel('Packfeature');
				$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();
				$packfeature_id = $packfeature['id'];
				$number_of_message = $packfeature['number_of_message'];

				$packfeature = $this->Packfeature->get($packfeature_id);
				$feature_info['number_of_message'] = $number_of_message - 1;
				$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
				$this->Packfeature->save($features_arr);
			} else if ($elegibility['package_type'] == 'NT') {
				$this->loadModel('Packfeature');
				$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();
				$packfeature_id = $packfeature['id'];
				$number_of_message = $packfeature['non_telent_number_of_private_message'];
				$packfeature = $this->Packfeature->get($packfeature_id);
				$check_in_contact = $this->Contactrequest->find('all')->where(['Contactrequest.from_id' => $userid, 'Contactrequest.to_id' => $id])->count();
				$requirementfeatured = $this->JobApplication->find('all')->where(['JobApplication.job_id' => 'Y', 'JobApplication.talent_accepted_status' => 'Y', 'JobApplication.job_id' => $jobid])->count();
				$check_job_application = $this->Contactrequest->find('all')->where(['Contactrequest.from_id' => $userid, 'Contactrequest.to_id' => $id])->count();
				if ($check_in_contact <= 0 || $check_job_application <= 0) {
					$feature_info['non_telent_number_of_private_message'] = $number_of_message - 1;
				}

				$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
				$this->Packfeature->save($features_arr);
			}
			$response['status'] = "1";
			$response['error_text'] = "";
			echo json_encode($response);
			die;
		} else {
			$elegibility = $this->checkmessageeligibility($userid);
			$sent_message = 1;
			if ($userid == 0) {
				$this->set('error', $elegibility['error']);
			} else {
				if ($elegibility['sent_message'] == 0) {
					$this->set('error', $elegibility['error']);
				}
			}
			if ($elegibility['sent_message'] == 1) {
				$this->loadModel('Users');
				$userdetails = $this->Users->find('all')->where(['Users.id' => $userid])->first();
				$this->set('userdetails', $userdetails);
				$this->set('userid', $userid);
			} else {
				$this->set('error', $elegibility['error']);
			}
		}
	}

	function checkmessageeligibility($userid)
	{
		$response['sent_message'] = 0;
		$response['error'] = '';
		$response['package_type'] = '';
		$id = $this->request->session()->read('Auth.User.id');
		$role_id = $this->request->session()->read('Auth.User.role_id');
		// pr($role_id);exit;
		$this->loadModel('Requirement');
		$this->loadModel('JobQuote');
		$this->loadModel('JobApplication');
		$this->loadModel('Packfeature');
		// checking friend.
		$conn = ConnectionManager::get('default');
		$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.to_id='" . $userid . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.from_id='" . $userid . "' and c.accepted_status='Y'";
		$stmt = $conn->execute($fquery);
		$friends = $stmt->fetchAll('assoc');
		// pr($friends);exit;

		$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();
		$packfeature_id = $packfeature['id'];
		$number_of_message = $packfeature['non_telent_number_of_private_message'];

		$monthly_of_messagenewtalent = $packfeature['Monthly_new_talent_messaging'];
		if ($role_id == NONTALANT_ROLEID) {
			// add 3 variable 20/04/24
			$current_user_id = $this->Auth->user('id');
			$profile_id = $userid;
			$job_array = array();
			// end
			$job_quotes = 0;
			$jobapplication = 0;
			$requirementfeatured = $this->Requirement->find('list')->contain([])->where(['Requirement.user_id' => $current_user_id])->order(['Requirement.id' => 'DESC'])->toarray();
			// pr(    $requirementfeatured);exit;
			$this->set('requirementfeatured', $requirementfeatured);
			foreach ($requirementfeatured as $jobkey => $value) {
				$job_array[] = $jobkey;
			}
			if (count($job_array) > 0) {
				//$jobposts = 
				$job_quotes = $this->JobQuote->find('all')->where(['JobQuote.job_id IN' => $job_array, 'JobQuote.user_id' => $profile_id])->count();
				$jobapplication = $this->JobApplication->find('all')->where(['JobApplication.job_id IN' => $job_array, 'JobApplication.user_id' => $profile_id])->count();
			}

			// if($job_quotes > 0 || $jobapplication > 0 || count($friends) > 0 || $number_of_message > 0 && $monthly_of_messagenewtalent =='Y' )
			if ($job_quotes > 0 || $jobapplication > 0 || count($friends) > 0 || $number_of_message > 0 && $monthly_of_messagenewtalent == 'Y' &&  $requirementfeatured == !"") {
				$response['sent_message'] = 1;
				//	pr($number_of_message)."test"; die;
				if ($number_of_message > 0) {
					$response['package_type'] = 'NT';
				}
			} else {
				$response['sent_message'] = 0;
				$response['error'] = 'You cannot send any more messages to non connections. Please upgrade your membership';
			}
		} else {
			// checking friend.
			$conn = ConnectionManager::get('default');
			$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.to_id='" . $userid . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.from_id='" . $userid . "' and c.accepted_status='Y'";
			$stmt = $conn->execute($fquery);
			$friends = $stmt->fetchAll('assoc');
			// add 3 variable 20/04/24
			$current_user_id = $this->Auth->user('id');
			// pr($current_user_id);exit;
			$profile_id = $userid;

			$job_array = array();
			// end
			// Checking quotes and application
			$job_quotes = 0;
			$jobapplication = 0;
			$requirementfeatured = $this->Requirement->find('list')->contain([])->where(['Requirement.user_id' => $current_user_id])->order(['Requirement.id' => 'DESC'])->toarray();
			$this->set('requirementfeatured', $requirementfeatured);
			foreach ($requirementfeatured as $jobkey => $value) {
				$job_array[] = $jobkey;
			}
			if (count($job_array) > 0) {
				$job_quotes = $this->JobQuote->find('all')->where(['JobQuote.job_id IN' => $job_array, 'JobQuote.user_id' => $profile_id])->count();
				$jobapplication = $this->JobApplication->find('all')->where(['JobApplication.job_id IN' => $job_array, 'JobApplication.user_id' => $profile_id])->count();
			}


			$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();
			// pr($packfeature);exit;
			$packfeature_id = $packfeature['id'];
			$number_of_message = $packfeature['number_of_message'];
			$monthly_of_messagenewtalent = $packfeature['Monthly_new_talent_messaging'];

			if ($job_quotes > 0 || $jobapplication > 0 || count($friends) > 0 || $number_of_message > 0 && $monthly_of_messagenewtalent == 'Y') {
				$response['sent_message'] = 1;
				if ($number_of_message > 0) {
					$response['package_type'] = 'RC';
				}
			} else {
				$response['sent_message'] = 0;
				$response['error'] = 'You cannot send any more messages to non connections. Please upgrade your membership';
			}
		}
		return $response;
	}

	public function messagesnoti()
	{
		$this->loadModel('Messages');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		// $this->autoRender = false;

		$uid = $this->request->session()->read('Auth.User.id');
		$notifications = $this->Messages->find('all')
			->contain(['Users' => ['Profile']])
			->where(['to_id' => $uid, 'to_viewed_status' => 'N'])
			->toarray();

		$this->set('messages', $notifications);

		// update all message where to_id = $uid update to_viewed_status = Y 
		$this->Messages->updateAll(
			['to_viewed_status' => 'Y'],
			array('to_id' => $uid)
		);

		// $users = TableRegistry::get('Messages');
		// $status = "Y";
		// $con = ConnectionManager::get('default');
		// $detail = 'UPDATE `messages` SET `to_viewed_status` ="' . $status . '" WHERE `messages`.`to_id` = ' . $uid;
		// $results = $con->execute($detail);
	}


	// Inbox Rupam 1 Feb 2025
	public function inbox($type = null)
	{
		$uid = $this->request->session()->read('Auth.User.id');

		if (!$uid) {
			$this->Flash->error(__('User not authenticated.'));
			return $this->redirect(['controller' => 'Users', 'action' => 'login']);
		}

		$this->loadModel('Messages');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Messagegroup');

		// Base SQL Query
		$query = "SELECT 
                m.*, 
                (SELECT COUNT(*) FROM messages WHERE thread_id = m.thread_id GROUP BY thread_id) AS total, 
                tu.user_name AS to_name, 
                tp.profile_image AS to_image, 
                tu.email AS to_email, 
                fu.user_name AS from_name, 
                fp.profile_image AS from_image, 
                fu.email AS from_email 
              FROM messages m 
              LEFT JOIN users tu ON tu.id = m.to_id 
              LEFT JOIN users fu ON fu.id = m.from_id 
              LEFT JOIN personal_profile tp ON tu.id = tp.user_id 
              LEFT JOIN personal_profile fp ON fu.id = fp.user_id 
              WHERE m.to_id = :uid AND m.to_box = 'I'";

		// Add read/unread filter if provided
		if ($type === 'r') {
			$query .= " AND m.read_status = 'Y'";
		} elseif ($type === 'u') {
			$query .= " AND m.read_status = 'N'";
		}

		$query .= " GROUP BY m.thread_id ORDER BY m.created DESC";

		// Execute Query Securely Using Bind Parameters
		$conn = ConnectionManager::get('default');
		$stmt = $conn->prepare($query);
		$stmt->bindValue('uid', $uid, 'integer');
		$stmt->execute();
		$messages = $stmt->fetchAll('assoc');

		// pr($messages);exit;

		// Fetch Folder List
		$folders = $this->Messagegroup->find()
			->where(['user_id' => $uid])
			->toArray();
		// Pass Data to View
		$this->set(compact('messages', 'folders'));
	}




	// Inbox
	// public function inbox($type = null)
	// {
	// 	//	echo $type; die;
	// 	$uid = $this->request->session()->read('Auth.User.id');
	// 	$where = " where 1=1 ";
	// 	if ($type == 'r') {
	// 		$where .= " and m.read_status= 'Y'";
	// 	} elseif ($type == 'u') {
	// 		$where .= " and m.read_status = 'N'";
	// 	}

	// 	$where .= " and m.to_id = '" . $uid . "'";
	// 	$where .= " and m.to_box = 'I'";
	// 	//$condition['to_id'] = $uid;
	// 	//$condition['to_box'] = 'I';

	// 	$this->loadModel('Messages');
	// 	$this->loadModel('Users');
	// 	$this->loadModel('Profile');

	// 	$conn = ConnectionManager::get('default');
	// 	$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where . " group by m.thread_id order by created DESC";
	// 	//echo $message_qry; die;
	// 	$message_qe = $conn->execute($message_qry);
	// 	$messages = $message_qe->fetchAll('assoc');
	// 	pr($messages );exit;
	// 	$this->set('messages', $messages);

	// 	// Folder list
	// 	$uid = $this->request->session()->read('Auth.User.id');
	// 	$this->loadModel('Messagegroup');
	// 	$folders = $this->Messagegroup->find('all')->where(['user_id' => $uid])->toarray();
	// 	$this->set('folders', $folders);
	// }

	// Draft
	public function draft()
	{
		$this->loadModel('Messages');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$uid = $this->request->session()->read('Auth.User.id');
		//$messages = $this->Messages->find('all')->contain(['Users'=>['Profile']])->where(['from_id' => $uid,'from_box'=>'D'])->group('Messages.thread_id')->toarray();
		//$this->set('messages',$messages);
		$where = " where 1=1 ";
		$where .= " and m.from_id = '" . $uid . "'";
		$where .= " and m.from_box = 'D'";

		$conn = ConnectionManager::get('default');
		$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where . " group by m.thread_id";
		$message_qe = $conn->execute($message_qry);
		$messages = $message_qe->fetchAll('assoc');
		$this->set('messages', $messages);
	}

	// Sendbox
	public function sentbox()
	{
		$this->loadModel('Messages');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$uid = $this->request->session()->read('Auth.User.id');
		$where = " where 1=1 ";
		$where .= " and m.from_id = '" . $uid . "'";
		$where .= " and m.from_box = 'S'";
		$where .= " and m.grouptype = 0";

		$conn = ConnectionManager::get('default');
		$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where . " group by m.thread_id";
		$message_qe = $conn->execute($message_qry);
		$messages = $message_qe->fetchAll('assoc');
		$this->set('messages', $messages);

		// Folder list
		$uid = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Messagegroup');
		$folders = $this->Messagegroup->find('all')->where(['user_id' => $uid])->toarray();
		$this->set('folders', $folders);
	}

	// Starting new thread
	public function compose($type = null, $messageid = null)
	{
		$userid = $this->request->session()->read('Auth.User.id');
		if ($this->request->is(['post', 'put'])) {

			// pr($tthis->request->data); die;
			$elegibility = $this->checkmessageeligibility($userid);
			// pr($elegibility); die;
			if ($elegibility['sent_message'] != 0) {
				$this->loadModel('Messages');
				$message_id = $this->request->data['message_id'];
				$to_id = $this->request->data['to_id'];
				$subject = $this->request->data['subject'];
				$description = $this->request->data['description'];

				$elegibility = $this->checkmessageeligibility($userid);

				if ($message_id > 0) {
					$mentity = $this->Messages->get($message_id);
				} else {
					$mentity = $this->Messages->newEntity();
				}
				$message_data['from_id'] = $userid;
				$message_data['to_id'] = $to_id;
				$message_data['subject'] = $subject;
				$message_data['description'] = $description;
				$message_data['to_box'] = 'I';
				$message_data['from_box'] = 'S';
				$message_arr = $this->Messages->patchEntity($mentity, $message_data);
				$savedata = $this->Messages->save($message_arr);

				$message_id = $savedata->id;

				// Saving mesage thread id
				$mentity = $this->Messages->get($message_id);
				$message_data['thread_id'] = $message_id;
				if (!empty($this->request->data['thread_id'])) {
					$message_data['thread_id'] = $this->request->data['thread_id'];
				}


				$message_arr = $this->Messages->patchEntity($mentity, $message_data);
				$savedata = $this->Messages->save($message_arr);
				$id = $this->request->session()->read('Auth.User.id');
				if ($elegibility['package_type'] == 'RC') {
					$this->loadModel('Packfeature');
					$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();
					$packfeature_id = $packfeature['id'];
					$number_of_message = $packfeature['number_of_message'];

					$packfeature = $this->Packfeature->get($packfeature_id);
					$feature_info['number_of_message'] = $number_of_message - 1;
					$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
					$this->Packfeature->save($features_arr);
				} else if ($elegibility['package_type'] == 'NT') {

					$this->loadModel('Packfeature');
					$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();
					$packfeature_id = $packfeature['id'];
					$number_of_message = $packfeature['non_telent_number_of_private_message'];

					$packfeature = $this->Packfeature->get($packfeature_id);
					$feature_info['non_telent_number_of_private_message'] = $number_of_message - 1;
					$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
					$this->Packfeature->save($features_arr);
				}

				$this->Flash->success(__('Message has been sent successfully'));
				return $this->redirect(['action' => 'sentbox']);
			} else {

				$this->Flash->error(__('Messages limit reached'));
				return $this->redirect(['action' => 'sentbox']);
			}
		}





		if ($messageid > 0) {
			//$this->loadModel('Messages');
			//$messages = $this->Messages->find('all')->contain(['Users'=>['Profile']])->where(['Messages.id' => $messageid])->first();
			//$this->set('messages',$messages); 
			$conn = ConnectionManager::get('default');
			$where = " where 1=1 ";
			$where .= " and m.id = '" . $messageid . "'";
			$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where . " group by m.thread_id";
			$message_qe = $conn->execute($message_qry);
			$messages = $message_qe->fetchAll('assoc');
			$this->set('messages', $messages[0]);
		}
	}



	// View Message
	public function view($id = null)
	{
		if ($id > 0) {
			$where = " where messages.id='" . $id . "'";
			$conn = ConnectionManager::get('default');
			$message_qry = " SELECT messages.*, tu.user_name as to_name, tu.email as to_email, fu.user_name as from_name, fu.email as from_email from messages LEFT JOIN users tu on tu.id=messages.to_id left join users fu on fu.id=messages.from_id " . $where;
			$message_qe = $conn->execute($message_qry);
			$messages = $message_qe->fetchAll('assoc');
			$this->set('messages', $messages);

			// Update Read Status
			$this->loadModel('Messages');
			$message = $this->Messages->get($id);
			$message_data['read_status'] = 'Y';
			$messages = $this->Messages->patchEntity($message, $message_data);
			$this->Messages->save($messages);

			// Folder list
			$uid = $this->request->session()->read('Auth.User.id');
			$this->loadModel('Messagegroup');
			$folders = $this->Messagegroup->find('all')->where(['user_id' => $uid])->toarray();
			$this->set('folders', $folders);
		}
	}


	// View Message
	public function viewmessage($id = null)
	{
		if ($id > 0) {
			$where = " where messages.thread_id='" . $id . "'";
			$where .= " and messages.grouptype = 0";

			$conn = ConnectionManager::get('default');
			$message_qry = " SELECT messages.*, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages LEFT JOIN users tu on tu.id=messages.to_id left join users fu on fu.id=messages.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where;

			// echo $message_qry; die;

			$message_qe = $conn->execute($message_qry);
			$messages = $message_qe->fetchAll('assoc');

			$this->set('messages', $messages);

			// Update Read Status
			$this->loadModel('Messages');
			$message = $this->Messages->get($id);
			$message_data['read_status'] = 'Y';
			$messages = $this->Messages->patchEntity($message, $message_data);
			$this->Messages->save($messages);

			// Folder list
			$uid = $this->request->session()->read('Auth.User.id');
			$this->loadModel('Messagegroup');
			$folders = $this->Messagegroup->find('all')->where(['user_id' => $uid])->toarray();
			$this->set('folders', $folders);
		}
	}

	public function messagebox()
	{
		$id = $this->request->data['message_id'];
		$where = " where messages.thread_id='" . $id . "'";
		$where .= " and messages.grouptype = 0";
		$conn = ConnectionManager::get('default');
		$message_qry = " SELECT messages.*, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages LEFT JOIN users tu on tu.id=messages.to_id left join users fu on fu.id=messages.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where;

		//echo $message_qry; die;

		$message_qe = $conn->execute($message_qry);
		$messages = $message_qe->fetchAll('assoc');

		$this->set('messages', $messages);

		// Update Read Status
		$this->loadModel('Messages');
		$message = $this->Messages->get($id);
		$message_data['read_status'] = 'Y';
		$messages = $this->Messages->patchEntity($message, $message_data);
		$this->Messages->save($messages);

		// Folder list
		$uid = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Messagegroup');
		$folders = $this->Messagegroup->find('all')->where(['user_id' => $uid])->toarray();
		$this->set('folders', $folders);
	}

	// Reply message
	public function reply($message_id = null)
	{
		$this->loadModel('Messages');

		if ($this->request->is(['post', 'put'])) {
			$id = $this->request->session()->read('Auth.User.id');

			// pr($this->request->data);exit;
			$description = trim($this->request->data('description'));
			// pr($description);exit;
			if (empty($description)) {
				$this->Flash->error(__('Description cannot be empty.'));
				return $this->redirect($this->referer());
			}

			// $data['description'] = trim($this->request->data['description']);
			$data = $this->request->data();

			$this->request->session()->write('enter_send', $data['enter_send'] > 0 ? "1" : "0");
			// Fetch first message in the thread
			$message = $this->Messages->find()
				->where(['thread_id' => $data['thread_id']])
				->orderAsc('id')
				->first();
			// pr($message);exit;

			$toId = ($message->to_id == $id) ? $message->from_id : $message->to_id;

			$messageEntity = $this->Messages->newEntity([
				'from_id'    => $id,
				'to_id'      => $toId,
				'thread_id'  => $data['thread_id'],
				'parent_id'  => $data['parent_id'],
				'description' => trim($data['description']),
				'subject'    => $message->subject,
				'to_box'     => 'I',
				'from_box'   => 'S'
			]);

			if ($this->Messages->save($messageEntity)) {
				return $this->redirect($this->referer());
			}
		} else {
			$this->set('messages', $this->Messages->get($message_id));
		}
	}


	// public function reply($message_id = null)
	// {
	// 	$this->loadModel('Messages');
	// 	if ($this->request->is(['post', 'put'])) {
	// 		// pr($this->request->data);exit;
	// 		$id = $this->request->session()->read('Auth.User.id');
	// 		$message_id = $this->request->data['message_id'];
	// 		$thread_id = $this->request->data['thread_id'];
	// 		$parent_id = $this->request->data['parent_id'];
	// 		$description = trim($this->request->data['description']);
	// 		$enter_send = $this->request->data['enter_send'];

	// 		if ($enter_send > 0) {
	// 			$this->request->session()->write('enter_send', "1");
	// 		} else {
	// 			$this->request->session()->write('enter_send', "0");
	// 		}

	// 		$messages = $this->Messages->get($thread_id);
	// 		$conn = ConnectionManager::get('default');
	// 		$message_qry = "SELECT id, thread_id, from_id, to_id, subject from messages where messages.thread_id='" . $thread_id . "' order by messages.id ASC limit 1";
	// 		$messages = $conn->execute($message_qry);
	// 		$messages_list = $messages->fetchAll('assoc');

	// 		if ($messages_list[0]['to_id'] == $id) {
	// 			$message_data['to_id'] = $messages_list[0]['from_id'];
	// 		} else {
	// 			$message_data['to_id'] = $messages_list[0]['to_id'];
	// 		}
	// 		//pr($messages); die;
	// 		$mentity = $this->Messages->newEntity();
	// 		$message_data['from_id'] = $id;

	// 		$message_data['thread_id'] = $thread_id;
	// 		$message_data['parent_id'] = $parent_id;
	// 		$message_data['description'] = $description;
	// 		$message_data['subject'] = $messages_list[0]['subject'];
	// 		$message_data['to_box'] = 'I';
	// 		$message_data['from_box'] = 'S';

	// 		$message_arr = $this->Messages->patchEntity($mentity, $message_data);
	// 		$savedata = $this->Messages->save($message_arr);			
	// 		$this->redirect(Router::url($this->referer(), true));
	// 	} else {
	// 		//$message_id = $this->request->data['message_id'];
	// 		$messages = $this->Messages->get($message_id);
	// 		$this->set('messages', $messages);
	// 	}
	// }



	// Reply message
	/*
    public function forward($message_id=null){
	$this->loadModel('Messages');
	if ($this->request->is(['post', 'put'])){
	    $id = $this->request->session()->read('Auth.User.id');
	    $message_id = $this->request->data['message_id'];
	    $thread_id = $this->request->data['thread_id'];
	    $parent_id = $this->request->data['parent_id'];
	    $description = $this->request->data['description'];
	    $enter_send = $this->request->data['enter_send'];
	    if($enter_send > 0)
	    {
		 $this->request->session()->write('enter_send',"1");
	    }
	    else
	    {
		$this->request->session()->write('enter_send',"0");
	    }
	    
	    $messages = $this->Messages->get($thread_id);
	    /*
	    if($id==$messages['to_id'])
	    {
		$message_data['to_id'] = $messages['to_id'];
	    }
	    else
	    {
		$message_data['to_id'] = $id;
	    }
	    
	    //pr($messages); die;
	    $mentity = $this->Messages->newEntity();
	    $message_data['from_id'] = $id;
	    
	    $message_data['thread_id'] = $thread_id;
	    $message_data['parent_id'] = $parent_id;
	    $message_data['description'] = $description;
	    $message_data['subject'] = $messages['subject'];
	    $message_data['to_box'] = 'I';
	    $message_data['from_box'] = 'S';

	    $message_arr = $this->Messages->patchEntity($mentity, $message_data);
	    $savedata = $this->Messages->save($message_arr);
	    return $this->redirect(['action' => 'viewmessage/'.$thread_id]);
	}
	else
	{
	    $messages = $this->Messages->get($message_id);
	    $this->set('messages',$messages); 
	}
	//pr($messages);die;
    }
    */


	// Delete Messages 
	public function deletetemp()
	{
		$this->loadModel('Messages');
		$error = '';
		if ($this->request->is(['post', 'put'])) {
			$id = $this->request->session()->read('Auth.User.id');
			$message_id = $this->request->data['message_id'];
			$type = $this->request->data['type'];
			$message = $this->Messages->get($message_id);
			if ($type == 'draft') {
				$this->Messages->delete($message);
				$status = '1';
			} else {
				if ($type == 'inbox') {
					$message_data['to_box'] = 'T';
					$message_data['deleted'] = date("Y-m-d h:i:s");
				} elseif ($type == 'trash') {
					if ($message['from_id'] == $id) {
						$message_data['from_box'] = 'P';
					} else {
						$message_data['to_box'] = 'P';
					}
				} else {
					$message_data['from_box'] = 'T';
					$message_data['deleted'] = date("Y-m-d h:i:s");
				}
				$messages = $this->Messages->patchEntity($message, $message_data);
				if ($this->Messages->save($messages)) {
					$status = '1';
				} else {
					$status = '0';
				}
			}
			$response['error'] = $error;
			$response['status'] = $status;
			echo json_encode($response);
			die;
		}
	}

	// Deleted Items 
	function trash()
	{
		$this->loadModel('Messages');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$uid = $this->request->session()->read('Auth.User.id');
		$where = " where 1=1 ";
		$where .= " and (m.from_id = '" . $uid . "' and m.from_box = 'T') OR (m.to_id = '" . $uid . "' and m.to_box = 'T')";
		//$where.= " ";
		$conn = ConnectionManager::get('default');
		$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where . " group by m.thread_id";

		//echo $message_qry; die;
		$message_qe = $conn->execute($message_qry);
		$messages = $message_qe->fetchAll('assoc');
		$this->set('messages', $messages);
		// Delete Old messages
		$whered = " where 1=1 ";
		$whered .= " and messages.from_id = '" . $uid . "'";
		$whered .= " and messages.from_box = 'T'";
		$message_del_qry = " Delete from messages " . $whered . " and messages.deleted < UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 7 DAY))";
		$deleted_message = $conn->execute($message_del_qry);

		// Folder list
		$uid = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Messagegroup');
		$folders = $this->Messagegroup->find('all')->where(['user_id' => $uid])->toarray();
		$this->set('folders', $folders);
	}




	// Fetch talent contacts for autocomplete
	function fetchcontactstalent()
	{
		$uid = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Users');
		$keyword = $this->request->data['keyword'];

		// Finding user contacts
		$conn = ConnectionManager::get('default');
		$frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $uid . "' and c.accepted_status='Y' and u.user_name LIKE '" . $keyword . "%' UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $uid . "' and c.accepted_status='Y' and u.user_name LIKE '" . $keyword . "%'";

		$friends = $conn->execute($frnds);
		$friendlist = $friends->fetchAll('assoc');
		//pr($friendlist);
		$this->set('friends', $friendlist);
		foreach ($friendlist as $datalistfriend) {

			$allfriend[] = $datalistfriend['from_id'];
			$allfriendreq[] = $datalistfriend['to_id'];
		}
		$totfriend = array_merge($allfriend, $allfriendreq);
		$nonresultfriend = array_unique($totfriend);
		$nonresultfriend =	implode(",", $nonresultfriend);

		// Finding other people who are not in contacts
		$conn = ConnectionManager::get('default');
		$role_id = '2';
		if ($nonresultfriend) {
			$users = "SELECT p.user_id, p.name, p.profile_image, p.location  FROM `users` u  inner join personal_profile p on p.user_id=u.id  WHERE u.user_name LIKE '" . $keyword . "%' and  u.id NOT IN (" . $nonresultfriend . ")";
		} else {
			$users = "SELECT p.user_id, p.name, p.profile_image, p.location  FROM `users` u  inner join personal_profile p on p.user_id=u.id  WHERE u.user_name LIKE '" . $keyword . "%' and  u.role_id='" . $role_id . "%'";
		}
		//pr($users);

		//	$users = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id!='".$uid."' and u.user_name LIKE '".$keyword."%' UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id!='".$uid."' and u.user_name LIKE '".$keyword."%'";

		$otherusers = $conn->execute($users);
		$otheruserslist = $otherusers->fetchAll('assoc');
		//pr($otheruserslist); die;
		$this->set('others', $otheruserslist);
		//$users = $this->Users->find('all')->contain('Profile')->where(['Users.user_name LIKE ' => $keyword.'%','Users.role_id'=>TALANT_ROLEID,'Users.id NOT IN'=>$uid])->limit(10)->toarray();
		//$this->set('users',$users); 
	}













	// Fetch contacts for autocomplete
	function fetchcontacts()
	{
		$uid = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Users');
		$keyword = $this->request->data['keyword'];

		// Finding user contacts
		$conn = ConnectionManager::get('default');
		$frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $uid . "' and c.accepted_status='Y' and u.user_name LIKE '" . $keyword . "%' UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $uid . "' and c.accepted_status='Y' and u.user_name LIKE '" . $keyword . "%'";

		$friends = $conn->execute($frnds);
		$friendlist = $friends->fetchAll('assoc');
		//pr($friendlist);
		$this->set('friends', $friendlist);
		foreach ($friendlist as $datalistfriend) {

			$allfriend[] = $datalistfriend['from_id'];
			$allfriendreq[] = $datalistfriend['to_id'];
		}
		$totfriend = array_merge($allfriend, $allfriendreq);
		$nonresultfriend = array_unique($totfriend);
		$nonresultfriend =	implode(",", $nonresultfriend);

		// Finding other people who are not in contacts
		$conn = ConnectionManager::get('default');
		if ($nonresultfriend) {
			$users = "SELECT p.user_id, p.name, p.profile_image, p.location  FROM `users` u  inner join personal_profile p on p.user_id=u.id  WHERE u.user_name LIKE '" . $keyword . "%' and  u.id NOT IN (" . $nonresultfriend . ")";
		} else {
			$users = "SELECT p.user_id, p.name, p.profile_image, p.location  FROM `users` u  inner join personal_profile p on p.user_id=u.id  WHERE u.user_name LIKE '" . $keyword . "%'";
		}
		//pr($users);

		//	$users = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id!='".$uid."' and u.user_name LIKE '".$keyword."%' UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id!='".$uid."' and u.user_name LIKE '".$keyword."%'";

		$otherusers = $conn->execute($users);
		$otheruserslist = $otherusers->fetchAll('assoc');
		//pr($otheruserslist); die;
		$this->set('others', $otheruserslist);
		//$users = $this->Users->find('all')->contain('Profile')->where(['Users.user_name LIKE ' => $keyword.'%','Users.role_id'=>TALANT_ROLEID,'Users.id NOT IN'=>$uid])->limit(10)->toarray();
		//$this->set('users',$users); 
	}

	// Saving message to draft
	function savetodraft()
	{
		$id = $this->request->session()->read('Auth.User.id');
		$response['message_id'] = 0;
		if ($this->request->is(['post', 'put'])) {
			$this->loadModel('Messages');
			$message_id = $this->request->data['message_id'];
			$to_id = $this->request->data['to_id'];
			$subject = $this->request->data['subject'];
			$description = $this->request->data['description'];
			if ($message_id > 0) {
				$mentity = $this->Messages->get($message_id);
			} else {
				$mentity = $this->Messages->newEntity();
			}
			$message_data['from_id'] = $id;
			$message_data['to_id'] = $to_id;
			$message_data['subject'] = $subject;
			$message_data['description'] = $description;
			//$message_data['to_box'] = 'I';
			$message_data['from_box'] = 'D';
			if ($to_id > 0) {
				$message_arr = $this->Messages->patchEntity($mentity, $message_data);
				$savedata = $this->Messages->save($message_arr);
				$message_id = $savedata->id;
				$response['message_id'] = $message_id;
			}
			$response['status'] = "1";
			$response['error_text'] = "";
			echo json_encode($response);
			die;
		}
	}

	// Creating Personal Folder
	public function createfolder($id = null)
	{
		$id = $this->request->session()->read('Auth.User.id');
		if ($this->request->is(['post', 'put'])) {
			$this->loadModel('Messagegroup');
			// Message Folder Limit Code

			$this->loadModel('Packfeature');
			$user_id = $this->request->session()->read('Auth.User.id');

			$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();

			$countfolder = $packfeature['message_folder'];
			$packfeature_id = $packfeature['id'];
			if ($countfolder <= 0) {
				$this->Flash->error(__('You have reach create number of folder limit please upgrade you package'));
				return $this->redirect(['action' => 'folders']);
			}




			// End 

			$folder_name = $this->request->data['folder_name'];
			$mentity = $this->Messagegroup->newEntity();
			$message_data['user_id'] = $id;
			$message_data['folder_name'] = $folder_name;
			$message_arr = $this->Messagegroup->patchEntity($mentity, $message_data);
			$savedata = $this->Messagegroup->save($message_arr);
			$message_id = $savedata->id;

			// Limit less
			$feature_info['message_folder'] = $packfeature['message_folder'] - 1;
			$packfeature = $this->Packfeature->get($packfeature_id);

			$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
			$this->Packfeature->save($features_arr);
			// End 

			$this->Flash->success(__('Folder has been created successfully'));
			return $this->redirect(['action' => 'folders']);
		}
	}

	// Showing all Users forlders
	public function folders($id = null)
	{
		$this->loadModel('Messagegroup');
		$uid = $this->request->session()->read('Auth.User.id');
		$folders = $this->Messagegroup->find('all')->where(['user_id' => $uid])->toarray();
		$this->set('folders', $folders);
	}

	// Deleting the folder
	public function deletefolder()
	{
		$this->loadModel('Messagegroup');
		$this->loadModel('Messages');
		$folder_id = $this->request->data['folder_id'];
		$uid = $this->request->session()->read('Auth.User.id');
		// getting message count
		//echo $folder_id;
		$total_message = $this->Messages->find('all')->where(['from_folder_id' => $folder_id, 'from_box' => 'F'])->orWhere(['to_folder_id' => $folder_id, 'to_box' => 'F'])->count();
		//echo $total_message; die;
		if ($total_message > 0) {
			// Cannot delete this folder
			$response['status'] = "0";
			$response['error_text'] = "This folder is associated with some of the Messages Please remove them first.";
		} else {
			$folder = $this->Messagegroup->get($folder_id);
			$this->Messagegroup->delete($folder);
			$response['status'] = "1";
			$response['error_text'] = "Folder has been deleted successfully";
		}

		echo json_encode($response);
		die;
	}

	function actions()
	{
		//pr($this->request); die;
		$action = $this->request->data['action'];
		if ($action == 'folders') {
			$this->movetofolder();
		} elseif ($action == 'delete') {
			$this->deletethreadtmp();
		} elseif ($action == 'markread') {
			$this->updatereadstatus('Y');
		} elseif ($action == 'markunread') {
			$this->updatereadstatus('N');
		}
	}


	function updatereadstatus($status)
	{
		$this->loadModel('Messages');
		$uid = $this->request->session()->read('Auth.User.id');
		$threads = $this->request->data['thread_id'];
		$folder_id = $this->request->data['folder_id'];
		$type = $this->request->data['type'];
		//$message = $this->Messages->get($message_id);
		$redirect = 'inbox';
		if ($type == 's') {
			$redirect = 'sentbox';
		} elseif ($type == 'i') {
			$redirect = 'inbox';
		} elseif ($type == 't') {
			$redirect = 'trash';
		}

		if ($status == 'Y') {
			$message = " Messages has been marked as Read";
		} else {
			$message = " Messages has been marked as UnRead";
		}

		if (count($threads) > 0) {
			foreach ($threads as $thread_id) {
				// Update read status
				$con = ConnectionManager::get('default');
				$detail = 'UPDATE `messages` SET `read_status`="' . $status . '" WHERE `messages`.`thread_id` = ' . $thread_id;
				$results = $con->execute($detail);
			}
			$this->Flash->success(__($message));
			return $this->redirect(['action' => $redirect]);
		} else {
			$redirect = '';
			$this->Flash->success(__('No Message selected to delete'));
			return $this->redirect(['action' => $redirect]);
		}
	}

	// Delete thread message to trash
	function deletethreadtmp()
	{
		$this->loadModel('Messages');
		$uid = $this->request->session()->read('Auth.User.id');
		$threads = $this->request->data['thread_id'];
		$folder_id = $this->request->data['folder_id'];
		$type = $this->request->data['type'];
		//$message = $this->Messages->get($message_id);
		$redirect = 'inbox';
		if (count($threads) > 0) {
			foreach ($threads as $thread_id) {
				if ($type == 'd') {
					$con = ConnectionManager::get('default');
					$detail = 'Delete from `messages` WHERE `messages`.`thread_id` = ' . $thread_id;
					$results = $con->execute($detail);
					$redirect = 'draft';
				} else {
					if ($type == 'i') {
						$con = ConnectionManager::get('default');
						$detail = 'UPDATE `messages` SET `to_box`="T" WHERE `messages`.`thread_id` = ' . $thread_id;
						$results = $con->execute($detail);
						$redirect = 'inbox';
					} elseif ($type == 't') {
						if ($message['from_id'] == $id) {
							$con = ConnectionManager::get('default');
							$detail = 'UPDATE `messages` SET `from_box`="P" WHERE `messages`.`thread_id` = ' . $thread_id;
							$results = $con->execute($detail);
						} else {
							$con = ConnectionManager::get('default');
							$detail = 'UPDATE `messages` SET `to_box`="P" WHERE `messages`.`thread_id` = ' . $thread_id;
							$results = $con->execute($detail);
						}
						$redirect = 'trash';
					} else {
						$con = ConnectionManager::get('default');
						$detail = 'UPDATE `messages` SET `from_box`="T" WHERE `messages`.`thread_id` = ' . $thread_id;
						$results = $con->execute($detail);
						$redirect = 'sentbox';
					}
				}
			}
			$this->Flash->success(__('Message has been deleted'));
			return $this->redirect(['action' => $redirect]);
		} else {
			$redirect = '';
			$this->Flash->success(__('No Message selected to delete'));
			return $this->redirect(['action' => $redirect]);
		}
	}

	// Moved to folder
	public function movetofolder()
	{
		$this->loadModel('Messages');
		$uid = $this->request->session()->read('Auth.User.id');
		$threads = $this->request->data['thread_id'];
		$folder_id = $this->request->data['folder_id'];
		$type = $this->request->data['type'];
		//$message = $this->Messages->get($message_id);

		pr($this->request->data);
		exit;
		$redirect = 'inbox';
		if (count($threads) > 0) {
			foreach ($threads as $thread_id) {
				if ($folder_id > 0) {
					if ($type == 's') {
						// $message_data['from_box'] = 'F';
						// $message_data['from_folder_id'] = $folder_id;
						$con = ConnectionManager::get('default');
						$detail = 'UPDATE `messages` SET `from_folder_id` ="' . $folder_id . '",`from_box`="F" WHERE `messages`.`thread_id` = ' . $thread_id;
						$results = $con->execute($detail);
					} else {
						//$message_data['to_box'] = 'F';
						// $message_data['to_folder_id'] = $folder_id;
						$con = ConnectionManager::get('default');
						$detail = 'UPDATE `messages` SET `to_folder_id` ="' . $folder_id . '",`to_box`="F" WHERE `messages`.`thread_id` = ' . $thread_id;
						$results = $con->execute($detail);
					}
					$redirect = 'folderview/' . $folder_id;
				} else {
					// move to inbox
					if ($type == 'i') {
						// $message_data['to_box'] = 'I';
						// $message_data['to_folder_id'] = '0';
						$redirect = 'inbox';
						// Updating message
						$con = ConnectionManager::get('default');
						$detail = 'UPDATE `messages` SET `to_folder_id` ="0",`to_box`="I" WHERE `messages`.`thread_id` = ' . $thread_id;
						$results = $con->execute($detail);
					}
					// move to sent box
					elseif ($type == 's') {
						// $message_data['from_box'] = 'S';
						//$message_data['from_folder_id'] = '0';
						$redirect = 'sentbox';
						// Updating message
						$con = ConnectionManager::get('default');
						$detail = 'UPDATE `messages` SET `from_folder_id` ="0",`from_box`="S" WHERE `messages`.`thread_id` = ' . $thread_id;
						$results = $con->execute($detail);
					}
					// 	    elseif($type=='t')
					{
					}
				}
			}
			$this->Flash->success(__('Message has been moved to folder'));
			return $this->redirect(['action' => $redirect]);
		} else {
			$redirect = '';
			$this->Flash->success(__('No Message selected to move'));
			return $this->redirect(['action' => $redirect]);
		}

		//$messages = $this->Messages->patchEntity($message, $message_data);
		//pr($messages); die;
		//$this->Messages->save($messages);

	}

	// View all messages of the folder
	public function folderview($folder_id = null)
	{
		$this->loadModel('Messages');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		// Folder information 
		$this->loadModel('Messagegroup');
		$folder_info = $this->Messagegroup->get($folder_id);
		$this->set('folder_info', $folder_info);

		$uid = $this->request->session()->read('Auth.User.id');

		$where = " where 1=1 ";
		$where .= " and ((m.from_folder_id = '" . $folder_id . "' and m.from_box='F' ) OR (m.to_folder_id = '" . $folder_id . "' and m.to_box='F' ))";
		$conn = ConnectionManager::get('default');
		$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where . " group by m.thread_id";
		$message_qe = $conn->execute($message_qry);
		$messages = $message_qe->fetchAll('assoc');
		$this->set('messages', $messages);

		// Folder list
		$uid = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Messagegroup');
		$folders = $this->Messagegroup->find('all')->where(['user_id' => $uid])->toarray();
		$this->set('folders', $folders);
	}

	// Searching of Messages
	public function search($id = null)
	{
		//pr($this->request->data); die;
		$uid = $this->request->session()->read('Auth.User.id');
		$where = " where 1=1 ";
		$type = $this->request->data['search_type'];
		$search_keyword = $this->request->data['search_keyword'];

		if ($this->request->is(['post', 'put'])) {
			if ($type == 'inbox') {
				$where .= " and m.to_id = '" . $uid . "'";
				$where .= " and m.to_box = 'I'";
				// $where.= " and (tu.user_name = '".$search_keyword."' OR fu.user_name = '".$search_keyword."')";
			} elseif ($type == 'sent') {
				$where .= " and m.from_id = '" . $uid . "'";
				$where .= " and m.from_box = 'S'";
			} elseif ($type == 'draft') {
				$where .= " and m.from_id = '" . $uid . "'";
				$where .= " and m.from_box = 'D'";
			} elseif ($type == 'deleted') {
				$where .= " and m.from_id = '" . $uid . "'";
			} elseif ($type == 'all') {
			} else {
				$where .= " and ((m.from_folder_id = '" . $type . "' and m.from_box='F' ) OR (m.to_folder_id = '" . $type . "' and m.to_box='F' ))";
			}
			$where .= " and ((tu.user_name = '" . $search_keyword . "' OR fu.user_name = '" . $search_keyword . "') OR (m.subject LIKE '" . $search_keyword . "%' OR (m.description LIKE '" . $search_keyword . "%'))) ";
		} else {
			if (!empty($id)) {
				$where .= " and m.from_id = '" . $id . "' OR m.to_id = '" . $id . "' ";
			}
		}

		// Query for searching 
		$conn = ConnectionManager::get('default');
		$message_qry = " SELECT m.*, (select count(*) from messages where thread_id=m.thread_id group by thread_id) as total, tu.id as to_id, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.id as from_id, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where . " group by m.thread_id";
		//echo $message_qry; die;
		$message_qe = $conn->execute($message_qry);
		$messages = $message_qe->fetchAll('assoc');
		$this->set('messages', $messages);

		$this->set('search_keyword', $search_keyword);
		$this->set('type', $type);

		// Folder list
		$uid = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Messagegroup');
		//$folders = $this->Messagegroup->find('all')->where(['user_id' => $uid])->toarray();
		//$this->set('folders',$folders); 



	}



	public function creategroup() {}



	public function groupmessage()
	{

		$uid = $this->request->session()->read('Auth.User.id');
		$where = " where 1=1 ";
		if ($type == 'r') {
			$where .= " and m.read_status= 'Y'";
		} elseif ($type == 'u') {
			$where .= " and m.read_status = 'N'";
		}


		$where .= " and m.to_box = 'I'";
		$where .= " and m.grouptype = 1";
		//$condition['to_id'] = $uid;
		//$condition['to_box'] = 'I';

		$this->loadModel('Messages');
		$this->loadModel('Users');
		$this->loadModel('Profile');

		$conn = ConnectionManager::get('default');
		$message_qry = " SELECT m.*,mg.group_name, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email,mg.created_id,mg.created as groupcreated from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join message_groups mg on mg.id=m.to_id left join personal_profile fp on fu.id=fp.user_id " . $where . " group by m.to_id order by created DESC";

		$message_qe = $conn->execute($message_qry);

		$messages = $message_qe->fetchAll('assoc');
		//pr($messages);
		$this->set('messages', $messages);


		$message_qrycount = " SELECT m.*,mg.group_name, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email,mg.created_id,mg.created as groupcreated from messages m LEFT JOIN users tu on tu.id=m.to_id left join users fu on fu.id=m.from_id left join personal_profile tp on tu.id=tp.user_id left join message_groups mg on mg.id=m.to_id left join personal_profile fp on fu.id=fp.user_id " . $where . " order by created DESC";

		$message_qec = $conn->execute($message_qrycount);

		$messagescount = $message_qec->fetchAll('assoc');

		$this->set('messagescount', count($messagescount));



		// Folder list
		$uid = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Messagegroup');
		$folders = $this->Messagegroup->find('all')->where(['user_id' => $uid])->toarray();
		$this->set('folders', $folders);
	}


	public function viewmessagegroup($id = null)
	{
		if ($id > 0) {
			$where = " where messages.thread_id='" . $id . "'";
			$where .= " and messages.grouptype = 1";
			$conn = ConnectionManager::get('default');
			$message_qry = " SELECT messages.*, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages LEFT JOIN users tu on tu.id=messages.to_id left join users fu on fu.id=messages.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where;

			//  echo $message_qry; die;

			$message_qe = $conn->execute($message_qry);
			$messages = $message_qe->fetchAll('assoc');

			$this->set('messages', $messages);

			// Update Read Status
			$this->loadModel('Messages');
			$message = $this->Messages->get($id);
			$message_data['read_status'] = 'Y';
			$messages = $this->Messages->patchEntity($message, $message_data);
			$this->Messages->save($messages);

			// Folder list
			$uid = $this->request->session()->read('Auth.User.id');
			$this->loadModel('Messagegroup');
			$folders = $this->Messagegroup->find('all')->where(['user_id' => $uid])->toarray();
			$this->set('folders', $folders);
		}
	}




	public function messageboxgroup()
	{
		$id = $this->request->data['message_id'];
		$where = " where messages.thread_id='" . $id . "'";
		$where .= " and messages.grouptype = 1";
		$conn = ConnectionManager::get('default');
		$message_qry = " SELECT messages.*, tu.user_name as to_name, tp.profile_image as to_image, tu.email as to_email, fu.user_name as from_name, fp.profile_image as from_image, fu.email as from_email from messages LEFT JOIN users tu on tu.id=messages.to_id left join users fu on fu.id=messages.from_id left join personal_profile tp on tu.id=tp.user_id left join personal_profile fp on fu.id=fp.user_id " . $where;

		//echo $message_qry; die;

		$message_qe = $conn->execute($message_qry);
		$messages = $message_qe->fetchAll('assoc');

		$this->set('messages', $messages);

		// Update Read Status
		$this->loadModel('Messages');
		$message = $this->Messages->get($id);
		$message_data['read_status'] = 'Y';
		$messages = $this->Messages->patchEntity($message, $message_data);
		$this->Messages->save($messages);

		// Folder list
		$uid = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Messagegroup');
		$folders = $this->Messagegroup->find('all')->where(['user_id' => $uid])->toarray();
		$this->set('folders', $folders);
	}

	public function groupreply($message_id = null)
	{
		$this->loadModel('Messages');
		if ($this->request->is(['post', 'put'])) {
			$id = $this->request->session()->read('Auth.User.id');
			$message_id = $this->request->data['message_id'];
			$thread_id = $this->request->data['thread_id'];
			$parent_id = $this->request->data['parent_id'];
			$description = $this->request->data['description'];
			$enter_send = $this->request->data['enter_send'];

			if ($enter_send > 0) {
				$this->request->session()->write('enter_send', "1");
			} else {
				$this->request->session()->write('enter_send', "0");
			}

			$messages = $this->Messages->get($thread_id);
			$conn = ConnectionManager::get('default');
			$message_qry = "SELECT id, thread_id, from_id, to_id, subject from messages where messages.thread_id='" . $thread_id . "' order by messages.id ASC limit 1";
			$messages = $conn->execute($message_qry);
			$messages_list = $messages->fetchAll('assoc');

			if ($messages_list[0]['to_id'] == $id) {
				$message_data['to_id'] = $messages_list[0]['from_id'];
			} else {
				$message_data['to_id'] = $messages_list[0]['to_id'];
			}
			//pr($messages); die;
			$mentity = $this->Messages->newEntity();
			$message_data['from_id'] = $id;

			$message_data['thread_id'] = $thread_id;
			$message_data['parent_id'] = $parent_id;
			$message_data['description'] = $description;
			$message_data['subject'] = $messages_list[0]['subject'];
			$message_data['to_box'] = 'I';
			$message_data['from_box'] = 'S';
			$message_data['grouptype'] = 1;

			$message_arr = $this->Messages->patchEntity($mentity, $message_data);
			$savedata = $this->Messages->save($message_arr);
			return $this->redirect(['action' => 'viewmessage/' . $thread_id]);
		} else {
			//$message_id = $this->request->data['message_id'];
			$messages = $this->Messages->get($message_id);
			$this->set('messages', $messages);
		}
	}
}
