<?php

namespace App\Controller;

use App\Controller;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;
use Cake\View\Helper\PaginatorHelper;
use Cake\Routing\Router;

class SearchController extends AppController
{
   public function initialize()
   {
      parent::initialize();
      $this->loadModel('Users');
      $this->Auth->allow(['_setPassword
			', 'signup', 'findUsername', 'login', 'logout', 'verify', 'getphonecode', 'forgotpassword', 'forgetCpass', 'sociallogin', 'jobrefine', 'userLocation', 'search', 'advanceJobsearch',  'advanceProfilesearch', 'withoutloginsearch', 'eventtypes', 'skills', 'profileskill']);
      // 'profilesearch', remove in auth allow 
   }

   public function index_ajax()
   {
      $this->Carroceria->recursive = 0;
      $this->layout = 'ajax';
      $conditions = $this->BuildConditions->buildConditions($this->modelClass);
      $this->set('carrocerias', $this->paginate(null, $conditions));
   }

   public function userLocation()
   {
      $data['latitude'] = $this->request->data['latitude'];
      $data['longitude'] = $this->request->data['longitude'];
      $session = $this->request->session();
      $session->delete('user_location');
      $session->write("user_location", $data);
   }

   // Optimize By Rupam 25/05/2023
   public function withoutloginsearch($is_reset = null)
   {

      //Here we are writing advance parameter in to session 
      $session = $this->request->session();
      if ($is_reset == "reset") {
         $this->request->session()->delete('request_data');
      }

      $data = $session->read("request_data");
      if (empty($this->request->query)) {
         $this->request->query = $data;
      }
      $claculationunit = $this->request->query['unit'];
      $this->set('claculationunit', $this->request->query['unit']);
      if ($this->request->query['refine'] != 1) {
         $session = $this->request->session();
         $session->write('advancejobsearch', $this->request->query);
      }
      $savejobarray = array();
      $this->loadModel('Profile');
      $this->loadModel('jrement');
      $this->loadModel('Savejobs');
      $this->loadModel('Likejobs');
      $this->loadModel('Blockjobs');
      $this->loadModel('JobApplication');
      $this->loadModel('RequirmentVacancy');
      $this->loadModel('JobQuote');
      $this->loadModel('Settings');
      $this->loadModel('Packfeature');
      $this->loadModel('Requirement');

      /*  Not For Searching */
      $numberofaskquoteperjob = 0;
      $this->set('numberofaskquoteperjob', $numberofaskquoteperjob);
      $this->set('month', 0);
      $this->set('daily', 0);
      $this->set('quote', 0);
      $currentdate = date('Y-m-d H:m:s');

      // advance search parameters
      if ($this->request->query['optiontype'] == 1) {

         if ($_SESSION['user_location']['latitude'] != 0) {
            $this->request->query['latitude'] = $_SESSION['user_location']['latitude'];
            $this->request->query['longitude'] = $_SESSION['user_location']['longitude'];
            $this->request->query['locationlat'] = "Jaipur, Rajasthan, India";
            $this->request->query['within'] = 100;
         } else {
            $this->request->query['latitude'] = 35.8617;
            $this->request->query['longitude'] = 104.1954;
            $this->request->query['locationlat'] = "no location";
            $this->request->query['within'] = 0;
         }

         $this->request->query['unit'] = "km";
         $this->request->query['time'] = "a";
         $this->request->query['role_id'] = 0;
         $this->request->query['from'] = 1;
      }

      if ($this->request->query['latitude']) {
         $loc_lat = $this->request->query['latitude'];
      } else {
         $loc_lat = "";
      }

      if ($this->request->query['longitude']) {
         $loc_long = $this->request->query['longitude'];
      } else {
         $loc_long = "";
      }
      if ($this->request->query['unit'] = "km") {
         $kmmile = "3956";
      } else {
         $kmmile = "6371";
      }

      $salary = explode("-", $this->request->query['salaryrange']);
      $min = $salary['0'];
      if ($min) {
         $min = $min;
         $this->set('selmini', $min);
      } else {
         $min = 0;
      }
      $max = $salary['1'];
      if ($max) {
         $max = $max;
         $this->set('selmaxi', $max);
      } else {
         $max = 50000;
      }

      // pr($this->request->query);exit;
      $date = date('Y-m-d H:i:s');
      // $query = "SELECT  requirement.continuejob,Posting_type,requirement_vacancy.telent_type ,requirement_vacancy.payment_currency,requirement_vacancy.payment_amount, requirement.location,requirement.talent_requirement_description,requirement_vacancy.sex as sex,users.user_name , users.role_id,eventtypes.name as eventname, requirement.id, requirement.user_id,requirement.last_date_app,requirement.event_type,currencys.name as currencysname,payment_fequency.name as payment_feqname,skill_type.name as skillname,requirement.image as image,requirement.title as title,currencys.id as currencyid, 1.609344 * '" . $kmmile . "' * ACOS( COS( RADIANS('" . $loc_lat . "') ) * COS( RADIANS(requirement.latitude) ) * COS( RADIANS(requirement.longitude) - RADIANS('" . $loc_long . "') ) + sin( RADIANS('" . $loc_lat . "') ) * sin( RADIANS(requirement.latitude) ) ) AS cdistance,payment_fequency.id as pfqid,skill_type.id as skillid, (SELECT subscriptions.package_id FROM subscriptions
      // WHERE subscriptions.package_type='PR' and subscriptions.user_id=requirement.user_id ORDER BY id desc
      // LIMIT 1) as p_package, (Select subscriptions.package_id  FROM subscriptions
      // WHERE subscriptions.package_type='RC' and subscriptions.user_id=requirement.user_id ORDER BY id desc
      // LIMIT 1) as r_package, (SELECT visibility_matrix.ordernumber FROM `visibility_matrix` where visibility_matrix.profilepack_id=p_package and visibility_matrix.recruiter_id=r_package) as order_num   FROM  `requirement` LEFT JOIN requirement_vacancy ON requirement.id = requirement_vacancy.requirement_id  LEFT JOIN skill_type ON requirement_vacancy.telent_type = skill_type.id LEFT JOIN currencys ON requirement_vacancy.payment_currency = currencys.id LEFT JOIN payment_fequency ON requirement_vacancy.payment_freq = payment_fequency.id LEFT JOIN users ON requirement.user_id = users.id LEFT JOIN personal_profile ON personal_profile.user_id = users.id  LEFT JOIN eventtypes ON eventtypes.id = requirement.event_type where ( requirement_vacancy.payment_amount>='$min' and requirement_vacancy.payment_amount <= '$max') ";
      // $query = "SELECT 
      //       requirement.continuejob,
      //       Posting_type,
      //       requirement_vacancy.telent_type,
      //       requirement_vacancy.payment_currency,
      //       requirement_vacancy.payment_amount,
      //       requirement.location,
      //       requirement.talent_requirement_description,
      //       requirement_vacancy.sex as sex,
      //       users.user_name,
      //       users.role_id,
      //       eventtypes.name as eventname,
      //       requirement.id,
      //       requirement.user_id,
      //       requirement.last_date_app,
      //       requirement.event_type,
      //       currencys.name as currencysname,
      //       payment_fequency.name as payment_feqname,
      //       skill_type.name as skillname,
      //       requirement.image as image,
      //       requirement.title as title,
      //       currencys.id as currencyid,
      //       1.609344 * '" . $kmmile . "' * ACOS( COS( RADIANS('" . $loc_lat . "') ) * COS( RADIANS(requirement.latitude) ) * COS( RADIANS(requirement.longitude) - RADIANS('" . $loc_long . "') ) + sin( RADIANS('" . $loc_lat . "') ) * sin( RADIANS(requirement.latitude) ) ) AS cdistance,
      //       payment_fequency.id as pfqid,
      //       skill_type.id as skillid,
      //       (SELECT subscriptions.package_id FROM subscriptions
      //          WHERE subscriptions.package_type='PR' and subscriptions.user_id=requirement.user_id ORDER BY id desc
      //          LIMIT 1) as p_package,
      //       (Select subscriptions.package_id  FROM subscriptions
      //          WHERE subscriptions.package_type='RC' and subscriptions.user_id=requirement.user_id ORDER BY id desc
      //          LIMIT 1) as r_package,
      //       (SELECT visibility_matrix.ordernumber FROM `visibility_matrix` where visibility_matrix.profilepack_id=p_package and visibility_matrix.recruiter_id=r_package) as order_num
      // FROM
      //       `requirement`
      // LEFT JOIN requirement_vacancy ON requirement.id = requirement_vacancy.requirement_id
      // LEFT JOIN skill_type ON requirement_vacancy.telent_type = skill_type.id
      // LEFT JOIN currencys ON requirement_vacancy.payment_currency = currencys.id
      // LEFT JOIN payment_fequency ON requirement_vacancy.payment_freq = payment_fequency.id
      // LEFT JOIN users ON requirement.user_id = users.id
      // LEFT JOIN personal_profile ON personal_profile.user_id = users.id
      // LEFT JOIN eventtypes ON eventtypes.id = requirement.event_type
      // WHERE
      //       (requirement_vacancy.payment_amount >= '$min' and requirement_vacancy.payment_amount <= '$max')
      // ";

      $query = "SELECT requirement.continuejob, requirement_vacancy.telent_type, requirement.is_paid_post,
          requirement_vacancy.payment_currency, requirement_vacancy.payment_amount, 
          requirement.location, requirement.talent_requirement_description, 
          requirement_vacancy.sex as sex, users.user_name, users.role_id, 
          eventtypes.name as eventname, requirement.id, requirement.user_id, 
          requirement.last_date_app, requirement.event_type, currencys.name as currencysname, 
          payment_fequency.name as payment_feqname, skill_type.name as skillname, 
          requirement.image as image, requirement.title as title, currencys.id as currencyid, 
          1.609344 * '" . $kmmile . "' * ACOS( COS( RADIANS('" . $loc_lat . "') ) * 
          COS( RADIANS(requirement.latitude) ) * COS( RADIANS(requirement.longitude) - 
          RADIANS('" . $loc_long . "') ) + SIN( RADIANS('" . $loc_lat . "') ) * 
          SIN( RADIANS(requirement.latitude) ) ) AS cdistance, 
          payment_fequency.id as pfqid, skill_type.id as skillid, 
            requirement.jobpost_time_profile_pack_id AS profile_package_id, 
            (CASE 
                WHEN requirement.is_paid_post = 'N' THEN requirement.jobpost_time_rec_pack_id 
                WHEN requirement.is_paid_post = 'Y' THEN requirement.jobpost_time_req_pack_id 
             END) AS req_package_id,

          (SELECT subscriptions.package_id FROM subscriptions 
              WHERE subscriptions.package_type='PR' AND subscriptions.user_id=requirement.user_id 
              ORDER BY id DESC LIMIT 1) AS p_package, 
          (SELECT subscriptions.package_id FROM subscriptions 
              WHERE subscriptions.package_type='RC' AND subscriptions.user_id=requirement.user_id 
              ORDER BY id DESC LIMIT 1) AS r_package, 
         (CASE 
            WHEN requirement.is_paid_post = 'N' 
            THEN COALESCE((SELECT visibility_matrix.ordernumber 
                           FROM visibility_matrix 
                           WHERE visibility_matrix.profilepack_id = requirement.jobpost_time_profile_pack_id 
                           AND visibility_matrix.recruiter_id = requirement.jobpost_time_rec_pack_id
                           LIMIT 1), 100) 
            WHEN requirement.is_paid_post = 'Y' 
            THEN COALESCE((SELECT requirement_pack.priorites 
                           FROM requirement_pack 
                           WHERE requirement_pack.id = requirement.jobpost_time_req_pack_id
                           LIMIT 1), 100) 
            ELSE 100 
         END) AS order_num  
      FROM requirement 
      LEFT JOIN requirement_vacancy ON requirement.id = requirement_vacancy.requirement_id  
      LEFT JOIN skill_type ON requirement_vacancy.telent_type = skill_type.id 
      LEFT JOIN currencys ON requirement_vacancy.payment_currency = currencys.id 
      LEFT JOIN payment_fequency ON requirement_vacancy.payment_freq = payment_fequency.id 
      LEFT JOIN users ON requirement.user_id = users.id 
      LEFT JOIN eventtypes ON eventtypes.id = requirement.event_type 
      WHERE requirement_vacancy.payment_amount >= '$min' 
      AND requirement_vacancy.payment_amount <= '$max'";

      // pr($query);exit;


      if ($this->request->query['optiontype'] == 1) {
         $session = $this->request->session();
         $session->write('backtorefinesearch', $_SERVER['QUERY_STRING']);
      }

      if (!empty(trim($this->request->query['name'])) && empty($this->request->query['refine']) && empty($this->request->query['form'])) {
         //pr($this->request)
         $title = trim($this->request->query['name']);
         //echo $title; die;
         $query .= " And (`title` Like '%$title%' or talent_requirement_description Like '%$title%' or requirement.location Like '%$title%' or skill_type.name Like '%$title%' or eventtypes.name Like '%$title%' or personal_profile.name LIKE '%$title%')";

         $this->set('title', $title);
      }
      // Refine Parametes
      if ($this->request->query['refine'] == 1) {

         if (!empty($this->request->query['keyword'])) {
            $title = $this->request->query['keyword'];
            $query .= " And ( requirement.title Like '%$title%'  or talent_requirement_description Like '%$title%'  or skill_type.name Like '%$title%' ) ";
         }

         $backtorefine = 1;
         $this->set('backtorefine', $backtorefine);

         if (!empty($this->request->query['currency']) && $this->request->query['currency']['0'] != 0) {
            $currencyarray = $this->request->query['currency'];
            $count = count($this->request->query['currency']);
            for ($i = 0; $i < count($this->request->query['currency']); $i++) {
               if ($i == 0) {
                  $currency .= "'" . $this->request->query['currency'][$i] . "'";
               } else {
                  $currency .= " OR requirement_vacancy.payment_currency='" . $this->request->query['currency'][$i] . "'";
               }
            }
            $query .= "and (requirement_vacancy.payment_currency=$currency)";
            $this->set('currencyarrayset', $currencyarray);
         }

         if (!empty($this->request->query['payment']) && $this->request->query['payment']['0'] != 0) {
            $paymentselectedarray = $this->request->query['payment'];
            $count = count($this->request->query['payment']);

            for ($i = 0; $i < count($this->request->query['payment']); $i++) {
               if ($i == 0) {
                  $payment = "'" . $this->request->query['payment'][$i] . "'";
               } else {
                  $payment .= " OR requirement_vacancy.payment_freq= '" . $this->request->query['payment'][$i] . "'";
               }
            }
            $query .= "And (requirement_vacancy.payment_freq=$payment) ";
            $this->set('paymentselarray', $paymentselectedarray);
         }

         if (!empty($this->request->query['location']) && $this->request->query['location']['0'] != 1) {
            $count = count($this->request->query['location']);
            for ($i = 0; $i < count($this->request->query['location']); $i++) {
               if ($i == 0) {
                  $location = "'" . $this->request->query['location'][$i] . "'";
               } else {
                  $location .= " OR requirement.location = '" . $this->request->query['location'][$i] . "'";
               }
            }
            $loc = $this->request->query['location'];
            $this->set('loc', $loc);
            $query .= " And (requirement.location = $location ) ";
         }

         if (!empty($this->request->query['time'])) {
            $time = $this->request->query['time'];
            if ($time != 'a') {
               $query .= " And (requirement.continuejob='$time' )";
            }
         }

         if (!empty($this->request->query['eventtype'])  && $this->request->query['eventtype']['0'] != 0) {
            $eventtypearr = $this->request->query['eventtype'];
            for ($i = 0; $i < count($this->request->query['eventtype']); $i++) {
               if ($i == 0) {
                  $eventtype = "'" . $this->request->query['eventtype'][$i] . "'";
               } else {
                  $eventtype .= " OR requirement.event_type='" . $this->request->query['eventtype'][$i] . "'";
               }
            }
            $this->set('eventtypearray', $eventtypearr);
            $query .= " And (requirement.event_type=$eventtype )";
         }

         if (!empty($this->request->query['telenttype']) && $this->request->query['telenttype'][0] != 0) {
            $telenttyp = $this->request->query['telenttype'];
            for ($i = 0; $i < count($this->request->query['telenttype']); $i++) {
               if ($i == 0) {
                  $telenttype = "'" . $this->request->query['telenttype'][$i] . "'";
               } else {

                  $telenttype .= " OR (requirement_vacancy.telent_type='" . $this->request->query['telenttype'][$i] . "')";
               }
            }
            $this->set('ttype', $telenttyp);
            $query .= " And (requirement_vacancy.telent_type=$telenttype )";
         }
      }
      // Refine End
      // pr($query);exit;


      //Advance Job Search start
      if ($this->request->query['from'] == 1) {
         $session = $this->request->session();
         $session->write('backtorefinesearch', $_SERVER['QUERY_STRING']);
         if (!empty($this->request->query['keyword'])) {
            $title = $this->request->query['keyword'];
            $query .= " And ( requirement.title Like '%$title%' or eventtypes.name Like '%$title%' ) ";
         }

         if ($this->request->query['skill']) {
            $skill = $this->request->query['skill'];
            $skillarray = explode(",", $skill);

            for ($i = 0; $i < count($skillarray); $i++) {
               if (count($skillarray) == 1) {
                  $skillcheck .= "requirement_vacancy.telent_type like '$skillarray[$i]'";
               } elseif ($i == 0) {
                  $skillcheck .= "requirement_vacancy.telent_type like '$skillarray[$i]'";
               } else if ($i == count($skillarray) - 1) {
                  $skillcheck .= " or requirement_vacancy.telent_type like '$skillarray[$i]'";
               } else {
                  $skillcheck .= " or requirement_vacancy.telent_type like '$skillarray[$i]'";
               }
            }

            $query .= "and (" . $skillcheck . ")";
         } else {
            $skillcheck = "";
         }

         if (!empty($this->request->query['gender'])) {
            if (in_array("a", $this->request->query['gender'])) {
            } else {
               for ($i = 0; $i < count($this->request->query['gender']); $i++) {
                  if ($i == 0) {
                     $sex = "'" . $this->request->query['gender'][$i] . "'";
                  } else {
                     $sex .= " OR requirement_vacancy.sex='" . $this->request->query['gender'][$i] . "'";
                  }
               }
               $query .= " And (requirement_vacancy.sex=$sex )";
            }
         }

         if (!empty($this->request->query['Paymentfequency'])) {
            $paymentselectedarray = $this->request->query['Paymentfequency'];
            $count = count($this->request->query['Paymentfequency']);

            for ($i = 0; $i < count($this->request->query['Paymentfequency']); $i++) {
               if ($i == 0) {
                  $Paymentfequency = "'" . $this->request->query['Paymentfequency'][$i] . "'";
               } else {
                  $Paymentfequency .= " OR requirement_vacancy.payment_freq= '" . $this->request->query['Paymentfequency'][$i] . "'";
               }
            }
            $query .= "And (requirement_vacancy.payment_freq=$Paymentfequency)";
         }


         if (!empty($this->request->query['eventtype'])) {
            $eventtypearr = $this->request->query['eventtype'];
            $newarray = explode(",", $this->request->query['eventtype']);
            for ($i = 0; $i < count($newarray); $i++) {
               if ($i == 0) {
                  $eventtype = "'" . $newarray[$i] . "'";
               } else {
                  $eventtype .= " OR requirement.event_type='" . $newarray[$i] . "'";
               }
            }

            $this->set('eventtypearray', $eventtypearr);
            $query .= " And (requirement.event_type=$eventtype )";
         }

         if (!empty($this->request->query['country_id'])) {
            $country_id = $this->request->query['country_id'];
            $query .= " And (requirement.country_id='$country_id')";
         }

         if (!empty($this->request->query['state_id'])) {
            $state_id = $this->request->query['state_id'];
            $query .= " And (requirement.state_id='$state_id')";
         }

         if (!empty($this->request->query['city_id'][0]) && $this->request->query['city_id'] != 0) {
            for ($i = 0; $i < count($this->request->query['city_id']); $i++) {
               if ($i == 0) {
                  $city_id = "'" . $this->request->query['city_id'][$i] . "'";
               } else {
                  $city_id .= " OR requirement.city_id='" . $this->request->query['city_id'][$i] . "'";
               }
            }
            $query .= " And (requirement.city_id=$city_id)";
         }

         if (!empty($this->request->query['latitude']) && $this->request->query['longitude']) {
            if ($this->request->query['unit'] == "" || $this->request->query['within'] == "") {
               $lat = $this->request->query['latitude'];
               $log = $this->request->query['longitude'];
               $query .= " And (requirement.latitude='$lat' And requirement.longitude='$log')";
            }
         }

         if ($this->request->query['unit'] != '' && $this->request->query['within'] != '') {
            $this->set('targetlocation', $this->request->query['locationlat']);
            $this->set('targetwithin', $this->request->query['within']);
         }

         if (!empty($this->request->query['role_id'])) {
            $role = $this->request->query['role_id'];
            if ($this->request->query['role_id'] != 0) {
               $query .= " And( users.role_id='$role')";
            }
         }

         if (!empty($this->request->query['recname'])) {
            $recname = $this->request->query['recname'];
            $query .= " And( users.user_name LIKE'%$recname%')";
         }

         if (!empty($this->request->query['time'])) {
            $recname = $this->request->query['time'];
            if ($recname != 'a') {
               $query .= " And( requirement.continuejob='$recname')";
            }
         }
         // If only event_from_date is given
         if (!empty($this->request->query['event_from_date']) && empty($this->request->query['event_to_date'])) {
            $eventFromDate = date("Y-m-d H:i:s", strtotime($this->request->query['event_from_date']));

            $query .= " AND (
            (requirement.continuejob = 'Y' AND requirement.last_date_app >= '$eventFromDate') OR
            (requirement.continuejob = 'N' AND requirement.event_from_date >= '$eventFromDate')
         )";
         }

         // If only event_to_date is given
         if (!empty($this->request->query['event_to_date']) && empty($this->request->query['event_from_date'])) {
            $eventToDate = date("Y-m-d H:i:s", strtotime($this->request->query['event_to_date']));

            $query .= " AND (
            (requirement.continuejob = 'Y' AND requirement.last_date_app <= '$eventToDate') OR
            (requirement.continuejob = 'N' AND requirement.event_to_date <= '$eventToDate')
         )";
         }


         if (!empty($this->request->query['event_to_date']) && !empty($this->request->query['event_from_date'])) {
            $eventFromDate = date("Y-m-d H:i:s", strtotime($this->request->query['event_from_date']));
            $eventToDate = date("Y-m-d H:i:s", strtotime($this->request->query['event_to_date']));

            $query .= " AND (
                      (requirement.continuejob = 'Y' AND requirement.last_date_app BETWEEN '$eventFromDate' AND '$eventToDate') OR
                      (requirement.continuejob = 'N' AND requirement.event_from_date >= '$eventFromDate' AND requirement.event_to_date <= '$eventToDate')
                  )";
         }


         // Only From Date provided
         if (!empty($this->request->query['talent_required_fromdate']) && empty($this->request->query['talent_required_todate'])) {
            $fromDate = date("Y-m-d H:i:s", strtotime($this->request->query['talent_required_fromdate']));

            $query .= " AND (
               (requirement.continuejob = 'Y' AND requirement.last_date_app >= '$fromDate') OR
               (requirement.continuejob = 'N' AND requirement.talent_required_fromdate >= '$fromDate')
            )";
         }

         // Only To Date provided
         if (!empty($this->request->query['talent_required_todate']) && empty($this->request->query['talent_required_fromdate'])) {
            $toDate = date("Y-m-d H:i:s", strtotime($this->request->query['talent_required_todate']));

            $query .= " AND (
               (requirement.continuejob = 'Y' AND requirement.last_date_app <= '$toDate') OR
               (requirement.continuejob = 'N' AND requirement.talent_required_todate <= '$toDate')
            )";
         }

         // Both From and To Dates provided
         if (!empty($this->request->query['talent_required_fromdate']) && !empty($this->request->query['talent_required_todate'])) {
            $fromDate = date("Y-m-d H:i:s", strtotime($this->request->query['talent_required_fromdate']));
            $toDate = date("Y-m-d H:i:s", strtotime($this->request->query['talent_required_todate']));

            $query .= " AND (
               (requirement.continuejob = 'Y' AND requirement.last_date_app BETWEEN '$fromDate' AND '$toDate') OR
               (requirement.continuejob = 'N' AND requirement.talent_required_fromdate >= '$fromDate' AND requirement.talent_required_todate <= '$toDate')
            )";
         }


         if (!empty($this->request->query['last_date_app']) && empty($this->request->query['last_date_appbefore'])) {
            $last_date_app = date("Y-m-d H:s:i", strtotime($this->request->query['last_date_app']));
            $query .= "And (requirement.last_date_app >= '$last_date_app')";
         }

         if (!empty($this->request->query['last_date_appbefore']) && empty($this->request->query['last_date_app'])) {
            $last_date_app = date("Y-m-d H:s:i", strtotime($this->request->query['last_date_appbefore']));
            $query .= "and (requirement.last_date_app <= '$last_date_app')";
         }

         if (!empty($this->request->query['last_date_appbefore']) && !empty($this->request->query['last_date_app'])) {
            $last_date_app = date("Y-m-d H:s:i", strtotime($this->request->query['last_date_app']));
            $last_date_appbefore = date("Y-m-d H:s:i", strtotime($this->request->query['last_date_appbefore']));
            $query .= "and (requirement.last_date_app <= '$last_date_app' and requirement.last_date_app >= '$last_date_appbefore' )";
         }

         if ($this->request->query['checkboxbefore']) {
            if ($this->request->query['checkboxafter']) {
               $last_date_app = date("Y-m-d H:s:i", strtotime($this->request->query['last_date_app']));
               $last_date_appbefore = date("Y-m-d H:s:i", strtotime($this->request->query['last_date_appbefore']));
               $query .= "And (requirement.last_date_app>='$date' and  requirement.last_date_app<='$last_date_appbefore' )";
            }
         }
      }
      // Advance Job Search End


      // Advance Search Plus Refine
      if ($_SESSION['advancejobsearch'] && $this->request->query['refine'] == 1) {
         if ($_SESSION['advancejobsearch']['skill']) {

            $skill = $_SESSION['advancejobsearch']['skill'];
            $skillarray = explode(",", $skill);
            for ($i = 0; $i < count($skillarray); $i++) {
               if (count($skillarray) == 1) {
                  $skillcheck .= "requirement_vacancy.telent_type like '$skillarray[$i]'";
               } elseif ($i == 0) {
                  $skillcheck .= "requirement_vacancy.telent_type like '$skillarray[$i]'";
               } else if ($i == count($skillarray) - 1) {
                  $skillcheck .= " or requirement_vacancy.telent_type like '$skillarray[$i]'";
               } else {
                  $skillcheck .= " or requirement_vacancy.telent_type like '$skillarray[$i]'";
               }
            }

            $query .= "and (" . $skillcheck . ") ";
         } else {
            $skillcheck = "";
         }

         if (!empty($_SESSION['advancejobsearch']['keyword'])) {
            $title = $_SESSION['advancejobsearch']['keyword'];
            $query .= " And ( requirement.title Like '%$title%'  or talent_requirement_description Like '%$title%'  or skill_type.name Like '%$title%' or eventtypes.name Like '%$title%' ) ";
         }


         if (!empty($_SESSION['advancejobsearch']['gender'])) {
            if (in_array("a", $_SESSION['advancejobsearch']['gender'])) {
            } else {
               for ($i = 0; $i < count($_SESSION['advancejobsearch']['gender']); $i++) {
                  if ($i == 0) {
                     $sex = "'" . $_SESSION['advancejobsearch']['gender'][$i] . "'";
                  } else {
                     $sex .= " OR requirement_vacancy.sex='" . $_SESSION['advancejobsearch']['gender'][$i] . "'";
                  }
               }
               $query .= " And (requirement_vacancy.sex=$sex ) ";
            }
         }

         if (!empty($_SESSION['advancejobsearch']['Paymentfequency'])) {
            $paymentselectedarray = $_SESSION['advancejobsearch']['Paymentfequency'];
            $count = count($_SESSION['advancejobsearch']['Paymentfequency']);
            for ($i = 0; $i < count($_SESSION['advancejobsearch']['Paymentfequency']); $i++) {
               if ($i == 0) {
                  $Paymentfequency = "'" . $_SESSION['advancejobsearch']['Paymentfequency'][$i] . "'";
               } else {
                  $Paymentfequency .= " OR requirement_vacancy.payment_freq= '" . $_SESSION['advancejobsearch']['Paymentfequency'][$i] . "'";
               }
            }
            $query .= "And (requirement_vacancy.payment_freq=$Paymentfequency)";
         }

         if (!empty($_SESSION['advancejobsearch']['eventtype'])) {
            $eventtypearr = $_SESSION['advancejobsearch']['eventtype'];
            $newarray = explode(",", $_SESSION['advancejobsearch']['eventtype']);
            for ($i = 0; $i < count($newarray); $i++) {
               if ($i == 0) {
                  $eventtype = "'" . $newarray[$i] . "'";
               } else {
                  $eventtype .= " OR requirement.event_type='" . $newarray[$i] . "'";
               }
            }

            $this->set('eventtypearray', $eventtypearr);
            $query .= " And (requirement.event_type=$eventtype )";
         }

         if (!empty($_SESSION['advancejobsearch']['country_id'])) {
            $country_id = $_SESSION['advancejobsearch']['country_id'];
            $query .= " And (requirement.country_id='$country_id')";
         }

         if (!empty($_SESSION['advancejobsearch']['state_id'])) {
            $state_id = $_SESSION['advancejobsearch']['state_id'];
            $query .= " And (requirement.state_id='$state_id')";
         }

         if (!empty($_SESSION['advancejobsearch']['city_id'][0]) && $_SESSION['advancejobsearch']['city_id'] != 0) {
            for ($i = 0; $i < count($_SESSION['advancejobsearch']['city_id']); $i++) {
               if ($i == 0) {
                  $city_id = "'" . $_SESSION['advancejobsearch']['city_id'][$i] . "'";
               } else {
                  $city_id .= " OR requirement.city_id='" . $_SESSION['advancejobsearch']['city_id'][$i] . "'";
               }
            }
            $query .= " And (requirement.city_id=$city_id)";
         }

         if (!empty($_SESSION['advancejobsearch']['latitude']) && $_SESSION['advancejobsearch']['longitude']) {
            $lat = $_SESSION['advancejobsearch']['latitude'];
            $log = $_SESSION['advancejobsearch']['longitude'];
            if ($_SESSION['advancejobsearch']['within'] == '') {
               $query .= " And (requirement.latitude='$lat' And requirement.longitude='$log')";
            }
         }

         if ($_SESSION['advancejobsearch']['unit'] != '' && $_SESSION['advancejobsearch']['within'] != '') {
            $within = $_SESSION['advancejobsearch']['within'];
         }

         if (!empty($_SESSION['advancejobsearch']['role_id'])) {
            $role = $_SESSION['advancejobsearch']['role_id'];
            if ($_SESSION['advancejobsearch']['role_id'] != 0) {
               $query .= " And( users.role_id='$role')";
            }
         }

         if (!empty($_SESSION['advancejobsearch']['recname'])) {
            $recname = $_SESSION['advancejobsearch']['recname'];
            $query .= " And( users.user_name LIKE'%$recname%')";
         }

         if (!empty($_SESSION['advancejobsearch']['time'])) {
            $recname = $_SESSION['advancejobsearch']['time'];
            if ($recname != 'a') {
               $query .= " And( requirement.continuejob='$recname')";
            }
         }


         if (!empty($_SESSION['advancejobsearch']['event_from_date']) && empty($_SESSION['advancejobsearch']['event_to_date'])) {
            $event_from_date = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['event_from_date']));
            $query .= " And (requirement.event_from_date='$event_from_date')";
         }


         if (!empty($_SESSION['advancejobsearch']['event_to_date']) && empty($_SESSION['advancejobsearch']['event_from_date'])) {
            $event_to_date = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['event_to_date']));
            $query .= " And (requirement.event_to_date='$event_to_date')";
         }

         if (!empty($_SESSION['advancejobsearch']['event_to_date']) && !empty($_SESSION['advancejobsearch']['event_from_date'])) {
            $event_to_date = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['event_to_date']));
            $event_from_date = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['event_from_date']));
            $query .= " And (requirement.event_from_date>='$event_from_date' And requirement.event_to_date <= '$event_to_date') ";
         }

         if (!empty($_SESSION['advancejobsearch']['talent_required_fromdate']) && empty($_SESSION['advancejobsearch']['talent_required_todate'])) {
            $talent_required_fromdate = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['talent_required_fromdate']));
            $query .= " And (requirement.talent_required_fromdate='$talent_required_fromdate')";
         }

         if (!empty($_SESSION['advancejobsearch']['talent_required_todate']) && empty($_SESSION['advancejobsearch']['talent_required_fromdate'])) {
            $talent_required_todate = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['talent_required_todate']));
            $query .= " And (requirement.talent_required_todate='$talent_required_todate')";
         }

         if (!empty($_SESSION['advancejobsearch']['talent_required_todate']) && !empty($_SESSION['advancejobsearch']['talent_required_fromdate'])) {
            $talent_required_todate = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['talent_required_todate']));
            $talent_required_fromdate = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['talent_required_fromdate']));
            $query .= " And (requirement.talent_required_fromdate>='$talent_required_fromdate' And requirement.talent_required_todate<='$talent_required_todate' )";
         }

         if ($_SESSION['advancejobsearch']['checkboxafter'] == 1 && $_SESSION['advancejobsearch']['checkboxbefore'] != 2) {
            if (!empty($_SESSION['advancejobsearch']['last_date_app'])) {

               $last_date_app = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['last_date_app']));
               $query .= "And (requirement.last_date_app>='$last_date_app')";
            }
         }

         if ($_SESSION['advancejobsearch']['checkboxbefore'] == 2 && $_SESSION['advancejobsearch']['checkboxafter'] != 1) {
            if (!empty($_SESSION['advancejobsearch']['last_date_appbefore'])) {
               $last_date_app = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['last_date_appbefore']));
               $query .= "And (requirement.last_date_app<='$last_date_app')";
            }
         }

         if ($_SESSION['advancejobsearch']['checkboxbefore']) {
            if ($_SESSION['advancejobsearch']['checkboxafter']) {
               $last_date_app = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['last_date_app']));
               $last_date_appbefore = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['last_date_appbefore']));
               $query .= "And (requirement.last_date_app>='$date' and  requirement.last_date_app<='$last_date_appbefore' )";
            }
         }
      }

      //Advance Search Plus Refine End

      $query .= "And (requirement.last_date_app>='$date') ";
      $query .= "And (requirement.status='Y') ";
      $query .= "And (requirement.jobdelete_status='N') ";
      $query .= "Group by requirement.id " . $have . "order by order_num ASC";

      if ($this->request->query['refine'] == 1) {
         $session = $this->request->session();
         $session->delete('Refinejobfilter');
         $this->request->session()->write('Refinejobfilter', $query);
      } else if ($this->request->query['from'] == 1) {
         $session = $this->request->session();
         $session->delete('Refinejobfilter');
         $this->request->session()->write('Refinejobfilter', $query);
      } else if (!empty(trim($this->request->query['name']))) {
         $session = $this->request->session();
         $session->delete('Refinejobfilter');
         $this->request->session()->write('Refinejobfilter', $query);
      }

      // End Advance job search parameters  

      // Refine filter query 
      if ($this->request->query['refine'] != 1) {
         $session = $this->request->session();
         $this->request->session()->write('searchparamer', $query);
         // $query .= "order by order_num, requirement.user_id asc";
      }
      // pr($query);
      // exit;

      $con = ConnectionManager::get('default');
      $refineparameter = $con->execute($_SESSION['searchparamer'])->fetchAll('assoc');
      //pr($refineparameter); die;
      //$query.="order by order_num, requirement.user_id asc"; 
      // $con = ConnectionManager::get('default');
      $searchdata = $con->execute($query)->fetchAll('assoc');
      // pr($searchdata);
      // exit;
      $this->set('searchdata', $searchdata);
      $currencyarray = array();
      $payemntfaq = array();
      $talentype = array();
      $eventtype = array();
      $continue = array();
      if (!empty($this->request->query['within']) && !empty($this->request->query['locationlat'])) {
         foreach ($refineparameter as $value) {
            $value['myvalue'] = $this->get_driving_information($this->request->query['locationlat'], $value['location']);
            if ($claculationunit == "mi") {
               $dis = (int)(preg_replace("/[a-zA-Z]/", "", $value['myvalue'])) * (0.621371);
            } else {
               $dis = (int)preg_replace("/[a-zA-Z]/", "", $value['myvalue']);
            }

            if ($dis <= $this->request->query['within']) {
               $continue[] = $value['continuejob'];
               if ($date < $value['last_date_app']) {
                  $skill = $this->RequirmentVacancy->find('all')->contain(['Skill', 'Paymentfequency', 'Currency'])->where(['RequirmentVacancy.requirement_id' => $value['id']])->toArray();
                  foreach ($skill as $myvalue) {
                     $talentype[$myvalue['skill']['id']] = $myvalue['skill']['name'];
                     $salryarray[] = $myvalue['payment_amount'];
                  }

                  foreach ($skill as $myvalue) {
                     $payemntfaq[$myvalue['paymentfequency']['id']] = $myvalue['paymentfequency']['name'];
                  }

                  foreach ($skill as $myvalue) {
                     $currencyarray[$myvalue['currency']['id']] = $myvalue['currency']['name'];
                  }

                  $eventtype[$value['event_type']] = $value['eventname'];
                  $locationarray[$value['location']] = $value['location'];
               }
            }
         }
      } else {
         foreach ($refineparameter as $value) {
            $continue[] = $value['continuejob'];
            if ($date < $value['last_date_app']) {
               $skill = $this->RequirmentVacancy->find('all')->contain(['Skill', 'Paymentfequency', 'Currency'])->where(['RequirmentVacancy.requirement_id' => $value['id']])->toArray();
               foreach ($skill as $myvalue) {
                  $talentype[$myvalue['skill']['id']] = $myvalue['skill']['name'];
                  $salryarray[] = $myvalue['payment_amount'];
               }

               foreach ($skill as $myvalue) {
                  $payemntfaq[$myvalue['paymentfequency']['id']] = $myvalue['paymentfequency']['name'];
               }

               foreach ($skill as $myvalue) {
                  $currencyarray[$myvalue['currency']['id']] = $myvalue['currency']['name'];
               }

               $eventtype[$value['event_type']] = $value['eventname'];
               $locationarray[$value['location']] = $value['location'];
            }
         }
      }

      if ($this->request->query['refine'] != 1) {
         $this->set('maxi', max($salryarray));
         $this->set('mini', min($salryarray));

         $session = $this->request->session();
         $session->write('maxi', max($salryarray));

         $session = $this->request->session();
         $session->write('mini', min($salryarray));

         $this->set('selmaxi', max($salryarray));
         $this->set('selmini', min($salryarray));
      }

      $this->set('title', $title);
      $this->set('location', $locationarray);
      $this->set('currencyarray', $currencyarray);
      $this->set('payemntfaq', $payemntfaq);
      $this->set('talentype', $talentype);
      $this->set('continue', $continue);
      $this->set('time', $this->request->query['time']);
      $this->set('eventtype', array_unique($eventtype));
      $this->set('data', $this->request->query);
   }

   public function advanceProfilesearch($edit = null)
   {
      // echo !$edit; die;
      //pr($_SESSION); die;
      if (!$edit) {
         $session = $this->request->session();
         $session->delete('advanceprofiesearchdata');
         //delete($_SESSION['advanceprofiesearchdata']);
      }

      //echo "GFDGfdgfdgdf"; die;
      $this->loadModel('Country');
      $this->loadModel('Paymentfequency');
      $this->loadModel('State');
      $this->loadModel('Profile');
      $this->loadModel('Skill');
      $country = $this->Country->find('list')->select(['id', 'name'])->toarray();
      $this->set('country', $country);
      $Paymentfequency = $this->Paymentfequency->find('all')->select(['id', 'name'])->toarray();

      $states = $this->State->find('list')->where(['State.id' => $_SESSION['advanceprofiesearchdata']['state_id']])->toarray();
      $Skill = $this->Skill->find('all')->select(['id', 'name'])->toarray();
      $this->set('Skill', $Skill);

      $this->set('states', $states);
      $this->set('Paymentfequency', $Paymentfequency);
      $this->set('edit', $edit);


      $user_id = $this->request->session()->read('Auth.User.id');
      $profile = $this->Profile->find('all')->where(['user_id' => $user_id])->first();
      //	pr($profile); die;
      $this->set('current_location', $profile['current_location']);
   }

   public function search($is_reset = null)
   {

      $this->loadModel('Profile');
      $this->loadModel('jrement');
      $this->loadModel('Savejobs');
      $this->loadModel('Likejobs');
      $this->loadModel('Blockjobs');
      $this->loadModel('JobApplication');
      $this->loadModel('RequirmentVacancy');
      $this->loadModel('Settings');
      $this->loadModel('Packfeature');
      $this->loadModel('Requirement');
      $this->loadModel('JobQuote');
      $this->loadModel('Blocks');
      $this->loadModel('Notification');


      // pr($this->request->query);
      // exit;

      // pr($this->request->query);
      // die;
      //   session_start();   
      //     if ($is_reset == "reset") {
      //       //  $session->delete('backtorefinesearch');
      //       unset($_SESSION['backtorefinesearch']);
      //     }
      $session = $this->request->session();
      if ($is_reset == "reset") {
         $this->request->session()->delete('request_data');
      }

      $data = $session->read("request_data");
      if (empty($this->request->query)) {
         $this->request->query = $data;
      }

      $claculationunit = $this->request->query['unit'];
      $this->set('claculationunit', $this->request->query['unit']);
      if ($this->request->query['refine'] != 1) {
         $session = $this->request->session();
         $session->write('advancejobsearch', $this->request->query);
      }

      $savejobarray = array();
      /*  Not For Searching */
      $id = $this->request->session()->read('Auth.User.id');

      // pr($_GET);exit;

      $user_id = $this->request->session()->read('Auth.User.id');
      if (empty($id)) {
         $session = $this->request->session();
         $session->delete('request_data');
         $session->write("request_data", $this->request->query);
         return $this->redirect(['action' => 'withoutloginsearch']);
      }
      $packfeature = $this->activePackage(); // comes from add controller data is from Packfeature table
      // $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();


      $totalDailyLimit = $packfeature['number_of_quote_daily'];
      $totalUsed = $packfeature['number_of_quote_daily_used'];
      $remaining = $totalDailyLimit - $totalUsed;
      $remaining = ($remaining > 0) ? $remaining : 0;


      $monthlimit = $packfeature['number_job_application_month'];
      $dailylimit = $packfeature['number_job_application_daily'];

      // Get the current date
      $currentDate = date('Y-m-d');
      // Check how many applications the user has made today
      $dailyApplicationCount = $this->JobApplication->find()
         ->where([
            'JobApplication.user_id' => $user_id,
            'DATE(JobApplication.created)' => $currentDate
         ])
         ->count();
      // Check how many applications the user has made this month
      $firstDayOfMonth = date('Y-m-01');
      $lastDayOfMonth = date('Y-m-t');
      $monthlyApplicationCount = $this->JobApplication->find()
         ->where([
            'JobApplication.user_id' => $user_id,
            'JobApplication.created >=' => $firstDayOfMonth,
            'JobApplication.created <=' => $lastDayOfMonth
         ])
         ->count();


      $numberofaskquoteperjob = $packfeature['ask_for_quote_request_per_job'];
      $this->set('month', $monthlimit - $monthlyApplicationCount);
      $this->set('daily', $dailylimit - $dailyApplicationCount);
      $this->set('numberofaskquoteperjob', $numberofaskquoteperjob);
      $this->set('quote', $remaining);
      // $this->set('quote', $packfeature['number_of_quote_daily']);

      $currentdate = date('Y-m-d H:m:s');
      $activejobs = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency']])->where(['user_id' => $id, 'Requirement.last_date_app >=' => $currentdate, 'Requirement.status' => 'Y'])->toarray();
      // pr($activejobs);exit;
      $this->set('activejobs', $activejobs);

      $setting = $this->Settings->find('all')->first();
      $userid = $this->request->session()->read('Auth.User.id');
      // $user_id = $this->request->session()->read('Auth.User.id');
      $askquote = $this->JobQuote->find('all')->where(['user_id' => $user_id])->toarray();

      $this->set('askquote', $askquote);
      // $this->set('ping_amt', $setting['ping_amt']);
      $this->set('ping_amt', $packfeature['ping_amt']);
      $bookjob = $this->JobApplication->find('all')->where(['user_id' => $userid])->toarray();
      $this->set('alliedjobs', $bookjob);
      $Savejobsdata = $this->Savejobs->find('all')->where(['Savejobs.user_id' => $user_id])->order(['Savejobs.id' => 'ASC'])->toarray();
      $likejobsdata = $this->Likejobs->find('all')->where(['Likejobs.user_id' => $user_id])->order(['Likejobs.id' => 'ASC'])->toarray();

      $Blockjobsdata = $this->Blockjobs->find('all')->where(['Blockjobs.user_id' => $user_id])->order(['Blockjobs.id' => 'ASC'])->toarray();

      foreach ($Savejobsdata as $key => $value) {
         $savejobarray[] = $value['job_id'];
      }

      foreach ($Blockjobsdata as $key => $value) {
         $blockjobarray[] = $value['job_id'];
      }

      foreach ($likejobsdata as $key => $value) {
         $likejobarray[] = $value['job_id'];
      }
      $this->set('savejobarray', $savejobarray);
      $this->set('likejobarray', $likejobarray);
      $this->set('blockjobarray', $blockjobarray);
      /*  Not For Searching */
      // advance search parameters

      $keywords = strtolower(trim($this->request->query['keyword']));

      if ($this->request->query['latitude']) {
         $loc_lat = $this->request->query['latitude'];
      } else {
         $loc_lat = "";
      }

      if ($this->request->query['longitude']) {
         $loc_long = $this->request->query['longitude'];
      } else {
         $loc_long = "";
      }

      // pr($this->request->data);exit;
      // if ($this->request->query['unit'] = "km") {
      //    $kmmile = 3956;
      // } else {
      //    $kmmile = 6371;
      // }
      if ($this->request->query['unit'] = "km") {
         $kmmile = $this->request->query['within'];
      } else {
         $kmmile = $this->request->query['within'];
      }

      $salary = explode("-", $this->request->query['salaryrange']);
      $min = $salary['0'];
      if ($min) {
         $min = $min;
         //$this->set('maxi', max($salryarray));
         $this->set('selmini', $min);
      } else {
         $min = 0;
      }
      $max = $salary['1'];
      if ($max) {
         $max = $max;
         $this->set('selmaxi', $max);
      } else {
         $max = 50000;
      }
      // Session 

      // pr($this->request->data);exit;

      $date = date('Y-m-d H:i:s');
      // $user_id = $this->request->session()->read('Auth.User.id');

      // Refine By Rupam Singh with visibility matrix do not remove 04-04-2025
      $query = "SELECT requirement.continuejob, requirement_vacancy.telent_type, requirement.is_paid_post,
          requirement_vacancy.payment_currency, requirement_vacancy.payment_amount, 
          requirement.location, requirement.talent_requirement_description, 
          requirement_vacancy.sex as sex, users.user_name, users.role_id, 
          eventtypes.name as eventname, requirement.id, requirement.user_id, 
          requirement.last_date_app, requirement.event_type, currencys.name as currencysname, 
          payment_fequency.name as payment_feqname, skill_type.name as skillname, 
          requirement.image as image, requirement.title as title, currencys.id as currencyid, 
          1.609344 * '" . $kmmile . "' * ACOS( COS( RADIANS('" . $loc_lat . "') ) * 
          COS( RADIANS(requirement.latitude) ) * COS( RADIANS(requirement.longitude) - 
          RADIANS('" . $loc_long . "') ) + SIN( RADIANS('" . $loc_lat . "') ) * 
          SIN( RADIANS(requirement.latitude) ) ) AS cdistance, 
          payment_fequency.id as pfqid, skill_type.id as skillid, 
            requirement.jobpost_time_profile_pack_id AS profile_package_id, 
            (CASE 
                WHEN requirement.is_paid_post = 'N' THEN requirement.jobpost_time_rec_pack_id 
                WHEN requirement.is_paid_post = 'Y' THEN requirement.jobpost_time_req_pack_id 
             END) AS req_package_id,

          (SELECT subscriptions.package_id FROM subscriptions 
              WHERE subscriptions.package_type='PR' AND subscriptions.user_id=requirement.user_id 
              ORDER BY id DESC LIMIT 1) AS p_package, 
          (SELECT subscriptions.package_id FROM subscriptions 
              WHERE subscriptions.package_type='RC' AND subscriptions.user_id=requirement.user_id 
              ORDER BY id DESC LIMIT 1) AS r_package, 
         (CASE 
            WHEN requirement.is_paid_post = 'N' 
            THEN COALESCE((SELECT visibility_matrix.ordernumber 
                           FROM visibility_matrix 
                           WHERE visibility_matrix.profilepack_id = requirement.jobpost_time_profile_pack_id 
                           AND visibility_matrix.recruiter_id = requirement.jobpost_time_rec_pack_id
                           LIMIT 1), 100) 
            WHEN requirement.is_paid_post = 'Y' 
            THEN COALESCE((SELECT requirement_pack.priorites 
                           FROM requirement_pack 
                           WHERE requirement_pack.id = requirement.jobpost_time_req_pack_id
                           LIMIT 1), 100) 
            ELSE 100 
         END) AS order_num  
      FROM requirement 
      LEFT JOIN requirement_vacancy ON requirement.id = requirement_vacancy.requirement_id  
      LEFT JOIN skill_type ON requirement_vacancy.telent_type = skill_type.id 
      LEFT JOIN currencys ON requirement_vacancy.payment_currency = currencys.id 
      LEFT JOIN payment_fequency ON requirement_vacancy.payment_freq = payment_fequency.id 
      LEFT JOIN users ON requirement.user_id = users.id 
      LEFT JOIN eventtypes ON eventtypes.id = requirement.event_type 
      WHERE requirement_vacancy.payment_amount >= '$min' 
      AND requirement_vacancy.payment_amount <= '$max'";


      if ($user_id) {
         $blocked_user = $this->Blocks->find('list', [
            'keyField' => 'user_id',
            'valueField' => 'user_id',
         ])->where(['Blocks.content_id' => $id])->toarray();

         if (count($blocked_user) > 0) {
            $ids = implode(",", $blocked_user);
            // pr($ids);exit;
            $query .= " AND requirement.user_id NOT IN ($ids,$user_id) ";
         } else {
            $query .= " AND requirement.user_id NOT IN ($user_id) ";
         }
      }

      if ($this->request->query['optiontype'] == 1) {
         $session = $this->request->session();
         if (!$session->check('backtorefinesearch')) { // Check if the session key exists
            $session->write('backtorefinesearch', $_SERVER['QUERY_STRING']);
         }
         // $session->write('backtorefinesearch', $_SERVER['QUERY_STRING']);
      }

      if (!empty(trim($this->request->query['name'])) && empty($this->request->query['refine']) && empty($this->request->query['form'])) {

         $title = strtolower(trim($this->request->query['name']));
         $this->set('title', $title);

         // Make search case-insensitive using LOWER() for DB columns
         $query .= " AND (
            LOWER(`title`) LIKE '%$title%' OR 
            LOWER(talent_requirement_description) LIKE '%$title%' OR 
            LOWER(requirement.location) LIKE '%$title%' OR 
            LOWER(skill_type.name) LIKE '%$title%' OR 
            LOWER(eventtypes.name) LIKE '%$title%'
         )";
      }

      // Refine Parametes
      if ($this->request->query['refine'] == 1) {

         if (!empty($this->request->query['keyword'])) {
            $title = strtolower(trim($this->request->query['keyword']));
            // $query .= " And ( requirement.title Like '%$title%'  or talent_requirement_description Like '%$title%'  or skill_type.name Like '%$title%' ) ";

            $query .= " AND (
               LOWER(`requirement.title`) LIKE '%$title%' OR 
               LOWER(talent_requirement_description) LIKE '%$title%' OR 
               LOWER(requirement.location) LIKE '%$title%' OR 
               LOWER(skill_type.name) LIKE '%$title%' OR 
               LOWER(eventtypes.name) LIKE '%$title%'
            )";
         }

         $backtorefine = 1;
         $this->set('backtorefine', $backtorefine);

         if (!empty($this->request->query['currency']) && $this->request->query['currency']['0'] != 0) {
            $currencyarray = $this->request->query['currency'];

            $count = count($this->request->query['currency']);

            for ($i = 0; $i < count($this->request->query['currency']); $i++) {

               if ($i == 0) {
                  //$currency=$this->request->query['currency'][$i];
                  $currency .= "'" . $this->request->query['currency'][$i] . "'";
               } else {
                  $currency .= " OR requirement_vacancy.payment_currency='" . $this->request->query['currency'][$i] . "'";
               }
            }

            $query .= "and (requirement_vacancy.payment_currency = $currency)";
            $this->set('currencyarrayset', $currencyarray);
         }

         if (!empty($this->request->query['payment']) && $this->request->query['payment']['0'] != 0) {
            $paymentselectedarray = $this->request->query['payment'];
            $count = count($this->request->query['payment']);

            for ($i = 0; $i < count($this->request->query['payment']); $i++) {
               if ($i == 0) {
                  $payment = "'" . $this->request->query['payment'][$i] . "'";
               } else {
                  $payment .= " OR requirement_vacancy.payment_freq= '" . $this->request->query['payment'][$i] . "'";
               }
            }
            $query .= "And (requirement_vacancy.payment_freq=$payment) ";
            $this->set('paymentselarray', $paymentselectedarray);
         }

         if (!empty($this->request->query['location']) && $this->request->query['location']['0'] != 1) {
            $count = count($this->request->query['location']);

            for ($i = 0; $i < count($this->request->query['location']); $i++) {
               if ($i == 0) {
                  $location = "'" . $this->request->query['location'][$i] . "'";
               } else {
                  $location .= " OR requirement.location = '" . $this->request->query['location'][$i] . "'";
               }
            }
            $loc = $this->request->query['location'];
            $this->set('loc', $loc);
            $query .= " And (requirement.location = $location ) ";
         }

         if (!empty($this->request->query['time'])) {
            $time = $this->request->query['time'];
            if ($time != 'a') {
               $query .= " And (requirement.continuejob = '$time' )";
            }
         }

         if (!empty($this->request->query['eventtype'])  && $this->request->query['eventtype']['0'] != 0) {
            $eventtypearr = $this->request->query['eventtype'];
            for ($i = 0; $i < count($this->request->query['eventtype']); $i++) {
               if ($i == 0) {
                  $eventtype = "'" . $this->request->query['eventtype'][$i] . "'";
               } else {
                  $eventtype = " OR requirement.event_type ='" . $this->request->query['eventtype'][$i] . "'";
               }
            }

            $this->set('eventtypearray', $eventtypearr);
            $query .= " And (requirement.event_type = $eventtype )";
         }

         if (!empty($this->request->query['telenttype']) && $this->request->query['telenttype'][0] != 0) {
            $telenttyp = $this->request->query['telenttype'];
            for ($i = 0; $i < count($this->request->query['telenttype']); $i++) {
               if ($i == 0) {
                  $telenttype = "'" . $this->request->query['telenttype'][$i] . "'";
               } else {
                  $telenttype .= " OR (requirement_vacancy.telent_type = '" . $this->request->query['telenttype'][$i] . "')";
               }
            }
            $this->set('ttype', $telenttyp);
            $query .= " And (requirement_vacancy.telent_type = $telenttype )";
         }
      }
      // Refine End

      //Advance Job Search start
      if ($this->request->query['from'] == 1) {
         $session = $this->request->session();
         $session->write('backtorefinesearch', $_SERVER['QUERY_STRING']);

         if (!empty($this->request->query['keyword'])) {
            $title = strtolower(trim($this->request->query['keyword']));
            $query .= " AND (
               LOWER(`title`) LIKE '%$title%' OR 
               LOWER(talent_requirement_description) LIKE '%$title%' OR 
               LOWER(requirement.location) LIKE '%$title%' OR 
               LOWER(skill_type.name) LIKE '%$title%' OR 
               LOWER(eventtypes.name) LIKE '%$title%'
            )";
         }

         // Rupam code 
         if (!empty($this->request->query['skill'])) {
            $skill = trim($this->request->query['skill']);
            $skillarray = array_filter(array_map('trim', explode(",", $skill))); // Clean and filter input

            if (!empty($skillarray)) {
               // Sanitize each ID (assuming numeric IDs)
               $escapedSkills = array_map(function ($id) {
                  return (int)$id; // Cast to int for safety
               }, $skillarray);

               // Build SQL condition
               $skillIds = implode(",", $escapedSkills);
               $query .= " AND (requirement_vacancy.telent_type IN ($skillIds)) ";
            }
         }

         if (!empty($this->request->query['gender'])) {
            if (in_array("a", $this->request->query['gender'])) {
            } else {
               $sex = '';
               for ($i = 0; $i < count($this->request->query['gender']); $i++) {
                  if ($i == 0) {
                     $sex = "'" . $this->request->query['gender'][$i] . "'";
                  } else {
                     $sex .= " OR requirement_vacancy.sex='" . $this->request->query['gender'][$i] . "'";
                  }
               }
               $query .= " And (requirement_vacancy.sex=$sex )";
               // pr($sex);exit;
            }
         }

         if (!empty($this->request->query['Paymentfequency'])) {
            $paymentselectedarray = $this->request->query['Paymentfequency'];
            $count = count($this->request->query['Paymentfequency']);

            for ($i = 0; $i < count($this->request->query['Paymentfequency']); $i++) {
               $Paymentfequency = '';
               if ($i == 0) {
                  $Paymentfequency = "'" . $this->request->query['Paymentfequency'][$i] . "'";
               } else {
                  $Paymentfequency .= " OR requirement_vacancy.payment_freq = '" . $this->request->query['Paymentfequency'][$i] . "'";
               }
            }
            $query .= "And (requirement_vacancy.payment_freq = $Paymentfequency)";
         }

         if (!empty($this->request->query['eventtype'])) {
            $eventtypearr = $this->request->query['eventtype'];
            $newarray = explode(",", $this->request->query['eventtype']);
            for ($i = 0; $i < count($newarray); $i++) {
               if ($i == 0) {
                  $eventtype = "'" . $newarray[$i] . "'";
               } else {
                  $eventtype .= " OR requirement.event_type = '" . $newarray[$i] . "'";
               }
            }

            $this->set('eventtypearray', $eventtypearr);
            $query .= " And (requirement.event_type = $eventtype )";
         }

         if (!empty($this->request->query['country_id'])) {
            $country_id = $this->request->query['country_id'];
            $query .= " And (requirement.country_id = '$country_id')";
         }

         if (!empty($this->request->query['state_id'])) {
            $state_id = $this->request->query['state_id'];
            $query .= " And (requirement.state_id='$state_id')";
         }

         if (!empty($this->request->query['city_id'][0]) && $this->request->query['city_id'] != 0) {
            for ($i = 0; $i < count($this->request->query['city_id']); $i++) {
               if ($i == 0) {
                  $city_id = "'" . $this->request->query['city_id'][$i] . "'";
               } else {
                  $city_id .= " OR requirement.city_id = '" . $this->request->query['city_id'][$i] . "'";
               }
            }
            $query .= " And (requirement.city_id = $city_id)";
         }

         if (!empty($this->request->query['latitude']) && $this->request->query['longitude']) {
            if ($this->request->query['unit'] == "" || $this->request->query['within'] == "") {
               $lat = $this->request->query['latitude'];
               $log = $this->request->query['longitude'];
               $query .= " And (requirement.latitude='$lat' And requirement.longitude='$log')";
            }
         }

         if ($this->request->query['unit'] != '' && $this->request->query['within'] != '') {
            $this->set('targetlocation', $this->request->query['locationlat']);
            $this->set('targetwithin', $this->request->query['within']);
         }

         if (!empty($this->request->query['role_id'])) {
            $role = $this->request->query['role_id'];
            if ($this->request->query['role_id'] != 0) {
               $query .= " And( users.role_id='$role')";
            }
         }

         if (!empty($this->request->query['recname'])) {
            $recname = $this->request->query['recname'];
            $query .= " And( users.user_name LIKE'%$recname%')";
         }

         if (!empty($this->request->query['time'])) {
            $recname = $this->request->query['time'];
            if ($recname != 'a') {
               $query .= " AND ( requirement.continuejob = '$recname')";
            }
         }


         // <<<<<<<<<<<<<<<<<<<<<<<<

         // If only event_from_date is given
         if (!empty($this->request->query['event_from_date']) && empty($this->request->query['event_to_date'])) {
            $eventFromDate = date("Y-m-d H:i:s", strtotime($this->request->query['event_from_date']));

            $query .= " AND (
            (requirement.continuejob = 'Y' AND requirement.last_date_app >= '$eventFromDate') OR
            (requirement.continuejob = 'N' AND requirement.event_from_date >= '$eventFromDate')
         )";
         }

         // If only event_to_date is given
         if (!empty($this->request->query['event_to_date']) && empty($this->request->query['event_from_date'])) {
            $eventToDate = date("Y-m-d H:i:s", strtotime($this->request->query['event_to_date']));

            $query .= " AND (
            (requirement.continuejob = 'Y' AND requirement.last_date_app <= '$eventToDate') OR
            (requirement.continuejob = 'N' AND requirement.event_to_date <= '$eventToDate')
         )";
         }


         if (!empty($this->request->query['event_to_date']) && !empty($this->request->query['event_from_date'])) {
            $eventFromDate = date("Y-m-d H:i:s", strtotime($this->request->query['event_from_date']));
            $eventToDate = date("Y-m-d H:i:s", strtotime($this->request->query['event_to_date']));

            $query .= " AND (
                      (requirement.continuejob = 'Y' AND requirement.last_date_app BETWEEN '$eventFromDate' AND '$eventToDate') OR
                      (requirement.continuejob = 'N' AND requirement.event_from_date >= '$eventFromDate' AND requirement.event_to_date <= '$eventToDate')
                  )";
         }


         // Only From Date provided
         if (!empty($this->request->query['talent_required_fromdate']) && empty($this->request->query['talent_required_todate'])) {
            $fromDate = date("Y-m-d H:i:s", strtotime($this->request->query['talent_required_fromdate']));

            $query .= " AND (
               (requirement.continuejob = 'Y' AND requirement.last_date_app >= '$fromDate') OR
               (requirement.continuejob = 'N' AND requirement.talent_required_fromdate >= '$fromDate')
            )";
         }

         // Only To Date provided
         if (!empty($this->request->query['talent_required_todate']) && empty($this->request->query['talent_required_fromdate'])) {
            $toDate = date("Y-m-d H:i:s", strtotime($this->request->query['talent_required_todate']));

            $query .= " AND (
               (requirement.continuejob = 'Y' AND requirement.last_date_app <= '$toDate') OR
               (requirement.continuejob = 'N' AND requirement.talent_required_todate <= '$toDate')
            )";
         }

         // Both From and To Dates provided
         if (!empty($this->request->query['talent_required_fromdate']) && !empty($this->request->query['talent_required_todate'])) {
            $fromDate = date("Y-m-d H:i:s", strtotime($this->request->query['talent_required_fromdate']));
            $toDate = date("Y-m-d H:i:s", strtotime($this->request->query['talent_required_todate']));

            $query .= " AND (
               (requirement.continuejob = 'Y' AND requirement.last_date_app BETWEEN '$fromDate' AND '$toDate') OR
               (requirement.continuejob = 'N' AND requirement.talent_required_fromdate >= '$fromDate' AND requirement.talent_required_todate <= '$toDate')
            )";
         }

         // >>>>>>>>>>>>>>>>>>>>>>>>>>>>        


         // if (!empty($this->request->query['last_date_app']) && empty($this->request->query['last_date_appbefore'])) {
         //    $last_date_app = date("Y-m-d H:s:i", strtotime($this->request->query['last_date_app']));
         //    $query .= "And (requirement.last_date_app >= '$last_date_app')";
         // }

         if (!empty($this->request->query['last_date_app']) && !empty($this->request->query['last_date_appbefore'])) {
            $last_date_app = date("Y-m-d H:i:s", strtotime($this->request->query['last_date_app']));
            $last_date_appbefore = date("Y-m-d H:i:s", strtotime($this->request->query['last_date_appbefore']));
            $query .= " AND (requirement.last_date_app BETWEEN '$last_date_app' AND '$last_date_appbefore')";
         } elseif (!empty($this->request->query['last_date_app'])) {
            $last_date_app = date("Y-m-d H:i:s", strtotime($this->request->query['last_date_app']));
            $query .= " AND (requirement.last_date_app >= '$last_date_app')";
         } elseif (!empty($this->request->query['last_date_appbefore'])) {
            $last_date_appbefore = date("Y-m-d H:i:s", strtotime($this->request->query['last_date_appbefore']));
            $query .= " AND (requirement.last_date_app <= '$last_date_appbefore')";
         }
         //   pr($query);exit;


         // if (!empty($this->request->query['last_date_appbefore']) && empty($this->request->query['last_date_app'])) {
         //    $last_date_app = date("Y-m-d H:s:i", strtotime($this->request->query['last_date_appbefore']));
         //    $query .= "and (requirement.last_date_app <= '$last_date_app')";
         // }

         // if (!empty($this->request->query['last_date_appbefore']) && !empty($this->request->query['last_date_app'])) {
         //    $last_date_app = date("Y-m-d H:s:i", strtotime($this->request->query['last_date_app']));
         //    $last_date_appbefore = date("Y-m-d H:s:i", strtotime($this->request->query['last_date_appbefore']));
         //    $query .= "and (requirement.last_date_app <= '$last_date_app' and requirement.last_date_app>='$last_date_appbefore' )";
         // }

         if ($this->request->query['checkboxbefore']) {
            if ($this->request->query['checkboxafter']) {
               $last_date_app = date("Y-m-d H:s:i", strtotime($this->request->query['last_date_app']));
               $last_date_appbefore = date("Y-m-d H:s:i", strtotime($this->request->query['last_date_appbefore']));
               $query .= "And (requirement.last_date_app >= '$date' and  requirement.last_date_app<='$last_date_appbefore' )";
            }
         }
      }
      // Advance Job Search End

      // pr($_SESSION['advancejobsearch']);
      // pr($_SESSION['advancejobsearch']); die;
      // Advance Search Plus Refine
      if ($_SESSION['advancejobsearch'] && $this->request->query['refine'] == 1) {

         if ($_SESSION['advancejobsearch']['skill']) {

            $skill = $_SESSION['advancejobsearch']['skill'];
            $skillarray = explode(",", $skill);
            for ($i = 0; $i < count($skillarray); $i++) {
               if (count($skillarray) == 1) {
                  $skillcheck .= "requirement_vacancy.telent_type like '$skillarray[$i]'";
               } elseif ($i == 0) {
                  $skillcheck .= "requirement_vacancy.telent_type like '$skillarray[$i]'";
               } else if ($i == count($skillarray) - 1) {
                  $skillcheck .= " or requirement_vacancy.telent_type like '$skillarray[$i]'";
               } else {
                  $skillcheck .= " or requirement_vacancy.telent_type like '$skillarray[$i]'";
               }
            }

            $query .= "and (" . $skillcheck . ")";
         } else {
            $skillcheck = "";
         }

         if (!empty($_SESSION['advancejobsearch']['keyword'])) {
            $title = $_SESSION['advancejobsearch']['keyword'];

            // $query .= " And ( requirement.title Like '%$title%'  or talent_requirement_description Like '%$title%'  or skill_type.name Like '%$title%' or eventtypes.name Like '%$title%' ) ";

            $title = strtolower(trim($title));

            $query .= " AND (
               LOWER(`title`) LIKE '%$title%' OR 
               LOWER(talent_requirement_description) LIKE '%$title%' OR 
               LOWER(requirement.location) LIKE '%$title%' OR 
               LOWER(skill_type.name) LIKE '%$title%' OR 
               LOWER(eventtypes.name) LIKE '%$title%'
            )";
         }


         if (!empty($_SESSION['advancejobsearch']['gender'])) {
            if (in_array("a", $_SESSION['advancejobsearch']['gender'])) {
            } else {
               for ($i = 0; $i < count($_SESSION['advancejobsearch']['gender']); $i++) {
                  if ($i == 0) {
                     $sex = "'" . $_SESSION['advancejobsearch']['gender'][$i] . "'";
                  } else {
                     $sex .= " OR requirement_vacancy.sex='" . $_SESSION['advancejobsearch']['gender'][$i] . "'";
                  }
               }
               $query .= " And (requirement_vacancy.sex=$sex )";
            }
         }

         if (!empty($_SESSION['advancejobsearch']['Paymentfequency'])) {
            $paymentselectedarray = $_SESSION['advancejobsearch']['Paymentfequency'];
            $count = count($_SESSION['advancejobsearch']['Paymentfequency']);
            for ($i = 0; $i < count($_SESSION['advancejobsearch']['Paymentfequency']); $i++) {
               if ($i == 0) {
                  $Paymentfequency = "'" . $_SESSION['advancejobsearch']['Paymentfequency'][$i] . "'";
               } else {
                  $Paymentfequency .= " OR requirement_vacancy.payment_freq= '" . $_SESSION['advancejobsearch']['Paymentfequency'][$i] . "'";
               }
            }
            $query .= "And (requirement_vacancy.payment_freq=$Paymentfequency)";
         }

         if (!empty($_SESSION['advancejobsearch']['eventtype'])) {
            $eventtypearr = $_SESSION['advancejobsearch']['eventtype'];
            $newarray = explode(",", $_SESSION['advancejobsearch']['eventtype']);
            for ($i = 0; $i < count($newarray); $i++) {
               if ($i == 0) {
                  $eventtype = "'" . $newarray[$i] . "'";
               } else {
                  $eventtype .= " OR requirement.event_type='" . $newarray[$i] . "'";
               }
            }

            $this->set('eventtypearray', $eventtypearr);
            $query .= " And (requirement.event_type=$eventtype )";
         }

         if (!empty($_SESSION['advancejobsearch']['country_id'])) {
            $country_id = $_SESSION['advancejobsearch']['country_id'];
            $query .= " And (requirement.country_id='$country_id')";
         }

         if (!empty($_SESSION['advancejobsearch']['state_id'])) {
            $state_id = $_SESSION['advancejobsearch']['state_id'];
            $query .= " And (requirement.state_id='$state_id')";
         }

         if (!empty($_SESSION['advancejobsearch']['city_id'][0]) && $_SESSION['advancejobsearch']['city_id'] != 0) {
            for ($i = 0; $i < count($_SESSION['advancejobsearch']['city_id']); $i++) {
               if ($i == 0) {
                  $city_id = "'" . $_SESSION['advancejobsearch']['city_id'][$i] . "'";
               } else {
                  $city_id .= " OR requirement.city_id='" . $_SESSION['advancejobsearch']['city_id'][$i] . "'";
               }
            }
            $query .= " And (requirement.city_id=$city_id)";
         }

         if (!empty($_SESSION['advancejobsearch']['latitude']) && $_SESSION['advancejobsearch']['longitude']) {
            $lat = $_SESSION['advancejobsearch']['latitude'];
            $log = $_SESSION['advancejobsearch']['longitude'];
            if ($_SESSION['advancejobsearch']['within'] == '') {
               $query .= " And (requirement.latitude='$lat' And requirement.longitude='$log')";
            }
         }

         if ($_SESSION['advancejobsearch']['unit'] != '' && $_SESSION['advancejobsearch']['within'] != '') {
            $within = $_SESSION['advancejobsearch']['within'];
         }

         if (!empty($_SESSION['advancejobsearch']['role_id'])) {
            $role = $_SESSION['advancejobsearch']['role_id'];
            if ($_SESSION['advancejobsearch']['role_id'] != 0) {
               $query .= " And( users.role_id='$role')";
            }
         }

         if (!empty($_SESSION['advancejobsearch']['recname'])) {
            $recname = strtolower($_SESSION['advancejobsearch']['recname']); // Convert input to lowercase
            $query .= " And (LOWER(users.user_name) LIKE '%$recname%')";
         }


         if (!empty($_SESSION['advancejobsearch']['time'])) {
            $recname = $_SESSION['advancejobsearch']['time'];
            if ($recname != 'a') {
               $query .= " And( requirement.continuejob = '$recname')";
            }
         }

         if (!empty($_SESSION['advancejobsearch']['event_from_date']) && empty($_SESSION['advancejobsearch']['event_to_date'])) {
            $event_from_date = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['event_from_date']));
            // pr($event_from_date);exit;
            $query .= " And (requirement.event_from_date = '$event_from_date')";
         }


         if (!empty($_SESSION['advancejobsearch']['event_to_date']) && empty($_SESSION['advancejobsearch']['event_from_date'])) {
            $event_to_date = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['event_to_date']));
            $query .= " And (requirement.event_to_date = '$event_to_date')";
         }

         if (!empty($_SESSION['advancejobsearch']['event_to_date']) && !empty($_SESSION['advancejobsearch']['event_from_date'])) {
            $event_to_date = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['event_to_date']));
            $event_from_date = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['event_from_date']));
            $query .= " And (requirement.event_from_date >= '$event_from_date' And requirement.event_to_date <= '$event_to_date') ";
         }

         if (!empty($_SESSION['advancejobsearch']['talent_required_fromdate']) && empty($_SESSION['advancejobsearch']['talent_required_todate'])) {
            $talent_required_fromdate = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['talent_required_fromdate']));
            $query .= " And (requirement.talent_required_fromdate = '$talent_required_fromdate')";
         }

         if (!empty($_SESSION['advancejobsearch']['talent_required_todate']) && empty($_SESSION['advancejobsearch']['talent_required_fromdate'])) {
            $talent_required_todate = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['talent_required_todate']));
            $query .= " And (requirement.talent_required_todate = '$talent_required_todate')";
         }

         if (!empty($_SESSION['advancejobsearch']['talent_required_todate']) && !empty($_SESSION['advancejobsearch']['talent_required_fromdate'])) {
            $talent_required_todate = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['talent_required_todate']));
            $talent_required_fromdate = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['talent_required_fromdate']));
            $query .= " And (requirement.talent_required_fromdate >= '$talent_required_fromdate' And requirement.talent_required_todate<='$talent_required_todate' )";
         }

         if ($_SESSION['advancejobsearch']['checkboxafter'] == 1 && $_SESSION['advancejobsearch']['checkboxbefore'] != 2) {
            if (!empty($_SESSION['advancejobsearch']['last_date_app'])) {

               $last_date_app = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['last_date_app']));
               $query .= "And (requirement.last_date_app >= '$last_date_app')";
            }
         }

         if ($_SESSION['advancejobsearch']['checkboxbefore'] == 2 && $_SESSION['advancejobsearch']['checkboxafter'] != 1) {
            if (!empty($_SESSION['advancejobsearch']['last_date_appbefore'])) {
               $last_date_app = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['last_date_appbefore']));
               $query .= "And (requirement.last_date_app <= '$last_date_app')";
            }
         }

         if ($_SESSION['advancejobsearch']['checkboxbefore']) {
            if ($_SESSION['advancejobsearch']['checkboxafter']) {
               $last_date_app = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['last_date_app']));
               $last_date_appbefore = date("Y-m-d H:s:i", strtotime($_SESSION['advancejobsearch']['last_date_appbefore']));
               $query .= "And (requirement.last_date_app >= '$date' and  requirement.last_date_app<='$last_date_appbefore' )";
            }
         }
      }


      //Advance Search Plus Refine End

      $query .= " And (requirement.last_date_app >= '$date') ";
      $query .= " And (requirement.status='Y') ";
      $query .= " And (requirement.jobdelete_status='N') And (requirement.status='Y')";
      // $query .= " GROUP BY requirement.id ORDER BY order_num ASC,requirement.last_date_app DESC, requirement.id DESC";
      // $query .= " GROUP BY requirement.id ORDER BY order_num ASC, requirement.last_date_app DESC, requirement.id DESC";
      $query .= " GROUP BY requirement.id 
      ORDER BY order_num ASC, 
               FIELD(requirement.is_paid_post, 'Y', 'N'),
               requirement.user_role_id ASC,
               requirement.last_date_app ASC, 
               requirement.id DESC";

      // pr($query);

      if ($this->request->query['refine'] == 1) {
         $session = $this->request->session();
         $session->delete('Refinejobfilter');
         $this->request->session()->write('Refinejobfilter', $query);
      } else if ($this->request->query['from'] == 1) {
         $session = $this->request->session();
         $session->delete('Refinejobfilter');
         $this->request->session()->write('Refinejobfilter', $query);
      } else if (!empty(trim($this->request->query['name']))) {
         $session = $this->request->session();
         $session->delete('Refinejobfilter');
         $this->request->session()->write('Refinejobfilter', $query);
      }

      // End Advance job search parameters  

      // Refine filter query 
      if ($this->request->query['refine'] != 1) {
         $session = $this->request->session();
         $this->request->session()->write('searchparamer', $query);
      }

      $accessJobLimit = $packfeature['access_job']; // Total job search limit 2 
      $total_access_job = $packfeature['access_job_used']; // Used job search count 0
      // $total_access_job = 1;

      // Remaining limit calculate karein
      $remainingLimit = $accessJobLimit - $total_access_job;

      // pr($packfeature['id']);
      // pr($accessJobLimit);
      // pr($total_access_job);
      // pr($remainingLimit);exit;

      if ($remainingLimit <= 0) {
         $notification['notification_sender'] = $user_id;
         $notification['notification_receiver'] = $user_id;
         $notification['type'] = 'Alert'; // Alert is self notification
         $notification['content'] = 'Your job search limit is exhausted. Upgrade your profile package to unlock more job searches!';
         $noti = $this->Notification->newEntity();
         $articles = $this->Notification->patchEntity($noti, $notification);
         $this->Notification->save($articles);

         $this->Flash->error(__('Your job search limit is exhausted. Upgrade your profile package to unlock more job searches!'));
      } else if ($remainingLimit <= ($accessJobLimit * 0.5)) {

         $notification['notification_sender'] = $user_id;
         $notification['notification_receiver'] = $user_id;
         $notification['type'] = 'Alert'; // Alert is self notification
         $notification['content'] = 'Your job search limit is 50% exhausted.';
         $noti = $this->Notification->newEntity();
         $articles = $this->Notification->patchEntity($noti, $notification);
         $this->Notification->save($articles);

         // Agar 50% limit use ho chuki hai to warning dikhayein
         $this->Flash->error(__('Your job search limit is 50% exhausted.'));
      }

      if ($remainingLimit == 0 || $remainingLimit < 0) {
         $query .= " LIMIT 0";
      } else {
         // Query me remaining limit apply karein
         $query .= " LIMIT " . $accessJobLimit;
      }
      // pr($query);exit;

      // Session update karein
      $session = $this->request->session();
      $session->delete('Refinejobfilter');
      $this->request->session()->write('Refinejobfilter', $query);

      // Database se search execute karein
      $con = ConnectionManager::get('default');
      $refineparameter = $con->execute($_SESSION['searchparamer'])->fetchAll('assoc');
      $searchdata = $con->execute($query)->fetchAll('assoc');
      // pr($searchdata);
      // exit;

      $this->set('searchdata', $searchdata);

      // Agar searchdata fetch ho gaya tabhi update karein (Rupam 27-03-2025)
      // if (!empty($searchdata)) {
      //    $this->Packfeature->updateAll(
      //       ['access_job_used' => $total_access_job + count($searchdata)], // Fix for correct update syntax
      //       ['id' => $packfeature['id']]
      //    );
      // }

      $currencyarray = array();
      $payemntfaq = array();
      $talentype = array();
      $eventtype = array();
      $continue = array();

      if (!empty($this->request->query['within']) && !empty($this->request->query['locationlat'])) {
         foreach ($refineparameter as $value) {
            $value['myvalue'] = $this->get_driving_information($this->request->query['locationlat'], $value['location']);
            if ($claculationunit == "mi") {
               $dis = (int)(preg_replace("/[a-zA-Z]/", "", $value['myvalue'])) * (0.621371);
            } else {
               $dis = (int)preg_replace("/[a-zA-Z]/", "", $value['myvalue']);
            }

            if ($dis <= $this->request->query['within']) {
               $continue[] = $value['continuejob'];
               if ($date < $value['last_date_app']) {
                  $skill = $this->RequirmentVacancy->find('all')->contain(['Skill', 'Paymentfequency', 'Currency'])->where(['RequirmentVacancy.requirement_id' => $value['id']])->toArray();
                  foreach ($skill as $myvalue) {
                     $talentype[$myvalue['skill']['id']] = $myvalue['skill']['name'];
                     $salryarray[] = $myvalue['payment_amount'];
                  }

                  foreach ($skill as $myvalue) {
                     $payemntfaq[$myvalue['paymentfequency']['id']] = $myvalue['paymentfequency']['name'];
                  }

                  foreach ($skill as $myvalue) {
                     $currencyarray[$myvalue['currency']['id']] = $myvalue['currency']['name'];
                  }

                  $eventtype[$value['event_type']] = $value['eventname'];
                  $locationarray[$value['location']] = $value['location'];
               }
            }
         }
      } else {
         foreach ($refineparameter as $value) {
            $continue[] = $value['continuejob'];
            if ($date < $value['last_date_app']) {
               $skill = $this->RequirmentVacancy->find('all')->contain(['Skill', 'Paymentfequency', 'Currency'])->where(['RequirmentVacancy.requirement_id' => $value['id']])->toArray();
               foreach ($skill as $myvalue) {
                  $talentype[$myvalue['skill']['id']] = $myvalue['skill']['name'];
                  $salryarray[] = $myvalue['payment_amount'];
               }

               foreach ($skill as $myvalue) {
                  $payemntfaq[$myvalue['paymentfequency']['id']] = $myvalue['paymentfequency']['name'];
               }

               foreach ($skill as $myvalue) {
                  $currencyarray[$myvalue['currency']['id']] = $myvalue['currency']['name'];
               }

               $eventtype[$value['event_type']] = $value['eventname'];
               $locationarray[$value['location']] = $value['location'];
            }
         }
      }

      if ($this->request->query['refine'] != 1) {
         $this->set('maxi', max($salryarray));
         $this->set('mini', min($salryarray));

         $session = $this->request->session();
         $session->write('maxi', max($salryarray));

         $session = $this->request->session();
         $session->write('mini', min($salryarray));

         $this->set('selmaxi', max($salryarray));
         $this->set('selmini', min($salryarray));
      }

      $this->set('title', $title);
      $this->set('location', $locationarray);
      $this->set('currencyarray', $currencyarray);
      $this->set('payemntfaq', $payemntfaq);
      $this->set('talentype', $talentype);
      $this->set('continue', $continue);
      $this->set('time', $this->request->query['time']);
      $this->set('eventtype', array_unique($eventtype));
      $this->set('data', $this->request->query);
   }

   public function advanceJobsearch($edit = null)
   {

      // pr($_SESSION); die;
      // $session = $this->request->session();
      // $data = $session->read('advancejobsearch');
      // pr($data); 
      $this->loadModel('Skill');
      $this->loadModel('Country');
      $this->loadModel('Paymentfequency');
      $this->loadModel('Eventtype');
      $this->loadModel('City');
      $this->loadModel('State');
      if (!$edit) {
         $session = $this->request->session();
         $session->delete('advancejobsearch');
      }
      $country = $this->Country->find('list')->select(['id', 'name'])->toarray();
      $this->set('country', $country);

      $Eventtype = $this->Eventtype->find('list')->where(['Eventtype.status' => 'Y'])->select(['id', 'name'])->toarray();
      //pr($Eventtype); die;
      $this->set('Eventtype', $Eventtype);
      $Paymentfequency = $this->Paymentfequency->find('all')->select(['id', 'name'])->toarray();
      $this->set('Paymentfequency', $Paymentfequency);
      $this->set('edit', $edit);
      //  $cities = $this->City->find('list')->where(['City.state_id' =>$_SESSION['advancejobsearch']['state_id']])->toarray();
      $this->set('cities', $cities);
      $states = $this->State->find('list')->where(['State.id' => $_SESSION['advancejobsearch']['state_id']])->toarray();
      // get skill and event
      $Skill = $this->Skill->find('all')->select(['id', 'name'])->toarray();
      $this->set('Skill', $Skill);

      $eventtype = $this->Eventtype->find('all')->toarray();

      $this->set('eventtype', $eventtype);

      //  pr($states); die;
      $this->set('states', $states);
      $session = $this->request->session();
      $session->delete('Refinejobfilter');

      $user_id = $this->request->session()->read('Auth.User.id');
      if (empty($user_id)) {
         $session = $this->request->session();
         $session->delete('request_data');
         $session->write("request_data", $this->request->query);
         //return $this->redirect(['action' => 'withoutloginsearch']);
      }
   }

   public function multiplebooknow()
   {

      $this->autoRender = false;
      $this->loadModel('JobApplication');
      $this->loadModel('RequirmentVacancy');
      $this->loadModel('Profile');
      $this->loadModel('Requirement');
      unset($_SESSION['bookingalreadyask']);
      $nontalent_id = $this->request->session()->read('Auth.User.id');

      if ($this->request->is(['post', 'put'])) {

         $booknowavb = $this->bookingchecked($this->request->data['job_id'], $this->request->data['user_id']);

         $profilecount = explode(",", $this->request->data['user_id']);
         for ($i = 0; $i < count($profilecount); $i++) {
            $profilecountarrayss   = explode(",", $this->request->data['user_id']);
            foreach ($this->request->data['job_id'] as $key => $value) {
               if ($this->request->data['job_id'][$key][0] != '') {
                  $details = $this->Requirement->find('all')->where(['Requirement.id' => $key])->first();
                  if ($details['booknowdata'] >= count($profilecount)) {
                     $access = 1;
                  } else {
                     $access = 0;
                  }
                  // pr($details['booknowdata']);exit;
                  // its code change  because booking not send alert message reciver

                  if ($access == 0) {
                     $jobidcountalready = $this->JobApplication->find('all')->where(['JobApplication.job_id' => $key, 'JobApplication.user_id' => $profilecountarrayss[$i]])->count();

                     if ($jobidcountalready <= 0) {
                        // if ($details['booknowdata'] > 0) {
                        if ($details['booknowdata'] <= 0) {
                           $booknow = $this->JobApplication->newEntity();
                           $user_id = $this->request->data['user_id'];
                           $user_Datacheck['status'] = $id;
                           $user_Datacheck['user_id'] = $profilecountarrayss[$i];
                           $user_Datacheck['job_id'] = $key;
                           $user_Datacheck['nontalentuser_id'] = $nontalent_id;
                           $user_Datacheck['skill_id'] = $value[0];

                           $user_Datacheck['nontalent_aacepted_status'] = "Y";
                           $user_Datacheck['talent_accepted_status'] = "N";

                           $usersavedata = $this->JobApplication->patchEntity($booknow, $user_Datacheck);
                           $jbques = $this->JobApplication->save($usersavedata);
                           if ($jbques) {
                              $this->eventselect($jbques['id']);
                           }
                           $Package = $this->Requirement->get($key);

                           $askdata = $details['booknowdata'] - count($profilecountarrayss[$i]);
                           $Package->booknowdata   = $askdata;
                           $this->Requirement->save($Package);
                        } else {
                           $this->Flash->error(__('For this job book request limit is full'));
                        }
                     } else {
                        $invitedalbookingreadyask[] = $key;
                        $invitedalreadyask[] = $invitedalbookingreadyask;
                        $session = $this->request->session();
                        $session->write('bookingalreadyask', $invitedalreadyask);
                        $invitedalbookingselectedask[] = $profilecountarrayss[$i];
                        $session = $this->request->session();
                        $session->write('bookingselectedask', $invitedalbookingselectedask);
                     }
                  } else {
                     $this->Flash->error(__('The following profiles have already been uploaded'), ['key' => 'booking_fail']);
                  }
               }
            }
         }

         if ($_SESSION['bookingalreadyask']) {
            $r = 0;
            foreach ($_SESSION['bookingalreadyask'] as $key => $value) {
               $jobdetailalready = $this->JobApplication->find('all')->contain(['Users' => ['Profile'], 'Requirement'])->where(['JobApplication.job_id' => $value[0], 'JobApplication.user_id' => $_SESSION['bookingselectedask'][$r]])->first();
               $this->Flash->error(__('You have booked already ' . $jobdetailalready['user']['profile']['name'] . ' for ' . $jobdetailalready['requirement']['title'] . ' job'));
               $r++;
            }
         } else {

            $_SESSION['booknowinvite'] = $this->JobApplication->find('all')->where(['JobApplication.job_id' => $key])->toarray();

            if ($_SESSION['booknowinvite']) {
               $this->Flash->success(__('Booking  Sent Successfully'));

               unset($_SESSION['booknowinvite']);
            } else {
               $this->Flash->error(__('Booking Not Send.'));
            }
         }

         // return  $this->redirect(['controller' => 'profile', 'action' => 'viewprofile', $user_id]);
         // return $this->redirect('https://www.bookanartiste.com/viewprofile/159');

         $response['success'] = "bookingrequestsent";
         echo json_encode($response);
         // die;
         //  return $this->redirect(SITE_URL . '/viewprofile/' . $user_id);


      }
   }

   public function mutiplebooknow()
   {
      $this->autoRender = false;
      $this->loadModel('JobApplication');
      $this->loadModel('RequirmentVacancy');
      $this->loadModel('Requirement');
      unset($_SESSION['bookingalreadyask']);
      $nontalent_id = $this->request->session()->read('Auth.User.id');
      if ($this->request->is(['post', 'put'])) {

         // pr($this->request->data);
         // exit;
         if (count($this->request->data['job_id']) == 0) {
            $this->Flash->error(__('Please select at least one job'));
            return $this->redirect($this->request->referer());
         }

         $profilecount = explode(",", $this->request->data['user_id']);
         $totalUserCount = count($profilecount);
         $booknowavb = $this->bookingchecked($this->request->data['job_id'], $this->request->data['user_id']);
         $errorMessage = [];
         // pr($this->request->data['job_id']);exit;
         // Loop through each job ID
         foreach ($this->request->data['job_id'] as $key => $value) {
            if ($this->request->data['job_id'][$key][0] != '') {
               $details = $this->Requirement->find('all')->where(['Requirement.id' => $key])->first();
               $totalLeftLimit = $details['booknowdata'];

               // Check if the number of users exceeds the available limit *before* the inner loop
               if ($totalUserCount > $totalLeftLimit && $totalLeftLimit > 0) {
                  $errorMessage[] = $details['title'] . " Job has only " . $totalLeftLimit . " slots available. You are trying to book for " . $totalUserCount . " users.";
                  // Break the loop for this job if the limit is exceeded.
                  continue; // Move on to the next job
               }

               for ($i = 0; $i < $totalUserCount; $i++) {
                  $profilecountarrayss = explode(",", $this->request->data['user_id']);

                  $jobidcountalready = $this->JobApplication->find('all')->where(['JobApplication.job_id' => $key, 'JobApplication.user_id' => $profilecountarrayss[$i]])->count();

                  if ($totalLeftLimit > 0 && $jobidcountalready == 0) {
                     $booknow = $this->JobApplication->newEntity();
                     $user_id = $this->request->data['user_id'];
                     $user_Datacheck['status'] = $id;
                     $user_Datacheck['user_id'] = $profilecountarrayss[$i];
                     $user_Datacheck['job_id'] = $key;
                     $user_Datacheck['nontalentuser_id'] = $nontalent_id;
                     $user_Datacheck['skill_id'] = $value[0];

                     $user_Datacheck['nontalent_aacepted_status'] = "Y";
                     $user_Datacheck['talent_accepted_status'] = "N";

                     $usersavedata = $this->JobApplication->patchEntity($booknow, $user_Datacheck);
                     $jbques = $this->JobApplication->save($usersavedata);
                     if ($jbques) {
                        $this->eventselect($jbques['id']);
                     }
                     $Package = $this->Requirement->get($key);
                     $askdata = $totalLeftLimit - 1;
                     $Package->booknowdata = $askdata;
                     $this->Requirement->save($Package);
                  } else {
                     if ($totalLeftLimit == 0) {
                        $errorMessage[] = $details['title'] . " Job is already full";
                     } else {
                        $jobdetailalready = $this->JobApplication->find('all')->contain(['Users' => ['Profile'], 'Requirement'])->where(['JobApplication.job_id' => $key, 'JobApplication.user_id' => $profilecountarrayss[$i]])->first();
                        if ($jobdetailalready) { // Check if $jobdetailalready is not null
                           $errorMessage[] = 'You have already booked ' . $jobdetailalready['user']['profile']['name'] . ' for ' . $jobdetailalready['requirement']['title'] . ' Job';
                        } else {
                           $errorMessage[] = 'An error occurred while checking your booking status.'; // Handle the case where the booking record is not found.
                        }
                     }
                  }
               }
            }
         }


         // pr($errorMessage);exit;

         if (count($errorMessage) > 0) {
            foreach ($errorMessage as $errorKey => $errMessage) {
               $this->Flash->error(__($errMessage));
            }
         } else {
            $_SESSION['booknowinvite'] = $this->JobApplication->find('all')->where(['JobApplication.job_id' => $key])->toarray();
            if ($_SESSION['booknowinvite']) {
               $this->Flash->success(__('Booking Sent Successfully'));
               unset($_SESSION['booknowinvite']);
            } else {
               $this->Flash->error(__('Booking Not Send.'));
            }
         }
         $response['success'] = "bookingrequestsent";
      } else {
         // invalid request flash message
         $this->Flash->error(__('Invalid Request'));
      }
      return $this->redirect($this->request->referer());
   }

   public function eventselect($id)
   {
      $this->autoRender = false;
      $this->loadModel('JobApplication');
      $this->loadModel('Calendar');
      $this->loadModel('Eventtype');
      $bookingreceived = $this->JobApplication->find('all')->contain(['Skill', 'Requirement' => ['Eventtype']])->where(['JobApplication.id' => $id])->first();
      //pr($bookingreceived); die;
      $eventfrom = date('Y-m-d H:i', strtotime($bookingreceived['requirement']['event_from_date']));
      $eventto = date('Y-m-d H:i', strtotime($bookingreceived['requirement']['event_to_date']));
      $job_id = $bookingreceived['job_id'];
      $title = $bookingreceived['requirement']['title'];
      $location = $bookingreceived['requirement']['location'];
      $eventtype = $bookingreceived['requirement']['eventtype']['name'];
      $req_dis = $bookingreceived['requirement']['talent_requirement_description'];
      $user_id = $bookingreceived['user_id'];
      $type = "EV";
      $calendarrec = $this->Calendar->find('all')->where(['Calendar.event_id' => $job_id])->count();

      if ($calendarrec > 0) {
      } else {
         $proff = $this->Calendar->newEntity();
         $this->request->data['from_date'] = $eventfrom;
         $this->request->data['to_date'] = $eventto;
         $this->request->data['type'] = $type;
         $this->request->data['user_id'] = $user_id;
         $this->request->data['event_id'] = $job_id;
         $this->request->data['title'] = $title;
         $this->request->data['location'] = $location;
         $this->request->data['eventtype'] = $eventtype;
         $this->request->data['description'] = $req_dis;
         $eventadd = $this->Calendar->patchEntity($proff, $this->request->data);
         $this->Calendar->save($eventadd);
      }
   }

   public function bookingchecked($job_id, $user_idcount)
   {
      $this->loadModel('RequirmentVacancy');
      $this->loadModel('Requirement');
      $this->loadModel('JobApplication');
      $profilecount   = explode(",", $user_idcount);
      for ($i = 0; $i < count($profilecount); $i++) {
         foreach ($job_id as $key => $value) {

            if ($job_id[$key][0] != '') {
               $details = $this->Requirement->find('all')->where(['Requirement.id' => $key])->first();

               $jobidcountalready = $this->JobApplication->find('all')->where(['JobApplication.job_id' => $key, 'JobApplication.user_id' => $profilecount[$i]])->count();

               if (count($profilecount) <= $details['booknowdata'] && $jobidcountalready <= 0) {
                  $invitedbook[] = $key;
                  $session = $this->request->session();
                  $session->write('booknowinvite', $invitedbook);
               } else {
                  $refernamenotbook = $key;
                  $invitednotbook[$refernamenotbook] = $value[0];
                  $session = $this->request->session();
                  $session->write('booknownotinvite', $invitednotbook);
               }
            }
         }

         $bookingnowinvitesss['profile'] = $user_idcount;
         $session = $this->request->session();
         $session->write('bookingselectedprofile', $bookingnowinvitesss);
      }
   }

   // public function bookingchecked($job_id, $user_idcount)
   // {
   //    $this->loadModel('RequirmentVacancy');
   //    $this->loadModel('Requirement');
   //    $this->loadModel('JobApplication');
   //    $profilecount   = explode(",", $user_idcount);
   //    for ($i = 0; $i < count($profilecount); $i++) {
   //       foreach ($job_id as $key => $value) {

   //          if ($job_id[$key][0] != '') {
   //             //$details = $this->RequirmentVacancy->find('all')->contain(['Requirement'])->where(['RequirmentVacancy.requirement_id'=>$key,'RequirmentVacancy.telent_type'=>$value[0]])->first();
   //             //pr($details); die;
   //             $details = $this->Requirement->find('all')->where(['Requirement.id' => $key])->first();
   //             //$jobidcount=$this->JobApplication->find('all')->where(['JobApplication.job_id'=>$key,'JobApplication.skill_id'=>$value[0]])->count();
   //             $jobidcountalready = $this->JobApplication->find('all')->where(['JobApplication.job_id' => $key, 'JobApplication.user_id' => $profilecount[$i]])->count();

   //             //if($jobidcount < $details['number_of_vacancy'] && count($profilecount) <= $details['number_of_vacancy'] && $jobidcountalready<=0  ){
   //             if (count($profilecount) <= $details['booknowdata'] && $jobidcountalready <= 0) {

   //                $invitedbook[] = $key;
   //                $session = $this->request->session();
   //                $session->write('booknowinvite', $invitedbook);
   //             } else {
   //                $refernamenotbook = $key;
   //                $invitednotbook[$refernamenotbook] = $value[0];
   //                $session = $this->request->session();
   //                $session->write('booknownotinvite', $invitednotbook);
   //             }
   //          }
   //       }

   //       $bookingnowinvitesss['profile'] = $user_idcount;
   //       $session = $this->request->session();
   //       $session->write('bookingselectedprofile', $bookingnowinvitesss);
   //    }
   // }

   public function bookingquoterpeat()
   {

      $this->loadModel('JobApplication');
      $this->loadModel('RequirmentVacancy');
      $this->loadModel('Requirement');
      $this->autoRender = false;
      $nontalent_id = $this->request->session()->read('Auth.User.id');
      $profilecount   = explode(",", $this->request->data['jobselectedprofile']);

      for ($i = 0; $i < count($profilecount); $i++) {
         $profilecountarrayss   = explode(",", $this->request->data['jobselectedprofile']);
         foreach ($this->request->data['job_idss'] as $key => $value) {
            if ($this->request->data['job_idss'][$key][0] != '') {
               $details = $this->Requirement->find('all')->where(['Requirement.id' => $key])->first();
               //	$details = $this->RequirmentVacancy->find('all')->contain(['Requirement'])->where(['RequirmentVacancy.requirement_id'=>$key,'RequirmentVacancy.telent_type'=>$value[0]])->first();
               $jobidcount = $this->JobApplication->find('all')->where(['JobApplication.job_id' => $key, 'JobApplication.skill_id' => $value[0]])->count();
               $jobidcountalready = $this->JobApplication->find('all')->where(['JobApplication.job_id' => $key, 'JobApplication.user_id' => $profilecount[$i]])->count();
               if ($jobidcountalready <= 0) {
                  if ($details['booknowdata']) {

                     $JobApplication = $this->JobApplication->newEntity();
                     $user_Datacheck['status'] = $id;
                     $user_Datacheck['user_id'] = $profilecountarrayss[$i];
                     $user_Datacheck['job_id'] = $key;
                     $user_Datacheck['nontalent_id'] =   $nontalent_id;
                     $user_Datacheck['skill_id'] = $value[0];
                     $user_Datacheck['nontalent_aacepted_status'] = "Y";
                     $user_Datacheck['talent_accepted_status'] = "N";
                     $usersavedata = $this->JobApplication->patchEntity($JobApplication, $user_Datacheck);
                     $jbques = $this->JobApplication->save($usersavedata);
                     $Package = $this->Requirement->get($key);

                     $askdata = $details['booknowdata'] - count($profilecountarrayss[$i]);
                     $Package->booknowdata   = $askdata;
                     $this->Requirement->save($Package);
                  }
               } else {
                  $invitedalbookingreadyask[] = $key;
                  $session = $this->request->session();
                  $session->write('bookingalreadyask', $invitedalbookingreadyask);

                  $invitedalbookingselectedask[] = $profilecountarrayss[$i];
                  $session = $this->request->session();
                  $session->write('bookingselectedask', $invitedalbookingselectedask);
               }
            }
         }
      }

      if ($_SESSION['bookingalreadyask']) {
         $r = 0;
         foreach ($_SESSION['bookingalreadyask'] as $key => $value) {
            //'JobQuote.user_id'=>$profilecountarray[$n]
            $jobdetailalready = $this->JobApplication->find('all')->contain(['Users' => ['Profile', 'Professinal_info'], 'Skill', 'Requirement'])->where(['JobApplication.job_id' => $value, 'JobApplication.user_id' => $_SESSION['bookingselectedask'][$r]])->first();

            $this->Flash->error(__('You have booked already ' . $jobdetailalready['user']['profile']['name'] . ' for ' . $jobdetailalready['requirement']['title'] . ' job'));

            $r++;
         }
      }
      unset($_SESSION['booknowinvite']);
      unset($_SESSION['booknownotinvite']);
      unset($_SESSION['bookingselectedprofile']);


      $this->redirect(Router::url($this->referer(), true));
   }

   // this fucntion for save multiple ask quote 
   public function mutipleaskQuote($invited = null)
   {
      // pr($this->request->data);exit;
      $totalJobid = count($this->request->data['job_id']);
      // return if not choose any job 
      if ($totalJobid == 0) {
         $this->Flash->error(__('Please select at least one job'));
         return $this->redirect(Router::url($this->referer(), true));
      }
      // pr($_SESSION['askquoteinvite']);exit;
      unset($_SESSION['askquoteinvitealreadyask']);
      unset($_SESSION['askquoteinvite']);

      $this->autoRender = false;
      $this->loadModel('Requirement');
      $this->loadModel('JobQuote');
      $nontalentuser_id = $this->request->session()->read('Auth.User.id');
      if ($this->request->is(['post', 'put'])) {

         // pr($this->request->data);exit;

         $this->request->data['user_id'];
         $profilecount = explode(",", $this->request->data['user_id']);
         $user_ids = $this->request->data['user_id'];


         $askquoteavb = $this->askquotechecked($this->request->data['job_id'], $user_ids);
         // pr($askquoteavb);
         // exit;
         for ($i = 0; $i < count($profilecount); $i++) {
            $profilecountarray   = explode(",", $user_ids);
            foreach ($this->request->data['job_id'] as $key => $value) {
               // pr($key);
               // pr($value[0]);exit;
               if ($this->request->data['job_id'][$key][0] != '') {
                  $details = $this->Requirement->find('all')->where(['Requirement.id' => $key])->first();
                  if ($details['askquoteactualdata'] >= count($profilecount)) {
                     $access = 1;
                  } else {
                     $access = 0;
                  }

                  if ($access == 1) {
                     $jobidcount = $this->JobQuote->find('all')->where(['JobQuote.job_id' => $key, 'JobQuote.user_id' => $profilecountarray[$i]])->count();

                     if ($jobidcount <= 0) {
                        if ($details['askquotedata'] > 0) {
                           $JobQuote = $this->JobQuote->newEntity();
                           $user_Datacheck['status'] = $id;
                           $user_Datacheck['user_id'] = $profilecountarray[$i];
                           $user_Datacheck['job_id'] = $key;
                           $user_Datacheck['nontalentuser_id'] = $nontalentuser_id;
                           $user_Datacheck['skill_id'] = $value[0];
                           $usersavedata = $this->JobQuote->patchEntity($JobQuote, $user_Datacheck);
                           $jbques = $this->JobQuote->save($usersavedata);
                           $Package = $this->Requirement->get($key);
                           $askdata = $details['askquotedata'] - count($profilecountarray[$i]);
                           $Package->askquotedata = $askdata;
                           $this->Requirement->save($Package);
                        }
                     } else {
                        $refernamealreadyask = $key;
                        $invitedalreadyask[] = $refernamealreadyask;
                        $session = $this->request->session();
                        $session->write('askquoteinvitealreadyask', $invitedalreadyask);
                     }
                  } else {
                     $this->Flash->error(__('The following profiles have already been uploaded'), ['key' => 'job_fail']);
                  }
               }
            }
         }

         //message for ask quote already
         if ($_SESSION['askquoteinvitealreadyask']) {

            $n = 0;
            foreach ($_SESSION['askquoteinvitealreadyask'] as $key => $value) {
               $profilecountarray   = explode(",", $_SESSION['jobselectedprofile']['profile']);
               $jobdetailalready = $this->JobQuote->find('all')->contain(['Users' => ['Profile', 'Professinal_info'], 'Skill', 'Requirement'])->where(['JobQuote.job_id' => $value, 'JobQuote.user_id' => $profilecountarray[$n]])->first();
               $this->Flash->error(__('You have already asked for quote from ' . $jobdetailalready['user']['profile']['name'] . ' for ' . $jobdetailalready['requirement']['title'] . ' on ' . date('Y-m-d h:m: A', strtotime($jobdetailalready['created']))));
               $n++;
            }
         }


         $x = 0;
         foreach ($this->request->data['job_id'] as $key => $value) {
            if ($this->request->data['job_id'][$key][0] != '') {
               $profilecount   = explode(",", $this->request->data['user_id']);
               $jobidcountnew = $this->JobQuote->find('all')->where(['JobQuote.job_id' => $key])->toarray();
               $actauldatasakqquotereomve = $jobidcountnew[0]['job_id'];
               $actauldatasakqquotereomveddd[$actauldatasakqquotereomve] = count($jobidcountnew);
               $session = $this->request->session();
               $session->write('actauldatasakqquotereomvess', $actauldatasakqquotereomveddd);

               if ($jobidcountnew <= 0 || $_SESSION['askquoteinvite']) {
                  $details = $this->Requirement->find('all')->where(['Requirement.id' => $key])->first();
                  if ($details['askquoteactualdata'] >= count($profilecount)) {
                     $Package = $this->Requirement->get($key);
                     $askdata = $details['askquoteactualdata'] - count($_SESSION['askquoteinvite']);
                     $Package->askquoteactualdata = $askdata;
                     $Package->askquotedata   = $askdata;
                     $this->Requirement->save($Package);
                  }
               }
            }
            $x++;
         }

         if ($_SESSION['askquoteinvite']) {
            $this->Flash->success(__('Quote Request Sent Successfully'));
            unset($_SESSION['askquoteinvite']);
         } else {
            $this->Flash->error(__('Quote Request Not Sent'));
         }
         $this->redirect(Router::url($this->referer(), true));
      }
   }

   public function askquotechecked($job_id, $user_idcount)
   {
      $this->loadModel('Requirement');
      $this->loadModel('JobQuote');
      $profilecount   = explode(",", $user_idcount);
      // pr($this->request->data);
      for ($i = 0; $i < count($profilecount); $i++) {
         foreach ($job_id as $key => $value) {

            if ($job_id[$key][0] != '') {
               $details = $this->Requirement->find('all')->where(['Requirement.id' => $key])->first();
               $jobidcount = $this->JobQuote->find('all')->where(['JobQuote.job_id' => $key, 'JobQuote.user_id' => $profilecount[$i]])->count();

               if (count($profilecount) <= $details['askquotedata'] &&  $jobidcount <= 0) {
                  $invited[] = $key;
                  $session = $this->request->session();
                  $session->write('askquoteinvite', $invited);
               } else {
                  $refernamess = $key;
                  $invitedss[$refernamess] = $value[0];
                  $session = $this->request->session();
                  $session->write('askquotenotinvite', $invitedss);
               }
            }
         }
      }
      $invitedsssss['profile'] = $user_idcount;
      $session = $this->request->session();
      $session->write('jobselectedprofile', $invitedsssss);
   }

   public function askquoterpeat()
   {
      $this->autoRender = false;
      $this->loadModel('Requirement');
      $this->loadModel('JobQuote');
      $nontalentuser_id = $this->request->session()->read('Auth.User.id');
      $profilecount   = explode(",", $this->request->data['jobselectedprofile']);
      //	pr($this->request->data); die;

      for ($i = 0; $i < count($profilecount); $i++) {
         $profilecountarray   = explode(",", $this->request->data['jobselectedprofile']);
         foreach ($this->request->data['job_idss'] as $key => $value) {
            $jobidcount = $this->JobQuote->find('all')->where(['JobQuote.job_id' => $key, 'JobQuote.user_id' => $profilecountarray[$i]])->count();
            if ($jobidcount <= 0) {
               if ($this->request->data['job_idss'][$key][0] != '') {
                  $details = $this->Requirement->find('all')->where(['Requirement.id' => $key])->first();
                  if ($details['askquotedata'] > 0) {
                     $JobQuote = $this->JobQuote->newEntity();
                     $user_id = $this->request->data['user_id'];
                     $user_Datacheck['status'] = $id;
                     $user_Datacheck['user_id'] = $profilecountarray[$i];
                     $user_Datacheck['job_id'] = $key;
                     $user_Datacheck['nontalentuser_id'] = $nontalentuser_id;
                     $user_Datacheck['skill_id'] = $value[0];
                     $usersavedata = $this->JobQuote->patchEntity($JobQuote, $user_Datacheck);
                     $jbques = $this->JobQuote->save($usersavedata);
                     $Package = $this->Requirement->get($key);
                     $askdata = $details['askquotedata'] - count($profilecountarray[$i]);
                     $askdatasss = $details['askquoteactualdata'] - count($profilecountarray[$i]);
                     $Package->askquoteactualdata   = $askdatasss;
                     $Package->askquotedata   = $askdata;
                     $this->Requirement->save($Package);
                  }
               }
            } else {
               $refernamealreadyask = $key;
               $invitedalreadyask[] = $refernamealreadyask;
               $session = $this->request->session();
               $session->write('askquoteinvitealreadyask', $invitedalreadyask);
            }
         }
      }
      if ($_SESSION['askquoteinvitealreadyask']) {
         $n = 0;
         foreach ($_SESSION['askquoteinvitealreadyask'] as $key => $value) {
            $profilecountarray   = explode(",", $_SESSION['jobselectedprofile']['profile']);
            $jobdetailalready = $this->JobQuote->find('all')->contain(['Users' => ['Profile', 'Professinal_info'], 'Skill', 'Requirement'])->where(['JobQuote.job_id' => $value, 'JobQuote.user_id' => $profilecountarray[$n]])->first();
            $this->Flash->error(__('You have already asked for quote from ' . $jobdetailalready['user']['profile']['name'] . ' for ' . $jobdetailalready['requirement']['title'] . ' on ' . date('Y-m-d h:m A', strtotime($jobdetailalready['created']))));

            $n++;
         }
      }



      unset($_SESSION['askquoteinvite']);
      unset($_SESSION['askquotenotinvite']);
      unset($_SESSION['jobselectedprofile']);
      $this->redirect(Router::url($this->referer(), true));
   }

   // This Function for show skills
   public function skills($id = null)
   {
      $this->loadModel('Users');
      $this->loadModel('Skillset');
      $this->loadModel('Skill');
      if ($id != null) {
         $contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id, 'Skillset.status' => 'Y'])->order(['Skill.name' => 'ASC'])->toarray();
      }
      $Skill = $this->Skill->find('all')->select(['id', 'name'])->where(['Skill.status' => 'Y'])->order(['Skill.name' => 'ASC'])->toarray();
      $this->set('Skill', $Skill);
      $this->set('skillset', $contentadminskillset);


      if (!empty($this->request->data['skill']) && $this->request->data['skill'] != 0) {

         $skill = $this->request->data['skill'];
         $skillarray = explode(",", $skill);
         //print_r($skillarray);  die;

         for ($i = 0; $i < count($skillarray); $i++) {
            //$skillvalue=$skillarray[$i];
            if ($i == 0) {
               $skillcheck .= "requirement_vacancy.telent_type like '$skillarray[$i]'";
            } else if ($i == count($skillarray) - 1) {
               $skillcheck .= " or requirement_vacancy.telent_type like '$skillarray[$i]' and";
            } else {
               $skillcheck .= " or requirement_vacancy.telent_type like '$skillarray[$i]'";
            }
         }
         //$have.="having skill Like '%$skill%'";


      } else {
         $skillcheck = "";
      }
      $this->loadModel('Packfeature');
      $user_id = $this->request->session()->read('Auth.User.id');
      $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
      $this->set('total_elegible_skills', $packfeature['number_categories']);
   }

   public function applymultiple()
   {

      $this->loadModel('Requirement');
      $this->loadModel('Packfeature');
      if ($this->request->is(['post', 'put'])) {

         $user_id = $this->request->session()->read('Auth.User.id');

         $chekcboxcount = $this->request->data['a'];
         $chekcboxcount = $chekcboxcount + 1;

         $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();

         $applycount = $packfeature['number_of_quote_daily'] + $packfeature['number_job_application_month'] + $packfeature['number_job_application_daily'];
         $a = $this->request->data['dyid'];
         $a = $a - 1;
         $jobarray['job'][$a] = $this->request->data['jobsearch'];


         /*
         if($chekcboxcount>$packfeature['number_job_application_daily'] && $chekcboxcount<$packfeature['number_job_application_month']){
         echo "daily"; die;
         }

         if($chekcboxcount>$packfeature['number_job_application_month'] && $chekcboxcount> $packfeature['number_job_application_daily'] && $chekcboxcount>$packfeature['number_of_quote_daily']){
         echo "Ping"; die;
         }
         if($chekcboxcount>$packfeature['number_job_application_month'] && $chekcboxcount>$packfeature['number_of_quote_daily']){
         echo "Month"; die;
         } if($chekcboxcount>$packfeature['number_job_application_month'] &&  $chekcboxcount>$packfeature['number_job_application_daily'] && $chekcboxcount>$packfeature['number_of_quote_daily']){
         echo "Both"; die;
            }
         */

         $id = $this->request->data['jobsearch'];
         try {
            $details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City', 'Users', 'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']])->where(['Requirement.id' => $id, 'Requirement.status' => 'Y'])->first();
            $this->set('requirement_data', $details);


            $this->set('id', $id);
            $this->set('a', $a);
         } catch (FatalErrorException $e) {
            $this->log("Error Occured", 'error');
         }
      }
   }

   public function uncheckrespon()
   {

      $this->loadModel('Requirement');
      $this->loadModel('Packfeature');
      if ($this->request->is(['post', 'put'])) {

         $user_id = $this->request->session()->read('Auth.User.id');;
         $chekcboxcount = $this->request->data['a'];


         $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
         $applycount = $packfeature['number_of_quote_daily'] + $packfeature['number_job_application_month'] + $packfeature['number_job_application_daily'];
         $a = $this->request->data['a'];
         $jobarray['job'][$a] = $this->request->data['jobsearch'];

         if ($chekcboxcount > $packfeature['number_job_application_daily'] && $chekcboxcount < $packfeature['number_job_application_month']) {
            echo "daily";
            die;
         }
         if ($chekcboxcount > $packfeature['number_job_application_month'] && $chekcboxcount > $packfeature['number_job_application_daily'] && $chekcboxcount > $packfeature['number_of_quote_daily']) {
            echo "Ping";
            die;
         }
         if ($chekcboxcount > $packfeature['number_job_application_month'] && $chekcboxcount > $packfeature['number_of_quote_daily']) {
            echo "Month";
            die;
         }
         if ($chekcboxcount > $packfeature['number_job_application_month'] &&  $chekcboxcount > $packfeature['number_job_application_daily'] && $chekcboxcount > $packfeature['number_of_quote_daily']) {
            echo "Both";
            die;
         }

         die;
      }
   }

   public function sendquotemultiple()
   {

      $this->loadModel('Requirement');
      $this->loadModel('Packfeature');
      if ($this->request->is(['post', 'put'])) {

         $user_id = $this->request->session()->read('Auth.User.id');


         $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();

         $applycount = $packfeature['number_of_quote_daily'];

         $a = $this->request->data['a'];

         $jobarray['job'][$a] = $this->request->data['jobsearch'];

         $id = $this->request->data['jobsearch'];
         try {
            $details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City', 'Users', 'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']])->where(['Requirement.id' => $id, 'Requirement.status' => 'Y'])->first();
            $this->set('requirement_data', $details);
            $this->set('id', $id);
            $this->set('a', $a);
         } catch (FatalErrorException $e) {
            $this->log("Error Occured", 'error');
         }
      }
   }

   public function savejobs()
   {
      $this->loadModel('Savejobs');
      if ($this->request->is(['post', 'put'])) {
         $jobid = $this->request->data['jobid'];
         $savejob = $this->Savejobs->find('all')->where(['Savejobs.job_id' => $jobid])->first();
         if (empty($savejob)) {

            $Savejobsenty = $this->Savejobs->newEntity();
            $this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');
            $this->request->data['job_id'] = $jobid;
            $savejobdata = $this->Savejobs->patchEntity($Savejobsenty, $this->request->data);
            $savedjob = $this->Savejobs->save($savejobdata);
            $response = array();
            if ($savedjob) {

               $response['success'] = 1;
            }
         } else {

            $id = $savejob['id'];
            $audio = $this->Savejobs->get($id);
            $this->Savejobs->delete($audio);
            $response['success'] = 2;
         }

         echo json_encode($response);
         die;
      }
   }

   public function likejobs()
   {
      $this->autoRender = false;
      $this->loadModel('Likejobs');
      $this->loadModel('Requirement');
      if ($this->request->is(['post', 'put'])) {
         $jobid = $this->request->data['jobid'];
         $this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');
         $requirement = $this->Requirement->find('all')->where(['Requirement.id' => $jobid])->first();

         $likejob = $this->Likejobs->find('all')->where(['Likejobs.job_id' => $jobid, 'Likejobs.user_id' => $this->request->data['user_id']])->first();

         //pr($this->request->data); die;
         if (empty($likejob)) {
            //echo "test"; die;
            $Savejobsenty = $this->Likejobs->newEntity();
            $this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');
            $this->request->data['job_id'] = $jobid;
            $savejobdata = $this->Likejobs->patchEntity($Savejobsenty, $this->request->data);
            $savedjob = $this->Likejobs->save($savejobdata);
            $response = array();
            if ($savedjob) {
               $this->loadModel('Notification');
               $senderid = $this->request->session()->read('Auth.User.id');
               $recieverid = $requirement['user_id'];
               $noti = $this->Notification->newEntity();
               $notification['notification_sender'] = $senderid;
               $notification['notification_receiver'] = $recieverid;
               $notification['content'] = $jobid;
               $notification['type'] = "job like";
               $notification = $this->Notification->patchEntity($noti, $notification);
               $this->Notification->save($notification);
               $response['success'] = 1;
            }
         } else {
            $id = $likejob['id'];
            $audio = $this->Likejobs->get($id);
            $this->Likejobs->delete($audio);
            $response['success'] = 2;
         }
         $totallikes = $this->Likejobs->find('all')->where(['Likejobs.job_id' => $jobid])->count();
         $response['count'] = $totallikes;
         echo json_encode($response);
         die;
      }
   }

   public function blockjobs()
   {
      $this->loadModel('Blockjobs');
      if ($this->request->is(['post', 'put'])) {
         $jobid = $this->request->data['jobid'];
         $userId = $this->request->session()->read('Auth.User.id');
         // Check if the job is already blocked by the same user
         $Blockjobs = $this->Blockjobs->find('all')
            ->where(['Blockjobs.job_id' => $jobid, 'Blockjobs.user_id' => $userId])
            ->first();

         $response = ['success' => 0]; // Default response (no action taken)

         if (empty($Blockjobs)) {
            // If no existing entry, create a new one
            $Savejobsenty = $this->Blockjobs->newEntity();
            $data = [
               'user_id' => $userId,
               'job_id' => $jobid
            ];
            $savejobdata = $this->Blockjobs->patchEntity($Savejobsenty, $data);
            if ($this->Blockjobs->save($savejobdata)) {
               $response['success'] = 1; // Successfully blocked job
            }
         } else {
            // If an entry exists, remove it
            $this->Blockjobs->delete($Blockjobs);
            $response['success'] = 2; // Successfully unblocked job
         }

         echo json_encode($response);
         die;
      }
   }


   // public function blockjobs()
   // {
   //    $this->loadModel('Blockjobs');
   //    if ($this->request->is(['post', 'put'])) {
   //       // pr($this->request->data);exit;
   //       $jobid = $this->request->data['jobid'];
   //       $Blockjobs = $this->Blockjobs->find('all')->where(['Blockjobs.job_id' => $jobid])->first();
   //       if (empty($Blockjobs)) {
   //          $Savejobsenty = $this->Blockjobs->newEntity();
   //          $this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');
   //          $this->request->data['job_id'] = $jobid;
   //          $savejobdata = $this->Blockjobs->patchEntity($Savejobsenty, $this->request->data);
   //          $savedjob = $this->Blockjobs->save($savejobdata);
   //          $response = array();
   //          if ($savedjob) {
   //             $response['success'] = 1;
   //          }
   //       } else {
   //          $id = $Blockjobs['id'];
   //          $audio = $this->Blockjobs->get($id);
   //          $this->Blockjobs->delete($audio);
   //          $response['success'] = 2;
   //       }
   //       echo json_encode($response);
   //       die;
   //    }
   // }

   public function savejobresult()
   {
      $this->loadModel('Savejobs');

      $this->loadModel('Packfeature');
      $this->loadModel('Savejobsearch');
      $this->loadModel('Settings');
      $this->loadModel('Packfeature');
      $this->loadModel('JobApplication');
      $this->loadModel('Savejobs');
      $this->loadModel('Likejobs');
      $this->loadModel('Blockjobs');
      $setting = $this->Settings->find('all')->first();
      $this->set('ping_amt', $setting['ping_amt']);
      $user_id = $this->request->session()->read('Auth.User.id');
      $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
      $this->set('month', $packfeature['number_job_application_month']);
      $this->set('daily', $packfeature['number_job_application_daily']);
      $this->set('quote', $packfeature['number_of_quote_daily']);

      $currentdate = date('Y-m-d H:m');
      $user_id = $this->request->session()->read('Auth.User.id');
      // this query not show data
      // $Savejobsdata = $this->Savejobs->find('all')->contain(['Requirement' => ['Users', 'Eventtype']])->where(['Savejobs.user_id' => $user_id, 'Requirement.status' => 'Y', 'Requirement.jobdelete_status' => 'Y', 'Requirement.last_date_app >=' => $currentdate])->order(['Savejobs.id' => 'ASC'])->toarray();
      $Savejobsdata = $this->Savejobs->find('all')->contain(['Requirement' => ['Users', 'Eventtype']])->where(['Savejobs.user_id' => $user_id, 'Requirement.status' => 'Y', 'Requirement.jobdelete_status' => 'N', 'Requirement.last_date_app >=' => $currentdate])->order(['Savejobs.id' => 'ASC'])->toarray();

      $this->set('searchdata', $Savejobsdata);
   }

   public function saveprofile()
   {
      $this->loadModel('Saveprofile');
      if ($this->request->is(['post', 'put'])) {
         $jobid = $this->request->data['p_id'];
         $saveprfile = $this->Saveprofile->find('all')->where(['Saveprofile.p_id' => $jobid])->first();
         if (empty($saveprfile)) {

            $Saveprofilesenty = $this->Saveprofile->newEntity();
            $this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');

            $saveprofiledata = $this->Saveprofile->patchEntity($Saveprofilesenty, $this->request->data);
            $savedprofile = $this->Saveprofile->save($saveprofiledata);
            $response = array();
            if ($savedprofile) {

               $response['success'] = 1;
            }
         } else {
            $id = $saveprfile['id'];
            $audio = $this->Saveprofile->get($id);
            $this->Saveprofile->delete($audio);
            $response['success'] = 2;
         }
         echo json_encode($response);
         die;
      }
   }

   public function saveprofileresult()
   {
      $this->loadModel('Saveprofile');
      $user_id = $this->request->session()->read('Auth.User.id');
      $Savejobsdata = $this->Saveprofile->find('all')->contain(['Profile' => ['Users' => ['Skillset' => ['Skill'], 'Professinal_info']]])->where(['Saveprofile.user_id' => $user_id])->order(['Saveprofile.id' => 'ASC'])->toarray();
      $this->set('searchdata', $Savejobsdata);
   }


   public function savesearchresult()
   {

      $this->loadModel('Savejobsearch');
      if ($this->request->is(['post', 'put'])) {

         $Savejobsearch = $this->Savejobsearch->newEntity();
         if ($_SESSION['Refinejobfilter']) {

            $this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');

            $this->request->data['query'] = $_SESSION['Refinejobfilter'];

            $saveprofiledata = $this->Savejobsearch->patchEntity($Savejobsearch, $this->request->data);
            $savedprofile = $this->Savejobsearch->save($saveprofiledata);
            $response = array();
            if ($savedprofile) {
               $response['success'] = 1;
            }
         } else {
            $response['success'] = 0;
         }
         echo json_encode($response);
         die;
      }
   }

   public function refinejobshow()
   {
      $this->loadModel('Savejobsearch');
      $user_id = $this->request->session()->read('Auth.User.id');
      // $Savejobsdata = $this->Savejobsearch->find('all')->where(['Savejobsearch.user_id' => $user_id ])->order(['Savejobsearch.id' => 'DESC'])->toarray();
      // only job show
      $Savejobsdata = $this->Savejobsearch->find('all')->where(['Savejobsearch.user_id' => $user_id, 'Savejobsearch.savewhere' => 1])->order(['Savejobsearch.id' => 'DESC'])->toarray();

      $this->set('savedata', $Savejobsdata);
   }
   // public function deletesave($id)
   // {
   //    $this->loadModel('Savejobsearch');
   //    $Requirement = $this->Savejobsearch->get($id);

   //    if ($this->Savejobsearch->delete(($Requirement))) {
   //       if ($requirement['savewhere'] == 2) {
   //          $this->Flash->success(__('The Savejobsearch with id: {0} has been deleted.', h($id)));
   //          $redirecturl = 'refineprofileshow';
   //       }else if($requirement['savewhere'] == 1){
   //          $this->Flash->success(__('The Savejobsearch with id: {0} has been deleted.', h($id)));
   //          $redirecturl = 'refinejobshow';
   //       }else{
   //          return $this->redirect($this->referer());
   //       }
   //    }else{
   //       $this->Flash->error(__('The Savejobsearch could not be deleted. Please try again.'));
   //             return $this->redirect($this->referer());
   //    }
   // }
   public function deletesave($id)
   {
      $this->loadModel('Savejobsearch');
      $requirement = $this->Savejobsearch->get($id);

      if ($requirement['savewhere'] == 2) {
         $redirecturl = 'refineprofileshow';
      } else {
         $redirecturl = 'refinejobshow';
      }

      if ($this->Savejobsearch->delete($requirement)) {
         $this->Flash->success(__('The Savejobsearch with id: {0} has been deleted.', h($id)));


         return $this->redirect(['action' => $redirecturl]);
      } else {
         $this->Flash->error(__('The Savejobsearch could not be deleted. Please try again.'));
         return $this->redirect($this->referer());
      }
   }


   public function viewrefinejobs($sid)
   {

      $this->loadModel('Savejobsearch');
      $this->loadModel('Settings');
      $this->loadModel('Packfeature');
      $this->loadModel('JobApplication');
      $this->loadModel('Savejobs');
      $this->loadModel('Likejobs');
      $this->loadModel('Blockjobs');
      $setting = $this->Settings->find('all')->first();
      $this->set('ping_amt', $setting['ping_amt']);

      $id = $this->request->session()->read('Auth.User.id');
      $packlimit = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $this->request->session()->read('Auth.User.id')])->first();
      $numberofaskquoteperjob = $packlimit['ask_for_quote_request_per_job'];
      $this->set('numberofaskquoteperjob', $numberofaskquoteperjob);
      $user_id = $this->request->session()->read('Auth.User.id');
      $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
      $this->set('month', $packfeature['number_job_application_month']);
      $this->set('daily', $packfeature['number_job_application_daily']);
      $this->set('quote', $packfeature['number_of_quote_daily']);

      $this->loadModel('Requirement');
      $this->loadModel('JobQuote');
      $currentdate = date('Y-m-d H:m:s');
      $activejobs = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency']])->where(['user_id' => $id, 'Requirement.last_date_app >=' => $currentdate, 'Requirement.status' => 'Y'])->toarray();
      //pr($activejobs);
      $this->set('activejobs', $activejobs);

      $askquote = $this->JobQuote->find('all')->where(['user_id' => $userid])->toarray();
      $this->set('askquote', $askquote);
      $setting = $this->Settings->find('all')->first();
      $this->set('ping_amt', $setting['ping_amt']);
      $userid = $this->request->session()->read('Auth.User.id');
      $bookjob = $this->JobApplication->find('all')->where(['user_id' => $userid])->toarray();
      $this->set('alliedjobs', $bookjob);
      $user_id = $this->request->session()->read('Auth.User.id');
      $Savejobsdata = $this->Savejobs->find('all')->where(['Savejobs.user_id' => $user_id])->order(['Savejobs.id' => 'ASC'])->toarray();

      $likejobsdata = $this->Likejobs->find('all')->where(['Likejobs.user_id' => $user_id])->order(['Likejobs.id' => 'ASC'])->toarray();

      $Blockjobsdata = $this->Blockjobs->find('all')->where(['Blockjobs.user_id' => $user_id])->order(['Blockjobs.id' => 'ASC'])->toarray();

      $Savejobsdataviewfilter = $this->Savejobsearch->find('all')->where(['Savejobsearch.id' => $sid])->order(['Savejobsearch.id' => 'DESC'])->first()->toarray();

      $query = $Savejobsdataviewfilter['query'];
      $con = ConnectionManager::get('default');

      $searchdata = $con->execute($query)->fetchAll('assoc');


      $this->set('searchdata', $searchdata);

      $currencyarray = array();
      $payemntfaq = array();
      $talentype = array();
      $eventtype = array();
      foreach ($searchdata as $value) {
         if ($date < $value['last_date_app']) {
            $eventtype[$value['event_type']] = $value['eventname'];


            $currencyarray[$value['currencyid']] = $value['currencysname'];

            $payemntfaq[$value['pfqid']] = $value['payment_feqname'];

            $talentype[$value['skillid']] = $value['skillname'];
            $locationarray[$value['location']] = $value['location'];
         }
         $this->set('title', $title);
         $this->set('maxi', $max);
         $this->set('mini', $min);
         $this->set('location', $locationarray);
         $this->set('currencyarray', $currencyarray);
         $this->set('payemntfaq', $payemntfaq);
         $this->set('talentype', $talentype);
         $this->set('eventtype', array_unique($eventtype));
      }
   }

   public function aplyjobmultiple()
   {

      $this->loadModel('Packfeature');
      $this->loadModel('Requirement');
      $this->loadModel('JobApplication');

      if ($this->request->is(['post', 'put'])) {


         if ($this->request->data['buttonpresstype'] == 1) {
            $flag = 0;

            $response = array();
            $user_id = $this->request->session()->read('Auth.User.id');
            $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
            $applycount = $packfeature['number_job_application'];
            $packfeature_id = $packfeature['id'];

            $number_jobday = $packfeature['number_job_application_daily'];
            $number_jobmonth = $packfeature['number_job_application_month'];
            $jobapplycount = count($this->request->data['job']);
            if ($jobapplycount > $number_jobday) {


               $response['dailylimit'] = 1;
               $response['daycount'] = $number_jobday;
               echo json_encode($response);
               die;
            } elseif ($jobapplycount > $number_jobmonth) {
               $response['monthlimit'] = 1;
               $response['monthcount'] = $number_jobmonth;
               echo json_encode($response);
               die;
            }


            $id = $this->request->data['jobsearch'];

            foreach ($this->request->data['job'] as $value) {

               $details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City', 'Users', 'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']])->where(['Requirement.id' => $value, 'Requirement.status' => 'Y'])->first();


               $skill = count($details['requirment_vacancy']);
               if ($skill <= 1) {
               } else {
                  $flag = 1;
               }
            }
            try {
               foreach ($this->request->data['job'] as $value) {

                  $details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City', 'Users', 'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']])->where(['Requirement.id' => $value, 'Requirement.status' => 'Y'])->first();
                  $this->set('requirement_data', $details);

                  // $requirementvacancy = $this->RequirmentVacancy->find('all')->where(['RequirmentVacancy.requirement_id' => $job_id])->toarray();
                  // $this->set('requirementvacancy', $requirementvacancy);

                  $skill = count($details['requirment_vacancy']);


                  if ($flag == 0) {

                     $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
                     $applycount = $packfeature['number_job_application'];
                     $packfeature_id = $packfeature['id'];

                     $number_jobday = $packfeature['number_job_application_daily'];
                     $number_jobmonth = $packfeature['number_job_application_month'];

                     $this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');


                     $this->request->data['talent_accepted_status'] = "Y";
                     $this->request->data['job_id'] = $details['id'];
                     $this->request->data['skill_id'] = $details['requirment_vacancy']['0']['skill']['id'];

                     $JobApplication = $this->JobApplication->newEntity();
                     $JobApplicationdata = $this->JobApplication->patchEntity($JobApplication, $this->request->data);
                     if ($resu = $this->JobApplication->save($JobApplicationdata)) {
                        $packfeature = $this->Packfeature->get($packfeature_id);

                        $feature_info['number_job_application_daily'] = $number_jobday - 1;
                        $feature_info['number_job_application_month'] = $number_jobmonth - 1;
                        $features_arr = $this->Packfeature->patchEntity($packfeature, $feature_info);
                        $this->Packfeature->save($features_arr);
                     }



                     $bookjob = $this->JobApplication->find('all')->order(['JobApplication.id' => 'DESC'])->first();
                     ////pr($bookjob); 
                     //$response['job_id']=$bookjob['job_id'];
                     $Job[] = $value;
                     $response['success'] = 2;
                     //echo json_encode($response);
                     //die;

                  } else {

                     $response['success'] = 1;
                  }
               }
            } catch (FatalErrorException $e) {
               $this->log("Error Occured", 'error');
            }
         } else {
            $response['success'] = 3;
         }
      }
      $response['jobarray'] = $Job;
      echo json_encode($response);
      die;
   }

   // multiple apply in one click rupam singh jan 30 2025
   public function applymultiplejob()
   {
      $this->loadModel('Packfeature');
      $this->loadModel('Requirement');
      $this->loadModel('JobApplication');
      $user_id = $this->request->session()->read('Auth.User.id');
      $roleId = $this->request->session()->read('Auth.User.role_id');

      // pr($this->request->data);exit;

      if ($this->request->is(['post', 'put'])) {

         $response = [];
         $Job = [];

         $jobapplycount = count($this->request->data['job']);

         if ($this->request->data['buttonpresstype'] == 1) {

            $packfeature = $this->activePackage();

            // **Extract limit values from package**
            $packfeature_id = $packfeature['id'];
            $daily_limit = $packfeature['number_job_application_daily'];
            $monthly_limit = $packfeature['number_job_application_month'];

            // **Count jobs applied today dynamically**
            $job_applied_today = $this->JobApplication->find()
               ->where([
                  'JobApplication.user_id' => $user_id,
                  'DATE(JobApplication.created)' => date('Y-m-d')
               ])
               ->count();

            $jobs_left_today = $daily_limit - $job_applied_today;
            $jobs_left_month = $monthly_limit - $packfeature['number_job_application_month_used'];

            // **Check Daily Limit**
            if ($job_applied_today >= $daily_limit) {
               $response['success'] = false;
               $response['message'] = "You have exceeded your daily job application limit of $daily_limit jobs.";
               echo json_encode($response);
               die;
            }

            // **Check Monthly Limit**
            if ($packfeature['number_job_application_month_used'] >= $monthly_limit) {
               $response['success'] = false;
               $response['message'] = "You have exceeded your monthly job application limit of $monthly_limit jobs.";
               echo json_encode($response);
               die;
            }

            // **Check if they are applying for more jobs than allowed**
            if ($jobapplycount > $jobs_left_today) {
               $response['success'] = false;
               $response['message'] = "You can only apply for $jobs_left_today more jobs today.";
               echo json_encode($response);
               die;
            }

            if ($jobapplycount > $jobs_left_month) {
               $response['success'] = false;
               $response['message'] = "You can only apply for $jobs_left_month more jobs this month.";
               echo json_encode($response);
               die;
            }

            // **Proceed to Apply for Jobs**
            foreach ($this->request->data['job'] as $value) {
               $details = $this->Requirement->find('all')
                  ->contain([
                     'RequirmentVacancy' => ['Skill', 'Currency'],
                     'Country',
                     'State',
                     'City',
                     'Users',
                     'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']
                  ])
                  ->where(['Requirement.id' => $value, 'Requirement.status' => 'Y'])
                  ->first();

               $this->request->data['user_type'] = $roleId;
               $this->request->data['package_id'] = $packfeature_id;
               $this->request->data['user_id'] = $user_id;
               $this->request->data['talent_accepted_status'] = "Y";
               $this->request->data['job_id'] = $details['id'];
               $this->request->data['skill_id'] = $details['requirment_vacancy'][0]['skill']['id'];

               $JobApplication = $this->JobApplication->newEntity();
               $JobApplicationdata = $this->JobApplication->patchEntity($JobApplication, $this->request->data);

               if ($this->JobApplication->save($JobApplicationdata)) {
                  // **Update Packfeature counts**
                  $packfeature = $this->Packfeature->get($packfeature_id);
                  $packfeature->number_job_application_month_used += 1;
                  $this->Packfeature->save($packfeature);

                  // Send notification for job application
                  $this->notification_sent(
                     $details['user_id'],
                     $messageType = 'Job Application',
                     $message = 'You have received a job application for the job titled "' . $details['title'] . '" from '
                  );

                  $Job[] = $value;
               }
            }

            $response['success'] = true;
            $response['message'] = "Job(s) applied successfully.";
         } else {
            $response['success'] = false;
            $response['message'] = "Invalid request.";
         }
      }

      $response['jobarray'] = $Job;
      echo json_encode($response);
      die;
   }

   function notification_sent($recieverId, $messageType, $message)
   {
      $this->autoRender = false;
      $this->loadModel('Notification');
      $id = $this->request->session()->read('Auth.User.id');
      $notification['notification_sender'] = $id;
      $notification['notification_receiver'] = $recieverId;
      $notification['type'] = $messageType;
      $notification['content'] = $message;
      $noti = $this->Notification->newEntity();
      $articles = $this->Notification->patchEntity($noti, $notification);
      $save = $this->Notification->save($articles);
      return true;
   }

   function notification_alert($recieverId, $messageType, $message)
   {
      $this->autoRender = false;
      $this->loadModel('Notification');
      $id = $this->request->session()->read('Auth.User.id');
      $notification['notification_sender'] = $id;
      $notification['notification_receiver'] = $recieverId;
      $notification['type'] = $messageType;
      $notification['content'] = $message;
      $noti = $this->Notification->newEntity();
      $articles = $this->Notification->patchEntity($noti, $notification);
      $this->Notification->save($articles);
      // return true;
   }


   // public function applymultiplejob()
   // {
   //    $this->loadModel('Packfeature');
   //    $this->loadModel('Requirement');
   //    $this->loadModel('JobApplication');

   //    if ($this->request->is(['post', 'put'])) {

   //       $response = array();
   //       $Job = array(); // Initialize an array to store job IDs

   //       if ($this->request->data['buttonpresstype'] == 1) {
   //          $user_id = $this->request->session()->read('Auth.User.id');
   //          $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
   //          $applycount = $packfeature['number_job_application'];
   //          $packfeature_id = $packfeature['id'];

   //          $number_jobday = $packfeature['number_job_application_daily'];
   //          $number_jobmonth = $packfeature['number_job_application_month'];
   //          $jobapplycount = count($this->request->data['job']);

   //          if ($jobapplycount > $number_jobday) {
   //             $response['dailylimit'] = 1;
   //             $response['daycount'] = $number_jobday;
   //          } elseif ($jobapplycount > $number_jobmonth) {
   //             $response['monthlimit'] = 1;
   //             $response['monthcount'] = $number_jobmonth;
   //          } else {
   //             // No limit reached, proceed to apply for jobs
   //             foreach ($this->request->data['job'] as $value) {
   //                $details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City', 'Users', 'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']])->where(['Requirement.id' => $value, 'Requirement.status' => 'Y'])->first();

   //                $skill = count($details['requirment_vacancy']);

   //                if ($skill <= 1) {
   //                   // Do something if skill count is less than or equal to 1
   //                } else {
   //                   // Do something if skill count is greater than 1
   //                   // You may set $flag = 1 here if needed
   //                }

   //                // Assuming your flag logic is correctly implemented here
   //                // Proceed with saving job application if flag condition is met
   //                if ($flag == 0) {
   //                   // Prepare data for saving job application
   //                   $this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');
   //                   $this->request->data['talent_accepted_status'] = "Y";
   //                   $this->request->data['job_id'] = $details['id'];
   //                   $this->request->data['skill_id'] = $details['requirment_vacancy']['0']['skill']['id'];

   //                   // Create new entity for JobApplication and save
   //                   $JobApplication = $this->JobApplication->newEntity();
   //                   $JobApplicationdata = $this->JobApplication->patchEntity($JobApplication, $this->request->data);
   //                   if ($this->JobApplication->save($JobApplicationdata)) {
   //                      // Update Packfeature count after successful job application
   //                      $packfeature = $this->Packfeature->get($packfeature_id);
   //                      $packfeature->number_job_application_daily = $number_jobday - 1;
   //                      $packfeature->number_job_application_month = $number_jobmonth - 1;
   //                      $this->Packfeature->save($packfeature);

   //                      // Store the job ID in the Job array
   //                      $Job[] = $value;
   //                   }
   //                } else {
   //                   // If flag condition is not met, set response success to 1
   //                   $response['success'] = 1;
   //                }
   //             }

   //             // Set response success to 2 if job application is successful
   //             $response['success'] = 2;
   //             $response['message'] = "job applied successfully";
   //          }
   //       } else {
   //          // If buttonpresstype is not 1, set response success to 3
   //          $response['success'] = 3;
   //       }
   //    }

   //    // Set jobarray in the response
   //    $response['jobarray'] = $Job;

   //    // Output JSON response and terminate script execution
   //    echo json_encode($response);
   //    die;
   // }

   public function saveprosearchresult()
   {

      $this->loadModel('Saveprofilesearch');
      if ($this->request->is(['post', 'put'])) {

         $Saveprofilesearch = $this->Saveprofilesearch->newEntity();
         if ($_SESSION['Profilerefinedata']) {

            $this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');



            if ($_SESSION['Profilerefinedata']['name']) {
               $this->request->data['keyword'] = $_SESSION['Profilerefinedata']['name'];
            } else {
               $this->request->data['keyword'] = $this->request->data['name'];
            }
            $this->request->data['age'] = $_SESSION['Profilerefinedata']['age'];
            $this->request->data['gender'] = $_SESSION['Profilerefinedata']['gender'];
            $this->request->data['performancelan'] = $_SESSION['Profilerefinedata']['performancelan'];
            $this->request->data['online'] = $_SESSION['Profilerefinedata']['online'];

            $vitalcount = count($_SESSION['Profilerefinedata']['vitalstats']);
            $vital = array();
            //pr($_SESSION['Profilerefinedata']);
            for ($i = 0; $i < $vitalcount; $i++) {

               if ($_SESSION['Profilerefinedata']['vitalstats'][$i] != 0) {

                  $vital[] = $_SESSION['Profilerefinedata']['vitalstats'][$i];
               }
            }

            //pr($vital);

            $this->request->data['vitaloption'] = implode(",", $vital);
            $this->request->data['ProfileActive'] = $_SESSION['Profilerefinedata']['activein'];
            $this->request->data['Payment-Frequency'] = $_SESSION['Profilerefinedata']['paymentfaq'];
            $this->request->data['Talent-Type'] = $_SESSION['Profilerefinedata']['skill'];
            $this->request->data['Ethnicity'] = $_SESSION['Profilerefinedata']['ethnicity'];
            $this->request->data['Review-Rating'] = $_SESSION['Profilerefinedata']['r3'];
            $this->request->data['Working-Style'] = $_SESSION['Profilerefinedata']['workingstyle'];

            //pr($this->request->data); die;

            $saveprofiledata = $this->Saveprofilesearch->patchEntity($Saveprofilesearch, $this->request->data);
            $savedprofile = $this->Saveprofilesearch->save($saveprofiledata);

            $response = array();
            if ($savedprofile) {
               $response['success'] = 1;
            }
         } else {
            $response['success'] = 0;
         }
         echo json_encode($response);
         die;
      }
   }

   public function viewRefine()
   {

      $this->loadModel('Saveprofilesearch');
      $user_id = $this->request->session()->read('Auth.User.id');
      $Savejobsdata = $this->Saveprofilesearch->find('all')->select(['id', 'template', 'created'])->where(['Saveprofilesearch.user_id' => $user_id])->order(['Saveprofilesearch.id' => 'DESC'])->toarray();
      $this->set('savedata', $Savejobsdata);
   }

   public function pingjobs()
   {
      $this->loadModel('Requirement');
      if ($this->request->is(['post', 'put'])) {

         $requirementid = $this->request->data['jobid'];
         $count = $this->request->data['count'];

         $details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City', 'Users', 'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']])->where(['Requirement.id' => $requirementid, 'Requirement.status' => 'Y'])->first();
         $html = "<div id='myping" . $requirementid . "'>";
         $html .= "
		<a href=" . SITE_URL . "/applyjob/" . $details['id'] . " target='_blank'>" . $details['title'] . "</a>
		<select class='form-control' name='skill" . $count . "' required><option value=''>Select Skill</option>";

         foreach ($details['requirment_vacancy'] as $value) {

            $html .= '<option value=' . $value["skill"]["id"] . '>' . $value["skill"]["name"] . '</option>';
         }

         $html .= '<input type="hidden" name="job_id' . $count . '" value=' . $details['id'] . '>
		<input type="hidden" name="count" value=' . $count . '>
		</div>';
         echo $html;
         die;
      }
   }

   public function singlepaidping($jobId)
   {
      // $this->autoRender = false;
      $this->loadModel('Requirement');
      // pr($jobId);exit;
      if ($jobId) {
         $details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City', 'Users', 'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']])->where(['Requirement.id' => $jobId, 'Requirement.status' => 'Y'])->first();
      } else {
         $details = [];
      }
      // pr($details);exit;
      $this->set('details', $details);
   }

   public function myfunctiondata()
   {

      $this->loadModel('RequirmentVacancy');

      if ($this->request->is(['post', 'put'])) {


         $skill = $this->request->data['skill'];
         $requirementid = $this->request->data['reqid'];
         $details = $this->RequirmentVacancy->find('all')->contain(['Skill', 'Currency'])->where(['RequirmentVacancy.requirement_id' => $requirementid, 'RequirmentVacancy.telent_type' => $skill])->first();


         $response = [];

         if ($details) {
            $response['payment_currency'] = ($details->payment_amount > 0) ? $details->payment_amount : null;
            $response['currency'] = $details->currency->name ?? '';
            $response['code'] = $details->currency->symbol ?? '';
            $response['currency_id'] = $details->currency->id ?? '';
         } else {
            $response['payment_currency'] =  null;
            $response['currency'] =  '';
            $response['code'] =  '';
            $response['currency_id'] = '';
         }

         echo json_encode($response);
         die;
      }
   }

   public function singleApply($jobid = null)
   {
      $this->loadModel('Packfeature');
      $this->loadModel('Requirement');
      $this->loadModel('JobApplication'); // Assuming job applications are stored here

      $user_id = $this->request->session()->read('Auth.User.id');

      // pr($jobid);exit;

      // Get the active package
      $packfeature = $this->activePackage();

      if (!$packfeature) {
         $this->setResponseData(0, 'No package found for the user.');
         return;
      }

      $monthlimit = $packfeature['number_job_application_month'];
      $monthlimitused = $packfeature['number_job_application_month_used'];
      $dailylimit = $packfeature['number_job_application_daily'];

      // Get the current date
      $currentDate = date('Y-m-d');

      // Check how many applications the user has made today
      $dailyApplicationCount = $this->JobApplication->find()
         ->where([
            'JobApplication.user_id' => $user_id,
            'DATE(JobApplication.created)' => $currentDate
         ])
         ->count();

      // Check how many applications the user has made this month
      $firstDayOfMonth = date('Y-m-01');
      $lastDayOfMonth = date('Y-m-t');

      $monthlyApplicationCount = $this->JobApplication->find()
         ->where([
            'JobApplication.user_id' => $user_id,
            'JobApplication.created >=' => $firstDayOfMonth,
            'JobApplication.created <=' => $lastDayOfMonth
         ])
         ->count();

      // Check if the user has exceeded limits
      if ($monthlyApplicationCount >= $monthlimit) {
         $this->setResponseData(0, 'You have reached your monthly job application limit.');
         return;
      }

      if ($dailyApplicationCount >= $dailylimit) {
         $this->setResponseData(0, 'You have reached your daily job application limit.');
         return;
      }

      // Fetch job details
      $details = $this->Requirement->find()
         ->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City', 'Users', 'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']])
         ->where(['Requirement.id' => $jobid, 'Requirement.status' => 'Y'])
         ->first();

      if (!$details) {
         $this->setResponseData(0, 'Job not found or inactive.');
         return;
      }

      // If everything is fine, return success
      $this->setResponseData(1, 'Job application can proceed.', $details, $jobid);
   }

   private function setResponseData($flag, $message, $details = null, $jobid = null)
   {
      $this->set('flag', $flag);
      $this->set('message', $message);

      if ($details) {
         $this->set('requirement_data', $details);
      }

      if ($jobid) {
         $this->set('jobid', $jobid);
      }
   }

   public function sendquotebysingle($jobid)
   {

      $this->loadModel('Requirement');
      $this->loadModel('Packfeature');
      $user_id = $this->request->session()->read('Auth.User.id');
      $id = $jobid;
      try {
         $details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City', 'Users', 'Jobquestion' => ['Questionmare_options_type', 'Jobanswer']])->where(['Requirement.id' => $id, 'Requirement.status' => 'Y'])->first();
         $this->set('requirement_data', $details);

         $this->set('id', $id);
      } catch (FatalErrorException $e) {
         $this->log("Error Occured", 'error');
      }
   }

   public function profilesearch($is_reset = null)
   {
      // pr($this->request->query);
      // die;

      if ($is_reset == "reset") {
         $session = $this->request->session();
         $session->delete('advanceprofiesearchdata');
      }

      $this->loadModel('Requirement');
      $this->loadModel('Packfeature');
      $this->loadModel('JobApplication');
      $this->loadModel('JobQuote');
      $this->loadModel('Profile');
      $this->loadModel('Blocks');
      $this->loadModel('Currency');

      //Write Advance details to session  
      if ($this->request->query['form'] == 1) {
         $session = $this->request->session();
         $session->write('advanceprofiesearchdata', $this->request->query);
      }

      foreach ($this->request->query['vitalstats'] as $key => $value) {
         $vitalarray[] = $value;
      }

      $newArray = array();
      foreach ($vitalarray as $array) {
         foreach ($array as $k => $v) {
            $newArray[] = $v;
         }
      }


      $currencies = $this->Currency->find('all')
         ->select(['id', 'name', 'currencycode', 'symbol'])
         ->order(['name' => 'ASC', 'id' => 'ASC'])
         ->all()
         ->combine(
            'id',
            function ($row) {
               return $row->name . ' (' . $row->currencycode . ' - ' . $row->symbol . ')';
            }
         )
         ->toArray();
      $this->set('currencies', $currencies);



      // pr($this->request->query);

      $this->set('vitalarray', $newArray);
      $id = $this->request->session()->read('Auth.User.id');
      // $packlimit = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $this->request->session()->read('Auth.User.id')])->first();
      $packlimit = $this->activePackage(); // Fetch package details

      $numberofaskquoteperjob = $packlimit['ask_for_quote_request_per_job'];
      $this->set('numberofaskquoteperjob', $numberofaskquoteperjob);

      $currentdate = date('Y-m-d H:m:s');
      $activejobs = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency']])->where(['user_id' => $id, 'Requirement.last_date_app >=' => $currentdate, 'Requirement.status' => 'Y'])->toarray();
      // pr($activejobs);exit;
      $this->set('activejobs', $activejobs);

      $askquote = $this->JobQuote->find('all')->where(['user_id' => $userid])->toarray();
      $this->set('askquote', $askquote);

      $user_id = $this->request->session()->read('Auth.User.id');
      if ($user_id) {
         $profile = $this->Profile->find('all')->where(['user_id' => $user_id])->first();
      }

      if ($this->request->query['optiontype'] == 2 || empty($this->request->query['clatitude']) || !empty($profile['current_lat']) && $this->request->query['form'] != 1) {

         if ($_SESSION['user_location']['latitude'] != 0) {
            $this->request->query['clatitude'] = $_SESSION['user_location']['latitude'];
            $this->request->query['clongitude'] = $_SESSION['user_location']['longitude'];
            $this->request->query['clocation'] = "Jaipur, Rajasthan, India";
            $this->request->query['cwithin'] = 1000;
         } else if ($profile['current_location']) {
            $this->request->query['clatitude'] = $profile['current_lat'];
            $this->request->query['clongitude'] = $profile['current_long'];
            $this->request->query['clocation'] = $profile['current_location'];
            $this->request->query['cwithin'] = 1000;
         } else {
            // $this->request->query['clatitude'] = 35.8617;
            // $this->request->query['clongitude'] = 104.1954;
            // $this->request->query['clocation'] = "no location";
            // $this->request->query['cwithin'] = 0;
         }

         $this->request->query['currentlocunit'] = "km";
         $this->request->query['form'] = 1;
      }


      if ($this->request->query['form'] == 1) {
         //echo "Fsdfsd"; die;
         if ($this->request->query['latitude']) {
            $loc_lat = $this->request->query['latitude'];
         } else {
            $loc_lat = "";
         }

         if ($this->request->query['longitude']) {
            $loc_long = $this->request->query['longitude'];
         } else {
            $loc_long = "";
         }
         if ($this->request->query['unit'] = "km") {
            $kmmile = 3956;
         } else {
            $kmmile = 6371;
         }

         if ($this->request->query['clatitude']) {
            $cloc_lat = $this->request->query['clatitude'];
         } else {
            $cloc_lat = "";
         }

         if ($this->request->query['clongitude']) {
            $cloc_long = $this->request->query['clongitude'];
         } else {
            $cloc_long = "";
         }

         if ($this->request->query['currentlocunit'] = "km") {
            $kmmile = 3956;
         } else {
            $kmmile = 6371;
         }
      }

      // pr($this->request->query); 
      //pr($cloc_lat); die;
      // 	$cloc_lat = "28.7041";
      // $loc_long = "77.1025";
      // $kmmile = 5;
      // pr($_SESSION); die;
      // pr($this->request->query); die;
      //  
      //if($this->request->query['optiontype']==2 && empty($id)){

      //}
      $current_time = date('Y-m-d H:i:s');


      // Refine By Rupam Singh with visibility matrix do not remove 04-04-2025
      $sql = "SELECT TIMESTAMPDIFF(DAY,users.last_login,NOW()) as active,users.last_login,personal_profile.location,personal_profile.id as pid, GROUP_CONCAT(DISTINCT skill.skill_id) AS skill, 1.609344 * '" . $kmmile . "' * ACOS( COS( RADIANS('" . $cloc_lat . "') ) * COS( RADIANS(personal_profile.current_lat) ) * COS( RADIANS(personal_profile.current_long) - RADIANS('" . $cloc_long . "') ) + sin( RADIANS('" . $cloc_lat . "') ) * sin( RADIANS(personal_profile.current_lat) ) ) AS cdistance,  1.609344 * '" . $kmmile . "' * ACOS( COS( RADIANS('" . $loc_lat . "') ) * COS( RADIANS(personal_profile.current_lat) ) * COS( RADIANS(personal_profile.current_long) - RADIANS('" . $loc_long . "') ) + sin( RADIANS('" . $loc_lat . "') ) * sin( RADIANS(personal_profile.current_lat) ) ) AS distance,professinal_info.areyoua,professinal_info.profile_title,personal_profile.name,languageknown.id as languageknownid,

      -- Fetch the latest valid package or fallback to package_id=1 if not found
         (
            SELECT COALESCE(
                  (SELECT package_id FROM subscriptions WHERE package_type = 'PR' AND user_id = users.id AND expiry_date >= NOW() ORDER BY id DESC LIMIT 1),
                  (SELECT package_id FROM subscriptions WHERE package_type = 'PR' AND user_id = users.id AND package_id = 1 ORDER BY id ASC LIMIT 1)
            )
         ) AS p_package,

         (
            SELECT COALESCE(
                  (SELECT package_id FROM subscriptions WHERE package_type = 'RC' AND user_id = users.id AND expiry_date >= NOW() ORDER BY id DESC LIMIT 1),
                  (SELECT package_id FROM subscriptions WHERE package_type = 'RC' AND user_id = users.id AND package_id = 1 ORDER BY id ASC LIMIT 1)
            )
         ) AS r_package,

         (
            SELECT visibility_matrix.ordernumber
            FROM visibility_matrix
            WHERE visibility_matrix.profilepack_id = 
                  (
                     SELECT COALESCE(
                        (SELECT package_id FROM subscriptions WHERE package_type = 'PR' AND user_id = users.id AND expiry_date >= NOW() ORDER BY id DESC LIMIT 1),
                        (SELECT package_id FROM subscriptions WHERE package_type = 'PR' AND user_id = users.id AND package_id = 1 ORDER BY id ASC LIMIT 1)
                     )
                  )
                  AND visibility_matrix.recruiter_id =
                  (
                     SELECT COALESCE(
                        (SELECT package_id FROM subscriptions WHERE package_type = 'RC' AND user_id = users.id AND expiry_date >= NOW() ORDER BY id DESC LIMIT 1),
                        (SELECT package_id FROM subscriptions WHERE package_type = 'RC' AND user_id = users.id AND package_id = 1 ORDER BY id ASC LIMIT 1)
                     )
                  )
         ) AS order_num,
      
      personal_profile.profile_image,personal_profile.gender,personal_profile.user_id,personal_profile.dob as dateofbirth,Round(TIMESTAMPDIFF(Day, personal_profile.dob, now() )/365)  as birthyear,personal_profile.gender,personal_profile.ethnicity,users.last_login,users.id,personal_profile.ethnicity,personal_profile.current_location,professinal_info.performing_year, count(*) as cont , professinal_info.performing_year ,('$year'-professinal_info.performing_year) as yearexpe,(YEAR(CURDATE())-professinal_info.performing_year) as pyear FROM `personal_profile` 
      LEFT JOIN users ON personal_profile.user_id = users.id 
		LEFT JOIN performance_language ON users.id = performance_language.user_id  
		LEFT JOIN languageknown ON users.id = languageknown.user_id 
		LEFT JOIN performance_desc2 ON users.id = performance_desc2.user_id 
		LEFT JOIN professinal_info ON users.id = professinal_info.user_id 
		LEFT JOIN uservital ON users.id = uservital.user_id 
		LEFT JOIN vques ON uservital.vs_question_id = vques.id 
		LEFT JOIN voption ON uservital.option_value_id = voption.id  
		LEFT JOIN skill ON users.id = skill.user_id 
      LEFT JOIN skill_type ON skill.skill_id = skill_type.id
		LEFT JOIN current_working ON users.id = current_working.user_id 
		LEFT JOIN performance_desc ON performance_desc.user_id = users.id 
		LEFT JOIN prof_exprience ON prof_exprience.user_id = users.id
      LEFT JOIN subscriptions ON subscriptions.user_id = users.id
      Where users.role_id=2 AND users.control_visibility= 'N' AND ";

      if ($id) {
         $blocked_user = $this->Blocks->find('list', [
            'keyField' => 'user_id',
            'valueField' => 'user_id',
         ])->where(['Blocks.content_id' => $id])->toarray();

         if (count($blocked_user) > 0) {
            $ids = implode(",", $blocked_user);
            $sql .= " users.id NOT IN ('$ids') AND ";
         }
      }
      // pr($sql); die;
      // For home page search
      // Back to refine search url

      if ($this->request->query['optiontype'] == 2) {
         $session = $this->request->session();
         if (!$session->check('backtorefinesearchprofile')) { // Check if the session key exists
            $session->write('backtorefinesearchprofile', $_SERVER['QUERY_STRING']);
         }
         // $session->write('backtorefinesearchprofile', $_SERVER['QUERY_STRING']);
      }

      if (!empty(trim($this->request->query['name'])) &&  $this->request->query['optiontype'] == 2) {
         $name = trim($this->request->query['name']);
         $this->set('d', $name);
         // $sql .= " (prof_exprience.description LIKE '%$name%' or  prof_exprience.location LIKE '%$name%' or current_working.description LIKE '%$name%'or current_working.location LIKE '%$name%' or performance_desc.description LIKE '%$name%' or personal_profile.name LIKE '%$name%' or personal_profile.profiletitle LIKE '%$name%' ) AND ";

         $searchTerm = strtolower(trim($this->request->query['name']));
         $sql .= " (
            LOWER(prof_exprience.description) LIKE '%$searchTerm%' OR  
            LOWER(prof_exprience.location) LIKE '%$searchTerm%' OR 
            LOWER(current_working.description) LIKE '%$searchTerm%' OR 
            LOWER(current_working.location) LIKE '%$searchTerm%' OR 
            LOWER(performance_desc.description) LIKE '%$searchTerm%' OR 
            LOWER(personal_profile.name) LIKE '%$searchTerm%' OR 
            LOWER(personal_profile.profiletitle) LIKE '%$searchTerm%' OR
            LOWER(skill_type.name) LIKE '%$searchTerm%'
         ) AND ";
      }

      // pr($sql);exit;
      // pr($this->request->query); die;

      // For home page search end$current_time

      // For Refine 
      if ($this->request->query['refine'] == 2) {
         // pr($this->request->query); die;
         $backtorefine = 1;
         $this->set('backtorefine', $backtorefine);

         // if (isset($_SERVER["HTTP_REFERER"])) {
         //    header("Location: " . $_SERVER["HTTP_REFERER"]);
         // }

         if (!empty($this->request->query['words'])) {

            $name = $this->request->query['words'];
            $this->set('d', $name);
            // $sql .= " (prof_exprience.description LIKE '%$name%' or  prof_exprience.location LIKE '%$name%' or current_working.description LIKE '%$name%'or current_working.location LIKE '%$name%' or performance_desc.description LIKE '%$name%' or personal_profile.name LIKE '%$name%' or personal_profile.profiletitle LIKE '%$name%' ) and ";
            $searchTerm = strtolower(trim($this->request->query['words']));

            $sql .= " (
               LOWER(prof_exprience.description) LIKE '%$searchTerm%' OR  
               LOWER(prof_exprience.location) LIKE '%$searchTerm%' OR 
               LOWER(current_working.description) LIKE '%$searchTerm%' OR 
               LOWER(current_working.location) LIKE '%$searchTerm%' OR 
               LOWER(performance_desc.description) LIKE '%$searchTerm%' OR 
               LOWER(personal_profile.name) LIKE '%$searchTerm%' OR 
               LOWER(personal_profile.profiletitle) LIKE '%$searchTerm%' OR
               LOWER(skill_type.name) LIKE '%$searchTerm%'
            ) AND ";
         }

         // pr($sql); die;
         if (!empty($this->request->query['age']) && $this->request->query['age'] !== '0') {
            $ageRange = explode("-", trim($this->request->query['age']));
            if (count($ageRange) === 2) { // Ensure valid min-max format
               $min = (int) $ageRange[0];
               $max = (int) $ageRange[1];

               $this->set('minselsss', $min);
               $this->set('maxselsss', $max);
               $max += 1; // Adjust max age range        
               // Formulate the query condition
               $having = " HAVING (birthyear >= '$min' AND birthyear < '$max') OR birthyear IS NULL ";
               //  pr($having);exit;
            }
         }


         if (!empty($this->request->query['gender']) && $this->request->query['gender'] != '0') {
            $gen = $this->request->query['gender'];
            $sql .= "  (personal_profile.gender='$gen') AND ";
            $this->set('gendersel', $gen);
         }

         //pr($this->request->query);
         if (!empty($this->request->query['performancelan']) && $this->request->query['performancelan']['0'] != 0) {
            $performancelan = $this->request->query['performancelan'];
            $count = count($this->request->query['performancelan']);

            for ($i = 0; $i < count($this->request->query['performancelan']); $i++) {
               if ($i == 0) {
                  $payment = "'" . $this->request->query['performancelan'][$i] . "'";
               } else {
                  $payment .= " OR performance_language.language_id= '" . $this->request->query['performancelan'][$i] . "'";
               }
            }

            $sql .= " (performance_language.language_id=$payment) AND ";
            $this->set('performancelansel', $performancelan);
         }

         if (!empty($this->request->query['language']) && $this->request->query['language']['0'] != 0) {
            $language = $this->request->query['language'];
            $count = count($this->request->query['language']);
            for ($i = 0; $i < count($this->request->query['language']); $i++) {
               if ($i == 0) {
                  $payment = "'" . $this->request->query['language'][$i] . "'";
               } else {
                  $payment .= " OR languageknown.language_id= '" . $this->request->query['language'][$i] . "'";
               }
            }
            $sql .= " (languageknown.language_id=$payment) AND ";
            $this->set('languagesel', $language);
         }

         //pr($this->request->query['online']); die;
         if (!empty($this->request->query['online']) && $this->request->query['online'] != 0) {
            $time = logintime; // Ensure this is properly defined somewhere
            $online = $this->request->query['online'];

            if ($online == 1) {
               $live = 1;
               $sql .= " (TIMESTAMPDIFF(MINUTE, users.last_login, '$current_time') < $time) AND ";
            } else {
               $live = 2;
               $sql .= " (TIMESTAMPDIFF(MINUTE, users.last_login, '$current_time') > $time) AND ";
            }

            $this->set(compact('live'));
         }

         //commented by gajanand
         if (!empty($this->request->query['activein']) && $this->request->query['activein']['0'] != 0) {
            $days = $this->request->query['activein'];
            $sql .= " TIMESTAMPDIFF(DAY,users.last_login,'$current_time') = '$days' AND ";
            $this->set('day', $days);
         }

         if (!empty($this->request->query['paymentfaq']) && $this->request->query['paymentfaq']['0'] != 0) {
            $paymentfaq = $this->request->query['paymentfaq'];
            $sql .= "  performance_desc2.payment_frequency='$paymentfaq' AND ";
            $this->set('payment', $paymentfaq);
         }

         // vital static
         if ($this->request->query['vitalstats']) {
            function Even($array)
            {
               // returns if the input integer is even
               if ($array % 2 == 0)
                  return TRUE;
               else
                  return FALSE;
            }

            //$array = array(12, 0, 0, 18, 27, 0, 46);
            //pr($this->request->query);
            $this->request->query['vitalstats'] = array_filter($this->request->query['vitalstats']);
            $c = a;
            if ($this->request->query['vitalstats']) {
               foreach ($this->request->query['vitalstats'] as $key => $va) {
                  $myva = "";
                  if ($va['0'] != 0) {
                     if (count($va) > 1) {
                        for ($i = 0; $i <= count($va) - 1; $i++) {
                           $myva .= "option_value_id =" . $va[$i] . " OR ";
                        }
                        $myva = rtrim($myva, ' OR');
                     } else {
                        $myva = "option_value_id = " . $va['0'] . "";
                     }
                     $query .= "(SELECT user_id FROM uservital WHERE " . $myva . ")" . $c . ",";
                     $c++;
                  }
               }

               $al = a;
               $count = 1;
               $arraykeys = array_keys($this->request->query['vitalstats']);
               for ($i = 1; $i <= count($this->request->query['vitalstats']) - 1; $i++) {
                  if ($this->request->query['vitalstats'][$key]['0'] != 0) {
                     if ($i == 1) {
                        $where = " Where " . a . ".user_id=" . ++$al . ".user_id";
                     } else {
                        $where .= "  AND " . a . ".user_id=" . ++$al . ".user_id";
                     }
                  }
               }

               $string = rtrim($query, ',');
               if ($string != "") {
                  if (count($this->request->query['vitalstats']) > 1) {
                     $sql .= " ( uservital.user_id in ( SELECT a.user_id FROM" . $string . $where . ')) AND ';
                  } else {
                     $sql .= " ( uservital.user_id in ( SELECT a.user_id FROM" . $string . ')) AND ';
                  }
               }
            }
         }

         // not empty conition 
         if (!empty($this->request->query['skill'])) {
            $skill = $this->request->query['skill'];
            $skillarray = explode(",", $skill);
            $skillcheck = " "; // Initialize the $skillcheck variable
            for ($i = 0; $i < count($skillarray); $i++) {
               if (count($skillarray) == 1) {
                  $skillcheck .= "skill.skill_id LIKE '$skillarray[$i]'";
                  // pr($skillcheck);exit;
               } elseif ($i == 0) {
                  $skillcheck .= "skill.skill_id LIKE '$skillarray[$i]'";
               } elseif ($i == count($skillarray) - 1) {
                  $skillcheck .= " OR skill.skill_id LIKE '$skillarray[$i]'";
               } else {
                  $skillcheck .= " OR skill.skill_id LIKE '$skillarray[$i]'";
               }
            }

            $sql .= " (" . $skillcheck . ") AND ";
         } else {
            $skillcheck = "";
         }

         if (!empty($this->request->query['ethnicity']) && $this->request->query['ethnicity'] != 0) {
            $ethnicityarray = $this->request->query['ethnicity'];
            $count = count($this->request->query['ethnicity']);
            for ($i = 0; $i < count($this->request->query['ethnicity']); $i++) {
               if ($i == 0) {
                  $ethnicity = "'" . $this->request->query['ethnicity'][$i] . "'";
               } else {
                  $ethnicity .= " OR personal_profile.ethnicity= '" . $this->request->query['ethnicity'][$i] . "'";
               }
            }
            $sql .= " (personal_profile.ethnicity=$ethnicity) AND ";
            $this->set('ethnicity', $ethnicityarray);
         }

         if (!empty($this->request->query['r3'])) {
            $r3 = $this->request->query['r3'];
            $sql .= "  (reviews.avgrating>='$r3') AND ";
            $this->set('r3', $r3);
         }

         if ($this->request->query['allrated'] == "rate") {
            $rated = $this->request->query['allrated'];
            $sql .= "  (reviews.avgrating>='0') AND ";
            $this->set('rated', $rated);
         } else if ($this->request->query['allrated'] == "unrate") {
            $rated = $this->request->query['allrated'];
            $this->set('rated', $rated);
         }

         if (!empty($this->request->query['workingstyle']) && $this->request->query['workingstyle'] != 0) {
            $workingstylearray = $this->request->query['workingstyle'];
            $count = count($this->request->query['workingstyle']);

            for ($i = 0; $i < count($this->request->query['workingstyle']); $i++) {
               if ($i == 0) {
                  $workingstyle = "'" . $this->request->query['workingstyle'][$i] . "'";
               } else {
                  $workingstyle .= " OR professinal_info.areyoua= '" . $this->request->query['workingstyle'][$i] . "'";
               }
            }
            $sql .= " (professinal_info.areyoua=$workingstyle) AND ";
            $this->set('workingstyleasel', $workingstylearray);
         }

         //pr($this->request->query);
         if ($this->request->query['profilepackage'] != 0) {
            $pid = $this->request->query['profilepackage'];
            $sql .= "  (subscriptions.package_type='PR' AND  subscriptions.package_id='$pid') AND ";
            $this->set('pid', $pid);
         }

         if ($this->request->query['recpackage'] != 0) {
            $pid = $this->request->query['recpackage'];
            $sql .= "  (subscriptions.package_type='RC' AND  subscriptions.package_id='$pid') AND ";
            $this->set('rid', $pid);
         }
         // pr($this->request->query);
      }
      // pr($sql);exit;
      // Refine End

      // Advance Search start
      // pr($this->request->query);
      if ($this->request->query['form'] == 1) {
         //back to refine search url 
         $session = $this->request->session();
         // pr($ession);exit;
         $session->write('backtorefinesearchprofile', $_SERVER['QUERY_STRING']);
         // end

         if (!empty(trim($this->request->query['name']))) {
            $name = addslashes(trim($this->request->query['name'])); // Prevent SQL injection
            $this->set('d', $name);
            // $sql .= " (LOWER(personal_profile.name) LIKE LOWER('%$name%')) AND";

            $searchTerm = strtolower(trim($this->request->query['name']));

            $sql .= " (
               LOWER(prof_exprience.description) LIKE '%$searchTerm%' OR  
               LOWER(prof_exprience.location) LIKE '%$searchTerm%' OR 
               LOWER(current_working.description) LIKE '%$searchTerm%' OR 
               LOWER(current_working.location) LIKE '%$searchTerm%' OR 
               LOWER(performance_desc.description) LIKE '%$searchTerm%' OR 
               LOWER(personal_profile.name) LIKE '%$searchTerm%' OR 
               LOWER(personal_profile.profiletitle) LIKE '%$searchTerm%' OR
               LOWER(skill_type.name) LIKE '%$searchTerm%'
            ) AND ";
         }

         if (!empty(trim($this->request->query['profiletitle']))) {
            $profiletitle = addslashes(trim($this->request->query['profiletitle'])); // Prevent SQL injection
            $this->set('title', $profiletitle);
            // $sql .= " (LOWER(personal_profile.profiletitle) LIKE LOWER('%$profiletitle%')) AND ";

            $searchTerm = strtolower(trim($this->request->query['profiletitle']));

            $sql .= " (
               LOWER(prof_exprience.description) LIKE '%$searchTerm%' OR  
               LOWER(prof_exprience.location) LIKE '%$searchTerm%' OR 
               LOWER(current_working.description) LIKE '%$searchTerm%' OR 
               LOWER(current_working.location) LIKE '%$searchTerm%' OR 
               LOWER(performance_desc.description) LIKE '%$searchTerm%' OR 
               LOWER(personal_profile.name) LIKE '%$searchTerm%' OR 
               LOWER(personal_profile.profiletitle) LIKE '%$searchTerm%' OR
               LOWER(skill_type.name) LIKE '%$searchTerm%'
            ) AND ";
         }

         // pr($sql);exit;

         // Rupam code 
         if (!empty($this->request->query['skill'])) {
            $skill = trim($this->request->query['skill']);
            $skillarray = array_filter(array_map('trim', explode(",", $skill))); // Clean and filter input

            if (!empty($skillarray)) {
               // Sanitize each ID (assuming numeric IDs)
               $escapedSkills = array_map(function ($id) {
                  return (int)$id; // Cast to int for safety
               }, $skillarray);

               // Build SQL condition
               $skillIds = implode(",", $escapedSkills);
               $sql .= " (skill.skill_id IN ($skillIds)) AND ";
            }
         }


         // if (!empty($this->request->query['skill'])) {
         //    $skill = $this->request->query['skill'];
         //    $skillarray = explode(",", $skill);
         //    $skillcheck = " "; // Initialize the $skillcheck variable
         //    for ($i = 0; $i < count($skillarray); $i++) {
         //       if (count($skillarray) == 1) {
         //          $skillcheck .= "skill.skill_id LIKE '$skillarray[$i]'";
         //          // pr($skillcheck);exit;
         //       } elseif ($i == 0) {
         //          $skillcheck .= "skill.skill_id LIKE '$skillarray[$i]'";
         //       } elseif ($i == count($skillarray) - 1) {
         //          $skillcheck .= " OR skill.skill_id LIKE '$skillarray[$i]'";
         //       } else {
         //          $skillcheck .= " OR skill.skill_id LIKE '$skillarray[$i]'";
         //       }
         //    }

         //    $sql .= " (" . $skillcheck . ") and ";
         // } else {
         //    $skillcheck = "";
         // }

         // pr($sql);exit;

         if (!empty($this->request->query['gender'])) {
            $genders = $this->request->query['gender'];
            $this->set('gendersel', $genders);

            if (in_array("a", $genders)) {
               // If "a" is selected, include all gender options
               $sql .= "(personal_profile.gender IN ('m', 'f', 'o', 'bmf')) AND ";
            } else {
               // Safely construct the gender filter
               $genderList = array_map(function ($gender) {
                  return "'" . addslashes($gender) . "'";
               }, $genders);

               // Check if there are any valid genders to include in the query
               if (!empty($genderList)) {
                  $sql .= "(personal_profile.gender IN (" . implode(",", $genderList) . ")) AND ";
               }
            }
         }

         if (!empty(trim($this->request->query['positionname']))) {
            $positionname = trim($this->request->query['positionname']);
            $positionname = strtolower($positionname);  // Convert input to lowercase
            $this->set('title', $name);
            $sql .= " (LOWER(prof_exprience.role) LIKE '%$positionname%' OR LOWER(current_working.role) LIKE '%$positionname%') AND ";
         }


         if (!empty($this->request->query['country_id'])) {
            $country_id = $this->request->query['country_id'];
            $sql .= "  (personal_profile.country_ids ='$country_id') AND ";
         }

         if (!empty($this->request->query['state_id'])) {

            $state_id = $this->request->query['state_id'];
            $sql .= " ( personal_profile.state_id ='$state_id') AND ";
         }

         if (!empty($this->request->query['city_id'][0]) && $this->request->query['city_id'] != 0) {
            $cityIds = array_map('intval', $this->request->query['city_id']); // Ensure values are integers

            $sql .= "(personal_profile.city_id IN (" . implode(",", $cityIds) . ")) AND ";
         }

         // pr($this->request->query); 
         // pr($sql);exit;

         // Rupam code 
         if (!empty(trim($this->request->query['wordsearch']))) {
            $wordsearch = trim($this->request->query['wordsearch']);
            $this->set('wordsearch', $wordsearch);

            $words = explode(",", $wordsearch);
            $conditions = [];
            $containType = $this->request->query['contain'] ?? 'c'; // Default: contains any

            foreach ($words as $word) {
               $word = addslashes(trim($word));
               $lowerWord = strtolower($word);

               // Common search condition
               $likeCondition = "(LOWER(prof_exprience.description) LIKE LOWER('%$lowerWord%')
                                OR LOWER(prof_exprience.location) LIKE LOWER('%$lowerWord%')
                                OR LOWER(prof_exprience.role) LIKE LOWER('%$lowerWord%')
                                OR LOWER(professinal_info.talent_manager) LIKE LOWER('%$lowerWord%')
                                OR LOWER(professinal_info.agency_name) LIKE LOWER('%$lowerWord%')
                                OR LOWER(professinal_info.profile_title) LIKE LOWER('%$lowerWord%')
                                OR LOWER(current_working.description) LIKE LOWER('%$lowerWord%')
                                OR LOWER(current_working.location) LIKE LOWER('%$lowerWord%')
                                OR LOWER(performance_desc.description) LIKE LOWER('%$lowerWord%')
                                OR LOWER(performance_desc.infulences) LIKE LOWER('%$lowerWord%')
                                OR LOWER(performance_desc.setup_requirement) LIKE LOWER('%$lowerWord%')
                                OR LOWER(performance_desc.paytermsandcondition) LIKE LOWER('%$lowerWord%')
                                OR LOWER(performance_desc.chargesdescription) LIKE LOWER('%$lowerWord%')
                                OR LOWER(personal_profile.current_location) LIKE LOWER('%$lowerWord%')
                                OR LOWER(personal_profile.name) LIKE LOWER('%$lowerWord%')
                                OR LOWER(skill_type.name) LIKE LOWER('%$lowerWord%')
                                OR LOWER(personal_profile.profiletitle) LIKE LOWER('%$lowerWord%'))";

               // NOT LIKE for all fields
               $notLikeCondition = "(LOWER(prof_exprience.description) NOT LIKE LOWER('%$lowerWord%')
                                    AND LOWER(prof_exprience.location) NOT LIKE LOWER('%$lowerWord%')
                                    AND LOWER(prof_exprience.role) NOT LIKE LOWER('%$lowerWord%')
                                    AND LOWER(professinal_info.talent_manager) LIKE LOWER('%$lowerWord%')
                                    AND LOWER(professinal_info.agency_name) LIKE LOWER('%$lowerWord%')
                                    AND LOWER(professinal_info.profile_title) LIKE LOWER('%$lowerWord%')
                                    AND LOWER(current_working.description) NOT LIKE LOWER('%$lowerWord%')
                                    AND LOWER(current_working.location) NOT LIKE LOWER('%$lowerWord%')
                                    AND LOWER(performance_desc.description) NOT LIKE LOWER('%$lowerWord%')
                                    AND LOWER(performance_desc.infulences) NOT LIKE LOWER('%$lowerWord%')
                                    AND LOWER(performance_desc.setup_requirement) NOT LIKE LOWER('%$lowerWord%')
                                    AND LOWER(performance_desc.paytermsandcondition) NOT LIKE LOWER('%$lowerWord%')
                                    AND LOWER(performance_desc.chargesdescription) NOT LIKE LOWER('%$lowerWord%')
                                    AND LOWER(personal_profile.current_location) NOT LIKE LOWER('%$lowerWord%')
                                    AND LOWER(personal_profile.name) NOT LIKE LOWER('%$lowerWord%')
                                    AND LOWER(skill_type.name) NOT LIKE LOWER('%$lowerWord%')
                                    AND LOWER(personal_profile.profiletitle) NOT LIKE LOWER('%$lowerWord%'))";

               // Add condition based on type
               if ($containType === 'n') {
                  $conditions[] = $notLikeCondition;
               } else {
                  $conditions[] = $likeCondition;
               }
            }

            // Choose glue (AND or OR) depending on contain type
            if (!empty($conditions)) {
               $glue = ($containType === 'a' || $containType === 'n') ? ' AND ' : ' OR ';
               $sql .= " (" . implode($glue, $conditions) . ") AND ";
            }
         }


         // pr($sql);
         // exit;

         if ($this->request->query['latitude']) {
            if (empty($this->request->query['within'])) {
               $latvalue = $this->request->query['latitude'];
               $sql .= " ( personal_profile.lat ='$latvalue' AND ";
            }
         }

         if ($this->request->query['longitude']) {
            if (empty($this->request->query['within'])) {
               $longvalue = $this->request->query['longitude'];
               $sql .= "  personal_profile.longs ='$longvalue') AND ";
            }
         }

         if ($this->request->query['clatitude']) {
            if (empty($this->request->query['cwithin'])) {
               $latvalue = $this->request->query['clatitude'];
               $sql .= " ( personal_profile.current_lat ='$latvalue') AND ";
            }
         }

         if ($this->request->query['clongitude']) {
            if (empty($this->request->query['cwithin'])) {
               $clongvalue = $this->request->query['clongitude'];
               $sql .= " ( personal_profile.current_long ='$clongvalue') AND ";
            }
         }

         if (!empty($this->request->query['currentlyworking'])) {
            $currentlyworking = $this->request->query['currentlyworking'];
            $sql .= " ( current_working.name LIKE '%$currentlyworking%') AND ";
         }

         if (!empty($this->request->query['within'])) {
            $within = $this->request->query['within'];
            //$within=$within-2;
            if (!empty($this->request->query['skill'])) {
               $skill = $this->request->query['skill'];
               $this->set('title', $name);
               //$have.=" and cdistance <='$within'";
               // $having .= " AND skill Like '%$skill%'";
            } else {
               //$having.="having distance <='$within'";
            }
         }

         if (!empty($this->request->query['cwithin'])) {
            $within = $this->request->query['cwithin'];
            //$within=$within-2;
            if (!empty($this->request->query['skill'])) {
               $skill = $this->request->query['skill'];
               $this->set('title', $name);
               //$have.=" and cdistance <='$within'";
               if (!empty($this->request->query['within'])) {
                  //$having.="and cdistance <='$within'";
               } else {
                  // $having .= " AND skill Like '%$skill%'";
               }
            } else {
               //$having.="having cdistance <='$within'";
            }
         }
         // pr($this->request->query);
         // if($id)

         // Commented by Rupam
         if (!empty($this->request->query['active']) && $this->request->query['active'] != 0 && !empty($id)) {
            $daysMapping = [
               1 => 15,
               2 => 30,
               3 => 45,
               4 => 60,
               5 => 90
            ];
            $days = $daysMapping[$this->request->query['active']] ?? 180;
            $days = (int)$days; // 15  
            // // add current date time days 
            // $days = $days + (int)date('d');
            // $days = $days - 1;
            // $date = date('Y-m-d', strtotime("-$days days"));
            // pr($date);exit;         
            // Append condition to SQL query using DATE_SUB WHERE created_date >= CURDATE() - INTERVAL 10 DAY;

            $sql .= " users.last_login >= CURDATE() - INTERVAL $days DAY  AND ";
            // pr($sql);exit;

            // Set the 'day' variable for view
            $this->set('day', $this->request->query['active']);
         }


         if ($this->request->query['experyear']) {
            $year = $this->request->query['experyear'];
            $myexpyear = explode(",", $year);
            if (!empty($this->request->query['skill'])) {
               if ($myexpyear['1']) {
                  $having .= " AND pyear>='$myexpyear[0]'AND pyear<='$myexpyear[1]' ";
               } else {
                  $having .= " AND pyear>='$myexpyear[0]' ";
               }
            } else {
               if ($myexpyear['1']) {
                  $having .= "having pyear>='$myexpyear[0]'AND pyear<='$myexpyear[1] '";
               } else {
                  $having .= " having pyear>='$myexpyear[0]' ";
               }
            }
         }

         // pr($this->request->query);
         // pr($sql);
         // exit;
      }

      // pr($this->request->query);exit;

      // Advance search End
      if (!empty($_SESSION['advanceprofiesearchdata']) && $this->request->query['refine'] == 2) {
         // pr('sdfs');
         // exit;

         if (!empty($_SESSION['advanceprofiesearchdata']['name'])) {
            $name = $_SESSION['advanceprofiesearchdata']['name'];
            $sql .= " ( personal_profile.name LIKE '%$name%'  ) AND ";
         }

         if (!empty($_SESSION['advanceprofiesearchdata']['profiletitle'])) {
            $profiletitle = $_SESSION['advanceprofiesearchdata']['profiletitle'];
            $this->set('title', $name);
            $sql .= "  (personal_profile.profiletitle LIKE '%$profiletitle%') AND ";
         }

         if (!empty($_SESSION['advanceprofiesearchdata']['gender'])) {
            if (in_array("a", $_SESSION['advanceprofiesearchdata']['gender'])) {
            } else {
               for ($i = 0; $i < count($_SESSION['advanceprofiesearchdata']['gender']); $i++) {
                  if ($i == 0) {
                     $sex = "'" . $_SESSION['advanceprofiesearchdata']['gender'][$i] . "'";
                  } else {
                     $sex .= " OR personal_profile.gender='" . $_SESSION['advanceprofiesearchdata']['gender'][$i] . "'";
                  }
               }
               $sql .= "  (personal_profile.gender=$sex) AND ";
            }
         }

         if (!empty($_SESSION['advanceprofiesearchdata']['positionname'])) {
            $positionname = $_SESSION['advanceprofiesearchdata']['positionname'];
            $this->set('title', $name);
            $sql .= " ( prof_exprience.role LIKE '%$positionname%' or current_working.role LIKE '%$positionname%') AND ";
         }

         if (!empty($_SESSION['advanceprofiesearchdata']['country_id'])) {
            $country_id = $_SESSION['advanceprofiesearchdata']['country_id'];
            $sql .= "  (personal_profile.country_ids ='$country_id') AND ";
         }

         if (!empty($_SESSION['advanceprofiesearchdata']['state_id'])) {
            $state_id = $_SESSION['advanceprofiesearchdata']['state_id'];
            $sql .= " ( personal_profile.state_id ='$state_id') AND ";
         }

         if (!empty($_SESSION['advanceprofiesearchdata']['city_id'][0]) && $_SESSION['advanceprofiesearchdata']['city_id'] != 0) {
            for ($i = 0; $i < count($_SESSION['advanceprofiesearchdata']['city_id']); $i++) {
               if ($i == 0) {
                  $city_id = "'" . $_SESSION['advanceprofiesearchdata']['city_id'][$i] . "'";
               } else {
                  $city_id .= " OR personal_profile.city_id='" . $_SESSION['advanceprofiesearchdata']['city_id'][$i] . "'";
               }
            }
            $sql .= "  (personal_profile.city_id=$city_id) AND ";
         }

         if ($_SESSION['advanceprofiesearchdata']['contain'] == 'c') {
            if (!empty($_SESSION['advanceprofiesearchdata']['wordsearch'])) {

               $wordsearch = $_SESSION['advanceprofiesearchdata']['wordsearch'];
               $array = explode(",", $wordsearch);
               $this->set('wordsearch', $wordsearch);
               $i = 1;
               foreach ($array as $key => $value) {
                  if ($i == 1) {
                     $con = " ";
                  } else {
                     $con = "OR";
                  }
                  $sql .= " $con (prof_exprience.description LIKE '%$value%' or  prof_exprience.location LIKE '%$value%' or current_working.description LIKE '%$value%'or current_working.location LIKE '%$value%' or performance_desc.description LIKE '%$value%' or personal_profile.name LIKE '%$value%' or personal_profile.profiletitle LIKE '%$value%' ) AND ";
                  $i++;
               }
            }
         } else if ($_SESSION['advanceprofiesearchdata']['contain'] == 'a') {
            if (!empty($_SESSION['advanceprofiesearchdata']['wordsearch'])) {
               $wordsearch = $_SESSION['advanceprofiesearchdata']['wordsearch'];
               $array = explode(",", $wordsearch);
               $this->set('wordsearch', $wordsearch);
               $i = 1;
               foreach ($array as $key => $value) {
                  if ($i == 1) {
                     $con = " ";
                  } else {
                     $con = "OR";
                  }
                  $sql .= "$con (prof_exprience.description Like'$value' or  prof_exprience.location Like '%$value%' or current_working.description Like  '%$value%'or current_working.location LIKE '%$value%' or performance_desc.description='%$value%' or personal_profile.name LIKE '%$value%' or personal_profile.profiletitle LIKE '%$value%' ) AND ";
                  $i++;
               }
            }
         } else {
            if (!empty($_SESSION['advanceprofiesearchdata']['wordsearch'])) {
               $wordsearch = $_SESSION['advanceprofiesearchdata']['wordsearch'];
               $this->set('wordsearch', $wordsearch);
               $i = 1;
               foreach ($array as $key => $value) {
                  if ($i == 1) {
                     $con = " ";
                  } else {
                     $con = "OR";
                  }
                  $sql .= " $con  (prof_exprience.description NOT LIKE '%$value%' or  prof_exprience.location NOT  LIKE '%$value%') AND (current_working.description  NOT LIKE '%$value%'or current_working.location  NOT LIKE '%$value%') AND (performance_desc.description NOT  LIKE '%$value%') AND (personal_profile.name  NOT LIKE '%$value%' or personal_profile.profiletitle NOT  LIKE '%$value%' ) AND ";
               }
            }
         }

         if ($_SESSION['advanceprofiesearchdata']['latitude']) {
            if (empty($_SESSION['advanceprofiesearchdata']['within'])) {
               $latvalue = $_SESSION['advanceprofiesearchdata']['latitude'];
               $sql .= " ( personal_profile.lat ='$latvalue') AND ";
            }
         }

         if ($_SESSION['advanceprofiesearchdata']['longitude']) {
            if (empty($_SESSION['advanceprofiesearchdata']['within'])) {
               $longvalue = $_SESSION['advanceprofiesearchdata']['longitude'];
               $sql .= " ( personal_profile.longs ='$longvalue') AND";
            }
         }

         if ($_SESSION['advanceprofiesearchdata']['clatitude']) {
            if (empty($_SESSION['advanceprofiesearchdata']['cwithin'])) {
               $latvalue = $_SESSION['advanceprofiesearchdata']['clatitude'];
               $sql .= " ( personal_profile.current_lat ='$latvalue') AND ";
            }
         }

         if ($_SESSION['advanceprofiesearchdata']['clongitude']) {
            if (empty($_SESSION['advanceprofiesearchdata']['cwithin'])) {
               $longvalue = $_SESSION['advanceprofiesearchdata']['clongitude'];
               $sql .= " ( personal_profile.current_long ='$longvalue') AND ";
            }
         }
         if (!empty($_SESSION['advanceprofiesearchdata']['currentlyworking'])) {
            $currentlyworking = $_SESSION['advanceprofiesearchdata']['currentlyworking'];
            $sql .= " ( current_working.name LIKE '%$currentlyworking%') AND ";
         }

         // if (!empty($_SESSION['advanceprofiesearchdata']['skill'])) {
         //    $skill = $_SESSION['advanceprofiesearchdata']['skill'];
         //    $skillarray = explode(",", $skill);

         //    for ($i = 0; $i < count($skillarray); $i++) {
         //       if (count($skillarray) == 1) {
         //          $skillcheck .= "skill.skill_id like '$skillarray[$i]'";
         //       } elseif ($i == 0) {
         //          $skillcheck .= "skill.skill_id  like '$skillarray[$i]'";
         //       } else if ($i == count($skillarray) - 1) {
         //          $skillcheck .= " or skill.skill_id like '$skillarray[$i]'";
         //       } else {
         //          $skillcheck .= " or skill.skill_id like '$skillarray[$i]'";
         //       }
         //    }

         //    $sql .= " (" . $skillcheck . " ) AND ";
         // } else {
         //    $skillcheck = "";
         // }

         if ($_SESSION['advanceprofiesearchdata']['experyear']) {
            $year = $_SESSION['advanceprofiesearchdata']['experyear'];
            $myexpyear = explode(",", $year);
            if (!empty($_SESSION['advanceprofiesearchdata']['skill'])) {
               if ($myexpyear['1']) {
                  $having .= " pyear >= '$myexpyear[0]' AND pyear<='$myexpyear[1]' AND ";
               } else {
                  $having .= " AND pyear>='$myexpyear[0]' AND  ";
               }
            } else {
               if (!empty($this->request->query['age']) && $this->request->query['age'] != '0') {
                  if ($myexpyear['1']) {
                     $having .= " AND pyear >='$myexpyear[0]' AND pyear<='$myexpyear[1] '";
                  }
               } else {
                  if ($myexpyear['1']) {
                     $having .= " having pyear >= '$myexpyear[0]'AND pyear<='$myexpyear[1] '";
                  } else {
                     $having .= " having pyear >= '$myexpyear[0]' ";
                  }
               }
            }
         }
      }
      // Session Wtih search
      // $sql .= " users.id!='$user_id' group by users.id " . $having . " order by order_num asc ";
      $pack =  $packlimit['number_of_talent_search'];
      // $sql .= " users.id != '$user_id' group by users.id " . $having . " order by order_num asc Limit  $pack ";
      $sql .= " users.id != '$user_id' group by users.id " . $having . " order by order_num ASC , subscriptions.id DESC";
      // pr($this->request->query);
      // pr($sql);
      // die;

      $con = ConnectionManager::get('default');
      $searchdata = $con->execute($sql)->fetchAll('assoc');
      // pr($searchdata);
      // die;

      if ($this->request->query['refine'] != 2) {
         $session = $this->request->session();
         $session->delete('searchparamerprofile');
         $session = $this->request->session();
         $this->request->session()->write('searchparamerprofile', $sql);
      }

      // Rupam 8/12/2023 -1
      $session = $this->request->session();
      $session->delete('Profilerefinedata');
      $this->request->session()->write('Profilerefinedata', $sql);


      $con = ConnectionManager::get('default');
      $newrefinearray = array();
      $newsearchdata = array();
      $refineparameterprofile = $con->execute($_SESSION['searchparamerprofile'])->fetchAll('assoc');
      // pr($refineparameterprofile);exit;
      // pr($this->request->query);

      $searchid = array();

      if ($this->request->query['location'] && $this->request->query['within']) {
         if ($searchdata) {
            $claculationunit = $this->request->query['unit'];
            foreach ($refineparameterprofile as $key => $value) {
               $value['frommyvalue'] = $this->get_driving_information($this->request->query['location'], $value['location']);
               if ($claculationunit == "mi") {
                  $fromdis = (int)(preg_replace("/[a-zA-Z]/", "", $value['frommyvalue'])) * (0.621371);
               } else {
                  $fromdis = (int)preg_replace("/[a-zA-Z]/", "", $value['frommyvalue']);
               }

               if ($fromdis <= $this->request->query['within']) {
                  $searchid[] = $value['pid'];
                  $newrefinearray[$key] = $value;
                  $vital = array('Profile.id IN' => $searchid);
               } else {
                  $vital = "";
               }
            }
         } else {
            $vital = "";
         }
      } else if ($this->request->query['clocation'] && $this->request->query['cwithin']) {
         if ($searchdata) {
            $claculationunit = $this->request->query['currentlocunit'];
            foreach ($refineparameterprofile as $key => $value) {
               $value['currentmyvalue'] = $this->get_driving_information($this->request->query['clocation'], $value['current_location']);
               if ($claculationunit == "mi") {
                  $currentdis = (int)(preg_replace("/[a-zA-Z]/", "", $value['currentmyvalue'])) * (0.621371);
               } else {
                  $currentdis = (int)preg_replace("/[a-zA-Z]/", "", $value['currentmyvalue']);
               }
               $cwithin = $_SESSION['advanceprofiesearchdata']['cwithin'];
               if ($currentdis <= $this->request->query['cwithin']) {
                  $newrefinearray[$key] = $value;
                  $searchid[] = $value['pid'];
                  $vital = array('Profile.id IN' => $searchid);
               } else {
                  $vital = "";
               }
            }
         } else {
            $vital = "";
         }
      } else if ($_SESSION['advanceprofiesearchdata']['clocation'] && $_SESSION['advanceprofiesearchdata']['cwithin']) {
         if ($searchdata) {
            $claculationunit = $this->request->query['currentlocunit'];
            foreach ($refineparameterprofile as $key => $value) {

               $value['currentmyvalue'] = $this->get_driving_information($_SESSION['advanceprofiesearchdata']['clocation'], $value['current_location']);;

               if ($claculationunit == "mi") {
                  $currentdis = (int)(preg_replace("/[a-zA-Z]/", "", $value['currentmyvalue'])) * (0.621371);
               } else {
                  $currentdis = (int)preg_replace("/[a-zA-Z]/", "", $value['currentmyvalue']);
               }

               $cwithin = $_SESSION['advanceprofiesearchdata']['cwithin'];
               if ($currentdis <= $cwithin) {
                  $newrefinearray[$key] = $value;
                  $searchid[] = $value['pid'];
                  $vital = array('Profile.id IN' => $searchid);
               } else {
                  $vital = "";
               }
            }
         } else {
            $vital = "";
         }
      } else if ($_SESSION['advanceprofiesearchdata']['location'] && $_SESSION['advanceprofiesearchdata']['within']) {
         if ($searchdata) {
            $claculationunit = $this->request->query['currentlocunit'];
            foreach ($refineparameterprofile as $key => $value) {
               $value['currentmyvalue'] = $this->get_driving_information($_SESSION['advanceprofiesearchdata']['location'], $value['current_location']);;
               if ($claculationunit == "mi") {
                  $currentdis = (int)(preg_replace("/[a-zA-Z]/", "", $value['currentmyvalue'])) * (0.621371);
               } else {
                  $currentdis = (int)preg_replace("/[a-zA-Z]/", "", $value['currentmyvalue']);
               }

               if ($currentdis <= $this->request->query['cwithin']) {
                  $newrefinearray[$key] = $value;
                  $searchid[] = $value['pid'];
                  $vital = array('Profile.id IN' => $searchid);
               } else {
                  $vital = "";
               }
            }
         } else {
            $vital = "";
         }
      } else {
         if ($searchdata) {
            foreach ($refineparameterprofile as $key => $value) {
               $searchid[] = $value['pid'];
            }
            $vital = array('Profile.id IN' => $searchid);
         } else {
            $vital = "";
         }
      }

      if ($vital) {
         $searchforvital = $this->Profile->find('all')->contain(['Users' => array('Uservital' => array('Vques' => ['conditions' => array('Vques.question NOT LIKE' => 'Open to Travel%')], 'Voption'))])->where([$vital, 'Users.role_id' => '2', 'Users.id !=' => $user_id])->toarray();
      } else {
         $searchforvital = "";
      }

      $querytionarray = array();
      foreach ($searchforvital as $value) {
         foreach ($value['user']['uservital'] as $vital) {
            if ($vital['option_value_id']) {
               if ($vital['option_type_id'] != 3 && $vital['option_type_id'] != 4 && $vital['option_type_id'] != 2) {
                  $querytionarray[$vital['vque']['question']][$vital['voption']['id']] = $vital['voption']['value'];
               }
            }
         }
      }

      $this->set('myvital', $querytionarray);
      if ($this->request->query['location'] && $this->request->query['within']) {
         $this->set('refineparameterprofile', $newrefinearray);
      } else {
         $this->set('refineparameterprofile', $refineparameterprofile);
      }

      if ($this->request->query['clocation'] && $this->request->query['cwithin']) {
         $this->set('refineparameterprofile', $newrefinearray);
      }

      $this->set('searchdata', $searchdata);

      $this->set(compact('$this->request->query'));
   }

   public function savesearchprofileresult()
   {
      $this->loadModel('Savejobsearch');
      if ($this->request->is(['post', 'put'])) {
         $Savejobsearch = $this->Savejobsearch->newEntity();
         if ($_SESSION['Profilerefinedata']) {
            $this->request->data['user_id'] = $this->request->session()->read('Auth.User.id');
            $this->request->data['query'] = $_SESSION['Profilerefinedata'];
            $this->request->data['savewhere'] = 2;
            $saveprofiledata = $this->Savejobsearch->patchEntity($Savejobsearch, $this->request->data);
            $savedprofile = $this->Savejobsearch->save($saveprofiledata);
            $response = array();
            if ($savedprofile) {
               $response['success'] = 1;
            }
         } else {
            $response['success'] = 0;
         }
         echo json_encode($response);
         die;
      }
   }

   public function refineprofileshow()
   {
      $this->loadModel('Savejobsearch');
      $user_id = $this->request->session()->read('Auth.User.id');
      $Savejobsdata = $this->Savejobsearch->find('all')->where(['Savejobsearch.user_id' => $user_id, 'Savejobsearch.savewhere' => 2])->order(['Savejobsearch.id' => 'DESC'])->toarray();
      $this->set('savedata', $Savejobsdata);
   }

   public function viewrefineprofile($id)
   {
      $this->loadModel('Savejobsearch');
      $this->loadModel('Profile');
      $Savejobsdataviewfilter = $this->Savejobsearch->find('all')->where(['Savejobsearch.id' => $id])->order(['Savejobsearch.id' => 'DESC'])->first()->toarray();
      $query = $Savejobsdataviewfilter['query'];
      // pr($query);exit;
      $con = ConnectionManager::get('default');
      $searchdata = $con->execute($query)->fetchAll('assoc');
      $title = trim($this->request->query['name']);
      $user_id = $this->request->session()->read('Auth.User.id');
      if (!empty($title)) {
         $this->set('title', $title);
         $use = array('Profile.name LIKE' => '%' . trim($title) . '%', 'Users.role_id' => '2', 'Users.id !=' => $user_id);
         $prr[] = $use;
      } else {
         $use = array('Users.role_id' => '2', 'Users.id !=' => $user_id);
         $prr[] = $use;
      }
      $searchforvital = $this->Profile->find('all')->contain(['Users' => array('Uservital' => array('Vques', 'Voption'))])->where($prr)->toarray();

      $querytionarray = array();
      foreach ($searchforvital as $value) {
         foreach ($value['user']['uservital'] as $vital) {

            if ($vital['option_value_id']) {

               if ($vital['option_type_id'] != 3 && $vital['option_type_id'] != 4 && $vital['option_type_id'] != 2) {
                  $querytionarray[$vital['vque']['question']][$vital['voption']['id']] = $vital['voption']['value'];
               }
            }
         }
      }
      $this->set('myvital', $querytionarray);
      $this->set('searchdata', $searchdata);
      $this->set(compact('$this->request->query'));
   }

   // function for  event type
   public function eventtypes($id = null)
   {
      $this->loadModel('Eventtype');
      $Eventtype = $this->Eventtype->find('list')->where(['Eventtype.status' => 'Y'])->select(['id', 'name'])->order(['Eventtype.name' => 'ASC'])->toarray();
      $this->set('Eventtype', $Eventtype);
   }

   public function profileskill()
   {
      $this->loadModel('Users');
      $this->loadModel('Skillset');
      $this->loadModel('Skill');
      if ($id != null) {
         $contentadminskillset = $this->Skillset->find('all')->contain(['Skill'])->where(['Skillset.user_id' => $id, 'Skillset.status' => 'Y'])->order(['Skillset.id' => 'DESC'])->toarray();
      }
      $Skill = $this->Skill->find('all')->select(['id', 'name'])->where(['Skill.status' => 'Y'])->toarray();
      $this->set('Skill', $Skill);
      $this->set('skillset', $contentadminskillset);

      if (!empty($this->request->data['skill']) && $this->request->data['skill'] != 0) {
         $skill = $this->request->data['skill'];
         $skillarray = explode(",", $skill);
         for ($i = 0; $i < count($skillarray); $i++) {
            //$skillvalue=$skillarray[$i];
            if ($i == 0) {
               $skillcheck .= "requirement_vacancy.telent_type like '$skillarray[$i]'";
            } else if ($i == count($skillarray) - 1) {
               $skillcheck .= " or requirement_vacancy.telent_type like '$skillarray[$i]' and";
            } else {
               $skillcheck .= " or requirement_vacancy.telent_type like '$skillarray[$i]'";
            }
         }
         //$have.="having skill Like '%$skill%'";
      } else {
         $skillcheck = "";
      }
      $this->loadModel('Packfeature');
      $user_id = $this->request->session()->read('Auth.User.id');
      $packfeature = $this->Packfeature->find('all')->where(['Packfeature.user_id' => $user_id])->order(['Packfeature.id' => 'ASC'])->first();
      $this->set('total_elegible_skills', $packfeature['number_categories']);
   }

   function file_get_contents_curl($url)
   {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $url);
      $data = curl_exec($ch);
      curl_close($ch);
      return  $data;
   }


   function get_driving_information($start, $finish, $raw = false)
   {
      $test = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . urlencode($start) . "&destinations=" . urlencode($finish) . "&departure_time=now&key=AIzaSyC27M5hfywTEJa5_l-g0KHWe8m8lxu-rSI";
      $json = file_get_contents($test);
      $details = json_decode($json, TRUE);
      return  $details['rows']['0']['elements']['0']['distance']['text'];
   }
}
