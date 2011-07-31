<p>Your current order status - <?php if($status == "New"){?>
			<span style="background: lime"><?php echo $status; ?></span>
		<?php }elseif($status == "Shipped"){?>
			<span style="background: yellow"><?php echo $status; ?></span>
		<?php }elseif($status == "Completed"){?>
			<span style="background: #6698FF"><?php echo $status; ?></span>
		<?php }elseif($status == "Cancelled"){?>
			<span style="background: red"><?php echo $status; ?></span>
		<?php }?></p>

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
	foreach ($orderedProducts['Product'] as $product):
	$totalPrice += ($product['pd_price'] * $product['OrdersProduct']['od_qty']);
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
	 		<td colspan="4">&nbsp;</td>
	 		<td colspan="1"><?php echo '= '.Configure::read('Shop.currency').' '.$totalPrice;?></td>
	 	</tr>
	 </tfoot>
</table>