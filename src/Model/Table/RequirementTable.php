<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class RequirementTable extends Table
{

      public $name = 'Requirement';

      public function initialize(array $config)
      {
            $this->table('requirement');
            $this->primaryKey('id');

            $this->belongsTo('Country', [
                  'foreignKey' => 'country_id',
                  'joinType' => 'LEFT',
            ]);

            $this->belongsTo('State', [
                  'foreignKey' => 'state_id',
                  'joinType' => 'LEFT',
            ]);

            $this->belongsTo('City', [
                  'foreignKey' => 'city_id',
                  'joinType' => 'LEFT',
            ]);

            $this->belongsTo('Eventtype', [
                  'foreignKey' => 'event_type',
                  'joinType' => 'left',
            ]);
            $this->belongsTo('Users', [
                  'foreignKey' => 'user_id',
                  'joinType' => 'left',
            ]);

            $this->belongsTo('Featuredjob', [
                  'foreignKey' => 'feature_job_pack',
                  'joinType' => 'left',
            ]);

            $this->hasOne('Jobadvertpack', [
                  'foreignKey' => 'requir_id',
                  'joinType' => 'left',
            ]);

            $this->hasMany('BookingRequest', [
                  'foreignKey' => 'job_id',
                  'joinType' => 'left',
            ]);

            $this->hasMany('JobView', [
                  'foreignKey' => 'job_id',
                  'joinType' => 'left',
            ]);

            $this->hasMany('RequirmentVacancy', [
                  'foreignKey' => 'requirement_id',
                  'joinType' => 'left',
            ]);

            $this->hasMany('JobQuote', [
                  'foreignKey' => 'job_id',
                  'joinType' => 'left',
            ]);


            $this->hasMany('Jobquestion', [
                  'foreignKey' => 'job_id',
                  'joinType' => 'left',
            ]);

            $this->hasMany('JobApplication', [
                  'foreignKey' => 'job_id',
                  'joinType' => 'left',
            ]);
      }
}
