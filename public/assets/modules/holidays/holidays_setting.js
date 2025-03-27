$(document).ready(function (){
    let csrf = $('input[name="_token"]').val()
    $('#use_settings').change(function (){
        if ($(this).is(':checked')) {
            $('#holidays_container').removeClass('d-none')
        } else {
            $('#holidays_container').addClass('d-none')
        }
    })

    $('#use_priority_setting').change(function (){
        if ($(this).is(':checked')) {
            $('#priority_setting_container').removeClass('d-none')
        } else {
            $('#priority_setting_container').addClass('d-none')
        }
    })
    $('#add_holiday_btn').on('click', function (){
        $('#loan_bar').remove()
        $('#holidays_container_data').append('<div class="d-flex justify-content-center p-3" id="loan_bar"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div></div>')

        get_form_holiday()
    })

    function get_form_holiday(for_settings = false) {
        $('#loan_bar').remove()
        $('#holidays_container_data').append('<div class="d-flex justify-content-center p-3" id="loan_bar"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div></div>')

        $.ajax({
            url: $('#holiday_form').data('url'),
            method: 'post',
            data: {'_token': csrf, 'number':$('.holiday-form').length+1, 'for_settings':for_settings},
            success: function(data){
                $('#loan_bar').remove()
                $('#holidays_container_data').append(data)
            },
            error: function (err){
                error_alert(err.responseJSON.message)
            }
        });
    }
    get_form_holiday(true)

    if ($('#use_settings').is(':checked')) {
        $('#holidays_container').removeClass('d-none')
    } else {
        $('#holidays_container').addClass('d-none')
    }
    if ($('#use_priority_setting').is(':checked')) {
        $('#priority_setting_container').removeClass('d-none')
    } else {
        $('#priority_setting_container').addClass('d-none')
    }

    $('#btn_save').on('click', function (){
        let data = {};
        for (let form of $('.holiday-form')) {
            let number = $(form).data('number')
            data[number] = {}
            let inputs = $(form).find('.input-holidays')
            for (let inp of inputs) {
                if ($(inp).attr('type')==='checkbox') {
                    data[number][$(inp).attr('name')] = $(inp).is(':checked')
                } else {
                    data[number][$(inp).attr('name')] = $(inp).val()
                }
            }
        }

        $.ajax({
            url: $('#holiday_save').data('url'),
            method: 'post',
            data: {
                '_token': csrf,
                'holidays':data,
                'use_settings':$('#use_settings').is(':checked'),
                'priority_setting':$('#priority_setting').val(),
                'use_priority_setting':$('#use_priority_setting').is(':checked')
            },
            success: function(data){
                location.reload();
            },
            error: function (err){
                error_alert(err.responseJSON.message)
            }
        });
    })
})

