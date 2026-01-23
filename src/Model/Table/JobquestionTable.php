<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class JobquestionTable extends Table {

    public $name = 'Jobquestions';
public function initialize(array $config)
    {
		$this->table('job_questions');
                $this->primaryKey('id');

           $this->belongsTo('Questionmare_options_type', [
            'foreignKey' => 'option_type',
            'joinType' => 'INNER',
            ]);  

            $this->hasMany('Jobanswer', [
            'foreignKey' => 'question_id',
            'joinType' => 'INNER',
            ]); 


            $this->hasMany('Userjobanswer', [
            'foreignKey' => 'question_id',
            'joinType' => 'INNER',
            ]);  


  
    }
    }
?>