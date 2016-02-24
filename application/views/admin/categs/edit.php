<?= $this->load->view('admin/chunks/header')?>
<?= $this->load->view('admin/chunks/menu')?>
<div class="row content">
	<h3><?= isset($edit) ? 'Редактирование' : 'Добавление'?> категории</h3>
	<hr />
	<?= show_message(validation_errors())?>
	<?= form_open('admin/categ_edit', array('role' => 'form', 'class' => 'form-horizontal'))?>
	<input type="hidden" name="id" value="<?= set_value('id')?>">
	<div class="form-group">
		<label for="input1" class="col-sm-2 control-label">Название</label>
		<div class="col-sm-10">
			<?= form_input(array('name' => 'name', 'value' => set_value('name'), 'id' => 'input1', 'placeholder' => 'Название', 'class' => 'form-control friendly_url'))?>
		</div>
	</div>
	<div class="form-group">
		<label for="friendly_url_title" class="col-sm-2 control-label">Псевдоним</label>
		<div class="col-sm-10">
			<?= form_input(array('name' => 'alias', 'value' => set_value('alias'), 'id' => 'friendly_url_title', 'placeholder' => 'Псевдоним', 'class' => 'form-control', 'readonly' => 'readonly'))?>
		</div>
	</div>
	<div class="form-group">
		<label for="input3" class="col-sm-2 control-label">Описание</label>
		<div class="col-sm-10">
			<?= form_textarea(array('name' => 'description', 'value' => set_value('description'), 'id' => 'input3', 'placeholder' => 'Описание', 'class' => 'form-control editor', 'rows' => '10'))?>
		</div>
	</div>
	<div class="col-sm-2"></div><?= form_checkbox('favorite', 1, set_checkbox('favorite', 1));?> В избранное<br />
	<div class="col-sm-2"></div><?= form_checkbox('publish', 1, set_checkbox('publish', 1));?> Опубликовано
	<div class="clearfix"></div>
	<hr />
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<a href="admin/categs/" class="btn btn-default">Отмена</a>
			<button type="submit" class="btn btn-primary"><?= isset($edit) ? 'Редактировать' : 'Добавить'?></button>
		</div>
	</div>
	</form>
</div>
<?= $this->load->view('admin/chunks/footer')?>
