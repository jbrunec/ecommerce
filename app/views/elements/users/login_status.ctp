<?php 
	if(!$session->check('Auth.User')){
		echo 'Welcome stranger!<br>';
		echo $html->link('Login',array('controller' => 'users', 'action' => 'login'));
		echo '<br>or register<br>';
		echo $html->link('Register',array('controller' => 'users', 'action' => 'register'));
	}else{
		echo 'Welcome '.$session->read('Auth.User.email').'<br>';
		echo $html->link('Logout', array('controller' => 'users', 'action' => 'logout'));
	}

?>