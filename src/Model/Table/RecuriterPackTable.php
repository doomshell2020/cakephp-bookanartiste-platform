<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class RecuriterPackTable extends Table {
   public $name = 'Quote';
   public function initialize(array $config)
       {
       
            $this->table('recruiter_packages');
            $this->primaryKey('id');


        
        
        
   	}
   
   	
   	
   	
   }
   
?>
