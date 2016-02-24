<?= $this->load->view('admin/chunks/header')?>
<?= $this->load->view('admin/chunks/menu')?>
	<div class="row content">
		<h3><a href="<?= base_url()?>admin/categs"><span class="glyphicon glyphicon-th"></span> Категории</a></h3>
		<div class="well well-sm">
			<a href="admin/categs/add" class="text-left btn btn-default btn-block"><span class="glyphicon glyphicon-plus"></span> Добавить категорию</a>
		</div>
		<?= show_message($form_success)?>
		<?if($list):?>
			<div class="list-group">
				<?foreach($list as $item):?>
					<li class="list-group-item" id="id_<?= get_value($item, 'id')?>">
						<a href="admin/categs/edit/<?= $item->id?>">
							<?= $item->name?>
						</a>
						<?if(get_value($item, 'favorite')):?>
							<span class="label label-primary">Избранная</span>
						<?endif?>
						<?if(!get_value($item, 'publish')):?>
							<span class="label label-danger">Неопубликована</span>
						<?endif?>
						<a class="delete" href="admin/categ_delete/<?= $item->id?>">
							<span class="glyphicon glyphicon-remove pull-right"></span>
						</a>
					</li>
				<?endforeach?>
			</div>
		<?endif?>
	</div>
<?= $this->load->view('admin/chunks/footer')?>