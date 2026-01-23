<?php //	echo "test"; die;

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;


class VquesTable extends Table {

  public function initialize(array $config)
    {
		$this->table('vques');
                $this->primaryKey('id');
                
$this->hasMany('Voption', [
	    'foreignKey' => 'question_id',
	    'joinType' => 'INNER',
	    ]);
   
   // Profile pack
	    $this->belongsTo('Vs_option_type', [
            'foreignKey' => 'option_type_id',
            'joinType' => 'INNER',
            ]);
   
   
   
	}
    
    

    
   
}
?>
