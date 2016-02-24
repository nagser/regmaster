<!DOCTYPE html>
<html lang="ru">
<head>
	<base href="<?= Settings::get('base_url') ?>" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title><?= Settings::get('site_name')?></title>
	<!-- HEAD JS LOAD -->
	<script src="templates/brutality/js/head.min.js"></script>
	<!-- Other JS -->
	<script>head.js(<?= Scripts::get()?>);</script>
	<link rel="stylesheet" href="templates/brutality/css/bootstrap.min.css">
	<link rel="stylesheet" href="templates/brutality/css/jquery.fileupload.css">
	<link rel="stylesheet" href="templates/brutality/css/bootstrap-dialog.min.css">
<!--	<link rel="stylesheet" href="templates/brutality/css/colorbox.css">-->
	<link rel="stylesheet" href="templates/brutality/css/jquery.fancybox.css">
	<link rel="stylesheet" href="templates/brutality/css/cropper.css">
	<link rel="stylesheet" href="templates/brutality/css/system.css">
</head>
<body>
