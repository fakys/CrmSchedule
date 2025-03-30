$(document).ready(function () {

    $('#week_end').change( function (){
        if ($(this).is(':checked')) {
            $('#format_container').addClass('d-none')
        } else {
            $('#format_container').removeClass('d-none')
        }
    })


    $('.add-btn-holiday').on('click', function (){
        let csrf = $('input[name="_token"]').val()
        let data = {'_token':csrf};
        let url = $('#url_add_holiday').data('url')

        for (let input of $('.input-holidays')) {
            if ($(input).attr('type') === 'checkbox') {
                data[$(input).attr('name')] = $(input).is(':checked')
            } else {
                data[$(input).attr('name')] = $(input).val()
            }

        }

        $.ajax({
            url: url,
            method: 'post',
            data:data ,
            success: function (data) {
                location.reload()
            },
            error: function (err) {
                error_alert(err.responseJSON.message)
            }
        });
    })
})
