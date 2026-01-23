<?php
namespace App\Controller;

use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use brain\brain;
use brain\Exception;
use Cake\Routing\Router;
use Cake\Log\Log;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
class PackageController extends AppController
{
	
	
    public function initialize(){
	parent::initialize();
	$this->Auth->allow(['buy']);
    }
    
    /*  ----------------------------------------------------------------------------------  
			    -Purchaing the Packages
      ----------------------------------------------------------------------------------  */
    public function allpackages($package)
    {
	$this->loadModel('Users');
	$this->loadModel('Profile');
	$this->loadModel('Enthicity');
    
	// Recruiter Package
	$this->loadModel('RecuriterPack');
	$RecuriterPack = $this->RecuriterPack->find('all')->where(['RecuriterPack.status'=>'Y'])->order(['RecuriterPack.priorites' => 'ASC'])->toarray();
	$this->set(compact('RecuriterPack'));

	// Requirement Packages 
	$this->loadModel('RequirementPack');
	$RequirementPack = $this->RequirementPack->find('all')->where(['RequirementPack.status'=>'Y'])->order(['RequirementPack.priorites' => 'ASC'])->toarray();
	$this->set('RequirementPack', $RequirementPack);

	// Profile Packages
	$this->loadModel('Profilepack');
	$Profilepack = $this->Profilepack->find('all')->where(['Profilepack.status'=>'Y'])->order(['Profilepack.Visibility_Priority' => 'ASC'])->toarray();
	$this->set(compact('Profilepack'));
	
	if($package=='profilepackage'){
	    $pacakgename="Profile";
	}elseif($package=='requirementpackage'){
	    $pacakgename="Requirement";
	}elseif($package=='recruiterepackage'){
	    $pacakgename="Recruiter";
	}else{
	    $pacakgename="";
	}
	$this->set('package', $package);
	$this->set('pacakgename', $pacakgename);
    }
    
    
    
    /*  ----------------------------------------------------------------------------------  
			    -Job posting payments
      ----------------------------------------------------------------------------------  */
      
    function jobposting($package)
    {
	$hide_free = 0;
	$this->loadModel('Packfeature');
	$this->loadModel('Subscription');
	$user_id = $this->request->session()->read('Auth.User.id');
	$user_role = $this->request->session()->read('Auth.User.role_id');
	$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();
	$status['id'] = $packfeature['id'];
	$status['number_of_job_post'] = $packfeature['number_of_job_post'];
	$status['requirement_package_jobs'] = $packfeature['requirement_package_jobs'];
	if($packfeature['number_of_job_post'] > 0)
	{

	}
	else
	{
	    if($packfeature['requirement_package_jobs'] > 0)
	    {
		$status['status'] = 'RE';
	    }
	    else
	    {
		// check user subscription
		$package_type = 'RC';
		$subscriptions = $this->Subscription->find('all')->where(['Subscription.user_id'=>$user_id,'Subscription.package_type'=>$package_type])->first();
		if($subscriptions['package_id']==RECUITER_PACKAGE || $this->request->params['pass'][1]=='N')
		{
		    $hide_free = 1;
		}
	    }
	}
	// echo $hide_free;die;
	$this->set('hide_free', $hide_free);
	//$id = $this->request->session()->read('Auth.User.id');
	$this->loadModel('State');
	$this->loadModel('City');
	$this->loadModel('Country');
	$this->loadModel('Users');
	$this->loadModel('Profile');
	$this->loadModel('Enthicity');
	$profile = $this->Profile->find('all')->contain(['Users','Enthicity','City','State','Country'])->where(['user_id' => $user_id])->first();
	$this->loadModel('RequirementPack');
	$requirement_packages = $this->RequirementPack->find('all')->where(['RequirementPack.status'=>'Y'])->order(['RequirementPack.priorites' => 'ASC'])->toarray();
	$this->set(compact('requirement_packages'));
    }
    
    // Job Payment while posting job (Requrement Package)
    public function jobpayment()
    {
	$package_id = $this->request->data['package_id'];
	$type = 'RC';
	$this->loadModel('RequirementPack');
	$pcakgeinformation = $this->RequirementPack->find('all')->where(['RequirementPack.status'=>'Y','RequirementPack.id'=>$package_id])->order(['RequirementPack.id' => 'DESC'])->first();
	
	if($this->request->session()->read('eligible.jobpostcredit') > 0)
	{
	    $clone_id = '';
	    $clone_id = $this->request->session()->read('eligible.clone_id');
	    //$this->redirect('/jobpost/jobpost');
	    $eligible['jobpost'] = '1';
	    $eligible['job_validity'] = $pcakgeinformation['number_of_days'];
	    $eligible['job_skills'] = $pcakgeinformation['number_of_talent_type'];
	    $eligible['clone_id'] = $clone_id;

	    $this->request->session()->write('eligible',$eligible);
	    $this->redirect('/jobpost/jobpost/'.$clone_id);
	}

	$this->loadModel('Profile');
	$this->loadModel('Users');
	$this->loadModel('Country');
	$user_id = $this->request->session()->read('Auth.User.id');
	$profile = $this->Profile->find('all')->contain(['Users','Country'])->where(['user_id' => $user_id])->first();
	$this->set('profile', $profile);

	$this->set('package_type', $type);
	$this->set('pcakgeinformation', $pcakgeinformation);
	$this->set('package_id', $package_id);
    }
    
    // Processing Payment while posting job
    public function processrepayment()
    {
	$package_id = $this->request->data['package_id'];
	$package_type = $this->request->data['package_type'];
	$package_price = $this->request->data['package_price'];
    
	$this->loadModel('RequirementPack');
	$pcakgeinformation = $this->RequirementPack->find('all')->where(['RequirementPack.status'=>'Y','RequirementPack.id'=>$package_id])->order(['RequirementPack.id' => 'DESC'])->first();
	$this->set('pcakgeinformation', $pcakgeinformation);
	
	$this->loadModel('Subscription');
	$user_id = $this->request->session()->read('Auth.User.id');
	$subscription_info['package_id'] = $package_id;
	$subscription_info['package_type'] = $package_type;
	$subscription_info['user_id'] =  $user_id;
	$subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
	if($package_price=='0'){
	    $subscription_info['status'] =  'Y';
	}
	
	$transcation_data['payment_method'] = 'Paypal';
	$transcation_data['amount'] = $pcakgeinformation['price'];
	$transcation_data['user_id'] = $user_id;

	$this->loadModel('Transcation');
	$transcation = $this->Transcation->newEntity();
	$transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
	$savetranscation = $this->Transcation->save($transcation_arr);
	$transcation_id = $savetranscation->id;
	$this->confirmrepayment($package_id, $transcation_id);
    }
    
    // Confirm job posting payment. 
    public function confirmrepayment($package_id, $transcation_id)
    {
	// Complete the Transcation
	$this->loadModel('RequirementPack');
	$pcakgeinformation = $this->RequirementPack->find('all')->where(['RequirementPack.status'=>'Y','RequirementPack.id'=>$package_id])->order(['RequirementPack.id' => 'DESC'])->first();
	//pr($pcakgeinformation); die;
	$user_id = $this->request->session()->read('Auth.User.id');
	$ref_id = $this->request->session()->read('Auth.User.ref_by');
	$this->loadModel('Transcation');
	$transcation = $this->Transcation->get($transcation_id);
	
	$transcation_data['status'] = 'Y';
	$transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
	$savetranscation = $this->Transcation->save($transcation_arr);
	
	// Adding Talent admin transcation
	if($ref_id > 0)
	{
	    $this->loadModel('TalentAdmin');
	    $this->loadModel('Talentadmintransc');
	    $checkrefdata = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $ref_id])->first();
	    $commision_per = $checkrefdata['commision'];
	    $total_trans = $transcation['amount'];
	    $commision_amt = ($commision_per/100)*$total_trans;
	    $atranscation = $this->Talentadmintransc->newEntity();
	    $atranscation_data['user_id'] = $user_id;
	    $atranscation_data['talent_admin_id'] = $ref_id;
	    $atranscation_data['amount'] = $commision_amt;
	    $atranscation_data['transcation_amount'] = $total_trans;
	    $package_type_name = 'Requirement';
	    // Package Name
	    $description = "Purchased ".$package_type_name.' Package';
	    $atranscation_data['description'] = $description;
	    $atranscation_arr = $this->Talentadmintransc->patchEntity($atranscation, $atranscation_data);
	    $savetranscation = $this->Talentadmintransc->save($atranscation_arr);
	}
	
	$clone_id = '';
	$clone_id = $this->request->session()->read('eligible.clone_id');
	$eligible['jobpost'] = '1';
	$eligible['clone_id'] = $clone_id;
	$eligible['job_validity'] = $pcakgeinformation['number_of_days'];
	$eligible['job_skills'] = $pcakgeinformation['number_of_talent_type'];
	//pr($eligible);
	$this->request->session()->write('eligible',$eligible);
	$this->redirect('/jobpost/jobpost/'.$clone_id);
	$this->Flash->success(__('You have successfully subscribed for the package!!'));
	//pr($_SESSION); die;
	return $this->redirect('/jobpost/jobpost/'.$clone_id);
    }
    
    
    
    
    /*  ----------------------------------------------------------------------------------  
			  Feature job Payment 
      ----------------------------------------------------------------------------------  */
     public function fjobpayment()
     {
	
	$this->loadModel('Featuredjob');
	$package_id = $this->request->data['fpackage_id'];
	$number_of_days = $this->request->data['number_of_days'];
	$job_id = $this->request->data['job_id'];
	$featuredjob = $this->Featuredjob->find('all')->where(['Featuredjob.status'=>'Y','Featuredjob.id'=>$package_id])->order(['Featuredjob.priorites' => 'ASC'])->first();
	if($featuredjob['validity_days']=='1' && $number_of_days > 0)
	{
	    $package_price = $number_of_days*$featuredjob['price'];
	}
	else
	{
	    $package_price = $featuredjob['price'];
	    $number_of_days = 0;
	}
	
	$this->set('number_of_days', $number_of_days);
	$this->set('package_price', $package_price);
	$this->set('pcakgeinformation', $featuredjob);
	$this->set('job_id', $job_id);
	
	
	$this->loadModel('Profile');
	$this->loadModel('Users');
	$this->loadModel('Country');
	$user_id = $this->request->session()->read('Auth.User.id');
	$profile = $this->Profile->find('all')->contain(['Users','Country'])->where(['user_id' => $user_id])->first();
	$this->set('profile', $profile);
    }
    
    
    // Process Featured Job payment
    function processfjpayment()
    {
	
	$package_id = $this->request->data['fpackage_id'];
	$number_of_days = $this->request->data['number_of_days'];
	$job_id = $this->request->data['job_id'];
	$transcation_data['payment_method'] = 'Paypal';
	$transcation_data['amount'] = $pcakgeinformation['price'];
	$transcation_data['user_id'] = $user_id;
	$transcation_data['number_of_days'] = $number_of_days;
	$transcation_data['job_id'] = $job_id;
	$this->loadModel('Transcation');
	$transcation = $this->Transcation->newEntity();
	$transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
	$savetranscation = $this->Transcation->save($transcation_arr);
	$transcation_id = $savetranscation->id;
	$this->confirmfjpayment($package_id, $transcation_id);
    }
    
    
    // Confirm featured job payment
    public function confirmfjpayment($package_id, $transcation_id)
    {
	// Complete the Transcation
	$this->loadModel('Featuredjob');
	$pcakgeinformation = $this->Featuredjob->find('all')->where(['Featuredjob.status'=>'Y','Featuredjob.id'=>$package_id])->order(['Featuredjob.priorites' => 'ASC'])->first();
	$user_id = $this->request->session()->read('Auth.User.id');
	$ref_id = $this->request->session()->read('Auth.User.ref_by');
	$this->loadModel('Transcation');
	$transcation = $this->Transcation->get($transcation_id);
	
	$transcation_data['status'] = 'Y';
	$transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
	$savetranscation = $this->Transcation->save($transcation_arr);
	
	// Adding Talent admin transcation
	if($ref_id > 0)
	{
	    $this->loadModel('TalentAdmin');
	    $this->loadModel('Talentadmintransc');
	    $checkrefdata = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $ref_id])->first();
	    $commision_per = $checkrefdata['commision'];
	    $total_trans = $transcation['amount'];
	    $commision_amt = ($commision_per/100)*$total_trans;
	    $atranscation = $this->Talentadmintransc->newEntity();
	    $atranscation_data['user_id'] = $user_id;
	    $atranscation_data['talent_admin_id'] = $ref_id;
	    $atranscation_data['amount'] = $commision_amt;
	    $atranscation_data['transcation_amount'] = $total_trans;
	    $package_type_name = 'Featured Job';
	    // Package Name
	    $description = "Purchased ".$package_type_name.' Package';
	    $atranscation_data['description'] = $description;
	    $atranscation_arr = $this->Talentadmintransc->patchEntity($atranscation, $atranscation_data);
	    $savetranscation = $this->Talentadmintransc->save($atranscation_arr);
	}
	
	// Setting job as featured job. 
	$this->loadModel('Requirement');
	$job_id = $transcation['job_id'];
	$number_of_days = $transcation['number_of_days'];
	$currentdate=date('Y-m-d H:m:s');
	$expiredate=date('Y-m-d H:m:s',strtotime($currentdate."+$number_of_days days"));
	$requirement = $this->Requirement->get($job_id);
	$requirement->expiredate = $expiredate;
	$this->Requirement->save($requirement);
	
	$this->redirect('/myrequirement');
	$this->Flash->success(__('Your job has been featured successfully!!'));
	return $this->redirect('/myrequirement');
    }
    

    
    
    public function buy($type,$id)
    {
	if($id==RECUITER_PACKAGE)
	{
	    $clone_id = $this->request->session()->read('eligible.clone_id');
	    $eligible['jobpost'] = '1';
	    $this->request->session()->write('eligible',$eligible);
	    //echo $clone_id;die;
	    if($clone_id > 0)
	    {
		return $this->redirect('/jobpost/jobpost/'.$clone_id);
	    }
	    else
	    {
		return $this->redirect('/jobpost/jobpost');
	    }
	}
	
	$this->loadModel('Profile');
	$this->loadModel('Users');
	$this->loadModel('Country');
	$user_id = $this->request->session()->read('Auth.User.id');
	$profile = $this->Profile->find('all')->contain(['Users','Country'])->where(['user_id' => $user_id])->first();
	$this->set('profile', $profile);
    
	//$users = $this->Users->newEntity();
	/*if ($this->request->is(['post', 'put']))
	{
	//pr($this->request->data); die;
	$name  = $this->request->data['user_name'];
	$email = $this->request->data['email'];
	$phone = $this->request->data['phone'];
	$password = $this->request->data['password'];
	$site_url=SITE_URL;
	$useractivation = $this->request->data['user_activation_key'];
	$this->request->data['password']= $this->_setPassword($this->request->data['password']);
	$this->request->data['confirmpass']= $this->request->data['confirmpassword'];
	$this->request->data['role_id']= NONTALANT_ROLEID ;
	$this->request->data['profilepack_id']= PROFILE_PACKAGE ;
	$department = $this->Users->patchEntity($users, $this->request->data);

	if ($register = $this->Users->save($department))
			*/  
	
	$pcakgeinformation = '';
	if($type=='profilepackage'){
	    $this->loadModel('Profilepack');
	    $pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status'=>'Y','Profilepack.id'=>$id])->order(['Profilepack.id' => 'ASC'])->first();
	}elseif($type=='requirementpackage'){  
	    $this->loadModel('RequirementPack');
	    $pcakgeinformation = $this->RequirementPack->find('all')->where(['RequirementPack.status'=>'Y','RequirementPack.id'=>$id])->order(['RequirementPack.id' => 'DESC'])->first();
	}elseif($type=='recruiterepackage'){
	    $this->loadModel('RecuriterPack');
	    $pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.status'=>'Y','RecuriterPack.id'=>$id])->order(['RecuriterPack.id' => 'DESC'])->first();
	}
	$this->set('package_type', $type);
	$this->set('pcakgeinformation', $pcakgeinformation);
	$this->set('package_id', $id);
    }
    
    
    
    
   
    
    
    
    // Processing Payment for the Package 
    public function processpayment()
    {
	//$session_action = (!empty($_SESSION['session_action']))?$_SESSION['session_action']:'index';
	//$session_controller = (!empty($_SESSION['session_controller']))?$_SESSION['session_controller']:'homes';
	
	//pr($this->request->data);
	$package_id = $this->request->data['package_id'];
	$package_type = $this->request->data['package_type'];
	$package_price = $this->request->data['package_price'];
    
	// echo $package_id;
    
	$pcakgeinformation = '';
	if($package_type=='profilepackage'){
	    $this->loadModel('Profilepack');
	    $pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status'=>'Y','Profilepack.id'=>$package_id])->order(['Profilepack.id' => 'ASC'])->first();
	     $package_type = 'PR';
	}elseif($package_type=='requirementpackage'){
	    $this->loadModel('RequirementPack');
	    $pcakgeinformation = $this->RequirementPack->find('all')->where(['RequirementPack.status'=>'Y','RequirementPack.id'=>$package_id])->order(['RequirementPack.id' => 'DESC'])->first();
	    $package_type = 'RE';
	}elseif($package_type=='recruiterepackage'){
	    $this->loadModel('RecuriterPack');
	    $pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.status'=>'Y','RecuriterPack.id'=>$package_id])->order(['RecuriterPack.id' => 'DESC'])->first();
	    $package_type = 'RC';
	}
	
	//pr($pcakgeinformation);
	$this->set('pcakgeinformation', $pcakgeinformation);
	
	$this->loadModel('Subscription');
	$user_id = $this->request->session()->read('Auth.User.id');
	$subscription_info['package_id'] = $package_id;
	$subscription_info['package_type'] = $package_type;
	$subscription_info['user_id'] =  $user_id;
	$subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
	if($package_price=='0'){
	    $subscription_info['status'] =  'Y';
	}
	
	$package_duration = '1';
	$expiry_date = strtotime('+'.$package_duration.' months',time());
	$subscription_info['expiry_date'] = $expiry_date;
	
	$subscriptions = $this->Subscription->find('all')->where(['Subscription.user_id'=>$user_id,'Subscription.package_type'=>$package_type])->first();
	
	if($subscriptions > 0)
	{
	    $subscription = $this->Subscription->get($subscriptions['id']);
	    $subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
	    $savedata = $this->Subscription->save($subscription_arr);
	    $subscription_id = $savedata->id;
	}
	else
	{
	    $subscription = $this->Subscription->newEntity();
	    $subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
	    $savedata = $this->Subscription->save($subscription_arr);
	    $subscription_id = $savedata->id;
	}
	

	if($package_price=='0'){
	    $this->Flash->success(__('You have successfully subscribed for the package!!'));
	    return $this->redirect(['controller' => $session_controller,'action' => $session_action]);
	}
	else
	{
	    $transcation_data['subscription_id'] = $subscription_id;
	    $transcation_data['payment_method'] = 'Paypal';
	    $transcation_data['amount'] = $package_price;
	    $transcation_data['user_id'] = $user_id;
	
	    $this->loadModel('Transcation');
	    $transcation = $this->Transcation->newEntity();
	    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
	    $savetranscation = $this->Transcation->save($transcation_arr);
	    $transcation_id = $savetranscation->id;
	    
	    $this->confirmpayment($package_id, $package_type,$transcation_id);

	    // pr($pcakgeinformation); 
	    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
	    $paypalID = 'ravi@doomshell.com'; //Business Email
	    $cancel_return = SITE_URL.'storesearch'; //Cancel URL
	    $return = SITE_URL.'storesearch/'.$lasid; //Return URL
	    $notify_url = SITE_URL.'cart/payment_done'; //Notify URL
	    $this->set('paypalURL', $paypalURL);
	    $this->set('paypalID', $paypalID);
	    $this->set('cancel_return', $cancel_return);
	    $this->set('return', $return);
	    $this->set('notify_url', $notify_url);
	    $this->set('paymentaction', 'sale');
	    $package_name = $pcakgeinformation->name;
	    $this->set('package_name', $package_name);
	    $package_id = $pcakgeinformation->id;
	    $this->set('package_id', $package_id);
	    $package_price = $pcakgeinformation->price;
	    $this->set('package_price', $package_price);
	    $user_data = $this->request->session()->read('Auth.User');
	    $this->set('user_data', $user_data);
	}
	
    }
    
    
    public function confirmpayment($package_id, $package_type, $transcation_id)
    {
	
	// Complete the Transcation
	$user_id = $this->request->session()->read('Auth.User.id');
	$ref_id = $this->request->session()->read('Auth.User.ref_by');
	$this->loadModel('Transcation');
	$transcation = $this->Transcation->get($transcation_id);
	
	$transcation_data['status'] = 'Y';
	$transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
	$savetranscation = $this->Transcation->save($transcation_arr);
	
	// Adding Talent admin transcation
	if($ref_id > 0)
	{
	    $this->loadModel('TalentAdmin');
	    $this->loadModel('Talentadmintransc');
	    $checkrefdata = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $ref_id])->first();
	    $commision_per = $checkrefdata['commision'];
	    $total_trans = $transcation['amount'];
	    $commision_amt = ($commision_per/100)*$total_trans;
	    $atranscation = $this->Talentadmintransc->newEntity();
	    $atranscation_data['user_id'] = $user_id;
	    $atranscation_data['talent_admin_id'] = $ref_id;
	    $atranscation_data['amount'] = $commision_amt;
	    $atranscation_data['transcation_amount'] = $total_trans;
	    $package_type_name = '';
	    // Package Name
	    if($package_type=='PR'){
		$package_type_name = 'Profile ';
	    }
	    elseif($package_type=='RC'){
		$package_type_name = 'Recuriter ';
	    }
	    elseif($package_type=='RE')
	    {
		$package_type_name = 'Requirement ';
	    }
	    
	    $description = "Purchased ".$package_type_name.' Package';
	    $atranscation_data['description'] = $description;
	    $atranscation_arr = $this->Talentadmintransc->patchEntity($atranscation, $atranscation_data);
	    $savetranscation = $this->Talentadmintransc->save($atranscation_arr);
	}
	
	$this->loadModel('Packfeature');
	$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();
	$packfeature_id = $packfeature['id'];
	//echo $packfeature_id;die;
	if($package_type=='PR'){

	    $this->loadModel('Profilepack');
	    $pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status'=>'Y','Profilepack.id'=>PROFILE_PACKAGE])->order(['Profilepack.id' => 'ASC'])->first();
	    $feature_info['number_categories'] = $pcakgeinformation['number_categories'];
	    $feature_info['number_audio'] = $pcakgeinformation['number_audio'];
	    $feature_info['number_video'] = $pcakgeinformation['number_video'];
	    $feature_info['website_visibility'] = $pcakgeinformation['website_visibility'];
	    $feature_info['private_individual'] = $pcakgeinformation['private_individual'];
	    $feature_info['access_job'] = $pcakgeinformation['access_job'];
	    $feature_info['number_job_application'] = $pcakgeinformation['number_job_application'];
	    $feature_info['number_search'] = $pcakgeinformation['number_search'];
	    $feature_info['ads_free'] = $pcakgeinformation['ads_free'];
	    $feature_info['number_albums'] = $pcakgeinformation['number_albums'];
	    $feature_info['message_folder'] = $pcakgeinformation['message_folder'];
	    $feature_info['privacy_setting_access'] = $pcakgeinformation['privacy_setting_access'];
	    $feature_info['access_to_ads'] = $pcakgeinformation['access_to_ads'];
	    $feature_info['number_of_jobs_alerts'] = $pcakgeinformation['number_of_jobs_alerts'];
	    $feature_info['number_of_introduction'] = $pcakgeinformation['number_of_introduction'];
	    $feature_info['number_of_intorduction_send'] = $pcakgeinformation['number_of_intorduction_send'];
	    $feature_info['search_of_other_profile'] = $pcakgeinformation['search_of_other_profile'];
	    $feature_info['nubmer_of_jobs_month'] = $pcakgeinformation['nubmer_of_jobs'];
	    $feature_info['introduction_sent'] = $pcakgeinformation['introduction_sent'];
	    $feature_info['profile_likes'] = $pcakgeinformation['profile_likes'];
	    $feature_info['job_alerts_month'] = $pcakgeinformation['job_alerts_month'];
	    $feature_info['job_alerts'] = $pcakgeinformation['job_alerts'];
	    $feature_info['packge'] = $pcakgeinformation['packge'];
	    $feature_info['page_id'] = $pcakgeinformation['page_id'];
	    $feature_info['persanalized_url'] = $pcakgeinformation['persanalized_url'];
	    $feature_info['number_of_free_quote_month'] = $pcakgeinformation['number_of_free_quote_month'];
	    $feature_info['number_of_free_day'] = $pcakgeinformation['number_of_free_day'];
	    $feature_info['number_of_free_job'] = $pcakgeinformation['number_of_free_job'];
	    $feature_info['number_of_booking'] = $pcakgeinformation['number_of_booking'];
	    $feature_info['number_of_introduction_recived'] = $pcakgeinformation['number_of_introduction_recived'];
	    $feature_info['number_of_photo'] = $pcakgeinformation['number_of_photo'];
  
	}elseif($package_type=='RE'){
	    $this->loadModel('RequirementPack');
	    $pcakgeinformation = $this->RequirementPack->find('all')->where(['RequirementPack.status'=>'Y','RequirementPack.id'=>$package_id])->order(['RequirementPack.id' => 'DESC'])->first();
	    $feature_info['requirement_package_jobs'] = '1';
	}elseif($package_type=='RC'){
	    $this->loadModel('RecuriterPack');
	    $pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.status'=>'Y','RecuriterPack.id'=>$package_id])->order(['RecuriterPack.id' => 'DESC'])->first();
	    $feature_info['number_of_job_post'] = $pcakgeinformation['number_of_job_post'];
	    $feature_info['number_of_job_simultancney'] = $pcakgeinformation['number_of_job_simultancney'];
	    $feature_info['nubmer_of_site'] = $pcakgeinformation['nubmer_of_site'];
	    $feature_info['number_of_message'] = $pcakgeinformation['number_of_message'];
	    $feature_info['number_of_contact_details'] = $pcakgeinformation['number_of_contact_details'];
	    $feature_info['number_of_talent_search'] = $pcakgeinformation['number_of_talent_search'];
	    $feature_info['lengthofpackage'] = $pcakgeinformation['lengthofpackage'];
	    $feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging'];
	    $feature_info['number_of_email'] = $pcakgeinformation['number_of_email'];
	    $feature_info['multipal_email_login'] = $pcakgeinformation['multipal_email_login'];
	}
	//pr($feature_info); die;
	$packfeature = $this->Packfeature->get($packfeature_id);
	$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
	$this->Packfeature->save($features_arr);
	
	$session_action = (!empty($_SESSION['session_action']))?$_SESSION['session_action']:'index';
	$session_controller = (!empty($_SESSION['session_controller']))?$_SESSION['session_controller']:'homes';
    
	$this->Flash->success(__('You have successfully subscribed for the package!!'));
	return $this->redirect(['controller' => $session_controller,'action' => $session_action]);
	
	//return true;
    
    }


    public function Pingpay(){

    	$this->loadModel('Transcation');
    	$this->loadModel('JobApplication');
    		$user_id = $this->request->session()->read('Auth.User.id');

    	if ($this->request->is(['post', 'put']))
		{
	$jobid=$this->request->data['job_id'] ;

				//$this->isavaibale($jobid);

				//die;
			
				$transcation = $this->Transcation->newEntity();
				$this->request->data['status'] = 'Y';
				$this->request->data['user_id'] = $user_id;
				$jobid=$this->request->data['job_id'] ;
				
				$transcation_arr = $this->Transcation->patchEntity($transcation, $this->request->data);
				$savetranscation = $this->Transcation->save($transcation_arr);
				if($savetranscation){

			
				$JobApplicationenty = $this->JobApplication->newEntity();
				$Jobapppingdata['user_id']=$this->request->session()->read('Auth.User.id');
				$Jobapppingdata['talent_accepted_status']="Y";
				$Jobapppingdata['ping']="1";
				$Jobapppingdata['job_id']=$jobid;
				$Jobapppingdata['skill_id']=$this->request->data['skill'];
				$Jobapppingdata['cover']=$this->request->data['cover'];
			

				$JobApplicationdata = $this->JobApplication->patchEntity($JobApplicationenty, $Jobapppingdata);
				$savejob = $this->JobApplication->save($JobApplicationdata);
				
				if($savejob){
					$this->Flash->success(__('You have applied job successfully!!'));
				
				return $this->redirect(SITE_URL.'/applyjob/'.$jobid);

				}

				}
			

		}
		
		


    }
    
    
    
  /* public function isavailable($job_id){

    	$this->loadModel('JobApplication');
    	$this->loadModel('Requirement');
    	$user_id = $this->request->session()->read('Auth.User.id');
    	 $apiledjobs = $this->JobApplication->find('all')->contain(['Requirement'])->where(['JobApplication.user_id'=>$user_id])->order(['JobApplication.id' => 'DESC'])->toarray();
    	 

    	 $aplyjob = $this->Requirement->find('all')->where(['Requirement.id'=>$job_id])->order(['Requirement.id' => 'DESC'])->first();

    	 foreach($apiledjobs as $value){
    	 	pr($value);
    	 	pr($aplyjo);

    	 	if($value['talent_required_fromdate']==$aplyjob['talent_required_fromdate']){

    	 	}



    	 }
    	 



    }
    
    */
    
    
}
