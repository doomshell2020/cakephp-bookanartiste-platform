<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class ProfileTable extends Table {
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
            'joinType' => 'INNER',
            ]);

            //for state

            $this->belongsTo('State', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER',
            ]);

            $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);
            
            $this->belongsTo('Skillset', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);

            $this->belongsTo('Enthicity', [
            'foreignKey' => 'ethnicity',
            'joinType' => 'INNER',
            ]);
			
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);
        
   	}
   
   	
   	
   	
   }
   
?>
