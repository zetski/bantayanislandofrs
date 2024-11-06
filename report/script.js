$(function(){
    $('#request-form').submit(function(e){
        e.preventDefault();
        var _this = $(this);
        $('.err-msg').remove();
        start_loader();
        $.ajax({
            url: _base_url_+"classes/Master.php?f=save_request",
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            dataType: 'json',
            error: function(err) {
                console.log(err);
                alert_toast("An error occurred",'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else if (resp.status == 'failed' && !!resp.msg) {
                    var el = $('<div>');
                    el.addClass("alert alert-danger err-msg").text(resp.msg);
                    _this.prepend(el);
                    el.show('slow');
                    $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                    end_loader();
                } else {
                    alert_toast("An error occurred",'error');
                    end_loader();
                    console.log(resp);
                }
            }
        });
    });
});
