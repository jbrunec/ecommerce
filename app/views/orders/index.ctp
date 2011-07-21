<?php 
	if($step == 1){
		echo $this->element('shippingAndPaymentInfo');
	}elseif ($step == 2){
		echo $this->element('confirmationPage');
	}elseif ($step == 'cod'){
		echo $this->element('thank_you_page');
	}elseif($step == 'paypal'){
		echo $this->element('paypal');
	}elseif($step == 'google'){
		echo $this->element('google_checkout');
	}
?>