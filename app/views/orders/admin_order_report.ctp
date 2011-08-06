<?php //debug($orders)?>
<div class="report index">
	<h3>Report!</h3>
	<p>Choose option:</p>
	<?php 
	
	echo $form->create('Order');
	echo $form->select('Order.option', array('today' => 'today', 'yesterday' => 'yesterday', 'last week' => 'last week'), array('selected' => 'today'));
	echo $form->end('submit');
	
	?>
	
	<p>Or choose your desired time frame:</p>
	
	<?php 
	
	    	
	echo $form->create('Order');
	echo $form->label('Order.startDate', '<br>Choose start date:');
	echo $form->dateTime('Order.startDate', 'DMY', '24', array('label' => 'Choose start date:'));
	echo $form->label('Order.endDate', '<br>Choose end date:');
	echo $form->dateTime('Order.endDate', 'DMY', '24', time());
	echo $form->end('submit');
	
	    
	if(isset($this->data)){
	?>
	
	<h2>Orders</h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID','id');?></th>
			<th><?php echo $this->Paginator->sort('Date','od_date');?></th>
			<th><?php echo $this->Paginator->sort('Last updated','od_last_update');?></th>
			<th><?php echo $this->Paginator->sort('Current status','od_status');?></th>
			<th><?php echo $this->Paginator->sort('Recipient name','od_shipping_full_name');?></th>
			<th><?php echo $this->Paginator->sort('Shipping/Postal cost','od_shipping_cost');?></th>
			<th><?php echo $this->Paginator->sort('Total price','od_payment_total');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($orders as $order):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $order['Order']['id']; ?>&nbsp;</td>
		<td><?php echo $order['Order']['od_date']; ?>&nbsp;</td>
		<td><?php echo $order['Order']['od_last_update']; ?>&nbsp;</td>
		
		<?php if($order['Order']['od_status'] == "New"){?>
			<td><span style="background: lime"><?php echo $order['Order']['od_status']; ?>&nbsp;</span></td>
		<?php }elseif($order['Order']['od_status'] == "Shipped"){?>
			<td><span style="background: yellow"><?php echo $order['Order']['od_status']; ?>&nbsp;</span></td>
		<?php }elseif($order['Order']['od_status'] == "Completed"){?>
			<td><span style="background: #6698FF"><?php echo $order['Order']['od_status']; ?>&nbsp;</span></td>
		<?php }elseif($order['Order']['od_status'] == "Cancelled"){?>
			<td><span style="background: red"><?php echo $order['Order']['od_status']; ?>&nbsp;</span></td>
		<?php }?>
		
		<td><?php echo $order['Order']['od_shipping_full_name']; ?>&nbsp;</td>
		<td><?php echo Configure::read('Shop.currency').' '.$order['Order']['od_shipping_cost']; ?></td>
		<td><?php echo Configure::read('Shop.currency').' '.$order['Order']['od_payment_total']; ?></td>
		
		<td class="actions">
			<?php echo $this->Html->link('View', array('controller' => 'orders','action' => 'admin_view', $order['Order']['id'], 'admin' => true)); ?>
			
		</td>
	</tr>
<?php endforeach; ?>
	
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', null, null, array('class' => 'disabled'));?>
	</div>
	
	<table>	
    	<tr>
    		<td colspan="6">Total sum: </td>
    		<td colspan="1" style="text-align: right"><strong><?php echo Configure::read('Shop.currency').' '.$totalSum?></strong></td>
    	</tr>
	</table>
	<table>	
    	<tr>
    		<td colspan="6">Total number: </td>
    		<td colspan="1" style="text-align: right"><strong><?php echo $totalNum?></strong></td>
    	</tr>
	</table>
	
	
	<?php }?>
</div>