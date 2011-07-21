<?php
class CartsController extends AppController{
	var $name = 'Carts';
	/**
	 * 
	 * Cart Model
	 * @var Cart
	 */
	var $Cart;
	
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('*');
	}
	
	function index(){
		
	}
	
	function getCartContent(){
		return $this->Cart->getCartContent($this->sid);
	}
	
	function addToCart(){
		$result = $this->Cart->Product->findById($this->p);	
		
		if(empty($result)){
			$this->Session->setFlash('This product was not found!');
			$this->redirect(array('action' => 'index'));
		}else{
			if($result['Product']['pd_qty'] <= 0){
				$this->Session->setFlash('The product you requested is out of stock!');
				$this->redirect(array('action' => 'index'));
			}
		}
		$sessionData = $this->Cart->getCart($this->p, $this->sid);
		if(empty($sessionData)){
			$this->Cart->addToCart($this->p, $this->sid);
			$this->Session->setFlash('Product added to cart!');
		}else{
			$this->Cart->updateCart($this->p, $this->sid);
			$this->Session->setFlash('Product added to cart!');
		}
		
		$this->Cart->cleanUp();
		$this->redirect(array('controller' => 'carts', 'action' => "index/c:$this->c/p:$this->p"));
	}
	
	//ogled vsebine vozicka
	function view(){
		//$this->Session->delete('Product_ids');
		$cartContents = $this->getCartContent();
		$totalPrice = 0;
		$i = 0;
		foreach($cartContents as $item){
			$totalPrice += ($item['Product']['pd_price'] * $item['Cart']['ct_qty']);
			$this->Session->write("Product_ids.$i",$item['Product']['id']);
			
			$i++;
		}
		
		$this->set('cartContents', $cartContents);
		$this->set('totalPrice', $totalPrice);
		
		
		//debug($this->data);
		if(!empty($this->data['Cart'])){
			$this->Cart->doUpdate($this->data['Cart']);
			$this->redirect(array('controller' => 'carts','action' => 'view/c:'.$this->c));
		}
	}
	
	function emptyCart(){
		$this->Cart->emptyCart($this->passedArgs['ct']);
		$this->redirect(array('action' => 'view/c:'.$this->c));
	}
	
	
	function isCartEmpty(){
		$result = $this->Cart->find('first',array('conditions' => array('Cart.ct_session_id' => $this->sid)));
		if(empty($result)){
			return true;
		}else{
			return false;
		}
	}
}
?>