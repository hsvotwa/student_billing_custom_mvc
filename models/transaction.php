<?php
class TransactionMdl extends BaseMdl {
    public $g_current_unit_count = null;

    public function __construct ( $id = null ) {
        $this->g_id = $id;
        $this->g_current_unit_count = 0;
        $this->g_entity_name = "Transaction";
        $this->g_sql_table = "tbl_student_transaction";
        $this->g_retrieve_query = $this->getRetrieveQuery();
        $this->g_fields = $this->g_invalid_fields = $this->g_errors = array ();
        if ( $id ) {
            $this->retrieve ();
        } else {
            $this->g_id = $this->getMySql()->getUuid();
        }
        $this->getFields();
    }

    protected function getRetrieveQuery () {
        return "select * from $this->g_sql_table where uuid = '$this->g_id'";
    }

    public function getRecordPageTitle() {
        return ( ! is_null ( $this->g_row ) ? $this->g_entity_name . ': ' . $this->g_row['date']  : 'New ' . strtolower( $this->g_entity_name ) );
    }

    public function getFields () {
        if ( $this->g_fields != null ) {
            return $this->g_fields;
        }
        $return = array ();
        $return["student_uuid"] = new FieldMdl( 
            "student_uuid", "student_uuid", "Student", true, EnumFieldDataType::_string, EnumFieldType::_select, $this->g_sql_table, true, "text", $this->g_row, null, 2, LookupData::getAllStudents(), "-- select student --", 6
        );
        $return["amount"] = new FieldMdl( 
            "amount", "amount", "Amount", true, EnumFieldDataType::_float, EnumFieldType::_float, $this->g_sql_table, true, "text", $this->g_row
        );
        $return["date"] = new FieldMdl( 
            "date", "date", "Date", true, EnumFieldDataType::_date, EnumFieldType::_date, $this->g_sql_table, true, "text", $this->g_row
        );
        $this->g_fields = $return;
        return $this->g_fields;
    }
}