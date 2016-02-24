<?= $this->load->view('admin/chunks/header')?>
<?= $this->load->view('admin/chunks/menu')?>
    <div class="row content">
        <h3><a href="<?= base_url()?>admin/users"><span class="glyphicon glyphicon-user"></span> Пользователи</a></h3>
        <hr/>
        <?if(isset($list) AND $list):?>
            <div class="list-group">
                <?foreach($list as $item):?>
                    <li class="list-group-item" id="id_<?= get_value($item, 'id')?>">
                        <a href="admin/settings/edit/<?= $item['id']?>">
                            <b><?= $item['name']?></b>
                            <?= $item['description'] ? '('.$item['description'].')':''?>
                            <span class="label label-default"><?= $item['type']?></span>
                        </a>
                        <a class="delete" href="admin/setting_delete/<?= $item['id']?>">
                            <span class="glyphicon glyphicon-remove pull-right"></span>
                        </a>
                    </li>
                <?endforeach?>
            </div>
        <?else:?>
            <?= show_message('Список пользователей пуст')?>
        <?endif?>
    </div>
<?= $this->load->view('admin/chunks/footer')?>