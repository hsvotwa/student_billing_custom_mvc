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
            course: { required: true },
            unit_uuid: { required: true },
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass("input-validation-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("input-validation-error");
        }
    });
    if ($("#course_uuid").val() === "") {
        $("#course").addClass("input-validation-error");
        $("#course").val("");
        $("#course").focus();
        return;
    }
    formValidate(validatorCourse);
    if ($("#frm_link_course").valid()) {
        httpHandler("/" + getBaseUrl() + "student/savecourse", "post", $("#frm_link_course").serialize(), coursePostSuccess, undefined, undefined, undefined, 'error_label');
    }
}

function coursePostSuccess() {
    $('#link_course').dialog("destroy");
    $('#tab-link-course').trigger("click");
    loadCourses();
}

function loadCourses() {
    httpHandler("/" + getBaseUrl() + "students/courselist/" + $("#uuid").val() + "/", "get", null,
        function(html) {
            $("#tab-courses").html(html);
            loadAuditTrail();
        }, null, false);
}

function removeCourse(unit_course_uuid) {
    confirmDialog("remove_occ", "Confirm", "Are you sure you want to remove this course?", function() {
        var data = {
            unit_course_uuid: unit_course_uuid
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