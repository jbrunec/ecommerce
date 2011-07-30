<?php
class Order extends AppModel{
	var $name = 'order';
	/**
	 * 
	 * Product associated model
	 * @var Product
	 */
	var $Product;
	
	
	
	var $hasAndBelongsToMany = array(
		'Product' => 
			array(
				'className' => 'Product',
				'joinTable' => 'orders_products',
				'foreignKey' => 'order_id',
				'associationForeignKey' => 'product_id'
			)
	);
	
	var $virtualFields = array('od_shipping_full_name' => 'CONCAT(Order.od_shipping_first_name, " ", Order.od_shipping_last_name)');
		
	var $validate = array(
	    'payment_option' => array(
	        'rule' => array('notEmpty'),
	        'message' => 'this field must not be empty!'
	    ),
	);	
		
		
	//shranjevanje narocila
	function saveOrder($orderData, $session_id ,$user_id = null){
		$time = new TimeHelper();
		//shrani Order v orders table
		$orderData['Order']['od_shipping_cost'] = 5.00;
		$orderData['Order']['od_date'] = $time->format("Y-m-d H:i:s", $time->gmt());
		$orderData['Order']['od_payment_tax'] = 0.00;
		
		$this->save($orderData);
		
		//shrani produkte v vmesno tabelo orders_products
		$order_id = $this->getInsertID();
		
		
		//    pridobivanje IDjev produktov iz vozicka 
		if(!empty($user_id)){
		    $result = $this->Product->Cart->getCartContent(null, $user_id);
		}else{
		    $result = $this->Product->Cart->getCartContent($session_id);
		}
		
		$product_ids = array();
		$orderQty = array();
		$i = 0;		
		foreach ($result as $item){
		    $product_ids[$i] = $item['Product']['id'];
		    $orderQty[$i] = $item['Cart']['ct_qty'];
		    $i++;
		}
		//pr($product_ids);
		//die;
		
		$this->addAssoc('Product', $product_ids, $order_id, $orderQty);
		//die;
		
		//updatanje zaloge v tabeli products
		
		$products = array();	
		foreach($result as $item){
			array_push($products, $item['Product']);
			$value = $item['Product']['pd_qty'] - $item['Cart']['ct_qty'];
			$this->Product->id = $item['Cart']['product_id'];
			$this->Product->saveField('pd_qty', $value);
		}
		
		//brisanje vsebine kosarice
		foreach($result as $item){
			$this->Product->Cart->emptyCart($item['Cart']['id']);
		}
		
		
		
		return $products;
		
		
	}
	
	//funkcija za pridobitev vseh narocil, ki niso starejsa od 1 dneva
	function get_recent_orders(){
	    $time = new TimeHelper();
	    	    
        $dayAgo = $time->gmt() - 86400;
        
        $formatedDayAgo = $time->format("Y-m-d H:i:s",$dayAgo);
	    $result =  $this->find('all', array('conditions' => array('od_date >=' => $formatedDayAgo)));
	    
	    return $result;
	}
	
	
	
	
	
}
?>