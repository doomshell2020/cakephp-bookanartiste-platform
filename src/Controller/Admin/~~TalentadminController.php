<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
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
        $this->viewBuilder()->layout('admin');
        $contentadmin = $this->Users->find('all')->contain(['Skillset'])->where(['Users.role_id'=>Talent_admin])->order(['Users.id' => 'DESC'])->toarray();
        $this->set(compact('contentadmin'));
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
                    $this->loadModel('Users');
                    $Genre = $this->Users->get($id);
                  
                    if ($this->Users->delete($Genre)) {
                    $this->Flash->success(__('The Users with id: {0} has been deleted.', h($id)));
                    return $this->redirect(['action' => 'index']);
                    }
          }




    public function add($id=null)
    {   
           
            $this->loadModel('Users');
            $this->loadModel('Country');
            $this->viewBuilder()->layout('admin');
            if(isset($id) && !empty($id)){
            $users = $this->Users->get($id);
            }else{

            $users = $this->Users->newEntity();
            }
            if ($this->request->is(['post', 'put'])){
                //pr($this->request->data); die;
                    
            $country = $this->Country->find('list')->select(['id', 'name'])->toarray();
	    $this->set('country', $country);
            if(!empty($this->request->data['passedit'])){
            $this->request->data['password']= $this->_setPassword($this->request->data['passedit']);
            }else if(!empty($this->request->data['password']))
            {
            $this->request->data['password']= $this->_setPassword($this->request->data['password']);
            }else{

            }

            $this->request->data['role_id']= Talent_admin;

            try { 
            $contentadmin = $this->Users->patchEntity($users, $this->request->data);
            $savedata=$this->Users->save($contentadmin);
            if ($savedata){
            

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

}
?>