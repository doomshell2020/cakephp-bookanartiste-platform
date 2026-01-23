<?php
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class JobadvertpackTable extends Table {
   public $name = 'Jobadvertpack';
   public function initialize(array $config)
       {
            $this->table('advrt_job_pack');
            $this->primaryKey('id');

            $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);

            $this->belongsTo('Requirement', [
            'foreignKey' => 'requir_id',
            'joinType' => 'INNER',
            ]);
       }
}
   
?>
