<div class="posts form">
<?php echo $form->create('Post', array('type' => 'file'));?>
	<fieldset>
 		<legend><?php __('Add Post');?></legend>
	<?php
		echo $form->input('user_id');
		echo $form->input('title');
		echo $form->input('body');
		echo $form->input('Tag', array('multiple' => 'checkbox'));
		echo $this->element('attachments', array('plugin' => 'media', 'model' => 'Post'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Posts', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Tags', true), array('controller' => 'tags', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Tag', true), array('controller' => 'tags', 'action' => 'add')); ?> </li>
	</ul>
</div>
