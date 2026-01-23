<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;

class VitalstatisticsController extends AppController
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
	$this->loadModel('Vitalskills');
	$this->loadModel('Vques');
	$this->loadModel('Skill');
	$this->loadModel('Genre');
	$this->loadModel('Genreskills');
	$this->viewBuilder()->layout('admin');
	
	$skilslist = $this->Skill->find('all')->contain(['Vitalskills'])->where(['Skill.status' =>'Y'])->order(['Skill.id' => 'DESC'])->toarray();
	$this->set(compact('skilslist'));
	
	$genre = $this->Genre->find('all')->select(['id','name'])->where(['Genre.parent'=>0,'Genre.status'=>'Y'])->order(['Genre.id' => 'DESC'])->toarray();
        $this->set('genre', $genre);
	
	$vitasls = $this->Genreskills->find('all')->select(['skill_id'=>'skill_id','vital_id'=>'GROUP_CONCAT(id)', 'genere_id'=>'GROUP_CONCAT(genre_id)'])->group('skill_id')->toarray();
    
        foreach($vitasls as $vitasls_data){
	    $vitalarr = '';
	    $skill_id = $vitasls_data['skill_id'];
	    $vital_id = explode(",",$vitasls_data->vital_id);
	    $genere_id = explode(",",$vitasls_data->genere_id);
	    $vitalarr['vital_ids'] = $vital_id;
	    $vitalarr['genre_ids'] = $genere_id;
	    $vitalarr_data[$skill_id] = $vitalarr;
        }
        $this->set('vitalarr_data', $vitalarr_data);
    }

    
    
     // Update Genere Vitals
     public function updatevitals(){ 
     
	$this->loadModel('Skill');
	$skill_id = $this->request->data['skill_id'];
	$vitasls = $this->Skill->find('all')->where(['Skill.id'=>$skill_id])->first();
	if($vitasls['is_vital']=='1')
	{
	    $options_data['is_vital'] = '0';
	    $options = $this->Skill->get($skill_id);
	    $option_arr = $this->Skill->patchEntity($options, $options_data);
	    $savedata = $this->Skill->save($option_arr);
	}
	else
	{
	    $options_data['is_vital'] = '1';
	    $options = $this->Skill->get($skill_id);
	    $option_arr = $this->Skill->patchEntity($options, $options_data);
	    $savedata = $this->Skill->save($option_arr);
	}
	die;
     }
 // Update Genere Vitals
     public function updatepersonnel(){ 
	$this->loadModel('Skill');
	$skill_id = $this->request->data['skill_id'];
	$vitasls = $this->Skill->find('all')->where(['Skill.id'=>$skill_id])->first();

	if($vitasls['manage_personnel']=='1')
	{
	    $options_data['manage_personnel'] = '0';
	    $options = $this->Skill->get($skill_id);
	    $option_arr = $this->Skill->patchEntity($options, $options_data);
	    $savedata = $this->Skill->save($option_arr);
	}
	else
	{
	    $options_data['manage_personnel'] = '1';
	    $options = $this->Skill->get($skill_id);
	    $option_arr = $this->Skill->patchEntity($options, $options_data);
	    $savedata = $this->Skill->save($option_arr);
	}
	die;
     }

      // Update Genere Vitals
     public function updateportfoilo(){ 
	$this->loadModel('Skill');
	$skill_id = $this->request->data['skill_id'];
	$vitasls = $this->Skill->find('all')->where(['Skill.id'=>$skill_id])->first();

	if($vitasls['is_Portfolio']=='1')
	{
	    $options_data['is_Portfolio'] = '0';
	    $options = $this->Skill->get($skill_id);
	    $option_arr = $this->Skill->patchEntity($options, $options_data);
	    $savedata = $this->Skill->save($option_arr);
	}
	else
	{
	    $options_data['is_Portfolio'] = '1';
	    $options = $this->Skill->get($skill_id);
	    $option_arr = $this->Skill->patchEntity($options, $options_data);
	    $savedata = $this->Skill->save($option_arr);
	}
	die;
     }
    
     // Update Genere Vitals
     public function updategenrevitals(){ 
	$this->loadModel('Genreskills');
	$genere_id = $this->request->data['genere_id'];
	$skill_id = $this->request->data['skill_id'];
	$vitasls = $this->Genreskills->find('all')->where(['Genreskills.skill_id'=>$skill_id,'Genreskills.genre_id'=>$genere_id])->first();
	//pr($vitasls); die;
	if($vitasls > 0)
	{
	    $vital_genre_id = $vitasls['id'];
	    $Genre = $this->Genreskills->get($vital_genre_id);
	    $this->Genreskills->delete($Genre);
	}
	else
	{
	    $options_data['skill_id'] = $skill_id;
	    $options_data['genre_id'] = $genere_id;
	    $options = $this->Genreskills->newEntity();
	    $option_arr = $this->Genreskills->patchEntity($options, $options_data);
	    $savedata = $this->Genreskills->save($option_arr);
	}
	die;
     }
    
    
    
    public function updatevitals1(){ 
	$this->loadModel('Genreskills');
	$this->loadModel('Skill');
	
	$skills = $this->request->data['skills'];
	if ($this->request->is(['post', 'put'])){
	    foreach($skills as $skill_id=>$skills_detail)
	    {
		$skill_id = $skill_id;
		// Saving Vital Statistics
		$vital_status = $skills_detail['is_vital'];
		$vital_data['is_vital'] = $vital_status;
		if($skill_id > 0)
		{
		    $vitals = $this->Skill->get($skill_id);
		    $vital_arr = $this->Skill->patchEntity($vitals, $vital_data);
		    $savevital = $this->Skill->save($vital_arr);
		}
		$genres = $skills_detail['genere'];
		foreach($genres as $genres_id)
		{
		    $genres_id = $genres_id;
		    $options_data['skill_id'] = $skill_id;
		    $options_data['genre_id'] = $genres_id;
		    if($this->request->data['datas']['oid'][$i] > 0)
		    {
			$options = $this->Genreskills->get($id);
			$option_arr = $this->Genreskills->patchEntity($options, $options_data);
			$savedata = $this->Genreskills->save($option_arr);
		    }
		    else
		    {
			$options = $this->Genreskills->newEntity();
			$option_arr = $this->Genreskills->patchEntity($options, $options_data);
			$savedata = $this->Genreskills->save($option_arr);
		    }
		}
	    }die;
	    $this->Flash->success(__('Vital Statistics status has been updated.'));
	    return $this->redirect(['action' => 'index']);  
	}
	else
	{
	
	
	}
    }
    
    
    
    
    
             // For Pack Active
    public function status($id,$status){ 
    
        $this->loadModel('Vques');
        if(isset($id) && !empty($id)){
            if($status =='N' ){

                $status = 'Y';
                $Pack = $this->Vques->get($id);
                $Pack->status = $status;
                if ($this->Vques->save($Pack)) {
                    $this->Flash->success(__('Vital Statistics status has been updated.'));
                    return $this->redirect(['action' => 'index']);  
                }

            }else{

                $status = 'N';
                $Pack = $this->Vques->get($id);
                $Pack->status = $status;
                if ($this->Vques->save($Pack)) {
                $this->Flash->success(__('Vital Statistics status has been updated.'));
                return $this->redirect(['action' => 'index']);  

                }
            }
        }
        }

    // For genre Delete
    public function delete($id){ 
	$this->loadModel('Users');
	$Genre = $this->Users->get($id);
	if ($this->Users->delete($Genre)) {
	    $this->Flash->success(__('The Users with id: {0} has been deleted.', h($id)));
	    return $this->redirect(['action' => 'index']);
	}
    }


	public function deleteoption($id){ 
	$this->autoRender=false;
	$this->loadModel('Voption');
	$id = $this->request->data['datadd'];
	$option = $this->Voption->get($id);

	if ($this->Voption->delete($option)) {
	    $this->Flash->success(__('The Option with id: {0} has been deleted.', h($id)));
	}
    }
    
    
    
    
    


    public function add($id=null)
    {   
	    $this->loadModel('Vs_option_type');
	    $vsoptiontype = $this->Vs_option_type->find('list')->select(['id','name'])->where(['Vs_option_type.status'=>1])->toarray();
	    $this->set('vsoptiontype', $vsoptiontype);
            $this->loadModel('Voption');
            $this->loadModel('Vques');
            $this->viewBuilder()->layout('admin');
            if(isset($id) && !empty($id)){
		$questions = $this->Vques->get($id);
		$question_info = $this->Vques->find('all')->where(['id' =>$id])->first();
		$this->set('question_info', $question_info);
		$savedoptions = $this->Voption->find('all')->where(['question_id' =>$id])->toarray();
		$this->set('savedoptions', $savedoptions);
            }else{
		$questions = $this->Vques->newEntity();
            }
            
            if ($this->request->is(['post', 'put'])){
		try { 
		    //$contentadmin = $this->Users->patchEntity($users, $this->request->data);
		    //$this->request->data['user_id']=$id;
		    $question_data['question'] = $this->request->data['question'];
		    $question_data['short_name'] = $this->request->data['short_name'];
		    $question_data['option_type_id'] = $this->request->data['category'];
		    $question_data['required'] = $this->request->data['required'];
		    $questions = $this->Vques->patchEntity($questions, $question_data);
		    $savedata = $this->Vques->save($questions);
		    $question_id = $this->request->data['question_id'];
    
		    $option_value = count($this->request->data['datas']['option_value']);
		    $options_data = array();
		    //$options_data['question_id'] = $id;
		    for($i=0;$i<$option_value;$i++)
		    {
			
			$options_data['question_id'] = $questions->id;
			$options_data['value'] = $this->request->data['datas']['option_value'][$i];
			if($this->request->data['datas']['oid'][$i] > 0)
			{
			    $options = $this->Voption->get($id);
			    $option_arr = $this->Voption->patchEntity($options, $options_data);
			    $savedata = $this->Voption->save($option_arr);
			}
			else
			{
			   $options = $this->Voption->newEntity();
			   $option_arr = $this->Voption->patchEntity($options, $options_data);
			   $savedata = $this->Voption->save($option_arr);
			}	
		    }
		    if ($savedata){
			$this->Flash->success(__('Vital Statistics has been added successfully.'));
			
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

}
?>
