<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class JobanswerTable extends Table {

    public $name = 'Jobanswer';
public function initialize(array $config)
    {
		$this->table('job_answer');
                $this->primaryKey('id');

  
    }
    }
?>
