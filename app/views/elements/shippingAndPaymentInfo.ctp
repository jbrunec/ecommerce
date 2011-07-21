<p>YOU ARE IN SHIPPING AND PAYMENT PAGE</p>
<?php 
	
	echo $html->script('checkout', array('inline' => false));
	//$result = $this->requestAction("/carts/getCartContent");	
	//debug($result);
?>

<div id="elementsToOperateOn">
	<legend>Shipping info</legend>
	<?php echo $form->create('Order', array('controller' => 'orders', 'action' => "index/c:$c/step:2", 'name' => 'formCheckout'));?>
	<?php echo $form->input('Order.od_status', array('value' => 'New', 'type' => 'hidden'));?>
	<?php echo $form->input('Order.od_shipping_first_name', array('label' => 'First name: '));?>
	<?php echo $form->input('Order.od_shipping_last_name', array('label' => 'Last name: '));?>
	<?php echo $form->input('Order.od_shipping_phone_number', array('label' => 'Phone Number: '));?>
	<?php echo $form->input('Order.od_shipping_address', array('label' => 'Address: '));?>
	<?php echo $form->input('Order.od_shipping_city');?>
	<?php echo $form->input('Order.od_shipping_postal_code');?>
	
	<br>
	<input type="checkbox" name="chkSame" id="chkSame" value="checkbox" onClick="setPaymentInfo(this.checked);"> 
	<label for="chkSame">Same as shipping information</label>
	<br>
	
	<legend>Payment info:</legend>
	<?php echo $form->input('Order.od_payment_first_name');?>
	<?php echo $form->input('Order.od_payment_last_name');?>
	<?php echo $form->input('Order.od_payment_phone_number', array('label' => 'Phone Number: '));?>
	<?php echo $form->input('Order.od_payment_address');?>
	<?php echo $form->input('Order.od_payment_city');?>
	<?php echo $form->input('Order.od_payment_postal_code');?>
	<?php echo $form->input('Order.od_payment_email', array('label' => 'Your Email: '));?>
</div><br>
	<?php //echo $form->radio('Order.payment_option', array('C.O.D.','Paypal','Google Checkout'));?>
	<table cellspacing="2" cellpadding="1" border="1">
  <tr>
    <td><input type="radio" name="data[Order][payment_option]" id="OrderPaymentOption0" value="0" /><label for="OrderPaymentOption0">C.O.D.</label></td>
  </tr>
  <tr>
    <td><input type="radio" name="data[Order][payment_option]" id="OrderPaymentOption1" value="1" onchange="toggleStatus()" />
	<label for="OrderPaymentOption1"><img src="https://www.sandbox.paypal.com/en_US/i/logo/PayPal_mark_50x34.gif" border="0" alt="Acceptance Mark">
	</label></td>
  </tr>
  <tr>
  	<td><input type="radio" name="data[Order][payment_option]" id="OrderPaymentOption2" value="2" onchange="toggleStatus()" /><label for="OrderPaymentOption2"><?php 
	echo $html->image('http://sandbox.google.com/checkout/buttons/checkout.gif?
						merchant_id=312598680695675&w=180&h=46&style=white&variant=text&loc=en_US',
						array(
							'name' => 'Google Checkout',
							'alt' => 'Fast checkout through Google',
							'width' => '180',
							'height' => '46'
						)
	);	
	?></label></td>
  </tr>
</table>

	
	
	
	
	<?php echo $form->end('confirm');?>
