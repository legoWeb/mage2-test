define(["jquery", "domReady!","hobby"], function($,dom,hobby){

    $(document).on('click', '#hobby-submit', function(e) {
        var ajxurl = $('#mcf').attr('action');
        var formdata = new FormData(jQuery('#mcf')[0]);
        $.ajax({
            url: ajxurl,
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: formdata,
            showLoader: true,
            success: function(data){
                location.reload();
                alert("Save");
            }
        });
        e.preventDefault();
    });
})
