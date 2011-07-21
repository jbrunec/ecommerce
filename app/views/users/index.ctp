<h2>User index Page</h2>
<dl>
  <dt> Email:</dt>  <dd> <?php echo $session->read('Auth.User.email'); ?> </dd>
  <dt> last login:</dt> <dd> <?php echo $session->read('Auth.User.user_last_login'); ?></dd>
</dl>
