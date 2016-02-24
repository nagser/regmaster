<?= $this->load->view('admin/chunks/header')?>
<?= $this->load->view('admin/chunks/menu')?>
	<div class="row content">

		<h3><?= isset($edit) ? 'Редактирование' : 'Добавление'?> параметра</h3>
		<hr />
		<?= show_message(validation_errors())?>
		<form class="form-horizontal" role="form" method="post">
			<input type="hidden" name="id" value="<?php echo set_value('id'); ?>">
			<div class="form-group">
				<label for="input1" class="col-sm-2 control-label">Название параметра</label>
				<div class="col-sm-10">
					<?= form_input(array('name' => 'name', 'value' => set_value('name'), 'id' => 'input1', 'placeholder' => 'Название', 'class' => 'form-control'))?>
				</div>
			</div>
			<div class="form-group">
				<label for="select1" class="col-sm-2 control-label">Тип параметра</label>
				<div class="col-sm-10">
					<?= show_dropdown('type', $this->settings_model->types, 'input2');?>
				</div>
			</div>
			<div class="form-group">
				<label for="input3" class="col-sm-2 control-label">Значение</label>
				<div class="col-sm-10">
					<?= $this->settings_model->show_form_by_type(set_value('type'), array('name' => 'value', 'value' => set_value('value'), 'id' => 'input3', 'placeholder' => 'Значение'))?>
				</div>
			</div>
			<div class="form-group">
				<label for="input4" class="col-sm-2 control-label">Описание</label>
				<div class="col-sm-10">
					<?= form_input(array('name' => 'description', 'value' => set_value('description'), 'id' => 'input4', 'placeholder' => 'Описание', 'class' => 'form-control'))?>
				</div>
			</div>
			<hr />
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<a href="admin/settings/" class="btn btn-default">Отмена</a>
					<button type="submit" class="btn btn-primary"><?= isset($edit) ? 'Редактировать' : 'Добавить'?></button>
				</div>
			</div>
		</form>
	</div>
<?= $this->load->view('admin/chunks/footer')?>