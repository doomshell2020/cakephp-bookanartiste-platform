<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
class GenreController extends AppController
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

	    $this->loadModel('Genre');
        $this->viewBuilder()->layout('admin');
        $Genre = $this->Genre->find('all')->where(['Genre.parent'=>0])->order(['Genre.id' => 'DESC'])->toarray();
        $this->set('Genre', $Genre);
    }
     // For Genre  add    
    public function add($id=null){

        $this->loadModel('Genre');
          $this->loadModel('Skill');
         $skill = $this->Skill->find('list')->select(['id','name'])->toarray();
            $this->set('skill', $skill);
        $this->viewBuilder()->layout('admin');
        if(isset($id) && !empty($id)){
            $Genre = $this->Genre->get($id);
            }else{
            $Genre = $this->Genre->newEntity();
            }
        if ($this->request->is(['post', 'put'])) {
            $this->request->data['parent']=0;
            

            $Genre = $this->Genre->patchEntity($Genre, $this->request->data);
            if ($resu=$this->Genre->save($Genre)) {

            $this->Flash->success(__('Genre has been saved.'));
            return $this->redirect(['action' => 'index']);
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