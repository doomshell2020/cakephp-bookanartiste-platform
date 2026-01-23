<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
class ProfileController extends AppController
{       
    public function initialize(){	
    	parent::initialize();
    }
	// For Talent Index
	public function index(){ 
		$this->loadModel('Users');
		$this->loadModel('Country');
		$this->viewBuilder()->layout('admin');
		$talent = $this->Users->find('all')->contain(['Skillset','Profile','Profilepack'])->where(['Users.role_id'=>TALANT_ROLEID])->order(['Users.id' => 'DESC'])->toarray();
		$country = $this->Country->find('list')->select(['id','name'])->toarray();
		$this->set('country', $country);
		$this->set(compact('talent'));
 }
 
	 
	 public function search(){ 
		 $status = $this->request->data['status'];
		 $name = $this->request->data['name'];
		 $email = $this->request->data['email'];
		 $country = $this->request->data['country'];
		 $cond = [];
		 if(!empty($status))
		 {
		 	$cond['Users.status'] = $status;
		 }
		 if(!empty($name))
		 {
		 	$cond['Profile.name LIKE']= "%".$name."%";
		 }
		 if(!empty($email))
		 {
		 	$cond['Users.email LIKE']= "%".$email."%";
		 }
		 if(!empty($country))
		 {
		 	$cond['Profile.country_ids ']= $country;
		 }
		 
		 $cond['Users.role_id'] = TALANT_ROLEID;
		 $this->loadModel('Users');
		 $this->loadModel('Profile');
		 $talent = $this->Users->find('all')->contain(['Skillset','Profile','Profilepack'])->where($cond)->order(['Users.id' => 'DESC'])->toarray();
		 $this->set('talent',$talent);
	 }
 
	 // For Talent Active
	 public function status($id,$status){ 
		 $this->loadModel('Users');
		 if(isset($id) && !empty($id)){
		 if($status =='N' ){
			 $status = 'Y';
			 $talent = $this->Users->get($id);
			 $talent->status = $status;
			 if ($this->Users->save($talent)) {
				 $this->Flash->success(__('Talent status has been updated.'));
			 	return $this->redirect(['action' => 'index']);	
			 }
		 }else{
				 $status = 'N';
				 $talent = $this->Users->get($id);
				 $talent->status = $status;
				 if ($this->Users->save($talent)) {
					 $this->Flash->success(__('Talent status has been updated.'));
					 return $this->redirect(['action' => 'index']);	
				 }
			 }
		 }
	 }
 
	 // For Talent Delete
	 public function delete($id){ 
		 $this->loadModel('Users');
		 $this->loadModel('Profile');
		 $talent = $this->Users->get($id);
		 $talentdata = $this->Profile->find('all')->where(['Profile.user_id'=>$id])->first()->toarray();
		 unlink('uploads/'.$talentdata['profile_image']);
		 if ($this->Users->delete($talent)) {
		 	$this->Flash->success(__('The Talent with id: {0} has been deleted.', h($id)));
		 	return $this->redirect(['action' => 'index']);
		 }
	 }
	 // For Profession data  
	 public function professiondata($id){ 
		 $this->loadModel('Professinal_info');
		 try {
			$talentpro = $this->Professinal_info->find('all')->where(['Professinal_info.user_id'=>$id])->first();
			$this->set('talentpro',$talentpro);
		 }
		 catch (FatalErrorException $e) {
		 	$this->log("Error Occured", 'error');
		 }
	 }
 
	// For Proformance data  
	public function performancedata($id){ 
		$this->loadModel('Performance_desc');
		$this->loadModel('TalentPerformance');
		try {
			$talentperformace1 = $this->Performance_desc->find('all')->where(['Performance_desc.user_id'=>$id])->first()->toarray();
			$talentperformace2 = $this->TalentPerformance->find('all')->contain(['Users','Payment_fequency'])->where(['TalentPerformance.user_id'=>$id])->first()->toarray();
			$fullperfomance=array_merge($talentperformace1,$talentperformace2);
			$this->set('fullperfomance',$fullperfomance);
		}
		catch (FatalErrorException $e) {
			$this->log("Error Occured", 'error');
		}
	}
 
	//for Skill
	public function skill($id){ 
		$this->loadModel('Skillset');
		try {
			$skill = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id'=>$id])->toarray();
			$this->set('skill',$skill);
		}
		catch (FatalErrorException $e) {
			$this->log("Error Occured", 'error');
		}
	}
 
 
 public function audio($id){
 
 $this->loadModel('Audio');
 $this->viewBuilder()->layout('admin');
 $audio = $this->Audio->find('all')->where(['Audio.user_id'=>$id])->toarray();
 $this->set('skill',$audio);
 $this->set('id',$id);
 
 
 }
 
 // For Talent Delete
 public function audiodelete($id,$aid){ 
 $this->loadModel('Audio');
 $Audio = $this->Audio->get($id);
 
 if ($this->Audio->delete($Audio)) {
 $this->Flash->success(__('The Audio with id: {0} has been deleted.', h($id)));
 return $this->redirect(['action' => 'audio'.'/'.$aid]);
 }
 }
 
 
 public function video($id){
 
 $this->loadModel('Video');
 $this->viewBuilder()->layout('admin');
 $Video = $this->Video->find('all')->where(['Video.user_id'=>$id])->toarray();
 $this->set('skill',$Video);
 $this->set('id',$id);
 
 
 }
 
 // For Talent Delete
 public function videodelete($id,$aid){ 
 
 $this->loadModel('Video');
 $Video = $this->Video->get($id);
 
 if ($this->Video->delete($Video)) {
 $this->Flash->success(__('The Video with id: {0} has been deleted.', h($id)));
 return $this->redirect(['action' => 'video'.'/'.$aid]);
 }
 }
 
 // For Talent Delete
 public function gallery($id,$aid){ 
 
 
 $this->loadModel('Gallery');
 $this->viewBuilder()->layout('admin');
 $Gallery = $this->Gallery->find('all')->contain(['Galleryimage'])->where(['Gallery.user_id'=>$id])->toarray();
 $this->set('Gallery',$Gallery);
 //pr($Gallery);
 $this->set('id',$id);
 
 }
 
 // For Talent Delete
 public function gallerydelete($id,$userid,$folder){ 
 
 
 $this->loadModel('Galleryimage');
 $gallery = $this->Galleryimage->get($id);
 $gallerydata = $this->Galleryimage->find('all')->where(['Galleryimage.id'=>$id])->first()->toarray();
 unlink('gallery/'.$folder.'/'.$gallerydata['imagename']);
 if ($this->Galleryimage->delete($gallery)) {
 $this->Flash->success(__('The gallery image with id: {0} has been deleted.', h($id)));
 return $this->redirect(['action' => 'gallery'.'/'.$userid]);
 }
 
 }  
 
 
 //for Skill
 public function details($id){ 
 
 $this->loadModel('Profile');
 try {
 $details = $this->Profile->find('all')->contain(['Country','State','City','Enthicity'])->where(['Profile.user_id'=>$id])->first();
 
 $this->set('nontalentdetails',$details);
 
 }
 catch (FatalErrorException $e) {
 $this->log("Error Occured", 'error');
 }
 
 // pr($details); die;
 
 
 }    
 
 
 } 