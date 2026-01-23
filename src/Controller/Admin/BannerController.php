<?php
//test
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class BannerController extends AppController
{
	public function initialize()
	{
		parent::initialize();
	}
	// For Talent Index
	public function index()
	{
		$this->loadModel('Banner');
		$this->viewBuilder()->layout('admin');

		//$isBannernotifi=$this->Banner->updateAll(array('notifi' =>0),array('notifi' =>2));


		$session = $this->request->session();
		$session->delete('bannerrequests');

		$banners = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->order(['Banner.id' => 'desc'])->where(['Banner.banner_status' => 'Y'])->toarray();
		$this->set('banners', $banners);
	}

	public function search()
	{
		$this->loadModel('Users');
		$this->loadModel('Banner');
		//pr($tcstatus); die;
		$status = $this->request->data['status'];
		$name = $this->request->data['name'];
		$email = $this->request->data['email'];
		$from_date = $this->request->data['from_date'];
		$to_date = $this->request->data['to_date'];
		$cond = [];



		if (!empty($status)) {
			$cond['Banner.status'] = $status;
		}
		if (!empty($name)) {
			$cond['Users.user_name LIKE'] = "%" . $name . "%";
		}
		if (!empty($email)) {
			$cond['Users.email LIKE'] = "%" . $email . "%";
		}

		if (!empty($from_date)) {
			$cond['DATE(Banner.created) >='] = date('Y-m-d', strtotime($from_date));
		}
		if (!empty($to_date)) {
			$cond['DATE(Banner.created) <='] = date('Y-m-d', strtotime($to_date));
		}
		$this->request->session()->write('bannerrequests', $cond);

		$banners = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->order(['Banner.id' => 'desc'])->where(['Banner.banner_status' => 'Y', $cond])->toarray();
		$this->set('banners', $banners);
	}


	public function bannerexcel()
	{
		$this->loadModel('Users');
		$this->loadModel('Banner');
		$this->autoRender = false;
		$userid = $this->request->session()->read('Auth.User.id');
		$blank = "NA";
		$output = "";

		$output .= '"Sr Number",';
		$output .= '"Banner Title",';
		$output .= '"Banner URL",';
		$output .= '"Banner From Date",';
		$output .= '"Banner End Date",';
		$output .= '"Total Price",';
		$output .= '"Requested By",';
		$output .= '"Requested By Email ID",';
		$output .= '"Status",';
		$output .= "\n";
		//pr($job); die;
		$str = "";

		$cond = $this->request->session()->read('bannerrequests');


		$banners = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->order(['Banner.id' => 'desc'])->where(['Banner.banner_status' => 'Y', $cond])->toarray();
		//pr($talents); die;
		$cnt = 1;
		foreach ($banners as $admin) {
			$fromdate = date('Y-m-d', strtotime($admin['banner_date_from']));
			$todate = date('Y-m-d', strtotime($admin['banner_date_to']));

			$output .= $cnt . ",";
			$output .= $admin['title'] . ",";
			$output .= $admin['bannerurl'] . ",";
			$output .= $fromdate . ",";
			$output .= $todate . ",";
			$output .= "$" . $admin['amount'] . ",";
			$output .= $admin['user']['user_name'] . ",";
			$output .= $admin['user']['email'] . ",";

			if ($admin['status'] == 'Y') {
				$output .= "Approved";
			} elseif ($admin['status'] == 'R') {
				$output .= "Declined";
			} else {
				$output .= "Pending";
			}

			$cnt++;
			$output .= "\r\n";
		}

		$filename = "Banner-Request.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		die;
		$this->redirect($this->referer());
	}

	//manage current home page banner image...
	public function managecurrentimg()
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('Banner');
		$currentdate = date('Y-m-d H:m:s');
		//echo $currentdate; die;
		$banner = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->where(['Banner.status' => 'Y', 'Banner.banner_status' => 'Y', 'Banner.banner_date_from <=' => $currentdate, 'Banner.banner_date_to >=' => $currentdate])->order(['banner_date_to' => 'ASC'])->toarray();
		//pr($banner); die;
		$this->set(compact('banner'));
	}



	//Create banner by admin...
	public function createbanner()
	{
		$this->viewBuilder()->layout('admin');
		$id = $this->request->session()->read('Auth.User.id');
		$banner = $this->Banner->newEntity();
		if ($this->request->is(['post', 'put'])) {
			if ($this->request->data['banner_image']['name'] != '') {
				$k = $this->request->data['banner_image'];
				$galls = $this->move_images($k);

				$this->FcCreateThumbnail("trash_image", "bannerimages/", $galls[0], $galls[0], "1368", "767");

				$this->request->data['banner_image'] = $galls[0];
				unlink('trash_image/' . $galls[0]);
			} else {
				$profileimage = $this->Banner->find('all')->where(['user_id' => $id])->first();
				$previmage = $profileimage['banner_image'];
				$this->request->data['banner_image'] = $previmage;
			}

			$this->request->data['user_id'] = $id;
			$this->request->data['status'] = 'Y';
			$this->request->data['banner_status'] = 'Y';
			if ($this->request->data['is_default_image'] == 0) {
				$this->request->data['banner_date_from'] = date('Y-m-d H:i', strtotime($this->request->data['banner_date_from']));
				$this->request->data['banner_date_to'] = date('Y-m-d H:i', strtotime($this->request->data['banner_date_to']));
			}

			$banners = $this->Banner->patchEntity($banner, $this->request->data);
			$savedbanners = $this->Banner->save($banners);
			$this->Flash->success(__('Home Page Banner Request Successfully Saved!!'));
			return $this->redirect(['action' => 'banner']);
		}
	}



	function editbanner($id)
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('Banner');
		$banner = $this->Banner->get($id);
		//pr($banner); die;
		$this->set('banner', $banner);
		if ($this->request->is(['post', 'put'])) {
			//pr($this->request->data); die;
			if ($this->request->data['banner_image']['name'] != '') {
				$k = $this->request->data['banner_image'];
				$galls = $this->move_images($k);
				$this->FcCreateThumbnail("trash_image", "bannerimages/", $galls[0], $galls[0], "1368", "767");
				$this->request->data['banner_image'] = $galls[0];
				unlink('trash_image/' . $galls[0]);
			} else {
				$this->request->data['banner_image'] = $banner['banner_image'];
			}

			$this->request->data['banner_date_from'] = date('Y-m-d H:i', strtotime($this->request->data['banner_date_from']));
			$this->request->data['banner_date_to'] = date('Y-m-d H:i', strtotime($this->request->data['banner_date_to']));
			$banners = $this->Banner->patchEntity($banner, $this->request->data);
			$savedbanners = $this->Banner->save($banners);
			$this->Flash->success(__('Home Page Banner updated Successfully!'));
			return $this->redirect(['action' => '/']);
		}
	}

	//reject or decline request...
	public function reject($id)
	{
		$bannerreject = $this->Banner->find('all')->order(['Banner.id' => 'ASC'])->where(['Banner.id' => $id])->first();
		$this->set('bannerreject', $bannerreject);
	}

	//reject or decline request...
	public function rejectbanner()
	{
		$this->loadModel('Banner');


		if ($this->request->is(['post', 'put'])) {
			$banner = $this->Banner->find('all')->contain(['Users'])->order(['Banner.id' => 'ASC'])->where(['Banner.id' => $this->request->data['bannerid']])->first();

			$bannerid = $this->Banner->get($this->request->data['bannerid']);
			$Pack['status'] = 'R';
			$Pack['notifi'] = 1;
			$Pack['decline_reason'] = $this->request->data['rejectdescription'];

			$saved = $this->Banner->patchEntity($bannerid, $Pack);

			if ($this->Banner->save($saved)) {


				$this->loadmodel('Templates');
				$profile = $this->Templates->find('all')->where(['Templates.id' => REJECTBANNER])->first();
				$subject = $profile['subject'];
				$from = $profile['from'];
				$fromname = $profile['fromname'];
				$to  = $banner['user']['email'];
				$name  = $banner['user']['user_name'];
				$formats = $profile['description'];
				$site_url = SITE_URL;
				$description = $this->request->data['rejectdescription'];
				$message1 = str_replace(array('{Name}', '{site_url}', '{description}'), array($name, $site_url, $description), $formats);
				$message = stripslashes($message1);
				$message = '
			<!DOCTYPE HTML>
			<html>
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<title>Mail</title>
			</head>
			<body style="padding:0px; margin:0px;font-family:Arial,Helvetica,sans-serif; font-size:13px;">
				' . $message1 . '
			</body>
			</html>
			';

				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				//$headers .= 'To: <'.$to.'>' . "\r\n";
				$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
				$emailcheck = mail($to, $subject, $message, $headers);
				$this->Flash->success(__('Banner Reject  Successfully'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('Banner Not Reject'));
				return $this->redirect(['action' => 'index']);
			}
		}
	}


	//accept banner request...
	public function banneramount($id = null, $amount = null)
	{
		$this->loadModel('Banner');

		if ($id && $amount) {
			$banner = $this->Banner->find('all')->contain(['Users'])->where(['Banner.id' => $id])->first();
			$fkey = rand(1, 10000);
			$bannerid = $this->Banner->get($id);

			$Packs['amount'] = $amount;
			$Packs['token'] = $fkey;
			$Packs['notifi'] = 1;
			$Packs['is_approved'] = 1;
			if ($Packs['is_approved'] == 1) {
				$today_date = date('Y-m-d h:s:i');
				$Packs['approval_date'] = date('Y-m-d', strtotime($today_date));
			}
			$saved = $this->Banner->patchEntity($bannerid, $Packs);

			if ($this->Banner->save($saved)) {

				$mid = base64_encode(base64_encode($id . '/' . $fkey));
				$url = SITE_URL . "/package/bannerpayment/" . $mid;

				$this->loadmodel('Templates');
				$profile = $this->Templates->find('all')->where(['Templates.id' => BANNERLINK])->first();
				$subject = $profile['subject'];
				$from = $profile['from'];
				$fromname = $profile['fromname'];
				$to  = $banner['user']['email'];
				$formats = $profile['description'];
				$name  = $banner['user']['user_name'];
				$site_url = SITE_URL;

				$message1 = str_replace(array('{Name}', '{site_url}', '{url}'), array($name, $site_url, $url), $formats);
				$message = stripslashes($message1);
				$message = '
				<!DOCTYPE HTML>
				<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<title>Mail</title>
				</head>
				<body style="padding:0px; margin:0px;font-family:Arial,Helvetica,sans-serif; font-size:13px;">
					' . $message1 . '
				</body>
				</html>
				';

				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				//$headers .= 'To: <'.$to.'>' . "\r\n";
				$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
				$emailcheck = mail($to, $subject, $message, $headers);
				$this->Flash->success(__('Banner Approved Sent Successfully'));
				return $this->redirect(['action' => 'index']);
			}
		} else {
			$this->Flash->error(__('Banner not approve'));
			return $this->redirect(['action' => 'index']);
		}
	}
	//For delete banner record from admin's view...
	public function delete($id)
	{
		$this->loadModel('Banner');
		$Pack = $this->Banner->get($id);
		$Pack->banner_status = 'N';
		if ($this->Banner->save($Pack)) {
			$this->Flash->success(__('The Banner with id: {0} has been deleted.', h($id)));
			return $this->redirect(['action' => 'index']);
		}
	}

	//Delete banner from views but record is save in detabase...
	public function parmanentdelete($id)
	{
		$this->loadModel('Banner');
		$bannerid = $this->Banner->get($id);
		$Pack['banner_status'] = 'N';
		$Pack['status'] = 'N';
		$saved = $this->Banner->patchEntity($bannerid, $Pack);
		if ($this->Banner->save($saved)) {
			$this->Flash->success(__('The Banner with id: {0} has been deleted.', h($id)));
			return $this->redirect(['action' => 'managecurrentimg']);
		}
	}

	public function approve($id)
	{
		$bannerapprove = $this->Banner->find('all')->order(['Banner.id' => 'ASC'])->where(['Banner.id' => $id])->first();
		$this->set('bannerapprove', $bannerapprove);
	}


	public function details($id)
	{

		$this->loadModel('Profile');
		try {
			$details = $this->Profile->find('all')->contain(['Country', 'State', 'City', 'Enthicity'])->where(['Profile.user_id' => $id])->first();

			$this->set('nontalentdetails', $details);
		} catch (FatalErrorException $e) {
			$this->log("Error Occured", 'error');
		}
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

	public function auto_decline_for_payment_notdone()
	{
		//	echo "tets"; die;   pay_date
		$this->autoRender = false;
		$currentdate = date('Y-m-d H:m:s');
		//	pr($currentdate); die;
		$all_banner = $this->Banner->find('all')->contain(['Users', 'Bannerpack'])->where(['Banner.is_approved' => 1, 'Banner.pay_date Is' => null, 'Banner.status !=' => 'R', 'DATE(Banner.banner_date_from) <' => $currentdate])->toarray();
		//pr($all_banner); die;
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
		//echo $status;  die;
		$this->loadModel('Banner');
		$Pack = $this->Banner->get($id);
		$Pack->status = $status;
		if ($this->Banner->save($Pack)) {
			if ($status == 'Y') {
				$this->Flash->success(__('The Banner with id: {0} has been activated.', h($id)));
			} else {
				$this->Flash->success(__('The Banner with id: {0} has been deactivated.', h($id)));
			}

			return $this->redirect(['action' => 'index']);
		}
	}
}
