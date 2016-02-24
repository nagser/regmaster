<?= $this->load->view('admin/chunks/header')?>
<?= $this->load->view('admin/chunks/menu')?>
    <div class="row content">
        <h3><a href="<?= base_url()?>admin/import"><span class="glyphicon glyphicon-upload"></span> Импорт</a></h3>
        <hr/>
		<?if($count):?>
			<div class="alert alert-info">
				Пользователей в базе: <?= $count?>
				<a class="delete btn btn-danger btn-sm" href="admin/users_delete">
					<span class="glyphicon glyphicon-remove"></span>
					Удалить всех пользователей
				</a>
				<hr>
				<form action="admin/users_import" method="get">
					<label for="visited_only"><input type="checkbox" name="visited_only" id="visited_only"> Только посетившие</label><br>

					<button class="btn btn-default" type="submit" name="route" value="users_import_excel">
						<span class="glyphicon glyphicon-upload"></span>
						Экспорт пользователей EXCEL
					</button>
					<button class="btn btn-default" type="submit" name="route" value="users_import_xml">
						<span class="glyphicon glyphicon-upload"></span>
						Экспорт пользователей XML
					</button>
				</form>
			</div>
		<?endif?>
		<div class="panel panel-default">
			<div class="panel-body">
				<?= form_open_multipart(base_url() . 'admin/import', array('role' => 'form', 'class' => 'form-horizontal')) ?>
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