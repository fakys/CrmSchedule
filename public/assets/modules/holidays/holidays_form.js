$(document).ready(function (){
    $('.week_end').off('change').change(function () {
        if ($(this).is(':checked')) {
            $('#format_container_'+$(this).data('number')).addClass('d-none')
        } else {
            $('#format_container_'+$(this).data('number')).removeClass('d-none')
        }
    })
    $('.delete-btn').off('click').on('click', function () {
        let number = $(this).data('number')
        if ($(`.delete-menu-container[number=${number}]`).length) {
            $(`.delete-menu-container[number=${number}]`).css({display:'flex'})
        } else  {
            $('.holiday-form[number='+number+']').remove()
        }
    })

    $('.menu-btn-delete').off('click').on('click', function () {
        let number = $(this).data('number')
        $('.holiday-form[number='+number+']').remove()
        $(`.delete-menu-container[number=${number}]`).css({display:'none'})
    })

    $('.close-btn-delete').off('click').on('click', function () {
        let number = $(this).data('number')
        $(`.delete-menu-container[number=${number}]`).css({display:'none'})
    })
})
