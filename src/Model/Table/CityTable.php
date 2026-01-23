<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class CityTable extends Table {

    public $name = 'City';
public function initialize(array $config)
    {
		$this->table('cities');
                $this->primaryKey('id');

        $this->belongsTo('States', [
	    'foreignKey' => 'state_id',
	    'joinType' => 'INNER',
        ]);
	}
}
?>
