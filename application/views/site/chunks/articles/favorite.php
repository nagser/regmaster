<?
	if($image){
		$image = $this->gallery_model->thumbs_url.get_value($image, 'image');
	} else {
		$image = base_url().Settings::get('gallery_no_image');
	}
?>
<a href="<?= base_url()?>articles/<?= $categ_alias?>/<?= $alias ?>"><img src="<?= $image?>" class="img-rounded img-responsive" alt=""/></a>
<h3><a href="articles/<?= $categ_alias?>/<?= $alias ?>"><?= $name ?></a></h3>
<div><?= cute_text($preview, 100) ?></div>
<p><a class="btn btn-default" href="articles/<?= $categ_alias?>/<?= $alias ?>" role="button">Подробнее &raquo;</a></p>