<?php
if( ! $records || ! $records->num_rows ) {
    echo "<thead id=\"th_cont_data\"><tr><td>No records found</td></tr></thead>";
    return;
}
?>
<thead id="th_cont_data">
<tr>
    <td class="head_td" width="200">
        <?php 
            echo $form_fields["name"]->getFieldHtmlLabel( /*is_form=*/ false );
        ?>
    </td>
    <td class="head_td" width="200">
        <?php 
            echo $form_fields["id_no"]->getFieldHtmlLabel( /*is_form=*/ false );
        ?>
    </td>
    <td class="head_td" width="200">
        <?php 
            echo $form_fields["cell_no"]->getFieldHtmlLabel( /*is_form=*/ false );
        ?>
    </td>
</tr>
</thead>
<tbody id="tb_cont_data">
    <?php
    $action = $can_edit ? "edit" : "detail";
    foreach ( $records as $record ) {
        echo "<tr>";
        echo "<td width=\"200\"><a class='url' href='" . WEBROOT . "occupant/$action/" . $record["id"] . "' >" . $record['surname'] . " " . $record['name'] . "</td>";
        echo "<td width=\"200\">" . $record['id_no'] . "</td>";
        echo "<td width=\"200\">" . $record['cell_no'] . "</td>";
        // echo "<td width=\"200\">" . $record['is_tenant_desc'] . "</td>";
        echo "</tr>";
    }
    ?>
</tbody>