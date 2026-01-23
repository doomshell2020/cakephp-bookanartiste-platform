<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
class SkillController extends AppController
{       
    public function initialize(){	
    parent::initialize();
    }
    // function used for password string  change:

    public  function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
    
	// For Skill set Index

	public function index(){ 
	    $this->loadModel('Skill');
	    $this->viewBuilder()->layout('admin');
	    $skilldata = $this->Skill->find('all')->order(['Skill.id' => 'DESC'])->toarray();
	    $this->set(compact('skilldata'));
	}
      // For Add Skill set add   
    public function add($id=null)
    {   
            $this->loadModel('Skill');
            $this->viewBuilder()->layout('admin');
            if(isset($id) && !empty($id)){

                 $skillent = $this->Skill->get($id);

            }else{
                 $skillent = $this->Skill->newEntity();
            }
            if ($this->request->is(['post', 'put'])){
            try { 

                    $skilldata = $this->Skill->patchEntity($skillent, $this->request->data);
                    $savedata=$this->Skill->save($skilldata);
                    if ($savedata){
                    $this->Flash->success(__('Skill set has been saved.'));
                    return $this->redirect(['action' => 'index']);
                    }else{
                    $this->Flash->error(__(' Skill set df has been saved.'));
                    return $this->redirect(['action' => 'index']);
                    }
                }

            catch (\PDOException $e) {

                    $this->Flash->error(__('Skill is Already Exits'));
                    $this->set('error', $error);
                    return $this->redirect(['action' => 'add']);
            }

            }
            $this->set('skillsetentity', $skillent);
                
    }
 
 // For Skill set Status

    public function status($id,$status){ 
	
            $this->loadModel('Skill');
            if(isset($id) && !empty($id)){

                if($status =='N' ){

                    $status = 'Y';
                    $Skill = $this->Skill->get($id);
                    $Skill->status = $status;
                    if ($this->Skill->save($Skill)) {

                        $this->Flash->success(__('Skill set has been updated.'));
                        return $this->redirect(['action' => 'index']);	
                    }
                }
                else{
                    $status = 'N';
                    $Skill = $this->Skill->get($id);
                    $Skill->status = $status;
                    if ($this->Skill->save($Skill)) {
                    $this->Flash->success(__('Skill sethas been updated.'));
                    return $this->redirect(['action' => 'index']);	
                    }
                }
            }
        }

            // For Skill set  Delete
	public function delete($id){
	
            $this->loadModel('Skill');
            $Skill = $this->Skill->get($id);
            if ($this->Skill->delete($Skill)) {

            $this->Flash->success(__('The Skill with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
            }
          }





     
}