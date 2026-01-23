<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class RequirementTable extends Table {

    public $name = 'Requirement';
    
    public function initialize(array $config)
    {
      $this->table('requirement');
      $this->primaryKey('id');
  
      $this->belongsTo('Country', [
            'foreignKey' => 'country_id',
            'joinType' => 'INNER',
            ]);

      $this->belongsTo('State', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER',
            ]);

      $this->belongsTo('City', [
            'foreignKey' => 'city_id',
            'joinType' => 'INNER',
            ]);

      $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);
      $this->belongsTo('Eventtype', [
            'foreignKey' => 'event_type',
            'joinType' => 'INNER',
            ]);
            
           
      $this->hasMany('BookingRequest', [
      'foreignKey' => 'job_id',
      'joinType' => 'INNER',
      ]);    
$this->hasMany('JobView', [
      'foreignKey' => 'job_id',
      'joinType' => 'INNER',
      ]);
    $this->hasMany('RequirmentVacancy', [
      'foreignKey' => 'requirement_id',
      'joinType' => 'INNER',
      ]);
  $this->hasMany('JobQuote', [
      'foreignKey' => 'job_id',
      'joinType' => 'INNER',
      ]);

   $this->hasMany('Jobquestion', [
      'foreignKey' => 'job_id',
      'joinType' => 'INNER',
      ]);
      $this->hasMany('JobApplication', [
      'foreignKey' => 'job_id',
      'joinType' => 'INNER',
      ]); 
      
      
    }
          
      
   


}
?>
