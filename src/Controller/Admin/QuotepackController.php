<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
class QuotepackController extends AppController
{       
    public function initialize(){	
    parent::initialize();
    }
	// For Quotepack package  Index
	public function index(){ 
            
                
		$this->loadModel('Quotepack');
	 	$this->viewBuilder()->layout('admin');
                $Quotepack = $this->Quotepack->find('all')->order(['Quotepack.id' => 'DESC'])->toarray();
                $this->set(compact('Quotepack'));
                
        
          }
         
         // For add Quotepack package
	public function add($id=null){
	
                $this->loadModel('Quotepack');
                $this->viewBuilder()->layout('admin');
                if(isset($id) && !empty($id)){
                    $packentity = $this->Quotepack->get($id);
                }else{
                
                    $packentity = $this->Quotepack->newEntity();
                }
                if ($this->request->is(['post', 'put'])) {
                
                    $transports = $this->Quotepack->patchEntity($packentity, $this->request->data);
                    if ($resu=$this->Quotepack->save($transports)) {
                    $this->Flash->success(__('Quotepack has been saved.'));
                    return $this->redirect(['action' => 'index']);
                    
                    }

                }

                    $this->set('packentity', $packentity);
            
        }
          
        // For Quotepack  Delete
	public function delete($id){
	
                    $this->loadModel('Quotepack');
                    $talent = $this->Quotepack->get($id);
                   if ($this->Quotepack->delete($talent)) {
                    $this->Flash->success(__('The Quotepack with id: {0} has been deleted.', h($id)));
                    return $this->redirect(['action' => 'index']);
                    
                    }
          }
          
          // For Pack Active
	public function status($id,$status){ 
            $this->loadModel('Quotepack');
            
			$talent = $this->Quotepack->get($id);
            $talent->status = $status;
            $this->Quotepack->save($talent);
            $active_pack_count = $this->Quotepack->find('all')->where(['status'=>'Y'])->count();
                    if($active_pack_count==0){
                        $talent->status = 'Y';
                        $this->Quotepack->save($talent);
                        $this->Flash->error(__('Atleast one package has to be active at all times.'));
                        return $this->redirect(['action' => 'index']);	
                    }else{
                    $this->Flash->success(__('Quotepack status has been updated.'));
                    return $this->redirect(['action' => 'index']);	
                    }
			
        }
        
}
