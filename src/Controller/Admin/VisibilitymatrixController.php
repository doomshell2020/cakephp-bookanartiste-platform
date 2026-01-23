<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;

class VisibilitymatrixController extends AppController
{

	// public function index($id = null)
	// {
	// 	$this->loadModel('Profilepack');
	// 	$this->loadModel('RecuriterPack');
	// 	$this->loadModel('VisibilityMatrix');
	// 	$this->viewBuilder()->layout('admin');

	// 	$profilepack = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y'])->toarray();
	// 	$this->set(compact('profilepack'));
	// 	// pr($profilepack);exit;

	// 	$recruiterpack = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y'])->toarray();
	// 	$this->set(compact('recruiterpack'));

	// 	$vismatrix = $this->VisibilityMatrix->find('all')->where()->toarray();
	// 	$idcheck = count($vismatrix);

	// 	if ($idcheck > 0) {
	// 		$matrix = $this->VisibilityMatrix->find('all')->order(['id'=>'DESC'])->toarray();
	// 	} else {
	// 		$matrix = $this->VisibilityMatrix->newEntity();
	// 	}
	// 	$this->set(compact('matrix'));

	// 	if ($this->request->is(['post', 'put'])) {
	// 		$prop_data = array();
	// 		pr($this->request->data);exit;
	// 		foreach ($this->request->data['Visibilitymatrix'] as $key => $value) {

	// 			foreach ($value as $rec => $recvalue) {
	// 				$prop_data['recruiter_id'] = $rec;
	// 				$prop_data['ordernumber'] = $recvalue;
	// 				$prop_data['profilepack_id'] = $key;
	// 				if ($this->request->data['hid'][$key][$rec] > 0) {
	// 					$matrix_id = $this->request->data['hid'][$key][$rec];

	// 					$optionspay = $this->VisibilityMatrix->get($matrix_id);
	// 					$option_pay = $this->VisibilityMatrix->patchEntity($optionspay, $prop_data);
	// 					$savedata = $this->VisibilityMatrix->save($option_pay);
	// 				} else {
	// 					$optionsweb = $this->VisibilityMatrix->newEntity();
	// 					$option_web = $this->VisibilityMatrix->patchEntity($optionsweb, $prop_data);
	// 					$savedata = $this->VisibilityMatrix->save($option_web);
	// 				}
	// 			}
	// 		}
	// 		$this->Flash->success(__('Visibility Matrix Saved Successfully'));
	// 		return $this->redirect(['action' => 'index']);
	// 	}
	// }


	// Rupam Singh 05/06/2023
	public function index($id = null)
	{
		$this->loadModel('Profilepack');
		$this->loadModel('RecuriterPack');
		$this->loadModel('RequirementPack');
		$this->loadModel('VisibilityMatrix');
		$this->viewBuilder()->layout('admin');

		$profilepack = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y'])->toarray();
		$this->set(compact('profilepack'));
		// pr($profilepack);exit;

		$recruiterpack = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y'])->toarray();
		$this->set(compact('recruiterpack'));

		$vismatrix = $this->VisibilityMatrix->find('all')->where()->toarray();
		$idcheck = count($vismatrix);

		$findRequirementPack = $this->RequirementPack->find('all')
			->select(['priorites'])
			->toArray(); // Convert result to an array

		$priorities = array_column($findRequirementPack, 'priorites'); // Extract 'priorites' column
		$prioritiesText = implode(', ', $priorities);


		// pr($priorities);exit;

		if ($idcheck > 0) {
			$matrix = $this->VisibilityMatrix->find('all')->order(['id' => 'DESC'])->toarray();
		} else {
			$matrix = $this->VisibilityMatrix->newEntity();
		}
		$this->set(compact('matrix', 'prioritiesText'));

		if ($this->request->is(['post', 'put'])) {
			// pr($this->request->data);
			$prop_data = array();

			foreach ($this->request->data['Visibilitymatrix'] as $recruiter_package_id => $value) {
				foreach ($value as $rec_package_id => $recvalue) {
					$prop_data['recruiter_id'] = $recruiter_package_id;
					$prop_data['ordernumber'] = $recvalue;
					$prop_data['profilepack_id'] = $rec_package_id;

					// pr($recruiter_package_id);
					// pr($this->request->data['hid'][$recruiter_package_id][$rec_package_id]);exit;

					if ($this->request->data['hid'][$recruiter_package_id][$rec_package_id] > 0) {
						$matrix_id = $this->request->data['hid'][$recruiter_package_id][$rec_package_id];

						$optionspay = $this->VisibilityMatrix->get($matrix_id);
						$option_pay = $this->VisibilityMatrix->patchEntity($optionspay, $prop_data);
						$savedata = $this->VisibilityMatrix->save($option_pay);
					} else {
						$optionsweb = $this->VisibilityMatrix->newEntity();
						$option_web = $this->VisibilityMatrix->patchEntity($optionsweb, $prop_data);
						$savedata = $this->VisibilityMatrix->save($option_web);
					}
				}
			}

			$this->Flash->success(__('Visibility Matrix Saved Successfully'));
			return $this->redirect(['action' => 'index']);
		}
	}
}
