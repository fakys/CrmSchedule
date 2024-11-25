$(document).ready(function (){
    $(".tabs-button").on('click', function (){
        let btn = $(this)
        let csrf = $('input[name="_token"]').val()
        let data = {'_token': csrf, 'id':context_id};
        let url = btn.data('url')
        if(url){
            $.ajax({
                url: url,
                method: 'post',
                data:data ,
                success: function(data){
                    $('.tabs-content').empty()
                    $('.tabs-content').append(data)
                }
            });
        }
    })
})
