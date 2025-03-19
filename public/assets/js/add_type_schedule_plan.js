$(document).ready(function (){
    let csrf = $('input[name="_token"]').val()
    let number_week = 1
    function getForm(number_week) {
        let url = $('#url_get_form').data('url')
        $('#add_week_form').append('<div class="d-flex justify-content-center p-3 load-bar"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div>')
        $.ajax({
            url: url,
            method: 'post',
            data: {'_token': csrf, 'number_week':number_week},
            success: function (data) {
                $('.load-bar').remove()
                $('#add_week_form').append(data)
            },
            error: function (err) {
                error_alert(err.responseJSON.message)
            }
        });
    }
    getForm(number_week)
    $('.add_week_btn').on('click', function () {
        number_week++
        getForm(number_week)
    })

    $('.save-type-week').on('click', function () {
        let data = {'weeks':{}};
        for (let week of $('.week-container')) {
            let weekend_inputs = $(week).find('.weekend-input')
            let week_end_arr = {}
            for (let weekend of weekend_inputs) {
                week_end_arr[$(weekend).data('week_end')] = $(weekend).is(':checked')
            }
            data['weeks'][$(week).data('number_week')] = {
                'week_end':week_end_arr
            }
        }

        let url = $('#url_add_type_plan').data('url')
        $('#operation_container').empty()
        $('#operation_container').append('<div class="d-flex justify-content-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div>')
        $.ajax({
            url: url,
            method: 'post',
            data: {'_token': csrf, 'data':data},
            success: function (data) {
                $('#operation_container').empty()
            },
            error: function (err) {
                error_alert(err.responseJSON.message)
            }
        });
    })

})
