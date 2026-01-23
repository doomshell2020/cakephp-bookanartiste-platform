<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class PackfeatureTable extends Table {

public $name = 'user_package_limits';
public function initialize(array $config)
    {
		$this->table('user_package_limits');
        $this->primaryKey('id');

        $this->belongsTo('Users', [
	    'foreignKey' => 'user_id',
	    'joinType' => 'INNER',
        ]);
	}
}
