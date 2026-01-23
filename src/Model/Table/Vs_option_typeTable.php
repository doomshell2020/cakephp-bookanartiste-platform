<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class Vs_option_typeTable extends Table {
   //public $name = 'Vs_option_type';
   public function initialize(array $config)
       {
       
        $this->table('vs_option_type');
        $this->primaryKey('id');


        
        
   	}
   
   	
   	
   	
   }
   
?>
