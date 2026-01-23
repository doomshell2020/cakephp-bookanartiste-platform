<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class ProfilefeaturedTable extends Table {
   public $name = 'Profilefeatured';
   public function initialize(array $config)
       {
       
            $this->table('profile_featured');
            $this->primaryKey('id');

            $this->belongsTo('Users', [
                'foreignKey' => 'user_id',
                'joinType' => 'left',
            ]);
        
       }
   }
   
?>
