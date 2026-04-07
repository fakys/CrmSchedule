var schedule_data = {}

$(document).ready(function () {

    const $menu = $('#context-menu');
    const $target = $('.card-slot');
    $target.on('contextmenu', function (e) {
        e.preventDefault();
        const x = e.pageX - $(this).width();
        const y = e.pageY - $(this).height();
        let slot = this
        $menu.off('click')

        if ($(this).children().length > 0) {
            $menu.html(`<ul>
                <li data-action="edit">Редактировать</li>
                <li data-action="delete">Удалить</li>
                <li data-action="copy">Копировать</li>
            </ul>`)
        } else {
            $menu.html(`<ul>
                <li data-action="add">Добавить</li>
                <li data-action="insert">Вставить</li>
            </ul>`)
        }

        $menu.on('click', 'li', async function () {
            const action = $(this).data('action');

            if (action === 'add') {
                addCardUi(slot)
            } else if (action === 'edit') {
                let card_id = $(slot).children().data('cardId')
                const modalElement = $('#card_model_data')[0];
                const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modal.show();
                openPairModal(card_id)
            } else if (action === 'delete') {
                let card_id = $(slot).children().data('cardId')
                if (card_id) {
                    $(slot).children().remove()
                    delete schedule_data[card_id]
                    setScheduleCash()
                }
            } else if (action === 'copy') {
                let card_id = $(slot).children().data('cardId')
                await navigator.clipboard.writeText(cardToJson(card_id));
            } else if (action === 'insert') {
                let groupId = $(slot).data('groupId')
                let weekDay = $(slot).data('weekDay')
                let weekNumber = $(slot).data('weekNumber')
                let number = $(slot).data('number')
                let pairData = getPairData(number)

                let cardJson = await navigator.clipboard.readText();
                let cardData = JSON.parse(cardJson)
                cardData.cardId = $('.pair-card').length + 1
                cardData.groupId = groupId
                cardData.weekDay = weekDay
                cardData.weekNumber = weekNumber
                cardData.numberPair = number
                cardData.timeStart = pairData.timeStart
                cardData.timeEnd = pairData.timeEnd

                insertCard(slot, cardData)
                if (cardData.teacherId && cardData.subjectId) {
                    let validate = validateCard(cardData)
                    validate.then(function (data) {
                        let result = JSON.parse(data)
                        if (result.result === true) {
                            insertCard(slot, cardData)
                        } else {
                            if (result.errors.length > 0) {
                                error_alert(
                                    Object.values(result.errors[0]).pop()
                                )
                                addCardError(cardData.cardId, Object.values(result.errors[0]).pop())
                            } else {
                                error_alert(
                                    'Ошибка вставки!'
                                )
                                addCardError(cardData.cardId, 'Ошибка вставки!')
                            }
                        }
                        setScheduleCash()
                    })
                } else {

                }
            }
            $menu.hide();
        });

        $menu.css({
            top: y + 'px',
            left: x + 'px'
        }).show();

        $(document).on('click', function () {
            $menu.hide();
        });


    });


    function insertCard(slot, cardData) {
        addCardUi(slot)
        let new_card = Object.values(schedule_data).pop()
        new_card.cardName = cardData.cardName
        new_card.teacherId = cardData.teacherId
        new_card.subjectId = cardData.subjectId
        new_card.timeStart = cardData.timeStart
        new_card.timeEnd = cardData.timeEnd
        new_card.formatId = cardData.formatId
        new_card.description = cardData.description
        schedule_data[new_card.cardId] = new_card
        restyleCard(new_card.cardId)
        setScheduleCash()
    }

    let plan_type = $('select[name="plan_type"]').val()
    let semester = $('select[name="semester"]').val()

    async function restyleCard(card_id) {
        let doc_card_elem = $('div[data-card-id="' + card_id + '"]')
        return $.ajax({
            url: $('#get_new_card_name').data('url'),
            method: 'post',
            data: {
                teacherId: schedule_data[card_id].teacherId,
                subjectId: schedule_data[card_id].subjectId,
                timeStart: schedule_data[card_id].timeStart,
                timeEnd: schedule_data[card_id].timeEnd,
                '_token': csrf
            },
            success: function (data) {
                let card_data = JSON.parse(data).result
                if (card_data) {
                    schedule_data[card_id].cardName = card_data.cardName
                    doc_card_elem.find('.card-name').html(card_data.cardName)
                    doc_card_elem.find('.card-body-pair').html("<div class='card_time'>" + card_data.cardTime + "</div>")
                    doc_card_elem.removeClass('cardError')
                    schedule_data[card_id].errorMessage = null
                    checkBtnSave()
                    if (card_data.color) {
                        doc_card_elem.removeClass('bg-gradient-secondary')
                        doc_card_elem.css({background: card_data.color});
                    }
                } else {
                    error_alert('Ошибка изменения карточки')
                }
            }
        });
    }

    checkBtnSave()

    function cardToJson(cardId) {
        let cardData = schedule_data[cardId]
        return JSON.stringify(cardData)
    }


    function checkCard(event) {
        let slot = event.parent();
        event.attr('data-week-number', slot.data('weekNumber'))
        event.attr('data-week-day', slot.data('weekDay'))
        event.attr('data-number', slot.data('number'))
        event.attr('data-group-id', slot.data('groupId'))
        schedule_data[event.data('cardId')].weekNumber = slot.data('weekNumber')
        schedule_data[event.data('cardId')].weekDay = slot.data('weekDay')
        schedule_data[event.data('cardId')].numberPair = slot.data('number')
        schedule_data[event.data('cardId')].groupId = slot.data('groupId')
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
                        // success_alert('Данные успешно сохранены в кеше')
                    } else {
                        error_alert('Ошибка сохранения в кеше')
                    }
                }
            });
        }
    }

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
            beforeStop: async function (event, ui) {
                let $targetSlot = ui.placeholder.parent();
                let hasOtherCard = $targetSlot.find('.pair-card').not(ui.item).length > 0;
                if (hasOtherCard) {
                    $(this).sortable('cancel');
                }

                let pairNumber = getPairData($targetSlot.data('number'))
                let cardId = $targetSlot.find('.pair-card').data('cardId')
                let cardData = schedule_data[cardId]
                //Валидируем данные при перемещение
                if (cardData.teacherId && cardData.subjectId) {
                    let slot = $targetSlot;
                    cardData.weekNumber = slot.data('weekNumber')
                    cardData.weekDay = slot.data('weekDay')
                    cardData.numberPair = slot.data('number')
                    cardData.groupId = slot.data('groupId')
                    cardData.timeStart = pairNumber.timeStart
                    cardData.timeEnd = pairNumber.timeEnd

                    let validationData = await validateCard(cardData)
                    let result = JSON.parse(validationData)
                    schedule_data[cardData.cardId] = cardData
                    await restyleCard(cardData.cardId)
                    if (result.result !== true) {
                        if (result.errors.length > 0) {
                            error_alert(
                                Object.values(result.errors[0]).pop()
                            )
                            addCardError(cardId, Object.values(result.errors[0]).pop())
                        } else {
                            error_alert(
                                'Ошибка перемещения!'
                            )
                        }
                        // $(this).sortable('cancel');
                    }
                }
                setScheduleCash()
            },
            stop: function (event, ui) {
                checkCard(ui.item)
            }
        }).disableSelection();
    });
    let csrf = $('input[name="_token"]').val()

    function getSubjectInput(input) {
        $.ajax({
            url: $('#get_subject_input').data('url'),
            method: 'post',
            data: {'teacherId': input.val(), '_token': csrf},
            success: function (data_input) {
                $('.subject-input-container').html(data_input)
            }
        })
    }

    function addCard(
        card_id,
        cardName,
        numberPair,
        weekDay,
        weekNumber,
        groupId,
        teacherId,
        subjectId,
        timeStart,
        timeEnd,
        description,
        planTypeId,
        formatId,
        semesterId,
        errorMessage = null
    ) {
        schedule_data[card_id] = {
            cardId: card_id,
            cardName: cardName,
            numberPair: numberPair,
            weekDay: weekDay,
            weekNumber: weekNumber,
            teacherId: teacherId,
            subjectId: subjectId,
            groupId: groupId,
            timeStart: timeStart,
            timeEnd: timeEnd,
            description: description,
            planTypeId: planTypeId,
            semesterId: semesterId,
            formatId: formatId,
            errorMessage: errorMessage
        }
    }

    function openPairModal(card_id) {
        $('#card_model_data_label').html(schedule_data[Number(card_id)].cardName)
        $('#card_modal_body').html('<div class="d-flex justify-content-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div>')
        let url = $('#get_form_for_pair').data('url')
        $.ajax({
            url: url,
            method: 'post',
            data: {data: schedule_data[Number(card_id)], '_token': csrf},
            success: function (data) {
                $('#card_modal_body').html(data)
                $('.users_select').on('change', function () {
                    getSubjectInput($(this))
                })
            }
        });
    }

    for (let card of $('.pair-card')) {
        addCard(
            $(card).data('cardId'),
            $(card).find('.card-name').html(),
            $(card).data('numberPair'),
            $(card).data('weekDay'),
            $(card).data('weekNumber'),
            $(card).data('groupId'),
            $(card).data('teacherId'),
            $(card).data('subjectId'),
            $(card).data('timeStart'),
            $(card).data('timeEnd'),
            $(card).data('description'),
            plan_type,
            $(card).data('formatId'),
            semester,
            $(card).data('errorMessage')
        )
    }

    function addCardError(cardId, message, conflictCardId = null) {
        let card = schedule_data[cardId]
        card.errorMessage = message
        let doc_card_elem = $('div[data-card-id="' + cardId + '"]')
        if (doc_card_elem.find('.error-text-card').length > 0) {
            doc_card_elem.find('.error-text-card').html(message)
        } else {
            doc_card_elem.find('.card-body-pair').append(`<div class="error-text-card">${message}</div>`)
            doc_card_elem.addClass('cardError')
        }
        checkBtnSave()
    }

    function checkBtnSave() {
        if ($('.cardError').length > 0) {
            $('.save-plan_schedule').attr({disabled: true})
            $('.save-plan_schedule').addClass('disabled_btn')
        } else {
            $('.save-plan_schedule').attr({disabled: false})
            $('.save-plan_schedule').removeClass('disabled_btn')
        }
    }

    function addCardUi(card_container) {
        if ($(card_container).find('.pair-card').length <= 0) {
            let card_id = $('.pair-card').length + 1
            let empty_card_id = $('.pair-empty').length + 1
            $(card_container).append(`<div class="pair-card pair-empty text-white card bg-gradient-secondary mb-2" ` +
                `data-week-day="${$(card_container).data('number')}" data-number-pair="${$(card_container).data('number')}"` +
                `data-card-id="${card_id}"  data-group-id="${$(card_container).data('group-id')}" data-format-id="">` +
                `<div class="card-header border-0 ui-sortable-handle" style="cursor: move;">` +
                `<h3 class="card-pair-title">` +
                `<i class="fa fa-users" aria-hidden="true"></i>` +
                `<div class="card-name">Новое расписание №${empty_card_id}</div>` +
                `</h3>` +
                `</div>` +
                `<div class="card-body-pair" data-bs-toggle="modal" data-bs-target="#card_model_data"> </div>` +
                `</div>`)

            addCard(
                empty_card_id,
                'Новое расписание №' + empty_card_id,
                $(card_container).data('number'),
                $(card_container).data('weekDay'),
                $(card_container).data('weekNumber'),
                $(card_container).data('groupId'),
                null,
                null,
                null,
                null,
                null,
                plan_type,
                null,
                semester
            )
            $(card_container).find('.card-body-pair').on('click', function () {
                openPairModal($(this).parent().data('cardId'))
            })
        }
    }

    async function validateCard(card_data) {
        $('#ErrorAlert').remove()
        let all_schedule_data = {}
        for (let key in schedule_data) {
            if (key != card_data.cardId) {
                all_schedule_data[key] = schedule_data[key]
            }
        }

        return $.ajax({
            url: $('#validate_card').data('url'),
            method: 'post',
            data: {
                'card_data': card_data,
                'all_schedule_data': all_schedule_data,
                'groups': $('.select_group').val(),
                '_token': csrf
            },
            success: function (data) {

            },
            error: function (err) {
                error_alert(err.responseJSON.message)
            }
        })
    }

    //Кнопка сохранить при редактировании карты
    $('.btn_save_schedule').on('click', function () {
        let card_id = $('#card_id_pair_form').data('cardId')
        let all_schedule_data = {}
        let pair_data = {};

        for (let key in schedule_data) {
            if (key != card_id) {
                all_schedule_data[key] = schedule_data[key]
            }
        }

        pair_data = schedule_data[card_id]
        for (let input of $('.schedule-input')) {
            pair_data[$(input).attr('name').replace(/\[|\]/g, '')] = $(input).val()
        }

        let request = validateCard(pair_data);

        request.then(function (data) {
            let result = JSON.parse(data)
            if (!result.result) {
                for (let input of $('.schedule-input')) {
                    for (let error of result.errors) {
                        for (let key in error) {
                            if (key === $(input).attr('name')) {
                                $(`#${key}_error`).html(error[key])
                                $(`#${key}_error`).css({display: 'block'})
                            }
                        }
                    }
                }
                return false
            }
            for (let input of $('.schedule-input')) {
                schedule_data[card_id][$(input).attr('name').replace(/\[|\]/g, '')] = $(input).val()
            }

            restyleCard(card_id)
            setScheduleCash()
            const modalElement = $('#card_model_data')[0];
            const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
            modal.hide();
        })
    })

    //Кнопка сохранить ВСЕ расписание
    $('.save-plan_schedule').on('click', function () {
        if ($(this).hasClass('disabled_btn')) {
            return;
        }
        $.ajax({
            url: $('#set_plan_schedule').data('url'),
            method: 'post',
            data: {'_token': csrf},
            success: function (data) {
                // window.location.reload()
            },
            error: function (err) {
                error_alert(err.responseJSON.message)
            }
        });
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
        openPairModal($(this).parent().data('cardId'))
    })

    $('#download_template').on('click', function () {
        window.open(
            $('#download_template_url').data('url') +
            "?semester=" + $('#select_semester_schedule_plan').val() + "&" +
            "plan_type=" + $('.plan_type').val() + "&" +
            "select_group=" + $('.select_group').val()
        )
    })

    let update_document = false;

    function checkBtnDownload() {
        window.setTimeout(checkBtnDownload,5000);
        $.ajax({
            url: $('#check_status_schedule_plan_cron').data('url'),
            method: 'post',
            data: {'_token': csrf},
            success: function (data) {
                if (data === 'pending') {
                    $('#download_schedule_file_btn').html(
                        `<div class="d-flex gap-2">
                            <div class="d-inline-block">
                                <i class="fas fa-sync-alt text-white"
                                   style="font-size: 14px; animation: fa-spin 2s infinite linear;"></i>
                            </div>
                            Идет загрузка расписания
                        </div>`
                    )
                    $('#download_schedule_file_btn').attr({disabled: true})
                    update_document = true
                } else if (data === 'none') {
                    if (update_document) {
                        window.location.reload()
                    }
                }
            },
            error: function (err) {
                error_alert(err.responseJSON.message)
            }
        });
    }

    checkBtnDownload()

    $('#download_schedule_file_btn').on('click', function () {
        setScheduleCash()
        let files = $('#download_schedule_file_input')[0].files
        if (files.length <= 0) {
            error_alert('Сначала загрузите файл!')
            return
        }
        var formData = new FormData();
        formData.append('file', files[0]);
        formData.append('semester', $('#select_semester_schedule_plan').val());
        formData.append('groups[]', $('.select_group').val());
        formData.append('plan_type', $('.plan_type').val());
        formData.append('_token', csrf)

        $.ajax({
            url: $('#download_schedule_file').data('url'),
            method: 'post',
            processData: false,
            contentType: false,
            data: formData,
            success: function (data) {
                checkBtnDownload()
            },
            error: function (err) {
                error_alert(err.responseJSON.message)
            }
        });
    })

    function getPairData(number) {
        let pairElement = $('.pair_numbers').children(`li[data-number="${number}"]`);
        return {
            number: pairElement.data('number'),
            timeStart: pairElement.data('timeStart'),
            timeEnd: pairElement.data('timeEnd')
        }
    }
})
