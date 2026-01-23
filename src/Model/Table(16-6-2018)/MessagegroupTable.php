<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class MessagegroupTable extends Table {

    public $name = 'Messagegroup';
	
	
    public function initialize(array $config)
    {
	$this->table('message_folders');
	$this->primaryKey('id');

	$this->belongsTo('Users', [
	'foreignKey' => 'from_id',
	'joinType' => 'INNER',
	]);
    }
	 


}
?>
