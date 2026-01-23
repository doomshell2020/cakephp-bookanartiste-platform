<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class SavejobsearchTable extends Table {
   
   public function initialize(array $config)
       {
       
        $this->table('jobrefinesave');
        $this->primaryKey('id');


	
        
   	}
   
   	
   	
   	
   }
   
?>