<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\Datasource\ConnectionManager;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;

class TalentadminController extends AppController
{       

     public $paginate = [
        'limit' => 25,
        'order' => [
            'Bannerpack.id' => 'asc'
        ]
    ];
    public function initialize(){	
    parent::initialize();
    //$this->loadComponent('Paginator');
     
    }

      public  function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
    
	// For Job pack index
	public function index(){ 
	    $this->loadModel('Users');
	    $this->loadModel('TalentAdmin');
	    $this->loadModel('Skill');
	    $this->loadModel('Talentadminskill');
	    
	    $this->viewBuilder()->layout('admin');
	    $where = " where users.is_talent_admin='Y'";
	    $this->request->session()->write('talent_admin_filter',$where);

	    $conn = ConnectionManager::get('default');
	    $talent_qry = " SELECT talent_admin.*,talent_admin.created_date as talent_from, users.user_name, users.created as membership_from, GROUP_CONCAT(skill_type.name) as skill_name, users.is_talent_admin, country.name as country, states.name as state, cities.name as city from talent_admin INNER join users on users.id=talent_admin.user_id LEFT JOIN talentadminskill on talent_admin.id=talentadminskill.talent_admin_id  LEFT JOIN skill_type ON talentadminskill.skill_id=skill_type.id LEFT JOIN country on country.id=talent_admin.country_id left join states on states.id=talent_admin.state_id left join cities on cities.id=talent_admin.city_id ".$where."  group by users.id ";
	    $talent = $conn->execute($talent_qry);
	    $talents = $talent ->fetchAll('assoc');
	    $this->set(compact('talents'));
	    
	    $this->loadModel('Country');
	    $country = $this->Country->find('list')->select(['id','name'])->toarray();
	    $this->set('country', $country);
	   
    }
    
    
    
     public function search(){ 
	     $this->loadModel('Users');
	    $this->loadModel('TalentAdmin');
	    $this->loadModel('Skill');
	    $this->loadModel('Talentadminskill');
	    
	   $from_date = $this->request->data['from_date'];
	    $to_date = $this->request->data['to_date'];
	    $user_type = $this->request->data['user_type'];
	    $country_id = $this->request->data['country_id'];
	    $state_id = $this->request->data['state_id'];
	    $city_id = $this->request->data['city_id'];
	    $skill = $this->request->data['skill'];
	  
	   // pr($this->request->data);
	  
	    $where = " where users.is_talent_admin = 'Y'";
	    
	    $cond = [];
	    if(!empty($user_type))
	    {
		$where.= " AND users.role_id = '".$user_type."'";
	    }
	    
	    if(!empty($country_id))
	    {
		$where.= " AND talent_admin.country_id = '".$country_id."'";
	    }
	    
	    if(!empty($state_id))
	    {
		$where.= " AND talent_admin.state_id = '".$state_id."'";
	    }
	    
	    if(!empty($city_id))
	    {
		$where.= " AND talent_admin.city_id = '".$city_id."'";
	    }
	    
	    if(!empty($skill))
	    {
		$where.= " AND talentadminskill.skill_id IN ('".$skill."')";
	    }
	    
	    $this->request->session()->write('talent_admin_filter',$where);
	    $conn = ConnectionManager::get('default');
	    $talent_qry = " SELECT talent_admin.*,talent_admin.created_date as talent_from, users.user_name, users.created as membership_from, GROUP_CONCAT(skill_type.name) as skill_name, users.is_talent_admin, country.name as country, states.name as state, cities.name as city from talent_admin INNER join users on users.id=talent_admin.user_id LEFT JOIN talentadminskill on talent_admin.id=talentadminskill.talent_admin_id  LEFT JOIN skill_type ON talentadminskill.skill_id=skill_type.id LEFT JOIN country on country.id=talent_admin.country_id left join states on states.id=talent_admin.state_id left join cities on cities.id=talent_admin.city_id ".$where."  group by users.id ";
	    //echo $talent_qry; die;
	    $talent = $conn->execute($talent_qry);
	    $talents = $talent ->fetchAll('assoc');
	    $this->set(compact('talents'));
	 }
	 
	 
	 
	 
    public function exporttalentadmin()
	{
	    $this->autoRender=false;
	    $blank="NA";
	    $conn = ConnectionManager::get('default');
	    $output="";
    
	    $output .= '"Sr Number",';
	    $output .= '"Name",';
	    $output .= '"Country",';
	    $output .= '"State",';
	    $output .= '"City",';
	    $output .= '"Skills",';
	    $output .= '"Email",';
	    $output .= '"Membership from",';
	    $output .= '"Talent Partner from",';
	    $output .="\n";
	    //pr($job); die;
	    $str="";
	    
	    //$where = " where users.is_talent_admin = 'Y'";
	    $where = $this->request->session()->read('talent_admin_filter');
	    $conn = ConnectionManager::get('default');
	    $talent_qry = " SELECT talent_admin.*,talent_admin.created_date as talent_from, users.user_name, users.created as membership_from, GROUP_CONCAT(skill_type.name) as skill_name, users.is_talent_admin, country.name as country, states.name as state, cities.name as city from talent_admin INNER join users on users.id=talent_admin.user_id LEFT JOIN talentadminskill on talent_admin.id=talentadminskill.talent_admin_id  LEFT JOIN skill_type ON talentadminskill.skill_id=skill_type.id LEFT JOIN country on country.id=talent_admin.country_id left join states on states.id=talent_admin.state_id left join cities on cities.id=talent_admin.city_id ".$where."  group by users.id ";
	    //echo $talent_qry; die;
	    $talent = $conn->execute($talent_qry);
	    $talents = $talent ->fetchAll('assoc');
	    
	    
	    $cnt=1; 
	    foreach($talents as $talent_data){ 
		
		$skills = str_replace(","," ",$talent_data['skill_name']);
		$output .=$cnt.",";
		$output.=$talent_data['user_name'].",";
		$output.=$talent_data['country'].",";
		$output.=$talent_data['state'].",";
		$output.=$talent_data['city'].",";
		$output.=$skills.",";
		$output.=$talent_data['email'].",";
		$output.=$talent_data['membership_from'].",";
		$output.=$talent_data['talent_from'].",";
		
		//$output .=$blank.",";
		//$output .=$blank.",";
		$cnt++;
		$output .="\r\n";
	    }

	    $filename = "Talent_admins.xlsx";
	    header('Content-type: application/xlsx');
	    header('Content-Disposition: attachment; filename='.$filename);
	    echo $output;
	    die;
	    $this->redirect($this->referer());
	}



             // For Pack Active
    public function status($id,$status){ 
    
        $this->loadModel('Users');
        if(isset($id) && !empty($id)){
            if($status =='N' ){

                $status = 'Y';
                $Pack = $this->Users->get($id);
                $Pack->status = $status;
                if ($this->Users->save($Pack)) {
                    $this->Flash->success(__('Users status has been updated.'));
                    return $this->redirect(['action' => 'index']);  
                }

            }else{

                $status = 'N';
                $Pack = $this->Users->get($id);
                $Pack->status = $status;
                if ($this->Users->save($Pack)) {
                $this->Flash->success(__('Users status has been updated.'));
                return $this->redirect(['action' => 'index']);  

                }
            }
        }
        }

                     // For genre Delete
    public function delete($id){ 
	    $this->loadModel('TalentAdmin');
	    $this->loadModel('Users');
	    $this->loadModel('Talentadminskill');
	    $talentadmin = $this->TalentAdmin->get($id);
	    if ($this->TalentAdmin->delete($talentadmin)) {
		// Change User status
		$users = $this->Users->get($talentadmin['user_id']);
		$user_info['is_talent_admin'] = 'N';
		$contentadmin = $this->Users->patchEntity($users, $user_info);
		$savedata=$this->Users->save($contentadmin);
		
		// Delete Talent admin skills
		 $this->Talentadminskill->deleteAll(['Talent_adminskills.user_id'=>$id]);
		$this->Flash->success(__('The TalentAdmin with id: {0} has been deleted.', h($id)));
		return $this->redirect(['action' => 'index']);
	    }
          }


	public function getStates()

		{
		$this->loadModel('Country');
		$this->loadModel('State');
		$states = array();
		if (isset($this->request->data['id']))
			{
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
		if (isset($this->request->data['id']))
			{
			$cities = $this->City->find('list')->select(['id', 'name'])->where(['City.state_id' => $this->request->data['id']])->toarray();
			}
		header('Content-Type: application/json');
		echo json_encode($cities);
		exit();
		}
	public function skills($id = null)

		{
		$this->loadModel('Users');
		$this->loadModel('Talentadminskill');
		$this->loadModel('Skill');
		if ($id != null)
			{
			$contentadminskillset = $this->Talentadminskill->find('all')->contain(['Skill'])->where(['Talentadminskill.user_id' => $id])->order(['Talentadminskill.id' => 'DESC'])->toarray();
			}
		$Skill = $this->Skill->find('all')->select(['id', 'name'])->where(['Skill.status' => 'Y'])->toarray();
		$this->set('Skill', $Skill);
		$this->set('skillset', $contentadminskillset);
		}
	
		public function add($id=null)
		{   
		    $this->loadModel('Users');
		    $this->loadModel('Country');
		    $this->loadModel('State');
		    $this->loadModel('City');
		    $this->loadModel('TalentAdmin');
		    $this->loadModel('Talentadminskill');
		    $this->loadModel('Skill');
		    $this->viewBuilder()->layout('admin');

		    $contentadminskillset = $this->Talentadminskill->find('all')->contain(['Skill'])->where(['Talentadminskill.user_id'=>$id])->toarray();
		    $this->set('skillofcontaint', $contentadminskillset);
		    if(isset($id) && !empty($id)){
			$users = $this->Users->find('all')->contain(['TalentAdmin','Talentadminskill'])->where(['Users.id' => $id])->first();
			$talent = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $id])->first();
		    }else{
			$users = $this->Users->newEntity();
			$talent = $this->TalentAdmin->newEntity();
		    }

		    $country = $this->Country->find('list')->select(['id', 'name'])->toarray();
		    $this->set('country', $country);
		    $cities = $this->City->find('list')->where(['City.state_id' =>$users['talent_admin']['state_id']])->toarray();
		    $this->set('cities', $cities);
		    $states = $this->State->find('list')->where(['State.country_id' =>$users['talent_admin']['country_id']])->toarray();
		    $this->set('states', $states);

		    if ($this->request->is(['post', 'put'])){
			if(!empty($this->request->data['passedit'])){
			    $this->request->data['password']= $this->_setPassword($this->request->data['passedit']);
			}else if(!empty($this->request->data['password']))
			{
			    $this->request->data['password']= $this->_setPassword($this->request->data['password']);
			}

			$this->request->data['role_id']= NONTALANT_ROLEID;
			try { 
			    $contentadmin = $this->Users->patchEntity($users, $this->request->data);
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
				$prop_data['enable_create_subadmin']= $this->request->data['enable_create_subadmin'];
				$prop_data['enable_delete_subadmin']= $this->request->data['enable_delete_subadmin'];
				$prop_data['referal_code']= md5(uniqid(rand(), true));
				$skillcheck	= $this->request->data['skill'];
				$skillcount=explode(",",$this->request->data['skill']);

				$contenttalent_admin = $this->TalentAdmin->patchEntity($talent, $prop_data);
				$savedata=$this->TalentAdmin->save($contenttalent_admin);
				$last_ta_id= $savedata->id;
				if ($skillcheck)
				{
				    $prop_skills=array();
				    $this->Talentadminskill->deleteAll(['Talent_adminskills.user_id'=>$id]);
				    for($i=0;$i<count($skillcount);$i++)
				    {
					$contentadminskill = $this->Talentadminskill->newEntity();
					$prop_skills['talent_admin_id']= $last_ta_id;
					$prop_skills['user_id']= $last_user_id;
					$prop_skills['skill_id']=$skillcount[$i];
					$contentadminskillsave = $this->Talentadminskill->patchEntity($contentadminskill, $prop_skills);
					$skilldata= $this->Talentadminskill->save($contentadminskillsave);
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
    
	
	// Make user Talent admin
	public function maketalentadmin($id=null)
	{   
	    $this->loadModel('Users');
	    $this->loadModel('Country');
	    $this->loadModel('State');
	    $this->loadModel('City');
	    $this->loadModel('TalentAdmin');
	    $this->loadModel('Talentadminskill');
	    $this->loadModel('Skill');
	    $this->viewBuilder()->layout('admin');

	    $contentadminskillset = $this->Talentadminskill->find('all')->contain(['Skill'])->where(['Talentadminskill.user_id'=>$id])->toarray();
	    $this->set('skillofcontaint', $contentadminskillset);
	    if(isset($id) && !empty($id)){
		$users = $this->Users->find('all')->where(['Users.id' => $id])->first();
		$talent = $this->TalentAdmin->newEntity();
	    }else{
		
		
	    }
	    $country = $this->Country->find('list')->select(['id', 'name'])->toarray();
	    $this->set('country', $country);
	    $cities = $this->City->find('list')->where(['City.state_id' => $users['talent_admin'][0]['state_id']])->toarray();
	    $this->set('cities', $cities);
	    $states = $this->State->find('list')->where(['State.country_id' =>$users['talent_admin'][0]['country_id']])->toarray();
	    $this->set('states', $states);

	    if ($this->request->is(['post', 'put'])){
		$usersdata['is_talent_admin']= 'Y';
		try { 
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
			$prop_data['enable_create_subadmin']= $this->request->data['enable_create_subadmin'];
			$prop_data['enable_delete_subadmin']= $this->request->data['enable_delete_subadmin'];
			$prop_data['referal_code']= md5(uniqid(rand(), true));
			$skillcheck	= $this->request->data['skill'];
			$skillcount=explode(",",$this->request->data['skill']);

			$contenttalent_admin = $this->TalentAdmin->patchEntity($talent, $prop_data);
			$savedata=$this->TalentAdmin->save($contenttalent_admin);
			$last_ta_id= $savedata->id;
			if ($skillcheck)
			{
			    $prop_skills=array();
			    $this->Talentadminskill->deleteAll(['Talent_adminskills.user_id'=>$id]);
			    for($i=0;$i<count($skillcount);$i++)
			    {
				$contentadminskill = $this->Talentadminskill->newEntity();
				$prop_skills['user_id']= $last_user_id;
				$prop_skills['skill_id']=$skillcount[$i];
				$prop_skills['talent_admin_id']= $last_ta_id;
				$contentadminskillsave = $this->Talentadminskill->patchEntity($contentadminskill, $prop_skills);
				$skilldata= $this->Talentadminskill->save($contentadminskillsave);
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
	
	public function removetalentadmin($id=null)
	{
	    $this->loadModel('Users');
	    $this->loadModel('TalentAdmin');
	    $this->loadModel('Talentadminskill');
	    if(isset($id) && !empty($id)){
		$users = $this->Users->find('all')->contain(['TalentAdmin','Talentadminskill'])->where(['Users.id' => $id])->first();
		$talent = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $id])->first();
	    }
	    $this->TalentAdmin->delete($talent);
	    $usersdata['is_talent_admin'] = "N";
	    $contentadmin = $this->Users->patchEntity($users, $usersdata);
	    $savedata=$this->Users->save($contentadmin);
	    $this->Talentadminskill->deleteAll(['Talent_adminskills.user_id'=>$id]);
	    $this->Flash->success(__('Talent admin has been deleted successfully'));
	    return $this->redirect(['action' => 'index']);
	
	}
	
	// All Transcations
	public function transcations($id=null)
	{
	    $this->viewBuilder()->layout('admin');
	    $this->loadModel('Users');
	    $this->loadModel('Profile');
	    $this->loadModel('Talentadmintransc');
	    $this->set('talent_admin_id', $id);
	
	    $transcations = $this->Talentadmintransc->find('all')->contain(['Users'])->where(['Talentadmintransc.talent_admin_id'=>$id])->order(['Talentadmintransc.id' => 'DESC'])->toarray();
	    //pr($transcations); die;
	    $this->set(compact('transcations'));
	}
	
	// Update Payout information
	public function updatepayout()
	{
	    $this->loadModel('Talentadmintransc');
	    //$amount = $this->request->data[''];
	    $talent_admin_id = $this->request->data['talent_admin_id'];
	    $this->request->data['description'] = "Payout";
	    $atranscation = $this->Talentadmintransc->newEntity();
	    $atranscation_arr = $this->Talentadmintransc->patchEntity($atranscation, $this->request->data);
	    $savetranscation = $this->Talentadmintransc->save($atranscation_arr);
	    $this->Flash->success(__('Payout has been updated successfully'));
	    return $this->redirect(['action' => 'transcations/'.$talent_admin_id]);
	    
	}
	
	
	
	
	
}
?>
