<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class StudentrunTable extends Table
{

    public function initialize(array $config)
    {

        $this->table('studentrun');
        $this->primaryKey('id');
        $this->belongsTo('Country', [
            'foreignKey' => 'country_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('States', [
            'foreignKey' => 'states',
            'joinType' => 'LEFT',
        ]);
    }
}