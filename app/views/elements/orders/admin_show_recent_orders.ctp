<?php //$data = $this->requestAction(array('controller' => 'orders', 'action' => 'get_recent_orders'));?>

<?php 


		$data = $this->requestAction(array('controller' => 'orders', 'action' => 'get_recent_orders'));
		//pr($products);
		//pr($data);

?>
<div id="recent_orders">
<h2>Recent Orders:</h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>Id</th>
			<th>Date</th>
			<th>Status</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Total Payment</th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	
	if(!empty($data)){
	    
	
	
	$i = 0;
	foreach ($data as $order):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $order['Order']['id']; ?>&nbsp;</td>
		<td><?php echo $order['Order']['od_date']; ?>&nbsp;</td>
		<td><?php echo $order['Order']['od_status']; ?>&nbsp;</td>
		<td><?php echo $order['Order']['od_shipping_first_name']; ?>&nbsp;</td>
		<td><?php echo $order['Order']['od_shipping_last_name']; ?>&nbsp;</td>
		<td><?php echo $order['Order']['od_payment_total']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('controller' => 'orders','action' => 'view', $order['Order']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $order['Order']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $order['Order']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $order['Order']['id'])); ?>
		</td>
	</tr>
    <?php endforeach; ?>
	<?php }else{?>
	<tr>
		<td colspan="1">NO RECENT ORDERS!</td>
		<td colspan="6">&nbsp;</td>
	</tr>
	<?php }?>
	</table>
	
	

	
</div>
