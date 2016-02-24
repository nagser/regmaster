<?= $this->load->view('admin/chunks/header')?>
<?= $this->load->view('admin/chunks/menu')?>
	<div class="row content">
		<h3><?= isset($edit) ? 'Редактирование' : 'Добавление'?> статьи</h3>
		<hr />
		<?= show_message(validation_errors())?>
		<?= form_open('admin/article_edit', array('role' => 'form', 'class' => 'form-horizontal'))?>

		<ul class="nav nav-tabs" role="tablist">
			<li class="active"><a href="#main" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span> Основное</a></li>
			<li><a href="#seo" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-search"></span> Поисковая оптимизация</a></li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane active" id="main">
				<br />
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
					<label for="select1" class="col-sm-2 control-label">Категория</label>
					<div class="col-sm-10">
						<?= show_dropdown('category_id', $this->categs_model->as_list(), 'select1');?>
					</div>
				</div>
				<div class="form-group">
					<label for="input3" class="col-sm-2 control-label">Вступление</label>
					<div class="col-sm-10">
						<?= form_textarea(array('name' => 'preview', 'value' => set_value('preview'), 'id' => 'input3', 'placeholder' => 'Вступление', 'class' => 'form-control editor', 'rows' => '10'))?>
					</div>
				</div>
				<div class="form-group">
					<label for="input4" class="col-sm-2 control-label">Подробный текст</label>
					<div class="col-sm-10">
						<?= form_textarea(array('name' => 'text', 'value' => set_value('text'), 'id' => 'input4', 'placeholder' => 'Подробный текст', 'class' => 'form-control editor', 'rows' => '15'))?>
					</div>
				</div>
				<div class="col-sm-2"></div><?= form_checkbox('favorite', 1, set_checkbox('favorite', 1));?> В избранное<br />
				<div class="col-sm-2"></div><?= form_checkbox('publish', 1, set_checkbox('publish', 1));?> Опубликовано
				<div class="clearfix"></div>
			</div>
			<div class="tab-pane" id="seo">
				<br />
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
			</div>
		</div>
		<hr />
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<a href="admin/articles/" class="btn btn-default">Отмена</a>
				<button type="submit" class="btn btn-primary"><?= isset($edit) ? 'Редактировать' : 'Добавить'?></button>
			</div>
		</div>
		</form>
	</div>
<?= $this->load->view('admin/chunks/footer')?>