<?php //debug($session->read())?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Session->flash('email'); ?>
	<?php echo $this->Html->charset(); ?>
	<title>
		Ecommerce app - Admin backend
		<?php echo $title_for_layout; ?>
	</title>
	<style type="text/css">
            div.disabled {
                    display: inline;
                    float: none;
                    clear: none;
                    color: #C0C0C0;
            }
    </style>
	<?php
	
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js');		
		echo $html->script('tiny_mce/tiny_mce');
		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1>Ecommerce App - Admin Area</h1>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth');?>

			<?php echo $content_for_layout; ?>
			<?php if($session->read('Auth.User.admin') == 1){?>
    			<div class="actions">
    				<ul>
    					<li><?php echo $html->link('Index', array('controller' => 'users', 'action' => 'admin_index', 'admin' => true))?></li>
    				</ul>
                	<h3>Product related actions:</h3>
                	<ul>  
                	    <li><?php echo $this->Html->link('Batch xml stock update', array('controller' => 'products','action' => 'admin_batch_xml_stock_update', 'admin' => true));?></li>           	
                		<li><?php echo $this->Html->link('Stock info', array('controller' => 'products','action' => 'admin_get_stock_info', 'admin' => true));?></li>         
                		<li><?php echo $this->Html->link('Add new product', array('controller' => 'products','action' => 'admin_add_product', 'admin' => true));?></li>
                		<li><?php echo $this->Html->link('Show all products', array('controller' => 'products','action' => 'admin_show_all_products', 'admin' => true));?></li>
                	</ul>
                	<br>           	
                	<h3>Users related actions: </h3>
                	<ul>
                		<li><?php echo $html->link('Show all registered users', array('controller' => 'users', 'action' => 'admin_show_all_users'));?></li>
                	</ul>
                	<br>
                	<h3>Orders related actions: </h3>
                	<ul>
                		<li><?php echo $html->link('Show all orders', array('controller' => 'orders', 'action' => 'admin_get_all_orders'));?></li>
                		<li><?php echo $html->link('Completed orders', array('controller' => 'orders','action' => 'admin_get_completed_orders', 'admin' => true)); ?></li>
                	</ul>
                	<br>
                	<h3>Admin: </h3>
                	<ul>
						<li><?php echo $this->Html->link('Logout', array('controller' => 'users','action' => 'admin_logout', 'admin' => true));?></li>           	
                	</ul>
    			</div>
			<?php }?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework', true), 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>