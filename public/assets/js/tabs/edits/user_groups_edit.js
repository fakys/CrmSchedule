$(document).ready(function (){
    $('.save-groups').on('click', function (){
        let data = $('.users-group-select').val()
        let csrf = $('input[name="_token"]').val()
        let url = $(this).data('url')
        if(url){
            $.ajax({
                url: url,
                method: 'post',
                data: {'_token': csrf, 'groups': data, 'user_id':context_id},
                success: function (data) {
                    success_alert('Данные успешно сохранены !')
                },
                error: function (err) {
                    let error = err.responseJSON.message
                    if(error){
                        error_alert(error)
                    }else {
                        error_alert('Ошибка обновления !')
                    }
                }
            });
        }else {
            error_alert('Ошибка обновления !')
        }
    })
});
