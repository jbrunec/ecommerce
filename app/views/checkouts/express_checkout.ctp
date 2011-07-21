<?php  
    if (!isset($error)){ 
        if ($step==2){ 
            echo $form->create('Order',array('type' => 'post', 'action' => 'expressCheckout/3', 'id' => 'OrderExpressCheckoutConfirmation'));  
            //all shipping info contained in $result display it here and ask user to confirm. 
            //echo pr($result); 
            echo $form->end('Confirm Payment');  
        } 
        if ($step==3){ 
            //show confirmation once again all information is contained in $result or $error 
            echo '<h2>Congrats</h2>'; 
        } 
    } 
    else 
        echo $error; 
?> 