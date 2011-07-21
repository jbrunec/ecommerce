<?php
class Cart extends AppModel{
	var $name = 'Cart';
	var $belongsTo = array('Product');
	
	
	
	/*
	function isCartEmpty($sid = null){
		$result = $this->find('first', array('conditions' => array('Cart.product_id' => $p, 'Cart.ct_session_id' => $sid)));
		
		if(empty($result)){
			return true;
		}else{
			return false;
		}
	}
	
	function getCart($pid,$sid){
		return $this->find('all', array('conditions' => array('Cart.product_id' => $pid,
																'Cart.ct_session_id' => $sid),
										'order' => 'Cart.id ASC'));
	}
	*/
	function addToCart($product_id, $session_id){
		$this->data['Cart']['product_id'] = $product_id;
		$this->data['Cart']['ct_date'] = date("Y-m-d H:i:s", time());
		$this->data['Cart']['ct_qty'] = 1;
		$this->data['Cart']['ct_session_id'] = $session_id;
		
		$this->save();
	}
	
	function getCartContent($session_id){
		//$cartContent = array();
		/*
		$sql = "SELECT ct.id, ct.product_id, ct.ct_qty, pd.pd_name, pd.pd_description, pd.pd_price, pd.pd_image, pd.category_id
		FROM carts ct, products pd, categories cat
		WHERE ct_session_id = '$session_id' AND
		ct.product_id = pd.id AND
		cat.id = pd.category_id";
		
		$results = $this->query($sql);
		foreach ($results as $result){
			$cartContent[] = $result;
		}*/
		
		//cake verzija querija
		$this->recursive = 2;
		$cartContent = $this->find('all', array('conditions' => array('Cart.ct_session_id' => $session_id)));
		
		
		
		return $cartContent;
	}
	
	
	function updateCart($product_id, $session_id){
		$sql = "UPDATE carts SET ct_qty = ct_qty + 1 WHERE ct_session_id = '$session_id' AND product_id = $product_id";
		$this->query($sql);
	}
	
	
	function doUpdate($cart){
		
		foreach($cart as $item){
			$this->data['Cart']['ct_qty'] = $item['ct_qty'];
			$this->data['Cart']['ct_date'] = date("Y-m-d H:i:s", time());
			$this->id = $item['id'];
			$this->save();
		}
		
		
		
	}
	
	//za pucanje starih kosaric
	function cleanUp(){
		$threeDaysAgo = date('Y-m-d H:i:s',mktime(0,0,0, date('m'),date('d') - 3, date('Y')));
		$delete_condition = "Cart.ct_date < '$threeDaysAgo'";
		$this->deleteAll($delete_condition, false);
	}
	
	function emptyCart($cartId){
		if($cartId){
			$this->delete($cartId);
		}
	}
}

?>