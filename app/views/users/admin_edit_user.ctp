<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php __('Edit User'); ?></legend>
	<?php
		 
    	
    	echo $form->input('email', array('label' => 'Email: ', 'after' => '<span style="color:red">*</span>'));
    	echo $form->input('password',array('label' => 'Password: ', 'after' => '<span style="color:red">*</span>'));
    	echo $form->input('password_confirm', array('type'=>'password', 'label' => 'Rewrite password: ', 'after' => '<span style="color:red">*</span>'));
    	echo $form->hidden('reg_date', array('value' => $time->format('Y-m-d H:i:s', $time->gmt())));
    	echo $form->hidden('user_last_login', array('value' => $time->format('Y-m-d H:i:s', $time->gmt())));
    	echo $form->input('first_name',array('label' => 'first name: ', 'after' => '<span style="color:red">*</span>'));
        echo $form->input('last_name',array('label' => 'last name: ', 'after' => '<span style="color:red">*</span>'));
    	echo $form->input('phone_number',array('label' => 'phone number: ', 'after' => '<span style="color:red">*</span>'));
	    echo $form->input('address',array('label' => 'address: ', 'after' => '<span style="color:red">*</span>'));
        echo $form->input('postal_code',array('label' => 'postal code: ', 'after' => '<span style="color:red">*</span>'));
	    echo $form->input('city',array('label' => 'city: ', 'after' => '<span style="color:red">*</span>')); 
	    echo $form->input('admin',array('label' => 'admin: ', 'after' => '<span style="color:red">*</span>'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
