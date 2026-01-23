<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class CurrencyTable extends Table {

    public $name = 'currencys';
public function initialize(array $config)
    {
		$this->table('currencys');
                $this->primaryKey('id');


	}
}
?>
