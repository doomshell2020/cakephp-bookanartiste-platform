<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class ProfileController extends AppController
{
	public function initialize()
	{
		parent::initialize();
	}
	// For Talent Index
	public function index()
	{
		$this->loadModel('Users');
		$this->loadModel('Country');
		$this->viewBuilder()->layout('admin');
		$talent = $this->Users->find('all')->contain(['Skillset', 'Profile', 'Profilepack'])->where(['Users.role_id' => TALANT_ROLEID, 'Users.user_delete' => 'N'])->order(['Users.id' => 'DESC'])->toarray();
		//$country = $this->Country->find('list')->select(['id','name'])->toarray();
		$country = $this->Users->find('all')->select(['Country.name', 'Country.id'])->contain(['Profile' => ['Country']])->where(['Users.role_id' => TALANT_ROLEID])->order(['Country.name' => 'ASC'])->toarray();
		//pr($country); die;
		$this->set(compact('talent', 'country'));
	}



	public function talentexcel($id = null)
	{
		$this->autoRender = false;
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Professinal_info');
		$this->loadModel('Skillset');
		$this->loadModel('Requirement');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Refers');
		$this->loadModel('Profileadvertpack');
		$artisteUser = $this->Users->find('all')->contain(['Skillset' => ['Skill'], 'Profile' => ['Country', 'State', 'City', 'Enthicity'], 'Professinal_info', 'Subscription' => ['Profilepack'], 'Packfeature', 'TalentAdmin'])->where(['Users.role_id' => TALANT_ROLEID, 'Users.user_delete' => 'N'])->order(['Users.id' => 'DESC'])->toarray();

		//pr($artisteUser); die;

		$blank = "-";

		$conn = ConnectionManager::get('default');
		$output = "";
		$output .= '"Sr No",';
		$output .= '"Name",';
		$output .= '"Email Id",';
		$output .= '"Contact Number",';
		$output .= '"Sex",';
		$output .= '"Skill",';
		$output .= '"Country",';
		$output .= '"State",';
		$output .= '"City",';
		$output .= '"Membership Since",';
		$output .= '"Source",';
		$output .= '"Membership Type",';
		$output .= '"Talent Partner Name",';
		$output .= '"Talent Partner Email ID",';
		$output .= '"Advertised Profile( No. of Days )",';
		$output .= '"Featured Profile( No. of Days )",';
		$output .= "\n";
		//pr($job); die;
		$cnt = 1;
		foreach ($artisteUser as $artisteValue) { //pr($artisteValue); die;			
			$contentadmin = $this->TalentAdmin->find('all')->contain(['Users' => ['Refers']])->where(['Users.is_talent_admin' => 'Y', 'TalentAdmin.talentdadmin_id' => $artisteValue['id']])->toarray();
			$referrUser = $this->Users->find('all')->contain(['Profile'])->select('id', 'user_name')->where(['Users.id' => $artisteValue['ref_by']])->first();

			$output .= $cnt . ",";
			$output .= $artisteValue['user_name'] . ",";
			$output .= $artisteValue['email'] . " " . str_replace(',', ' ', $artisteValue['profile']['altemail']) . ",";

			if ($artisteValue['profile']['phone']) {
				$removespace = str_replace(' ', '', $artisteValue['profile']['altnumber']);
				//echo $removespace; die;
				$altphone = explode(",", $removespace);
				//pr($altphone); die;
				$output .= $artisteValue['profile']['phonecode'] . '-' . $artisteValue['profile']['phone'];
				foreach ($altphone as $altphonevalue) {
					//pr($altphonevalue); die;
					$output .= $artisteValue['profile']['phonecode'] . "-" . $altphonevalue;
				}
				$output .= ",";
			} else {
				$output .= $blank . ",";
			}

			if ($artisteValue['profile']['gender'] == 'm') {
				$output .= 'Male' . ",";
			} elseif ($artisteValue['profile']['gender'] == 'f') {
				$output .= 'Female' . ",";
			} elseif ($artisteValue['profile']['gender'] == 'bmf') {
				$output .= 'Both male and female' . ",";
			} elseif ($artisteValue['profile']['gender'] == 'o') {
				$output .= 'Other' . ",";
			} else {
				$output .= $blank . ",";
			}

			if ($artisteValue['skillset']) {
				$knownskills = '';
				foreach ($artisteValue['skillset'] as $skillquote) {
					if (!empty($knownskills)) {
						$knownskills = $knownskills . ', ' . $skillquote['skill']['name'];
					} else {
						$knownskills = $skillquote['skill']['name'];
					}
				}
				$output .= str_replace(',', ' ', $knownskills) . ',';
			}


			//if($artisteValue['profile']['country_ids']==""){
			//$output.=$artisteValue['profile']['location'].",";
			//}else
			if ($artisteValue['profile']['country']['name']) {
				$output .= $artisteValue['profile']['country']['name'] . ",";
			} else {
				$output .= "- ,";
			}

			if ($artisteValue['profile']['state']['name']) {
				$output .= $artisteValue['profile']['state']['name'] . ",";
			} else {
				$output .= "- ,";
			}

			if ($artisteValue['profile']['city']['name']) {
				$output .= $artisteValue['profile']['city']['name'] . ",";
			} else {
				$output .= "- ,";
			}

			$output .= date('d-M-Y', strtotime($artisteValue['created'])) . ",";

			//$output .="Source".",";

			if ($artisteValue['ref_by'] != 0) {
				if (!empty($artisteValue['talent_admin'])) {
					$talentPartenrs = "Referred and Referred Talent";
				} else {
					$talentPartenrs = "Referred";
				}
			} elseif (strtotime($artisteValue['created']) < strtotime($artisteValue['talent_admin']['created_date'])) {
				$talentPartenrs = "Self";
			} elseif (!empty($artisteValue['talent_admin'])) {
				if ($artisteValue['talent_admin']['talentdadmin_id'] == 1) {
					$talentPartenrs = "Admin";
				} else {
					$talentPartenrs = "Referred (Talent Partner)";
				}
			} else {
				$talentPartenrs = "Self";
			}
			$output .= $talentPartenrs . ",";

			$newmmtype = array();
			foreach ($artisteValue['subscription'] as $key => $mambertype) {
				if ($mambertype['package_type'] == 'PR' || $mambertype['package_type'] == 'RC') {
					if ($mambertype['package_type'] == 'PR') {
						if ($mambertype['profilepack']['name'] == "Free") {
							$mmtype = "Free pr";
						} else {
							$mmtype = $mambertype['profilepack']['name'] . " Profile Package";
						}
					}
					// elseif($mambertype['package_type']=='RE'){
					// 	if($mambertype['profilepack']['name']=="Free"){
					// 		$mmtype= "Free";
					// 		$type = "RE";
					// 	}else{
					// 		$mmtype= $mambertype['profilepack']['name']." Requirement Package";
					// 		$type = "RE";
					// 	}
					// }
					elseif ($mambertype['package_type'] == 'RC') {
						if ($mambertype['profilepack']['name'] == "Free") {
							$mmtype = "Free rc";
						} else {
							$mmtype = $mambertype['profilepack']['name'] . " Recruiter Package";
						}
					} else {
						$output .= $blank . ",";
					}
					$newmmtype[] = $mmtype;
				}
			}
			//pr($newmmtype); die;

			if ($newmmtype['0'] == "Free pr" && $newmmtype['1'] == "Free rc") {
				$output .= "Free Member";
			} elseif ($newmmtype['0'] == "Free pr" && $newmmtype['1'] != "Free rc") {
				$output .= $newmmtype['1'] . " and Default Profile Package";
			} elseif ($newmmtype['0'] != "Free pr" && $newmmtype['1'] == "Free rc") {
				$output .= $newmmtype['0'] . " and Default Recruiter Package";
			} elseif ($newmmtype['0'] == "Free rc" && $newmmtype['1'] != "Free pr") {
				$output .= $newmmtype['1'] . " and Default Recruiter Package";
			} elseif ($newmmtype['0'] != "Free rc" && $newmmtype['1'] == "Free pr") {
				$output .= $newmmtype['0'] . " and Default Profile Package";
			} elseif ($newmmtype['0'] != "Free pr" && $newmmtype['1'] != "Free rc") {
				$output .= $newmmtype['0'] . " and " . $newmmtype['1'];
			} else {
				//$output.="Member";
			}

			$output .= ",";

			//pr($contentadmin); die;
			// foreach ($contentadmin as $key => $talentPartenr) {
			// 	if($talentPartenr['user']['user_name']){
			// 		$talentPartenrs= $talentPartenr['user']['user_name'];
			// 	}else{
			// 		$output .= $blank.",";
			// 	}

			// 	$output.=$talentPartenrs." ";
			// }
			// $output.=",";

			// foreach ($contentadmin as $key => $talentPartenre) {
			// 	if($talentPartenr['user']['email']){
			// 		$talentPartenrse= $talentPartenre['user']['email'];
			// 	}else{
			// 		$output .= $blank.",";
			// 	}

			// 	$output.=$talentPartenrse." ";
			// }
			// $output.=",";
			if ($talentPartenrs == "Self") {
				$output .= $blank . ",";
				$output .= $blank . ",";
			} else {

				if ($artisteValue['ref_by'] != 0) {
					$taletnrefer = $this->Users->find('all')->contain(['Profile'])->select(['id', 'user_name', 'email'])->where(['Users.id' => $artisteValue['ref_by']])->first();
					if ($taletnrefer['user_name'] == "Anirudh") {
						$output .= $taletnrefer['user_name'] . " (Admin) ,";
					} else {
						$output .= $taletnrefer['user_name'] . ",";
					}
					$output .= $taletnrefer['email'] . ",";
				} elseif (!empty($artisteValue['talent_admin']['talentdadmin_id'])) {
					$taletnrefer = $this->Users->find('all')->contain(['Profile'])->select(['id', 'user_name', 'email'])->where(['Users.id' => $artisteValue['talent_admin']['talentdadmin_id']])->first();
					if ($taletnrefer['user_name'] == "Anirudh") {
						$output .= $taletnrefer['user_name'] . " (Admin) ,";
					} else {
						$output .= $taletnrefer['user_name'] . ",";
					}

					$output .= $taletnrefer['email'] . ",";
				} else {
					$output .= $blank . ",";
					$output .= $blank . ",";
				}
			}


			$currentdate = date('Y-m-d H:m:s');
			//echo $currentdate;
			$useradvertisze = $this->Profileadvertpack->find('all')->where(['Profileadvertpack.user_id' => $artisteValue['id']])->order(['Profileadvertpack.id' => 'Asc'])->toarray();
			//pr($useradvertisze);
			if (!empty($useradvertisze)) {
				foreach ($useradvertisze as $value) {
					//pr($value);
					//$dateto= $value['ad_date_to'];
					//if($currentdate < date('Y-m-d H:m:s',strtotime($dateto))){					
					// Calulating the difference in timestamps 
					$diff = strtotime($value['ad_date_to']) - strtotime($value['ad_date_from']);
					$dateDiff = abs(round($diff / 86400));
					// }
					$totalday += $dateDiff;
				}
				$output .= $totalday . ",";
			} else {
				$output .= $blank . ",";
			}


			$featured_expiry = $artisteValue['featured_expiry'];
			if ($currentdate < date('Y-m-d H:m:s', strtotime($featured_expiry))) {
				$output .= $artisteValue['feature_pro_pack_numofday'] . ",";
			} else {
				$output .= $blank . ",";
			}


			$output .= "\r\n";
			$cnt++;
		}
		//die;

		$filename = "ArtisteExcel.csv";
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename=' . $filename);
		echo $output;
		die;
		$this->redirect($this->referer());
	}



	public function search()
	{
		$tcstatus = $this->request->data['tcstatus'];

		//pr($tcstatus); die;
		$status = $this->request->data['status'];
		$name = $this->request->data['name'];
		$email = $this->request->data['email'];
		$country = $this->request->data['country'];
		$cond = [];

		if ($tcstatus == "CY") {
			$cond['Users.is_content_admin'] = "Y";
		} elseif ($tcstatus == "CN") {
			$cond['Users.is_content_admin'] = "N";
		} elseif ($tcstatus == "TY") {
			$cond['Users.is_talent_admin'] = "Y";
		} elseif ($tcstatus == "TN") {
			$cond['Users.is_talent_admin'] = "N";
		}

		if (!empty($status)) {
			$cond['Users.status'] = $status;
		}
		if (!empty($name)) {
			$cond['Profile.name LIKE'] = "%" . $name . "%";
		}
		if (!empty($email)) {
			$cond['Users.email LIKE'] = "%" . $email . "%";
		}
		if (!empty($country)) {
			$cond['Profile.country_ids '] = $country;
		}

		$cond['Users.role_id'] = TALANT_ROLEID;
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$talent = $this->Users->find('all')->contain(['Skillset', 'Profile', 'Profilepack'])->where([$cond, 'Users.user_delete' => 'N'])->order(['Users.id' => 'DESC'])->toarray();
		$this->set('talent', $talent);
	}

	// For Talent Active
	public function status($id, $status)
	{
		$this->loadModel('Users');
		if (isset($id) && !empty($id)) {
			if ($status == 'N') {
				$status = 'Y';
				$talent = $this->Users->get($id);
				//pr($talent); die;
				$talent->status = $status;
				if ($this->Users->save($talent)) {
					$this->Flash->success(__($talent['user_name'] . ' profile has been activated.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {
				$status = 'N';
				$talent = $this->Users->get($id);
				//pr($talent); die;
				$talent->status = $status;
				if ($this->Users->save($talent)) {
					$this->Flash->success(__($talent['user_name'] . ' profile has been deactivate.'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}

	// For Talent Delete
	public function delete($id)
	{
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Refers');
		$talent = $this->Users->get($id);
		$talentadmin = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $id])->count();
		$refers = $this->Refers->find('all')->where(['Refers.email' => $talent['email']])->count();
		//pr($talent); die;
		// echo $talentadmin; die;
		$talentdata = $this->Profile->find('all')->where(['Profile.user_id' => $id])->first()->toarray();
		unlink('uploads/' . $talentdata['profile_image']);

		$usertable = TableRegistry::get("Users");
		$query = $usertable->query();
		$result = $query->update()
			->set(['user_delete' => 'Y'])
			->where(['id' => $id])
			->execute();

		if ($talentadmin > 0) {
			$this->TalentAdmin->deleteAll(['TalentAdmin.user_id' => $id]);
		}

		if ($refers > 0) {
			$this->Refers->deleteAll(['Refers.email' => $talent['email']]);
		}
		$this->Flash->success(__('The Talent with id: {0} has been deleted.', h($id)));
		return $this->redirect(['action' => 'index']);
	}

	// For Profession data  
	public function professiondata($id)
	{
		$this->loadModel('Professinal_info');
		try {
			$talentpro = $this->Professinal_info->find('all')->where(['Professinal_info.user_id' => $id])->first();
			//pr($talentpro); die;
			$this->set('talentpro', $talentpro);
		} catch (FatalErrorException $e) {
			$this->log("Error Occured", 'error');
		}
	}

	// For Proformance data  
	public function performancedata($id)
	{
		$this->loadModel('Performance_desc');
		$this->loadModel('TalentPerformance');
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Payment_fequency');
		try {
			$talentperformace1 = $this->Performance_desc->find('all')->where(['Performance_desc.user_id' => $id])->toarray();
			$talentperformace2 = $this->TalentPerformance->find('all')->contain(['Users', 'Payment_fequency'])->where(['TalentPerformance.user_id' => $id])->toarray();
			$fullperfomance = array_merge($talentperformace1, $talentperformace2);
			//pr($fullperfomance); die;
			$this->set('fullperfomance', $fullperfomance);
		} catch (FatalErrorException $e) {
			$this->log("Error Occured", 'error');
		}
	}

	//for Skill
	public function skill($id)
	{
		$this->loadModel('Skillset');
		try {
			$skill = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id])->toarray();
			$this->set('skill', $skill);
		} catch (FatalErrorException $e) {
			$this->log("Error Occured", 'error');
		}
	}


	public function audio($id)
	{

		$this->loadModel('Audio');
		$this->viewBuilder()->layout('admin');
		$audio = $this->Audio->find('all')->where(['Audio.user_id' => $id])->toarray();
		$this->set('skill', $audio);
		$this->set('id', $id);
	}

	// For Talent Delete
	public function audiodelete($id, $aid)
	{
		$this->loadModel('Audio');
		$Audio = $this->Audio->get($id);
		//pr($Audio); die;
		$this->loadModel('Notification');
		$noti = $this->Notification->newEntity();
		$notification['notification_sender'] = 1;
		$notification['notification_receiver'] = $Audio['user_id'];
		$notification['type'] = "content delete";
		$notification['content'] = $Audio['audio_link'];;
		$notification = $this->Notification->patchEntity($noti, $notification);
		$this->Notification->save($notification);

		if ($this->Audio->delete($Audio)) {
			$this->Flash->success(__('The Audio with id: {0} has been deleted.', h($id)));
			return $this->redirect(['action' => 'audio' . '/' . $aid]);
		}
	}


	public function video($id)
	{

		$this->loadModel('Video');
		$this->viewBuilder()->layout('admin');
		$Video = $this->Video->find('all')->where(['Video.user_id' => $id])->toarray();
		$this->set('skill', $Video);
		$this->set('id', $id);
	}

	// For Talent Delete
	public function videodelete($id, $aid)
	{

		$this->loadModel('Video');
		$Video = $this->Video->get($id);
		//pr($Video); die;
		$this->loadModel('Notification');
		$noti = $this->Notification->newEntity();
		$notification['notification_sender'] = 1;
		$notification['notification_receiver'] = $Video['user_id'];
		$notification['type'] = "content delete";
		$notification['content'] = $Video['video_type'];;
		$notification = $this->Notification->patchEntity($noti, $notification);
		$this->Notification->save($notification);

		if ($this->Video->delete($Video)) {
			$this->Flash->success(__('The Video with id: {0} has been deleted.', h($id)));
			return $this->redirect(['action' => 'video' . '/' . $aid]);
		}
	}

	// For Talent Delete
	public function gallery($id, $aid = null)
	{
		$this->loadModel('Gallery');
		$this->loadModel('Galleryimage');
		$this->viewBuilder()->layout('admin');
		$Gallery = $this->Gallery->find('all')->contain(['Galleryimage'])->where(['Gallery.user_id' => $id])->toarray();
		$Galleryimage = $this->Galleryimage->find('all')->where(['Galleryimage.user_id' => $id])->toarray();

		$this->set('Gallery', $Gallery);
		$this->set('Galleryimage', $Galleryimage);
		$this->set('id', $id);
		//pr($Gallery);
	}

	// For Talent Delete
	public function gallerydelete($id, $userid = null, $folder = null)
	{
		$this->loadModel('Galleryimage');
		$gallery = $this->Galleryimage->get($id);
		$gallerydata = $this->Galleryimage->find('all')->where(['Galleryimage.id' => $id])->first();
		//unlink('gallery/'.$folder.'/'.$gallerydata['imagename']);
		//pr($gallerydata); die;
		$this->loadModel('Notification');
		$noti = $this->Notification->newEntity();
		$notification['notification_sender'] = 1;
		$notification['notification_receiver'] = $gallerydata['user_id'];
		$notification['type'] = "image delete";
		$notification['content'] = $gallerydata['imagename'];;
		$notification = $this->Notification->patchEntity($noti, $notification);
		$this->Notification->save($notification);


		if ($this->Galleryimage->delete($gallery)) {
			$this->Flash->success(__('The gallery image with id: {0} has been deleted.', h($id)));
			return $this->redirect(['action' => 'gallery' . '/' . $userid]);
		}
	}


	//for Skill
	public function details($id)
	{

		$this->loadModel('Profile');
		$this->loadModel('Users');
		try {
			$talent = $this->Users->find('all')->where(['Users.id' => $id])->first();
			$this->set('talent', $talent);

			$details = $this->Profile->find('all')->contain(['Country', 'State', 'City', 'Enthicity'])->where(['Profile.user_id' => $id])->first();

			$this->set('nontalentdetails', $details);
		} catch (FatalErrorException $e) {
			$this->log("Error Occured", 'error');
		}

		// pr($details); die;


	}


	// For Profile featured 
	public function setdefult($id, $status)
	{

		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Settings');

		// pr($id);
		// pr($status);exit;

		if (isset($id) && !empty($id)) {
			if ($status == 'N') {
				$talent = $this->Users->get($id);
				$talent->feature_by_admin = $status;
				$talent->featured_expiry = '';
				if ($this->Users->save($talent)) {
					$this->Flash->success(__('Requirement featured has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {
				$setting = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();
				$expiredays = $setting->featured_artist_days;
				$currentdate = date('Y-m-d H:m:s');
				$expiredate = date('Y-m-d H:m:s', strtotime($currentdate . "+$expiredays days"));
				$talent = $this->Users->get($id);
				$talent->feature_by_admin = $status;
				$talent->featured_expiry = $expiredate;
				// pr($talent);exit;
				if ($this->Users->save($talent)) {
					$this->Flash->success(__('Users featured has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}
}
