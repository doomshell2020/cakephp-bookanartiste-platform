<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class Talent_portfolio extends Table {

    public $name = 'Talent_portfolio';
    public function initialize(array $config)
        {
                    $this->table('talent_portfolio');
                    $this->primaryKey('id');

    
        }
    }
?>
