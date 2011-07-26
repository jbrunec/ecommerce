<?php $data = $this->requestAction(array('controller' => 'orders', 'action' => 'get_recent_orders'));?>

<?php pr($data);?>
<div class="recent_orders">
	<h3>Recent Orders</h3>
	<?php echo $data[0]['Order']['od_status']?>
</div>