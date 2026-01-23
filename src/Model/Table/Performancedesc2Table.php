<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class Performancedesc2Table extends Table {
   public $name = 'Performancedesc2';
   public function initialize(array $config)
       {
       
        $this->table('performance_desc2');
        $this->primaryKey('id');
    //For city
        $this->belongsTo('City', [
   	    'foreignKey' => 'city',
   	    'joinType' => 'INNER',
               ]);
               
    //for country
        $this->belongsTo('Country', [
   	    'foreignKey' => 'country_code',
   	    'joinType' => 'INNER',
               ]);
       
    //for state
       
        $this->belongsTo('State', [
   	    'foreignKey' => 'state',
   	    'joinType' => 'INNER',
               ]);
    $this->belongsTo('Users', [
           'foreignKey' => 'user_id',
           'joinType' => 'INNER',
       ]);
       
       $this->belongsTo('Currency', [
           'foreignKey' => 'currency_id',
           'joinType' => 'INNER',
       ]);
       
       $this->belongsTo('Paymentfequency', [
           'foreignKey' => 'payment_frequency',
           'joinType' => 'INNER',
       ]);
       
       
       
        
        
   	}
   
   	
   	
   	
   }
   
?>
