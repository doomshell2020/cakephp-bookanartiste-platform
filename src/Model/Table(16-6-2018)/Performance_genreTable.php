<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class Performance_genre extends Table {

    public $name = 'performance_genre';
    public function initialize(array $config)
        {
                    $this->table('performance_genre');
                    $this->primaryKey('id');
                    
    
        }
    }
?>
