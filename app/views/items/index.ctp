<!-- Put keywords into alt tags for SEO (charge for this?) -->

<?php $paginator->options(array('url' => $this->passedArgs)); ?>

<div class="items-list">
	<div class="paging_top">
	<?php echo $paginator->counter(array('format' =>
		'Results <span class="bold">%start% - %end%</span> of <span class="bold">%count%</span>'));
	?>
	</div>

	<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<th/>
			<th><?php echo $paginator->sort('name');?></th>
			<!--
			<th><?php echo $paginator->sort('description');?></th>
			-->
			<th><?php echo $paginator->sort('category_id');?></th>
			<th><?php echo $paginator->sort('price');?></th>
			<th><?php echo $paginator->sort('created');?></th>
			<?php $remoteUser = $session->read('User'); if(isset($remoteUser)) { ?>
			<th><?php echo $paginator->sort('Distance', 'dist'); ?></th>
			<?php } ?>
		</tr>

		<?php
		$i = 0;
		foreach ($items as $item):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		?>

		<tr<?php echo $class;?>>
			<td>
				<?php echo $image->showImage($item['Image'], $item['Item']['id']); ?>
			</td>
			<td>
				<?php echo $html->link($item['Item']['name'], array('controller' => 'items', 'action' => 'view', $item['Item']['id'])); ?>
			</td>
			<!--
			<td>
				<?php echo $item['Item']['description']; ?>
			</td>
			-->
			<td>
				<?php echo $html->link($item['Category']['name'], array('controller'=> 'items', 'action'=>'index', 'c='.$item['Category']['id'])); ?>
			</td>
			<td>
				$<?php echo $item['Item']['price']; ?>
			</td>
			<td>
				<?php echo date('d M Y', strtotime($item['Item']['created'])); ?><br/>
				<?php echo date('H:i', strtotime($item['Item']['created'])); ?>
			</td>
			<?php $remoteUser = $session->read('User'); if(isset($remoteUser)) { ?>
			<td>
				<?php printf("%.1f miles", $item['Distance']['distance']); ?>
			</td>
			<?php } ?>
		</tr>
		<?php endforeach; ?>
	</table>
</div>

<div class="paging_bottom">
	<?php
		echo $paginator->prev('Previous', array(), null, array('class'=>'disabled'));
		echo '&nbsp;&nbsp;&nbsp;';
		echo $paginator->numbers();
		echo '&nbsp;&nbsp;&nbsp;';
		echo $paginator->next('Next', array(), null, array('class'=>'disabled'));
	?>
</div>
