<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class Questionmare_options_typeTable extends Table {

    public $name = 'Questionmare_options_type';
public function initialize(array $config)
    {
		$this->table('questionmare_options_type');
                $this->primaryKey('id');

  
    }
    }
?>
