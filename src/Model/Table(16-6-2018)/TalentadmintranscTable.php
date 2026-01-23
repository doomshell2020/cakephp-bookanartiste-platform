<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class TalentadmintranscTable extends Table {

	public $name = 'Talentadmintransc';
	public function initialize(array $config)
	{
	    $this->table('talentadmintransc');
	    $this->primaryKey('id');
	    
	    
	    
	   
	   // profile
	    $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'LEFT',
            ]);
	    
	    // profile
	    $this->belongsTo('Profile', [
            'foreignKey' => 'user_id',
            'joinType' => 'LEFT',
            ]);
            
	}

}

?>
