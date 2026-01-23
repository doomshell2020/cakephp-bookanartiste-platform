<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class EnthicityTable extends Table {
   public $name = 'Enthicity';
   public function initialize(array $config)
       {
       
        $this->table('enthicity');
        $this->primaryKey('id');


        
        
   	}
   
   	
   	
   	
   }
   
?>