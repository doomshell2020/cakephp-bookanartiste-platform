<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class VsoptionvalueTable extends Table {

    public $name = 'Vsoptionvalues';
    public function initialize(array $config)
        {
                    $this->table('vsoptionvalue');
                    $this->primaryKey('id');
                    
                    
		$this->belongsTo('Vsquestions', [
		'foreignKey' => 'question_id',
		'joinType' => 'INNER',
		]);
                    
    
        }
    }
?>
