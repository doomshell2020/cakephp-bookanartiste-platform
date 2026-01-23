<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class VitalskillsTable extends Table {
    public $name = 'Vitalskills';
    public function initialize(array $config)
    {
	$this->table('skills_vitals');
	$this->primaryKey('id');
	
	$this->belongsTo('Vs_questions', [
	    'foreignKey' => 'is_vitals',
	    'joinType' => 'INNER',
	]);
	
	$this->belongsTo('Skill', [
	    'foreignKey' => 'skills_id',
	    'joinType' => 'INNER',
	]);
    }
}
   
?>
