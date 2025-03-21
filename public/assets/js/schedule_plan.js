$(document).ready(function (){
    let type_id = $('#select_type_schedule_plan').val()
    let group_id = $('#select_group_schedule_plan').val()
    let semester_id = $('#select_semester_schedule_plan').val()

    $('.required-input').change(function (){
        let number_week = $(this).data('number_week')
        let day_week_number = $(this).data('day_week_number')
        let pair_number = $(this).data('pair_number')
        let count_arr = [];
        let edit_day = false
        for (let input of $(`.required-input-${number_week}-${day_week_number}-${pair_number}`)) {
            if (!$(input).val() || $(input).val() === '' || $(input).val() === undefined || $(input).val() == 0) {
                edit_day = true
                count_arr.push($(input))
            }
        }
        if (!$(`.week-end-input-${number_week}-${day_week_number}-${pair_number}`).is(':checked')) {
            $(`.week-end-day-plan-${number_week}-${day_week_number}-${pair_number}`).css({display:'none'})
        }

        if ($(`.week-end-input-${number_week}-${day_week_number}-${pair_number}`).is(':checked')){
            $(`.success-day-plan-${number_week}-${day_week_number}-${pair_number}`).css({display:'none'})
            $(`.edit-day-plan-${number_week}-${day_week_number}-${pair_number}`).css({display:'none'})
            $(`.week-end-day-plan-${number_week}-${day_week_number}-${pair_number}`).css({display:'block'})
        }else if (count_arr.length == $(`.required-input-${number_week}-${day_week_number}-${pair_number}`).length) {
            $(`.success-day-plan-${number_week}-${day_week_number}-${pair_number}`).css({display:'none'})
            $(`.edit-day-plan-${number_week}-${day_week_number}-${pair_number}`).css({display:'none'})
        } else if (edit_day) {
            $(`.success-day-plan-${number_week}-${day_week_number}-${pair_number}`).css({display:'none'})
            $(`.edit-day-plan-${number_week}-${day_week_number}-${pair_number}`).css({display:'block'})
        } else {
            $(`.edit-day-plan-${number_week}-${day_week_number}-${pair_number}`).css({display:'none'})
            $(`.success-day-plan-${number_week}-${day_week_number}-${pair_number}`).css({display:'block'})
        }
    })


    $('.save-plan_schedule').on('click', function (){
        let main_data = {}
        let csrf = $('input[name="_token"]').val()
        let url = $('#add_url_schedule_plan').data('url')

        for (let i of $(`.edit-day-plan`)) {
            if ($(i).css('display')!=='none') {
                error_alert('Заполните расписание до конца')
                return 1;
            }
        }

        for(let input of $('.input-data')) {
            if (!main_data[$(input).data('number_week')]) {
                main_data[$(input).data('number_week')] = {}
            }
            if (!main_data[$(input).data('number_week')][$(input).data('day_week_number')]) {
                main_data[$(input).data('number_week')][$(input).data('day_week_number')] = {}
            }
            if (!main_data[$(input).data('number_week')][$(input).data('day_week_number')][$(input).data('pair_number')]) {
                main_data[$(input).data('number_week')][$(input).data('day_week_number')][$(input).data('pair_number')] = {}
            }

            if (!main_data[$(input).data('number_week')][$(input).data('day_week_number')][$(input).data('pair_number')][$(input).attr('name')]) {
                main_data[$(input).data('number_week')][$(input).data('day_week_number')][$(input).data('pair_number')][$(input).attr('name')] = {}
            }
            main_data[$(input).data('number_week')][$(input).data('day_week_number')][$(input).data('pair_number')][$(input).attr('name')] = $(input).val()
        }

        if (main_data) {
            console.log(main_data)
            $.ajax({
                url: url,
                method: 'post',
                data:{'_token': csrf, 'schedule_data':main_data, 'group_id':group_id, 'type_id':type_id, 'semester_id':semester_id},
                success: function(data){
                    console.log(data)
                },
                error: function (err){
                    error_alert(err.responseJSON.message)
                }
            });
        } else {
            error_alert('Ошибка при сборе информации')
        }
    })
})
