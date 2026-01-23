<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ProfileViewTable extends Table {

    public $name = 'ProfileView';
public function initialize(array $config)
    {
		$this->table('profile_view');
                $this->primaryKey('id');

   
	}
}
?>
