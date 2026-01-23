<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ReviewTable extends Table {

    public $name = 'reviews';
public function initialize(array $config)
    {
		$this->table('reviews');
        $this->primaryKey('id');

   $this->belongsTo('Requirement', [
            'foreignKey' => 'job_id',
            'class' => 'Requirement',
            ]);
            
            
            $this->belongsTo('Users', [
            'foreignKey' => 'nontalent_id',
            'class' => 'Users',
            ]);
            
	}
}
?>
