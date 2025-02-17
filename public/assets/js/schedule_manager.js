$(document).ready(function (){

    let student_groups = null
    let specialties = null
    let period = null
    let csrf = $("input[name='_token']").val()

    $('#btn_search_manager').on('click', function (){
        $('.schedule-manager-menu').empty()
        student_groups = $('.student_groups').val()
        specialties = $('.specialties').val()
        period = $('#period').val()
        let url = $('.url-manager-menu').data('url')
        $('.schedule-manager-menu').append('<div class="d-flex justify-content-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div>')
        $.ajax({
            url: url,
            method: 'post',
            data: {'_token':csrf, period:period, specialties:specialties, groups:student_groups},
            success: function(data){
                $('.schedule-manager-menu').empty()
                $('.schedule-manager-menu').append(data)
                $('#btn_search_manager').text('Обновить')
            },
            error: function (err){
                let error = err.responseJSON.message
                if(error){
                    error_alert(error)
                }else {
                    error_alert('Ошибка сервера !!')
                }
            }
        });
    })


    if ($('.specialties').val().length) {
        $('.student_groups').attr('disabled', true)
    }

    if ($('.student_groups').val().length) {
        $('.specialties').attr('disabled', true)
    }

    $('.student_groups').change(function (){
        let data = $(this).val()

        if (data.length) {
            $('.specialties').attr('disabled', true)
            $('.specialties').attr('title', 'Одновременно можно выбрать только или группы или специальности')
        } else {
            $('.specialties').removeAttr('disabled')
            $('.specialties').removeAttr('title')
        }
    })

    $('.specialties').change(function (){
        let data = $(this).val()

        if (data.length) {
            $('.student_groups').attr('disabled', true)
            $('.student_groups').attr('title', 'Одновременно можно выбрать только или группы или специальности')
        } else {
            $('.student_groups').removeAttr('disabled')
            $('.student_groups').removeAttr('title')
        }
    })
})
