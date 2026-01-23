<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class ProfilecounterTable extends Table {

    public $name = 'Profilecounter';
    public function initialize(array $config)
        {
                    $this->table('profilecounter');
                    $this->primaryKey('id');
       
                  
                 
    
        }
    }
?>
