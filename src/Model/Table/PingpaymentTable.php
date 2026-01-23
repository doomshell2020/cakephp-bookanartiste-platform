<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class PingpaymentTable extends Table {

	public $name = 'ping_payment';
	public function initialize(array $config)
	{
	    $this->table('ping_payment');
	    $this->primaryKey('id');
	    
	    
	    
	   
            
	}

}

?>
