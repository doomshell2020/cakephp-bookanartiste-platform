<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;

class DevController extends AppController
{
public function initialize()
{
        
        parent::initialize();
        $this->Auth->allow(['login', 'add','addsubscribe','contactservice','notifications']);
        //$this->loadComponent('Flash');  Include the FlashComponent
}
    public  function _setPassword($password)
    {
    return (new DefaultPasswordHasher)->hash($password);
    }
public function login()
    {
    $this->loadmodel('Users');
    $this->loadmodel('Profile');
    $this->loadmodel('Profilepack');
    $this->loadmodel('Packfeature');
        if ($this->request->is('get')) { 

                $users = $this->Users->newEntity();
                $email=$this->request->query['uid'];
                $name=$this->request->query['last_name'];
                $user = $this->Users->find('all')->where(['email' =>$email])->first();
                if($user){

                    if ($user && $user['role_id']==NONTALANT_ROLEID || $user['role_id']==TALANT_ROLEID) {

                        $this->loadModel('Subscription');
                        $this->loadModel('Profilepack');
                        $this->loadModel('Packfeature');
                        $this->loadModel('Subscription');
                        $subscriptiondata = $this->Subscription->find('all')->where(['Subscription.user_id' =>$user['id'],'Subscription.package_type'=>'PR'])->first();

                    
                        if(time()>strtotime($subscriptiondata['expiry_date'])){

                        $subscriptionid=$subscriptiondata['id'];
                        $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user['id']])->order(['Packfeature.id' => 'ASC'])->first();
                
                        $packfeature_id = $packfeature['id'];
                        $packfeature = $this->Packfeature->get($packfeature_id);
                        $pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status'=>'Y','Profilepack.id'=>PROFILE_PACKAGE])->order(['Profilepack.id' => 'ASC'])->first();
                        $feature_info['number_categories'] = $pcakgeinformation['number_categories'];
                        $feature_info['number_audio'] = $pcakgeinformation['number_audio'];
                        $feature_info['ask_for_quote_request_per_job'] = $pcakgeinformation['ask_for_quote_request_per_job'];
                        $feature_info['number_video'] = $pcakgeinformation['number_video'];
                        $feature_info['website_visibility'] = $pcakgeinformation['website_visibility'];
                        $feature_info['private_individual'] = $pcakgeinformation['private_individual'];
                        $feature_info['access_job'] = $pcakgeinformation['access_job'];
                        $feature_info['number_job_application'] = $pcakgeinformation['number_job_application'];
                        $feature_info['number_job_application_month'] = $pcakgeinformation['number_job_application'];
                $feature_info['number_job_application_daily'] = $pcakgeinformation['number_of_application_day'];
                $feature_info['number_of_quote_daily'] = $pcakgeinformation['number_of_quote_daily'];
                        $feature_info['number_search'] = $pcakgeinformation['number_search'];
                        $feature_info['ads_free'] = $pcakgeinformation['ads_free'];
                        $feature_info['number_albums'] = $pcakgeinformation['number_albums'];
                        $feature_info['message_folder'] = $pcakgeinformation['message_folder'];
                        $feature_info['privacy_setting_access'] = $pcakgeinformation['privacy_setting_access'];
                        $feature_info['access_to_ads'] = $pcakgeinformation['access_to_ads'];
                        $feature_info['number_of_jobs_alerts'] = $pcakgeinformation['number_of_jobs_alerts'];
                        $feature_info['number_of_introduction'] = $pcakgeinformation['number_of_introduction'];
                        $feature_info['number_of_intorduction_send'] = $pcakgeinformation['number_of_intorduction_send'];
                        $feature_info['search_of_other_profile'] = $pcakgeinformation['search_of_other_profile'];
                        $feature_info['nubmer_of_jobs_month'] = $pcakgeinformation['nubmer_of_jobs'];
                        $feature_info['introduction_sent'] = $pcakgeinformation['introduction_sent'];
                        $feature_info['profile_likes'] = $pcakgeinformation['profile_likes'];
                        $feature_info['job_alerts_month'] = $pcakgeinformation['job_alerts_month'];
                        $feature_info['job_alerts'] = $pcakgeinformation['job_alerts'];
                        $feature_info['packge'] = $pcakgeinformation['packge'];
                        $feature_info['page_id'] = $pcakgeinformation['page_id'];
                        $feature_info['persanalized_url'] = $pcakgeinformation['persanalized_url'];
                        $feature_info['number_of_free_quote_month'] = $pcakgeinformation['number_of_free_quote_month'];
                        $feature_info['number_of_free_day'] = $pcakgeinformation['number_of_free_day'];
                        $feature_info['number_of_free_job'] = $pcakgeinformation['number_of_free_job'];
                        $feature_info['number_of_booking'] = $pcakgeinformation['number_of_booking'];
                        $feature_info['number_of_introduction_recived'] = $pcakgeinformation['number_of_introduction_recived'];
                        $feature_info['number_of_photo'] = $pcakgeinformation['number_of_photo'];
                        $daysofprofile=$pcakgeinformation['validity_days'];
                        $this->loadModel('Subscription');
                        $subscription = $this->Subscription->get($subscriptionid);
                        $subscription_info['package_id'] = PROFILE_PACKAGE;
                        $subscription_info['user_id'] =  $user['id'];
                        $subscription_info['package_type'] = "P";
                        $subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+".$daysofprofile." days"));
                        $subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
                        $subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
                        $savedata = $this->Subscription->save($subscription_arr);
                        $packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
                        $this->Packfeature->save($packfeatures);

                        }


                        // Requiter data
                        $subscriptiondata = $this->Subscription->find('all')->where(['Subscription.user_id' =>$user['id'],'Subscription.package_type'=>'RC'])->first();

                        if(time()>strtotime($subscriptiondata['expiry_date'])){
                        $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user['id']])->order(['Packfeature.id' => 'ASC'])->first();
                        $packfeature_id = $packfeature['id'];
                        $packfeature = $this->Packfeature->get($packfeature_id);
                        $subscriptionid=$subscriptiondata['id'];
                        $this->loadModel('RecuriterPack');
                        $pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.status'=>'Y','RecuriterPack.id'=>RECUITER_PACKAGE])->order(['RecuriterPack.id' => 'DESC'])->first();
                        $feature_info['number_of_job_post'] = $pcakgeinformation['number_of_job_post'];
                        $feature_info['number_of_job_simultancney'] = $pcakgeinformation['number_of_job_simultancney'];
                        $feature_info['nubmer_of_site'] = $pcakgeinformation['nubmer_of_site'];
                        $feature_info['number_of_message'] = $pcakgeinformation['number_of_message'];
                        $feature_info['number_of_contact_details'] = $pcakgeinformation['number_of_contact_details'];
                        $feature_info['number_of_talent_search'] = $pcakgeinformation['number_of_talent_search'];
                        $feature_info['lengthofpackage'] = $pcakgeinformation['lengthofpackage'];
                        $feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging'];
                        $feature_info['number_of_email'] = $pcakgeinformation['number_of_email'];
                        $feature_info['multipal_email_login'] = $pcakgeinformation['multipal_email_login'];
                        $daysofrecur=$pcakgeinformation['validity_days'];
                        $subscription = $this->Subscription->get($subscriptionid);
                        $subscription_info['package_id'] = RECUITER_PACKAGE;
                        $subscription_info['user_id'] = $user['id'];
                        $subscription_info['package_type'] = "R";
                        $subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+".$daysofprofile." days"));
                        $subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
                        $subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
                        $savedata = $this->Subscription->save($subscription_arr);
                        $packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
                        $this->Packfeature->save($packfeatures);
                        }

                            //end 
            // Non talent data
            $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id'=>$user['id']])->order(['Packfeature.id' => 'ASC'])->first();
            

            if(time()>strtotime($packfeature['non_telent_expire'])){
                $this->loadModel('Settings');
                $pcakgeinformation = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();
                $feature_info['non_telent_number_of_audio'] = $pcakgeinformation['non_telent_number_of_audio'];
                $feature_info['non_telent_number_of_video'] = $pcakgeinformation['non_telent_number_of_video'];
                $feature_info['non_telent_number_of_album'] = $pcakgeinformation['non_telent_number_of_album'];
                $feature_info['non_telent_number_of_folder'] = $pcakgeinformation['non_telent_number_of_folder'];
                $feature_info['non_telent_number_of_jobalerts'] = $pcakgeinformation['non_telent_number_of_jobalerts'];
                $feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging'];
                $feature_info['non_telent_number_of_search_profile'] = $pcakgeinformation['non_telent_number_of_search_profile'];
                $feature_info[' non_telent_number_of_private_message'] = $pcakgeinformation['   non_telent_number_of_private_message'];
                $feature_info['non_telent_ask_quote'] = $pcakgeinformation['non_telent_ask_quote'];
                $feature_info[' non_telent_number_of_job_post'] = $pcakgeinformation['      non_telent_number_of_job_post'];
                $daysofnontalent=$pcakgeinformation['non_talent_validity_days'];
                $feature_info['non_telent_expire'] = date('Y-m-d H:i:s a', strtotime("+".$daysofnontalent." days"));
                $packfeature_id = $packfeature['id'];
                $packfeature = $this->Packfeature->get($packfeature_id);
                $packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
                $this->Packfeature->save($packfeatures);
            }  
                 
            $blocked_expiry = strtotime($user['blocked_expiry']);
            $current_time = time();
            if($blocked_expiry > $current_time)
            {
                $datediff = $blocked_expiry-$current_time;
                $blocked_days = round($datediff / (60 * 60 * 24));
                $this->Flash->error(__('Your Profile is Blocked for '.$blocked_days.' days'));
                return $this->redirect(['controller' => 'users','action'=>'login']);
            }
            else
            {
                if($user['status']=="Y"){
                $this->loadModel('Settings');
                $settingdetails = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->toarray();
                $session = $this->request->session();
                $session->write('settings', $settingdetails[0]);
                // Update
                $user_id = $user['id'];
                $users = $this->Users->find('all')->where(['id' => $user_id])->first();
                $user_data['last_login'] = date('Y-m-d H:i:s',time());
                $users = $this->Users->patchEntity($users, $user_data);
                $updateuser = $this->Users->save($users);
                $this->Auth->setUser($user);
                $response['redirect_url']=$this->Auth->redirectUrl();
                }else{
                $this->Flash->error(__('Your Profile is Deactivated by admin'));
                $response['redirect_url']='http://bookanartiste.com/login';
                }
            }

                    
                    




                    }

                }else{
                    

                $this->request->data['password']= $this->_setPassword('12345');
                $this->request->data['role_id']= NONTALANT_ROLEID ;
                $this->request->data['profilepack_id']= PROFILE_PACKAGE ;
                $this->request->data['status']= "Y" ;
                $this->request->data['user_name']=$this->request->query['first_name'];
                $this->request->data['email']=$this->request->query['uid'];
                  // pr($this->request->data); die;
                $department = $this->Users->patchEntity($users, $this->request->data);
                if ($register = $this->Users->save($department)){
                    $user_id=$register->id;
                $pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status'=>'Y','Profilepack.id'=>PROFILE_PACKAGE])->order(['Profilepack.id' => 'ASC'])->first();
                $feature_info['number_categories'] = $pcakgeinformation['number_categories'];
                $feature_info['number_audio'] = $pcakgeinformation['number_audio'];
                $feature_info['number_video'] = $pcakgeinformation['number_video'];
                $feature_info['website_visibility'] = $pcakgeinformation['website_visibility'];
                $feature_info['private_individual'] = $pcakgeinformation['private_individual'];
                $feature_info['access_job'] = $pcakgeinformation['access_job'];
                $feature_info['number_job_application_month'] = $pcakgeinformation['number_job_application'];
                $feature_info['number_job_application_daily'] = $pcakgeinformation['number_of_application_day'];
                $feature_info['number_of_quote_daily'] = $pcakgeinformation['number_of_quote_daily'];
                $feature_info['number_search'] = $pcakgeinformation['number_search'];
                $feature_info['ads_free'] = $pcakgeinformation['ads_free'];
                $feature_info['number_albums'] = $pcakgeinformation['number_albums'];
                $feature_info['message_folder'] = $pcakgeinformation['message_folder'];
                $feature_info['privacy_setting_access'] = $pcakgeinformation['privacy_setting_access'];
                $feature_info['access_to_ads'] = $pcakgeinformation['access_to_ads'];
                $feature_info['number_of_jobs_alerts'] = $pcakgeinformation['number_of_jobs_alerts'];
                $feature_info['number_of_introduction'] = $pcakgeinformation['number_of_introduction'];
                $feature_info['number_of_intorduction_send'] = $pcakgeinformation['number_of_intorduction_send'];
                $feature_info['search_of_other_profile'] = $pcakgeinformation['search_of_other_profile'];
                $feature_info['nubmer_of_jobs_month'] = $pcakgeinformation['nubmer_of_jobs'];
                $feature_info['introduction_sent'] = $pcakgeinformation['introduction_sent'];
                $feature_info['profile_likes'] = $pcakgeinformation['profile_likes'];
                $feature_info['job_alerts_month'] = $pcakgeinformation['job_alerts_month'];
                $feature_info['job_alerts'] = $pcakgeinformation['job_alerts'];
                $feature_info['packge'] = $pcakgeinformation['packge'];
                $feature_info['page_id'] = $pcakgeinformation['page_id'];
                $feature_info['persanalized_url'] = $pcakgeinformation['persanalized_url'];
                $feature_info['number_of_free_quote_month'] = $pcakgeinformation['number_of_free_quote_month'];
                $feature_info['number_of_free_day'] = $pcakgeinformation['number_of_free_day'];
                $feature_info['ask_for_quote_request_per_job'] = $pcakgeinformation['ask_for_quote_request_per_job'];

                $feature_info['number_of_free_job'] = $pcakgeinformation['number_of_free_job'];
                $feature_info['number_of_booking'] = $pcakgeinformation['number_of_booking'];
                $feature_info['number_of_introduction_recived'] = $pcakgeinformation['number_of_introduction_recived'];
                $feature_info['number_of_photo'] = $pcakgeinformation['number_of_photo'];
                $daysofprofile=$pcakgeinformation['validity_days'];

                //Subscription data save

                    $this->loadModel('Subscription');
                    $subscription = $this->Subscription->newEntity();
                    $subscription_info['package_id'] = PROFILE_PACKAGE;
                    $subscription_info['user_id'] =  $user_id;
                    $subscription_info['package_type'] = "PR";
                    $subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+".$daysofprofile." days"));
                    $subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
                    

                    $subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
                    $savedata = $this->Subscription->save($subscription_arr);


            // RecuriterPack data
                    $this->loadModel('RecuriterPack');

                    $pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.status'=>'Y','RecuriterPack.id'=>RECUITER_PACKAGE])->order(['RecuriterPack.id' => 'DESC'])->first();
                    $feature_info['number_of_job_post'] = $pcakgeinformation['number_of_job_post'];
                    $feature_info['number_of_job_simultancney'] = $pcakgeinformation['number_of_job_simultancney'];
                    $feature_info['nubmer_of_site'] = $pcakgeinformation['nubmer_of_site'];
                    $feature_info['number_of_message'] = $pcakgeinformation['number_of_message'];
                    $feature_info['number_of_contact_details'] = $pcakgeinformation['number_of_contact_details'];
                    $feature_info['number_of_talent_search'] = $pcakgeinformation['number_of_talent_search'];
                    $feature_info['lengthofpackage'] = $pcakgeinformation['lengthofpackage'];
                    $feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging'];
                    $feature_info['number_of_email'] = $pcakgeinformation['number_of_email'];
                    $feature_info['multipal_email_login'] = $pcakgeinformation['multipal_email_login'];
                    $daysofrecur=$pcakgeinformation['validity_days'];
                    $subscription = $this->Subscription->newEntity();
                    $subscription_info['package_id'] = RECUITER_PACKAGE;
                    $subscription_info['user_id'] =  $user_id;
                    $subscription_info['package_type'] = "RC";
                    $subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+".$daysofprofile." days"));
                    $subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
                    $subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
                    $savedata = $this->Subscription->save($subscription_arr);


                     $this->loadModel('Settings');
                     $pcakgeinformation = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();

                    $feature_info['non_telent_number_of_audio'] = $pcakgeinformation['non_telent_number_of_audio'];
                    $feature_info['user_id'] = $user_id;
                    $feature_info['non_telent_number_of_video'] = $pcakgeinformation['non_telent_number_of_video'];
                    $feature_info['non_telent_number_of_album'] = $pcakgeinformation['non_telent_number_of_album'];
                    $feature_info['non_telent_number_of_folder'] = $pcakgeinformation['non_telent_number_of_folder'];
                    $feature_info['non_telent_number_of_jobalerts'] = $pcakgeinformation['non_telent_number_of_jobalerts'];
                    $feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging'];
                    $feature_info['non_telent_number_of_search_profile'] = $pcakgeinformation['non_telent_number_of_search_profile'];
                    $feature_info[' non_telent_number_of_private_message'] = $pcakgeinformation['   non_telent_number_of_private_message'];
                    $feature_info['non_telent_ask_quote'] = $pcakgeinformation['non_telent_ask_quote'];
                    $feature_info[' non_telent_number_of_job_post'] = $pcakgeinformation['non_telent_number_of_job_post'];
                    $daysofnontalent=$pcakgeinformation['non_talent_validity_days'];
                    $feature_info['non_telent_expire'] = date('Y-m-d H:i:s a', strtotime("+".$daysofnontalent." days"));

                    $packfeature = $this->Packfeature->newEntity();
                    $packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
                    $this->Packfeature->save($packfeatures);



                    $profile = $this->Profile->newEntity();
                    
                    $profess = $this->Users->find('all')->select(['id','user_name'])->where(['id' =>$user_id])->first(); 
                    $this->request->data['name']=$profess['user_name'];
                    $this->request->data['user_id']=$user_id;
                    $this->request->data['phonecode']=$this->request->data['phonecode'];
                    $this->request->data['social']=1;
                    $this->request->data['profile_image']=$this->request->query['photo'];;
                    $profiles = $this->Profile->patchEntity($profile, $this->request->data);
                    $profess = $this->Users->find('all')->where(['email' =>$email])->first(); 
                    $this->Profile->save($profiles);
                    $response['success']=1; 
                            if($profess){
                            $this->Auth->setUser($profess);
                            $response['redirect_url']=$this->Auth->redirectUrl();
                            }

                }



                }   





        }
    return $this->redirect($this->Auth->redirectUrl());
    }
}