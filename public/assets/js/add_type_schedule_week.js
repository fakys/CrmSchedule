$(document).ready(function (){
    let csrf = $('input[name="_token"]').val()
    let delete_url = $('#url_delete_week_type_plan').data('url')
    $('.delete-weeks').on('click', function () {
        let number = $(this).data('number')
        $('.delete-panel-type-schedule-week[number='+number+']').addClass('open-delete-panel-panel-type-schedule-week')
    })
    $('.close-delete-type-schedule-week').on('click', function () {
        let number = $(this).data('number')
        $('.delete-panel-type-schedule-week[number='+number+']').removeClass('open-delete-panel-panel-type-schedule-week')
    })
    $('.send-delete-type-schedule-week').on('click', function () {
        let number = $(this).data('number')
        let id = $('#week_data').data('id')
        $.ajax({
            url: delete_url,
            method: 'post',
            data: {'_token': csrf, 'id':id, 'number':number},
            success: function (data) {
                location.reload();
            },
            error: function (err) {
                error_alert(err.responseJSON.message)
            }
        })
    })
})
