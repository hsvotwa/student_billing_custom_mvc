$(function() {
    focusField('name');
    loadCourses();
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
            httpHandler("/" + getBaseUrl() + "student/save", "post", $("#frm_main").serialize(), null, undefined, undefined, undefined, 'student_error');
        }
    });
});

function linkCourses() {
    var validatorCourse = $("#frm_link_course").validate({
        onclick: true,
        ignore: [],
        errorPlacement: function(error, element) {
            return true;
        },
        rules: {
            course_uuid: { required: true },
            student_uuid: { required: true },
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass("input-validation-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("input-validation-error");
        }
    });
    formValidate(validatorCourse);
    if ($("#frm_link_course").valid()) {
        httpHandler("/" + getBaseUrl() + "student/savecourse", "post", $("#frm_link_course").serialize(), coursePostSuccess, undefined, undefined, undefined, '');
    }
}

function coursePostSuccess() {
    $('#link_course').dialog("destroy");
    $('#link_course').html("");
    $('#tab-link-courses').trigger("click");
    loadCourses();
}

function loadCourses() {
    httpHandler("/" + getBaseUrl() + "student/courselist/" + $("#uuid").val() + "/", "get", null,
        function(html) {
            $("#tab-courses").html(html);
        }, null, false);
}

function removeCourse(student_course_uuid) {
    confirmDialog("remove_course", "Confirm", "Are you sure you want to remove this course?", function() {
        var data = {
            student_course_uuid: student_course_uuid
        };
        httpHandler("/" + getBaseUrl() + "student/removecourse", "post", data, loadCourses);
    });
}

function validField(field_name) {
    return getAllFields()[field_name];
}

function getAllFields() {
    return {
        name: { required: true },
        tel_no: { required: true },
        email: { required: true }
    }
}