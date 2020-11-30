$(function() {
    focusField('name');
    loadSubjects();
    var validator = $("#frm_main").validate({
        onclick: true,
        errorPlacement: function(error, element) {
            return false;
        },
        rules: getAllFields(),
        highlight: function(element, errorClass, validClass) {
            $(element).addClass("input-validation-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("input-validation-error");
        }
    });
    $("#frm_main").on("submit", function(e) {
        e.preventDefault();
        formValidate(validator);
        if ($("#frm_main").valid()) {
            httpHandler("/" + getBaseUrl() + "course/save", "post", $("#frm_main").serialize(), null, undefined, undefined, undefined, 'student_error');
        }
    });
});

function linkSubjects() {
    var validatorCourse = $("#frm_link_subject").validate({
        onclick: true,
        ignore: [],
        errorPlacement: function(error, element) {
            return true;
        },
        rules: {
            course_uuid: { required: true },
            subject_uuid: { required: true },
            lecturer_uuid: { required: true },
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass("input-validation-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass("input-validation-error");
        }
    });
    formValidate(validatorCourse);
    if ($("#frm_link_subject").valid()) {
        httpHandler("/" + getBaseUrl() + "course/savesubject", "post", $("#frm_link_subject").serialize(), subjectPostSuccess, undefined, undefined, undefined, '');
    }
}

function subjectPostSuccess() {
    $('#link_subject').dialog("destroy");
    $('#link_subject').html("");
    $('#tab-link-subjects').trigger("click");
    loadSubjects();
}

function loadSubjects() {
    httpHandler("/" + getBaseUrl() + "course/subjectlist/" + $("#uuid").val() + "/", "get", null,
        function(html) {
            $("#tab-subjects").html(html);
        }, null, false);
}

function removeSubject(course_subject_uuid) {
    confirmDialog("remove_course", "Confirm", "Are you sure you want to remove this subject?", function() {
        var data = {
            course_subject_uuid: course_subject_uuid
        };
        httpHandler("/" + getBaseUrl() + "course/removesubject", "post", data, loadSubjects);
    });
}

function validField(field_name) {
    return getAllFields()[field_name];
}

function getAllFields() {
    return {
        name: { required: true },
        department_uuid: { required: true },
        status_id: { required: true }
    }
}