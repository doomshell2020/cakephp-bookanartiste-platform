<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class JobApplicationTable extends Table
{
   public $name = 'JobApplication';
   public function initialize(array $config)
   {

      $this->table('job_application');
      $this->primaryKey('id');


      $this->belongsTo('Users', [
         'foreignKey' => 'user_id',
         'class' => 'Users',
      ]);


      $this->belongsTo('Requirement', [
         'foreignKey' => 'job_id',
         'class' => 'inner',
      ]);

      $this->belongsTo('Skill', [
         'foreignKey' => 'skill_id',
         'joinType' => 'INNER',
      ]);
   }
}
