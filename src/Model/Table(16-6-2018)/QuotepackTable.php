<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class QuotepackTable extends Table {
   public $name = 'Quote';
   public function initialize(array $config)
       {
       
            $this->table('quote_package');
            $this->primaryKey('id');


        
        
        
   	}
   
   	
   	
   	
   }
   
?>
