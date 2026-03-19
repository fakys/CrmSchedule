$(document).ready(function (){
    function generatePassword(){
        var length = 8,
            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_";
        res = '';
        for (var i = 0, n = charset.length; i < length; ++i) {
            res += charset.charAt(Math.floor(Math.random() * n));
        }
        return res;
    }
    $('.btn-generate-password').on('click', function (){
        $('.password-input').val(generatePassword());

        if ($('.password-input').val() && $('.password-input').val().length >= 1) {
            $('.btn-copy-password').removeClass('d-none');
        } else {
            $('.btn-copy-password').addClass('d-none');
        }
    })

    $('.btn-copy-password').on('click', function (){
        navigator.clipboard.writeText($('.password-input').val())
    })

    $('.password-input').on('input', function (){
        if ($('.password-input').val() && $('.password-input').val().length >= 1) {
            $('.btn-copy-password').removeClass('d-none');
        } else {
            $('.btn-copy-password').addClass('d-none');
        }
    })
})
