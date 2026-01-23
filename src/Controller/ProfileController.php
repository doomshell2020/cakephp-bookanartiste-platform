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

class ProfileController extends AppController
{

	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['viewprofile', 'testprofile', 'profiledetails', 'likeprofile', 'managefriends']);
	}


	public function controlmyvisbility()
	{
		$this->loadModel('Users');
		// $this->autoRender = false;
		$current_user_id = $this->request->session()->read('Auth.User.id');
		if ($this->request->is(['post', 'put'])) {
			// pr($this->request->data);exit;
			$packfeature = $this->Users->get($current_user_id);
			$feature_info['control_visibility'] = $this->request->data['control_visibility'];
			$features_arr = $this->Users->patchEntity($packfeature, $feature_info);
			$this->Users->save($features_arr);
			// $this->Session->setFlash('Profile updated successfully.', 'default', ['class'
			$this->redirect(Router::url($this->referer(), true));
		}
	}

	public function controlmyadvertisement()
	{
		$this->loadModel('Users');
		// $this->autoRender = false;
		$current_user_id = $this->request->session()->read('Auth.User.id');
		if ($this->request->is(['post', 'put'])) {
			$packfeature = $this->Users->get($current_user_id);
			$feature_info['access_adds'] = $this->request->data['access_adds'];
			$features_arr = $this->Users->patchEntity($packfeature, $feature_info);
			$this->Users->save($features_arr);
			$this->redirect(Router::url($this->referer(), true));
		}
	}

	public function refinesearch($id = null)
	{
		if ($this->request->is(['post', 'put'])) {
			$namerefine = $this->request->data['name'];
			$agerefine = $this->request->data['age'];
			$genderrefine = $this->request->data['gender'];
			$ethnicityrefine = $this->request->data['ethnicity'];
			$cntrefine = $this->request->data['country_ids'];
			$staterefine = $this->request->data['state_id'];
			$cityrefine = $this->request->data['city_id'];
			$profilerefine = $this->request->data['profile_active'];
		}
		$tab = $this->request->data['tab'];
		if ($id > 0) {
			$id = $id;
		} else {
			$id = $this->request->session()->read('Auth.User.id');
		}

		$current_user_id = $this->request->session()->read('Auth.User.id');


		if (!empty($namerefine)) {
			$res .= "and p.name LIKE '%$namerefine%'";
		} else {
			$res .= '';
		}

		if (!empty($genderrefine)) {
			$res .= " and p.gender = '$genderrefine'";
			//$res .="($sex) and  ";

		} else {
			$res .= '';
		}

		if (!empty($ethnicityrefine)) {
			$res .= " and p.ethnicity = '$ethnicityrefine'";
			//$res .="($sex) and  ";
		} else {
			$res .= '';
		}

		if (!empty($cntrefine)) {
			$res .= " and( p.country_ids = '$cntrefine' or p.state_id = '$staterefine' or p.city_id = '$cityrefine')";
			//$res .="($sex) and  ";
		} else {
			$res .= '';
		}


		if (!empty($profilerefine)) {
			$days = $profilerefine;
			$res .= " and TIMESTAMPDIFF(DAY,u.last_login,NOW()) = '$days' ";
		} else {
			$res .= '';
		}
		// if (!empty($agerefine)){
		if (empty($agerefine)) {
			$age = explode("-", $agerefine);
			$min = $age['0'];
			$max = $age['1'];
			$this->set('minselsss', $min);
			$this->set('maxselsss', $max);
			// $having = "having birthyear>='$min' and birthyear <='$max'";
			$having = "HAVING (birthyear >= '$min' AND birthyear <= '$max') OR birthyear IS NULL";
			$res .= "group by u.id $having ";
			$min = $age['0'];
			$max = $age['1'];
		} else {
			$having = '';
		}



		if ($tab == 'contacts') {
			$conn = ConnectionManager::get('default');
			$frnds = "SELECT c.*,e.title,Round(TIMESTAMPDIFF(Day, p.dob, now() )/365)  as birthyear,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, u.last_login, p.gender, p.ethnicity as ethniid, p.country_ids,p.city_id,p.state_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id  WHERE c.from_id='" . $id . "' and c.accepted_status='Y' $res UNION SELECT c.*,e.title,Round(TIMESTAMPDIFF(Day, p.dob, now() )/365)  as birthyear,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, u.last_login, p.gender, p.ethnicity as ethniid, p.country_ids,p.city_id,p.state_id,  cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y' $res";
			$friends = $conn->execute($frnds);
			$this->set('friends', $friends);
		}

		if ($tab == 'mutual') {

			$conn = ConnectionManager::get('default');
			$frnds = "SELECT c.*,e.title,Round(TIMESTAMPDIFF(Day, p.dob, now() )/365)  as birthyear,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, u.last_login, p.gender, p.ethnicity as ethniid, p.country_ids,p.city_id,p.state_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id WHERE c.from_id='" . $current_user_id . "' and c.accepted_status='Y' $res UNION SELECT c.*,e.title,Round(TIMESTAMPDIFF(Day, p.dob, now() )/365)  as birthyear,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, u.last_login, p.gender, p.ethnicity as ethniid, p.country_ids,p.city_id,p.state_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id WHERE c.to_id='" . $current_user_id . "' and c.accepted_status='Y' $res and p.user_id IN (SELECT p.user_id FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' $res  UNION SELECT p.user_id FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y' $res )";


			$friends = $conn->execute($frnds);

			$this->set('friends', $friends);
		}

		if ($tab == 'online') {

			$conn = ConnectionManager::get('default');
			$frnds = "SELECT c.*,e.title,Round(TIMESTAMPDIFF(Day, p.dob, now() )/365)  as birthyear,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, u.last_login, p.gender, p.ethnicity as ethniid, p.country_ids,p.city_id,p.state_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id  WHERE c.from_id='" . $id . "' and c.accepted_status='Y' and TIMESTAMPDIFF(MINUTE,u.last_login,NOW()) < 5 $res UNION SELECT c.*,e.title,Round(TIMESTAMPDIFF(Day, p.dob, now() )/365)  as birthyear,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, u.last_login, p.gender, p.ethnicity as ethniid, p.country_ids,p.city_id,p.state_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id  left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y' and TIMESTAMPDIFF(MINUTE,u.last_login,NOW()) < 5 $res";

			$friends = $conn->execute($frnds);
			$this->set('friends', $friends);
		}


		if ($tab == 'following') {

			$conn = ConnectionManager::get('default');
			$frnds = "SELECT c.*,e.title,Round(TIMESTAMPDIFF(Day, p.dob, now() )/365)  as birthyear,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, u.last_login, p.gender, p.ethnicity as ethniid, p.country_ids,p.city_id,p.state_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id   WHERE c.from_id='" . $id . "' and c.accepted_status='N' $res";
			$friends = $conn->execute($frnds);
			$this->set('friends', $friends);
		}


		if ($tab == 'followers') {

			$conn = ConnectionManager::get('default');
			$frnds = "SELECT c.*,e.title,Round(TIMESTAMPDIFF(Day, p.dob, now() )/365)  as birthyear,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, u.last_login, p.gender, p.ethnicity as ethniid, p.country_ids,p.city_id,p.state_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id WHERE c.to_id='" . $id . "' and c.accepted_status='N' $res";
			$friends = $conn->execute($frnds);
			$this->set('friends', $friends);
		}
	}

	public function followerscontacts($id = null)
	{
		$this->loadModel('Audio');
		$this->loadModel('Users');
		$this->loadModel('Enthicity');
		$this->loadModel('City');
		$this->loadModel('State');
		$this->loadModel('Country');
		$this->loadModel('Professinal_info');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');
		$this->loadModel('Performance_desc');
		if ($id > 0) {
			$id = $id;
		} else {
			$id = $this->request->session()->read('Auth.User.id');
		}
		$ethnicity = $this->Enthicity->find('list')->select(['id', 'title'])->toarray();
		$this->set('ethnicity', $ethnicity);

		$current_user_id = $this->request->session()->read('Auth.User.id');
		//echo $current_user_id; die;
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'State', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);
		$videoprofile = $this->Audio->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofile', $videoprofile);

		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);

		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);
		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $current_user_id])->toarray();
		$this->set('uservitals', $uservitals);
		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);

		//contacts
		$conn = ConnectionManager::get('default');
		$frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$friends = $conn->execute($frnds);
		$this->set('friends', $friends);
		//mutual friends
		$conn = ConnectionManager::get('default');
		//$mutual = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";


		$mutual = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $current_user_id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $current_user_id . "' and c.accepted_status='Y' and p.user_id IN (SELECT p.user_id FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT p.user_id FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y')";

		$mutualfrnd = $conn->execute($mutual);
		$this->set('mutualfrnd', $mutualfrnd);

		// Online friends
		$current_time = date('Y-m-d H:i:s');
		$conn = ConnectionManager::get('default');
		$online_qry = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location, u.last_login FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='Y' and u.last_login > ('" . $current_time . "' - INTERVAL 2 MINUTE) UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location,u.last_login FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y' and u.last_login > ('" . $current_time . "' - INTERVAL 2 MINUTE)";


		// echo $online_qry; die;
		$onlines = $conn->execute($online_qry);
		$onlines = $onlines->fetchAll('assoc');
		$this->set('onlines', $onlines);


		// friends following
		$conn = ConnectionManager::get('default');
		$following = "SELECT c.*,e.title,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, p.ethnicity as ethniid, p.country_ids, p.state_id, p.city_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id  WHERE c.from_id='" . $id . "' and c.accepted_status='N'";
		$follower = $conn->execute($following);
		$following = $follower->fetchAll('assoc');
		$this->set('following', $following);


		// friends followers
		$id = $this->request->session()->read('Auth.User.id');
		$conn = ConnectionManager::get('default');
		$follow = "SELECT c.*,e.title,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, p.ethnicity as ethniid, p.country_ids, p.state_id, p.city_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id WHERE c.to_id='" . $id . "' and c.accepted_status='N'";
		$followers = $conn->execute($follow);

		$followerd = $followers->fetchAll('assoc');
		$this->set('followerd', $followerd);

		foreach ($followerd as  $key => $value) {
			$cntfetch[] =  $value['country_ids'];
		}

		foreach ($followerd as  $key => $value) {
			$statefetch[] =  $value['state_id'];
		}

		foreach ($followerd as  $key => $value) {
			$cityfetch[] =  $value['city_id'];
		}

		if ($cntfetch) {
			$country = $this->Country->find('list')->select(['id', 'name'])->where(['Country.id IN' => $cntfetch])->toarray();
			$this->set('country', $country);
		}

		if ($statefetch) {
			$state = $this->State->find('list')->select(['id', 'name'])->where(['State.id IN' => $statefetch])->toarray();
			$this->set('state', $state);
		}
		if ($cityfetch) {
			$city = $this->City->find('list')->select(['id', 'name'])->where(['City.id IN' => $cityfetch])->toarray();
			$this->set('city', $city);
		}
	}

	public function followingcontacts($id = null)
	{
		$this->loadModel('Audio');
		$this->loadModel('Users');
		$this->loadModel('Enthicity');
		$this->loadModel('City');
		$this->loadModel('State');
		$this->loadModel('Country');
		$this->loadModel('Professinal_info');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');
		$this->loadModel('Performance_desc');
		if ($id > 0) {
			$id = $id;
		} else {
			$id = $this->request->session()->read('Auth.User.id');
		}
		$ethnicity = $this->Enthicity->find('list')->select(['id', 'title'])->toarray();
		$this->set('ethnicity', $ethnicity);


		$current_user_id = $this->request->session()->read('Auth.User.id');
		//echo $current_user_id; die;
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'State', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);
		$videoprofile = $this->Audio->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofile', $videoprofile);

		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);

		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);
		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $current_user_id])->toarray();
		$this->set('uservitals', $uservitals);
		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);

		//contacts
		$conn = ConnectionManager::get('default');
		$frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$friends = $conn->execute($frnds);
		$this->set('friends', $friends);
		//mutual friends
		$conn = ConnectionManager::get('default');
		//$mutual = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";

		$mutual = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $current_user_id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $current_user_id . "' and c.accepted_status='Y' and p.user_id IN (SELECT p.user_id FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT p.user_id FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y')";

		$mutualfrnd = $conn->execute($mutual);
		$this->set('mutualfrnd', $mutualfrnd);

		// Online friends
		$current_time = date('Y-m-d H:i:s');
		$conn = ConnectionManager::get('default');
		$online_qry = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location, u.last_login FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='Y' and u.last_login > ('" . $current_time . "' - INTERVAL 2 MINUTE) UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location,u.last_login FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y' and u.last_login > ('" . $current_time . "' - INTERVAL 2 MINUTE)";


		// echo $online_qry; die;
		$onlines = $conn->execute($online_qry);
		$onlines = $onlines->fetchAll('assoc');
		$this->set('onlines', $onlines);


		// friends following
		$conn = ConnectionManager::get('default');
		$following = "SELECT c.*,e.title,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, p.ethnicity as ethniid, p.country_ids, p.state_id, p.city_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id  WHERE c.from_id='" . $id . "' and c.accepted_status='N'";
		$follower = $conn->execute($following);
		$following = $follower->fetchAll('assoc');
		$this->set('following', $following);

		foreach ($following as  $key => $value) {
			$cntfetch[] =  $value['country_ids'];
		}

		foreach ($following as  $key => $value) {
			$statefetch[] =  $value['state_id'];
		}

		foreach ($following as  $key => $value) {
			$cityfetch[] =  $value['city_id'];
		}

		if ($cntfetch) {
			$country = $this->Country->find('list')->select(['id', 'name'])->where(['Country.id IN' => $cntfetch])->toarray();
			$this->set('country', $country);
		}

		if ($statefetch) {
			$state = $this->State->find('list')->select(['id', 'name'])->where(['State.id IN' => $statefetch])->toarray();
			$this->set('state', $state);
		}
		if ($cityfetch) {
			$city = $this->City->find('list')->select(['id', 'name'])->where(['City.id IN' => $cityfetch])->toarray();
			$this->set('city', $city);
		}


		// friends followers
		$id = $this->request->session()->read('Auth.User.id');
		$conn = ConnectionManager::get('default');
		$follow = "SELECT c.*,e.title,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, p.ethnicity as ethniid, p.country_ids, p.state_id, p.city_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id WHERE c.to_id='" . $id . "' and c.accepted_status='N'";
		$followers = $conn->execute($follow);
		$followerd = $followers->fetchAll('assoc');
		$this->set('followerd', $followerd);
	}

	public function onlinecontacts($id = null)
	{
		$this->loadModel('Audio');
		$this->loadModel('Users');
		$this->loadModel('Enthicity');
		$this->loadModel('City');
		$this->loadModel('State');
		$this->loadModel('Country');
		$this->loadModel('Professinal_info');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');
		$this->loadModel('Performance_desc');
		if ($id > 0) {
			$id = $id;
		} else {
			$id = $this->request->session()->read('Auth.User.id');
		}
		$ethnicity = $this->Enthicity->find('list')->select(['id', 'title'])->toarray();
		$this->set('ethnicity', $ethnicity);


		$current_user_id = $this->request->session()->read('Auth.User.id');
		//echo $current_user_id; die;
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'State', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);
		$videoprofile = $this->Audio->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofile', $videoprofile);



		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);




		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);
		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $current_user_id])->toarray();
		$this->set('uservitals', $uservitals);
		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);

		//contacts
		$conn = ConnectionManager::get('default');
		$frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$friends = $conn->execute($frnds);
		$this->set('friends', $friends);
		//mutual friends
		$conn = ConnectionManager::get('default');
		//$mutual = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";


		$mutual = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $current_user_id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $current_user_id . "' and c.accepted_status='Y' and p.user_id IN (SELECT p.user_id FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT p.user_id FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y')";

		$mutualfrnd = $conn->execute($mutual);
		$this->set('mutualfrnd', $mutualfrnd);
		$current_time = date('Y-m-d H:i:s');
		// // Online friends
		// $conn = ConnectionManager::get('default');
		// $online_qry = "SELECT c.*,e.title,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, p.ethnicity as ethniid, p.country_ids, p.state_id, p.city_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id  WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*,e.title,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, p.ethnicity as ethniid, p.country_ids, p.state_id, p.city_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id  WHERE c.to_id='" . $id . "' and c.accepted_status='Y' ";
		// // echo $current_time; die;
		// $online_qry .= "and last_login > ('" . $current_time . "' - INTERVAL 2 MINUTE)";
		// //    echo $online_qry; die;
		// $onlines = $conn->execute($online_qry);
		// $onlines = $onlines->fetchAll('assoc');
		// $this->set('onlines', $onlines);


		// $current_time = date('Y-m-d H:i:s');
		$conn = ConnectionManager::get('default');
		$online_qry = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location, u.last_login FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='Y' and u.last_login > ('" . $current_time . "' - INTERVAL 2 MINUTE) UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location,u.last_login FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y' and u.last_login > ('" . $current_time . "' - INTERVAL 2 MINUTE)";

		$onlines = $conn->execute($online_qry);
		$onlines = $onlines->fetchAll('assoc');
		// pr($onlines);exit;
		$this->set('onlines', $onlines);



		foreach ($onlines as  $key => $value) {
			$cntfetch[] =  $value['country_ids'];
		}

		foreach ($onlines as  $key => $value) {
			$statefetch[] =  $value['state_id'];
		}

		foreach ($onlines as  $key => $value) {
			$cityfetch[] =  $value['city_id'];
		}

		if ($cntfetch) {
			$country = $this->Country->find('list')->select(['id', 'name'])->where(['Country.id IN' => $cntfetch])->toarray();
			$this->set('country', $country);
		}

		if ($statefetch) {
			$state = $this->State->find('list')->select(['id', 'name'])->where(['State.id IN' => $statefetch])->toarray();
			$this->set('state', $state);
		}
		if ($cityfetch) {
			$city = $this->City->find('list')->select(['id', 'name'])->where(['City.id IN' => $cityfetch])->toarray();
			$this->set('city', $city);
		}

		// friends following
		$conn = ConnectionManager::get('default');
		$following = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location, u.last_login FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='N'";
		$follower = $conn->execute($following);
		$following = $follower->fetchAll('assoc');
		$this->set('following', $following);


		// friends followers
		$id = $this->request->session()->read('Auth.User.id');
		$conn = ConnectionManager::get('default');
		$follow = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location,u.last_login FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='N'";
		$followers = $conn->execute($follow);
		$followerd = $followers->fetchAll('assoc');
		$this->set('followerd', $followerd);
	}

	public function mutualcontacts($id = null)
	{
		$this->loadModel('Audio');
		$this->loadModel('Users');
		$this->loadModel('Enthicity');
		$this->loadModel('City');
		$this->loadModel('State');
		$this->loadModel('Country');
		$this->loadModel('Professinal_info');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');
		$this->loadModel('Performance_desc');
		if ($id > 0) {
			$id = $id;
		} else {
			$id = $this->request->session()->read('Auth.User.id');
		}
		$ethnicity = $this->Enthicity->find('list')->select(['id', 'title'])->toarray();
		$this->set('ethnicity', $ethnicity);

		$current_user_id = $this->request->session()->read('Auth.User.id');
		//echo $current_user_id; die;
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'State', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);
		$videoprofile = $this->Audio->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofile', $videoprofile);



		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);




		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);
		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $current_user_id])->toarray();
		$this->set('uservitals', $uservitals);
		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);

		//contacts
		$conn = ConnectionManager::get('default');
		$frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$friends = $conn->execute($frnds);
		$this->set('friends', $friends);
		//mutual friends
		$conn = ConnectionManager::get('default');

		$mutual = "SELECT c.*,e.title,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, p.ethnicity as ethniid, p.country_ids, p.state_id, p.city_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id WHERE c.from_id='" . $current_user_id . "' and c.accepted_status='Y' UNION SELECT c.*,e.title,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, p.ethnicity as ethniid, p.country_ids, p.state_id, p.city_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id WHERE c.to_id='" . $current_user_id . "' and c.accepted_status='Y' and p.user_id IN (SELECT p.user_id FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT p.user_id FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y')";

		$mutualfrnd = $conn->execute($mutual);
		$mutualfrnd = $mutualfrnd->fetchAll('assoc');

		$this->set('mutualfrnd', $mutualfrnd);





		foreach ($mutualfrnd as  $key => $value) {
			$cntfetch[] =  $value['country_ids'];
		}

		foreach ($mutualfrnd as  $key => $value) {
			$statefetch[] =  $value['state_id'];
		}

		foreach ($mutualfrnd as  $key => $value) {
			$cityfetch[] =  $value['city_id'];
		}

		if ($cntfetch) {
			$country = $this->Country->find('list')->select(['id', 'name'])->where(['Country.id IN' => $cntfetch])->toarray();
			$this->set('country', $country);
		}

		if ($statefetch) {
			$state = $this->State->find('list')->select(['id', 'name'])->where(['State.id IN' => $statefetch])->toarray();
			$this->set('state', $state);
		}
		if ($cityfetch) {
			$city = $this->City->find('list')->select(['id', 'name'])->where(['City.id IN' => $cityfetch])->toarray();
			$this->set('city', $city);
		}
		// Online friends
		$current_time = date('Y-m-d H:i:s');

		$conn = ConnectionManager::get('default');
		$online_qry = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location, u.last_login FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='Y' and u.last_login > ('" . $current_time . "' - INTERVAL 2 MINUTE) UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location,u.last_login FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y' and u.last_login > ('" . $current_time . "' - INTERVAL 2 MINUTE)";






		// echo $online_qry; die;
		$onlines = $conn->execute($online_qry);
		$onlines = $onlines->fetchAll('assoc');
		$this->set('onlines', $onlines);


		// friends following
		$conn = ConnectionManager::get('default');
		$following = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location, u.last_login FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='N'";
		$follower = $conn->execute($following);
		$following = $follower->fetchAll('assoc');
		$this->set('following', $following);


		// friends followers
		$id = $this->request->session()->read('Auth.User.id');
		$conn = ConnectionManager::get('default');
		$follow = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location,u.last_login FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='N'";
		$followers = $conn->execute($follow);
		$followerd = $followers->fetchAll('assoc');
		$this->set('followerd', $followerd);
	}

	public function profilelikedusers($user_id)
	{
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$content_type = 'profile';
		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $user_id])->toarray();
		$this->set('findall', $totallikes);
	}

	public function quickreviewshow($jobid, $artistid)
	{
		$this->loadModel('Review');
		$quireview = $this->Review->find('all')->contain(['Requirement'])->where(['Review.job_id' => $jobid, 'Review.artist_id' => $artistid])->first();
		$this->set('review', $quireview);
	}

	public function viewrating($job_review)
	{
		$this->loadModel('Review');
		$current_user_id = $this->request->session()->read('Auth.User.id');

		$review = $this->Review->find('all')->contain(['Requirement'])->where(['Review.id' => $job_review])->toarray();

		$this->set('review', $review);
	}
	public function reportspamsearch($profile_id)
	{
		$this->set('profile_id', $profile_id);
	}

	public function sendmessagesearch($profile_id)
	{
		$this->set('profile_id', $profile_id);
	}

	public function calendar() {}

	public function profilePdf($profile_id)
	{

		$this->loadModel('Requirement');
		$this->loadModel('Users');
		$this->loadModel('JobQuote');
		$this->loadModel('JobApplication');
		$this->loadModel('Skillset');
		$this->loadModel('Profile');
		$this->loadModel('Subscription');
		$this->loadModel('RecuriterPack');
		$this->loadModel('Packfeature');
		$this->loadModel('Professinal_info');
		$this->loadModel('Current_working');
		$this->loadModel('Prof_exprience');
		$this->loadModel('Audio');
		$this->loadModel('Talent_portfolio');
		$this->loadModel('Personnel_det');
		$this->loadModel('Performance_desc');
		$this->loadModel('Performancelanguage');
		$this->loadModel('Language');
		$this->loadModel('Genreskills');
		$this->loadModel('Genre');
		$this->loadModel('Skillset');
		$this->loadModel('Performancedesc2');
		$this->loadModel('Currency');
		$this->loadModel('Paymentfequency');
		$this->loadModel('Uservital');
		$this->loadModel('Vques');
		$this->loadModel('Voption');

		$conn = ConnectionManager::get('default');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$current_user = $this->Users->find('all')->where(['Users.id' => $current_user_id])->first();
		$this->loadModel('Profilecounter');
		$count = $this->Profilecounter->find('all')->where(['Profilecounter.user_id' => $current_user_id, 'Profilecounter.profile_id' => $profile_id])->first();
		// $profilecounter = $count['counter']+1;
		$profilecounter = $this->Profilecounter->find('all')->where(['Profilecounter.user_id' => $current_user_id])->count();
		$profilecounter = $profilecounter + 1;
		$pack_data = $this->Subscription->find('all')->where(['Subscription.user_id' => $current_user_id, 'Subscription.package_type' => 'RE'])->first();
		$pack_all_data = $this->RecuriterPack->find('all')->where(['RecuriterPack.id' => $pack_data['package_id']])->first();
		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $profile_id])->first();
		$this->set('profile_title', $profile_title);
		$currentworking = $this->Current_working->find('all')->where(['user_id' => $profile_id])->first();
		$this->set('currentworking', $currentworking);

		$profexp = $this->Prof_exprience->find('all')->where(['user_id' => $profile_id])->first();
		$this->set('profexp', $profexp);

		$videoprofile = $this->Audio->find('all')->where(['user_id' => $profile_id])->first();
		$this->set('videoprofile', $videoprofile);

		$videoprofiletalentpro = $this->Talent_portfolio->find('all')->where(['user_id' => $profile_id])->first();
		$this->set('videoprofiletalentpro', $videoprofiletalentpro);

		$videoprofilepersoneeldet = $this->Personnel_det->find('all')->where(['user_id' => $profile_id])->first();
		$this->set('videoprofilepersoneeldet', $videoprofilepersoneeldet);

		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $profile_id])->first();
		$this->set('perdes', $perdes);

		$languageknow = $this->Performancelanguage->find('all')->select(['id', 'language_id', 'Language.name'])->contain(['Language'])->where(['Performancelanguage.user_id' => $profile_id])->order(['Performancelanguage.id' => 'DESC'])->toarray();
		$this->set('languageknow', $languageknow);

		$skills_set = $this->Skillset->find('all')->select(['skill_id'])->where(['Skillset.user_id' => $profile_id])->order(['Skillset.id' => 'DESC'])->toarray();
		foreach ($skills_set as $skills) {
			$userskills[] = $skills['skill_id'];
		}
		if (count($userskills) == 0) {
			$userskills = 0;
		}
		$genre = $this->Genreskills->find('all')->select(['Genre.id', 'Genre.name'])->contain(['Genre'])->where(['Genreskills.skill_id IN' => $userskills, 'Genre.parent' => 0, 'Genre.status' => 'Y'])->group('Genreskills.genre_id')->toarray();

		$this->set('genre', $genre);
		foreach ($genre as $gemreres) {
			$gens_id[] = $gemreres['Genre']['id'];
		}
		if ($gens_id) {
			$subgenre = $this->Genre->find('all')->where(['Genre.parent IN' => $gens_id, 'status' => 'Y'])->toarray();
		}
		$this->set('subgenre', $subgenre);

		$payfrequency = $this->Performancedesc2->find('all')->contain(['Currency', 'Paymentfequency'])->where(['user_id' => $profile_id])->toarray();
		$this->set('payfrequency', $payfrequency);


		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $profile_id])->toarray();
		$this->set('uservitals', $uservitals);


		$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $profile_id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $profile_id . "' and c.accepted_status='Y'";
		$stmt = $conn->execute($fquery);
		$friends = $stmt->fetchAll('assoc');
		foreach ($friends  as $value) {
			if ($value['from_id'] == $current_user_id || $value['to_id'] == $current_user_id) {
				$valid[] = '1';
			} else {
				$valid[] = 0;
			}
		}

		/*
		//$this->response->type('pdf');
		$profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','Country'])->where(['user_id' => $profile_id])->first();
		$this->set('profile', $profile);
		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $profile_id])->order(['Skillset.id' => 'DESC'])->toarray();
		$this->set('skillofcontaint', $contentadminskillset);
		
		if(in_array("1", $valid)){ }else{
		  
		
		
		
		if($count=='')
		{
		$this->request->data['user_id']=$current_user_id;
		$this->request->data['profile_id']=$profile_id;
		$this->request->data['counter']='1';
		$options = $this->Profilecounter->newEntity();
		$option_arr = $this->Profilecounter->patchEntity($options, $this->request->data);
		$savedata = $this->Profilecounter->save($option_arr);
		}else{
		$users= TableRegistry::get('Profilecounter');
		$counteradd= 'counter + 1';
		$con = ConnectionManager::get('default');
		$detail = 'UPDATE `profilecounter` SET `counter` ='.$counteradd.' WHERE `profilecounter`.`profile_id` = ' . $profile_id;
		$results = $con->execute($detail);
	    }
		}
		*/

		$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $current_user_id])->order(['Packfeature.id' => 'ASC'])->first();

		//	if($profilecounter<=$pack_all_data['number_of_contact_details'] || in_array("1", $valid)){
		if ($profilecounter <= $packfeature['number_of_contact_details'] || in_array("1", $valid)) {

			$this->response->type('pdf');
			$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'Country'])->where(['user_id' => $profile_id])->first();
			$this->set('profile', $profile);
			$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $profile_id])->order(['Skillset.id' => 'DESC'])->toarray();
			$this->set('skillofcontaint', $contentadminskillset);

			if (in_array("1", $valid)) {
			} else {




				if ($count == '') {
					$this->request->data['user_id'] = $current_user_id;
					$this->request->data['profile_id'] = $profile_id;
					$this->request->data['counter'] = '1';
					$options = $this->Profilecounter->newEntity();
					$option_arr = $this->Profilecounter->patchEntity($options, $this->request->data);
					$savedata = $this->Profilecounter->save($option_arr);
				} else {
					$users = TableRegistry::get('Profilecounter');
					$counteradd = 'counter + 1';
					$con = ConnectionManager::get('default');
					$detail = 'UPDATE `profilecounter` SET `counter` =' . $counteradd . ' WHERE `profilecounter`.`profile_id` = ' . $profile_id;
					$results = $con->execute($detail);
				}
			}
		} else {
			//$this->Flash->error(__('Profile download limit is expired'));
			// $this->Flash->error(__('You cannot download any more profiles. You can upgrade your package to download'));
			// $this->redirect( Router::url( $this->referer(), true ));
		}
	}

	public function calendarinformation()
	{
		$this->autoRender = false;
		$eventListHTML = '';
		$type = $this->request->data['fun_type'];
		$informationdate = $this->request->data['date'];
		//$currentDate = $date_Year.'-'.$date_Month.'-'.$dayCount;
		$currentdate = date('Y-m-d');
		$this->loadModel('Calendar');

		$conn = ConnectionManager::get('default');
		$frnds = "SELECT from_date,title FROM calendar WHERE `user_id` ='" . $_SESSION['Auth']['User']['id'] . "' and   STR_TO_DATE(`from_date`,'%Y-%m-%d')  = '" . $informationdate . "'";
		$onlines = $conn->execute($frnds);
		$event = $onlines->fetchAll('assoc');

		//$event = $this->Calendar->find('all')->where(['Calendar.from_date' => $informationdate])->toarray();
		$events = count($event);
		if ($events > 0) {
			$eventListHTML .= '<div class="modal-content">';
			$eventListHTML .= '<span class="close"><a href="#" onclick="close_popup("event_list")">×</a></span>';
			$eventListHTML .= '<h2>Events on ' . date("l, d M Y", strtotime($informationdate)) . '</h2>';
			$eventListHTML .= '<ul>';
			foreach ($event as $eventrec) {
				$eventListHTML .= '<li>' . $eventrec['title'] . '</li>';
			}
			$eventListHTML .= '</ul>';
			$eventListHTML .= '</div>';
		}
		echo $eventListHTML;
	}

	public function viewpersonalpage()
	{
		$id = $this->request->session()->read('Auth.User.id');
		$this->loadModel('PersonalPage');
		$viewpage = $this->PersonalPage->find('all')->where(['user_id' => $id])->first();
		$this->set('viewpage', $viewpage);
	}

	public function findUsername($username = null)
	{
		$this->loadModel('Users');
		$username = $this->request->data['username'];
		echo $username;
		$user = $this->Users->find('all')->where(['Users.guardianemailaddress' => $username])->toArray();
		echo $user[0]['id'];
		die;
	}

	public function tabget()
	{
		$name = $this->request->data['action'];
		header('Content-Type: application/json');
		echo json_encode($name);
		exit();
	}

	public function search($id)
	{
		$name = $this->request->data['name'];

		$tab = $this->request->data['tab'];
		if ($id > 0) {
			$id = $id;
		} else {
			$id = $this->request->session()->read('Auth.User.id');
		}

		$current_user_id = $this->request->session()->read('Auth.User.id');
		if ($tab == 'contacts') {
			if (!empty($name)) {
				$res	= "and p.name LIKE '%$name%'";
			} else {
				$res = '';
			}
			$conn = ConnectionManager::get('default');
			$frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='Y' $res UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y' $res";
			$friends = $conn->execute($frnds);
			$this->set('friends', $friends);
		}
		if ($tab == 'mutual') {
			if (!empty($name)) {
				$res	= "and p.name LIKE '%$name%'";
			} else {
				$res = '';
			}
			$conn = ConnectionManager::get('default');
			$frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $current_user_id . "' and c.accepted_status='Y' $res UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $current_user_id . "' and c.accepted_status='Y' $res and p.user_id IN (SELECT p.user_id FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT p.user_id FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y')";
			$friends = $conn->execute($frnds);
			$this->set('friends', $friends);
		}



		if ($tab == 'online') {
			if (!empty($name)) {
				$res	= "and p.name LIKE '%$name%'";
			} else {
				$res = '';
			}
			$conn = ConnectionManager::get('default');
			$frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location, u.last_login FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='Y' $res and TIMESTAMPDIFF(MINUTE,u.last_login,NOW()) < 5 UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location,u.last_login FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y' $res and TIMESTAMPDIFF(MINUTE,u.last_login,NOW()) < 5";
			$friends = $conn->execute($frnds);
			$this->set('friends', $friends);
		}


		if ($tab == 'following') {
			if (!empty($name)) {
				$res	= "and p.name LIKE '%$name%'";
			} else {
				$res = '';
			}
			$conn = ConnectionManager::get('default');
			$frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location, u.last_login FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='N' $res";
			$friends = $conn->execute($frnds);
			$this->set('friends', $friends);
		}


		if ($tab == 'followers') {
			if (!empty($name)) {
				$res	= "and p.name LIKE '%$name%'";
			} else {
				$res = '';
			}
			$conn = ConnectionManager::get('default');
			$frnds = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location,u.last_login FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='N' $res";
			$friends = $conn->execute($frnds);
			$this->set('friends', $friends);
		}
	}

	public function imagecrop()
	{
		$profile_image = $this->request->data['profile_image'];
		pr($this->request->data);
		exit;
	}

	public function personalpage()
	{
		$this->loadModel('PersonalPage');
		$id = $this->request->session()->read('Auth.User.id');
		$profiled = $this->PersonalPage->find('all')->where(['user_id' => $id])->first();
		$idcheck = count($profiled);
		if ($idcheck > 0) {
			$pagepersonal = $this->PersonalPage->find('all')->where(['user_id' => $id])->first();
		} else {
			$pagepersonal = $this->PersonalPage->newEntity();
		}
		// pr($pagepersonal);exit;
		$this->set('pagepersonal', $pagepersonal);

		if ($this->request->is(['post', 'put'])) {
			// pr($this->request->data);exit;
			$this->request->data['user_id'] = $id;
			$pagepersonals = $this->PersonalPage->patchEntity($pagepersonal, $this->request->data);
			$savedprofile = $this->PersonalPage->save($pagepersonals);

			if ($savedprofile) {
				$this->Flash->success(__('Saved Successfully'));
				return $this->redirect(['action' => 'personalpage']);
			}
		}
	}

	public function allcontacts($id = null)
	{
		$this->loadModel('Audio');
		$this->loadModel('Users');
		$this->loadModel('Enthicity');
		$this->loadModel('City');
		$this->loadModel('State');
		$this->loadModel('Country');
		$this->loadModel('Professinal_info');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');
		$this->loadModel('Performance_desc');
		$this->loadModel('Likes');
		if ($id > 0) {
			$id = $id;
		} else {
			$id = $this->request->session()->read('Auth.User.id');
		}

		$content_type = 'profile';
		$ethnicity = $this->Enthicity->find('list')->select(['id', 'title'])->toarray();
		$this->set('ethnicity', $ethnicity);



		$country = $this->Country->find('list')->select(['id', 'name'])->toarray();
		$this->set('country', $country);
		$current_user_id = $this->request->session()->read('Auth.User.id');
		//echo $current_user_id; die;
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'State', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);
		$videoprofile = $this->Audio->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofile', $videoprofile);



		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);




		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);
		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $current_user_id])->toarray();
		$this->set('uservitals', $uservitals);
		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);

		//contacts
		$conn = ConnectionManager::get('default');
		$conn = ConnectionManager::get('default');
		$frnds = "SELECT c.*,e.title,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, p.ethnicity as ethniid, p.country_ids, p.state_id, p.city_id, cn.name as countryname ,p.dob, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id  WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*,e.title,TIMESTAMPDIFF(DAY,u.last_login,NOW())as active, p.ethnicity as ethniid, p.country_ids, p.state_id, p.city_id, cn.name as countryname, p.dob, p.user_id, p.name,p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id left join enthicity e on p.ethnicity=e.id left join country cn on p.country_ids=cn.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$friends = $conn->execute($frnds);
		$friends = $friends->fetchAll('assoc');
		$this->set('friends', $friends);

		$friends = $conn->execute($frnds);


		foreach ($friends as  $key => $value) {
			$cntfetch[] =  $value['country_ids'];
		}

		foreach ($friends as  $key => $value) {
			$statefetch[] =  $value['state_id'];
		}

		foreach ($friends as  $key => $value) {
			$cityfetch[] =  $value['city_id'];
		}


		$cntfetch = array_unique($cntfetch);
		$statefetch = array_unique($statefetch);
		$cityfetch = array_unique($cityfetch);
		$this->set('friends', $friends);
		if ($cntfetch) {
			$country = $this->Country->find('list')->select(['id', 'name'])->where(['Country.id IN' => $cntfetch])->toarray();
			$this->set('country', $country);
		}

		if ($statefetch) {
			$state = $this->State->find('list')->select(['id', 'name'])->where(['State.id IN' => $statefetch])->toarray();
			$this->set('state', $state);
		}
		if ($cityfetch) {
			$city = $this->City->find('list')->select(['id', 'name'])->where(['City.id IN' => $cityfetch])->toarray();
			$this->set('city', $city);
		}
		//mutual friends
		$conn = ConnectionManager::get('default');
		//$mutual = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='".$id."' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='".$id."' and c.accepted_status='Y'";


		$mutual = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $current_user_id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $current_user_id . "' and c.accepted_status='Y' and p.user_id IN (SELECT p.user_id FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT p.user_id FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y')";

		$mutualfrnd = $conn->execute($mutual);
		$this->set('mutualfrnd', $mutualfrnd);

		// Online friends
		$current_time = date('Y-m-d H:i:s');
		$conn = ConnectionManager::get('default');
		$online_qry = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location, u.last_login FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='Y' and u.last_login > ('" . $current_time . "' - INTERVAL 2 MINUTE) UNION SELECT c.*, p.user_id, p.name, p.profile_image, p.location,u.last_login FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y' and u.last_login > ('" . $current_time . "' - INTERVAL 2 MINUTE)";


		// echo $online_qry; die;
		$onlines = $conn->execute($online_qry);
		$onlines = $onlines->fetchAll('assoc');
		$this->set('onlines', $onlines);


		// friends following
		$conn = ConnectionManager::get('default');
		$following = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location, u.last_login FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id   WHERE c.from_id='" . $id . "' and c.accepted_status='N'";
		$follower = $conn->execute($following);
		$following = $follower->fetchAll('assoc');
		$this->set('following', $following);


		// friends followers
		$id = $this->request->session()->read('Auth.User.id');
		$conn = ConnectionManager::get('default');
		$follow = "SELECT c.*, p.user_id, p.name, p.profile_image, p.location,u.last_login FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='N'";
		$followers = $conn->execute($follow);
		$followerd = $followers->fetchAll('assoc');
		$this->set('followerd', $followerd);
	}

	// public function deleteuser()
	// {
	// 	$this->loadModel('Contactrequest');
	// 	$this->loadModel('Packfeature');
	// 	$this->loadModel('Users');
	// 	$this->autoRender = false;
	// 	$users = TableRegistry::get('Contactrequest');
	// 	$status = "Y";
	// 	$con = ConnectionManager::get('default');
	// 	$id = $this->request->session()->read('Auth.User.id');

	// 	$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();
	// 	$packfeature_idappli = $packfeature['id'];
	// 	$packfeatureapplication = $this->Packfeature->get($packfeature_idappli);

	// 	$application['introduction_sent'] = $pcakgeinformation['introduction_sent'] + 1;

	// 	$application['number_of_introduction'] = $pcakgeinformation['number_of_introduction'] + 1;


	// 	$packfeaturesapp = $this->Packfeature->patchEntity($packfeatureapplication, $application);

	// 	$result = $this->Packfeature->save($packfeaturesapp);

	// 	$user_data = $this->Users->find('all')->where(['id' => $id])->first();
	// 	if ($user_data['con_req_noti_count'] >= 1) {
	// 		$dataa['con_req_noti_count'] = $user_data['con_req_noti_count'] - 1;
	// 		$savepackk = $this->Users->patchEntity($user_data, $dataa);
	// 		$this->Users->save($savepackk);
	// 	}

	// 	$detail = 'UPDATE `contactrequest` SET `deletestatus` ="' . $status . '" WHERE `contactrequest`.`id` = ' . $this->request->data['profile'];
	// 	$results = $con->execute($detail);
	// }

	// Rupam singh 
	public function deleteuser()
	{
		$this->loadModel('Contactrequest');
		$this->loadModel('Packfeature');
		$this->loadModel('Users');
		$this->loadModel('Notification');
		$this->autoRender = false;

		$id = $this->request->session()->read('Auth.User.id');
		$profileId = $this->request->data['profile'];

		// Fetch the contact request
		$contactRequest = $this->Contactrequest->find()
			->where(['id' => $profileId])
			->first();

		if ($contactRequest) {
			// If contact request exists, proceed with updates
			// Update contact request deletestatus
			// $contactRequest->deletestatus = 'Y';
			// $this->Contactrequest->save($contactRequest);
			$this->Contactrequest->deleteAll(['Contactrequest.id' => $contactRequest['id']]);

			// Fetch the active package and update usage
			$packfeature = $this->Packfeature->find('all')
				->where(['user_id' => $contactRequest['from_id']])
				->andWhere(['OR' => [
					['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
					['package_status' => 'default']
				]])
				->select(['id'])
				->order(['id' => 'DESC'])
				->first();
			$packfeatureId = $packfeature['id'];
			$packfeatureEntity = $this->Packfeature->get($packfeatureId);
			$packfeatureEntity->number_of_introduction_used -= 1;
			$this->Packfeature->save($packfeatureEntity);

			// Fetch user data and update con_req_noti_count if applicable
			$user = $this->Users->get($id);
			if ($user->con_req_noti_count >= 1) {
				$user->con_req_noti_count -= 1;
				$this->Users->save($user);
			}

			// Send like notification
			$notification = $this->Notification->newEntity([
				'notification_sender' => $id,
				'notification_receiver' => $contactRequest['from_id'],
				'type' => 'request deleted',
			]);
			$this->Notification->save($notification);
		}
	}

	// Rupam singh 
	public function confirmuser()
	{
		$this->loadModel('Contactrequest');
		$this->loadModel('Users');
		$this->loadModel('Notification');
		$this->autoRender = false;

		// Get the authenticated user ID
		$id = $this->request->session()->read('Auth.User.id');

		$recieverid = $this->request->data['userid'];
		$profileId = $this->request->data['profile'];

		// Fetch the contact request
		$contactRequest = $this->Contactrequest->find()
			->where(['id' => $profileId])
			->first();

		if (!$contactRequest) {
			// If no contact request is found, exit
			return;
		}

		// Fetch user data
		$user_data = $this->Users->get($id);

		if ($user_data->con_req_noti_count >= 1) {
			$user_data->con_req_noti_count -= 1; // Decrement notification count
			$this->Users->save($user_data);
		}

		// Update contact request status
		$contactRequest->accepted_status = 'Y';
		$this->Contactrequest->save($contactRequest);

		// Send like notification
		$notification = $this->Notification->newEntity([
			'notification_sender' => $id,
			'notification_receiver' => $recieverid,
			'type' => 'request accept',
		]);
		$this->Notification->save($notification);
	}



	// public function confirmuser()
	// {
	// 	$this->loadModel('Contactrequest');
	// 	$this->loadModel('Packfeature');
	// 	$this->loadModel('Users');
	// 	$this->autoRender = false;

	// 	$users = TableRegistry::get('Contactrequest');
	// 	$status = "Y";
	// 	$con = ConnectionManager::get('default');
	// 	$id = $this->request->session()->read('Auth.User.id');

	// 	$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();
	// 	$packfeature_idappli = $packfeature['id'];
	// 	$packfeatureapplication = $this->Packfeature->get($packfeature_idappli);
	// 	$application['introduction_sent'] = $pcakgeinformation['introduction_sent'] - 1;
	// 	$application['number_of_introduction'] = $pcakgeinformation['number_of_introduction'] - 1;

	// 	$packfeaturesapp = $this->Packfeature->patchEntity($packfeatureapplication, $application);
	// 	$result = $this->Packfeature->save($packfeaturesapp);

	// 	$user_data = $this->Users->find('all')->where(['id' => $id])->first();
	// 	if ($user_data['con_req_noti_count'] >= 1) {
	// 		$dataa['con_req_noti_count'] = $user_data['con_req_noti_count'] - 1;
	// 		$savepackk = $this->Users->patchEntity($user_data, $dataa);
	// 		$this->Users->save($savepackk);
	// 	}


	// 	//send like notification
	// 	$this->loadModel('Notification');
	// 	$senderid = $this->request->session()->read('Auth.User.id');
	// 	$recieverid = $this->request->data['userid'];
	// 	$noti = $this->Notification->newEntity();
	// 	$notification['notification_sender'] = $senderid;
	// 	$notification['notification_receiver'] = $recieverid;
	// 	$notification['type'] = "request accept";
	// 	$notification = $this->Notification->patchEntity($noti, $notification);
	// 	$this->Notification->save($notification);

	// 	$detail = 'UPDATE `contactrequest` SET `accepted_status` ="' . $status . '" WHERE `contactrequest`.`id` = ' . $this->request->data['profile'];
	// 	$results = $con->execute($detail);
	// }

	public function checknotification()
	{
		$this->autoRender = false;
		$users = TableRegistry::get('Contactrequest');
		$status = "Y";
		$con = ConnectionManager::get('default');
		$id = $this->request->session()->read('Auth.User.id');
		$detail = 'UPDATE `contactrequest` SET `viewedstatus` ="' . $status . '" WHERE `contactrequest`.`to_id` = ' . $id;
		$results = $con->execute($detail);
	}

	// Contact Request
	public function contactrequest()
	{
		$error = '';
		$rstatus = '';
		$this->autoRender = false;
		$this->loadModel('Contactrequest');
		$id = $this->request->session()->read('Auth.User.id');
		$this->request->data['to_id'] = $this->request->data['profile'];
		$this->request->data['from_id'] = $id;
		$contactrequest =
			$this->Contactrequest->find('all')->where(['Contactrequest.from_id' => $id, 'Contactrequest.to_id' => $this->request->data['profile']])->count();
		$this->set('contactrequest', $contactrequest);
		if ($contactrequest > 0) {
			$this->Contactrequest->deleteAll(['Contactrequest.to_id' => $this->request->data['profile'], 'Contactrequest.from_id' => $id]);
			$error = 'Contact Request Cancelled.';
			$rstatus = 0;
		} else {
			$userrequest = $this->Contactrequest->newEntity();
			$user_req = $this->Contactrequest->patchEntity($userrequest, $this->request->data);
			if ($this->Contactrequest->save($user_req)) {
				$rstatus = 1;
			}
		}
		$response['error'] = $error;
		$response['status'] = $rstatus;
		echo json_encode($response);
		die;
		die;
	}

	// Show contact information and Update Profile Visit counter

	public function profilecountersearch($profile_id)
	{
		$this->loadModel('Requirement');
		$this->loadModel('Users');
		$this->loadModel('JobQuote');
		$this->loadModel('JobApplication');
		$this->autoRender = false;
		$error = '';
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$current_user = $this->Users->find('all')->where(['Users.id' => $current_user_id])->first();

		$role_id = $current_user['role_id'];
		if ($role_id == TALANT_ROLEID) {
			$show_contactinfo = 1;
		} else if ($role_id == NONTALANT_ROLEID) {
			$job_quotes = 0;
			$jobapplication = 0;
			$requirementfeatured = $this->Requirement->find('list')->contain([])->where(['Requirement.user_id' => $current_user_id])->order(['Requirement.id' => 'DESC'])->toarray();
			$this->set('requirementfeatured', $requirementfeatured);
			foreach ($requirementfeatured as $jobkey => $value) {
				$job_array[] = $jobkey;
			}
			if (count($job_array) > 0) {
				//$jobposts = 
				$job_quotes = $this->JobQuote->find('all')->where(['JobQuote.job_id IN' => $job_array, 'JobQuote.user_id' => $profile_id])->count();
				$jobapplication = $this->JobApplication->find('all')->where(['JobApplication.job_id IN' => $job_array, 'JobApplication.user_id' => $profile_id])->count();
			}
			if ($job_quotes > 0 || $jobapplication > 0) {
				$show_contactinfo = 1;
			} else {
				$show_contactinfo = 0;
				$this->Flash->error(__('You are not authorized to access the contact details of this user.'));
				$this->redirect(Router::url($this->referer(), true));
			}
		} else {
			$show_contactinfo = 0;
			$this->redirect(Router::url($this->referer(), true));
		}

		if ($show_contactinfo == '1') {
			$this->loadModel('Profilecounter');
			$count = $this->Profilecounter->find('all')->where(['Profilecounter.user_id' => $current_user_id, 'Profilecounter.profile_id' => $profile_id])->first();
			if ($count == 0 && $current_user_id != $profile_id) {
				$this->request->data['user_id'] = $current_user_id;
				$this->request->data['profile_id'] = $profile_id;
				$options = $this->Profilecounter->newEntity();
				$option_arr = $this->Profilecounter->patchEntity($options, $this->request->data);
				$savedata = $this->Profilecounter->save($option_arr);
			}
			$users = TableRegistry::get('Profilecounter');
			$counteradd = 'counter + 1';
			$con = ConnectionManager::get('default');
			$detail = 'UPDATE `profilecounter` SET `counter` =' . $counteradd . ' WHERE `profilecounter`.`profile_id` = ' . $profile_id;
			$results = $con->execute($detail);
			return $this->redirect(['controller' => 'profile', 'action' => 'profilePdf/' . $profile_id]);
		}
	}

	// rupam singh 31-Jan 2025
	public function profilecounter()
	{
		$this->loadModel('Requirement');
		$this->loadModel('Users');
		$this->loadModel('JobQuote');
		$this->loadModel('JobApplication');
		$this->loadModel('Skillset');
		$this->loadModel('Profile');
		$this->loadModel('Subscription');
		$this->loadModel('RecuriterPack');
		$this->loadModel('Packfeature');
		$this->loadModel('Profilecounter');

		$this->autoRender = false;
		// pr($this->request->data['data']);exit;
		$profile_id = $this->request->data['data'];

		$current_user_id = $this->request->session()->read('Auth.User.id');
		$conn = ConnectionManager::get('default');

		$packfeature = $this->activePackage('RC');
		$profileViewLimit = $packfeature['number_of_contact_details'] ?? 0;
		$profileViewCount = $this->Profilecounter->find()->where(['user_id' => $current_user_id])->count();

		// Check if the user has already viewed this profile
		$profileExists = $this->Profilecounter->exists(['user_id' => $current_user_id, 'profile_id' => $profile_id]);

		// Fetch mutual contacts
		$friendsQuery = "SELECT c.*, p.user_id FROM `contactrequest` c 
						 INNER JOIN users u ON c.to_id = u.id 
						 INNER JOIN personal_profile p ON p.user_id = u.id 
						 WHERE c.from_id = :profile_id AND c.accepted_status = 'Y' 
						 UNION 
						 SELECT c.*, p.user_id FROM `contactrequest` c 
						 INNER JOIN users u ON c.from_id = u.id 
						 INNER JOIN personal_profile p ON p.user_id = u.id 
						 WHERE c.to_id = :profile_id AND c.accepted_status = 'Y'";
		$stmt = $conn->execute($friendsQuery, ['profile_id' => $profile_id]);
		$friends = $stmt->fetchAll('assoc');

		$valid = array_column($friends, 'user_id');
		$isFriend = in_array($current_user_id, $valid);

		$profile = $this->Profile->find()->contain(['Users', 'Enthicity', 'City', 'Country'])->where(['user_id' => $profile_id])->first();
		$this->set(compact('profile'));

		// Check if user can view the profile
		if ($profileViewCount < $profileViewLimit || $isFriend || $profile_id == $current_user_id) {
			// $this->response = $this->response->withType('pdf');
			// pr($profile);exit;

			$skills = $this->Skillset->find()->contain(['Skill'])->where(['Skillset.user_id' => $profile_id])->order(['Skillset.id' => 'DESC'])->toArray();
			$this->set('skillofcontaint', $skills);

			if (!$isFriend && $profile_id != $current_user_id) {
				if (!$profileExists) {
					$newProfileView = $this->Profilecounter->newEntity([
						'user_id' => $current_user_id,
						'profile_id' => $profile_id,
						'counter' => 1
					]);
					$this->Profilecounter->save($newProfileView);
				} else {
					$conn->execute(
						"UPDATE profilecounter SET counter = counter + 1 WHERE user_id = :user_id AND profile_id = :profile_id",
						['user_id' => $current_user_id, 'profile_id' => $profile_id]
					);
				}
			}

			$response = ['error' => '', 'status' => 1];
		} else {
			$response = ['error' => 'You cannot view any more contact details. Upgrade your package.', 'status' => 0];
		}

		echo json_encode($response);
		die;
	}

	// public function profilecounter()
	// {
	// 	$this->loadModel('Requirement');
	// 	$this->loadModel('Users');
	// 	$this->loadModel('JobQuote');
	// 	$this->loadModel('JobApplication');
	// 	$this->loadModel('Skillset');
	// 	$this->loadModel('Profile');
	// 	$this->loadModel('Subscription');
	// 	$this->loadModel('RecuriterPack');
	// 	$this->loadModel('Packfeature');
	// 	$this->autoRender = false;
	// 	$error = '';
	// 	$profile_id = $this->request->data['data'];
	// 	$conn = ConnectionManager::get('default');
	// 	$current_user_id = $this->request->session()->read('Auth.User.id');
	// 	$current_user = $this->Users->find('all')->where(['Users.id' => $current_user_id])->first();
	// 	$this->loadModel('Profilecounter');
	// 	$count = $this->Profilecounter->find('all')->where(['Profilecounter.user_id' => $current_user_id, 'Profilecounter.profile_id' => $profile_id])->first();
	// 	//$profilecounter = $count['counter']+1;
	// 	$profilecounter = $this->Profilecounter->find('all')->where(['Profilecounter.user_id' => $current_user_id])->count();
	// 	$profilecounter = $profilecounter + 1;

	// 	$pack_data = $this->Subscription->find('all')->where(['Subscription.user_id' => $current_user_id, 'Subscription.package_type' => 'RE'])->first();
	// 	$pack_all_data = $this->RecuriterPack->find('all')->where(['RecuriterPack.id' => $pack_data['package_id']])->first();


	// 	$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $profile_id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $profile_id . "' and c.accepted_status='Y'";
	// 	$stmt = $conn->execute($fquery);
	// 	$friends = $stmt->fetchAll('assoc');
	// 	foreach ($friends  as $value) {
	// 		if ($value['from_id'] == $current_user_id || $value['to_id'] == $current_user_id) {
	// 			$valid[] = '1';
	// 		} else {
	// 			$valid[] = 0;
	// 		}
	// 	}

	// 	$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $current_user_id])->order(['Packfeature.id' => 'ASC'])->first();

	// 	if ($profilecounter <= $packfeature['number_of_contact_details']  || in_array("1", $valid) || $profile_id == $current_user_id) {
	// 		$this->response->type('pdf');
	// 		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'Country'])->where(['user_id' => $profile_id])->first();
	// 		$this->set('profile', $profile);
	// 		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $profile_id])->order(['Skillset.id' => 'DESC'])->toarray();
	// 		$this->set('skillofcontaint', $contentadminskillset);
	// 		if (in_array("1", $valid) || $profile_id == $current_user_id) {
	// 		} else {
	// 			if ($count == '') {
	// 				$this->request->data['user_id'] = $current_user_id;
	// 				$this->request->data['profile_id'] = $profile_id;
	// 				$this->request->data['counter'] = '1';
	// 				$options = $this->Profilecounter->newEntity();
	// 				$option_arr = $this->Profilecounter->patchEntity($options, $this->request->data);
	// 				$savedata = $this->Profilecounter->save($option_arr);
	// 			} else {
	// 				$users = TableRegistry::get('Profilecounter');
	// 				$counteradd = 'counter + 1';
	// 				$con = ConnectionManager::get('default');
	// 				$detail = 'UPDATE `profilecounter` SET `counter` =' . $counteradd . ' WHERE `profilecounter`.`profile_id` = ' . $profile_id;
	// 				$results = $con->execute($detail);
	// 			}
	// 		}
	// 		$show_contactinfo = 1;
	// 	} else {
	// 		$show_contactinfo = 0;
	// 		//$error = 'Profile download limit is expired';
	// 		$error = 'You cannot view any more contact details. You can upgrade your package to view more contact details';
	// 	}

	// 	$response['error'] = $error;
	// 	$response['status'] = $show_contactinfo;
	// 	echo json_encode($response);
	// 	die;
	// }
	/*	
	public function profilecounter()
	{ 
	  $this->loadModel('Requirement');
	    $this->loadModel('Users');
	    $this->loadModel('JobQuote');
	    $this->loadModel('JobApplication');
        $this->loadModel('Skillset');
    	$this->loadModel('Profile');
    	$this->loadModel('Subscription');
    	$this->loadModel('RecuriterPack');

	    $this->autoRender=false;
	    $error = '';
	      $profile_id = $this->request->data['data'];
	    $current_user_id = $this->request->session()->read('Auth.User.id');
	    $current_user = $this->Users->find('all')->where(['Users.id'=>$current_user_id])->first(); 
	  
	    $role_id = $current_user['role_id'];
	    if($role_id==TALANT_ROLEID)
	    {
		$show_contactinfo = 1;	
	    }
	    else if($role_id==NONTALANT_ROLEID)
	    {
		$job_quotes = 0;
		$jobapplication = 0;
		$requirementfeatured = $this->Requirement->find('list')->contain([])->where(['Requirement.user_id'=>$current_user_id])->order(['Requirement.id' => 'DESC'])->toarray();
		$this->set('requirementfeatured', $requirementfeatured);
		foreach($requirementfeatured as $jobkey=>$value)
		{
		    $job_array[] = $jobkey;
		}
		if(count($job_array)>0)
		{
		    //$jobposts = 
		    $job_quotes = $this->JobQuote->find('all')->where(['JobQuote.job_id IN'=>$job_array,'JobQuote.user_id'=>$profile_id])->count();
		    $jobapplication = $this->JobApplication->find('all')->where(['JobApplication.job_id IN'=>$job_array,'JobApplication.user_id' => $profile_id])->count();
		}
		if($job_quotes > 0 || $jobapplication > 0)
		{
		    $show_contactinfo = 1;	
		}
		else
		{
		    $show_contactinfo = 0;
		    $error = 'You are not authorized to access the contact details of this user.';
		}
	    }
	    else
	    {
		$show_contactinfo = 0;
	    }
	    
	    if($show_contactinfo=='1')
	    {
		$this->loadModel('Profilecounter');
		$count = $this->Profilecounter->find('all')->where(['Profilecounter.user_id' => $current_user_id,'Profilecounter.profile_id' => $this->request->data['data']])->first();
		if($count==0 && $current_user_id !=$this->request->data['data'])
		{
		$this->request->data['user_id']=$current_user_id;
		$this->request->data['profile_id']=$this->request->data['data'];
		$options = $this->Profilecounter->newEntity();
		$option_arr = $this->Profilecounter->patchEntity($options, $this->request->data);
		$savedata = $this->Profilecounter->save($option_arr);
		}
		$users= TableRegistry::get('Profilecounter');
		$counteradd= 'counter + 1';
		$con = ConnectionManager::get('default');
		$detail = 'UPDATE `profilecounter` SET `counter` ='.$counteradd.' WHERE `profilecounter`.`profile_id` = ' . $this->request->data['data'];
		$results = $con->execute($detail);
	    }
	    $response['error']= $error;
	    $response['status']=$show_contactinfo;
	    echo json_encode($response); die;
	   
	}
	 */


	public function editableprofile()

	{
		$this->loadModel('Requirement');
		$this->loadModel('Users');
		$this->loadModel('JobQuote');
		$this->loadModel('JobApplication');
		$this->loadModel('Skillset');
		$this->loadModel('Profile');
		$this->loadModel('Subscription');
		$this->loadModel('RecuriterPack');

		$this->autoRender = false;
		$model = $this->request->data['model'];
		$id = $this->request->data['pk'];
		$value = $this->request->data['value'];
		$field = $this->request->data['name'];
		$Pack = $this->$model->get($id);
		$Pack->$field = $value;
		$this->$model->save($Pack);
	}


	public function resizeImage($image, $width, $height, $scale)
	{
		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth, $newImageHeight);
		switch ($ext) {
			case 'jpg':
			case 'jpeg':
				$source = imagecreatefromjpeg($image);
				break;

			case 'gif':
				$source = imagecreatefromgif($image);
				break;

			case 'png':
				$source = imagecreatefrompng($image);
				break;

			default:
				$source = false;
				break;
		}
		//imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
		//imagejpeg($newImage,$image,90);
		chmod($image, 0777);
		// return $image;
	}

	public function changeimage()
	{
		$post = isset($_POST) ? $_POST : array();
		switch ($post['action']) {
			case 'save':
				$this->saveProfilePic();
				$this->saveProfilePicTmp();
				break;
			default:
				changeProfilePic();
		}
	}

	/* Function to handle profile pic update in database*/
	public function saveProfilePic()
	{
		$post = isset($_POST) ? $_POST : array();
		if ($post['id']) {
			$prop_bookanartist_data = array();
			$profiled = $this->Profile->find('all')->where(['user_id' => $post['id']])->first();
			$idcheck = count($profiled);
			if ($idcheck > 0) {
				$options = $this->Profile->get($profiled['id']);
				$prop_bookanartist_data['profile_image'] = $post['image_name'];
				$option_arr = $this->Profile->patchEntity($options, $prop_bookanartist_data);
				$savedata = $this->Profile->save($option_arr);
			}
		}
	}

	/* Function to handle profile pic update in frontend*/
	public function saveProfilePicTmp()
	{
		$post = isset($_POST) ? $_POST : array();
		$userId = isset($post['id']) ? intval($post['id']) : 0;
		$path = '\\profileimages\tmp';
		$t_width = 300; // Maximum thumbnail width
		$t_height = 300; // Maximum thumbnail height


		if (isset($_POST['t']) and $_POST['t'] == "ajax") {
			extract($_POST);

			$w1 = $_POST['w1'];
			$x1 = $_POST['x1'];
			$h1 = $_POST['h1'];
			$y1 = $_POST['y1'];
			//$_POST['x2'];
			//$_POST['y2'];

			$imagePath = 'profileimages/tmp/' . $_POST['image_name'];
			$ratio = ($t_width / $w1);
			$nw = ceil($w1 * $ratio);
			$nh = ceil($h1 * $ratio);
			$nimg = imagecreatetruecolor($nw, $nh);
			$im_src = imagecreatefromjpeg($imagePath);


			imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, $nw, $nh, $w1, $h1);
			imagejpeg($nimg, $imagePath, 90);
		}
		echo $imagePath . '?' . time();
		exit(0);
	}

	/* Function to change profile picture */
	public function changeProfilePic()
	{
		$post = isset($_POST) ? $_POST : array();
		$max_width = "500";
		$userId = isset($post['hdn-profile-id']) ? intval($post['hdn-profile-id']) : 0;
		$path = 'profileimages/tmp';
		$valid_formats = array("jpg", "png", "gif", "jpeg");
		$name = $_FILES['profile-pic']['name'];
		$size = $_FILES['profile-pic']['size'];
		if (strlen($name)) {
			list($txt, $ext) = explode(".", $name);
			$ext = strtolower($ext);
			if (in_array($ext, $valid_formats)) {
				if ($size < (1024 * 1024)) {
					$actual_image_name = 'avatar' . '_' . $userId . '.' . $ext;
					$filePath = $path . '/' . $actual_image_name;
					$tmp = $_FILES['profile-pic']['tmp_name'];
					if (move_uploaded_file($tmp, $filePath)) {
						$width = $this->getWidth($filePath);
						$height = $this->getHeight($filePath);
						//Scale the image if it is greater than the width set above
						if ($width > $max_width) {
							$scale = $max_width / $width;
							$uploaded = $this->resizeImage($filePath, $width, $height, $scale, $ext);
						} else {
							$scale = 1;
							$uploaded = $this->resizeImage($filePath, $width, $height, $scale, $ext);
						}
						echo "<img id='photo' file-name='" . $actual_image_name . "' class='' src='" . $filePath . '?' . time() . "' class='preview'/>";
					} else
						echo "failed";
				} else
					echo "Image file size max 1 MB";
			} else
				echo "Invalid file format..";
		} else
			echo "Please select image..!";
		exit;
	}
	public function getHeight($image)
	{
		$sizes = getimagesize($image);
		$height = $sizes[1];
		return $height;
	}
	public function getWidth($image)
	{
		$sizes = getimagesize($image);
		$width = $sizes[0];
		return $width;
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

	// This Function used for saved video
	public function deletedirectory($dirname, $id)
	{
		$this->loadModel('Gallery');
		$this->loadModel('Galleryimage');
		$this->loadModel('Packfeature');
		$this->loadModel('Notification');
		$this->loadModel('Activities');
		$this->loadModel('Likes');
		$this->autoRender = false;

		$path = WWW_ROOT . 'gallery' . DS . $dirname . DS;
		$user_id = $this->request->session()->read('Auth.User.id');
		// $roleId = $this->request->session()->read('Auth.User.role_id');

		$galleryImages = $this->Galleryimage->find('all')->where(['Galleryimage.gallery_id' => $id]);
		$imageCount = $galleryImages->count();
		if ($imageCount > 0) {
			$this->Galleryimage->deleteAll(['Galleryimage.gallery_id' => $id]);
			$imagesArra = $galleryImages->toarray();
			foreach ($imagesArra as $key => $image_id) {
				// Delete related activity and likes
				$this->Activities->deleteAll(['Activities.photo_id' => $image_id['id']]);
				$this->Likes->deleteAll(['Likes.content_id' => $image_id['id']]);
				$this->Notification->deleteAll(['Notification.content' => $image_id['imagename']]);
			}
		}
		$gallery = $this->Gallery->get($id);
		$roleId = $gallery['user_role'];
		rmdir($path);
		if ($this->Gallery->delete($gallery)) {
			$packfeature = $this->Packfeature->find('all')
				->where(['id' => $gallery['package_id']])
				->first();
			$updateField = ($roleId == NONTALANT_ROLEID)
				? 'non_telent_number_of_album_used'
				: 'number_albums_used';
			$packfeature->$updateField -= 1;
			$usedPhotos = ($roleId == NONTALANT_ROLEID)
				? $packfeature['non_telent_totalnumber_of_images_used']
				: $packfeature['number_of_photo_used'];
			if ($usedPhotos > 0) {
				$imageLimitField = ($roleId == NONTALANT_ROLEID)
					? 'non_telent_totalnumber_of_images_used'
					: 'number_of_photo_used';

				$packfeature->$imageLimitField -= $imageCount;
			}
			if ($this->Packfeature->save($packfeature)) {
				$this->Flash->success(__("The album '{$gallery['name']}' and its images were deleted successfully."));
			} else {
				$this->Flash->error(__('Failed to update album and image count.'));
			}
		} else {
			$this->Flash->error(__('Failed to delete the gallery.'));
		}
		// return $this->redirect(['action' => 'galleries']);
		return $this->redirect($this->referer());
	}

	public function deleteimages($image_id = null, $album_id = null)
	{
		$this->autoRender = false;
		$this->loadModel('Galleryimage');
		$this->loadModel('Packfeature');
		$this->loadModel('Activities');
		$this->loadModel('Likes');
		$this->loadModel('Notification');

		$galleryimage = $this->Galleryimage->get($image_id);
		// pr($galleryimage);
		// exit;

		$pathThumb = 'gallery/'; // Path to the folder where images are stored
		$imageFilePath = WWW_ROOT . $pathThumb . $galleryimage->imagename; // Full path to the image file

		// Get the user's Packfeature data
		$user_id = $this->request->session()->read('Auth.User.id');
		// $packfeature = $this->Packfeature->find('all')
		// 	->where(['Packfeature.user_id' => $user_id])
		// 	->order(['Packfeature.id' => 'DESC'])
		// 	->first();

		$packfeature = $this->Packfeature->find('all')
			->where(['id' => $galleryimage['package_id']])
			->first();
		// pr($packfeature);exit;
		// Check the role and used photo count
		if ($galleryimage['user_role'] == NONTALANT_ROLEID) {
			$used_photos = $packfeature['non_telent_totalnumber_of_images_used'];
		} else {
			$used_photos = $packfeature['number_of_photo_used'];
		}

		// Prevent deletion if no photos are used
		// if ($used_photos <= 0) {
		// 	$this->Flash->error(__('You cannot delete this image because you have no used photos remaining.'));
		// 	return $this->redirect($this->referer());
		// }

		// Proceed with deletion
		$galldel = $this->Galleryimage->delete($galleryimage);

		if ($galldel) {
			// Unlink (delete) the physical file if it exists
			if (file_exists($imageFilePath) && is_file($imageFilePath)) {
				unlink($imageFilePath);
			}

			// Delete related activity and likes
			$this->Notification->deleteAll(['Notification.content' => $galleryimage['imagename']]);
			$this->Activities->deleteAll(['Activities.photo_id' => $image_id]);
			$this->Likes->deleteAll(['Likes.content_id' => $image_id]);

			// Decrease the used photo count
			if ($galleryimage['user_role'] == NONTALANT_ROLEID) {
				$feature_info['non_telent_totalnumber_of_images_used'] = $used_photos - 1;
			} else {
				$feature_info['number_of_photo_used'] = $used_photos - 1;
			}

			// Save updated feature info
			$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
			$this->Packfeature->save($features_arr);

			$this->Flash->success(__('Image has been deleted successfully'));
			return $this->redirect($this->referer());
		} else {
			$this->Flash->error(__('Error deleting the image. Please try again.'));
			return $this->redirect($this->referer());
		}
	}

	public function audio()
	{
		$this->loadModel('Audio');
		$this->loadModel('Users');
		$this->loadModel('Enthicity');
		$this->loadModel('City');
		$this->loadModel('State');
		$this->loadModel('Country');
		$this->loadModel('Settings');
		$this->loadModel('Packfeature');
		$id = $this->request->session()->read('Auth.User.id');

		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'DESC'])->first();
		// $packfeature = $this->Packfeature->find('all')
		// 	->where([
		// 		'user_id' => $id,
		// 		'OR' => [
		// 			['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
		// 			['package_status' => 'default']
		// 		]
		// 	])
		// 	->order(['id' => 'DESC'])
		// 	->first();
		$packfeature = $this->activePackage(); // comes from add controller data is from Packfeature table

		$this->set('packfeature', $packfeature);

		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'State', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);
		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
		$user = $_SESSION['Auth']['User']['id'];

		$admin_setting = $this->Settings->find('all')->first();
		if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
			$audioprofile = $this->Audio->find('all')
				->where(['user_id' => $user])
				->order(['Audio.id' => 'DESC'])
				->limit($packfeature['non_telent_number_of_audio'])
				->toarray();
		} else {
			$audioprofile = $this->Audio->find('all')->where(['user_id' => $user])->order(['Audio.id' => 'DESC'])->toarray();
		}

		$this->set('audioprofile', $audioprofile);

		if ($this->request->is(['post', 'put'])) {
			$id = $this->request->data['id'];

			// pr($this->request->data);exit;
			$Audio = isset($id) && !empty($id) ? $this->Audio->get($id) : $this->Audio->newEntity();

			try {
				// Load necessary models
				$this->loadModel('Packfeature');
				$this->loadModel('Subscription');
				$this->loadModel('Profilepack');
				$this->loadModel('Setting');

				$user_id = $this->request->session()->read('Auth.User.id');
				$roleId = $this->request->session()->read('Auth.User.role_id');

				// Get the active package for the user
				// $packfeature = $this->Packfeature->find('all')
				// 	->where([
				// 		'user_id' => $user_id,
				// 		'OR' => [
				// 			['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
				// 			['package_status' => 'default']
				// 		]
				// 	])
				// 	->order(['id' => 'DESC'])
				// 	->first();
				$packfeature = $this->activePackage(); // comes from add controller data is from Packfeature table

				if (!$packfeature) {
					$this->Flash->error(__("No active package found. Please purchase a package to upload audio."));
					return $this->redirect($this->referer());
				}

				$packfeature_id = $packfeature['id'];

				// Determine limits and usage
				if ($roleId == NONTALANT_ROLEID) {
					$audioLimit = $packfeature['non_telent_number_of_audio'];
					$usedCount = $packfeature['number_audio_used'] + $packfeature['non_telent_number_of_audio_used'];
				} else {
					$audioLimit = $packfeature['number_audio'];
					$usedCount = $packfeature['number_audio_used'] + $packfeature['non_telent_number_of_audio_used'];
				}

				$remainingSlots = $audioLimit - $usedCount;

				// Skip limit check if editing
				if (!empty($id) || $remainingSlots > 0) {  // Skip limit check if editing
					// Save audio details
					$prop_data = [
						'audio_type' => $this->request->data['audio_type'],
						'audio_link' => $this->request->data['audio_link'],
						'user_id' => $user_id,
						'package_id' => $packfeature_id,
						'user_role' => $roleId
					];

					$audioEntity = $this->Audio->patchEntity($Audio, $prop_data);
					$savedAudio = $this->Audio->save($audioEntity);

					if ($savedAudio) {
						$this->addactivity($user_id, 'upload_audio', $savedAudio['id']);

						// Update usage count only for new uploads (not edits)
						if (empty($id)) {
							$packfeature = $this->Packfeature->get($packfeature_id);
							$updateField = ($roleId == NONTALANT_ROLEID) ? 'non_telent_number_of_audio_used' : 'number_audio_used';
							$packfeature->$updateField = $usedCount + 1;

							$features_arr = $this->Packfeature->patchEntity($packfeature, [$updateField => $packfeature->$updateField]);
							$this->Packfeature->save($features_arr);
							$remainingSlots--;
						}

						// Flash appropriate message
						if (empty($id)) {
							$this->Flash->success(__("Audio uploaded successfully! You can upload $remainingSlots more audio link(s)."));
						} else {
							$this->Flash->success(__("Audio details updated successfully!"));
						}
					} else {
						$this->Flash->error(__("Failed to upload audio. Please try again."));
					}

					return $this->redirect(SITE_URL . '/galleries/audio');
				} else {
					// Limit exceeded messages (only for new uploads)
					if ($audioLimit == 0) {
						if ($roleId == NONTALANT_ROLEID) {
							$this->Flash->error(__("You currently don't have any available audio upload slots. Please remove some audio links from your gallery to upload new ones."));
						} else {
							$this->Flash->error(__("You currently don't have any available audio upload slots. Please upgrade your profile package or remove some audio links from your gallery to upload new ones."));
						}
					} else {
						if ($roleId == NONTALANT_ROLEID) {
							$this->Flash->error(__("You can upload only $audioLimit audio link(s). You have already used $usedCount. Please remove some audio links from your gallery to upload new ones."));
						} else {
							$this->Flash->error(__("You can upload only $audioLimit audio link(s). You have already used $usedCount. For more slots, upgrade your profile package or remove some audio links from your gallery."));
						}
					}

					return $this->redirect($this->referer());
				}

				// if ($remainingSlots > 0) {
				// 	// Save audio details
				// 	$prop_data = [
				// 		'audio_type' => $this->request->data['audio_type'],
				// 		'audio_link' => $this->request->data['audio_link'],
				// 		'user_id' => $user_id,
				// 		'package_id' => $packfeature_id,
				// 		'user_role' => $roleId
				// 	];

				// 	$audioEntity = $this->Audio->patchEntity($Audio, $prop_data);
				// 	$savedAudio = $this->Audio->save($audioEntity);

				// 	if ($savedAudio) {
				// 		$this->addactivity($user_id, 'upload_audio', $savedAudio['id']);

				// 		// Update usage count only if it's a new upload (no `$id`)
				// 		if (empty($id)) {
				// 			$packfeature = $this->Packfeature->get($packfeature_id);
				// 			$updateField = ($roleId == NONTALANT_ROLEID) ? 'non_telent_number_of_audio_used' : 'number_audio_used';
				// 			$packfeature->$updateField = $usedCount + 1;

				// 			$features_arr = $this->Packfeature->patchEntity($packfeature, [$updateField => $packfeature->$updateField]);
				// 			$this->Packfeature->save($features_arr);
				// 			$remainingSlots--;
				// 		}

				// 		// Flash appropriate message
				// 		if (empty($id)) {
				// 			$this->Flash->success(__("Audio uploaded successfully! You can upload $remainingSlots more audio link(s)."));
				// 		} else {
				// 			$this->Flash->success(__("Audio details updated successfully!"));
				// 		}
				// 	} else {
				// 		$this->Flash->error(__("Failed to upload audio. Please try again."));
				// 	}

				// 	return $this->redirect(SITE_URL . '/galleries/audio');
				// } else {
				// 	// Display message if no slots are available
				// 	if (0 > $remainingSlots) {
				// 		$this->Flash->error(__(
				// 			"You have exceeded the maximum number of audio you can upload."
				// 		));
				// 	} else
				// 	if ($audioLimit == 0) {
				// 		if ($roleId == NONTALANT_ROLEID) {
				// 			$this->Flash->error(__("You currently don't have any available audio upload slots. Please remove some audio links from your gallery to upload new ones."));
				// 		} else {
				// 			$this->Flash->error(__("You currently don't have any available audio upload slots. Please upgrade your profile package or remove some audio links from your gallery to upload new ones."));
				// 		}
				// 	} else {
				// 		if ($roleId == NONTALANT_ROLEID) {
				// 			$this->Flash->error(__("You can upload only $audioLimit audio link(s). You have already used $usedCount. Please remove some audio links from your gallery to upload new ones."));
				// 		} else {
				// 			$this->Flash->error(__("You can upload only $audioLimit audio link(s). You have already used $usedCount. For more slots, upgrade your profile package or remove some audio links from your gallery."));
				// 		}
				// 	}


				// 	return $this->redirect($this->referer());
				// }
			} catch (\PDOException $e) {
				$this->Flash->error(__('Error in uploading audio. Please try again later.'));
				return $this->redirect(SITE_URL . '/galleries/audio');
			}
		}
		$this->set('Audio', $Audio);
	}

	public function video()
	{
		$this->loadModel('Video');
		$this->loadModel('Users');
		$this->loadModel('Enthicity');
		$this->loadModel('City');
		$this->loadModel('State');
		$this->loadModel('Country');
		$this->loadModel('Settings');
		$this->loadModel('Packfeature');
		$id = $this->request->session()->read('Auth.User.id');
		// pr($this->request->data);exit;
		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();

		// $packfeature = $this->Packfeature->find('all')
		// 	->where([
		// 		'user_id' => $id,
		// 		'OR' => [
		// 			['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
		// 			['package_status' => 'default']
		// 		]
		// 	])
		// 	->order(['id' => 'DESC'])
		// 	->first();
		$packfeature = $this->activePackage(); // comes from add controller data is from Packfeature table
		$this->set('packfeature', $packfeature);


		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'State', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);
		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
		$user = $_SESSION['Auth']['User']['id'];

		$admin_setting = $this->Settings->find('all')->first();

		if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
			$videoprofile = $this->Video->find('all')
				->where(['user_id' => $user])
				->order(['Video.id' => 'DESC'])
				->limit($packfeature['non_telent_number_of_video'])
				->toarray();
		} else {
			$videoprofile = $this->Video->find('all')
				->where(['user_id' => $user])
				->order(['Video.id' => 'DESC'])
				->toarray();
		}
		$this->set('videoprofile', $videoprofile);

		if ($this->request->is(['post', 'put'])) {
			// pr($this->request->data);
			// die;
			$id = $this->request->data['id'];

			if (isset($id) && !empty($id)) {
				$Video = $this->Video->get($id);
			} else {
				$Video = $this->Video->newEntity();
			}
			$this->loadModel('Packfeature');
			$this->loadModel('Subscription');
			$this->loadModel('Profilepack');
			try {
				// Checking Image uploading Limit
				$user_id = $this->request->session()->read('Auth.User.id');
				// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'DESC'])->first();
				$packfeature = $this->activePackage(); // comes from add controller data is from Packfeature table


				// $subscription = $this->Subscription->find('all')->select('package_id')->where(['user_id' => $user_id, 'package_type' => 'PR'])->first();
				// $subscription = $this->Subscription->find('all')->select('package_id')->where(['user_id' => $user_id, 'package_type' => 'PR'])->order(['package_id' => 'DESC'])->first();

				// $pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => $subscription['package_id']])->order(['Profilepack.id' => 'ASC'])->first();
				// $pcakgeinformation = $pcakgeinformation['number_video'];
				$used = 0;
				$packfeature_id = $packfeature['id'];
				$roleId = $this->request->session()->read('Auth.User.role_id');

				// Fetch video limits based on user role
				if ($roleId == NONTALANT_ROLEID) {
					$number_video = $packfeature['non_telent_number_of_video'];
					$used = $packfeature['non_telent_number_of_video_used'] + $packfeature['number_video_used'];
				} else {
					$number_video = $packfeature['number_video'];
					$used = $packfeature['non_telent_number_of_video_used'] + $packfeature['number_video_used'];
				}

				$limit_remaining = $number_video - $used;

				// Check if the user has available video slots
				if ($used < $number_video) {
					$prop_data = [
						'video_name' => $this->request->data['video_name'],
						'user_id' => $user,
					];

					if ($this->request->data['imagename']['error'] == 4) {
						// Handle video from URL
						$url = $this->request->data['imagesrc'];
						$ext = pathinfo($url, PATHINFO_EXTENSION);
						$name = md5(time() . $filename);
						$rnd = mt_rand();
						$imagename = trim("$name$rnd.$ext", " ");
						$img = WWW_ROOT . 'videothumb/' . $imagename;
						file_put_contents($img, file_get_contents($url));
						$prop_data['thumbnail'] = $imagename;
						$prop_data['video_type'] = $this->request->data['videourl'];

						// Delete thumbnail
						if ($id && !empty($Video->thumbnail)) {
							$imgPath = WWW_ROOT . 'videothumb/' . $Video->thumbnail;
							if (file_exists($imgPath)) {
								unlink($imgPath);
							}
						}
					} else {
						// Handle video thumbnail from file upload
						if (!empty($this->request->data['imagename']['name'])) {
							$ks = $this->request->data['imagename'];
							$gall = $this->mimages($ks);
							$pathThumb = 'videothumb/';
							$this->FcCreateThumbnail("trash_image", $pathThumb, $gall[0], $gall[0], "300", "100");
							$prop_data['thumbnail'] = $gall[0];
						} else {
							$prop_data['thumbnail'] = 'noimage.jpg';
						}

						// Delete thumbnail
						if ($id && !empty($Video->thumbnail)) {
							$imgPath = WWW_ROOT . 'videothumb/' . $Video->thumbnail;
							if (file_exists($imgPath)) {
								unlink($imgPath);
							}
						}
					}

					// Use the previous thumbnail if no new image source is provided
					if (empty($this->request->data['imagesrc']) && $this->request->data['imagename']['error'] == 4) {
						$prop_data['thumbnail'] = $Video['thumbnail'];
					}
					$prop_data['package_id'] = $packfeature_id;
					$prop_data['user_role'] = $this->request->session()->read('Auth.User.role_id');
					// Save video data
					$option_arr = $this->Video->patchEntity($Video, $prop_data);
					$savedata = $this->Video->save($option_arr);

					// Log activity
					$this->addactivity($userid, 'upload_video', $savedata['id']);

					if (empty($id)) {
						// Update video usage count
						$packfeature = $this->Packfeature->get($packfeature_id);
						$updateField = ($roleId == NONTALANT_ROLEID) ? 'non_telent_number_of_video_used' : 'number_video_used';
						// pr($updateField);exit;

						$packfeature->$updateField += 1;

						// Save updated pack feature
						$features_arr = $this->Packfeature->patchEntity($packfeature, [$updateField => $packfeature->$updateField]);
						if ($this->Packfeature->save($features_arr)) {
							$remaining = ($number_video - $packfeature->$updateField);
							$this->Flash->success(__("Video uploaded successfully! You can upload $remaining more video(s)."));
						} else {
							$this->Flash->error(__("Video uploaded, but failed to update usage limits."));
						}
					} else {
						$this->Flash->success(__("Video updated successfully!"));
					}

					return $this->redirect(SITE_URL . '/galleries/video');
				} else {
					// Handle cases when video slots are unavailable
					if (0 > $limit_remaining || $limit_remaining == 0) {
						$this->Flash->error(__(
							"You have exceeded the maximum number of videos you can upload."
						));
					} else {

						if ($roleId == NONTALANT_ROLEID) {
							$this->Flash->error(__(
								"You have reached your upload limit. You have used $used out of $number_video slots. Please remove some videos to upload new ones."
							));
						} else {
							$this->Flash->error(__(
								"You have reached your upload limit. You have used $used out of $number_video slots. Please upgrade your profile package or remove some videos to upload new ones."
							));
						}
					}

					return $this->redirect(SITE_URL . '/galleries/video');
				}
			} catch (\PDOException $e) {
				$this->Flash->error(__('Error in Uploading Videos'));
				$this->set('error', $error);
				return $this->redirect(SITE_URL . '/galleries/video');
			}
		}
		$this->set('Video', $Video);
	}

	public function deleteaudio($id)
	{
		// Load necessary models
		$this->loadModel('Activities');
		$this->loadModel('Likes');
		$this->loadModel('Packfeature');
		$this->loadModel('Audio');
		$this->autoRender = false;
		$user_id = $this->request->session()->read('Auth.User.id');
		$audio = $this->Audio->find('all')->where(['id' => $id])->first();
		if (!$audio) {
			$this->Flash->error(__("Audio not found"));
			return $this->redirect(SITE_URL . '/galleries/audio');
		}
		$packfeature = $this->Packfeature->find('all')->where(['id' => $audio['package_id']])->first();
		if (!$packfeature) {
			$this->Flash->error(__("Package feature not found"));
			return $this->redirect(SITE_URL . '/galleries/audio');
		}

		$this->Activities->deleteAll(['Activities.photo_id' => $id]);
		$this->Likes->deleteAll(['Likes.content_id' => $id]);

		// $roleId = $this->request->session()->read('Auth.User.role_id');
		$roleId = $audio['user_role'];
		$audioUsedField = ($roleId == NONTALANT_ROLEID) ? 'non_telent_number_of_audio_used' : 'number_audio_used';
		$packfeature->$audioUsedField = max(0, $packfeature->$audioUsedField - 1);
		$this->Packfeature->save($packfeature);
		$this->Audio->delete($audio);
		$this->Flash->success(__("'{$audio['audio_type']}' Audio Deleted Successfully!!"));
		return $this->redirect(SITE_URL . '/galleries/audio');
	}

	public function deletevideo($id = null)
	{
		$this->autoRender = false;
		$this->loadModel('Video');
		$this->loadModel('Packfeature');
		$this->loadModel('Activities');
		$this->loadModel('Likes');
		$this->loadModel('Notification');

		// Validate the video ID
		if (!$id) {
			$this->Flash->error(__('Invalid video ID.'));
			return $this->redirect($this->referer());
		}

		$user_id = $this->request->session()->read('Auth.User.id');
		$role_id = $this->request->session()->read('Auth.User.role_id');

		// Fetch video details
		$video = $this->Video->find()
			->where(['id' => $id, 'user_id' => $user_id])
			->first();
		// pr($video);exit;

		if (!$video) {
			$this->Flash->error(__('Video not found or you are not authorized to delete this video.'));
			return $this->redirect($this->referer());
		}

		// Fetch associated package feature
		$packfeature = $this->Packfeature->find()
			->where(['id' => $video->package_id])
			->first();

		if (!$packfeature) {
			$this->Flash->error(__('Package information not found.'));
			return $this->redirect($this->referer());
		}

		// Delete thumbnail
		if (!empty($video->thumbnail)) {
			$imgPath = WWW_ROOT . 'videothumb/' . $video->thumbnail;
			if (file_exists($imgPath)) {
				unlink($imgPath);
			}
		}

		// Delete video, activities, and likes
		$this->Video->delete($video);
		$this->Activities->deleteAll(['Activities.photo_id' => $id]);
		$this->Likes->deleteAll(['Likes.content_id' => $id]);
		$this->Notification->deleteAll(['Notification.content' => $video['video_type']]);

		// Update video usage count
		$usedKey = ($video['user_role'] == NONTALANT_ROLEID)
			? 'non_telent_number_of_video_used'
			: 'number_video_used';

		$packfeature->$usedKey = max(0, $packfeature->$usedKey - 1); // Ensure count doesn't go below 0
		$this->Packfeature->save($packfeature);

		$this->Flash->success(__('Video deleted successfully!'));
		return $this->redirect($this->referer());
	}

	// This Function used for saved Audio

	// This Function used for get states according country
	public function getStates()
	{
		$this->autoRender = false;
		$this->loadModel('Country');
		$this->loadModel('State');
		$states = array();
		if (isset($this->request->data['id'])) {
			$states = $this->Country->State->find('list')->select(['id', 'name'])->where(['State.country_id' => $this->request->data['id']])->toarray();
		}
		// pr($states);exit;
		header('Content-Type: application/json');
		echo json_encode($states);
		exit();
	}
	// This Function used for get city according states
	public function getcities()
	{
		$this->autoRender = false;
		$this->loadModel('City');
		$cities = array();
		if (isset($this->request->data['id'])) {
			$cities = $this->City->find('list')->select(['id', 'name'])->where(['City.state_id' => $this->request->data['id']])->toarray();
		}
		header('Content-Type: application/json');
		echo json_encode($cities);
		exit();
	}

	public  function _setPassword($password)
	{
		return (new DefaultPasswordHasher)->hash($password);
	}
	// This Function used for edit and add profile

	public function removeimage($id, $imagelink)
	{
		$this->loadModel('Profile');
		$this->autoRender = false;
		$profileimage = $this->Profile->get($id);
		$profileimage->profile_image = '';
		$this->Profile->save($profileimage);
		return $this->redirect(['action' => 'profile']);
		unlink(SITE_URL . "profileimages/" . $imagelink);
	}

	public function profile($id = null, $type = null)
	{
		$this->loadModel('Skill');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Skillset');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Language');
		$this->loadModel('Languageknown');
		$this->loadModel('Enthicity');
		$this->loadModel('Currency');
		$this->loadModel('Subscription');
		$this->loadModel('Profilepack');
		$ethnicity = $this->Enthicity->find('list')->select(['id', 'title'])->toarray();
		$this->set('ethnicity', $ethnicity);
		$id = $this->request->session()->read('Auth.User.id');
		// $subscription = $this->Subscription->find('all')->where(['user_id' => $id, 'package_type' => 'PR'])->first();
		$subscription = $this->Subscription->find('all')->where(['user_id' => $id, 'package_type' => 'PR', 'package_id !=' => 1])->first();

		$pcakgeinformation = $this->Profilepack->find('all')->select(['name', 'id'])->where(['Profilepack.status' => 'Y', 'Profilepack.id' => $subscription['package_id']])->first();

		if ($subscription) {
			$date2 = date_format($subscription['expiry_date'], "d-m-Y");
			$date1 = date("d-m-Y");
			$diff = strtotime($date2) - strtotime($date1);
			$expirepackageddays  =  abs(round($diff / 86400));
		}

		$session = $this->request->session();
		if (($expirepackageddays == '15' || $expirepackageddays == '10' || $expirepackageddays == '7' || ($expirepackageddays <= '3' && $expirepackageddays > '0')) && isset($_SESSION['packagedatacheck']) == 0) {
			$datapackage = '1';
			$invited[] = $datapackage;
			$session->write('packagedatacheck', $invited);
		} else if ($expirepackageddays == '0') {
			$datapackage = '0';
		}

		$this->set('datapackage', $datapackage);
		$this->set('packName', $pcakgeinformation['name']);
		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		// pr($userpack_check);exit;
		$this->Auth->setUser($userpack_check);
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
		$lang = $this->Language->find('all')->select(['id', 'name'])->toarray();
		$this->set('lang', $lang);
		$country = $this->Country->find('list')->select(['id', 'name'])->toarray();
		$this->set('country', $country);
		$cntcode = $this->Country->find('list', ['keyField' => 'cntcode', 'valueField' => 'cntcode'])->toarray();
		$this->set('cntcode', $cntcode);
		$currency = $this->Currency->find('list', ['keyField' => 'id', 'valueField' => 'currencycode'])->toarray();
		$this->set('currency', $currency);
		$languageknow = $this->Languageknown->find('all')->select(['id', 'language_id'])->where(['Languageknown.user_id' => $id])->order(['Languageknown.id' => 'DESC'])->toarray();
		$this->set('languageknow', $languageknow);
		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id])->order(['Skillset.id' => 'DESC'])->toarray();
		$this->set('skillofcontaint', $contentadminskillset);
		$Skill = $this->Skill->find('all')->select(['id', 'name'])->toarray();
		$this->set('Skill', $Skill);
		$profiled = $this->Profile->find('all')->where(['user_id' => $id])->first();
		$idcheck = count($profiled);

		if ($idcheck > 0) {
			$profile = $this->Profile->find('all')->contain(['Users'])->where(['user_id' => $id])->first();
		} else {
			$profile = $this->Profile->newEntity();
		}
		// pr($profile);
		// exit;
		$this->set('profile', $profile);
		$cities = $this->City->find('list')->where(['City.state_id' => $profile['state_id']])->toarray();
		$this->set('cities', $cities);
		$states = $this->State->find('list')->where(['State.country_id' => $profile['country_ids']])->toarray();
		$this->set('states', $states);
		$phonecodess = $this->Country->find('list', ['keyField' => 'id', 'valueField' => 'cntcode'])->toarray();
		$this->set('phonecodess', $phonecodess);

		if ($this->request->is('post') || $this->request->is('put')) {
			// pr($this->request->data);
			$Pack = $this->Users->get($id);
			$pass = md5($this->request->data['guardianpassword']);
			$Pack->guardianpassword = $pass;
			$Pack->guardianemailaddress = $this->request->data['guardian_email'];
			$Pack->user_name = $this->request->data['name'];

			$Pack->country_id = $this->request->data['country_ids'];
			$Pack->state_id = $this->request->data['state_id'];
			$Pack->city_id = $this->request->data['city_id'];
			$chekc = $this->Users->save($Pack);
			// pr($chekc);exit;

			if (!empty($this->request->data['profile_image']['name'])) {
				// unlink image in folder sliderimage
				unlink("profileimages/{$profile['profile_image']}");
				$filename = $this->request->data['profile_image']['name'];
				$name = md5(time() . $filename);
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$imagename = $name . '.' . $ext;
				$dest = "profileimages/";
				$newfile = $dest . $imagename;
				if (move_uploaded_file($this->request->data['profile_image']['tmp_name'], $newfile)) {
					$this->request->data['profile_image'] = $imagename;
				} else {
					$this->request->data['profile_image'] =	 $profile['profile_image'];
				}
			}

			$this->request->data['dob'] = date('Y-m-d', strtotime($this->request->data['dob']));
			$this->request->data['user_id'] = $id;

			$prop_count = count($this->request->data['languageknow']);
			$prop_data = array();
			$this->Languageknown->deleteAll(['Languageknown.user_id' => $id]);
			// pr($prop_count);die;
			for ($i = 0; $i < $prop_count; $i++) {
				if ($this->request->data['languageknow'][$i] > 0) {
					$peopleTable = TableRegistry::get('Languageknown');
					$oQuery = $peopleTable->query();
					$oQuery->insert(['language_id', 'user_id'])->values(['language_id' => $this->request->data['languageknow'][$i], 'user_id' => $id]);
					$d = $oQuery->execute();
				}
			}
			$skillcheck = $this->request->data['skill'];
			$skillcount = explode(",", $this->request->data['skill']);
			$this->request->data['dob'] = $this->request->data['dobdate'];
			$profiles = $this->Profile->patchEntity($profile, $this->request->data);

			if ($savedprofile = $this->Profile->save($profiles)) {
				$this->loadModel('TalentAdmin');
				$talentprofile = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $savedprofile['user_id']])->count();
				if ($talentprofile > 0 && $savedprofile['altemail'] != "") {
					$talentTable = TableRegistry::get('TalentAdmin');
					$query = $talentTable->query();
					$query->update()
						->set(['alternate_email' => $savedprofile['altemail']])
						->where(['TalentAdmin.user_id' => $savedprofile['user_id']])
						->execute();
				}
			}

			$guardianname = $this->request->data['guadian_name'];
			$guardianphone = $this->request->data['guardian_phone'];
			$guardianpass = $this->request->data['guardianpassword'];
			$guardianemail = $this->request->data['guardian_email'];
			$usergender = $this->request->data['gender'];
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
			$usermail = $Pack['email'];
			$user = $Pack['user_name'];
			$userpass = $Pack['cpassword'];
			if ($guardianemail) {
				$this->loadmodel('Templates');
				$profile = $this->Templates->find('all')->where(['Templates.id' => GUARDIANMAIL])->first();
				$subject = $profile['subject'];
				$from = $profile['from'];
				$fromname = $profile['fromname'];
				$to  = $guardianemail;
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
				$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
			}

			if (!empty($this->request->data['skill'])) {
				$this->Skillset->deleteAll(['Skillset.user_id' => $id]);
				for ($i = 0; $i < count($skillcount); $i++) {
					$contentadminskill = $this->Skillset->newEntity();
					$this->request->data['user_id'] = $id;
					$this->request->data['skill_id'] = $skillcount[$i];
					$contentadminskillsave = $this->Skillset->patchEntity($contentadminskill, $this->request->data);
					$skilldata = $this->Skillset->save($contentadminskillsave);
					if ($skilldata) {
						$con = ConnectionManager::get('default');
						$detail = 'UPDATE `users` SET `role_id` ="' . TALANT_ROLEID . '" WHERE `users`.`id` = ' . $id;
						$results = $con->execute($detail);
						$_SESSION['Auth']['User']['role_id'] = TALANT_ROLEID;
					}
				}
			} else {
				$this->Skillset->deleteAll(['Skillset.user_id' => $id]);
				$con = ConnectionManager::get('default');
				$detail = 'UPDATE `users` SET `role_id` ="' . NONTALANT_ROLEID . '" WHERE `users`.`id` = ' . $id;
				$results = $con->execute($detail);
				$_SESSION['Auth']['User']['role_id'] = NONTALANT_ROLEID;
			}


			$conss = ConnectionManager::get('default');
			$checkfirsttimeuser = '1';
			$detail = 'UPDATE `users` SET `checkuser` ="' . $checkfirsttimeuser . '" WHERE `users`.`id` = ' . $id;
			$results = $conss->execute($detail);
			$currentdate = date('Y-m-d H:m:s');
			$featured_expiry = $this->request->session()->read('Auth.User.featured_expiry');
			$userrole_id = $this->request->session()->read('Auth.User.role_id');
			$check_userrole = $this->Users->find('all')->where(['Users.id' => $id])->first();
			$expirdate = date('M d,Y', strtotime($featured_expiry));

			if ($type == "submit") {
				$this->Flash->success(__('Your Profile Has Been Successfully Updated'));
				if ($currentdate > date('Y-m-d H:m:s', strtotime($featured_expiry)) && $check_userrole['role_id'] == TALANT_ROLEID) {
					return $this->redirect(['action' => 'featureprofile']);
				} else {
					return $this->redirect(['action' => 'viewprofile']);
				}
			} else {
				$this->Flash->success(__('Changes has been saved successfully!!'));
				return $this->redirect(['action' => 'galleries']);
			}
		}
	}
	// This Function for show skills
	public function skills($id = null)
	{
		$this->loadModel('Users');
		$this->loadModel('Skillset');
		$this->loadModel('Skill');
		if ($id != null) {
			$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id, 'Skillset.status' => 'Y'])->order(['Skillset.id' => 'DESC'])->toarray();
		}
		$Skill = $this->Skill->find('all')->select(['id', 'name'])->where(['Skill.status' => 'Y'])->order(['Skill.name' => 'ASC'])->toarray();
		$this->set('Skill', $Skill);
		$this->set('skillset', $contentadminskillset);

		$this->loadModel('Packfeature');
		$user_id = $this->request->session()->read('Auth.User.id');
		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
		$packfeature = $this->Packfeature->find('all')
			->where(['user_id' => $user_id])
			->andWhere(['OR' => [
				['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
				['package_status' => 'default']
			]])
			->order(['id' => 'DESC'])
			->first();
		$this->set('total_elegible_skills', $packfeature['number_categories']);
	}

	// ************************ this fucntion call for ajax used for delete gallery *****************************//
	public function gallery($id)
	{
		$this->loadModel('Galleryimage');
		$tattoo = $this->Galleryimage->get($id);
		// $this->Galleryimage->delete($tattoo);
		$this->redirect(Router::url($this->referer(), true));
	}

	public function deletegallery($id = null, $tattoo_id)
	{
		// pr($this->request->data);exit;
		$this->loadModel('Galleryimage');
		$id = $this->request->data['delid'];
		$pro_id = $this->request->data['product_id'];
		$gallery = $this->Galleryimage->find('all')->contain(['Gallery'])->order(['Galleryimage.id' => 'DESC'])->where(['Galleryimage.id' => $id])->first();
		unlink('gallery/' . $gallery['gallery']['name'] . '/' . $gallery['imagename']);
		$tattoo = $this->Galleryimage->get($id);
		// $this->Galleryimage->delete($tattoo);
		return $this->redirect(['action' => 'images/' . $id]);
	}

	// This Function used for gallery album add images
	public function images($id = null, $type = null)
	{
		$this->loadModel('Gallery');
		$this->loadModel('Packfeature');
		$this->loadModel('Galleryimage');
		$this->loadModel('Profilepack');
		$this->loadModel('Subscription');

		// pr($this->request->data);exit;

		if (empty($id)) {
			$id = 0;
		}
		$this->set('id', $id);
		$userid = $this->request->session()->read('Auth.User.id');
		$userRole = $this->request->session()->read('Auth.User.role_id');
		// pr($userid);exit;
		$galleryimage = $this->Galleryimage->newEntity();
		$this->set('galleryimage', $galleryimage);

		$galleryalbumname = $this->Gallery->find('all')->where(['Gallery.id' => $id])->first();
		$this->set('galleryalbumname', $galleryalbumname);

		$packfeature = $this->activePackage(); // comes from add controller data is from Packfeature table
		$this->set('packfeature', $packfeature);


		$galleryprofileimage = $this->Gallery->find('all')->contain(['Galleryimage'])->where(['Gallery.id' => $id])->first();
		$galleryprofileimagescount = $this->Galleryimage->find('all')->where(['Galleryimage.gallery_id' => $id])->toarray();
		$gallerycounting = count($galleryprofileimagescount);
		$gallurl = $galleryprofileimage['name'];
		$this->set('galleryprofileimage', $galleryprofileimage);

		if ($this->request->is(['post', 'put'])) {

			// pr($this->request->data);
			// exit;

			if ($this->request->data['imagename'][0]['name'] != '') {
				$this->request->data['gallery_id'] = ($id > 0) ? $id : null;

				$packfeature = $this->activePackage(); // comes from add controller data is from Packfeature table
				$packfeature_id = $packfeature['id'];
				$number_of_photo = 0;
				$number_of_photo_used = 0;
				// Get the number of images uploaded by the user
				if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
					$number_of_photo = $packfeature['non_telent_totalnumber_of_images'];
					$number_of_photo_used = $packfeature['non_telent_totalnumber_of_images_used'] + $packfeature['number_of_photo_used'];
				} else {
					$number_of_photo = $packfeature['number_of_photo'];
					$number_of_photo_used = $packfeature['number_of_photo_used'] + $packfeature['non_telent_totalnumber_of_images_used'];
				}
				$limit_remaining = $number_of_photo - $number_of_photo_used;

				// pr($limit_remaining);exit;

				$romm = count($this->request->data['imagename']);
				// Check if the user has enough upload limit left
				if ($limit_remaining >= $romm) {
					for ($i = 0; $i < $romm; $i++) {
						// Checking Image uploading Limit
						if ($this->request->data['imagename'][$i]['name'] != '') {
							$gall = $this->uploadFiles($this->request->data['imagename'][$i]);
							// $ks = $this->request->data['imagename'][$i];
							// $gall = $this->move_images($ks);
							// pr($gall);
							// die;
							// $this->FcCreateThumbnail("trash_image", $pathThumb, $gall[0], $gall[0], "200", "200");
							$resss = $this->FcCreateThumbnail("trash_image", "gallery", $gall[0], $gall[0], "1500", "1500");

							// pr($resss);exit;
							$filennames = $gall[0];
						} else {
							$filennames = 'noimage.jpg';
						}

						$image_data['gallery_id'] = ($id > 0) ? $id : null;
						$image_data['user_id'] = $userid;
						$image_data['user_role'] = $userRole;
						$image_data['package_id'] = $packfeature_id;
						$image_data['imagename'] = $filennames;
						$images = $this->Galleryimage->newEntity();
						$images = $this->Galleryimage->patchEntity($images, $image_data);
						$result = $this->Galleryimage->save($images);
						$last_id = $result->id;

						// Add to activities
						if ($result['gallery_id'] == 0) {
							$this->addactivity($userid, 'update_photos', $last_id);
						} else {
							$this->addactivity($userid, 'update_album', $last_id);
						}

						// Update the used photo count (do not update the original limit)
						$packfeature = $this->Packfeature->get($packfeature_id);

						// Update the used image count
						if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
							$feature_info['non_telent_totalnumber_of_images_used'] = $packfeature['non_telent_totalnumber_of_images_used'] + 1;
						} else {
							$feature_info['number_of_photo_used'] = $packfeature['number_of_photo_used'] + 1;
						}

						// Save the updated used count
						$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
						$this->Packfeature->save($features_arr);
					}
				} else {
					// If the user has reached their upload limit
					if ($limit_remaining == 0) {
						$this->Flash->error(__(
							"You have reached the maximum number of photos you can upload. 
							Your limit is {$number_of_photo} photos, and you have already uploaded {$number_of_photo_used}."
						));
					} else if (0 > $limit_remaining) {
						$this->Flash->error(__(
							"You have exceeded the maximum number of photos you can upload."
						));
					} else {
						$this->Flash->error(__(
							"You can upload only {$limit_remaining} more photographs out of your total limit of {$number_of_photo}. 
							Please delete photographs from the gallery to upload more."
						));
					}
					return $this->redirect($this->referer());
				}
			}

			if ($id > 0) {
				return $this->redirect(['action' => 'images/' . $id]);
			} else {
				return $this->redirect(['action' => 'galleries/' . $type]);
			}
		}
	}

	// This Function used for Add gallery album
	public function galleries($type = null)
	{
		$this->loadModel('Galleryimage');
		$this->loadModel('Gallery');
		$this->loadModel('Users');
		$this->loadModel('Enthicity');
		$this->loadModel('City');
		$this->loadModel('State');
		$this->loadModel('Country');
		$this->loadModel('Packfeature');
		$this->loadModel('Settings');
		// echo $type; die;
		$id = $this->request->session()->read('Auth.User.id');
		// $this->set('id', $id);
		// $this->request->session()->destroy();
		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();

		$packfeature = $this->activePackage(); // comes from add controller data is from Packfeature table
		// $admin_setting = $this->Settings->find('all')
		// ->order(['id'=>'DESC'])
		// ->first();
		// pr($admin_setting['non_telent_number_of_album']);exit;

		// $total_gallery_images = $this->Galleryimage->find('all')->where(['Galleryimage.user_id' => $id])->order(['Galleryimage.id' => 'DESC'])->toarray();
		// pr($total_gallery_images);exit;

		//Some changes by rupam
		$total_gallery_images = $this->Galleryimage->find('all')
			->where(['user_id' => $id, 'status !=' => 1])
			->order(['Galleryimage.id' => 'DESC'])
			->toarray();
		// pr($total_gallery_images);exit;

		if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
			$gallerylimit = $packfeature['non_telent_totalnumber_of_images'];
		} else {
			$gallerylimit = $packfeature['number_of_photo'];
		}
		// pr($gallerylimit);exit;

		if (!empty($total_gallery_images)) {
			$i = 0;
			foreach ($total_gallery_images as $value) {
				if ($i <= $gallerylimit)
					$galleryfeature = $this->Galleryimage->get($value['id']);
				$feature_gallery['status'] = 1;
				$features_gallery = $this->Galleryimage->patchEntity($galleryfeature, $feature_gallery);
				$this->Galleryimage->save($features_gallery);
				$i++;
			}
		}

		// pr($gallerylimit);exit;

		$album_limit = 0;
		$album_limit_used = 0;
		if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
			$album_limit = $packfeature['non_telent_number_of_album'];
			$album_limit_used = $packfeature['non_telent_number_of_album_used'] + $packfeature['number_albums_used'];
		} else {
			$album_limit = $packfeature['number_albums'];
			$album_limit_used = $packfeature['non_telent_number_of_album_used'] + $packfeature['number_albums_used'];
		}
		$this->set(compact('album_limit', 'album_limit_used'));

		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);

		$galleryprofile = $this->Gallery->find('all')
			->contain(['Galleryimage'])
			->where(['user_id' => $id])
			->limit($album_limit)
			->order(['Gallery.id' => 'DESC'])
			->toarray();
		$galleryalbumcount = count($galleryprofile);
		// pr($id);exit;
		$this->set('galleryprofile', $galleryprofile);

		$gallery = $this->Gallery->newEntity();
		$this->set('gallery', $gallery);

		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);

		//$admin_setting = $this->Users->find('all')->where(['role_id' => 1])->first();
		$admin_setting = $this->Settings->find('all')->first();
		// pr($this->request->session()->read('Auth.User.role_id'));exit;
		if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
			$singleimages = $this->Galleryimage->find('all')
				->select(['id', 'imagename', 'status'])
				->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => 0])
				->order(['Galleryimage.id' => 'DESC'])
				->limit($gallerylimit)
				->toarray();
		} else {
			$singleimages = $this->Galleryimage->find('all')
				->select(['id', 'imagename', 'status'])
				->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => 0])
				->order(['Galleryimage.id' => 'DESC'])
				->toarray();
		}
		// pr($singleimages);exit;
		$this->set('singleimages', $singleimages);

		if ($this->request->is(['post', 'put'])) {
			// Loading required models
			$this->loadModel('Packfeature');
			$this->loadModel('Subscription');
			$this->loadModel('Profilepack');

			$user_id = $this->request->session()->read('Auth.User.id');

			// Fetching the current package details
			$packfeature = $this->activePackage(); // comes from add controller data is from Packfeature table

			if (!$packfeature) {
				$this->Flash->error(__('No active package found.'));
				return $this->redirect(['action' => 'galleries']);
			}
			// pr($this->request->session()->read('Auth.User.role_id'));exit;
			// Determine limits and used counts based on role
			$limit = 0;
			$used = 0;
			if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
				$limit = $packfeature['non_telent_number_of_album'];
				$used = $packfeature['non_telent_number_of_album_used'];
			} else {
				$limit = $packfeature['number_albums'];
				$used = $packfeature['number_albums_used'];
			}
			// Validate usage
			if ($used >= $limit) {
				$this->Flash->error(__(
					"You have reached the limit of {$limit} albums.
					Please delete an existing album to create a new one."
				));
				// $this->Flash->error(__(
				// 	"You have reached the limit of {$limit} albums. You have already used {$used} albums. 
				// 	Please delete an existing album to create a new one."
				// ));
				return $this->redirect(['action' => 'galleries']);
			}

			// Proceed with album creation
			$this->request->data['Gallery']['user_id'] = $user_id;
			$this->request->data['package_id'] = $packfeature['id'];
			$this->request->data['user_role'] = $this->request->session()->read('Auth.User.role_id');

			// pr($this->request->data);exit;
			$galleries = $this->Gallery->patchEntity($gallery, $this->request->data);

			if ($this->Gallery->save($galleries)) {
				// Update the used count in the Packfeature
				$packfeature = $this->Packfeature->get($packfeature['id']);
				if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
					$packfeature->non_telent_number_of_album_used = $used + 1;
				} else {
					$packfeature->number_albums_used = $used + 1;
				}
				$this->Packfeature->save($packfeature);

				$this->Flash->success(__('Album Created Successfully!'));
				return $this->redirect(['action' => 'galleries']);
			} else {
				$this->Flash->error(__('Error creating the album. Please try again.'));
				return $this->redirect(['action' => 'galleries']);
			}
		}


		if ($type == "save") {
			$this->Flash->success(__('Images uploaded Successfully!!'));
			// return $this->redirect(['action' => 'professionalsummary']);
			return $this->redirect($this->referer());
		}

		// $currentdate = date('Y-m-d H:m:s');
		// $featured_expiry = $this->request->session()->read('Auth.User.featured_expiry');
		// $userrole_id = $this->request->session()->read('Auth.User.role_id');
		// //echo $userrole_id; die;

		// if ($type == "submit" && $currentdate > date('Y-m-d H:m:s', strtotime($featured_expiry)) && $userrole_id == TALANT_ROLEID) {
		// 	// pr('gallary2730');exit;
		// 	$this->Flash->success(__('Your profile has been successfully updated'));
		// 	return $this->redirect(['action' => 'featureprofile']);
		// } elseif ($type == "submit" && $userrole_id == NONTALANT_ROLEID) {
		// 	$this->Flash->success(__('Your profile has been successfully updated.'));
		// 	return $this->redirect(['action' => 'viewprofile']);
		// }
	}

	// this function used for Report spam
	public function reportspammedia($imageid = null, $vitype = null, $profileid = null)
	{
		//echo "test"; die;
		$this->set('imageid', $imageid);
		$this->set('vitype', $vitype);
		$this->set('profileid', $profileid);
	}

	public function reportspam()
	{
		//echo "test"; die;
		$this->autoRender = false;
		$this->loadModel('Users');
		$this->loadModel('Report');

		$error = '';
		$rstatus = '';
		if ($this->request->is(['post', 'put'])) {
			$userid = $this->request->session()->read('Auth.User.id');
			$profile_id = $this->request->data['profile_id'];
			$data['reason'] = $this->request->data['reportoption'];
			$data['comments'] = $this->request->data['description'];
			$data['reported_by_id'] = $userid;
			$data['profile_id'] = $profile_id;
			$data['type'] = $this->request->data['type'];
			$userreports = $this->Report->find('all')->where(['Report.profile_id' => $profile_id, 'Report.reported_by_id' => $userid])->count();
			//	echo $profile_id; die;
			if ($userreports > 0) {
				$error = 'You have already Reported';
				$rstatus = 0;
			} else {
				$report = $this->Report->newEntity();
				$report = $this->Report->patchEntity($report, $data);
				if ($this->Report->save($report)) {
					$rstatus = 1;
					$totalreports = $this->Report->find('all')->where(['Report.profile_id' => $profile_id])->count();
					$number_of_report_for_block = $this->request->session()->read('settings.block_after_report');
					$unblock_within = $this->request->session()->read('settings.unblock_within');
					if ($totalreports >= $number_of_report_for_block) {
						$userreports = $this->Report->find('all')->where(['Report.profile_id' => $profile_id, 'Report.type' => 'profile'])->count();
						if ($userreports) {
							$users = $this->Users->find('all')->where(['id' => $profile_id])->first();
							$blocked_expiry_str = strtotime('+' . $unblock_within . ' days', time());
							$user_data['blocked_expiry'] = date('Y-m-d H:i:s', $blocked_expiry_str);
							$user_data['blocked_attempts'] = $users['blocked_attempts'] + 1;
							$users = $this->Users->patchEntity($users, $user_data);
							$updateuser = $this->Users->save($users);
						}
					}

					//send like notification
					$this->loadModel('Notification');
					$senderid = $this->request->session()->read('Auth.User.id');
					$recieverid = $this->request->data['user_id'];
					$noti = $this->Notification->newEntity();
					$notification['notification_sender'] = $senderid;
					$notification['notification_receiver'] = $recieverid;
					if ($this->request->data['type'] == "image") {
						$this->loadModel('Galleryimage');
						$notification['type'] = "image report";
						$imagedata = $this->Galleryimage->find('all')->select(['imagename'])->where(['id' => $profile_id])->first();
						$notification['content'] = $imagedata['imagename'];
					} elseif ($this->request->data['type'] == "audio") {
						$this->loadModel('Audio');
						$notification['type'] = "audio report";
						$audiodata = $this->Audio->find('all')->select(['audio_link'])->where(['id' => $profile_id])->first();
						$notification['content'] = $audiodata['audio_link'];
					} elseif ($this->request->data['type'] == "video") {
						$this->loadModel('Video');
						$notification['type'] = "video report";
						$videodata = $this->Video->find('all')->select(['video_type'])->where(['id' => $profile_id])->first();
						$notification['content'] = $videodata['video_type'];
					} elseif ($this->request->data['type'] == "job") {
						$notification['type'] = "job report";
						$notification['content'] = $profile_id;
					} elseif ($this->request->data['type'] == "profile") {
						$notification['type'] = "profile report";
						$notification['notification_receiver'] = $profile_id;
						$notification['content'] = $profile_id;
					}
					$notification = $this->Notification->patchEntity($noti, $notification);
					$this->Notification->save($notification);
				} else {
					$error = 'Something wrong here.';
				}
				// echo $rstatus; die;
			}
			$reportcount = $this->Report->find('all')->where(['Report.profile_id' => $profile_id, 'Report.type' => 'job'])->count();

			$response['count'] = $reportcount;
			$response['error'] = $error;
			$response['status'] = $rstatus;
			if ($rstatus == 1) {
				$this->Flash->success(__('This profile has been reported successfully.'));
				$this->redirect($this->referer());
			} else {
				$this->Flash->success(__($error));
				$this->redirect($this->referer());
			}
			//echo json_encode($response); 
			//	return true;

		}
	}


	public function professionalsummary($type = null)
	{
		$this->loadModel('Professinal_info');
		$this->loadModel('Prof_website');
		$this->loadModel('Prof_exprience');
		$this->loadModel('Current_working');
		$this->loadModel('Users');
		$this->loadModel('Enthicity');
		$this->loadModel('Personnel_det');
		$this->loadModel('Talent_portfolio');
		$this->loadModel('City');
		$this->loadModel('State');
		$this->loadModel('Country');
		$this->loadModel('Skillset');
		$this->loadModel('Skill');

		$id = $this->request->session()->read('Auth.User.id');
		$profile = $this->Profile->find('all')->contain(['Users',  'Enthicity', 'City', 'State', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);


		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id, 'Skill.is_Portfolio' => 1])->order(['Skillset.id' => 'DESC'])->toarray();

		$this->set('skillofcontaint', $contentadminskillset);
		// $skillofcontaint = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id, 'Skill.is_Portfolio' => 1])->order(['Skillset.id' => 'DESC'])->toarray();

		// $this->set('skillofcontaint', $skillofcontaint);


		$contentadminskillsetpersonnel = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id, 'Skill.manage_personnel' => 1])->order(['Skillset.id' => 'DESC'])->toarray();
		$this->set('contentadminskillsetpersonnel', $contentadminskillsetpersonnel);

		$videoprofile = $this->Prof_website->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofile', $videoprofile);
		// get datal only profiletitle field
		// $profile = $this->Profile->find()
		// ->select(['profiletitle']) // Selecting only the profiletitle field
		// ->where(['user_id' => $id])
		// ->first();

		// $this->set('profile',$profile);

		$videoprofilepersoneeldet = $this->Personnel_det->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofilepersoneeldet', $videoprofilepersoneeldet);
		$videoprofiletalentpro = $this->Talent_portfolio->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofiletalentpro', $videoprofiletalentpro);

		$profexp = $this->Prof_exprience->find('all')->where(['user_id' => $id])->toarray();
		$this->set('profexp', $profexp);
		$currentworking = $this->Current_working->find('all')->where(['user_id' => $id])->toarray();
		$this->set('currentworking', $currentworking);
		$profess = $this->Professinal_info->find('all')->where(['user_id' => $id])->first();
		$idcheck = count($profess);
		if ($idcheck > 0) {
			// using for edit
			$proff = $this->Professinal_info->find('all')->where(['user_id' => $id])->first();
		} else {
			$proff = $this->Professinal_info->newEntity();
		}
		$this->set('proff', $proff);
		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
		if ($this->request->is(['post', 'put'])) {
			// pr($this->request->data);
			// exit;
			$this->request->data['user_id'] = $id;
			$this->request->data['profile_title'] = $profile['profiletitle'];
			$prop_bookanartist_count = count($this->request->data['current']['bookenartist']);
			$prop_bookanartist_data = array();

			if ($this->request->data['current']['name'][0]) {
				for ($i = 0; $i < $prop_bookanartist_count; $i++) {
					$from_date = $this->request->data['current']['date_from'][$i];
					$prop_bookanartist_data['name'] = $this->request->data['current']['name'][$i];
					$prop_bookanartist_data['bookenartist'] = $this->request->data['current']['bookenartist'][$i];
					$prop_bookanartist_data['date_from'] = date('Y-m-d', strtotime($from_date . '-01'));
					// pr($prop_bookanartist_data);
					// exit;
					//$prop_bookanartist_data['date_to'] = $this->request->data['datas']['date_to'][$i];
					$prop_bookanartist_data['role'] = $this->request->data['current']['role'][$i];
					$prop_bookanartist_data['location'] = $this->request->data['current']['location'][$i];
					$prop_bookanartist_data['description'] = $this->request->data['current']['description'][$i];
					$prop_bookanartist_data['user_id'] = $id;
					if ($this->request->data['current']['hid'][$i] > 0) {
						$options = $this->Current_working->get($this->request->data['current']['hid'][$i]);
						$option_arr = $this->Current_working->patchEntity($options, $prop_bookanartist_data);
						$savedata = $this->Current_working->save($option_arr);
					} else {
						$options = $this->Current_working->newEntity();
						$option_arr = $this->Current_working->patchEntity($options, $prop_bookanartist_data);
						$savedata = $this->Current_working->save($option_arr);
					}
				}
			}
			$prop_desc_count = count($this->request->data['exp']['description']);
			$prop_desc_data = array();
			$from_date = '';
			$to_date = '';
			if ($this->request->data['exp']['name'][0]) {
				for ($ij = 0; $ij < $prop_desc_count; $ij++) {
					$from_date = $this->request->data['exp']['date_from'][$ij];
					$to_date = $this->request->data['exp']['date_to'][$ij];
					$prop_desc_data['description'] = $this->request->data['exp']['description'][$ij];
					$prop_desc_data['bookenartist'] = $this->request->data['exp']['bookenartist'][$ij];
					$prop_desc_data['name'] = $this->request->data['exp']['name'][$ij];
					$prop_desc_data['location'] = $this->request->data['exp']['location'][$ij];
					$prop_desc_data['role'] = $this->request->data['exp']['role'][$ij];
					if (!empty($from_date)) {
						$prop_desc_data['from_date'] = date('Y-m-d', strtotime($from_date . '-01'));
					}
					if (!empty($to_date)) {
						$prop_desc_data['to_date'] = date('Y-m-d', strtotime($to_date . '-01'));
					}

					// pr($prop_desc_data);exit;
					// $prop_desc_data['from_date'] = date('Y-m-d', strtotime($from_date . '-01'));
					// $prop_desc_data['to_date'] = date('Y-m-d', strtotime($to_date . '-01'));
					$prop_desc_data['user_id'] = $id;
					if ($this->request->data['exp']['hid'][$ij] > 0) {
						$optionsprof = $this->Prof_exprience->get($this->request->data['exp']['hid'][$ij]);
						$option_prof = $this->Prof_exprience->patchEntity($optionsprof, $prop_desc_data);
						$savedata = $this->Prof_exprience->save($option_prof);
					} else {
						$optionsprof = $this->Prof_exprience->newEntity();
						$option_prof = $this->Prof_exprience->patchEntity($optionsprof, $prop_desc_data);
						$savedata = $this->Prof_exprience->save($option_prof);
					}
				}
			}

			$prop_count = count($this->request->data['data']['weblink']);
			$prop_data = array();
			if ($this->request->data['data']['weblink'][0]) {
				for ($i = 0; $i < $prop_count; $i++) {
					$prop_data['web_link'] = $this->request->data['data']['weblink'][$i];
					$prop_data['web_type'] = $this->request->data['data']['webtype'][$i];
					$prop_data['user_id'] = $id;
					if ($this->request->data['data']['hid'][$i] > 0) {
						$optionsweb = $this->Prof_website->get($this->request->data['data']['hid'][$i]);
						$option_web = $this->Prof_website->patchEntity($optionsweb, $prop_data);
						$savedata = $this->Prof_website->save($option_web);
					} else {
						$optionsweb = $this->Prof_website->newEntity();
						$option_web = $this->Prof_website->patchEntity($optionsweb, $prop_data);
						$savedata = $this->Prof_website->save($option_web);
					}
				}
			}
			$prop_counttalentport = count($this->request->data['datatalentport']['talentport']);
			$prop_datatalentport = array();
			if ($this->request->data['datatalentport']['talentport'][0]) {
				for ($i = 0; $i < $prop_counttalentport; $i++) {
					$prop_datatalentport['name'] = $this->request->data['datatalentport']['talentport'][$i];
					$prop_datatalentport['url'] = $this->request->data['datatalentport']['talentporturl'][$i];
					$prop_datatalentport['user_id'] = $id;
					if ($this->request->data['datatalentport']['hid'][$i] > 0) {
						$optionswebtalentport = $this->Talent_portfolio->get($this->request->data['datatalentport']['hid'][$i]);
						$option_webtalentport = $this->Talent_portfolio->patchEntity($optionswebtalentport, $prop_datatalentport);
						$savedatatalentport = $this->Talent_portfolio->save($option_webtalentport);
					} else {
						$optionswebtalentport = $this->Talent_portfolio->newEntity();
						$option_webtalentport = $this->Talent_portfolio->patchEntity($optionswebtalentport, $prop_datatalentport);
						$savedatatalentport = $this->Talent_portfolio->save($option_webtalentport);
					}
				}
			}
			//personnel details
			$prop_countpersonneldet = count($this->request->data['datapersonneldet']['personaldetname']);
			$prop_datapersonneldet = array();
			if ($this->request->data['datapersonneldet']['personaldetname'][0]) {
				for ($i = 0; $i < $prop_countpersonneldet; $i++) {

					$prop_datapersonneldet['name'] = $this->request->data['datapersonneldet']['personaldetname'][$i];
					$prop_datapersonneldet['url'] = $this->request->data['datapersonneldet']['personaldeturl'][$i];
					$prop_datapersonneldet['user_id'] = $id;

					if ($this->request->data['datapersonneldet']['hid'][$i] > 0) {
						$optionswebpersonneldet = $this->Personnel_det->get($this->request->data['datapersonneldet']['hid'][$i]);
						$option_webpersonneldet = $this->Personnel_det->patchEntity($optionswebpersonneldet, $prop_datapersonneldet);
						$savedatapersonneldet = $this->Personnel_det->save($option_webpersonneldet);
					} else {
						$optionswebpersonneldet = $this->Personnel_det->newEntity();
						$option_webpersonneldet = $this->Personnel_det->patchEntity($optionswebpersonneldet, $prop_datapersonneldet);
						$savedatapersonneldet = $this->Personnel_det->save($option_webpersonneldet);
					}
				}
			}

			$profiles = $this->Professinal_info->patchEntity($proff, $this->request->data);
			$savedprofile = $this->Professinal_info->save($profiles);

			if ($savedprofile) {
				$this->Flash->success(__('Proffessional Summary Saved Successfully!!'));
				if ($type == "save") {
					return $this->redirect(['action' => 'performance']);
				}

				$currentdate = date('Y-m-d H:m:s');
				$featured_expiry = $this->request->session()->read('Auth.User.featured_expiry');
				$userrole_id = $this->request->session()->read('Auth.User.role_id');
				//echo $userrole_id; die;

				if ($type == "submit" && $currentdate > date('Y-m-d H:m:s', strtotime($featured_expiry)) && $userrole_id == 2) {
					return $this->redirect(['action' => 'featureprofile']);
				} elseif ($type == "submit") {
					return $this->redirect(['action' => 'viewprofile']);
				}
			}
		}
	}

	public function deletepersonneltalentpro()

	{
		$this->autoRender = false;
		$this->loadModel('Talent_portfolio');
		$id = $this->request->data['datadd'];
		$video = $this->Talent_portfolio->get($id);
		$this->Talent_portfolio->delete($video);
	}

	public function deletepersonneldet()

	{
		$this->autoRender = false;
		$this->loadModel('Personnel_det');
		$id = $this->request->data['datadd'];
		$video = $this->Personnel_det->get($id);
		$this->Personnel_det->delete($video);
	}

	public function deleteproffessionalexp()

	{
		$this->autoRender = false;
		$this->loadModel('Prof_exprience');
		$id = $this->request->data['datadd'];
		$video = $this->Prof_exprience->get($id);
		$this->Prof_exprience->delete($video);
	}
	public function deleteproffessional()

	{
		$this->autoRender = false;
		$this->loadModel('Prof_website');
		$id = $this->request->data['datadd'];
		$video = $this->Prof_website->get($id);
		$this->Prof_website->delete($video);
	}
	public function deleteproffessionalcurrent()

	{
		$this->autoRender = false;
		$this->loadModel('Current_working');
		$id = $this->request->data['datadd'];
		$video = $this->Current_working->get($id);
		$this->Current_working->delete($video);
	}
	public function deletepersonal()

	{
		$this->autoRender = false;
		$this->loadModel('Performance_personaldetails');
		$id = $this->request->data['datadd'];
		$video = $this->Performance_personaldetails->get($id);
		$this->Performance_personaldetails->delete($video);
	}
	public function deletepayment()
	{
		$this->autoRender = false;
		$this->loadModel('Performancedesc2');
		$id = $this->request->data['datadd'];
		$video = $this->Performancedesc2->get($id);
		$this->Performancedesc2->delete($video);
	}
	public function performance($type = null)
	{
		$this->loadModel('Skillset');
		$this->loadModel('Skill');
		$this->loadModel('Genre');
		$this->loadModel('Genreskills');
		$this->loadModel('Users');
		$this->loadModel('Enthicity');
		$this->loadModel('City');
		$this->loadModel('State');
		$this->loadModel('Country');
		//echo $type; die;
		$id = $this->request->session()->read('Auth.User.id');
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'State', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);
		$skills_set = $this->Skillset->find('all')->select(['skill_id'])->where(['Skillset.user_id' => $id])->order(['Skillset.id' => 'DESC'])->toarray();
		foreach ($skills_set as $skills) {
			$userskills[] = $skills['skill_id'];
		}

		$genre = $this->Genreskills->find('all')->select(['Genre.id', 'Genre.name'])->contain(['Genre'])->where(['Genreskills.skill_id IN' => $userskills, 'Genre.parent' => 0, 'Genre.status' => 'Y'])->group('Genreskills.genre_id')->toarray();

		$this->set('genre', $genre);
		foreach ($genre as $gemreres) {
			$gens_id[] = $gemreres['Genre']['id'];
		}

		if ($gens_id) {
			$subgenre = $this->Genre->find('all')->where(['Genre.parent IN' => $gens_id, 'status' => 'Y'])->toarray();
			$this->set('subgenre', $subgenre);
		}
		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
		$this->loadModel('Currency');
		$this->loadModel('Performance_desc');
		$this->loadModel('Performance_genre');
		$this->loadModel('Performance_personaldetails');
		$this->loadModel('Performancedesc2');
		$this->loadModel('Performance_language');
		$this->loadModel('Language');
		$this->loadModel('Payment_fequency');
		$id = $this->request->session()->read('Auth.User.id');
		$lang = $this->Language->find('all')->select(['id', 'name'])->toarray();
		$this->set('lang', $lang);
		$pay_freq = $this->Payment_fequency->find('list')->select(['id', 'name'])->toarray();
		$this->set('pay_freq', $pay_freq);
		$videoprofile = $this->Performance_personaldetails->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofile', $videoprofile);
		$languageknow = $this->Performance_language->find('all')->select(['id', 'language_id'])->where(['Performance_language.user_id' => $id])->order(['Performance_language.id' => 'DESC'])->toarray();
		$this->set('languageknow', $languageknow);
		$performance_genre = $this->Performance_genre->find('all')->select(['id', 'genre_id'])->where(['Performance_genre.user_id' => $id, 'Performance_genre.subgenre_id' => 0])->order(['Performance_genre.id' => 'DESC'])->toarray();
		$this->set('performance_genre', $performance_genre);
		$performance_subgenre = $this->Performance_genre->find('all')->select(['id', 'subgenre_id'])->where(['Performance_genre.user_id' => $id, 'Performance_genre.genre_id' => 0])->order(['Performance_genre.id' => 'DESC'])->toarray();
		$this->set('performance_subgenre', $performance_subgenre);
		$payfrequency = $this->Performancedesc2->find('all')->where(['user_id' => $id])->toarray();
		$this->set('payfrequency', $payfrequency);
		$currency = $this->Currency->find('list')->select(['id', 'name', 'symbol'])->order(['Currency.id' => 'DESC'])->toarray();
		$this->set('currency', $currency);
		$profess = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$idcheck = count($profess);
		if ($idcheck > 0) {
			// using for edit
			$proff = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		} else {
			$proff = $this->Performance_desc->newEntity();
		}
		$this->set('proff', $proff);
		if ($this->request->is(['post', 'put'])) {
			// pr($this->request->data);exit;

			$this->request->data['acceptassignment'] = $this->request->data['acceptassignment'];
			$this->request->data['user_id'] = $id;
			$prop_count = count($this->request->data['data']['url']);
			if ($this->request->data['data']['url'][0]) {
				$prop_data = array();
				for ($i = 0; $i < $prop_count; $i++) {
					$prop_data['name'] = $this->request->data['data']['name'][$i];
					$prop_data['url'] = $this->request->data['data']['url'][$i];
					$prop_data['user_id'] = $id;
					if ($this->request->data['data']['hid'][$i] > 0) {
						$options = $this->Performance_personaldetails->get($this->request->data['data']['hid'][$i]);
						$option_arr = $this->Performance_personaldetails->patchEntity($options, $prop_data);
						$savedata = $this->Performance_personaldetails->save($option_arr);
					} else {
						$options = $this->Performance_personaldetails->newEntity();
						$option_arr = $this->Performance_personaldetails->patchEntity($options, $prop_data);
						$savedata = $this->Performance_personaldetails->save($option_arr);
					}
				}
			}
			$pay_count = count($this->request->data['datas']['payment_frequency']);
			$pay_data = array();
			if ($this->request->data['datas']['payment_frequency'][0]) {
				for ($i = 0; $i < $pay_count; $i++) {
					$pay_data['payment_frequency'] = $this->request->data['datas']['payment_frequency'][$i];
					$pay_data['currency_id'] = $this->request->data['datas']['currency'][$i];
					$pay_data['amount'] = $this->request->data['datas']['amount'][$i];
					$pay_data['user_id'] = $id;
					if ($this->request->data['datas']['hid'][$i] > 0) {
						$optionspay = $this->Performancedesc2->get($this->request->data['datas']['hid'][$i]);
						$option_pay = $this->Performancedesc2->patchEntity($optionspay, $pay_data);
						$savedata = $this->Performancedesc2->save($option_pay);
					} else {

						$optionspay = $this->Performancedesc2->newEntity();
						$option_pay = $this->Performancedesc2->patchEntity($optionspay, $pay_data);
						$savedata = $this->Performancedesc2->save($option_pay);
					}
				}
			}
			$language_count = count($this->request->data['languageknow']);
			if ($language_count > 0) {
				$language_data = array();
				$this->Performance_language->deleteAll(['Languageknown.user_id' => $id]);
				for ($i = 0; $i < $language_count; $i++) {
					if ($this->request->data['languageknow'][$i] > 0) {
						$peopleTable = TableRegistry::get('Performance_language');
						$oQuery = $peopleTable->query();
						$oQuery->insert(['language_id', 'user_id'])->values(['language_id' => $this->request->data['languageknow'][$i], 'user_id' => $id]);
						$d = $oQuery->execute();
					}
				}
			}
			$genre_count = count($this->request->data['genre']);
			if ($genre_count > 0) {
				$genre_data = array();
				$this->Performance_genre->deleteAll(['Performance_genre.user_id' => $id, 'Performance_genre.genre_id >' => '0']);
				for ($i = 0; $i < $genre_count; $i++) {
					if ($this->request->data['genre'][$i] > 0) {
						$subgen = '0';
						$peopleTable = TableRegistry::get('Performance_genre');
						$oQuery = $peopleTable->query();
						$oQuery->insert(['genre_id', 'user_id', 'subgenre_id'])->values(['genre_id' => $this->request->data['genre'][$i], 'user_id' => $id, 'subgenre_id' => $subgen]);
						$d = $oQuery->execute();
					}
				}
			}
			$subgenre_count = count($this->request->data['subgenre']);
			if ($subgenre_count > 0) {
				$subgenre_data = array();
				$this->Performance_genre->deleteAll(['Performance_genre.user_id' => $id, 'Performance_genre.subgenre_id >' => '0']);
				for ($i = 0; $i < $subgenre_count; $i++) {
					if ($this->request->data['subgenre'][$i] > 0) {
						$genre = '0';
						$peopleTable = TableRegistry::get('Performance_genre');
						$oQuery = $peopleTable->query();
						$oQuery->insert(['genre_id', 'user_id', 'subgenre_id'])->values(['genre_id' => $genre, 'user_id' => $id, 'subgenre_id' => $this->request->data['subgenre'][$i]]);
						$d = $oQuery->execute();
					}
				}
			}
			$profiles = $this->Performance_desc->patchEntity($proff, $this->request->data);
			$savedprofile = $this->Performance_desc->save($profiles);
			if ($savedprofile) {
				$this->Flash->success(__('performance Saved Successfully!!'));
				if ($type == "save") {
					return $this->redirect(['action' => 'vitalstatistics']);
				}

				$currentdate = date('Y-m-d H:m:s');
				$featured_expiry = $this->request->session()->read('Auth.User.featured_expiry');
				$userrole_id = $this->request->session()->read('Auth.User.role_id');
				//echo $userrole_id; die;

				if ($type == "submit" && $currentdate > date('Y-m-d H:m:s', strtotime($featured_expiry)) && $userrole_id == 2) {
					return $this->redirect(['action' => 'featureprofile']);
				} elseif ($type == "submit") {
					return $this->redirect(['action' => 'viewprofile']);
				}
			}
		}
	}

	public function vitalstatistics()
	{
		// Load models
		$this->loadModel('Skillset');
		$this->loadModel('Profile');
		$this->loadModel('Vques');
		$this->loadModel('Vitalskills');
		$this->loadModel('Vs_option_type');
		$this->loadModel('Voption');
		$this->loadModel('Skill');
		$this->loadModel('Uservital');
		$this->loadModel('Users');
		$this->loadModel('Enthicity');
		$this->loadModel('City');
		$this->loadModel('State');
		$this->loadModel('Country');

		$id = $this->request->session()->read('Auth.User.id');
		$profile = $this->Profile->find('all')
			->contain(['Users', 'Enthicity', 'City', 'State', 'Country'])
			->where(['user_id' => $id])
			->first();
		$this->set('profile', $profile);

		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);

		$skills_set = $this->Skillset->find('all')
			->select(['skill_id'])
			->where(['Skillset.user_id' => $id])
			->order(['Skillset.id' => 'DESC'])
			->toArray();

		$userskills = array_column($skills_set, 'skill_id');
		$skillfind = $this->Skill->find('all')
			->select(['id'])
			->where(['Skill.id IN' => $userskills, 'is_vital' => 1])
			->toArray();

		if (!empty($skillfind)) {
			$skillsvalue = array_column($skillfind, 'id');
			$vitals = $this->Vitalskills->find('all')
				->contain(['Skill'])
				->where(['Vitalskills.skills_id IN' => $skillsvalue, 'Vitalskills.status' => 'Y'])
				->toArray();
			$this->set('vitals', $vitals);
		}
		$profile = $this->Profile->find('all')
			->select(['gender'])
			->where(['user_id' => $id])
			->first();
		$gender = isset($profile['gender']) ? $profile['gender'] : null; // Check if gender is set
		$gnd = ($gender == 'm' || $gender == 'f') ? [$gender, 'o'] : []; // Set gender-related options

		$query = $this->Vques->find('all')
			->contain(['Voption', 'Vs_option_type'])
			->where(['Vques.status' => 'Y']); // Base query to filter by status

		// Add gender condition only if it's provided
		if (!empty($gnd)) {
			$query->where(['Vques.gender IN' => $gnd]);
		}

		$vitalsquestion = $query
			->order(['Vques.orderstrcture' => 'ASC'])
			->toArray();
		$this->set('vitalsquestion', $vitalsquestion);

		$uservitaled = $this->Uservital->find('all')->where(['user_id' => $id])->toArray();
		$uservitals = !empty($uservitaled) ? $uservitaled : $this->Uservital->newEntity();
		$this->set('uservitals', $uservitals);

		if ($this->request->is(['post', 'put'])) {
			$prop_count = count($this->request->data['data']);
			for ($i = 0; $i < $prop_count; $i++) {
				$vs_question_id = $this->request->data['data'][$i]['vs_question_id'];
				$option_type_id = $this->request->data['data'][$i]['vs_option_id'];
				$value = $this->request->data['data'][$i]['value'];
				$vitalid = $this->request->data['data'][$i]['vitalid'];

				if (empty($value) || $value == 0) {
					continue;
				}

				$prop_data = [
					'vs_question_id' => $vs_question_id,
					'option_type_id' => $option_type_id,
					'user_id' => $id,
				];
				if (in_array($option_type_id, [1, 2, 5])) {
					$prop_data['option_value_id'] = $value;
					$prop_data['value'] = '';
				} else {
					$prop_data['value'] = $value;
					$prop_data['option_value_id'] = '';
				}

				if (!empty($vitalid)) {
					$optionsweb = $this->Uservital->get($vitalid);
					$option_web = $this->Uservital->patchEntity($optionsweb, $prop_data);
				} else {
					$optionsweb = $this->Uservital->newEntity($prop_data);
				}
				$this->Uservital->save($optionsweb);
			}

			$this->Flash->success(__('Vital Statistics Saved Successfully!'));
			return $this->redirect(['action' => 'viewprofile']);
		}
	}

	// vital statistics
	public function viewvitalstatistics($id = null)
	{
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Skillset');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Vques');
		//$this->loadModel('Skillset');
		$this->loadModel('Contactrequest');
		$this->loadModel('Likes');
		$this->loadModel('Activities');
		$this->loadModel('Blocks');
		$this->loadModel('Professinal_info');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Performance_desc');
		$this->loadModel('Uservital');

		$this->loadModel('Voption');
		$this->loadModel('Skill');


		$current_user_id = $this->request->session()->read('Auth.User.id');
		if ($current_user_id != $id) {
			$this->set('userid', $id);
		}

		$content_type = 'profile';
		if (empty($id)) {
			$id = $current_user_id;
		} else {
			$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id, 'Likes.user_id' => $current_user_id])->count();
			$this->set('totaluserlikes', $totaluserlikes);
			$blocks = $this->Blocks->find('all')->where(['Blocks.content_type' => $content_type, 'Blocks.content_id' => $id, 'Blocks.user_id' => $current_user_id])->count();
			$this->set('userblock', $blocks);
		}
		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
		$this->set('totallikes', $totallikes);
		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);

		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);


		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id])->order(['Skillset.id' => 'DESC'])->toarray();
		$this->set('skillofcontaint', $contentadminskillset);
		$conn = ConnectionManager::get('default');
		$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$stmt = $conn->execute($fquery);
		$friends = $stmt->fetchAll('assoc');
		$this->set('friends', $friends);

		// Checking Tabs to show
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);

		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);

		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);

		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $id])->toarray();
		$this->set('uservitals', $uservitals);
	}





	public function unblock($id)
	{

		$this->loadModel('Blocks');
		// $res = $this->Blocks->get($id);
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$is_block = $this->Blocks->find('all')->where(['Blocks.content_type' => 'profile', 'Blocks.content_id' => $id, 'Blocks.user_id' => $current_user_id])->first();
		$res = $this->Blocks->get($is_block['id']);
		if ($this->Blocks->delete($res)) {
			$this->Flash->success(__('User has been unblocked!!'));
			$this->redirect(Router::url($this->referer(), true));
		}
	}


	// View Persoanal Profile
	public function viewprofile($id = null)
	{
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Skillset');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Language');
		$this->loadModel('Languageknown');
		$this->loadModel('Enthicity');
		$this->loadModel('Galleryimage');
		$this->loadModel('Contactrequest');
		$this->loadModel('Likes');
		$this->loadModel('Activities');
		$this->loadModel('Blocks');
		$this->loadModel('Packfeature');
		$this->loadModel('ProfileView');
		$this->loadModel('Professinal_info');
		$this->loadModel('Performance_desc');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');
		$this->loadModel('Video');
		$this->loadModel('Audio');
		$this->loadModel('Notification');
		$this->loadModel('RecuriterPack');
		$this->loadModel('Subscription');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		// Check if the user is authorized to view the profile
		//   if ($this->Auth->user('id') == $id) {
		// 	$this->set('showGreenTick', true);
		// } else {
		// 	$this->set('showGreenTick', false);
		// }

		$isIdComes = $id;
		// pr($isIdComes);exit;

		if ($current_user_id == '') {
			$this->request->session()->write('profileid', $id);
			return $this->redirect(['controller' => 'users', 'action' => 'login']);
		}

		$is_block = $this->Blocks->find('all')
			->where([
				'Blocks.content_type' => 'profile',
				'Blocks.content_id' => $id,
				'Blocks.user_id' => $current_user_id
			])
			->first();
		$this->set('is_block', $is_block);


		if (!empty($current_user_id) && $current_user_id != $id) {
			$notifind = $this->Notification->find('all')->where(['notification_sender' => $current_user_id, 'notification_receiver' => $id, 'type' => "view profile", 'content' => "1"])->count();
			// pr($notifind);exit;
			if ($notifind == 0) {
				$notinew = $this->Notification->newEntity();
				$noti['notification_sender'] = $current_user_id;
				$noti['notification_receiver'] = $id;
				$noti['type'] = "view profile";
				$noti['content'] = 1;
				if ($noti['notification_receiver'] != 0) {
					$notisave = $this->Notification->patchEntity($notinew, $noti);
					$savedata = $this->Notification->save($notisave);
				}
			}
		}

		$viewproclick = $this->request->session()->read('profileid');
		if ($viewproclick) {
			$id = $viewproclick;
		} else {
			$id = $id;
		}

		// Fetch the active package details
		$packfeature = $this->activePackage('RC');
		// pr($packfeature);exit;
		if (!empty($isIdComes) || $current_user_id == 1) {
			// Extract package limits
			$access_profile_limit = $packfeature['number_of_talent_search'];
			$access_profile_limit_used = $packfeature['number_of_talent_search_used'];
			$packfeature_id = $packfeature['id'];

			// Check if the profile has already been viewed by this user
			$profileExists = $this->ProfileView->find('all')
				->where([
					'ProfileView.profile_id' => $id,
					'ProfileView.user_id' => $current_user_id
				])->first();

			// Calculate 50% limit warning threshold
			$recruiterPackLimit = round($access_profile_limit / 2);

			// If user is not admin, enforce the search limit
			if (!$profileExists && $current_user_id != 1) {

				if ($access_profile_limit_used >= $access_profile_limit) {
					$this->Flash->error(__('You have reached your profile search limit. Upgrade your package to continue searching.'));
					return $this->redirect(SITE_URL . '/package/allpackages/profilepackage/');
				}

				if ($access_profile_limit_used >= $recruiterPackLimit) {
					$this->Flash->error(__('You have reached 50% of your Profile Search limit. Be diligent in your searches.'));
				}
			}

			// If the profile is not yet viewed, save it and update the limit
			if (!$profileExists) {
				// pr('dddddd');exit;

				if ($current_user_id != 1 && $access_profile_limit_used >= $access_profile_limit) {
					$this->Flash->error(__('You cannot search for more profiles. Upgrade your package.'));
					return $this->redirect(SITE_URL . '/package/allpackages/profilepackage/');
				}

				$profileView = $this->ProfileView->newEntity();
				$profileData = [
					'profile_id' => $id,
					'user_id' => $current_user_id
				];
				$jobViewDataSave = $this->ProfileView->patchEntity($profileView, $profileData);
				$this->ProfileView->save($jobViewDataSave);

				// Update search count
				$packfeature = $this->Packfeature->get($packfeature_id);
				$featureInfo = ['number_of_talent_search_used' => $access_profile_limit_used + 1];
				$featuresArr = $this->Packfeature->patchEntity($packfeature, $featureInfo);
				$this->Packfeature->save($featuresArr);
			}
		}


		if ($current_user_id != $id) {
			$this->set('userid', $id);
		}

		$content_type = 'profile';
		if (empty($id)) {
			$id = $current_user_id;
		} else {
			$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id, 'Likes.user_id' => $current_user_id])->count();
			$this->set('totaluserlikes', $totaluserlikes);
			$blocks = $this->Blocks->find('all')->where(['Blocks.content_type' => $content_type, 'Blocks.content_id' => $id, 'Blocks.user_id' => $current_user_id])->count();
			$this->set('userblock', $blocks);
		}

		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
		$this->set('totallikes', $totallikes);

		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);

		$languageknow = $this->Languageknown->find('all')->select(['id', 'language_id', 'Language.name'])->contain(['Language'])->where(['Languageknown.user_id' => $id])->order(['Languageknown.id' => 'DESC'])->toarray();
		$this->set('languageknow', $languageknow);

		if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
			$gallerylimit = $packfeature['non_telent_totalnumber_of_images'];
		} else {
			$gallerylimit = $packfeature['number_of_photo'];
		}

		$totalimages = $this->Galleryimage->find('all')
			->select(['imagename'])
			->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => '0'])
			->order(['Galleryimage.id' => 'DESC'])
			->limit($gallerylimit)
			->toarray();
		$this->set('totalimages', $totalimages);
		// pr($totalimages);exit;
		$galleryimages = $this->Galleryimage->find('all')
			->select(['imagename', 'id'])
			->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => 0])
			->order(['Galleryimage.id' => 'DESC'])
			->limit($gallerylimit)
			->toarray();
		$this->set('galleryimages', $galleryimages);
		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id])->order(['Skillset.id' => 'DESC'])->toarray();

		$skil = $contentadminskillset[0]['skill']['name'];
		$this->set('skil', $skil);
		$this->set('skillofcontaint', $contentadminskillset);
		$conn = ConnectionManager::get('default');
		$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$stmt = $conn->execute($fquery);
		$friends = $stmt->fetchAll('assoc');
		$this->set('friends', $friends);

		$activities = $this->Activities->find('all')->contain(['Galleryimage', 'Likes', 'Video', 'Audio', 'Users'])->where(['Activities.user_id' => $id, 'Activities.activity_type NOT IN' => ['unblock_profile', 'block_profile']])->order(['Activities.id' => 'DESC'])->limit(50)->toarray();
		$this->set('activities', $activities);

		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'Country', 'State'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);

		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);

		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);
		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $id])->toarray();
		$this->set('uservitals', $uservitals);

		$session = $this->request->session();
		$session->delete('profileid');
		$this->loadModel('PersonalPage');
		$viewpage = $this->PersonalPage->find('all')->where(['user_id' => $id])->first();
		$this->set('viewpage', $viewpage);
	}

	public function profiledetails($id)
	{
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Skillset');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Language');
		$this->loadModel('Languageknown');
		$this->loadModel('Enthicity');
		$this->loadModel('Galleryimage');
		$this->loadModel('Contactrequest');
		$this->loadModel('Likes');
		$this->loadModel('Activities');
		$this->loadModel('Blocks');
		$this->loadModel('Packfeature');
		$this->loadModel('ProfileView');
		$this->loadModel('Professinal_info');
		$this->loadModel('Performance_desc');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');
		$this->loadModel('Video');
		$this->loadModel('Audio');
		$this->loadModel('Notification');
		$this->loadModel('RecuriterPack');
		$this->loadModel('Subscription');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		// pr($current_user_id);exit;

		if ($current_user_id) {
			$this->request->session()->write('profileid', $id);
		}

		// Fetch the active package details
		$packfeature = $this->activePackage('RC');
		// pr($packfeature);exit;

		$this->set('userid', $id);
		$content_type = 'profile';
		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
		$this->set('totallikes', $totallikes);

		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);

		$languageknow = $this->Languageknown->find('all')->select(['id', 'language_id', 'Language.name'])->contain(['Language'])->where(['Languageknown.user_id' => $id])->order(['Languageknown.id' => 'DESC'])->toarray();
		$this->set('languageknow', $languageknow);


		$totalimages = $this->Galleryimage->find('all')
			->select(['imagename'])
			->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => '0'])
			->order(['Galleryimage.id' => 'DESC'])
			->toarray();
		$this->set('totalimages', $totalimages);

		$galleryimages = $this->Galleryimage->find('all')
			->select(['imagename', 'id'])
			->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => 0])
			->order(['Galleryimage.id' => 'DESC'])
			->toarray();
		$this->set('galleryimages', $galleryimages);
		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id])->order(['Skillset.id' => 'DESC'])->toarray();

		$skil = $contentadminskillset[0]['skill']['name'];
		$this->set('skil', $skil);
		$this->set('skillofcontaint', $contentadminskillset);
		$conn = ConnectionManager::get('default');
		$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$stmt = $conn->execute($fquery);
		$friends = $stmt->fetchAll('assoc');
		$this->set('friends', $friends);

		$activities = $this->Activities->find('all')->contain(['Galleryimage', 'Likes', 'Video', 'Audio', 'Users'])->where(['Activities.user_id' => $id, 'Activities.activity_type NOT IN' => ['unblock_profile', 'block_profile']])->order(['Activities.id' => 'DESC'])->limit(50)->toarray();
		$this->set('activities', $activities);

		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'Country', 'State'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);

		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);

		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);
		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $id])->toarray();
		$this->set('uservitals', $uservitals);

		$session = $this->request->session();
		$session->delete('profileid');
		$this->loadModel('PersonalPage');
		$viewpage = $this->PersonalPage->find('all')->where(['user_id' => $id])->first();
		$this->set('viewpage', $viewpage);
	}

	// View Professional summery
	public function viewprofessionalsummary($id = null)
	{
		$this->loadModel('Profile');
		$this->loadModel('Contactrequest');
		$this->loadModel('Enthicity');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$this->loadModel('Blocks');
		$this->loadModel('Professinal_info');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');
		$this->loadModel('Performance_desc');

		if ($current_user_id != $id) {
			$this->set('userid', $id);
		}

		$content_type = 'profile';
		if (empty($id)) {
			$id = $current_user_id;
		} else {
			$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id, 'Likes.user_id' => $current_user_id])->count();
			$this->set('totaluserlikes', $totaluserlikes);
			$blocks = $this->Blocks->find('all')->where(['Blocks.content_type' => $content_type, 'Blocks.content_id' => $id, 'Blocks.user_id' => $current_user_id])->count();
			$this->set('userblock', $blocks);
		}
		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
		$this->set('totallikes', $totallikes);
		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
		$conn = ConnectionManager::get('default');
		$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$stmt = $conn->execute($fquery);
		$friends = $stmt->fetchAll('assoc');
		$this->set('friends', $friends);

		$this->loadModel('Prof_website');
		$this->loadModel('Prof_exprience');
		$this->loadModel('Current_working');

		$this->loadModel('Personnel_det');
		$this->loadModel('Talent_portfolio');
		$videoprofile = $this->Prof_website->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofile', $videoprofile);

		$videoprofilepersoneeldet = $this->Personnel_det->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofilepersoneeldet', $videoprofilepersoneeldet);
		$videoprofiletalentpro = $this->Talent_portfolio->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofiletalentpro', $videoprofiletalentpro);

		$profexp = $this->Prof_exprience->find('all')->where(['user_id' => $id])->toarray();
		$this->set('profexp', $profexp);
		$currentworking = $this->Current_working->find('all')->where(['user_id' => $id])->toarray();
		$this->set('currentworking', $currentworking);
		$profess = $this->Professinal_info->find('all')->where(['user_id' => $id])->first();
		$this->set('proff', $profess);

		// Checking Tabs to show
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);

		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);

		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);

		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $id])->toarray();
		$this->set('uservitals', $uservitals);
	}


	public function viewperformance($id = null)
	{
		$this->loadModel('Profile');
		$this->loadModel('Contactrequest');
		$this->loadModel('Enthicity');
		$this->loadModel('Skillset');
		$this->loadModel('Skill');
		$this->loadModel('Genre');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$this->loadModel('Blocks');
		$this->loadModel('Professinal_info');
		$this->loadModel('Genreskills');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');

		$current_user_id = $this->request->session()->read('Auth.User.id');
		if ($current_user_id != $id) {
			$this->set('userid', $id);
		}

		$content_type = 'profile';
		if (empty($id)) {
			$id = $current_user_id;
		} else {
			$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id, 'Likes.user_id' => $current_user_id])->count();
			$this->set('totaluserlikes', $totaluserlikes);
			$blocks = $this->Blocks->find('all')->where(['Blocks.content_type' => $content_type, 'Blocks.content_id' => $id, 'Blocks.user_id' => $current_user_id])->count();
			$this->set('userblock', $blocks);
		}
		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);


		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
		$this->set('totallikes', $totallikes);

		$conn = ConnectionManager::get('default');
		$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$stmt = $conn->execute($fquery);
		$friends = $stmt->fetchAll('assoc');
		$this->set('friends', $friends);


		$skills_set = $this->Skillset->find('all')->select(['skill_id'])->where(['Skillset.user_id' => $id])->order(['Skillset.id' => 'DESC'])->toarray();
		foreach ($skills_set as $skills) {
			$userskills[] = $skills['skill_id'];
		}
		$genre = $this->Genreskills->find('all')->select(['Genre.id', 'Genre.name'])->contain(['Genre'])->where(['Genreskills.skill_id IN' => $userskills, 'Genre.parent' => 0, 'Genre.status' => 'Y'])->group('Genreskills.genre_id')->toarray();

		$this->set('genre', $genre);
		foreach ($genre as $gemreres) {
			$gens_id[] = $gemreres['Genre']['id'];
		}
		if ($gens_id) {
			$subgenre = $this->Genre->find('all')->where(['Genre.parent IN' => $gens_id, 'status' => 'Y'])->toarray();
		}
		$this->set('subgenre', $subgenre);
		$this->loadModel('Currency');
		$this->loadModel('Performance_desc');
		$this->loadModel('Performance_genre');
		$this->loadModel('Performance_personaldetails');
		$this->loadModel('Performancedesc2');
		$this->loadModel('Performancelanguage');
		$this->loadModel('Language');
		$this->loadModel('Payment_fequency');
		$lang = $this->Language->find('all')->select(['id', 'name'])->toarray();
		$this->set('lang', $lang);

		$pay_freq = $this->Payment_fequency->find('list')->select(['id', 'name'])->toarray();
		$this->set('pay_freq', $pay_freq);

		$videoprofile = $this->Performance_personaldetails->find('all')->where(['user_id' => $id])->toarray();
		$this->set('videoprofile', $videoprofile);

		$languageknow = $this->Performancelanguage->find('all')->select(['id', 'language_id', 'Language.name'])->contain(['Language'])->where(['Performancelanguage.user_id' => $id])->order(['Performancelanguage.id' => 'DESC'])->toarray();

		$this->set('languageknow', $languageknow);
		$performance_genre = $this->Performance_genre->find('all')->select(['id', 'genre_id'])->where(['Performance_genre.user_id' => $id, 'Performance_genre.subgenre_id' => 0])->order(['Performance_genre.id' => 'DESC'])->toarray();
		$this->set('performance_genre', $performance_genre);
		$performance_subgenre = $this->Performance_genre->find('all')->select(['id', 'subgenre_id'])->where(['Performance_genre.user_id' => $id, 'Performance_genre.genre_id' => 0])->order(['Performance_genre.id' => 'DESC'])->toarray();
		$this->set('performance_subgenre', $performance_subgenre);
		$payfrequency = $this->Performancedesc2->find('all')->contain(['Currency', 'Paymentfequency'])->where(['user_id' => $id])->toarray();
		$this->set('payfrequency', $payfrequency);
		$currency = $this->Currency->find('list')->select(['id', 'name', 'symbol'])->order(['Currency.id' => 'DESC'])->toarray();
		$this->set('currency', $currency);
		// Checking Tabs to show
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);

		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);


		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);


		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $id])->toarray();
		$this->set('uservitals', $uservitals);
	}

	// View Gallery Albums
	public function viewgalleries($id = null)
	{
		$this->loadModel('Profile');
		$this->loadModel('Contactrequest');
		$this->loadModel('Enthicity');
		$this->loadModel('Galleryimage');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$this->loadModel('Gallery');
		$this->loadModel('Blocks');
		$this->loadModel('Professinal_info');
		$this->loadModel('Video');
		$this->loadModel('Audio');
		$this->loadModel('Performance_desc');
		$this->loadModel('Settings');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');


		$current_user_id = $this->request->session()->read('Auth.User.id');
		if ($current_user_id != $id) {
			$this->set('userid', $id);
		}
		$content_type = 'profile';
		if (empty($id)) {
			$id = $current_user_id;
		} else {
			$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id, 'Likes.user_id' => $current_user_id])->count();
			$this->set('totaluserlikes', $totaluserlikes);
			$blocks = $this->Blocks->find('all')->where(['Blocks.content_type' => $content_type, 'Blocks.content_id' => $id, 'Blocks.user_id' => $current_user_id])->count();
			$this->set('userblock', $blocks);
		}
		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);

		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
		$this->set('totallikes', $totallikes);

		$conn = ConnectionManager::get('default');
		$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$stmt = $conn->execute($fquery);
		$friends = $stmt->fetchAll('assoc');
		$this->set('friends', $friends);

		//$total_photos = $this->Galleryimage->find('all')->where(['user_id' => $id,'gallery_id'=>0])->count();

		//echo $total_photos;
		// Total Video counts

		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();
		$this->loadModel('Packfeature');
		$packfeature = $this->activePackage();

		if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
			$number_audio_lt = $packfeature['non_talent_audio_list_total'];
			$number_video_lt = $packfeature['non_talent_video_list_total'];
			$totalPhotoLimit = $packfeature['non_telent_totalnumber_of_images'];
			$album_limit = $packfeature['non_telent_number_of_album'];
		} else {
			$totalPhotoLimit = 50; // because get all for 
			$number_audio_lt = 50; // because get all for 
			$number_video_lt = 50; // because get all for 
			$album_limit = 50; // because get all for 
		}

		// pr($totalPhotoLimit);
		// exit;
		// Total Photos counts
		$total_photos = $this->Galleryimage->find('all')
			->where(['user_id' => $id, 'status' => 1])
			->limit($totalPhotoLimit)
			->count();
		$this->set('total_photos', $total_photos);

		// Audios
		$audios = $this->Audio->find('all')->select(['audio_link', 'audio_type'])->where(['Audio.user_id' => $id])->order(['Audio.id' => 'DESC'])->limit($number_audio_lt)->toarray();
		$this->set('audios', $audios);

		// Videos
		$videos = $this->Video->find('all')->select(['video_name', 'video_type', 'thumbnail', 'id', 'caption'])->where(['Video.user_id' => $id])->order(['Video.id' => 'DESC'])->limit($number_video_lt)->toarray();
		$this->set('videos', $videos);

		$total_videos = $this->Video->find('all')->limit($number_video_lt)->where(['user_id' => $id])->count();
		$this->set('total_videos', $total_videos);

		// Total Audios counts
		$total_audios = $this->Audio->find('all')->limit($number_audio_lt)->where(['user_id' => $id])->count();
		$this->set('total_audios', $total_audios);

		// Albums
		$galleryprofile = $this->Gallery->find('all')
			->contain(['Galleryimage'])
			->limit($album_limit)
			->where([
				'Gallery.user_id' => $id,
				// 'Galleryimage.id !=' => 0 
			])
			->order(['Gallery.id' => 'DESC'])
			->toArray();

		$this->set('galleryprofile', $galleryprofile);


		$admin_setting = $this->Settings->find('all')->first();
		if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
			$singleimages = $this->Galleryimage->find('all')->select(['id', 'imagename', 'caption'])->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => 0, 'Galleryimage.status' => 1])
				->limit($totalPhotoLimit)
				->order(['Galleryimage.id' => 'DESC'])
				->toarray();
		} else {
			$singleimages = $this->Galleryimage->find('all')
				->select(['id', 'imagename', 'caption'])
				->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => 0, 'Galleryimage.status' => 1])
				->order(['Galleryimage.id' => 'DESC'])
				->toarray();
		}


		$this->set('singleimages', $singleimages);

		// Checking Tabs to show
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);

		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);

		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);

		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $id])->toarray();
		$this->set('uservitals', $uservitals);
	}

	// View Gallery Videos
	public function viewvideos($id = null)
	{
		$this->loadModel('Profile');
		$this->loadModel('Contactrequest');
		$this->loadModel('Enthicity');
		$this->loadModel('Galleryimage');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$this->loadModel('Audio');
		$this->loadModel('Video');
		$this->loadModel('Blocks');
		$this->loadModel('Professinal_info');
		$this->loadModel('Performance_desc');
		$this->loadModel('Settings');

		$current_user_id = $this->request->session()->read('Auth.User.id');
		if ($current_user_id != $id) {
			$this->set('userid', $id);
		}
		$content_type = 'profile';
		if (empty($id)) {
			$id = $current_user_id;
		} else {
			$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id, 'Likes.user_id' => $current_user_id])->count();
			$this->set('totaluserlikes', $totaluserlikes);
			$blocks = $this->Blocks->find('all')->where(['Blocks.content_type' => $content_type, 'Blocks.content_id' => $id, 'Blocks.user_id' => $current_user_id])->count();
			$this->set('userblock', $blocks);
		}
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');

		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
		$this->set('totallikes', $totallikes);

		$conn = ConnectionManager::get('default');
		$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$stmt = $conn->execute($fquery);
		$friends = $stmt->fetchAll('assoc');
		$this->set('friends', $friends);

		// Photos
		$galleryimages = $this->Galleryimage->find('all')->select(['imagename', 'caption'])->where(['Galleryimage.user_id' => $id])->order(['Galleryimage.id' => 'DESC'])->toarray();
		$this->set('galleryimages', $galleryimages);

		// Audios
		$this->loadModel('Packfeature');
		$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();

		if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
			$number_audio_lt = $packfeature['non_talent_audio_list_total'];
			$number_video_lt = $packfeature['non_talent_video_list_total'];
			$totalPhotoLimit = $packfeature['non_telent_totalnumber_of_images'];
			$album_limit = $packfeature['non_telent_number_of_album'];
		} else {
			$totalPhotoLimit = 50; // because get all for 
			$number_audio_lt = 50; // because get all for 
			$number_video_lt = 50; // because get all for 
			$album_limit = 50; // because get all for 
		}

		$audios = $this->Audio->find('all')->select(['audio_link', 'audio_type'])->where(['Audio.user_id' => $id])->order(['Audio.id' => 'DESC'])->limit($number_audio_lt)->toarray();
		$this->set('audios', $audios);

		// Videos
		$videos = $this->Video->find('all')->select(['video_name', 'video_type', 'thumbnail', 'id', 'caption'])->where(['Video.user_id' => $id])->order(['Video.id' => 'DESC'])->limit($number_video_lt)->toarray();
		$this->set('videos', $videos);

		// Total Photos counts
		//$total_photos = $this->Galleryimage->find('all')->where(['user_id' => $id,'gallery_id'=>0])->count();
		$total_photos = $this->Galleryimage->find('all')->where(['user_id' => $id, 'status' => 1])->count();
		$this->set('total_photos', $total_photos);
		//echo $total_photos;
		// Total Video counts
		$total_videos = $this->Video->find('all')->where(['user_id' => $id])->count();
		$this->set('total_videos', $total_videos);
		// Total Audios counts
		$total_audios = $this->Audio->find('all')->where(['user_id' => $id])->count();
		$this->set('total_audios', $total_audios);

		// Checking Tabs to show
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);

		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);

		//	$proff = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		//$this->set('proff', $proff);
		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);
		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $id])->toarray();
		$this->set('uservitals', $uservitals);

		$admin_setting = $this->Settings->find('all')->first();
		if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
			$singleimages = $this->Galleryimage->find('all')->select(['id', 'imagename', 'status'])->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => '0'])->order(['Galleryimage.id' => 'DESC'])->limit($totalPhotoLimit)->toarray();
		} else {
			$singleimages = $this->Galleryimage->find('all')->select(['id', 'imagename', 'status'])->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => '0'])->order(['Galleryimage.id' => 'DESC'])->toarray();
		}
		$this->set('singleimages', $singleimages);
	}

	// View Gallery Audios
	public function viewaudios($id = null)
	{
		$this->loadModel('Profile');
		$this->loadModel('Contactrequest');
		$this->loadModel('Enthicity');
		$this->loadModel('Galleryimage');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$this->loadModel('Audio');
		$this->loadModel('Video');
		$this->loadModel('Blocks');
		$this->loadModel('Professinal_info');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');
		$this->loadModel('Performance_desc');
		$this->loadModel('Settings');

		$this->set('userid', $id);
		$current_user_id = $this->request->session()->read('Auth.User.id');
		if ($current_user_id != $id) {
			$this->set('profile_id', $id);
		}
		$content_type = 'profile';
		if (empty($id)) {
			$id = $current_user_id;
		} else {
			$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id, 'Likes.user_id' => $current_user_id])->count();
			$this->set('totaluserlikes', $totaluserlikes);
			$blocks = $this->Blocks->find('all')->where(['Blocks.content_type' => $content_type, 'Blocks.content_id' => $id, 'Blocks.user_id' => $current_user_id])->count();
			$this->set('userblock', $blocks);
		}

		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
		$this->set('totallikes', $totallikes);

		$conn = ConnectionManager::get('default');
		$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$stmt = $conn->execute($fquery);
		$friends = $stmt->fetchAll('assoc');
		$this->set('friends', $friends);

		// Photos
		$galleryimages = $this->Galleryimage->find('all')->select(['imagename', 'caption'])->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => 0])->order(['Galleryimage.id' => 'DESC'])->toarray();
		$this->set('galleryimages', $galleryimages);

		// Audios
		$this->loadModel('Packfeature');
		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();

		$packfeature = $this->activePackage();

		if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
			$number_audio_lt = $packfeature['non_talent_audio_list_total'];
			$number_video_lt = $packfeature['non_talent_video_list_total'];
			$totalPhotoLimit = $packfeature['non_telent_totalnumber_of_images'];
			$album_limit = $packfeature['non_telent_number_of_album'];
		} else {
			$totalPhotoLimit = 50; // because get all for 
			$number_audio_lt = 50; // because get all for 
			$number_video_lt = 50; // because get all for 
			$album_limit = 50; // because get all for 
		}

		$audios = $this->Audio->find('all')->select(['audio_link', 'audio_type', 'id', 'created'])->where(['Audio.user_id' => $id])->order(['Audio.id' => 'DESC'])->limit($number_audio_lt)->toarray();
		$this->set('audios', $audios);

		// Total Audios counts
		$total_audios = $this->Audio->find('all')->where(['user_id' => $id])->limit($number_audio_lt)->count();
		$this->set('total_audios', $total_audios);


		// Videos
		$videos = $this->Video->find('all')->select(['video_name', 'video_type', 'thumbnail'])->where(['Video.user_id' => $id])->order(['Video.id' => 'DESC'])->limit($number_video_lt)->toarray();
		$this->set('videos', $videos);


		// Total Photos counts
		//$total_photos = $this->Galleryimage->find('all')->where(['user_id' => $id,'gallery_id'=>0])->count();
		$total_photos = $this->Galleryimage->find('all')->where(['user_id' => $id, 'Galleryimage.gallery_id' => 0, 'status' => 1])->count();
		$this->set('total_photos', $total_photos);
		//echo $total_photos;
		// Total Video counts
		$total_videos = $this->Video->find('all')->where(['user_id' => $id])->count();
		$this->set('total_videos', $total_videos);


		// Checking Tabs to show
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);

		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);

		//$proff = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		//$this->set('proff', $proff);
		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);
		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $id])->toarray();
		$this->set('uservitals', $uservitals);

		$admin_setting = $this->Settings->find('all')->first();
		if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
			$singleimages = $this->Galleryimage->find('all')->select(['id', 'imagename', 'caption'])->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => 0, 'Galleryimage.status' => 1])->order(['Galleryimage.id' => 'DESC'])->limit($totalPhotoLimit)->toarray();
		} else {
			$singleimages = $this->Galleryimage->find('all')->select(['id', 'imagename', 'caption'])->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => 0, 'Galleryimage.status' => 1])->order(['Galleryimage.id' => 'DESC'])->toarray();
		}

		$this->set('singleimages', $singleimages);
	}

	// View Gallery Images
	public function viewimages($id = null, $album_id = null)
	{
		$this->loadModel('Profile');
		$this->loadModel('Contactrequest');
		$this->loadModel('Enthicity');
		$this->loadModel('Galleryimage');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$this->loadModel('Blocks');
		$this->loadModel('Gallery');
		$this->loadModel('Professinal_info');
		$this->loadModel('Video');
		$this->loadModel('Audio');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');
		$this->loadModel('Performance_desc');

		$galleryalbumname = $this->Gallery->find('all')->where(['Gallery.id' => $album_id])->first();
		$this->set('galleryalbumname', $galleryalbumname);

		$current_user_id = $this->request->session()->read('Auth.User.id');
		if ($current_user_id != $id) {
			$this->set('userid', $id);
		}
		$content_type = 'profile';
		if (empty($id)) {
			$id = $current_user_id;
		} else {
			$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id, 'Likes.user_id' => $current_user_id])->count();
			$this->set('totaluserlikes', $totaluserlikes);
			$blocks = $this->Blocks->find('all')->where(['Blocks.content_type' => $content_type, 'Blocks.content_id' => $id, 'Blocks.user_id' => $current_user_id])->count();
			$this->set('userblock', $blocks);
		}

		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
		$this->set('totallikes', $totallikes);

		$conn = ConnectionManager::get('default');
		$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$stmt = $conn->execute($fquery);
		$friends = $stmt->fetchAll('assoc');
		$this->set('friends', $friends);

		$this->set('album_id', $album_id);

		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);

		// Albums Photos
		$galleryimages = $this->Galleryimage->find('all')->select(['id', 'gallery_id', 'imagename', 'caption'])->where(['Galleryimage.gallery_id' => $album_id, 'Galleryimage.status' => 1])->order(['Galleryimage.id' => 'DESC'])->toarray();
		$this->set('galleryimages', $galleryimages);


		// Audios
		$this->loadModel('Packfeature');
		// $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();
		$packfeature = $this->activePackage();

		if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
			$number_audio_lt = $packfeature['non_talent_audio_list_total'];
			$number_video_lt = $packfeature['non_talent_video_list_total'];
			$totalPhotoLimit = $packfeature['non_telent_totalnumber_of_images'];
			$album_limit = $packfeature['non_telent_number_of_album'];
		} else {
			$totalPhotoLimit = 50; // because get all for 
			$number_audio_lt = 50; // because get all for 
			$number_video_lt = 50; // because get all for 
			$album_limit = 50; // because get all for 
		}

		$audios = $this->Audio->find('all')->select(['audio_link', 'audio_type'])->where(['Audio.user_id' => $id])->order(['Audio.id' => 'DESC'])->limit($number_audio_lt)->toarray();
		$this->set('audios', $audios);

		// Videos
		$videos = $this->Video->find('all')->select(['video_name', 'video_type', 'thumbnail', 'id', 'caption'])->where(['Video.user_id' => $id])->order(['Video.id' => 'DESC'])->limit($number_video_lt)->toarray();
		$this->set('videos', $videos);

		$total_videos = $this->Video->find('all')->where(['user_id' => $id])->count();
		$this->set('total_videos', $total_videos);
		// Total Audios counts
		$total_audios = $this->Audio->find('all')->where(['user_id' => $id])->count();
		$this->set('total_audios', $total_audios);

		if ($this->request->session()->read('Auth.User.role_id') == NONTALANT_ROLEID) {
			$singleimages = $this->Galleryimage->find('all')->select(['id', 'imagename', 'caption'])->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => 0, 'Galleryimage.status' => 1])->order(['Galleryimage.id' => 'DESC'])->limit($totalPhotoLimit)->toarray();
		} else {
			$singleimages = $this->Galleryimage->find('all')->select(['id', 'imagename', 'caption'])->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => 0, 'Galleryimage.status' => 1])->order(['Galleryimage.id' => 'DESC'])->toarray();
		}

		$this->set('singleimages', $singleimages);
		$this->set('total_photos', count($singleimages));


		// Checking Tabs to show
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);

		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);

		$proff = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('proff', $proff);

		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $id])->toarray();
		$this->set('uservitals', $uservitals);
	}


	public function savedprofiledelete($id)
	{
		$this->loadModel('Saveprofile');
		$gallery = $this->Saveprofile->get($id);
		if ($this->Saveprofile->delete($gallery)) {
			$this->Flash->success(__('Profile Deleted Successfully!!'));
			$this->redirect(Router::url($this->referer(), true));
		}
	}
	public function savedprofile()
	{
		$id = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Saveprofile');
		$savedprfile = $this->Saveprofile->find('all')->contain(['Users'])->where(['Saveprofile.user_id' => $id])->toarray();
		$this->set('savedprfile', $savedprfile);
	}

	// Like Profile
	public function saveprofile()
	{
		$this->loadModel('Saveprofile');
		if ($this->request->is(['post', 'put'])) {
			$profile_id = $this->request->data['user_id'];

			$saveprfile = $this->Saveprofile->find('all')->where(['Saveprofile.p_id' => $profile_id])->first();
			if (empty($saveprfile)) {

				$Saveprofilesenty = $this->Saveprofile->newEntity();
				$this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');
				$this->request->data['p_id'] = $profile_id;
				$saveprofiledata = $this->Saveprofile->patchEntity($Saveprofilesenty, $this->request->data);
				$savedprofile = $this->Saveprofile->save($saveprofiledata);
				$response = array();
				if ($savedprofile) {

					$response['success'] = 1;
				}
			} else {
				$id = $saveprfile['id'];
				$audio = $this->Saveprofile->get($id);
				$this->Saveprofile->delete($audio);
				$response['success'] = 2;
			}
			echo json_encode($response);
			die;
		}
	}

	// Like Profile
	public function likeprofile()
	{
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$error = '';
		// pr($this->request->data);exit;
		if ($this->request->is(['post', 'put'])) {
			$id = $this->request->session()->read('Auth.User.id');
			if (empty($id)) {
				$response['message'] = "You are not logged in";
				$response['status'] = true;
				echo json_encode($response);
				die;
			}
			$user_id = $this->request->data['user_id'];
			if ($id == $user_id) {
				$error = '1';
			} else {
				$content_type = 'profile';
				$likedata['content_id'] = $user_id;
				$likedata['user_id'] = $id;
				$likedata['content_type'] = $content_type;
				$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $user_id, 'Likes.user_id' => $id])->count();
				if ($totaluserlikes > 0) {
					$this->Likes->deleteAll(['Likes.content_type' => $content_type, 'Likes.content_id' => $user_id, 'Likes.user_id' => $id]);
					$status = 'dislike';
					$this->addactivity($userid, 'unlike_profile', $user_id);
				} else {
					$proff = $this->Likes->newEntity();
					$likes = $this->Likes->patchEntity($proff, $likedata);
					$savelike = $this->Likes->save($likes);
					$status = 'like';
					$this->addactivity($userid, 'like_profile', $user_id);

					//send like notification
					$this->loadModel('Notification');
					$senderid = $this->request->session()->read('Auth.User.id');
					$recieverid = $user_id;
					$noti = $this->Notification->newEntity();
					$notification['notification_sender'] = $senderid;
					$notification['notification_receiver'] = $recieverid;
					$notification['type'] = "profile like";
					$notification = $this->Notification->patchEntity($noti, $notification);
					$this->Notification->save($notification);
				}
				$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $user_id])->count();
			}
			$response['error'] = $error;
			$response['status'] = $status;
			$response['count'] = $totallikes;
			echo json_encode($response);
			die;
		}
	}

	// Like Job
	public function likejob()
	{
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$error = '';
		if ($this->request->is(['post', 'put'])) {
			$id = $this->request->session()->read('Auth.User.id');
			$user_id = $this->request->data['user_id'];
			if ($id == $user_id) {
				$error = '1';
			} else {
				$content_type = 'job_profile';
				$likedata['content_id'] = $user_id;
				$likedata['user_id'] = $id;
				$likedata['content_type'] = $content_type;
				$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $user_id, 'Likes.user_id' => $id])->count();
				if ($totaluserlikes > 0) {
					$this->Likes->deleteAll(['Likes.content_type' => $content_type, 'Likes.content_id' => $user_id, 'Likes.user_id' => $id]);
					$status = 'dislike';
					$this->addactivity($userid, 'unlike_job', $user_id);
				} else {
					$proff = $this->Likes->newEntity();
					$likes = $this->Likes->patchEntity($proff, $likedata);
					$savelike = $this->Likes->save($likes);
					$status = 'like';
					$this->addactivity($userid, 'like_job', $user_id);
				}
				$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $user_id])->count();
			}
			$response['error'] = $error;
			$response['status'] = $status;
			$response['count'] = $totallikes;
			echo json_encode($response);
			die;
		}
	}
	// Like Profile
	public function blockprofile()
	{
		$this->loadModel('Users');
		$this->loadModel('Blocks');
		$error = '';
		if ($this->request->is(['post', 'put'])) {
			$id = $this->request->session()->read('Auth.User.id');
			$user_id = $this->request->data['user_id'];
			$block_user = $this->Users->find('all')->where(['Users.id' => $user_id])->first();
			// echo $id.'---'.$user_id;
			if ($id == $user_id) {
				$error = "1";
			} else {
				$content_type = 'profile';
				$blockdata['content_id'] = $user_id;
				$blockdata['user_id'] = $id;
				$blockdata['content_type'] = $content_type;
				$blocks = $this->Blocks->find('all')->where(['Blocks.content_type' => $content_type, 'Blocks.content_id' => $user_id, 'Blocks.user_id' => $id])->count();
				if ($blocks > 0) {
					$this->Blocks->deleteAll(['Blocks.content_type' => $content_type, 'Blocks.content_id' => $user_id, 'Blocks.user_id' => $id]);
					$status = 'unblock';
					$this->addactivity($id, 'unblock_profile', $user_id);
					$response['msg'] = "You have successfully unblocked " . $block_user['user_name'];
				} else {
					$proff = $this->Blocks->newEntity();
					$blockp = $this->Blocks->patchEntity($proff, $blockdata);
					$savelike = $this->Blocks->save($blockp);
					$status = 'block';
					$this->addactivity($id, 'block_profile', $user_id);
					$response['msg'] = "You have successfully blocked " . $block_user['user_name'];
				}
			}
			$response['error'] = $error;
			$response['status'] = $status;

			echo json_encode($response);
			die;
		}
	}

	// Add activity
	public function addactivity($user_id, $activity_type, $content_id)
	{
		$this->loadModel('Activities');

		$activity_data['activity_type'] = $activity_type;
		$activity_data['user_id'] = $this->request->session()->read('Auth.User.id');
		if ($activity_type == 'update_photos') {
			$activity_data['photo_id'] = $content_id;
		} elseif ($activity_type == 'update_album') {
			$activity_data['photo_id'] = $content_id;
		} else if ($activity_type == 'update_profile') {
		} else if ($activity_type == 'block_profile') {
			$activity_data['profile_id'] = $content_id;
		} else if ($activity_type == 'unblock_profile') {
			$activity_data['profile_id'] = $content_id;
		} else if ($activity_type == 'like_profile') {

			$activity_data['profile_id'] = $content_id;
		} else if ($activity_type == 'unlike_profile') {
			$activity_data['profile_id'] = $content_id;
		} else if ($activity_type == 'like_image') {
			$activity_data['profile_id'] = $content_id;
		} else if ($activity_type == 'unlike_image') {
			$activity_data['profile_id'] = $content_id;
		} else if ($activity_type == 'like_audio') {
			$activity_data['profile_id'] = $content_id;
		} else if ($activity_type == 'unlike_audio') {
			$activity_data['profile_id'] = $content_id;
		} else if ($activity_type == 'unlike_video') {
			$activity_data['profile_id'] = $content_id;
		} else if ($activity_type == 'like_video') {
			$activity_data['profile_id'] = $content_id;
		} else if ($activity_type == 'like_job') {
			$activity_data['profile_id'] = $content_id;
		} else if ($activity_type == 'unlike_job') {
			$activity_data['profile_id'] = $content_id;
		} else if ($activity_type == 'upload_video') {
			$activity_data['photo_id'] = $content_id;
		} else if ($activity_type == 'upload_audio') {
			$activity_data['photo_id'] = $content_id;
		}
		$activity_data['photo_id'] = $content_id;

		$activity = $this->Activities->newEntity();
		$activity = $this->Activities->patchEntity($activity, $activity_data);
		$savelike = $this->Activities->save($activity);
		return true;
	}

	// Update captions
	public function updateimagecaption()
	{
		//$this->set('id', $id);
		$this->autoRender = false;
		$userid = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Galleryimage');
		if ($this->request->is(['post', 'put'])) {
			if ($this->request->data['image_id'] != '') {
				$cpation['image_id'] = $this->request->data['image_id'];
				$cpation['album_id'] = $this->request->data['album_id'];
				$cpation['caption'] = $this->request->data['caption'];
				$galleryimage = $this->Galleryimage->get($cpation['image_id']);
				$transports = $this->Galleryimage->patchEntity($galleryimage, $cpation);
				if ($resu = $this->Galleryimage->save($transports)) {
					$this->Flash->success(__('Caption for the image has been uploaded Successfully!!'));
					return $this->redirect(['action' => 'images/' . $cpation['album_id']]);
				}
			}
		}
	}

	public function showalbumimages($id = null, $album_id = null, $imageid = null)
	{
		$this->loadModel('Profile');
		$this->loadModel('Contactrequest');
		$this->loadModel('Enthicity');
		$this->loadModel('Galleryimage');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$this->loadModel('Blocks');
		$this->loadModel('Gallery');
		$this->loadModel('Professinal_info');
		$this->set('album_id', $album_id);
		$galleryalbumname = $this->Gallery->find('all')->where(['Gallery.id' => $album_id])->first();
		$this->set('galleryalbumname', $galleryalbumname);

		$current_user_id = $this->request->session()->read('Auth.User.id');
		if ($current_user_id != $id) {
			$this->set('userid', $id);
		}
		$content_type = 'profile';
		if (empty($id)) {
			$id = $current_user_id;
		} else {
		}
		$this->set('imageid', $imageid);
		// Photos
		$galleryimages = $this->Galleryimage->find('all')->select(['id', 'imagename', 'caption', 'created', 'Users.user_name', 'Users.id'])->contain(['Users'])->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => $album_id])->order(['Galleryimage.id' => 'DESC'])->toarray();
		$this->set('galleryimages', $galleryimages);
	}

	public function showsingleimages($id = null, $imageid = null)
	{
		$this->loadModel('Profile');
		$this->loadModel('Contactrequest');
		$this->loadModel('Enthicity');
		$this->loadModel('Galleryimage');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$this->loadModel('Blocks');
		$this->loadModel('Gallery');
		$this->loadModel('Professinal_info');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		if ($current_user_id != $id) {
			$this->set('userid', $id);
		}
		if (empty($id)) {
			$id = $current_user_id;
		}

		// Photos
		$this->set('imageid', $imageid);
		$singleimages = $this->Galleryimage->find('all')->select(['id', 'imagename', 'created', 'Users.user_name', 'Users.id'])->contain(['Users'])->where(['Galleryimage.user_id' => $id, 'Galleryimage.gallery_id' => '0'])->order(['Galleryimage.id' => 'DESC'])->toarray();
		$this->set('singleimages', $singleimages);


		$content_type = 'image';
		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
		$this->set('totallikes', $totallikes);
	}

	public function viewschedule($id = null)
	{
		$this->loadModel('Profile');
		$this->loadModel('Contactrequest');
		$this->loadModel('Enthicity');
		$this->loadModel('Galleryimage');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$this->loadModel('Gallery');
		$this->loadModel('Blocks');
		$this->loadModel('Professinal_info');
		$this->loadModel('Calendar');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');
		$this->loadModel('Performance_desc');

		if ($current_user_id != $id) {
			$this->set('userid', $id);
		}
		$content_type = 'profile';
		if (empty($id)) {
			$id = $current_user_id;
		} else {
			$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id, 'Likes.user_id' => $current_user_id])->count();
			$this->set('totaluserlikes', $totaluserlikes);
			$blocks = $this->Blocks->find('all')->where(['Blocks.content_type' => $content_type, 'Blocks.content_id' => $id, 'Blocks.user_id' => $current_user_id])->count();
			$this->set('userblock', $blocks);
		}

		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
		$this->set('totallikes', $totallikes);
		$conn = ConnectionManager::get('default');
		$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$stmt = $conn->execute($fquery);
		$friends = $stmt->fetchAll('assoc');
		$this->set('friends', $friends);
		// Checking Tabs to show
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'State', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);
		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);

		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);


		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $id])->toarray();
		$this->set('uservitals', $uservitals);



		$event = $this->Calendar->find('all')->where(['Calendar.type' => 'EV', 'Calendar.user_id' => $id])->toarray();
		$this->set('event', $event);
	}

	public function viewreviews($id = null)
	{
		$this->loadModel('Profile');
		$this->loadModel('Contactrequest');
		$this->loadModel('Enthicity');
		$this->loadModel('Galleryimage');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Country');
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$this->loadModel('Gallery');
		$this->loadModel('Blocks');
		$this->loadModel('Professinal_info');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$this->loadModel('Voption');
		$this->loadModel('Vques');
		$this->loadModel('Uservital');
		$this->loadModel('Performance_desc');
		$this->loadModel('Review');
		$this->loadModel('JobApplication');
		if ($id > 0) {
			$us_id = $id;
		} else {
			$us_id = $this->request->session()->read('Auth.User.id');
		}



		if ($current_user_id != $id) {
			$this->set('userid', $id);
		}
		$content_type = 'profile';
		if (empty($id)) {
			$id = $current_user_id;
		} else {
			$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id, 'Likes.user_id' => $current_user_id])->count();
			$this->set('totaluserlikes', $totaluserlikes);
			$blocks = $this->Blocks->find('all')->where(['Blocks.content_type' => $content_type, 'Blocks.content_id' => $id, 'Blocks.user_id' => $current_user_id])->count();
			$this->set('userblock', $blocks);
		}
		//Excellent Review
		$excellentreviews = array('8.8', '8.9', '9.0', '9.1', '9.2', '9.3', '9.4', '9.6', '9.7', '9.8', '9.9', '10');
		// $excellentreview = $this->Review->find('all')->contain(['Requirement', 'Users' => ['Profile']])->where(['Review.artist_id' => $us_id, 'Review.avgrating IN' => $excellentreviews])->first();
		$excellentreview = $this->Review->find('all')->contain(['Requirement', 'Users' => ['Profile']])->where(['Review.artist_id' => $us_id, 'Review.avgrating IN' => $excellentreviews])->count();
		$this->set('excellentreview', $excellentreview);
		//Good
		$goodreviews = array('6.8', '6.9', '7.0', '7.1', '7.2', '7.3', '7.4', '7.5', '7.6', '7.7', '7.8', '7.9', '8.0', '8.1', '8.2', '8.3', '8.4', '8.5', '8.6', '8.7');
		$goodreview = $this->Review->find('all')->contain(['Requirement', 'Users' => ['Profile']])->where(['Review.artist_id' => $us_id, 'Review.avgrating IN' => $goodreviews])->count();
		$this->set('goodreview', $goodreview);
		//Average
		$averagereviews = array('4.8', '4.9', '5.0', '5.1', '5.2', '5.3', '5.4', '5.5', '5.6', '5.7', '5.8', '5.9', '6.0', '6.1', '6.2', '6.3', '6.4', '6.5', '6.5', '6.5', '6.5', '6.5', '6.5', '6.0', '6.1', '6.2', '6.3', '6.4', '6.5', '6.6', '6.7');
		$averagereview = $this->Review->find('all')->contain(['Requirement', 'Users' => ['Profile']])->where(['Review.artist_id' => $us_id, 'Review.avgrating IN' => $averagereviews])->count();
		$this->set('averagereview', $averagereview);

		//Below Average
		$belowavgreviews = array('2.8', '2.9', '3.0', '3.1', '3.2', '3.3', '3.4', '3.5', '3.6', '3.7', '3.8', '3.9', '4.0', '4.1', '4.2', '4.3', '4.4', '4.5', '4.6', '4.7',);
		$belowavgreview = $this->Review->find('all')->contain(['Requirement', 'Users' => ['Profile']])->where(['Review.artist_id' => $us_id, 'Review.avgrating IN' => $belowavgreviews])->count();
		$this->set('belowavgreview', $belowavgreview);

		//Bad
		$badreviews = array('0.5', '0.6', '0.7', '0.8', '0.9', '1.0', '1.1', '1.2', '1.3', '1.4', '1.5', '1.6', '1.7', '1.8', '1.9', '2.0', '2.1', '2.2', '2.3', '2.4', '2.5', '2.6', '2.7');
		$badreview = $this->Review->find('all')->contain(['Requirement', 'Users' => ['Profile']])->where(['Review.artist_id' => $us_id, 'Review.avgrating IN' => $badreviews])->count();
		$this->set('badreview', $badreview);

		//,'Review.r2 IN'=>$badreviews,'Review.r3 IN'=>$badreviews,'Review.r4 IN'=>$badreviews,'Review.r5 IN'=>$badreviews,'Review.r6 IN'=>$badreviews,'Review.r7 IN'=>$badreviews,'Review.r8 IN'=>$badreviews
		// $review = $this->Review->find('all')->contain(['Requirement', 'Users' => ['Profile' => ['Country', 'City']]])->where(['Review.nontalent_id' => $us_id])->toarray();

		$review = $this->Review->find('all')->contain(['Requirement', 'Users' => ['Profile' => ['Country', 'City']]])->where(['Review.artist_id' => $us_id])->toarray();
		$this->set('review', $review);
		$totaljobcount = count($review);
		foreach ($review as $rev) {
			$totalrating[] = $rev['avgrating'];
		}
		// $totalrating = 8.4;
		$totalreviewcount =  array_sum($totalrating);
		// echo $totalreviewcount; die;
		$alljobcount = $totalreviewcount / $totaljobcount;
		// echo $alljobcount; die;
		$jobavgreview = round($alljobcount, 1);
		// echo $jobavgreview; die;
		$this->set('jobavgreview', $jobavgreview);


		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
		$this->set('totallikes', $totallikes);
		$userpack_check = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$session = $this->request->session();
		$session->write('usercheck', $userpack_check);
		$this->set('user_check', $userpack_check);
		$conn = ConnectionManager::get('default');
		$fquery = "SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.to_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.from_id='" . $id . "' and c.accepted_status='Y' UNION SELECT c.*, p.user_id, p.name, p.profile_image FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $id . "' and c.accepted_status='Y'";
		$stmt = $conn->execute($fquery);
		$friends = $stmt->fetchAll('assoc');
		$this->set('friends', $friends);

		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'State', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);

		// Checking Tabs to show
		$profile = $this->Profile->find('all')->contain(['Users', 'Enthicity', 'City', 'State', 'Country'])->where(['user_id' => $id])->first();
		$this->set('profile', $profile);

		$profile_title = $this->Professinal_info->find('all')->select(['Professinal_info.profile_title', 'Professinal_info.areyoua', 'Professinal_info.performing_month', 'Professinal_info.performing_year'])->where(['user_id' => $id])->first();
		$this->set('profile_title', $profile_title);

		$perdes = $this->Performance_desc->find('all')->where(['user_id' => $id])->first();
		$this->set('perdes', $perdes);

		//$uservitals = $this->Uservital->find('all')->contain(['Vques','Voption'])->where(['user_id' => $current_user_id])->toarray();
		//$this->set('uservitals', $uservitals);

		$uservitals = $this->Uservital->find('all')->contain(['Vques', 'Voption'])->where(['user_id' => $id])->toarray();
		$this->set('uservitals', $uservitals);

		$jobdetail = $this->JobApplication->find('all')->contain(['Requirement', 'Skill', 'Users' => ['Skillset' => ['Skill'], 'Profile', 'Professinal_info']])->where(['JobApplication.user_id' => $us_id])->order(['JobApplication.id' => 'DESC'])->first();
		$this->set('jobdetail', $jobdetail);
	}

	public function getAudio()
	{
		$response = array();
		$url = $this->request->data['url'];
		$autoRender = false;
		$videourls = array('soundcloud.com', 'www.pandora.com', 'www.reverbnation.com', 'tidal.com', 'music.yandex.ru', 'itunes', ' amazon music', 'google play', 'spotify.com', 'open.spotify.com', 'playlist.com', 'myspace.com', 'hypem.com', 'youtube.com', 'tindeck.com', 'freesound.org', 'archive.org', 'discogs.com', 'musica.com', 'mp3.zing.vn', 'deezer.com', 'zaycev.net', 'bandcamp.com', 'nhaccuatui.com', 'letras.mus.br', 'pitchfork.com', 'last.fm', 'zamunda.net', 'xiami.com', 'palcomp3.com', 'cifraclub.com.br', 'biqle.ru', 'suamusica.com.br', 'ulub.pl', 'www.jiosaavn.com');
		$parurl = parse_url($url);
		// pr($parurl);exit;
		if (in_array($parurl['host'], $videourls)) {
			$response['status'] = 1;
		} else {
			$response['status'] = 0;
		}
		echo json_encode($response);
		die;
	}

	public function getVideo()
	{
		$response = array();
		$url = $this->request->data['url'];
		$videourls = array('www.youtube.com', 'vimeo.com', 'www.dailymotion.com', 'www.veoh.com', 'myspace.com', 'vine.co', 'www.ustream.tv', 'www.kankan.com', 'www.break.com', 'www.metacafe.com', 'wwitv.com', 'www.tv.com', 'www.vh1.com', 'www.iqiyi.com', 'www.pptv.com', 'tv.sohu.com', 'yandex.com', 'youku.com', 'www.ku6.com', 'www.nicovideo.jp', 'www.pandora.tv', 'www.vbox7.com', 'tu.tv', 'fc2.com', 'www.babble.com');
		$parurl = parse_url($url);
		if (in_array($parurl['host'], $videourls)) {
			if ($parurl['host'] == $videourls[0]) {
				function getYouTubeThumbnailImage($video_id)
				{
					return  "https://img.youtube.com/vi/$video_id/hqdefault.jpg";
				}
				preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);
				$id = $matches[1];
				$response['image'] = getYouTubeThumbnailImage($id);
				$response['status'] = 1;
			} else if ($parurl['host'] == $videourls[1]) {
				function getVimeoThumb($id)
				{
					$arr_vimeo = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$id.php"));
					return $arr_vimeo[0]['thumbnail_medium'];
				}
				$vid = end(explode('/', $parurl['path']));
				$response['image'] = getVimeoThumb($vid);
				$response['status'] = 1;
			} else if ($parurl['host'] == $videourls[2]) {


				function getDailymotionThumb($id)
				{
					$thumbnail_medium_url = 'https://api.dailymotion.com/video/' . $id . '?fields=thumbnail_medium_url';
					$json_thumbnail = file_get_contents($thumbnail_medium_url);
					$arr_dailymotion = json_decode($json_thumbnail, TRUE);
					$thumb = $arr_dailymotion['thumbnail_medium_url'];
					return  $thumb;
				}

				$daily = end(explode('/', $parurl['path']));
				getDailymotionThumb($daily);
				$response['image'] = getDailymotionThumb($daily);
				$response['status'] = 1;
			} else if ($parurl['host'] == $videourls[5]) {
				function get_vine_thumbnail($id)
				{
					$vine = file_get_contents("http://vine.co/v/{$id}");
					preg_match('/property="og:image" content="(.*?)"/', $vine, $matches);
					return ($matches[1]) ? $matches[1] : false;
				}
				$vinevideo = explode('/', $parurl['path']);
				$response['image'] = get_vine_thumbnail($vinevideo[2]);
				$response['status'] = 1;
			}
		} else {
			$response['status'] = 0;
		}
		echo json_encode($response);
		die;
	}

	public function audiodetail($id)
	{
		$this->loadModel('Audio');
		try {
			$audio = $this->Audio->find('all')->where(['Audio.id' => $id])->first()->toarray();
			$this->set('audio', $audio);
		} catch (FatalErrorException $e) {
			$this->log("Error Occured", 'error');
		}
	}

	public function detail($id)
	{
		$this->loadModel('Video');
		try {
			$video = $this->Video->find('all')->where(['Video.id' => $id])->first()->toarray();
			$this->set('video', $video);
		} catch (FatalErrorException $e) {
			$this->log("Error Occured", 'error');
		}
	}


	// public function contactrequestnoti()
	// {
	// 	//echo "test"; die;
	// 	$this->loadModel('Contactrequest');
	// 	$this->loadModel('Users');
	// 	$this->loadModel('Profile');
	// 	$this->loadModel('Packfeature');

	// 	$uid = $this->request->session()->read('Auth.User.id');

	// 	// Get the current user's active package
	// 	$packfeature = $this->activePackage();
	// 	if (!$packfeature) {
	// 		$response = ['status' => 0, 'error_text' => "No active package found. Please purchase a package to proceed."];
	// 		echo json_encode($response);
	// 		die;
	// 	}

	// 	$friendreq = $this->Contactrequest->find('all')->where(['to_id' => $uid])->count();

	// 	if ($packfeature['number_of_introduction_recived'] < $friendreq) {
	// 		$msg = "You have reached the limit of receiving connection request. Please delete some member under your followers tab to receive more request or upgrade your profile package";
	// 		$this->set('msg', $msg);
	// 	}

	// 	if ($packfeature['number_of_introduction_recived'] >= $friendreq) {
	// 		$conn = ConnectionManager::get('default');
	// 		$frnds = "SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $uid . "' and c.accepted_status='N' and c.deletestatus='N'";
	// 		//echo $frnds; die;
	// 		$frnds_data = $conn->execute($frnds);
	// 		$notifications = $frnds_data->fetchAll('assoc');
	// 		$this->set('contatrequest', $notifications);
	// 	}
	// 	$users = TableRegistry::get('Contactrequest');
	// 	$status = "Y";
	// 	$con = ConnectionManager::get('default');
	// 	$detail = 'UPDATE `contactrequest` SET `viewedstatus` ="' . $status . '" WHERE `contactrequest`.`to_id` = ' . $uid;
	// 	$results = $con->execute($detail);
	// }

	public function contactrequestnoti()
	{
		$this->loadModel('Contactrequest');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Packfeature');

		$uid = $this->request->session()->read('Auth.User.id');
		// Get the current user's active package
		$packfeature = $this->activePackage();
		if (!$packfeature) {
			$response = ['status' => 0, 'error_text' => "No active package found. Please purchase a package to proceed."];
			echo json_encode($response);
			die;
		}

		$friendreq = $this->Contactrequest->find()
			->where(['to_id' => $uid])
			->count();

		if ($packfeature['number_of_introduction_recived'] < $friendreq) {
			$msg = "You have reached the limit of receiving connection requests. Please delete some members under your followers tab to receive more requests or upgrade your profile package.";
			$this->set('msg', $msg);
		} else {

			// Fetch contact requests with joined data
			if ($packfeature['number_of_introduction_recived'] >= $friendreq) {
				$conn = ConnectionManager::get('default');
				$frnds = "SELECT c.*, p.user_id, p.name, p.profile_image,p.location FROM `contactrequest` c inner join users u on c.from_id = u.id inner join personal_profile p on p.user_id=u.id WHERE c.to_id='" . $uid . "' and c.accepted_status='N' and c.deletestatus='N'";
				$frnds_data = $conn->execute($frnds);
				$notifications = $frnds_data->fetchAll('assoc');
				// pr($notifications);exit;
				$this->set('contatrequest', $notifications);
			}
		}
		// pr($notifications);exit;
		// Update viewed status using CakePHP's Query Builder
		$this->Contactrequest->updateAll(
			['viewedstatus' => 'Y'],
			['to_id' => $uid]
		);
	}

	// Manager frirneds
	// public function managefriends($callthis_fun = null)
	// {
	// 	$this->loadModel('Contactrequest');
	// 	$this->loadModel('Packfeature');
	// 	$this->loadModel('Users');
	// 	$response['status'] = "1";
	// 	$response['error_text'] = "";
	// 	$uid = $this->request->session()->read('Auth.User.id');

	// 	if ($this->request->is(['post', 'put'])) {
	// 		$current_user_id = $this->request->session()->read('Auth.User.id');
	// 		$user_id = $this->request->data['user_id'];
	// 		$action = $this->request->data['action'];
	// 		if ($current_user_id == $user_id) {
	// 			$response['status'] = "0";
	// 			$response['error_text'] = "error in script";
	// 		} else {
	// 			$connect_status =  $this->Contactrequest->find('all')->where(['from_id' => $user_id, 'to_id' => $current_user_id])->orWhere(['from_id' => $current_user_id, 'to_id' => $user_id])->first();
	// 			if (count($connect_status) > 0) {
	// 				//	echo "test"; die;
	// 				// echo $connect_status['id'];
	// 				$connects = $this->Contactrequest->get($connect_status['id']);
	// 				if ($action == 'confirm') {

	// 					$connect_data['accepted_status'] = 'Y';
	// 					$connection_data = $this->Contactrequest->patchEntity($connects, $connect_data);
	// 					$savedata = $this->Contactrequest->save($connection_data);
	// 				} elseif ($action == 'reject') {
	// 					$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $current_user_id])->order(['Packfeature.id' => 'ASC'])->first();

	// 					$packfeature_id = $packfeature['id'];
	// 					$packfeature = $this->Packfeature->get($packfeature_id);
	// 					$status['number_of_introduction'] = $packfeature['number_of_introduction'] + 1;
	// 					$status['introduction_sent'] = $packfeature['introduction_sent'] + 1;
	// 					$packfeatures = $this->Packfeature->patchEntity($packfeature, $status);
	// 					$this->Packfeature->save($packfeatures);

	// 					$this->Contactrequest->delete($connects);
	// 					$user_data = $this->Users->find('all')->where(['id' => $user_id])->first();
	// 					if ($user_data['con_req_noti_count'] >= 1) {
	// 						$dataa['con_req_noti_count'] = $user_data['con_req_noti_count'] - 1;
	// 						$savepackk = $this->Users->patchEntity($user_data, $dataa);
	// 						$this->Users->save($savepackk);
	// 					}
	// 				} elseif ($action == 'cancel') {

	// 					$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $current_user_id])->order(['Packfeature.id' => 'ASC'])->first();

	// 					$packfeature_id = $packfeature['id'];
	// 					$packfeature = $this->Packfeature->get($packfeature_id);
	// 					$status['number_of_introduction'] = $packfeature['number_of_introduction'] + 1;
	// 					$status['introduction_sent'] = $packfeature['introduction_sent'] + 1;
	// 					$packfeatures = $this->Packfeature->patchEntity($packfeature, $status);
	// 					$this->Packfeature->save($packfeatures);

	// 					$this->Contactrequest->delete($connects);
	// 					$user_data = $this->Users->find('all')->where(['id' => $user_id])->first();
	// 					if ($user_data['con_req_noti_count'] >= 1) {
	// 						$dataa['con_req_noti_count'] = $user_data['con_req_noti_count'] - 1;
	// 						$savepackk = $this->Users->patchEntity($user_data, $dataa);
	// 						$this->Users->save($savepackk);
	// 					}
	// 				} elseif ($action == 'remove') {

	// 					$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $current_user_id])->order(['Packfeature.id' => 'ASC'])->first();

	// 					$packfeature_id = $packfeature['id'];
	// 					$packfeature = $this->Packfeature->get($packfeature_id);
	// 					$status['number_of_introduction'] = $packfeature['number_of_introduction'] + 1;
	// 					$status['introduction_sent'] = $packfeature['introduction_sent'] - 1;
	// 					$packfeatures = $this->Packfeature->patchEntity($packfeature, $status);
	// 					$this->Packfeature->save($packfeatures);

	// 					$this->Contactrequest->delete($connects);
	// 					$user_data = $this->Users->find('all')->where(['id' => $user_id])->first();
	// 					if ($user_data['con_req_noti_count'] >= 1) {
	// 						$dataa['con_req_noti_count'] = $user_data['con_req_noti_count'] - 1;
	// 						$savepackk = $this->Users->patchEntity($user_data, $dataa);
	// 						$this->Users->save($savepackk);
	// 					}
	// 				}
	// 				$response['status'] = "1";
	// 				$response['error_text'] = "";
	// 			} else {
	// 				//Limit Section
	// 				//echo "test1"; die;


	// 				$user_role = $this->request->session()->read('Auth.User.role_id');
	// 				$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $uid])->order(['Packfeature.id' => 'ASC'])->first();
	// 				//$packfeature['number_of_introduction']=0;
	// 				$request_count_perday = $this->Contactrequest->find('all')->where(['Contactrequest.from_id' => $uid, 'DATE(Contactrequest.created_date)' => date('Y-m-d')])->count();

	// 				$friendreq = $this->Contactrequest->find('all')->where(['to_id' => $user_id])->count();
	// 				$senperson_packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();

	// 				if ($senperson_packfeature['number_of_introduction_recived'] <= $friendreq) {
	// 					$user_data = $this->Users->find('all')->where(['id' => $user_id])->first();
	// 					$response['status'] = "0";
	// 					//$response['error'] = "Your Daily introduction Send Limit Expire Please Upgrade Your package";
	// 					$response['error'] = $user_data['user_name'] . " cannot receive more connect request as the limit of pending request has been reached.";
	// 					echo json_encode($response);
	// 					die;
	// 				}

	// 				if ($packfeature['number_of_introduction'] <= 0) {
	// 					$response['status'] = "0";
	// 					//$response['error'] = "You can not send more request. Cancel Request from your Following list or upgrade your profile package";
	// 					$response['error'] = "You cannot send more requests. Please delete members from your 'Following' tab to send more requests.";
	// 				} else if ($request_count_perda >= $packfeature['introduction_sent']) {
	// 					$response['status'] = "0";
	// 					//$response['error'] = "Your Daily introduction Send Limit Expire Please Upgrade Your package";
	// 					$response['error'] = "You cannot send more requests today. Please delete members from your 'Following' tab or send more requests after 24 hours.";
	// 				} else {
	// 					// End Limit  
	// 					//echo "test"; die;
	// 					$connect_status['from_id'] = $current_user_id;
	// 					$connect_status['to_id'] = $user_id;
	// 					$connects = $this->Contactrequest->newEntity();
	// 					$connection_data = $this->Contactrequest->patchEntity($connects, $connect_status);
	// 					$savedata = $this->Contactrequest->save($connection_data);
	// 					$response['status'] = "1";
	// 					$response['error_text'] = "";
	// 					$packfeature_id = $packfeature['id'];
	// 					$packfeature = $this->Packfeature->get($packfeature_id);
	// 					$status['number_of_introduction'] = $packfeature['number_of_introduction'] - 1;
	// 					//$status['introduction_sent'] = $packfeature['introduction_sent']-1;
	// 					$status['intorducation_send_date'] = date('Y-m-d');
	// 					$packfeatures = $this->Packfeature->patchEntity($packfeature, $status);
	// 					$this->Packfeature->save($packfeatures);

	// 					$user_data = $this->Users->find('all')->where(['id' => $user_id])->first();
	// 					$dataa['con_req_noti_count'] = $user_data['con_req_noti_count'] + 1;
	// 					$savepackk = $this->Users->patchEntity($user_data, $dataa);
	// 					$this->Users->save($savepackk);
	// 				}
	// 			}
	// 		}
	// 		echo json_encode($response);
	// 		die;
	// 	}
	// }

	// rupam singh 
	public function managefriends($callthis_fun = null)
	{
		$this->loadModel('Contactrequest');
		$this->loadModel('Packfeature');
		$this->loadModel('Users');

		$response = ['status' => 1, 'error_text' => ''];
		$current_user_id = $this->request->session()->read('Auth.User.id');
		// pr($this->request->data);exit;
		if ($this->request->is(['post', 'put'])) {
			$user_id = $this->request->data['user_id'];
			$action = $this->request->data['action'];

			if (empty($current_user_id)) {
				$response = ['status' => 0, 'error_text' => "Yor are not login"];
				echo json_encode($response);
				die;
			}

			if ($current_user_id == $user_id) {
				$response = ['status' => 0, 'error_text' => "You can't add yourself as a friend."];
				echo json_encode($response);
				die;
			}

			// Get the current user's active package
			$packfeature = $this->activePackage();
			if (!$packfeature) {
				$response = ['status' => 0, 'error_text' => "No active package found. Please purchase a package to proceed."];
				echo json_encode($response);
				die;
			}

			$connect_status = $this->Contactrequest->find('all')
				->where(['from_id' => $user_id, 'to_id' => $current_user_id])
				->orWhere(['from_id' => $current_user_id, 'to_id' => $user_id])
				->first();

			// pr($connect_status);exit;

			if ($action == 'cancel' || $action == 'remove') {
				$connect = $this->Contactrequest->get($connect_status['id']);
				$this->updatePackageOnRejection($packfeature);
				$this->Contactrequest->delete($connect);
				$this->updateNotificationCount($user_id, -1);
				$response = ['status' => 1, 'error_text' => "Friend request $action."];
				echo json_encode($response);
				die;
			}


			// pr($connect_status);exit;

			$activeToUserPackage = $this->Packfeature->find('all')
				->where(['user_id' => $user_id])
				->andWhere(['OR' => [
					['package_status' => 'PR', 'expire_date >=' => date('Y-m-d H:i:s')],
					['package_status' => 'default']
				]])
				->order(['id' => 'DESC'])
				->first();

			$request_count_perday = $this->Contactrequest->find('all')
				->where(['Contactrequest.from_id' => $current_user_id, 'DATE(Contactrequest.created_date)' => date('Y-m-d')])
				->count();

			$number_of_introduction_limit = $packfeature['number_of_introduction'] ?? 0;
			$number_of_introduction_used = $packfeature['number_of_introduction_used'] ?? 0;
			$introduction_sent_limit = $packfeature['introduction_sent'] ?? 0;
			// pr($number_of_introduction_limit);
			// pr($number_of_introduction_used);
			// pr($request_count_perday);
			// pr($introduction_sent_limit);exit;
			// Handle existing connection statuses
			if ($connect_status) {
				$connect = $this->Contactrequest->get($connect_status['id']);

				switch ($action) {
					case 'confirm':
						$connect->accepted_status = 'Y';
						$this->Contactrequest->save($connect);
						break;
					case 'remove':
						$this->updatePackageOnRejection($packfeature);
						$this->Contactrequest->delete($connect);
						$this->updateNotificationCount($user_id, -1);
						break;

					default:
						$response = ['status' => 0, 'error_text' => 'You are already friend'];
				}
				echo json_encode($response);
				die;
			}

			$friendreq = $this->Contactrequest->find('all')->where(['to_id' => $user_id])->count();
			if ($activeToUserPackage['number_of_introduction_recived'] <= $friendreq) {
				$user_data = $this->Users->find('all')
					->select(['user_name'])
					->where(['id' => $user_id])
					->first();
				$response['status'] = 0;
				$response['error_text'] = $user_data['user_name'] . " cannot receive more connect request as the limit of pending request has been reached.";
				echo json_encode($response);
				die;
			}

			// Check for introduction limits
			if ($number_of_introduction_used >= $number_of_introduction_limit) {
				$response = ['status' => 0, 'error_text' => "You have reached the maximum limit of introductions send request."];
				echo json_encode($response);
				die;
			}


			if ($request_count_perday >= $introduction_sent_limit) {
				$response = ['status' => 0, 'error_text' => "You cannot send more requests today. Try again tomorrow."];
				echo json_encode($response);
				die;
			}

			// Add a new connection request
			$new_request = $this->Contactrequest->newEntity([
				'from_id' => $current_user_id,
				'to_id' => $user_id
			]);
			$this->Contactrequest->save($new_request);

			// Update package usage
			$packfeature->number_of_introduction_used += 1;
			$packfeature->intorducation_send_date = date('Y-m-d');
			$this->Packfeature->save($packfeature);

			// Update notification count for the recipient
			$this->updateNotificationCount($user_id, 1);

			$response = ['status' => 1, 'error_text' => "Connect Request Sent Successfully"];
			echo json_encode($response);
			die;
		}
	}

	// Helper function to update package limits
	private function updatePackageOnRejection($packfeature)
	{
		if ($packfeature) {
			$packfeature->number_of_introduction_used -= 1;
			$this->Packfeature->save($packfeature);
		}
	}

	// Helper function to update notification count
	private function updateNotificationCount($user_id, $delta)
	{
		$user = $this->Users->find('all')->where(['id' => $user_id])->first();
		if ($user) {
			$user->con_req_noti_count = max(0, $user->con_req_noti_count + $delta);
			$this->Users->save($user);
		}
	}

	public function videosonline($id)
	{

		$this->loadModel('Video');
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$videos = $this->Video->find('all')->where(['Video.id' => $id])->contain(['Users'])->toarray();

		$this->set('videos', $videos);
		$content_type = 'video';
		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
		$this->set('totallikes', $totallikes);

		$user_det_id = $this->request->session()->read('Auth.User.id');
		$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id, 'Likes.user_id' => $user_det_id])->count();
		$this->set('totaluserlikes', $totaluserlikes);
	}

	public function audiosonline($id)
	{
		$this->loadModel('Audio');
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$audioes = $this->Audio->find('all')->where(['Audio.id' => $id])->contain(['Users'])->toarray();
		$this->set('audioes', $audioes);
		$content_type = 'audio';
		$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
		$this->set('totallikes', $totallikes);
		$user_det_id = $this->request->session()->read('Auth.User.id');
		$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id, 'Likes.user_id' => $user_det_id])->count();
		$this->set('totaluserlikes', $totaluserlikes);
	}




	// Showing Plans for making profile as featured profiles. 
	public function featureprofile()
	{ //echo "test"; die;
		$this->loadModel('Featuredprofile');
		$currentdate = date('Y-m-d H:m:s');
		$current_user_id = $this->request->session()->read('Auth.User.id');
		$featured_expiry = $this->request->session()->read('Auth.User.featured_expiry');
		$expirdate = date('M d,Y', strtotime($featured_expiry));

		// pr($featured_expiry);exit;
		if ($currentdate > date('Y-m-d H:m:s', strtotime($featured_expiry))) {
			// pr('if');exit;
			$featuredprofile = $this->Featuredprofile->find('all')->where(['Featuredprofile.status' => 'Y'])->order(['Featuredprofile.priorites' => 'ASC'])->toarray();
			$this->set('featuredprofile', $featuredprofile);
			$this->set('profile_id', $current_user_id);
		} else {
			// pr('else');exit;
			// $this->Flash->error(__('Your Profile is Already Featured Till ' . $expirdate));
			$this->loadModel('Featuredprofile');
			$this->loadModel('Users');
			$session = $this->request->session();
			$session->delete('featureprosearchs');
			$myfeaturedprofile = $this->Users->find('all')->contain(['Featuredprofile'])->where(['Users.id' => $current_user_id, 'DATE(Users.featured_expiry) >=' => $currentdate, 'Users.status' => 'Y'])->first();
			// pr($myfeaturedprofile);exit;

			$this->set('myfeaturedprofile', $myfeaturedprofile);
		}
		// pr('>>>>>>');exit;
	}



	public function checklike()
	{
		$this->loadModel('Users');
		$this->loadModel('Likes');
		$error = '';
		if ($this->request->is(['post', 'put'])) {
			$id = $this->request->session()->read('Auth.User.id');
			$user_id = $this->request->data['user_id'];
			if ($id != $user_id) {
				$error = '1';
			} else {
				$content_type = 'image';
				$likedata['content_id'] = $this->request->data['content_id'];
				$likedata['user_id'] = $id;
				$likedata['content_type'] = $content_type;


				$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
				$this->set('totallikes', $totallikes);

				$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $this->request->data['content_id'], 'Likes.user_id' => $id])->count();
				if ($totaluserlikes > 0) {
					$this->Likes->deleteAll(['Likes.content_type' => $content_type, 'Likes.content_id' => $this->request->data['content_id'], 'Likes.user_id' => $id]);
					$status = 'dislike';
					$this->addactivity($userid, 'unlike_image', $this->request->data['content_id']);
				} else {
					$proff = $this->Likes->newEntity();
					$likes = $this->Likes->patchEntity($proff, $likedata);
					$savelike = $this->Likes->save($likes);
					$status = 'like';
					$this->addactivity($userid, 'like_image', $savelike['content_id']);

					//send like notification
					$this->loadModel('Notification');
					$senderid = $this->request->session()->read('Auth.User.id');
					$recieverid = $this->request->data['reciveid'];
					$noti = $this->Notification->newEntity();
					$notification['notification_sender'] = $senderid;
					$notification['notification_receiver'] = $recieverid;
					$notification['type'] = "photo like";
					$notification['content'] = $this->request->data['imagename'];
					$notification = $this->Notification->patchEntity($noti, $notification);
					$this->Notification->save($notification);
				}
				$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $this->request->data['content_id']])->count();
			}
			$response['error'] = $error;
			$response['status'] = $status;
			$response['count'] = $totallikes;
			echo json_encode($response);
			die;
		}
	}

	/*
	public function checklike()
		{			
			$this->loadModel('Galleryimagelike');
			$user_id=$this->Auth->user('id');
			$count = $this->Galleryimagelike->find('all')->select(["image_like"])->where(['image_gallery_id'=>$this->request->data['id'],'user_id'=>$user_id])->count();
			if($count==0){
				$new = $this->Galleryimagelike->newEntity();
				$fn['image_gallery_id']=$this->request->data['id'];
				$fn['user_id']=$this->Auth->user('id');
				$fn['caption']="";
				if($this->request->data['title']=='Like'){
				$fn['image_like']=1;
				}else{
				$fn['image_like']=0;
				}
				$connection_data = $this->Galleryimagelike->patchEntity($new, $fn);
				$savedata = $this->Galleryimagelike->save($connection_data);
			
			}else{
				if($this->request->data['title']=='Like'){
					$value="1";
				}else{
					$value="0";
				}				
				$tablename = TableRegistry::get("Galleryimagelike");
				$query = $tablename->query();
				$result = $query->update()->set(['image_like' => $value])->where(['image_gallery_id' => $this->request->data['id'],'user_id'=>$user_id])->execute();
			}	
			
			$qb = $this->Galleryimagelike->find('all')->select(["image_like"])->where(['image_gallery_id'=>$this->request->data['id'],'user_id'=>$user_id])->first();
			$tcount = $this->Galleryimagelike->find('all')->where(['image_gallery_id'=>$this->request->data['id'],'image_like'=>1])->count();
            echo $qb['image_like']."/".$tcount;
            
			die;
			
		}
		*/
	public function checkcaption()
	{
		$this->loadModel('Galleryimage');
		$this->loadModel('Galleryimagelike');
		$user_id = $this->Auth->user('id');
		$find = $this->Galleryimagelike->find('all')
			->where([
				'image_gallery_id' => $this->request->data['id'],
				'user_id' => $user_id
			])
			->first();

		// pr($count);
		// exit;
		if (count($find) == 0) {
			$new = $this->Galleryimagelike->newEntity();
			$fn['image_gallery_id'] = $this->request->data['id'];
			$fn['user_id'] = $user_id;
			$fn['image_like'] = "";
			$fn['caption'] = $this->request->data['cap'];
			$connection_data = $this->Galleryimagelike->patchEntity($new, $fn);
			$savedata = $this->Galleryimagelike->save($connection_data);
		} else {
			$tablename = TableRegistry::get("Galleryimagelike");
			$query = $tablename->query();
			$result = $query->update()->set(['caption' => $this->request->data['cap']])->where(['image_gallery_id' => $this->request->data['id'], 'user_id' => $user_id])->execute();
		}

		$galleryImages = $this->Galleryimage->find('all')->where(['Galleryimage.id' => $find['image_gallery_id']])->first();
		// if find then update caption fields to $this->request->data['cap'] 
		if ($galleryImages) {
			$galleryImages->caption = $this->request->data['cap'];
			$this->Galleryimage->save($galleryImages);
		}
		// pr($galleryImages);
		// exit;

		$qb = $this->Galleryimagelike->find('all')->select(["caption"])->where(['image_gallery_id' => $this->request->data['id'], 'user_id' => $user_id])->first();
		echo $qb['caption'];
		die;
	}

	/*		public function checkvideolike()
		{
			
			$this->loadModel('Videolike');
			$user_id=$this->Auth->user('id');
			$count = $this->Videolike->find('all')->select(['video_like'])->where(['video_id'=>$this->request->data['id'],'user_id'=>$user_id])->count();
			if($count==0){
				$new = $this->Videolike->newEntity();
				$fn['video_id']=$this->request->data['id'];
				$fn['user_id']=$this->Auth->user('id');
				$fn['caption']="";
				if($this->request->data['title']=='Like'){
				$fn['video_like']=1;
				}else{
				$fn['video_like']=0;
				}
				$connection_data = $this->Videolike->patchEntity($new, $fn);
				$savedata = $this->Videolike->save($connection_data);
			
			}else{
				if($this->request->data['title']=='Like'){
					$value="1";
				}else{
					$value="0";
				}				
				$tablename = TableRegistry::get("Videolike");
				$query = $tablename->query();
				$result = $query->update()->set(['video_like' => $value])->where(['video_id' => $this->request->data['id'],'user_id'=>$user_id])->execute();
			}	
			
			$qb = $this->Videolike->find('all')->select(["video_like"])->where(['video_id'=>$this->request->data['id'],'user_id'=>$user_id])->first();
			$tcount = $this->Audiolike->find('all')->where(['video_id'=>$this->request->data['id'],'video_like'=>1])->count();
            echo $qb['video_like']."/".$tcount; 
			die;
			
		} */


	public function checkvideolike()
	{

		$this->loadModel('Users');
		$this->loadModel('Likes');
		$error = '';
		if ($this->request->is(['post', 'put'])) {
			$id = $this->request->session()->read('Auth.User.id');
			$user_id = $this->request->data['user_id'];
			if ($id != $user_id) {
				$error = '1';
			} else {
				$content_type = 'video';
				$likedata['content_id'] = $this->request->data['content_id'];
				$likedata['user_id'] = $id;
				$likedata['content_type'] = $content_type;

				$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
				$this->set('totallikes', $totallikes);

				$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $this->request->data['content_id'], 'Likes.user_id' => $id])->count();
				if ($totaluserlikes > 0) {
					$this->Likes->deleteAll(['Likes.content_type' => $content_type, 'Likes.content_id' => $this->request->data['content_id'], 'Likes.user_id' => $id]);
					$status = 'dislike';
					$this->addactivity($userid, 'unlike_video', $this->request->data['content_id']);
				} else {
					$proff = $this->Likes->newEntity();
					$likes = $this->Likes->patchEntity($proff, $likedata);
					$savelike = $this->Likes->save($likes);
					$status = 'like';
					$this->addactivity($userid, 'like_video', $savelike['content_id']);

					//send like notification
					$this->loadModel('Notification');
					$senderid = $this->request->session()->read('Auth.User.id');
					$recieverid = $this->request->data['reciveid'];
					$noti = $this->Notification->newEntity();
					$notification['notification_sender'] = $senderid;
					$notification['notification_receiver'] = $recieverid;
					$notification['type'] = "video like";
					$notification['content'] = $this->request->data['video'];
					$notification = $this->Notification->patchEntity($noti, $notification);
					$this->Notification->save($notification);
				}
				$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $this->request->data['content_id']])->count();
			}
			$response['error'] = $error;
			$response['status'] = $status;
			$response['count'] = $totallikes;
			echo json_encode($response);
			die;
		}
	}

	public function checkvideocaption()
	{

		$this->loadModel('Video');

		$this->loadModel('Videolike');
		$user_id = $this->Auth->user('id');
		$tablename = TableRegistry::get("Video");
		$query = $tablename->query();
		$result = $query->update()->set(['caption' => $this->request->data['cap']])->where(['id' => $this->request->data['id'], 'user_id' => $user_id])->execute();

		$qb = $this->Video->find('all')->select(["caption"])->where(['id' => $this->request->data['id'], 'user_id' => $user_id])->first();
		echo $qb['caption'];
		die;
	}

	public function likedusers($id)
	{
		$this->loadModel('Likes');
		$this->loadModel('Users');
		$content_type = 'image';
		$findall = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->toarray();
		$this->set('findall', $findall);
	}


	public function videolikedusers($id)
	{
		$this->loadModel('Likes');
		$this->loadModel('Users');
		$content_type = 'video';
		$findall = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->toarray();
		$this->set('findall', $findall);
	}

	public function audiolikedusers($id)
	{


		$this->loadModel('Likes');
		$this->loadModel('Users');
		$content_type = 'audio';
		$findall = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->toarray();
		$this->set('findall', $findall);
	}


	public function checkaudiocaption()
	{
		$this->loadModel('Audio');
		$user_id = $this->Auth->user('id');
		$tablename = TableRegistry::get("Audio");
		$query = $tablename->query();
		$result = $query->update()->set(['caption' => $this->request->data['cap']])->where(['id' => $this->request->data['id'], 'user_id' => $user_id])->execute();

		$qb = $this->Audio->find('all')->select(["caption"])->where(['id' => $this->request->data['id'], 'user_id' => $user_id])->first();
		echo $qb['caption'];
		die;
	}

	public function checkaudiolike()
	{

		/*	$this->loadModel('Audiolike');
			$user_id=$this->Auth->user('id');
			$count = $this->Audiolike->find('all')->select(['audio_like'])->where(['audio_id'=>$this->request->data['id'],'user_id'=>$user_id])->count();
			if($count==0){
				$new = $this->Audiolike->newEntity();
				$fn['audio_id']=$this->request->data['id'];
				$fn['user_id']=$user_id;
				$fn['caption']="";
				if($this->request->data['title']=='Like'){
				$fn['audio_like']=1;
				}else{
				$fn['audio_like']=0;
				}
				$connection_data = $this->Audiolike->patchEntity($new, $fn);
				$savedata = $this->Audiolike->save($connection_data);
			
			}else{
				if($this->request->data['title']=='Like'){
					$value="1";
				}else{
					$value="0";
				}				
				$tablename = TableRegistry::get("Audiolike");
				$query = $tablename->query();
				$result = $query->update()->set(['audio_like' => $value])->where(['audio_id' => $this->request->data['id'],'user_id'=>$user_id])->execute();
			}	
			
			$qb = $this->Audiolike->find('all')->select(["audio_like"])->where(['audio_id'=>$this->request->data['id'],'user_id'=>$user_id])->first();
            $tcount = $this->Audiolike->find('all')->where(['audio_id'=>$this->request->data['id'],'audio_like'=>1])->count();
            echo $qb['audio_like']."/".$tcount;            
			die;
			*/

		$this->loadModel('Users');
		$this->loadModel('Likes');
		$error = '';
		if ($this->request->is(['post', 'put'])) {
			$id = $this->request->session()->read('Auth.User.id');
			$user_id = $this->request->data['user_id'];
			if ($id != $user_id) {
				$error = '1';
			} else {
				$content_type = 'audio';
				$likedata['content_id'] = $this->request->data['content_id'];
				$likedata['user_id'] = $id;
				$likedata['content_type'] = $content_type;


				$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $id])->count();
				$this->set('totallikes', $totallikes);

				$totaluserlikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $this->request->data['content_id'], 'Likes.user_id' => $id])->count();
				if ($totaluserlikes > 0) {
					$this->Likes->deleteAll(['Likes.content_type' => $content_type, 'Likes.content_id' => $this->request->data['content_id'], 'Likes.user_id' => $id]);
					$status = 'dislike';
					$this->addactivity($userid, 'unlike_audio', $this->request->data['content_id']);
				} else {
					$proff = $this->Likes->newEntity();
					$likes = $this->Likes->patchEntity($proff, $likedata);
					$savelike = $this->Likes->save($likes);
					$status = 'like';
					$this->addactivity($userid, 'like_audio', $savelike['content_id']);

					//send like notification
					$this->loadModel('Notification');
					$senderid = $this->request->session()->read('Auth.User.id');
					$recieverid = $this->request->data['reciveid'];
					$noti = $this->Notification->newEntity();
					$notification['notification_sender'] = $senderid;
					$notification['notification_receiver'] = $recieverid;
					$notification['type'] = "audio like";
					$notification['content'] = $this->request->data['audio'];
					$notification = $this->Notification->patchEntity($noti, $notification);
					$this->Notification->save($notification);
				}
				$totallikes = $this->Likes->find('all')->where(['Likes.content_type' => $content_type, 'Likes.content_id' => $this->request->data['content_id']])->count();
			}
			$response['error'] = $error;
			$response['status'] = $status;
			$response['count'] = $totallikes;
			echo json_encode($response);
			die;
		}
	}

	// 		public function sharenotification(){
	// 		    $this->loadModel('Notification');
	// 		    $senderid = $this->request->session()->read('Auth.User.id');
	// 		    $recieverid = $this->request->data['user_id'];
	// 		    $noti = $this->Notification->newEntity();
	// 		    if ($this->request->is(['post', 'put']))
	//     		{ 
	//     			$notification['notification_sender'] = $senderid;
	//     			$notification['notification_receiver'] = $recieverid;
	//     			$notification['type'] = $this->request->data['sharetype'];
	//     			if($this->request->data['sharetype'] == "share photo"){
	//     			    $notification['image'] = $this->request->data['image'];
	//     			}elseif($this->request->data['sharetype'] == "share audio"){
	//     			    $notification['audio_link'] = $this->request->data['audio'];
	//     			}elseif($this->request->data['sharetype'] == "share video"){
	//     			    $notification['video_link'] = $this->request->data['video'];
	//     			}

	//     			$notification = $this->Notification->patchEntity($noti, $notification);
	//     			$this->Notification->save($notification);
	//     		}
	//     		die;
	// 		}

	public function earlierfeaturedprofile()
	{
		$this->loadModel('Profilefeatured');
		$this->loadModel('Users');
		$currentdate = date('Y-m-d H:m:s');
		$user_id = $this->request->session()->read('Auth.User.id');
		$fprofile = $this->Profilefeatured->find('all')->contain(['Users'])->where(['DATE(Profilefeatured.expirydate) <=' => $currentdate, 'Profilefeatured.user_id' => $user_id])->order(['Profilefeatured.id' => 'DESC'])->toarray();
		$this->set('fprofile', $fprofile);
	}

	public function status($id, $status)
	{
		//	echo "test"; die;
		$this->loadModel('Users');
		$Pack = $this->Users->get($id);
		$Pack->feature_pro_status = $status;
		if ($this->Users->save($Pack)) {
			if ($status == 'Y') {
				$this->Flash->success(__('The Profile featured status has been activated.'));
			} else {
				$this->Flash->success(__('The Profile featured status has been deactivated.'));
			}

			$this->redirect(Router::url($this->referer(), true));
		}
	}
}
