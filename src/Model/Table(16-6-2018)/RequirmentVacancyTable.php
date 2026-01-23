<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class RequirmentVacancyTable extends Table {
    public $name = 'RequirmentVacancy';
    public function initialize(array $config)
    {
	$this->table('requirement_vacancy');
	$this->primaryKey('id');
	
	
	$this->belongsTo('Requirement', [
	    'foreignKey' => 'requirement_id',
	    'joinType' => 'INNER',
	]);
	$this->belongsTo('Skill', [
	    'foreignKey' => 'telent_type',
	    'joinType' => 'INNER',
	]);

	$this->belongsTo('Currency', [
	    'foreignKey' => 'payment_currency',
	    'joinType' => 'INNER',
	]);

	$this->belongsTo('Paymentfequency', [
	    'foreignKey' => 'payment_freq',
	    'joinType' => 'INNER',
	]);

    }
}
   
?>
