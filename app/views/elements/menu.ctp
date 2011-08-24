<?php //debug($c);?>
<?php 

	$categories = $this->requestAction("/categories/menu/c:$c/");
	//pr($categories);
?>
<ul id="menu">
<?php foreach($categories as $category):?>
	<?php 
	if($category['cat_parent_id'] == 0){
		$level = 1;
	}else{
		$level = 2;
	}
		
	if($level == 2){
	?>
	<li><?php 	
	    echo $html->link('---'.$category['cat_name'], array('controller' => 'carts', 'action' => 'index/c:'.$category['id']), array('id' => 'subCategory'),null);	
	?></li>
	<?php }else{?>
		<li>
			<?php echo $html->link($category['cat_name'], array('controller' => 'carts', 'action' => 'index/c:'.$category['id']));?>
		</li>
	<?php }?>
<?php endforeach;?>
</ul>