<?= $this->load->view('admin/chunks/header')?>
<?= $this->load->view('admin/chunks/menu')?>
    <div class="row content">
        <h3><a href="<?= base_url()?>admin/articles"><span class="glyphicon glyphicon-file"></span> Статьи</a></h3>
        <div class="well well-sm">
            <a href="admin/articles/add" class="text-left btn btn-default btn-block"><span class="glyphicon glyphicon-plus"></span> Добавить статью</a>
        </div>
        <?= show_message($form_success) ?>
        <? if ($list): ?>
            <div class="panel panel-default">
                <table class="table table-bordered">
                    <? foreach ($list as $item): ?>
                        <tr id="id_<?= get_value($item, 'id') ?>">
                            <td>
                                <a href="admin/articles/edit/<?= $item->id ?>">
                                    <?= $item->name ?>
                                </a>
                            </td>
                            <td class="min-width">
                                <?if(get_value($item, 'favorite')):?>
                                    <span class="label label-primary">Избранная</span>
                                <?endif?>
								<?if(!get_value($item, 'publish')):?>
									<span class="label label-danger">Неопубликована</span>
								<?endif?>
                            </td>
                            <td class="min-width">
                                <a class="btn btn-small btn-primary upload" href="admin/articles/images/<?= $item->id ?>/articles">
                                    <span class="glyphicon glyphicon-picture"></span>
                                </a>
                                <a class="btn btn-small btn-danger delete" href="admin/album_delete/<?= $item->id ?>/articles">
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