<?php
class Product extends AppModel{
	var $name = 'Product';
	/**
	 * 
	 * Cart model
	 * @var Cart
	 */
	var $Cart;
	
	
	var $belongsTo = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	var $hasMany = array('Cart');
	var $hasAndBelongsToMany = array(
		'Order' => 
			array(
				'className' => 'Order',
				'joinTable' => 'orders_products',
				'foreignKey' => 'product_id',
				'associationForeignKey' => 'order_id'
			)
		);
	
	function listProducts($catId = null){
		$results = $this->find('all', array('conditions' => array('Product.category_id' => $catId),
											'order' => 'Product.category_id ASC'));
		return $results;
	}
}
?>