<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class SkillsetTable extends Table {
   public $name = 'Skillset';
   public function initialize(array $config)
       {
       
        $this->table('skill');
        $this->primaryKey('id');
    //For city
        $this->belongsTo('Skill', [
   	    'foreignKey' => 'skill_id',
   	    'joinType' => 'INNER',
               ]);


        
        
   	}
   
   	
   	
   	
   }
   
?>