<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class CountryTable extends Table {

    public $name = 'country';
public function initialize(array $config)
    {
		$this->table('country');
                $this->primaryKey('id');
                
                
                 $this->hasMany('State', [
	    
	    ]);

    }
    }
?>
