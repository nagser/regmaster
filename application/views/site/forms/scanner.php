<?= $this->load->view('site/chunks/header') ?>
<?= $this->load->view('site/chunks/menu') ?>

	<div class="row">
		<div class="alert alert-info">
			Пожалуйста, отсканируйте штрихкод
		</div>
		<div class="col-sm-12">
			<?= form_open(base_url().'forms/scanner', array('role' => 'form', 'class' => 'form-horizontal')) ?>
				<div class="form-group">
					<input type="text" name="hash" class="form-control" autofocus="autofocus"/>
				</div>
			</form>
		</div>
	</div>


<?= $this->load->view('site/chunks/footer') ?>