<?php 
	//$html->addCrumb('Categories','/');
	$categories = $this->requestAction("/categories/getAllCategories");
	//pr($categories);
	foreach($categories as $category):

?>
<div id="category_list">
	<?php
		echo $html->link($category['Category']['cat_name'], '/menu/c:'.$category['Category']['id']); 
	?>
</div>
<?php endforeach;?>