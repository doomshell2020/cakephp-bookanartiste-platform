<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
class LanguageController extends AppController
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
	
        $this->loadModel('Language');
        $this->viewBuilder()->layout('admin');
        $Language = $this->Language->find('all')->order(['Language.id' => 'DESC'])->toarray();
        $this->set(compact('Language'));

    }
      // For Add Skill set add   
    public function add($id=null)
    {   
            $this->loadModel('Language');
            $this->viewBuilder()->layout('admin');
            if(isset($id) && !empty($id)){

                 $Language = $this->Language->get($id);

            }else{
                 $Language = $this->Language->newEntity();
            }
            if ($this->request->is(['post', 'put'])){
            try { 

                    $Language = $this->Language->patchEntity($Language, $this->request->data);
                    $Language=$this->Language->save($Language);
                    if ($Language){
                    $this->Flash->success(__('Language has been saved.'));
                    return $this->redirect(['action' => 'index']);
                    }else{
                    $this->Flash->error(__(' Skill set df has been saved.'));
                    return $this->redirect(['action' => 'index']);
                    }
                }

            catch (\PDOException $e) {

                    $this->Flash->error(__('Language  Already Exits'));
                    $this->set('error', $error);
                    return $this->redirect(['action' => 'add']);
            }

            }
            $this->set('Language', $Language);
                
    }
 
 // For Skill set Status

    public function status($id,$status){ 
	
            $this->loadModel('Language');
            if(isset($id) && !empty($id)){

                if($status =='N' ){

                    $status = 'Y';
                    $Language = $this->Language->get($id);
                    $Language->status = $status;
                    if ($this->Language->save($Language)) {

                        $this->Flash->success(__('Language has been updated.'));
                        return $this->redirect(['action' => 'index']);	
                    }
                }
                else{

                    $status = 'N';
                    $Language = $this->Language->get($id);
                    $Language->status = $status;
                   // pr($Enthicity); die;
                    if ($this->Language->save($Language)) {
                    $this->Flash->success(__('Language has been updated.'));
                    return $this->redirect(['action' => 'index']);	
                    }
                }
            }
        }

            // For Skill set  Delete
	public function delete($id){
	
            $this->loadModel('Language');
            $Language = $this->Language->get($id);
            if ($this->Language->delete($Language)) {

            $this->Flash->success(__('The Language with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
            }
          }

     
}