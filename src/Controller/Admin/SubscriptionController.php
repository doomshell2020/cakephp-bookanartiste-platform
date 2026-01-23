<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class SubscriptionController extends AppController
{
	public function initialize()
	{
		parent::initialize();
	}
	// For Talent Index
	public function index()
	{


		$this->loadModel('Users');
		$this->loadModel('Subscription');
		$this->viewBuilder()->layout('admin');
		$cond = [];
		$this->request->session()->write('subscription_filter', $cond);

		$subscription = $this->Subscription->find('all')->contain(['Users' => ['Profile']])->order(['Subscription.id' => 'DESC'])->toarray();
		$this->set(compact('subscription'));
	}

	public function search()
	{
		$this->loadModel('Users');
		$this->loadModel('Subscription');
		$status = $this->request->data['status'];
		$name = $this->request->data['name'];
		$email = $this->request->data['email'];
		$from_date = $this->request->data['from_date'];
		$to_date = $this->request->data['to_date'];
		$packtype = $this->request->data['packtype'];
		$status = $this->request->data['status'];

		$cond = [];

		if (!empty($packtype)) {
			$cond['Subscription.package_type'] = $packtype;
		}

		if (!empty($name)) {
			$cond['Users.user_name LIKE'] = "%" . $name . "%";
		}

		if (!empty($email)) {
			$cond['Users.email LIKE'] = "%" . $email . "%";
		}

		if (!empty($from_date)) {
			$cond['DATE(Subscription.subscription_date) >='] = date('Y-m-d', strtotime($from_date));
		}
		if (!empty($to_date)) {
			$cond['DATE(Subscription.subscription_date) <='] = date('Y-m-d', strtotime($to_date));
		}
		$currentdate = date('Y-m-d');

		if (!empty($status)) {
			if ($status == 'Y') {
				$cond['DATE(Subscription.expiry_date) >='] = $currentdate;
			} else {
				$cond['DATE(Subscription.expiry_date) <'] = $currentdate;
			}
		}
		$this->request->session()->write('subscription_filter', $cond);
		$subscription = $this->Subscription->find('all')->contain(['Users' => ['Profile']])->where($cond)->order(['Subscription.id' => 'DESC'])->toarray();
		$this->set('subscription', $subscription);
	}

	public function packagedetailss($type = null, $packageid = null, $sid = null)
	{
		$this->loadModel('Profilepack');
		$this->loadModel('RequirementPack');
		$this->loadModel('RecuriterPack');
		$this->loadModel('Transcation');
		$pcakgeinformation = '';
		if ($type == 'PR') {
			$pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.id' => $packageid])->first();
		} elseif ($type == 'RC') {
			$pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.id' => $packageid])->first();
		} elseif ($type == 'RE') {
			$pcakgeinformation = $this->RequirementPack->find('all')->where(['RequirementPack.id' => $packageid])->first();
		}

		return $pcakgeinformation;
	}



	public function exportSubscription()
	{
		$this->autoRender = false;
		$this->loadModel('Subscription');
		$this->loadModel('Transcation');
		$blank = "NA";
		$output = "";
		$output .= '"Sr Number",';
		$output .= '"Name of Purchaser",';
		$output .= '"Email of Purchaser",';
		$output .= '"Invoice Number",';

		$output .= '"Package type",';
		$output .= '"Package Name",';
		$output .= '"Subscription Date",';
		$output .= '"Subscription Expiry",';
		$output .= '"Status",';
		$output .= "\n";
		//pr($job); die;
		$str = "";

		$cond = $this->request->session()->read('subscription_filter');

		$substransc = $this->Transcation->find('all')->where(['subscription_id'])->toarray();


		//pr($substransc); die;
		$cnt = 1;
		foreach ($substransc as $talent_data) {
			$this->loadModel('Users');
			$subsid[] = $talent_data['subscription_id'];
			$subscription = $this->Subscription->find('all')->contain(['Users' => ['Profile']])->where([$cond, 'Subscription.id' => $talent_data['subscription_id']])->order(['Subscription.id' => 'DESC'])->first();
			if ($subscription) {

				$packagedetails = $this->packagedetailss($subscription['package_type'], $subscription['package_id']);

				if ($subscription['package_type'] == 'PR') {
					$packtype = "Profile";
				} elseif ($subscription['package_type'] == 'RC') {
					$packtype = "Recruiter";
				} elseif ($subscription['package_type'] == 'RE') {
					$packtype = "Requirement";
				} else {
					$packtype = "N/A";
				}

				if ($packagedetails['title']) {
					$packname = $packagedetails['title'];
				} else {
					$packname = $packagedetails['name'];
				}
				$subdate = date("d M Y h:i a", strtotime($subscription['subscription_date']));
				$expriy = date("d M Y h:i a", strtotime($subscription['expiry_date']));

				$expriydate = date("Y-m-d", strtotime($subscription['expiry_date']));
				$curdate = date("Y-m-d");

				if ($expriydate >= $curdate) {
					$sts = 'Active';
				} else {
					$sts = 'Expired';
				}

				$output .= $cnt . ",";
				$output .= $subscription['user']['user_name'] . ",";
				$output .= $subscription['user']['email'] . ",";
				$output .= $talent_data['id'] . ",";

				$output .= $packtype . ",";
				$output .= $packname . ",";
				$output .= $subdate . ",";
				$output .= $expriy . ",";
				$output .= $sts . ",";

				$cnt++;
				$output .= "\r\n";
			}
		}
		//pr($subsid);
		$output .= "\r\n";
		$output .= "First Sign Up Package List";
		$output .= "\r\n";
		$output .= "\r\n";
		$subscrip = $this->Subscription->find('all')->contain(['Users' => ['Profile']])->where([$cond, 'Subscription.id NOT IN' => $subsid])->order(['Subscription.id' => 'DESC'])->toarray();
		//pr($subscrip); die;
		//die;
		$cnts = 1;
		foreach ($subscrip as $talent_datas) {
			$this->loadModel('Users');

			$packagedetailss = $this->packagedetailss($talent_datas['package_type'], $talent_datas['package_id']);

			if ($talent_datas['package_type'] == 'PR') {
				$packtypes = "Profile";
			} elseif ($talent_datas['package_type'] == 'RC') {
				$packtypes = "Recruiter";
			} elseif ($talent_datas['package_type'] == 'RE') {
				$packtypes = "Requirement";
			} else {
				$packtypes = "N/A";
			}

			if ($packagedetailss['title']) {
				$packnames = $packagedetailss['title'];
			} else {
				$packnames = $packagedetailss['name'];
			}
			$subdate = date("d M Y h:i a", strtotime($talent_datas['subscription_date']));
			$expriy = date("d M Y h:i a", strtotime($talent_datas['expiry_date']));

			$expriydate = date("Y-m-d", strtotime($talent_datas['expiry_date']));
			$curdate = date("Y-m-d");

			if ($expriydate >= $curdate) {
				$sts = 'Active';
			} else {
				$sts = 'Expired';
			}
			$username = ($talent_datas['user']['user_name']) ? $talent_datas['user']['user_name'] : "N/A";
			$useremail = ($talent_datas['user']['email']) ? $talent_datas['user']['email'] : "N/A";
			$output .= $cnts . ",";
			$output .= $username . ",";
			$output .= $useremail . ",";
			$output .= "N/A,";

			$output .= $packtypes . ",";
			$output .= $packnames . ",";
			$output .= $subdate . ",";
			$output .= $expriy . ",";
			$output .= $sts . ",";

			$cnts++;
			$output .= "\r\n";
		}

		$filename = "Subscriptions.xlsx";

		header('Content-type: application/xlsx');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		die;
		$this->redirect($this->referer());
	}
}
