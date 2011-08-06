<h3>Change your shipping info</h3>
<?php 
    echo $form->create('User', array('url' => array('controller' => 'users', 'action' => 'changeUserAddress')));
    //echo $form->hidden('id', array('value' => $userId));
    echo $form->input('address');
    echo $form->input('postal_code', array('label' => 'Postal code: '));
    echo $form->input('city', array('label' => 'City: '));
    echo $form->input('phone_number', array('label' => 'Mobile number: '));
    echo $form->end('change!');

    echo $html->link('Back',array('controller' => 'users', 'action' => 'index'));
?>
