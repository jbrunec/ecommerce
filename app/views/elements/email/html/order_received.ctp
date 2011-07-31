<p>Your order has been received!</p>
<p>Thanks for visiting our online shop - eCommerce</p>

<?php debug($orderedProducts)?>
<table id="gradient-style">
	 <thead>
    	<tr>
    		<th scope="col">&nbsp;</th>
        	<th scope="col">Item:</th>
            <th scope="col">Price:</th>
            <th scope="col">Quantity</th>
            <th scope="col">Total:</th>
        </tr>
    </thead>
    <tbody>
<?php 
    $totalPrice = 0.00;
	foreach ($orderedProducts as $product):
	$totalPrice += ($product['Product']['pd_price'] * $product['Cart']['ct_qty']);
?>
	
		<tr>
        	<td><?php echo $html->image('products/'.$product['Product']['pd_image'], array('width' => '50', 'height' => '50'));?></td>
            <td><?php echo $product['Product']['pd_name'];?></td>
            <td><?php echo Configure::read('Shop.currency').' '.$product['Product']['pd_price'];?></td>
            <td><?php echo 'X '.$product['Cart']['ct_qty'];?></td>
            <td><?php echo Configure::read('Shop.currency').' '.$product['Cart']['ct_qty'] * $product['Product']['pd_price'];?></td>
        </tr>
<?php endforeach;?>
	 </tbody>
	 <tfoot>
	 	<tr>
	 		<td colspan="4">&nbsp;</td>
	 		<td colspan="1"><?php echo '= '.Configure::read('Shop.currency').' '.$totalPrice;?></td>
	 	</tr>
	 </tfoot>
</table>