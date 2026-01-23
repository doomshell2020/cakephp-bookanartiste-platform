<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class LanguageknownTable extends Table {

    public $name = 'Languageknown';
public function initialize(array $config)
    {
		$this->table('languageknown');
                $this->primaryKey('id');
                
                   $this->belongsTo('Language', [
	    'foreignKey' => 'language_id',
	    'joinType' => 'INNER',
        ]);

  
    }
    }
?>
