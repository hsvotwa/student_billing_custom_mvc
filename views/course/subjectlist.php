<?php
if( ! $records || ! $records->num_rows ) {
    echo "<thead id=\"th_cont_data\"><tr><td>No records found</td></tr></thead>";
    return;
}
?>
<thead id="th_cont_data">
<tr>
    <td class="head_td" width="200">
       Subject
    </td>
    <td class="head_td" width="200">
        Subject cost
    </td>
    <td class="head_td" width="200">
        Lecturer
    </td>
    <td></td>
</tr>
</thead>
<tbody id="tb_cont_data">
    <?php
    foreach ( $records as $record ) {
        echo "<tr>";
        echo "<td width=\"200\"><a class='url' href='" . WEBROOT . "subject/edit/" . $record["uuid"] . "' >" . $record['subject'] . "</td>";
        echo "<td width=\"200\">" . $record['subject'] . "</td>";
        echo "<td width=\"200\">" . $record['cost'] . "</td>";
        echo "<td width=\"200\">" . $record['lecturer'] . "</td>";
        echo "<td width=\"100\"><a href=\"#\" class=\"action_link\" onclick='removeSubject(\"" . $record["course_subject_uuid"] . "\")'>remove</a></td>";
        echo "</tr>";
    }
    ?>
</tbody>