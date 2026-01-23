<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class SaveprofilesearchTable extends Table {
   
   public function initialize(array $config)
       {
       
        $this->table('refineprofile');
        $this->primaryKey('id');


	
        
   	}
   
   	
   	
   	
   }
   
?>