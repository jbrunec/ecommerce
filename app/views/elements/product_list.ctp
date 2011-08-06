<?php 
	//debug($products);
	$html->addCrumb('Products','/carts/index/c:'.$c);
	
	if(empty($products) || !isset($products)){
		$data = $this->requestAction("/products/listProducts/c:$c");
		//pr($data);
		$products = $data['products'];
		$this->Paginator->params['paging'] = $data['paging'];
	}
	
	//$products = $this->requestAction(array('controller' => 'products', 'action' => 'listProducts'));
		
	
	

	$this->Paginator->options(array(
    'update' => '#product_list',
    'evalScripts' => true,    
	'before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),
	'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false)),
	'url' => array('controller' => 'products', 'action' => 'listProducts', 'c' => $c)
	));

	
    //pr($products);

?>



	<h2>Products:</h2>
	
	<table>
	<tr>
			<th>&nbsp;</th>
			<th><?php echo $this->Paginator->sort('Name');?></th>
			<th><?php echo $this->Paginator->sort('Description');?></th>
			<th><?php echo $this->Paginator->sort('Price');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($products as $product):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	
	<tr<?php echo $class;?>>
		<td><?php echo $html->image('products/'.$product['Product']['pd_image'], array('url' => "/carts/index/c:$c/p:".$product['Product']['id'], 'width' =>'50', 'height' => '50'));?></td>
		<td><?php echo $html->link($product['Product']['pd_name'], array('controller' => 'carts', 'action' => "index/c:$c/p:".$product['Product']['id'])); ?>&nbsp;</td>
		<td><?php echo $product['Product']['pd_description']; ?></td>
		<td><b><?php echo Configure::read('Shop.currency').'&nbsp;'.$product['Product']['pd_price']; ?></b></td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>

<?php echo $this->Js->writeBuffer();?>