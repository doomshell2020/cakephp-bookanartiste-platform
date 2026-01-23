<?php
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class ProfileadvertpackTable extends Table {
   public $name = 'Profileadvertpack';
   public function initialize(array $config)
       {
            $this->table('advrt_profile_pack');
            $this->primaryKey('id');
            
            $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);
       }
}
