<form method="post" action="<?php echo $form_action; ?>" id="frm_main">
<div id="department_error"></div>
    <table class="tbl_cont">
        <tr>
            <td class="tbl_cont_td_2">
                <div id="tab">
                    <ul>
                        <li id="li-tab-gen">
                            <a href="#tab-gen">Detail</a>
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
                                        echo $form_fields["status_id"]->getFieldHtmlLabel();
                                        echo $form_fields["status_id"]->getFieldHtml();
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Submit" class="button" />
                                    <a href="<?php echo APP_DOMAIN; ?>departments/manage" class="url">Go to list</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</form>
<?php
    echo $gen->getJavascriptRef('js/department.js')
?>