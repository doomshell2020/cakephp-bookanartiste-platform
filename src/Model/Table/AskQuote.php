<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class AskQuoteTable extends Table {
   public $name = 'AskQuote';
   public function initialize(array $config)
       {
       
            $this->table('ask_quote');
            $this->primaryKey('id');


        
        
        
   	}
   
   	
   	
   	
   }
   
?>
