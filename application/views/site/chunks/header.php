<!DOCTYPE html>
<html lang="ru">
<head>
	<?= $this->load->view('site/chunks/meta/index')?>
	<base href="<?= Settings::get('base_url') ?>" />
    <!-- HEAD JS LOAD -->
    <script src="templates/brutality/js/head.min.js"></script>
    <!-- Other JS -->
    <script>head.js(<?= Scripts::get()?>);</script>
	<link rel="stylesheet" href="templates/brutality/css/bootstrap.min.css">
	<link rel="stylesheet" href="templates/brutality/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="templates/brutality/css/jquery.fancybox.css">
	<link rel="stylesheet" href="templates/brutality/css/selectize.css">
	<link rel="stylesheet" href="templates/brutality/css/style.css">
</head>
<body>
<div class="container">