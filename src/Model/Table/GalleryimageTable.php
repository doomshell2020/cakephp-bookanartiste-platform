<?php //	echo "test"; die;

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;


class GalleryimageTable extends Table {

  public function initialize(array $config)
    {
		$this->table('gallery_images');
                $this->primaryKey('id');
// Profile pack
	    $this->belongsTo('Gallery', [
            
            'joinType' => 'INNER',
            ]);
            $this->belongsTo('Users', [
            'foreignkey'=>'user_id',
            'joinType' => 'INNER',
            ]);
   
	}
    
    

    
   
}
?>
