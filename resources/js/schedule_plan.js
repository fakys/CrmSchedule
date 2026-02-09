$(document).ready(function (){
    let err = {}
    let csrf = $('input[name="_token"]').val()


    function validateInput(input, request = false) {
        let value = null;
        let url = $('#validate_shcedule_plan').data('url')

        if (input.attr('type') === 'checkbox') {
            value = input.is(':checked')
        } else {
            value = input.val()
        }

        let day_data = input.parents('.pair-container').first()

        // error_alert(value)
        if (input.hasClass('required-input') && (!value || value == 0 || typeof value === 'object' && value.length == 0)) {
            input.next().html('Поле обязательное')
            err[day_data.data('number_week')+'-'+day_data.data('week_day')+'-'+day_data.data('pair_number')] = 'Расписание не полностью заполнено Неделя №'+day_data.data('number_week')+" День №"+day_data.data('week_day')+' Пара №'+day_data.data('pair_number')
            return;
        } else {
            input.next().html('')
            delete err[day_data.data('number_week')+'-'+day_data.data('week_day')+'-'+day_data.data('pair_number')]
        }

        let all_container_input = day_data.find('.required-input')

        let pair_data = {
            'pair_number': day_data.data('pair_number'),
            'week_number': day_data.data('number_week'),
            'week_day': day_data.data('week_day')
        }
        for (let input_container of all_container_input) {
            pair_data[$(input_container).attr('name')] = $(input_container).val()
        }

        if (request) {
            $.ajax({
                url: url,
                method: 'post',
                data: {
                    '_token': csrf,
                    'pair_data': pair_data
                },
                success: function (data) {
                    for (let val of data) {
                        err[day_data.data('number_week') + '-' + day_data.data('week_day') + '-' + day_data.data('pair_number')] = val
                    }
                },
            });
        }
    }

    $('.input-data').change(function (){
        validateInput($(this), true)
    })


    $('.save-plan_schedule').on('click', function (){
        //
        // for (let input of $('.required-input')) {
        //     validateInput($(input))
        // }
        //
        // if (Object.keys(err).length > 0) {
        //     let str = ""
        //     str += "<ul>"
        //     for (let val in err) {
        //         str += "<li>"+err[val]+"</li>"
        //     }
        //     str += "</ul>"
        //     $('#errors_block_data').html(str)
        //
        //     error_alert('Расписание не полностью заполнено')
        //     return;
        //}


        // let main_data = {}
        // let csrf = $('input[name="_token"]').val()
        // let url = $('#add_url_schedule_plan').data('url')

        // if (main_data) {
        //     $.ajax({
        //         url: url,
        //         method: 'post',
        //         data:{'_token': csrf, 'schedule_data':main_data, 'group_id':group_id, 'type_id':type_id, 'semester_id':semester_id},
        //         success: function(data){
        //             $('#add_plan_schedule').click()
        //         },
        //         error: function (err){
        //             error_alert(err.responseJSON.message)
        //         }
        //     });
        // } else {
        //     error_alert('Ошибка при сборе информации')
        // }
    })
})
