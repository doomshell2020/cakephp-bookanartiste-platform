<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
class SubgenreController extends AppController
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
	public function index($id){ 

	    $this->loadModel('Genre');
        $this->viewBuilder()->layout('admin');
        $Genre = $this->Genre->find('all')->contain(['Skill'])->where(['Genre.parent'=>$id])->order(['Genre.id' => 'DESC'])->toarray();
        $this->set('Genre', $Genre);
    }
     // For Genre  add    
    public function add($id=null){

        $this->loadModel('Genre');
         
         $Genreparent = $this->Genre->find('list')->where(['Genre.status'=>'Y','Genre.parent'=>0])->select(['id','name','skills_id'])->toarray();
         
            $this->set('Genreparent', $Genreparent);
        $this->viewBuilder()->layout('admin');
        if(isset($id) && !empty($id)){
            $Genre = $this->Genre->get($id);
            }else{
            $Genre = $this->Genre->newEntity();
            }
        if ($this->request->is(['post', 'put'])) {
            $pid=$this->request->data['parent'];
            $pskill=$this->Genre->find('all')->where(['Genre.id'=>$pid])->select(['skills_id'])->first()->toarray();
         
            $this->request->data['skills_id']=$pskill['skills_id'];
            

            $Genre = $this->Genre->patchEntity($Genre, $this->request->data);
            if ($resu=$this->Genre->save($Genre)) {

            $this->Flash->success(__('Genre has been saved.'));
            return $this->redirect(['action' => 'index'.'/'.$pid]);
            }

        }
        $this->set('Genre', $Genre);
            
        }


             // For Pack Active
    public function status($id,$status){ 
    
        $this->loadModel('Genre');
        if(isset($id) && !empty($id)){
            if($status =='N' ){

                $status = 'Y';
                $Pack = $this->Genre->get($id);
                $Pack->status = $status;
                if ($this->Genre->save($Pack)) {
                    $this->Flash->success(__('Genre status has been updated.'));
                    return $this->redirect(['action' => 'index']);  
                }

            }else{

                $status = 'N';
                $Pack = $this->Genre->get($id);
                $Pack->status = $status;
                if ($this->Genre->save($Pack)) {
                $this->Flash->success(__('Genre status has been updated.'));
                return $this->redirect(['action' => 'index']);  

                }
            }
        }
        }

                     // For genre Delete
    public function delete($id){ 
                    $this->loadModel('Genre');
                    $Genre = $this->Genre->get($id);
                  
                    if ($this->Genre->delete($Genre)) {
                    $this->Flash->success(__('The Genre with id: {0} has been deleted.', h($id)));
                    return $this->redirect(['action' => 'index']);
                    }
          }

}
?>