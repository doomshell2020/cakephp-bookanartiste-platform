<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class Loginusercheck extends Table {

    public $name = 'Loginusercheck';
    public function initialize(array $config)
        {
                    $this->table('loginusercheck');
                    $this->primaryKey('id');
                    
    
        }
    }
?>
