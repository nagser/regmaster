<?= $this->load->view('admin/chunks/header')?>
<?= $this->load->view('admin/chunks/menu')?>
	<div class="row content">
		<h3><a href="<?= base_url()?>admin/gallery"><span class="glyphicon glyphicon-camera"></span> Альбомы</a></h3>
		<div class="well well-sm">
			<a href="admin/gallery/add" class="text-left btn btn-default btn-block"><span class="glyphicon glyphicon-plus"></span> Добавить альбом</a>
		</div>
		<?= show_message($form_success) ?>
		<? if ($list): ?>
			<div class="panel panel-default">
				<table class="table table-bordered">
					<? foreach ($list as $item): ?>
						<tr id="id_<?= get_value($item, 'id') ?>">
							<td>
								<a href="admin/gallery/edit/<?= $item->id ?>">
									<?= $item->name ?>
								</a>
							</td>
							<td class="min-width">
								<a class="btn btn-small btn-primary upload" href="admin/gallery/images/<?= $item->id ?>/gallery">
									<span class="glyphicon glyphicon-picture"></span>
								</a>
								<a class="btn btn-small btn-danger delete" href="admin/album_delete/<?= $item->id ?>/gallery">
									<span class="glyphicon glyphicon-remove"></span>
								</a>
							</td>
						</tr>
					<? endforeach ?>
				</table>
			</div>
		<? endif ?>
	</div>
<?= $this->load->view('admin/chunks/footer')?>