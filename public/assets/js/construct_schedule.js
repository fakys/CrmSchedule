var schedule_data = {}

$(document).ready(function () {
    let max_pair = 4
    let plan_type = $('select[name="plan_type"]').val()
    let semester = $('select[name="semester"]').val()

    function checkAddBtn() {
        for (let cont of $('.day-container')) {
            if ($(cont).find('.pair-card').length >= max_pair) {
                $(cont).find('.add_card').hide()
            } else {
                $(cont).find('.add_card').show()
            }
        }
    }

    function restyleCard(card_id) {
        let doc_card_elem = $('div[card_id="' + card_id + '"]')

        $.ajax({
            url: $('#get_new_card_name').data('url'),
            method: 'post',
            data: {
                user: schedule_data[card_id].user,
                subject: schedule_data[card_id].subject,
                time_start: schedule_data[card_id].time_start,
                time_end: schedule_data[card_id].time_end,
                '_token': csrf
            },
            success: function (data) {
                let card_data = JSON.parse(data).result
                if (card_data) {
                    schedule_data[card_id].cardName = card_data.card_name
                    doc_card_elem.find('.card-name').html(card_data.card_name)
                    doc_card_elem.find('.card-body-pair').html("<div class='card_time'>" + card_data.card_time + "</div>")

                    if (card_data.color) {
                        doc_card_elem.removeClass('bg-gradient-secondary')
                        doc_card_elem.css({background:card_data.color});
                    }

                    setScheduleCash()
                } else {
                    error_alert('Ошибка изменения карточки')
                }
            }
        });
    }


    function checkCard(event) {
        let slot = event.parent();
        event.attr('data-week_number', slot.data('week_number'))
        event.attr('data-week_day', slot.data('week_day'))
        event.attr('data-number', slot.data('number'))
        event.attr('data-group', slot.data('group'))
        schedule_data[event.attr('card_id')].weekNumber = slot.data('week_number')
        schedule_data[event.attr('card_id')].weekDay = slot.data('week_day')
        schedule_data[event.attr('card_id')].numberPair = slot.data('number')
        schedule_data[event.attr('card_id')].group = slot.data('group')
    }

    function setScheduleCash() {
        if (Object.keys(schedule_data).length > 0) {
            $.ajax({
                url: $('#set_schedule_plan_cash').data('url'),
                method: 'post',
                data: {
                    data: {
                        'schedule_data': schedule_data,
                        'semester': $('#select_semester_schedule_plan').val(),
                        'plan_type': $(".plan_type").val(),
                        'groups': $(".select_group").val(),
                        'specialties': $(".specialties_select").val(),
                    }, '_token': csrf
                },
                success: function (data) {
                    if (JSON.parse(data).result) {
                        success_alert('Данные успешно сохранены в кеше')
                    } else {
                        error_alert('Ошибка сохранения в кеше')
                    }
                }
            });
        }
    }
    // function updateCard(card) {
    //     schedule_data[card.attr('card_id')] = {
    //         cardName: card.find('.card-name').html(),
    //         numberPair: card.data('number'),
    //         weekDay: card.data('week_day'),
    //         weekNumber: card.data('week_number'),
    //         user: card.data('user'),
    //         subject: card.data('subject'),
    //         group: card.data('group'),
    //         time_start: card.data('time_start'),
    //         time_end: card.data('time_end'),
    //         description: card.data('description'),
    //     }
    // }

    $(function () {
        $(".card-slot").sortable({
            connectWith: ".card-slot",
            items: "> .pair-card",
            placeholder: "ui-state-highlight",
            forcePlaceholderSize: true,
            tolerance: "pointer",

            over: function (event, ui) {
                let $slot = $(this);
                let hasOtherCard = $slot.find('.pair-card').not(ui.item).length > 0;
                if (hasOtherCard) {
                    $('.ui-sortable-placeholder').hide();
                } else {
                    $('.ui-sortable-placeholder').show();
                }
            },

            out: function (event, ui) {

            },

            sort: function (event, ui) {

            },
            beforeStop: function (event, ui) {
                let $targetSlot = ui.placeholder.parent();
                let hasOtherCard = $targetSlot.find('.pair-card').not(ui.item).length > 0;

                if (hasOtherCard) {
                    $(this).sortable('cancel');
                }
            },
            stop: function (event, ui) {
                updateSlotAppearance();
                checkCard(ui.item)
                // updateCard(ui.item)
                checkAddBtn()
                setScheduleCash()
            }
        }).disableSelection();

        // Обновление внешнего вида слотов
        function updateSlotAppearance() {
            $('.card-slot').each(function () {
                if ($(this).children('.pair-card').length > 0) {
                    $(this).addClass('slot-filled').removeClass('slot-empty');
                } else {
                    $(this).addClass('slot-empty').removeClass('slot-filled');
                }
            });
        }

        updateSlotAppearance();
    });
    let csrf = $('input[name="_token"]').val()

    function getSubjectInput(input) {
        $.ajax({
            url: $('#get_subject_input').data('url'),
            method: 'post',
            data: {'teacher': input.val(), '_token': csrf},
            success: function (data_input) {
                $('.subject-input-container').html(data_input)
            }
        })
    }

    function openPairModal(card_id) {

        $('#card_model_data_label').html(schedule_data[Number(card_id)].cardName)
        $('#card_modal_body').html('<div class="d-flex justify-content-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div>')
        let url = $('#get_form_for_pair').data('url')
        $.ajax({
            url: url,
            method: 'post',
            data: {data: schedule_data[Number(card_id)], '_token': csrf, 'card_id': card_id},
            success: function (data) {
                $('#card_modal_body').html(data)
                $('.users_select').on('change', function () {
                    getSubjectInput($(this))
                })
            }
        });
    }

    for (let card of $('.pair-card')) {
        schedule_data[$(card).attr('card_id')] = {
            cardName: $(card).find('.card-name').html(),
            numberPair: $(card).data('number'),
            weekDay: $(card).data('week_day'),
            weekNumber: $(card).data('week_number'),
            user: $(card).data('user'),
            subject: $(card).data('subject'),
            group: $(card).data('group'),
            time_start: $(card).data('time_start'),
            time_end: $(card).data('time_end'),
            description: $(card).data('description'),
            plan_type: plan_type,
            semester: semester,
            format: $(card).data('format')
        }
        checkAddBtn()
    }

    $('.add_card').on('click', function () {
        let container = $(this).parent().parent()

        for (let card_container of container.find('.connectedSortable')) {

            if ($(card_container).find('.pair-card').length <= 0) {
                let card_id = $('.pair-card').length + 1
                let empty_card_id = $('.pair-empty').length + 1
                $(card_container).append('<div class="pair-card pair-empty text-white card bg-gradient-secondary mb-2" ' +
                    'data-week_day="' + $(card_container).data('number') + '" data-number="' + $(card_container).data('number') + '"' +
                    'card_id="' + card_id + '" data-group="' + $(card_container).data('group') + ' data-format='+""+'">' +
                    '<div class="card-header border-0 ui-sortable-handle" style="cursor: move;">' +
                    '<h3 class="card-pair-title">' +
                    '<i class="fa fa-users" aria-hidden="true"></i>' +
                    '<div class="card-name">' +
                    ' Новое расписание №' + (empty_card_id) +
                    '</div>' +
                    '</h3>' +
                    '</div>' +
                    '<div class="card-body-pair" data-bs-toggle="modal" data-bs-target="#card_model_data"> </div>' +
                    '<div class="card-footer d-flex justify-content-center"><div class="btn btn-danger delete-card">Удалить карточку</div></div>' +
                    '</div>')
                checkAddBtn()
                schedule_data[card_id] = {
                    cardName: 'Новое расписание №' + empty_card_id,
                    numberPair: $(card_container).data('number'),
                    weekDay: $(card_container).data('week_day'),
                    weekNumber: $(card_container).data('week_number'),
                    group: $(card_container).data('group'),
                    user: null,
                    subject: null,
                    time_start: null,
                    time_end: null,
                    description: null,
                    plan_type: plan_type,
                    format: null,
                    semester: semester
                }

                $(card_container).find('.delete-card').on('click', function () {
                    let card_id = $($(this).parents('.pair-card')[0]).attr('card_id')
                    if (card_id) {
                        $($(this).parents('.pair-card')[0]).remove()
                        delete schedule_data[card_id]
                        setScheduleCash()
                    }
                })
                $(card_container).find('.card-body-pair').on('click', function () {
                    openPairModal($(this).parent().attr('card_id'))
                })
                break
            }
        }
    })

    $('.btn_save_schedule').on('click', function () {
        let card_id = $('#card_id_pair_form').data('card_id')
        let all_schedule_data = {}
        let pair_data = {};

        for (let key in schedule_data) {
            if (key != card_id) {
                all_schedule_data[key] = {
                    cardName: schedule_data[key].cardName,
                    numberPair: schedule_data[key].numberPair,
                    weekDay: schedule_data[key].weekDay,
                    weekNumber: schedule_data[key].weekNumber,
                    group: schedule_data[key].group,
                    user: schedule_data[key].user,
                    subject: schedule_data[key].subject,
                    time_start: schedule_data[key].time_start,
                    time_end: schedule_data[key].time_end,
                    description: schedule_data[key].description,
                    plan_type: plan_type,
                    semester: semester
                }
            } else {
                pair_data = {
                    cardName: schedule_data[key].cardName,
                    numberPair: schedule_data[key].numberPair,
                    weekDay: schedule_data[key].weekDay,
                    weekNumber: schedule_data[key].weekNumber,
                    group: schedule_data[key].group,
                }
            }
        }
        for (let input of $('.schedule-input')) {
            pair_data[$(input).attr('name').replace(/\[|\]/g, '')] = $(input).val()
        }

        $.ajax({
            url: $('#validate_card').data('url'),
            method: 'post',
            data: {'card_data': pair_data, 'all_schedule_data':all_schedule_data, '_token': csrf},
            success: function (data) {
                let result = JSON.parse(data)
                if (!result.result) {
                    for (let input of $('.schedule-input')) {
                        for (let key in result.errors) {
                            if (result.errors[key][$(input).attr('name')]) {
                                $(input).parent().find('.error-block').html(result.errors[key][$(input).attr('name').replace(/\[|\]/g, '')])
                            }
                        }

                    }
                    return false
                }
                for (let input of $('.schedule-input')) {
                    schedule_data[card_id][$(input).attr('name').replace(/\[|\]/g, '')] = $(input).val()
                }

                restyleCard(card_id)
            }
        });

    })

    $('.save-plan_schedule').on('click', function () {
        $.ajax({
            url: $('#set_plan_schedule').data('url'),
            method: 'post',
            data: {'_token': csrf},
            success: function (data) {
                window.location.reload()
            },
            error: function (err) {
                error_alert(err.responseJSON.message)
            }
        });
    })

    $('.delete-card').on('click', function () {
        let card_id = $($(this).parents('.pair-card')[0]).attr('card_id')
        if (card_id) {
            $($(this).parents('.pair-card')[0]).remove()
            delete schedule_data[card_id]
            setScheduleCash()
        }
    })


    $('.btn-open-construct').on('click', function () {
        let status = $(this).data('status')
        if (status === 'close') {
            $(this).data('status', 'open')
            $(this).html('<i class="fas fa-compress-arrows-alt"></i>')
            $(this).parents('.row_construct_schedule').first().addClass('row_construct_schedule_open')
            $(this).parents('.container_construct_schedule').first().addClass('container_construct_schedule_open')
            $('body').css({overflow: 'hidden'})
        } else {
            $(this).data('status', 'close')
            $(this).html('<i class="fas fa-expand-arrows-alt"></i>')
            $(this).parents('.row_construct_schedule').first().removeClass('row_construct_schedule_open')
            $(this).parents('.container_construct_schedule').first().removeClass('container_construct_schedule_open')
            $('body').css({overflow: 'auto'})
        }
    })

    $('.card-body-pair').on('click', function () {
        openPairModal($(this).parent().attr('card_id'))
    })

    $('#download_template').on('click', function () {
        window.open(
            $('#download_template_url').data('url') +
            "?semester=" + $('#select_semester_schedule_plan').val()+"&" +
            "plan_type=" + $('.plan_type').val()+"&" +
            "select_group=" + $('.select_group').val()
        )
    })
})
