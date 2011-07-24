<?php 
	    
	   
	    
	    
	    if(isset($key)){
	        echo $form->create('User', array('controller' => 'users', 'action' => 'changeUserPassword', 'id' => 'myForm'));
	        echo $form->hidden('id', array('value' => $userId));
	        echo $form->end();
	        ?>
	        <script type="text/javascript">
	        	document.getElementById('myForm').submit();
			</script>
	        <?php 
	    }else{
	        echo $form->create('Ticket');
    	    echo $form->input('email');
    	    echo $form->end('submit');
	    }
?>