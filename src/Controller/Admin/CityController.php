<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
class CityController extends AppController
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
	public function index($id){ 

	    $this->loadModel('City');
        $this->viewBuilder()->layout('admin');
        $Country = $this->City->find('all')->contain(['States'])->order(['City.id' => 'DESC'])->where(['City.state_id'=>$id])->toarray();
        $this->set('Country', $Country);
    }
     // For Country add    
    public function add($id=null){

        $this->loadModel('City');
        $this->loadModel('States');
        $this->viewBuilder()->layout('admin');
        $States = $this->States->find('list')->select(['id','name'])->toarray();
            $this->set('States', $States);

        if(isset($id) && !empty($id)){
            $City = $this->City->get($id);
            }else{
            $City = $this->City->newEntity();
            }
        if ($this->request->is(['post', 'put'])) {

            $City = $this->City->patchEntity($City, $this->request->data);
            if ($resu=$this->City->save($City)) {
                    $state_id=$this->request->data['state_id'];
            $this->Flash->success(__('City  has been saved.'));
            return $this->redirect(['action' => 'index'.'/'.$state_id]);
            }

        }
        $this->set('City', $City);
            
        }


             // For Country Active
    public function status($id,$status){ 
    
        $this->loadModel('Country');
        if(isset($id) && !empty($id)){
            if($status =='N' ){

                $status = 'Y';
                $Country = $this->Country->get($id);
                $Country->status = $status;
                if ($this->Country->save($Country)) {
                    $this->Flash->success(__('Country status has been updated.'));
                    return $this->redirect(['action' => 'index']);  
                }

            }else{

                $status = 'N';
                $Country = $this->Country->get($id);
                $Country->status = $status;
                if ($this->Country->save($Country)) {
                $this->Flash->success(__('Country status has been updated.'));
                return $this->redirect(['action' => 'index']);  

                }
            }
        }
        }


               // For city Delete
    public function delete($id){ 
                    $this->loadModel('Country');
                    $Country = $this->Country->get($id);
                  
                    if ($this->Country->delete($Country)) {
                    $this->Flash->success(__('The Country with id: {0} has been deleted.', h($id)));
                    return $this->redirect(['action' => 'index']);
                    }
          }


}
?>