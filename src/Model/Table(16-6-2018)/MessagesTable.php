<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class MessagesTable extends Table {

    public $name = 'messages';
	
	
    public function initialize(array $config)
    {
	$this->table('messages');
	$this->primaryKey('id');

	$this->belongsTo('Users', [
	'foreignKey' => 'from_id',
	'joinType' => 'INNER',
	]);

	//$this->belongsTo('Users', [
	//'foreignKey' => 'to_id',
	//'joinType' => 'INNER',
	//]);
    }
	 


}
?>
