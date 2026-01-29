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
use PHPMailer\PHPMailer\PHPMailer;

include(ROOT . DS . "vendor" . DS  . "PHPMailer/" . DS . "PHPMailerAutoload.php");


class PackageController extends AppController
{

  public function initialize()
  {
    parent::initialize();
    $this->loadComponent('Email');
    $this->Auth->allow(['buy']);
  }

  /*  ----------------------------------------------------------------------------------  
          -Purchasing the Packages
          ----------------------------------------------------------------------------------  */
  // public function allpackages($package = null)
  // {
  //   $this->loadModel('Users');
  //   $this->loadModel('Profile');
  //   $this->loadModel('Enthicity');
  //   $this->loadModel('Profilepack');
  //   $this->loadModel('RecuriterPack');
  //   $this->loadModel('Subscription');
  //   $user_id = $this->request->session()->read('Auth.User.id');
  //   // pr($package); die;
  //   $currentdate = date('Y-m-d H:i:s');

  //   $subscriptions = $this->Subscription->find('all')->where(['Subscription.user_id' => $user_id, 'Subscription.package_type' => 'PR', 'DATE(Subscription.expiry_date) >=' => $currentdate])->orWhere(['Subscription.user_id' => $user_id, 'Subscription.package_type' => 'RC'])->toarray();
  //   // pr($subscriptions); die;

  //   $profile = $this->Subscription->find('all')->where(['Subscription.user_id' => $user_id, 'Subscription.package_type' => 'PR', 'DATE(Subscription.expiry_date) >=' => $currentdate])->order(['Subscription.package_id' => 'desc'])->first();

  //   //  pr($profile); die;
  //   // $recuriter = $this->Subscription->find('all')->where(['Subscription.user_id'=>$user_id,'Subscription.package_type'=>'RC','DATE(Subscription.expiry_date) >='=>$currentdate])->order(['Subscription.package_id' => 'desc'])->first();
  //   $recuriter = $this->Subscription->find('all')->where(['Subscription.user_id' => $user_id, 'Subscription.package_type' => 'RC'])->order(['Subscription.package_id' => 'desc'])->first();
  //   // pr($recuriter); die;

  //   // $currentpackanme=array();

  //   // foreach($subscriptions as $key=>$value){ 
  //   //  if($value['package_type']=='PR'){
  //   $Profilepackcurrent = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => $profile['package_id']])->first();
  //   $currentpackanme['PR'] = $Profilepackcurrent['name'];
  //   $currentpackanmess = $profile['expiry_date'];
  //   //  }
  //   // pr($Profilepackcurrent);exit;
  //   array_push($currentpackanme, $currentpackanmess);

  //   // if($value['package_type']=='RC'){
  //   $recruiterpackcurrent = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y', 'RecuriterPack.id' => $recuriter['package_id']])->first();
  //   $currentpackanme['RC'] = $recruiterpackcurrent['title'];
  //   $currentpackanmess = $recuriter['expiry_date'];

  //   //  }

  //   array_push($currentpackanme, $currentpackanmess);

  //   // }

  //   // pr($currentpackanme);
  //   // exit;
  //   $this->set(compact('currentpackanme'));
  //   // Recruiter Package

  //   $RecuriterPack = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y'])->order(['RecuriterPack.priorites' => 'ASC'])->toarray();
  //   $this->set(compact('RecuriterPack'));

  //   // Requirement Packages 
  //   $this->loadModel('RequirementPack');
  //   $RequirementPack = $this->RequirementPack->find('all')->where(['RequirementPack.status' => 'Y'])->order(['RequirementPack.priorites' => 'ASC'])->toarray();
  //   $this->set('RequirementPack', $RequirementPack);

  //   $Profilepack = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y'])->order(['Profilepack.Visibility_Priority' => 'ASC'])->toarray();
  //   $this->set(compact('Profilepack'));

  //   if ($package == 'profilepackage') {
  //     $pacakgename = "Profile";
  //   } elseif ($package == 'requirementpackage') {
  //     $pacakgename = "Requirement";
  //   } elseif ($package == 'recruiterepackage') {
  //     $pacakgename = "Recruiter";
  //   } else {
  //     $pacakgename = "";
  //   }
  //   // pr($package);exit;
  //   $this->set('package', $package);
  //   $this->set('pacakgename', $pacakgename);
  // }


  // Optimize these codes By Rupam 
  public function allpackages($package = null)
  {
    $this->loadModel('Users');
    $this->loadModel('Profile');
    $this->loadModel('Enthicity');
    $this->loadModel('Profilepack');
    $this->loadModel('RecuriterPack');
    $this->loadModel('Subscription');

    $currentdate = date('Y-m-d H:i:s');
    $user_id = $this->request->session()->read('Auth.User.id');
    // $subscriptions = $this->Subscription->find()
    //   ->where([
    //     'Subscription.user_id' => $user_id,
    //     'OR' => [
    //       ['Subscription.package_type' => 'PR', 'DATE(Subscription.expiry_date) >=' => date('Y-m-d', strtotime($currentdate))],
    //       ['Subscription.package_type' => 'RC']
    //     ]
    //   ])
    //   ->toArray();

    // pr($subscriptions);exit;

    $profile = $this->Subscription->find()
      ->where([
        'Subscription.user_id' => $user_id,
        'Subscription.package_type' => 'PR',
        // 'DATE(Subscription.expiry_date) >=' => date('Y-m-d', strtotime($currentdate))
      ])
      ->order(['Subscription.package_id' => 'desc'])
      ->first();


    $recuriter = $this->Subscription->find()
      ->where([
        'Subscription.user_id' => $user_id,
        'Subscription.package_type' => 'RC',
        // 'DATE(Subscription.expiry_date) >=' => date('Y-m-d', strtotime($currentdate))
      ])
      ->order(['Subscription.package_id' => 'desc'])
      ->first();

    $currentpackanme = [];

    if ($profile) {
      $Profilepackcurrent = $this->Profilepack->find()
        ->where([
          'Profilepack.status' => 'Y',
          'Profilepack.id' => $profile['package_id']
        ])
        ->first();

      $currentpackanme['PR'] = $Profilepackcurrent['name'];
      $currentpackanme[] = $profile['expiry_date'];
    }

    if ($recuriter) {
      $recruiterpackcurrent = $this->RecuriterPack->find()
        ->where([
          'RecuriterPack.status' => 'Y',
          'RecuriterPack.id' => $recuriter['package_id']
        ])
        ->first();

      $currentpackanme['RC'] = $recruiterpackcurrent['title'];
      $currentpackanme[] = $recuriter['expiry_date'];
    }

    // pr($currentpackanme);exit;

    $this->set(compact('currentpackanme'));

    // Recruiter Package
    $RecuriterPack = $this->RecuriterPack->find()
      ->where(['RecuriterPack.status' => 'Y'])
      ->order(['RecuriterPack.priorites' => 'ASC'])
      ->toArray();
    $this->set(compact('RecuriterPack'));

    // Requirement Packages 
    $this->loadModel('RequirementPack');
    $RequirementPack = $this->RequirementPack->find()
      ->where(['RequirementPack.status' => 'Y'])
      ->order(['RequirementPack.priorites' => 'ASC'])
      ->toArray();
    $this->set('RequirementPack', $RequirementPack);

    $Profilepack = $this->Profilepack->find()
      ->where(['Profilepack.status' => 'Y'])
      ->order(['Profilepack.Visibility_Priority' => 'ASC'])
      ->toArray();
    $this->set(compact('Profilepack'));

    // Determine the package name
    $packageNameLookup = [
      'profilepackage' => 'Profile',
      'requirementpackage' => 'Requirement',
      'recruiterepackage' => 'Recruiter'
    ];

    $pacakgename = isset($packageNameLookup[$package]) ? $packageNameLookup[$package] : '';
    // pr($pacakgename);exit;

    $this->set('package', $package);
    $this->set('pacakgename', $pacakgename);
  }



  /*  ---------------------------Buy quote payments--------------------------  */
  public function buyquote($job_id)
  {
    $this->set('job_id', $job_id);
    $this->loadModel('Quotepack');
    $url = $_SERVER['HTTP_REFERER'];
    $this->set('redirection_url', $url);
    $quote_packages = $this->Quotepack->find('all')->where(['Quotepack.status' => 'Y'])->order(['Quotepack.priorites' => 'ASC'])->toarray();
    $this->set(compact('quote_packages'));
  }

  public function buyquotepayment()
  {
    $this->loadModel('Invoicereceipt');
    $invoicereceipt = $this->Invoicereceipt->find('all')->where(['status' => 'Y'])->order(['id' => ASC])->toarray();
    $this->set('invoicereceipt', $invoicereceipt);
    $package_id = $this->request->data['package_id'];
    $redirect_url = $this->request->data['redirect_url'];
    $requirement_id = $this->request->data['requirement_id'];
    $type = 'AC';
    $this->loadModel('Quotepack');
    $pcakgeinformation = $this->Quotepack->find('all')->where(['Quotepack.status' => 'Y', 'Quotepack.id' => $package_id])->order(['Quotepack.id' => 'DESC'])->first();
    $this->set('pcakgeinformation', $pcakgeinformation);
    $this->set('package_id', $package_id);
    $this->set('package_type', $type);
    $this->set('requirement_id', $requirement_id);
    $this->set('redirect_url', $redirect_url);
  }

  public function buyquoteprocessrepayment()
  {
    $this->loadModel('Quotepack');
    $this->loadModel('Transcation');
    $this->loadModel('Subscription');

    $package_id = $this->request->data['package_id'];
    $package_type = $this->request->data['package_type'];
    $package_price = $this->request->data['package_price'];
    $job_id = $this->request->data['requirement_id'];
    $url = $this->request->data['redirect_url'];

    // pr($this->request->data);exit;

    $pcakgeinformation = $this->Quotepack->find('all')
      ->where(['Quotepack.status' => 'Y', 'Quotepack.id' => $package_id])
      ->order(['Quotepack.id' => 'DESC'])
      ->first();
    // pr($pcakgeinformation);exit;

    $this->set('pcakgeinformation', $pcakgeinformation);

    $user_id = $this->request->session()->read('Auth.User.id');
    $subscription_info['package_id'] = $package_id;
    $subscription_info['package_type'] = $package_type;
    $subscription_info['user_id'] =  $user_id;

    $transcation_data['GST'] = $this->request->data['GST'];
    $transcation_data['SGST'] = $this->request->data['SGST'];
    $transcation_data['CGST'] = $this->request->data['CGST'];

    $subscription_info['subscription_date'] = date('Y-m-d H:i:s');
    if ($package_price == '0') {
      $subscription_info['status'] =  'Y';
    }

    $transcation_data['payment_method'] = 'Paypal';
    $transcation_data['amount'] = $package_price;
    $transcation_data['before_tax_amt'] = $pcakgeinformation['total_price'];
    $transcation_data['user_id'] = $user_id;
    $transcation_data['job_id'] =  $job_id;
    $transcation = $this->Transcation->newEntity();
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);
    $transcation_id = $savetranscation->id;
    $this->buyquoteconfirmrepayment($package_id, $transcation_id, $url);
  }

  public function buyquoteconfirmrepayment($package_id, $transcation_id, $url)
  {
    $this->loadModel('Transcation');
    $this->loadModel('Quotepack');

    $pcakgeinformation = $this->Quotepack->find('all')
      ->where(['Quotepack.status' => 'Y', 'Quotepack.id' => $package_id])
      ->order(['Quotepack.id' => 'DESC'])
      ->first();

    $user_id = $this->request->session()->read('Auth.User.id');
    $ref_id = $this->request->session()->read('Auth.User.ref_by');
    $transcation = $this->Transcation->get($transcation_id);

    $transcation_data['status'] = 'Y';
    $transcation_data['description'] = 'AQ';
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);

    if ($ref_id > 0) {
      $this->loadModel('TalentAdmin');
      $this->loadModel('Talentadmintransc');
      $checkrefdata = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $ref_id])->first();
      $commision_per = $checkrefdata['commision'];
      $total_trans = $transcation['before_tax_amt'];
      $commision_amt = ($commision_per / 100) * $total_trans;
      $atranscation = $this->Talentadmintransc->newEntity();
      $atranscation_data['user_id'] = $user_id;
      $atranscation_data['talent_admin_id'] = $ref_id;
      $atranscation_data['amount'] = $commision_amt;
      $atranscation_data['transcation_amount'] = $transcation['amount'];
      $package_type_name = 'AQ';
      //$package_type_name = 'Paid Quote Sent';
      // Package Name
      // $description = $package_type_name;
      $atranscation_data['description'] = $package_type_name;
      $atranscation_data['transaction_id'] = $savetranscation['id'];
      $atranscation_arr = $this->Talentadmintransc->patchEntity($atranscation, $atranscation_data);
      $savetranscation = $this->Talentadmintransc->save($atranscation_arr);
    }

    if ($savetranscation) {
      $this->invoiceMail($savetranscation['id']);
    }
    // Setting job as featured job. 
    $this->loadModel('Requirement');
    $job_id = $transcation['job_id'];
    $number_of_free_quotes = $pcakgeinformation['number_of_free_quotes'];
    $number_of_quote_daily = $pcakgeinformation['number_of_quote_daily'];

    $requirement = $this->Requirement->get($job_id);
    $requirement->askquotedata = $number_of_free_quotes;
    $requirement->askquoteactualdata = $number_of_free_quotes;
    // $requirement->number_of_quote_daily = $number_of_quote_daily;
    $this->Requirement->save($requirement);
    $this->Flash->success(__('You have successfully subscribed for the package!!'));
    return $this->redirect($url);
  }

  /*  ---------------------------Job posting payments--------------------------  */

  function jobposting($package = null)
  {
    $this->loadModel('RequirementPack');
    $this->loadModel('Requirement');
    $this->loadModel('Subscription');
    $user_id = $this->request->session()->read('Auth.User.id');
    $user_role = $this->request->session()->read('Auth.User.role_id');

    $packFeature = $this->activePackage('RC'); // if purches any recuruter packages else default package limit comes 
    $daily_limit = $packFeature['number_of_job_simultancney'];
    // pr($packFeature);exit;
    if ($user_role == NONTALANT_ROLEID) {
      $totalLimitJobPost = $packFeature['non_telent_number_of_job_post'];
      $totalUsedLimit = $packFeature['non_telent_number_of_job_post_used'];
    } else {
      $totalLimitJobPost = $packFeature['number_of_job_post'];
      $totalUsedLimit = $packFeature['number_of_job_post_used'];
    }

    $existing_subscription = $this->Subscription->find('all')
      ->where([
        'user_id' => $user_id,
        'package_type' => 'RE',
        'is_used' => 'N',
      ])
      ->select(['id'])
      ->first();

    // pr($totalLimitJobPost);
    // pr($totalUsedLimit);
    // pr($existing_subscription);
    // exit;

    // Validation checks
    if ($existing_subscription || $totalLimitJobPost > $totalUsedLimit) {
      return $this->redirect('/jobpost');
    }

    // $requirecount = $this->Requirement->find('all')
    //   ->where([
    //     'user_id' => $user_id,
    //     'package_id' => $packFeature['id'],
    //     // 'user_role_id' => $user_role,
    //     'status' => 'Y',
    //     'is_paid_post' => 'N',
    //     'DATE(created)' => date('Y-m-d')
    //   ])
    //   ->count();
    $currentdate = date('Y-m-d H:m:s');
    $requirecount = $this->Requirement->find('all')
      ->where([
        'Requirement.user_id' => $user_id,
        'DATE(Requirement.last_date_app) >=' => $currentdate,
        'status' => 'Y'
      ])
      ->count();

    // echo 'This will execute if the if condition is false.';die;
    if ($user_role == TALANT_ROLEID && $requirecount >= $daily_limit) {
      $this->Flash->error(__(
        'You have reached your daily job posting limit of {0}. Jobs posted today: {1}. Please try again tomorrow or upgrade your package.',
        $daily_limit,
        $requirecount
      ));
      return $this->redirect($this->referer());
    }

    $requirement_packages = $this->RequirementPack->find('all')
      ->where(['status' => 'Y'])
      ->order(['priorites' => 'ASC'])
      ->toarray();
    // pr($requirement_packages);exit;
    $this->set(compact('requirement_packages', 'packFeature', 'totalLimitJobPost', 'totalUsedLimit'));
  }

  // Job Payment while posting job (Requrement Package)
  public function jobpayment()
  {
    $this->loadModel('Invoicereceipt');
    $invoicereceipt = $this->Invoicereceipt->find('all')->where(['status' => 'Y'])->order(['id' => 'DESC'])->toarray();
    $this->set('invoicereceipt', $invoicereceipt);

    $package_id = $this->request->data['package_id'];
    $package_type = $this->request->data['package_type'];
    // pr($this->request->data);die;
    $type = $package_type;
    if ($this->request->data['isFree'] == 'FR') {
      //This is for free job post...
      // $this->loadModel('RequirementPack');
      // $pcakgeinformation = $this->RequirementPack->find('all')->where(['RequirementPack.status' => 'Y', 'RequirementPack.id' => $package_id])->order(['RequirementPack.id' => 'DESC'])->first();
      // if ($this->request->session()->read('eligible.jobpostcredit') > 0) {

      //   $clone_id = '';
      //   $clone_id = $this->request->session()->read('eligible.clone_id');
      //   //$this->redirect('/jobpost/jobpost');
      //   $eligible['jobpost'] = 1;
      //   $eligible['job_validity'] = $this->request->session()->read('settings.number_of_days_free_jobpost');
      //   $eligible['job_skills'] = $this->request->session()->read('settings.number_of_talent_free_jobpost');
      //   $eligible['clone_id'] = $clone_id;


      //   $this->request->session()->write('eligible', $eligible);
      $this->redirect('/jobpost');
      // }
      $posttype['postingtype'] = 'Free Posting';
      $this->request->session()->write('posttype', $posttype);
    } else {
      $this->loadModel('RequirementPack');
      $pcakgeinformation = $this->RequirementPack->find('all')->where(['RequirementPack.status' => 'Y', 'RequirementPack.id' => $package_id])->order(['RequirementPack.id' => 'DESC'])->first();
      // pr($pcakgeinformation); die;
      // if ($this->request->session()->read('eligible.jobpostcredit') > 0) {
      // if ($this->request->session()->read('eligible.jobpostcredit') < 0) {

      //   $clone_id = '';
      //   $clone_id = $this->request->session()->read('eligible.clone_id');
      //   //$this->redirect('/jobpost/jobpost');
      //   $eligible['jobpost'] = 1;
      //   $eligible['job_validity'] = $pcakgeinformation['number_of_days'];
      //   $eligible['job_skills'] = $pcakgeinformation['number_of_talent_type'];
      //   $eligible['clone_id'] = $clone_id;
      //   $this->request->session()->write('eligible', $eligible);
      //   $this->redirect('/jobpost/jobpost/' .  $clone_id);
      // }
      // $posttype['postingtype'] = 'Paid Posting Option $' . $pcakgeinformation['price'];
      // $this->request->session()->write('posttype', $posttype);
    }

    $this->loadModel('Profile');
    $this->loadModel('Users');
    $this->loadModel('Country');
    $user_id = $this->request->session()->read('Auth.User.id');
    $profile = $this->Profile->find('all')->contain(['Users', 'Country'])->where(['user_id' => $user_id])->first();
    $this->set('profile', $profile);
    $this->set('package_type', $type);
    $this->set('pcakgeinformation', $pcakgeinformation);
    $this->set('package_id', $package_id);
  }

  // Processing Payment while posting job
  public function processrepayment()
  {
    $this->loadModel('Transcation');
    $this->loadModel('Subscription');
    $this->loadModel('RequirementPack');

    //pr($this->request->session()->read('posttype')); die;
    $package_id = $this->request->data['package_id'];
    $package_type = $this->request->data['package_type'];
    $package_price = $this->request->data['package_price'];
    $user_id = $this->request->session()->read('Auth.User.id');
    $pcakgeinformation = $this->RequirementPack->find('all')->where(['status' => 'Y', 'id' => $package_id])->order(['id' => 'DESC'])->first();
    // pr($this->request->data);
    // pr($pcakgeinformation);
    // die;
    $this->set('pcakgeinformation', $pcakgeinformation);

    $subscription_info = [
      'user_id' => $user_id,
      'package_id' => $package_id,
      'package_type' => $package_type,
      'subscription_date' => date('Y-m-d H:i:s'),
      'status' => ($package_price == '0') ? 'Y' : 'N'
    ];

    $existing_subscription = $this->Subscription->find('all')
      ->where([
        'user_id' => $user_id,
        'is_used' => 'N',
        'package_id' => $package_id
      ])
      ->first();
    // pr($subscription_info);exit;

    if (!$existing_subscription) {
      $subscription = $this->Subscription->newEntity();
      $subscription = $this->Subscription->patchEntity($subscription, $subscription_info);

      if ($subscriptionSave = $this->Subscription->save($subscription)) {
        $transcation_data['subscription_id'] = $subscriptionSave->id;
      } else {
        $this->Flash->error(__('Failed to save the subscription. Please try again.'));
        return $this->redirect('/myrequirement');
      }
    } else {
      $this->Flash->error(__('You have already purchased this package.'));
      return $this->redirect('/myrequirement');
    }

    $transcation_data['before_tax_amt'] = $pcakgeinformation['price'];
    $transcation_data['number_of_days'] = $pcakgeinformation['number_of_days'];
    $transcation_data['payment_method'] = 'Paypal';
    $transcation_data['amount'] = $package_price;
    $transcation_data['user_id'] = $user_id;

    $transcation_data['package_id'] = $package_id;
    $transcation_data['number_of_talent_type'] = $pcakgeinformation['number_of_talent_type'];
    $transcation_data['post_priorites'] = $pcakgeinformation['priorites'];

    $transcation_data['GST'] = $this->request->data['GST'];
    $transcation_data['SGST'] = $this->request->data['SGST'];
    $transcation_data['CGST'] = $this->request->data['CGST'];

    $transcation = $this->Transcation->newEntity();
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);
    $transcation_id = $savetranscation->id;
    $this->confirmrepayment($package_id, $transcation_id);
  }

  // Confirm job posting payment. 
  public function confirmrepayment($package_id, $transcation_id)
  {
    // Complete the Transcation
    $this->loadModel('Transcation');
    $this->loadModel('RequirementPack');
    $pcakgeinformation = $this->RequirementPack->find('all')->where(['RequirementPack.status' => 'Y', 'RequirementPack.id' => $package_id])->order(['RequirementPack.id' => 'DESC'])->first();
    $user_id = $this->request->session()->read('Auth.User.id');
    $ref_id = $this->request->session()->read('Auth.User.ref_by');
    $transcation = $this->Transcation->get($transcation_id);

    $transcation_data['status'] = 'Y';
    $transcation_data['description'] = 'PAR';
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);

    // Adding Talent admin transcation
    if ($ref_id > 0) {
      $this->loadModel('TalentAdmin');
      $this->loadModel('Talentadmintransc');
      $checkrefdata = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $ref_id])->first();
      $commision_per = $checkrefdata['commision'];
      $total_trans = $transcation['before_tax_amt'];
      $commision_amt = ($commision_per / 100) * $total_trans;
      $atranscation = $this->Talentadmintransc->newEntity();
      $atranscation_data['user_id'] = $user_id;
      $atranscation_data['talent_admin_id'] = $ref_id;
      $atranscation_data['amount'] = $commision_amt;
      $atranscation_data['transcation_amount'] = $transcation['amount'];

      // Package Name
      //$description = "Post a Requirement";
      $description = "PAR";
      $atranscation_data['description'] = $description;
      $atranscation_data['transaction_id'] = $savetranscation['id'];
      $atranscation_arr = $this->Talentadmintransc->patchEntity($atranscation, $atranscation_data);
      $savetranscation = $this->Talentadmintransc->save($atranscation_arr);
    }

    if ($savetranscation) {
      $this->invoiceMail($savetranscation['id']);
    }
    // pr('You have successfully subscribed for the package!!');exit;
    $clone_id = '';
    $clone_id = $this->request->session()->read('eligible.clone_id');
    $eligible['jobpost'] = 1;
    $eligible['clone_id'] = $clone_id;
    $eligible['job_validity'] = $pcakgeinformation['number_of_days'];
    $eligible['job_skills'] = $pcakgeinformation['number_of_talent_type'];
    $this->request->session()->write('eligible', $eligible);
    $this->Flash->success(__('You have successfully subscribed for the package!!'));
    return $this->redirect('/jobpost/jobpost/' . $clone_id);
  }

  /*  --------------------------Feature job Payment--------------------------  */
  public function fjobpayment()
  {
    $this->loadModel('Invoicereceipt');
    $invoicereceipt = $this->Invoicereceipt->find('all')->where(['status' => 'Y'])->order(['id' => 'ASC'])->toarray();
    $this->loadModel('Featuredjob');
    $this->set('invoicereceipt', $invoicereceipt);
    // pr($this->request->data);exit;
    $package_id = $this->request->data['fpackage_id'];
    $number_of_days = $this->request->data['number_of_days'];
    $job_id = $this->request->data['job_id'];
    $featuredjob = $this->Featuredjob->find('all')->where(['Featuredjob.status' => 'Y', 'Featuredjob.id' => $package_id])->order(['Featuredjob.priorites' => 'ASC'])->first();
    if ($featuredjob['validity_days'] == '1' && $number_of_days > 0) {
      $package_price = $number_of_days * $featuredjob['price'];
    } else {
      $package_price = $featuredjob['price'];
      $number_of_days = 0;
    }
    //pr($this->request->data); die;

    $this->set('number_of_days', $number_of_days);
    $this->set('package_price', $package_price);
    $this->set('pcakgeinformation', $featuredjob);
    $this->set('package_id', $package_id);
    $this->set('job_id', $job_id);


    $this->loadModel('Profile');
    $this->loadModel('Users');
    $this->loadModel('Country');
    $user_id = $this->request->session()->read('Auth.User.id');
    $profile = $this->Profile->find('all')->contain(['Users', 'Country'])->where(['user_id' => $user_id])->first();
    $this->set('profile', $profile);
  }


  // Process Featured Job payment
  function processfjpayment()
  {
    //pr($this->request->data); die;
    $user_id = $this->request->session()->read('Auth.User.id');
    $package_id = $this->request->data['package_id'];
    $number_of_days = $this->request->data['number_of_days'];
    $job_id = $this->request->data['job_id'];
    $transcation_data['payment_method'] = 'Paypal';
    $transcation_data['amount'] = $this->request->data['package_price'];
    $transcation_data['before_tax_amt'] = $this->request->data['before_tax_amt'];


    $transcation_data['GST'] = $this->request->data['GST'];
    $transcation_data['SGST'] = $this->request->data['SGST'];
    $transcation_data['CGST'] = $this->request->data['CGST'];
    //$transcation_data['amount'] = $pcakgeinformation['price'];
    $transcation_data['user_id'] = $user_id;
    $transcation_data['number_of_days'] = $number_of_days;
    $transcation_data['job_id'] = $job_id;
    $this->loadModel('Transcation');
    $transcation = $this->Transcation->newEntity();
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);
    $transcation_id = $savetranscation->id;
    $this->confirmfjpayment($package_id, $transcation_id);
  }


  // Confirm featured job payment
  public function confirmfjpayment($package_id, $transcation_id)
  {
    // Complete the Transcation
    $this->loadModel('Featuredjob');
    $pcakgeinformation = $this->Featuredjob->find('all')->where(['Featuredjob.status' => 'Y', 'Featuredjob.id' => $package_id])->order(['Featuredjob.priorites' => 'ASC'])->first();
    $user_id = $this->request->session()->read('Auth.User.id');
    $ref_id = $this->request->session()->read('Auth.User.ref_by');
    $this->loadModel('Transcation');
    $transcation = $this->Transcation->get($transcation_id);

    $transcation_data['status'] = 'Y';
    $transcation_data['description'] = 'FJ'; // Feature Job
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);

    // Adding Talent admin transcation
    if ($ref_id > 0) {
      $this->loadModel('TalentAdmin');
      $this->loadModel('Talentadmintransc');
      $checkrefdata = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $ref_id])->first();
      $commision_per = $checkrefdata['commision'];
      $total_trans = $transcation['before_tax_amt'];
      $commision_amt = ($commision_per / 100) * $total_trans;
      $atranscation = $this->Talentadmintransc->newEntity();
      $atranscation_data['user_id'] = $user_id;
      $atranscation_data['talent_admin_id'] = $ref_id;
      $atranscation_data['amount'] = $commision_amt;
      $atranscation_data['transcation_amount'] = $transcation['amount'];

      // Package Name
      //$description = "Featured Job";
      $description = "FJ";
      $atranscation_data['description'] = $description;
      $atranscation_data['transaction_id'] = $savetranscation['id'];
      $atranscation_arr = $this->Talentadmintransc->patchEntity($atranscation, $atranscation_data);
      $savetranscation = $this->Talentadmintransc->save($atranscation_arr);
    }
    if ($savetranscation) {
      $this->invoiceMail($savetranscation['id']);
    }

    // Setting job as featured job. 
    $this->loadModel('Requirement');
    $job_id = $transcation['job_id'];
    $number_of_days = $transcation['number_of_days'];
    $currentdate = date('Y-m-d H:m:s');
    $expiredate = date('Y-m-d H:m:s', strtotime($currentdate . "+$number_of_days days"));
    $requirement = $this->Requirement->get($job_id);

    $myrequirement['expiredate'] = $expiredate;
    $myrequirement['feature_job_pack'] = $package_id;
    $myrequirement['feature_job_days'] = $number_of_days;
    $myrequirement['feature_job_date'] = $currentdate;
    $myrequirement['featured'] = 'Y';

    $requirementsave = $this->Requirement->patchEntity($requirement, $myrequirement);
    $this->Requirement->save($requirementsave);

    $this->redirect('/myrequirement');
    $this->Flash->success(__('Your job has been featured successfully!'));
    return $this->redirect('/myrequirement');
  }



  /*  ----------------------------------------------------------------------------------  
        Feature Profile Payment 
        ----------------------------------------------------------------------------------  */
  public function fprofilepayment()
  {
    $this->loadModel('Invoicereceipt');
    $invoicereceipt = $this->Invoicereceipt->find('all')->where(['status' => 'Y'])->order(['id' => 'ASC'])->toarray();
    $this->set('invoicereceipt', $invoicereceipt);

    $this->loadModel('Featuredprofile');
    $package_id = $this->request->data['fpackage_id'];
    $number_of_days = $this->request->data['number_of_days'];
    $profile_id = $this->request->data['profile_id'];
    $featuredjob = $this->Featuredprofile->find('all')->where(['Featuredprofile.status' => 'Y', 'Featuredprofile.id' => $package_id])->order(['Featuredprofile.priorites' => 'ASC'])->first();
    // pr($this->request->data);die;
    if ($featuredjob['validity_days'] == '1' && $number_of_days > 0) {
      $package_price = $number_of_days * $featuredjob['price'];
    } else {
      $package_price = $featuredjob['price'];
      $number_of_days = 0;
    }
    $this->set('number_of_days', $number_of_days);
    $this->set('package_price', $package_price);
    $this->set('pcakgeinformation', $featuredjob);
    $this->set('package_id', $package_id);

    $this->loadModel('Profile');
    $this->loadModel('Users');
    $this->loadModel('Country');
    $user_id = $this->request->session()->read('Auth.User.id');
    $this->set('profile_id', $user_id);

    $profile = $this->Profile->find('all')->contain(['Users', 'Country'])->where(['user_id' => $user_id])->first();
    $this->set('profile', $profile);
  }


  // Process Featured Profile payment
  function processfppayment()
  {
    //pr($this->request->data); die;
    $currentdate = date('Y-m-d H:i:s');
    $user_id = $this->request->session()->read('Auth.User.id');
    $package_id = $this->request->data['package_id'];
    $number_of_days = $this->request->data['number_of_days'];
    $profile_id = $this->request->data['profile_id'];

    $transcation_data['GST'] = $this->request->data['GST'];
    $transcation_data['SGST'] = $this->request->data['SGST'];
    $transcation_data['CGST'] = $this->request->data['CGST'];

    $transcation_data['payment_method'] = 'Paypal';
    $transcation_data['amount'] = $this->request->data['package_price'];
    $transcation_data['before_tax_amt'] = $this->request->data['before_tax_amt'];
    //$transcation_data['amount'] = $pcakgeinformation['price'];
    $transcation_data['user_id'] = $user_id;
    $transcation_data['number_of_days'] = $number_of_days;
    $transcation_data['profile_id'] = $profile_id;
    $this->loadModel('Transcation');
    $transcation = $this->Transcation->newEntity();
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);
    $transcation_id = $savetranscation['id'];
    $this->confirmfppayment($package_id, $transcation_id);
  }


  // Confirm featured profile payment
  public function confirmfppayment($package_id, $transcation_id)
  {
    // Complete the Transcation
    $this->loadModel('Featuredprofile');
    // $this->loadModel('Users');

    $pcakgeinformation = $this->Featuredprofile->find('all')->where(['Featuredprofile.status' => 'Y', 'Featuredprofile.id' => $package_id])->order(['Featuredprofile.priorites' => 'ASC'])->first();
    $user_id = $this->request->session()->read('Auth.User.id');
    $ref_id = $this->request->session()->read('Auth.User.ref_by');
    $this->loadModel('Transcation');
    $transcation = $this->Transcation->get($transcation_id);

    $transcation_data['description'] = 'FP';
    $transcation_data['status'] = 'Y';
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);

    // Adding Talent admin transcation
    if ($ref_id > 0) {
      $this->loadModel('TalentAdmin');
      $this->loadModel('Talentadmintransc');
      $checkrefdata = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $ref_id])->first();
      $commision_per = $checkrefdata['commision'];
      $total_trans = $transcation['before_tax_amt'];
      $commision_amt = ($commision_per / 100) * $total_trans;
      $atranscation = $this->Talentadmintransc->newEntity();
      $atranscation_data['user_id'] = $user_id;
      $atranscation_data['talent_admin_id'] = $ref_id;
      $atranscation_data['amount'] = $commision_amt;
      $atranscation_data['transcation_amount'] = $transcation['amount'];
      $package_type_name = 'FP';
      //$package_type_name = 'Featured Profile';
      // Package Name
      $description = $package_type_name;
      $atranscation_data['description'] = $description;
      $atranscation_data['transaction_id'] = $savetranscation['id'];
      $atranscation_arr = $this->Talentadmintransc->patchEntity($atranscation, $atranscation_data);
      $savetranscation = $this->Talentadmintransc->save($atranscation_arr);
    }
    if ($savetranscation) {
      $this->invoiceMail($savetranscation['id']);
    }

    // Setting job as featured job. 
    $this->loadModel('Users');
    //pr($transcation); die;
    $user_id = $transcation['user_id'];
    $number_of_days = $transcation['number_of_days'];
    $currentdate = date('Y-m-d H:m:s');
    $expiredate = date('Y-m-d H:m:s', strtotime($currentdate . "+$number_of_days days"));
    $profile = $this->Users->get($user_id);

    $myrequirement['featured_expiry'] = $expiredate;
    $myrequirement['feature_pro_pack_id'] = $package_id;
    $myrequirement['feature_pro_pack_numofday'] = $number_of_days;
    $myrequirement['feature_pro_date'] = $currentdate;

    $Usersave = $this->Users->patchEntity($profile, $myrequirement);
    $this->Users->save($Usersave);

    $this->loadModel('Profilefeatured');
    $profilefeaturednew = $this->Profilefeatured->newEntity();
    $profilefeatured['user_id'] = $this->request->session()->read('Auth.User.id');
    $profilefeatured['expirydate'] = $expiredate;
    $profilefeatured['amount'] = $transcation['amount'];
    $profilefeatured['number_of_days'] = $number_of_days;
    $profilefeaturedsave = $this->Profilefeatured->patchEntity($profilefeaturednew, $profilefeatured);
    $this->Profilefeatured->save($profilefeaturedsave);


    $this->redirect('/profile');
    $this->Flash->success(__('Your Profile has been featured successfully!!'));
    return $this->redirect('/profile');
  }

  public function buy($type, $id)
  {
    $this->loadModel('Invoicereceipt');
    $invoicereceipt = $this->Invoicereceipt->find('all')->where(['status' => 'Y'])->order(['id' => 'ASC'])->toarray();
    $this->set('invoicereceipt', $invoicereceipt);


    if ($id == RECUITER_PACKAGE) {
      $clone_id = $this->request->session()->read('eligible.clone_id');
      $eligible['jobpost'] = 1;
      $this->request->session()->write('eligible', $eligible);
      //echo $clone_id;die;
      if ($clone_id > 0) {
        return $this->redirect('/jobpost/jobpost/' . $clone_id);
      } else {
        return $this->redirect('/jobpost/jobpost');
      }
    }

    $this->loadModel('Profile');
    $this->loadModel('Users');
    $this->loadModel('Country');
    $user_id = $this->request->session()->read('Auth.User.id');
    $profile = $this->Profile->find('all')->contain(['Users', 'Country'])->where(['user_id' => $user_id])->first();
    $this->set('profile', $profile);

    //$users = $this->Users->newEntity();
    /*if ($this->request->is(['post', 'put']))
      {
      //pr($this->request->data); die;
      $name  = $this->request->data['user_name'];
      $email = $this->request->data['email'];
      $phone = $this->request->data['phone'];
      $password = $this->request->data['password'];
      $site_url=SITE_URL;
      $useractivation = $this->request->data['user_activation_key'];
      $this->request->data['password']= $this->_setPassword($this->request->data['password']);
      $this->request->data['confirmpass']= $this->request->data['confirmpassword'];
      $this->request->data['role_id']= NONTALANT_ROLEID ;
      $this->request->data['profilepack_id']= PROFILE_PACKAGE ;
      $department = $this->Users->patchEntity($users, $this->request->data);

      if ($register = $this->Users->save($department))
          */

    $pcakgeinformation = '';
    if ($type == 'profilepackage') {
      $this->loadModel('Profilepack');
      $pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => $id])->order(['Profilepack.id' => 'ASC'])->first();
    } elseif ($type == 'requirementpackage') {
      $this->loadModel('RequirementPack');
      $pcakgeinformation = $this->RequirementPack->find('all')->where(['RequirementPack.status' => 'Y', 'RequirementPack.id' => $id])->order(['RequirementPack.id' => 'DESC'])->first();
    } elseif ($type == 'recruiterepackage') {
      $this->loadModel('RecuriterPack');
      $pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y', 'RecuriterPack.id' => $id])->order(['RecuriterPack.id' => 'DESC'])->first();
    }
    // pr($pcakgeinformation);
    // exit;
    $this->set('package_type', $type);
    $this->set('pcakgeinformation', $pcakgeinformation);
    $this->set('package_id', $id);
  }

  // Processing Payment for the Package 
  public function processpayment()
  {
    //$session_action = (!empty($_SESSION['session_action']))?$_SESSION['session_action']:'index';
    //$session_controller = (!empty($_SESSION['session_controller']))?$_SESSION['session_controller']:'homes';
    $this->loadModel('RequirementPack');
    $this->loadModel('Profilepack');
    $this->loadModel('RecuriterPack');
    $this->loadModel('Subscription');
    $this->loadModel('Transcation');

    // pr($this->request->data); die;
    $user_id = $this->request->session()->read('Auth.User.id');
    $package_id = $this->request->data['package_id'];
    $package_type = $this->request->data['package_type'];
    $package_price = $this->request->data['package_price'];
    $before_tax_amt = $this->request->data['before_tax_amt'];
    $currentdate = date('Y-m-d H:i:s');

    // echo $package_id;
    $pcakgeinformation = '';
    if ($package_type == 'profilepackage') {
      $pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => $package_id])->order(['Profilepack.id' => 'DESC'])->first();
      $package_type = 'PR';
    } elseif ($package_type == 'requirementpackage') {
      $pcakgeinformation = $this->RequirementPack->find('all')->where(['RequirementPack.status' => 'Y', 'RequirementPack.id' => $package_id])->order(['RequirementPack.id' => 'DESC'])->first();
      $package_type = 'RE';
    } elseif ($package_type == 'recruiterepackage') {
      $pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y', 'RecuriterPack.id' => $package_id])->order(['RecuriterPack.id' => 'DESC'])->first();
      $package_type = 'RC';
    }

    // pr($pcakgeinformation); 
    $this->set('pcakgeinformation', $pcakgeinformation);

    $subscription_info['package_id'] = $package_id;
    $subscription_info['package_type'] = $package_type;
    $subscription_info['user_id'] =  $user_id;
    $subscription_info['subscription_date'] = date('Y-m-d H:i:s');
    //if($package_price=='0'){
    $subscription_info['status'] =  'Y';
    //  }

    $package_duration = $pcakgeinformation['validity_days'];
    // pr($package_duration); die;
    //  $expiry_date = strtotime('+'.$package_duration.' months',time());
    $expiry_date = date('Y-m-d H:i:s', strtotime($currentdate . "+$package_duration days"));
    $subscription_info['expiry_date'] = $expiry_date;
    // pr($subscription_info);exit;

    $subscriptions = $this->Subscription->find('all')->where(['Subscription.user_id' => $user_id, 'Subscription.package_type' => $package_type, 'Subscription.package_id' => $package_id])->first();

    if ($subscriptions) {
      $today_date =  date('Y-m-d H:i:s');
      $expiry_date = date('Y-m-d H:i:s', strtotime($subscriptions['expiry_date']));
      if ($expiry_date >= $today_date && $subscriptions['package_id'] == $package_id) {
        $this->Flash->error(__('You have already subscribed this package!!'));
        return $this->redirect(['controller' => 'package', 'action' => 'allpackages']);
      }
      if ($subscriptions['package_id'] == $package_id) {
        $subscription = $this->Subscription->get($subscriptions['id']);
        $subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
        $savedata = $this->Subscription->save($subscription_arr);
        $subscription_id = $savedata->id;
      } else {
        $subscription = $this->Subscription->newEntity();
        $subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
        $savedata = $this->Subscription->save($subscription_arr);
        $subscription_id = $savedata->id;
      }
    } else {
      $subscription = $this->Subscription->newEntity();
      $subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
      $savedata = $this->Subscription->save($subscription_arr);
      $subscription_id = $savedata->id;
    }

    if ($package_price == '0') {
      $this->Flash->success(__('You have successfully subscribed for the package!!'));
      // return $this->redirect(['controller' => $session_controller, 'action' => $session_action]);
      return $this->redirect(['controller' => 'package', 'action' => 'allpackages']);
    } else {
      $transcation_data['subscription_id'] = $subscription_id;
      $transcation_data['payment_method'] = 'Paypal';
      $transcation_data['amount'] = $package_price;
      $transcation_data['before_tax_amt'] = $before_tax_amt;
      $transcation_data['number_of_days'] = $package_duration;
      $transcation_data['user_id'] = $user_id;

      $transcation_data['GST'] = $this->request->data['GST'];
      $transcation_data['SGST'] = $this->request->data['SGST'];
      $transcation_data['CGST'] = $this->request->data['CGST'];

      $transcation = $this->Transcation->newEntity();
      $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
      $savetranscation = $this->Transcation->save($transcation_arr);
      $transcation_id = $savetranscation['id'];
      $this->confirmpayment($package_id, $package_type, $transcation_id, $expiry_date);

      // pr($pcakgeinformation); 
      $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
      $paypalID = 'ravi@doomshell.com'; //Business Email
      $cancel_return = SITE_URL . 'storesearch'; //Cancel URL
      $return = SITE_URL . 'storesearch/' . $lasid; //Return URL
      $notify_url = SITE_URL . 'cart/payment_done'; //Notify URL
      $this->set('paypalURL', $paypalURL);
      $this->set('paypalID', $paypalID);
      $this->set('cancel_return', $cancel_return);
      $this->set('return', $return);
      $this->set('notify_url', $notify_url);
      $this->set('paymentaction', 'sale');
      $package_name = $pcakgeinformation->name;
      $this->set('package_name', $package_name);
      $package_id = $pcakgeinformation->id;
      $this->set('package_id', $package_id);
      $package_price = $pcakgeinformation->price;
      $this->set('package_price', $package_price);
      $user_data = $this->request->session()->read('Auth.User');
      $this->set('user_data', $user_data);
    }
  }

  public function confirmpayment($package_id, $package_type, $transcation_id, $expiry_date)
  {

    // Complete the Transcation

    if ($package_type == 'PR') {
      //$package_type_name = 'Profile ';
      $package_type_name = 'PP';
    } elseif ($package_type == 'RC') {
      //$package_type_name = 'Recruiter ';
      $package_type_name = 'RP';
    } elseif ($package_type == 'RE') {
      //$package_type_name = 'Requirement ';
      $package_type_name = 'PAR';
    }
    $this->loadModel('Transcation');
    $this->loadModel('Settings');

    $user_id = $this->request->session()->read('Auth.User.id');
    $ref_id = $this->request->session()->read('Auth.User.ref_by');
    $transcation = $this->Transcation->get($transcation_id);

    $transcation_data['description'] = $package_type_name;
    $transcation_data['status'] = 'Y';
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);

    // Adding Talent admin transcation
    if ($ref_id > 0) {
      $this->loadModel('TalentAdmin');
      $this->loadModel('Talentadmintransc');
      $checkrefdata = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $ref_id])->first();
      $commision_per = $checkrefdata['commision'];
      $total_trans = $transcation['amount'];
      $total_trans = $transcation['before_tax_amt']; //Changed by rupam 10-05-2023 as per client says
      $commision_amt = ($commision_per / 100) * $total_trans;
      $atranscation = $this->Talentadmintransc->newEntity();
      $atranscation_data['user_id'] = $user_id;
      $atranscation_data['talent_admin_id'] = $ref_id;
      $atranscation_data['amount'] = $commision_amt;
      $atranscation_data['transcation_amount'] = $transcation['amount'];
      // Package Name
      $description = $package_type_name;
      $atranscation_data['description'] = $description;
      $atranscation_data['transaction_id'] = $savetranscation['id'];
      $atranscation_data['transaction_id'] = $transcation_id;
      $atranscation_arr = $this->Talentadmintransc->patchEntity($atranscation, $atranscation_data);
      $savetranscation = $this->Talentadmintransc->save($atranscation_arr);
    }
    if ($savetranscation) {
      $this->invoiceMail($savetranscation['id']);
    }
    $this->loadModel('Packfeature');
    $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'DESC'])->first();
    $packfeature_id = $packfeature['id'];

    if ($package_type == 'PR') {

      $this->loadModel('Profilepack');
      $pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => $package_id])->order(['Profilepack.id' => 'DESC'])->first();
      $feature_info['number_categories'] = $pcakgeinformation['number_categories'];
      $feature_info['number_audio'] = $pcakgeinformation['number_audio'];
      $feature_info['number_video'] = $pcakgeinformation['number_video'];
      $feature_info['website_visibility'] = $pcakgeinformation['website_visibility'];
      $feature_info['private_individual'] = $pcakgeinformation['private_individual'];
      $feature_info['access_job'] = $pcakgeinformation['access_job'];
      $feature_info['number_job_application'] = $pcakgeinformation['number_job_application'];
      $feature_info['number_job_application_month'] = $pcakgeinformation['number_job_application'];
      $feature_info['number_job_application_daily'] = $pcakgeinformation['number_of_application_day'];
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
    } elseif ($package_type == 'RE') {
      $this->loadModel('RequirementPack');
      $pcakgeinformation = $this->RequirementPack->find('all')->where(['RequirementPack.status' => 'Y', 'RequirementPack.id' => $package_id])->order(['RequirementPack.id' => 'DESC'])->first();
      $feature_info['requirement_package_jobs'] = 1;
    } elseif ($package_type == 'RC') {
      $this->loadModel('RecuriterPack');
      $this->loadModel('Settings');
      $pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y', 'RecuriterPack.id' => $package_id])->order(['RecuriterPack.id' => 'DESC'])->first();
      $settingPack = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();
      //pr($pcakgeinformation); die;
      $feature_info['number_of_job_post'] = $pcakgeinformation['number_of_job_post'];
      $feature_info['number_of_job_simultancney'] = $pcakgeinformation['number_of_job_simultancney'];
      $feature_info['nubmer_of_site'] = $pcakgeinformation['nubmer_of_site'];
      $feature_info['number_of_contact_details'] = $pcakgeinformation['number_of_contact_details'];
      $feature_info['number_of_talent_search'] = $pcakgeinformation['number_of_talent_search'];
      $feature_info['lengthofpackage'] = $pcakgeinformation['lengthofpackage'];
      $feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging']; // Y,N
      $feature_info['number_of_message'] = $pcakgeinformation['number_of_message'];
      $feature_info['non_telent_number_of_private_message'] = $settingPack['non_telent_number_of_private_message'];
      $feature_info['number_of_email'] = $pcakgeinformation['number_of_email'];
      $feature_info['multipal_email_login'] = $pcakgeinformation['multipal_email_login'];
    }
    //pr($feature_info); die;
    // $packfeature = $this->Packfeature->get($packfeature_id);
    // $features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
    // $this->Packfeature->save($features_arr);

    $pcakgesettinginformation = $this->Settings->find('all')
      ->select(['number_of_talent_free_jobpost'])
      ->order(['id' => 'DESC'])
      ->first();
    $feature_info['number_of_talent_free_jobpost'] = $pcakgesettinginformation['number_of_talent_free_jobpost'];
    $feature_info['package_status'] = $package_type;
    $feature_info['user_id'] = $user_id;
    $feature_info['number_of_days_free_jobpost'] = $user_id;
    $feature_info['expire_date'] = $expiry_date;


    $packfeature = $this->Packfeature->newEntity();
    $features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
    $this->Packfeature->save($features_arr);
    // if ($this->Packfeature->save($features_arr)) {
    //   $this->Flash->success(__('New record has been created successfully.'));
    // } else {
    //   $this->Flash->error(__('Unable to create a new record. Please try again.'));
    // }


    $session_action = (!empty($_SESSION['session_action'])) ? $_SESSION['session_action'] : 'index';
    $session_controller = (!empty($_SESSION['session_controller'])) ? $_SESSION['session_controller'] : 'homes';

    // $this->Flash->success(__('You have successfully subscribed for the package!!'));
    // return $this->redirect(['controller' => $session_controller,'action' => $session_action]);

    //this code added by gajanand
    $this->Flash->success(__('You have successfully subscribed for the package!!'));
    return $this->redirect(['controller' => 'package', 'action' => 'allpackages']);
    //end

    //return true;

  }

  public function Pingpay()
  {

    $this->loadModel('Transcation');
    $this->loadModel('JobApplication');
    $user_id = $this->request->session()->read('Auth.User.id');

    if ($this->request->is(['post', 'put'])) {

      // pr($this->request->data);die;

      //$this->isavaibale($jobid);
      //die;
      $transcation = $this->Transcation->newEntity();
      $this->request->data['status'] = 'Y';
      $this->request->data['user_id'] = $user_id;
      $jobid = $this->request->data['job_id'];
      $transcation_arr = $this->Transcation->patchEntity($transcation, $this->request->data);
      // pr($transcation_arr);exit;
      $savetranscation = $this->Transcation->save($transcation_arr);
      if ($savetranscation) {
        $JobApplicationenty = $this->JobApplication->newEntity();
        $Jobapppingdata['user_id'] = $user_id;
        $Jobapppingdata['talent_accepted_status'] = "Y";
        $Jobapppingdata['ping'] = 1;
        $Jobapppingdata['job_id'] = $jobid;
        $Jobapppingdata['skill_id'] = $this->request->data['skill'];
        $Jobapppingdata['cover'] = $this->request->data['cover'];

        $JobApplicationdata = $this->JobApplication->patchEntity($JobApplicationenty, $Jobapppingdata);
        $savejob = $this->JobApplication->save($JobApplicationdata);

        if ($savejob) {
          $this->Flash->success(__('You have Pinged this to job successfully!!'));
          echo $this->redirect(Router::url($this->referer(), true));
        }
      }
    }
  }

  public function sendpaidquote()
  {

    $this->loadModel('Transcation');
    $this->loadModel('JobApplication');
    $this->loadModel('JobQuote');
    $user_id = $this->request->session()->read('Auth.User.id');

    if ($this->request->is(['post', 'put'])) {

      // pr($this->request->data);
      // die;
      $transcation = $this->Transcation->newEntity();
      $this->request->data['status'] = 'Y';
      $this->request->data['user_id'] = $user_id;
      $this->request->data['description'] = 'PQ';
      $jobid = $this->request->data['job_id'];
      $transcation_arr = $this->Transcation->patchEntity($transcation, $this->request->data);
      $savetranscation = $this->Transcation->save($transcation_arr);
      if ($savetranscation) {
        // Create a new job quote entry
        $JobQuote = $this->JobQuote->newEntity();
        $this->request->data['job_id'] = $this->request->data['job_id'];
        $this->request->data['user_id'] = $user_id;
        $this->request->data['talent_accepted_status'] = "Y";
        $this->request->data['amt'] = $this->request->data['amt'];
        $this->request->data['status'] = 'N';
        $this->request->data['nontalent_satus'] = 'Y';
        $this->request->data['paid_quote'] = 'Y';
        $this->request->data['skill_id'] = $this->request->data['skill'];

        $JobApplicationdata = $this->JobQuote->patchEntity($JobQuote, $this->request->data);

        if ($this->JobQuote->save($JobApplicationdata)) {
          // Update used limit count
          $this->Flash->success(__('Quote sent successfully.'));
          return $this->redirect(Router::url($this->referer(), true));
        } else {
          $this->Flash->success(__('Failed to send quote. Please try again.'));
          return $this->redirect(Router::url($this->referer(), true));
        }
      }
    }
  }

  public function Pingpaybymultiple()
  {

    $this->loadModel('Transcation');
    $this->loadModel('JobApplication');
    $user_id = $this->request->session()->read('Auth.User.id');

    if ($this->request->is(['post', 'put'])) {
      //pr($this->request->data);die;
      $jobid = $this->request->data['job_id'];

      //$this->isavaibale($jobid);

      //die;
      for ($i = 1; $i <= $this->request->data['count']; $i++) {

        $transcation = $this->Transcation->newEntity();
        $this->request->data['status'] = 'Y';
        $this->request->data['user_id'] = $user_id;
        $this->request->data['amount'] = 50;
        $this->request->data['job_id'] = $this->request->data['job_id' . $i];

        $transcation_arr = $this->Transcation->patchEntity($transcation, $this->request->data);
        $savetranscation = $this->Transcation->save($transcation_arr);
        if ($savetranscation) {


          $JobApplicationenty = $this->JobApplication->newEntity();
          $Jobapppingdata['user_id'] = $this->request->session()->read('Auth.User.id');
          $Jobapppingdata['talent_accepted_status'] = "Y";
          $Jobapppingdata['ping'] = 1;
          $Jobapppingdata['job_id'] = $this->request->data['job_id' . $i];
          $Jobapppingdata['skill_id'] = $this->request->data['skill' . $i];
          $Jobapppingdata['cover'] = "";
          $job[] = $this->request->data['job_id' . $i];

          $JobApplicationdata = $this->JobApplication->patchEntity($JobApplicationenty, $Jobapppingdata);
          $savejob = $this->JobApplication->save($JobApplicationdata);
          $response = array();
          if ($savejob) {
            $this->Flash->success(__('You have applied job successfully!!'));
            $response['success'] = 1;

            //return $this->redirect(SITE_URL.'/applyjob/'.$jobid);

          }
        }
      }
      $response['jobarray'] = $job;

      //$this->dd($this->request->data); die;
      $response['jobarray'] = $job;
      //$this->dd($response); die;
      echo json_encode($response);
      die;
    }
  }

  public function SendQoute()
  {
    $this->loadModel('JobQuote');
    $this->loadModel('Packfeature');
    $this->loadModel('Transcation');


    if ($this->request->is(['post', 'put'])) {
      //  pr($this->request->data); die;
      $user_id = $this->request->session()->read('Auth.User.id');
      //echo $user_id; die;
      $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
      $packfeature_id = $packfeature['id'];
      $number_of_quote_daily = $packfeature['number_of_quote_daily'];
      $number_quotemonth = 0;
      $jobid = $this->request->data['job_id'];

      $transcation = $this->Transcation->newEntity();
      $this->request->data['status'] = 'Y';
      $this->request->data['user_id'] = $user_id;
      $this->request->data['job_id'] = $jobid;

      $transcation_arr = $this->Transcation->patchEntity($transcation, $this->request->data);
      $savetranscation = $this->Transcation->save($transcation_arr);
      if ($savetranscation) {
        $id = $this->request->data['job_idprimary'];
        if (isset($id) && !empty($id)) {
          $JobQuote = $this->JobQuote->get($id);
        } else {
          $JobQuote = $this->JobQuote->newEntity();
        }
        // $packfeature = $this->Packfeature->get($packfeature_id);
        // $feature_info['number_of_quote_daily'] = $number_of_quote_daily-1;
        // $features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
        // $this->Packfeature->save($features_arr);
        $this->request->data['status'] = 'N';
        $this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');
        $this->request->data['skill_id'] = $this->request->data['skill'];
        $Jobquotedata = $this->JobQuote->patchEntity($JobQuote, $this->request->data);
        if ($resu = $this->JobQuote->save($Jobquotedata)) {
          $this->Flash->success(__('You Sent Quote on ' . date('d F Y')));
        }
        return $this->redirect(SITE_URL . '/applyjob/' . $jobid);
      }
    }
  }


  public function sendquote()
  {

    $this->loadModel('Transcation');
    $this->loadModel('JobApplication');
    $user_id = $this->request->session()->read('Auth.User.id');

    if ($this->request->is(['post', 'put'])) {
      $jobid = $this->request->data['job_id'];

      //$this->isavaibale($jobid);

      //die;

      $transcation = $this->Transcation->newEntity();
      $this->request->data['status'] = 'Y';
      $this->request->data['user_id'] = $user_id;

      $jobid = $this->request->data['job_id'];

      $transcation_arr = $this->Transcation->patchEntity($transcation, $this->request->data);
      $savetranscation = $this->Transcation->save($transcation_arr);
      if ($savetranscation) {


        $JobApplicationenty = $this->JobApplication->newEntity();
        $Jobapppingdata['user_id'] = $user_id;
        $Jobapppingdata['talent_accepted_status'] = "Y";
        $Jobapppingdata['ping'] = 1;
        $Jobapppingdata['job_id'] = $jobid;
        $Jobapppingdata['skill_id'] = $this->request->data['skill'];
        $Jobapppingdata['cover'] = $this->request->data['cover'];


        $JobApplicationdata = $this->JobApplication->patchEntity($JobApplicationenty, $Jobapppingdata);
        $savejob = $this->JobApplication->save($JobApplicationdata);

        if ($savejob) {
          $this->Flash->success(__('You have Pinged this to job successfully!!'));

          return $this->redirect(SITE_URL . '/applyjob/' . $jobid);
        }
      }
    }
  }


  /* public function isavailable($job_id){

      $this->loadModel('JobApplication');
      $this->loadModel('Requirement');
      $user_id = $this->request->session()->read('Auth.User.id');
       $apiledjobs = $this->JobApplication->find('all')->contain(['Requirement'])->where(['JobApplication.user_id'=>$user_id])->order(['JobApplication.id' => 'DESC'])->toarray();
       

       $aplyjob = $this->Requirement->find('all')->where(['Requirement.id'=>$job_id])->order(['Requirement.id' => 'DESC'])->first();

       foreach($apiledjobs as $value){
        pr($value);
        pr($aplyjo);

        if($value['talent_required_fromdate']==$aplyjob['talent_required_fromdate']){

        }



       }
       



    }
    
    */
  //--------------------banner package--------------------------//

  public function banner()
  {

    $this->loadModel('Banner');
    $this->loadModel('Bannerpack');
    $bannerpackid = $this->Bannerpack->find('all')->where(['status' => 'Y'])->first();
    $bannerreq = $this->Banner->find('all')->where(['user_id' => $id])->first();
    $idcheck = count($bannerreq);
    if ($idcheck > 0) {
      // using for edit
      $banner = $this->Banner->find('all')->contain(['Users'])->where(['user_id' => $id])->first();
    } else {
      $banner = $this->Banner->newEntity();
    }
    $this->set('banner', $banner);
    $this->set('bannerpackid', $bannerpackid);
    $id = $this->request->session()->read('Auth.User.id');
    if ($this->request->is(['post', 'put'])) {
      //pr($this->request->data); die;


      if ($this->request->data['banner_image']['name'] != '') {
        $k = $this->request->data['banner_image'];
        $galls = $this->move_images($k);

        // automatically create the dimensionally file
        $this->FcCreateThumbnail("trash_image", "bannerimages/", $galls[0], $galls[0], "1368", "767");

        $this->request->data['banner_image'] = $galls[0];
        unlink('trash_image/' . $galls[0]);
      } else {
        $profileimage = $this->Banner->find('all')->where(['user_id' => $id])->first();
        $previmage = $profileimage['banner_image'];
        $this->request->data['banner_image'] = $previmage;
      }

      /*if ($this->request->data['banner_image']['name'] != '')
        {
          $gallery = $this->request->data['banner_image'];
          
          $gall = $this->move_images($gallery);
          $pathThumb = 'bannerimages/';
          $filereturn = $this->upload_images($gall, array(
            1368,
            767
            ) , $pathThumb);
          
          $this->request->data['banner_image'] = $filereturn;
        }
        else
        {
          $profileimage = $this->Banner->find('all')->where(['user_id' => $id])->first();
          $previmage = $profileimage['banner_image'];
          $this->request->data['banner_image'] = $previmage;
        }*/

      $this->request->data['user_id'] = $id;
      $this->request->data['notifi'] = 2;
      $this->request->data['amount'] = $this->request->data['bannertotal'];
      $this->request->data['banner_date_from'] = date('Y-m-d H:i', strtotime($this->request->data['banner_date_from']));
      $this->request->data['banner_date_to'] = date('Y-m-d H:i', strtotime($this->request->data['banner_date_to']));
      $banners = $this->Banner->patchEntity($banner, $this->request->data);
      //pr($this->request->data); die;
      $savedbanners = $this->Banner->save($banners);
      //$this->Flash->success(__('Home Page Banner Request Successfully Saved!!'));
      $this->Flash->success(__('Request for Banner has been sent successfully. Check banner request status for further actions.'));
      return $this->redirect(['controller' => 'banner', 'action' => 'requestStatus']);
    }
  }

  public function bannerpayment($mid = '')
  {
    $this->loadModel('Invoicereceipt');
    $invoicereceipt = $this->Invoicereceipt->find('all')->where(['status' => 'Y'])->order(['id' => 'ASC'])->toarray();
    $this->set('invoicereceipt', $invoicereceipt);
    $this->loadModel('Banner');
    $mix = explode("/", base64_decode(base64_decode($mid)));


    if (!empty($mix[0])) {

      $id = $mix[0];
      $fkey = $mix[1];

      $user = $this->Banner->find('all')->select(['id', 'token'])->where(['Banner.id' => $id])->first();
      $usrfkey = $user['token'];
      if ($usrfkey == $fkey) {
        $ftyp = 1;
      } else {
        $ftyp = 0;
      }
    } else {
      $id = $mid;

      $user = $this->Banner->find('all')->select(['id', 'token'])->where(['Banner.id' => $id])->first();
      $usrfkey = $user['token'];
      $ftyp = 1;
    }


    $this->set('ftyp', $ftyp);
    $this->set('usrid', $id);

    $this->loadModel('Profile');
    $this->loadModel('Users');
    $this->loadModel('Country');
    $user_id = $this->request->session()->read('Auth.User.id');
    $bannerrec = $this->Banner->find('all')->where(['Banner.id' => $id])->first();
    //pr($bannerrec);
    $this->set('bannerrec', $bannerrec);

    $profile = $this->Profile->find('all')->contain(['Users', 'Country'])->where(['user_id' => $user_id])->first();
    $this->set('profile', $profile);
  }

  public function bannerprocessrepayment()
  {
    $banner_id = $this->request->data['banner_id'];
    // pr($this->request->data);
    // exit;    //echo $banner_id; die;

    $package_price = $this->request->data['package_price'];
    $before_tax_amt = $this->request->data['before_tax_amt'];
    $user_id = $this->request->session()->read('Auth.User.id');
    $transcation_data['payment_method'] = 'Paypal';

    $transcation_data['amount'] = $package_price;
    $transcation_data['before_tax_amt'] = $before_tax_amt;

    $transcation_data['user_id'] = $user_id;
    $transcation_data['banner_id'] = $banner_id;

    $transcation_data['GST'] = $this->request->data['GST'];
    $transcation_data['SGST'] = $this->request->data['SGST'];
    $transcation_data['CGST'] = $this->request->data['CGST'];

    $this->loadModel('Transcation');
    $transcation = $this->Transcation->newEntity();
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);
    //pr($savetranscation); die;
    $cdate = date("Y-m-d h:i:sa");
    $bannertable = TableRegistry::get("Banner");
    $query = $bannertable->query();
    $result = $query->update()
      ->set(['pay_date' => $cdate])
      ->where(['id' => $savetranscation['banner_id']])
      ->execute();

    $transcation_id = $savetranscation->id;
    $this->bannerconfirmpayment($banner_id, $transcation_id);

    // pr($pcakgeinformation); 
    $paypalURL = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //Test PayPal API URL
    $paypalID = 'ravi@doomshell.com'; //Business Email
    $cancel_return = SITE_URL . 'storesearch'; //Cancel URL
    $return = SITE_URL . 'storesearch/' . $lasid; //Return URL
    $notify_url = SITE_URL . 'cart/payment_done'; //Notify URL
    $this->set('paypalURL', $paypalURL);
    $this->set('paypalID', $paypalID);
    $this->set('cancel_return', $cancel_return);
    $this->set('return', $return);
    $this->set('notify_url', $notify_url);
    $this->set('paymentaction', 'sale');
    $this->Flash->success(__('Your payment for the banner has been successful!'));
    return $this->redirect(['controller' => 'Homes', 'action' => 'index']);
  }

  public function bannerconfirmpayment($banner_id, $transcation_id)
  {
    $this->loadModel('Banner');
    $banner = $this->Banner->get($banner_id);
    $fromdate = date('Y-m-d', strtotime($banner['banner_date_from']));
    $todate = date('Y-m-d', strtotime($banner['banner_date_to']));
    /*echo $fromdate;*/
    $date1 = date_create($fromdate);
    $date2 = date_create($todate);
    $diff = date_diff($date1, $date2);
    $bannerdays = $diff->days;

    $user_id = $this->request->session()->read('Auth.User.id');
    $ref_id = $this->request->session()->read('Auth.User.ref_by');
    $this->loadModel('Transcation');
    $transcation = $this->Transcation->get($transcation_id);

    $transcation_data['status'] = 'Y';
    $transcation_data['number_of_days'] = $bannerdays;
    $transcation_data['description'] = "BNR";
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);

    // Adding Talent admin transcation
    if ($ref_id > 0) {
      $this->loadModel('TalentAdmin');
      $this->loadModel('Talentadmintransc');
      $checkrefdata = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $ref_id])->first();
      $commision_per = $checkrefdata['commision'];
      $total_trans = $transcation['before_tax_amt'];
      $commision_amt = ($commision_per / 100) * $total_trans;
      $atranscation = $this->Talentadmintransc->newEntity();
      $atranscation_data['user_id'] = $user_id;
      $atranscation_data['talent_admin_id'] = $ref_id;
      $atranscation_data['amount'] = $commision_amt;
      $atranscation_data['transcation_amount'] = $transcation['amount'];

      //$description = "Banner";
      $description = "BNR";
      $atranscation_data['description'] = $description;
      $atranscation_data['transaction_id'] = $savetranscation['id'];
      $atranscation_arr = $this->Talentadmintransc->patchEntity($atranscation, $atranscation_data);
      $savetranscation = $this->Talentadmintransc->save($atranscation_arr);
    }

    if ($savetranscation) {
      $this->invoiceMail($savetranscation['id']);
    }

    $banner_data['token'] = '';
    $banner_data['status'] = 'Y';
    $banner_arr = $this->Banner->patchEntity($banner, $banner_data);
    $savebanner = $this->Banner->save($banner_arr);
  }



  //=========================================advertise my job====================================
  //  ============================================================================================
  //  ===========================================================================================

  public function advertisedRequirment($jobadid = null)
  {
    $this->loadModel('Requirement');
    $this->loadModel('Users');
    $this->loadModel('Jobadvertpack');
    $session = $this->request->session();
    $session->delete('advrtjobsearch');
    $currentdate = date('Y-m-d H:i:s');
    $user_id = $this->request->session()->read('Auth.User.id');
    if (!empty($jobadid)) {
      $Job = $this->Jobadvertpack->find('all')->contain(['Users', 'Requirement'])->where(['Jobadvertpack.user_id' => $user_id, 'Jobadvertpack.id' => $jobadid, 'Jobadvertpack.ad_date_from >' => $currentdate, 'Requirement.status' => 'Y'])->toarray();
    } else {
      $Job = $this->Jobadvertpack->find('all')->contain(['Users', 'Requirement'])->where(['Jobadvertpack.user_id' => $user_id, 'Jobadvertpack.ad_date_from <' => $currentdate, 'Requirement.status' => 'Y'])->toarray();
    }
    //pr($Job);

    $this->set('Job', $Job);
  }

  public function advertisedProfile()
  {

    $this->loadModel('Profileadvertpack');

    $user_id = $this->request->session()->read('Auth.User.id');

    $profile = $this->Profileadvertpack->find('all')->where(['Profileadvertpack.user_id' => $user_id])->toarray();
    //pr($profile); die;
    $this->set('profile', $profile);
  }

  public function advrtjobsearching()
  {
    $this->loadModel('Users');
    $this->loadModel('Requirement');
    //pr($this->request->data); die;
    $currentdate = date('Y-m-d H:m:s');
    $status = $this->request->data['status'];
    $name = $this->request->data['name'];
    $user_id = $this->request->session()->read('Auth.User.id');
    $cond = [];


    if (!empty($name)) {
      $cond['Requirement.title LIKE'] = "%" . $name . "%";
    }


    $this->request->session()->write('advrtjobsearch', $cond);

    $Job = $this->Requirement->find('all')->contain(['Users', 'Jobadvertpack'])->where([$cond, 'DATE(Requirement.last_date_app) >=' => $currentdate, 'Requirement.status' => 'Y', 'Requirement.user_id' => $user_id])->order(['Requirement.id' => 'DESC'])->toarray();
    $this->set('Job', $Job);
  }

  public function advrtiseMyRequirment()
  {

    $this->loadModel('Requirement');
    $this->loadModel('Users');
    $this->loadModel('Jobadvertpack');
    $currentdate = date('Y-m-d H:m:s');
    $session = $this->request->session();
    $session->delete('advrtjobsearch');

    $user_id = $this->request->session()->read('Auth.User.id');

    $Job = $this->Requirement->find('all')->contain(['Users', 'Jobadvertpack'])->where(['DATE(Requirement.last_date_app) >=' => $currentdate, 'Requirement.status' => 'Y', 'Requirement.user_id' => $user_id])->order(['Requirement.id' => 'DESC'])->toarray();
    //pr($Job);
    $this->set('Job', $Job);
  }


  public function advertisejob($jid = null, $jobadid = null)
  {

    $this->loadModel('Requirement');
    $this->loadModel('Jobadvertpack');
    $this->loadModel('Skillset');
    $this->loadModel('Skill');
    $this->loadModel('Users');
    $this->loadModel('Packfeature');
    $id = $this->request->session()->read('Auth.User.id');

    $bannerpackid = $this->Jobadvertpack->find('all')->where(['status' => 'Y'])->order(['id' => ASC])->first();
    // pr($bannerpackid );exit;

    $this->set('bannerpackid', $bannerpackid);

    $jobadid = $this->Jobadvertpack->find('all')->where(['user_id' => $id, 'requir_id' => $jobadid])->order(['id' => DESC])->first();
    $this->set('jobadid', $jobadid);

    $myjobs = $this->Requirement->find('all')->where(['Requirement.status' => 'Y', 'Requirement.id' => $jid])->first();
    $this->set('myjobs', $myjobs);

    $Skill = $this->Skill->find('all')->select(['id', 'name'])->where(['Skill.status' => 'Y'])->order(['Skill.name' => 'ASC'])->toarray();
    $this->set('Skill', $Skill);

    $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();
    $this->set('total_elegible_skills', $packfeature['number_categories']);

    $serviceDelete = $this->Jobadvertpack->deleteAll(['requir_id' => $jid, 'status' => 'N']);
    $jobadvertpack = $this->Jobadvertpack->newEntity();

    //$this->set('banner', $banner);
    if ($this->request->is(['post', 'put'])) {
      //pr($this->request->data); die;

      if ($this->request->data['job_image_change']['name'] != '') {
        $k = $this->request->data['job_image_change'];
        $galls = $this->move_images($k);

        // automatically create the dimensionally file
        $this->FcCreateThumbnail("trash_image", "job/", $galls[0], $galls[0], "500", "400");

        $this->request->data['job_image_change'] = $galls[0];
        unlink('trash_image/' . $galls[0]);
      } else {
        $this->request->data['job_image_change'] = $this->request->data['jobimg'];
      }
      $this->request->data['current_location'] = implode("/", $this->request->data['current_location']);

      $this->request->data['current_lat'] = implode(",", $this->request->data['current_lat']);

      $this->request->data['current_long'] = implode(",", $this->request->data['current_long']);

      $this->request->data['gender'] = implode(",", $this->request->data['gender']);

      $this->request->data['ad_for'] = implode(",", $this->request->data['adfor']);
      $this->request->data['skill'] = implode(",", $this->request->data['skill']);

      $this->request->data['user_id'] = $id;
      $this->request->data['status'] = 'N';
      $this->request->data['ad_date_from'] = date('Y-m-d H:i', strtotime($this->request->data['ad_date_from']));
      $this->request->data['ad_date_to'] = date('Y-m-d H:i', strtotime($this->request->data['ad_date_to']));
      $banners = $this->Jobadvertpack->patchEntity($jobadvertpack, $this->request->data);
      //pr($this->request->data); die;
      $savedbanners = $this->Jobadvertpack->save($banners);
      if ($savedbanners) {
        return $this->redirect(['action' => 'advertisejobpayment/', $savedbanners['id']]);
      } else {
        $this->Flash->error(__('Ad not published'));
        return $this->redirect(['action' => 'advertisejob']);
      }
    }
  }



  public function advertisejobpayment($adid = null)
  {

    $this->loadModel('Jobadvertpack');
    $this->loadModel('Invoicereceipt');

    $invoicereceipt = $this->Invoicereceipt->find('all')->where(['status' => 'Y'])->order(['id' => ASC])->toarray();
    $this->set('invoicereceipt', $invoicereceipt);

    $bannerpackid = $this->Jobadvertpack->find('all')->where(['id' => $adid])->first();
    //pr($bannerpackid); die;
    $this->set('bannerpackid', $bannerpackid);

    $fromdate = date('Y-m-d', strtotime($bannerpackid['ad_date_from']));
    $todate = date('Y-m-d', strtotime($bannerpackid['ad_date_to']));
    /*echo $fromdate;*/
    $date1 = date_create($fromdate);
    $date2 = date_create($todate);
    $diff = date_diff($date1, $date2);
    $bannerdays = $diff->days;

    $this->set('number_of_days', $bannerdays);
  }

  // Process advertise Job payment
  public  function proadjobpay()
  {
    //pr($this->request->data); die;
    $user_id = $this->request->session()->read('Auth.User.id');
    $number_of_days = $this->request->data['number_of_days'];
    $job_id = $this->request->data['job_id'];
    $package_id = $this->request->data['package_id'];
    $transcation_data['payment_method'] = 'Paypal';
    $transcation_data['amount'] = $this->request->data['package_price'];
    $transcation_data['before_tax_amt'] = $this->request->data['before_tax_amt'];
    //$transcation_data['amount'] = $pcakgeinformation['price'];
    $transcation_data['user_id'] = $user_id;
    $transcation_data['number_of_days'] = $number_of_days;
    $transcation_data['advrt_job_id'] = $this->request->data['advrt_job_id'];

    $transcation_data['GST'] = $this->request->data['GST'];
    $transcation_data['SGST'] = $this->request->data['SGST'];
    $transcation_data['CGST'] = $this->request->data['CGST'];

    $this->loadModel('Transcation');
    $transcation = $this->Transcation->newEntity();
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);
    $transcation_id = $savetranscation->id;
    $this->confirmadjobpay($package_id, $transcation_id);
  }


  // Confirm advertise job payment
  public function confirmadjobpay($package_id, $transcation_id)
  {

    $user_id = $this->request->session()->read('Auth.User.id');
    $ref_id = $this->request->session()->read('Auth.User.ref_by');
    $this->loadModel('Transcation');
    $transcation = $this->Transcation->get($transcation_id);

    $transcation_data['status'] = 'Y';
    $transcation_data['description'] = "JA";
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);

    // Adding Talent admin transcation
    if ($ref_id > 0) {
      $this->loadModel('TalentAdmin');
      $this->loadModel('Talentadmintransc');
      $checkrefdata = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $ref_id])->first();
      $commision_per = $checkrefdata['commision'];
      $total_trans = $transcation['before_tax_amt'];
      $commision_amt = ($commision_per / 100) * $total_trans;
      $atranscation = $this->Talentadmintransc->newEntity();
      $atranscation_data['user_id'] = $user_id;
      $atranscation_data['talent_admin_id'] = $ref_id;
      $atranscation_data['amount'] = $commision_amt;
      $atranscation_data['transcation_amount'] = $transcation['amount'];

      // Package Name
      //$description = "Job Advertisement";
      $description = "JA";
      $atranscation_data['description'] = $description;
      $atranscation_data['transaction_id'] = $savetranscation['id'];
      $atranscation_arr = $this->Talentadmintransc->patchEntity($atranscation, $atranscation_data);
      $savetranscations = $this->Talentadmintransc->save($atranscation_arr);
    }
    if ($savetranscation) {
      $this->invoiceMail($savetranscation['id']);
    }
    // Setting advertise job. 
    $this->loadModel('Jobadvertpack');

    $requirement = $this->Jobadvertpack->get($package_id);
    $myrequirement['status'] = 'Y';

    $requirementsave = $this->Jobadvertpack->patchEntity($requirement, $myrequirement);
    $this->Jobadvertpack->save($requirementsave);

    $this->Flash->success(__('Your advertisement has been published.'));
    return $this->redirect(['action' => 'advrtiseMyRequirment']);
  }





  //=========================================advertise my profile====================================

  public function advertiseprofile()
  {
    $this->loadModel('Banner');
    $this->loadModel('Profileadvertpack');
    $this->loadModel('Profile');
    $this->loadModel('Skillset');
    $this->loadModel('Skill');
    $this->loadModel('Users');
    $this->loadModel('Packfeature');
    $id = $this->request->session()->read('Auth.User.id');

    $profileimg = $this->Profile->find('all')->where(['user_id' => $id])->first();
    $this->set('profileimg', $profileimg);

    $bannerpackid = $this->Profileadvertpack->find('all')->where(['status' => 'Y'])->first();
    // pr($bannerpackid);exit;
    $this->set('bannerpackid', $bannerpackid);

    $jobadid = $this->Profileadvertpack->find('all')->where(['user_id' => $id])->first();
    $this->set('jobadid', $jobadid);

    $Skill = $this->Skill->find('all')->select(['id', 'name'])->where(['Skill.status' => 'Y'])->order(['Skill.name' => 'ASC'])->toarray();
    $this->set('Skill', $Skill);

    $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $id])->order(['Packfeature.id' => 'ASC'])->first();
    $this->set('total_elegible_skills', $packfeature['number_categories']);


    $this->Profileadvertpack->deleteAll(['user_id' => $id, 'status' => 'N']);
    $jobadvertpack = $this->Profileadvertpack->newEntity();

    //$this->set('banner', $banner);
    if ($this->request->is(['post', 'put'])) {

      if ($this->request->data['job_image_change']['name'] != '') {
        $k = $this->request->data['job_image_change'];
        $galls = $this->move_images($k);

        // automatically create the dimensionally file
        $this->FcCreateThumbnail("trash_image", "profileimages/", $galls[0], $galls[0], "500", "400");

        $this->request->data['job_image_change'] = $galls[0];
        unlink('trash_image/' . $galls[0]);
      } else {
        $this->request->data['job_image_change'] = $this->request->data['jobimg'];
      }
      $this->request->data['current_location'] = implode("/", $this->request->data['current_location']);

      $this->request->data['current_lat'] = implode(",", $this->request->data['current_lat']);

      $this->request->data['current_long'] = implode(",", $this->request->data['current_long']);

      $this->request->data['gender'] = implode(",", $this->request->data['gender']);

      $this->request->data['ad_for'] = implode(",", $this->request->data['adfor']);
      $this->request->data['skill'] = implode(",", $this->request->data['skill']);

      $this->request->data['user_id'] = $id;
      $this->request->data['status'] = 'N';
      $this->request->data['ad_date_from'] = date('Y-m-d H:i', strtotime($this->request->data['ad_date_from']));
      $this->request->data['ad_date_to'] = date('Y-m-d H:i', strtotime($this->request->data['ad_date_to']));
      //pr($this->request->data); die;
      $banners = $this->Profileadvertpack->patchEntity($jobadvertpack, $this->request->data);
      $savedbanners = $this->Profileadvertpack->save($banners);
      if ($savedbanners) {
        return $this->redirect(['action' => 'advertiseprofilepayment/', $savedbanners['id']]);
      } else {
        $this->Flash->error(__('Ad not published'));
        return $this->redirect(['action' => 'advertiseprofile']);
      }
    }
  }



  public function advertiseprofilepayment($adid = null)
  {

    $this->loadModel('Profileadvertpack');
    $this->loadModel('Invoicereceipt');
    $invoicereceipt = $this->Invoicereceipt->find('all')->where(['status' => 'Y'])->order(['id' => ASC])->toarray();
    $this->set('invoicereceipt', $invoicereceipt);

    $bannerpackid = $this->Profileadvertpack->find('all')->where(['id' => $adid])->first();
    //pr($bannerpackid); die;
    $this->set('bannerpackid', $bannerpackid);

    $fromdate = date('Y-m-d', strtotime($bannerpackid['ad_date_from']));
    $todate = date('Y-m-d', strtotime($bannerpackid['ad_date_to']));
    /*echo $fromdate;*/
    $date1 = date_create($fromdate);
    $date2 = date_create($todate);
    $diff = date_diff($date1, $date2);
    $bannerdays = $diff->days;

    $this->set('number_of_days', $bannerdays);
  }

  // Process advertise profile payment
  public  function proadprofilepay()
  {
    //pr($this->request->data); die;
    //$this->invoiceMail($savetranscation['id']);
    $user_id = $this->request->session()->read('Auth.User.id');
    $number_of_days = $this->request->data['number_of_days'];
    $job_id = $this->request->data['job_id'];
    $package_id = $this->request->data['package_id'];
    $transcation_data['payment_method'] = 'Paypal';
    $transcation_data['amount'] = $this->request->data['package_price'];
    $transcation_data['before_tax_amt'] = $this->request->data['before_tax_amt'];
    //$transcation_data['amount'] = $pcakgeinformation['price'];
    $transcation_data['GST'] = $this->request->data['GST'];
    $transcation_data['SGST'] = $this->request->data['SGST'];
    $transcation_data['CGST'] = $this->request->data['CGST'];

    $transcation_data['user_id'] = $user_id;
    $transcation_data['number_of_days'] = $number_of_days;
    $transcation_data['advrt_profile_id'] = $package_id;
    $this->loadModel('Transcation');
    $transcation = $this->Transcation->newEntity();
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);
    $transcation_id = $savetranscation->id;
    $this->confirmadprofilepay($package_id, $transcation_id);
  }


  // Confirm advertise job payment
  public function confirmadprofilepay($package_id, $transcation_id)
  {

    $user_id = $this->request->session()->read('Auth.User.id');
    $ref_id = $this->request->session()->read('Auth.User.ref_by');
    $this->loadModel('Transcation');
    $transcation = $this->Transcation->get($transcation_id);

    $transcation_data['status'] = 'Y';
    $transcation_data['description'] = "PA";
    $transcation_arr = $this->Transcation->patchEntity($transcation, $transcation_data);
    $savetranscation = $this->Transcation->save($transcation_arr);

    // Adding Talent admin transcation
    if ($ref_id > 0) {
      $this->loadModel('TalentAdmin');
      $this->loadModel('Talentadmintransc');
      $checkrefdata = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $ref_id])->first();
      $commision_per = $checkrefdata['commision'];
      $total_trans = $transcation['before_tax_amt'];
      $commision_amt = ($commision_per / 100) * $total_trans;
      $atranscation = $this->Talentadmintransc->newEntity();
      $atranscation_data['user_id'] = $user_id;
      $atranscation_data['talent_admin_id'] = $ref_id;
      $atranscation_data['amount'] = $commision_amt;
      $atranscation_data['transcation_amount'] = $transcation['amount'];

      // Package Name
      $description = "PA";
      //$description = "Profile Advertisement";
      $atranscation_data['description'] = $description;
      $atranscation_data['transaction_id'] = $savetranscation['id'];
      $atranscation_arr = $this->Talentadmintransc->patchEntity($atranscation, $atranscation_data);
      $savetranscations = $this->Talentadmintransc->save($atranscation_arr);
    }

    // Setting advertise job. 
    $this->loadModel('Profileadvertpack');

    $requirement = $this->Profileadvertpack->get($package_id);
    $myrequirement['status'] = 'Y';

    $requirementsave = $this->Profileadvertpack->patchEntity($requirement, $myrequirement);
    $this->Profileadvertpack->save($requirementsave);

    if ($savetranscation) {
      $this->invoiceMail($savetranscation['id']);
    }

    $this->Flash->success(__('You have successfully created your advertisement. It will start at the chosen date and time.'));
    return $this->redirect(['action' => 'advertiseprofile']);
  }


  public function invoiceMail($transcation_id = null)
  {
    $this->autoRender = false;
    $this->loadModel('Transcation');
    $transcation = $this->Transcation->find('all')->contain(['Users' => ['Skillset' => ['Skill'], 'Profile' => ['Country', 'State', 'City']]])->where(['Transcation.id' => $transcation_id])->order(['Transcation.id' => 'DESC'])->first();
    // pr($transcation);exit;
    if ($transcation['description'] == 'PAR') {
      $packtype = "Post a Requirement";
      $unit = "01 Units";
    } elseif ($transcation['description'] == 'PP') {
      $packtype = "Profile Package";
      $unit = "01 Units";
    } elseif ($transcation['description'] == 'RP') {
      $packtype = "Recruiter Package";
      $unit = "01 Units";
    } elseif ($transcation['description'] == 'PG') {
      $packtype = "Ping";
      $unit = "01 Units";
    } elseif ($transcation['description'] == 'PQ') {
      $packtype = "Paid Quote Sent";
      $unit = "01 Units";
    } elseif ($transcation['description'] == 'AQ') {
      $packtype = "Ask for Quote";
      $unit = "01 Units";
    } elseif ($transcation['description'] == 'PA') {
      $packtype = "Profile Advertisement";
      $unit = $transcation['number_of_days'] . "/days";
    } elseif ($transcation['description'] == 'JA') {
      $packtype = "Job Advertisement";
      $unit = $transcation['number_of_days'] . "/days";
    } elseif ($transcation['description'] == 'BNR') {
      $packtype = "Banner";
      $unit = $transcation['number_of_days'] . "/days";
    } elseif ($transcation['description'] == 'FJ') {
      $packtype = "Feature Job";
      $unit = $transcation['number_of_days'] . "/days";
    } elseif ($transcation['description'] == 'FP') {
      $packtype = "Feature Profile";
      $unit = $transcation['number_of_days'] . "/days";
    } else {
      $packtype = "N/A";
    }
    // pr($packtype);exit;

    //$transcation['id']
    $crdate = date("d-M-Y", strtotime($transcation['created']));
    $invnum = "INV-" . $transcation['description'] . "-" . $crdate . "-" . $transcation['id'];

    if ($transcation['GST'] > 0) {
      $gst = $transcation['GST'];
    } else {
      $gst = 0;
    }
    if ($transcation['SGST'] > 0) {
      $sgst = $transcation['SGST'];
    } else {
      $sgst = 0;
    }
    if ($transcation['CGST'] > 0) {
      $cgst = $transcation['CGST'];
    } else {
      $cgst = 0;
    }
    if ($transcation['status'] == 'Y') {
      $status = "Paid";
    } else {
      $status = "Payment Declined and Not Received";
    }
    $this->loadmodel('Templates');
    $profile = $this->Templates->find('all')->where(['Templates.id' => INVOICEMAIL])->first();
    $subject = $profile['subject'];
    $from = $profile['from'];
    $fromname = $profile['fromname'];

    $to  = $transcation['user']['email'];
    //$to  = "aditya@doomshell.com";
    //pr($transcation); die;
    $formats = $profile['description'];
    $site_url = SITE_URL;
    //$message1 = str_replace(array('{Name}','{Useractivation}','{site_url}'), array($name,$referal_code,$site_url), $formats);
    //$message = stripslashes($message1);
    $message = '
      <!DOCTYPE HTML>
      <html>
      <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <title>Mail</title>
      </head>
      
      <body style=" text-align:center; font-family:Arial, Helvetica, sans-serif">
      <table cellspacing="0" style="border:solid #b2b2b2 1px; text-align:center" width="auto" align="center">
      <tr style=" background-color:#252525;">
      <td style="text-align:center; padding:50px 0px 50px 0px;">
      <a href="' . $site_url . '">
      <img src="' . $site_url . '/images/book-an-artiste-logo.png" alt="book-an-artiste-logo"/>
      </a>
      </td>
      </tr>

      <tr >
      <td style="text-align:center; padding:15px 10px 15px 0px; border-bottom:solid #b2b2b2 1px">
      <h2 style=" padding:0px; margin:0px; font-weight:600">INVOICE</h2>
      </td>
      </tr>


      <tr>
      <td style="border-bottom:solid #b2b2b2 1px">
      <table>
      <tr style="width:100%;">
      <td style=" text-align:left; padding:20px 0px 20px 20px; width:300px;">
      <h4 style=" margin:0px; padding-bottom:8px;">To ' . $transcation['user']['user_name'] . '</h4>
      <a href="' . $site_url . '">www.bookanartiste.com</a>
      <h4 style=" margin:0px; padding:8px 0px;">Address:</h4>
      <p style="margin:0px; color: #666;">
      ' . $transcation['user']['profile']['location'] . '
      </p>
      </td>

      <td style=" text-align:left; padding:20px 0px 20px 0px; margin:0px; width:300px; vertical-align:top;">
      <p style=" font-weight:600; margin:0px;">Invoice number: ' . $invnum . '</p>
      <p style="  font-weight:600;">Payment Status: ' . $status . '</p>
      <p style="  font-weight:600;">Transaction ID: ' . $transcation['id'] . '</p>
      <p style=" font-weight:600;">Date: ' . $crdate . '</p>
      </td>
      </tr>
      </table>
      </td>
      </tr>

      <tr style="">
      <td style="margin:0px; padding:0px; ">
      <table style=" border-spacing:0px; width:100%;">
      <tr style="border-bottom:1px solid #b2b2b2 ;">

      <td style="border-right:1px solid #b2b2b2; width:8%; padding:4px 4px 0px 10px; border-bottom:1px solid #b2b2b2; text-align:center;">No.</td>
      <td style="border-right:1px solid #b2b2b2; width:37%; padding:8px 0px 8px 8px ; border-bottom:1px solid #b2b2b2; text-align:left;">Product Type</td>
      <td style="border-right:1px solid #b2b2b2; width:20%; padding:8px 0px; border-bottom:1px solid #b2b2b2;">Per Unit Amount</td>
      <td style="border-right:1px solid #b2b2b2; width:15%; padding:8px 0px; border-bottom:1px solid #b2b2b2;">Quantity </td>
      <td style="border-right:0px solid #b2b2b2; width:20%; padding:8px 0px; border-bottom:1px solid #b2b2b2;" >Total Amount</td>

      </tr>
      <tr style="border-bottom:1px solid #b2b2b2; height:60px">

      <td style="border-right:1px solid #b2b2b2; width:8%; padding:4px 4px 0px 10px; border-bottom:1px solid #b2b2b2; text-align:center;">1</td>
      <td style="border-right:1px solid #b2b2b2; width:37%; padding:8px 0px 8px 8px ; border-bottom:1px solid #b2b2b2; text-align:left;">' . $packtype . '</td>
      <td style="border-right:1px solid #b2b2b2; width:20%; padding:8px 0px; border-bottom:1px solid #b2b2b2;">$' . number_format($transcation['before_tax_amt'] / $transcation['number_of_days']) . '</td>
      <td style="border-right:1px solid #b2b2b2; width:15%; padding:8px 0px; border-bottom:1px solid #b2b2b2;">' . $unit . ' </td>
      <td style="border-right:0px solid #b2b2b2; width:20%; padding:8px 0px; border-bottom:1px solid #b2b2b2;" >$' . $transcation['before_tax_amt'] . '</td>

      </tr>

      </table>
      </td>
      </tr>
      <tr>
      <td>
      <table style="width:100%; text-align:right">
      <tr style="text-align:right; width:100%;">
      <td> </td>
      </tr>
      
      <tr style="text-align:right; width:100%;">
      <td style=" font-weight:600; padding:15px 10px 19px 0px ;">SGST: ' . $sgst . '%</td>
      </tr>
      <tr style="text-align:right; width:100%;">
      <td style=" font-weight:600; padding:0px 10px 19px 0px ;">CGST: ' . $cgst . '%</td>
      </tr>
      <tr style="text-align:right; width:100%; ">
      <td style=" font-weight:600; padding:0px 10px 0px 0px ; ">Total Bill Amount: $' . $transcation['amount'] . '</td>
      </tr>
      <tr style="text-align:right; width:100%; ">
      <td style=" font-weight:600; padding:20px 0px; "></td>
      </tr>

      </table>
      </td>
      </tr>

      </table>
      </body>
      </html>
      ';

    // pr($message); die;
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    //$headers .= 'To: <'.$to.'>' . "\r\n";
    $headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
    // $emailcheck = mail($to, $subject, $message, $headers);
    // $mail = $this->Email->send($to, $subject, $message);
    // pr($message); die;


  }

  public function skills()
  {
    $this->loadModel('Users');
    $this->loadModel('Skillset');
    $this->loadModel('Skill');

    $Skill = $this->Skill->find('all')->select(['id', 'name'])->where(['Skill.status' => 'Y'])->order(['Skill.name' => 'ASC'])->toarray();
    $this->set('Skill', $Skill);
    $this->set('skillset', $contentadminskillset);


    $this->loadModel('Packfeature');
    $user_id = $this->request->session()->read('Auth.User.id');
    $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
    $this->set('total_elegible_skills', $packfeature['number_categories']);
  }

  public function checkadtodate()
  {
    $this->loadModel('Profileadvertpack');
    $user_id = $this->request->session()->read('Auth.User.id');
    if (!empty($this->request->data['advertisejobdate'])) {
      $packdate = date('Y-m-d H:m:s', strtotime($this->request->data['advertisejobdate']));
      //pr($packdate); die;
      $packfeature = $this->Profileadvertpack->find('all')->where(['Profileadvertpack.user_id' => $user_id, 'Profileadvertpack.ad_date_from <=' => $packdate, 'Profileadvertpack.ad_date_to >=' => $packdate])->count();

      echo $packfeature;
      die;
    }
  }

  //  public function advertiseskill(){
  //      pr($this->request->data); die;
  //  }


}
