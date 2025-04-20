

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

    function checker(){
        let csrf = $('input[name="_token"]').val()
        if (check_export_url) {
            data = {'task_name': task_name, '_token': csrf}
            $.ajax({
                url: check_export_url,
                method: 'post',
                data: data,
                success: function(data){
                    if (data === 'created') {
                        $('#export_btn').attr('file', 'created')
                        $('#export_btn').html('<div class="d-flex align-items-center gap-2"><div class="spinner-border spinner-border-sm text-white" role="status"><i class="fa fa-refresh" aria-hidden="true"></i></div> Файл формируется</div>')
                    } else if (data === 'done') {
                        $('#export_btn').attr('file', 'done')
                        $('#export_btn').html('<div class="d-flex align-items-center gap-2"><i class="fa fa-download" aria-hidden="true"></i> Скачать файл</div>')
                    }
                },
                error: function (err){


                }
            });
        }
    }

    function downloadFile() {
        window.open(download_export_excel+"?task_name="+task_name, '_blank');
        $('#export_btn').attr('file', '')
        $('#export_btn').html('<i class="fa fa-file" aria-hidden="true"></i> Экспорт в excel')
    }

    $('#export_btn').on('click', function () {
        if (export_url && validSearch() && !$('#export_btn').attr('file')) {
            let data = {}

            for (let input of $(`#searchForm`).find('input')){
                data[$(input).attr('name')] = $(input).val()
            }

            for (let select of $(`#searchForm`).find('select')){
                data[$(select).attr('name')] = $(select).val()
            }
            data['task_name'] = task_name

            $.ajax({
                url: export_url,
                method: 'post',
                data: data,
                success: function(data){
                    checker()
                },
                error: function (err){


                }
            });
        } else if ($('#export_btn').attr('file') === 'done'){
            downloadFile()
        }
    })


    $('#search_btn').on('click', function () {
        if (validSearch()) {
            $(`#searchForm`).submit();
        }
    })
    checker()

    setInterval(() => {
        checker()
    }, 10000);

})
