function get_add_schedule() {
    $('.menu-container-data').empty()
    let url = $('.link-add-schedule').data('url')
    $('.menu-container-data').append('<div class="d-flex justify-content-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div>')
    if (url) {
        $.ajax({
            url: url,
            method: 'post',
            data: {'_token':document.querySelector('input[name="_token"]').value},
            success: function(data){
                $('.menu-container-data').empty()
                $('.menu-container-data').append(data)
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
    }
}

$(document).ready(function (){
    $(".nav-tabs-link").on('click', function () {
        for (let i of $(".nav-tabs-link")) {
            $(i).removeClass('active')
        }
        $(this).addClass('active')
        let type = $(this).attr('id')

        switch (type) {
            case 'schedule':
                break
            case 'edit_schedule':
                get_add_schedule()
                break
            case 'auto_create_schedule':
                break
            case 'add_schedule':
                break

        }

    })
})
