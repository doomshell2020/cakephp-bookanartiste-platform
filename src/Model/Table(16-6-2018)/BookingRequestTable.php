<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class BookingRequestTable extends Table {
   public $name = 'BookingRequest';
   public function initialize(array $config)
       {
       
            $this->table('booking_request');
            $this->primaryKey('id');


	$this->belongsTo('Users', [
            'foreignKey' => 'nontalent_id',
            'class' => 'Users',
            ]);
   
        
   	}
   
   	
   	
   	
   }
   
?>
