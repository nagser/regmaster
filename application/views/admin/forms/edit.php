<?= $this->load->view('admin/chunks/header')  ?>
<?= $this->load->view('admin/chunks/menu') ?>
    <div class="row content">
        <h3><?= isset($edit) ? 'Редактирование' : 'Добавление' ?> поля</h3>
        <hr/>
        <?if(isset($item) AND $item->not_editable):?>
            <?=show_message('Это системное поле. Непродуманное редактирование может привести к непредсказуемым последставиям')?>
        <?endif?>
        <?= show_message(validation_errors()) ?>
        <?= form_open(base_url().'admin/forms_edit', array('role' => 'form', 'class' => 'form-horizontal')) ?>

        <input type="hidden" name="id" value="<?= set_value('id') ?>">

        <div class="form-group">
            <label for="input1" class="col-sm-2 control-label">Имя</label>

            <div class="col-sm-10">
                <?= form_input(array('name' => 'name', 'value' => set_value('name'), 'id' => 'input1', 'placeholder' => 'Название поля', 'class' => 'form-control')) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="friendly_url_title" class="col-sm-2 control-label">Идентификатор</label>

            <div class="col-sm-10">
                <?= form_input(array('name' => 'alias', 'value' => set_value('alias'), 'id' => 'input1231', 'placeholder' => 'Уникальный alias', 'class' => 'form-control')) ?>
            </div>
        </div>
<!--        <div class="form-group">-->
<!--            <label for="select1" class="col-sm-2 control-label">Категория</label>-->
<!---->
<!--            <div class="col-sm-10">-->
<!--                --><?//= show_dropdown('category_id', $this->categs_model->as_list(), 'select1'); ?>
<!--            </div>-->
<!--        </div>-->
        <div class="form-group">
            <label for="input3" class="col-sm-2 control-label">Возможные значения</label>

            <div class="col-sm-10">
                <?= form_textarea(array('name' => 'values', 'value' => set_value('values'), 'id' => 'input3', 'placeholder' => 'Опция1|Опция2|Опция3', 'class' => 'form-control editor', 'rows' => '5')) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="input4" class="col-sm-2 control-label">Правила валидации</label>

            <div class="col-sm-10">
                <div class="alert alert-warning">
                    <ul>
                        <li>required - Обязательное</li>
                        <li>min_length[6] - Минимальная длина 6 символов</li>
                        <li>max_length[255] - Максимальная длина 255 символов</li>
                        <li>integer - Число</li>
                        <li>valid_email - Правильный адрес Email</li>
                    </ul>
                </div>
                <?= form_textarea(array('name' => 'rules', 'value' => set_value('rules'), 'id' => 'input4', 'placeholder' => 'Правило1|Правило2|Правило3', 'class' => 'form-control editor', 'rows' => '5')) ?>
            </div>
        </div>
        <div class="form-group">
            <label for="friendly_url_title" class="col-sm-2 control-label">Позиция</label>

            <div class="col-sm-10">
                <?= form_input(array('name' => 'position', 'value' => set_value('position'), 'id' => 'input1231213', 'placeholder' => 'Целое число', 'class' => 'form-control')) ?>
            </div>
        </div>
        <div class="col-sm-2"></div><?= form_checkbox('publish', 1, set_checkbox('publish', 1)); ?> Активно
        <div class="clearfix"></div>
        <hr/>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <a href="admin/forms/" class="btn btn-default">Отмена</a>
                <button type="submit" class="btn btn-primary"><?= isset($edit) ? 'Редактировать' : 'Добавить' ?></button>
            </div>
        </div>
        </form>
    </div>
<?= $this->load->view('admin/chunks/footer') ?>