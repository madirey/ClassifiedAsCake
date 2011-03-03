<div class="images-form">
	<?php echo $form->create('Image1', array('type' => 'file')); ?>
	<fieldset>
 		<legend><?php __('Add Image 1');?></legend>
		<?php echo $form->file('Image.filedata'); ?>
	</fieldset>
	<?php echo $form->end('Add Image');?>

	<?php echo $form->create('Image2', array('type' => 'file')); ?>
	<fieldset>
 		<legend><?php __('Add Image 2');?></legend>
		<?php echo $form->file('Image.filedata'); ?>
	</fieldset>
	<?php echo $form->end('Add Image');?>

	<?php echo $form->create('Image3', array('type' => 'file')); ?>
	<fieldset>
 		<legend><?php __('Add Image 3');?></legend>
		<?php echo $form->file('Image.filedata'); ?>
	</fieldset>
	<?php echo $form->end('Add Image');?>
</div>

<!--
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Items', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Categories', true), array('controller'=> 'categories', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Category', true), array('controller'=> 'categories', 'action'=>'add')); ?> </li>
	</ul>
</div>
-->
