function checkUserAccess(){
    let csrf = $('input[name="_token"]').val()
    let url = $('#access_route').data('url');
    let links = $('a');
    let links_arr = [];
    for (let link of links){
        let url_link = $(link).attr('href');
        if (url_link && url_link.length > 5) {
            links_arr.push(url_link)
        }
    }

    $.ajax({
        url: url,
        method: 'post',
        data: {'_token':csrf, 'links':links_arr},
        success: function(data){
            for (let url in data) {
                if (data[url] === 'rejected') {
                    if ($('a[href="' + url + '"]')) {
                        // $('a[href="' + url + '"]').remove()
                    }
                }
            }
        },
        error: function (err){
            error_alert(err.responseJSON.message)
        }
    });
}
checkUserAccess()
