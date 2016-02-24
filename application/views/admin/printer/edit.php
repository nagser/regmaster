<?= $this->load->view('admin/chunks/header') ?>
<?= $this->load->view('admin/chunks/menu') ?>
	<div class="row content">
		<h3><?= isset($edit) ? 'Редактирование' : 'Добавление' ?> статьи</h3>
		<hr/>
		<?= show_message(validation_errors()) ?>
		<?= form_open(base_url().'admin/themes_edit', array('role' => 'form', 'class' => 'form-horizontal')) ?>

		<br/>
		<input type="hidden" name="id" value="<?= set_value('id') ?>">

		<div class="form-group">
			<label for="input1" class="col-sm-2 control-label">Название</label>

			<div class="col-sm-10">
				<?= form_input(array('name' => 'name', 'value' => set_value('name'), 'id' => 'input1', 'placeholder' => 'Название', 'class' => 'form-control friendly_url')) ?>
			</div>
		</div>
		<div class="form-group">
			<label for="input3" class="col-sm-2 control-label">Макет</label>
			<div class="col-sm-10">
				<?= form_textarea(array('name' => 'text', 'value' => set_value('text'), 'id' => 'input3', 'placeholder' => 'Макет', 'class' => 'form-control editor', 'rows' => '10')) ?>
			</div>
		</div>
		<div class="col-sm-2"></div><?= form_checkbox('active', 1, set_checkbox('active', 1)); ?> Активен
		<div class="clearfix"></div>
		<hr/>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<a href="admin/themes/" class="btn btn-default">Отмена</a>
				<button type="submit"
						class="btn btn-primary"><?= isset($edit) ? 'Редактировать' : 'Добавить' ?></button>
			</div>
		</div>
		</form>
	</div>
<?= $this->load->view('admin/chunks/footer') ?>