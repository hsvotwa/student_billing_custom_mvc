    $("#frm_main").on("submit", function(e) {
        e.preventDefault();
        if ($("#frm_main").valid()) {
            httpHandler("/" + getBaseUrl() + "config/save", "post", $("#frm_main").serialize(), null, undefined, undefined, undefined, 'config_error');
        }
    });