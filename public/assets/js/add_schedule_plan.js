$(document).ready(function (){

    let type_plan_id;

    $('#add_plan_schedule').on('click', function (){
        let csrf = $('input[name="_token"]').val()
        let url = $('#check_schedule_plan').data('url')
        let group_id = $('#select_group_schedule_plan').val()
        let semester_id = $('#select_semester_schedule_plan').val()
        $('#add_plan_schedule_container').empty()

        if ($('#type_schedule_plan').length) {
            type_plan_id = $('#type_schedule_plan').val()
        }

        if (type_plan_id){
            $('#add_plan_schedule_container').append('<div class="d-flex justify-content-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div>')
            $.ajax({
                url: $('#add_schedule_plan').data('url'),
                method: 'post',
                data: {'_token': csrf, 'group_id':group_id, 'semester_id':semester_id, 'plan_type_id':type_plan_id},
                success: function(data){
                    type_plan_id = null
                    $('#add_plan_schedule_container').empty()
                    $('#add_plan_schedule_container').append(data)
                }
            });
        }else {
            $.ajax({
                url: url,
                method: 'post',
                data: {'_token': csrf, 'group_id':group_id, 'semester_id':semester_id},
                success: function(data){
                    if (data){
                        type_plan_id = data
                        $('#add_plan_schedule').click()
                    } else {
                        $('#schedule_plan_type').empty()
                        $('#schedule_plan_type').append('<div class="d-flex justify-content-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div>')
                        $.ajax({
                            url: $('#get_type_schedule_plan_form').data('url'),
                            method: 'post',
                            data: {'_token': csrf},
                            success: function(data){
                                $('#schedule_plan_type').empty()
                                $('#schedule_plan_type').append(data)
                                $('#type_schedule_plan').change(function (){
                                    type_plan_id = $(this).val()
                                })
                            }
                        });
                    }
                }
            });
        }


    })
})
