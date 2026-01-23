<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class PersonalPageTable extends Table {

    public $name = 'PersonalPage';
public function initialize(array $config)
    {
		$this->table('personal_page');
        $this->primaryKey('id');

   
	}
}
?>
