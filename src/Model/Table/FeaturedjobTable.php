<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class FeaturedjobTable extends Table {
   public $name = 'Featuredjob';
   public function initialize(array $config)
       {
       
            $this->table('featured_jobs_packages');
            $this->primaryKey('id');


        
        
        
   	}
   
   	
   	
   	
   }
   
?>
