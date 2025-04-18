

$(document).ready(function (){
    let sort = {};
    const DESC = 'desc'
    const ASC = 'asc'

    function sortDesc(obj){
        for (let desc of $('.sort-table')) {
            $(desc).attr({'sort':''})
            $(desc).removeClass('sort-desc')
            $(desc).removeClass('sort-asc')
        }
        obj.removeClass('sort-asc')
        obj.addClass('sort-desc')
        sort[obj.parents('th').data('column')] = DESC
        obj.attr({'sort':DESC})
    }

    function sortAsc(obj){
        for (let desc of $('.sort-table')) {
            $(desc).attr({'sort':''})
            $(desc).removeClass('sort-desc')
            $(desc).removeClass('sort-asc')
        }
        obj.removeClass('sort-desc')
        obj.addClass('sort-asc')
        sort[obj.parents('th').data('column')] = ASC
        obj.attr({'sort':ASC})
    }
    function nonAsc(){
        for (let desc of $('.sort-table')) {
            $(desc).attr({'sort':''})
            $(desc).removeClass('sort-desc')
            $(desc).removeClass('sort-asc')
        }
    }

    $('.sort-table').on('click', function () {
        sort = {}
        let sort_row = $(this).attr('sort')

        if (sort_row === DESC) {
            sortAsc($(this))
        } else if (sort_row === ASC) {
            nonAsc()
        } else {
            sortDesc($(this))
        }

    })

    function validSearch() {
        for (let field in required_fields) {
            if (!$(`input[name='${field}']`).val()) {
                error_alert(`Заполните поле ${required_fields[field]}`)
                return false;
            }
        }
        return true;
    }


    $('#search_btn').on('click', function () {
        if (validSearch()) {
            $(`#searchForm`).submit();
        }
    })
})
