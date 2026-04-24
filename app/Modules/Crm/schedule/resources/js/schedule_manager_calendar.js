$(document).ready(function () {
    $(function () {
        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendar.Draggable;

        var containerEl = document.getElementById('external-events');
        var containerElPair = document.getElementById('external-events-pair');


        new Draggable(containerEl, {
            itemSelector: '.external-event',
            eventData: function (eventEl) {
                return {
                    title: eventEl.innerText,
                    backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                    borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                    textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
                };
            },
        });

        new Draggable(containerElPair, {
            itemSelector: '.external-event',
            eventData: function (eventEl) {
                let id = getScheduleNewId()

                let card = createCard(id, 'Новое расписание №' + id, null, moment(), moment())
                card.backgroundColor = window.getComputedStyle(eventEl, null).getPropertyValue('background-color');
                card.borderColor = window.getComputedStyle(eventEl, null).getPropertyValue('background-color')
                return card;
            },
        });

        var calendarObject = {}


        for (let elem of $('.calendar')) {

            var date = new Date()
            var d    = date.getDate(),
                m    = date.getMonth(),
                y    = date.getFullYear()

            var calendar = new Calendar(elem, {
                    locale: 'ru',

                    buttonText: {
                        today: 'Сегодня',
                        dayGridMonth: 'в рамках месяца',
                        timeGridDay: "В рамках дня",
                    },
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridDay'
                    },
                    themeSystem: 'bootstrap',
                    events: events[$(elem).data('groupId')],


                    snapDuration: '00:05:00',
                    slotDuration: '00:30:00',
                    slotMinTime: '08:00:00',
                    slotMaxTime: '20:00:00',
                    scrollTime: '08:00:00',

                    editable: false,
                    eventStartEditable: true,
                    eventDurationEditable: true,

                    eventDidMount: function (info) {
                        restyleCard()
                        addContextMenuEvent()
                    },
                    eventContent: function (arg) {
                        var start = moment(arg.event.start).format('HH:mm');
                        var end = arg.event.end ? moment(arg.event.end).format('HH:mm') : '';
                        var id = arg.event.id
                        var pairNumber = null

                        var timeText = end ? start + ' – ' + end : start;

                        var cardName = arg.event.extendedProps.cardName || '';
                        arg.event.extendedProps.numberPair = pairNumber


                        var html =
                            `<div class="card-schedule-title d-flex">${cardName} <div class="pair-number-card">${pairNumber}</div></div>` +
                            '<div class="card-schedule-time">' + timeText + '</div>';

                        // Возвращаем объект с HTML
                        return {html: `<div class="card-schedule" data-id="${id}" data-group-id="" data-number-pair="${pairNumber}"
                        style="background: ${arg.event.backgroundColor}; border: 1px solid ${arg.event.borderColor};">
                            ${html}</div>`};
                    }
                }
            );
            calendarObject[$(elem).data('groupId')] = calendar
            calendar.render();
        }

        function addContextMenuEvent() {
            let $menu = $('#context-menu');
            let $target = $('.card-schedule');
            $target.on('contextmenu', function (e) {
                e.preventDefault();
                const x = e.pageX - $(this).width() - 100;
                const y = e.pageY - $(this).height() - 100;
                let card = $(this)
                $menu.off('click')

                $menu.html(`<ul>
                <li data-action="delete">Удалить</li>
                <li data-action="edit">Редактировать</li>
            </ul>`)

                $menu.on('click', 'li', async function () {
                    const action = $(this).data('action');
                    if (action === 'delete') {
                        deleteCard(card.data('id'), card.data('groupId'))
                    } else if (action === 'edit') {
                        openModalData(card.data('id'), card.data('groupId'))
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
        }

        addContextMenuEvent()

        function formatEventData(id, groupId) {
            let data = {}
            let calendar = calendarObject[groupId]
            let event = calendar.getEventById(id)
            data['id'] = event.toPlainObject().id
            data['start'] = event.toPlainObject().start
            data['end'] = event.toPlainObject().end
            data['cardName'] = event.toPlainObject().extendedProps.cardName
            return data
        }


        function deleteCard(id, groupId) {
            let calendar = calendarObject[groupId]
            var event = calendar.getEventById(id);
            if (event) {
                event.remove()
            }
        }

        function openModalData(id, groupId) {
            let cardData = formatEventData(id, groupId)
            $('#card_model_data_label').html(cardData.cardName)
            const modalElement = $('#card_model_data')[0];
            const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
            modal.show();
            let url = $('#get_pair_form').data('url')
            let csrf = $("input[name='_token']").val()

            cardData['numberPair'] = 1
            cardData['groupId'] = 72

            $.ajax({
                url: url,
                method: 'post',
                data: {'_token': csrf, data: cardData},
                success: function (data) {
                    $('#card_modal_body').html(data)
                },
                error: function (err) {
                    let error = err.responseJSON.message
                    if (error) {
                        error_alert(error)
                    } else {
                        error_alert('Ошибка сервера !!')
                    }
                }
            });
        }


        function createCard(id, cardName, pairNumber, start = '', end = '') {
            return {
                id: id,
                cardName: cardName,
                start: start,
                end: end,
                numberPair: pairNumber
            };
        }


        function getScheduleNewId() {
            let maxId = 0

            for (let calendar of $('.calendar')) {
                let groupId = $(calendar).data('groupId')
                calendarObject[groupId].getEvents().forEach(function (event) {
                    if (Number(event.id) > maxId) {
                        maxId = Number(event.id)
                    }
                });
            }



            return maxId + 1
        }

        function restyleCard() {
            let allDays = $('.fc-daygrid-day')
            for (let days of allDays) {
                let pair = Number($($('.pair_numbers').find('li')[0]).data('number'));
                let allCards = $(days).find('.card-schedule')
                for (let card of allCards) {
                    card = $(card)
                    let calendar = card.closest('.calendar')
                    let calendarObj = calendarObject[calendar.data('groupId')]
                    let pairObject = $('.pair_numbers').find(`li[data-number="${pair}"]`)

                    var timePartsStart = pairObject.data('timeStart').split(':');
                    var hoursStart = parseInt(timePartsStart[0]);
                    var minutesStart = parseInt(timePartsStart[1]);

                    var timePartsEnd = pairObject.data('timeEnd').split(':');
                    var hoursEnd = parseInt(timePartsEnd[0]);
                    var minutesEnd = parseInt(timePartsEnd[1]);


                    card.attr({'data-number-pair': pair})
                    card.attr({'data-group-id': calendar.data('groupId')})
                    card.find('.pair-number-card').html(pair)

                    calendarObj.getEventById(card.data('id')).extendedProps.numberPair = pair
                    calendarObj.getEventById(card.data('id')).extendedProps.groupId = Number(calendar.data('groupId'))

                    let pairStart = moment(calendarObj.getEventById(card.data('id')).start);
                    pairStart.hours(hoursStart)
                    pairStart.minutes(minutesStart)


                    let pairEnd = moment(calendarObj.getEventById(card.data('id')).start);
                    pairEnd.hours(hoursEnd)
                    pairEnd.minutes(minutesEnd)

                    calendarObj.getEventById(card.data('id')).start = pairStart.format('YYYY-MM-DDTHH:mm:ss')
                    calendarObj.getEventById(card.data('id')).end = pairEnd.format('YYYY-MM-DDTHH:mm:ss')

                    card.find('.card-schedule-time').html(`${pairStart.format('HH:mm')} - ${pairEnd.format('HH:mm')}`)

                    pair++
                }
            }
        }
    })


})
