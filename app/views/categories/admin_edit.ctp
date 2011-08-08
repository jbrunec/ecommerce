<div class="categories index">
<h3>Edit Category!</h3>
<?php 
    
    echo $form->create('Category');
    echo $form->hidden('id');
    echo $form->input('cat_name');
    echo $form->input('cat_description');
    echo $form->select('cat_parent_id', array($cat_parent_id), array('selected' => $this->data['Category']['cat_parent_id']));
    echo $form->end('submit');

?>
</div>