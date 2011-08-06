<?php
App::import('Sanitize');
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Cart' => array(
			'className' => 'Cart',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),/*
		'Ticket' => array(
			'className' => 'Ticket',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
	    )*/
	);
	
	
	var $virtualFields = array('full_name' => 'CONCAT(User.first_name, " ", User.last_name)');
		
	
	
	var $validate = array(
		'email' => array(
			'notempty' => 	array(
				'rule' => 'notEmpty',
				//'required' => true,				
				'message' => 'this field cannot be left blank!',
				'last' => true,
				),
			
			'email' => array(
				'rule' => array('email'),
				'message' => 'your email is not valid!',	
				//'required' => true,			
				),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'This email is already taken!'),
			
			
		),
		'password' => array(
			'between' => array(
				'rule' => array('between',2,10),
				'message' => 'Password must be between 2 and 10 chars long',
				//'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'You cannot leave password blank!',
				//'allowEmpty' => false,
				//'required' => true,
				'last' => true, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'password_match' => array(
				'rule' => array('comparePassword','password_confirm'),
			    //'required' => true,
			    'on' => 'create',
				'message' => 'passwords do not match!'
			),
		),	
		'first_name' => array(
		    'notEmpty' => array(
		    	'rule' => 'notEmpty',		
			//'required' => true,
				'allowEmpty' => false,
		    	'message' => 'You cannot leave this field blank!'
		    ),
		    'onlyChars' => array(
		        'rule' => '/[A-Za-z ]+/',
		        'message' => 'Only alphabet characters allowed',
		    ),
		),
		'last_name' => array(
		    'rule' => 'notEmpty',
			//'required' => true,
			'allowEmpty' => false,
		    'message' => 'You cannot leave this field blank!'  
		),
		'address' => array(
		    'notEmpty' => array(
		    	'rule' => 'notEmpty',		
			//'required' => true,
				'allowEmpty' => false,
		    	'message' => 'You cannot leave this field blank!'
		    ),
		    'alphaNumeric' => array(
		        'rule' => '/[A-Za-z0-9 ]/',
		        'message' => 'Irregular address given',
		    ),
		),
		'postal_code' => array(
		    'notEmpty' => array(
		    	'rule' => 'notEmpty',		
			//'required' => true,
				'allowEmpty' => false,
		    	'message' => 'You cannot leave this field blank!'
		    ),
		    'numeric' => array(
		        'rule' => 'numeric',
		        'message' => 'Only numbers allowed, e.g.: 2000',
		    ),
		    'between' => array(
		        'rule' => array('between',4,4),
		        'message' => 'Must be 4 numbers long',
		    ),
		),
		'city' => array(
		    'notEmpty' => array(
		    	'rule' => 'notEmpty',		
			//'required' => true,
				'allowEmpty' => false,
		    	'message' => 'You cannot leave this field blank!'
		    ),
		),
		'phone_number' => array(
		    'notEmpty' => array(
		    	'rule' => 'notEmpty',		
			//'required' => true,
				'allowEmpty' => false,
		    	'message' => 'You cannot leave this field blank!'
		    ),
		   
		),
	);
	
	//v $check parametru se vedno prenesejo podatki fielda, ki ga zelimo validirat v obliki array('key' => value)
	//v tem primeru se prenese input field 'password' torej je $check['password'] = vnosUsera
	//$field je vnosno polje iz forme ki jo validiramo (confirm_password)
	function comparePassword($check, $field){
	    pr('Im in comparePassword function');
	    pr('This is check data:');
	    debug($check);
	    pr('this is this->data:');
	    debug($this->data);
	    //die;
	    if(isset($this->data) && !empty($this->data)){
    		if($check['password'] != $this->data['User'][$field]){
    			$this->invalidate($field, 'password do not match!');
    			return false;
    		}
    		
    		//se prozi takrat ko hocemo primerjat samo passworde in nimamo na voljo polja this->data (v primerih ko ne gre za registracijo)
	    }else{
	        if(empty($check) || empty($field)){
	            $this->invalidate('password', 'You cannot leave password blank!');
	            $this->invalidate('password_confirm', 'You cannot leave password confirmation blank!');
    			return false;
	        }
	        elseif($check != $field){
	            
	            $this->invalidate('password_confirm', 'passwords do not match!');
    			return false;
	        }
	    }
	    
		return true;
	}
	
	function hashPasswords($data, $enforce=false) {
	    pr('Im in hashPassword function!');
	    pr('this is $data variable:');
	    pr($data);
	     pr('this is $this->data variable:');
	    pr($this->data);
        //die;
		if($enforce && isset($this->data[$this->alias]['password'])) {
               if(!empty($this->data[$this->alias]['password'])) {
                   pr('Im in hashPassword function2!');
                   $this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password'], null, true);
                }
        //se prozi ko v funkcijo podamo svoj podatek, ki ga zelimo hashat (v primeru resetiranja passworda)
        }elseif(isset($data) && !empty($data) && $enforce){
            pr('Im in hashPassword function3!');
            $data = Security::hash($data,null,true);
            
        }
         
        return $data;
    }
    
    function beforeSave(){
        pr('Im in beforesave function!');
        //die;
    	$this->hashPasswords(null,true);
    	return true;
    }
    
    
    function updateLastLogin($user_id, $session_id){
        $user_id = Sanitize::paranoid($user_id);
    	$sql = "UPDATE users SET user_last_login = NOW() WHERE id = $user_id";
    	$this->id = $user_id;
    	$this->saveField('session_id', $session_id);
    	$this->query($sql);
    }
    
    
    
    
    
    
    
    //za ponovno nastavitev passworda
    function reset_password($userId, $data){
        $user_id = Sanitize::paranoid($user_id);
        
        if($this->comparePassword($data['User']['password'], $data['User']['password_confirm'])){
            pr('password comparison passed!');
            
            $password = $this->hashPasswords($data['User']['password'],true);
            
            $sql = "UPDATE users SET users.password = '$password' WHERE users.id = $userId";
            
            $this->query($sql);
            return true;
        }else{
            pr('password comparison failed!');
           
            return false;
        }
        
    }
    
    //funkcija za vracanje novo registriranih userov (1 dan)
    function get_new_users(){
        $time = new TimeHelper();
        $dayAgo = $time->gmt() - 86400;
        $formatedDayAgo = $time->format("Y-m-d H:i:s",$dayAgo);
        
        return $this->find('all', array('conditions' => array('User.reg_date >=' => $formatedDayAgo)));
            
       
    }
    
    
	
	

}
