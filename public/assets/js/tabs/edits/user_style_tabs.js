$(document).ready(function (){
    $('#btn_save').on('click', function () {
        let color = $('#user_color').val()
        let csrf = $('input[name="_token"]').val()
        $.ajax({
            url: $('#save_style').data('url'),
            method: 'post',
            data: {'_token':csrf, 'color':color, 'id': context_id},
            success: function(data){
                success_alert('Данные успешно сохранены !');
            },
            error: function (err){
                error_alert('Ошибка обновления !')
            }
        });
    })
})
