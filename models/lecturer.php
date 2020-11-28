<?php
class LecturerMdl extends BaseMdl {
    public $g_current_unit_count = null;

    public function __construct ( $id = null ) {
        $this->g_id = $id;
        $this->g_current_unit_count = 0;
        $this->g_entity_name = "lecturer";
        $this->g_sql_table = "tbl_lecturer";
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
        return ( ! is_null ( $this->g_row ) ? $this->g_entity_name . ': ' . $this->g_row['name']  : 'New ' . strtolower( $this->g_entity_name ) );
    }

    public function getFields () {
        if ( $this->g_fields != null ) {
            return $this->g_fields;
        }
        $return = array ();
        $return["full_name"] = new FieldMdl( 
            "full_name", "full_name", "Full name", true, EnumFieldDataType::_string, EnumFieldType::_string, $this->g_sql_table, true, "text", $this->g_row
        );
        $return["department_uuid"] = new FieldMdl( 
            "department_uuid", "department_uuid", "Department", true, EnumFieldDataType::_string, EnumFieldType::_string, $this->g_sql_table, true, "text telephone_number_field", $this->g_row, null, 2, null, LookupData::getDepartmentList(), 6
        );
        $return["status_id"] = new FieldMdl( 
            "status_id", "status_id", "Status", true, EnumFieldDataType::_string, EnumFieldType::_string, $this->g_sql_table, true, "text", $this->g_row, null, 2, null, LookupData::getStatusList(), 0, false
        );
        $this->g_fields = $return;
        return $this->g_fields;
    }
}