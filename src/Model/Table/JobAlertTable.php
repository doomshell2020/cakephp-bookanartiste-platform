<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class JobAlertTable extends Table
{
   public $name = 'JobAlert';
   public function initialize(array $config)
   {

      $this->table('job_alert');
      $this->primaryKey('id');


      $this->belongsTo('Users', [
         'foreignKey' => 'user_id',
         'class' => 'Users',
      ]);

      $this->belongsTo('Requirement', [
         'foreignKey' => 'job_id',
         'class' => 'Requirement',
      ]);
   }
}
