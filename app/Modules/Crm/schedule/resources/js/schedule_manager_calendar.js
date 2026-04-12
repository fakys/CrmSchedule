$(document).ready(function () {
    $(function () {
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendar.Draggable;

        var containerEl = document.getElementById('external-events');
        var containerElPair = document.getElementById('external-events-pair');
        var calendarEl = document.getElementById('calendar');


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

                let card = createCard(id, 'Новое расписание №' + id, 1)
                card.backgroundColor = window.getComputedStyle(eventEl, null).getPropertyValue('background-color');
                card.borderColor = window.getComputedStyle(eventEl, null).getPropertyValue('background-color')
                return card;
            },
        });

        function createCard(id, cardName, pairNumber, start = '', end = '') {
            return {
                id: id,
                cardName: cardName,
                start: start,
                end: end,
                numberPair: pairNumber
            };
        }

        var calendar = new Calendar(calendarEl, {
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
                events: [],


                snapDuration: '00:05:00',
                slotDuration: '00:30:00',
                slotMinTime: '08:00:00',
                slotMaxTime: '20:00:00',
                scrollTime: '08:00:00',

                editable: true,
                eventStartEditable: true,
                eventDurationEditable: true,

                eventOverlap: function (stillEvent, movingEvent) {
                    return true;
                },
                eventDidMount: function (info) {
                    let pairNumber = getNumberPairByCard(info.event.id)
                    let element = $(`.card-schedule[data-id="${info.event.id}"]`)
                    element.attr({'data-number-pair':pairNumber})
                    element.find('.pair-number-card').html(pairNumber)

                    addContextMenuEvent()
                },
                eventContent: function (arg) {
                    var start = moment(arg.event.start).format('HH:mm');
                    var end = arg.event.end ? moment(arg.event.end).format('HH:mm') : '';
                    var id = arg.event.id
                    var pairNumber = null;

                    var timeText = end ? start + ' – ' + end : start;

                    var cardName = arg.event.extendedProps.cardName || '';
                    arg.event.extendedProps.numberPair = pairNumber


                    var html =
                        `<div class="card-schedule-title d-flex">${cardName} <div class="pair-number-card">${pairNumber}</div></div>` +
                        '<div class="card-schedule-time">' + timeText + '</div>';

                    // Возвращаем объект с HTML
                    return {html: `<div class="card-schedule" data-id="${id}" data-number-pair="${pairNumber}">${html}</div>`};
                },
            }
        );

        calendar.render();

        function getScheduleNewId() {
            let maxId = 0
            calendar.getEvents().forEach(function (event) {
                if (Number(event.id) > maxId) {
                    maxId = Number(event.id)
                }
            });

            return maxId + 1
        }

        function getNumberPairByCard(id)
        {

            let allCards = $(`.card-schedule[data-id="${id}"]`).closest('.fc-daygrid-day-events').find('.card-schedule')
            let pair = Number($($('.pair_numbers').find('li')[0]).data('number'));
            for (let card of allCards) {
                card = $(card)
                if (Number(id) !== Number(card.data('id'))) {
                    if (pair <= Number(card.data('numberPair'))) {
                        pair = Number(card.data('numberPair')) + 1
                    }
                }
            }
            return pair
        }

        function deleteCard(id) {
            var event = calendar.getEventById(id);
            if (event) {
                event.remove()
            }
        }

        function openModalData(id) {
            let cardData = formatEventData(id)
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

        function formatEventData(id) {
            let data = {}
            let event = calendar.getEventById(id)
            data['id'] = event.toPlainObject().id
            data['start'] = event.toPlainObject().start
            data['end'] = event.toPlainObject().end
            data['cardName'] = event.toPlainObject().extendedProps.cardName
            return data
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
                        deleteCard(card.data('id'))
                    } else if (action === 'edit') {
                        openModalData(card.data('id'))
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
    })


})
