<?php 
/**
 * LIME SKLAD 2019
 * ©EMIL GASANOV
 * Версия для сотовых магазинов
 */

require_once 'function.php';
root_dir();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Lime Store</title>
	<link rel="icon" type="image/x-icon" href="img/favicon.ico">	
	<link rel="stylesheet" type="text/css" href="css/new_style.css">
	<link rel="stylesheet" type="text/css" href="css/print.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="js/jquery-3.3.1.min.js" defer=""></script>
	<script src="js/function.js" defer=""></script>
	<script src="js/print.min.js" defer=""></script>
	<script src="js/ajax.js" defer=""></script>
<!-- 	<script src="js/chart_loader.js"></script>
    <script type="text/javascript" src="./charts/loader.js"></script> -->
</head>
<body>

<div class="header-top-site flex-cntr">
	<div class="header-logo-wrp">
		<div class="header-logo-center">
			<a href="javascript:void(0);" class="header-logo-link">
				<span class="header-logo-bold-style flex-cntr">L</span>ime Store archive upd</a>
		</div>
	</div>
	<div class="author_info">
		<div class="link_to_site_info"><a href="http://lime-sklad.github.io/" target="_blank" class="link">lime-sklad.github.io</a></div>
		<span>©Emil (tel: 0504213635) <?php echo date("Y"); ?></span>
	</div>

	<div class="preloader">
		<?php echo get_preloader(); ?>
	</div>
</div>


<?php include (GET_ROOT_DIRS.'/core/main/update_check.php'); ?>