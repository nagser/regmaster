<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Переключить меню</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?= Settings::get('base_url') ?>"><?=Settings::get('site_name')?></a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
<!--				--><?//= show_link(base_url(), 'Главная') ?>
<!--				--><?//= show_link(base_url().'forms/pager', 'Список пользователей') ?>
<!--				--><?//= show_link(base_url().'articles/', 'Статьи') ?>
<!--				--><?//= show_link(base_url().'o_sayte/', 'О сайте')?>
<!--				<li><a href="#">Link</a></li>-->
<!--				<li class="dropdown">-->
<!--					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>-->
<!--					<ul class="dropdown-menu" role="menu">-->
<!--						<li><a href="#">Action</a></li>-->
<!--						<li><a href="#">Another action</a></li>-->
<!--						<li><a href="#">Something else here</a></li>-->
<!--						<li class="divider"></li>-->
<!--						<li class="dropdown-header">Nav header</li>-->
<!--						<li><a href="#">Separated link</a></li>-->
<!--						<li><a href="#">One more separated link</a></li>-->
<!--					</ul>-->
<!--				</li>-->
			</ul>
			<ul class="nav navbar-nav navbar-right">
<!--				--><?= show_link(base_url().'forms/pager', 'Список пользователей') ?>
			</ul>
		</div>
	</div>
</div>
