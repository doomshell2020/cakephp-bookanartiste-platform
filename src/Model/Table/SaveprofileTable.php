<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class SaveprofileTable extends Table {

    public $name = 'saveprofiles';
public function initialize(array $config)
    {
		$this->table('saveprofiles');
        $this->primaryKey('id');
             $this->belongsTo('Users', [
            'foreignKey' => 'p_id',
            'joinType' => 'INNER',
            ]);
	}
}
?>
