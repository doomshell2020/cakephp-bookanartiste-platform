<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
class StateController extends AppController
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
	public function index($id=null){ 

	    $this->loadModel('State');
        $this->viewBuilder()->layout('admin');
        $State = $this->State->find('all')->contain(['Country'])->where(['State.country_id'=>$id])->order(['State.id' => 'DESC'])->toarray();

       
        $this->set('State', $State);
    }
     // For Country add    
    public function add($id=null){

        $this->loadModel('Country');
        $this->loadModel('State');
         $country = $this->Country->find('list')->select(['id','name'])->toarray();
            $this->set('country', $country);
        $this->viewBuilder()->layout('admin');
        if(isset($id) && !empty($id)){
            $State = $this->State->get($id);
            }else{
            $State = $this->State->newEntity();
            }
        if ($this->request->is(['post', 'put'])) {
        

            $State = $this->State->patchEntity($State, $this->request->data);
            if ($resu=$this->State->save($State)) {
                    $cntid=$this->request->data['country_id'];
            $this->Flash->success(__('State  has been saved.'));
            return $this->redirect(['action' => 'index'.'/'.$cntid]);
            }

        }
        $this->set('State', $State);
            
        }


             // For State Active
    public function status($id,$status){ 
    
        $this->loadModel('State');
        if(isset($id) && !empty($id)){
            if($status =='N' ){

                $status = 'Y';
                $State = $this->State->get($id);
                $State->status = $status;
                if ($this->State->save($State)) {

                    $this->Flash->success(__('State status has been updated.'));
                    return $this->redirect(['action' => 'index']);  
                }

            }
            else{

                $status = 'N';
                echo  $State = $this->State->get($id);
                $State->status = $status;
                if ($this->State->save($State)) {
                $this->Flash->success(__('State status has been updated.'));
                return $this->redirect(['action' => 'index']);  

                }
            }
        }
        }


               // For Talent Delete
    public function delete($id){ 
                    $this->loadModel('State');
                    $Country = $this->State->get($id);
                  
                    if ($this->State->delete($Country)) {
                    $this->Flash->success(__('The State with id: {0} has been deleted.', h($id)));
                    return $this->redirect(['action' => 'index']);
                    }
          }


}
?>