<?php
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
	
	
	
		
	
	
	var $validate = array(
		'email' => array(
			'notempty' => 	array(
				'rule' => array('notempty'),
				'required' => true,
				'message' => 'this field cannot be left blank!'
				),
			
			'rule2' => array(
				'rule' => array('email'),
				'message' => 'your email is not valid!'				
				)
			
		),
		'password' => array(
			'between' => array(
				'rule' => array('between',2,10),
				'message' => 'Password must be between 2 and 10 chars long',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'You cannot leave password blank!',
				//'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'password_match' => array(
				'rule' => array('comparePassword','password_confirm'),
			    //'required' => true,
				'message' => 'passwords do not match!'
			),
		),	
	);
	
	//v $check parametru se vedno prenesejo podatki fielda, ki ga zelimo validirat v obliki array('key' => value)
	//v tem primeru se prenese input field 'password' torej je $check['password'] = vnosUsera
	//$field je vnosno polje iz forme ki jo validiramo (confirm_password)
	function comparePassword($check, $field){
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
		if($enforce && isset($this->data[$this->alias]['password'])) {
               if(!empty($this->data[$this->alias]['password'])) {
                   $this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password'], null, true);
                }
        //se prozi ko v funkcijo podamo svoj podatek, ki ga zelimo hashat
        }elseif(isset($data) && !empty($data)){
            $data = Security::hash($data,null,true);
        }
 
        return $data;
    }
    
    function beforeSave(){
    	$this->hashPasswords(null,true);
    	return true;
    }
    
    
    function updateLastLogin($user_id){
    	$sql = "UPDATE users SET user_last_login = NOW() WHERE id = $user_id";
    	
    	$this->query($sql);
    }
    
    
    //za ponovno nastavitev passworda
    function reset_password($userId, $data){
        
        
        if($this->comparePassword($data['User']['password'], $data['User']['password_confirm'])){
            pr('password comparison passed!');
            
            $password = $this->hashPasswords($data['User']['password']);
            
            $sql = "UPDATE users SET users.password = '$password' WHERE users.id = $userId";
            
            $this->query($sql);
            return true;
        }else{
            pr('password comparison failed!');
           
            return false;
        }
        
    }
    
    
	
	

}
