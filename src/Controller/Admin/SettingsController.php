<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
class SettingsController extends AppController
{

    // For Setting  add
    public function add($id = null)
    {
        $this->loadModel('Settings');

        $this->viewBuilder()->layout('admin');
        if (isset($id) && !empty($id)) {

            $packentity = $this->Settings->get($id);
        } else {

            $packentity = $this->Settings->newEntity();
        }
        if ($this->request->is(['post', 'put'])) {

            $Settings = $this->Settings->patchEntity($packentity, $this->request->data);
            if ($resu = $this->Settings->save($Settings)) {
                $this->Flash->success(__('Settings pack has been saved.'));
                return $this->redirect(['action' => 'add' . '/' . $id]);
            }
        }

        $this->set('packentity', $packentity);
    }

    public function index()
    {
        $this->loadModel('Settings');
        $this->viewBuilder()->layout('admin');
        $settingdetails = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->toarray();
        $this->set('settingdetails', $settingdetails);
    }
    // For setting Active
    public function status($id, $status)
    {
        $this->loadModel('Settings');
        if (isset($id) && !empty($id)) {
            if ($status == 'N') {
                $status = 'Y';
                $Pack = $this->Settings->get($id);
                $Pack->status = $status;
                if ($this->Settings->save($Pack)) {
                    $this->Flash->success(__('Settings  status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            } else {

                $status = 'N';
                $Pack = $this->Settings->get($id);
                $Pack->status = $status;
                if ($this->Settings->save($Pack)) {
                    $this->Flash->success(__('Settings status has been updated.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
        }
    }
    public function export_database()
    {
    }
}