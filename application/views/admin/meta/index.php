<?= $this->load->view('admin/chunks/header')?>
<?= $this->load->view('admin/chunks/menu')?>
	<div class="row content">
		<h3><a href="<?=base_url()?>admin/meta/"><span class="glyphicon glyphicon-search"></span> Мета правила</a></h3>
		<div class="well well-sm">
			<a href="admin/meta/add" class="text-left btn btn-default btn-block"><span class="glyphicon glyphicon-plus"></span> Добавить правило</a>
		</div>
		<?= show_message($form_success)?>
		<?if($list):?>
			<div class="list-group">
				<?foreach($list as $item):?>
					<li class="list-group-item" id="id_<?= get_value($item, 'id')?>">
						<a href="<?=base_url()?>admin/meta/edit/<?= get_value($item, 'id')?>">
							<?= get_value($item, 'path')?>
						</a>
						<a class="delete" href="<?=base_url()?>admin/meta_delete/<?= get_value($item, 'id')?>">
							<span class="glyphicon glyphicon-remove pull-right"></span>
						</a>
					</li>
				<?endforeach?>
			</div>
		<?endif?>
	</div>
<?= $this->load->view('admin/chunks/footer')?>