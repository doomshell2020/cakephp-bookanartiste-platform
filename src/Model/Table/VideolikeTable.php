<?php //	echo "test"; die;

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;


class VideolikeTable extends Table {

  public function initialize(array $config)
    {
		$this->table('gallery_video_like');
                $this->primaryKey('id');
// Profile pack
	    $this->belongsTo('Video', [
            'foreignKey' => 'video_id',
            'joinType' => 'INNER',
            ]);
            
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);
   
	}
    
    

    
   
}
?>
