<form method="post" action="<?php echo $form_action; ?>" id="frm_main">
<div id="transaction_error"></div>
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
                                        echo $form_fields["student_uuid"]->getFieldHtmlLabel();
                                        echo $form_fields["student_uuid"]->getFieldHtml();
                                    ?>
                                </td>
                                <td class="w-50">
                                    <?php
                                        echo $form_fields["amount"]->getFieldHtmlLabel();
                                        echo $form_fields["amount"]->getFieldHtml();
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50">
                                    <?php
                                        echo $form_fields["date"]->getFieldHtmlLabel();
                                        echo $form_fields["date"]->getFieldHtml();
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Submit" class="button" />
                                    <a href="<?php echo APP_DOMAIN; ?>transactions/manage" class="url">Go to list</a>
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
    echo $gen->getJavascriptRef('js/transaction.js')
?>