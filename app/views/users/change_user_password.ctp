<h3>Provide a new password!</h3>
<?php 
    echo $form->create('User', array('url' => array('controller' => 'users', 'action' => 'changeUserPassword', 'uid' => $uid)));
    echo $form->input('password');
    echo $form->input('password_confirm', array('type' => 'password', 'label' => 'Rewrite password: '));
    echo $form->end('change!');
?>