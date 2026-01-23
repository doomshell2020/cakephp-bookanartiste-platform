<?php //	echo "test"; die;

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;


class GalleryTable extends Table {

  public function initialize(array $config)
    {
		$this->table('gallery');
                $this->primaryKey('id');
                
$this->hasMany('Galleryimage', [
	    'foreignKey' => 'gallery_id',
	    'joinType' => 'INNER',
	    ]);
   
	}
    
    

    
   
}
?>
