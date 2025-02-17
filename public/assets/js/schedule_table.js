$(document).ready(function (){
    $('.schedule-row').on('click', function () {
        if ($(this).hasClass('menu-open')) {
            let edit_block = $(this).next()
            $(this).removeClass('menu-open')
            if (edit_block.hasClass('edit-container-schedule')){
                edit_block.addClass('d-none')
            }
        } else {
            let edit_block = $(this).next()
            $(this).addClass('menu-open')
            if (edit_block.hasClass('edit-container-schedule')){
                edit_block.removeClass('d-none')
            }
        }
    })
})
