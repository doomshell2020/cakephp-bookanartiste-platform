<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class SkillTable extends Table {
   public $name = 'skill_type';
   public function initialize(array $config)
       {
       
        $this->table('skill_type');
        $this->primaryKey('id');

	$this->belongsTo('Vitalskills', [
	    'foreignKey' => 'id',
	    'joinType' => 'LEFT',
	]);
	
	
	
        
   	}
   
   	
   	
   	
   }
   
?>