<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
class JobadvertpackController extends AppController
{       

 public $paginate = [
 'limit' => 25,
 'order' => [
 'Jobadvertpack.id' => 'asc'
 ]
 ];
 public function initialize(){	
    parent::initialize();
    //$this->loadComponent('Paginator');

}
	// For Banner pack index
public function index($id=null){ 

 $this->loadModel('Jobadvertpack');
 $this->viewBuilder()->layout('admin');
 $currentdate=date('Y-m-d h:i:s', time());
 
 $jobadvert = TableRegistry::get("Jobadvertpack");
 $query = $jobadvert->query();
            $result = $query->update()
                    ->set(['status' => 'N'])
                    ->where(['ad_date_to <'=> $currentdate])
                    ->execute();
 
//  $Profilepack = $this->Jobadvertpack->find('all')->order(['id'=>'asc'])->first();
//  $this->set('Profilepack', $Profilepack);

//  if(isset($id) && !empty($id)){
//         $packentity = $this->Jobadvertpack->get($id);
//     }
//     if ($this->request->is(['post', 'put'])) {

//         $transports = $this->Jobadvertpack->patchEntity($packentity, $this->request->data);
//         if ($resu=$this->Jobadvertpack->save($transports)) {

//             $this->Flash->success(__('Job advertisement price has been changed.'));
//             return $this->redirect(['action' => 'index']);
//         }

//     }
$Profilepack = $this->Jobadvertpack->find('all')->order(['id' => 'asc'])->first();
$this->set('Profilepack', $Profilepack);

// Initialize $packentity with a new entity instance
$packentity = $this->Jobadvertpack->newEntity();

// Assuming $id is defined or passed as a parameter
if (isset($id) && !empty($id)) {
    $packentity = $this->Jobadvertpack->get($id);
}

if ($this->request->is(['post', 'put'])) {
    // Patch the entity with request data
    $packentity = $this->Jobadvertpack->patchEntity($packentity, $this->request->data);
    if ($resu = $this->Jobadvertpack->save($packentity)) {
        $this->Flash->success(__('Job advertisement price has been changed.'));
        return $this->redirect(['action' => 'index']);
    } else {
        // If save operation fails, display error message
        $this->Flash->error(__('Unable to save job advertisement price. Please, try again.'));
    }

}


    $session = $this->request->session(); 
    $session->delete('adjobsearchs');

    $this->set('packentity', $packentity);
    $alladvtpro = $this->Jobadvertpack->find('all')->contain(['Users','Requirement'])->where(['Requirement.status'=>'Y'])->toarray();
    //pr($alladvtpro); die;
 $this->set('alladvtpro', $alladvtpro);
}


public function search(){ 
        $this->loadModel('Users');
        $this->loadModel('Requirement');
        $this->loadModel('Jobadvertpack');
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
            $cond['DATE(Jobadvertpack.created) >=']=date('Y-m-d',strtotime($from_date));
        }
        if(!empty($to_date))
        { 
            $cond['DATE(Jobadvertpack.created) <=']=date('Y-m-d',strtotime($to_date));
        }
        
        if(!empty($status))
        {
           $cond['Jobadvertpack.status'] = $status;
        }
        
        //pr($cond); die;
        $this->request->session()->write('adjobsearchs',$cond);
       

        $alladvtpro = $this->Jobadvertpack->find('all')->contain(['Users','Requirement'])->where([$cond,'Requirement.status'=>'Y'])->toarray();
        $this->set('alladvtpro', $alladvtpro);
     }

    public function advrtjobexcel(){

        $currentdate=date('Y-m-d H:m:s');
        $this->loadModel('Users');
        $this->loadModel('Jobadvertpack');
        $this->loadModel('Requirement');
        $this->autoRender=false;
        $userid = $this->request->session()->read('Auth.User.id');
        $blank="NA";
        $output="";
    
        $output .= '"Sr Number",';
        $output .= '"Job Title",';
        $output .= '"User Name",';
        $output .= '"User Email Id",';
        $output .= '"Ad Date From",';
        $output .= '"Ad Date To",';
        $output .= '"Number of Days",';
        $output .= '"Total Price Paid",';
        $output .= '"Status",';
        $output .="\n";
        //pr($job); die;
        $str="";
        
        $cond = $this->request->session()->read('adjobsearchs');
        

         $banners = $this->Jobadvertpack->find('all')->contain(['Users','Requirement'])->where([$cond,'Requirement.status'=>'Y'])->toarray(); 
        //pr($talents); die;
        $cnt=1; 
        foreach($banners as $admin)
        { 
            $currentdate=date('Y-m-d H:m:s');
            $todates= date('Y-m-d H:m:s',strtotime($admin['ad_date_to'])); 

            $fromdate= date('Y-m-d',strtotime($admin['ad_date_from'])); 
            $todate= date('Y-m-d',strtotime($admin['ad_date_to'])); 
            $date1 = date_create($fromdate);
            $date2 = date_create($todate);
            $diff = date_diff($date1,$date2);
            $bannerdays=$diff->days;

            $output .=$cnt.",";
            $output.=$admin['requirement']['title'].",";
            $output.=$admin['user']['user_name'].",";
            $output.=$admin['user']['email'].",";
            if ($admin['ad_date_from']) {
                $output.=$fromdate.",";
            }else{
                $output.="NA,"; 
            }

            if ($admin['ad_date_to']) {
                $output.=$todate.",";
            }else{
                $output.="NA,"; 
            }

            $output.=$bannerdays."days ,";       
            $output.="$".$admin['req_ad_total'].",";     
                    
            if($todates>=$currentdate){ 
                $output.="Ad Active,";
            }else{ 
                $output.="Ad Inactive,"; 
            }

            $cnt++;
            $output .="\r\n";
         }

        $filename = "Advertise-Job.csv";
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename='.$filename);
        echo $output;
        die;
        $this->redirect($this->referer());
    }
    
    public function status($id,$status){ 
	
            $this->loadModel('Jobadvertpack');
            if(isset($id) && !empty($id)){
                    $status = 'N';
                    $talent = $this->Jobadvertpack->get($id);
                    $talent->status = $status;
                    if ($this->Jobadvertpack->save($talent)) {
                    $this->Flash->success(__('Jobadvertpack status has been updated.'));
                    return $this->redirect(['action' => 'index']);	
                }


                
            }
        }


}
?>