<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class RefersTable extends Table {

    public $name = 'refers';
    public function initialize(array $config)
       {       
            $this->table('refers');
            $this->primaryKey('id');
            
            $this->belongsTo('Users', [
                'foreignKey' => 'user_id',
                'joinType' => 'LEFT',
            ]);
        }
}
?>
