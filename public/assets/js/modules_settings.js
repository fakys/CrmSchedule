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
        $('.save-alert').removeClass('save-alert-active')
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
                $('.save-alert').addClass('save-alert-active')
                $(".massage-save-alert").text('Данные успешно сохранены !')
                setInterval(function(){
                    $('.save-alert').removeClass('save-alert-active')
                }, 10000);
            }
        });
    })
    setInterval(function(){
        $('.alert-main').addClass('d-none')
    }, 10000);
})
