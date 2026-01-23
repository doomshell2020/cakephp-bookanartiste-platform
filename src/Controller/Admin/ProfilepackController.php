<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;

class ProfilepackController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }
    // For Profile package  Index
    public function index()
    {
        $this->loadModel('Profilepack');
        $this->viewBuilder()->layout('admin');
        $Profilepack = $this->Profilepack->find('all')->order(['Profilepack.id' => 'ASC'])->toarray();
        $this->set(compact('Profilepack'));
    }
    // For add profile package
    
    public function add($id = null)
    {
        $this->loadModel('Profilepack');
        $this->viewBuilder()->layout('admin');

        if (isset($id) && !empty($id)) {
            $packentity = $this->Profilepack->get($id);
        } else {
            $packentity = $this->Profilepack->newEntity();
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

            $transports = $this->Profilepack->patchEntity($packentity, $this->request->data);
            if ($resu = $this->Profilepack->save($transports)) {
                $conss = ConnectionManager::get('default');
                $show_on_home_page = $this->request->data['show_on_home_page'];
                $show_on_home_page = serialize($show_on_home_page);
                $con = ConnectionManager::get('default');
                // rupam sir
                // $detail = 'UPDATE `profile_package` SET `show_on_home_page` ="' . mysqli_real_escape_string($show_on_home_page) . '" WHERE `id`= ' . $resu->id . '';
                // $results = $con->execute($detail);
                $detail = 'UPDATE `profile_package` SET `show_on_home_page` = :show_on_home_page WHERE `id` = :id';

                // Bind values to placeholders
                $params = [
                    'show_on_home_page' => $show_on_home_page,
                    'id' => $resu->id
                ];

                // Execute the query
                $results = $con->execute($detail, $params);
                // end qu3ery
                $show_on_package_page = $this->request->data['show_on_package_page'];
                $show_on_package_page = serialize($show_on_package_page);
                $conss = ConnectionManager::get('default');
                // rupam sir
                // $detailpak = 'UPDATE `profile_package` SET `show_on_package_page` ="' . $show_on_package_page . '" WHERE `id`= ' . $resu->id . '';
                $detailpak = 'UPDATE `profile_package` SET `show_on_package_page` = :show_on_package_page WHERE `id` = :id';
                $params = [
                    'show_on_package_page' => $show_on_package_page,
                    'id' => $resu->id
                ];

                $results = $conss->execute($detailpak, $params);
                $this->Flash->success(__('Profile pack has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
        }
        $this->set('packentity', $packentity);
    }
    // For Package  Delete
    public function delete($id)
    {

        $this->loadModel('Profilepack');
        $talent = $this->Profilepack->get($id);
        if ($this->Profilepack->delete($talent)) {
            $this->Flash->success(__('The Profilepack with id: {0} has been deleted.', h($id)));
            return $this->redirect(['action' => 'index']);
        }
    }
    // For Pack Active
    public function status($id, $status)
    {
        $this->loadModel('Profilepack');
        $talent = $this->Profilepack->get($id);
        $talent->status = $status;
        $this->Profilepack->save($talent);
        $active_pack_count = $this->Profilepack->find('all')->where(['status' => 'Y'])->count();
        if ($active_pack_count == 0) {
            $talent->status = 'Y';
            $this->Profilepack->save($talent);
            $this->Flash->error(__('Atleast one package has to be active at all times.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->success(__('Profilepack status has been updated.'));
            return $this->redirect(['action' => 'index']);
        }
    }
    public function profilepackdata($id)
    {
        $this->loadModel('Profilepack');
        try {
            $profilepack = $this->Profilepack->find('all')->where(['Profilepack.id' => $id])->first()->toarray();
            $this->set('profile', $profilepack);
        } catch (FatalErrorException $e) {
            $this->log("Error Occured", 'error');
        }
    }
    public function setdefult($id, $status)
    {
        $this->loadModel('Profilepack');
        if (isset($id) && !empty($id)) {
            if ($status == 'N') {
                $status = 'N';
                $talent = $this->Profilepack->get($id);
                $talent->featured = $status;
                if ($this->Profilepack->save($talent)) {

                    $this->Flash->success(__('Profilepack featured has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            } else {
                $status = 'Y';
                $talent = $this->Profilepack->get($id);
                $talent->featured = $status;
                if ($this->Profilepack->save($talent)) {
                    $query2 = "UPDATE `profile_package` SET `featured` = 'N' WHERE `profile_package`.`id` != '$id';";
                    $conn = ConnectionManager::get('default');
                    $conn->execute($query2);
                    $this->Flash->success(__('Profilepack featured has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }
}
