<form method="post" action="<?php echo $form_action; ?>" id="frm_main">
<div id="config_error"></div>
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
                            <?php
                            $values = ConfigMdl::getAllValues();
                            foreach( $values as $value ) { ?>
                                <tr>
                                    <td class="w-50">
                                        <?php
                                            echo $form_fields[$value["enum_id"]]->getFieldHtmlLabel();
                                            echo $form_fields[$value["enum_id"]]->getFieldHtml();
                                        ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Submit" class="button" />
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
    echo $gen->getJavascriptRef('js/config.js')
?>