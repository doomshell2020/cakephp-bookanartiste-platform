<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class BannerTable extends Table {

    public $name = 'banners';
public function initialize(array $config)
    {
		$this->table('banners');
                $this->primaryKey('id');
 $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
            ]);
   
	}
}
?>
