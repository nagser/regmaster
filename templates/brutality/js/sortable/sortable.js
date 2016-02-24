$(function(){

	$('.sortable').sortable({
		cursor: 'move',
        update: function(event, ui){
            console.log($(this).data('url') + '/?' + $(this).sortable('serialize'));
            $.ajax({
              url: $(this).data('url') + '/?' + $(this).sortable('serialize'),
              success: function(data){
                  if(!data.result){
					  alert('Позиции изображений не сохранены. Ошибка интернет соединения');
                  }
              }
            });
        }
	}).disableSelection();
});