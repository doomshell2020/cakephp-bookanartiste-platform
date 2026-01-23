<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class LanguageTable extends Table {

    public $name = 'Language';
public function initialize(array $config)
    {
		$this->table('languages');
                $this->primaryKey('id');

  
    }
    }
?>
