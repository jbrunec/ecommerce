<?php 
	if(!$session->check('Auth.User')){
		echo 'Welcome stranger!<br>';
		echo $html->link('Login',array('controller' => 'users', 'action' => 'login'));
		echo '<br>or register<br>';
		echo $html->link('Register',array('controller' => 'users', 'action' => 'register'));
		echo '<br>Lost your password?<br>';
		echo $html->link('click here', array('controller' => 'tickets', 'action' => 'reset_user_password'));
	}else{
		echo 'Welcome '.$session->read('Auth.User.email').'<br>';
		echo $html->link('Logout', array('controller' => 'users', 'action' => 'logout'));
	}

?>