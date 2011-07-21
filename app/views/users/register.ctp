<p>Please fill out the register form!</p>
<p>Current time: <?php echo $time->format('Y-m-d H:i:s', time());?></p>
<?php 
	echo $form->create();
	echo $form->input('email', array('label' => 'Email: ', 'after' => '<span style="color:red">*</span>'));
	echo $form->input('password',array('label' => 'Password: ', 'after' => '<span style="color:red">*</span>'));
	echo $form->input('password_confirm', array('type'=>'password', 'label' => 'Rewrite password: ', 'after' => '<span style="color:red">*</span>'));
	echo $form->hidden('reg_date', array('value' => $time->format('Y-m-d H:i:s', time())));
	echo $form->hidden('user_last_login', array('value' => $time->format('Y-m-d H:i:s', time())));
	echo $form->end('Register');
?>
<span style="color:red">* denotes required info</span>