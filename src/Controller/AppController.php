<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use MyClass\MyClass;
use MyClass\Exception;
use Cake\Datasource\ConnectionManager;



/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

	// this function used for save images 
	public function mimages($k = '')
	{
		//pr($k); die;
		$i = 0;
		if ($k['name']) {
			$filename = $k['name'];
			//pr($filename); die;
			$ext =  end(explode('.', $filename));
			$name = md5(time($filename));
			$rnd = mt_rand();
			$imagename = trim($name . $rnd . $i . '.' . $ext, " ");
			if (move_uploaded_file($k['tmp_name'], "trash_image/" . $imagename)) {
				$kk[] = $imagename;
			}
		} else {
			foreach ($k as $item) {
				$filename = $item['name'];
				$ext =  end(explode('.', $filename));
				$name = md5(time($filename));
				$rnd = mt_rand();
				$imagename = trim($name . $rnd . $i . '.' . $ext, " ");
				if (move_uploaded_file($item['tmp_name'], "trash_image/" . $imagename)) {
					$kk[] = $imagename;
				}
				$i++;
			}
		}
		//pr($kk);

		return $kk;
	}

	public function beforeFilter(Event $event)
	{
		\Cake\Event\EventManager::instance()->on('HybridAuth.newUser', [$this, 'createUser']);

		// 		$this->Auth->allow(['logincheck']);
		// pr($this->request->session()->read('Auth.User'));
		//  $this->login_check();


	}

	public function createUser(\Cake\Event\Event $event)
	{
		// Entity representing record in social_profiles table
		$profile = $event->data()['profile'];

		$user = $this->newEntity([
			'email' => $profile->email,
			'password' => time()
		]);
		$user = $this->save($user);

		if (!$user) {
			throw new \RuntimeException('Unable to save new user');
		}

		return $user;
	}


	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * e.g. `$this->loadComponent('Security');`
	 *
	 * @return void
	 */
	public function initialize()
	{
		parent::initialize();

		$this->loadComponent('RequestHandler');
		$this->loadComponent('Flash');
		$this->set('BASE_URL', Configure::read('BASE_URL'));
		$this->loadComponent('Auth', [
			'authorize' => ['Controller'],
			'authenticate' => [
				'Form' => [
					'fields' => ['username' => 'email', 'password' => 'password']
				]
			],
			'ADmad/HybridAuth.HybridAuth' => [
				'fields' => [
					'provider' => 'provider',
					'openid_identifier' => 'openid_identifier',
					'email' => 'email',
				],
				'profileModel' => 'ADmad/HybridAuth.SocialProfiles',
				'profileModelFkField' => 'user_id',
				'userModel' => 'Users',
				'hauth_return_to' => [
					'controller' => 'Users',
					'action' => 'socail_login',
					'prefix' => false,
					'plugin' => false
				]
			]


		]);

		// Pass Auth user data to all views
		$this->set('authUser', $this->Auth->user());

		// Load the CSRF component
		// $this->loadComponent('Csrf');

		/*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
		//$this->loadComponent('Security');
		//$this->loadComponent('Csrf');
	}


	/**
	 * Before render callback.
	 *
	 * @param \Cake\Event\Event $event The beforeRender event.
	 * @return \Cake\Network\Response|null|void
	 */
	public function beforeRender(Event $event)
	{
		if (
			!array_key_exists('_serialize', $this->viewVars) &&
			in_array($this->response->type(), ['application/json', 'application/xml'])
		) {
			$this->set('_serialize', true);
		}
		//  print_r($_SERVER);
	}

	public function uploadFiles($fileInput, $uploadPath = "trash_image/")
	{
		$uploadedFiles = [];

		if (!isset($fileInput['name']) || empty($fileInput['name'])) {
			return $uploadedFiles;
		}

		// Convert single file to array format
		if (!is_array($fileInput['name'])) {
			$fileInput = [
				'name'     => [$fileInput['name']],
				'type'     => [$fileInput['type']],
				'tmp_name' => [$fileInput['tmp_name']],
				'error'    => [$fileInput['error']],
				'size'     => [$fileInput['size']]
			];
		}

		foreach ($fileInput['name'] as $index => $originalFileName) {
			if (!empty($originalFileName) && $fileInput['error'][$index] === UPLOAD_ERR_OK) {
				// Generate unique file name
				$fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
				$uniqueFileName = uniqid('img_', true) . '_' . bin2hex(random_bytes(5)) . '.' . $fileExtension;
				$destinationPath = $uploadPath . $uniqueFileName;
				if (move_uploaded_file($fileInput['tmp_name'][$index], $destinationPath)) {
					$uploadedFiles[] = $uniqueFileName;
				}
			}
		}
		return $uploadedFiles;
	}


	// this function used for save images 
	public function move_images($k = '')
	{
		$i = 0;
		if (count($k['name']) == 1) {
			$filename = $k['name'];
			$ext =  end(explode('.', $filename));
			$name = md5(time($filename));
			$rnd = mt_rand();
			$imagename = trim(uniqid('img_', true) . '_' . bin2hex(random_bytes(5)) . '.' . $ext, " ");
			if (move_uploaded_file($k['tmp_name'], "trash_image/" . $imagename)) {
				$kk[] = $imagename;
			}
		} else {
			foreach ($k as $item) {
				$filename = $item['name'];
				$ext =  end(explode('.', $filename));
				$name = md5(time($filename));
				$rnd = mt_rand();
				// $imagename = trim($name . $rnd . $i . '.' . $ext, " ");
				$imagename = trim(uniqid('img_', true) . '_' . bin2hex(random_bytes(5)) . '.' . $ext, " ");
				if (move_uploaded_file($item['tmp_name'], "trash_image/" . $imagename)) {
					$kk[] = $imagename;
				}
				$i++;
			}
		}

		return $kk;
	}

	public function upload_images($k = '', $sizeArray = '', $path)
	{

		require(ROOT . DS . "vendor" . DS  . "MyClass" . DS . "MyClass.php");
		$wm = new MyClass();

		// Set the image
		$wm->setImage("trash_image/" . $k[0]); // you can also set the quality with setImage, you only need to change it with an array: array('file' => 'test.png', 'quality' => 70)

		// Set the export quality
		$wm->setQuality(100);
		// Resize the image
		$wm->resize(array('type' => 'resize', 'size' => $sizeArray));
		// Flip it
		//$wm->flip('horizontal');
		// Now rotate it 30deg
		//$wm->rotate(30);
		// It's time to apply the watermark
		// Export the file
		if (!$wm->generate($path . $k[0])) {
			// handle errors...
		}
		unlink('trash_image/' . $k[0]);
		return $k[0];
	}


	/**
	 * @desc Function used to create a thumbnail by shrinkage
	 * 
	 * $imgPath				:path for the big image (the uplaoded one)
	 * $imgSmallPath 		:path for the small image
	 * $fileName 			:name for the already uploaded file
	 * $fileSmallName 		:name for the to be copied and resized trumbnail image
	 * $newWidth 			:the new width (to be used for the trumbnail)
	 * $newHeight 			:the new height (to be used for the trumbnail)
	 */
	// function FcCreateThumbnail($imgPath, $imgSmallPath, $fileName, $fileSmallName, $newWidth, $newHeight)
	// {

	// 	/********************* getting the image in php *********************/

	// 	$myImageFileName = $imgPath . '/' . $fileName;
	// 	$myImageAttribs = @getimagesize($myImageFileName);
	// 	pr($myImageFileName);
	// 	pr($myImageAttribs);exit;

	// 	if ($myImageAttribs[2] == 2) {
	// 		$myImageOld = imagecreatefromjpeg($myImageFileName);
	// 	} else if ($myImageAttribs[2] == 1) {
	// 		//echo $myImageFileName;
	// 		//$myImageOld = imagecreatefromgif($myImageFileName);
	// 		//$myImageOld = imagecreatefromstring($);
	// 	} else if ($myImageAttribs[2] == 3) {
	// 		$myImageOld = imagecreatefrompng($myImageFileName);
	// 	}


	// 	/**************** setting up the trumbnail object *****************/
	// 	//$ratio = ($width > $height) ? $newWidth/$myImageAttribs[0] : $newHeight/$myImageAttribs[1];
	// 	//$myThumbWidth = $myImageAttribs[0] * $ratio;
	// 	//$myThumbHeight = $myImageAttribs[1] * $ratio;
	// 	$myThumbWidth = $newWidth;
	// 	$myThumbHeight = $newHeight;
	// 	$myImageNew = imagecreatetruecolor($myThumbWidth, $myThumbHeight);
	// 	//imageAntiAlias($myImageNew,true);

	// 	/*************** write ime image to disk **************************/

	// 	// path + name of the file
	// 	$myThumbFileName = $imgSmallPath . '/' . $fileSmallName;
	// 	// if image is a GIF copy it
	// 	if ($myImageAttribs[2] == 1) {
	// 		// copy the image as we do not have a function like this
	// 		$response = copy($myImageFileName, $myThumbFileName);
	// 		// else if the image JPG or PNG
	// 	} else if ($myImageAttribs[2] != 1) {
	// 		// resample image (only JPG, PNG)
	// 		@imagecopyresampled($myImageNew, $myImageOld, 0, 0, 0, 0, $myThumbWidth, $myThumbHeight, $myImageAttribs[0], $myImageAttribs[1]);

	// 		// JPG
	// 		if ($myImageAttribs[2] == 2) {
	// 			$return = imagejpeg($myImageNew, $myThumbFileName, 100);
	// 			// PNG
	// 		} else if ($myImageAttribs[2] == 3) {
	// 			$return = imagepng($myImageNew, $myThumbFileName);
	// 		}
	// 	}


	// 	$myReturnArray = array($return);
	// 	return $myReturnArray;
	// }

	function FcCreateThumbnail($imgPath, $imgSmallPath, $fileName, $fileSmallName, $newWidth, $newHeight)
	{
		// Get image path
		$myImageFileName = $imgPath . '/' . $fileName;

		// Use finfo to get the correct MIME type
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mimeType = finfo_file($finfo, $myImageFileName);
		finfo_close($finfo);

		// Map MIME types to image types
		$mimeToImageType = [
			'image/jpeg' => IMAGETYPE_JPEG,
			'image/png' => IMAGETYPE_PNG,
			'image/gif' => IMAGETYPE_GIF,
			'image/webp' => IMAGETYPE_WEBP
		];

		// Get correct image type
		$imageType = $mimeToImageType[$mimeType] ?? false;

		// pr($imageType);exit;

		if (!$imageType) {
			return ['error' => "Unsupported image type: $mimeType"];
		}

		$myImageOld = null;
		// Load the image based on type
		switch ($imageType) {
			case IMAGETYPE_JPEG:
				$myImageOld = imagecreatefromjpeg($myImageFileName);
				break;
			case IMAGETYPE_PNG:
				$myImageOld = imagecreatefrompng($myImageFileName);
				break;
			case IMAGETYPE_GIF:
				$myImageOld = imagecreatefromgif($myImageFileName);
				break;
			case IMAGETYPE_WEBP:
				$myImageOld = imagecreatefromwebp($myImageFileName);
				break;
			default:
				return ['error' => "Unsupported image type: $mimeType"];
		}

		if (!$myImageOld) {
			return ['error' => "Failed to create image from file: $myImageFileName"];
		}

		// Create a blank image with new dimensions
		$myImageNew = imagecreatetruecolor($newWidth, $newHeight);

		// Preserve transparency for PNG, GIF, and WebP
		if (in_array($imageType, [IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP])) {
			imagecolortransparent($myImageNew, imagecolorallocatealpha($myImageNew, 0, 0, 0, 127));
			imagealphablending($myImageNew, false);
			imagesavealpha($myImageNew, true);
		}

		// Resize and resample the image
		imagecopyresampled($myImageNew, $myImageOld, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($myImageOld), imagesy($myImageOld));

		// Define output path
		$myThumbFileName = $imgSmallPath . '/' . $fileSmallName;
		$return = false;

		// Save the new image
		switch ($imageType) {
			case IMAGETYPE_JPEG:
				$return = imagejpeg($myImageNew, $myThumbFileName, 100);
				break;
			case IMAGETYPE_PNG:
				$return = imagepng($myImageNew, $myThumbFileName);
				break;
			case IMAGETYPE_GIF:
				$return = imagegif($myImageNew, $myThumbFileName);
				break;
			case IMAGETYPE_WEBP:
				$return = imagewebp($myImageNew, $myThumbFileName);
				break;
		}

		// Free memory
		imagedestroy($myImageOld);
		imagedestroy($myImageNew);
		unlink($myImageFileName);
		return ['success' => $return, 'file' => $myThumbFileName];
	}



	function dd($var)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}

	function logincheck()
	{

		$this->loadModel('Loginusercheck');
		$this->loadModel('Users');
		$this->autoRender = false;
		$id = $this->request->session()->read('Auth.User.id');

		$user = $this->Users->find('all')->where(['id' => $id])->first();
		// pr($user); die;
		if ($user) {
			$user['last_login'] = date('Y-m-d H:i:s', time());
			//  pr($user['last_login']); die;
			$this->Users->save($user);
		}

		$conn = ConnectionManager::get('default');
		$lastlogq = "SELECT id, user_id from loginusercheck  where created < (NOW() - INTERVAL 10 MINUTE)";
		$latlog = $conn->execute($lastlogq);
		$lastlogdata = $latlog->fetchAll('assoc');
		foreach ($lastlogdata as $key => $value) {
			$this->Loginusercheck->deleteAll(['Loginusercheck.id' => $value['id']]);
		}
		if ($id) {
			$check_login_ids = $this->Loginusercheck->find('all')->where(['user_id' => $id, 'ip' => $_SERVER['REMOTE_ADDR']])->first();
			if ($check_login_ids) {
				$loginusercheck = $this->Loginusercheck->get($check_login_ids['id']);
				$data['user_id'] = $id;
				$data['ip'] = $_SERVER['REMOTE_ADDR'];
				$data['created'] = date('Y-m-d H:i:s', time());
				$option_arr = $this->Loginusercheck->patchEntity($loginusercheck, $data);
				$savedata = $this->Loginusercheck->save($option_arr);
				die;
			}
			die;
		}
	}

	public function requirmentFilter($id = null)
	{

		$this->loadModel('Requirement');
		$currentdate = date('Y-m-d H:m:s');
		$id = $this->request->session()->read('Auth.User.id');
		$stsearch = $this->request->data['fetch'];
		$i = $this->request->data['i'];
		$usest = array('Requirement.title LIKE' => $stsearch . '%', 'Requirement.status' => 'Y', 'Requirement.user_id' => $id, 'DATE(Requirement.last_date_app) >=' => $currentdate);
		$searchst = $this->Requirement->find('all', array('conditions' => $usest));
		//pr($searchst); die;
		foreach ($searchst as $value) {
			echo '<li onclick="cllbckrequirment(' . "'" . $value['title'] . "'" . ',' . "'" . $value['id'] . "'" . ',' . "'" . $value['image'] . "'" . ',' . "'" . $value['last_date_app'] . "'" . ',' . "'" . $i . "'" . ')"><a href="#">' . $value['title'] . '</a></li>';
		}

		die;
	}

	public function isAuthorized($user)
	{

		// Admin can access every action 

		if ($this->request->params['prefix'] == 'admin') {
			if (isset($user['role_id']) && $user['role_id'] === 1) {
				// pr($user); die;
				return true;
			}
			// Default deny 
			return false;
		}
		return true;
	}

	// public function notification($id=null,$type,$typeid=null){
	// 	$this->loadModel('Notification');
	// 	$this->loadModel('Users');		

	// 	if($type == 'Requirement'){
	// 		$requiremrnt = $this->Requirement->find('all')->contain(['RequirmentVacancy'])->where(['Requirement.id' => $typeid])->first();
	// 		$count= count($requiremrnt['requirment_vacancy']);
	// 		$requirementv = array();
	// 		for($i=0;$i<$count;$i++){
	// 			$requirementv[] = $requiremrnt['requirment_vacancy'][$i]['telent_type'];
	// 		}
	// 		pr($requirementv);
	// 		die;
	// 	}
	// 	$new= $this->Notification->newEntity();
	// 	$notification = array();
	// 	$notification['user_id']= $id;
	// 	$notification['type']= $type;
	// 	$notification['type_id']= $typeid;
	// 	$patchnotification = $this->Notification->patchEntity($new,$notification);
	// 	$savenotification= $this->Notification->save($patchnotification);

	// }


	public function activePackage($packageType = 'PR')
	{
		$this->loadModel('Packfeature');
		$this->loadModel('Users');

		$userid = $this->request->session()->read('Auth.User.id');
		$userRole = $this->Users->find('all')
			->where(['id' => $userid])
			->select(['role_id'])
			->first();

		$query = $this->Packfeature->find('all')
			->where(['user_id' => $userid]);
		if ($userRole['role_id'] == 3) {
			$query->andWhere(['package_status' => 'default']);
		} else {
			$query->andWhere([
				'OR' => [
					['package_status' => $packageType, 'expire_date >=' => date('Y-m-d H:i:s')],
					['package_status' => 'default']
				]
			]);
		}
		$activePackage = $query->order(['id' => 'DESC'])->first();
		// pr($activePackage);exit;
		return $activePackage;
	}
}
