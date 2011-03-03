<div class="login">
	Please enter a valid username/password combination and click 'Login'.
	<br/><br/>
	<?php echo $form->create('User', array('action' => 'login')); ?>
		<?php echo $form->input('username'); ?>
		<?php echo $form->input('password'); ?>
		<?php echo $form->submit('Login'); ?>
	<?php echo $form->end(); ?>
</div>
