<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<title><?php hybrid_document_title(); ?></title>

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<?php hybrid_head(); // Hybrid head hook ?>

<?php wp_head(); // WP head hook ?>

</head>

<body class="<?php hybrid_body_class(); ?>">

<div id="body-container">

	<?php hybrid_before_header(); // Before header hook ?>

	<div id="header-container">

		<div id="header">

			<?php hybrid_header(); // Header hook ?>

		</div>

	</div>

	<?php hybrid_after_header(); // After header hook ?>

	<div id="container">

		<?php hybrid_before_container(); // Before container hook ?>

		<div id="content">

			<?php hybrid_before_content(); // Before content loop ?>