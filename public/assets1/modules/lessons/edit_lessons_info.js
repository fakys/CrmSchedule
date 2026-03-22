$(document).ready(function () {
    $('#bnt_save').on('click', function () {
        let url = $('#url_edit_lesson').data('url')
        let csrf = $("input[name='_token']").val()

        $.ajax({
            url: url,
            method: 'post',
            data: {'_token': csrf, 'teacher':$("select[name='teacher']").val(), 'subject':$("select[name='subject']").val(), id:context_id},
            success: function (data) {
                success_alert('Данные сохранены')
            },
            error: function (err){
                error_alert(err.responseJSON.message)
            }
        })
    })
})
