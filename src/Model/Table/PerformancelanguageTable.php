<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class PerformancelanguageTable extends Table {
   public $name = 'Performancelanguage';
   public function initialize(array $config)
       {
       
        $this->table('performance_language');
        $this->primaryKey('id');
   	
   	
   	
   	
   	 $this->belongsTo('Language', [
	    'foreignKey' => 'language_id',
	    'joinType' => 'INNER',
        ]);
   	
   	
   	
   	}
   
   	
   	
   	
   }
   
?>
