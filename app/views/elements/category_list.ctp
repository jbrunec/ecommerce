<?php 
	//$html->addCrumb('Categories','/');
	$featured = $this->requestAction("/products/get_featured_products");
	
    //pr($featured);
?>
<div style="clear: both;"></div>
    <div class="featured">   	
		<ul>
    	<?php foreach($featured as $product):?>
    		<?php 
    		$this->ImageResizer->load($product['Product']['pd_image']);
    		$this->ImageResizer->resizeToHeight(110);
    		$imgHeight = $this->ImageResizer->getHeight();
    		$imgWidth = $this->ImageResizer->getWidth();
    		$imgTopMargin = $this->ImageResizer->getTopMargin();
    		$imgBottomMargin = $this->ImageResizer->getBottomMargin();
    		//$this->ImageResizer->outputImage();
    	    
    		$title = substr($product['Product']['pd_name'], 0, 18);
    		$string = strlen($product['Product']['pd_description']);
    		$product['Product']['pd_description'] = substr($product['Product']['pd_description'], 0, 100);
    		$product['Product']['pd_description'] = $product['Product']['pd_description'].' ...';
    		//pr($string);
    		?>
    		<?php $product['Product']['pd_description'] = Sanitize::html($product['Product']['pd_description'], array('remove' => true));?>
              <li>
              	<h3><?php echo $title;?></h3>
              	<h1>
              	    <a href="<?php echo $html->url(array('controller' => 'products', 'action' => 'view', $product['Product']['id']))?>">
              	    	<span>
              	    		<?php echo $html->image('products/'.$product['Product']['pd_image'], array('width' => $imgWidth, 'height' => $imgHeight, 'style' => "margin-top:{$imgTopMargin}px;margin-bottom:{$imgBottomMargin}px;"));?>
              	    	</span>
              	    </a>     	
              	</h1>
              	<p>
              	    <?php echo $product['Product']['pd_description'];?><br>
              		<span>
              			<em>Price:</em>
              			<big><?php echo Configure::read('Shop.currency').'&nbsp;'.$product['Product']['pd_price'];?></big>
              		</span>
              	</p>
              	
              	
              </li>
  	
    	<?php endforeach; ?>
    	</ul>   	
    </div>
    
    
    
<?php //echo $html->image('products/'.$product['Product']['pd_image'], array('width' => $imgWidth, 'height' => $imgHeight, 'url' => array('controller' => 'products', 'action' => 'view', $product['Product']['id'])));?>