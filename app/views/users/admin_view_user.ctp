<div class="users view">
<h2><?php  __('User');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>>id</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>First Name:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['first_name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Last Name:</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['last_name']; ?>
			&nbsp;
		</dd>
	</dl>
	<div class="actions">
    	<h3><?php __('Actions'); ?></h3>
    	<ul>
    		<li><?php echo $this->Html->link(__('Edit User', true), array('action' => 'admin_edit_user', $user['User']['id'])); ?> </li>
    		<li><?php echo $this->Html->link(__('Delete User', true), array('action' => 'admin_delete_user', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> </li>
    	</ul>
	</div>
</div>

