$(document).ready(function (){


    $('.btn-close-save-alert').on('click', function (){
        $('.save-alert').removeClass('save-alert-active')
    })
    $(".save-btn").on('click', function (){

        let field = $(this).data('field');
        let table = field.split('-')[0]
        let field_name = field.split('-')[1]
        let error_block = $(".error-block-"+field)

        error_block.empty()
        $('.save-alert').removeClass('save-alert-active')
        if(table && field_name){
            let csrf = $('input[name="_token"]').val()
            let url = $('.url-edit-user').data("url")
            let value = $(`input[name="${field}"]`).val()
            if(!value){
                value = $(`textarea[name="${field}"]`).val()
            }
            if(url){
                $.ajax({
                    url: url,
                    method: 'post',
                    data:{'_token': csrf,'table':table , 'field_name':field_name, 'value':value, 'id':context_id},
                    success: function(data){
                        success_alert('Данные успешно сохранены !');
                        setInterval(function(){
                            $('.save-alert').removeClass('save-alert-active')
                        }, 10000);
                    },
                    error: function (err){
                        if (err.status === 422) {
                            let error = err.responseJSON.message
                            if (error){
                                if(error_block){
                                    error_block.append(error)
                                    setInterval(function(){
                                        error_block.empty()
                                    }, 10000);
                                }
                            }
                        }else {
                            if (err){
                                if(error_block){
                                    error_block.append('Ошибка обновления')
                                    setInterval(function(){
                                        error_block.empty()
                                    }, 10000);
                                }
                            }
                        }
                    }
                });
            }
        }
    })
})
