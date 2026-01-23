<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ActivitiesTable extends Table {
    public $name = 'activities';
    public function initialize(array $config)
    {
	$this->table('activities');
	$this->primaryKey('id');
	
	 $this->belongsTo('Galleryimage', [
	    'foreignKey' => 'photo_id',
	    'joinType' => 'LEFT',
        ]);
        
        $this->belongsTo('Users', [
	    'foreignKey' => 'profile_id',
	    'joinType' => 'LEFT',
        ]);
        
    }
}
?>
