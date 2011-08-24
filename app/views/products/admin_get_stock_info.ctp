<?php //debug($products)?>
<div class="products index">
	<h2>Stock info:</h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID','id');?></th>
			<th><?php echo $this->Paginator->sort('Product name','pd_name');?></th>
			<th><?php echo $this->Paginator->sort('Stock quantity','pd_qty');?></th>
			<th class="actions">Actions</th>
	</tr>
	<?php
	
	$i = 0;
	foreach ($products as $product):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		echo $form->create('Product', array('url' => array('controller' => 'products', 'action' => 'admin_get_stock_info', 'pd_id' => $product['Product']['id'])));
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $product['Product']['id']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['pd_name']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['pd_qty']; ?>&nbsp;</td>
		<td class="actions" id="stock_change">
			<?php echo $form->input("Product.pd_qty", array('value' => $product['Product']['pd_qty'], 'label' => 'Change stock qty:')); ?>
			<?php echo $form->end('Update stock'); ?><br>
			<?php echo $this->Html->link('Edit', array('action' => 'admin_edit_product', $product['Product']['id'], 'admin' => true)); ?>
			<?php echo $this->Html->link('Delete', array('action' => 'admin_delete_product', $product['Product']['id'], 'admin' => true), null, sprintf(__('Are you sure you want to delete # %s?', true), $product['Product']['id'])); ?>
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
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
