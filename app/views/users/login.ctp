<?php ?>
<h2>LOGIN PAGE</h2>
<?php 
	//echo $this->Session->flash('auth');
	echo $this->Form->create('User', array('controller' => 'users', 'action' => 'login'));
	
	echo $this->Form->input('email');
	echo $this->Form->input('password');
	//echo $form->hidden('user_last_login', array('value' => $time->format('Y-m-d H:i:s', time())));
	echo $this->Form->end('Login!');


?>