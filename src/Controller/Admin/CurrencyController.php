<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
class CurrencyController extends AppController
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
	
        $this->loadModel('Currency');
        $this->viewBuilder()->layout('admin');
        $Currency = $this->Currency->find('all')->order(['Currency.id' => 'DESC'])->toarray();
        
        $this->set(compact('Currency'));

    }
      // For Add Skill set add   
    public function add($id=null)
    {   
            $this->loadModel('Currency');
            $this->viewBuilder()->layout('admin');
            if(isset($id) && !empty($id)){

                 $Currency = $this->Currency->get($id);

            }else{
                 $Currency = $this->Currency->newEntity();
            }
            if ($this->request->is(['post', 'put'])){
            try { 

                    $Currency = $this->Currency->patchEntity($Currency, $this->request->data);
                    $Currency=$this->Currency->save($Currency);
                    if ($Currency){
                    $this->Flash->success(__('Currency has been saved.'));
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
	
            $this->loadModel('Currency');
            if(isset($id) && !empty($id)){

                if($status =='N' ){

                    $status = 'Y';
                    $Currency = $this->Currency->get($id);
                    $Currency->status = $status;
                    if ($this->Currency->save($Currency)) {

                        $this->Flash->success(__('Currency has been updated.'));
                        return $this->redirect(['action' => 'index']);	
                    }
                }
                else{

                    $status = 'N';
                    $Currency = $this->Currency->get($id);
                    $Currency->status = $status;
                   // pr($Enthicity); die;
                    if ($this->Currency->save($Currency)) {
                    $this->Flash->success(__('Currency has been updated.'));
                    return $this->redirect(['action' => 'index']);	
                    }
                }
            }
        }

            // For Skill set  Delete
	public function delete($id){
	
            $this->loadModel('Currency');
            $Currency = $this->Currency->get($id);
            if ($this->Currency->delete($Currency)) {

            $this->Flash->success(__('The Currency with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
            }
          }

     
}