<?php
namespace APP\Controller;
use App\Controller\AppController;

class StudentrunController extends AppController
{
 //initialize component
//  public $paginate = ['limit' => 10];

 public function initialize()
 {
     parent::initialize();
    //  $this->loadComponent('Paginator');
 }

 public function index()
 {
    //  $this->loadComponent('Paginator');
    //  $this->viewBuilder()->layout('admin');

     $this->loadModel('Studentrun');
  //    $data = $this->request->query;
  // search data get
     $reqdata = $_GET;
     
     $name= $reqdata['first_name'];
     $mobile =trim($reqdata['phone']);
     $dob = date('Y-m-d', strtotime($reqdata['dob']));   
     
             //   array $cond in searchin
     $cond = [];

     if (!empty($name)) {
         $contra = ['Studentrun.first_name LIKE' => '%' . $name . '%'];
         $cond[] = $contra;
     }

     if (!empty($mobile)) {
         $contra = ['Studentrun.phone LIKE' => '%' . $mobile . '%'];
         $cond[] = $contra;
     }

     if ($dob !== '1970-01-01') {
         $contra = ['DATE(Studentrun.dob) ' =>$dob];
         $cond[] = $contra;
     }
    
     // searching data condition using  if| other wise else the view all data
     if ($reqdata) {
         $students = $this->Studentrun->find('all')->where($cond)->contain(['Country'])->order(['Studentrun.id' => 'Desc']);
     } else {
         $students = $this->Studentrun->find('all')->contain(['Country'])->order(['Studentrun.id' => 'DESC'])->toarray();
         
     }

     $this->set('students', $students);
   
 }
 public function search()
 {
     $this->loadModel('Studentrun');

     $reqdata = $_GET;       
     $name= $reqdata['first_name'];
     $mobile =trim($reqdata['phone']);
     $dob = date('Y-m-d', strtotime($reqdata['dob']));
 
     $cond = [];
     if (!empty($name)) {
         $contra = ['Studentrun.first_name LIKE' => '%' . $name . '%'];
         $cond[] = $contra;
     }
     if (!empty($mobile)) {
         $contra = ['Studentrun.phone LIKE' => '%' . $mobile . '%'];
         $cond[] = $contra;
     }
     if ($dob !== '1970-01-01') {
         $contra = ['DATE(Studentrun.dob) ' =>$dob];
         $cond[] = $contra;
     }
     //    write the session
     $this->request->session()->write('cond',  $cond);
     // get searching data
     $students = $this->Studentrun->find('all')->where($cond)->order(['Studentrun.id' => 'Desc']);

     $students = $this->paginate($students)->toarray();      
     $this->set('students',$students);
 }
    
 
 public function add()
 {
    //  $this->viewBuilder()->layout('admin');
     $this->loadModel('States');
     $this->loadModel('Country');
     $this->loadModel('Studentrun');
    // Country table  find data
     $country = $this->Country->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Country.status' => 'Y'])->order(['id' => 'ASC'])->toarray();
     $this->set('country', $country);
      // States table find data
     $states = $this->States->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['States.status' => 'Y'])->order(['id' => 'ASC'])->toarray();
     $this->set('states', $states);
      // post the data in database
     if ($this->request->is('post')) {

         //  pr( $this->request->data);exit;

         $skills = implode(",", $this->request->data['skill']);
         $this->request->data['skill'] = $skills;

         if ($this->request->data['document'][0]['name'] != '') {
             $document = [];

             foreach ($this->request->data['document'] as
                 $key => $value) {
                 $filename = $value['name'];
                 $ext = end(explode('.', $filename));
                 $name = md5(time($filename));
                 $rnd = mt_rand();
                 $imagename = trim($name . $rnd . '.' . $ext, "");
                 if (move_uploaded_file($value['tmp_name'], "sliderimages/" . $imagename)) {
                     $document[] = $imagename;
                 }
                 $this->request->data['document'] = implode(",", $document);
             }
         }

         if ($this->request->data['image']['name'] != '') {
             $k = $this->request->data['image'];
             $filename = $k['name'];
             $ext = end(explode('.', $filename));
             $name = md5(time($filename));
             $rnd = mt_rand();
             $imagename = trim($name . $rnd . $i . '.' . $ext, "");
             if (move_uploaded_file($k['tmp_name'], "sliderimages/" . $imagename)) {
                 $this->request->data['image'] = $imagename;
             }
         }
         $students = $this->Studentrun->newEntity();
         $students = $this->Studentrun->patchEntity($students, $this->request->data);
         if ($this->Studentrun->save($students)) {
             $this->Flash->success('Student has been saved.');
             return $this->redirect(['action' => 'index']);
         } else {
             $this->Flash->error('Unable to add student. Please, try again.');
         }
     }
     $this->set(compact('students'));
 }

 public function edit($id = null)
 {
    //  $this->viewBuilder()->layout('admin');
     $this->loadModel('Studentrun');
     $this->loadModel('States');
     $this->loadModel('Country');
 
     // Retrieve the student data for editing
     $student = $this->Studentrun->find('all')->contain(['States'])->where(['Studentrun.id' => $id])->first();
     $this->set('student', $student);
      
     // Retrieve the list of countries table for dropdown
     $country = $this->Country->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['Country.status' => 'Y'])->order(['id' => 'ASC'])->toArray();
     $this->set('country', $country);
 
     // Retrieve the list of states table for dropdown
     $states = $this->States->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['States.status' => 'Y'])->order(['id' => 'ASC'])->toArray();
     $this->set('states', $states);
 
     // Handle form submission
     if ($this->request->is(['post', 'put'])) {
         // all data get id in table
         $student = $this->Studentrun->get($id);
          

         // Update skills
         $skills = implode(",", $this->request->data['skill']);
         $this->request->data['skill'] = $skills;
 
         // Update multiple images
         if (!empty($this->request->data['document'][0]['name'])) {

             // Unlink existing documents
             $existingDocuments = explode(",",  $student['document']);
             foreach ($existingDocuments as $existingDocument) {
                 unlink("sliderimages/{$existingDocument}");
             }
 
             $documents = [];
             foreach ($this->request->data['document'] as $document) {
                 $filename = $document['name'];
                 $name = md5(time() . $filename);
                 $ext = pathinfo($filename, PATHINFO_EXTENSION);
                 $imagename = $name . '.' . $ext;
 
                 $dest = "sliderimages/";
                 $newfile = $dest . $imagename;
 
                 if (move_uploaded_file($document['tmp_name'], $newfile)) {
                     $documents[] = $imagename;
                 }
                 $this->request->data['document'] = implode(",", $documents);
             }
         }else{
             $this->request->data['document'] = $student['document'];
         }
 
         // Update image
         if (!empty($this->request->data['file']['name'])) {
             // unlink image in folder sliderimage
             unlink("sliderimages/{$student['image']}");
 
             $filename = $this->request->data['file']['name'];
             $name = md5(time() . $filename);
             $ext = pathinfo($filename, PATHINFO_EXTENSION);
             $imagename = $name . '.' . $ext;
 
             $dest = "sliderimages/";
             $newfile = $dest . $imagename;
 
             if (move_uploaded_file($this->request->data['file']['tmp_name'], $newfile)) {
                 $this->request->data['image'] = $imagename;
             }
         }
 
         $students = $this->Studentrun->patchEntity($student, $this->request->data);
        
 
         if ($this->Studentrun->save($students)) {
             $this->Flash->success('Student updated.');
             return $this->redirect(['action' => 'index']);
         } else {
             $this->Flash->error('Unable to update student. Please, try again.');
         }
     }
 }
 
 public function delete($id)
 {

     $this->viewBuilder()->layout('admin');
     $this->loadModel('Studentrun');
     $students = $this->Studentrun->get($id);



     unlink("sliderimages/{$students['image']}");

     $this->Studentrun->delete($students);
     // $this->flash->Success(__('deleted data'));
     return $this->redirect(['action' => 'index']);
 }
 public function getStates()
 {
     $this->loadModel('Studentrun');
     $this->loadModel('Country');
     $this->loadModel('States');
     $this->autoRender = false;
     $countryId = $this->request->data('id');
     $states = $this->States->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['States.c_id' =>  $countryId])->order(['id' => 'ASC'])->toarray();


     echo json_encode($states);
     die;
     // echo "<option>--Select States-- </option>";
     // foreach ($states as $bj) {
     //     echo "<option value=" . $bj['countryId'] . ">" . $bj['name'] . "</option>";
     // }
     // die;

 }

}



?>