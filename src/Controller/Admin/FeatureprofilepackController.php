<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;

class FeatureprofilepackController extends AppController
{       
    public function initialize(){	
    parent::initialize();
    }
	// For Featured profile package  Index
	public function index(){ 
	    $this->loadModel('Featuredprofile');
	    $this->viewBuilder()->layout('admin');
	    $Featuredjob = $this->Featuredprofile->find('all')->order(['Featuredprofile.id' => 'DESC'])->toarray();
	    $this->set(compact('Featuredjob'));
	}
         
	// For add Featured profile package
	public function add($id=null){
	    $this->loadModel('Featuredprofile');
	    $this->viewBuilder()->layout('admin');
	    if(isset($id) && !empty($id)){
		$packentity = $this->Featuredprofile->get($id);
	    }else{
		$packentity = $this->Featuredprofile->newEntity();
	    }
	    if ($this->request->is(['post', 'put'])) {
	    	//pr($this->request->data); die;
	    	if ($this->request->data['is_default']=='Y') {
	    		
	    		$this->Featuredprofile->updateAll(array('is_default' =>'N'),array('is_default' => 'Y'));
	    	}else{
	    		
	    		$this->request->data['is_default']='N';
	    	}
		$transports = $this->Featuredprofile->patchEntity($packentity, $this->request->data);
		if ($resu=$this->Featuredprofile->save($transports)) {
		    $this->Flash->success(__('Featured profile has been saved.'));
		    return $this->redirect(['action' => 'index']);
		}
	    }
	    $this->set('packentity', $packentity);
	}
          
	// For Quotepack  Delete
	public function delete($id){
	    $this->loadModel('Featuredprofile');
	    $talent = $this->Featuredprofile->get($id);
	    if ($this->Featuredprofile->delete($talent)) {
		$this->Flash->success(__('The Featured profile with id: {0} has been deleted.', h($id)));
		return $this->redirect(['action' => 'index']);
	    }
	}
          
	// For Pack Active
	public function status($id,$status){ 
	    $this->loadModel('Featuredprofile');
	    if(isset($id) && !empty($id)){
		if($status =='N' ){
		    $status = 'Y';
		    $talent = $this->Featuredprofile->get($id);
		    $talent->status = $status;
		    if ($this->Featuredprofile->save($talent)) {
			$this->Flash->success(__('Featured profile status has been updated.'));
			return $this->redirect(['action' => 'index']);	
		    }
		}else{
		    $status = 'N';
		    $talent = $this->Featuredprofile->get($id);
		    $talent->status = $status;
		    if ($this->Featuredprofile->save($talent)) {
			$this->Flash->success(__('Featured profile status has been updated.'));
			return $this->redirect(['action' => 'index']);	
		    }
		}
	    }
	}
        
        
                  
	// packdata in model
	public function profilepackdata($id){
	    $this->loadModel('Featuredprofile');
	    try {
		$profilepack = $this->Featuredprofile->find('all')->where(['Featuredprofile.id'=>$id])->first()->toarray();
		$this->set('profile',$profilepack);
	    }
	    catch (FatalErrorException $e) {
		$this->log("Error Occured", 'error');
	    }
	}

	public function featureprofiles($id=null){

	    $this->viewBuilder()->layout('admin');
	    $this->loadModel('Featuredprofile');
		$this->loadModel('Users');
		$currentdate=date('Y-m-d H:m:s');
		$session = $this->request->session(); 
		$session->delete('featureprosearchs');

		
		$Job = $this->Users->find('all')->contain(['Featuredprofile'])->where(['DATE(Users.featured_expiry) >='=>$currentdate,'Users.status'=>'Y'])->order(['Users.id' => 'DESC'])->toarray();

		$this->set('Job', $Job);
	   
	}


	public function search(){ 
	    $this->loadModel('Users');
	    //pr($this->request->data); die;
	    $currentdate=date('Y-m-d H:m:s');
	    $status = $this->request->data['status'];
	    $name = $this->request->data['name'];
	    $email = $this->request->data['email'];
	    $from_date = $this->request->data['from_date'];
	    $to_date = $this->request->data['to_date'];
	    $cond = [];

	    
	    if(!empty($name))
	    {
			$cond['Users.user_name LIKE']= "%".$name."%";
	    }
	    if(!empty($email))
	    {
			$cond['Users.email LIKE']= "%".$email."%";
	    }

	    if(!empty($from_date))
        {
            $cond['DATE(Users.feature_pro_date) >=']=date('Y-m-d',strtotime($from_date));
        }
        if(!empty($to_date))
        { 
            $cond['DATE(Users.featured_expiry) <=']=date('Y-m-d',strtotime($to_date));
        }
	    $this->request->session()->write('featureprosearchs',$cond);
	   
	    $Job = $this->Users->find('all')->contain(['Featuredprofile'])->where([$cond,'DATE(Users.featured_expiry) >='=>$currentdate,'Users.status'=>'Y'])->order(['Users.id' => 'DESC'])->toarray();
	    $this->set('Job',$Job);
	 }

	public function featureproexcel(){

	    $currentdate=date('Y-m-d H:m:s');
		$this->loadModel('Users');
	    $this->autoRender=false;
	    $userid = $this->request->session()->read('Auth.User.id');
	    $blank="NA";
	    $output="";
    
	    $output .= '"Sr Number",';
	    $output .= '"User Name",';
	    $output .= '"User Email Id",';
	    $output .= '"Feature Start Date",';
	    $output .= '"Feature End Date",';
	    $output .= '"Number of Days",';
	    $output .= '"Total Price Paid",';
	    $output .= '"Status",';
	    $output .="\n";
	    //pr($job); die;
	    $str="";
	    
	    $cond = $this->request->session()->read('featureprosearchs');
	    

		 $banners = $this->Users->find('all')->contain(['Featuredprofile'])->where([$cond,'DATE(Users.featured_expiry) >='=>$currentdate,'Users.status'=>'Y'])->order(['Users.id' => 'DESC'])->toarray(); 
	    //pr($talents); die;
	    $cnt=1; 
	    foreach($banners as $admin)
	    { 
			$fromdate=date('Y-m-d',strtotime($admin['feature_pro_date']));
        	$todate=date('Y-m-d',strtotime($admin['featured_expiry']));

			$output .=$cnt.",";
			$output.=$admin['user_name'].",";
			$output.=$admin['email'].",";
			if ($admin['feature_pro_date']) {
				$output.=$fromdate.",";
			}else{
	        	$output.="NA,"; 
			}

			if ($admin['featured_expiry']) {
				$output.=$todate.",";
			}else{
	        	$output.="NA,"; 
			}

			$output.=$admin['feature_pro_pack_numofday']."days ,";		
			$output.="$".$admin['feature_pro_pack_numofday']*$admin['featuredprofile']['price'].",";		
					
			if($todate > $currentdate){ 
	        	$output.="Featured";
	        }else{ 
	        	$output.="NA,"; 
	        }

			$cnt++;
			$output .="\r\n";
		 }

	    $filename = "Feature-Profiles.xlsx";
	    header('Content-type: application/xlsx');
	    header('Content-Disposition: attachment; filename='.$filename);
	    echo $output;
	    die;
	    $this->redirect($this->referer());
	}

	
}
