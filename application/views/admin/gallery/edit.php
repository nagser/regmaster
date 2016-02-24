<?= $this->load->view('admin/chunks/header')?>
<?= $this->load->view('admin/chunks/menu')?>
	<div class="row content">
		<h3><?= isset($edit) ? 'Редактирование' : 'Добавление'?> альбома</h3>
		<hr />
		<?= show_message(validation_errors())?>

<!--			<ul class="nav nav-tabs" role="tablist">-->
<!--				<li class="active"><a href="#main" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span> Альбом</a></li>-->
<!--				--><?//if(isset($edit)):?>
<!--					<li><a href="#images" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-picture"></span> Изображения</a></li>-->
<!--				--><?//endif?>
<!--			</ul>-->
		<?= form_open(base_url() . 'admin/album_edit', array('role' => 'form', 'class' => 'form-horizontal')) ?>
		<br/>
		<input type="hidden" name="id" class="album_id" value="<?= set_value('id') ?>">

		<div class="form-group">
			<label for="input1" class="col-sm-2 control-label">Название</label>

			<div class="col-sm-10">
				<?= form_input(array('name' => 'name', 'value' => set_value('name'), 'id' => 'input1', 'placeholder' => 'Название', 'class' => 'form-control friendly_url')) ?>
			</div>
		</div>
		<div class="form-group">
			<label for="friendly_url_title" class="col-sm-2 control-label">Псевдоним</label>

			<div class="col-sm-10">
				<?= form_input(array('name' => 'alias', 'value' => set_value('alias'), 'id' => 'friendly_url_title', 'placeholder' => 'Псевдоним', 'class' => 'form-control', 'readonly' => 'readonly')) ?>
			</div>
		</div>
		<div class="form-group">
			<label for="select1" class="col-sm-2 control-label">Категория</label>

			<div class="col-sm-10">
				<?= show_dropdown('category_id', $this->categs_model->as_list(), 'select1'); ?>
			</div>
		</div>
		<div class="form-group">
			<label for="input3" class="col-sm-2 control-label">Описание</label>

			<div class="col-sm-10">
				<?= form_textarea(array('name' => 'description', 'value' => set_value('description'), 'id' => 'input3', 'placeholder' => 'Описание', 'class' => 'form-control editor', 'rows' => '10')) ?>
			</div>
		</div>
		<div class="col-sm-2"></div><?= form_checkbox('public', 1, set_checkbox('public', 1)); ?> Опубликовано
		<div class="clearfix"></div>
		<hr/>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<a href="admin/gallery/" class="btn btn-default">Отмена</a>
				<button type="submit"
						class="btn btn-primary"><?= isset($edit) ? 'Редактировать' : 'Добавить' ?></button>
			</div>
		</div>
		</form>
	</div>
<?= $this->load->view('admin/chunks/footer')?>