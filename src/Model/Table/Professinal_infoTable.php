<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class Professinal_info extends Table
{

    public $name = 'Professinal_info';
    public function initialize(array $config)
    {
        $this->table('professinal_info');
        $this->primaryKey('id');
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
    }
}
