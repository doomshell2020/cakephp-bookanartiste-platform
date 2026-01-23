<?php
   
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class GenreTable extends Table {
   public $name = 'Genre';
   public function initialize(array $config)
       {
       
            $this->table('genre');
            $this->primaryKey('id');

              $this->belongsTo('Skill', [
          'foreignKey' => 'skills_id',
          'joinType' => 'INNER',
               ]);
           
   	}
   
   	
   	
   	
   }
   
?>
