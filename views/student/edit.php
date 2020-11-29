<form method="post" action="<?php echo $form_action; ?>" id="frm_main">
<div id="student_error"></div>
    <table class="tbl_cont">
        <tr>
            <td class="tbl_cont_td_2">
                <div id="tab">
                    <ul>
                        <li id="li-tab-gen">
                            <a href="#tab-gen">Detail</a>
                        </li>
                        <li id="li-tab-courses">
                            <a href="#tab-courses" id="tab-link-courses">Courses(s)</a>
                        </li>
                    </ul>
                    <div id="tab-gen">
                        <input type="hidden" name="uuid" id="uuid" value="<?php echo $record_id; ?>" /> 
                        <input type="submit" class="hidden" />
                        <table class="w-100">
                            <tr>
                                <td class="w-50">
                                    <?php
                                    echo $form_fields["status_id"]->getFieldHtmlLabel();
                                    echo $form_fields["status_id"]->getFieldHtml();
                                    ?>
                                </td>
                                <td class="w-50">
                                    <?php
                                    echo $form_fields["title_id"]->getFieldHtmlLabel();
                                    echo $form_fields["title_id"]->getFieldHtml();
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50">
                                    <?php
                                    echo $form_fields["first_name"]->getFieldHtmlLabel();
                                    echo $form_fields["first_name"]->getFieldHtml();
                                    ?>
                                </td>
                                <td class="w-50">
                                    <?php
                                    echo $form_fields["surname"]->getFieldHtmlLabel();
                                    echo $form_fields["surname"]->getFieldHtml();
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50">
                                    <?php
                                    echo $form_fields["tel_no"]->getFieldHtmlLabel();
                                    echo $form_fields["tel_no"]->getFieldHtml();
                                    ?>
                                </td>
                                <td class="w-50">
                                    <?php
                                    echo $form_fields["email"]->getFieldHtmlLabel();
                                    echo $form_fields["email"]->getFieldHtml();
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Submit" class="button" />
                                    <a href="#" id="btn_link_course" class="url <?php echo true ? "" : "hidden" ?>" onclick="showDialog();">Enroll new course</a> |
                                    <a href="<?php echo APP_DOMAIN; ?>students/manage" class="url">Go to list</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="tab-courses">
                    </div>
                </div>
            </td>
        </tr>
    </table>
</form>
<?php
    echo $gen->getJavascriptRef('js/student.js')
?>