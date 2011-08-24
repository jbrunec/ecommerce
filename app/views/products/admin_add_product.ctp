<?php debug($categories)?>

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
	    
		echo $this->Form->input('pd_name', array('label' => 'Name: '));
		echo $this->Form->input('pd_description', array('label' => 'Description: '));
		echo $this->Form->input('pd_price', array('label' => 'Price: '));
		echo $this->Form->input('pd_qty', array('label' => 'Stock quantity: '));
		echo $this->Form->hidden('pd_date', array('value' => $time->format('Y-m-d H:i:s', time())));
		
	    echo $this->Form->file('file');
		
		echo $this->Form->input('Category');
		/*$options = $categories;
		echo $this->Form->select('Category', $options, NULL);*/
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>