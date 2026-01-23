<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class Personnel_det extends Table {

    public $name = 'Personnel_det';
    public function initialize(array $config)
        {
                    $this->table('personnel_det');
                    $this->primaryKey('id');

    
        }
    }
?>
