<?php
class CategoriesController extends AppController{
	var $name = 'Categories';
	
	/**
	 * Category Model
	 * @var Category
	 */
	var $Category;
	
	function getAllCategories(){
		$result = $this->Category->getAllCategories();
		return $result;
	}
	
	function menu(){
		$result = $this->getAllCategories();
		//pr($this->passedArgs);
		
		return $this->Category->buildCategories($result,$this->passedArgs['c']);	
		
	}
}

?>