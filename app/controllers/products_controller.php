<?php
App::import('File');
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
		$this->paginate = array('conditions' => array('Product.category_id' => $allCatIds),'limit' => 2);
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
		    if(!$this->admin_upload_photo()){
		        //$this->Product->invalidate('file','isUploaded');
		        $this->Session->setFlash('Incorrect file type');
		        //$this->render();
		    }else{
    			$this->Product->create();
    			//$this->data['Product']['pd_image'] = $this->data['Product']['pd_image']['name'];
    			if($this->Product->save($this->data)){
    				$this->Session->setFlash('Product was saved successfully!');
    			}else{
    				$this->Session->setFlash('The product could not be saved');
    			}
		    }
		}
		
	$categories = $this->Product->Category->find('list',array('fields' => array('Category.id','Category.cat_name','Category.cat_parent_id'), 'order' => array('Category.cat_parent_id ASC')));
	//$subCategories = $this->Product->Category->find('list', array('fields' => array('Category.cat_parent_id')));
	//pr($subCategories);
	$this->set(compact('categories'));
	}
	
	function admin_edit_product($id = null){
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid product');
			$this->redirect(array('action' => 'admin_show_all_products', 'admin' => true));
		}
		if (!empty($this->data)) {
		    if(!$this->admin_upload_photo()){
		        //$this->Product->invalidate('file','isUploaded');
		        $this->Session->setFlash('Incorrect file type');
		        //$this->render();
		    }else{
		        //$this->data['Product']['pd_last_update'] = date('Y-m-d H:i:s', time());
			    if ($this->Product->save($this->data)) {
				    $this->Session->setFlash('Product has been edited successfully');
				    $this->redirect(array('action' => 'admin_show_all_products', 'admin' => true));
			    } else {
				    $this->Session->setFlash('Product could not be edited!');
			    }
		    }
		   
		}
		if (empty($this->data)) {
		    $this->Product->recursive = 1;
			$this->data = $this->Product->read(null, $id);
		}
		
		$categories = $this->Product->Category->find('list',array('fields' => array('Category.id','Category.cat_name')));
	
		$this->set(compact('categories'));
	}
	
	
	function admin_delete_product($id = null){
		if (!$id) {
			$this->Session->setFlash('Invalid id for a product');
			$this->redirect(array('action'=>'admin_show_all_products'));
		}
		if ($this->Product->delete($id)) {
			$this->Session->setFlash('Product was deleted successfully!');
			$this->redirect(array('action'=>'admin_show_all_products'));
		}
		$this->Session->setFlash('Product was not deleted!');
		$this->redirect(array('action' => 'admin_show_all_products'));
	 
	}
	
	function admin_show_all_products(){
		$this->paginate = array('limit' => 5);
		//$products = $this->Product->find('all');
		$this->set('products', $this->paginate());
		
		
	}
	
	function admin_get_stock_info(){
	    //$products = $this->Product->find('all');
	    $this->paginate = array('fields' => array('Product.id','Product.pd_name','Product.pd_qty'), 'order' => 'Product.pd_qty ASC');
	    $this->set('products', $this->paginate());
	    
	    if(!empty($this->data)){
		    pr($this->data);
		    //die;
		    $productId = $this->passedArgs['pd_id'];
		    $stockQty = $this->data['Product']['pd_qty'];
		    if($this->Product->update_stock_qty($productId,$stockQty)){
		        $this->Session->setFlash('Product stock updated successfully!');
		        $this->redirect(array('action' => "admin_get_stock_info", 'admin' => true));
		    }else{
		        $this->Session->setFlash('Product stock failed to update');
		        $this->redirect(array('action' => "admin_get_stock_info", 'admin' => true));
		    }
		    
		    
		}
	}
	
	//za updatanje zaloge preko XMLa
	function admin_batch_xml_stock_update(){
	    App::import('Xml');
	    
	    if(!empty($this->data)){
	        $path = WWW_ROOT.'files\\';
	        $xml = $this->data['Product']['file']['tmp_name'];
	        $xmlName = $this->data['Product']['file']['name'];
	        $file = new File($xml);
	        $xmlContent = $file->read();
	        $file->close();
	        
	        $file = new File($path.$xmlName, true);
	        $file->write($xmlContent);
	        $file->close();
	        
	        $parsed_xml = new Xml($path.$xmlName);
	        $parsed_xml = Set::reverse($parsed_xml);
	        $this->Product->batch_xml_update($parsed_xml);
	        $this->Session->setFlash('Xml update successful!'); 
	    }
	    
	    //$file = WWW_ROOT.'files\\stock_update.xml';
	    
	    ;
	    //debug($parsed_xml);
	    //die;
	    
	    
	}
	
	function admin_upload_photo($file = null){
	    $path = "img\\products\\";
	    $dir = WWW_ROOT.$path;
	    
	    //trenutna lokacija slike
	    $image = $this->data['Product']['file']['tmp_name'];
	    $imageName = $this->data['Product']['file']['name'];
	    $file = new File($image);
	    
	    //preverjanje koncnic za sliko
	    $ext = $file->ext();	    
	    if($ext != 'jpg' || $ext != 'jpeg' || $ext != 'png' || $ext != 'gif'){
	        
	        return false;
	    }
	    
	    $fileData = $file->read();
	    $file->close();
	    
	    //zapis v nov fajl
	    $file = new File($dir.$imageName,true);
	    $file->write($fileData);
	    $file->close();
	    
	    //nastavitev pd_image na ime slike (ker je se vedno array())
	    $this->data['Product']['pd_image'] = $imageName;
	    return true;
	}
}
?>