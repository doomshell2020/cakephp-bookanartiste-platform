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
class ContentadminController extends AppController
{
	
	public function initialize()
	{ 
        parent::initialize();
       	$this->loadModel('Users');
    }
 
    public function beforeFilter(Event $event)
    {
		parent::beforeFilter($event);
		$this->Auth->allow();
    }
	
	// Block users
	public function blockedusers()
	{
		$this->loadModel('Users');
		$blockedusers = $this->Users->find('all')->contain(['Profile'])->where(['Users.blocked_expiry >'=>0])->order(['Users.id' => 'DESC'])->toarray();
		$this->set(compact('blockedusers'));
	}
	
	// Ignore blocking
	public function ignoreblocking($id=null)
	{
		$this->loadModel('Users');
		$blockedusers = $this->Users->find('all')->contain(['Profile'])->where(['Users.blocked_expiry >'=>0])->order(['Users.id' => 'DESC'])->toarray();
		$this->set(compact('blockedusers'));
	}
	
	// Block users
	public function approveblocking($id=null)
	{
		// Approve Users for blocking
		$this->loadModel('Users');		 
		$users = $this->Users->get($id);
		$user_data['blocked_expiry'] = '0000-00-00 00:00:00';
		$users = $this->Users->patchEntity($users, $user_data);
		$updateuser = $this->Users->save($users);
		
		// Delete all reports for the users.
		$this->loadModel('Report'); 
		$this->Report->deleteAll(['Report.profile_id' => $id,'Report.type'=>'profile']);
		$this->Flash->success(__('Blocked user has been approved successfully.!!'));
		return $this->redirect(['action' => 'blockedusers']);
	}
	
	// Block users
	public function removebprofile($id=null)
	{
		// Deleting Users
		$this->loadModel('Users');
		$this->Users->deleteAll(['Users.id' => $id]);
		
		// Deleting Profile
		$this->loadModel('Profile');
		$this->Profile->deleteAll(['Profile.user_id' => $id]);
		
		// Deleting Gallery Image
		$this->loadModel('Galleryimage');
		$this->Galleryimage->deleteAll(['Galleryimage.profile_id' => $id]);
		
		// Deleting Contact Request
		$this->loadModel('Contactrequest');
		$this->Contactrequest->deleteAll(['Contactrequest.to_id' => $id]);
		$this->Contactrequest->deleteAll(['Contactrequest.from_id' => $id]);
		
		// Deleting Likes
		$this->loadModel('Likes');
		$this->Likes->deleteAll(['Likes.user_id' => $id]);
		$this->Likes->deleteAll(['Likes.content_id' => $id,'Likes.content_type' => 'profile']);
		
		// Deleting Users
		$this->loadModel('Activities');
		$this->Activities->deleteAll(['Activities.user_id' => $id]);
		
		// Deleting Users
		$this->loadModel('Blocks');
		$this->Blocks->deleteAll(['Blocks.user_id' => $id]);
		//$this->Report->deleteAll(['Blocks.content_id' => $id]);
		
		// Deleting Users
		$this->loadModel('Professinal_info');
		$this->Professinal_info->deleteAll(['Users.profile_id' => $id]);
		
		// Deleting Users
		$this->loadModel('Performance_desc');
		$this->Performance_desc->deleteAll(['Performance_desc.profile_id' => $id]);
		
		// Deleting Users
		$this->loadModel('Uservital');
		$this->Uservital->deleteAll(['Uservital.profile_id' => $id]);
		
		// Deleting Users
		$this->loadModel('Video');
		$this->Video->deleteAll(['Video.profile_id' => $id]);
		
		// Deleting Users
		$this->loadModel('Audio');
		$this->Audio->deleteAll(['Audio.profile_id' => $id]);
		
		
	}
	
	// Edit users
	public function editbprofile($id=null)
	{
		$this->loadModel('Users');
		$blockedusers = $this->Users->find('all')->contain(['Profile'])->where(['Users.blocked_expiry >'=>0])->order(['Users.id' => 'DESC'])->toarray();
		$this->set(compact('blockedusers'));
	}
	
	
    
	



}