<?php 
	$result = $this->requestAction("/carts/getCartContent");
	debug($this->data);

?>
<p>confirmation page</p>
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
	foreach ($result as $item):
?>
	
		<tr>
        	<td><?php echo $html->image('products/'.$item['Product']['pd_image'], array('width' => '50', 'height' => '50'));?></td>
            <td><?php echo $item['Product']['pd_name'];?></td>
            <td><?php echo Configure::read('Shop.currency').' '.$item['Product']['pd_price'];?></td>
            <td><?php echo $item['Cart']['ct_qty'];?></td>
            <td><?php echo Configure::read('Shop.currency').' '.$item['Cart']['ct_qty'] * $item['Product']['pd_price'];?></td>
        </tr>
<?php endforeach;?>
	
	<?php 
	//naredimo obrazec za pošiljanje dostavnih podatkov glede na to katero plaèilno opcijo je user izbral
	if($userInfo['Order']['payment_option'] == 0){
		echo $form->create('Order', array('controller' => 'orders', 'action' => "index/c:$c/step:cod"));
	}elseif($userInfo['Order']['payment_option'] == 1){
		echo $form->create('Order', array('controller' => 'orders', 'action' => "index/c:$c/step:paypal"));
	}else{
		echo $form->create('Order', array('controller' => 'orders', 'action' => "index/c:$c/step:google"));
	}
	?>
	
	
	<?php echo $form->input('Order.od_status', array('value' => 'New', 'type' => 'hidden'));?>
	<?php echo $form->input('Order.od_shipping_first_name', array('value' => $userInfo['Order']['od_shipping_first_name'], 'type' => 'hidden'));?>
	<?php echo $form->input('Order.od_shipping_last_name', array('value' => $userInfo['Order']['od_shipping_last_name'], 'type' => 'hidden'));?>
	<?php echo $form->input('Order.od_shipping_phone_number', array('value' => $userInfo['Order']['od_shipping_phone_number'], 'type' => 'hidden'));?>
	<?php echo $form->input('Order.od_shipping_address', array('value' => $userInfo['Order']['od_shipping_address'], 'type' => 'hidden'));?>
	<?php echo $form->input('Order.od_shipping_city',array('value' => $userInfo['Order']['od_shipping_city'], 'type' => 'hidden'));?>
	<?php echo $form->input('Order.od_shipping_postal_code',array('value' => $userInfo['Order']['od_shipping_postal_code'],'type' => 'hidden'));?>
	
	<?php echo $form->input('Order.od_payment_first_name',array('value' => $userInfo['Order']['od_payment_first_name'],'type' => 'hidden'));?>
	<?php echo $form->input('Order.od_payment_last_name',array('value' => $userInfo['Order']['od_payment_last_name'],'type' => 'hidden'));?>
	<?php echo $form->input('Order.od_payment_email',array('value' => $userInfo['Order']['od_payment_email'],'type' => 'hidden'));?>
	<?php echo $form->input('Order.od_payment_phone_number',array('value' => $userInfo['Order']['od_payment_phone_number'],'type' => 'hidden'));?>
	<?php echo $form->input('Order.od_payment_address',array('value' => $userInfo['Order']['od_payment_address'],'type' => 'hidden'));?>
	<?php echo $form->input('Order.od_payment_city',array('value' => $userInfo['Order']['od_payment_city'],'type' => 'hidden'));?>
	<?php echo $form->input('Order.od_payment_postal_code',array('value' => $userInfo['Order']['od_payment_postal_code'],'type' => 'hidden'));?>
	</tbody>

</table>

<?php echo $html->link('Continue shopping', '/carts/index/c:'.$c, null, false);?>
<br>
<?php echo $html->link('<< Back to step 1', "/orders/index/c:$c/step:1")?>
