<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;


class TestingalertsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['index', 'add','addsubscribe','contactservice','notifications']);
		//$this->loadComponent('Flash');  Include the FlashComponent
	}

public function index()
    {
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Requirement');
		    $this->loadModel('JobQuote');
	    $this->loadModel('JobApplication');
		$quotes = '';
		$applications = '';
		$uid = $this->request->session()->read('Auth.User.id');
		$role_id = $this->request->session()->read('Auth.User.role_id');
		
		
		$requirementfeatured = $this->Requirement->find('list')->where(['Requirement.user_id'=>$uid])->order(['Requirement.id' => 'DESC'])->toarray();
		
		foreach($requirementfeatured as $jobkey=>$value)
		{
		    $job_array[] = $jobkey;
		}

	
	
	




		
		/*if($role_id==TALANT_ROLEID)
		{
			$this->loadModel('JobApplication');
			$booking_req = $this->JobApplication->find('all')->contain(['Requirement'])->where(['JobApplication.user_id' =>$uid])->toarray();
			//pr($booking_req); 
			$this->set('booking_req',$booking_req);
			
			//pr($booking_req);
			
			// Ask quote request received
			$this->loadModel('JobQuote');
			$quote_req = $this->JobQuote->find('all')->contain(['Requirement'])->where(['JobQuote.viewedstatus' => 'N','JobQuote.user_id' =>$uid])->toarray();
			$this->set('quote_req',$quote_req);
		}	**/
    }

        
        
		
    
	

}
