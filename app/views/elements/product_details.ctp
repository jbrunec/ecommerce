<?php 
	
	
	
	$product = $this->requestAction("/products/view/p:$p");
	//$this->Js->get('.lightbox')->event('lightBox', array('buffer' => false));
	$html->addCrumb('Products',"/carts/index/c:$c");
	$html->addCrumb('Product details',"/carts/index/c:$c/p:$p");
?>
<script type="text/javascript">
$(function() {
	// Use this example, or...
	$('a[@rel*=lightbox]').lightBox(); // Select all links that contains lightbox in the attribute rel
	// This, or...
	$('#gallery a').lightBox(); // Select all links in object with gallery ID
	// This, or...
	$('a.lightbox').lightBox(); // Select all links with lightbox class
	// This, or...

});
</script>
<h2>Product details:</h2>
<a href="/ecommerce/img/products/<?php echo $product['Product']['pd_image']?>" class="lightbox"><?php echo $html->image('products/'.$product['Product']['pd_image'], array('width' => '50', 'height' => '50'));?></a>
<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Name: </dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['pd_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Description:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $product['Product']['pd_description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Stock:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				if($product['Product']['pd_qty'] > 0){
					echo $product['Product']['pd_qty']; 
				}else{?>
					<span style="color:red">Product is out of stock!</span>
			<?php }?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Price: </dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo Configure::read('Shop.currency').' '.$product['Product']['pd_price']; ?>
			&nbsp;
		</dd>
</dl>
<p>
<?php 
	if($product['Product']['pd_qty'] > 0){
		echo $html->image('addToCart2.gif',array('url' => "/carts/addToCart/c:$c/p:".$p)); 
		?>
		<form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="amount" value='<?php echo $product['Product']['pd_price']?>'>
		<input type="hidden" name="business" value='usshop_1310216713_biz@gmail.com'>
		<input type="hidden" name="item_name" value='<?php echo $product['Product']['pd_name'] ?>'>
		
		<?php // echo $html->image('https://www.sandbox.paypal.com/en_US/i/btn/btn_cart_LG.gif',array('url' => "/carts/addToCart/c:$c/p:".$p));?>
		<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>
		
		<?php 
	}else{
		echo $html->link('<< back','/carts/index/c:'.$c);
	}
?>
</p>
<?php echo $this->Js->writeBuffer();?>