<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class Performance_desc extends Table {

    public $name = 'performance_desc';
    public function initialize(array $config)
        {
                    $this->table('performance_desc');
                    $this->primaryKey('id');
                    
    
        }
    }
?>
