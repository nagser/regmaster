<?= $this->load->view('site/chunks/header') ?>
<?= $this->load->view('site/chunks/menu') ?>

	<div class="row">
		<div class="col-sm-12">
			<? if ($user): ?>
				<div class="panel panel-default">
					<div class="panel-heading">
						Данные о пользователе
						<? if (is_admin()): ?>
							<a href="<?= base_url() ?>forms/edit/<?= $user->id ?>"
							   class="btn btn-primary btn-xs">Редактировать</a>
						<? endif ?>
					</div>
					<div class="panel-body">
						<table style="margin-top: 10px;" class="table table-bordered table-striped">
							<? foreach ($form as $item): ?>
								<tr>
									<td><b><?= $item->name ?></b></td>
									<td><?= get_value($user, $item->alias) ?></td>
								</tr>
							<? endforeach ?>
						</table>
						<? foreach ($this->printer_model->themes_as_list() as $id => $theme): ?>
							<!-- Если тема уже была распечатана выводим красную кнопку с предупреждением -->
							<?if(get_value($print_history, $id)):?>
								<a class="btn-danger btn" href="<?= base_url() ?>forms/view/<?= $user->id ?>/?&theme=<?= $id ?>"><i class="glyphicon glyphicon-ban-circle"></i> <?= $theme ?> (Выдан)</a>
							<?else:?>
								<a class="btn-primary btn" href="<?= base_url() ?>forms/view/<?= $user->id ?>/?&theme=<?= $id ?>"><?= $theme ?></a>
							<?endif?>

						<? endforeach ?>
					</div>
				</div>
			<? else: ?>
				<?= show_message('Нет данных') ?>
			<?endif ?>
		</div>
	</div>

<?= $this->load->view('site/chunks/footer') ?>