<?php debug($order)?>
<div class="orders view">
<h2>Order info: </h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>>id</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $order['Order']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Date:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $order['Order']['od_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Status:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $order['Order']['od_status']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Recipient name:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $order['Order']['od_shipping_full_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Recipient address:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $order['Order']['od_shipping_address']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Recipient city:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $order['Order']['od_shipping_city']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Recipient postal code:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $order['Order']['od_shipping_postal_code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Shipping cost:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo Configure::read('Shop.currency').' '.$order['Order']['od_shipping_cost']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Tax:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $order['Order']['od_payment_tax']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Total:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo Configure::read('Shop.currency').' '.$order['Order']['od_payment_total']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<br>
<div class="products view">
<h2>Ordered Products: </h2>
<?php foreach($order['Product'] as $product):?>
	<dl>
		<dt class="altrow">Name</dt>
		<dd class="altrow">
			<strong><?php echo $product['pd_name']; ?></strong>
			&nbsp;			
		</dd>
		<dt>price:</dt>
		<dd>
			<?php echo Configure::read('Shop.currency').' '.$product['pd_price']; ?>
			&nbsp;			
		</dd>
		<dt class="altrow">Quantity:</dt>
		<dd class="altrow">
			<?php echo 'X '.$product['OrdersProduct']['od_qty']; ?>
			&nbsp;			
		</dd>
	</dl>
	<br>
	<hr>
<?php endforeach;?>
</div>
