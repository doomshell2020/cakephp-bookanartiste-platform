<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class SubscriptionTable extends Table {

	public $name = 'subscriptions';
	public function initialize(array $config)
	{
	    $this->table('subscriptions');
	    $this->primaryKey('id');
	    
	     // profile
	    $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);
	    
	    // profile
	    $this->belongsTo('Profile', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);
	    
	    
	   
	}

}

?>
