<?= $this->load->view('admin/chunks/header')?>
<?= $this->load->view('admin/chunks/menu')?>
	<div class="row content">
		<h3><a href="<?= base_url()?>admin/settings"><span class="glyphicon glyphicon-cog"></span> Настройки сайта</a></h3>
		<div class="well well-sm">
			<a href="admin/settings/add" class="text-left btn btn-default btn-block"><span class="glyphicon glyphicon-plus"></span> Добавить параметр</a>
		</div>
		<?= show_message($form_success)?>
		<?if($list):?>
			<div class="list-group">
				<?foreach($list as $item):?>
					<li class="list-group-item" id="id_<?= get_value($item, 'id')?>">
						<a href="admin/settings/edit/<?= $item['id']?>">
							<b><?= $item['name']?></b>
							<?= $item['description'] ? '('.$item['description'].')':''?>
							<span class="label label-default"><?= $item['type']?></span>
						</a>
						<a class="delete" href="admin/setting_delete/<?= $item['id']?>">
							<span class="glyphicon glyphicon-remove pull-right"></span>
						</a>
					</li>
				<?endforeach?>
			</div>
		<?endif?>
	</div>
<?= $this->load->view('admin/chunks/footer')?>