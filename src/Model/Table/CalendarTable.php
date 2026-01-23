<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class CalendarTable extends Table {

    public $name = 'Calendar';
public function initialize(array $config)
    {
		$this->table('calendar');
                $this->primaryKey('id');

   
	}
}
?>
