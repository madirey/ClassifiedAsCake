<div id="image-upload">
	<h2>Add Images</h2>
	<?php echo $html->link('Skip', array('controller' => 'items', 'action' => 'index')); ?>
	<?php echo $form->create('Image', array('enctype' => 'multipart/form-data'));?>
		<fieldset>
 			<legend><?php __('Add Image');?></legend>
			<?php echo $form->file('Image.data'); ?>
		</fieldset>
	<?php echo $form->end('Submit');?>
</div>
