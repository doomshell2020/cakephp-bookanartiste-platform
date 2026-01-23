<?php
   namespace App\Model\Table;
   use Cake\ORM\Table;
   use Cake\Validation\Validator;
   class BannerpackTable extends Table {
   public $name = 'banner_pack';
   public function initialize(array $config)
       {
            $this->table('banner_pack');
            $this->primaryKey('id');
       }
}
   
?>
