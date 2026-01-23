<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;

class VitalstatsController extends AppController
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
	$this->loadModel('Vques');
	$this->viewBuilder()->layout('admin');
	$vitalstats = $this->Vques->find('all')->order(['Vques.id' => 'DESC'])->toarray();
	$this->set(compact('vitalstats'));
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
	$this->loadModel('Vques');
	$Genre = $this->Vques->get($id);
	if ($this->Vques->delete($Genre)) {
	    $this->Flash->success(__('The Vitals with id: {0} has been deleted.', h($id)));
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
	$vsoptiontype = $this->Vs_option_type->find('list')->select(['id','name'])->where(['Vs_option_type.status'=>'Y'])->toarray();
	//pr($vsoptiontype); die;
	//pr($this->request->data); die;
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
		$question_data['gender'] = $this->request->data['gender'];
		$question_data['option_type_id'] = $this->request->data['category'];
		$question_data['required'] = $this->request->data['required'];
		$question_data['orderstrcture'] = $this->request->data['orderstrcture'];
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
			$options = $this->Voption->get($this->request->data['datas']['oid'][$i]);
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
