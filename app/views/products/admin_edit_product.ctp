<?php debug($this->data)?>
<div class="products form">
<?php echo $this->Form->create('Product');?>
	<fieldset>
 		<legend>Add product</legend>
	<?php
		echo $this->Form->input('pd_name');
		echo $this->Form->input('pd_description');
		echo $this->Form->input('pd_price');
		echo $this->Form->input('pd_qty');
		echo $this->Form->input('pd_date');
		//echo $this->Form->input('pd_image');
		//echo $this->Form->input('pd_thumbnail');
		echo $this->Form->input('pd_qty');
		echo $this->Form->input('Category', array('selected' => $this->data['Product']['category_id']));
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>