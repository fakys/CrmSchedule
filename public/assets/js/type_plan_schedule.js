$(document).ready(function () {
    let csrf = $('input[name="_token"]').val()

    $('#btn_search_type_plan').on('click', function () {
        let schedule_operation = $('#select_operation_plan_schedule').val()
        let url = $('#url_search_operation').data('url')
        $('#operation_container').empty()
        $('#operation_container').append('<div class="d-flex justify-content-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div>')

        if (schedule_operation && csrf && url) {
            $.ajax({
                url: url,
                method: 'post',
                data: {'_token': csrf, 'operation_name': schedule_operation},
                success: function (data) {
                    $('#operation_container').empty()
                    $("#operation_container").append(data)
                },
                error: function (err) {
                    error_alert(err.responseJSON.message)
                }
            });
        }
    })

})
