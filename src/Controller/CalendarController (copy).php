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
class CalendarController extends AppController{
	
	
	
	
	
	public function initialize()
	{
	    parent::initialize();
	   
	}
	
	
	
	 public function calendar()
    {
		
		
		
	//$currentDate = $date_Year.'-'.$date_Month.'-'.$dayCount;
		$currentdate=date('Y-m-d');
		//pr($currentdate);
	$this->loadModel('Calendar');
	$eventNum = $this->Calendar->find('all')->where(['Calendar.from_date' => $currentdate])->count();
	$this->set('eventnum', $eventNum);
	
	//Reminder
	$reminderevent = $this->Calendar->find('all')->where(['Calendar.type' =>'RE'])->toarray();
	$this->set('reminderevent', $reminderevent);
	
	//ToDo
	$todoevent = $this->Calendar->find('all')->where(['Calendar.type' =>'TD'])->toarray();
	$this->set('todoevent', $todoevent);
	
	//Events
	$userevent = $this->Calendar->find('all')->where(['Calendar.type' =>'EV'])->toarray();
	$this->set('userevent', $userevent);
	
	//Bookings
	$bookingevent = $this->Calendar->find('all')->where(['Calendar.type' =>'RQ'])->toarray();
	$this->set('bookingevent', $bookingevent);
	
	
	
	
	
	
    }
	public function calendarinformation()
    {
		$this->autoRender=false;
		$eventListHTML = '';
		$type = $this->request->data['fun_type'];
		$informationdate = $this->request->data['date'];
	//$currentDate = $date_Year.'-'.$date_Month.'-'.$dayCount;
		$currentdate=date('Y-m-d');
	$this->loadModel('Calendar');
	
	$conn = ConnectionManager::get('default');
						$frnds = "SELECT from_date,title FROM calendar WHERE STR_TO_DATE(`from_date`,'%Y-%m-%d')  = '".$informationdate."'";
						$onlines = $conn->execute($frnds);	
						$event = $onlines ->fetchAll('assoc');
	
	//$event = $this->Calendar->find('all')->where(['Calendar.from_date' => $informationdate])->toarray();
	$events = count($event);
if($events > 0){
		$eventListHTML .= '<div class="modal-content">';
		$eventListHTML .= '<span class="close"><a href="#" onclick="close_popup("event_list")">×</a></span>';
		$eventListHTML .= '<h2>Events on '.date("l, d M Y",strtotime($informationdate)).'</h2>';
		$eventListHTML .= '<ul>';
		foreach($event as $eventrec){ 
			//pr($eventrec);
            $eventListHTML .= '<li>'.$eventrec['title'].'</li>';
        }
		$eventListHTML .= '</ul>';
		$eventListHTML .= '</div>';
	}
	echo $eventListHTML;
    }
	
	
	
	
	 public function calendarset()
    {

    }
	
	public function eventadd()
	{
		$this->autoRender=false;
		$this->loadModel('Calendar');
			if ($this->request->is(['post', 'put']))
			{
				//pr($this->request->data); die;
				$id = $this->request->session()->read('Auth.User.id');
				$this->request->data['from_date'] =$this->request->data['eventdate'];
				$this->request->data['title'] =$this->request->data['title'];
				$this->request->data['description'] =$this->request->data['desc'];
				$this->request->data['type'] =$this->request->data['reminder'];
				$this->request->data['user_id'] = $id;
				$proff = $this->Calendar->newEntity();
				$eventadd = $this->Calendar->patchEntity($proff,$this->request->data);
				if($this->Calendar->save($eventadd))
				{
					echo 'ok'; die;
				}
			}
	}
    
	
	
	
		
		
		
		
} 
