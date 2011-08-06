<?php 
	//$html->addCrumb('Categories','/');
	$categories = $this->requestAction("/categories/getAllCategories");
	//pr($categories);
	$i=0;
	$num = count($categories);

?>
<table id="gradient-style">
	<thead>
		<tr>
			<th>Categories:</th>
			<th>Description:</th>
		</tr>
		
			

	</thead>
<?php foreach($categories as $category):?>
	
	<tr>
		<td>
		<?php 	
		if($category['Category']['cat_parent_id'] != 0){	
		    echo $html->link('^----'.$category['Category']['cat_name'], '/carts/index/c:'.$category['Category']['id']); 			
		}else{
		    echo $html->link($category['Category']['cat_name'], '/carts/index/c:'.$category['Category']['id']); 					    
		}
		?>
		</td>
		<td><?php echo $category['Category']['cat_description']?></td>
	</tr>
	
		
	
<?php endforeach;?>
</table>
