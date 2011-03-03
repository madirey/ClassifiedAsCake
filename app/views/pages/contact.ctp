If you have a question, please first check the <?php echo $html->link('FAQ', array('controller' => 'pages', 'action' => 'faq')); ?>. 
<br/><br/>
If you can't find what you need there, feel free to use the form below to contact technical support.
We will do everything in our power to resolve your problems promptly and reliably.  Thank you!
<br/><br/><br/>

<div class="contact-form">
	<?php echo $form->create('Page', array('action' => 'contact')); ?>
		<fieldset>
			<ul>
				<?php if(!isset($me)) { ?>
				<li><?php echo $form->input('email', array('label' => 'Your e-mail address', 'type' => 'text', 'value' => '')); ?></li>
				<?php } ?>
				<li><?php echo $form->input('subject', array('type' => 'text', 'value' => '')); ?></li>
				<li><?php echo $form->input('body', array('label' => 'Message', 'type' => 'textarea')); ?></li>
			</ul>
		</fieldset>
	<?php echo $form->end('Submit');?>
</div>
