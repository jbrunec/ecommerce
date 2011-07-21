Welcome to our Computer shop!
<?php 
	
	//debug($this->params);
	if($p && $p != 0){
		echo $this->element('product_details');
	}elseif($c && $c != 0){
		//$this->Paginator->params['paging'] = $paging;
		echo $this->element('product_list');
	}else{
		echo $this->element('category_list');
	}

?>