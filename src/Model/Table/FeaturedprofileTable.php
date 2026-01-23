<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class FeaturedprofileTable extends Table {
   public $name = 'Featuredprofile';
   public function initialize(array $config)
       {
       
            $this->table('featured_profile_packages');
            $this->primaryKey('id');
        
   	}
   
   	
   	
   	
   }
   
?>
