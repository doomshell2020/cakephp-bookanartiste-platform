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
class StaticController extends AppController
{
	
	
	public function initialize(){
        parent::initialize();
        
        $this->Auth->allow(['privacy','termsandconditions','faq','contactus','info']);
    	}



public function privacy(){
$this->loadModel('Static');
$staticprivacy = $this->Static->find('all')->where(['Static.id' =>1])->first();
$this->set('staticprivacy', $staticprivacy);
 }
 public function info(){
    $user = $this->request->session()->read('user_data');
			$this->loadModel('Report');
			$this->loadModel('Settings');
            $check_report = $this->Report->find('all')->where(['Report.profile_id' =>$user['id'],'action_taken'=>'N'])->order(['Report.id' =>'desc'])->first();
          // pr($check_report); die;
          $settingdetails = $this->Settings->find('all')->first();

            $datetime1 = date('Y-m-d');
            $datetime2 = date("Y-m-d", strtotime($check_report['created']));
           
            $dateTimeObject1 = date_create($datetime1); 
            $dateTimeObject2 = date_create($datetime2); 
            $interval = date_diff($dateTimeObject1, $dateTimeObject2); 
            $min = $interval->days * 24 * 60;
            $day1 = $interval->days;
            $min += $interval->h * 60;
            $min += $interval->i;
           // pr($day1); die;
            $datetime11 = date('Y-m-d');
            $datetime22=Date('Y-m-d', strtotime('-'.$settingdetails['unblock_within'].' days'));
            $dateTimeObject11 = date_create($datetime11); 
            $dateTimeObject22 = date_create($datetime22); 
            $interval1 = date_diff($dateTimeObject11, $dateTimeObject22); 
            $min1 = $interval1->days * 24 * 60;
            $day2 = $interval1->days;
            $min1 += $interval1->h * 60;
            $min1 += $interval1->i;   
            $hours = ($min1-$min)/60;
         //  pr($day2-$day1); die;
            $this->set('day', $day2-$day1);
            $this->set('hours', $hours);
            $this->set('settingdetails', $settingdetails);
            $this->set('check_report_count', $check_report_count);
     }

 public function termsandconditions()
    {
$this->loadModel('Static');
		$staticterms = $this->Static->find('all')->where(['Static.id' =>2])->first();
$this->set('staticterms', $staticterms);
    }

    
 public function contactus()
 {
$this->loadModel('Static');
     $staticterms = $this->Static->find('all')->where(['Static.id' =>3])->first();
$this->set('staticterms', $staticterms);
 }

 public function faq()
 {

    $this->loadModel('FaqCatQuestion');
		$this->loadModel('Faq');
        $Faq_cat = $this->Faq->find('all')->contain(['FaqCatQuestion'])->where(['Faq.status'=>'Y'])->order(['Faq.id' => 'asc'])->toarray();
       // pr($Faq_cat); die;
		$this->set('Faq_cat',$Faq_cat);
 }


}