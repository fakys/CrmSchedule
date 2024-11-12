$(document).ready(function (){
    check_modules()
    function check_modules(){
        for (let i of $(".modules-settings-checkbox")){
            let row = $('.row-'+$(i).data('module'))
            if(i.checked){
                row.removeClass('table-danger')
                row.addClass('table-success')
            }else {
                row.removeClass('table-success')
                row.addClass('table-danger')
            }
        }
    }

    $(".modules-settings-checkbox").on('click', function (){
        check_modules()
    })

    $(".save-modules-settings").on('click', function (){
        let settings = $(".modules-settings-checkbox");
        let csrf = $('input[name="_token"]').val()
        let data = {'_token': csrf, 'data':[]};
        let url = $('.form-settings-module').attr('action')
        for (let i of settings){
            let active = i.checked
            let module = $(i).data('module_name')
            data.data.push({status:active, name:module})
        }
        $.ajax({
            url: url,
            method: 'post',
            data: data,
            success: function(data){
                $('.alert-main').removeClass('d-none')
            }
        });
    })
    setInterval(function(){
        $('.alert-main').addClass('d-none')
        console.log(123)
    }, 10000);
})
