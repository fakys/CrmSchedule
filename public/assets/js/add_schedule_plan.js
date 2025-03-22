$(document).ready(function (){
    $('#add_plan_schedule').on('click', function (){
        let csrf = $('input[name="_token"]').val()
        let url = $('#add_schedule_plan').data('url')
        let plan_type_id = $('#select_type_schedule_plan').val()
        let group_id = $('#select_group_schedule_plan').val()
        let semester_id = $('#select_semester_schedule_plan').val()
        $('#add_plan_schedule_container').empty()
        $('#add_plan_schedule_container').append('<div class="d-flex justify-content-center p-3"><div class="spinner-border text-primary" role="status"><span class="visually-hidden"></span></div>')
        $.ajax({
            url: url,
            method: 'post',
            data: {'_token': csrf, 'plan_type_id':plan_type_id, 'group_id':group_id, 'semester_id':semester_id},
            success: function(data){
                $('#add_plan_schedule_container').empty()
                $('#add_plan_schedule_container').append(data)
            }
        });
    })
})
