<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class VsquestionTable extends Table {

    public $name = 'Vsquestions';
    public function initialize(array $config)
        {
                    $this->table('vsquestion');
                    $this->primaryKey('id');
                  
                  $this->hasMany('Vsoptionvalues', [
	    
	    ]);
                  
                  
                 
    
        }
    }
?>
