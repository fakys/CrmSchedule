$(document).ready(function () {
    $('#download_template').on('click', function () {
        window.open(
            $('#download_template_url').data('url') +
            "?semester=" + $('#select_semester_schedule_plan').val()+"&" +
            "plan_type=" + $('.plan_type').val()+"&" +
            "select_group=" + $('.select_group').val()
        )
    })
})
