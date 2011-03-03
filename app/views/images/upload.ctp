<h2>Upload An Image</h2>
<form action="<?php echo $html->url('/images/upload'); ?>" method="post" enctype="multipart/form-data">
	<fieldset>
		<legend>
			Images
		</legend>
		<ul>
			<li>
				<?php echo $form->create('Image', array('type' => 'file')); ?>
				<?php echo $form->file('Image.filedata'); ?>
			</li>
		</ul>
	</fieldset>
	<p><input type="submit" name="add" value="Add Image" /></p>
</form>

