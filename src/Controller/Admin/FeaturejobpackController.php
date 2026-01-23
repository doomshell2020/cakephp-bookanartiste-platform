<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;

class FeaturejobpackController extends AppController
{       
    public function initialize(){	
    parent::initialize();
    }
	// For Quotepack package  Index
	public function index(){ 
	    $this->loadModel('Featuredjob');
	    $this->viewBuilder()->layout('admin');
	    $Featuredjob = $this->Featuredjob->find('all')->order(['Featuredjob.id' => 'DESC'])->toarray();
	    $this->set(compact('Featuredjob'));
	}
         
	// For add Quotepack package
	public function add($id=null){
	    $this->loadModel('Featuredjob');
	    $this->viewBuilder()->layout('admin');
	    if(isset($id) && !empty($id)){
		$packentity = $this->Featuredjob->get($id);
	    }else{
		$packentity = $this->Featuredjob->newEntity();
	    }
	    if ($this->request->is(['post', 'put'])) {
	    	pr($this->request->data); die;
	    	if ($this->request->data['is_default']=='Y') {
	    		
	    		$this->Featuredjob->updateAll(array('is_default' =>'N'),array('is_default' => 'Y'));
	    	}else{
	    		
	    		$this->request->data['is_default']='N';
	    	}
		$transports = $this->Featuredjob->patchEntity($packentity, $this->request->data);
		if ($resu=$this->Featuredjob->save($transports)) {
		    $this->Flash->success(__('Featuredjob has been saved.'));
		    return $this->redirect(['action' => 'index']);
		} 
	    } 
	    $this->set('packentity', $packentity);
	} 
          
	// For Quotepack  Delete
	public function delete($id){
	    $this->loadModel('Featuredjob');
	    $talent = $this->Featuredjob->get($id);
	    if ($this->Featuredjob->delete($talent)) {
		$this->Flash->success(__('The Featuredjob with id: {0} has been deleted.', h($id)));
		return $this->redirect(['action' => 'index']);
	    }
	}
          
	// For Pack Active
	public function status($id,$status){ 
	    $this->loadModel('Featuredjob');
	    if(isset($id) && !empty($id)){
		if($status =='N' ){
		    $status = 'Y';
		    $talent = $this->Featuredjob->get($id);
		    $talent->status = $status;
		    if ($this->Featuredjob->save($talent)) {
			$this->Flash->success(__('Featuredjob status has been updated.'));
			return $this->redirect(['action' => 'index']);	
		    }
		}else{
		    $status = 'N';
		    $talent = $this->Featuredjob->get($id);
		    $talent->status = $status;
		    if ($this->Featuredjob->save($talent)) {
			$this->Flash->success(__('Featuredjob status has been updated.'));
			return $this->redirect(['action' => 'index']);	
		    }
		}
	    }
	}
        
        
                  
	// packdata in model
	public function profilepackdata($id){
	    $this->loadModel('Featuredjob');
	    try {
		$profilepack = $this->Featuredjob->find('all')->where(['Featuredjob.id'=>$id])->first()->toarray();
		$this->set('profile',$profilepack);
	    }
	    catch (FatalErrorException $e) {
		$this->log("Error Occured", 'error');
	    }
	}

	public function editsort($ids=null)
		{
			$this->loadModel('Products');
			$pro=explode(",", $ids);

			$productid = $this->Products->find('all')->where(['Products.id'=>$ids])->order(['Products.ptype' => 'ASC','Products.sortnumber' => 'ASC'])->toarray();
           //pr($productid); die;
			$this->set('productid', $productid);	

			if ($this->request->is(['post', 'put'])) {

				$results = $this->sortingupdate($this->request->data['sortnumber'],$this->request->data['prtype']);
				$id=$this->request->data['id'];

				$sortnumber=$this->request->data['sortnumber'];
				
				$conn = ConnectionManager::get('default');
				$update_status='UPDATE `products` SET `sortnumber`='.$sortnumber.'  where `products`.`id`='.$id.'';
				$conn->execute($update_status);
				
				$this->Flash->success(__('Products sorting has been updated.'));
				return $this->redirect(['action' => 'index']);	

			}
		}

		public function sortingupdate($number,$type)
		{ 
			$this->loadModel('Products');
			$con = ConnectionManager::get('default');
			$detail = 'update products set sortnumber=sortnumber+1 where sortnumber >='.$number.' AND `ptype`='."'".$type."'".'';
			$results = $con->execute($detail);
		}


		public function check_shortingquick()
		{
			$this->loadModel('Products');
			$radioValue=$this->request->data['radioValue'];

			$product = $this->Products->find('all')->where(['Products.ptype'=>$radioValue,'Products.sortnumber' =>$this->request->data['sortno']])->toarray();

			if($product){
				echo 1; die;

			}else{
				echo 0; die;
			}
		}
    
//Featured requirements...
    public function featurerequirment()
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('Requirement');
		$this->loadModel('Users');
		$currentdate=date('Y-m-d H:m:s');
		$session = $this->request->session(); 
		$session->delete('featurejobsearchs');

		
		$Job = $this->Requirement->find('all')->contain(['Eventtype','Users','Featuredjob'])->where(['DATE(Requirement.expiredate) >='=>$currentdate,'Requirement.status'=>'Y'])->order(['Requirement.id' => 'DESC'])->toarray();
		//pr($Job);
		$this->set('Job', $Job);
	}


	public function search(){ 
	    $this->loadModel('Users');
	    $this->loadModel('Requirement');
	    //pr($this->request->data); die;
	    $currentdate=date('Y-m-d H:m:s');
	    $status = $this->request->data['featured'];
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
            $cond['DATE(Requirement.feature_job_date) >=']=date('Y-m-d',strtotime($from_date));
        }
        if(!empty($to_date))
        { 
            $cond['DATE(Requirement.feature_job_date) <=']=date('Y-m-d',strtotime($to_date));
		}
		if(!empty($status))
        { 
            $cond['featured']=$status;
        }
	    $this->request->session()->write('featurejobsearchs',$cond);
	   
	    $Job = $this->Requirement->find('all')->contain(['Users','Featuredjob'])->where([$cond,'DATE(Requirement.expiredate) >='=>$currentdate,'Requirement.status'=>'Y'])->order(['Requirement.id' => 'DESC'])->toarray();
	    $this->set('Job',$Job);
	 }

	public function featurejoexcel(){

	    $currentdate=date('Y-m-d H:m:s');
		$this->loadModel('Users');
		$this->loadModel('Requirement');
	    $this->autoRender=false;
	    $userid = $this->request->session()->read('Auth.User.id');
	    $blank="NA";
	    $output="";
    
	    $output .= '"Sr Number",';
	    $output .= '"Job Title",';
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
	    
	    $cond = $this->request->session()->read('featurejobsearchs');
	    

		 $banners = $this->Requirement->find('all')->contain(['Users','Featuredjob'])->where([$cond,'DATE(Requirement.expiredate) >='=>$currentdate,'Requirement.status'=>'Y'])->order(['Requirement.id' => 'DESC'])->toarray();  
	    //pr($talents); die;
	    $cnt=1; 
	    foreach($banners as $admin)
	    { 
			$fromdate=date('Y-m-d',strtotime($admin['feature_job_date']));
        	$todate=date('Y-m-d',strtotime($admin['expiredate']));

			$output .=$cnt.",";
			$output.=$admin['title'].",";
			$output.=$admin['user']['user_name'].",";
			$output.=$admin['user']['email'].",";
			if ($admin['feature_job_date']) {
				$output.=$fromdate.",";
			}else{
	        	$output.="NA,"; 
			}

			if ($admin['expiredate']) {
				$output.=$todate.",";
			}else{
	        	$output.="NA,"; 
			}

			$output.=$admin['feature_job_days']."days ,";		
			$output.="$".$admin['feature_job_days']*$admin['featuredjob']['price'].",";		
					
			if($admin['featured']=='Y'){ 
	        	$output.="Featured";
	        }else{ 
	        	$output.="NA,"; 
	        }

			$cnt++;
			$output .="\r\n";
		 }

	    $filename = "Feature-Job.csv";
	    header('Content-type: application/csv');
	    header('Content-Disposition: attachment; filename='.$filename);
	    echo $output;
	    die;
	    $this->redirect($this->referer());
	}
        
        
}
