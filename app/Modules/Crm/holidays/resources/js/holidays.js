$(document).ready(function () {

    $('#week_end').change( function (){
        if ($(this).is(':checked')) {
            $('#format_container').addClass('d-none')
        } else {
            $('#format_container').removeClass('d-none')
        }
    })
    if ($('#week_end').is(':checked')) {
        $('#format_container').addClass('d-none')
    } else {
        $('#format_container').removeClass('d-none')
    }

    let csrf = $('input[name="_token"]').val()
    $('.add-btn-holiday').on('click', function (){
        let data = {'_token':csrf};
        let url = '';

        if ($('#url_edit_holiday').length) {
            url = $('#url_edit_holiday').data('url')
        } else {
            url = $('#url_add_holiday').data('url')
        }

        for (let input of $('.input-holidays')) {
            if ($(input).attr('type') === 'checkbox') {
                data[$(input).attr('name')] = $(input).is(':checked')
            } else {
                data[$(input).attr('name')] = $(input).val()
            }

        }

        if ($('#url_edit_holiday').length) {
            data['id'] = $('#url_edit_holiday').data('id')
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

    $('.btn-open-delete-menu').on('click', function () {
        let id = $(this).data('id')
        $(`.delete-menu-container[id=${id}]`).css({display:'flex'})
    })

    $('.close-btn-delete').on('click', function () {
        let id = $(this).data('id')
        $(`.delete-menu-container[id=${id}]`).css({display:'none'})
    })

    $('.menu-btn-delete').on('click', function () {
        let id = $(this).data('id')
        let url_delete = $('#url_delete').data('url')
        $.ajax({
            url: url_delete,
            method: 'post',
            data:{'id':id, '_token':csrf},
            success: function (data) {
                location.reload()
            },
            error: function (err) {
                error_alert(err.responseJSON.message)
            }
        });
    })
})
