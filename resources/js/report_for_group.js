$(document).ready(function (){


    $('select').change(function (){
        switch ($(this).attr('name')) {
            case 'students_group[]' :
                $("select[name='students_group[]']").attr('disabled', false)
                $("select[name='specialties[]']").attr('disabled', true)
                break
            case 'specialties[]':
                $("select[name='specialties[]']").attr('disabled', false)
                $("select[name='students_group[]']").attr('disabled', true)
                break
        }
    })


    for (select of $('select')) {
        if ($(select).val().length)  {
            switch ($(select).attr('name')) {
                case 'students_group[]' :
                    $("select[name='students_group[]']").attr('disabled', false)
                    $("select[name='specialties[]']").attr('disabled', true)
                    break
                case 'specialties[]':
                    console.log($(select).val())
                    $("select[name='specialties[]']").attr('disabled', false)
                    $("select[name='students_group[]']").attr('disabled', true)
                    break
            }
        }
    }
})
