<?= $this->load->view('site/chunks/header') ?>
<?= $this->load->view('site/chunks/menu') ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Регистрация</div>
            <div class="panel-body">
                <?= show_message(validation_errors()) ?>
                <?if(isset($form) AND count($form)):?>
                    <?= form_open(base_url().'forms', array('role' => 'form', 'class' => 'form-horizontal')) ?>
					<input type="hidden" name="id" value="<?= set_value('id')?>">
                        <?foreach($form as $field):?>
                            <div class="form-group single">
                                <label class="col-sm-2 control-label"><?= get_value($field, 'name')?></label>
                                <div class="col-sm-10">
									<!--Специальность-->
									<?if(get_value($field, 'alias') == 'special'):?>
										<?= show_dropdown(get_value($field, 'alias'), array_to_list($this->users_model->get_categs(), 'name', 'name'), get_value($field, 'alias'), get_value($field, 'alias'));?>
									<!--Фамилия-->
									<?elseif(get_value($field, 'alias') == 'surname'):?>
										<?= form_input(array('name' => get_value($field, 'alias'), 'value' => set_value(get_value($field, 'alias')),  'placeholder' => get_value($field, 'name'), 'class' => 'form-control', 'id' => isset($edit) ? NULL : get_value($field, 'alias'), 'data-add' => 'Добавить', 'autofocus' => 'autofocus', 'data-url' => $this->users_model->get_url($field->alias) ? $this->users_model->get_url($field->alias):NULL)) ?>
									<?else:?>
										<!--Текст-->
										<?if(get_value($field, 'rows')):?>
											<?= form_textarea(array('name' => get_value($field, 'alias'), 'value' => set_value(get_value($field, 'alias')), 'id' => 'input3', 'placeholder' => get_value($field, 'name'), 'class' => 'form-control editor', 'rows' => get_value($field, 'rows'))) ?>
											<!--дропдаун-->
										<?elseif(get_value($field, 'values')):?>
											<?= show_dropdown(get_value($field, 'alias'), $this->forms_model->explode_values($field->values), get_value($field, 'alias'));?>
											<!--Обычное поле-->
										<?else:?>
											<?= form_input(array('name' => get_value($field, 'alias'), 'value' => set_value(get_value($field, 'alias')),  'placeholder' => get_value($field, 'name'), 'class' => 'form-control', 'id' => get_value($field, 'alias'), 'data-add' => 'Добавить','data-url' => $this->users_model->get_url($field->alias) ? $this->users_model->get_url($field->alias):NULL)) ?>
										<?endif?>
									<?endif?>
                                </div>
                            </div>
                        <?endforeach?>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-lg btn-primary"><?= isset($edit) ? 'Редактировать' : 'Добавить' ?></button>
<!--								<a class="btn btn-default" href="forms/pager">К списку пользователей</a>-->
                            </div>
                        </div>
                    </form>
                <?endif?>
            </div>
        </div>
    </div>
</div>

<?= $this->load->view('site/chunks/footer') ?>