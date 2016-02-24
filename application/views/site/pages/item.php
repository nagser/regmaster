<?= $this->load->view('site/chunks/header') ?>
<?= $this->load->view('site/chunks/menu') ?>

	<div class="row">
		<div class="col-sm-12">
			<?= breadcrumbs::get() ?>
		</div>
		<div class="page">
			<div class="col-sm-12">
				<h1><?= $name ?></h1>
				<p><?= $text ?></p>
			</div>
		</div>
	</div>

<?= $this->load->view('site/chunks/footer')?>