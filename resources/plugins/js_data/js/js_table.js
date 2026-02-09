$(document).ready(function (){
    $('.js-table-row').on('click', function (){
        let id = $(this).data('id')
        for (let i of $('.active_row')) {
            $(i).removeClass('active_row')
        }
        $(this).addClass('active_row')
        let csrf = $('input[name="_token"]').val()
        let data = {'_token': csrf, 'id':id};
        let url = $('#example2').data('url')
        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: function(data){
                $('.content-tabs-js-table').empty()
                $('.content-tabs-js-table').append(data)
                $(".tabs-button").on('click', function (){
                    let btn = $(this)
                    let context_id = $('.active_row').data('id')
                    let csrf = $('input[name="_token"]').val()
                    let data = {'_token': csrf, 'id':context_id};
                    let url = btn.data('url')
                    if(url){
                        $.ajax({
                            url: url,
                            method: 'post',
                            data:data ,
                            success: function(data){
                                $('.tabs-content').empty()
                                $('.tabs-content').append(data)
                            }
                        });
                    }
                })

            }
        });
    })
})
