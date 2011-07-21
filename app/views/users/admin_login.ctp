<?php debug($session->read())?>
<h2>ADMIN LOGIN PAGE</h2>
<?php 
	echo $this->Session->flash('auth');
	echo $this->Form->create('User', array('controller' => 'users', 'action' => 'admin_login'));
	
	echo $this->Form->input('email');
	echo $this->Form->input('password');
	//echo $form->hidden('user_last_login', array('value' => $time->format('Y-m-d H:i:s', time())));
	echo $this->Form->end('Login!');

echo $html->link('<< back',array('controller' => 'carts', 'action' => 'index', 'c' => $c, 'admin' => false));
?>