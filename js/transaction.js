$(function() {
    focusField('name');
    var validator = $("#frm_main").validate({
        onclick: true,
        errorPlacement: function(error, element) {
            return false;
        },
        rules: getAllFields(),
        highlight: function(element, errorClass, validClass) {},
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("input-validation-error");
        }
    });
    $("#frm_main").on("submit", function(e) {
        e.preventDefault();
        formValidate(validator);
        if ($("#frm_main").valid()) {
            httpHandler("/" + getBaseUrl() + "transaction/save", "post", $("#frm_main").serialize(), null, undefined, undefined, undefined, 'student_error');
        }
    });
});

function validField(field_name) {
    return getAllFields()[field_name];
}

function getAllFields() {
    return {
        student_uuid: { required: true },
        amount: { required: true, checkNum: true },
        date: { required: true }
    }
}