<div class="items-response-form">
	<?php echo $form->create('Item', array('action' => '/respond')); ?>
		<fieldset>
			<ul>
				<li><?php echo $form->input('item_id', array('type' => 'hidden', 'value' => $item['Item']['id'])); ?></li>
				<?php if($notLoggedIn) { ?>
				<li><?php echo $form->input('email', array('label' => 'Your email address', 'type' => 'text')); ?></li>
				<?php } ?>
				<li><?php echo $form->input('subject', array('type' => 'text', 'value' => $item['Item']['name'])); ?></li>
				<li><?php echo $form->input('body', array('type' => 'textarea')); ?></li>
			</ul>
		</fieldset>
	<?php echo $form->end('Submit');?>
</div>
