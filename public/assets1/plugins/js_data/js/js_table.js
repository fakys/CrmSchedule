let context_id;
$(document).ready(function (){

    $('.js-table-row').on('click', function (){
        let id = $(this).data('id')
        context_id = id
        let csrf = $('input[name="_token"]').val()
        let data = {'_token': csrf, 'id':id};
        let url = $('#example2').data('url')
        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: function(data){
                $('.content-tabs-js-table').empty()
                $('.content-tabs-js-table').append(data)
            }
        });
    })
})
