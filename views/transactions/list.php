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
            echo $form_fields["student_uuid"]->getFieldHtmlLabel( /*is_form=*/ false );
        ?>
    </td>
    <td class="head_td" width="200">
        <?php 
            echo $form_fields["date"]->getFieldHtmlLabel( /*is_form=*/ false );
        ?>
    </td>
    <td class="head_td text-right" width="200">
        <?php 
            echo $form_fields["amount"]->getFieldHtmlLabel( /*is_form=*/ false );
        ?>
    </td>
</tr>
</thead>
<tbody id="tb_cont_data">
    <?php
    foreach ( $records as $record ) {
        echo "<tr>";
        echo "<td width=\"200\"><a class='url' href='" . WEBROOT . "subject/edit/" . $record["uuid"] . "' >" . $record['student_name'] . "</td>";
        echo "<td width=\"200\">" . Convert::toDate( $record['date'], false, true ) . "</td>";
        echo "<td width=\"200\" class=\"text-right\">" . Convert::toNum( $record['amount'] ) . "</td>";
        echo "</tr>";
    }
    ?>
</tbody>