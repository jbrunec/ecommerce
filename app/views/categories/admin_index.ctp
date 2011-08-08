<?php //debug($categories)?>
<div class="products index">
	<h2>Products currently in DB</h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('cat_parent_id');?></th>
			<th><?php echo $this->Paginator->sort('cat_name');?></th>
			<th><?php echo $this->Paginator->sort('cat_description');?></th>
			<th class="actions">Actions</th>
	</tr>
	<?php
	$i = 0;
	foreach ($categories as $category):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $category['Category']['id']; ?>&nbsp;</td>
		<td><?php echo $category['Category']['cat_parent_id']; ?>&nbsp;</td>
		<td><?php echo $category['Category']['cat_name']; ?>&nbsp;</td>
		<td><?php echo $category['Category']['cat_description']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link('Edit', array('action' => 'admin_edit', $category['Category']['id'], 'admin' => true)); ?>
			<?php echo $this->Html->link('Delete', array('action' => 'admin_delete', $category['Category']['id'], 'admin' => true), null, sprintf(__('Are you sure you want to delete # %s?', true), $category['Category']['id'])); ?>
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
