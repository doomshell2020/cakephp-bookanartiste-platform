<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class NotificationTable extends Table {
    public $name = 'Notification';
    public function initialize(array $config)
    {
	$this->table('notification');
	$this->primaryKey('id');
	
	$this->belongsTo('Users', [
	    'foreignKey' => 'notification_sender',
	    'joinType' => 'INNER',
    ]);
    }
}
?>
