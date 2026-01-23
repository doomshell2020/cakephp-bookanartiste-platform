<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ContactrequestTable extends Table {

    public $name = 'Contactrequest';
public function initialize(array $config)
    {
		$this->table('contactrequest');
        $this->primaryKey('id');

        $this->belongsTo('Users', [
	    'foreignKey' => 'from_id',
	    'joinType' => 'INNER',
        ]);
        
        $this->belongsTo('Users', [
	    'foreignKey' => 'to_id',
	    'joinType' => 'INNER',
        ]);
        
    
        
        
	}
}
?>
