<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\View\Helper\PaginatorHelper;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\Datasource\ConnectionManager;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

use PHPExcel_IOFactory;
use PHPExcel;


include '../vendor/PHPExcel/Classes/PHPExcel.php';
include '../vendor/PHPExcel/Classes/PHPExcel/IOFactory.php';

class TalentadminController extends AppController
{

	public $paginate = [
		'limit' => 25,
		'order' => ['TalentAdmin.id' => 'asc'],
	];
	public function initialize()
	{
		parent::initialize();
		//$this->loadComponent('Paginator');
	}

	public  function _setPassword($password)
	{
		return (new DefaultPasswordHasher)->hash($password);
	}
	public function comissionmanager()
	{
		$this->loadModel('Users');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Skill');
		$this->loadModel('Talentadminskill');

		$this->viewBuilder()->layout('admin');
		$where = " where users.is_talent_admin='Y'";
		$this->request->session()->write('talent_comission_filter', $where);

		$conn = ConnectionManager::get('default');
		$talent_qry = " SELECT talent_admin.*,
		talent_admin.created_date as talent_from, 
		users.email,users.user_name,
		ta.user_name as talentname, 
		ta.email as talentemail, 
		users.created as membership_from, 
		GROUP_CONCAT(skill_type.name) as skill_name, 
		users.is_talent_admin, 
		country.name as country, 
		states.name as state, 
		cities.name as city, 
		(Select SUM(amount)-SUM(payout_amount) as dues  
		from talentadmintransc where talentadmintransc.talent_admin_id=users.id ) as total, 
		(Select SUM(amount) as comissionearened  
		from talentadmintransc where talentadmintransc.talent_admin_id=users.id ) as commissionearned  
		from talent_admin 
		INNER join users on users.id=talent_admin.user_id 
		LEFT join users ta on ta.id=talent_admin.talentdadmin_id 
		LEFT JOIN talentadminskill on talent_admin.id=talentadminskill.talent_admin_id  
		LEFT JOIN skill_type ON talentadminskill.skill_id=skill_type.id 
		LEFT JOIN country on country.id=talent_admin.bank_country 
		left join states on states.id=talent_admin.bank_state 
		left join cities on cities.id=talent_admin.bank_city " . $where . "  group by users.id ";
		//pr($talent_qry);

		$talent = $conn->execute($talent_qry);
		$talents = $talent->fetchAll('assoc');
		$this->set(compact('talents'));

		$this->loadModel('Country');
		//$country = $this->Country->find('list')->select(['id','name'])->toarray();
		$country = $this->TalentAdmin->find('all')->select(['Country.name', 'Country.id'])->contain(['Country'])->order(['Country.name' => 'ASC'])->toarray();

		//pr($country); die;
		$this->set('country', $country);
	}

	//Talent admin partners bank details
	public function bankdetails($id = null)
	{
		$this->loadModel('TalentAdmin');
		$where = " where talent_admin.user_id=$id";

		$conn = ConnectionManager::get('default');
		$talent_qry = " SELECT talent_admin.*,
		users.email,
		users.user_name,
		ta.user_name as talentname, 
		ta.email as talentemail,
		country.name as country, 
		states.name as state, 
		cities.name as city, 	
		users.is_talent_admin

		from talent_admin 
		INNER join users on users.id=talent_admin.user_id 
		LEFT join users ta on ta.id=talent_admin.talentdadmin_id 
		LEFT JOIN country on country.id=talent_admin.bank_country 
		left join states on states.id=talent_admin.bank_state 
		left join cities on cities.id=talent_admin.bank_city " . $where . "";
		//pr($talent_qry);

		$talent = $conn->execute($talent_qry);
		$talents = $talent->fetchAll('assoc');
		$this->set(compact('talents'));
		//pr($talents); die;
	}



	//commission manager searching...
	public function searchcommission()
	{
		$this->loadModel('Users');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Skill');
		$this->loadModel('Talentadminskill');

		$from_date = date('Y-m-d', strtotime($this->request->data['from_date']));
		$to_date = date('Y-m-d', strtotime($this->request->data['to_date']));
		$user_type = $this->request->data['user_type'];
		$talent_name = $this->request->data['talent_name'];
		$email = $this->request->data['email'];

		//pr($from_date);

		$where = " where users.is_talent_admin = 'Y'";

		$cond = [];
		if (!empty($user_type)) {
			$where .= " AND users.role_id = '" . $user_type . "'";
		}

		if (!empty($talent_name)) {
			$where .= " AND users.user_name LIKE '%" . $talent_name . "%'";
		}


		if (!empty($email)) {
			$where .= " AND users.email LIKE '%" . $email . "%'";
		}


		if (!empty($from_date) && !empty($to_date)) {
			$where .= " AND STR_TO_DATE(talent_admin.created_date,'%Y-%m-%d') between '" . $from_date . "' and '" . $to_date . "'";
		}


		$this->request->session()->write('talent_comission_filter', $where);
		$conn = ConnectionManager::get('default');
		$talent_qry = " SELECT talent_admin.*,
		talent_admin.created_date as talent_from, 
		users.email,
		users.user_name,
		ta.user_name as talentname, 
		ta.email as talentemail, 
		users.created as membership_from, 
		GROUP_CONCAT(skill_type.name) as skill_name, 
		users.is_talent_admin, 
		country.name as country, 
		states.name as state, 
		cities.name as city, 
		(Select SUM(amount)-SUM(payout_amount) as dues  
		from talentadmintransc where talentadmintransc.talent_admin_id=users.id ) as total, 
		(Select SUM(amount) as comissionearened  
		from talentadmintransc where talentadmintransc.talent_admin_id=users.id ) as commissionearned  
		from talent_admin 
		INNER join users on users.id=talent_admin.user_id 
		LEFT join users ta on ta.id=talent_admin.talentdadmin_id 
		LEFT JOIN talentadminskill on talent_admin.id=talentadminskill.talent_admin_id  
		LEFT JOIN skill_type ON talentadminskill.skill_id=skill_type.id 
		LEFT JOIN country on country.id=talent_admin.bank_country 
		left join states on states.id=talent_admin.bank_state 
		left join cities on cities.id=talent_admin.bank_city " . $where . "  group by users.id ";
		//echo $talent_qry; die;
		$talent = $conn->execute($talent_qry);
		$talents = $talent->fetchAll('assoc');
		$this->set(compact('talents'));
	}


	// change on 27/04/2024
	// Export Commission manager Talent admin 
	// public function exportcommission()
	// {

	// 	$this->autoRender = false;
	// 	$blank = "NA";
	// 	$conn = ConnectionManager::get('default');
	// 	$output = "";

	// 	$output .= '"Sr Number",';
	// 	$output .= '"Talent Partner Name",';
	// 	$output .= '"Talent Partner Email",';
	// 	$output .= '"Creator Name",';
	// 	$output .= '"Creator E Mail id",';
	// 	$output .= '"Membership from",';
	// 	$output .= '"Talent Partner from",';
	// 	$output .= '"Revenue Share Due",';
	// 	$output .= "\n";
	// 	//pr($job); die;
	// 	$str = "";

	// 	//$where = " where users.is_talent_admin = 'Y'";
	// 	$where = $this->request->session()->read('talent_comission_filter');
	// 	$conn = ConnectionManager::get('default');
	// 	$talent_qry = " SELECT talent_admin.*,
	// 	talent_admin.created_date as talent_from, 
	// 	users.email,users.user_name,
	// 	ta.user_name as talentname, 
	// 	ta.email as talentemail, 
	// 	users.created as membership_from,  
	// 	users.is_talent_admin, 
	// 	(Select SUM(amount)-SUM(payout_amount) as dues  
	// 	from talentadmintransc where talentadmintransc.talent_admin_id=users.id ) as total, 
	// 	(Select SUM(amount) as comissionearened  
	// 	from talentadmintransc where talentadmintransc.talent_admin_id=users.id ) as commissionearned  
	// 	from talent_admin 
	// 	INNER join users on users.id=talent_admin.user_id 
	// 	LEFT join users ta on ta.id=talent_admin.talentdadmin_id 
	// 	LEFT JOIN talentadminskill on talent_admin.id=talentadminskill.talent_admin_id  
	// 	" . $where . "  group by users.id ";
	// 	//echo $talent_qry; die;
	// 	$talent = $conn->execute($talent_qry);
	// 	$talents = $talent->fetchAll('assoc');

	// 	//pr($talents); die;
	// 	$cnt = 1;
	// 	foreach ($talents as $talent_data) {
	// 		$this->loadModel('Users');
	// 		if ($talent_data['talentdadmin_id'] == 0) {
	// 			$talentName = "Admin";
	// 			$talentEmail = "Admin";
	// 		} else {
	// 			$talentName = $talent_data['talentname'];
	// 			$talentEmail = $talent_data['talentemail'];
	// 		}
	// 		$output .= $cnt . ",";
	// 		$output .= $talent_data['user_name'] . ",";
	// 		$output .= $talent_data['email'] . ",";
	// 		$output .= $talentName . ",";
	// 		$output .= $talentEmail . ",";
	// 		$output .= $talent_data['membership_from'] . ",";
	// 		$output .= $talent_data['talent_from'] . ",";
	// 		$output .= $talent_data['total'] . ",";

	// 		$cnt++;
	// 		$output .= "\r\n";
	// 	}

	// 	$filename = "Talent Partners.xlsx";
	// 	header('Content-type: application/xlsx');
	// 	header('Content-Disposition: attachment; filename=' . $filename);
	// 	echo $output;
	// 	die;
	// 	$this->redirect($this->referer());
	// }
	public function exportcommission()
	{
		// Disable auto-rendering
		$this->autoRender = false;

		// Create a new instance of PHPExcel
		$objPHPExcel = new PHPExcel();

		// Set properties for the Excel file
		$objPHPExcel->getProperties()
			->setCreator("Your Name")
			->setLastModifiedBy("Your Name")
			->setTitle("Talent Partners Commission Export")
			->setSubject("Talent Partners Commission Export")
			->setDescription("Export of talent partners commission data in Excel format.")
			->setKeywords("talent partners commission export excel")
			->setCategory("Exported data");

		// Set column widths for better readability
		$columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
		foreach ($columns as $col) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}

		// Define the header row
		$headers = [
			'Sr Number', 'Talent Partner Name', 'Talent Partner Email', 'Creator Name',
			'Creator Email', 'Membership from', 'Talent Partner from', 'Revenue Share Due'
		];
		$objPHPExcel->getActiveSheet()->fromArray($headers, null, 'A1');

		// Get data from database
		$conn = ConnectionManager::get('default');
		$where = $this->request->session()->read('talent_commission_filter');
		$talent_qry = " SELECT talent_admin.*,
		 	talent_admin.created_date as talent_from, 
		 	users.email,users.user_name,
		 	ta.user_name as talentname, 
		 	ta.email as talentemail, 
		 	users.created as membership_from,  
		 	users.is_talent_admin, 
		 	(Select SUM(amount)-SUM(payout_amount) as dues  
		 	from talentadmintransc where talentadmintransc.talent_admin_id=users.id ) as total, 
		 	(Select SUM(amount) as comissionearened  
		 	from talentadmintransc where talentadmintransc.talent_admin_id=users.id ) as commissionearned  
		 	from talent_admin 
		 	INNER join users on users.id=talent_admin.user_id 
		 	LEFT join users ta on ta.id=talent_admin.talentdadmin_id 
		 	LEFT JOIN talentadminskill on talent_admin.id=talentadminskill.talent_admin_id  
		 	" . $where . "  group by users.id ";

		// Execute the query and fetch the results
		$talentResult = $conn->execute($talent_qry);
		$talents = $talentResult->fetchAll('assoc');

		// Initialize row counter starting from the second row
		$row = 2;
		$cnt = 1;

		// Iterate through the data and populate the Excel sheet
		foreach ($talents as $talentData) {
			// Prepare the data for each row
			$talentName = ($talentData['talentdadmin_id'] == 0) ? 'Admin' : $talentData['talentname'];
			$talentEmail = ($talentData['talentdadmin_id'] == 0) ? 'Admin' : $talentData['talentemail'];

			$rowData = [
				$cnt,
				$talentData['user_name'],
				$talentData['email'],
				$talentName,
				$talentEmail,
				date('M-d-Y', strtotime($talentData['membership_from'])),
				date('M-d-Y', strtotime($talentData['talent_from'])),
				$talentData['total'] ? number_format($talentData['total'], 2) : 'NA'
			];

			// Write the row data to the Excel sheet
			$objPHPExcel->getActiveSheet()->fromArray($rowData, null, 'A' . $row);

			// Increment row counter and Sr Number counter
			$row++;
			$cnt++;
		}

		// Set the active sheet index to the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Set the file headers for downloading the Excel file
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Talent_Partners_Commission.xlsx"');
		header('Cache-Control: max-age=0');

		// Create an Excel writer object
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		// Output the Excel file to the browser for downloading
		$objWriter->save('php://output');

		// End script execution
		exit();
	}






	// For talent admin index
	public function index()
	{
		$this->loadModel('Users');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Skill');
		$this->loadModel('Talentadminskill');

		$this->viewBuilder()->layout('admin');
		$where = "where users.is_talent_admin='Y'";
		//$where = "Users.is_talent_admin='Y'";
		$this->request->session()->write('talent_admin_filter', $where);

		$conn = ConnectionManager::get('default');
		/*$talents = $this->TalentAdmin->find('all')
	    ->select(['TalentAdmin.id','Users.email','City.name'])
	    ->contain(['Users'=>['Profile','Refers'],'Country','State','City'])->where([$where])->toarray();*/

		$talent_qry = " SELECT talent_admin.*,
	    talent_admin.created_date as talent_from, 
	    users.user_name, 
	    users.created as membership_from, 
	    GROUP_CONCAT(skill_type.name) as skill_name, 
	    users.is_talent_admin, 
	    cu31.name as country, 
	    cu32.name as bankcountry,
	    st33.name as state, 
	    st34.name as bankstate,
	    ct33.name as city, 
	    ct34.name as bankcity	     
	    from talent_admin 
	    INNER join users on users.id=talent_admin.user_id 
	    LEFT JOIN talentadminskill on talent_admin.id=talentadminskill.talent_admin_id  
	    LEFT JOIN skill_type ON talentadminskill.skill_id=skill_type.id 
	    LEFT JOIN country cu31 ON cu31.id = talent_admin.country_id 
	    LEFT JOIN country cu32 ON cu32.id = talent_admin.bank_country 
	    LEFT JOIN states st33 ON st33.id = talent_admin.state_id 
	    LEFT JOIN states st34 ON st34.id = talent_admin.bank_state
	    LEFT JOIN cities ct33 ON ct33.id = talent_admin.city_id 
	    LEFT JOIN cities ct34 ON ct34.id = talent_admin.bank_city " . $where . "  group by users.id order by id DESC";

		$talent = $conn->execute($talent_qry);
		$talents = $talent->fetchAll('assoc');
		//pr($talents); 
		$this->set(compact('talents'));

		$this->loadModel('Country');
		//$country = $this->Country->find('list')->select(['id','name'])->toarray();
		$country = $this->TalentAdmin->find('all')->select(['Country.name', 'Country.id'])->contain(['Country'])->order(['Country.name' => 'ASC'])->toarray();

		//pr($country); die;
		$this->set('country', $country);
	}


	//index page searching...
	public function search()
	{
		$this->loadModel('Users');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Skill');
		$this->loadModel('Talentadminskill');

		$from_date = $this->request->data['from_date'];
		$to_date = $this->request->data['to_date'];
		$user_type = $this->request->data['user_type'];
		$country_id = $this->request->data['country_id'];
		$state_id = $this->request->data['state_id'];
		$city_id = $this->request->data['city_id'];
		$skill = $this->request->data['skill'];
		$talent_name = $this->request->data['talent_name'];

		// pr($this->request->data);

		$where = " where users.is_talent_admin = 'Y'";

		$cond = [];
		if (!empty($user_type)) {
			$where .= " AND users.role_id = '" . $user_type . "'";
		}

		if (!empty($talent_name)) {
			$where .= " AND users.user_name LIKE '%" . $talent_name . "%'";
		}

		if (!empty($country_id)) {
			$where .= " AND talent_admin.country_id = '" . $country_id . "'";
		}

		if (!empty($state_id)) {
			$where .= " AND talent_admin.state_id = '" . $state_id . "'";
		}

		if (!empty($city_id)) {
			$where .= " AND talent_admin.city_id = '" . $city_id . "'";
		}

		if (!empty($skill)) {
			$where .= " AND talentadminskill.skill_id IN ('" . $skill . "')";
		}

		$this->request->session()->write('talent_admin_filter', $where);
		$conn = ConnectionManager::get('default');
		$talent_qry = " SELECT talent_admin.*,
		talent_admin.created_date as talent_from, 
		users.user_name, 
		users.created as membership_from, 
		GROUP_CONCAT(skill_type.name) as skill_name, 
		users.is_talent_admin, 
		cu31.name as country, 
		cu32.name as bankcountry,
		st33.name as state, 
		st34.name as bankstate,
		ct33.name as city, 
		ct34.name as bankcity	     
		from talent_admin 
		INNER join users on users.id=talent_admin.user_id 
		LEFT JOIN talentadminskill on talent_admin.id=talentadminskill.talent_admin_id  
		LEFT JOIN skill_type ON talentadminskill.skill_id=skill_type.id 
		LEFT JOIN country cu31 ON cu31.id = talent_admin.country_id 
		LEFT JOIN country cu32 ON cu32.id = talent_admin.bank_country 
		LEFT JOIN states st33 ON st33.id = talent_admin.state_id 
		LEFT JOIN states st34 ON st34.id = talent_admin.bank_state
		LEFT JOIN cities ct33 ON ct33.id = talent_admin.city_id 
		LEFT JOIN cities ct34 ON ct34.id = talent_admin.bank_city " . $where . "  group by users.id ";
		//echo $talent_qry; die;
		$talent = $conn->execute($talent_qry);
		$talents = $talent->fetchAll('assoc');
		$this->set(compact('talents'));
	}

	
	
	public function exporttalentadmin()
	{
		$this->loadModel('Profile');
		$this->loadModel('Refers');

		// Disable auto-rendering
		$this->autoRender = false;

		// Create a new instance of PHPExcel
		$objPHPExcel = new PHPExcel();

		// Set properties for the Excel file
		$objPHPExcel->getProperties()
			->setCreator("Your Name")
			->setLastModifiedBy("Your Name")
			->setTitle("Talent Partners Export")
			->setSubject("Talent Partners Export")
			->setDescription("Export of talent partners data in Excel format.")
			->setKeywords("talent partners export excel")
			->setCategory("Exported data");

		// Set column widths for better readability
		$columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
		foreach ($columns as $col) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}

		// Define the header row
		$headers = [
			'Sr Number', 'Name', 'Email', 'Alternative Email', 'Phone',
			'Country', 'State', 'City', 'Total Profile Upload',
			'Profile Uploaded (Registered / Non Registered)', 'Talent Partner From',
			'Revenue Share %', 'Created By (Name)', 'Created By (Email)'
		];
		$objPHPExcel->getActiveSheet()->fromArray($headers, null, 'A1');

		// Get data from database
		$conn = ConnectionManager::get('default');
		$where = $this->request->session()->read('talent_admin_filter');
		$talent_qry = " SELECT talent_admin.*,
		 	talent_admin.created_date as talent_from, 
			users.user_name, users.email, 
		 	users.created as membership_from, 
		 	GROUP_CONCAT(skill_type.name) as skill_name, 
		 	users.is_talent_admin, 
		 	country.name as country, 
			states.name as state, 
		 	cities.name as city 
		 	from talent_admin 
		 	INNER join users on users.id=talent_admin.user_id 
		 	LEFT JOIN talentadminskill on talent_admin.id=talentadminskill.talent_admin_id  
		 	LEFT JOIN skill_type ON talentadminskill.skill_id=skill_type.id 
		 	LEFT JOIN country on country.id=talent_admin.country_id 
		 	left join states on states.id=talent_admin.state_id 
		 	left join cities on cities.id=talent_admin.city_id " . $where . "  group by users.id ORDER BY talent_admin.id DESC";
		$talentResult = $conn->execute($talent_qry);
		$talents = $talentResult->fetchAll('assoc');


		$row = 2;
		$cnt = 1;


		foreach ($talents as $talentData) {
			$user_id = $talentData['user_id'];

			// Count the total referrals and registered/non-registered profiles
			$totalRefer = $this->Refers->find('all')->where(['Refers.ref_by' => $user_id])->count();
			$registeredProfiles = $this->Refers->find('all')->where(['Refers.ref_by' => $user_id, 'Refers.status' => 'Y'])->count();
			$nonRegisteredProfiles = $this->Refers->find('all')->where(['Refers.ref_by' => $user_id, 'Refers.status' => 'N'])->count();

			// Prepare the row data
			$rowData = [
				$cnt,
				$talentData['user_name'],
				$talentData['email'],
				$talentData['altemail'] ?: '-',
				$talentData['phonecode'] . '-' . str_replace(',', '/', $talentData['phone']) . (!empty($talentData['altnumber']) ? ' ' . $talentData['phonecode'] . '-' . str_replace(',', '/', $talentData['altnumber']) : ''),
				$talentData['country'],
				$talentData['state'],
				$talentData['city'],
				$totalRefer,
				'Registered: ' . $registeredProfiles . ' / Non Registered: ' . $nonRegisteredProfiles,
				date('M-d-Y', strtotime($talentData['created_date'])),
				$talentData['commision'] . ' %',
				$talentData['user_name'] ?? '-',
				$talentData['email'] ?? '-'
			];

			// Write the row data to the Excel sheet
			$objPHPExcel->getActiveSheet()->fromArray($rowData, null, 'A' . $row);

			// Increment row counter and Sr Number counter
			$row++;
			$cnt++;
		}

		// Set the active sheet index to the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Set the file headers for downloading the Excel file
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Talent_Partners.xlsx"');
		header('Cache-Control: max-age=0');

		// Create an Excel writer object
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		// Output the Excel file to the browser for downloading
		$objWriter->save('php://output');

		// End script execution
		exit();
	}




	// For Pack Active
	public function status($id, $status)
	{
		$this->loadModel('Users');
		if (isset($id) && !empty($id)) {
			if ($status == 'N') {

				$status = 'Y';
				$Pack = $this->Users->get($id);
				$Pack->status = $status;
				if ($this->Users->save($Pack)) {
					$this->Flash->success(__('Users status has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			} else {

				$status = 'N';
				$Pack = $this->Users->get($id);
				$Pack->status = $status;
				if ($this->Users->save($Pack)) {
					$this->Flash->success(__('Users status has been updated.'));
					return $this->redirect(['action' => 'index']);
				}
			}
		}
	}

	// For genre Delete
	public function delete($id)
	{
		$this->loadModel('TalentAdmin');
		$this->loadModel('Users');
		$this->loadModel('Talentadminskill');
		$this->loadModel('Templates');
		$this->loadModel('Sitesettings');
		$talentadmin = $this->TalentAdmin->get($id);
		//pr($talentadmin); die;
		if ($this->TalentAdmin->delete($talentadmin)) {
			// Change User status
			$users = $this->Users->get($talentadmin['user_id']);
			$user_info['is_talent_admin'] = 'N';
			$contentadmin = $this->Users->patchEntity($users, $user_info);
			$savedata = $this->Users->save($contentadmin);

			// Delete Talent admin skills
			$this->Talentadminskill->deleteAll(['Talent_adminskills.user_id' => $id]);
			$profile = $this->Templates->find('all')->where(['Templates.id' => DELETETALENTADMIN])->first();
			//pr($profile); die;
			$subject = $profile['subject'];
			$from = $profile['from'];
			$fromname = $profile['fromname'];
			$to  = $talentadmin['email'];
			$formats = $profile['description'];
			$name = $talentadmin['user_name'];
			$userexist = $this->Users->find('all')->where(['Users.email' => $to])->count();
			//pr($userexist); die;
			if ($userexist == 1) {
				$visit_site_url = SITE_URL . "/login";
			} else {
				$visit_site_url = SITE_URL . "/signup";
			}
			$site_url = SITE_URL;
			$sitesetting = $this->Sitesettings->find('all')->where(['id' => 1])->first();
			if (!empty($sitesetting['facebook_url'])) {
				$facebook = $sitesetting['facebook_url'];
			} else {
				$facebook = "#";
			}

			if (!empty($sitesetting['instagram'])) {
				$instagram = $sitesetting['instagram'];
			} else {
				$instagram = "#";
			}

			if (!empty($sitesetting['twitter_url'])) {
				$twitter = $sitesetting['twitter_url'];
			} else {
				$twitter = "#";
			}
			$message1 = str_replace(array('{Name}', '{site_url}', '{visit_site_url}', '{facebook_url}', '{insta_url}', '{twitter_url}'), array($name, $site_url, $visit_site_url, $facebook, $instagram, $twitter), $formats);
			$message = stripslashes($message1);
			$message = '
        	<!DOCTYPE HTML>
        	<html>
        	<head>
        		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        	</head>
        	<body style="padding:0px; margin:0px;font-family:Arial,Helvetica,sans-serif; font-size:13px;">
        		' . $message1 . '
        	</body>
        	</html>
        	';

			//pr($message); die;
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			//$headers .= 'To: <'.$to.'>' . "\r\n";
			$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
			$emailcheck = mail($to, $subject, $message, $headers);

			$this->Flash->success(__('The TalentAdmin with id: {0} has been deleted.', h($id)));
			return $this->redirect(['action' => 'index']);
		} else {
			$this->Flash->error(__('The TalentAdmin deletion fail.'));
			return $this->redirect(['action' => 'index']);
		}
	}


	public function getStates()
	{
		$this->loadModel('TalentAdmin');
		$this->loadModel('State');
		$states = array();
		if (isset($this->request->data['id'])) {
			$states = $this->TalentAdmin->find('all')->select(['State.name', 'State.id'])->contain(['State'])->order(['State.name' => 'ASC'])->toarray();
			foreach ($states as $states_data) {
				$state_id = $states_data['State']['id'];
				$countryarr[$state_id] = $states_data['State']['name'];
			}
		}
		header('Content-Type: application/json');
		echo json_encode($countryarr);
		exit();
	}



	public function getallStates()

	{
		$this->loadModel('Country');
		$this->loadModel('State');
		$states = array();
		if (isset($this->request->data['id'])) {
			$states = $this->Country->State->find('list')->select(['id', 'name'])->where(['State.country_id' => $this->request->data['id']])->toarray();
		}
		header('Content-Type: application/json');
		echo json_encode($states);
		exit();
	}
	public function getallcities()

	{
		$this->loadModel('City');
		$cities = array();
		if (isset($this->request->data['id'])) {
			$cities = $this->City->find('list')->select(['id', 'name'])->where(['City.state_id' => $this->request->data['id']])->toarray();
		}
		header('Content-Type: application/json');
		echo json_encode($cities);
		exit();
	}


	// This Function used for get city according states
	public function getcities()
	{
		$this->loadModel('TalentAdmin');
		$this->loadModel('City');
		$cities = array();
		if (isset($this->request->data['id'])) {
			//$cities = $this->City->find('list')->select(['id', 'name'])->where(['City.state_id' => $this->request->data['id']])->toarray();
			$cities = $this->TalentAdmin->find('all')->select(['City.name', 'City.id'])->contain(['City'])->order(['City.name' => 'ASC'])->toarray();
			//pr($cities); die;
			foreach ($cities as $cities_data) {
				$city_id = $cities_data['City']['id'];
				$countryarr[$city_id] = $cities_data['City']['name'];
			}
		}
		header('Content-Type: application/json');
		echo json_encode($countryarr);
		exit();
	}


	public function skills($id = null)

	{
		$this->loadModel('Users');
		$this->loadModel('Talentadminskill');
		$this->loadModel('Skill');
		if ($id != null) {
			$contentadminskillset = $this->Talentadminskill->find('all')->contain(['Skill'])->where(['Talentadminskill.user_id' => $id])->order(['Talentadminskill.id' => 'DESC'])->toarray();
		}
		$Skill = $this->Skill->find('all')->select(['id', 'name'])->where(['Skill.status' => 'Y'])->toarray();
		$this->set('Skill', $Skill);
		$this->set('skillset', $contentadminskillset);
	}



	public function randomPassword()
	{
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array();
		$alphaLength = strlen($alphabet) - 1;
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass);
	}




	public function checktalent($username = null)
	{

		$name = '';
		$id = '';
		$this->loadModel('Users');
		$this->loadModel('Profile');
		$this->loadModel('Country');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('Refers');
		$this->loadModel('TalentAdmin');
		$username = $this->request->data['username'];
		//$user = $this->Users->find('all')->where(['Users.email' =>$username,'Users.is_talent_admin'=>'Y'])->first();
		$talent = $this->Talentadmin->find('all')->where(['email' => $username])->first();
		//pr($talent); die;
		if ($talent) {
			$name = "Y";
			$user_name = $talent['user_name'];
		} else {
			$usertalent	= $this->Users->find('all')->where(['Users.email' => $username])->first();
			$name = $usertalent['user_name'];
			$id = $usertalent['id'];
			$usersProfile = $this->Profile->find('all')->where(['user_id' => $id])->first();

			$country = $this->Country->find('all')->select(['id', 'name'])->where(['Country.id' => $usersProfile['country_ids']])->first();
			$states = $this->State->find('all')->where(['State.id' => $usersProfile['state_id']])->first();
			$cities = $this->City->find('all')->where(['City.id' => $usersProfile['city_id']])->first();

			$response['country'] = $country['id'];
			$response['state'] = $states['id'];
			$response['city'] = $cities['id'];
		}
		$response['name'] = $name;
		$response['id'] = $id;
		$response['user_name'] = $user_name;
		echo json_encode($response);
		die;
	}


	public function newTalentMailsend($email = null, $user_name = null, $passwordr = null)
	{

		/*sending email start */
		$this->loadmodel('Templates');

		if ($passwordr) {
			$profile = $this->Templates->find('all')->where(['Templates.id' => OLDTALENTPARTNER])->first();
			//pr($profile); die;
			$subject = $profile['subject'];
			$from = $profile['from'];
			$fromname = $profile['fromname'];
			$to  = $email;
			$formats = $profile['description'];
			$site_url = SITE_URL;

			$message1 = str_replace(array('{Name}', '{Email}', '{Password}', '{visit_site_url}'), array($user_name, $email, $passwordr, $site_url), $formats);
			$message = stripslashes($message1);
			$message = '
		<!DOCTYPE HTML>
		<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<title>Mail</title>
		</head>
		<body style="padding:0px; margin:0px;font-family:Arial,Helvetica,sans-serif; font-size:13px;">
			' . $message1 . '
		</body>
		</html>';
			//pr($message);
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			//$headers .= 'To: <'.$to.'>' . "\r\n";
			$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
			$emailcheck = mail($to, $subject, $message, $headers);
		} else {
			$profile = $this->Templates->find('all')->where(['Templates.id' => OLDTALENTPARTNER])->first();
			$subject = $profile['subject'];
			$from = $profile['from'];
			$fromname = $profile['fromname'];
			$to  = $email;
			$userexist = $this->Users->find('all')->where(['Users.email' => $email])->count();
			//pr($userexist); die;
			if ($userexist == 1) {
				$visit_site_url = SITE_URL . "/login";
			} else {
				$visit_site_url = SITE_URL . "/signup";
			}
			$formats = $profile['description'];
			$site_url = SITE_URL;

			$message1 = str_replace(array('{Name}', '{Email}', '{site_url}', '{visit_site_url}'), array($user_name, $email, $site_url, $visit_site_url), $formats);
			$message = stripslashes($message1);
			$message = '
		<!DOCTYPE HTML>
		<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		</head>
		<body style="padding:0px; margin:0px;font-family:Arial,Helvetica,sans-serif; font-size:13px;">
			' . $message1 . '
		</body>
		</html>';
			//pr($message); die;
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			//$headers .= 'To: <'.$to.'>' . "\r\n";
			$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
			$emailcheck = mail($to, $subject, $message, $headers);
		}

		/*if($emailcheck){
	    echo "mail sent"; die;
	}else{
	   echo "no"; die;
	}*/

		/*   sending email end */
	}


	public function add($id = null)
	{
		$this->loadModel('Users');
		$this->loadModel('Country');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Talentadminskill');
		$this->loadModel('Skill');
		$this->loadModel('Profile');
		$this->viewBuilder()->layout('admin');
		//echo $id; die;

		$contentadminskillset = $this->Talentadminskill->find('all')->contain(['Skill'])->where(['Talentadminskill.user_id' => $id])->toarray();
		$this->set('skillofcontaint', $contentadminskillset);

		//pr($contentadminskillset); die;

		$country = $this->Country->find('list')->select(['id', 'name'])->toarray();
		$this->set('country', $country);

		if (isset($id) && !empty($id)) {
			$users = $this->Users->find('all')->contain(['Profile', 'TalentAdmin', 'Talentadminskill'])->where(['Users.id' => $id])->first();
			$talent = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $id])->first();

			$cities = $this->City->find('list')->where(['City.state_id' => $users['talent_admin']['state_id']])->toarray();
			$this->set('cities', $cities);

			$states = $this->State->find('list')->where(['State.country_id' => $users['talent_admin']['country_id']])->toarray();
			$this->set('states', $states);
		} elseif ($this->request->data['non_tp_id'] != '') {
			$userid = $this->request->data['non_tp_id'];

			$users = $this->Users->get($userid);
			$talent = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $userid])->first();

			if ($users['is_talent_admin'] == 'Y' || $talent) {
				$this->Flash->error(__($users['user_name'] . ' is already a Talent partner'));
				$this->set('error', $error);
				return $this->redirect(['action' => 'add']);
			} else {
				$talent = $this->TalentAdmin->newEntity();

				$this->request->data['is_talent_admin'] = 'Y';
				$this->request->data['is_talent_admin_accept'] = 2;
			}
		} else {
			$email = $this->request->data['email'];

			$usersexsits = $this->Users->find('all')->where(['Users.email' => $email])->first();

			$talent = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $usersexsits['email']])->first();

			if ($usersexsits['is_talent_admin'] == 'Y' || $talent) {
				$this->Flash->error(__($usersexsits['user_name'] . ' is already a Talent partner'));
				$this->set('error', $error);
				return $this->redirect(['action' => 'add']);
			} else {
				$users = $this->Users->newEntity();
				$talent = $this->TalentAdmin->newEntity();
				$this->request->data['role_id'] = NONTALANT_ROLEID;
				//$this->request->data['isvarify']= 'Y';
				$this->request->data['is_talent_admin'] = 'Y';
				$this->request->data['is_talent_admin_accept'] = 1;

				$passwordr = $this->randomPassword();
				$password = $this->_setPassword($passwordr);
				$this->request->data['password'] = $password;
			}
		}

		if ($this->request->is(['post', 'put'])) {
			//pr($this->request->data); die;

			//$contentadmin = $this->Users->patchEntity($users, $this->request->data);
			//$savedata=$this->Users->save($contentadmin);

			//	if ($savedata)
			//	{	
			//$newprofile = $this->Profile->newEntity();
			//	$profiledata = array();
			//	$profiledata['user_id']=$savedata['id'];
			//	$profiledata['country_ids']=$savedata['country_id'];
			//	$profiledata['state_id']=$savedata['state_id'];
			//	$profiledata['city_id']=$savedata['city_id'];
			//	$profiledata['name']=$savedata['user_name'];
			//	$contenpro = $this->Profile->patchEntity($newprofile, $profiledata);
			//	$savepro=$this->Profile->save($contenpro);

			//if ($passwordr) {
			//	$this->assigndefaultpackage($savedata['id']);
			//}


			$userexist = $this->Users->find('all')->where(['Users.email' => $this->request->data['email']])->first();

			//pr($userexist); die;

			$newTalentMail = $this->newTalentMailsend($this->request->data['email'], $this->request->data['user_name']);

			$last_user_id = $savedata->id;
			$prop_data = array();

			if (isset($userexist) && $userexist['altemail'] != "") {
				$prop_data['alternate_email'] = $userexist['altemail'];
			}

			if (isset($userexist)) {
				$prop_data['user_id'] = $userexist['id'];
			}

			$prop_data['talentdadmin_id'] = 1;
			$prop_data['email'] = $this->request->data['email'];
			$prop_data['user_name'] = $this->request->data['user_name'];
			$prop_data['country_id'] = $this->request->data['country_id'];
			$prop_data['state_id'] = $this->request->data['state_id'];
			$prop_data['city_id'] = $this->request->data['city_id'];
			$prop_data['commision'] = $this->request->data['commission'];
			//$prop_data['user_id']= $last_user_id;	
			$prop_data['enable_create_subadmin'] = $this->request->data['enable_create_subadmin'];
			$prop_data['enable_delete_subadmin'] = $this->request->data['enable_delete_subadmin'];
			$prop_data['referal_code'] = md5(uniqid(rand(), true));
			$skillcheck	= $this->request->data['skill'];
			$skillcount = explode(",", $this->request->data['skill']);
			//pr($prop_data); die;

			$contenttalent_admin = $this->TalentAdmin->patchEntity($talent, $prop_data);
			$savedataTalent = $this->TalentAdmin->save($contenttalent_admin);
			if ($savedataTalent) {
				if ($id == "") {
					//$newappointMail = $this->appointmailsend($savedataTalent['user_name'],$savedataTalent['email'],$savedataTalent['created']);
					$users = TableRegistry::get('TalentAdmin');
					$query = $users->query();
					$query->update()
						->set(['appointment' => 1])
						->where(['id' => $savedataTalent['id']])
						->execute();
				} else {
					if ($this->request->data['commision'] != $talent['commision']) {
						//$newappointMail = $this->appointmailsend($talent['user_name'],$talent['email'],$talent['created']);
						$users = TableRegistry::get('TalentAdmin');
						$query = $users->query();
						$query->update()
							->set(['appointment' => 1])
							->where(['id' => $savedataTalent['id']])
							->execute();
					}
				}
			}
			if ($savedataTalent['user_id'] != "") {
				$users = TableRegistry::get('Users');
				$user = $users->get($savedataTalent['user_id']); // Return article with id = $id (primary_key of row which need to get updated)
				$user->is_talent_admin = "Y";
				$users->save($user);
			}
			$last_ta_id = $savedataTalent->id;
			if ($skillcheck) {
				$prop_skills = array();
				$this->Talentadminskill->deleteAll(['Talent_adminskills.user_id' => $id]);
				for ($i = 0; $i < count($skillcount); $i++) {
					//echo $i; die;
					$contentadminskill = $this->Talentadminskill->newEntity();
					$prop_skills['talent_admin_id'] = $last_ta_id;
					$prop_skills['user_id'] = $id;
					$prop_skills['skill_id'] = $skillcount[$i];
					//pr($prop_skills); die;
					$contentadminskillsave = $this->Talentadminskill->patchEntity($contentadminskill, $prop_skills);
					$skilldata = $this->Talentadminskill->save($contentadminskillsave);
				}
			}
			$this->Flash->success(__('Talent Partner details submitted successfully. Please inform ' . $savedataTalent['user_name'] . '.'));
			return $this->redirect(['action' => 'index']);
			//	}

		}
		$this->set('packentity', $users);
	}


	// Make user Talent admin
	public function maketalentadmin($id = null)
	{
		$this->loadModel('Users');
		$this->loadModel('Country');
		$this->loadModel('State');
		$this->loadModel('City');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Talentadminskill');
		$this->loadModel('Skill');
		$this->loadModel('Profile');
		$this->viewBuilder()->layout('admin');

		$contentadminskillset = $this->Talentadminskill->find('all')->contain(['Skill'])->where(['Talentadminskill.user_id' => $id])->toarray();
		//pr($contentadminskillset); die;
		$this->set('skillofcontaint', $contentadminskillset);
		if (isset($id) && !empty($id)) {
			$users = $this->Users->find('all')->where(['Users.id' => $id])->first();
			$usersProfile = $this->Profile->find('all')->where(['user_id' => $id])->first();
			$this->set('usersProfile', $usersProfile);
			//pr($usersProfile); die;
			$talent = $this->TalentAdmin->newEntity();
		} else {
		}

		$country = $this->Country->find('list')->select(['id', 'name'])->toarray();
		$this->set('country', $country);

		$cities = $this->City->find('list')->where(['City.state_id' => $usersProfile['state_id']])->toarray();
		$this->set('cities', $cities);

		$states = $this->State->find('list')->where(['State.country_id' => $usersProfile['country_ids']])->toarray();
		$this->set('states', $states);

		if ($this->request->is(['post', 'put'])) {
			//pr($this->request->data); die;
			$usersdata['is_talent_admin'] = 'Y';
			$usersdata['is_talent_admin_accept'] = 1;
			try {
				$contentadmin = $this->Users->patchEntity($users, $usersdata);
				$savedata = $this->Users->save($contentadmin);
				if ($savedata) {
					$last_user_id = $savedata->id;
					$prop_data = array();
					$prop_data['country_id'] = $this->request->data['country_id'];
					$prop_data['state_id'] = $this->request->data['state_id'];
					$prop_data['city_id'] = $this->request->data['city_id'];
					$prop_data['commision'] = $this->request->data['commission'];
					$prop_data['user_id'] = $last_user_id;
					$prop_data['enable_create_subadmin'] = $this->request->data['enable_create_subadmin'];
					$prop_data['enable_delete_subadmin'] = $this->request->data['enable_delete_subadmin'];
					$prop_data['referal_code'] = md5(uniqid(rand(), true));
					$skillcheck	= $this->request->data['skill'];
					$skillcount = explode(",", $this->request->data['skill']);

					$contenttalent_admin = $this->TalentAdmin->patchEntity($talent, $prop_data);
					$savedata = $this->TalentAdmin->save($contenttalent_admin);
					$newTalentMail = $this->newTalentMailsend($this->request->data['email'], $this->request->data['user_name']);
					$last_ta_id = $savedata->id;
					if ($skillcheck) {
						$prop_skills = array();
						$this->Talentadminskill->deleteAll(['Talent_adminskills.user_id' => $id]);
						for ($i = 0; $i < count($skillcount); $i++) {
							$contentadminskill = $this->Talentadminskill->newEntity();
							$prop_skills['user_id'] = $last_user_id;
							$prop_skills['skill_id'] = $skillcount[$i];
							$prop_skills['talent_admin_id'] = $last_ta_id;
							$contentadminskillsave = $this->Talentadminskill->patchEntity($contentadminskill, $prop_skills);
							$skilldata = $this->Talentadminskill->save($contentadminskillsave);
						}
					}
					$this->Flash->success(__('Your Talent Admin has been saved.'));
					return $this->redirect(['action' => 'index']);
				}
			} catch (\PDOException $e) {
				$this->Flash->error(__('User Name Already Exits'));
				$this->set('error', $error);
				return $this->redirect(['action' => 'add']);
			}
		}
		$this->set('packentity', $users);
	}

	public function removetalentadmin($id = null)
	{
		$this->loadModel('Users');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Talentadminskill');
		$this->loadmodel('Templates');
		if (isset($id) && !empty($id)) {
			$users = $this->Users->find('all')->contain(['TalentAdmin', 'Talentadminskill'])->where(['Users.id' => $id])->first();
			$talent = $this->TalentAdmin->find('all')->where(['TalentAdmin.user_id' => $id])->first();
		}

		/* Send Deletion mail */
		$email = $users['email'];
		$profile = $this->Templates->find('all')->where(['Templates.id' => DELETETALENTPARNER])->first();
		//pr($profile); die;
		$subject = $profile['subject'];
		$from = $profile['from'];
		$fromname = $profile['fromname'];
		$to  = $email;
		$formats = $profile['description'];
		$site_url = SITE_URL;
		$user_name = $users['user_name'];

		$message1 = str_replace(array('{Name}', '{site_url}'), array($user_name, $site_url), $formats);
		$message = stripslashes($message1);
		$message = '
	<!DOCTYPE HTML>
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Mail</title>
	</head>
	<body style="padding:0px; margin:0px;font-family:Arial,Helvetica,sans-serif; font-size:13px;">
		' . $message1 . '
	</body>
	</html>';
		//pr($message);
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		//$headers .= 'To: <'.$to.'>' . "\r\n";
		$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
		$emailcheck = mail($to, $subject, $message, $headers);

		$this->TalentAdmin->delete($talent);
		$usersdata['is_talent_admin'] = "N";
		$contentadmin = $this->Users->patchEntity($users, $usersdata);
		$savedata = $this->Users->save($contentadmin);
		$this->Talentadminskill->deleteAll(['Talent_adminskills.user_id' => $id]);
		$this->Flash->success(__('Talent admin has been deleted successfully'));
		return $this->redirect(['action' => 'index']);
	}



	//all paid transaction...
	public function paidtransaction($id = null)
	{

		$this->loadModel('Country');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Talentadmintransc');
		//$country = $this->Country->find('list')->select(['id', 'name'])->toarray();
		$country = $this->TalentAdmin->find('all')->select(['Country.name', 'Country.id'])->contain(['Country'])->order(['Country.name' => 'ASC'])->toarray();
		$this->set('country', $country);

		if ($this->request->is(['post', 'put'])) {
			//pr($this->request->data); die;
			$talent_admin_id = $this->request->data['talent_admin_id'];
			$write_notes = $this->request->data['write_notes'];


			$isPaymentdone = $this->Talentadmintransc->updateAll(array('write_notes' => $write_notes), array('id' => $talent_admin_id));
			if ($isPaymentdone) {
				$this->Flash->success(__('Note has been updated'));
				return $this->redirect(Router::url($this->referer(), true));
			}
		}


		$this->viewBuilder()->layout('admin');
		$where = " where talentadmintransc.payout_amount >'0' ";
		$this->request->session()->write('talent_admin_paid_transcations', $where);
		$conn = ConnectionManager::get('default');
		$talent_qry = " SELECT talentadmintransc.*, 
	Adminuser.user_name as talent_admin_name, 
	Adminuser.email as talent_admin_email, 

	Adminuser.created as membership_from, 

	(Select `talentdadmin_id` from talent_admin where talent_admin.user_id=talent_admin_id ) as talent_creator_id,
	(Select `created_date` from talent_admin where talent_admin.user_id=talent_admin_id ) as talent_from,
	(Select `user_name` from users where users.id=talent_creator_id ) as talent_creator_name,
	(Select `email` from users where users.id=talent_creator_id ) as talent_creator_email
	from talentadmintransc 
	left join users on users.id=user_id 
	left join users Adminuser on Adminuser.id=talent_admin_id " . $where . " group by talentadmintransc.id ORDER BY paid_date";

		$talent = $conn->execute($talent_qry);
		$talents = $talent->fetchAll('assoc');
		//pr($talents); die;
		$this->set(compact('talents'));
		$this->set('talent_admin_id', $id);
	}


	//filter paid transactions...
	public function searchpaidtransaction()
	{
		$this->loadModel('Users');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Skill');
		$this->loadModel('Talentadminskill');

		$from_date = date('Y-m-d', strtotime($this->request->data['from_date']));
		$to_date = date('Y-m-d', strtotime($this->request->data['to_date']));
		$user_type = $this->request->data['user_type'];
		$talent_name = $this->request->data['name'];
		$email = $this->request->data['email'];

		// pr($this->request->data);


		$where = " where talentadmintransc.payout_amount >'0' ";

		if (!empty($talent_name)) {
			$where .= " AND Adminuser.user_name LIKE '%" . $talent_name . "%'";
		}

		if (!empty($email)) {
			$where .= " AND Adminuser.email LIKE '%" . $email . "%'";
		}


		if (!empty($from_date) && !empty($to_date)) {
			$where .= " AND STR_TO_DATE(talentadmintransc.paid_date,'%Y-%m-%d') between '" . $from_date . "' and '" . $to_date . "'";
		}

		/*if(!empty($country_id))
	    {
		$where.= " AND talent_admin.country_id = '".$country_id."'";
	}*/

		$this->request->session()->write('talent_admin_paid_transcations', $where);
		$conn = ConnectionManager::get('default');
		$talent_qry = " SELECT talentadmintransc.*, 
	Adminuser.user_name as talent_admin_name, 
	Adminuser.email as talent_admin_email,
	Adminuser.created as membership_from,	    
	(Select `talentdadmin_id` from talent_admin where talent_admin.user_id=talent_admin_id ) as talent_creator_id,
	(Select `created_date` from talent_admin where talent_admin.user_id=talent_admin_id ) as talent_from,
	(Select `user_name` from users where users.id=talent_creator_id ) as talent_creator_name,
	(Select `email` from users where users.id=talent_creator_id ) as talent_creator_email
	from talentadmintransc 
	left join users Adminuser on Adminuser.id=talent_admin_id " . $where . " group by talentadmintransc.id ORDER BY paid_date";
		//echo $talent_qry; die;
		$talent = $conn->execute($talent_qry);
		$talents = $talent->fetchAll('assoc');
		$this->set(compact('talents'));
	}

	// change on 27/04/2024
	// Export Paid Transactions... 
	// public function exportpaidtrans()
	// {

	// 	$this->autoRender = false;
	// 	$blank = "NA";
	// 	$conn = ConnectionManager::get('default');
	// 	$output = "";

	// 	$output .= '"Sr Number",';
	// 	$output .= '"Talent Partner Name",';
	// 	$output .= '"Talent Partner Email",';
	// 	$output .= '"Creator Name",';
	// 	$output .= '"Creator E Mail id",';
	// 	$output .= '"Membership from",';
	// 	$output .= '"Talent Partner from",';
	// 	$output .= '"Total Amount Paid",';
	// 	$output .= "\n";
	// 	//pr($job); die;
	// 	$str = "";

	// 	//$where = " where users.is_talent_admin = 'Y'";
	// 	$where = $this->request->session()->read('talent_admin_paid_transcations');
	// 	$conn = ConnectionManager::get('default');
	// 	$talent_qry = " SELECT talentadmintransc.*, 
	//        Adminuser.user_name as talent_admin_name, 
	//     Adminuser.email as talent_admin_email,
	//     Adminuser.created as membership_from,	    
	//     (Select `talentdadmin_id` from talent_admin where talent_admin.user_id=talent_admin_id ) as talent_creator_id,
	//     (Select `created_date` from talent_admin where talent_admin.user_id=talent_admin_id ) as talent_from,
	//     (Select `user_name` from users where users.id=talent_creator_id ) as talent_creator_name,
	//     (Select `email` from users where users.id=talent_creator_id ) as talent_creator_email
	//     from talentadmintransc 
	//     left join users Adminuser on Adminuser.id=talent_admin_id " . $where . " group by talentadmintransc.id ORDER BY paid_date";
	// 	//echo $talent_qry; die;
	// 	$talent = $conn->execute($talent_qry);
	// 	$talents = $talent->fetchAll('assoc');

	// 	//pr($talents); die;
	// 	$cnt = 1;
	// 	foreach ($talents as $talent_data) {
	// 		$this->loadModel('Users');
	// 		if ($talent_data['talent_creator_id'] == 0) {
	// 			$talentCreator = "Admin";
	// 			$talentCreatorEmail = "Admin";
	// 		} else {
	// 			$talentCreator = $talent_data['talent_creator_name'];
	// 			$talentCreatorEmail = $talent_data['talent_creator_email'];
	// 		}
	// 		$output .= $cnt . ",";
	// 		$output .= $talent_data['talent_admin_name'] . ",";
	// 		$output .= $talent_data['talent_admin_email'] . ",";
	// 		$output .= $talentCreator . ",";
	// 		$output .= $talentCreatorEmail . ",";
	// 		$output .= $talent_data['membership_from'] . ",";
	// 		$output .= $talent_data['talent_from'] . ",";
	// 		$output .= "$" . $talent_data['amount'] . ",";

	// 		$cnt++;
	// 		$output .= "\r\n";
	// 	}

	// 	$filename = "Paid Talent Partners.xlsx";
	// 	header('Content-type: application/xlsx');
	// 	header('Content-Disposition: attachment; filename=' . $filename);
	// 	echo $output;
	// 	die;
	// 	$this->redirect($this->referer());
	// }
	public function exportpaidtrans()
	{
		// Disable auto-rendering
		$this->autoRender = false;

		// Create a new instance of PHPExcel
		$objPHPExcel = new PHPExcel();

		// Set properties for the Excel file
		$objPHPExcel->getProperties()
			->setCreator("Your Name")
			->setLastModifiedBy("Your Name")
			->setTitle("Paid Talent Partners Export")
			->setSubject("Paid Talent Partners Export")
			->setDescription("Export of paid talent partners data in Excel format.")
			->setKeywords("paid talent partners export excel")
			->setCategory("Exported data");

		// Set column widths for better readability
		$columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
		foreach ($columns as $col) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}

		// Define the header row
		$headers = [
			'Sr Number', 'Talent Partner Name', 'Talent Partner Email', 'Creator Name',
			'Creator Email', 'Membership from', 'Talent Partner from', 'Total Amount Paid'
		];
		$objPHPExcel->getActiveSheet()->fromArray($headers, null, 'A1');

		// Get data from the database
		$conn = ConnectionManager::get('default');
		$where = $this->request->session()->read('talent_admin_paid_transcations');
		$talent_qry = " SELECT talentadmintransc.*, 
		        Adminuser.user_name as talent_admin_name, 
		     Adminuser.email as talent_admin_email,
		     Adminuser.created as membership_from,	    
		     (Select `talentdadmin_id` from talent_admin where talent_admin.user_id=talent_admin_id ) as talent_creator_id,
		     (Select `created_date` from talent_admin where talent_admin.user_id=talent_admin_id ) as talent_from,
		     (Select `user_name` from users where users.id=talent_creator_id ) as talent_creator_name,
		     (Select `email` from users where users.id=talent_creator_id ) as talent_creator_email
		     from talentadmintransc 
		     left join users Adminuser on Adminuser.id=talent_admin_id " . $where . " group by talentadmintransc.id ORDER BY paid_date";


		// Execute the query and fetch the results
		$talentResult = $conn->execute($talent_qry);
		$talents = $talentResult->fetchAll('assoc');

		// Initialize row counter starting from the second row
		$row = 2;
		$cnt = 1;

		// Iterate through the data and populate the Excel sheet
		foreach ($talents as $talentData) {
			$talentCreatorName = ($talentData['talent_creator_id'] == 0) ? 'Admin' : $talentData['talent_creator_name'];
			$talentCreatorEmail = ($talentData['talent_creator_id'] == 0) ? 'Admin' : $talentData['talent_creator_email'];

			// Prepare the data for each row
			$rowData = [
				$cnt,
				$talentData['talent_admin_name'],
				$talentData['talent_admin_email'],
				$talentCreatorName,
				$talentCreatorEmail,
				date('M-d-Y', strtotime($talentData['membership_from'])),
				date('M-d-Y', strtotime($talentData['talent_from'])),
				"$" . number_format($talentData['amount'], 2)
			];

			// Write the row data to the Excel sheet
			$objPHPExcel->getActiveSheet()->fromArray($rowData, null, 'A' . $row);

			// Increment row counter and Sr Number counter
			$row++;
			$cnt++;
		}

		// Set the active sheet index to the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Set the file headers for downloading the Excel file
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Paid_Talent_Partners.xlsx"');
		header('Cache-Control: max-age=0');

		// Create an Excel writer object
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		// Output the Excel file to the browser for downloading
		$objWriter->save('php://output');

		// End script execution
		exit();
	}



	// All Transcations
	public function transcations($id = null)
	{

		$this->loadModel('Country');
		$this->loadModel('TalentAdmin');
		$this->loadModel('Users');
		//$country = $this->Country->find('list')->select(['id', 'name'])->toarray();
		$country = $this->TalentAdmin->find('all')->select(['Country.name', 'Country.id'])->contain(['Country'])->order(['Country.name' => 'ASC'])->toarray();
		$this->set('country', $country);

		$talentadmin = $this->Users->find('all')->select(['id', 'user_name', 'email'])->where(['id' => $id])->first();
		$this->set('talentadmin', $talentadmin);

		$this->viewBuilder()->layout('admin');
		$where = " where talentadmintransc.talent_admin_id='" . $id . "'  ";
		$this->request->session()->write('talent_admin_transcation', $where);
		$conn = ConnectionManager::get('default');
		$talent_qry = " SELECT talentadmintransc.*, users.user_name as talent_name, users.email, GROUP_CONCAT(skill_type.name) as skill_name from talentadmintransc left join users on users.id=user_id left join personal_profile on personal_profile.user_id=talentadmintransc.user_id LEFT JOIN skill on talentadmintransc.user_id=skill.user_id LEFT JOIN skill_type ON skill.skill_id=skill_type.id  " . $where . " group by talentadmintransc.id";
		$talent = $conn->execute($talent_qry);
		$transcations = $talent->fetchAll('assoc');
		$this->set(compact('transcations'));
		$this->set('talent_admin_id', $id);
	}

	// All Transcations filters
	public function searchtranscation($id = null)
	{

		$from_date = $this->request->data['from_date'];
		$to_date = $this->request->data['to_date'];
		$invoice = $this->request->data['invoice'];
		//$id = $this->request->data['talentadminid'];
		//echo $id;
		//pr($this->request->data); die;
		//commented for lokesh 
		$where = " where talentadmintransc.talent_admin_id='" . $id . "'";
		$cond = [];
		if (!empty($from_date) && !empty($to_date)) {
			$where .= " AND STR_TO_DATE(talentadmintransc.paid_date,'%Y-%m-%d') between '" . $from_date . "' and '" . $to_date . "'";
		}

		if (!empty($invoice)) {
			$where .= " AND talentadmintransc.transaction_id = '" . $invoice . "'";
		}
		$this->request->session()->write('talent_admin_transcation', $where);
		$conn = ConnectionManager::get('default');
		$talent_qry = " SELECT talentadmintransc.*, users.user_name as talent_name, users.email, GROUP_CONCAT(skill_type.name) as skill_name from talentadmintransc left join users on users.id=user_id left join personal_profile on personal_profile.user_id=talentadmintransc.user_id LEFT JOIN skill on talentadmintransc.user_id=skill.user_id LEFT JOIN skill_type ON skill.skill_id=skill_type.id  " . $where . " group by talentadmintransc.id";

		$talent = $conn->execute($talent_qry);
		$transcations = $talent->fetchAll('assoc');
		$this->set(compact('transcations'));
	}

	//change on 27/04/2024
	// Export talent admin transcations 
	// public function exporttranscation($id = null, $status = null)
	// {
	// 	$this->loadModel('Country');
	// 	$this->loadModel('TalentAdmin');
	// 	//$country = $this->Country->find('list')->select(['id', 'name'])->toarray();
	// 	$country = $this->TalentAdmin->find('all')->select(['Country.name', 'Country.id'])->contain(['Country'])->order(['Country.name' => 'ASC'])->toarray();
	// 	$this->set('country', $country);

	// 	$this->viewBuilder()->layout('admin');
	// 	//$where = " where talentadmintransc.talent_admin_id='".$id."' and talentadmintransc.payout_amount='0' ";
	// 	$where = $this->request->session()->read('talent_admin_transcation');
	// 	$conn = ConnectionManager::get('default');
	// 	$talent_qry = " SELECT talentadmintransc.*, users.user_name as talent_name, users.email, GROUP_CONCAT(skill_type.name) as skill_name from talentadmintransc left join users on users.id=user_id left join personal_profile on personal_profile.user_id=talentadmintransc.user_id LEFT JOIN skill on talentadmintransc.user_id=skill.user_id LEFT JOIN skill_type ON skill.skill_id=skill_type.id  " . $where . " group by talentadmintransc.id";
	// 	$talent = $conn->execute($talent_qry);
	// 	$transcations = $talent->fetchAll('assoc');
	// 	$this->set(compact('transcations'));

	// 	$output = "";

	// 	//pr($transcations); die;

	// 	$output .= '"Sr Number",';
	// 	$output .= '"Invoice Number",';
	// 	$output .= '"Date of Invoice",';
	// 	$output .= '"Invoice Type",';
	// 	$output .= '"Invoice Total",';
	// 	$output .= '"Revenue Share Due",';
	// 	$output .= '"Note",';
	// 	$output .= '"Date of Payout",';
	// 	$output .= '"Action",';
	// 	$output .= "\n";
	// 	$str = "";

	// 	$cnt = 1;
	// 	foreach ($transcations as $talent_data) {

	// 		if ($talent_data['payout_amount'] > 0) {
	// 			$invoicetotal = "$" . $talent_data['payout_amount'];
	// 			$notes = $talent_data['write_notes'];
	// 			$paid_date = $talent_data['paid_date'];
	// 			$invoicestatus = "Paid";
	// 		} else {
	// 			$invoicetotal = '$0';
	// 			$notes = "N/A";
	// 			$paid_date = "N/A";
	// 			$invoicestatus = "Pending";
	// 		}
	// 		if ($talent_data['payout_amount'] < 1) {
	// 			$invoicedue = "$" . $talent_data['amount'];
	// 		} else {
	// 			$invoicedue = '$0';
	// 		}
	// 		$output .= $cnt . ",";
	// 		$output .= $talent_data['transaction_id'] . ",";
	// 		$output .= $talent_data['created_date'] . ",";
	// 		$output .= $talent_data['description'] . ",";
	// 		$output .= $invoicetotal . ",";
	// 		$output .= $invoicedue . ",";
	// 		$output .= $notes . ",";
	// 		$output .= $paid_date . ",";
	// 		$output .= $invoicestatus . ",";

	// 		$cnt++;
	// 		$output .= "\r\n";
	// 	}

	// 	$filename = "Talent Partners Transactions.xlsx";
	// 	header('Content-type: application/xlsx');
	// 	header('Content-Disposition: attachment; filename=' . $filename);
	// 	echo $output;
	// 	die;
	// 	$this->redirect($this->referer());
	// }
	public function exporttranscation($id = null, $status = null)
	{   
		$this->loadModel('Country');
		$this->loadModel('TalentAdmin');
		// Disable auto-rendering
		$this->autoRender = false;

		// Create a new instance of PHPExcel
		$objPHPExcel = new PHPExcel();

		// Set properties for the Excel file
		$objPHPExcel->getProperties()
			->setCreator("Your Name")
			->setLastModifiedBy("Your Name")
			->setTitle("Talent Partners Transactions Export")
			->setSubject("Talent Partners Transactions Export")
			->setDescription("Export of talent partners transactions data in Excel format.")
			->setKeywords("talent partners transactions export excel")
			->setCategory("Exported data");

		// Set column widths for better readability
		$columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];
		foreach ($columns as $col) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}

		// Define the header row
		$headers = [
			'Sr Number', 'Invoice Number', 'Date of Invoice', 'Invoice Type',
			'Invoice Total', 'Revenue Share Due', 'Note', 'Date of Payout', 'Action'
		];
		$objPHPExcel->getActiveSheet()->fromArray($headers, null, 'A1');

		// Get data from the database
		$conn = ConnectionManager::get('default');
		$where = $this->request->session()->read('talent_admin_transcation');
		$talentQry = "
			SELECT talentadmintransc.*, users.user_name as talent_name, users.email,
			GROUP_CONCAT(skill_type.name) as skill_name
			FROM talentadmintransc
			LEFT JOIN users ON users.id = user_id
			LEFT JOIN personal_profile ON personal_profile.user_id = talentadmintransc.user_id
			LEFT JOIN skill ON talentadmintransc.user_id = skill.user_id
			LEFT JOIN skill_type ON skill.skill_id = skill_type.id
			$where
			GROUP BY talentadmintransc.id
		";

		// Execute the query and fetch the results
		$talentResult = $conn->execute($talentQry);
		$transcations = $talentResult->fetchAll('assoc');

		// Initialize row counter starting from the second row
		$row = 2;
		$cnt = 1;

		// Iterate through the data and populate the Excel sheet
		foreach ($transcations as $talentData) {
			// Determine the invoice total, notes, paid date, and invoice status
			if ($talentData['payout_amount'] > 0) {
				$invoiceTotal = "$" . number_format($talentData['payout_amount'], 2);
				$notes = $talentData['write_notes'];
				$paidDate = date('M-d-Y', strtotime($talentData['paid_date']));
				$invoiceStatus = 'Paid';
			} else {
				$invoiceTotal = '$0';
				$notes = 'N/A';
				$paidDate = 'N/A';
				$invoiceStatus = 'Pending';
			}

			if ($talentData['payout_amount'] < 1) {
				$invoiceDue = "$" . number_format($talentData['amount'], 2);
			} else {
				$invoiceDue = '$0';
			}

			// Prepare the data for each row
			$rowData = [
				$cnt,
				$talentData['transaction_id'],
				date('M-d-Y', strtotime($talentData['created_date'])),
				$talentData['description'],
				$invoiceTotal,
				$invoiceDue,
				$notes,
				$paidDate,
				$invoiceStatus
			];

			// Write the row data to the Excel sheet
			$objPHPExcel->getActiveSheet()->fromArray($rowData, null, 'A' . $row);

			// Increment row counter and Sr Number counter
			$row++;
			$cnt++;
		}

		// Set the active sheet index to the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Set the file headers for downloading the Excel file
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Talent_Partners_Transactions.xlsx"');
		header('Cache-Control: max-age=0');

		// Create an Excel writer object
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		// Output the Excel file to the browser for downloading
		$objWriter->save('php://output');

		// End script execution
		exit();
	}




	//pay all selected transactions...
	public function payallselected($id = null)
	{
		$this->loadModel('Talentadmintransc');

		if ($this->request->is(['post', 'put'])) {
			//pr($this->request->data); die;
			$ids = $this->request->data['id'];
			$write_notes = $this->request->data['write_notes'];

			$alltalentpayout = $this->Talentadmintransc->find('all')->where(['talent_admin_id IN' => $ids, 'payout_amount' => 0])->toarray();
			foreach ($alltalentpayout as $key => $allvalue) {
				$talenttraid = $this->Talentadmintransc->find('all')->where(['id' => $allvalue['id']])->toarray();
				$current = date('Y-m-d H:i');
				$isPaymentdone = $this->Talentadmintransc->updateAll(array('payout_amount' => $allvalue['amount'], 'write_notes' => $write_notes, 'paid_date' => $current), array('id' => $allvalue['id']));
			}

			//pr($talenttraid); die;

			if ($isPaymentdone) {
				$this->Flash->success(__('Selected payout has been paid successfully'));
				return $this->redirect(['action' => 'paidtransaction/']);
			}
		}

		$where = " where talentadmintransc.talent_admin_id IN (" . $id . ") and talentadmintransc.payout_amount='0' ";
		$conn = ConnectionManager::get('default');
		$talent_qry = " SELECT talentadmintransc.*, users.user_name as talent_name, users.email,
	(Select SUM(amount)-SUM(payout_amount) as dues) as total
	from talentadmintransc 
	left join users on users.id=talent_admin_id 
	left join personal_profile on personal_profile.user_id=talentadmintransc.user_id " . $where . " group by talentadmintransc.talent_admin_id";

		$talent = $conn->execute($talent_qry);
		$talenttraids = $talent->fetchAll('assoc');

		$this->set('talenttraids', $talenttraids);
	}


	//pay selected transactions...
	public function payselected($id = null)
	{
		$this->loadModel('Talentadmintransc');
		$pro = explode(",", $id);
		//pr($pro); die;
		$talenttraid = $this->Talentadmintransc->find('all')->where(['id IN' => $pro])->toarray();
		$this->set(compact('talenttraid'));

		if ($this->request->is(['post', 'put'])) {
			//pr($this->request->data); die;
			$ids = $this->request->data['id'];
			$write_notes = $this->request->data['write_notes'];
			//pr($id); die;
			$talenttraid = $this->Talentadmintransc->find('all')->where(['id IN' => $ids])->toarray();
			$current = date('Y-m-d H:i');
			foreach ($talenttraid as $key => $value) {
				$isPaymentdone = $this->Talentadmintransc->updateAll(array('payout_amount' => $value['amount'], 'write_notes' => $write_notes, 'paid_date' => $current), array('id' => $value['id']));
			}
			//pr($talenttraid); die;

			if ($isPaymentdone) {
				$this->Flash->success(__('Selected payout has been paid successfully'));
				return $this->redirect(['action' => 'transcations/' . $talenttraid[0]['talent_admin_id']]);
			}
		}
	}

	// Update Payout information
	public function updatepayout()
	{
		$this->loadModel('Talentadmintransc');
		//$amount = $this->request->data[''];
		$talent_admin_id = $this->request->data['talent_admin_id'];
		$write_notes = $this->request->data['write_notes'];

		$talenttraid = $this->Talentadmintransc->find('all')->where(['talent_admin_id' => $talent_admin_id])->toarray();
		//pr($talenttraid); die;
		$current = date('Y-m-d H:i');
		foreach ($talenttraid as $key => $value) {
			$isPaymentdone = $this->Talentadmintransc->updateAll(array('payout_amount' => $value['amount'], 'write_notes' => $write_notes, 'paid_date' => $current), array('id' => $value['id']));
		}

		if ($isPaymentdone) {
			$this->Flash->success(__('All Payout has been paid successfully'));
			return $this->redirect(['action' => 'paidtransaction/']);
		}
	}



	//when create new user as a talent partner by talent admin...
	public function assigndefaultpackage($user_id)
	{
		$this->loadModel('Packfeature');
		$packfeature = $this->Packfeature->newEntity();
		$feature_info['user_id'] = $user_id;
		$this->loadModel('Profilepack');
		$pcakgeinformation = $this->Profilepack->find('all')->where(['Profilepack.status' => 'Y', 'Profilepack.id' => PROFILE_PACKAGE])->order(['Profilepack.id' => 'ASC'])->first();

		$feature_info['number_audio'] = $pcakgeinformation['number_audio'];
		$feature_info['talent_audio_list_total'] = $pcakgeinformation['number_audio'];
		$feature_info['number_video'] = $pcakgeinformation['number_video'];
		$feature_info['talent_video_list_total'] = $pcakgeinformation['number_video'];
		$feature_info['website_visibility'] = $pcakgeinformation['website_visibility'];
		$feature_info['access_job'] = $pcakgeinformation['access_job'];
		$feature_info['privacy_setting_access'] = $pcakgeinformation['privacy_setting_access'];
		$feature_info['access_to_ads'] = $pcakgeinformation['access_to_ads'];
		$feature_info['number_job_application_month'] = $pcakgeinformation['number_job_application'];
		$feature_info['number_job_application_daily'] = $pcakgeinformation['number_of_application_day'];
		$feature_info['ads_free'] = $pcakgeinformation['ads_free'];
		$feature_info['number_albums'] = $pcakgeinformation['number_albums'];
		$feature_info['number_of_jobs_alerts'] = $pcakgeinformation['number_of_jobs_alerts'];
		$feature_info['number_of_introduction'] = $pcakgeinformation['number_of_introduction'];
		$feature_info['introduction_sent'] = $pcakgeinformation['introduction_sent'];
		$feature_info['number_of_introduction_recived'] = $pcakgeinformation['number_of_introduction_recived'];
		$feature_info['number_of_photo'] = $pcakgeinformation['number_of_photo'];
		$feature_info['ask_for_quote_request_per_job'] = $pcakgeinformation['ask_for_quote_request_per_job'];
		$feature_info['number_of_quote_daily'] = $pcakgeinformation['number_of_quote_daily'];
		$feature_info['job_alerts'] = $pcakgeinformation['job_alerts'];
		$feature_info['number_of_booking'] = $pcakgeinformation['number_of_booking'];
		$feature_info['persanalized_url'] = $pcakgeinformation['persanalized_url'];
		$feature_info['number_categories'] = $pcakgeinformation['number_categories'];
		$feature_info['personal_page'] = $pcakgeinformation['personal_page'];




		// package validity
		$daysofprofile = $pcakgeinformation['validity_days'];
		$this->loadModel('Subscription');
		$subscription = $this->Subscription->newEntity();
		$subscription_info['package_id'] = PROFILE_PACKAGE;
		$subscription_info['user_id'] =  $user_id;
		$subscription_info['package_type'] = "PR";
		$subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofprofile . " days"));
		$subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
		$subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
		$savedata = $this->Subscription->save($subscription_arr);


		// RecuriterPack data
		$this->loadModel('RecuriterPack');
		$pcakgeinformation = $this->RecuriterPack->find('all')->where(['RecuriterPack.status' => 'Y', 'RecuriterPack.id' => RECUITER_PACKAGE])->order(['RecuriterPack.id' => 'DESC'])->first();
		$feature_info['number_of_job_post'] = $pcakgeinformation['number_of_job_post'];
		$feature_info['number_of_job_simultancney'] = $pcakgeinformation['number_of_job_simultancney'];
		$feature_info['Monthly_new_talent_messaging'] = $pcakgeinformation['Monthly_new_talent_messaging'];
		$feature_info['number_of_message'] = $pcakgeinformation['number_of_message'];
		$feature_info['number_of_contact_details'] = $pcakgeinformation['number_of_contact_details'];
		$feature_info['number_of_talent_search'] = $pcakgeinformation['number_of_talent_search'];
		$feature_info['nubmer_of_site'] = $pcakgeinformation['nubmer_of_site'];
		$feature_info['number_of_email'] = $pcakgeinformation['number_of_email'];
		$feature_info['multipal_email_login'] = $pcakgeinformation['multipal_email_login'];

		// recruiter validity
		$daysofrecur = $pcakgeinformation['validity_days'];
		$subscription = $this->Subscription->newEntity();
		$subscription_info['package_id'] = RECUITER_PACKAGE;
		$subscription_info['user_id'] =  $user_id;
		$subscription_info['package_type'] = "RC";
		$subscription_info['expiry_date'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofprofile . " days"));
		$subscription_info['subscription_date'] = date('Y-m-d H:i:s a');
		$subscription_arr = $this->Subscription->patchEntity($subscription, $subscription_info);
		$savedata = $this->Subscription->save($subscription_arr);

		// Non Telent data
		$this->loadModel('Settings');
		$pcakgeinformation = $this->Settings->find('all')->order(['Settings.id' => 'DESC'])->first();
		//$feature_info['number_of_talent_free_jobpost'] = $pcakgeinformation['number_of_talent_free_jobpost'];
		$feature_info['non_telent_number_of_job_post'] = $pcakgeinformation['non_telent_number_of_job_post'];
		$feature_info['non_telent_ask_quote'] = $pcakgeinformation['non_telent_ask_quote'];
		$feature_info['non_talent_number_of_free_booking_req'] = $pcakgeinformation['number_of_free_booking_req'];
		$feature_info['non_telent_number_of_audio'] = $pcakgeinformation['non_telent_number_of_audio'];
		$feature_info['non_telent_number_of_video'] = $pcakgeinformation['non_telent_number_of_video'];
		$feature_info['non_telent_number_of_album'] = $pcakgeinformation['non_telent_number_of_album'];
		$feature_info['non_telent_number_of_folder'] = $pcakgeinformation['non_telent_number_of_folder'];
		//$feature_info['non_telent_number_of_search_profile'] = $pcakgeinformation['non_telent_number_of_search_profile'];
		$feature_info['non_telent_number_of_private_message'] = $pcakgeinformation['non_telent_number_of_private_message'];
		$feature_info['non_talent_video_list_total'] = $pcakgeinformation['non_telent_number_of_video'];
		$feature_info['non_talent_audio_list_total'] = $pcakgeinformation['non_telent_number_of_audio'];
		$feature_info['non_telent_totalnumber_of_images'] = $pcakgeinformation['non_telent_number_of_folder'];
		$daysofnontalent = $pcakgeinformation['non_talent_validity_days'];
		$feature_info['non_telent_expire'] = date('Y-m-d H:i:s a', strtotime("+" . $daysofnontalent . " days"));


		$packfeatures = $this->Packfeature->patchEntity($packfeature, $feature_info);
		$this->Packfeature->save($packfeatures);
		return true;
	}

	public function appointmailsend($name = null, $email = null, $creatdate = null)
	{
		$this->loadmodel('Templates');
		$profile = $this->Templates->find('all')->where(['Templates.id' => APPOINTMENTPARTNER])->first();
		$created = date('M d, Y', strtotime($creatdate));
		$subject = $profile['subject'];
		$from = $profile['from'];
		$fromname = $profile['fromname'];
		$to  = $email;
		$name  = $name;
		$formats = $profile['description'];
		$userexist = $this->Users->find('all')->where(['Users.email' => $to])->count();
		//pr($userexist); die;
		if ($userexist == 1) {
			$visit_site_url = SITE_URL . "/login";
		} else {
			$visit_site_url = SITE_URL . "/signup";
		}
		$site_url = SITE_URL;

		$message1 = str_replace(array('{Name}', '{site_url}', '{commision}', '{created}', '{subject}', '{visit_site_url}'), array($name, $site_url, $commision, $created, $subject, $visit_site_url), $formats);
		$message = stripslashes($message1);
		$message = '
				<!DOCTYPE HTML>
				<html>
				<head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<title>Mail</title>
				</head>
				<body style="padding:0px; margin:0px;font-family:Arial,Helvetica,sans-serif; font-size:13px;">
					' . $message1 . '
				</body>
				</html>
				';

		//pr($message); 
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		//$headers .= 'To: <'.$to.'>' . "\r\n";
		$headers .= 'From: ' . $fromname . ' <' . $from . '>' . "\r\n";
		$emailcheck = mail($to, $subject, $message, $headers);
	}
}
