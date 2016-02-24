<?= $this->load->view('admin/chunks/header')?>
<?= $this->load->view('admin/chunks/menu')?>
<div class="row content">
	<h3><?= isset($edit) ? 'Редактирование' : 'Добавление'?> мета правила</h3>
	<hr />
	<?= show_message(validation_errors())?>
	<?= form_open('admin/meta_edit', array('role' => 'form', 'class' => 'form-horizontal'))?>
	<input type="hidden" name="id" value="<?= set_value('id')?>">
	<div class="form-group">
		<label for="input1" class="col-sm-2 control-label">Относительный путь</label>
		<div class="col-sm-10">
			<?= form_input(array('name' => 'path', 'value' => set_value('path'), 'id' => 'input1', 'placeholder' => 'Путь', 'class' => 'form-control'))?>
		</div>
	</div>
	<div class="form-group">
		<label for="input10" class="col-sm-2 control-label">Title</label>
		<div class="col-sm-10">
			<?= form_input(array('name' => 'seo_title', 'value' => set_value('seo_title'), 'id' => 'input10', 'placeholder' => 'Title', 'class' => 'form-control'))?>
		</div>
	</div>
	<div class="form-group">
		<label for="input11" class="col-sm-2 control-label">Keywords</label>
		<div class="col-sm-10">
			<?= form_input(array('name' => 'seo_keywords', 'value' => set_value('seo_keywords'), 'id' => 'input11', 'placeholder' => 'Keywords', 'class' => 'form-control'))?>
		</div>
	</div>
	<div class="form-group">
		<label for="input12" class="col-sm-2 control-label">Description</label>
		<div class="col-sm-10">
			<?= form_textarea(array('name' => 'seo_description', 'value' => set_value('seo_description'), 'id' => 'input12', 'placeholder' => 'Description', 'class' => 'form-control', 'rows' => '3'))?>
		</div>
	</div>
	<div class="clearfix"></div>
	<hr />
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<a href="admin/meta/" class="btn btn-default">Отмена</a>
			<button type="submit" class="btn btn-primary"><?= isset($edit) ? 'Редактировать' : 'Добавить'?></button>
		</div>
	</div>
	</form>
</div>
<?= $this->load->view('admin/chunks/footer')?>
