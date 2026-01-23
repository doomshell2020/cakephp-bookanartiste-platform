<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
class CountryController extends AppController
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

	    $this->loadModel('Country');
        $this->viewBuilder()->layout('admin');
        $Country = $this->Country->find('all')->order(['Country.id' => 'DESC'])->toarray();

        $this->set('Country', $Country);
    }
     // For Country add    
    public function add($id=null){

        $this->loadModel('Country');
        $this->viewBuilder()->layout('admin');
        if(isset($id) && !empty($id)){
            $Country = $this->Country->get($id);
            }else{
            $Country = $this->Country->newEntity();
            }
        if ($this->request->is(['post', 'put'])) {

            $transports = $this->Country->patchEntity($Country, $this->request->data);
            if ($resu=$this->Country->save($transports)) {

            $this->Flash->success(__('Country  has been saved.'));
            return $this->redirect(['action' => 'index']);
            }

        }
        $this->set('Country', $Country);
            
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


               // For Talent Delete
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