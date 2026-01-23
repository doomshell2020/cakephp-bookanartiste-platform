<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
class EventtypeController extends AppController
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
	
        $this->loadModel('Eventtype');
        $this->viewBuilder()->layout('admin');
        $Currency = $this->Eventtype->find('all')->order(['Eventtype.id' => 'DESC'])->toarray();
        
        $this->set(compact('Currency'));

    }
      // For Add Skill set add   
    public function add($id=null)
    {   
            $this->loadModel('Eventtype');
            $this->viewBuilder()->layout('admin');
            if(isset($id) && !empty($id)){

                 $Currency = $this->Eventtype->get($id);

            }else{
                 $Currency = $this->Eventtype->newEntity();
            }
            if ($this->request->is(['post', 'put'])){
            try { 

                    $Currency = $this->Eventtype->patchEntity($Currency, $this->request->data);
                    $Currency=$this->Eventtype->save($Currency);
                    if ($Currency){
                    $this->Flash->success(__('Event type has been saved.'));
                    return $this->redirect(['action' => 'index']);
                    }else{
                    $this->Flash->error(__(' Skill set df has been saved.'));
                    return $this->redirect(['action' => 'index']);
                    }
                }

            catch (\PDOException $e) {

                    $this->Flash->error(__('Currency  Already Exits'));
                    $this->set('error', $error);
                    return $this->redirect(['action' => 'add']);
            }

            }
            $this->set('Currency', $Currency);
                
    }
 
 // For Skill set Status

    public function status($id,$status){ 
	
            $this->loadModel('Eventtype');
            if(isset($id) && !empty($id)){

                if($status =='N' ){

                    $status = 'Y';
                    $Currency = $this->Eventtype->get($id);
                    $Currency->status = $status;
                    if ($this->Eventtype->save($Currency)) {

                        $this->Flash->success(__('Event type has been updated.'));
                        return $this->redirect(['action' => 'index']);	
                    }
                }
                else{

                    $status = 'N';
                    $Currency = $this->Eventtype->get($id);
                    $Currency->status = $status;
                   // pr($Enthicity); die;
                    if ($this->Eventtype->save($Currency)) {
                    $this->Flash->success(__('Event type has been updated.'));
                    return $this->redirect(['action' => 'index']);	
                    }
                }
            }
        }

            // For Skill set  Delete
	public function delete($id){
	
            $this->loadModel('Eventtype');
            $Currency = $this->Eventtype->get($id);
            if ($this->Eventtype->delete($Currency)) {

            $this->Flash->success(__('The Event type with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
            }
          }

     
}