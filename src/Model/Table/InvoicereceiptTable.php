<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class InvoicereceiptTable extends Table {

    public $name = 'Invoicereceipt';
    
    public function initialize(array $config)
    {
      $this->table('invoice_receipt');
      $this->primaryKey('id');
    }
          
}
?>
