<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class JobController extends AppController
{

    public $paginate = [
        'limit' => 25,
        'order' => [
            'Bannerpack.id' => 'asc'
        ]
    ];
    public function initialize()
    {
        parent::initialize();
        //$this->loadComponent('Paginator');

    }
    // For Job pack index
    public function index()
    {

        $this->viewBuilder()->layout('admin');
        $this->loadModel('Requirement');
        $this->loadModel('Users');

        $session = $this->request->session();
        $session->delete('requirementsearch');

        $Job = $this->Requirement->find('all')->contain(['Eventtype', 'Users', 'Featuredjob'])->where(['Requirement.jobdelete_status' => 'N'])->order(['Requirement.id' => 'DESC'])->toarray();
        // pr($Job); die;
        $this->set('Job', $Job);
    }


    public function search()
    {
        $this->loadModel('Users');
        $this->loadModel('Requirement');
        //pr($tcstatus); die;
        $status = $this->request->data['status'];
        $name = $this->request->data['name'];
        $email = $this->request->data['email'];
        $postedby = $this->request->data['postedby'];
        $postingtype = $this->request->data['postingtype'];
        $from_date = $this->request->data['from_date'];
        $to_date = $this->request->data['to_date'];
        $cond = [];

        if ($postingtype == 'F') {
            $cond['Requirement.Posting_type'] = 'Free Posting';
        } elseif ($postingtype == 'P' || $postingtype == 'R') {
            $cond['Requirement.Posting_type LIKE'] = '%Paid Posting Option%';
        } elseif ($postingtype == 'PR') {
            $cond['Requirement.Posting_type'] = 'Profile and Recruiter Package';
        }

        if (!empty($status)) {
            if ($status == "Y") {
                $cond['DATE(Requirement.last_date_app) >='] = date('Y-m-d h:i:s', time());
            } else {
                $cond['DATE(Requirement.last_date_app) <='] = date('Y-m-d h:i:s', time());
            }
            // $cond['Requirement.status'] = $status;
        }
        if (!empty($name)) {
            $cond['Users.user_name LIKE'] = "%" . $name . "%";
        }
        if (!empty($email)) {
            $cond['Users.email LIKE'] = "%" . $email . "%";
        }

        if (!empty($postedby)) {
            if ($postedby == 3) {
                $role = array(1, $postedby);

                $cond['Users.role_id IN'] = $role;
            } else {
                $cond['Users.role_id'] = $postedby;
            }
        }

        if (!empty($from_date)) {
            $cond['DATE(Requirement.created) >='] = date('Y-m-d', strtotime($from_date));
        }
        if (!empty($to_date)) {
            $cond['DATE(Requirement.created) <='] = date('Y-m-d', strtotime($to_date));
        }
        //pr($cond); 
        $this->request->session()->write('requirementsearch', $cond);

        $Job = $this->Requirement->find('all')->contain(['Eventtype', 'Users', 'Featuredjob'])->where([$cond, 'Requirement.jobdelete_status' => 'N'])->order(['Requirement.id' => 'DESC'])->toarray();
        //pr($Job); die;
        $this->set('Job', $Job);
    }


    public function requirmentexcel()
    {
        $this->loadModel('Users');
        $this->loadModel('Requirement');
        $this->loadModel('Jobquestion');
        $this->autoRender = false;
        $userid = $this->request->session()->read('Auth.User.id');
        $blank = "-";
        $output = "";

        $output .= '"Sr Number",';
        $output .= '"Job Title",';
        $output .= '"Talent Requirement",';
        $output .= '"Location",';
        $output .= '"Country",';
        $output .= '"State",';
        $output .= '"City",';
        $output .= '"Job Type",';
        $output .= '"Posting Type",';
        $output .= '"Event from Date",';
        $output .= '"Even to Date",';
        $output .= '"Posted for (No. of Days)",';
        $output .= '"Talent Type",';
        $output .= '"Posted By Name",';
        $output .= '"Posted By Email ID",';
        $output .= '"Posted by (Skill)",';
        $output .= '"Questionnaire",';
        $output .= '"Advertised (No. of Days)",';
        $output .= '"Featured (No. of Days)",';
        $output .= '"Bill Amount Paid",';
        $output .= '"Status",';
        $output .= "\n";
        //pr($job); die;
        $str = "";

        $cond = $this->request->session()->read('requirementsearch');


        $requirment = $this->Requirement->find('all')->contain(['Users' => ['Skillset' => ['Skill']], 'Eventtype', 'Featuredjob', 'RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City'])->order(['Requirement.id' => 'desc'])->where(['Requirement.jobdelete_status' => 'N', $cond])->toarray();
        //pr($requirment); die;
        $cnt = 1;
        foreach ($requirment as $admin) {
            //pr($admin); die;

            $jobquestion = $this->Jobquestion->find('all')->where(['job_id' => $admin['id']])->count();

            $output .= $cnt . ",";
            $output .= $admin['title'] . ",";

            foreach ($admin['requirment_vacancy'] as $key => $value) {
                $output .= $value['skill']['name'] . " ";
            }
            $output .= ",";
            $output .= str_replace(',', ' ', $admin['location']) . ",";
            $output .= $admin['country']['name'] . ",";
            $output .= $admin['state']['name'] . ",";
            $output .= $admin['city']['name'] . ",";

            if ($admin['continuejob'] == 'Y') {
                $output .= '"Continuous",';
            } else {
                $output .= '"Non continuous",';
            }

            if ($admin['Posting_type']) {
                $output .= $admin['Posting_type'] . ",";
            } else {
                $output .= $blank . ',';
            }


            $fromdate = date('Y-m-d', strtotime($admin['event_from_date']));
            $todate = date('Y-m-d', strtotime($admin['event_to_date']));
            //echo $fromdate; die;

            $output .= $fromdate . ",";
            $output .= $todate . ",";

            $date1 = date_create($fromdate);
            $date2 = date_create($todate);
            $diff = date_diff($date1, $date2);


            $output .= $diff->days . ",";

            if ($admin['user']['role_id'] == '2') {
                $output .= '"Talent",';
            } else {
                $output .= '"Non Talent",';
            }

            $output .= $admin['user']['user_name'] . ",";
            $output .= $admin['user']['email'] . ",";

            if ($admin['user']['skillset']) {
                $knownskills = '';
                foreach ($admin['user']['skillset'] as $skillquote) {
                    if (!empty($knownskills)) {
                        $knownskills = $knownskills . ', ' . $skillquote['skill']['name'];
                    } else {
                        $knownskills = $skillquote['skill']['name'];
                    }
                }
                $output .= str_replace(',', ' ', $knownskills) . ',';
            } else {
                $output .= '"Non Talent",';
            }

            if ($jobquestion > 0) {
                $output .= '"Yes",';
            } else {
                $output .= '"No",';
            }

            $output .= $blank . ",";

            $output .= $admin['feature_job_days'] . "days,";

            if ($admin['featuredjob']) {
                $output .= "$" . $admin['feature_job_days'] * $admin['featuredjob']['price'] . ",";
            } else {
                $output .= '"0",';
            }


            if ($admin['status'] == 'Y') {
                $output .= "Activate";
            } else {
                $output .= "Deactivate";
            }

            $cnt++;
            $output .= "\r\n";
        }

        $filename = "Requirements.csv";
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        echo $output;
        die;
        $this->redirect($this->referer());
    }


    // For Pack Active
    public function status($id, $status)
    {

        $this->loadModel('Requirement');
        if (isset($id) && !empty($id)) {
            if ($status == 'N') {

                $status = 'Y';
                $Pack = $this->Requirement->get($id);
                $Pack->status = $status;
                if ($this->Requirement->save($Pack)) {
                    $this->Flash->success(__('Requirement status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            } else {

                $status = 'N';
                $Pack = $this->Requirement->get($id);
                $Pack->status = $status;
                if ($this->Requirement->save($Pack)) {
                    $this->Flash->success(__('Requirement status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }

    // For Requirement Delete
    /*public function delete($id){ 
    $this->loadModel('Requirement');
    $Genre = $this->Requirement->get($id);
    
    if ($this->Requirement->delete($Genre)) {
        $this->Flash->success(__('The Requirement with id: {0} has been deleted.', h($id)));
        return $this->redirect(['action' => 'index']);
    }
}
*/
    public function delete($id)
    {

        $this->loadModel('Requirement');
        $Pack = $this->Requirement->get($id);
        $jobdelstatus = 'Y';
        $status = 'N';
        $Pack->jobdelete_status = $jobdelstatus;
        $Pack->status = $status;
        if ($this->Requirement->save($Pack)) {
            $this->Flash->success(__('Requirement has been deleted.'));
            return $this->redirect(['action' => 'index']);
        }
    }


    // For Pack featured 
    public function setdefult($id, $status)
    {

        $this->loadModel('Requirement');
        $this->loadModel('Settings');
        // pr($id);
        // pr($status);exit;
        if (isset($id) && !empty($id)) {
            if ($status == 'N') {
                //  $status = 'N';
                $talent = $this->Requirement->get($id);
                $talent->featured = $status;
                $talent->expiredate = '';
                $talent->feature_job_days = 0;
                if ($this->Requirement->save($talent)) {
                    $this->Flash->success(__('Requirement featured has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $setting = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();

                $expiredays = $setting->featured_job_days;
                $currentdate = date('Y-m-d H:m:s');
                $expiredate = date('Y-m-d H:m:s', strtotime($currentdate . "+$expiredays days"));
                //$status = 'Y';
                $talent = $this->Requirement->get($id);
                $talent->featured = $status;
                $talent->feature_job_days = $expiredays;
                $talent->expiredate = $expiredate;

                if ($this->Requirement->save($talent)) {
                    $this->Flash->success(__('Requirement featured has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }


    public function details($id)
    {

        $this->loadModel('Requirement');

        try {

            $details = $this->Requirement->find('all')->contain(['RequirmentVacancy' => ['Skill', 'Currency'], 'Country', 'State', 'City'])->where(['Requirement.id' => $id])->first();
            $this->set('requirement_data', $details);
        } catch (FatalErrorException $e) {

            $this->log("Error Occured", 'error');
        }
    }



    public function joadvrtdetail($jid = null)
    {

        $this->loadModel('Requirement');
        $this->loadModel('Users');
        $this->loadModel('Jobadvertpack');
        $currentdate = date('Y-m-d H:m:s');
        $session = $this->request->session();
        $session->delete('advrtjobsearch');

        $Job = $this->Jobadvertpack->find('all')->where(['Jobadvertpack.requir_id' => $jid])->toarray();
        //pr($Job); die;
        $this->set('Job', $Job);
    }
}
