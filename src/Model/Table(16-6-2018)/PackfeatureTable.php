<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class PackfeatureTable extends Table {

    public $name = 'package_features';
public function initialize(array $config)
    {
		$this->table('package_features');
        $this->primaryKey('id');

        $this->belongsTo('Users', [
	    'foreignKey' => 'user_id',
	    'joinType' => 'INNER',
        ]);
	}
}
?>
