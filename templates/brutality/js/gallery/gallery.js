$(function(){

	/*
	 * Шаблон вывода thumbnail для галереи
	 * */
	function showThumb(data) {
		return '' +
			'<div class="col-sm-6 col-md-4 col-xs-12 col-lg-3" id="id_'+data.id+'">' +
			'	<div class="thumbnail">' +
			'		<a href="'+data.resized+'" class="colorbox fancybox">'+
			'			<img src="'+data.thumb+'" alt="">' +
			'		</a>'+
			'		<div class="caption">' +
			'			<p class="text-center">' +
			'				<a class="btn btn-sm btn-danger delete_image" href="'+data.delete_link+''+data.id+'" class="btn btn-sm btn-danger delete_image" data-id="'+data.id+'"><span class="glyphicon glyphicon-remove"></span> Удалить</a>' +
			'				<a href="#" data-image="'+data.resized+'" data-url="'+data.edit_link+''+data.id+'" class="btn btn-sm btn-default edit_image" data-id="'+data.id+'"><span class="glyphicon glyphicon-edit"></span> Обрезать</a>' +
			'			</p>' +
			'		</div>' +
			'	</div>' +
			'</div>';
	}

	/*
	 * Ajax удаление изображений из альбома
	 * */
	function deleteImageFromDom(id){
		if(id){
			$this = $('#id_'+id);
			$this.fadeOut(function(){
				$this.remove();
			});

		}
	}

	/*
	* Обновить сортировщик
	* */
	function show_sort(){
		$('#thumbs').sortable({
			cursor: 'move',
			connectWith: ".sortable"
		}).disableSelection();
	}

	/*
	* Замена изображения в DOM
	* */
	function replaceImageInDom(data){
		$this = $('#id_' + data.id);
		$this.find('img').attr('src', data.image +'?time' + new Date().getTime());
	}

	/*
	 * Ajax загрузка изображений в галерею
	 * */
	$('#gallery_upload').fileupload({
		dataType: 'json',
		done: function (e, data) {
			$box = $('#thumbs');
			if(data.result.error){
				BootstrapDialog.show({
					type: BootstrapDialog.TYPE_DANGER,
					title: 'Предупреждение',
					message: data.result.error,
					buttons: [{
						label: 'Скрыть',
						action: function(dialog) {
							dialog.close();
						}
					}]
				});
			} else {
				show_sort();
				$box.append(showThumb(data.result));
			}
		}
	});

	/*
	 * Подтверждение удаления изображения
	 * */
	$(document).on('click', 'a.delete_image', function(){
		$this = $(this);
		link = $this.attr('href');
		BootstrapDialog.show({
			type: BootstrapDialog.TYPE_DANGER,
			title: 'Подтверждение удаления',
			message: 'Вы действительно хотите удалить этот элемент?',
			buttons: [{
				label: 'Удалить',
				cssClass: 'btn-danger',
				action: function(dialog) {
					$.ajax({
						url: link+'/ajax',
						success: function(data){
							if(data.id){
								dialog.close();
								deleteImageFromDom(data.id)
							}
						}
					});
				}
			}, {
				label: 'Отменить',
				action: function(dialog) {
					dialog.close();
				}
			}]
		});
		return false;
	});

	/*
	* Изображение для кроппера
	* */
	$(document).on('click', 'a.edit_image', function(){
		$this = $(this);
		id = $this.data('id');
		url = $this.data('url');
		image = $this.data('image');
		cropperData = {
			x: 0,
			y: 0,
			width: 640,
			height: 400
		};
		$image = {};
		BootstrapDialog.show({
			title: 'Изменить миниатюру',
			closeByBackdrop: false,
			message: function(){
				$image = $('' +
						'<div class="cropper">'+
							'<div class="row">' +
								'<div class="col-sm-7 col-xs-8 no-margin">' +
									'<div style="width:320px; height: 200px;" class="cropper_preview"></div>' +
								'</div>'+
								'<div class="col-sm-5 col-xs-4 no-margin no-padding">' +
									'<div style="width:160px; height: 100px;" class="cropper_preview"></div>' +
								'</div>'+
							'</div>'+

							'<hr />' +
							'<div class="cropper_img">' +
								'<img data-image_id="'+id+'" src="'+image+'" width="100%" />' +
							'</div>' +

						'</div>');
				$content = $('<div class="img-preview"></div>');
				$content.append($image);
				return $image;
			},
			buttons: [{
				id: 'btn-1',
				label: 'Сохранить изменения.',
				autospin: true,
				icon: 'glyphicon glyphicon-ok',
				cssClass: 'btn-primary',
				action: function(dialogRef){
					dialogRef.enableButtons(false);
					dialogRef.setClosable(false);
					$.ajax({
						url: url,
						type: 'POST',
						dataType: 'json',
						data: {
							id: id,
							x: cropperData.x,
							y: cropperData.y,
							width: cropperData.width,
							height: cropperData.height
						},
						success: function(data){
							replaceImageInDom(data);
							setTimeout(function(){dialogRef.close()}, 500);
						}
					});
				}
			}],
			onshown: function(){
				$('.bootstrap-dialog-message').imagesLoaded( function() {
					$image.find('.cropper_img img').cropper({
						aspectRatio: 16 / 10,
						multiple: true,
						data: cropperData,
						minWidth: 320,
						minHeight: 200,
						preview: ".cropper_preview",
						done: function(data){
							cropperData = data;
						}
					});
				});
			}
		});
		return false;
	});
});
