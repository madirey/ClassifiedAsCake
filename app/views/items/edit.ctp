<div class="items form">
<?php echo $form->create('Item');?>
	<fieldset>
 		<legend><?php __('Edit Item');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('user_id');
		echo $form->input('category_id');
		echo $form->input('name');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Item.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Item.id'))); ?></li>
		<li><?php echo $html->link(__('List Items', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Categories', true), array('controller'=> 'categories', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Category', true), array('controller'=> 'categories', 'action'=>'add')); ?> </li>
	</ul>
</div>
