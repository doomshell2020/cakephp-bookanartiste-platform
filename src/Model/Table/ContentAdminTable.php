<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class ContentAdminTable extends Table {

    public $name = 'ContentAdmin';
    
    public function initialize(array $config)
    {
      $this->table('content_admin');
      $this->primaryKey('id');
  

	
    $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);
  
  
    }
          
      
   


}
?>
