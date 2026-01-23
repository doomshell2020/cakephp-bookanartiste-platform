<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class VideoTable extends Table {

    public $name = 'videos';
public function initialize(array $config)
    {
		$this->table('videos');
                $this->primaryKey('id');

   
	}
}
?>
