$(document).ready(function () {
    let table_id = $('.validate-js-name').data('form')
    let rule_obj = {}
    let messages = {}

    for (let i of $('.validate-js-rule')) {
        let rule = $(i)
        let rule_name = rule.data('name')
        let rule_field = rule.data('field')
        let type_field = rule.data('type_field')

        if (!(rule_field in rule_obj)) {
            rule_obj[rule_field] = {}
            messages[rule_field] = {}
        }


        switch (rule_name) {
            case 'required':
                rule_obj[rule_field].required = true
                messages[rule_field].required = rule.data('message')
                break
            case 'min':
               if (type_field === 'numeric') {
                   rule_obj[rule_field].min = rule.data('min')
                   messages[rule_field].min = rule.data('message');
               } else {
                   rule_obj[rule_field].minlength = rule.data('min')
                   messages[rule_field].minlength = rule.data('message');
               }

                break
        }
    }
    console.log(rule_obj)
    $('#'+table_id).validate({
        rules: rule_obj,
        messages: messages,
        errorClass: "is-invalid",
        validClass: "is-valid",
        errorElement: "div",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            $('#'+element.attr('name')+'_error').html(error)
        },
        highlight: function (element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element) {
            $(element).addClass('is-valid').removeClass('is-invalid');
        }
    });
})
