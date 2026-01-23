<?php

namespace App\Controller;
use App\Controller;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\PaginatorHelper;
use Cake\Routing\Router;

class SearchController extends AppController
{
	
	public function initialize()
	{
         parent::initialize();
       	$this->loadModel('Users');
        $this->Auth->allow(['_setPassword
        	','signup','findUsername','login','logout','verify','getphonecode','forgotpassword','forgetCpass','sociallogin','jobrefine','']);
        
    }
    	

  public function index_ajax() {
    $this->Carroceria->recursive = 0;
    $this->layout = 'ajax';
    $conditions = $this->BuildConditions->buildConditions($this->modelClass);
    $this->set('carrocerias', $this->paginate(null, $conditions));
}	
    	
public function search(){
//Here we are writing advance parameter in to session 
	if($this->request->query['refine']!=1){
	$session = $this->request->session();
	    $session->write('advancejobsearch', $this->request->query);
	}
		$savejobarray=array();
		$this->loadModel('Profile');
		$this->loadModel('jrement');
		$this->loadModel('Savejobs');
		$this->loadModel('Likejobs');
		$this->loadModel('Blockjobs');
		$this->loadModel('JobApplication');
		$this->loadModel('RequirmentVacancy');
		$this->loadModel('JobQuote');
		$this->loadModel('Settings');
		$this->loadModel('Packfeature');
/*  Not For Searching */
	$id = $this->request->session()->read('Auth.User.id');
	$packlimit=$this->Packfeature->find('all')->where(['Packfeature.user_id'=>$this->request->session()->read('Auth.User.id')])->first();
	$numberofaskquoteperjob = $packlimit['ask_for_quote_request_per_job'];
	$this->set('numberofaskquoteperjob', $numberofaskquoteperjob);
	$user_id=$this->request->session()->read('Auth.User.id');
	$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();
	$this->set('month',$packfeature['number_job_application_month']);
	$this->set('daily',$packfeature['number_job_application_daily']);
	$this->set('quote',$packfeature['number_of_quote_daily']);

	$this->loadModel('Requirement');
	$this->loadModel('JobQuote');
	$currentdate=date('Y-m-d H:m:s');
	$activejobs = $this->Requirement->find('all')->contain(['RequirmentVacancy'=>['Skill','Currency']])->where(['user_id' =>$id,'Requirement.last_date_app >='=>$currentdate])->toarray();
	//pr($activejobs);
	$this->set('activejobs', $activejobs);

	$askquote = $this->JobQuote->find('all')->where(['user_id' =>$userid])->toarray();
	$this->set('askquote', $askquote);
	$setting=$this->Settings->find('all')->first();
	$this->set('ping_amt',$setting['ping_amt']);
	$userid = $this->request->session()->read('Auth.User.id');
	$bookjob = $this->JobApplication->find('all')->where(['user_id' =>$userid])->toarray();
	$this->set('alliedjobs',$bookjob);
	$user_id = $this->request->session()->read('Auth.User.id');
	$Savejobsdata = $this->Savejobs->find('all')->where(['Savejobs.user_id'=>$user_id])->order(['Savejobs.id' => 'ASC'])->toarray();
	$likejobsdata = $this->Likejobs->find('all')->where(['Likejobs.user_id'=>$user_id])->order(['Likejobs.id' => 'ASC'])->toarray();

	$Blockjobsdata = $this->Blockjobs->find('all')->where(['Blockjobs.user_id'=>$user_id])->order(['Blockjobs.id' => 'ASC'])->toarray();

/*  Not For Searching */
	// advance search parameters


if($this->request->query['latitude']){
$loc_lat=$this->request->query['latitude'];
}else{
$loc_lat="";
}

if($this->request->query['longitude']){
	$loc_long=$this->request->query['longitude'];

}else{
	$loc_long="";
	
}
if($this->request->query['unit']="km"){
	$kmmile="3956";

}else{
	$kmmile="6371";
	
}	

	$salary=explode("-",$this->request->query['salaryrange']);

		$min=$salary['0'];
		if($min){
		$min=$min;
		}else{
		$min=0;
		}

		$max=$salary['1'];
		if($max){
		$max=$max;
		}else{
		$max=50000;
		}
// Session 





		$date=date('Y-m-d H:i:s');
		$user_id=$this->request->session()->read('Auth.User.id');

		 $query="SELECT  requirement_vacancy.telent_type ,requirement_vacancy.payment_currency,requirement_vacancy.payment_amount, requirement.location,requirement.talent_requirement_description,requirement_vacancy.sex as sex,users.	user_name , users.role_id,eventtypes.name as eventname, requirement.id, requirement.user_id,requirement.last_date_app,requirement.event_type,currencys.name as currencysname,payment_fequency.name as payment_feqname,skill_type.name as skillname,requirement.image as image,requirement.title as title,currencys.id as currencyid, 1.609344 * '".$kmmile."' * acos( cos( radians('".$loc_lat."') ) * cos( radians(requirement.latitude) ) * cos( radians(requirement.longitude) - radians('".$loc_long."') ) + sin( radians('".$loc_lat."') ) * sin( radians(requirement.latitude) ) ) AS cdistance,payment_fequency.id as pfqid,skill_type.id as skillid, (SELECT subscriptions.package_id FROM subscriptions
		WHERE subscriptions.package_type='PR' and subscriptions.user_id=requirement.user_id) as p_package, (Select subscriptions.package_id  FROM subscriptions
		WHERE subscriptions.package_type='RC' and subscriptions.user_id=requirement.user_id) as r_package, (SELECT visibility_matrix.ordernumber FROM `visibility_matrix` where visibility_matrix.profilepack_id=p_package and visibility_matrix.recruiter_id=r_package) as order_num   FROM  `requirement` LEFT JOIN requirement_vacancy ON requirement.id = requirement_vacancy.requirement_id  LEFT JOIN skill_type ON requirement_vacancy.telent_type = skill_type.id LEFT JOIN currencys ON requirement_vacancy.payment_currency = currencys.id LEFT JOIN payment_fequency ON requirement_vacancy.payment_freq = payment_fequency.id LEFT JOIN users ON requirement.user_id = users.id LEFT JOIN eventtypes ON eventtypes.id = requirement.event_type where $skillcheck $lastdatecon ( requirement_vacancy.payment_amount>='$min' and requirement_vacancy.payment_amount <= '$max' and requirement.user_id !='$user_id') "; 

	if(!empty($this->request->query['name']) && empty($this->request->query['refine']) && empty($this->request->query['form']) ){

	  $title=$this->request->query['name'];
		$query.=" And (`title` Like '%$title%' or talent_requirement_description Like '%$title%' or location Like '%$title%' or skill_type.name Like '%$title%')";
	}
	// Refine Parametes
	if($this->request->query['refine']==1){ 


		   if(!empty($this->request->query['keyword'])){
	$title=$this->request->query['keyword'];
	$query.=" And ( requirement.title Like '%$title%'  or talent_requirement_description Like '%$title%'  or skill_type.name Like '%$title%' ) ";
	
	 
	}

if(!empty($this->request->query['currency']) && $this->request->query['currency']!=0){
	$currencyarray=$this->request->query['currency'];

			 $count=count($this->request->query['currency']);
			
			for($i=0;$i<count($this->request->query['currency']);$i++){

				if($i==0){
					//$currency=$this->request->query['currency'][$i];
					$currency.="'".$this->request->query['currency'][$i]."'";
				}else{
					$currency.=" OR requirement_vacancy.payment_currency='".$this->request->query['currency'][$i]."'";
				}
			}

			$query.="and (requirement_vacancy.payment_currency=$currency)";
			$this->set('currencyarrayset',$currencyarray);
}

	if(!empty($this->request->query['payment']) && $this->request->query['payment']!=0){
			$paymentselectedarray=$this->request->query['payment'];
			//print_r($paymentselectedarray);
		 $count=count($this->request->query['payment']);

			for($i=0;$i<count($this->request->query['payment']);$i++){

				if($i==0){
					//$currency=$this->request->query['currency'][$i];
					$payment="'".$this->request->query['payment'][$i]."'";
				}else{
		$payment.=" OR requirement_vacancy.payment_freq= '".$this->request->query['payment'][$i]."'";
				}
			}
			//$payment=$this->request->query['payment'];
			$query.="And (requirement_vacancy.payment_freq=$payment) ";
			$this->set('paymentselarray',$paymentselectedarray);
			//echo $payment; 
	}

		if(!empty($this->request->query['location'])){
		 $count=count($this->request->query['location']);
			for($i=0;$i<count($this->request->query['location']);$i++){

				if($i==0){
					//$currency=$this->request->query['currency'][$i];
					$location="'%".$this->request->query['location'][$i]."%'";
				}else{
		$location.=" OR requirement.location Like '%".$this->request->query['location'][$i]." % '";
				}
			}

			//$loc=$this->request->query['location'];
			//$this->set('loc',$loc);
			$query.=" And (requirement.location like $location ) ";
	}

		if(!empty($this->request->query['time'])){

		
			$time=$this->request->query['time'];
			$query.=" And (requirement.continuejob='$time' )";

		}

		if(!empty($this->request->query['eventtype'])){
$eventtypearr=$this->request->query['eventtype'];
	for($i=0;$i<count($this->request->query['eventtype']);$i++){

				if($i==0){
					//$currency=$this->request->query['currency'][$i];
					
					$eventtype="'".$this->request->query['eventtype'][$i]."'";
				}else{
				
					$eventtype.=" OR requirement.event_type='".$this->request->query['eventtype'][$i]."'";
				}
			}
	
$this->set('eventtypearray',$eventtypearr);
			//$eventtype=$this->request->query['eventtype'];
		    $query.=" And (requirement.event_type=$eventtype )"; 
	}

		if(!empty($this->request->query['telenttype']) && $this->request->query['telenttype']!=0){

				// echo $count=count($this->request->query['telenttype']);
		$telenttyp=$this->request->query['telenttype'];
			for($i=0;$i<count($this->request->query['telenttype']);$i++){

				if($i==0){
					//$currency=$this->request->query['currency'][$i];
					$telenttype="'".$this->request->query['telenttype'][$i]."'";
				}else{
				
					$telenttype.=" OR (requirement_vacancy.telent_type='".$this->request->query['telenttype'][$i]."')";
				}
			}
			//echo $telenttype; die;
			
			$this->set('ttype',$telenttyp);
		    $query.=" And (requirement_vacancy.telent_type=$telenttype )";
	}

}
// Refine End


//Advance Job Search start

if($this->request->query['from']==1){

   

   if(!empty($this->request->query['keyword'])){
	$title=$this->request->query['keyword'];
	$query.=" And ( requirement.title Like '%$title%'  or talent_requirement_description Like '%$title%'  or skill_type.name Like '%$title%' ) ";
	
	 
	}

	if($this->request->query['skill']){
	$skill=$this->request->query['skill'];
		$skillarray=explode(",",$skill);
			//print_r($skillarray);  die;
			
			for($i=0;$i<count($skillarray);$i++){
				//$skillvalue=$skillarray[$i];
				
				if(count($skillarray)==1){
				 $skillcheck.="requirement_vacancy.telent_type like '$skillarray[$i]'";
				}
				elseif($i==0){
			$skillcheck.="requirement_vacancy.telent_type like '$skillarray[$i]'";
			    }else if($i==count($skillarray)-1){
			    $skillcheck.=" or requirement_vacancy.telent_type like '$skillarray[$i]'";
			    }else{
			     $skillcheck.=" or requirement_vacancy.telent_type like '$skillarray[$i]'";
			    }
			    
			}
			

		$query.="and (".$skillcheck.")";
	}else{
		$skillcheck="";
	}


	if(!empty($this->request->query['gender'])) {
		//echo "Test";
	//	$this->dd($this->request->query);
		if(in_array( "a",$this->request->query['gender'])){

		}else{
			//$telenttyp=$this->request->query['gender'];
			for($i=0;$i<count($this->request->query['gender']);$i++){

				if($i==0){
				//$currency=$this->request->query['currency'][$i];
					$sex="'".$this->request->query['gender'][$i]."'";
				}else{

					$sex.=" OR requirement_vacancy.sex='".$this->request->query['gender'][$i]."'";
				}
			}
				$query.=" And (requirement_vacancy.sex=$sex )";
		}
	
		
		
	}

	if(!empty($this->request->query['Paymentfequency'])){
		$paymentselectedarray=$this->request->query['Paymentfequency'];
		$count=count($this->request->query['Paymentfequency']);

			for($i=0;$i<count($this->request->query['Paymentfequency']);$i++){

				if($i==0){
					//$currency=$this->request->query['currency'][$i];
					$Paymentfequency="'".$this->request->query['Paymentfequency'][$i]."'";
				}else{
		$Paymentfequency.=" OR requirement_vacancy.payment_freq= '".$this->request->query['Paymentfequency'][$i]."'";
				}
			}
			
			$query.="And (requirement_vacancy.payment_freq=$Paymentfequency)";
	}


	if(!empty($this->request->query['eventtype'])){

			$eventtypearr=$this->request->query['eventtype'];
			$newarray=explode(",",$this->request->query['eventtype']);
			for($i=0;$i<count($newarray);$i++){

				if($i==0){
				//$currency=$this->request->query['currency'][$i];
				$eventtype="'".$newarray[$i]."'";
				}else{

				$eventtype.=" OR requirement.event_type='".$newarray[$i]."'";
				}
			}

			$this->set('eventtypearray',$eventtypearr);
			//$eventtype=$this->request->query['eventtype'];
			$query.=" And (requirement.event_type=$eventtype )"; 
	}

	if(!empty($this->request->query['country_id'])){

		
			$country_id=$this->request->query['country_id'];
			$query.=" And (requirement.country_id='$country_id')";

	}
	if(!empty($this->request->query['state_id'])){

		
			$state_id=$this->request->query['state_id'];
			$query.=" And (requirement.state_id='$state_id')";

	}
	if(!empty($this->request->query['city_id'][0]) && $this->request->query['city_id']!=0){


	for($i=0;$i<count($this->request->query['city_id']);$i++){

				if($i==0){
					//$currency=$this->request->query['currency'][$i];
					$city_id="'".$this->request->query['city_id'][$i]."'";
				}else{
				
					$city_id.=" OR requirement.city_id='".$this->request->query['city_id'][$i]."'";
				}
			}
	


		 $query.=" And (requirement.city_id=$city_id)"; 

	}
	pr($this->request->query);

	if(!empty($this->request->query['latitude']) && $this->request->query['longitude']){
	if($this->request->query['unit']=="" && $this->request->query['within']=="") {
			$lat=$this->request->query['latitude'];
			$log=$this->request->query['longitude'];
			$query.=" And (requirement.latitude='$lat' And requirement.longitude='$log')";
		}

	}

	if($this->request->query['unit']!='' && $this->request->query['within']!='') {

	$within=$this->request->query['within'];
	$have.="having cdistance <= '$within'";

	}

	if( !empty($this->request->query['role_id']) ){
		
			$role=$this->request->query['role_id'];
			if($this->request->query['role_id']!=0){
				$query.=" And( users.role_id='$role')";
			}
			
			

	}
	

	if( !empty($this->request->query['recname']) ){
		
			$recname=$this->request->query['recname'];
			 $query.=" And( users.user_name LIKE'%$recname%')";
		
			

	}


	if( !empty($this->request->query['time']) ){
		
			$recname=$this->request->query['time'];
			 $query.=" And( requirement.continuejob='$recname')";
		
			

	}

	if( !empty($this->request->query['event_from_date']) && empty($this->request->query['event_to_date'])  ){
		
			 $event_from_date=date("Y-m-d H:s:i",strtotime($this->request->query['event_from_date']));
			 $query.=" And (requirement.event_from_date='$event_from_date')";
		
			

	}


	if( !empty($this->request->query['event_to_date']) && empty($this->request->query['event_from_date']) ){
		
			$event_to_date=date("Y-m-d H:s:i",strtotime($this->request->query['event_to_date']));
			 $query.=" And (requirement.event_to_date='$event_to_date')";
		
			

	}


		if( !empty($this->request->query['event_to_date']) && !empty($this->request->query['event_from_date']) ){
		
			$event_to_date=date("Y-m-d H:s:i",strtotime($this->request->query['event_to_date']));
			$event_from_date=date("Y-m-d H:s:i",strtotime($this->request->query['event_from_date']));
			 $query.=" And (requirement.event_from_date>='$event_from_date' And requirement.event_to_date<='$event_to_date') ";
		
			

	}


	if( !empty($this->request->query['talent_required_fromdate']) && empty($this->request->query['talent_required_todate']) ){
		
			$talent_required_fromdate=date("Y-m-d H:s:i",strtotime($this->request->query['talent_required_fromdate']));
			 $query.=" And (requirement.talent_required_fromdate='$talent_required_fromdate')";
		
			

	}


	if( !empty($this->request->query['talent_required_todate']) && empty($this->request->query['talent_required_fromdate']) ){

		
			$talent_required_todate=date( "Y-m-d H:s:i",strtotime($this->request->query['talent_required_todate'] ));
			 $query.=" And (requirement.talent_required_todate='$talent_required_todate')";
		
			

	}


	if( !empty($this->request->query['talent_required_todate']) && !empty($this->request->query['talent_required_fromdate']) ){
		
		$talent_required_todate=date( "Y-m-d H:s:i",strtotime($this->request->query['talent_required_todate'] ));
		$talent_required_fromdate=date("Y-m-d H:s:i",strtotime($this->request->query['talent_required_fromdate']));

			 $query.=" And (requirement.talent_required_fromdate>='$talent_required_fromdate' And requirement.talent_required_todate<='$talent_required_todate' )";
		
			

	}


		if($this->request->query['checkboxafter']==1 && $this->request->query['checkboxbefore']!=2) {

	if( !empty($this->request->query['last_date_app']) ){
	
			 $last_date_app=date("Y-m-d H:s:i",strtotime($this->request->query['last_date_app']));
			 $query.="And (requirement.last_date_app>='$last_date_app')";
		
			

	}
 }

if($this->request->query['checkboxbefore']==2 && $this->request->query['checkboxafter']!=1) {

	if( !empty($this->request->query['last_date_appbefore']) ){
		
			 $last_date_app=date("Y-m-d H:s:i",strtotime($this->request->query['last_date_appbefore']));
			 $query.="(requirement.last_date_app<='$last_date_app')";

			

	}
		

}

	
if($this->request->query['checkboxbefore']){
	if($this->request->query['checkboxafter']){
		 $last_date_app=date("Y-m-d H:s:i",strtotime($this->request->query['last_date_app']));
		 $last_date_appbefore=date("Y-m-d H:s:i",strtotime($this->request->query['last_date_appbefore']));

		$query.="And (requirement.last_date_app>='$date' and  requirement.last_date_app<='$last_date_appbefore' )";
}}

	}	





// Advance Job Search End


	// Advance Search Plus Refine

	if($_SESSION['advancejobsearch'] && $this->request->query['refine']==1){


if($_SESSION['advancejobsearch']['skill']){
	$skill=$_SESSION['advancejobsearch']['skill'];
		$skillarray=explode(",",$skill);
			//print_r($skillarray);  die;
			
			for($i=0;$i<count($skillarray);$i++){
				//$skillvalue=$skillarray[$i];
				
				if(count($skillarray)==1){
				 $skillcheck.="requirement_vacancy.telent_type like '$skillarray[$i]'";
				}
				elseif($i==0){
			$skillcheck.="requirement_vacancy.telent_type like '$skillarray[$i]'";
			    }else if($i==count($skillarray)-1){
			    $skillcheck.=" or requirement_vacancy.telent_type like '$skillarray[$i]'";
			    }else{
			     $skillcheck.=" or requirement_vacancy.telent_type like '$skillarray[$i]'";
			    }
			    
			}
			

		$query.="and (".$skillcheck.")";
	}else{
		$skillcheck="";
	}

  if(!empty($_SESSION['advancejobsearch']['keyword'])){
	$title=$_SESSION['advancejobsearch']['keyword'];
	$query.=" And ( requirement.title Like '%$title%'  or talent_requirement_description Like '%$title%'  or skill_type.name Like '%$title%' ) ";
	
	 
	}


	if(!empty($_SESSION['advancejobsearch']['gender'])) {
		//echo "Test";
	//	$this->dd($this->request->query);
		if(in_array( "a",$_SESSION['advancejobsearch']['gender'])){

		}else{
			//$telenttyp=$this->request->query['gender'];
	
			for($i=0;$i<count($_SESSION['advancejobsearch']['gender']);$i++){ 

				if($i==0){
				//$currency=$this->request->query['currency'][$i];

					 $sex="'".$_SESSION['advancejobsearch']['gender'][$i]."'";
				}else{

					 $sex.=" OR requirement_vacancy.sex='".$_SESSION['advancejobsearch']['gender'][$i]."'";
				}
			}
			
				$query.=" And (requirement_vacancy.sex=$sex )";
		}
	
		
		
	}
	//echo $query; 

	if(!empty($_SESSION['advancejobsearch']['Paymentfequency'])){
		$paymentselectedarray=$_SESSION['advancejobsearch']['Paymentfequency'];
		$count=count($_SESSION['advancejobsearch']['Paymentfequency']);

			for($i=0;$i<count($_SESSION['advancejobsearch']['Paymentfequency']);$i++){

				if($i==0){
					//$currency=$this->request->query['currency'][$i];
					$Paymentfequency="'".$_SESSION['advancejobsearch']['Paymentfequency'][$i]."'";
				}else{
		$Paymentfequency.=" OR requirement_vacancy.payment_freq= '".$_SESSION['advancejobsearch']['Paymentfequency'][$i]."'";
				}
			}
			
			$query.="And (requirement_vacancy.payment_freq=$Paymentfequency)";
	}


if(!empty($_SESSION['advancejobsearch']['eventtype'])){

			$eventtypearr=$_SESSION['advancejobsearch']['eventtype'];
			$newarray=explode(",",$_SESSION['advancejobsearch']['eventtype']);
			for($i=0;$i<count($newarray);$i++){

				if($i==0){
				//$currency=$this->request->query['currency'][$i];
				$eventtype="'".$newarray[$i]."'";
				}else{

				$eventtype.=" OR requirement.event_type='".$newarray[$i]."'";
				}
			}

			$this->set('eventtypearray',$eventtypearr);
			//$eventtype=$this->request->query['eventtype'];
			$query.=" And (requirement.event_type=$eventtype )"; 
	}

	if(!empty($_SESSION['advancejobsearch']['country_id'])){

		
			$country_id=$_SESSION['advancejobsearch']['country_id'];
			$query.=" And (requirement.country_id='$country_id')";

	}
	if(!empty($_SESSION['advancejobsearch']['state_id'])){

		
			$state_id=$_SESSION['advancejobsearch']['state_id'];
			$query.=" And (requirement.state_id='$state_id')";

	}

	if(!empty($_SESSION['advancejobsearch']['city_id'][0]) && $_SESSION['advancejobsearch']['city_id']!=0){


	for($i=0;$i<count($_SESSION['advancejobsearch']['city_id']);$i++){

				if($i==0){
					//$currency=$_SESSION['advancejobsearch']['currency'][$i];
					$city_id="'".$_SESSION['advancejobsearch']['city_id'][$i]."'";
				}else{
				
					$city_id.=" OR requirement.city_id='".$_SESSION['advancejobsearch']['city_id'][$i]."'";
				}
			}
	


		 $query.=" And (requirement.city_id=$city_id)"; 

	}

	if(!empty($_SESSION['advancejobsearch']['latitude']) && $_SESSION['advancejobsearch']['longitude']){
	
			$lat=$_SESSION['advancejobsearch']['latitude'];
			$log=$_SESSION['advancejobsearch']['longitude'];
			$query.=" And (requirement.latitude='$lat' And requirement.longitude='$log')";

	}

	if($_SESSION['advancejobsearch']['unit']!='' && $_SESSION['advancejobsearch']['within']!='') {

	$within=$_SESSION['advancejobsearch']['within'];
	$have.="having cdistance <= '$within'";

	}

		if( !empty($_SESSION['advancejobsearch']['role_id']) ){
		
			$role=$_SESSION['advancejobsearch']['role_id'];
			if($_SESSION['advancejobsearch']['role_id']!=0){
				$query.=" And( users.role_id='$role')";
			}
			
			

	}
	

	if( !empty($_SESSION['advancejobsearch']['recname']) ){
		
			$recname=$_SESSION['advancejobsearch']['recname'];
			 $query.=" And( users.user_name LIKE'%$recname%')";
		
			

	}


	if( !empty($_SESSION['advancejobsearch']['time']) ){
		
			$recname=$_SESSION['advancejobsearch']['time'];
			 $query.=" And( requirement.continuejob='$recname')";
		
			

	}


		if( !empty($_SESSION['advancejobsearch']['event_from_date']) && empty($_SESSION['advancejobsearch']['event_to_date'])  ){
		
			 $event_from_date=date("Y-m-d H:s:i",strtotime($_SESSION['advancejobsearch']['event_from_date']));
			 $query.=" And (requirement.event_from_date='$event_from_date')";
		
			

	}


	if( !empty($_SESSION['advancejobsearch']['event_to_date']) && empty($_SESSION['advancejobsearch']['event_from_date']) ){
		
			$event_to_date=date("Y-m-d H:s:i",strtotime($_SESSION['advancejobsearch']['event_to_date']));
			 $query.=" And (requirement.event_to_date='$event_to_date')";
		
			

	}


		if( !empty($_SESSION['advancejobsearch']['event_to_date']) && !empty($_SESSION['advancejobsearch']['event_from_date']) ){
		
			$event_to_date=date("Y-m-d H:s:i",strtotime($_SESSION['advancejobsearch']['event_to_date']));
			$event_from_date=date("Y-m-d H:s:i",strtotime($_SESSION['advancejobsearch']['event_from_date']));
			 $query.=" And (requirement.event_from_date>='$event_from_date' And requirement.event_to_date<='$event_to_date') ";
		
			

	}


	if( !empty($_SESSION['advancejobsearch']['talent_required_fromdate']) && empty($_SESSION['advancejobsearch']['talent_required_todate']) ){
		
			$talent_required_fromdate=date("Y-m-d H:s:i",strtotime($_SESSION['advancejobsearch']['talent_required_fromdate']));
			 $query.=" And (requirement.talent_required_fromdate='$talent_required_fromdate')";
		
			

	}


	if( !empty($_SESSION['advancejobsearch']['talent_required_todate']) && empty($_SESSION['advancejobsearch']['talent_required_fromdate']) ){

		
			$talent_required_todate=date( "Y-m-d H:s:i",strtotime($_SESSION['advancejobsearch']['talent_required_todate'] ));
			 $query.=" And (requirement.talent_required_todate='$talent_required_todate')";
		
			

	}


	if( !empty($_SESSION['advancejobsearch']['talent_required_todate']) && !empty($_SESSION['advancejobsearch']['talent_required_fromdate']) ){
		
		$talent_required_todate=date( "Y-m-d H:s:i",strtotime($_SESSION['advancejobsearch']['talent_required_todate'] ));
		$talent_required_fromdate=date("Y-m-d H:s:i",strtotime($_SESSION['advancejobsearch']['talent_required_fromdate']));

			 $query.=" And (requirement.talent_required_fromdate>='$talent_required_fromdate' And requirement.talent_required_todate<='$talent_required_todate' )";
		
			

	}


		if($_SESSION['advancejobsearch']['checkboxafter']==1 && $_SESSION['advancejobsearch']['checkboxbefore']!=2) {

	if( !empty($_SESSION['advancejobsearch']['last_date_app']) ){
	
			 $last_date_app=date("Y-m-d H:s:i",strtotime($_SESSION['advancejobsearch']['last_date_app']));
			 $query.="And (requirement.last_date_app>='$last_date_app')";
		
			

	}
 }

if($_SESSION['advancejobsearch']['checkboxbefore']==2 && $_SESSION['advancejobsearch']['checkboxafter']!=1) {

	if( !empty($_SESSION['advancejobsearch']['last_date_appbefore']) ){
		
			 $last_date_app=date("Y-m-d H:s:i",strtotime($_SESSION['advancejobsearch']['last_date_appbefore']));
			 $query.="(requirement.last_date_app<='$last_date_app')";

			

	}
		

}

	
if($_SESSION['advancejobsearch']['checkboxbefore']){
	if($_SESSION['advancejobsearch']['checkboxafter']){
		 $last_date_app=date("Y-m-d H:s:i",strtotime($_SESSION['advancejobsearch']['last_date_app']));
		 $last_date_appbefore=date("Y-m-d H:s:i",strtotime($_SESSION['advancejobsearch']['last_date_appbefore']));

		$query.="And (requirement.last_date_app>='$date' and  requirement.last_date_app<='$last_date_appbefore' )";
}}


	}



	//Advance Search Plus Refine End







//end 	
	echo $query.="Group by requirement.id ".$have."order by order_num, requirement.user_id asc";   
  
if($this->request->query['refine']==1){

$session = $this->request->session();
$session->delete('Refinejobfilter');
$this->request->session()->write('Refinejobfilter',$query);
}else if($this->request->query['from']==1){
$session = $this->request->session();
$session->delete('Refinejobfilter');
$this->request->session()->write('Refinejobfilter',$query);
}else if(!empty($this->request->query['name'])){
$session = $this->request->session();
$session->delete('Refinejobfilter');
$this->request->session()->write('Refinejobfilter',$query);
}

// End Advance job search parameters  

//$query.="order by order_num, requirement.user_id asc"; 
$con = ConnectionManager::get('default');
$searchdata = $con->execute($query)->fetchAll('assoc');


$this->set('searchdata', $searchdata);

$currencyarray=array();
$payemntfaq=array();
$talentype=array();
$eventtype=array();
foreach($searchdata as $value){


if($date<$value['last_date_app']) {

$skill=$this->RequirmentVacancy->find('all')->contain(['Skill','Paymentfequency','Currency'])->where(['RequirmentVacancy.requirement_id' => $value['id']])->toArray();

foreach($skill as $myvalue ){
//pr($myvalue);
$talentype[$myvalue['skill']['id']]=$myvalue['skill']['name'];
}

foreach($skill as $myvalue ){
//pr($myvalue);
$payemntfaq[$myvalue['paymentfequency']['id']]=$myvalue['paymentfequency']['name'];
}

foreach($skill as $myvalue ){
//pr($myvalue);
$currencyarray[$myvalue['currency']['id']]=$myvalue['currency']['name'];
}

$eventtype[$value['event_type']]=$value['eventname'];







$locationarray[$value['location']]=$value['location'];



}

}


$this->set('title', $title);
$this->set('maxi', $max);
$this->set('mini', $min);
$this->set('location',$locationarray);
$this->set('currencyarray', $currencyarray);
$this->set('payemntfaq', $payemntfaq);
$this->set('talentype', $talentype);
$this->set('time', $this->request->query['time']);
$this->set('eventtype', array_unique($eventtype));

 
}
public function advanceJobsearch($edit){

	 $this->loadModel('Country');
	 $this->loadModel('Paymentfequency');
	 $this->loadModel('Eventtype');
	 $this->loadModel('City');
	 $this->loadModel('State');
	if(!$edit){
			$session = $this->request->session();
	    $session->delete('advancejobsearch');



	}
		$country = $this->Country->find('list')->select(['id','name'])->toarray();
	    $this->set('country', $country);

	$Eventtype = $this->Eventtype->find('list')->where(['Eventtype.status'=>'Y'])->select(['id','name'])->toarray();
	    $this->set('Eventtype', $Eventtype);
	    $Paymentfequency = $this->Paymentfequency->find('all')->select(['id','name'])->toarray();
	    $this->set('Paymentfequency', $Paymentfequency);
	    $this->set('edit', $edit);
	  //  $cities = $this->City->find('list')->where(['City.state_id' =>$_SESSION['advancejobsearch']['state_id']])->toarray();
	    $this->set('cities', $cities);
	    $states=$this->State->find('list')->where(['State.id' =>$_SESSION['advancejobsearch']['state_id']])->toarray();
	
	    $this->set('states', $states);
 		$session = $this->request->session();
	    $session->delete('Refinejobfilter');
		

}

public function advanceProfilesearch($edit){
	$session = $this->request->session();
	    $session->delete('advancerefinedata');

	    if(!$edit){
	
	   unset($_SESSION['advanceprofiesearchdata']);
	    }
	 $this->loadModel('Country');
	 $this->loadModel('Paymentfequency');
	 $this->loadModel('State');
	$country = $this->Country->find('list')->select(['id','name'])->toarray();
	    $this->set('country', $country);
	    $Paymentfequency = $this->Paymentfequency->find('all')->select(['id','name'])->toarray();

	       $states=$this->State->find('list')->where(['State.id' =>$_SESSION['advanceprofiesearchdata']['state_id']])->toarray();
	
	    $this->set('states', $states);
	    $this->set('Paymentfequency', $Paymentfequency);
	    $this->set('edit', $edit);


		

}

public function advanceJobsearchfind(){



$this->loadModel('Requirement');
$this->loadModel('Packfeature');
$this->loadModel('Settings');
$setting=$this->Settings->find('all')->first();
$this->set('ping_amt',$setting['ping_amt']);
$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();

$this->set('month',$packfeature['number_job_application_month']);
$this->set('daily',$packfeature['number_job_application_daily']);
$this->set('quote',$packfeature['number_of_quote_daily']);

 $this->request->session()->write('Refinejobfilter',$this->request->query);
	$this->set('data',$this->request->data);
	
$user_id=$this->request->session()->read('Auth.User.id');
	$date=date('Y-m-d H:i:s');
	if(empty($this->request->query['title']) && empty($this->request->query['skill']) && empty($this->request->query['eventtype']) && empty($this->request->query['country_id']) & empty($this->request->query['state_id']) && empty($this->request->query['city_id']) & empty($this->request->query['latitude']) && empty($this->request->query['longitude']) & empty($this->request->query['gender']) && empty($this->request->query['Paymentfequency']) && empty($this->request->query['eventtype'])&& empty($this->request->query['within']) && empty($this->request->query['role_id'])&& empty($this->request->query['recname']) && empty($this->request->query['time'])&& empty($this->request->query['event_from_date']) && empty($this->request->query['event_to_date']) && empty($this->request->query['talent_required_fromdate']) && empty($this->request->query['talent_required_todate']) && empty($this->request->query['last_date_app']) && empty($this->request->query['last_date_appbefore']) ){
	

		
		$sql="SELECT requirement.id, requirement.user_id,users.user_name,requirement.last_date_app,requirement.location,requirement.event_type,eventtypes.name as eventname,currencys.name as currencysname,payment_fequency.name as payment_feqname,skill_type.name as skillname,requirement.image as image,requirement.title as title,currencys.id as currencyid,payment_fequency.id as pfqid,skill_type.id as skillid, (SELECT subscriptions.package_id FROM subscriptions
		WHERE subscriptions.package_type='PR' and subscriptions.user_id=requirement.user_id) as p_package, (Select subscriptions.package_id FROM subscriptions
		WHERE subscriptions.package_type='RC' and subscriptions.user_id=requirement.user_id) as r_package, (SELECT visibility_matrix.ordernumber FROM `visibility_matrix` where visibility_matrix.profilepack_id=p_package and visibility_matrix.recruiter_id=r_package) as order_num   FROM `requirement` LEFT JOIN requirement_vacancy ON requirement.id = requirement_vacancy.requirement_id LEFT JOIN eventtypes ON requirement.event_type = eventtypes.id  LEFT JOIN skill_type ON requirement_vacancy.telent_type = skill_type.id LEFT JOIN currencys ON requirement_vacancy.payment_currency = currencys.id LEFT JOIN users ON requirement.user_id = users.id LEFT JOIN payment_fequency ON requirement_vacancy.payment_freq = payment_fequency.id  where  requirement.last_date_app > '$date' and requirement.user_id != '$user_id' ";

	}else{
	

if($this->request->query['latitude']){
$loc_lat=$this->request->query['latitude'];
}else{
$loc_lat="";
}

if($this->request->query['longitude']){
	$loc_long=$this->request->query['longitude'];

}else{
	$loc_long="";
	
}
if($this->request->query['unit']="km"){
	$kmmile="3956";

}else{
	$kmmile="6371";
	
}	
		$salary=explode("-",$_SESSION['advanceRefinejobfilter']['salaryrange']);

		$min=$salary['0'];
		if($min){
		$min=$min;
		}else{
		$min=0;
		}

		$max=$salary['1'];
		if($max){
		$max=$max;
		}else{
		$max=500000;
		}
		$user_id=$this->request->session()->read('Auth.User.id');
		if(!empty($this->request->query['skill']) && $this->request->query['skill']!=0){
		
			$skill=$this->request->query['skill'];
			$skillarray=explode(",",$skill);
			//print_r($skillarray);  die;
			
			for($i=0;$i<count($skillarray);$i++){
				//$skillvalue=$skillarray[$i];
				
				if(count($skillarray)==1){
				 $skillcheck.="requirement_vacancy.telent_type like '$skillarray[$i]' and";
				}
				elseif($i==0){
			$skillcheck.="requirement_vacancy.telent_type like '$skillarray[$i]'";
			    }else if($i==count($skillarray)-1){
			    $skillcheck.=" or requirement_vacancy.telent_type like '$skillarray[$i]' and";
			    }else{
			     $skillcheck.=" or requirement_vacancy.telent_type like '$skillarray[$i]'";
			    }
			    
			}
			//$have.="having skill Like '%$skill%'";

		
	}else{
		$skillcheck="";
	}

//pr($this->request->data);
	if($this->request->query['checkboxafter']==1) {

	if( !empty($this->request->query['last_date_app']) ){
	
			 $last_date_app=date("Y-m-d H:s:i",strtotime($this->request->query['last_date_app']));
			 $lastdatecon="  requirement.last_date_app>='$last_date_app'";
		
			

	}
 }else{
 	$lastdateset=1;
 	//echo "Testing";
 	$lastdatecon="requirement.last_date_app>='$date'";

 }	

if($this->request->query['checkboxbefore']==2) {

	if( !empty($this->request->query['last_date_appbefore']) ){
		
			 $last_date_app=date("Y-m-d H:s:i",strtotime($this->request->query['last_date_appbefore']));
			 $lastdatecon="  requirement.last_date_app<='$last_date_app'";
if($this->request->query['checkboxafter']==1) {

			 $lastdatecon.=" and requirement.last_date_app<='$last_date_app'";
		}
			

	}
		

}else{
	if($this->request->query['checkboxafter']!=1) {
		//echo "tes";
		 	$lastdatecon="requirement.last_date_app>='$date'";

	}
}


if($this->request->query['checkboxbefore']){
	if($this->request->query['checkboxafter']){
	//echo "Test";
		$lastdatecon="requirement.last_date_app>='$date'";
}}
//echo $lastdatecon;
  $sql="SELECT requirement_vacancy.telent_type , requirement_vacancy.sex as sex,users.name , users.role_id,eventtypes.name as eventname, requirement.id, requirement.user_id,requirement.last_date_app,requirement.event_type,currencys.name as currencysname,payment_fequency.name as payment_feqname,skill_type.name as skillname,requirement.image as image,requirement.title as title,currencys.id as currencyid, 1.609344 * '".$kmmile."' * acos( cos( radians('".$loc_lat."') ) * cos( radians(requirement.latitude) ) * cos( radians(requirement.longitude) - radians('".$loc_long."') ) + sin( radians('".$loc_lat."') ) * sin( radians(requirement.latitude) ) ) AS cdistance,payment_fequency.id as pfqid,skill_type.id as skillid, (SELECT subscriptions.package_id FROM subscriptions
		WHERE subscriptions.package_type='PR' and subscriptions.user_id=requirement.user_id) as p_package, (Select subscriptions.package_id  FROM subscriptions
		WHERE subscriptions.package_type='RC' and subscriptions.user_id=requirement.user_id) as r_package, (SELECT visibility_matrix.ordernumber FROM `visibility_matrix` where visibility_matrix.profilepack_id=p_package and visibility_matrix.recruiter_id=r_package) as order_num   FROM  `requirement` LEFT JOIN requirement_vacancy ON requirement.id = requirement_vacancy.requirement_id  LEFT JOIN skill_type ON requirement_vacancy.telent_type = skill_type.id LEFT JOIN currencys ON requirement_vacancy.payment_currency = currencys.id LEFT JOIN payment_fequency ON requirement_vacancy.payment_freq = payment_fequency.id LEFT JOIN users ON requirement.user_id = users.id LEFT JOIN eventtypes ON eventtypes.id = requirement.event_type where $skillcheck $lastdatecon and  requirement_vacancy.payment_amount>='$min' and requirement_vacancy.payment_amount <= '$max' and requirement.user_id !='$user_id'";

		


	
	if(!empty($this->request->query['title'])){
	$title=$this->request->query['title'];
	$sql.=" And requirement.title Like '%$title%'  or talent_requirement_description Like '%$title%'  or skill_type.name Like '%$title%' ";
	
	 
	}



	if(!empty($this->request->query['gender'])) {
		
	
			$sex=$this->request->query['gender'];
			if($sex!="a"){
			$sql.=" And requirement_vacancy.sex='$sex'";
			}
	}
	if(!empty($this->request->query['Paymentfequency'])){


			$payment_freq=$this->request->query['Paymentfequency'];
			$sql.=" And requirement_vacancy.payment_freq='$payment_freq'";
	}


	if(!empty($this->request->query['eventtype'])){

	

			$eventtype=$this->request->query['eventtype'];
		    $sql.=" And requirement.event_type='$eventtype'"; 
	}
	if(!empty($this->request->query['country_id'])){

		
			$country_id=$this->request->query['country_id'];
			$sql.=" And requirement.country_id='$country_id'";

	}
	if(!empty($this->request->query['state_id'])){

		
			$state_id=$this->request->query['state_id'];
			$sql.=" And requirement.state_id='$state_id'";

	}
	if(!empty($this->request->query['city_id'])){

		
			$city_id=$this->request->query['city_id'];
			$sql.=" And requirement.city_id='$city_id'";

	}

	if(!empty($this->request->query['latitude']) && $this->request->query['longitude']){
	
			$lat=$this->request->query['latitude'];
			$log=$this->request->query['longitude'];
			$sql.=" And requirement.latitude='$lat' And requirement.longitude='$log'";

	}


	if( !empty($this->request->query['role_id']) ){
		
			$role=$this->request->query['role_id'];
			if($this->request->query['role_id']!=0){
				$sql.=" And users.role_id='$role'";
			}
			
			

	}
	

	if( !empty($this->request->query['recname']) ){
		
			$recname=$this->request->query['recname'];
			 $sql.=" And users.user_name LIKE'%$recname%'";
		
			

	}


	if( !empty($this->request->query['time']) ){
		
			$recname=$this->request->query['time'];
			 $sql.=" And requirement.time='$recname'";
		
			

	}

	if( !empty($this->request->query['event_from_date']) ){
		
			 $event_from_date=date("Y-m-d H:s:i",strtotime($this->request->query['event_from_date']));
			 $sql.=" And requirement.event_from_date>='$event_from_date'";
		
			

	}


	if( !empty($this->request->query['event_to_date']) ){
		
			$event_to_date=date("Y-m-d H:s:i",strtotime($this->request->query['event_to_date']));
			 $sql.=" And requirement.event_to_date<='$event_to_date'";
		
			

	}


	if( !empty($this->request->query['talent_required_fromdate']) ){
		
			$talent_required_fromdate=date("Y-m-d H:s:i",strtotime($this->request->query['talent_required_fromdate']));
			 $sql.=" And requirement.talent_required_fromdate>='$talent_required_fromdate'";
		
			

	}


	if( !empty($this->request->query['talent_required_todate']) ){

		
			$talent_required_todate=date( "Y-m-d H:s:i",strtotime($this->request->query['talent_required_todate'] ));
			 $sql.=" And requirement.talent_required_todate<='$talent_required_todate'";
		
			

	}




if($this->request->query['unit']!='' && $this->request->query['within']!='') {

	if( !empty($this->request->query['within'] && empty($this->request->query['skill'])) ){

			
			
		$within=$this->request->query['within'];	
		
			
		$have.="having cdistance <= '$within'";
			

	}else{


	$have.="having skill Like '%$skill%' and cdistance <= '$within' ";




	}

}




}	
  //pr($this->request->query);
$sql.="Group by requirement.id ".$have."order by order_num, requirement.user_id asc";  
  //pr($this->request->data); die;

		$con = ConnectionManager::get('default');
		$searchdata = $con->execute($sql)->fetchAll('assoc');
		//pr($searchdata); 


		 $currencyarray=array();
		 $payemntfaq=array();
		 $talentype=array();
		 $eventtype=array();
		 foreach($searchdata as $value){
		 if($date<$value['last_date_app']) {
		
		 $eventtype[$value['event_type']]=$value['eventname'];
		  $details = $this->Requirement->find('all')->contain(['RequirmentVacancy'=>['Skill','Currency','Paymentfequency'],'Country','State','City','Users','Jobquestion'=>['Questionmare_options_type','Jobanswer']])->where(['Requirement.id'=>$value['id']])->first();
		   
			    foreach($details['requirment_vacancy'] as $value){
 //pr($value);
		 
		 $currencyarray[$value['currency']['id']]=$value['currency']['name'];
		
		 $payemntfaq[$value['paymentfequency']['id']]=$value['paymentfequency']['name'];
		 $talentype[$value['skill']['id']]=$value['skill']['name'];
		 
		}
		 		
}
		 }

		 
		
		 $this->set('currencyarray', array_filter($currencyarray));
		 $this->set('payemntfaq',array_filter( $payemntfaq));
		 $this->set('talentype', array_filter($talentype));
		 $this->set('searchdata', array_filter($searchdata));
		 $this->set('eventtype',array_filter( array_unique($eventtype)));
		 







	
	

	  
		

}





//this function for save mutiple book now 

	public function mutiplebooknow(){
		$this->autoRender = false;
	$this->loadModel('JobApplication');
	$this->loadModel('RequirmentVacancy');

	$nontalent_id=$this->request->session()->read('Auth.User.id');
			if ($this->request->is(['post', 'put'])) {
				//  pr($this->request->data); die;
			count($this->request->data['job_id']);
		$profilecount	= explode(",", $this->request->data['user_id']);
			$user_id=$this->request->data['user_id'];
			
	$booknowavb	= $this->bookingchecked($this->request->data['job_id'],$this->request->data['user_id']);
				for ($i = 0; $i < count($profilecount); $i++)
			{
				$profilecountarrayss	= explode(",", $this->request->data['user_id']);
				foreach($this->request->data['job_id'] as $key=>$value){
					
					if($this->request->data['job_id'][$key][0]!='')
					{
						
						$details = $this->RequirmentVacancy->find('all')->contain(['Requirement'])->where(['RequirmentVacancy.requirement_id'=>$key,'RequirmentVacancy.telent_type'=>$value[0]])->first();
						 $jobidcount=$this->JobApplication->find('all')->where(['JobApplication.job_id'=>$key,'JobApplication.skill_id'=>$value[0]])->count();
if($jobidcount < $details['number_of_vacancy'] && count($profilecount) <= $details['number_of_vacancy'] ){
						$JobApplication = $this->JobApplication->newEntity();	
						$user_Datacheck['status']= $id;
						$user_Datacheck['user_id']= $profilecountarrayss[$i];
						$user_Datacheck['job_id']=$key;
						$user_Datacheck['nontalent_id']=	$nontalent_id;
						$user_Datacheck['skill_id']=$value[0];
						$user_Datacheck['nontalent_aacepted_status']="Y";
						$user_Datacheck['talent_accepted_status']="N";
						$usersavedata= $this->JobApplication->patchEntity($JobApplication,$user_Datacheck);
						$jbques= $this->JobApplication->save($usersavedata);
						$invited[]='';
					}else{
						
						$this->Flash->error(__('The following profiles have already been uploaded'), ['key' => 'booking_fail']);
					}
						
						
					} 
		
					
				}
			}
			$response['success']="bookingrequestsent";
				echo json_encode($response);
				$this->Flash->success(__('Booking Request Sent Successfully'));
				
				die;
			
		}
	}



public function bookingchecked($job_id,$user_idcount){
$this->loadModel('RequirmentVacancy');
$profilecount	= explode(",", $user_idcount);

foreach($job_id as $key=>$value){
	
		if($job_id[$key][0]!=''){
$details = $this->RequirmentVacancy->find('all')->contain(['Requirement'])->where(['RequirmentVacancy.requirement_id'=>$key,'RequirmentVacancy.telent_type'=>$value[0]])->first();
 //pr($details); die;
 $jobidcount=$this->JobApplication->find('all')->where(['JobApplication.job_id'=>$key,'JobApplication.skill_id'=>$value[0]])->count();
 
if($jobidcount < $details['number_of_vacancy'] && count($profilecount) <= $details['number_of_vacancy'] ){
	$refernamebook = $details['requirement']['title'];
	$invitedbook[$refernamebook] = $details['number_of_vacancy'] ;
	$session = $this->request->session();
	$session->write('booknowinvite',$invitedbook);
}else{
$refernamenotbook = $key;
	$invitednotbook[$refernamenotbook] = $value[0];
	$session = $this->request->session();
	$session->write('booknownotinvite',$invitednotbook);
}
}
}
$bookingnowinvitesss['profile'] = $user_idcount;
	$session = $this->request->session();
	$session->write('bookingselectedprofile',$bookingnowinvitesss);

}


public function bookingquoterpeat(){
	
	$this->loadModel('JobApplication');
	$this->loadModel('RequirmentVacancy');
	$this->autoRender=false;
	$nontalent_id=$this->request->session()->read('Auth.User.id');
	$profilecount	= explode(",", $this->request->data['jobselectedprofile']);
	
	for ($i = 0; $i < count($profilecount); $i++)
			{
				$profilecountarrayss	= explode(",", $this->request->data['jobselectedprofile']);
				foreach($this->request->data['job_idss'] as $key=>$value){
					if($this->request->data['job_idss'][$key][0]!='')
					{
						$details = $this->RequirmentVacancy->find('all')->contain(['Requirement'])->where(['RequirmentVacancy.requirement_id'=>$key,'RequirmentVacancy.telent_type'=>$value[0]])->first();
						 $jobidcount=$this->JobApplication->find('all')->where(['JobApplication.job_id'=>$key,'JobApplication.skill_id'=>$value[0]])->count();
if($jobidcount < $details['number_of_vacancy']){
						$JobApplication = $this->JobApplication->newEntity();	
						$user_Datacheck['status']= $id;
						$user_Datacheck['user_id']= $profilecountarrayss[$i];
						$user_Datacheck['job_id']=$key;
						$user_Datacheck['nontalent_id']=	$nontalent_id;
						$user_Datacheck['skill_id']=$value[0];
						$user_Datacheck['nontalent_aacepted_status']="Y";
						$user_Datacheck['talent_accepted_status']="N";
						$usersavedata= $this->JobApplication->patchEntity($JobApplication,$user_Datacheck);
						$jbques= $this->JobApplication->save($usersavedata);
					}
					}
					} 
		
					
				}
				
				
	unset($_SESSION['booknowinvite']);
	unset($_SESSION['booknownotinvite']);
	unset($_SESSION['bookingselectedprofile']);
				
					$this->Flash->success(__('Booking Request Sent Successfully'));
	$this->redirect( Router::url( $this->referer(), true ));
			}
			
	











// this fucntion for save multiple ask quote 
	public function mutipleaskQuote($invited)
	{
	
		$this->autoRender = false;
		$this->loadModel('Requirement');
		$this->loadModel('JobQuote');
		$nontalentuser_id=$this->request->session()->read('Auth.User.id');
			if ($this->request->is(['post', 'put'])) {
			$this->request->data['user_id'];
			$profilecount	= explode(",", $this->request->data['user_id']);
			$user_id=$this->request->data['user_id'];
			count($this->request->data['job_id']);

			$askquoteavb= $this->askquotechecked($this->request->data['job_id'],$this->request->data['user_id']);
			
			





			for ($i = 0; $i < count($profilecount); $i++)
			{
			$profilecountarray	= explode(",", $this->request->data['user_id']);
			//	echo  count($profilecount); die;
			foreach($this->request->data['job_id'] as $key=>$value){ 
			if($this->request->data['job_id'][$key][0]!=''){
			$details = $this->Requirement->find('all')->where(['Requirement.id'=>$key])->first();
				if($details['askquoteactualdata']>=count($profilecount)){
					$access = '1';
				}else{
					$access = '0';
				}
				if($access==1){
						if($details['askquotedata']> 0){
							$JobQuote = $this->JobQuote->newEntity();
							$user_id=$this->request->data['user_id'];
							$user_Datacheck['status']= $id;
							$user_Datacheck['user_id']= $profilecountarray[$i];
							$user_Datacheck['job_id']=$key;
							$user_Datacheck['nontalentuser_id']=$nontalentuser_id;
							$user_Datacheck['skill_id']=$value[0];
							$usersavedata= $this->JobQuote->patchEntity($JobQuote,$user_Datacheck);
							$jbques= $this->JobQuote->save($usersavedata);
							$Package = $this->Requirement->get($key);
							$askdata= $details['askquotedata']-count($profilecountarray[$i]);
							$Package->askquotedata	= $askdata;
							$this->Requirement->save($Package);
	
						}

					}
					
					else{
					$this->Flash->error(__('The following profiles have already been uploaded'), ['key' => 'job_fail']);
									

				}
					}
			else{
			
			}
			}
			}
			$this->redirect( Router::url( $this->referer(), true ));
						$this->Flash->success(__('Quote Request Sent Successfully'));

				foreach($this->request->data['job_id'] as $key=>$value){ 
			if($this->request->data['job_id'][$key][0]!=''){
			$details = $this->Requirement->find('all')->where(['Requirement.id'=>$key])->first();
				if($details['askquoteactualdata']>=count($profilecount)){
					$Package = $this->Requirement->get($key);
							$askdata= $details['askquoteactualdata']-count($profilecount);
							$Package->askquoteactualdata	= $askdata;
							$this->Requirement->save($Package);
				}else{
					//$access = '0';
				}
			}
	}
			
			//die;
			}
	}
	
public function askquotechecked($job_id,$user_idcount){
$this->loadModel('Requirement');
$this->loadModel('JobQuote');
$profilecount	= explode(",", $user_idcount);
foreach($job_id as $key=>$value){ 
	if($job_id[$key][0]!=''){
$details = $this->Requirement->find('all')->where(['Requirement.id'=>$key])->first();

if(count($profilecount) <= $details['askquotedata']){
	$refername = $details['title'];
	$invited[$refername] = $details['askquotedata'];
	$session = $this->request->session();
	$session->write('askquoteinvite',$invited);
}else{
	$refernamess = $key;
	$invitedss[$refernamess] = $value[0];
	$session = $this->request->session();
	$session->write('askquotenotinvite',$invitedss);
}


}
}

$invitedsssss['profile'] = $user_idcount;
	$session = $this->request->session();
	$session->write('jobselectedprofile',$invitedsssss);
}

public function askquoterpeat(){
	$this->autoRender=false;
	$this->loadModel('Requirement');
	$this->loadModel('JobQuote');
	$nontalentuser_id=$this->request->session()->read('Auth.User.id');
	$profilecount	= explode(",", $this->request->data['jobselectedprofile']);
//	pr($this->request->data); die;
	for ($i = 0; $i < count($profilecount); $i++)
	{
	$profilecountarray	= explode(",", $this->request->data['jobselectedprofile']);
	foreach($this->request->data['job_idss'] as $key=>$value){ 

	if($this->request->data['job_idss'][$key][0]!=''){
	$details = $this->Requirement->find('all')->where(['Requirement.id'=>$key])->first();
	if($details['askquotedata']> 0){
	$JobQuote = $this->JobQuote->newEntity();
	$user_id=$this->request->data['user_id'];
	$user_Datacheck['status']= $id;
	$user_Datacheck['user_id']= $profilecountarray[$i];
	$user_Datacheck['job_id']=$key;
	$user_Datacheck['nontalentuser_id']=$nontalentuser_id;
	$user_Datacheck['skill_id']=$value[0];
	$usersavedata= $this->JobQuote->patchEntity($JobQuote,$user_Datacheck);
	$jbques= $this->JobQuote->save($usersavedata);
	$Package = $this->Requirement->get($key);
	$askdata= $details['askquotedata']-count($profilecountarray[$i]);
	$askdatasss= $details['askquoteactualdata']-count($profilecountarray[$i]);
	$Package->askquoteactualdata	= $askdatasss;
	$Package->askquotedata	= $askdata;
	$this->Requirement->save($Package);
	}}
	}
	

	}
	unset($_SESSION['askquoteinvite']);
unset($_SESSION['askquotenotinvite']);
unset($_SESSION['jobselectedprofile']);
			$this->Flash->success(__('Quote Request Sent Successfully'));
	$this->redirect( Router::url( $this->referer(), true ));
	}














	// This Function for show skills
	public function skills($id = null)
	{
	    $this->loadModel('Users');
	    $this->loadModel('Skillset');
	    $this->loadModel('Skill');
	    if ($id != null)
	    {
		$contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id, 'Skillset.status' => 'Y'])->order(['Skillset.id' => 'DESC'])->toarray();
	    }
	    $Skill = $this->Skill->find('all')->select(['id', 'name'])->where(['Skill.status' => 'Y'])->toarray();
	    $this->set('Skill', $Skill);
	    $this->set('skillset', $contentadminskillset);
	    
	    
	    	if(!empty($this->request->data['skill']) && $this->request->data['skill']!=0){
		
			$skill=$this->request->data['skill'];
			$skillarray=explode(",",$skill);
			//print_r($skillarray);  die;
			
			for($i=0;$i<count($skillarray);$i++){
				//$skillvalue=$skillarray[$i];
				if($i==0){
			$skillcheck.="requirement_vacancy.telent_type like '$skillarray[$i]'";
			    }else if($i==count($skillarray)-1){
			    $skillcheck.=" or requirement_vacancy.telent_type like '$skillarray[$i]' and";
			    }else{
			     $skillcheck.=" or requirement_vacancy.telent_type like '$skillarray[$i]'";
			    }
			    
			}
			//$have.="having skill Like '%$skill%'";

		
	}else{
		$skillcheck="";
	}
	$this->loadModel('Packfeature');
	    $user_id = $this->request->session()->read('Auth.User.id');
	    $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();
	    $this->set('total_elegible_skills', $packfeature['number_categories']);
	}


public function applymultiple(){

$this->loadModel('Requirement');
$this->loadModel('Packfeature');
if ($this->request->is(['post', 'put'])){
	
$user_id = $this->request->session()->read('Auth.User.id');

$chekcboxcount=$this->request->data['a'];
$chekcboxcount=$chekcboxcount+1;

$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();

$applycount=$packfeature['number_of_quote_daily']+$packfeature['number_job_application_month']+$packfeature['number_job_application_daily'];
$a=$this->request->data['dyid'];
$a=$a-1;
$jobarray['job'][$a]=$this->request->data['jobsearch'];


/*
if($chekcboxcount>$packfeature['number_job_application_daily'] && $chekcboxcount<$packfeature['number_job_application_month']){
echo "daily"; die;
}

if($chekcboxcount>$packfeature['number_job_application_month'] && $chekcboxcount> $packfeature['number_job_application_daily'] && $chekcboxcount>$packfeature['number_of_quote_daily']){
echo "Ping"; die;
}
if($chekcboxcount>$packfeature['number_job_application_month'] && $chekcboxcount>$packfeature['number_of_quote_daily']){
echo "Month"; die;
} if($chekcboxcount>$packfeature['number_job_application_month'] &&  $chekcboxcount>$packfeature['number_job_application_daily'] && $chekcboxcount>$packfeature['number_of_quote_daily']){
echo "Both"; die;
}
 */

	
			
	$id=$this->request->data['jobsearch'];
			try {
		$details = $this->Requirement->find('all')->contain(['RequirmentVacancy'=>['Skill','Currency'],'Country','State','City','Users','Jobquestion'=>['Questionmare_options_type','Jobanswer']])->where(['Requirement.id'=>$id])->first();
		$this->set('requirement_data',$details);

	
		$this->set('id',$id);
		$this->set('a',$a);
	    }
	    catch (FatalErrorException $e) {
		$this->log("Error Occured", 'error');
	    }


		
	
	
	}





	}



	public function uncheckrespon(){

$this->loadModel('Requirement');
$this->loadModel('Packfeature');
if ($this->request->is(['post', 'put'])){
	
$user_id = $this->request->session()->read('Auth.User.id');
;
$chekcboxcount=$this->request->data['a'];


$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();
$applycount=$packfeature['number_of_quote_daily']+$packfeature['number_job_application_month']+$packfeature['number_job_application_daily'];
$a=$this->request->data['a'];
$jobarray['job'][$a]=$this->request->data['jobsearch'];



if($chekcboxcount>$packfeature['number_job_application_daily'] && $chekcboxcount<$packfeature['number_job_application_month']){
echo "daily"; die;
}if($chekcboxcount>$packfeature['number_job_application_month'] && $chekcboxcount> $packfeature['number_job_application_daily'] && $chekcboxcount>$packfeature['number_of_quote_daily']){
echo "Ping"; die;
}
if($chekcboxcount>$packfeature['number_job_application_month'] && $chekcboxcount>$packfeature['number_of_quote_daily']){
echo "Month"; die;
} if($chekcboxcount>$packfeature['number_job_application_month'] &&  $chekcboxcount>$packfeature['number_job_application_daily'] && $chekcboxcount>$packfeature['number_of_quote_daily']){
echo "Both"; die;
}

die;
	
	
	}





	}


	public function sendquotemultiple(){

$this->loadModel('Requirement');
$this->loadModel('Packfeature');
if ($this->request->is(['post', 'put'])){

$user_id = $this->request->session()->read('Auth.User.id');


$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();

$applycount=$packfeature['number_of_quote_daily'];

$a=$this->request->data['a'];

$jobarray['job'][$a]=$this->request->data['jobsearch'];


	
			
	$id=$this->request->data['jobsearch'];
			try {
		$details = $this->Requirement->find('all')->contain(['RequirmentVacancy'=>['Skill','Currency'],'Country','State','City','Users','Jobquestion'=>['Questionmare_options_type','Jobanswer']])->where(['Requirement.id'=>$id])->first();
		$this->set('requirement_data',$details);

	
		$this->set('id',$id);
		$this->set('a',$a);
	    }
	    catch (FatalErrorException $e) {
		$this->log("Error Occured", 'error');
	    }


		
	
	
	}





	}


// Profile Refine 
public function Profilerefine(){
	$this->loadModel('Requirement');
	$this->loadModel('Packfeature');
	 $this->loadModel('Packfeature');
	 $this->loadModel('JobApplication');
$this->loadModel('JobQuote');


	    $id = $this->request->session()->read('Auth.User.id');

$packlimit=$this->Packfeature->find('all')->where(['Packfeature.user_id'=>$this->request->session()->read('Auth.User.id')])->first();
	    $numberofaskquoteperjob = $packlimit['ask_for_quote_request_per_job'];
$this->set('numberofaskquoteperjob', $numberofaskquoteperjob);
	    $this->loadModel('Requirement');
	    $this->loadModel('JobQuote');
	     $currentdate=date('Y-m-d H:m:s');
	    $activejobs = $this->Requirement->find('all')->contain(['RequirmentVacancy'=>['Skill','Currency']])->where(['user_id' =>$id,'Requirement.last_date_app >='=>$currentdate])->toarray();
	//pr($activejobs);
	    $this->set('activejobs', $activejobs);

	    $askquote = $this->JobQuote->find('all')->where(['user_id' =>$userid])->toarray();
	    $this->set('askquote', $askquote);
	if ($this->request->is(['post', 'put'])){
	// pr($this->request->data);

$this->request->session()->write('Profilerefinedata',$this->request->data); 

		
		$user_id=$this->request->session()->read('Auth.User.id');



	   $sql="SELECT personal_profile.name, personal_profile.profile_image,personal_profile.dob as dateofbirth,personal_profile.gender,personal_profile.user_id,personal_profile.dob as dateofbirth,Round(TIMESTAMPDIFF(Day, personal_profile.dob, now() )/365)  as birthyear,personal_profile.gender,personal_profile.ethnicity,users.last_login,users.id,reviews.avgrating,personal_profile.ethnicity,enthicity.title,personal_profile.current_location,professinal_info.performing_year,count(*) as cont FROM `personal_profile` LEFT JOIN users ON personal_profile.user_id = users.id LEFT JOIN performance_language ON users.id = performance_language.user_id  LEFT JOIN languageknown ON users.id = languageknown.user_id LEFT JOIN performance_desc2 ON users.id = performance_desc2.user_id LEFT JOIN professinal_info ON users.id = professinal_info.user_id LEFT JOIN uservital ON users.id = uservital.user_id LEFT JOIN vques ON uservital.vs_question_id = vques.id LEFT JOIN voption ON uservital.option_value_id = voption.id  LEFT JOIN skill ON users.id = skill.user_id LEFT JOIN reviews ON users.id = reviews.artist_id LEFT JOIN enthicity ON personal_profile.ethnicity = enthicity.id  Where users.id!='$user_id'";

	  if(!empty($this->request->data['name']) ){

		$name=$this->request->data['name'];
		$this->set('title',$name);
	$sql.=" And personal_profile.name LIKE '%$name%'";

	}

	if(!empty($this->request->data['gender']) && $this->request->data['gender']!='0'){

	$gen=$this->request->data['gender'];
	$sql.=" And personal_profile.gender='$gen'";

	}

	


	if(!empty($this->request->data['performancelan'])  && $this->request->data['performancelan']!='0'){
	$performancelan=$this->request->data['performancelan'];
	$sql.=" And performance_language.language_id ='$performancelan'";
	}

	if(!empty($this->request->data['language']) && $this->request->data['language']!=0){
		$language=$this->request->data['language'];
		$sql.=" And languageknown.language_id='$language'";
	}

	if(!empty($this->request->data['paymentfaq']) && $this->request->data['paymentfaq']!=0){

		$paymentfaq=$this->request->data['paymentfaq'];
		$sql.=" And performance_desc2.payment_frequency='$paymentfaq'"; 
	}

	if(!empty($this->request->data['skill']) && $this->request->data['skill']!=0){

		$skill=$this->request->data['skill'];
		$sql.=" And skill.skill_id='$skill'"; 
	}

	if(!empty($this->request->data['ethnicity']) && $this->request->data['ethnicity']!=0){

		$ethnicity=$this->request->data['ethnicity'];
		$sql.=" And personal_profile.ethnicity='$ethnicity'"; 
	}

	if($this->request->data['online']!=0){
$time=logintime;
		$online=$this->request->data['online'];
		if($this->request->data['online']==1){
			
		$sql.=" And TIMESTAMPDIFF(MINUTE,users.last_login,NOW()) < '$time'"; 
		}else{
			$sql.="And TIMESTAMPDIFF(MINUTE,users.last_login,NOW()) >'$time'"; 
		}
	}


	if(!empty($this->request->data['activein']) && $this->request->data['activein']!=0){

		$days=$this->request->data['activein'];
		$sql.=" And TIMESTAMPDIFF(DAY,users.last_login,NOW()) < '$days'"; 
	}
	
	if(!empty($this->request->data['workingstyle']) ){

		$workingstyle=$this->request->data['workingstyle'];
		$sql.=" And professinal_info.areyoua='$workingstyle'"; 
	}

	if(!empty($this->request->data['r3']) ){

		$r3=$this->request->data['r3'];
		$sql.=" And reviews.avgrating='$r3'"; 
	}
		$count=0;
		for($i=0;$i<count($this->request->data['vitalstats']);$i++){

			if($this->request->data['vitalstats'][$i]!=0){

				$option[]=$this->request->data['vitalstats'][$i];
				$count++;
					
			}
			
		}

		if(!empty($this->request->data['age']) && $this->request->data['age']!='0' ){
			if($count>0){
	$year=$this->request->data['age'];
		$having="having birthyear='$year' and count(*) = '$count'";
	}else{
		$year=$this->request->data['age'];
		$having="having birthyear='$year'";
	}

	}else{
		if($count>0){
		$having="having  count(*) = cont";
		}
	}
		
if($count>0){		
$sql.=" and option_value_id in(".implode(",",$option).")";
}
	
         $sql.=" group by users.id ".$having." order by personal_profile.id asc";
	

	$con = ConnectionManager::get('default');
	$searchdata = $con->execute($sql)->fetchAll('assoc');



$this->set('searchdata',$searchdata);
$this->set('querytionarray',$querytionarray);





	}

		
}


public function advanceprofilesearchpost(){

	$this->loadModel('Requirement');

if ($this->request->is(['post', 'put'])){


	if($this->request->data['latitude']){
				$loc_lat=$this->request->data['latitude'];
				}else{
				$loc_lat="";
				}

				if($this->request->data['longitude']){
				$loc_long=$this->request->data['longitude'];

				}else{
				$loc_long="";

				}
				if($this->request->data['unit']="km"){
				$kmmile="3956";

				}else{
				$kmmile="6371";

				}

$user_id=$this->request->session()->read('Auth.User.id');


$year =date('Y');

 $sql="SELECT GROUP_CONCAT(skill.skill_id) as skill, 1.609344 * '".$kmmile."' * acos( cos( radians('".$loc_lat."') ) * cos( radians(personal_profile.current_lat) ) * cos( radians(personal_profile.current_long) - radians('".$loc_long."') ) + sin( radians('".$loc_lat."') ) * sin( radians(personal_profile.current_lat) ) ) AS cdistance, personal_profile.name, personal_profile.profile_image,personal_profile.gender,personal_profile.user_id,personal_profile.dob as dateofbirth,Round(TIMESTAMPDIFF(Day, personal_profile.dob, now() )/365)  as birthyear,personal_profile.gender,personal_profile.ethnicity,users.last_login,users.id,reviews.avgrating,personal_profile.ethnicity,enthicity.title,personal_profile.current_location,professinal_info.performing_year,('$year'-professinal_info.performing_year) as yearexpe FROM `personal_profile` LEFT JOIN users ON personal_profile.user_id = users.id LEFT JOIN performance_language ON users.id = performance_language.user_id  LEFT JOIN languageknown ON users.id = languageknown.user_id LEFT JOIN performance_desc2 ON users.id = performance_desc2.user_id LEFT JOIN professinal_info ON users.id = professinal_info.user_id   LEFT JOIN skill ON users.id = skill.user_id LEFT JOIN reviews ON users.id = reviews.artist_id LEFT JOIN prof_exprience ON users.id = prof_exprience.user_id LEFT JOIN current_working ON users.id = current_working.user_id  LEFT JOIN enthicity ON personal_profile.ethnicity = enthicity.id LEFT JOIN performance_desc ON performance_desc.user_id = users.id Where users.id!='$user_id'";



			if(!empty($this->request->data['name']) ){

				$name=$this->request->data['name'];
				$this->set('title',$name);
				$sql.=" And personal_profile.name LIKE '%$name%'";

			}

			if(!empty($this->request->data['profiletitle']) ){

				$profiletitle=$this->request->data['profiletitle'];
				$this->set('title',$name);
				$sql.=" And professinal_info.profile_title LIKE '%$profiletitle%'";

			}

			if(!empty($this->request->data['wordsearch']) ){

				$wordsearch=$this->request->data['wordsearch'];
				$this->set('title',$name);
				$sql.=" And prof_exprience.description LIKE '%$wordsearch%' or  prof_exprience.location LIKE '%$wordsearch%' or current_working.description LIKE '%$wordsearch%'or current_working.location LIKE '%$wordsearch%' or performance_desc.description LIKE '%$wordsearch%'";

			}
			if(!empty($this->request->data['skill']) ){

				$skill=$this->request->data['skill'];
				$this->set('title',$name);
				$have.="having skill Like '%$skill%'";

			}

			if(!empty($this->request->data['positionname']) ){

				$positionname=$this->request->data['positionname'];
				$this->set('title',$name);
				$sql.=" And prof_exprience.role LIKE '%$positionname%' or current_working.role LIKE '%$positionname%'";

			}

			if(!empty($this->request->data['gender']) ){

				$gender=$this->request->data['gender'];
				$sql.=" And personal_profile.gender ='$gender'";

			}
			if(!empty($this->request->data['country_id']) ){

				$country_id=$this->request->data['country_id'];
				$sql.=" And personal_profile.country_ids ='$country_id'";

			}
			if(!empty($this->request->data['state_id']) ){

				$state_id=$this->request->data['state_id'];
				$sql.=" And personal_profile.state_id ='$state_id'";

			}

if(!empty($this->request->data['city_id']) ){

				$city_id=$this->request->data['city_id'];
				$sql.=" And personal_profile.city_id ='$city_id'";

			}

		

			if(!empty($this->request->data['clocation']) ){

				$clocation=$this->request->data['clocation'];
				$sql.=" And personal_profile.current_location ='$clocation'";

			}

			if(!empty($this->request->data['clocation']) ){

				$clocation=$this->request->data['clocation'];
				$sql.=" And personal_profile.current_location ='$clocation'";

			}

			if($this->request->data['experyear']!=0) {
					$year=$this->request->data['experyear'];
				if(!empty($this->request->data['skill']) ){

				$skill=$this->request->data['skill'];
				$this->set('title',$name);
				$have.=" and yearexpe='$year'";

				}else{
					$have.="having yearexpe='$year'";
				}
				
				
			
			}

			if(!empty($this->request->data['within']) ){

					$within=$this->request->data['within'];
				if(!empty($this->request->data['skill']) ){

				$skill=$this->request->data['skill'];
				$this->set('title',$name);
				//$have.=" and cdistance <='$within'";

				}if($this->request->data['experyear']!=0) {

				
				$have.=" and cdistance <='$within'";

				}else{
					$have.="having cdistance <='$within'";
				}

			}







	
$sql.=" group by users.id ".$have." order by personal_profile.id asc";
	 




$con = ConnectionManager::get('default');
	$searchdata = $con->execute($sql)->fetchAll('assoc');



$this->set('searchdata',$searchdata);

	

}

}
public function savejobs(){
$this->loadModel('Savejobs');
if ($this->request->is(['post', 'put'])){
$jobid=$this->request->data['jobid'];
$savejob=$this->Savejobs->find('all')->where(['Savejobs.job_id'=>$jobid])->first();
if(empty($savejob)){

		$Savejobsenty = $this->Savejobs->newEntity();
		$this->request->data['user_id']=$this->request->session()->read('Auth.User.id');
		$this->request->data['job_id']=$jobid;
		$savejobdata = $this->Savejobs->patchEntity($Savejobsenty, $this->request->data);
		$savedjob = $this->Savejobs->save($savejobdata);
		$response=array();
		if($savedjob){

			$response['success']=1;
		}

}
else{

	$id=$savejob['id'];
	$audio = $this->Savejobs->get($id);
	$this->Savejobs->delete($audio);
	$response['success']=2;
}

	echo json_encode($response); die;


	}

}

public function likejobs(){
$this->loadModel('Likejobs');
if ($this->request->is(['post', 'put'])){
$jobid=$this->request->data['jobid'];
$likejob=$this->Likejobs->find('all')->where(['Likejobs.job_id'=>$jobid])->first();
if(empty($likejob)){

		$Savejobsenty = $this->Likejobs->newEntity();
		$this->request->data['user_id']=$this->request->session()->read('Auth.User.id');
		$this->request->data['job_id']=$jobid;
		$savejobdata = $this->Likejobs->patchEntity($Savejobsenty, $this->request->data);
		$savedjob = $this->Likejobs->save($savejobdata);
		$response=array();
		if($savedjob){

			$response['success']=1;
		}

}
else{

	$id=$likejob['id'];
	$audio = $this->Likejobs->get($id);
	$this->Likejobs->delete($audio);
	$response['success']=2;
}

	echo json_encode($response); die;


	}

}



public function blockjobs(){
$this->loadModel('Blockjobs');
if ($this->request->is(['post', 'put'])){
$jobid=$this->request->data['jobid'];
$Blockjobs=$this->Blockjobs->find('all')->where(['Blockjobs.job_id'=>$jobid])->first();
if(empty($Blockjobs)){

		$Savejobsenty = $this->Blockjobs->newEntity();
		$this->request->data['user_id']=$this->request->session()->read('Auth.User.id');
		$this->request->data['job_id']=$jobid;
		$savejobdata = $this->Blockjobs->patchEntity($Savejobsenty, $this->request->data);
		$savedjob = $this->Blockjobs->save($savejobdata);
		$response=array();
		if($savedjob){

			$response['success']=1;
		}

}
else{

	$id=$Blockjobs['id'];
	$audio = $this->Blockjobs->get($id);
	$this->Blockjobs->delete($audio);
	$response['success']=2;
}

	echo json_encode($response); die;


	}

}
public function savejobresult(){
		$this->loadModel('Savejobs');
			$user_id = $this->request->session()->read('Auth.User.id');
		$Savejobsdata = $this->Savejobs->find('all')->contain(['Requirement'])->where(['Savejobs.user_id'=>$user_id])->order(['Savejobs.id' => 'ASC'])->toarray();
		$this->set('searchdata',$Savejobsdata);

}

public function saveprofile(){
$this->loadModel('Saveprofile');
if ($this->request->is(['post', 'put'])){
$jobid=$this->request->data['p_id'];
$saveprfile=$this->Saveprofile->find('all')->where(['Saveprofile.p_id'=>$jobid])->first();
if(empty($saveprfile)){

		$Saveprofilesenty = $this->Saveprofile->newEntity();
		$this->request->data['user_id']=$this->request->session()->read('Auth.User.id');
		
		$saveprofiledata = $this->Saveprofile->patchEntity($Saveprofilesenty, $this->request->data);
		$savedprofile = $this->Saveprofile->save($saveprofiledata);
		$response=array();
		if($savedprofile){

			$response['success']=1;
		}
}
else{
	$id=$saveprfile['id'];
	$audio = $this->Saveprofile->get($id);
	$this->Saveprofile->delete($audio);
	$response['success']=2;
}
	echo json_encode($response); die;


	}

}
public function saveprofileresult(){
		$this->loadModel('Saveprofile');
			$user_id = $this->request->session()->read('Auth.User.id');
		$Savejobsdata = $this->Saveprofile->find('all')->contain(['Profile'=>['Users'=>['Skillset'=>['Skill'],'Professinal_info']]])->where(['Saveprofile.user_id'=>$user_id])->order(['Saveprofile.id' => 'ASC'])->toarray();
		$this->set('searchdata',$Savejobsdata);

}


public function savesearchresult(){

	$this->loadModel('Savejobsearch');
	if ($this->request->is(['post', 'put'])){

	$Savejobsearch = $this->Savejobsearch->newEntity();
	if($_SESSION['Refinejobfilter']){

	$this->request->data['user_id']=$this->request->session()->read('Auth.User.id');

	$this->request->data['query']=$_SESSION['Refinejobfilter'];
	
	$saveprofiledata = $this->Savejobsearch->patchEntity($Savejobsearch, $this->request->data);
	$savedprofile = $this->Savejobsearch->save($saveprofiledata);
	$response=array();
		if($savedprofile){
			$response['success']=1;
				}
	

	}else{
		$response['success']=0;
	}
echo json_encode($response); die;

}
	
}

public function refinejobshow(){
$this->loadModel('Savejobsearch');
$user_id = $this->request->session()->read('Auth.User.id');
$Savejobsdata = $this->Savejobsearch->find('all')->where(['Savejobsearch.user_id'=>$user_id])->order(['Savejobsearch.id' => 'DESC'])->toarray();
		$this->set('savedata',$Savejobsdata);
}
 public function deletesave($id)
    {
   $this->loadModel('Savejobsearch');
                    $Requirement = $this->Savejobsearch->get($id);
                  
                    if ($this->Savejobsearch->delete($Requirement)) {
                    $this->Flash->success(__('The Savejobsearch with id: {0} has been deleted.', h($id)));
                    return $this->redirect(['action' => 'refinejobshow']);
                    }
    }



public function viewrefinejobs( $id ){

	$this->loadModel('Savejobsearch');
$Savejobsdataviewfilter = $this->Savejobsearch->find('all')->where(['Savejobsearch.id'=>$id])->order(['Savejobsearch.id' => 'DESC'])->first()->toarray();

//pr($Savejobsdataviewfilter); die;
$query=$Savejobsdataviewfilter['query'];
	$con = ConnectionManager::get('default');

		$searchdata = $con->execute($query)->fetchAll('assoc');


		$this->set('searchdata', $searchdata);

		$currencyarray=array();
		$payemntfaq=array();
		$talentype=array();
		$eventtype=array();
		foreach($searchdata as $value){



		if($date<$value['last_date_app']) {
		$eventtype[$value['event_type']]=$value['eventname'];


		$currencyarray[$value['currencyid']]=$value['currencysname'];

		$payemntfaq[$value['pfqid']]=$value['payment_feqname'];

		$talentype[$value['skillid']]=$value['skillname'];
		$locationarray[$value['location']]=$value['location'];



		}
		$this->set('title', $title);
		$this->set('maxi', $max);
		$this->set('mini', $min);
		$this->set('location',$locationarray);
		$this->set('currencyarray', $currencyarray);
		$this->set('payemntfaq', $payemntfaq);
		$this->set('talentype', $talentype);
		$this->set('eventtype', array_unique($eventtype));

}
}






public function advanceRefine(){


	
	
$_SESSION['Refinejobfilter']=array_merge($_SESSION['Refinejobfilter'],$this->request->data);



 $date=date('Y-m-d H:i:s');

	if($_SESSION['Refinejobfilter']['latitude']){
$loc_lat=$_SESSION['Refinejobfilter']['latitude'];
}else{
$loc_lat="";
}

if($_SESSION['Refinejobfilter']['longitude']){
	$loc_long=$_SESSION['Refinejobfilter']['longitude'];

}else{
	$loc_long="";
	
}
if($_SESSION['Refinejobfilter']['unit']="km"){
	$kmmile="3956";

}else{
	$kmmile="6371";
	
}	
		$salary=explode("-",$this->request->data['salaryrange']);

		$min=$salary['0'];
		if($min){
		$min=$min;
		}else{
		$min=0;
		}

		$max=$salary['1'];
		if($max){
		$max=$max;
		}else{
		$max=500000;
		}
		$user_id=$this->request->session()->read('Auth.User.id');
		
	if(!empty($_SESSION['Refinejobfilter']['skill']) ){
		
			$skill=$_SESSION['Refinejobfilter']['skill'];
			$skillarray=explode(",",$skill);
			//print_r($skillarray);  die;
			
			
			for($i=0;$i<count($skillarray);$i++){
				//$skillvalue=$skillarray[$i];
				
				if(count($skillarray)==1){
				 $skillcheck.="requirement_vacancy.telent_type like '$skillarray[$i]' and";
				}
				elseif($i==0){
			$skillcheck.="requirement_vacancy.telent_type like '$skillarray[$i]'";
			    }else if($i==count($skillarray)-1){
			    $skillcheck.=" or requirement_vacancy.telent_type like '$skillarray[$i]' and";
			    }else{
			     $skillcheck.=" or requirement_vacancy.telent_type like '$skillarray[$i]'";
			    }
			    
			}
			
			//$have.="having skill Like '%$skill%'";

		
	}else{
		$skillcheck="";
	}

  $sql="SELECT GROUP_CONCAT(requirement_vacancy.telent_type) as skill ,eventtypes.name as eventname,requirement_vacancy.sex as sex,users.name , users.role_id, requirement.id, requirement.user_id,requirement.last_date_app,requirement.event_type,currencys.name as currencysname,payment_fequency.name as payment_feqname,skill_type.name as skillname,requirement.image as image,requirement.title as title,currencys.id as currencyid, 1.609344 * '".$kmmile."' * acos( cos( radians('".$loc_lat."') ) * cos( radians(requirement.latitude) ) * cos( radians(requirement.longitude) - radians('".$loc_long."') ) + sin( radians('".$loc_lat."') ) * sin( radians(requirement.latitude) ) ) AS cdistance,payment_fequency.id as pfqid,skill_type.id as skillid, (SELECT subscriptions.package_id FROM subscriptions
		WHERE subscriptions.package_type='PR' and subscriptions.user_id=requirement.user_id) as p_package, (Select subscriptions.package_id  FROM subscriptions
		WHERE subscriptions.package_type='RC' and subscriptions.user_id=requirement.user_id) as r_package, (SELECT visibility_matrix.ordernumber FROM `visibility_matrix` where visibility_matrix.profilepack_id=p_package and visibility_matrix.recruiter_id=r_package) as order_num   FROM  `requirement`  LEFT JOIN eventtypes ON requirement.event_type = eventtypes.id LEFT JOIN requirement_vacancy ON requirement.id = requirement_vacancy.requirement_id  LEFT JOIN skill_type ON requirement_vacancy.telent_type = skill_type.id  LEFT JOIN currencys ON requirement_vacancy.payment_currency = currencys.id LEFT JOIN payment_fequency ON requirement_vacancy.payment_freq = payment_fequency.id LEFT JOIN users ON requirement.user_id = users.id  where $skillcheck  requirement.last_date_app > '$date' and  requirement_vacancy.payment_amount>='$min' and requirement_vacancy.payment_amount <= '$max' and requirement.user_id !='$user_id'";
		



if($this->request->query['currency']){
	$currnecy=$this->request->query['currency'];
	$sql.=" And requirement_vacancy.payment_currency='$currnecy'";

}


if($this->request->query['payment']){
	$payment=$this->request->query['payment'];
	$sql.=" And requirement_vacancy.payment_freq='$payment'";

}

if($this->request->query['location']){
	$location=$this->request->query['location'];
	$sql.=" And requirement.location='$location'";

}

if($this->request->query['telenttype']){
	$telenttype=$this->request->query['telenttype'];
	$sql.=" And requirement_vacancy.telent_type='$telenttype'";

}

if($this->request->query['eventtype']){
	$eventtype=$this->request->query['eventtype'];
	$sql.=" And requirement.event_type='$eventtype'";

}else{


	if(!empty($_SESSION['Refinejobfilter']['eventtype'])){

	

			$eventtype=$_SESSION['Refinejobfilter']['eventtype'];
		    $sql.=" And requirement.event_type='$eventtype'"; 
	}


}
	if($this->request->query['time']){
	$time=$this->request->query['time'];
	$sql.=" And requirement.time='$time'";

}

	
	if(!empty($_SESSION['Refinejobfilter']['title'])){
	
	$title=$_SESSION['Refinejobfilter']['title'];
	$sql.=" And requirement.title Like '%$title%'  or talent_requirement_description Like '%$title%' or location Like '%$title%' or skill_type.name Like '%$title%' ";
	
	}



	if(!empty($_SESSION['Refinejobfilter']['gender'])) {
		
	
			$sex=$_SESSION['Refinejobfilter']['gender'];
			if($sex!="a"){
			$sql.=" And requirement_vacancy.sex='$sex'";
			}
	}
	if(!empty($_SESSION['Refinejobfilter']['Paymentfequency'])){


			$payment_freq=$_SESSION['Refinejobfilter']['Paymentfequency'];
			$sql.=" And requirement_vacancy.payment_freq='$payment_freq'";
	}


	if(!empty($_SESSION['Refinejobfilter']['country_id'])){

		
			$country_id=$_SESSION['Refinejobfilter']['country_id'];
			$sql.=" And requirement.time='$country_id'";

	}
	if(!empty($_SESSION['Refinejobfilter']['state_id'])){

		
			$state_id=$_SESSION['Refinejobfilter']['country_id'];
			$sql.=" And requirement.time='$state_id'";

	}
	if(!empty($_SESSION['Refinejobfilter']['city_id'])){

		
			$city_id=$_SESSION['Refinejobfilter']['city_id'];
			$sql.=" And requirement.time='$city_id'";

	}

	if(!empty($_SESSION['Refinejobfilter']['latitude']) && $_SESSION['Refinejobfilter']['longitude']){
	
			$lat=$_SESSION['Refinejobfilter']['latitude'];
			$log=$_SESSION['Refinejobfilter']['longitude'];
			$sql.=" And requirement.latitude='$lat' And requirement.longitude='$log'";

	}


	if( !empty($_SESSION['Refinejobfilter']['role_id']!=0) ){
		
			$role=$_SESSION['Refinejobfilter']['role_id'];
			if($_SESSION['Refinejobfilter']['role_id']==2){
				$sql.=" And users.role_id='$role'";
			}else{
				$sql.=" And users.role_id='1' or requirement.longitude='2'";
			}
			
			

	}

	if( !empty($_SESSION['Refinejobfilter']['recname']) ){
		
			$recname=$_SESSION['Refinejobfilter']['recname'];
			 $sql.=" And users.name='$recname'";
		
			

	}


	if( !empty($_SESSION['Refinejobfilter']['time']) ){
		
			$recname=$_SESSION['Refinejobfilter']['time'];
			 $sql.=" And requirement.time='$recname'";
		
			

	}

	if( !empty($_SESSION['Refinejobfilter']['event_from_date']) ){
		
			$event_from_date=date("Y-m-d H:s:i",$this->request->data['event_from_date']);
			 $sql.=" And requirement.event_from_date='$event_from_date'";
		
			

	}


	if( !empty($_SESSION['Refinejobfilter']['event_to_date']) ){
		
			$event_to_date=date("Y-m-d H:s:i",$_SESSION['Refinejobfilter']['event_to_date']);
			 $sql.=" And requirement.event_to_date='$event_to_date'";
		
			

	}


	if( !empty($_SESSION['Refinejobfilter']['talent_required_fromdate']) ){
		
			$talent_required_fromdate=date("Y-m-d H:s:i",$_SESSION['Refinejobfilter']['talent_required_fromdate']);
			 $sql.=" And requirement.talent_required_fromdate='$talent_required_fromdate'";
		
			

	}


	if( !empty($_SESSION['Refinejobfilter']['talent_required_todate']) ){
		
			$talent_required_todate=date( "Y-m-d H:s:i",$_SESSION['Refinejobfilter']['talent_required_todate'] );
			 $sql.=" And requirement.talent_required_todate='$talent_required_todate'";
		
			

	}


	if($_SESSION['Refinejobfilter']['checkboxafter']==1) {

	if( !empty($_SESSION['Refinejobfilter']['last_date_app']) ){
		
			$last_date_app=date("Y-m-d H:s:i",$_SESSION['Refinejobfilter']['last_date_app']);
			 $sql.=" And requirement.last_date_app>='$last_date_app'";
		
			

	}
 }	

if($_SESSION['Refinejobfilter']['checkboxbefore']==1) {

	if( !empty($_SESSION['Refinejobfilter']['last_date_appbefore']) ){
		
			$last_date_app=date("Y-m-d H:s:i",$_SESSION['Refinejobfilter']['last_date_appbefore']);
			 $sql.=" And requirement.last_date_app<='$talent_required_todate'";
		
			

	}

}

if($_SESSION['Refinejobfilter']['unit']!='' && $_SESSION['Refinejobfilter']['within']!='') {

	if( !empty($_SESSION['Refinejobfilter']['within'] && empty($_SESSION['Refinejobfilter']['skill'])) ){

			
			
		$within=$_SESSION['Refinejobfilter']['within'];	
		
			
		$have.="having cdistance <= '$within'";
			

	}else{


	$have.="having skill Like '%$skill%' and cdistance <= '$within' ";




	}

}
  $sql.="Group by requirement.id ".$have."order by order_num, requirement.user_id asc"; 
   

		$con = ConnectionManager::get('default');
		$searchdata = $con->execute($sql)->fetchAll('assoc');


		 $currencyarray=array();
		 $payemntfaq=array();
		 $talentype=array();
		 $eventtype=array();
		 foreach($searchdata as $value){
		
		
if($date<$value['last_date_app']) {
		 $eventtype[]=$value['eventname'];
		 $currencyarray[$value['currencyid']]=$value['currencysname'];
		
		 $payemntfaq[$value['pfqid']]=$value['payment_feqname'];
		 $talentype[$value['skillid']]=$value['skillname'];

		 		

		 }
		 }

		 
		
		 $this->set('currencyarray', array_filter($currencyarray));
		 $this->set('payemntfaq',array_filter( $payemntfaq));
		 $this->set('talentype', array_filter($talentype));
		 $this->set('searchdata', array_filter($searchdata));
		 $this->set('eventtype',array_filter( array_unique($eventtype)));
		 







}



public function aplyjobmultiple(){

	$this->loadModel('Packfeature');
	$this->loadModel('Requirement');
	$this->loadModel('JobApplication');

if ($this->request->is(['post', 'put'])){


if($this->request->data['buttonpresstype']==1){
	$flag=0;

$response=array();
$user_id = $this->request->session()->read('Auth.User.id');
$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();
$applycount=$packfeature['number_job_application'];
$packfeature_id = $packfeature['id'];

        $number_jobday = $packfeature['number_job_application_daily'];
        $number_jobmonth = $packfeature['number_job_application_month'];
 $jobapplycount=count($this->request->data['job']);
/*
if($packfeature['number_job_application_daily']==0 && $packfeature['number_job_application_month']!=0 && $packfeature['number_of_quote_daily']!=0){
echo "daily"; die;
}if($packfeature['number_job_application_month']==0 &&  $packfeature['number_job_application_daily']!=0  && $packfeature['number_of_quote_daily']!=0){
echo "Month"; die;
} if($packfeature['number_job_application_month']==0 &&  $packfeature['number_job_application_daily']==0  && $packfeature['number_of_quote_daily']!=0){
echo "Both"; die;
}if($packfeature['number_job_application_month']==0 &&  $packfeature['number_job_application_daily']==0  && $packfeature['number_of_quote_daily']==0){
echo "Ping"; die;
}
*/
if( $packfeature['number_job_application_month']!=0 && $packfeature['number_job_application_daily']!=0){
	$id=$this->request->data['jobsearch'];
//pr($this->request->data['job']);
	foreach($this->request->data['job'] as $value){

		$details = $this->Requirement->find('all')->contain(['RequirmentVacancy'=>['Skill','Currency'],'Country','State','City','Users','Jobquestion'=>['Questionmare_options_type','Jobanswer']])->where(['Requirement.id'=>$value])->first();
		//pr($details);
	
	  $skill=count($details['requirment_vacancy']);
			if($skill<=1){

		}else{
			$flag=1;
		}
	}
	try {
		foreach($this->request->data['job'] as $value){

		$details = $this->Requirement->find('all')->contain(['RequirmentVacancy'=>['Skill','Currency'],'Country','State','City','Users','Jobquestion'=>['Questionmare_options_type','Jobanswer']])->where(['Requirement.id'=>$value])->first();
	
		$skill=count($details['requirment_vacancy']);

		
if($flag==0){
	$this->request->data['user_id']=$this->request->session()->read('Auth.User.id');


		$this->request->data['talent_accepted_status']="Y";
		$this->request->data['job_id']=$details['id'];
		$this->request->data['skill_id']=$details['requirment_vacancy']['0']['skill']['id'];
	
		 $JobApplication = $this->JobApplication->newEntity();
	$JobApplicationdata = $this->JobApplication->patchEntity($JobApplication, $this->request->data);
		if ($resu=$this->JobApplication->save($JobApplicationdata)) {
		$packfeature = $this->Packfeature->get($packfeature_id);

		$feature_info['number_job_application_daily'] = $number_jobday-1;
		$feature_info['number_job_application_month'] = $number_jobmonth-1;
		$features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
		$this->Packfeature->save($features_arr);




		}



		$bookjob = $this->JobApplication->find('all')->order(['JobApplication.id' =>'DESC'])->first();
		////pr($bookjob); 
		//$response['job_id']=$bookjob['job_id'];
		$Job[]=$value;
		$response['success']=2;
		//echo json_encode($response);
		//die;

		}else{

$response['success']=1;

		}

	}
	
	    }
	    catch (FatalErrorException $e) {
		$this->log("Error Occured", 'error');
	    }


		}


}else{
	$response['success']=3;
}



	}
	$response['jobarray']=$Job;
	echo json_encode($response);
die;

}





public function saveprosearchresult(){

	$this->loadModel('Saveprofilesearch');
	if ($this->request->is(['post', 'put'])){

	$Saveprofilesearch = $this->Saveprofilesearch->newEntity();
	if($_SESSION['Profilerefinedata']){

	$this->request->data['user_id']=$this->request->session()->read('Auth.User.id');



if($_SESSION['Profilerefinedata']['name']){
	$this->request->data['keyword']=$_SESSION['Profilerefinedata']['name'];
}else{
	$this->request->data['keyword']=$this->request->data['name'];
	}
	$this->request->data['age']=$_SESSION['Profilerefinedata']['age'];
	$this->request->data['gender']=$_SESSION['Profilerefinedata']['gender'];
	$this->request->data['performancelan']=$_SESSION['Profilerefinedata']['performancelan'];
	$this->request->data['online']=$_SESSION['Profilerefinedata']['online'];

 $vitalcount=count($_SESSION['Profilerefinedata']['vitalstats']);
$vital=array();
	//pr($_SESSION['Profilerefinedata']);
	for($i=0;$i<$vitalcount;$i++){

if($_SESSION['Profilerefinedata']['vitalstats'][$i]!=0){
	
	$vital[]=$_SESSION['Profilerefinedata']['vitalstats'][$i] ;
		 
	}

	}

	//pr($vital);

	$this->request->data['vitaloption']=implode(",",$vital);
	$this->request->data['ProfileActive']=$_SESSION['Profilerefinedata']['activein'];
	$this->request->data['Payment-Frequency']=$_SESSION['Profilerefinedata']['paymentfaq'];
	$this->request->data['Talent-Type']=$_SESSION['Profilerefinedata']['skill'];
	$this->request->data['Ethnicity']=$_SESSION['Profilerefinedata']['ethnicity'];
	$this->request->data['Review-Rating']=$_SESSION['Profilerefinedata']['r3'];
	$this->request->data['Working-Style']=$_SESSION['Profilerefinedata']['workingstyle'];
	
	//pr($this->request->data); die;
	
	$saveprofiledata = $this->Saveprofilesearch->patchEntity($Saveprofilesearch, $this->request->data);
	$savedprofile = $this->Saveprofilesearch->save($saveprofiledata);

	$response=array();
		if($savedprofile){
			$response['success']=1;
				}
	

	}else{
		$response['success']=0;
	}
echo json_encode($response); die;

}
	
}



// Profile Refine 
public function viewProfilerefine($id){

	$this->loadModel('Requirement');
	if ($this->request->is(['post', 'put'])){
	// pr($this->request->data);

$this->request->session()->write('Profilerefinedata',$this->request->data); 

		
		$user_id=$this->request->session()->read('Auth.User.id');



	   $sql="SELECT personal_profile.name, personal_profile.profile_image,personal_profile.gender,personal_profile.user_id,personal_profile.dob as dateofbirth,Round(TIMESTAMPDIFF(Day, personal_profile.dob, now() )/365)  as birthyear,personal_profile.gender,personal_profile.ethnicity,users.last_login,users.id,reviews.avgrating,personal_profile.ethnicity,enthicity.title,personal_profile.current_location,professinal_info.performing_year,count(*) as cont FROM `personal_profile` LEFT JOIN users ON personal_profile.user_id = users.id LEFT JOIN performance_language ON users.id = performance_language.user_id  LEFT JOIN languageknown ON users.id = languageknown.user_id LEFT JOIN performance_desc2 ON users.id = performance_desc2.user_id LEFT JOIN professinal_info ON users.id = professinal_info.user_id LEFT JOIN uservital ON users.id = uservital.user_id LEFT JOIN vques ON uservital.vs_question_id = vques.id LEFT JOIN voption ON uservital.option_value_id = voption.id  LEFT JOIN skill ON users.id = skill.user_id LEFT JOIN reviews ON users.id = reviews.artist_id LEFT JOIN enthicity ON personal_profile.ethnicity = enthicity.id  Where users.id!='$user_id'";

	  if(!empty($this->request->data['name']) ){

		$name=$this->request->data['name'];
		$this->set('title',$name);
	$sql.=" And personal_profile.name LIKE '%$name%'";

	}

	if(!empty($this->request->data['gender']) && $this->request->data['gender']!='0'){

	$gen=$this->request->data['gender'];
	$sql.=" And personal_profile.gender='$gen'";

	}

	


	if(!empty($this->request->data['performancelan'])  && $this->request->data['performancelan']!='0'){
	$performancelan=$this->request->data['performancelan'];
	$sql.=" And performance_language.language_id ='$performancelan'";
	}

	if(!empty($this->request->data['language']) && $this->request->data['language']!=0){
		$language=$this->request->data['language'];
		$sql.=" And languageknown.language_id='$language'";
	}

	if(!empty($this->request->data['paymentfaq']) && $this->request->data['paymentfaq']!=0){

		$paymentfaq=$this->request->data['paymentfaq'];
		$sql.=" And performance_desc2.payment_frequency='$paymentfaq'"; 
	}

	if(!empty($this->request->data['skill']) && $this->request->data['skill']!=0){

		$skill=$this->request->data['skill'];
		$sql.=" And skill.skill_id='$skill'"; 
	}

	if(!empty($this->request->data['ethnicity']) && $this->request->data['ethnicity']!=0){

		$ethnicity=$this->request->data['ethnicity'];
		$sql.=" And personal_profile.ethnicity='$ethnicity'"; 
	}

	if($this->request->data['online']!=0){
$time=logintime;
		$online=$this->request->data['online'];
		if($this->request->data['online']==1){
			
		$sql.=" And TIMESTAMPDIFF(MINUTE,users.last_login,NOW()) < '$time'"; 
		}else{
			$sql.="And TIMESTAMPDIFF(MINUTE,users.last_login,NOW()) >'$time'"; 
		}
	}


	if(!empty($this->request->data['activein']) && $this->request->data['activein']!=0){

		$days=$this->request->data['activein'];
		$sql.=" And TIMESTAMPDIFF(DAY,users.last_login,NOW()) < '$days'"; 
	}
	
	if(!empty($this->request->data['workingstyle']) ){

		$workingstyle=$this->request->data['workingstyle'];
		$sql.=" And professinal_info.areyoua='$workingstyle'"; 
	}

	if(!empty($this->request->data['r3']) ){

		$r3=$this->request->data['r3'];
		$sql.=" And reviews.avgrating='$r3'"; 
	}
		$count=0;
		for($i=0;$i<count($this->request->data['vitalstats']);$i++){

			if($this->request->data['vitalstats'][$i]!=0){

				$option[]=$this->request->data['vitalstats'][$i];
				$count++;
					
			}
			
		}

		if(!empty($this->request->data['age']) && $this->request->data['age']!='0' ){
			if($count>0){
	$year=$this->request->data['age'];
		$having="having birthyear='$year' and count(*) = '$count'";
	}else{
		$year=$this->request->data['age'];
		$having="having birthyear='$year'";
	}

	}else{
		if($count>0){
		$having="having  count(*) = cont";
		}
	}
		
if($count>0){		
$sql.=" and option_value_id in(".implode(",",$option).")";
}
	
         $sql.=" group by users.id ".$having." order by personal_profile.id asc";
	

	$con = ConnectionManager::get('default');
	$searchdata = $con->execute($sql)->fetchAll('assoc');



$this->set('searchdata',$searchdata);
$this->set('querytionarray',$querytionarray);





	}

		
}


public function viewRefine(){

	$this->loadModel('Saveprofilesearch');
$user_id = $this->request->session()->read('Auth.User.id');
$Savejobsdata = $this->Saveprofilesearch->find('all')->select(['id','template','created'])->where(['Saveprofilesearch.user_id'=>$user_id])->order(['Saveprofilesearch.id' => 'DESC'])->toarray();
		$this->set('savedata',$Savejobsdata);

}


public function pingjobs(){
$this->loadModel('Requirement');
		if ($this->request->is(['post', 'put'])){
				
				$requirementid=$this->request->data['jobid'];
				$count=$this->request->data['count'];

				$details = $this->Requirement->find('all')->contain(['RequirmentVacancy'=>['Skill','Currency'],'Country','State','City','Users','Jobquestion'=>['Questionmare_options_type','Jobanswer']])->where(['Requirement.id'=>$requirementid])->first();
$html="<div id='myping".$requirementid."'>";			
$html.="
	<a href=".SITE_URL."/applyjob/".$details['id']." target='_blank'>".$details['title']."</a>
     <select class='form-control' name='skill".$count."' required><option value=''>Select Skill</option>";

foreach($details['requirment_vacancy'] as $value){

$html.='<option value='.$value["skill"]["id"].'>'.$value["skill"]["name"].'</option>';


}

        $html.='<input type="hidden" name="job_id'.$count.'" value='.$details['id'].'>
        <input type="hidden" name="count" value='.$count.'>
         </div>';
echo $html;
die;
		}
}


public function myfunctiondata(){
	
	$this->loadModel('RequirmentVacancy');

	if ($this->request->is(['post', 'put'])){

			
			$skill=$this->request->data['skill'];
			$requirementid=$this->request->data['reqid'];
			$details = $this->RequirmentVacancy->find('all')->contain(['Skill','Currency'])->where(['RequirmentVacancy.requirement_id'=>$requirementid,'RequirmentVacancy.telent_type'=>$skill])->first();
			
			$response=array();
			$response['payment_currency']=$details['payment_amount'];
			$response['currency']=$details['currency']['name'];
			$response['code']=$details['currency']['symbol'];

			echo json_encode($response);
			die;



}

}

	public function singleApply($jobid=null){

		$this->loadModel('Packfeature');
		$this->loadModel('Requirement');
	
		$user_id = $this->request->session()->read('Auth.User.id');
		$packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user_id])->order(['Packfeature.id' => 'ASC'])->first();
		$flag;

		$monthlimit=$packfeature['number_job_application_month'];
		$dailylimit=$packfeature['number_job_application_daily'];

		$details = $this->Requirement->find('all')->contain(['RequirmentVacancy'=>['Skill','Currency'],'Country','State','City','Users','Jobquestion'=>['Questionmare_options_type','Jobanswer']])->where(['Requirement.id'=>$jobid])->first();
		$this->set('requirement_data',$details);

		if($monthlimit==0 || $dailylimit==0){
			$flag=1;

			
		}else{
			$flag=2;
		}
		$this->set(compact('flag'));
		$this->set(compact('jobid'));
		

	}


	public function sendquotebysingle($jobid){

$this->loadModel('Requirement');
$this->loadModel('Packfeature');
$user_id = $this->request->session()->read('Auth.User.id');
$id=$jobid;
			try {
		$details = $this->Requirement->find('all')->contain(['RequirmentVacancy'=>['Skill','Currency'],'Country','State','City','Users','Jobquestion'=>['Questionmare_options_type','Jobanswer']])->where(['Requirement.id'=>$id])->first();
		$this->set('requirement_data',$details);

	
		$this->set('id',$id);
	
	    }
	    catch (FatalErrorException $e) {
		$this->log("Error Occured", 'error');
	    }
}


public function profilesearch(){

	//pr($this->request->query);
	$this->loadModel('Requirement');
	$this->loadModel('Packfeature');
	$this->loadModel('JobApplication');
	$this->loadModel('JobQuote');
	$this->loadModel('Profile');
//Write Advance details to session  
	if($this->request->query['form']==1){
		$session = $this->request->session();
		$session->write('advanceprofiesearchdata', $this->request->query);
	}

	$this->set('vitalarray',$this->request->query['vitalstats']);
	$id = $this->request->session()->read('Auth.User.id');
	$packlimit=$this->Packfeature->find('all')->where(['Packfeature.user_id'=>$this->request->session()->read('Auth.User.id')])->first();
	$numberofaskquoteperjob = $packlimit['ask_for_quote_request_per_job'];
	$this->set('numberofaskquoteperjob', $numberofaskquoteperjob);
	$currentdate=date('Y-m-d H:m:s');
	$activejobs = $this->Requirement->find('all')->contain(['RequirmentVacancy'=>['Skill','Currency']])->where(['user_id' =>$id,'Requirement.last_date_app >='=>$currentdate])->toarray();
	$this->set('activejobs', $activejobs);
	$askquote = $this->JobQuote->find('all')->where(['user_id' =>$userid])->toarray();
	$this->set('askquote', $askquote);

	if($this->request->query['form']==1){
	if($this->request->query['latitude']){
				$loc_lat=$this->request->query['latitude'];
				}else{
				$loc_lat="";
				}

				if($this->request->query['longitude']){
				$loc_long=$this->request->query['longitude'];

				}else{
				$loc_long="";

				}
				if($this->request->query['unit']="km"){
				$kmmile="3956";

				}else{
				$kmmile="6371";

				}

					if($this->request->query['clatitude']){
				$cloc_lat=$this->request->query['clatitude'];
				}else{
					$cloc_lat="";
				}

				if($this->request->query['clongitude']){
				$cloc_long=$this->request->query['clongitude'];

				}else{
				$cloc_long="";

				}
				if($this->request->query['unit']="km"){
				$kmmile="3956";

				}else{
				$kmmile="6371";

				}
}
$user_id=$this->request->session()->read('Auth.User.id');
 $sql="SELECT GROUP_CONCAT(skill.skill_id) as skill, 1.609344 * '".$kmmile."' * acos( cos( radians('".$cloc_lat."') ) * cos( radians(personal_profile.current_lat) ) * cos( radians(personal_profile.current_long) - radians('".$cloc_long."') ) + sin( radians('".$cloc_lat."') ) * sin( radians(personal_profile.current_lat) ) ) AS cdistance,  1.609344 * '".$kmmile."' * acos( cos( radians('".$loc_lat."') ) * cos( radians(personal_profile.current_lat) ) * cos( radians(personal_profile.current_long) - radians('".$loc_long."') ) + sin( radians('".$loc_lat."') ) * sin( radians(personal_profile.current_lat) ) ) AS distance,professinal_info.areyoua,professinal_info.profile_title,personal_profile.name,enthicity.id as encid,enthicity.title as encname,languageknown.id as languageknownid,(SELECT subscriptions.package_id FROM subscriptions
		WHERE subscriptions.package_type='PR' and subscriptions.user_id=users.id) as p_package, (Select subscriptions.package_id  FROM subscriptions
		WHERE subscriptions.package_type='RC' and subscriptions.user_id=users.id) as r_package, (SELECT visibility_matrix.ordernumber FROM `visibility_matrix` where visibility_matrix.profilepack_id=p_package and visibility_matrix.recruiter_id=r_package) as order_num, personal_profile.profile_image,personal_profile.gender,personal_profile.user_id,personal_profile.dob as dateofbirth,Round(TIMESTAMPDIFF(Day, personal_profile.dob, now() )/365)  as birthyear,personal_profile.gender,personal_profile.ethnicity,users.last_login,users.id,reviews.avgrating,personal_profile.ethnicity,enthicity.title,personal_profile.current_location,professinal_info.performing_year,count(*) as cont ,professinal_info.performing_year,('$year'-professinal_info.performing_year) as yearexpe FROM `personal_profile` LEFT JOIN users ON personal_profile.user_id = users.id LEFT JOIN performance_language ON users.id = performance_language.user_id  LEFT JOIN languageknown ON users.id = languageknown.user_id LEFT JOIN performance_desc2 ON users.id = performance_desc2.user_id LEFT JOIN professinal_info ON users.id = professinal_info.user_id LEFT JOIN uservital ON users.id = uservital.user_id LEFT JOIN vques ON uservital.vs_question_id = vques.id LEFT JOIN voption ON uservital.option_value_id = voption.id  LEFT JOIN skill ON users.id = skill.user_id LEFT JOIN reviews ON users.id = reviews.artist_id LEFT JOIN enthicity ON personal_profile.ethnicity = enthicity.id LEFT JOIN prof_exprience ON users.id = prof_exprience.user_id LEFT JOIN current_working ON users.id = current_working.user_id LEFT JOIN performance_desc ON performance_desc.user_id = users.id Where users.id!='$user_id'";
// For home page search
		if(!empty($this->request->query['name']) ){

			$name=$this->request->query['name'];
			$this->set('d',$name);
			$sql.="And (personal_profile.name LIKE '%$name%')";

		}
// For home page search end

// For Refine 
if($this->request->query['refine']==2){

		if(!empty($this->request->query['age']) && $this->request->query['age']!='0' ){
				$age=explode("-",$this->request->query['age']);

				$min=$age['0'];
				$max=$age['1'];
				$year=$this->request->query['age'];
				$having="having birthyear>='$min' and birthyear <='$max'";
			}
		if(!empty($this->request->query['gender']) && $this->request->query['gender']!='0'){

				$gen=$this->request->query['gender'];
				$sql.=" And (personal_profile.gender='$gen')";
				$this->set('gen',$gen);
			}

	
		if(!empty($this->request->query['performancelan']) && $this->request->query['performancelan']!=0){
			$performancelan=$this->request->query['performancelan'];
			$count=count($this->request->query['performancelan']);

			for($i=0;$i<count($this->request->query['performancelan']);$i++){

			if($i==0){
			
			$payment="'".$this->request->query['performancelan'][$i]."'";
			}else{
			$payment.=" OR performance_language.language_id= '".$this->request->query['performancelan'][$i]."'";
			}
			}

			$sql.="And (performance_language.language_id=$payment) ";
			$this->set('performancelansel',$performancelan);
		
		}
		if(!empty($this->request->query['language']) && $this->request->query['language']!=0){
			$language=$this->request->query['language'];
			$count=count($this->request->query['language']);

			for($i=0;$i<count($this->request->query['language']);$i++){

			if($i==0){
			
			$payment="'".$this->request->query['language'][$i]."'";
			}else{
			$payment.=" OR languageknown.language_id= '".$this->request->query['language'][$i]."'";
			}
			}

			$sql.="And (languageknown.language_id=$payment) ";
					$this->set('languagesel',$language);
		
		}

		if($this->request->query['online']!=0){

			$time=logintime;
			$online=$this->request->query['online'];
			if($this->request->query['online']==1){
				$live=1;
			$sql.=" And (TIMESTAMPDIFF(MINUTE,users.last_login,NOW()) < '$time')"; 
			}else{
				$live=2;
				$sql.="And (TIMESTAMPDIFF(MINUTE,users.last_login,NOW()) >'$time')"; 
			}
			$this->set(compact('live'));
		}
		if(!empty($this->request->query['activein']) && $this->request->query['activein']!=0){

			$days=$this->request->query['activein'];
			$sql.=" And TIMESTAMPDIFF(DAY,users.last_login,NOW()) < '$days'"; 
			$this->set('day',$days);
		}

		if(!empty($this->request->query['paymentfaq']) && $this->request->query['paymentfaq']!=0){

			$paymentfaq=$this->request->query['paymentfaq'];
			$sql.=" And performance_desc2.payment_frequency='$paymentfaq'"; 
			$this->set('payment',$paymentfaq);
		}

		// vital static

		if($this->request->query['vitalstats']){
		

		foreach($this->request->query['vitalstats'] as $va){
			$option[]= $va;
		}



		$sql.=" and( option_value_id in(".implode(",",$option).") )";
	}
		if(!empty($this->request->query['skill']) ){

			$skill=$this->request->query['skill'];
			$this->set('title',$name);
			$have.="having skill Like '%$skill%'";

		}


		if(!empty($this->request->query['ethnicity']) && $this->request->query['ethnicity']!=0){
			$ethnicityarray=$this->request->query['ethnicity'];
			$count=count($this->request->query['ethnicity']);

			for($i=0;$i<count($this->request->query['ethnicity']);$i++){

			if($i==0){
			
			$ethnicity="'".$this->request->query['ethnicity'][$i]."'";
			}else{
			$ethnicity.=" OR personal_profile.ethnicity= '".$this->request->query['ethnicity'][$i]."'";
			}
			}

			$sql.="And (personal_profile.ethnicity=$ethnicity) ";
					$this->set('ethnicity',$ethnicityarray);
		
		}
		if(!empty($this->request->query['r3']) ){

			$r3=$this->request->query['r3'];
			$sql.=" And (reviews.avgrating>='$r3')"; 
			$this->set('r3',$r3);
		}

		if($this->request->query['allrated']=="rate") {

			$rated=$this->request->query['allrated'];
			$sql.=" And (reviews.avgrating>='0')"; 
			$this->set('rated',$rated);

		}else if($this->request->query['allrated']=="unrate"){

			$rated=$this->request->query['allrated'];
			$this->set('rated',$rated);
		}

		if(!empty($this->request->query['workingstyle']) && $this->request->query['workingstyle']!=0){

			$workingstylearray=$this->request->query['workingstyle'];
			$count=count($this->request->query['workingstyle']);

			for($i=0;$i<count($this->request->query['workingstyle']);$i++){

			if($i==0){
			
			$workingstyle="'".$this->request->query['workingstyle'][$i]."'";
			}else{
			$workingstyle.=" OR professinal_info.areyoua= '".$this->request->query['workingstyle'][$i]."'";
			}
			}

			$sql.="And (languageknown.language_id=$workingstyle) ";
					$this->set('workingstyleasel',$workingstylearray);
		
		}

}



// Refine End


// Advance Search start

  if($this->request->query['form']==1){

  		if(!empty($this->request->query['profiletitle']) ){

				$profiletitle=$this->request->query['profiletitle'];
				$this->set('title',$name);
				$sql.=" And (professinal_info.profile_title LIKE '%$profiletitle%')";

			}

	
if(empty($this->request->query['within']) && empty($this->request->query['cwithin'])) {
		if(!empty($this->request->query['skill']) ){

			$skill=$this->request->query['skill'];
			
			$having.="having skill Like '%$skill%'";

		}
	}

		if(!empty($this->request->query['gender'])) {
	
			if(in_array( "a",$this->request->query['gender'])){

			}else{
	
			for($i=0;$i<count($this->request->query['gender']);$i++){

			if($i==0){
		
			$sex="'".$this->request->query['gender'][$i]."'";
			}else{

			$sex.=" OR personal_profile.gender='".$this->request->query['gender'][$i]."'";
			}
			}
			$sql.=" And (personal_profile.gender=$sex)";
		}


	
	}

	if(!empty($this->request->query['positionname']) ){

			$positionname=$this->request->query['positionname'];
			$this->set('title',$name);
			$sql.=" (And prof_exprience.role LIKE '%$positionname%' or current_working.role LIKE '%$positionname%')";

		}

	if(!empty($this->request->query['country_id']) ){

		$country_id=$this->request->query['country_id'];
		$sql.=" And (personal_profile.country_ids ='$country_id')";

	}

	if(!empty($this->request->query['state_id']) ){

		$state_id=$this->request->query['state_id'];
		$sql.=" And( personal_profile.state_id ='$state_id')";

		}


if(!empty($this->request->query['city_id'][0]) && $this->request->query['city_id']!=0){


	for($i=0;$i<count($this->request->query['city_id']);$i++){

				if($i==0){
					//$currency=$this->request->query['currency'][$i];
					$city_id="'".$this->request->query['city_id'][$i]."'";
				}else{
				
					$city_id.=" OR personal_profile.city_id='".$this->request->query['city_id'][$i]."'";
				}
			}
	


		 $sql.=" And (personal_profile.city_id=$city_id)"; 

	}

		if(!empty($this->request->query['wordsearch']) ){

			$wordsearch=$this->request->query['wordsearch'];
			$this->set('wordsearch',$wordsearch);
			$sql.=" And (prof_exprience.description LIKE '%$wordsearch%' or  prof_exprience.location LIKE '%$wordsearch%' or current_working.description LIKE '%$wordsearch%'or current_working.location LIKE '%$wordsearch%' or performance_desc.description LIKE '%$wordsearch%')";

		}

		if($this->request->query['latitude']){

			$latvalue=$this->request->query['latitude'];
			$sql.=" And( personal_profile.lat ='$latvalue')";

		}

		if($this->request->query['longitude']){

			$longvalue=$this->request->query['longitude'];
			$sql.=" And( personal_profile.longs ='$longvalue')";

		}

		if($this->request->query['clatitude']){

			$latvalue=$this->request->query['clatitude'];
			$sql.=" And( personal_profile.current_lat ='$latvalue')";

		}

		if($this->request->query['clatitude']){

			$longvalue=$this->request->query['clatitude'];
			$sql.=" And( personal_profile.current_long ='$longvalue')";

		}
		if(!empty($this->request->query['currentlyworking'])){
			$currentlyworking=$this->request->query['currentlyworking'];
			$sql.=" And( current_working.name LIKE '%$currentlyworking%')";
		}

		if(!empty($this->request->query['within']) ){

					$within=$this->request->query['within'];
				if(!empty($this->request->query['skill']) ){

				$skill=$this->request->query['skill'];
				$this->set('title',$name);
				//$have.=" and cdistance <='$within'";
				$having.="having distance <='$within' and skill Like '%$skill%'";

				}else{
					$having.="having distance <='$within'";
				}

		}

		if(!empty($this->request->query['cwithin']) ){

					$within=$this->request->query['cwithin'];
				if(!empty($this->request->query['skill']) ){

				$skill=$this->request->query['skill'];
				$this->set('title',$name);
				//$have.=" and cdistance <='$within'";
				$having.="having cdistance <='$within' and skill Like '%$skill%'";

				}else{
					$having.="having cdistance <='$within'";
				}

		}
				if(!empty($this->request->query['active']) && $this->request->query['active']!=0){
					if($this->request->query['active']==1){
						$days=45;
					}else if($this->request->query['active']==2){
						$days=60;
					}else if($this->request->query['active']==3){
						$days=90;
					}else{
						$days=180;
					}
				
			
			$sql.=" And TIMESTAMPDIFF(DAY,users.last_login,NOW()) >'$days'"; 
			$this->set('day',$this->request->query['active']);
		}

		if($this->request->query['experyear']) {
					$year=$this->request->query['experyear'];
					$myexpyear=explode(",", $year);
				if(!empty($this->request->query['skill']) ){

				
				$having.=" and yearexpe<='$myexpyear[0]'and yearexpe>='$myexpyear[1] ";

				}else{
					$having.="having yearexpe<='$myexpyear[0]'and yearexpe>='$myexpyear[1] '";
				}
				
				
			
		}





  }
// Advance search End
if($_SESSION['advanceprofiesearchdata'] && $this->request->query['refine']==2){ 

	if(!empty($_SESSION['advanceprofiesearchdata']['profiletitle']) ){

				$profiletitle=$_SESSION['advanceprofiesearchdata']['profiletitle'];
				$this->set('title',$name);
				$sql.=" And (professinal_info.profile_title LIKE '%$profiletitle%')";

			}

	
if(empty($_SESSION['advanceprofiesearchdata']['within']) && empty($_SESSION['advanceprofiesearchdata']['cwithin'])) {
		if(!empty($_SESSION['advanceprofiesearchdata']['skill']) ){

			$skill=$_SESSION['advanceprofiesearchdata']['skill'];
			
			$having.="having skill Like '%$skill%'";

		}
	}

		if(!empty($_SESSION['advanceprofiesearchdata']['gender'])) {
	
			if(in_array( "a",$_SESSION['advanceprofiesearchdata']['gender'])){

			}else{
	
			for($i=0;$i<count($_SESSION['advanceprofiesearchdata']['gender']);$i++){

			if($i==0){
		
			$sex="'".$_SESSION['advanceprofiesearchdata']['gender'][$i]."'";
			}else{

			$sex.=" OR personal_profile.gender='".$_SESSION['advanceprofiesearchdata']['gender'][$i]."'";
			}
			}
			$sql.=" And (personal_profile.gender=$sex)";
		}


	
	}

	if(!empty($_SESSION['advanceprofiesearchdata']['positionname']) ){

			$positionname=$_SESSION['advanceprofiesearchdata']['positionname'];
			$this->set('title',$name);
			$sql.=" (And prof_exprience.role LIKE '%$positionname%' or current_working.role LIKE '%$positionname%')";

		}

	if(!empty($_SESSION['advanceprofiesearchdata']['country_id']) ){

		$country_id=$_SESSION['advanceprofiesearchdata']['country_id'];
		$sql.=" And (personal_profile.country_ids ='$country_id')";

	}

	if(!empty($_SESSION['advanceprofiesearchdata']['state_id']) ){

		$state_id=$_SESSION['advanceprofiesearchdata']['state_id'];
		$sql.=" And( personal_profile.state_id ='$state_id')";

		}


if(!empty($_SESSION['advanceprofiesearchdata']['city_id'][0]) && $_SESSION['advanceprofiesearchdata']['city_id']!=0){


	for($i=0;$i<count($_SESSION['advanceprofiesearchdata']['city_id']);$i++){

				if($i==0){
					//$currency=$_SESSION['advanceprofiesearchdata']['currency'][$i];
					$city_id="'".$_SESSION['advanceprofiesearchdata']['city_id'][$i]."'";
				}else{
				
					$city_id.=" OR personal_profile.city_id='".$_SESSION['advanceprofiesearchdata']['city_id'][$i]."'";
				}
			}
	


		 $sql.=" And (personal_profile.city_id=$city_id)"; 

	}

		if(!empty($_SESSION['advanceprofiesearchdata']['wordsearch']) ){

			$wordsearch=$_SESSION['advanceprofiesearchdata']['wordsearch'];
			$this->set('wordsearch',$wordsearch);
			$sql.=" And (prof_exprience.description LIKE '%$wordsearch%' or  prof_exprience.location LIKE '%$wordsearch%' or current_working.description LIKE '%$wordsearch%'or current_working.location LIKE '%$wordsearch%' or performance_desc.description LIKE '%$wordsearch%')";

		}

		if($_SESSION['advanceprofiesearchdata']['latitude']){

			$latvalue=$_SESSION['advanceprofiesearchdata']['latitude'];
			$sql.=" And( personal_profile.lat ='$latvalue')";

		}

		if($_SESSION['advanceprofiesearchdata']['longitude']){

			$longvalue=$_SESSION['advanceprofiesearchdata']['longitude'];
			$sql.=" And( personal_profile.longs ='$longvalue')";

		}

		if($_SESSION['advanceprofiesearchdata']['clatitude']){

			$latvalue=$_SESSION['advanceprofiesearchdata']['clatitude'];
			$sql.=" And( personal_profile.current_lat ='$latvalue')";

		}

		if($_SESSION['advanceprofiesearchdata']['clatitude']){

			$longvalue=$_SESSION['advanceprofiesearchdata']['clatitude'];
			$sql.=" And( personal_profile.current_long ='$longvalue')";

		}
		if(!empty($_SESSION['advanceprofiesearchdata']['currentlyworking'])){
			$currentlyworking=$_SESSION['advanceprofiesearchdata']['currentlyworking'];
			$sql.=" And( current_working.name LIKE '%$currentlyworking%')";
		}

		if(!empty($_SESSION['advanceprofiesearchdata']['within']) ){

					$within=$_SESSION['advanceprofiesearchdata']['within'];
				if(!empty($_SESSION['advanceprofiesearchdata']['skill']) ){

				$skill=$_SESSION['advanceprofiesearchdata']['skill'];
				$this->set('title',$name);
				//$have.=" and cdistance <='$within'";
				$having.="having distance <='$within' and skill Like '%$skill%'";

				}else{
					$having.="having distance <='$within'";
				}

		}

		if(!empty($_SESSION['advanceprofiesearchdata']['cwithin']) ){

					$within=$_SESSION['advanceprofiesearchdata']['cwithin'];
				if(!empty($_SESSION['advanceprofiesearchdata']['skill']) ){

				$skill=$_SESSION['advanceprofiesearchdata']['skill'];
				$this->set('title',$name);
				//$have.=" and cdistance <='$within'";
				$having.="having cdistance <='$within' and skill Like '%$skill%'";

				}else{
					$having.="having cdistance <='$within'";
				}

		}

		if($_SESSION['advanceprofiesearchdata']['experyear']) {
					$year=$_SESSION['advanceprofiesearchdata']['experyear'];
					$myexpyear=explode(",", $year);
				if(!empty($_SESSION['advanceprofiesearchdata']['skill']) ){

				
				$having.=" and yearexpe<='$myexpyear[0]'and yearexpe>='$myexpyear[1] ";

				}else{
					$having.="having yearexpe<='$myexpyear[0]'and yearexpe>='$myexpyear[1] '";
				}
				
				
			
		}

}
  // Session Wtih search



  //

	
 $sql.=" group by users.id ".$having." order by order_num"; 
$con = ConnectionManager::get('default');
$searchdata = $con->execute($sql)->fetchAll('assoc');
$title=$this->request->query['name'];
if(!empty($title)) {
			$this->set('title',$title);
		$use=array('Profile.name LIKE'=>'%'.trim($title).'%','Users.role_id'=>'2','Users.id !='=>$user_id);
		$prr[]=$use;

	}else{
		$use=array('Users.role_id'=>'2','Users.id !='=>$user_id);
		$prr[]=$use;

	}
$searchforvital = $this->Profile->find('all')->contain(['Users'=>array('Uservital'=>array('Vques','Voption'))])->where($prr)->toarray();

$querytionarray=array();
foreach($searchforvital as $value){
		foreach($value['user']['uservital'] as $vital){

			if($vital['option_value_id']){

				if($vital['option_type_id']!=3 && $vital['option_type_id']!=4 && $vital['option_type_id']!=2 ) {
				$querytionarray[$vital['vque']['question']][$vital['voption']['id']]=$vital['voption']['value'];
					}
			}

			

	}

}


$this->set('myvital', $querytionarray);

$this->set('searchdata',$searchdata);
$this->set(compact('$this->request->query'));



    }


    public function savesearchprofileresult(){

	$this->loadModel('Savejobsearch');
	if ($this->request->is(['post', 'put'])){

	$Savejobsearch = $this->Savejobsearch->newEntity();
	if($_SESSION['Profilerefinedata']){

	$this->request->data['user_id']=$this->request->session()->read('Auth.User.id');

	$this->request->data['query']=$_SESSION['Profilerefinedata'];
	$this->request->data['savewhere']=2;
	
	$saveprofiledata = $this->Savejobsearch->patchEntity($Savejobsearch, $this->request->data);
	$savedprofile = $this->Savejobsearch->save($saveprofiledata);
	$response=array();
		if($savedprofile){
			$response['success']=1;
				}
	

	}else{
		$response['success']=0;
	}
echo json_encode($response); die;

}
	
}


public function refineprofileshow(){
$this->loadModel('Savejobsearch');
$user_id = $this->request->session()->read('Auth.User.id');
$Savejobsdata = $this->Savejobsearch->find('all')->where(['Savejobsearch.user_id'=>$user_id,'Savejobsearch.savewhere'=>2])->order(['Savejobsearch.id' => 'DESC'])->toarray();
		$this->set('savedata',$Savejobsdata);
}
public function viewrefineprofile( $id ){
	

	$this->loadModel('Savejobsearch');
	$this->loadModel('Profile');
$Savejobsdataviewfilter = $this->Savejobsearch->find('all')->where(['Savejobsearch.id'=>$id])->order(['Savejobsearch.id' => 'DESC'])->first()->toarray();
$query=$Savejobsdataviewfilter['query'];
$con = ConnectionManager::get('default');
$searchdata = $con->execute($query)->fetchAll('assoc');
$title=$this->request->query['name'];
$user_id=$this->request->session()->read('Auth.User.id');
if(!empty($title)) {
			$this->set('title',$title);
		$use=array('Profile.name LIKE'=>'%'.trim($title).'%','Users.role_id'=>'2','Users.id !='=>$user_id);
		$prr[]=$use;

	}else{
		$use=array('Users.role_id'=>'2','Users.id !='=>$user_id);
		$prr[]=$use;

	}
$searchforvital = $this->Profile->find('all')->contain(['Users'=>array('Uservital'=>array('Vques','Voption'))])->where($prr)->toarray();

$querytionarray=array();
foreach($searchforvital as $value){
		foreach($value['user']['uservital'] as $vital){

			if($vital['option_value_id']){

				if($vital['option_type_id']!=3 && $vital['option_type_id']!=4 && $vital['option_type_id']!=2 ) {
				$querytionarray[$vital['vque']['question']][$vital['voption']['id']]=$vital['voption']['value'];
					}
			}

			

	}

}
$this->set('myvital', $querytionarray);
$this->set('searchdata',$searchdata);
$this->set(compact('$this->request->query'));


		
}

// function for  event type

public function eventtypes($id=null){
		$this->loadModel('Eventtype');
		
	$Eventtype = $this->Eventtype->find('list')->where(['Eventtype.status'=>'Y'])->select(['id','name'])->toarray();

	    $this->set('Eventtype', $Eventtype);


}

}





