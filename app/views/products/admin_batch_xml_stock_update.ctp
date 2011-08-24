<div class="products index">
<h2>Choose an XML file with products!</h2>
<?php 

    echo $form->create('Product',array('type' => 'file'));
    echo $form->file('file', array('label' => 'XML file: '));
    echo $form->end('Submit');
?>
</div>