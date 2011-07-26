<?php debug($this->params)?>
<div class="users index">
	<h2>Welcome Administrator <?php echo $session->read('Auth.User.first_name').' '. $session->read('Auth.User.last_name');?>!</h2>
	
	<?php echo $this->element('/users/admin_show_recent_orders');?>
	
</div>
