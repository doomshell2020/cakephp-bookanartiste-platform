<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class TranscationTable extends Table
{

    public $name = 'transcations';
    public function initialize(array $config)
    {
        $this->table('transcations');
        $this->primaryKey('id');

        // profile
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);

        // profile
        $this->belongsTo('Profile', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('Subscription', [
            'foreignKey' => 'subscription_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Requirement', [
            'foreignKey' => 'job_id',
            'joinType' => 'LEFT',
        ]);
    }
}
