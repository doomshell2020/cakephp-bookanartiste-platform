<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class EventtypeTable extends Table {

    public $name = 'country';
public function initialize(array $config)
    {
		$this->table('eventtypes');
                $this->primaryKey('id');
                
                
           

    }
    }
?>
