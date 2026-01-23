<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class Performance_personaldetails extends Table {

    public $name = 'performance_personaldetails';
    public function initialize(array $config)
        {
                    $this->table('performance_personaldetails');
                    $this->primaryKey('id');
                    
                    
         

    
        }
    }
?>
