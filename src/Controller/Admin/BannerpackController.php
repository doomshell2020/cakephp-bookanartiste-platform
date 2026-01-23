<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
class BannerpackController extends AppController
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
	// For Banner pack index
public function index(){ 

 $this->loadModel('Bannerpack');
 $this->viewBuilder()->layout('admin');
 $Profilepack = $this->Bannerpack->find('all')->order(['Bannerpack.id' => 'DESC'])->toarray();
 $this->set('Profilepack', $Profilepack);
}
     // For Banner pack add    
public function add($id=null){

    $this->loadModel('Bannerpack');
    $this->viewBuilder()->layout('admin');
    if(isset($id) && !empty($id)){
        $packentity = $this->Bannerpack->get($id);
    }else{
        $packentity = $this->Bannerpack->newEntity();
    }
    if ($this->request->is(['post', 'put'])) {

        $transports = $this->Bannerpack->patchEntity($packentity, $this->request->data);
        if ($resu=$this->Bannerpack->save($transports)) {

            $this->Flash->success(__('Banner pack has been saved.'));
            return $this->redirect(['action' => 'index']);
        }

    }
    $this->set('packentity', $packentity);

}


             // For Pack Active
public function status($id,$status){ 

    $this->loadModel('Bannerpack');
    if(isset($id) && !empty($id)){
        if($status =='N' ){

            $status = 'Y';
            $Pack = $this->Bannerpack->get($id);
            $Pack->status = $status;
            if ($this->Bannerpack->save($Pack)) {
                $isServiceComplete=$this->Bannerpack->updateAll(array('status' =>'N'),array('Bannerpack.id !=' => $id));

                $this->Flash->success(__('Banner pack status has been updated.'));
                return $this->redirect(['action' => 'index']);  
            }

        }else{

            $status = 'N';
            $Pack = $this->Bannerpack->get($id);
            $Pack->status = $status;
            if ($this->Bannerpack->save($Pack)) {
                $this->Flash->success(__('Banner pack status has been updated.'));
                return $this->redirect(['action' => 'index']);  

            }
        }
    }
}


public function delete($id){ 
    $this->loadModel('Bannerpack');
    $Country = $this->Bannerpack->get($id);

    if ($this->Bannerpack->delete($Country)) {
        $this->Flash->success(__('The Banner package with id: {0} has been deleted.', h($id)));
        return $this->redirect(['action' => 'index']);
    }
}


}
?>