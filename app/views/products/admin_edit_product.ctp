<?php debug($this->data)?>
<?php error_reporting(0);?>
<script type="text/javascript"> 
    tinyMCE.init({ 
        theme : "advanced", 
        mode : "textareas", 
        convert_urls : false 
    }); 
</script>
<div class="products form">
<?php echo $this->Form->create('Product', array('type' => 'file'));?>
	<fieldset>
 		<legend>Add product</legend>
	<?php
		echo $this->Form->input('pd_name');
		echo $this->Form->input('pd_description');
		echo $this->Form->input('pd_price');
		echo $this->Form->input('pd_qty');
		echo $this->Form->input('pd_date');
		echo $this->Form->hidden('pd_last_update', array('value' => $time->format('Y-m-d H:i:s', time())));
		//echo $this->Form->input('pd_image');
		//echo $this->Form->input('pd_thumbnail');
		echo $form->file('file', array('label' => 'add a picture: '));
		echo $this->Form->input('pd_qty');
		echo $this->Form->input('Category', array('selected' => $this->data['Product']['category_id']));
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>