<p>YOU ARE IN SHIPPING AND PAYMENT PAGE</p>
<?php 
	
	echo $html->script('checkout', array('inline' => false));
	//$result = $this->requestAction("/carts/getCartContent");	
	//debug($result);
?>
<hr>

<?php 
    $user = $session->read('Auth.User');
    if(!empty($user)){
        echo $form->create('Order',array('controller' => 'orders', 'action' => "index/c:$c/step:2"));
        echo $form->hidden('od_status', array('value' => 'New'));
        echo $form->hidden('User.id', array('value' => $user['id']));
        echo $form->input('od_shipping_first_name', array('label' => 'First name: ', 'value' => $session->read('Auth.User.first_name')));
        echo $form->input('od_shipping_last_name', array('label' => 'Last name: ', 'value' => $session->read('Auth.User.last_name')));
        echo $form->input('od_shipping_phone_number', array('label' => 'Phone number: ', 'value' => $session->read('Auth.User.phone_number')));
        echo $form->input('od_shipping_address', array('label' => 'Last name: ', 'value' => $session->read('Auth.User.address')));
        echo $form->input('od_shipping_city', array('label' => 'Last name: ', 'value' => $session->read('Auth.User.city')));
        echo $form->input('od_shipping_postal_code', array('label' => 'Last name: ', 'value' => $session->read('Auth.User.postal_code')));echo $form->input('od_shipping_last_name', array('label' => 'Last name: ', 'value' => $session->read('Auth.User.last_name')));
        
        echo $form->radio('Order.payment_option', array('C.O.D.','Paypal','Google Checkout'));
       
        
        echo $form->hidden('od_payment_first_name', array('value' => $session->read('Auth.User.first_name')));
        echo $form->hidden('od_payment_last_name', array('value' => $session->read('Auth.User.last_name')));
        echo $form->hidden('od_payment_phone_number', array('value' => $session->read('Auth.User.phone_number')));
        echo $form->hidden('od_payment_address', array('value' => $session->read('Auth.User.address')));
        echo $form->hidden('od_payment_city', array('value' => $session->read('Auth.User.city')));
        echo $form->hidden('od_payment_postal_code', array('value' => $session->read('Auth.User.postal_code')));
        echo $form->hidden('od_payment_email', array('value' => $session->read('Auth.User.email')));
        //echo $form->hidden('od_payment_tax', array('value' => $session->read('Auth.User.first_name')));
        //echo $form->hidden('od_payment_total', array('value' => 50.00));
        echo $form->end('next step >>');
         echo "<hr>";
    }else{
        echo "<h3>Use your account to shop!</h3>";
        echo '<h3>You are not logged in?! Please login!</h3>';
        echo $form->create('User', array('controller' => 'users', 'action' => 'login'));       
        echo $form->input('email');
        echo $form->input('password');
        echo $form->end('login');
        echo "<hr>";
    }

?>
<h3>Or just give us your info here without the need to register!</h3>
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
