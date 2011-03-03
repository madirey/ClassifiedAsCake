<div class="search-form">
	Enter a value in the 'Search String' box and click 'Submit'.
	<br/><br/>

	<?php echo $form->create('Item', array('action' => '/index'));?>
		<fieldset>
			<ol>
				<label for="searchString">Search String:</label>
				<input name="data[Item][searchString]" type="text" value="" id="searchString" />
			</ol>
		</fieldset>
	<?php echo $form->end('Submit');?>
</div>
