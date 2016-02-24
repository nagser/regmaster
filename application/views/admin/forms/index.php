<?= $this->load->view('admin/chunks/header')?>
<?= $this->load->view('admin/chunks/menu')?>
    <div class="row content">
        <h3><a href="<?= base_url()?>admin/forms"><span class="glyphicon glyphicon-th-list"></span> Форма регистрации</a></h3>
        <div class="well well-sm">
            <a href="admin/forms/add" class="text-left btn btn-default btn-block"><span class="glyphicon glyphicon-plus"></span> Добавить поле</a>
        </div>
        <? if ($list): ?>
            <div class="panel panel-default">
                <table class="table table-bordered">
                    <? foreach ($list as $item): ?>
                        <tr id="id_<?= get_value($item, 'id') ?>">
                            <td <?= get_value($item, 'publish') ? 'style="font-weight:bold"' : ''?>>
                                <a href="admin/forms/edit/<?= $item->id ?>">
                                    <?= $item->name ?>
                                </a>
                            </td>
                            <td class="min-width">
                                <a class="btn btn-small btn-danger delete" href="admin/form_delete/<?= $item->id ?>">
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