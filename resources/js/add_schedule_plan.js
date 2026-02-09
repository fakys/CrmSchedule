$(document).ready(function (){

    const NOT_VALUE = 'Не выбрано'

    if ($('.delete_session').length > 0) {
        $('.delete_session').on('click', function () {
            $.ajax({
                url: $('#delete_session').data('url'),
                method: 'post',
                data: {'_token': csrf},
                success: function(data){
                    window.location.reload()
                }
            });
        })
    }

    let csrf = $('input[name="_token"]').val()
    $('#add_plan_schedule').hide()

    function change_specialties_select() {
        $('#constructor_schedule').empty()
        if ($(".specialties_select").val()) {
            $.ajax({
                url: $('#get_group').data('url'),
                method: 'post',
                data: {'_token': csrf, 'specialties_id':$(".specialties_select").val()},
                success: function(data){
                    $('.select_group_container').html(data)
                    $('.schedule_plan_type').empty()
                    $('#add_plan_schedule').show()
                    if ($(".select_group").val().length > 0 && $(".plan_type").val() && $('#select_semester_schedule_plan').val()) {
                        add_plan_schedule()
                    }
                }
            });
        }
    }

    if($(".specialties_select").val() !== NOT_VALUE) {
        change_specialties_select()
    }


    $(".specialties_select").on('change', function (){
        change_specialties_select()
    })

    $(".plan_type").on('change', function (){
        $('#constructor_schedule').empty()
    })

    $('#select_semester_schedule_plan').on('change', function (){
        $('#constructor_schedule').empty()
    })


    function add_plan_schedule() {
        let groups = $(".select_group").val()
        let plan_type = $(".plan_type").val()
        let semester = $('#select_semester_schedule_plan').val()

        if (!semester) {
            error_alert('Выберите семестр!')
            return
        }

        if (!groups.length) {
            error_alert('Выберите группу!')
            return
        }

        if (plan_type === NOT_VALUE) {
            error_alert('Выберите тип расписания!')
            return
        }
        $('#constructor_schedule').html('<div class="d-flex justify-content-center p-3 load-bar"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div>')

        $.ajax({
            url: $('#get_constructor_schedule').data('url'),
            method: 'post',
            data: {'_token': csrf, 'semester_id':semester, 'groups_id': groups, 'plan_type':plan_type},
            success: function(data){
                $('#constructor_schedule').html(data)
            }
        });
    }

    $('#add_plan_schedule').on('click', function (){
        add_plan_schedule()
    })
})
