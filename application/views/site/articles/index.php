<?= $this->load->view('site/chunks/header')?>
<?= $this->load->view('site/chunks/menu')?>
	<div class="content">
		<?= breadcrumbs::get() ?>
		<div class="articles">
			<?foreach($list['articles'] as $article):
				isset($list['images'][$article->id]) ? $image = $list['images'][$article->id] : $image = FALSE;
				?>
				<?= $this->load->view('site/chunks/articles/list', array(
					'name' => get_value($article, 'name'),
					'categ_alias' => get_value($article, 'categ_alias'),
					'alias' => get_value($article, 'alias'),
					'preview' => get_value($article, 'preview'),
					'image' => $image,
				))?>
			<?endforeach?>
		</div>
		<?= $this->pagination->create_links() ?>
	</div>
<?= $this->load->view('site/chunks/footer')?>