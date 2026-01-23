<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class TalentadminskillTable extends Table {

    public $name = 'Talentadminskill';
    
    public function initialize(array $config)
    {
      $this->table('talentadminskill');
      $this->primaryKey('id');
      
	$this->belongsTo('Skill', [
   	'foreignKey' => 'skill_id',
   	'joinType' => 'INNER',
    ]);
  
    }
          
      
   


}
?>
