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

// Front side banner pages file...
class BannerController extends AppController
{


	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['autodecline', 'autodeclineforpaymentnotdone','auto_decline_for_payment_notdone']);
	}

	public function requestStatus()
	{
		//$this->request->session()->delete('action'); 
		$this->loadModel('Banner');
		$currentdate = date('Y-m-d H:m:s');
		$userid = $this->request->session()->read('Auth.User.id');

		$isBannernotifi = $this->Banner->updateAll(array('notifi' => 0), array('notifi' => 1, 'user_id' => $userid));

		$allbanner = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->where(['Banner.user_id' => $userid, 'Banner.banner_status' => 'Y', 'Banner.status !=' => 'R', 'DATE(Banner.banner_date_to) >=' => $currentdate])->order(['Banner.id' => 'desc'])->toarray();

		$approvedbanner = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->where(['Banner.user_id' => $userid, 'Banner.is_approved' => 1, 'Banner.status !=' => 'R', 'Banner.user_side_banner_status' => 'Y', 'DATE(Banner.banner_date_to) >=' => $currentdate])->order(['Banner.id' => 'desc'])->toarray();
		//pr($approvedbanner); die;

		$declinebanner = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->where(['Banner.user_id' => $userid, 'Banner.status' => 'R', 'DATE(Banner.banner_date_to) >=' => $currentdate, 'Banner.user_side_banner_status' => 'Y'])->toarray();

		$previousbanner = $this->Banner->find('all')->where(['Banner.user_id' => $userid, 'Banner.status' => 'Y', 'DATE(Banner.banner_date_to) <=' => $currentdate, 'Banner.user_side_banner_status' => 'Y', 'Banner.created >=' => date('Y-m-d', strtotime('-3 Months'))])->toarray();
		$this->set(compact('allbanner', 'approvedbanner', 'declinebanner', 'previousbanner'));
	}

	// public function delete($id,$action){ 
	// 	$this->loadModel('Banner');
	// //	echo $action; die;
	// $this->request->session()->delete('action'); 
	// 	$session = $this->request->session();
	// 		$session->write('action',$action);
	// 		$session->read('action');
	// 	// 	die;
	// 	// $Pack = $this->Banner->get($id);
	// 	// $Pack->user_side_banner_status='N';
	// 	// if ($this->Banner->save($Pack)) {
	// 		$this->Flash->success(__('The banner has been successfully deleted'));
	// 		return $this->redirect($this->referer());
	// 	//}
	// }

	public function delete($id)
	{
		$this->loadModel('Banner');
		$currentdate = date('Y-m-d H:m:s');
		$userid = $this->request->session()->read('Auth.User.id');
		$banner_id = $this->request->data['banner_id'];
		$action = $this->request->data['action'];
		//echo $banner_id; die;
		$Pack = $this->Banner->get($banner_id);
		$Pack->user_side_banner_status = 'N';
		if ($this->Banner->save($Pack)) {
			if ($action == "declined") {
				$count = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->where(['Banner.user_id' => $userid, 'Banner.status' => 'R', 'DATE(Banner.banner_date_to) >=' => $currentdate, 'Banner.user_side_banner_status' => 'Y'])->count();
			}
			if ($action == "previousbanners") {
				$count = $this->Banner->find('all')->where(['Banner.user_id' => $userid, 'Banner.status' => 'Y', 'DATE(Banner.banner_date_to) <=' => $currentdate, 'Banner.user_side_banner_status' => 'Y', 'Banner.created >=' => date('Y-m-d', strtotime('-3 Months'))])->count();
			}
			$data['action'] = $action;
			$data['count'] = $count;
			echo json_encode($data);
			die;
			//$this->Flash->success(__('The banner has been successfully deleted'));
			//return $this->redirect($this->referer());
		}
	}

	public function search()
	{
		$userid = $this->request->session()->read('Auth.User.id');
		$fromdate = \DateTime::createFromFormat('m d, Y H:i', $this->request->data['fromdate'])->format('Y-m-d');
		$todate = \DateTime::createFromFormat('m d, Y H:i', $this->request->data['todate'])->format('Y-m-d');
		$currentdate = date('Y-m-d H:m:s');
		$cond = [];
		if (isset($this->request->data['fromdate']) && $this->request->data['fromdate'] != '') {
			$cond['DATE(Banner.pay_date) >='] = $fromdate;
		}

		if (isset($this->request->data['todate']) && $this->request->data['todate'] != '') {
			$cond['DATE(Banner.pay_date) <='] = $todate;
		}

		//$previousbanner = $this->Banner->find('all')->where(['Banner.user_id'=>$userid,'Banner.status'=>'Y',$cond,'Banner.user_side_banner_status'=>'Y','Banner.created >='=>date('Y-m-d',strtotime('-3 Months'))])->toarray();

		$previousbanner = $this->Banner->find('all')->where([$cond, 'Banner.user_id' => $userid, 'Banner.status' => 'Y', 'DATE(Banner.banner_date_to) <=' => $currentdate, 'Banner.user_side_banner_status' => 'Y', 'Banner.created >=' => date('Y-m-d', strtotime('-3 Months'))])->toarray();
		$this->set('previousbanner', $previousbanner);
	}

	public function approvedsearch()
	{
		//pr($this->request->data); 
		$currentdate = date('Y-m-d H:m:s');
		$userid = $this->request->session()->read('Auth.User.id');
		$fromdate = date('Y-m-d', strtotime($this->request->data['fromdate']));
		$todate = date('Y-m-d', strtotime($this->request->data['todate']));

		$cond = [];
		if (isset($this->request->data['fromdate']) && $this->request->data['fromdate'] != '') {
			$cond['DATE(Banner.created) >='] = $fromdate;
		}

		if (isset($this->request->data['todate']) && $this->request->data['todate'] != '') {
			$cond['DATE(Banner.created) <='] = $todate;
		}
		$approvedbanner = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->where(['Banner.user_id' => $userid, 'Banner.is_approved' => 1, 'Banner.status !=' => 'R', 'Banner.user_side_banner_status' => 'Y', 'DATE(Banner.banner_date_to) >=' => $currentdate, $cond])->order(['Banner.id' => 'desc'])->toarray();

		$this->set('approvedbanner', $approvedbanner);
	}

	public function declinesearch()
	{
		$currentdate = date('Y-m-d H:m:s');
		$userid = $this->request->session()->read('Auth.User.id');
		$fromdate = date('Y-m-d', strtotime($this->request->data['fromdate']));
		$todate = date('Y-m-d', strtotime($this->request->data['todate']));

		$cond = [];
		if (isset($this->request->data['fromdate']) && $this->request->data['fromdate'] != '') {
			$cond['DATE(Banner.created) >='] = $fromdate;
		}

		if (isset($this->request->data['todate']) && $this->request->data['todate'] != '') {
			$cond['DATE(Banner.created) <='] = $todate;
		}
		$declinebanner = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->where(['Banner.user_id' => $userid, 'Banner.status' => 'R', 'DATE(Banner.banner_date_to) >=' => $currentdate, 'Banner.user_side_banner_status' => 'Y', $cond])->toarray();

		$this->set('declinebanner', $declinebanner);
	}

	public function auto_decline()
	{
		//	echo "tets"; die;   pay_date
		$this->autoRender = false;
		$currentdate = date('Y-m-d H:m:s');
		$all_declinebanner = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->where(['Banner.status' => 'N', 'Banner.status !=' => 'R', 'Banner.is_approved !=' => 1, 'DATE(Banner.banner_date_from) <' => $currentdate])->toarray();
		foreach ($all_declinebanner as $value) {
			$banner = $this->Banner->get($value['id']);
			$data['status'] = 'R';
			$data['is_approved'] = 0;
			$data['auto_decline'] = 1;
			$data['decline_reason'] = "Does not meet the website standards";
			$savepack = $this->Banner->patchEntity($banner, $data);
			$results = $this->Banner->save($savepack);
		}
	}

	public function autodecline()
	{
		$this->autoRender = false;
		$currentdate = date('Y-m-d H:m:s');
		$all_declinebanner = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->where(['Banner.status' => 'N', 'Banner.status !=' => 'R', 'Banner.is_approved !=' => 1, 'DATE(Banner.banner_date_from) <' => $currentdate])->toarray();
		foreach ($all_declinebanner as $value) {
			$banner = $this->Banner->get($value['id']);
			$data['status'] = 'R';
			$data['is_approved'] = 0;
			$data['auto_decline'] = 1;
			$data['decline_reason'] = "Does not meet the website standards";
			$savepack = $this->Banner->patchEntity($banner, $data);
			$results = $this->Banner->save($savepack);
		}
	}

	public function autodeclineforpaymentnotdone()
	{
		$this->autoRender = false;
		$currentdate = date('Y-m-d H:m:s');
		$all_banner = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->where(['Banner.is_approved' => 1, 'Banner.pay_date Is' => null, 'Banner.status !=' => 'R', 'DATE(Banner.banner_date_from) <' => $currentdate])->toarray();
		foreach ($all_banner as $value) {
			$banner = $this->Banner->get($value['id']);
			$data['status'] = 'R';
			$data['is_approved'] = 0;
			$data['auto_decline'] = 1;
			$data['decline_reason'] = "You did not Pay to proceed";
			$savepack = $this->Banner->patchEntity($banner, $data);
			$results = $this->Banner->save($savepack);
		}
	}

	public function auto_decline_for_payment_notdone()
	{
		//	echo "tets"; die;   pay_date
		$this->autoRender = false;
		$currentdate = date('Y-m-d H:m:s');
		//	pr($currentdate); die;
		$all_banner = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->where(['Banner.is_approved' => 1, 'Banner.pay_date Is' => null, 'Banner.status !=' => 'R', 'DATE(Banner.banner_date_from) <' => $currentdate])->toarray();
		//	pr($all_banner); die;
		foreach ($all_banner as $value) {
			$banner = $this->Banner->get($value['id']);
			$data['status'] = 'R';
			$data['is_approved'] = 0;
			$data['auto_decline'] = 1;
			$data['decline_reason'] = "You did not Pay to proceed";
			$savepack = $this->Banner->patchEntity($banner, $data);
			$results = $this->Banner->save($savepack);
		}
	}

	public function status($id, $status)
	{
		//	echo "test"; die;
		$this->loadModel('Banner');
		$Pack = $this->Banner->get($id);
		$Pack->status = $status;
		if ($this->Banner->save($Pack)) {
			if ($status == 'Y') {
				$this->Flash->success(__('The Banner with has been activated.', h($id)));
			} else {
				$this->Flash->success(__('The Banner with has been deactivated.', h($id)));
			}

			return $this->redirect(['action' => 'requestStatus']);
		}
	}
}
