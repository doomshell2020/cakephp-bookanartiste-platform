<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class RecuriterpackController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }
    // For Quotepack package  Index
    public function index()
    {


        $this->loadModel('RecuriterPack');
        $this->viewBuilder()->layout('admin');
        $RecuriterPack = $this->RecuriterPack->find('all')->order(['RecuriterPack.id' => 'ASC'])->toarray();
        $this->set(compact('RecuriterPack'));
    }

    // For add Quotepack package
    public function add($id = null)
    {

        $this->loadModel('RecuriterPack');
        $this->viewBuilder()->layout('admin');

        if (isset($id) && !empty($id)) {
            $packentity = $this->RecuriterPack->get($id);
        } else {
            $packentity = $this->RecuriterPack->newEntity();
        }

        if ($this->request->is(['post', 'put'])) {
            // pr($this->request->data);exit;

            $imagefilename = $this->request->data['Icon']['name'];
            if ($imagefilename) {
                $item = $this->request->data['Icon']['tmp_name'];
                $ext =  end(explode('.', $imagefilename));
                $name = md5(time($filename));
                $imagename = $name . '.' . $ext;
                $this->request->data['icon'] = $imagename;
                if (move_uploaded_file($item, "img/" . $imagename)) {
                    $this->request->data['icon'] = $imagename;
                }
            }
            $transports = $this->RecuriterPack->patchEntity($packentity, $this->request->data);
            if ($resu = $this->RecuriterPack->save($transports)) {
                $this->Flash->success(__('RecuriterPack has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set('packentity', $packentity);
    }

    // For Quotepack  Delete
    public function delete($id)
    {

        $this->loadModel('RecuriterPack');
        $talent = $this->RecuriterPack->get($id);
        if ($this->RecuriterPack->delete($talent)) {
            $this->Flash->success(__('The RecuriterPack with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
        }
    }

    // For Pack Active
    public function status($id, $status)
    {
        // pr($status); die;
        $this->loadModel('RecuriterPack');

        $talent = $this->RecuriterPack->get($id);
        $talent->status = $status;
        $this->RecuriterPack->save($talent);
        $active_pack_count = $this->RecuriterPack->find('all')->where(['status' => 'Y'])->count();
        if ($active_pack_count == 0) {
            $talent->status = 'Y';
            $this->RecuriterPack->save($talent);
            $this->Flash->error(__('Atleast one package has to be active at all times.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->success(__('RecuriterPack status has been updated.'));
            return $this->redirect(['action' => 'index']);
        }
    }
    // packdata in model
    public function profilepackdata($id)
    {

        $this->loadModel('RecuriterPack');
        try {
            $profilepack = $this->RecuriterPack->find('all')->where(['RecuriterPack.id' => $id])->first()->toarray();
            $this->set('profile', $profilepack);
        } catch (FatalErrorException $e) {
            $this->log("Error Occured", 'error');
        }
    }
}
