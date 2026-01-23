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
    public function initialize(){
    parent::initialize();
	$this->Auth->allow(['privacy','termsandconditions']);
    }
    
    public function sendmessage($userid='')
    {
	$id = $this->request->session()->read('Auth.User.id');
	if ($this->request->is(['post', 'put']))
	{
	    $this->loadModel('Messages');
	    $mentity = $this->Messages->newEntity();
	    $userid = $this->request->data['userid'];
	    $subject = $this->request->data['subject'];
	    $description = $this->request->data['message'];
	    $message_data['from_id'] = $id;
	    $message_data['to_id'] = $userid;
	    $message_data['subject'] = $subject;
	    $message_data['description'] = $description;
	    $message_data['to_box'] = 'I';
	    $message_data['from_box'] = 'S';
	    $message_arr = $this->Messages->patchEntity($mentity, $message_data);
	    $savedata = $this->Messages->save($message_arr);
	    $response['status'] = "1";
	    $response['error_text'] = "";
	    echo json_encode($response); die;
	    
	}
	else
	{
	    if($userid==0)
	    {
		$this->set('error', "You cannot send message to yourself");
	    }
	    $this->set('userid', $userid);
	}
    }
    
    public function messagesnoti()
    {
	$this->loadModel('Messages');
	$this->loadModel('Users');
	$this->loadModel('Profile');

	$uid = $this->request->session()->read('Auth.User.id');
	$notifications = $this->Messages->find('all')->contain(['Users'=>['Profile']])->where(['to_id' => $uid])->where(['to_viewed_status' => 'N'])->toarray();
	//pr($notifications);
	$this->set('messages',$notifications);
	
	$users= TableRegistry::get('Messages');
	$status="Y";
	$con = ConnectionManager::get('default');
	$detail = 'UPDATE `messages` SET `to_viewed_status` ="'.$status.'" WHERE `messages`.`to_id` = '. $uid;
	$results = $con->execute($detail);
    }
    
    // Inbox
    public function inbox($type)
    {
	$uid = $this->request->session()->read('Auth.User.id');
	if($type=='r')
	{
	    $condition['read_status'] = 'Y';
	}
	elseif($type=='u')
	{
	    $condition['read_status'] = 'N';
	}
	
	$condition['to_id'] = $uid;
	$condition['to_box'] = 'I';
	
	$this->loadModel('Messages');
	$this->loadModel('Users');
	$this->loadModel('Profile');
	$messages = $this->Messages->find('all')->contain(['Users'=>['Profile']])->where($condition)->toarray();
	$this->set('messages',$messages);
    }
    
    
     // Draft
    public function draft()
    {
	$this->loadModel('Messages');
	$this->loadModel('Users');
	$this->loadModel('Profile');
	$uid = $this->request->session()->read('Auth.User.id');
	$messages = $this->Messages->find('all')->contain(['Users'=>['Profile']])->where(['from_id' => $uid,'from_box'=>'D'])->toarray();
	$this->set('messages',$messages);
    }
    
    // Sendbox
    public function sentbox()
    {
	$this->loadModel('Messages');
	$this->loadModel('Users');
	$this->loadModel('Profile');
	$uid = $this->request->session()->read('Auth.User.id');
	$messages = $this->Messages->find('all')->contain(['Users'=>['Profile']])->where(['from_id' => $uid,'from_box'=>'S'])->toarray();
	$this->set('messages',$messages);
    }
    
    public function compose($id=null)
    {
	$id = $this->request->session()->read('Auth.User.id');
	if ($this->request->is(['post', 'put']))
	{
	    $this->loadModel('Messages');
	    $message_id = $this->request->data['message_id'];
	    $to_id = $this->request->data['to_id'];
	    $subject = $this->request->data['subject'];
	    $description = $this->request->data['description'];
	    if($message_id > 0)
	    {
		$mentity = $this->Messages->get($message_id);
	    }else
	    {
		$mentity = $this->Messages->newEntity();
	    }
	    $message_data['from_id'] = $id;
	    $message_data['to_id'] = $to_id;
	    $message_data['subject'] = $subject;
	    $message_data['description'] = $description;
	    $message_data['to_box'] = 'I';
	    $message_data['from_box'] = 'S';
	    $message_arr = $this->Messages->patchEntity($mentity, $message_data);
	    $savedata = $this->Messages->save($message_arr);
	    $message_id = $savedata->id;
	    $this->Flash->success(__('Message has been sent successfully'));
	    return $this->redirect(['action' => 'sentbox']);
	}
	if($id > 0)
	{
	    $this->loadModel('Messages');
	    //$messages = $this->Messages->get($id);
	    $messages = $this->Messages->find('all')->contain(['Users'=>['Profile']])->where(['Messages.id' => $id])->first();
	    //pr($messages); die;
	    $this->set('messages',$messages);   
	}
    }
    
    // View Message
    public function view($id=null)
    {
	if($id > 0)
	{
	    $where = " where messages.id='".$id."'";
	    $conn = ConnectionManager::get('default');
	    $message_qry = " SELECT messages.*, tu.user_name as to_name, tu.email as to_email, fu.user_name as from_name, fu.email as from_email from messages LEFT JOIN users tu on tu.id=messages.to_id left join users fu on fu.id=messages.from_id ".$where;
	    $message_qe = $conn->execute($message_qry);
	    $messages = $message_qe ->fetchAll('assoc');
	    $this->set('messages',$messages);   
	}
    }
    
    // Delete Messages 
    public function deletetemp()
    {
	$this->loadModel('Messages');
	$error = '';
	if ($this->request->is(['post', 'put']))
	{
	    $id = $this->request->session()->read('Auth.User.id');
	    $message_id = $this->request->data['message_id'];
	    $type = $this->request->data['type'];
	    $message = $this->Messages->get($message_id);
	    if($type=='draft')
	    {
		$this->Messages->delete($message);
		$status='1';
	    }
	    else
	    {
		if($type=='inbox')
		{
		    $message_data['to_box'] = 'T';
		}
		elseif($type=='trash')
		{
		    if($message['from_id']==$id)
		    {
			$message_data['from_box'] = 'P';
		    }
		    else
		    {
			$message_data['to_box'] = 'P';
		    }
		}
		else
		{
		    $message_data['from_box'] = 'T';
		}
		$messages = $this->Messages->patchEntity($message, $message_data);
		if($this->Messages->save($messages))
		{
		    $status='1';
		}
		else
		{
		    $status='0';
		}
	    }
	    $response['error']= $error;
	    $response['status']=$status;
	    echo json_encode($response); die;
	}
    }
    
    // Deleted Items 
    function trash()
    {
	$this->loadModel('Messages');
	$this->loadModel('Users');
	$this->loadModel('Profile');
	$uid = $this->request->session()->read('Auth.User.id');
	$messages = $this->Messages->find('all')->contain(['Users'=>['Profile']])->where(['from_id' => $uid,'from_box'=>'T'])->orWhere(['to_id' => $uid,'to_box'=>'T'])->toarray();
	$this->set('messages',$messages);   
    }
    
    // Fetch contacts for autocomplete
    function fetchcontacts()
    {
	$uid = $this->request->session()->read('Auth.User.id');
	$this->loadModel('Users');
	$keyword = $this->request->data['keyword'];
	$users = $this->Users->find('all')->where(['Users.user_name LIKE ' => $keyword.'%','Users.role_id'=>TALANT_ROLEID,'Users.id NOT IN'=>$uid])->limit(10)->toarray();
	$this->set('users',$users);  
    }
    
    // Saving message to draft
    function savetodraft()
    {
	$id = $this->request->session()->read('Auth.User.id');
	if ($this->request->is(['post', 'put']))
	{
	    $this->loadModel('Messages');
	    $message_id = $this->request->data['message_id'];
	    $to_id = $this->request->data['to_id'];
	    $subject = $this->request->data['subject'];
	    $description = $this->request->data['description'];
	    if($message_id > 0)
	    {
		$mentity = $this->Messages->get($message_id);
	    }else
	    {
		$mentity = $this->Messages->newEntity();
	    }
	    $message_data['from_id'] = $id;
	    $message_data['to_id'] = $to_id;
	    $message_data['subject'] = $subject;
	    $message_data['description'] = $description;
	    //$message_data['to_box'] = 'I';
	    $message_data['from_box'] = 'D';
	    $message_arr = $this->Messages->patchEntity($mentity, $message_data);
	    $savedata = $this->Messages->save($message_arr);
	    $message_id = $savedata->id;
	    $response['status'] = "1";
	    $response['error_text'] = "";
	    $response['message_id'] = $message_id;
	    echo json_encode($response); die;
	}
    }
    
    public function createfolder($id=null)
    {
	$id = $this->request->session()->read('Auth.User.id');
	if ($this->request->is(['post', 'put']))
	{
	    $this->loadModel('Messages');
	    $message_id = $this->request->data['message_id'];
	    $to_id = $this->request->data['to_id'];
	    $subject = $this->request->data['subject'];
	    $description = $this->request->data['description'];
	    if($message_id > 0)
	    {
		$mentity = $this->Messages->get($message_id);
	    }else
	    {
		$mentity = $this->Messages->newEntity();
	    }
	    $message_data['from_id'] = $id;
	    $message_data['to_id'] = $to_id;
	    $message_data['subject'] = $subject;
	    $message_data['description'] = $description;
	    $message_data['to_box'] = 'I';
	    $message_data['from_box'] = 'S';
	    $message_arr = $this->Messages->patchEntity($mentity, $message_data);
	    $savedata = $this->Messages->save($message_arr);
	    $message_id = $savedata->id;
	    $this->Flash->success(__('Message has been sent successfully'));
	    return $this->redirect(['action' => 'sentbox']);
	}
	if($id > 0)
	{
	    $this->loadModel('Messages');
	    //$messages = $this->Messages->get($id);
	    $messages = $this->Messages->find('all')->contain(['Users'=>['Profile']])->where(['Messages.id' => $id])->first();
	    //pr($messages); die;
	    $this->set('messages',$messages);   
	}
    }
    
    
    
    





}