$(document).ready(function (){
    let delete_semesters;


    $('.delete-semesters-btn').on('click', function (){
        delete_semesters = $(this).data('semester_id')
        $('.delete-panel-semesters').css({display:'flex'})
    })

    $('.close-delete-semesters').on('click', function () {
        $('.delete-panel-semesters').css({display:'none'})
    })

    $('.send-delete-semesters').on('click', function () {
        let url = $('.url-delete-semesters').data('url')
        let csrf = $('input[name="_token"]').val()
        $.ajax({
            url: url,
            method: 'post',
            data: {'_token':csrf, semesters_id: delete_semesters},
            success: function(data){
                $("div[semesters='"+delete_semesters+"']").remove()
                $('.delete-panel-semesters').css({display:'none'})
            },
            error: function (err) {
                error_alert(err.responseJSON.message)
            }
        });


    })
})
