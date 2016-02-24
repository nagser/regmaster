$(function(){

	/*
	 * Fancybox
	 * */
	$('a.fancybox').fancybox({
		openEffect	: 'elastic',
		closeEffect	: 'elastic',
		loop: false
	});
//
//    $('#surname').change(function(){
//        $this = $(this);
//        value = $this.val();
//        $.ajax({
//            url: 'forms/find_user/?surname=' + value,
//            success: function(data){
//                $('#insert').remove();
//                if(data && data.result.length){
//                   $this.after('<table id="insert" style="margin-top: 10px;" class="table table-bordered">');
//                   jQuery.each(data.result, function(){
//                       $table = $('#insert');
//                       $table.append('<tr class="bg-danger">' +
//                           '<td>'+ this.surname +'</td>' +
//                           '<td>'+ this.name +'</td>' +
//                           '<td>'+ this.patronymic +'</td>' +
//                           '<td>'+ this.country +'</td>' +
//                           '<td>'+ this.region +'</td>' +
//                           '<td>'+ this.city +'</td>' +
//                           '<td>'+ this.email +'</td>' +
//                           '<td class="min-width"><a class="btn btn-default" href="forms/view/'+ this.id+'"><span class="glyphicon glyphicon-search"></span></a></td>' +
//                           '</tr>');
//                   });
//                  $this.after('</table>');
//
//               }
//            }
//        });
//    });

    /*
     * Подтверждение удаления чего-либо
     * */
    $('a.delete').click(function(){
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
                                $('#id_'+data.id).fadeOut();
                                dialog.close();
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

 });