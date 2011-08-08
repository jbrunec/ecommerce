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
			return true;
		}else{

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
				
				//za google checkout---------------
				if($this->data['Order']['payment_option'] == 2){
					$this->redirect("index/c:$this->c/step:google");
				}
				//////////////////////////////////////
			}else{
			    $this->Session->setFlash('User data missing!');
			    $this->redirect(array('action' => "index/c:$c/step:1"));
			}
			
		}elseif ($this->step == 'cod'){
			if(!empty($this->data)){
			    if($this->Auth->user()){
			        $order = $this->Order->saveOrder($this->data, $this->sid ,$this->data['User']['id']);
			    }else{
			        $order = $this->Order->saveOrder($this->data,$this->sid);
			    }
			    
			    if($orderedProducts == 'error'){
			        $this->Session->setFlash('Error, order not received');
			    }else{
			        $this->Session->setFlash('Order placed!');	
			        //nastavi kupljene produkte za prikaz v e-mailu		        
			        $this->set('order',$order);
			        
				    $this->MyEmail->sendOrderReceivedEmail($this->data['Order']['od_payment_email']);
				    $this->redirect(array('action' => "index"));   
			    }
				
				
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
	
	
    function view($id = null){
	    $order =  $this->Order->find('first', array('conditions' => array('Order.id' => $id)));
	    $this->set(compact('order'));
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
	
	//vsa narocila dolocene osebe
	function get_all_user_orders($email = null){	    
	    $this->paginate = array('conditions' => array('Order.od_payment_email' => $email), 'order' => 'Order.od_date DESC');
	    $orders = $this->paginate();
	    $totalSum = $this->Order->get_total_payed_orders_sum($orders, true);
	    $this->set(compact('orders','totalSum'));
	    
	    
	    if(isset($this->params['requested'])){
	        //$orders['totalSum'] = $totalSum;
            $orders =  compact('orders','totalSum');
            //array_push($orders, array('totalSum' => $totalSum));
            return $orders;
	    }
	    
	    
	}
	
	//za view admin_get_all_orders, prikaze vsa narocila
	function admin_get_all_orders(){
	    //$orders = $this->Order->find('all');
	    $this->paginate = array('limit' => 10, 'order' => 'Order.od_date ASC');
	    
	    $this->set('orders', $this->paginate());
	    
	    //v primeru da zelimo spremeniti status narocila
	    if(!empty($this->data)){
	        $this->Order->id = $this->data['Order']['id'];
	        $this->Order->saveField('od_status', $this->data['Order']['od_status']);
	        
	        $result = $this->Order->get_ordered_items($this->data['Order']['id']);
	        
	        //posiljanje emaila s statusom
	        $this->set('orderedProducts',$result);
	        $this->set('status', $this->data['Order']['od_status']);
	        $this->MyEmail->sendOrderStatusEmail($this->data['Order']['od_payment_email']);
	        $this->redirect($this->referer());
	    }  
	}
	
	
	function admin_get_completed_orders(){
	    $this->paginate = array('conditions' => array('Order.od_status' => 'Completed'));
	    $total = $this->Order->get_total_payed_orders_sum();
	    $this->set('orders', $this->paginate());
	    $this->set('totalSum', $total);
	}
	
	
	function admin_view($id = null){
	    $order =  $this->Order->find('first', array('conditions' => array('Order.id' => $id)));
	    $this->set(compact('order'));
	}
	
	
	function admin_order_report(){
	    $time = new TimeHelper();
	    
	    
	    if(!empty($this->data)){
	        //pr($this->data);
	        if($this->data['Order']['option'] == 'today'){
	            $todayStart = mktime(0,0,0,date('m'),date('d'),date('Y'));
	            
	            pr(date('Y-m-d H:i:s',$todayStart));
	            pr(date('H:i:s',time() - $todayStart));
	            //die;
	            //$this->paginate = array('conditions' => array('Order.od_date >=' => $todayStart));
	            $this->paginate = array('conditions' => array($time->daysAsSql($todayStart, time(), 'Order.od_date')));
	            
	            $orders = $this->paginate();
	            $countNum = count($orders);
	            $this->set('orders',$orders);
	            $this->set('totalNum', $countNum);
	            if($countNum == 0){
	                $totalSum = 0.00;                                               
	            }else{
	                $totalSum = $this->Order->get_total_payed_orders_sum($orders);            
	            }
	            $this->set('totalSum', $totalSum); 
	        }elseif($this->data['Order']['option'] == 'yesterday'){
	            $yesterdayStart = mktime(0,0,0,date('m'),date('d')-1,date('Y'));
	            $yesterdayEnd = mktime(23,59,0,date('m'),date('d')-1,date('Y'));
	            //pr(date('Y-m-d H:i:s',$yesterdayStart));
	            //die;
	            
	            $this->paginate = array('conditions' => array('Order.od_date >' => date('Y-m-d H:i:s',$yesterdayStart), 'Order.od_date <' => date('Y-m-d H:i:s',$yesterdayEnd)));
	            //$this->paginate = array('conditions' => array($time->daysAsSql($yesterdayStart, $yesterdayEnd, 'Order.od_date')));
	            $orders = $this->paginate();
	            $countNum = count($orders);
	            if($countNum == 0){
	                $totalSum = 0.00;                                               
	            }else{
	               $totalSum = $this->Order->get_total_payed_orders_sum($orders);
	            }
	            $this->set('totalSum', $totalSum); 
	            $this->set('orders',$orders);	            
    	        $this->set('totalNum', $countNum);
	        }else{
    	        $hour = $this->data['Order']['startDate']['hour'];
    	        $minute = $this->data['Order']['startDate']['min'];
    	        $year = $this->data['Order']['startDate']['year'];
    	        $month = $this->data['Order']['startDate']['month'];
    	        $day = $this->data['Order']['startDate']['day'];
    	        $start = @mktime($hour,$minute,0,$month,$day,$year);
    	        
    	        $hour = $this->data['Order']['endDate']['hour'];
    	        $minute = $this->data['Order']['endDate']['min'];
    	        $year = $this->data['Order']['endDate']['year'];
    	        $month = $this->data['Order']['endDate']['month'];
    	        $day = $this->data['Order']['endDate']['day'];
    	        $end = @mktime($hour,$minute,0,$month,$day,$year);
    	        
    	        $this->paginate = array('conditions' => array($time->daysAsSql($start, $end, 'Order.od_date'), 'Order.od_status' => 'Completed'));
    	        $orders = $this->paginate();
    	        $countNum = count($orders);
    	        $this->set('orders', $orders);
    	        $this->set('totalNum', $countNum);
    	        
    	        $totalSum = $this->Order->get_total_payed_orders_sum($orders);
    	        $this->set('totalSum', $totalSum);
	        }
	        
	        
	    }
	    
	    //Y-m-d H:i:s
	    mktime();
	    $beginningDay = mktime(0,0,0,8,2,2011);
	    
	    /*
	    pr($now);
	    pr($time->format('Y-m-d H:i:s',$now));
	    pr($beginningDay);
	    pr($time->format('Y-m-d H:i:s',$beginningDay));
	    $timeElapsed = time() - $beginningDay;
	    pr(date('H:i:s', $timeElapsed));
	    
	    pr($timeElapsed/60/60);
	    //die;
	    
	    $orders = $this->Order->find('all', array('conditions' => array($time->daysAsSql($beginningDay, time(), 'Order.od_date'))));
	    $totalSum = $this->Order->get_total_payed_orders_sum($orders);
	    $this->set('orders', $orders);
	    */
	}

	function admin_report_pdf(){
	    $orders = $this->Order->find('all');
	    //pr($orders);
	    //die;
	    //Configure::write('debug', 0);
	    $this->layout = 'pdf';
	    $this->set('orders', $orders);
	    $this->render();
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