<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class StaticTable extends Table {
   public $name = 'static_page';
   public function initialize(array $config)
       {
       
        $this->table('static_page');
        $this->primaryKey('id');


        
        
   	}
   
   	
   	
   	
   }
   
?>