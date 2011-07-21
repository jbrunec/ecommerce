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
	
	/*function formatCategories($categories, $parentId){
		// $navCat stores all children categories
		// of $parentId
		$navCat = array();
		
		// expand only the categories with the same parent id
		// all other remain compact
		$ids = array();
		foreach ($categories as $category) {
			if ($category['Category']['cat_parent_id'] == $parentId) {
				$navCat[] = $category;
			}
			
			// save the ids for later use
			$ids[$category['Category']['id']] = $category;
		}	
	
		$tempParentId = $parentId;
		
		// keep looping until we found the 
		// category where the parent id is 0
		while ($tempParentId != 0) {
			$parent    = array($ids[$tempParentId]);
			$currentId = $parent[0]['id'];
	
			// get all categories on the same level as the parent
			$tempParentId = $ids[$tempParentId]['cat_parent_id'];
			foreach ($categories as $category) {
			    // found one category on the same level as parent
				// put in $parent if it's not already in it
				if ($category['Category']['cat_parent_id'] == $tempParentId && !in_array($category, $parent)) {
					$parent[] = $category;
				}
			}
			
			// sort the category alphabetically
			array_multisort($parent);
		
			// merge parent and child
			$n = count($parent);
			$navCat2 = array();
			for ($i = 0; $i < $n; $i++) {
				$navCat2[] = $parent[$i];
				if ($parent[$i]['id'] == $currentId) {
					$navCat2 = array_merge($navCat2, $navCat);
				}
			}
			
			$navCat = $navCat2;
		}
	
	
		return $navCat;
	}*/
	
}
?>