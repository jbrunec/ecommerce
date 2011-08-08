<p>Your order has been received!</p>
<p>Thanks for visiting our online shop - eCommerce</p>

<?php debug($order)?>
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
    $totalPrice = ($order['Order']['od_payment_total'] + $order['Order']['od_shipping_cost']);
	foreach ($order['Product'] as $product):
	
?>
	
		<tr>
        	<td><?php echo $html->image('products/'.$product['pd_image'], array('width' => '50', 'height' => '50'));?></td>
            <td><?php echo $product['pd_name'];?></td>
            <td><?php echo Configure::read('Shop.currency').' '.$product['pd_price'];?></td>
            <td><?php echo 'X '.$product['OrdersProduct']['od_qty'];?></td>
            <td><?php echo Configure::read('Shop.currency').' '.$product['OrdersProduct']['od_qty'] * $product['pd_price'];?></td>
        </tr>
<?php endforeach;?>
	 </tbody>
	 <tfoot>
	 	<tr>
	 		<td colspan="4" align="right">Shipping cost: </td>
	 		<td colspan="1"><?php echo '+ '.Configure::read('Shop.currency').' '.$order['Order']['od_shipping_cost']?></td>
	 	</tr>
	 	<tr>
	 		<td colspan="3">&nbsp;</td>
	 		<td colspan="1">&nbsp;</td>
	 		<td colspan="1"><?php echo '= '.Configure::read('Shop.currency').' '.$totalPrice;?></td>
	 	</tr>
	 </tfoot>
</table>