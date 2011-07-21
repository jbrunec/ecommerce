<p>Your order has been received!</p>
<p>Thanks for visiting our online shop - eCommerce</p>

<?php debug($Object)?>
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
	foreach ($Object as $item):
?>
	
		<tr>
        	<td><?php echo $html->image('products/'.$item['pd_image'], array('width' => '50', 'height' => '50'));?></td>
            <td><?php echo $item['pd_name'];?></td>
            <td><?php echo Configure::read('Shop.currency').' '.$item['pd_price'];?></td>
            <td><?php echo $item['Cart'][0]['ct_qty'];?></td>
            <td><?php echo Configure::read('Shop.currency').' '.$item['Cart'][0]['ct_qty'] * $item['pd_price'];?></td>
        </tr>
<?php endforeach;?>
	 </tbody>
</table>
