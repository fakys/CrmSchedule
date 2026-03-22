$(document).ready(function () {

    function checkCash() {
        if ($('#cash_schedule').is(':checked')) {
            $('#cash_container').removeClass('d-none')
        } else {
            $('#cash_container').addClass('d-none')
        }
    }
    checkCash()
    $('#cash_schedule').change(function () {
        checkCash()
    })
})
