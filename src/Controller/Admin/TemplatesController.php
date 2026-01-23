<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;


class TemplatesController extends AppController
{
	//initialize component

	public function initialize(){
        parent::initialize();
       	$this->loadModel('Templates');
$this->Auth->allow(['index','description']);
    	}
	
	public function index($id=null){ 
		$this->viewBuilder()->layout('admin');
		$templatesdata = $this->Templates->find('all')->where(['Templates.id !=' =>10])->order(['Templates.id' => 'DESC'])->toarray();
			$this->set('templatesdata', $templatesdata);
		//show data in listing
	}
public function add($id=null){ 
		$this->viewBuilder()->layout('admin');
		if(isset($id) && !empty($id)){
			//using for edit
		     $templates = $this->Templates->get($id);
            
		}
		else{
		$templates = $this->Templates->newEntity();
	}
		$this->set('templates', $templates);
		if ($this->request->is(['post', 'put'])) {
			//pr($this->request->data); die;
		//show data in listing
				$templates = $this->Templates->patchEntity($templates, $this->request->data);
				//pr($artists); die;
			//pr($this->request->data); die;	
			if ($this->Templates->save($templates)) {
					$this->Flash->success(__(' Template Page has been saved.'));
					return $this->redirect(['action' => 'index']);	
				  }
	}
}
	public function delete($id){
	    //$this->request->allowMethod(['post', 'delete']);
		$templates = $this->Templates->get($id);
		//delete pariticular entry
	    if ($this->Templates->delete($templates)) {
		$this->Flash->success(__('The Template with id: {0} has been deleted.', h($id)));
		return $this->redirect(['action' => 'index']);
	    }
	}
	 public function status($id,$status){
		if(isset($id) && !empty($id)){
		if($status =='N' ){
			
				$status = 'Y';
			//status update
				$templates = $this->Templates->get($id);
				$templates->status = $status;
				if ($this->Templates->save($templates)) {
					$this->Flash->success(__('Template status has been updated.'));
					return $this->redirect(['action' => 'index']);	
				}
		}else{
			
				$status = 'N';
			//status update
			$templates = $this->Templates->get($id);
			$templates->status = $status;
			if ($this->Templates->save($templates)) {
				$this->Flash->success(__('Template status has been updated.'));
				return $this->redirect(['action' => 'index']);	
			}
			
			
		}

	}
		
	}
	
	
	// for description pop-up
		public function description($id=null){ 
		$templates = $this->Templates->find('all')->where(['Templates.id' =>$id])->first();
		//pr($artists); die;
			$this->set('templates', $templates);
		//show data in listing
	}   
	
	 
}
