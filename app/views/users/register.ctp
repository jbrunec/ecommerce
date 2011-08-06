<h1>Please fill out the register form!</h1>

<h2>Login credentials</h2>
<?php 
	echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'register')));
	echo $this->Form->input('email', array('label' => 'Email: '));
	echo $this->Form->input('password',array('label' => 'Password: '));
	echo $this->Form->input('password_confirm', array('type'=>'password', 'label' => 'Rewrite password: ' ));
	echo $this->Form->hidden('reg_date', array('value' => $time->format('Y-m-d H:i:s', time())));
	echo $this->Form->hidden('user_last_login', array('value' => $time->format('Y-m-d H:i:s', time())));
	echo '<br>';
	echo '<h3>Shipping information: </h3>';
	echo $this->Form->input('first_name', array('label' => 'First name: '));
	echo $this->Form->input('last_name', array('label' => 'Last name: '));
	echo $this->Form->input('address', array('label' => 'Address: '));
	echo $this->Form->input('postal_code', array('label' => 'Postal code: '));
	echo $this->Form->input('city', array('label' => 'City: '));
	echo $this->Form->input('phone_number', array('label' => 'Mobile number: '));
	echo $this->Form->end('Register');
?>
<span style="color:red">* denotes required info</span>

<?php 
/*
echo $form->create('User', array('url' => array('controller' => 'users', 'action' => 'register')));
	echo $form->input('email', array('label' => 'Email: ', 'after' => '<span style="color:red">*</span>'));
	echo $form->input('password',array('label' => 'Password: ', 'after' => '<span style="color:red">*</span>'));
	echo $form->input('password_confirm', array('type'=>'password', 'label' => 'Rewrite password: ', 'after' => '<span style="color:red">*</span>'));
	echo $form->hidden('reg_date', array('value' => $time->format('Y-m-d H:i:s', time())));
	echo $form->hidden('user_last_login', array('value' => $time->format('Y-m-d H:i:s', time())));
	echo $form->input('first_name', array('label' => 'First name: '));
	echo $form->input('last_name', array('label' => 'Last name: '));
	echo $form->end('Register');
*/
?>