<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
class EnthcityController extends AppController
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
	
        $this->loadModel('Enthicity');
        $this->viewBuilder()->layout('admin');
        $Enthicity = $this->Enthicity->find('all')->order(['Enthicity.id' => 'DESC'])->toarray();
        $this->set(compact('Enthicity'));

    }
      // For Add Skill set add   
    public function add($id=null)
    {   
            $this->loadModel('Enthicity');
            $this->viewBuilder()->layout('admin');
            if(isset($id) && !empty($id)){

                 $Enthicity = $this->Enthicity->get($id);

            }else{
                 $Enthicity = $this->Enthicity->newEntity();
            }
            if ($this->request->is(['post', 'put'])){
            try { 

                    $Enthicity = $this->Enthicity->patchEntity($Enthicity, $this->request->data);
                    $Enthicity=$this->Enthicity->save($Enthicity);
                    if ($Enthicity){
                    $this->Flash->success(__('Enthicity has been saved.'));
                    return $this->redirect(['action' => 'index']);
                    }else{
                    $this->Flash->error(__(' Skill set df has been saved.'));
                    return $this->redirect(['action' => 'index']);
                    }
                }

            catch (\PDOException $e) {

                    $this->Flash->error(__('Enthicity Already Exits'));
                    $this->set('error', $error);
                    return $this->redirect(['action' => 'add']);
            }

            }
            $this->set('Enthicityentity', $Enthicity);
                
    }
 
 // For Skill set Status

    public function status($id,$status){ 
	
            $this->loadModel('Enthicity');
            if(isset($id) && !empty($id)){

                if($status =='N' ){

                    $status = 'Y';
                    $Enthicity = $this->Enthicity->get($id);
                    $Enthicity->status = $status;
                    if ($this->Enthicity->save($Enthicity)) {

                        $this->Flash->success(__('Enthicity has been updated.'));
                        return $this->redirect(['action' => 'index']);	
                    }
                }
                else{

                    $status = 'N';
                    $Enthicity = $this->Enthicity->get($id);
                    $Enthicity->status = $status;
                   // pr($Enthicity); die;
                    if ($this->Enthicity->save($Enthicity)) {
                    $this->Flash->success(__('Enthicity has been updated.'));
                    return $this->redirect(['action' => 'index']);	
                    }
                }
            }
        }

            // For Skill set  Delete
	public function delete($id){
	
            $this->loadModel('Enthicity');
            $Enthicity = $this->Enthicity->get($id);
            if ($this->Enthicity->delete($Enthicity)) {

            $this->Flash->success(__('The Enthicity with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
            }
          }

     
}