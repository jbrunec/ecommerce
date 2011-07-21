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
		
	//shranjevanje narocila
	function saveOrder($orderData, $product_ids, $user_id){
		
		//shrani Order v orders table
		$orderData['Order']['od_shipping_cost'] = 5.00;
		$orderData['Order']['od_date'] = date("Y-m-d H:i:s", time());
		$this->save($orderData);
		
		//shrani produkte v vmesno tabelo orders_products
		$order_id = $this->getInsertID();
		$this->addAssoc('Product', $product_ids, $order_id);
		
		//updatanje zaloge v tabeli products
		$result = $this->Product->Cart->getCartContent($user_id);
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
	
	
	function sendMail($recipient){
		
	}
	
	
}
?>