<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class PaymentfequencyTable extends Table {

    public $name = 'Paymentfequency';
public function initialize(array $config)
    {
		$this->table('payment_fequency');
                $this->primaryKey('id');

  
    }
    }
?>
