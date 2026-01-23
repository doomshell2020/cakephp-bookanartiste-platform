<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
class TranscationController extends AppController
{       
	public function initialize(){	
		parent::initialize();
	}
	 
	/*======================================
	*For all transactions page....
	*=======================================
	*/
	public function index(){ 

		
		$this->loadModel('Users');
		$this->loadModel('Transcation');
		$this->viewBuilder()->layout('admin');
		$cond=[];
		$this->request->session()->write('invoice_transaction_filter',$cond);
		$transcation = $this->Transcation->find('all')->contain(['Users'=>['Profile']])->where([])->order(['Transcation.id' => 'DESC'])->toarray();
		$this->set(compact('transcation'));

		$this->loadModel('Country');
	    //$country = $this->Country->find('list')->select(['id','name'])->toarray();
	    $country = $this->Transcation->find('all')->select(['Country.name','Country.id'])->contain(['Users'=>['Profile'=>['Country']]])->group(['Country.id'])->toarray();
	   // $country = $this->Users->find('all')->select(['Country.name','Country.id'])->contain(['Profile'=>['Country']])->where(['Users.role_id'=>TALANT_ROLEID])->order(['Country.name' => 'ASC'])->toarray();
	    //pr($country); die;
	    $this->set('country', $country);

	}



	public function search(){ 
		$this->loadModel('Users');
		$this->loadModel('Transcation');
		$paystatus = $this->request->data['paystatus'];
		$name = $this->request->data['name'];
		$email = $this->request->data['email'];
		$from_date = $this->request->data['from_date'];
		$to_date = $this->request->data['to_date'];
		$country_id = $this->request->data['country_id'];
		$state_id = $this->request->data['state_id'];
		$city_id = $this->request->data['city_id'];

		$transcationtype = $this->request->data['transcationtype'];
		$transactionby = $this->request->data['transactionby'];
		$packsts = $this->request->data['packsts'];
		$invoicenum = $this->request->data['invoicenum'];
		$cond = [];
		
		if(!empty($status))
		{
			$cond['Transcation.status'] = $paystatus;
		}
		if(!empty($invoicenum))
		{
			$cond['Transcation.id'] = $invoicenum;
		}
		if(!empty($transcationtype))
		{
			$cond['Transcation.description']= $transcationtype;
		}
		if(!empty($name)  )
		{
			$cond['Users.user_name LIKE']= "%".$name."%";
		}
		if(!empty($email)  )
		{
			$cond['Users.email LIKE']= "%".$email."%";
		}
		if(!empty($transactionby)  )
		{
			$cond['Users.role_id']= $transactionby;
		}
		if(!empty($transactionby)  )
		{
			$cond['Users.role_id']= $transactionby;
		}
		if(!empty($from_date))
        {
            $cond['DATE(Transcation.created) >=']=date('Y-m-d',strtotime($from_date));
        }
        if(!empty($to_date))
        { 
            $cond['DATE(Transcation.created) <=']=date('Y-m-d',strtotime($to_date));
        }
        if(!empty($country_id))
	    {
			$cond['Profile.phonecountry'] =$country_id;
	    }
	    if(!empty($state_id))
	    {
			$cond['Profile.state_id']=$state_id;
	    }
	    if(!empty($city_id))
	    {
			$cond['Profile.city_id']=$city_id;
	    }
	    $this->request->session()->write('invoice_transaction_filter',$cond);
		$transcation = $this->Transcation->find('all')->contain(['Users'=>['Profile']])->where($cond)->order(['Transcation.id' => 'DESC'])->toarray();
		$this->set('transcation',$transcation);
	}


	public function exporttransaction()
	{

		$this->autoRender=false;
		$blank="NA";
		$output="";
		$output .= '"Sr Number",';
		$output .= '"Name of Purchaser",';
		$output .= '"Email of Purchaser",';
		$output .= '"Invoice Number",';
		$output .= '"Package Name",';
		$output .= '"Quantity",';
		$output .= '"Payment Gateway",';
		$output .= '"Total Amount",';
		$output .= '"Tax",';
		$output .= '"Total Bill Amount",';
		$output .= '"Payment Status",';
		$output .="\n";
	    //pr($job); die;
		$str="";
		
		$cond = $this->request->session()->read('invoice_transaction_filter');
		
		$transcation = $this->Transcation->find('all')->contain(['Users'=>['Profile']])->where($cond)->order(['Transcation.id' => 'DESC'])->toarray();
	    //pr($talents); die;
		$cnt=1; 
		foreach($transcation as $talent_data){ 
			$this->loadModel('Users');
			$crdate=date("d-M-Y",strtotime($talent_data['created']));

		if ($talent_data['description']=='PAR') 
        {
          $packtype="Post a Requirement";
          $unit="01 Units";
        }
        elseif ($talent_data['description']=='PP') 
        {
          $packtype="Profile Package";
          $unit="01 Units";
        }
        elseif ($talent_data['description']=='RP') 
        {
          $packtype="Recruiter Package";
          $unit="01 Units";
        }
        elseif ($talent_data['description']=='PG') 
        {
          $packtype="Ping";
          $unit="01 Units";
        }
        elseif ($talent_data['description']=='PQ') 
        {
          $packtype="Paid Quote Sent";
          $unit="01 Units";
        }
        elseif ($talent_data['description']=='AQ') 
        {
          $packtype="Ask for Quote";
          $unit="01 Units";
        }
        elseif ($talent_data['description']=='PA') 
        {
          $packtype="Profile Advertisement";
          $unit=$talent_data['number_of_days']."/days";
        }
        elseif ($talent_data['description']=='JA') 
        {
          $packtype="Job Advertisement";
          $unit=$talent_data['number_of_days']."/days";
        }
        elseif ($talent_data['description']=='BNR') 
        {
          $packtype="Banner";
          $unit=$talent_data['number_of_days']."/days";
        }
        elseif ($talent_data['description']=='FJ') 
        {
          $packtype="Feature Job";
          $unit=$talent_data['number_of_days']."/days";
        }
        elseif ($talent_data['description']=='FP') 
        {
          $packtype="Feature Profile";
          $unit=$talent_data['number_of_days']."/days";
        }
        else{
          $packtype="N/A";
        }
			$output.=$cnt.",";
			$output.=$talent_data['user']['user_name'].",";
			$output.=$talent_data['user']['email'].",";
			
			
            if ($invoice==1) {
				$output.="INV-".$talent_data['description']."-".$crdate."-".$talent_data['id'].",";
			}else{
				$output.="REC-".$talent_data['description']."-".$crdate."-".$talent_data['id'].",";
			}
			
			$output.=$packtype.",";
			$output.=$unit.",";
			$output.=$talent_data['payment_method'].",";
			if ($talent_data['before_tax_amt']>0) {
				$output.="$".$talent_data['before_tax_amt'].",";
			}else{
				$output.="$0 ,";
			}

			$totaltax=$talent_data['GST']+$talent_data['CGST']+$talent_data['SGST'];
			$alltax=$talent_data['before_tax_amt']*$totaltax/100;
			if ($alltax>0) {
				$output.=$alltax.",";
			}else{
				$output.="0 ,";				
			}
			$output.=$talent_data['amount'].",";
			if ($talent_data['status']=='Y') {
				$output.="Paid,";	
			}else{
				$output.="Declined,";	
			}
			

			$cnt++;
			$output .="\r\n";
		}
		
		$filename = "Transaction invoices.xlsx";
		header('Content-type: application/xlsx');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
		die;
		$this->redirect($this->referer());
	}
	
	
	public function details($trid=null){ 
		$this->loadModel('Users');
		$this->loadModel('Subscription');
		$this->loadModel('Transcation');

		$transcation = $this->Transcation->find('all')->where(['id'=>$trid])->first();
		
		//$this->set('transcation',$transcation);
		if ($transcation['subscription_id']) {
			$subscription = $this->Subscription->find('all')->contain(['Users'=>['Profile']])->where(['Subscription.id'=>$transcation['subscription_id']])->first();
			//pr($subscription);
			$this->set('subscription',$subscription);
		}else{
			$this->set('transcation',$transcation);
		}

	}
	
	public function getStates()

	{
		$this->loadModel('TalentAdmin');
		$this->loadModel('State');
		$states = array();
		if (isset($this->request->data['id']))
		{
			$states = $this->Transcation->find('all')->select(['State.name','State.id'])->contain(['Users'=>['Profile'=>['State']]])->group(['State.id'])->toarray();
			foreach($states as $states_data)
			{
				$state_id = $states_data['State']['id'];
				$countryarr[$state_id] = $states_data['State']['name'];
			}
		}
		header('Content-Type: application/json');
		echo json_encode($countryarr);
		exit();
	}

	public function getcities()
	{
		$this->loadModel('TalentAdmin');
		$this->loadModel('City');
		$cities = array();
		if (isset($this->request->data['id']))
		{
		
			$cities = $this->Transcation->find('all')->select(['City.name','City.id'])->contain(['Users'=>['Profile'=>['City']]])->group(['City.id'])->toarray();
		//pr($cities); die;
			foreach($cities as $cities_data)
			{
				$city_id = $cities_data['City']['id'];
				$countryarr[$city_id] = $cities_data['City']['name'];
			}
		}
		header('Content-Type: application/json');
		echo json_encode($countryarr);
		exit();
	}

	// ======================================For all transactions page end....=========================================
	
	// ======================================For all transactions Receipts page....=========================================
	public function receipt(){ 

		
		$this->loadModel('Users');
		$this->loadModel('Transcation');
		$this->viewBuilder()->layout('admin');
		$cond=[];
		$this->request->session()->write('receipt_filter',$cond);

		$transcation = $this->Transcation->find('all')->contain(['Users'=>['Skillset'=>['Skill'],'Profile'=>['Country','State','City']]])->order(['Transcation.id' => 'DESC'])->toarray();
		$this->set(compact('transcation'));
		//pr($transcation); die;
		$this->loadModel('Country');
	    $country = $this->Transcation->find('all')->select(['Country.name','Country.id'])->contain(['Users'=>['Profile'=>['Country']]])->group(['Country.id'])->toarray();
	   
	    $this->set('country', $country);

	}


	

	public function searchreceipt(){ 
		$this->loadModel('Users');
		$this->loadModel('Transcation');
		$paystatus = $this->request->data['paystatus'];
		$name = $this->request->data['name'];
		$email = $this->request->data['email'];
		$from_date = $this->request->data['from_date'];
		$to_date = $this->request->data['to_date'];
		$country_id = $this->request->data['country_id'];
		$state_id = $this->request->data['state_id'];
		$city_id = $this->request->data['city_id'];

		$transcationtype = $this->request->data['transcationtype'];
		$transactionby = $this->request->data['transactionby'];
		$packsts = $this->request->data['packsts'];
		$invoicenum = $this->request->data['invoicenum'];
		$cond = [];
		
		if(!empty($status))
		{
			$cond['Transcation.status'] = $paystatus;
		}
		if(!empty($invoicenum))
		{
			$cond['Transcation.id'] = $invoicenum;
		}
		if(!empty($transcationtype))
		{
			$cond['Transcation.description']= $transcationtype;
		}
		if(!empty($name)  )
		{
			$cond['Users.user_name LIKE']= "%".$name."%";
		}
		if(!empty($email)  )
		{
			$cond['Users.email LIKE']= "%".$email."%";
		}
		if(!empty($transactionby)  )
		{
			$cond['Users.role_id']= $transactionby;
		}
		if(!empty($transactionby)  )
		{
			$cond['Users.role_id']= $transactionby;
		}
		if(!empty($from_date))
        {
            $cond['DATE(Transcation.created) >=']=date('Y-m-d',strtotime($from_date));
        }
        if(!empty($to_date))
        { 
            $cond['DATE(Transcation.created) <=']=date('Y-m-d',strtotime($to_date));
        }
        if(!empty($country_id))
	    {
			$cond['Profile.phonecountry'] =$country_id;
	    }
	    if(!empty($state_id))
	    {
			$cond['Profile.state_id']=$state_id;
	    }
	    if(!empty($city_id))
	    {
			$cond['Profile.city_id']=$city_id;
	    }
	    $this->request->session()->write('receipt_filter',$cond);
	    
		$transcation = $this->Transcation->find('all')->contain(['Users'=>['Skillset'=>['Skill'],'Profile'=>['Country','State','City']]])->where($cond)->order(['Transcation.id' => 'DESC'])->toarray();
		$this->set(compact('transcation'));
	}

	// Export Receipt manager 
	public function exportreceipt($invoice=null)
	{

		$this->autoRender=false;
		$blank="NA";
		$output="";
		$output .= '"Sr Number",';
		$output .= '"Name of Purchaser",';
		$output .= '"Email of Purchaser",';
		$output .= '"Skill",';
		$output .= '"Country",';
		$output .= '"State",';
		$output .= '"City",';
		if ($invoice==1) {
			$output .= '"Invoice Number",';
		}else{
			$output .= '"Receipt Number",';
		}
		$output .= '"Date of transaction",';
		$output .= '"Product type",';
		$output .= '"Quantity",';
		$output .= '"Total Amount",';
		$output .= '"Tax",';
		$output .= '"Total Bill Amount",';
		$output .= '"Referred By Name",';
		$output .= '"Referred By E Mail id",';
		$output .="\n";
	    //pr($job); die;
		$str="";
		if ($invoice==1) {
			$cond = $this->request->session()->read('invoice_filter');
		}else{
			$cond = $this->request->session()->read('receipt_filter');
		}
		$transcation = $this->Transcation->find('all')->contain(['Users'=>['Skillset'=>['Skill'],'Profile'=>['Country','State','City']]])->where($cond)->order(['Transcation.id' => 'DESC'])->toarray();

	    //pr($talents); die;
		$cnt=1; 
		foreach($transcation as $talent_data){ 
			$this->loadModel('Users');
			$crdate=date("d-M-Y",strtotime($talent_data['created']));

		if ($talent_data['description']=='PAR') 
        {
          $packtype="Post a Requirement";
          $unit="01 Units";
        }
        elseif ($talent_data['description']=='PP') 
        {
          $packtype="Profile Package";
          $unit="01 Units";
        }
        elseif ($talent_data['description']=='RP') 
        {
          $packtype="Recruiter Package";
          $unit="01 Units";
        }
        elseif ($talent_data['description']=='PG') 
        {
          $packtype="Ping";
          $unit="01 Units";
        }
        elseif ($talent_data['description']=='PQ') 
        {
          $packtype="Paid Quote Sent";
          $unit="01 Units";
        }
        elseif ($talent_data['description']=='AQ') 
        {
          $packtype="Ask for Quote";
          $unit="01 Units";
        }
        elseif ($talent_data['description']=='PA') 
        {
          $packtype="Profile Advertisement";
          $unit=$talent_data['number_of_days']."/days";
        }
        elseif ($talent_data['description']=='JA') 
        {
          $packtype="Job Advertisement";
          $unit=$talent_data['number_of_days']."/days";
        }
        elseif ($talent_data['description']=='BNR') 
        {
          $packtype="Banner";
          $unit=$talent_data['number_of_days']."/days";
        }
        elseif ($talent_data['description']=='FJ') 
        {
          $packtype="Feature Job";
          $unit=$talent_data['number_of_days']."/days";
        }
        elseif ($talent_data['description']=='FP') 
        {
          $packtype="Feature Profile";
          $unit=$talent_data['number_of_days']."/days";
        }
        else{
          $packtype="N/A";
        }
			$output.=$cnt.",";
			$output.=$talent_data['user']['user_name'].",";
			$output.=$talent_data['user']['email'].",";
			
			if($talent_data['user']['skillset']){
	            foreach ($talent_data['user']['skillset'] as $skillval) {
	              $skill=$skillval['skill']['name']." ";
	              $output.=$skill;
	            }
	            $output.=",";
	        }else{
	              $skill="Non-Talent"; 
	              $output.=$skill.",";
	        }
            if ($talent_data['user']['profile']['country']) {
				$output.=$talent_data['user']['profile']['country']['name'].",";
				$output.=$talent_data['user']['profile']['state']['name'].",";
				$output.=$talent_data['user']['profile']['city']['name'].",";
            }else{
            	$output.="N/A ,";
            	$output.="N/A ,";
            	$output.="N/A ,";
            }
            if ($invoice==1) {
				$output.="INV-".$talent_data['description']."-".$crdate."-".$talent_data['id'].",";
			}else{
				$output.="REC-".$talent_data['description']."-".$crdate."-".$talent_data['id'].",";
			}
			$output.=$crdate.",";
			$output.=$packtype.",";
			$output.=$unit.",";
			$output.=$talent_data['payment_method'].",";
			if ($talent_data['before_tax_amt']>0) {
				$output.="$".$talent_data['before_tax_amt'].",";
			}else{
				$output.="$0 ,";
			}

			$totaltax=$talent_data['GST']+$talent_data['CGST']+$talent_data['SGST'];
			$alltax=$talent_data['before_tax_amt']*$totaltax/100;
			if ($alltax>0) {
				$output.=$alltax.",";
			}else{
				$output.="0 ,";				
			}
			$output.=$talent_data['amount'].",";

			$talentrefers=$this->Users->find('all')->where(['id'=>$talent_data['user']['ref_by']])->first();
			if (isset($talentrefers)) {
           		$refrname= $talentrefers['user_name'];
           		$refemail= $talentrefers['email'];
	        }else{
	          	$refrname= "Self";
	          	$refemail= "Self";
	        }

			$output.=$refrname.",";
			$output.=$refemail.",";
			

			$cnt++;
			$output .="\r\n";
		}
		if ($invoice==1) {
			$filename = "invoices.xlsx";
		}else{
			$filename = "Receipts.xlsx";
		}
		header('Content-type: application/xlsx');
		header('Content-Disposition: attachment; filename='.$filename);
		echo $output;
		die;
		$this->redirect($this->referer());
	}
/*======================================
*For all transactions Receipts page end
*=======================================
*/


/*======================================
*For all transactions Invoice page....
*=======================================
*/
	public function invoice(){ 

		
		$this->loadModel('Users');
		$this->loadModel('Transcation');
		$this->viewBuilder()->layout('admin');
		$cond=[];
		$this->request->session()->write('invoice_filter',$cond);
		$transcation = $this->Transcation->find('all')->contain(['Users'=>['Skillset'=>['Skill'],'Profile'=>['Country','State','City']]])->order(['Transcation.id' => 'DESC'])->toarray();
		$this->set(compact('transcation'));
		//pr($transcation); die;
		$this->loadModel('Country');
	    $country = $this->Transcation->find('all')->select(['Country.name','Country.id'])->contain(['Users'=>['Profile'=>['Country']]])->group(['Country.id'])->toarray();
	   
	    $this->set('country', $country);

	}

	public function searchinvoice(){ 
		$this->loadModel('Users');
		$this->loadModel('Transcation');
		$paystatus = $this->request->data['paystatus'];
		$name = $this->request->data['name'];
		$email = $this->request->data['email'];
		$from_date = $this->request->data['from_date'];
		$to_date = $this->request->data['to_date'];
		$country_id = $this->request->data['country_id'];
		$state_id = $this->request->data['state_id'];
		$city_id = $this->request->data['city_id'];

		$transcationtype = $this->request->data['transcationtype'];
		$transactionby = $this->request->data['transactionby'];
		$packsts = $this->request->data['packsts'];
		$invoicenum = $this->request->data['invoicenum'];
		$cond = [];
		
		if(!empty($status))
		{
			$cond['Transcation.status'] = $paystatus;
		}
		if(!empty($invoicenum))
		{
			$cond['Transcation.id'] = $invoicenum;
		}
		if(!empty($transcationtype))
		{
			$cond['Transcation.description']= $transcationtype;
		}
		if(!empty($name)  )
		{
			$cond['Users.user_name LIKE']= "%".$name."%";
		}
		if(!empty($email)  )
		{
			$cond['Users.email LIKE']= "%".$email."%";
		}
		if(!empty($transactionby)  )
		{
			$cond['Users.role_id']= $transactionby;
		}
		if(!empty($transactionby)  )
		{
			$cond['Users.role_id']= $transactionby;
		}
		if(!empty($from_date))
        {
            $cond['DATE(Transcation.created) >=']=date('Y-m-d',strtotime($from_date));
        }
        if(!empty($to_date))
        { 
            $cond['DATE(Transcation.created) <=']=date('Y-m-d',strtotime($to_date));
        }
        if(!empty($country_id))
	    {
			$cond['Profile.phonecountry'] =$country_id;
	    }
	    if(!empty($state_id))
	    {
			$cond['Profile.state_id']=$state_id;
	    }
	    if(!empty($city_id))
	    {
			$cond['Profile.city_id']=$city_id;
	    }
	    $this->request->session()->write('invoice_filter',$cond);
		$transcation = $this->Transcation->find('all')->contain(['Users'=>['Skillset'=>['Skill'],'Profile'=>['Country','State','City']]])->where($cond)->order(['Transcation.id' => 'DESC'])->toarray();
		$this->set(compact('transcation'));
	}


	/*
	*Generate PDF file receipt and invoice according to $billtype numbers 1-2... 
	*for all manager where admin wants to generate receipt and invoice...
	*/

	public function billpdf($transcation_id=null,$billtype=null){
		//$this->viewBuilder()->layout('ajax');
		$this->response->type('pdf');
		$this->loadModel('Transcation');
		$transcation = $this->Transcation->find('all')->contain(['Users'=>['Skillset'=>['Skill'],'Profile'=>['Country','State','City']]])->where(['Transcation.id'=>$transcation_id])->order(['Transcation.id' => 'DESC'])->first();
		// pr($transcation); die;
		$this->set(compact('transcation','billtype'));
	}

}
