<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class UserjobanswerTable extends Table {

    public $name = 'UserJobanswer';
public function initialize(array $config)
    {
		$this->table('userjobanswer');
        $this->primaryKey('id');

  	
    }
    }
?>
