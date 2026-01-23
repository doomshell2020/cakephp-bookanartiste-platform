<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class GenreskillsTable extends Table {
    public $name = 'Genreskills';
    public function initialize(array $config)
    {
	$this->table('skills_genre');
	$this->primaryKey('id');
	
	$this->belongsTo('Genre', [
	    'foreignKey' => 'genre_id',
	    'joinType' => 'INNER',
	]);
	
	$this->belongsTo('Skill', [
	    'foreignKey' => 'skill_id',
	    'joinType' => 'INNER',
	]);
    }
}
   
?>
