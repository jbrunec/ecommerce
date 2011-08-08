<?php
class CategoriesController extends AppController{
	var $name = 'Categories';
	
	/**
	 * Category Model
	 * @var Category
	 */
	var $Category;
	
	
	function beforeFilter(){
	    parent::beforeFilter();
	    
	    $this->Auth->allow('getAllCategories','menu');
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
	
	function getAllCategories(){
		$result = $this->Category->getAllCategories();
		return $result;
	}
	
	function menu(){
		$result = $this->getAllCategories();
		//pr($this->passedArgs);
		
		return $this->Category->buildCategories($result,$this->passedArgs['c']);	
		
	}
	
	function admin_add(){
	    if(!empty($this->data)){
	        
	        /*
	        if($this->data['Category']['parent'] == 1){
	            $this->data['Category']['cat_parent_id'] = 0;
	            
	        }*/
	        pr($this->data);
	        //die;
	        $this->Category->create();
	        if($this->Category->save($this->data)){
	            $this->Session->setFlash('Category added successfully!');
	            $this->redirect(array('controller' => 'users', 'action' => 'index', 'admin' => true));
	        }else{
	            $this->Session->setFlash('Error adding category!');
	            
	        }
	    }
	    
        $cat_parent_id = $this->Category->find('list', array('conditions' => array('Category.cat_parent_id' => '0'), 'fields' => array('Category.id','Category.cat_name')));
        array_unshift($cat_parent_id, 'PARENT');
        
        $this->set(compact('cat_parent_id'));
	}
	
	function admin_index(){
	    $this->Category->recursive = 0;
	    $categoriesFinal = array();
	    $this->paginate = array('limit' => 15);
	    $categories = $this->paginate();
	    foreach($categories as $category1){
	        $parentIdTmp = $category1['Category']['cat_parent_id'];
	        if($parentIdTmp != 0){
    	        foreach($categories as $category2){
    	            if($category2['Category']['id'] == $parentIdTmp){
    	                $category1['Category']['cat_parent_id'] = $category2['Category']['cat_name'];
    	            }    	        
    	        } 
	        }
	        
	        //pr($category1);
	        array_push($categoriesFinal, $category1);
	    }
	    //pr($categoriesFinal);
	    //die;
	    $this->set('categories', $categoriesFinal);
	    
	}
	
	function admin_edit($id = null){
	    if(!$id){
	        $this->setFlash('Wrong category id');
	    }
	    if(!empty($this->data)){
	        if($this->Category->save($this->data)){
	            $this->Session->setFlash('Category has been edited successfully');
				$this->redirect(array('action' => 'admin_index', 'admin' => true));	            
	        }
	    }else{
	        $this->data = $this->Category->read(null,$id);
	    }
	    
	    $cat_parent_id = $this->Category->find('list', array('conditions' => array('Category.cat_parent_id' => '0'), 'fields' => array('Category.id','Category.cat_name')));
	    array_unshift($cat_parent_id, 'PARENT');
	    $this->set(compact('cat_parent_id'));
	}
	
	
	function admin_delete($id = null){
	    if (!$id) {
			$this->Session->setFlash('Invalid category id');
			$this->redirect(array('action'=>'admin_index', 'admin' => true));
		}elseif($this->Category->delete($id)) {
			$this->Session->setFlash('Product was deleted successfully!');
			$this->redirect(array('action'=>'admin_index', 'admin' => true));
		}
	}
}

?>