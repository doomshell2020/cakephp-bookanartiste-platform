<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class SubscriptionTable extends Table
{

    public $name = 'subscriptions';
    public function initialize(array $config)
    {
        $this->table('subscriptions');
        $this->primaryKey('id');

        // profile
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Profilepack', [
            'foreignKey' => 'package_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('RequirementPack', [
            'foreignKey' => 'package_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('RecuriterPack', [
            'foreignKey' => 'package_id',
            'joinType' => 'LEFT',
        ]);

    }
}
