<?= $this->load->view('admin/chunks/header')?>
<?= $this->load->view('admin/chunks/menu')?>
	<div class="row content">
		<h3><a href="<?= base_url()?>admin/categs_import"><span class="glyphicon glyphicon-upload"></span> Импорт категорий</a></h3>
		<hr/>
		<?if($count):?>
			<div class="alert alert-info">
				Специальностей в базе: <?= $count?>
				<p>
					<a class="delete btn btn-danger" href="admin/categs_delete">
						<span class="glyphicon glyphicon-remove"></span>
						Удалить все специальности
					</a>
				</p>
			</div>
		<?endif?>
		<div class="panel panel-default">
			<div class="panel-body">
				<?= form_open_multipart(base_url() . 'admin/import_categs', array('role' => 'form', 'class' => 'form-horizontal')) ?>
				<div class="col-sm-12">
					<div class="form-group">
						<input name="file" type="file"/>
					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit">Загрузить</button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
<?= $this->load->view('admin/chunks/footer')?>