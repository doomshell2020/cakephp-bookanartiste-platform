<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProfileTable extends Table
{
   public $name = 'Profile';
   public function initialize(array $config)
   {

      $this->table('personal_profile');
      $this->primaryKey('id');
      //For city
      $this->belongsTo('City', [
         'foreignKey' => 'city_id',
         'joinType' => 'LEFT',
      ]);

      //for country
      $this->belongsTo('Country', [
         'foreignKey' => 'country_ids',
         'joinType' => 'LEFT',
      ]);

      //for Currency
      $this->belongsTo('Currency', [
         'foreignKey' => 'currency_id',
         'joinType' => 'LEFT',
      ]);

      //for state

      $this->belongsTo('State', [
         'foreignKey' => 'state_id',
         'joinType' => 'LEFT',
      ]);

      $this->belongsTo('Users', [
         'foreignKey' => 'user_id',
         'joinType' => 'LEFT',
      ]);

      $this->belongsTo('Skillset', [
         'foreignKey' => 'user_id',
         'joinType' => 'LEFT',
      ]);

      $this->belongsTo('Enthicity', [
         'foreignKey' => 'ethnicity',
         'joinType' => 'LEFT',
      ]);
      // new add prfoiel title
      // $this->belongsTo('Profiletitle', [
      //    'foreignKey' => 'profiletitle',
      //    'joinType' => 'LEFT',
      //    ]);


   }
}
