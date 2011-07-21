<?php
class ProductsController extends AppController{
	var $name = 'Products';
	//var $helpers = array('Paginator');
	/**
	 * 
	 * Product Model
	 * @var Product
	 */
	var $Product;
	//var $paginate = array('limit' => 10, 'order' => 'Product.id DESC');
	//var $paginate = array('Product', array('conditions' => array()));
	function beforeFilter(){
		parent::beforeFilter();
		
		$this->Auth->allow('view');
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
	
	
	function listProducts(){
		
		$this->autoRender = false;
		//$this->Product->recursive = 0;
		
		$categories = $this->Product->Category->getAllCategories();
		$categories = $this->Product->Category->buildCategories($categories,$this->passedArgs['c']);
		$catChildren = $this->Product->Category->getChildCategories($categories,$this->passedArgs['c'],true);
		$allCatIds = array_merge(array($this->passedArgs['c']),$catChildren);
		
		//pr($allCatIds);
		$this->paginate = array('conditions' => array('Product.category_id' => $allCatIds),'limit' => 3);
		$data = $this->paginate();
		$this->set('products',$data);
		$this->helpers['Paginator'] = array('ajax' => 'Ajax');
		//pr($this->helpers);		
		if ($this->RequestHandler->isAjax()) {
	        $this->render('/elements/product_list');
	        return;
	    }

		if(isset($this->params['requested'])){		
			//ClassRegistry::getObject('view')->loaded['paginator']->params = $this->params;
			//$this->set('paging', $this->params['paging']);
			return array('products' => $data, 'paging' => $this->params['paging']);
		}else{
			
			$this->render('/elements/product_list');
		}		
	}
	
	
	function view(){
		$result = $this->Product->read(null,$this->passedArgs['p']);
		$this->set('product',$result);
		
		if($this->params['requested']){
			return $result;
		}
	}
	
	function admin_add_product(){
		if(!empty($this->data)){
			$this->Product->create();
			if($this->Product->save($this->data)){
				$this->Session->setFlash('Product was saved successfully!');
			}else{
				$this->Session->setFlash('The product could not be saved');
			}
		}
		
	$categories = $this->Product->Category->find('list',array('fields' => array('Category.id','Category.cat_name')));
	
	$this->set(compact('categories'));
	}
	
	function admin_edit_product($id = null){
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid product');
			$this->redirect(array('action' => 'admin_show_all_products', 'admin' => true));
		}
		if (!empty($this->data)) {
			if ($this->Post->save($this->data)) {
				$this->Session->setFlash('Product has been edited successfully');
				$this->redirect(array('action' => 'admin_show_all_products', 'admin' => true));
			} else {
				$this->Session->setFlash('Product could not be edited!');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Product->read(null, $id);
		}
		
		$categories = $this->Product->Category->find('list',array('fields' => array('Category.id','Category.cat_name')));
	
		$this->set(compact('categories'));
	}
	
	function admin_show_all_products(){
		$this->paginate = array('limit' => 3);
		//$products = $this->Product->find('all');
		$this->set('products', $this->paginate());
	}
	
}
?>