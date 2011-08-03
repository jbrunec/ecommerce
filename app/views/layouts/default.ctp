<?php debug($session->read());
//debug($this->params);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-GB">
<head>
	
	<?php echo $this->Html->charset(); ?>
	<title>
		Ecommerce shop!
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

		echo $this->Html->css('costum');
		echo $this->Html->css('jquery.lightbox-0.5');
		echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js');
		echo $this->Html->script('jquery');
		echo $this->Html->script('jquery.lightbox-0.5');
		/*echo $this->Html->script('jquery.lightbox-0.5.min');
		echo $this->Html->script('jquery.lightbox-0.5.pack');*/
		echo $scripts_for_layout;
	?>
</head>
<body>

<div id="header">
	<p><a href="http://matthewjamestaylor.com/blog/perfect-multi-column-liquid-layouts" title="Perfect multi-column liquid layouts - iPhone compatible">&laquo; Back to the CSS article</a> by <a href="http://matthewjamestaylor.com">Matthew James Taylor</a></p>
	<h1>The Perfect 3 Column Liquid Layout (Percentage widths)</h1>
	<h2>No CSS hacks. SEO friendly. No Images. No JavaScript. Cross-browser &amp; iPhone compatible.</h2>
	<ul>
		<li><a href="http://localhost/ecommerce/" class="active">3 Column <span>Holy Grail</span></a></li>
		<li><a href="http://localhost/ecommerce/users/login">Users <span>Login!</span></a></li>
		<li><a href="http://localhost/ecommerce/users/index">Your <span>Account</span></a></li>
		<li><a href="http://matthewjamestaylor.com/blog/perfect-2-column-right-menu.htm">2 Column <span>Right Menu</span></a></li>
		<li><a href="http://matthewjamestaylor.com/blog/perfect-2-column-double-page.htm">2 Column <span>Double Page</span></a></li>
		<li><a href="http://matthewjamestaylor.com/blog/perfect-full-page.htm">1 Column <span>Full Page</span></a></li>
		<li><a href="http://matthewjamestaylor.com/blog/perfect-stacked-columns.htm">Stacked <span>columns</span></a></li>
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
				<h2>Browser Compatibility</h2>
				<p>This 3 column liquid Layout has been tested on the following browsers:</p>
				<h3>iPhone &amp; iPod Touch</h3>
				<?php ?>
			
				<!-- Column 3 end -->
			</div>
		</div>
	</div>
</div>
<div id="footer">
	<?php echo $html->link('Admin login', array('controller' => 'users', 'action' => 'admin_login', 'c' => $c, 'admin' => true));?>
	<p>This page uses the <a href="http://matthewjamestaylor.com/blog/perfect-3-column.htm">Perfect 'Holy Grail' 3 Column Liquid Layout</a> by <a href="http://matthewjamestaylor.com">Matthew James Taylor</a>. View more <a href="http://matthewjamestaylor.com/blog/-website-layouts">website layouts</a> and <a href="http://matthewjamestaylor.com/blog/-web-design">web design articles</a>.</p>
	<?php echo $session->flash('email');?>
	<?php echo $this->element('sql_dump');?>
</div>

</body>
</html>
