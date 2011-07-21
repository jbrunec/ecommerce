<?php 
$result = $this->requestAction("/carts/getCartContent");

debug($result);
?>

<p>REDIRECTING...</p>

<?php 
	echo $form->create(false, array('url' => 'https://sandbox.google.com/checkout/api/checkout/v2/checkoutForm/Merchant/312598680695675',
										'accept-charset' => 'utf-8',
										'name' => 'frmGoogle'));
	
	$i = 1;
	foreach ($result as $item){
		echo $form->hidden("item_name_$i", array('value' => $item['Product']['pd_name'], 'name' => "item_name_$i"));
		echo $form->hidden("item_description_$i", array('value' => $item['Product']['pd_description'], 'name' => "item_description_$i"));
		echo $form->hidden("item_price_$i", array('value' => $item['Product']['pd_price'], 'name' => "item_price_$i"));
		echo $form->hidden("item_currency_$i", array('value' => 'USD', 'name' => "item_currency_$i"));
		echo $form->hidden("item_quantity_$i", array('value' => $item['Cart']['ct_qty'], 'name' => "item_quantity_$i"));
		echo $form->hidden("item_merchant_id_$i", array('value' => '312598680695675', 'name' => "item_merchant_id_$i"));
		echo $form->hidden("checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-$i.shipping-restrictions.allowed-areas.world-area-$i", array('value' => '', 'name' => "checkout-flow-support.merchant-checkout-flow-support.shipping-methods.flat-rate-shipping-$i.shipping-restrictions.allowed-areas.world-area-$i"));
		echo $form->hidden("ship_method_name_$i", array('value' => 'Delivery'.$i, 'name' => "ship_method_name_$i"));
		echo $form->hidden("ship_method_price_$i", array('value' => '5.00', 'name' => "ship_method_price_$i"));
		echo $form->hidden("ship_method_currency_$i", array('value' => 'USD', 'name' => "ship_method_currency_$i"));
		
		$i++;
	}
	
	
	echo $form->hidden('_charset_');
	echo $html->image('http://sandbox.google.com/checkout/buttons/checkout.gif?
						merchant_id=312598680695675&w=180&h=46&style=white&variant=text&loc=en_US',
						array(
							'name' => 'Google Checkout',
							'alt' => 'Fast checkout through Google',
							'width' => '180',
							'height' => '46'
						)
	);
	echo $form->end();
?>

<script language="JavaScript" type="text/javascript">
window.onload=function() {
    window.document.frmGoogle.submit();
}
</script>