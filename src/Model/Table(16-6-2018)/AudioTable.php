<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class AudioTable extends Table {

    public $name = 'audios';
public function initialize(array $config)
    {
		$this->table('audios');
                $this->primaryKey('id');

   
	}
}
?>
