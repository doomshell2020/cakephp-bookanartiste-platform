<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class TalentadminTable extends Table {

    public $name = 'Talentadmin';
    
    public function initialize(array $config)
    {
      $this->table('talentadmin');
      $this->primaryKey('id');
  

      $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);

  
  
    }
          
      
   


}
?>
