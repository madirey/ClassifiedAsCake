<div class="register">
	<?php echo $form->create('User', array('action' => 'register')); ?>
		<?php echo $form->input('username'); ?>
		<?php echo $form->input('email'); ?>
		<?php echo $form->input('Location.zip_code'); ?>
		<?php echo $form->input('password'); ?>
		<?php echo $form->input('retypePassword', array('type' => 'password')); ?>
		<?php $this->requestAction('users/recaptcha'); ?>
		<?php echo $form->submit('Register'); ?>
	<?php echo $form->end(); ?>
</div>
