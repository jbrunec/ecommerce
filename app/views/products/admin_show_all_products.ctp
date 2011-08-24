<?php //debug($products)?>
<div class="products index">
	<h2>Products currently in DB</h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('category_id');?></th>
			<th><?php echo $this->Paginator->sort('pd_name');?></th>
			<th><?php echo $this->Paginator->sort('pd_description');?></th>
			<th><?php echo $this->Paginator->sort('pd_price');?></th>
			<th><?php echo $this->Paginator->sort('pd_qty');?></th>
			<th><?php echo $this->Paginator->sort('pd_date');?></th>
			<th><?php echo $this->Paginator->sort('pd_last_update');?></th>
			<th><?php echo $this->Paginator->sort('Feature','pd_featured');?></th>
			<th class="actions">Actions</th>
	</tr>
	<?php
	$i = 0;
	$j = 0;
	foreach ($products as $product):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		echo $form->create('Product', array('url' => array('controller' => 'products', 'action' => 'admin_show_all_products')));
		
	?>
	<tr<?php echo $class;?>>
	<?php echo $form->hidden('Product.id', array('value' => $product['Product']['id']));?>
		<td><?php echo $product['Product']['id']; ?>&nbsp;</td>
		<td><?php echo $product['Category']['cat_name']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['pd_name']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['pd_description']; ?>&nbsp;</td>
		<td><?php echo Configure::read('Shop.currency').'&nbsp;'.$product['Product']['pd_price']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['pd_qty']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['pd_date']; ?>&nbsp;</td>
		<td><?php echo $product['Product']['pd_last_update']; ?>&nbsp;</td>		
		
		<td><?php echo $form->input("Product.pd_featured",array('checked' => $product['Product']['pd_featured'], 'onChange' => 'this.form.submit()'));?></td>
		<?php echo $form->end();?>
		<td class="actions">
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
