<?php //debug($this->params['requested'])?>
<h2>Welcome Administrator <?php echo $session->read('Auth.User.email')?>!</h2>

<div class="actions">
	<?php echo $html->link('Add product',array('controller' => 'products', 'action' => 'admin_add_product', 'admin' => true));?>
	<?php echo $html->link('logout', array('controller' => 'users', 'action' => 'admin_logout', 'admin' => true));?>
</div>