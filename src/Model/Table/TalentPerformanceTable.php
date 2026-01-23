<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class TalentPerformanceTable extends Table {
   public $name = 'TalentPerformance';
   public function initialize(array $config)
       {
       
    $this->table('performance_desc2');
    $this->primaryKey('id');

    $this->belongsTo('Users', [
           'foreignKey' => 'user_id',
           'joinType' => 'INNER',
       ]);
       
       
    $this->belongsTo('Payment_fequency', [
           'foreignKey' => 'payment_frequency',
           'joinType' => 'INNER',
       ]);
        
        
   	}
   
   	
   	
   	
   }
   
?>