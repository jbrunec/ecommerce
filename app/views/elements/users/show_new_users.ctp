<?php $data = $this->requestAction(array('controller' => 'users', 'action' => 'get_new_users'));?>
<table id="gradient-style">
    <thead>
    	<tr>
    		<th scope="col">First name:</th>
        	<th scope="col">Last name:</th>
            <th scope="col">Email:</th>
            <th scope="col">Last login:</th>     
            <th scope="col">Date Registered:</th> 
            <th scope="col">Actions:</th>    
        </tr>
    </thead>
    <tbody>
<?php 

    if(!empty($data)){
        
    
	foreach ($data as $user):
?>
	
		<tr>
        	<td><?php echo $user['User']['first_name']?></td>
            <td><?php echo $user['User']['last_name'];?></td>
            <td><?php echo $user['User']['email'];?></td>
            <td><?php echo $user['User']['user_last_login'];?></td>
            <td><?php echo $user['User']['reg_date'];?></td>
            
        </tr>
<?php 
    endforeach;

    }else{
?>
		<tr>
			<td colspan="5">NO NEW USERS!</td>
		</tr>

	<?php }?>
	</tbody>
	<tfoot>
	</tfoot>
</table>