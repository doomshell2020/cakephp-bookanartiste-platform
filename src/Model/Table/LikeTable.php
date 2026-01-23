<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class LikeTable extends Table {

    public $name = 'likes';
   public function initialize(array $config)
    {
	$this->table('likes');
    $this->primaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);
   
	}
}

?>
