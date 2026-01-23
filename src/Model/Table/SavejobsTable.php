<?php 
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class SavejobsTable extends Table {

    public $name = 'Savejobs';
public function initialize(array $config)
    {
		$this->table('savejobs');
                $this->primaryKey('id');
 $this->primaryKey('id');
             $this->belongsTo('Requirement', [
            'foreignKey' => 'job_id',
            'joinType' => 'INNER',
            ]);
   
	}
}
?>
