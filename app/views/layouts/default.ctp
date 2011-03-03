<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $title_for_layout; ?> | Monetize My Car</title>
	<meta name="keywords" content="monetize,car,ads,vehicle,vinyl,wrap,make money,free money" />
	<meta name="description" content="Make money by displaying ads on your vehicle!" />
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<?php echo $scripts_for_layout; ?>
	<?php echo $html->css('default'); ?>
</head>

<body>
	<!-- start container -->
	<div id="container">

	<!-- start header -->
	<div id="header">
		<div id="header-left">
		</div>

		<div id="header-right">
			<?php echo $html->image('logo_text.png', array('alt' => 'monetizemycar.com')); ?>

			<!-- start menu -->
			<div id="menu">
				<ul>
					<li class="current_page_item" id="active"><?php echo $html->link('Home', array('controller' => 'items', 'action' => 'index', 'admin' => 0)); ?></li>
					<li><?php echo $html->link('Post', array('controller' => 'items', 'action' => 'add', 'admin' => 0)); ?></li>
					<li><?php echo $html->link('Search', array('controller' => 'items', 'action' => 'search', 'admin' => 0)); ?></li>
					<li><?php echo $admin->showLoginLogout(); ?></li>
					<li><?php echo $admin->showRegister(); ?></li>
				</ul>
			</div>
			<!-- end menu -->
		</div>

		<div id="menu-bar">
			<!-- nothing here -->
		</div>
	</div>
	<!-- end header -->

	<!-- start page -->
	<div id="page">

		<!-- start sidebar -->
		<div id="sidebar">
			<ul>
				<li id="categories">
					<h2>Categories</h2>
					<?php echo $categoryMenu->display($categoryList); ?>
				</li>
				<li id="meta">
					<h2>Support</h2>
					<ul>
						<li><?php echo $html->link('About', array('controller' => 'pages', 'action' => 'about', 'admin' => 0)); ?></li>
						<?php echo $admin->showAdminLink($showAdminLink); ?>
						<li><?php echo $html->link('Contact', array('controller' => 'pages', 'action' => 'contact', 'admin' => 0)); ?></li>
						<li><?php echo $html->link('Donate', array('controller' => 'pages', 'action' => 'donate', 'admin' => 0)); ?></li>
						<li><?php echo $html->link('FAQ', array('controller' => 'pages', 'action' => 'faq', 'admin' => 0)); ?></li>
						<li><?php echo $html->link('Privacy Policy', array('controller' => 'pages', 'action' => 'privacy', 'admin' => 0)); ?></li>
						<li><?php echo $html->link('Terms of Use', array('controller' => 'pages', 'action' => 'terms', 'admin' => 0)); ?></li>
					</ul>
				</li>
			</ul>
		</div>
		<!-- end sidebar -->

		<!-- start content -->
		<div id="content">
			<div class="post">
				<div class="entry">
					<?php $session->flash(); ?>
					<h2 style="margin-bottom: 10px;"><?php echo $title_for_layout; ?></h2>
					<?php echo $content_for_layout; ?> 
				</div>
			</div>
		</div>
		<!-- end content -->
	</div>
	<!-- end page -->

	<!-- start footer -->
	<div id="footer">
		<p class="legal">
			&copy;2009 MonetizeMyCar.com - All Rights Reserved.
			&nbsp;&nbsp;&bull;&nbsp;&nbsp;
			<a href="http://validator.w3.org/check/referer" class="css" title="This page validates as XHTML">Valid <abbr title="Extensible Hypertext Markup Language">XHTML</abbr></a>
			&nbsp;&bull;&nbsp;
			<a href="http://jigsaw.w3.org/css-validator/check/referer" class="css" title="This page validates as CSS">Valid <abbr title="Cascading Style Sheets">CSS</abbr></a>
		</p>
	</div>
	<!-- end footer -->

	</div>
	<!-- end container -->

</body>
</html>
