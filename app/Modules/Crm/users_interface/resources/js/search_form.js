$(document).ready(function (){
    $('.clear-btn-user-info').on('click', function (){
        $('.search-input').val('')
        $('.option-search').attr('selected', false)
        $('.select2-selection__choice').remove()
    })
})
