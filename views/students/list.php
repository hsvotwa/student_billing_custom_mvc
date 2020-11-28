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
            echo $form_fields["first_name"]->getFieldHtmlLabel( /*is_form=*/ false );
        ?>
    </td>
    <td class="head_td" width="200">
        <?php 
            echo $form_fields["name"]->getFieldHtmlLabel( /*is_form=*/ false );
        ?>
    </td>
    <td class="head_td" width="200">
        <?php 
            echo $form_fields["department_uuid"]->getFieldHtmlLabel( /*is_form=*/ false );
        ?>
    </td>
    <td class="head_td" width="200">
        <?php 
            echo $form_fields["status_id"]->getFieldHtmlLabel( /*is_form=*/ false );
        ?>
    </td>
</tr>
</thead>
<tbody id="tb_cont_data">
    <?php
    foreach ( $records as $record ) {
        echo "<tr>";
        echo "<td width=\"200\"><a class='url' href='" . WEBROOT . "course/edit/" . $record["uuid"] . "' >" . $record['surname'] . " " . $record['first_name'] . "</td>";
        echo "<td width=\"200\">" . $record['id_no'] . "</td>";
        echo "<td width=\"200\">" . $record['cell_no'] . "</td>";
        // echo "<td width=\"200\">" . $record['is_tenant_desc'] . "</td>";
        echo "</tr>";
    }
    ?>
</tbody>