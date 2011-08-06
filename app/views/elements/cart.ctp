<table id="gradient-style">
<?php 
//debug($cart);
	$cartContents = $this->requestAction("/carts/getCartContent");
	//debug($cartContents);
	if(!empty($cartContents) && is_array($cartContents)){
		$total = 0;
	
?>
	<tr>
		<th colspan="2">cart content</td>
	</tr>
	<?php 
		foreach ($cartContents as $cartContent):
			$total += $cartContent['Product']['pd_price'] * $cartContent['Cart']['ct_qty'];
		
	?>
	<tr>
		<td><?php echo $cartContent['Cart']['ct_qty'];?> X
		<?php echo $html->link($cartContent['Product']['pd_name'], '/carts/index/p:'.$cartContent['Cart']['product_id'].'/c:'.$cartContent['Product']['category_id']);?></td>
		<td><?php echo Configure::read('Shop.currency').'&nbsp;'.$cartContent['Product']['pd_price'] * $cartContent['Cart']['ct_qty'];?></td>
	</tr>
	<?php endforeach;?>
	<tr>
		<td align="right">Total:</td>
		<td><strong><?php echo Configure::read('Shop.currency').'&nbsp;'.$total?></strong></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2"><?php echo $html->link('Go To Shopping Cart', '/carts/view/c:'.$c);?></td>
	</tr>
	
	
	
	<?php 
	}else{
		echo '<tr><td width="150">Shopping cart is empty</td></tr>';
	}
	?>
</table>