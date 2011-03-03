<?php
echo '{"totalRecords":' . $total.',
		"recordsReturned":' . $page_size.',
		"records":' . $javascript->Object($item_list).'}';
?>
