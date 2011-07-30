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
		
		
		
	var $validate = array(
	    'file' => array(
	        'rule' => array('isUploadedFile','file'),
	        'message' => 'Error uploading file!'
	    ),
	);
	
	function listProducts($catId = null){
		$results = $this->find('all', array('conditions' => array('Product.category_id' => $catId),
											'order' => 'Product.category_id ASC'));
		return $results;
	}
	
	

    function isUploadedFile($params,$field){
	    $val = $params['file'];
    	if ((isset($val['error']) && $val['error'] == 0) || (!empty( $val['tmp_name']) && $val['tmp_name'] != 'none')) {
    		return is_uploaded_file($val['tmp_name']);
    	}
    	$this->invalidate($field,'Error uploading file');
	    return false;
    }
    
    function update_stock_qty($id, $qty){
             
        $this->id = $id;
        if($this->saveField('pd_qty', $qty)){
            return true;
        }else{    
            return false;
        }
    }
    
    
    function batch_xml_update($data){
        foreach($data['Products']['Product'] as $product){
            $this->id = $product['id'];
            $this->saveField('pd_qty', $product['quantity']);
        }
        
        return true;
    }
	
}
?>