
$(document).ready(function (){


    /** Массив с изначальным расписанием */
    let start_data = {};
    let schedule = {};

    /** собирает данные по расписанию */
    function getScheduleData() {
        for (let block of $('.schedule-block')) {
            let inputs = $(block).find('.change-input')
            let group_id = $(block).data('student_group')
            let date_start = $(block).data('date')
            let pair_number = $(block).data('pair_number')

            let block_data = {}
            block_data[pair_number] = {
                'group_id': group_id,
                'date': date_start,
                'pair_number': pair_number,
                'schedule': {}
            }

            if (start_data[group_id] && start_data[group_id][date_start]) {
                start_data[group_id][date_start][pair_number] = {
                    'group_id': group_id,
                    'date': date_start,
                    'pair_number': pair_number,
                    'schedule': {}
                }
            } else {
                if (!start_data[group_id]) {
                    start_data[group_id] = {}
                }
                start_data[group_id][date_start] = {}
                start_data[group_id][date_start][pair_number] = {
                    'group_id': group_id,
                    'date': date_start,
                    'pair_number': pair_number,
                    'schedule': {}
                }
            }
            let count_inputs = 1;
            for (let input of inputs) {
                let name = $(input).attr('name')
                start_data[group_id][date_start][pair_number]['schedule'][name] = $(input).val();
                if ($(input).val() != 0 && $(input).attr('name') !== 'schedule_description') {
                    count_inputs ++
                }
            }

            if (count_inputs === inputs.length) {
                $(block).find('.schedule-pair-number').addClass('schedule-pair-set')
            }
        }
    }

    getScheduleData()

    function getStartSchedule(group_id, date_start, pair_number) {
        return start_data[group_id][date_start][pair_number];
    }


    function changeSchedule(obj) {
        let block = obj.closest('.schedule-block')
        let group_id = block.data('student_group')
        let date_start = block.data('date')
        let pair_number = block.data('pair_number')
        let start_schedule = getStartSchedule(group_id, date_start, pair_number)
        let inputs = $(block).find('.change-input')

        if (!schedule[group_id]) {
            schedule[group_id] = {}
        }
        if (!schedule[group_id][date_start]) {
            schedule[group_id][date_start] = {}
        }
        if (!schedule[group_id][date_start][pair_number]) {
            schedule[group_id][date_start][pair_number] = {}
        }
        if (!schedule[group_id][date_start][pair_number]['schedule']) {
            schedule[group_id][date_start][pair_number]['schedule'] = {}
        }

        for (let inp of inputs) {
            schedule[group_id][date_start][pair_number]['schedule'][$(inp).attr('name')] = $(inp).val()
        }

        for (let inp of inputs) {
            if (
                $(inp).val() == 0 &&
                $(inp).attr('name') !== 'schedule_description'
            ) {
                block.find('.schedule-pair-number').removeClass('schedule-pair-number-ready')
                block.find('.schedule-pair-number').addClass('schedule-pair-number-error')
                return 0
            }
        }
        block.find('.schedule-pair-number').removeClass('schedule-pair-number-error')
        block.find('.schedule-pair-number').addClass('schedule-pair-number-ready')
        return 1

    }

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

    let task_cash = false
    function hasTaskCashSchedule(){
        if ($('#use_cash').length) { //Если используется кеширование
            let url = $('#use_cash').data('url')

            $.ajax({
                url: url,
                method: 'get',
                data: {},
                success: function (data) {
                    if (data) {
                        $('#cash_alert').removeClass('d-none')
                        task_cash = true;
                        $('.btn-save-schedule').attr({disabled:true})
                    } else  {
                        $('#cash_alert').addClass('d-none')

                        if (task_cash) {
                            get_edit_schedule()
                        }
                        task_cash = false
                    }
                }
            })
        }
    }
    hasTaskCashSchedule()
    setInterval(() => {
        hasTaskCashSchedule()
    }, 15000);

    $('.btn-save-schedule').on('click', function (){
        getScheduleData()
        let url = $('.url-edit-schedule').data('url')
        if ($('.schedule-pair-number-error').length !== 0) {
            if ($('.schedule-pair-number-error').length > 1) {
                error_alert('Ошибка в расписании за '+$('.schedule-pair-number-error')[0].closest('.schedule-block').data('date'))
            } else {
                error_alert('Ошибка в расписании за '+$('.schedule-pair-number-error').closest('.schedule-block').data('date'))
            }

            return 0;
        }
        if (url) {
            $.ajax({
                url: url,
                method: 'post',
                data: {'_token':$("input[name='_token']").val(), 'schedule':JSON.stringify(schedule), 'full_data':JSON.stringify(start_data)},
                success: function(data){
                    if (data == 1) {
                        if ($('#use_cash').length) { //Если используется кеширование
                            hasTaskCashSchedule()
                        } else {
                            get_edit_schedule()
                        }

                    } else {
                        $('.schedule-errors-block').empty()
                        $('.schedule-errors-block').append(data)
                    }
                },
                error: function (err){
                    let data = null;
                    try {
                        data = JSON.parse(err.responseJSON.message);
                    } catch (e) {
                        error_alert(err.responseJSON.message)
                        return false;
                    }

                    if (data && data.error) {

                    }
                }
            })
        }
    })


    $('select').change(function () {
        if ($(this).hasClass('change-input')) {
            changeSchedule($(this))
        }
    })
    $('input').bind('input', function () {
        if ($(this).hasClass('change-input')) {
            changeSchedule($(this))
        }
    })

    $('textarea').bind('input', function () {
        if ($(this).hasClass('change-input')) {
            changeSchedule($(this))
        }
    })

})
