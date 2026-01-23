<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;


class DashboardsController extends AppController
{
	//$this->loadcomponent('Session');
	public function initialize(){	
		//load all models
		parent::initialize();
	}
	public function index(){ 
		$this->loadModel('Users');
		$this->loadModel('Requirement');
		$this->loadModel('Country');
		$this->loadModel('State');
		$this->loadModel('City');
		// All dashboard data like counts and admin user name	
	 	$this->viewBuilder()->layout('admin');
		$user_id =  $this->Auth->user('id');    
		$user_data = $this->Users->get($user_id);
   		$admin_url =	configure::read('ADMIN_URL');
		$user_name = $user_data['user_name'];
		// Total Talents
		$total_talents = $this->Users->find('all')->contain(['Skillset'])->where(['Users.role_id'=>TALANT_ROLEID,'Users.user_delete' =>'N'])->order(['Users.id' => 'DESC'])->count();
		// Total Non Talents
		$total_nontalents = $this->Users->find('all')->contain(['Profile'])->where(['Users.role_id'=>NONTALANT_ROLEID,'Users.user_delete' =>'N'])->order(['Users.id' => 'DESC'])->count();
		// Total Jobs
		$total_jobs = $this->Requirement->find('all')->where(['Requirement.jobdelete_status'=>'N'])->order(['Requirement.id' => 'DESC'])->count(); 
		// Total Visitors 
		$total_payments = 0;

		// Latest Members
		// $latest_members = $this->Users->find('all')->contain(['Profile'])->where(['Users.role_id'=>NONTALANT_ROLEID])->orWhere(['Users.role_id'=>TALANT_ROLEID])->order(['Users.id' => 'DESC'])->limit(8)->toarray();
		$latest_members = $this->Users->find('all')->contain(['Profile'])->where(['Users.role_id'=>NONTALANT_ROLEID,'Users.user_delete' =>'N'])->orWhere(['Users.role_id'=>TALANT_ROLEID,'Users.user_delete' =>'N'])->order(['Users.id' => 'DESC'])->limit(8)->toarray();
		
		$latest_jobs = $this->Requirement->find('all')->contain(['Country'])->contain(['State'])->contain(['City'])->order(['Requirement.id' => 'DESC'])->limit(8)->toarray(); 

		$this->set(compact('admin_url','user_name','total_talents','total_nontalents','total_jobs','total_payments','latest_members','latest_jobs'));
	}
}
