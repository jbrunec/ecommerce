<?php debug($cat_parent_id)?>

<div class="categories form">

<?php echo $this->Form->create('Category');?>
	<fieldset>
 		<legend>Add category</legend>
	<?php
		echo $this->Form->input('cat_name', array('label' => 'Name: '));
		echo $this->Form->input('cat_description', array('label' => 'Description: '));
		echo '<br>';
		echo $form->label('cat_parent_id', 'Pick a parent category:');	
		echo $form->select('cat_parent_id', array($cat_parent_id), array('selected' => '0'));
	?>
	</fieldset> 
<?php echo $this->Form->end(__('Submit', true));?>
</div>