<?= $this->load->view('site/chunks/header') ?>
<?= $this->load->view('site/chunks/menu') ?>

<div class="row">
		<div class="col-sm-12">
			<?= breadcrumbs::get() ?>
		</div>
		<div class="article">
			<div class="col-sm-12">
				<h1><?= get_value($article, 'name') ?></h1>
			</div>
			<?= $this->load->view('site/chunks/gallery/images', array('images' => $images))?>
			<div class="clearfix"></div>
			<div class="col-sm-12">
				<p><?= get_value($article, 'text') ?></p>
			</div>
		</div>
</div>

<?= $this->load->view('site/chunks/footer') ?>