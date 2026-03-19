$(document).ready(function (){
    let pair_id = '';
    $('.delete-user-group-btn').on('click', function (){
        pair_id = $(this).data('pair_id');
        $('.delete-panel-user-group').addClass('open-delete-panel-user-group')
    })

    $('.close-delete-user-group').on('click', function (){
        pair_id = '';
        $('.delete-panel-user-group').removeClass('open-delete-panel-user-group')
    })
    $('.send-delete-user-group').on('click', function (){
        if(pair_id){
            let csrf = $('input[name="_token"]').val()
            let url = $('.url-delete-user-group').data('url');

            $.ajax({
                url: url,
                method: 'post',
                data: {'_token': csrf, 'pair_id': pair_id},
                success: function (data) {
                    $('.delete-panel-user-group').removeClass('open-delete-panel-user-group')
                    if($('tr[pair_id="'+pair_id+'"]')){
                        $('tr[pair_id="'+pair_id+'"]').remove()
                    }
                    success_alert('Группа успешно удалена');
                },
            })
        }else {
            $('.delete-panel-user-group').removeClass('open-delete-panel-user-group')
            error_alert('Ошибка при удалении: группа не выбрана')
        }
    })
})
