$(function(){
    /**/
    $('#city')
        .attr('placeholder', 'Начните ввод...')
        .selectize({
            maxItems: 1,
            load: function(query, callback) {
                $this = $(this.$input);
                if (!query.length) return callback();
                $.ajax({
                    url: $this.data('url'),
                    type: 'POST',
                    dataType: 'json',
                    data: 'query='+query,
                    error: function() {
                        callback();
                    },
                    success: function(list) {
                        callback(list);
                    }
                });
            }
        });


    $('#special')
        .attr('placeholder', 'Начните ввод...')
        .selectize({
            maxItems: 1,
            load: function(query, callback) {
                $this = $(this.$input);
                if (!query.length) return callback();
                $.ajax({
                    url: $this.data('url'),
                    type: 'POST',
                    dataType: 'json',
                    data: 'query='+query,
                    error: function() {
                        callback();
                    },
                    success: function(list) {
                        callback(list);
                    }
                });
            }
        });

    $('#surname')
        .attr('placeholder', 'Начните ввод...')
        .selectize({
            create: true,
            maxItems: 1,
            load: function(query, callback) {
                $this = $(this.$input);
                if (!query.length) return callback();
                $.ajax({
                    url: $this.data('url')+'/get_surname',
                    type: 'POST',
                    dataType: 'json',
                    data: 'query='+query,
                    error: function() {
                        callback();
                    },
                    success: function(list) {
                        callback(list);
                    }
                });
            },
            render: {
//                item: function(item, escape) {
//
//                    text = item.text.toString();
//                    text = text.split(';');
//                    text = text.toString().split(' ');
//                    console.log(text);
//                    return '<span>'+text[0]+'</span>';
//                },
                option: function(item, escape) {
                    console.log(item);
                    return '<div><a data-link="'+item.link+'" href="'+item.link+'">'+item.text+'</a></div>';
                }
            },
            onItemAdd: function(value, item){
                $.ajax({
                    url: $this.data('url')+'/find_surname?ajax=1&name='+value,
                    success: function(result) {
                        if(result){
                            window.location.href = $this.data('url')+'/find_surname?name='+value;
                        }
                    }
                });
            }
        });
});