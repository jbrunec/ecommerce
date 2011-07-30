<?php
class OrdersController extends AppController{
	var $name = 'Orders';
	var $step;
	/**
	 * 
	 * Order Model
	 * @var Order
	 */
	var $Order;
	
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index');
		
		if($this->isAuthorized()){
		    $this->Auth->allow('*');
		}
		
	}
	
	
	function isAuthorized(){
	    if($this->Auth->user('admin')){
			pr('this user is admin');
			//exit;
			return true;
		}else{
			pr('this user is NOT admin');
			//exit;
			//$this->Session->setFlash('This area is for admins only!');
			return false;
		}
	}
	
	function index(){
		//$this->_sendEmail('jernej.brunec@gmail.com', 'Your Order has been recieved!','this is an email text body');

		if(isset($this->passedArgs['step'])){
			$this->step = $this->passedArgs['step'];
		}
		$this->set('step', $this->step);
		
		if($this->step == 2){
			if(!empty($this->data)){
			    $this->Order->set($this->data);
			    if(!$this->Order->validates(array('fieldList' => 'payment_option'))){
			        $this->Session->setFlash('You forgot to choose payment option');
			        $this->redirect($this->referer());
			    }
			    
				$this->set('userInfo',$this->data);
				$totalPrice = $this->Order->Product->Cart->getCartTotalPrice(null, $this->sid, $this->Session->read('Auth.User.id'));
				$this->set('totalPrice',$totalPrice);
				if($this->data['Order']['payment_option'] == 2){
					$this->redirect("index/c:$this->c/step:google");
				}
			}else{
			    $this->Session->setFlash('User data missing!');
			    $this->redirect(array('action' => "index/c:$c/step:1"));
			}
			
		}elseif ($this->step == 'cod'){
			if(!empty($this->data)){
			    if($this->Auth->user()){
			        $orderedProducts = $this->Order->saveOrder($this->data, $this->sid ,$this->data['User']['id']);
			    }else{
			        $orderedProducts = $this->Order->saveOrder($this->data,$this->sid);
			    }
				//$this->redirect(array('action' => "index/c:$c"/))
				//$this->_sendEmail($this->data['Order']['od_payment_email'], 'Your Order has been recieved!',$orderedProducts, 'received_order');
				$this->Session->delete('Product_ids');
			}
		}elseif($this->step == 'paypal'){
			$paypal = array();
			$paypal['username'] = 'eshop_1309605309_biz_api1.gmail.com';
			$paypal['password'] = '1309605353';
			$paypal['signature'] = 'AiPC9BjkCyDFQXbSkoZcgqH3hpacA4TlLrMdwUVOcGq8BK4tNk9Rdji5';
			$paypal['currency_code'] = 'GBP';
			$paypal['url'] = "https://api-3t.sandbox.paypal.com/nvp";
			$this->set('paypal',$paypal);

		}
	}
	//narocila stara 1 dan in manj
	function get_recent_orders(){
	    $orders = $this->Order->get_recent_orders();
	    if($this->params['requested']){
	        return $orders;
	    }else{
	        $this->set('orders', $orders);
	    }
    
	}
	
	//za view admin_get_all_orders, prikaze vsa narocila
	function admin_get_all_orders(){
	    //$orders = $this->Order->find('all');
	    $this->paginate = array('limit' => 10, 'order' => 'Order.od_date ASC');
	    
	    $this->set('orders', $this->paginate());
	}
	
	
	function admin_view($id = null){
	    $order =  $this->Order->find('first', array('conditions' => array('Order.id' => $id)));
	    $this->set(compact('order'));
	}
	
	
	


	/** SetExpressCheckout NVP example; last modified 08MAY23.
	 *
	 *  Initiate an Express Checkout transaction. 
	*/
	
	
	
	/**
	 * Send HTTP POST Request
	 *
	 * @param	string	The API method name
	 * @param	string	The POST Message fields in &name=value pair format
	 * @return	array	Parsed HTTP Response body
	 */
	function PPHttpPost($methodName_, $nvpStr_) {

	
		// Set up your API credentials, PayPal end point, and API version.
		$API_UserName = urlencode('eshop_1309605309_biz_api1.gmail.com');
		$API_Password = urlencode('1309605353');
		$API_Signature = urlencode('AiPC9BjkCyDFQXbSkoZcgqH3hpacA4TlLrMdwUVOcGq8BK4tNk9Rdji5');
		$API_Endpoint = "https://api-3t.sandbox.paypal.com/nvp";
		
		$version = urlencode('51.0');
	
		// Set the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
	
		// Turn off the server and peer verification (TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
	
		// Set the API operation, version, and API signature in the request.
		$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
	
		// Set the request as a POST FIELD for curl.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
	
		// Get response from the server.
		$httpResponse = curl_exec($ch);
	
		if(!$httpResponse) {
			exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
		}
	
		// Extract the response details.
		$httpResponseAr = explode("&", $httpResponse);
	
		$httpParsedResponseAr = array();
		foreach ($httpResponseAr as $i => $value) {
			$tmpAr = explode("=", $value);
			if(sizeof($tmpAr) > 1) {
				$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
			}
		}
	
		if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
			exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
		}
	
		return $httpParsedResponseAr;
	}
	



}
?>