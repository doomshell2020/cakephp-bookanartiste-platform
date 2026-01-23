<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class Prof_website extends Table {

    public $name = 'Prof_website';
    public function initialize(array $config)
        {
                    $this->table('prof_website');
                    $this->primaryKey('id');

    
        }
    }
?>
