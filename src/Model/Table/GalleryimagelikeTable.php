<?php //	echo "test"; die;

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;


class GalleryimagelikeTable extends Table {

  public function initialize(array $config)
    {
		$this->table('gallery_image_like');
                $this->primaryKey('id');
// Profile pack
	    $this->belongsTo('Galleryimage', [
            'foreignKey' => 'image_gallery_id',
            'joinType' => 'INNER',
            ]);
            $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);
   
	}
    
    

    
   
}
?>
