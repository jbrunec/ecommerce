<div class="products index">
<?php 

    echo $form->create('Product',array('type' => 'file'));
    echo $form->file('file', array('label' => 'XML file: '));
    echo $form->end('Submit');
?>
</div>