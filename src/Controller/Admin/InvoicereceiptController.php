<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\Datasource\ConnectionManager;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class InvoicereceiptController extends AppController
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

	public function index(){ 
		$this->loadModel('Invoicereceipt');
		$this->viewBuilder()->layout('admin');
		$invoicereceipt=$this->Invoicereceipt->find('all')->order(['id'=>ASC])->toarray();
		$this->set('invoicereceipt', $invoicereceipt);
	}



	public function add($id=null){

        $this->viewBuilder()->layout('admin');
        $this->loadModel('Invoicereceipt');
        
        if(isset($id) && !empty($id)){
            $invoicereceipt = $this->Invoicereceipt->get($id);
            }else{
            $invoicereceipt = $this->Invoicereceipt->newEntity();
            }
        if ($this->request->is(['post', 'put'])) {

            $invoicereceipts = $this->Invoicereceipt->patchEntity($invoicereceipt, $this->request->data);
            if ($resu=$this->Invoicereceipt->save($invoicereceipts)) {
            $this->Flash->success(__('Invoice and receipt has been updated.'));
            return $this->redirect(['action' => 'index']);
            }

        }
        $this->set('invoicereceipt', $invoicereceipt);
            
        }


	public function status($id,$status){ 
		$this->loadModel('Invoicereceipt');
		if(isset($id) && !empty($id)){
			if($status =='N' ){

				$status = 'Y';
				$Pack = $this->Invoicereceipt->get($id);
				$Pack->status = $status;
				if ($this->Invoicereceipt->save($Pack)) {
					$this->Flash->success(__('Invoice and receipt status has been updated.'));
					return $this->redirect(['action' => 'index']);  
				}

			}else{

				$status = 'N';
				$Pack = $this->Invoicereceipt->get($id);
				$Pack->status = $status;
				if ($this->Invoicereceipt->save($Pack)) {
					$this->Flash->success(__('Invoice and receipt status has been updated.'));
					return $this->redirect(['action' => 'index']);  

				}
			}
		}
	}


}
?>
