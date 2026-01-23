<?php //	echo "test"; die;

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;


class UservitalTable extends Table {

  public function initialize(array $config)
    {
		$this->table('uservital');
                $this->primaryKey('id');
                
          
		$this->belongsTo('Vques', [
    'foreignKey' => 'vs_question_id',
    'className' => 'Vques'
    ]);
	$this->belongsTo('Voption', [
    'foreignKey' => 'option_value_id',
    'className' => 'Voption'
    ]);	
   
	}
    
    

    
   
}
?>
