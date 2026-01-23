<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class TalentAdminTable extends Table {

    public $name = 'TalentAdmin';
    
    public function initialize(array $config)
    {
      $this->table('talent_admin');
      $this->primaryKey('id');
  

	
    $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);
            
            

     $this->belongsTo('City', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER',
            ]);

            //for country
            $this->belongsTo('Country', [
            'foreignKey' => 'country_id',
            'joinType' => 'INNER',
            ]);

            //for state

            $this->belongsTo('State', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER',
            ]);
            
	    $this->hasMany('Talentadminskill', [
	    'foreignKey' => 'talent_admin_id',
	    'joinType' => 'INNER',
	    ]);
            
            
  
  
    }
          
      
   


}
?>
