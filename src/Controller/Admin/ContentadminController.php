<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
class ContentadminController extends AppController
{       
    public function initialize(){	
    parent::initialize();
    }
    // function used for password string  change:

    public  function _setPassword($password) 
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
    
	// For content admin Index

	public function index(){ 
		$this->loadModel('Users');
		$this->viewBuilder()->layout('admin');
		$contentadmin = $this->Users->find('all')->contain(['Skillset'])->where(['Users.is_content_admin'=>'Y'])->order(['Users.id' => 'DESC'])->toarray();
		$this->set(compact('contentadmin'));
	}

      // For content admin add   
    public function add($id=null)
    {   
            $this->loadModel('Country');
            $this->loadModel('Users');
            $this->loadModel('Skillset');
            $this->viewBuilder()->layout('admin');
            if(isset($id) && !empty($id)){
            $users = $this->Users->get($id);

            $contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id'=>$id])->order(['Skillset.id' => 'DESC'])->toarray();

            $this->set('skillofcontaint', $contentadminskillset);


            }else{

            $users = $this->Users->newEntity();
            }

            $country = $this->Country->find('list')->select(['id','name'])->toarray();
            $this->set('country', $country);
            if ($this->request->is(['post', 'put'])){
                
            $skillcount=explode(",",$this->request->data['skill']);
            if(!empty($this->request->data['passedit'])){
            $this->request->data['password']= $this->_setPassword($this->request->data['passedit']);
            }else if(!empty($this->request->data['password']))
            {
            $this->request->data['password']= $this->_setPassword($this->request->data['password']);
            }else{

            }


            $this->request->data['role_id']= CONTENT_ADMIN;

            try { 
            $contentadmin = $this->Users->patchEntity($users, $this->request->data);
            $savedata=$this->Users->save($contentadmin);
            if ($savedata){
            $lasid = $savedata->id;
            $this->Skillset->deleteAll(['Skillset.user_id'=>$id]);
            for($i=0;$i<count($skillcount);$i++){

            $contentadminskill = $this->Skillset->newEntity();
            $this->request->data['user_id']=$lasid;
            $this->request->data['skill_id']=$skillcount[$i];
            $contentadminskillsave = $this->Skillset->patchEntity($contentadminskill, $this->request->data);
            $this->Skillset->save($contentadminskillsave);
            }  

            $this->Flash->success(__('Your  content Admin has been saved.'));
            return $this->redirect(['action' => 'index']);
            }
            }
            catch (\PDOException $e) {

            $this->Flash->error(__('User Name Already Exits'));
            $this->set('error', $error);
            return $this->redirect(['action' => 'add']);
            }

            }
            $this->set('packentity', $users);
            $this->set('skillofcontaint', $contentadminskillset);
    }

// For content admin skills
    public function skills($id=null){

            $this->loadModel('Users');
            $this->loadModel('Skillset');
            $this->loadModel('Skill');
            if($id!=null){
            $contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id'=>$id])->order(['Skillset.id' => 'DESC'])->toarray();
            }
            $Skill = $this->Skill->find('all')->select(['id','name'])->where(['Skill.status'=>'Y'])->toarray();
            $this->set('Skill', $Skill);
            $this->set('skillset', $contentadminskillset);
      
    }
	
	// For content admin status
	public function status($id,$status){ 
		$this->loadModel('Users');
		if(isset($id) && !empty($id)){
			if($status =='N' ){
				$status = 'Y';
				$talent = $this->Users->get($id);
				$talent->status = $status;
				if ($this->Users->save($talent)) {
					$this->Flash->success(__('Talent status has been updated.'));
					return $this->redirect(['action' => 'index']);	
				}
			}else{
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

            // For content  Delete
	public function delete($id){
	
            $this->loadModel('Users');
            $talent = $this->Users->get($id);
            if ($this->Users->delete($talent)) {

            $this->Flash->success(__('The Users with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);

            }
          }
		  
		  
		  
    // Make user Talent admin
	public function makecontentadmin($id=null)
	{   
	    $this->loadModel('Users');
	    $this->loadModel('Country');
	    $this->loadModel('State');
	    $this->loadModel('City');
	    $this->loadModel('ContentAdmin');
	    $this->loadModel('Contentadminskill');
	    $this->loadModel('Skill');
	    $this->viewBuilder()->layout('admin');

	    $contentadminskillset = $this->Contentadminskill->find('all')->contain(['Skill'])->where(['Contentadminskill.user_id'=>$id])->toarray();
	    $this->set('skillofcontaint', $contentadminskillset);
	    if(isset($id) && !empty($id)){
		$users = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$talent = $this->ContentAdmin->newEntity();
	    }else{
		
	    }
	    $country = $this->Country->find('list')->select(['id', 'name'])->toarray();
	    $this->set('country', $country);
	    $cities = $this->City->find('list')->where(['City.state_id' => $users['talent_admin'][0]['state_id']])->toarray();
	    $this->set('cities', $cities);
	    $states = $this->State->find('list')->where(['State.country_id' =>$users['talent_admin'][0]['country_id']])->toarray();
	    $this->set('states', $states);

	    if ($this->request->is(['post', 'put'])){
		$usersdata['is_content_admin']= 'Y';
		try 
		{ 
		    $contentadmin = $this->Users->patchEntity($users, $usersdata);
		    $savedata=$this->Users->save($contentadmin);
		    if ($savedata)
		    {
			$last_user_id= $savedata->id;
			$prop_data=array();
			$prop_data['country_id']= $this->request->data['country_id'];
			$prop_data['state_id']= $this->request->data['state_id'];
			$prop_data['city_id']= $this->request->data['city_id'];	
			$prop_data['commision']= $this->request->data['commission'];
			$prop_data['user_id']= $last_user_id;	
			$prop_data['subadmincreate_id']= $this->request->data['subadmincreate_id'];
			$prop_data['referal_code']= md5(uniqid(rand(), true));
			$skillcheck	= $this->request->data['skill'];
			$skillcount=explode(",",$this->request->data['skill']);

			$contenttalent_admin = $this->ContentAdmin->patchEntity($talent, $prop_data);
			$savedata=$this->ContentAdmin->save($contenttalent_admin);
			if ($skillcheck)
			{
			    $prop_skills=array();
			    $this->Contentadminskill->deleteAll(['Contentadminskill.user_id'=>$id]);
			    for($i=0;$i<count($skillcount);$i++)
			    {
				$contentadminskill = $this->Contentadminskill->newEntity();
				$prop_skills['user_id']= $last_user_id;
				$prop_skills['skill_id']=$skillcount[$i];
				$contentadminskillsave = $this->Contentadminskill->patchEntity($contentadminskill, $prop_skills);
				$skilldata= $this->Contentadminskill->save($contentadminskillsave);
			    }  
			}
			$this->Flash->success(__('Your  content Admin has been saved.'));
			return $this->redirect(['action' => 'index']);
		    }
		}
		catch (\PDOException $e) {
		$this->Flash->error(__('User Name Already Exits'));
		$this->set('error', $error);
		return $this->redirect(['action' => 'add']);
		}
	    }
	    $this->set('packentity', $users);
	}
	
	public function removecontentadmin($id=null)
	{
	    $this->loadModel('Users');
	    $this->loadModel('ContentAdmin');
	    $this->loadModel('Contentadminskill');
	    if(isset($id) && !empty($id)){
		$users = $this->Users->find('all')->contain(['ContentAdmin','Contentadminskill'])->where(['Users.id' => $id])->first();
		$talent = $this->ContentAdmin->find('all')->where(['ContentAdmin.user_id' => $id])->first();
	    }
	    $this->ContentAdmin->delete($talent);
	    $usersdata['is_content_admin'] = "N";
	    $contentadmin = $this->Users->patchEntity($users, $usersdata);
	    $savedata=$this->Users->save($contentadmin);
	    $this->Contentadminskill->deleteAll(['Contentadminskill.user_id'=>$id]);
	    $this->Flash->success(__('Talent admin has been deleted successfully'));
	    return $this->redirect(['action' => 'index']);
	
	}

     
} 