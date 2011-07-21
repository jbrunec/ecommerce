
<?php 
	
	//pr($c);
	if($p && $p != 0){
		echo $this->element('product_details');
	}elseif($c && $c != 0){
		
		echo $this->element('product_list');
	}else{
		echo $this->element('category_list');
	}

?>