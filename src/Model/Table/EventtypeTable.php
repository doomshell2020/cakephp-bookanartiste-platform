<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class EventtypeTable extends Table
{

    public $name = 'Eventtype';
    public function initialize(array $config)
    {
        $this->table('eventtypes');
        $this->primaryKey('id');
    }
}
