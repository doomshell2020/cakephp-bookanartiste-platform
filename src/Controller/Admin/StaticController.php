<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
class StaticController extends AppController
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
	
        $this->loadModel('Static');
        $this->viewBuilder()->layout('admin');
        $Static = $this->Static->find('all')->order(['Static.id' => 'DESC'])->toarray();
        
        $this->set(compact('Static'));

    }
      // For Add Skill set add   
    public function add($id=null)
    {   //echo $id;
            $this->loadModel('Static');

            $this->viewBuilder()->layout('admin');
            if(isset($id) && !empty($id)){

                 $Static = $this->Static->get($id);

            }else{
                 $Static = $this->Static->newEntity();
            }
            if ($this->request->is(['post', 'put'])){
                
            try { 

                    $Static = $this->Static->patchEntity($Static, $this->request->data);
                    $Static=$this->Static->save($Static);
                    if ($Static){
                    $this->Flash->success(__('Static has been saved.'));
                    return $this->redirect(['action' => 'index']);
                    }else{
                    $this->Flash->error(__(' Static set df has been saved.'));
                    return $this->redirect(['action' => 'index']);
                    }
                }

            catch (\PDOException $e) {

                    $this->Flash->error(__('Currency  Already Exits'));
                    $this->set('error', $error);
                    return $this->redirect(['action' => 'add']);
            }

            }
            $this->set('Static', $Static);
                
    }
 
 // For Skill set Status

    public function status($id,$status){ 
	
            $this->loadModel('Static');
            if(isset($id) && !empty($id)){

                if($status =='N' ){

                    $status = 'Y';
                    $Static = $this->Static->get($id);
                    $Static->status = $status;
                    if ($this->Static->save($Static)) {

                        $this->Flash->success(__('Static has been updated.'));
                        return $this->redirect(['action' => 'index']);	
                    }
                }
                else{

                    $status = 'N';
                    $Static = $this->Static->get($id);
                    $Static->status = $status;
                   // pr($Enthicity); die;
                    if ($this->Static->save($Static)) {
                    $this->Flash->success(__('Static has been updated.'));
                    return $this->redirect(['action' => 'index']);	
                    }
                }
            }
        }

            // For Skill set  Delete
	public function delete($id){
	
            $this->loadModel('Static');
            $Static = $this->Static->get($id);
            if ($this->Static->delete($Static)) {

            $this->Flash->success(__('The Currency with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
            }
          }

            // for description pop-up
        public function description($id=null){ 
            $this->loadModel('Static');
        $templates = $this->Static->find('all')->where(['Static.id' =>$id])->first();
        
            $this->set('templates', $templates);
        //show data in listing
    } 

     
}