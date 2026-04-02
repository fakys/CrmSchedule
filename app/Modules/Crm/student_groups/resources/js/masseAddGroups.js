$(document).ready(function () {
    $('#download_template').on('click', function () {
        window.open(
            $('#download_template_url').data('url')
        )
    })
})
