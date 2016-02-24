<?= $this->load->view('admin/chunks/header') ?>
<?= $this->load->view('admin/chunks/menu') ?>
<div class="row content">
	<h3>Изображения</h3>
	<hr/>
	<?= form_open_multipart(base_url() . 'admin/album_upload/'.$id.'/'.$component, array('role' => 'form', 'class' => 'form-horizontal', 'id' => 'gallery_upload')) ?>
	<br/>

	<div class="well well-sm">
		<?= form_input(array('name' => 'file', 'id' => 'input10', 'placeholder' => 'Изображения', 'class' => 'form-control file-control', 'type' => 'file', 'multiple' => 'multiple')) ?>
	</div>
	<div class="clearfix"></div>
    <div id="thumbs">
	<? if (count($images)): ?>
		<h3>Изображения в альбоме</h3>
		<hr/>
	    <div class="row sortable" data-url="<?= base_url() . 'admin/sort_images/'.$id.'/'.$component ?>">
			<? foreach ($images as $image): ?>
				<div class="col-sm-6 col-md-4 col-xs-12 col-lg-3" id="id_<?= get_value($image, 'id') ?>">
					<div class="thumbnail">
						<a href="<?= $this->gallery_model->resizes_url . get_value($image, 'image') ?>" class="colorbox fancybox" rel="gallery">
							<img src="<?= $this->gallery_model->thumbs_url . get_value($image, 'image') ?>" alt="">
						</a>
						<div class="caption">
							<p class="text-center">
								<a class="btn btn-sm btn-danger delete_image"
									href="<?= base_url() . 'admin/delete_image/' . get_value($image, 'id') ?>"
									data-id="<?= get_value($image, 'id') ?>"><span class="glyphicon glyphicon-remove"></span> Удалить</a>
								<a href="#" data-image="<?= $this->gallery_model->resizes_url . get_value($image, 'image') ?>" class="btn btn-sm btn-default edit_image"
									data-id="<?= get_value($image, 'id') ?>"
									data-url="<?= base_url() . 'admin/cropp_image/' . get_value($image, 'id') ?>"><span class="glyphicon glyphicon-edit"></span> Редактировать</a>
							</p>
						</div>
					</div>
				</div>
			<? endforeach ?>
		</div>
	<? endif ?>
    </div>
	<div class="clearfix"></div>
	</form>
</div>
<?= $this->load->view('admin/chunks/footer') ?>














<? if (isset($edit)): ?>
	<div class="tab-pane" id="images">

	</div>
<? endif ?>

</form>