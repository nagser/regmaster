<?= $this->load->view('site/chunks/header') ?>
<?= $this->load->view('site/chunks/menu') ?>

	<div class="well well-sm">
		<a class="btn btn-lg btn-block btn-primary" href="<?= base_url().'forms/scanner'?>">Сканировать</a>
	</div>
	<div class="well well-sm">
		<a class="btn btn-lg btn-block btn-primary" href="<?= base_url().'forms'?>">Новая регистрация</a>
	</div>
	<?if(Settings::get('event_city') OR Settings::get('event_date')):?>
		<div class="well well-sm">
			<?= Settings::get('event_date')?>
			<div class="pull-right">
				<?= Settings::get('event_city')?>
			</div>
		</div>
	<?endif?>

<?= $this->load->view('site/chunks/footer') ?>