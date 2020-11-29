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
            echo $form_fields["department_uuid"]->getFieldHtmlLabel( /*is_form=*/ false );
        ?>
    </td>
    <td class="head_td text-right" width="200">
        <label class="form_label">Cost</label>
    </td>
    <td class="head_td" width="200">
        <?php 
            echo $form_fields["status_id"]->getFieldHtmlLabel( /*is_form=*/ false );
        ?>
    </td>
    <td></td>
</tr>
</thead>
<tbody id="tb_cont_data">
    <?php
    foreach ( $records as $record ) {
        echo "<tr>";
        echo "<td width=\"200\"><a class='url' href='" . WEBROOT . "course/edit/" . $record["uuid"] . "' >" . $record['name'] . "</td>";
        echo "<td width=\"200\">" . $record['department'] . "</td>";
        echo "<td width=\"200\" class=\"text-right\">" . Convert::toNum( $record['course_cost'] ) . "</td>";
        echo "<td width=\"200\">" . $record['status'] . "</td>";
        echo "<td width=\"100\"><a href=\"#\" class=\"action_link\" onclick='removeCourse(\"" . $record["student_course_uuid"] . "\")'>remove</a></td>";
        echo "</tr>";
    }
    ?>
</tbody>