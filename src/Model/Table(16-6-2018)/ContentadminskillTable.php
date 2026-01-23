<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class ContentadminskillTable extends Table {

    public $name = 'Contentadminskill';
    
    public function initialize(array $config)
    {
      $this->table('contentadminskill');
      $this->primaryKey('id');
      
	$this->belongsTo('Skill', [
   	'foreignKey' => 'skill_id',
   	'joinType' => 'INNER',
               ]);

  
  
    }
          
      
   


}
?>
