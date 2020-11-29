<?php
if( ! $records || ! $records->num_rows ) {
    echo "<thead id=\"th_cont_data\"><tr><td>No records found</td></tr></thead>";
    return;
}
$vat = ConfigMgr::getValue( EnumConfig::vat );
?>
<thead id="th_cont_data">
<tr>
    <td class="head_td" width="200">
      <label class="form_label"> Subject</label>
    </td>
    <td class="head_td text-right" width="200">
        <label class="form_label">Subject cost (excl. VAT)</label>
    </td>
    <td class="head_td text-right" width="200">
        <label class="form_label">VAT (<?php echo ( $vat + 0 ); ?>%)</label>
    </td>
    <td class="head_td text-right" width="200">
        <label class="form_label">Subject cost (incl. VAT)</label>
    </td>
    <td class="head_td" width="200">
        <label class="form_label">Lecturer</label>
    </td>
    <td></td>
</tr>
</thead>
<tbody id="tb_cont_data">
    <?php
    foreach ( $records as $record ) {
        echo "<tr>";
        echo "<td width=\"200\"><a class='url' href='" . WEBROOT . "subject/edit/" . $record["uuid"] . "' >" . $record['subject'] . "</td>";
        echo "<td width=\"200\" class=\"text-right\">" . Convert::toNum( $record['cost'] ) . "</td>";
        echo "<td width=\"200\" class=\"text-right\">" . Convert::toNum( $record['cost'] * ( $vat / 100 ) ) . "</td>";
        echo "<td width=\"200\" class=\"text-right\">" . Convert::toNum( $record['cost'] * ( 100 + $vat ) / 100 ) . "</td>";
        echo "<td width=\"200\">" . $record['lecturer'] . "</td>";
        echo "<td width=\"100\"><a href=\"#\" class=\"action_link\" onclick='removeSubject(\"" . $record["course_subject_uuid"] . "\")'>remove</a></td>";
        echo "</tr>";
    }
    ?>
</tbody>