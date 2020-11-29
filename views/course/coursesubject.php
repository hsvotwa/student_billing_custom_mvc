<form method="post" action="<?php echo $form_action; ?>" id="frm_link_subject">
  <input type="hidden" name="course_uuid" id="course_uuid" value="" />
  <div id="error_label"></div>
    <table class="w-100">
        <tr>
            <td class="w-50">
                <?php
                echo $form_fields["subject_uuid"]->getFieldHtmlLabel();
                echo $form_fields["subject_uuid"]->getFieldHtml();
                ?>
            </td>
        </tr>
        <tr>
            <td class="w-50">
                <?php
                echo $form_fields["lecturer_uuid"]->getFieldHtmlLabel();
                echo $form_fields["lecturer_uuid"]->getFieldHtml();
                ?>
            </td>
        </tr>
    </table>
</form>