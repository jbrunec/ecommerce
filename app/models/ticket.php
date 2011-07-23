<?php
class Ticket extends AppModel {
	var $name = 'Ticket';
	var $displayField = 'name';
	
	/*
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);*/
	
	
	function findUser($email){
	    $sql = "SELECT * FROM users WHERE email = '$email'";
	    $result = $this->query($sql);
	    
	    $cakeConventionArray = array();
	    
	    $cakeConventionArray['User']['id'] = $result[0]['users']['id'];
	    $cakeConventionArray['User']['email'] = $result[0]['users']['email'];
	    return $cakeConventionArray;
	}
}
?>