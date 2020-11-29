<form method="post" action="<?php echo $form_action; ?>" id="frm_link_course">
  <input type="hidden" name="student_uuid" id="student_uuid" value="" />
  <div id="error_label"></div>
    <table class="w-100">
        <tr>
            <td class="w-50">
                <?php
                echo $form_fields["course_uuid"]->getFieldHtmlLabel();
                echo $form_fields["course_uuid"]->getFieldHtml();
                ?>
            </td>
        </tr>
    </table>
</form>