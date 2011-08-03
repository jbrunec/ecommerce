<?php //debug($this->Paginator)?>
<h2>User Index Page</h2>
<br>
<dl>
  <dt><span style="background: #82CAFF;">Login details:</span></dt> 
  <dd>
      <?php echo $form->create('User', array('controller' => 'users', 'action' => 'changeUserPassword'))?>
      <?php echo $form->hidden('User.id',array('value' => $session->read('Auth.User.id')));?> 
      <?php echo $form->end('change password');?>
  </dd>
  
  <dt class="altrow"> Email:</dt>  <dd> <?php echo $session->read('Auth.User.email'); ?> </dd>
  <dt> Last login:</dt> <dd> <?php echo $session->read('Auth.User.user_last_login'); ?></dd>
  <dt class="altrow"> Date registered:</dt>  <dd> <?php echo $session->read('Auth.User.reg_date'); ?> </dd>
  <br>
  <dt><span style="background: #82CAFF;">Address:</span></dt>
  <dd>
      <?php echo $form->create('User', array('controller' => 'users', 'action' => 'changeUserPassword'))?>
      <?php echo $form->hidden('User.id',array('value' => $session->read('Auth.User.id')));?> 
      <?php echo $form->end('change address');?>
  </dd>
  <dt class="altrow"> First name:</dt> <dd> <?php echo $session->read('Auth.User.first_name'); ?></dd>
  <dt> Last name:</dt>  <dd> <?php echo $session->read('Auth.User.last_name'); ?> </dd>
  <dt class="altrow"> Phone number:</dt> <dd> <?php echo $session->read('Auth.User.phone_number'); ?></dd>
  <dt> Address:</dt>  <dd> <?php echo $session->read('Auth.User.address'); ?> </dd>
  <dt class="altrow"> Postal code:</dt> <dd> <?php echo $session->read('Auth.User.postal_code'); ?></dd>
  <dt> City:</dt> <dd> <?php echo $session->read('Auth.User.city'); ?></dd>
</dl>
<hr>

<h3>Your recent orders:</h3>
<br>
<?php echo $this->element('/orders/get_user_orders');?>