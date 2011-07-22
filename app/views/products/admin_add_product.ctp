<?php debug($categories)?>

<script type="text/javascript"> 
    tinyMCE.init({ 
        theme : "advanced", 
        mode : "textareas", 
        convert_urls : false 
    }); 
</script>
<div class="products form">

<?php echo $this->Form->create('Product');?>
	<fieldset>
 		<legend>Add product</legend>
	<?php
		echo $this->Form->input('pd_name');
		echo $this->Form->input('pd_description');
		echo $this->Form->input('pd_price');
		echo $this->Form->input('pd_qty');
		echo $this->Form->hidden('pd_date', array('value' => $time->format('Y-m-d H:i:s', time())));
		echo $this->Form->input('Category');
		/*$options = $categories;
		echo $this->Form->select('Category', $options, NULL);*/
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>