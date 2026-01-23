<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class StateTable extends Table {

    public $name = 'States';
public function initialize(array $config)
    {
		$this->table('states');
                $this->primaryKey('id');

        $this->belongsTo('Country', [
	    'foreignKey' => 'country_id',
	    'joinType' => 'INNER',
        ]);
	}
}
?>
