<?php

class Category extends AppModel{
	var $name  = 'Category';
	var $hasMany = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'category_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	function getAllCategories(){
		$result  = $this->find('all', array('order' => 'Category.id ASC'));
		
		return $result;
	}
	
	function getTopCategories(){
		$result = $this->find('all', array('conditions' => array('Category.cat_parent_id' => 0)));
		
		return $result;
	}
	function buildCategories($categories, $parentId){
			$childCategories = array();
			$ids = 	array();
			
			foreach ($categories as $category){
				if($category['Category']['cat_parent_id'] == $parentId){
					$childCategories[] = $category['Category'];
				}
				$ids[$category['Category']['id']] = $category['Category'];
			}
			$holdParentId = $parentId;
			while($holdParentId != 0){
				$parent = array($ids[$holdParentId]);
				$currentId = $parent[0]['id'];
				$holdParentId = $ids[$holdParentId]['cat_parent_id'];
				foreach($categories as $category){
					if($category['Category']['cat_parent_id'] == $holdParentId && !in_array($category['Category'], $parent)){
						$parent[] = $category['Category'];
					}
				}
				array_multisort($parent);
				$n = count($parent);
				$childCategories2 = array();
				
				for($i=0;$i<$n;$i++){
					$childCategories2[] = $parent[$i];
					if($parent[$i]['id'] == $currentId){
						$childCategories2 = array_merge($childCategories2,$childCategories);
					}
				}
				$childCategories = $childCategories2;
			}
		return $childCategories;
	}
	
	
	function getChildCategories($categories, $id, $recursive = true){
			if($categories == null){
				$categories = $this->getAllCategories();
			}
			$n = count($categories);
			$child = array();
			for($i=0;$i<$n;$i++){
				$catId = $categories[$i]['id'];
				$parentId = $categories[$i]['cat_parent_id'];
				if($parentId == $id){
					$child[] = $catId;
					if($recursive){
						$child = array_merge($child,$this->getChildCategories($categories, $catId));
					}
				}
			}
			return $child;
	}
	
	
}
?>