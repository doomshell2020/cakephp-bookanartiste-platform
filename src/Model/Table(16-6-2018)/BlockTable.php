<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class BlockTable extends Table {

    public $name = 'blocks';
    public function initialize(array $config)
    {
	$this->table('blocks');
	$this->primaryKey('id');
    }
}

?>
