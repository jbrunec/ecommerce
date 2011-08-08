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
 		<legend>Edit product</legend>
	<?php
	    echo $form->hidden('id'); 
		echo $this->Form->input('pd_name', array('label' => 'Name: '));
		echo $this->Form->input('pd_description', array('label' => 'Description: '));
		echo $this->Form->input('pd_price', array('label' => 'Price: '));
		echo $this->Form->input('pd_qty', array('label' => 'Stock quantity: '));
		echo $this->Form->input('pd_date', array('label' => 'Date added: '));
		echo $this->Form->hidden('pd_last_update', array('value' => $time->format('Y-m-d H:i:s', time())));
		if(empty($this->data['Product']['pd_image'])){
		    echo '<span style="color: red;">THIS PRODUCT HAS NO PHOTO YET</span>';
		}else{
		    echo $html->image('products/'.$this->data['Product']['pd_image'], array('width' => '250', 'height' => '250', 'border' => '1'));		    
		    echo $form->hidden('image', array('value' => $this->data['Product']['pd_image']));
		}
		//echo $this->Form->input('pd_image', array('label' => 'Current product image: '));
		//echo $this->Form->input('pd_thumbnail');
		echo '<br><br>';
		echo $form->label('file','Add a photo:');
		echo $form->file('file');
		echo $this->Form->input('Category', array('selected' => $this->data['Product']['category_id']));
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>