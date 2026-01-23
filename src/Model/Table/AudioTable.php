<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class AudioTable extends Table {

    public $name = 'Audio';
public function initialize(array $config)
    {
		$this->table('audios');
        $this->primaryKey('id');
		
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);
   
	}
}
?>
