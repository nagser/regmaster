$(function(){

//	/*
//	 * Подтверждение удаления чего-либо
//	 * */
//	$('a.delete').click(function(){
//		$this = $(this);
//		link = $this.attr('href');
//		BootstrapDialog.show({
//			type: BootstrapDialog.TYPE_DANGER,
//			title: 'Подтверждение удаления',
//			message: 'Вы действительно хотите удалить этот элемент?',
//			buttons: [{
//				label: 'Удалить',
//				cssClass: 'btn-danger',
//				action: function(dialog) {
//					$.ajax({
//						url: link+'/ajax',
//						success: function(data){
//							if(data.id){
//								$('#id_'+data.id).fadeOut();
//								dialog.close();
//							}
//						}
//					});
//				}
//			}, {
//				label: 'Отменить',
//				action: function(dialog) {
//					dialog.close();
//				}
//			}]
//		});
//		return false;
//	});

//	/*
//	 * Colorbox
//	 * */
//	$(document).on('click', 'a.colorbox', function(){
//		$.colorbox({
//			'href': $(this).attr('href')
//		});
//		return false;
//	});

	/*
	 * Fancybox
	 * */
	$(document).on('click', 'a.fancybox', function(){
		$.fancybox({
			href: $(this).attr('href'),
			openEffect	: 'elastic',
			closeEffect	: 'elastic',
			'loop' : false
		});
		return false;
	});


});