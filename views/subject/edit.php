<div style="margin: 15px 5px">
    <a href="<?php echo APP_DOMAIN; ?>occupants/manage/" class="button">Back</a>
    <a href="#" class="button" onclick="showDialog();">Add document(s)</a>
</div>
<form method="post" action="<?php echo $form_action; ?>" id="frm_main">
<div id="occupant_error"></div>
    <table class="tbl_cont">
        <tr>
            <td class="tbl_cont_td_2">
                <div id="tab">
                    <ul>
                        <li id="li-tab-gen">
                            <a href="#tab-gen">General</a>
                        </li>
                        <li id="li-tab-documents">
                            <a href="#tab-documents" id="doc-tab-link">Document(s)</a>
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
                                        echo $form_fields["surname"]->getFieldHtmlLabel();
                                        echo $form_fields["surname"]->getFieldHtml();
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50">
                                    <?php
                                        echo $form_fields["birthday"]->getFieldHtmlLabel();
                                        echo $form_fields["birthday"]->getFieldHtml();
                                    ?>
                                </td>
                                <td class="w-50">
                                    <?php
                                        echo $form_fields["id_no"]->getFieldHtmlLabel();
                                        echo $form_fields["id_no"]->getFieldHtml();
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50">
                                    <?php
                                        echo $form_fields["cell_no"]->getFieldHtmlLabel();
                                        echo $form_fields["cell_no"]->getFieldHtml();
                                    ?>
                                </td>
                                <td class="w-50">
                                    <?php
                                        echo $form_fields["lease_expiry_date"]->getFieldHtmlLabel();
                                        echo $form_fields["lease_expiry_date"]->getFieldHtml();
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="w-50">
                                    <?php
                                        echo $form_fields["can_load_visitor"]->getFieldHtml();
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="tab-documents">
                        
                    </div>
                </div>
            </td>
            <td class="tbl_cont_td_3">
                <div id="div_chg_log"></div>
            </td>
        </tr>
    </table>
</form>
<div id="link_document" class="hidden">
</div>
<?php
    echo $gen->getJavascriptRef('js/occupant.js')
?>
<script>
    function showDialog() {
        $('#link_document').load('<?php echo WEBROOT . "occupant/createdocument"; ?>',
            function() {
                $("#occupant_uuid").val( $("#uuid").val() );
                dialogHandler('Add document', $('#link_document'), linkDocument, null, 300, null, true, false, false);
            });
    }
</script>