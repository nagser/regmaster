<?= $this->load->view('admin/chunks/header')?>

<div class="container">
	<div class="row content">
		<?= form_open(base_url().'admin/login', array('role' => 'form', 'class' => 'form-signin'))?>
			<?= show_message($form_success)?>
			<?= show_message(validation_errors())?>
			<h2 class="form-signin-heading">Пожалуйста войдите</h2>
			<?= form_input(array('name' => 'name', 'value' => set_value('name'), 'id' => 'input1', 'placeholder' => 'Имя', 'class' => 'form-control'))?>
			<?= form_input(array('name' => 'password', 'value' => set_value('password'), 'id' => 'input2', 'placeholder' => 'Пароль', 'class' => 'form-control'))?>
			<br />
			<button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
		</form>
	</div>
</div>
<?= $this->load->view('admin/chunks/footer')?>