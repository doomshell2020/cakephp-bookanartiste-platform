<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class ProfileadvertpackController extends AppController
{

    public $paginate = [
        'limit' => 25,
        'order' => [
            'Profileadvertpack.id' => 'asc'
        ]
    ];
    public function initialize()
    {
        parent::initialize();
        //$this->loadComponent('Paginator');

    }

    // For Banner pack add    
    public function index($id = null)
    {

        $this->loadModel('Profileadvertpack');
        $this->loadModel('Users');
        $this->viewBuilder()->layout('admin');
        $Profilepack = $this->Profileadvertpack->find('all')->order(['id' => 'asc'])->first();
        $this->set('Profilepack', $Profilepack);

        if (isset($id) && !empty($id)) {
            $packentity = $this->Profileadvertpack->get($id);
        } else {
            $packentity = $this->Profileadvertpack->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {

            $transports = $this->Profileadvertpack->patchEntity($packentity, $this->request->data);
            if ($resu = $this->Profileadvertpack->save($transports)) {

                $this->Flash->success(__('Profile advertisement price has been changed.'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set('packentity', $packentity);

        $session = $this->request->session();
        $session->delete('adprosearchs');

        $alladvtpro = $this->Profileadvertpack->find('all')->contain(['Users'])->order(['Profileadvertpack.id' => DESC])->toarray();
        //pr($alladvtpro); die;
        $this->set('alladvtpro', $alladvtpro);
    }

    public function search()
    {
        $this->loadModel('Users');
        $this->loadModel('Requirement');
        $this->loadModel('Jobadvertpack');
        //pr($this->request->data); die;
        $currentdate = date('Y-m-d H:m:s');
        $status = $this->request->data['status'];
        $name = $this->request->data['name'];
        $email = $this->request->data['email'];
        $from_date = $this->request->data['from_date'];
        $to_date = $this->request->data['to_date'];
        $cond = [];


        if (!empty($name)) {
            $cond['Users.user_name LIKE'] = "%" . $name . "%";
        }
        if (!empty($email)) {
            $cond['Users.email LIKE'] = "%" . $email . "%";
        }

        if (!empty($from_date)) {
            $cond['DATE(Profileadvertpack.created) >='] = date('Y-m-d', strtotime($from_date));
        }
        if (!empty($to_date)) {
            $cond['DATE(Profileadvertpack.created) <='] = date('Y-m-d', strtotime($to_date));
        }
        $this->request->session()->write('adprosearchs', $cond);


        $alladvtpro = $this->Profileadvertpack->find('all')->contain(['Users'])->where([$cond])->order(['Profileadvertpack.id' => DESC])->toarray();
        $this->set('alladvtpro', $alladvtpro);
    }


    public function advrtproexcel()
    {

        $currentdate = date('Y-m-d H:m:s');
        $this->loadModel('Users');
        $this->loadModel('Profileadvertpack');
        $this->loadModel('Transcation');
        $this->autoRender = false;

        $blank = "NA";
        $output = "";

        $output .= '"Sr Number",';
        $output .= '"User Name",';
        $output .= '"User Email Id",';
        $output .= '"Ad Date From",';
        $output .= '"Ad Date To",';
        $output .= '"Number of Days",';
        $output .= '"Total Price Paid",';
        $output .= '"Status",';
        $output .= "\n";
        //pr($job); die;
        $str = "";

        $cond = $this->request->session()->read('adprosearchs');


        $banners = $this->Profileadvertpack->find('all')->contain(['Users'])->where([$cond])->order(['Profileadvertpack.id' => DESC])->toarray();
        //pr($talents); die;
        $cnt = 1;
        foreach ($banners as $admin) {
            $mytransactions = $this->Transcation->find('all')->where(['advrt_profile_id' => $admin['id']])->first();
            if ($mytransactions['amount'] > 0) {
                $totalamount = $mytransactions['amount'];
            } else {
                $totalamount = "0";
            }

            $currentdate = date('Y-m-d H:m:s');
            $todates = date('Y-m-d H:m:s', strtotime($admin['ad_date_to']));

            $fromdate = date('Y-m-d', strtotime($admin['ad_date_from']));
            $todate = date('Y-m-d', strtotime($admin['ad_date_to']));
            $date1 = date_create($fromdate);
            $date2 = date_create($todate);
            $diff = date_diff($date1, $date2);
            $bannerdays = $diff->days;

            $output .= $cnt . ",";
            $output .= $admin['user']['user_name'] . ",";
            $output .= $admin['user']['email'] . ",";
            if ($admin['ad_date_from']) {
                $output .= $fromdate . ",";
            } else {
                $output .= "NA,";
            }

            if ($admin['ad_date_to']) {
                $output .= $todate . ",";
            } else {
                $output .= "NA,";
            }

            $output .= $bannerdays . "days ,";
            $output .= "$" . $totalamount . ",";

            if ($todates >= $currentdate) {
                $output .= "Ad Active,";
            } else {
                $output .= "Ad Inactive,";
            }

            $cnt++;
            $output .= "\r\n";
        }

        $filename = "Advertise-Profiles.xlsx";
        header('Content-type: application/xlsx');
        header('Content-Disposition: attachment; filename=' . $filename);
        echo $output;
        die;
        $this->redirect($this->referer());
    }

    // For Country Active
    public function status($id, $status)
    {

        $this->loadModel('Profileadvertpack');
        if (isset($id) && !empty($id)) {
            if ($status == 'N') {

                $status = 'Y';
                $adpack = $this->Profileadvertpack->get($id);
                $adpack->status = $status;
                if ($this->Profileadvertpack->save($adpack)) {
                    $this->Flash->success(__('Status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            } else {

                $status = 'N';
                $adpack = $this->Profileadvertpack->get($id);
                $adpack->status = $status;
                if ($this->Profileadvertpack->save($adpack)) {
                    $this->Flash->success(__('Status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }
}
