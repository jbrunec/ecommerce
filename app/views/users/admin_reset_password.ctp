<?php //debug($uid)?>
<div class="users form">
	<h3>Change user <?php echo $uname?>'s password</h3>
	<?php 
	    echo $form->create('User', array('url' => array('action' => 'admin_reset_password', 'uid' => $uid)));
	    echo $form->input('password');
	    echo $form->input('password_confirm', array('type' => 'password', 'label' => 'Rewrite password: '));
	    echo $form->end('change');
	
	?>
	
</div>