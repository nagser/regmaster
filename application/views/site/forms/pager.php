<?= $this->load->view('site/chunks/header') ?>
<?= $this->load->view('site/chunks/menu') ?>

	<div class="row">
        <form method="get">
            <div class="col-sm-10">
                <?= form_input(array('name' => 'search_text', 'value' => $this->input->get('search_text'), 'id' => 'search_text', 'placeholder' => 'ФИО или номер пульта', 'class' => 'form-control'))?>
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary btn-block" type="submit"><span class="glyphicon glyphicon-search"></span> Поиск</button>
            </div>
        </form>
		<div class="clearfix"></div>
		<br>
		<div class="col-sm-12">
			<?if($list):?>
				<table class="table table-bordered table-striped">
					<?foreach ($list as $item):?>
						<tr id="id_<?= get_value($item, 'id') ?>">
							<td><a href="forms/view/<?= $item->id?>"><?= $item->full_name?></a></td>
							<td class="min-width">
								<a class="btn btn-small btn-danger delete" href="forms/user_delete/<?= $item->id ?>/users">
									<span class="glyphicon glyphicon-remove"></span>
								</a>
							</td>
						</tr>
					<?endforeach?>
				</table>
				<?= $this->pagination->create_links() ?>
			<?else:?>
				<p>Нет данных</p>
			<?endif?>
		</div>
	</div>

<?= $this->load->view('site/chunks/footer') ?>