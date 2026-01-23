<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class ProfilepackTable extends Table {
   public $name = 'Profile';
   public function initialize(array $config)
       {
            $this->table('profile_package');
            $this->primaryKey('id');
   	}
   
   	
   	
   	
   }
   
?>
