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

class TalentsubadminController extends AppController
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




}
?>
