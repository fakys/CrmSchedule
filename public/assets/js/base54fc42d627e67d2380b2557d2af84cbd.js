$(document).ready(function (){
    $('.btn-close-save-alert').on('click', function (){
        $('.save-alert').removeClass('save-alert-active')
    })
    $('.btn-close-save-alert').on('click', function (){
        if($('.btn-close-save-alert').hasClass('save-error-alert-active')){
            $('.save-alert').removeClass('save-error-alert-active')
            setInterval(function(){
                $('.save-alert').removeClass('save-error-alert-coll')
            }, 600);
        }
    })


    $('.description-settings').on('click', function (){
        let text = $(this).attr('title')
        success_alert(text)
    })
})

