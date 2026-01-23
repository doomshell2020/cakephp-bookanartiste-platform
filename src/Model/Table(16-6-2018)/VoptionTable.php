<?php //	echo "test"; die;

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;


class VoptionTable extends Table {

  public function initialize(array $config)
    {
		$this->table('voption');
                $this->primaryKey('id');

   
	}
    
    

    
   
}
?>
