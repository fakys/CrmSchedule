$(document).ready(function (){
    let group_id = '';
    $('.delete-user-group-btn').on('click', function (){
        group_id = $(this).data('group_id');
        $('.delete-panel-user-group').addClass('open-delete-panel-user-group')
    })

    $('.close-delete-user-group').on('click', function (){
        group_id = '';
        $('.delete-panel-user-group').removeClass('open-delete-panel-user-group')
    })
    $('.send-delete-user-group').on('click', function (){
        if(group_id){
            let csrf = $('input[name="_token"]').val()
            let url = $('.url-delete-user-group').data('url');

            $.ajax({
                url: url,
                method: 'post',
                data: {'_token': csrf, 'group_id': group_id},
                success: function (data) {
                    $('.delete-panel-user-group').removeClass('open-delete-panel-user-group')
                    if($('tr[user_group_id="'+group_id+'"]')){
                        $('tr[user_group_id="'+group_id+'"]').remove()
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
