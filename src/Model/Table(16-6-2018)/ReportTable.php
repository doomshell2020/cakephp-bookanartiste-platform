<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ReportTable extends Table {

    public $name = 'reports';
public function initialize(array $config)
    {
		$this->table('reports');
                $this->primaryKey('id');
  /*$this->belongsTo('Users', [
            'foreignKey' => 'profile_id',
            'joinType' => 'INNER',
            ]); */
    }
   
	}

?>
