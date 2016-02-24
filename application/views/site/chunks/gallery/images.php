<?if($images):?>
	<?foreach($images as $image):?>
		<div class="col-sm-3">
			<a href="<?= $this->gallery_model->resizes_url . get_value($image, 'image') ?>" class="colorbox fancybox img-rounded img-thumbnail" rel="gallery">
				<img src="<?= $this->gallery_model->thumbs_url . get_value($image, 'image') ?>" class="img-responsive" alt="">
			</a>
		</div>
	<?endforeach?>
<?endif?>
