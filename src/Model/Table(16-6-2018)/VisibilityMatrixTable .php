<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class VisibilityMatrixTable extends Table {

    public $name = 'VisibilityMatrix';
public function initialize(array $config)
    {
		$this->table('visibility_matrix');
        $this->primaryKey('id');

   
	}
}
?>
