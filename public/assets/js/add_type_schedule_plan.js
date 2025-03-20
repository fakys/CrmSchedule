$(document).ready(function (){
    let csrf = $('input[name="_token"]').val()
    let number_week = 1
    function getForm(number_week, week_data = null) {
        let url = $('#url_get_form').data('url')
        $('#add_week_form').append('<div class="d-flex justify-content-center p-3 load-bar"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div>')
        let data = {'_token': csrf, 'number_week':number_week}

        if (week_data) {
            data['week_data'] = week_data
        }
        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: function (data) {
                $('.load-bar').remove()
                $('#add_week_form').append(data)
            },
            error: function (err) {
                error_alert(err.responseJSON.message)
            }
        });
    }

    function processWithDelay(week_data, week = 1) {
        if (week_data[week] === undefined) return;
        getForm(week, week_data[week])
        setTimeout(() => {
            number_week=week
            processWithDelay(week_data, week + 1);
        }, 100);
    }

    if ($('#week_data').length) {
        let week_data = $('#week_data').data('weeks')
        processWithDelay(week_data);
    } else {
        getForm(number_week)
    }


    $('.add_week_btn').on('click', function () {
        number_week+=1
        getForm(number_week)
    })

    $('.save-type-week').on('click', function () {
        let data = {'weeks':{}};
        let name = $('#type_name').val()
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
        let data_request = {'_token': csrf, 'data':data, 'name':name};
        let url = '';
        if ($('#url_edit_type_plan').length) {
            url = $('#url_edit_type_plan').data('url')
            data_request['id'] = $('#week_data').data('id')
        } else {
            url = $('#url_add_type_plan').data('url')
        }

        $('#operation_container').empty()
        $('#operation_container').append('<div class="d-flex justify-content-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div>')
        $.ajax({
            url: url,
            method: 'post',
            data: data_request,
            success: function (data) {
                location.reload();
            },
            error: function (err) {
                error_alert(err.responseJSON.message)
            }
        });
    })

})
