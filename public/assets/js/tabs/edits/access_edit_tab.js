$(document).ready(function (){
    function validate(login, password, password_confirm){
        let block_login = $('.error-block-login')
        let block_password = $('.error-block-password')
        block_login.empty()
        block_password.empty()
        if(!login){
            block_login.text('Поле обязательное');
            return false;
        }
        if(login.length<=3){
            block_login.text('Поле слишком мало');
            return false;
        }
        if(!password){
            block_password.text('Поле обязательное')
            return false
        }
        if(password.length<=6){
            block_password.text('Поле слишком мало')
            return false
        }
        if (password !== password_confirm){
            block_password.text('Поля не совпадают')
            return false
        }
        return true
    }

    $('.save-access').on('click', function (){
        let login = $("#access_login").val()
        let password = $("#access_password").val()
        let url = $(this).data('url')
        let password_confirm = $("#access_password_confirm").val()
        let csrf = $('input[name="_token"]').val()
        let data = {'id':context_id, 'username':login, 'password':password, 'password_confirm':password_confirm}
        if(url && validate(login, password, password_confirm)){
            $.ajax({
                url: url,
                method: 'post',
                data: {'_token': csrf, 'data': data},
                success: function (data) {
                    success_alert('Данные успешно сохранены !')
                    $("#access_password_confirm").val('')
                    $("#access_password").val('')
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
        }
    })
})
