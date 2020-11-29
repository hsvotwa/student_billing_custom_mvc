<form method="post" action="<?php echo $form_action; ?>" id="frm_main">
<div id="course_error"></div>
    <table class="tbl_cont">
        <tr>
            <td class="tbl_cont_td_2">
                <div id="tab">
                    <ul>
                        <li id="li-tab-gen">
                            <a href="#tab-gen">Detail</a>
                        </li>
                        <li id="li-tab-subjects">
                            <a href="#tab-subjects" id="tab-link-subjects">Subject(s)</a>
                        </li>
                    </ul>
                    <div id="tab-gen">
                        <input type="hidden" name="uuid" id="uuid" value="<?php echo $record_id; ?>" /> 
                        <input type="submit" class="hidden" />
                        <table class="w-100">
                            <tr>
                                <td class="w-50">
                                    <?php
                                        echo $form_fields["name"]->getFieldHtmlLabel();
                                        echo $form_fields["name"]->getFieldHtml();
                                    ?>
                                </td>
                                <td class="w-50">
                                    <?php
                                        echo $form_fields["department_uuid"]->getFieldHtmlLabel();
                                        echo $form_fields["department_uuid"]->getFieldHtml();
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50" colspan="2">
                                    <?php
                                        echo $form_fields["status_id"]->getFieldHtmlLabel();
                                        echo $form_fields["status_id"]->getFieldHtml();
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="tab-subjects">
                    </div>
                </div>
            </td>
        </tr>
        <tr>
        <td colspan="2">
            <input type="submit" value="Submit" class="button" />
            <a href="#" id="btn_link_subject" class="url <?php echo true ? "" : "hidden" ?>" onclick="showDialog();">Add new subject</a> |
            <a href="<?php echo APP_DOMAIN; ?>courses/manage" class="url">Go to list</a>
        </td>
    </tr>
    </table>
</form>
<div id="link_subject"></div>
<?php
    echo $gen->getJavascriptRef('js/course.js')
?>
<script>
    function showDialog() {
        $('#link_subject').load('<?php echo WEBROOT . "course/createsubject"; ?>',
            function() {
                $("#course_uuid").val($("#uuid").val());
                dialogHandler('Add new subject', $('#link_subject'), linkSubjects, null, 300, null, true, false, false);
            });

    }
</script>