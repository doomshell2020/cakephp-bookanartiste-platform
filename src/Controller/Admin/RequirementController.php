<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
class RequirementController extends AppController
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
	// For Country index
	public function index(){ 

	    $this->loadModel('RequirementPack');
        $this->viewBuilder()->layout('admin');
        $Country = $this->RequirementPack->find('all')->order(['RequirementPack.id' => 'DESC'])->toarray();

        $this->set('RequirementPack', $Country);
    }
     // For Country add    
    public function add($id=null){

        $this->loadModel('RequirementPack');

 
        $this->viewBuilder()->layout('admin');
        if(isset($id) && !empty($id)){
          $Requirementpackage = $this->RequirementPack->get($id);
            }else{
        $Requirementpackage = $this->RequirementPack->newEntity();
            }
        if ($this->request->is(['post', 'put'])) {


            $Requirementent = $this->RequirementPack->patchEntity($Requirementpackage, $this->request->data);

             //$this->Requirement->save($Requirement);
            
            if ($resu=$this->RequirementPack->save($Requirementent)) {

            $this->Flash->success(__('Requirement  has been saved.'));
            return $this->redirect(['action' => 'index']);
            }

        }
        $this->set('Requirement', $Requirementpackage);
            
        }


             // For Country Active
    public function status($id,$status){ 
    
        $this->loadModel('RequirementPack');
        if(isset($id) && !empty($id)){
            if($status =='N' ){

                $status = 'Y';
                $Country = $this->RequirementPack->get($id);
                $Country->status = $status;
                if ($this->RequirementPack->save($Country)) {
                    $this->Flash->success(__('Requirement Pack status has been updated.'));
                    return $this->redirect(['action' => 'index']);  
                }

            }else{

                $status = 'N';
                $Country = $this->RequirementPack->get($id);
                $Country->status = $status;
                if ($this->RequirementPack->save($Country)) {
                $this->Flash->success(__('Requirement Pack status has been updated.'));
                return $this->redirect(['action' => 'index']);  

                }
            }
        }
        }


               // For Talent Delete
    public function delete($id){ 
                    $this->loadModel('RequirementPack');
                    $Requirement = $this->RequirementPack->get($id);
                  
                    if ($this->RequirementPack->delete($Requirement)) {
                    $this->Flash->success(__('The Requirement Pack with id: {0} has been deleted.', h($id)));
                    return $this->redirect(['action' => 'index']);
                    }
          }


}
?>