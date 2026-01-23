<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;

class UsersTable extends Table {

    public $name = 'Users';
    
    public function initialize(array $config)
    {
	    $this->table('users');
	    $this->primaryKey('id');
// skill set 
	   
	 
	    $this->hasMany('Languageknown', [
	    'foreignKey' => 'user_id',
	    'joinType' => 'INNER',
	    ]); 

	    $this->hasMany('Skillset', [
	    'foreignKey' => 'user_id',
	    'joinType' => 'INNER',
	    ]);
	    	    $this->hasMany('Performancedesc2', [
	    'foreignKey' => 'user_id',
	    'joinType' => 'INNER',
	    ]);
	       // Reprot
	    $this->hasMany('Performancelanguage', [
	    'foreignKey' => 'user_id',
	    'joinType' => 'INNER',
	    ]);

	        // Reprot
	    $this->hasMany('Uservital', [
	    'foreignKey' => 'user_id',
	    'joinType' => 'INNER',
	    ]);
	// profile
	    $this->hasOne('Profile', [
	    'foreignKey' => 'user_id',
	    'joinType' => 'left',
	    ]);
	         // Profile pack
	    $this->hasOne('Packfeature', [
            'foreignKey' => 'user_id',
            'joinType' => 'left',
            ]);// Profile pack
	    
	    // proffessional Summary
	    $this->hasOne('Professinal_info', [
	    'foreignKey' => 'user_id',
	    'joinType' => 'left',
	    ]);
	    
	     // Talent amdin
	    $this->hasOne('TalentAdmin', [
	    'foreignKey' => 'user_id',
	    'joinType' => 'left',
	    ]);
		
		$this->hasMany('Talentadminskill', [
	    'foreignKey' => 'user_id',
	    'joinType' => 'INNER',
	    ]);
	    
		 // Content amdin
	    $this->hasOne('ContentAdmin', [
	    'foreignKey' => 'user_id',
	    'joinType' => 'left',
	    ]);
		
		$this->hasMany('Contentadminskill', [
	    'foreignKey' => 'user_id',
	    'joinType' => 'INNER',
	    ]);
		
	    // Reprot
	    $this->hasMany('Report', [
	    'foreignKey' => 'profile_id',
	    'joinType' => 'INNER',
	    ]);
// Reprot
	    $this->hasMany('Subscription', [
	    'foreignKey' => 'user_id',
	    'joinType' => 'left',
	    ]);
	 $this->hasMany('Refers', [
	    'foreignKey' => 'ref_by',
	    'joinType' => 'left',
	    ]);
	
	// Profile pack
	    $this->belongsTo('Profilepack', [
            'foreignKey' => 'profilepack_id',
            'joinType' => 'left',
            ]);// Profile pack
            
       
	    $this->belongsTo('Enthicity', [
            'foreignKey' => 'Enthicity',
            'joinType' => 'INNER',z
            ]);

	    $this->belongsTo('Featuredprofile', [
            'foreignKey' => 'feature_pro_pack_id',
            'joinType' => 'left',
			]);
			
    }
    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
    					
	    
	 


}
?>
