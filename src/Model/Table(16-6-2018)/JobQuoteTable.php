<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class JobQuoteTable extends Table {
   public $name = 'JobQuote';
   public function initialize(array $config)
       {
       
            $this->table('job_quote');
            $this->primaryKey('id');


	$this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'class' => 'Users',
            ]);
		   $this->belongsTo('Skill', [
   	    'foreignKey' => 'skill_id',
   	    'joinType' => 'INNER',
               ]);
            
	$this->belongsTo('Requirement', [
            'foreignKey' => 'job_id',
            'class' => 'Requirement',
            ]);
   
        
   	}
   
   	
   	
   	
   }
   
?>
