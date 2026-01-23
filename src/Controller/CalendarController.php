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

class CalendarController extends AppController
{

	public function initialize()
	{
		parent::initialize();
	}

	public function todaytask()
	{
		$this->loadModel('Calendar');

		$date = date('Y-m-d');
		$id = $this->request->session()->read('Auth.User.id');
		$conn = ConnectionManager::get('default');
		// $date =date("Y-m-d H:i:s");
		//Events
		// $userevent = $this->Calendar->find('all')->where(['Calendar.type' => 'EV', 'Calendar.user_id' => $id, 'Calendar.from_date <= ' => $date, 'Calendar.to_date >=' => $date])->toarray();
		$userevent = $this->Calendar->find('all')->where(['Calendar.type' => 'EV','Calendar.user_id' => $id,'DATE(Calendar.from_date)' => $date,// 'DATE(Calendar.to_date)' => $date
		])->toArray();
		$this->set('userevent', $userevent);

		//Reminder
		// $reminderevent = $this->Calendar->find('all')->where(['Calendar.type' => 'RE', 'Calendar.user_id' => $id, 'Calendar.from_date <= ' => $date, 'Calendar.to_date >=' => $date])->toarray();
		$reminderevent = $this->Calendar->find('all')->where(['Calendar.type' => 'RE','Calendar.user_id' => $id,'DATE(Calendar.from_date)' => $date,// 'DATE(Calendar.to_date)' => $date
		])->toArray();
		$this->set('reminderevent', $reminderevent);

		//ToDo
		// $todoevent = $this->Calendar->find('all')->where(['Calendar.type' => 'TD', 'Calendar.user_id' => $id, 'Calendar.from_date <= ' => $date, 'Calendar.to_date >=' => $date])->toarray();
		$todoevent = $this->Calendar->find('all')->where(['Calendar.type' => 'TD','Calendar.user_id' => $id,'DATE(Calendar.from_date)' => $date, // 'DATE(Calendar.to_date)' => $date
			])->toArray();
			$this->set('todoevent', $todoevent);
	}

	public function edit($id = null, $typeevent = null)
	{
		$this->loadModel('Calendar');
		
		
		$this->set('typeevent', $typeevent);
		
		$userid = $this->request->session()->read('Auth.User.id');
		$calenedit = $this->Calendar->find('all')->where(['Calendar.id' => $id, 'Calendar.user_id' => $userid])->first();
		$this->set('calenedit', $calenedit);

		if ($this->request->is(['post', 'put'])) {
			//	pr($this->request->data); die;
		
			$id = $this->request->session()->read('Auth.User.id');
			$this->request->data['from_date'] = date('Y-m-d H:i', strtotime($this->request->data['from_date']));
			$this->request->data['to_date'] = date('Y-m-d H:i', strtotime($this->request->data['to_date']));
			if ($this->request->data['type'] == 'TD') {
				$this->request->data['to_date'] = date('Y-m-d H:i', strtotime($this->request->data['from_date']));
			}


			$this->request->data['user_id'] = $id;
			$eventadd = $this->Calendar->patchEntity($calenedit, $this->request->data);
			
			if ($this->request->data['type'] == 'EV') {
				$eventtype = "Event";
			} else if ($this->request->data['type'] == 'RE') {
				$eventtype = "Reminder";
			} else {
				$eventtype = "To Do";
			}

			if ($this->Calendar->save($eventadd)) {
				$checkdatev = explode("/", $_SERVER['HTTP_REFERER']);

				if (count($checkdatev) == '7') {
					$this->Flash->success(__($eventtype . ' Saved Sddduccessfully'));
					$url = SITE_URL . "/calendar/calendarlist/" . $this->request->data['type'];
					return $this->redirect($url);
				} else {
					$this->Flash->success(__($eventtype . ' Saved Successfully'));
					$this->redirect(Router::url($this->referer(), true));
				}
			}
		}
	}

	public function delete($id)
	{

		$this->loadModel('Calendar');
		$Static = $this->Calendar->get($id);
		if ($this->Calendar->delete($Static)) {

			$this->Flash->success(__('Deleted Successfully'));
			$this->redirect(Router::url($this->referer(), true));
		}
	}

	public function calendarlist($typeevent = null, $eventid = null)
	{

		if ($eventid) {

			$this->set('eventid', $eventid);
			$this->Flash->success('', [
				'key' => 'calendardataget',
				'params' => [
					'eventid' => $eventid
				]
			]);
		}
		$this->loadModel('Calendar');
		$id = $this->request->session()->read('Auth.User.id');
		$this->set('typeevent', $typeevent);
		//Reminder
		$event = $this->Calendar->find('all')->where(['Calendar.type' => $typeevent, 'Calendar.user_id' => $id])->toarray();
		$this->set('event', $event);
	}

	public function pendingtask()
	{
		$this->loadModel('Calendar');
		$id = $this->request->session()->read('Auth.User.id');
		$currentdate = date('Y-m-d');
		$date = date("Y-m-d H:i:s");
			$this->set('typeevent', $typeevent);

		//Events
		// $userevent = $this->Calendar->find('all')->where(['Calendar.type' => 'EV', 'Calendar.user_id' => $id, 'Calendar.to_date <=' => $date])->toarray();
		// $this->set('userevent', $userevent);

		$userevent = $this->Calendar->find('all')->where(['Calendar.type' => 'EV', 'Calendar.user_id' => $id])->toarray();
		$this->set('userevent', $userevent);

		//Reminder
		// $reminderevent = $this->Calendar->find('all')->where(['Calendar.type' => 'RE', 'Calendar.user_id' => $id, 'Calendar.to_date <=' => $date])->toarray();
		// $this->set('reminderevent', $reminderevent);
		$reminderevent = $this->Calendar->find('all')->where(['Calendar.type' => 'RE', 'Calendar.user_id' => $id])->toarray();
		$this->set('reminderevent', $reminderevent);

		//ToDo
		// $todoevent = $this->Calendar->find('all')->where(['Calendar.type' => 'TD', 'Calendar.user_id' => $id, 'Calendar.to_date <=' => $date])->toarray();
		// $this->set('todoevent', $todoevent);
		$todoevent = $this->Calendar->find('all')->where(['Calendar.type' => 'TD', 'Calendar.user_id' => $id])->toarray();
		$this->set('todoevent', $todoevent);
	}

	public function calendar()
	{


		$id = $this->request->session()->read('Auth.User.id');
		//$currentDate = $date_Year.'-'.$date_Month.'-'.$dayCount;
		$currentdate = date('Y-m-d');
		//pr($currentdate);
		$this->loadModel('Calendar');
		$eventNum = $this->Calendar->find('all')->where(['Calendar.from_date' => $currentdate, 'Calendar.user_id' => $id])->count();
		$this->set('eventnum', $eventNum);


		//$schedule= $this->Calendar->find('all')->select(['publisheddate' => 'DATE(from_date)'])->where(['Calendar.user_id' => $id])->group('publisheddate')->toarray();
		//$this->set('schedule', $schedule);	

		$date = date("Y-m-d H:i:s");

		//pending event 
		$usereventcountpe = $this->Calendar->find('all')->where(['Calendar.type' => 'EV', 'Calendar.user_id' => $id, 'Calendar.to_date <=' => $date])->toarray();
		$this->set('userevent', $userevent);

		//Reminder
		$remindereventcountpe = $this->Calendar->find('all')->where(['Calendar.type' => 'RE', 'Calendar.user_id' => $id, 'Calendar.to_date <=' => $date])->toarray();
		$this->set('reminderevent', $reminderevent);

		//ToDo
		$todoeventcountpe = $this->Calendar->find('all')->where(['Calendar.type' => 'TD', 'Calendar.user_id' => $id, 'Calendar.to_date <=' => $date])->toarray();
		$this->set('todoevent', $todoevent);

		// $totalpendingtask = count($usereventcountpe) + count($reminderevent) + count($todoeventcountpe);
		// $this->set('totalpendingtask', $totalpendingtask);




		//Reminder
		$reminderevent = $this->Calendar->find('all')->where(['Calendar.type' => 'RE', 'Calendar.user_id' => $id])->toarray();
		$this->set('reminderevent', $reminderevent);

		//ToDo
		$todoevent = $this->Calendar->find('all')->where(['Calendar.type' => 'TD', 'Calendar.user_id' => $id])->toarray();
		$this->set('todoevent', $todoevent);

		//Events
		$userevent = $this->Calendar->find('all')->where(['Calendar.type' => 'EV', 'Calendar.user_id' => $id])->toarray();
		//  pr($userevent);exit;
		$this->set('userevent', $userevent);

		//Bookings
		$bookingevent = $this->Calendar->find('all')->where(['Calendar.type' => 'RQ', 'Calendar.user_id' => $id])->toarray();
		$this->set('bookingevent', $bookingevent);
		// count all pending task
		$totalpendingtask = count($reminderevent) + count($todoevent) + count($userevent);
	    $this->set('totalpendingtask', $totalpendingtask);


		$calendar = $this->Calendar->find('all')->toarray();
		foreach ($calendar as $value) {

			$cal['type'] = "Birthday";
			$cal['date'] = 15;
			$cal['month'] = 3;
			$cal['title'] = $value['title'];
			$cal['tagIndex'] = '1';
			$result[] = $cal;
		}
		$res = json_encode($result);
		$this->set('res', $res);
	}

	public function calendarinformation()
	{
		$this->autoRender = false;
		$eventListHTML = '';
		$type = $this->request->data['fun_type'];
		$informationdate = $this->request->data['date'];
		$currentdate = date('Y-m-d');
		$this->loadModel('Calendar');
		$id = $this->request->session()->read('Auth.User.id');
		$conn = ConnectionManager::get('default');
		$frnds = "SELECT from_date,title FROM calendar WHERE `user_id` ='" . $_SESSION['Auth']['User']['id'] . "' and    STR_TO_DATE(`from_date`,'%Y-%m-%d')  = '" . $informationdate . "' OR STR_TO_DATE(`to_date`,'%Y-%m-%d')  = '" . $informationdate . "' AND user_id ='" . $id . "'";
		$onlines = $conn->execute($frnds);
		$event = $onlines->fetchAll('assoc');
		$events = count($event);
		if ($events > 0) {
			$eventListHTML .= '<div class="modal-content">';
			$eventListHTML .= '<span class="close"><a href="#" onclick="close_popup("event_list")">×</a></span>';
			$eventListHTML .= '<h2>Events on ' . date("l, d M Y", strtotime($informationdate)) . '</h2>';
			$eventListHTML .= '<ul>';
			foreach ($event as $eventrec) {
				//pr($eventrec);
				$eventListHTML .= '<li>' . $eventrec['title'] . '</li>';
			}
			$eventListHTML .= '</ul>';
			$eventListHTML .= '</div>';
		}
		echo $eventListHTML;
	}

	public function calendarset()
	{

		$id = $this->request->session()->read('Auth.User.id');
		//$currentDate = $date_Year.'-'.$date_Month.'-'.$dayCount;
		$currentdate = date('Y-m-d');
		//pr($currentdate);
		$this->loadModel('Calendar');
		$eventNum = $this->Calendar->find('all')->where(['Calendar.from_date' => $currentdate, 'Calendar.user_id' => $id])->count();
		$this->set('eventnum', $eventNum);


		//$schedule= $this->Calendar->find('all')->select(['publisheddate' => 'DATE(from_date)'])->where(['Calendar.user_id' => $id])->group('publisheddate')->toarray();
		//$this->set('schedule', $schedule);	

		$date = date("Y-m-d H:i:s");

		//pending event 
		$usereventcountpe = $this->Calendar->find('all')->where(['Calendar.type' => 'EV', 'Calendar.user_id' => $id, 'Calendar.to_date <=' => $date])->toarray();
		$this->set('userevent', $userevent);

		//Reminder
		$remindereventcountpe = $this->Calendar->find('all')->where(['Calendar.type' => 'RE', 'Calendar.user_id' => $id, 'Calendar.to_date <=' => $date])->toarray();
		$this->set('reminderevent', $reminderevent);

		//ToDo
		$todoeventcountpe = $this->Calendar->find('all')->where(['Calendar.type' => 'TD', 'Calendar.user_id' => $id, 'Calendar.to_date <=' => $date])->toarray();
		$this->set('todoevent', $todoevent);

		$totalpendingtask = count($usereventcountpe) + count($remindereventcountpe) + count($todoeventcountpe);
		$this->set('totalpendingtask', $totalpendingtask);




		//Reminder
		$reminderevent = $this->Calendar->find('all')->where(['Calendar.type' => 'RE', 'Calendar.user_id' => $id])->toarray();
		$this->set('reminderevent', $reminderevent);

		//ToDo
		$todoevent = $this->Calendar->find('all')->where(['Calendar.type' => 'TD', 'Calendar.user_id' => $id])->toarray();
		$this->set('todoevent', $todoevent);

		//Events
		$userevent = $this->Calendar->find('all')->where(['Calendar.type' => 'EV', 'Calendar.user_id' => $id])->toarray();
		$this->set('userevent', $userevent);

		//Bookings
		$bookingevent = $this->Calendar->find('all')->where(['Calendar.type' => 'RQ', 'Calendar.user_id' => $id])->toarray();
		$this->set('bookingevent', $bookingevent);



		$calendar = $this->Calendar->find('all')->toarray();
		foreach ($calendar as $value) {

			$cal['type'] = "Birthday";
			$cal['date'] = 15;
			$cal['month'] = 3;
			$cal['title'] = $value['title'];
			$cal['tagIndex'] = '1';
			$result[] = $cal;
		}
		$res = json_encode($result);
		$this->set('res', $res);
	}

	public function calendardataevent($date, $eventtype)
	{
		$this->set('eventtypename', $eventtype);
		$this->loadModel('Calendar');
		$id = $this->request->session()->read('Auth.User.id');
		$conn = ConnectionManager::get('default');
		//$frnds = "SELECT from_date,title,to_date,description,location,remark,eventtype FROM calendar WHERE `user_id` ='".$id."' and    STR_TO_DATE(`from_date`,'%Y-%m-%d')  = '".$date."' OR STR_TO_DATE(`to_date`,'%Y-%m-%d')  >= '".$date."' AND user_id ='".$id."' AND type='".$eventtype."'";
		if ($eventtype == 'VA') {
			$event = 'EV';
			$reminder = 'RE';
			$todo = 'TD';
			// Event
			$eventfrnds = "SELECT id,from_date,title,to_date,type,description,location,remark,eventtype FROM calendar WHERE `type` ='" . $event . "' AND `user_id` ='" . $id . "' and  STR_TO_DATE(`from_date`,'%Y-%m-%d')  <= '" . $date . "' AND STR_TO_DATE(`to_date`,'%Y-%m-%d')  >= '" . $date . "' ";
			$onlinesevent = $conn->execute($eventfrnds);
			$eventview = $onlinesevent->fetchAll('assoc');
			$this->set('eventview', $eventview);
			// Reminder
			$reminderfrnds = "SELECT id,from_date,title,to_date,type,description,location,remark,eventtype FROM calendar WHERE `type` ='" . $reminder . "' AND `user_id` ='" . $id . "' and  STR_TO_DATE(`from_date`,'%Y-%m-%d')  <= '" . $date . "' AND STR_TO_DATE(`to_date`,'%Y-%m-%d')  >= '" . $date . "' ";
			$onlinesreminder = $conn->execute($reminderfrnds);
			$eventreminderview = $onlinesreminder->fetchAll('assoc');
			$this->set('eventreminderview', $eventreminderview);
			// ToDo 
			$todofrnds = "SELECT id,from_date,title,to_date,type,description,location,remark,eventtype FROM calendar WHERE `type` ='" . $todo . "' AND `user_id` ='" . $id . "' and  STR_TO_DATE(`from_date`,'%Y-%m-%d')  <= '" . $date . "' AND STR_TO_DATE(`to_date`,'%Y-%m-%d')  >= '" . $date . "' ";
			$onlinestodo = $conn->execute($todofrnds);
			$eventtodoview = $onlinestodo->fetchAll('assoc');
			$this->set('eventtodoview', $eventtodoview);
		} else {
			$frnds = "SELECT id,from_date,title,to_date,type,description,location,remark,eventtype FROM calendar WHERE `type` ='" . $eventtype . "' AND `user_id` ='" . $id . "' and  STR_TO_DATE(`from_date`,'%Y-%m-%d')  <= '" . $date . "' AND STR_TO_DATE(`to_date`,'%Y-%m-%d')  >= '" . $date . "' ";
			$onlines = $conn->execute($frnds);
			$event = $onlines->fetchAll('assoc');
			$this->set('event', $event);
		}



		/*
		if($eventtype=="TD"){
				$id = $this->request->session()->read('Auth.User.id');
			$conn = ConnectionManager::get('default');
			$frnds = "SELECT from_date,title FROM calendar WHERE `user_id` ='".$id."' and    STR_TO_DATE(`from_date`,'%Y-%m-%d')  = '".$date."' and type='TD' OR STR_TO_DATE(`to_date`,'%Y-%m-%d')  >= '".$date."' AND user_id ='".$id."'";
			$onlines = $conn->execute($frnds);	
			
			$event = $onlines ->fetchAll('assoc');


		}
		if($eventtype=="RE"){
			$id = $this->request->session()->read('Auth.User.id');
			$conn = ConnectionManager::get('default');
			$frnds = "SELECT from_date,title FROM calendar WHERE `user_id` ='".$id."' and    STR_TO_DATE(`from_date`,'%Y-%m-%d')  = '".$date."' AND type='RE' OR STR_TO_DATE(`to_date`,'%Y-%m-%d')  >= '".$date."' AND user_id ='".$id."'";
			$onlines = $conn->execute($frnds);	
			$event = $onlines ->fetchAll('assoc');


		}
		*/
	}

	public function addtocalendar()
	{

		$this->loadModel('Calendar');
		if ($this->request->is(['post', 'put'])) {
			//	pr($this->request->data); die;
			$id = $this->request->session()->read('Auth.User.id');
			$this->request->data['from_date'] = date('Y-m-d H:i', strtotime($this->request->data['from_date']));
			$this->request->data['to_date'] = date('Y-m-d H:i', strtotime($this->request->data['to_date']));
			if ($this->request->data['type'] == 'TD') {
				$this->request->data['to_date'] = date('Y-m-d H:i', strtotime($this->request->data['from_date']));
			}

			$this->request->data['user_id'] = $id;
			$proff = $this->Calendar->newEntity();
			$eventadd = $this->Calendar->patchEntity($proff, $this->request->data);
			if ($this->request->data['type'] == 'EV') {
				$eventtype = "Event";
			} else if ($this->request->data['type'] == 'RE') {
				$eventtype = "Reminder";
			} else {
				$eventtype = "To Do";
			}
			if ($this->Calendar->save($eventadd)) {
				$this->Flash->success(__($eventtype . ' Saved Successfully'));
				$this->redirect(['controller' => 'Calendar', 'action' => 'calendar']);
			}
		}
	}
}
