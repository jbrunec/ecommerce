<?php debug($session->read())?>
<div class="users index">
	<h2>Welcome Administrator <?php echo $session->read('Auth.User.first_name').' '. $session->read('Auth.User.last_name');?>!</h2>
	<?php echo 'Current time: '.$time->format("Y-m-d H:i:s",$time->gmt());?>
	<?php echo 'Day ago: '.$time->format("Y-m-d H:i:s",$time->gmt() - 86400);?>
	<?php echo $this->element('/orders/admin_show_recent_orders');?>
	<?php echo $this->element("/users/show_new_users");?>
	
</div>
