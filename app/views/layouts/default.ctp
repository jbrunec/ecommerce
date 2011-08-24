<?php debug($session->read());
//debug($this->params);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB">
<head>
	
	<?php echo $this->Html->charset(); ?>
	<title>
		Ecommerce shop! - 
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

		echo $this->Html->css('menu_style');
		echo $this->Html->css('costum');
		echo $this->Html->css('jquery.lightbox-0.5');
		echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js');
		echo $this->Html->script('jquery');
		echo $this->Html->script('jquery.lightbox-0.5');
		/*echo $this->Html->script('jquery.lightbox-0.5.min');
		echo $this->Html->script('jquery.lightbox-0.5.pack');*/
		echo $scripts_for_layout;
	?>
	<?php echo $session->flash('email');?>
</head>
<body>

<div id="header">

	<h1>CakePHP Powered e-Commerce website!</h1>
	<h2>Choose your desired product!</h2>
	<ul>
		<li><a href="http://localhost/ecommerce/" class="active">Home <span>&nbsp;</span></a></li>
		<li><a href="http://localhost/ecommerce/users/login">Users <span>Login!</span></a></li>
		<?php if($session->check('Auth.User')){?>
			<li><a href="http://localhost/ecommerce/users/index">Your <span>Account</span></a></li>
		<?php }?>
	</ul>
	<div id="spinner" style="display: none; float:right;">
            <?php echo $html->image('ajax-loader.gif'); ?>
	</div>
	<p id="layoutdims">You are here: <?php echo $html->getCrumbs(' -> ','Home')?></p>
</div>
<div class="colmask threecol">
	<div class="colmid">
		<div class="colleft">
			<div class="col1">
				<!-- Column 1 start -->
				<span style="color: red"><?php echo $this->Session->flash(); ?></span>
				<span style="color: red"><?php echo $this->Session->flash('auth'); ?></span>
				<?php echo $content_for_layout?>
				<div>
					<br></br>
					<br></br>
				
				</div>
				<!-- Column 1 end -->
			</div>
			<div class="col2">
				<!-- Column 2 start -->
				<?php echo $this->element('menu');?>
				<!-- Column 2 end -->
			</div>
			<div class="col3">
				<!-- Column 3 start -->
				
				<div id="ads">
					<?php echo $this->element('cart');?>
				</div>
				<br></br>
				<?php echo $this->element('users/login_status'); ?>
				<br></br>
				<h2>Ad space</h2>
				<p>advertisement for sponsors</p>
				
				<?php ?>
			
				<!-- Column 3 end -->
			</div>
		</div>
	</div>
</div>
<div id="footer">
	<?php echo $html->link('Admin login', array('controller' => 'users', 'action' => 'admin_login', 'c' => $c, 'admin' => true));?>
	
	<?php echo $this->element('sql_dump');?>
</div>

</body>
</html>
