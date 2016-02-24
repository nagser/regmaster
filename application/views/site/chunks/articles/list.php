<?
if($image){
	$image = $this->gallery_model->thumbs_url.get_value($image, 'image');
} else {
	$image = base_url().Settings::get('gallery_no_image');
}
?>
<div class="row">
	<div class="article">
		<div class="col-sm-3"><a href="articles/<?= $categ_alias ?>/<?= $alias ?>"><img src="<?= $image?>" class="img-rounded img-responsive" alt=""></a></div>
		<div class="col-sm-9">
			<h3><a href="articles/<?= $categ_alias ?>/<?= $alias ?>"><?= $name ?></a></h3>
			<p><?= cute_text($preview, 200) ?></p>
			<p><a class="btn btn-default" href="articles/<?= $categ_alias ?>/<?= $alias ?>" role="button">Подробнее »</a></p>
		</div>
		<div class="clearfix"></div>
		<div class="col-sm-12"><hr /></div>
	</div>
</div>