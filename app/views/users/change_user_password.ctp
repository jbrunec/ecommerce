<h3>Provide a new password!</h3>
<?php 
    echo $form->create('User', array('url' => array('controller' => 'users', 'action' => 'changeUserPassword')));
    echo $form->hidden('id', array('value' => $userId));
    echo $form->input('password');
    echo $form->input('password_confirm', array('type' => 'password', 'label' => 'Rewrite password: '));
    echo $form->end('change!');

    echo $html->link('Back',array('controller' => 'users', 'action' => 'index'));
?>
