<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class RequirementPackTable extends Table {
   public $name = 'Requirement';
   public function initialize(array $config)
       {
       
            $this->table('requirement_pack');
            $this->primaryKey('id');


        
        
        
   	}
   
   	
   	
   	
   }
   
?>
