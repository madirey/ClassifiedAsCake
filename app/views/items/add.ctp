<div class="items-form">
	<?php echo $form->create('Item', array('enctype' => 'multipart/form-data'));?>
		<fieldset>
			<ul>
				<li><?php echo $form->input('user_id', array('type' => 'hidden', 'value' => $user_id)); ?></li>
				<li><?php echo $form->input('category_id'); ?></li>
				<li><?php echo $form->input('name'); ?></li>
				<li><?php echo $form->input('description'); ?></li>
				<li><?php echo $form->input('price'); ?></li>
			</ul>
		</fieldset>
	<?php echo $form->end('Submit');?>
</div>
