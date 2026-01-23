<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class JobViewTable extends Table {

    public $name = 'JobView';
public function initialize(array $config)
    {
		$this->table('job_view');
                $this->primaryKey('id');

        
	}
}
?>
