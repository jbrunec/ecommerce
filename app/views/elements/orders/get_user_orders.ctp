<?php 

    $orders = $this->requestAction("/orders/get_all_user_orders/".$session->read('Auth.User.email'));
    
   //pr($orders);
    
    
?>


<table id="gradient-style" cellpadding="0" cellspacing="0">
	
	<thead>
		<th scope="col">ID</th>
		<th scope="col">Date</th>
		<th scope="col">Status</th>
		<th scope="col">Shipping/postal cost</th>
		<th scope="col">Total price</th>
		<th class="actions"><?php __('Actions');?></th>
	</thead>
	<tbody>
	<?php 
	
	$i=0;
	foreach ($orders['orders'] as $order):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $order['Order']['id']; ?>&nbsp;</td>
		<td><?php echo $order['Order']['od_date']; ?>&nbsp;</td>		
		<?php if($order['Order']['od_status'] == "New"){?>
			<td><span style="background: lime; color:black;"><?php echo $order['Order']['od_status']; ?>&nbsp;</span></td>
		<?php }elseif($order['Order']['od_status'] == "Shipped"){?>
			<td><span style="background: yellow"><?php echo $order['Order']['od_status']; ?>&nbsp;</span></td>
		<?php }elseif($order['Order']['od_status'] == "Completed"){?>
			<td><span style="background: #6698FF; color:black"><?php echo $order['Order']['od_status']; ?>&nbsp;</span></td>
		<?php }elseif($order['Order']['od_status'] == "Cancelled"){?>
			<td><span style="background: red"><?php echo $order['Order']['od_status']; ?>&nbsp;</span></td>
		<?php }?>
		
		<td><?php echo Configure::read('Shop.currency').' '.$order['Order']['od_shipping_cost']; ?></td>
		<td><?php echo Configure::read('Shop.currency').' '.$order['Order']['od_payment_total']; ?></td>
		
		<td class="actions">
			<?php echo $this->Html->link('View', array('controller' => 'orders','action' => 'view', $order['Order']['id'])); ?>			
		</td>		
	</tr>
	
	</tbody>
	<?php endforeach; ?>
	<tfoot>
		<tr>
    		<td colspan="5">Total sum: </td>
    		<td colspan="1"><strong><?php echo Configure::read('Shop.currency').' '.$orders['totalSum']?></strong></td>
		</tr>
	</tfoot>


	
</table>

