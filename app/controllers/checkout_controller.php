<?php
class CheckoutController extends AppController{
	function _get($var) { 
    	return isset($this->params['url'][$var])? $this->params['url'][$var]: null; 
	} 
     
	function expressCheckout($step=1){ 
	    $this->Ssl->force(); 
	    $this->set('step',$step); 
	    //first get a token 
	    if ($step==1){ 
	        // set 
	        $paymentInfo['Order']['theTotal']= .01; 
	        $paymentInfo['Order']['returnUrl']= "http://localhost/ecommerce/checkout/expressCheckout/2/"; 
	        $paymentInfo['Order']['cancelUrl']= "http://localhost/ecommerce/"; 
	             
	        // call paypal 
	        $result = $this->Paypal->processPayment($paymentInfo,"SetExpressCheckout"); 
	        $ack = strtoupper($result["ACK"]); 
	        //Detect Errors 
	        if($ack!="SUCCESS") 
	            $error = $result['L_LONGMESSAGE0']; 
	        else { 
	            // send user to paypal 
	            $token = urldecode($result["TOKEN"]); 
	            $payPalURL = PAYPAL_URL.$token; 
	            $this->redirect($payPalURL); 
	        } 
	    } 
	    //next have the user confirm 
	    elseif($step==2){ 
	        //we now have the payer id and token, using the token we should get the shipping address 
	        //of the payer. Compile all the info into the session then set for the view. 
	        //Add the order total also 
	        $result = $this->Paypal->processPayment($this->_get('token'),"GetExpressCheckoutDetails"); 
	        $result['PAYERID'] = $this->_get('PayerID'); 
	        $result['TOKEN'] = $this->_get('token'); 
	        $result['ORDERTOTAL'] = .01; 
	        $ack = strtoupper($result["ACK"]); 
	        //Detect errors 
	        if($ack!="SUCCESS"){ 
	            $error = $result['L_LONGMESSAGE0']; 
	            $this->set('error',$error); 
	        } 
	        else { 
	            $this->set('result',$this->Session->read('result')); 
	            $this->Session->write('result',$result); 
	            /* 
	             * Result at this point contains the below fields. This will be the result passed  
	             * in Step 3. I used a session, but I suppose one could just use a hidden field 
	             * in the view:[TOKEN] [TIMESTAMP] [CORRELATIONID] [ACK] [VERSION] [BUILD] [EMAIL] [PAYERID] 
	             * [PAYERSTATUS]  [FIRSTNAME][LASTNAME] [COUNTRYCODE] [SHIPTONAME] [SHIPTOSTREET] 
	             * [SHIPTOCITY] [SHIPTOSTATE] [SHIPTOZIP] [SHIPTOCOUNTRYCODE] [SHIPTOCOUNTRYNAME] 
	             * [ADDRESSSTATUS] [ORDERTOTAL] 
	             */ 
	        } 
	    } 
	    //show the confirmation 
	    elseif($step==3){ 
	        $result = $this->Paypal->processPayment($this->Session->read('result'),"DoExpressCheckoutPayment"); 
	    //Detect errors 
	        $ack = strtoupper($result["ACK"]); 
	        if($ack!="SUCCESS"){ 
	            $error = $result['L_LONGMESSAGE0']; 
	            $this->set('error',$error); 
	        } 
	        else { 
	            $this->set('result',$this->Session->read('result')); 
	        } 
	    } 
	} 

}