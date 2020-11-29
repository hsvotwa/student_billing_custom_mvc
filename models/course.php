<?php
class CourseMdl extends BaseMdl {
    public $g_current_unit_count = null;

    public function __construct ( $id = null ) {
        $this->g_id = $id;
        $this->g_current_unit_count = 0;
        $this->g_entity_name = "Course";
        $this->g_sql_table = "tbl_course";
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

    function getSubjects() {
        $query = "select l.full_name as lecturer, 
                        su.name as subject, 
                        su.cost as cost, 
                        su.uuid as uuid, 
                        sc.uuid as course_subject_uuid 
                    from tbl_course_subject_lecturer sc
                    inner join tbl_course c on c.uuid = sc.course_uuid
                    inner join tbl_subject su on su.uuid = sc.subject_uuid
                    inner join tbl_lecturer l on l.uuid = sc.lecturer_uuid
                    where sc.course_uuid='" . $this->g_id . "' 
                    and sc.soft_deleted != '" . EnumYesNo::yes . "' 
                    order by su.name";
        return $this->getMySql()->getQueryResult( $query );
    }

    public function getFields () {
        if ( $this->g_fields != null ) {
            return $this->g_fields;
        }
        $return = array ();
        $return["name"] = new FieldMdl( 
            "name", "name", "Name", true, EnumFieldDataType::_string, EnumFieldType::_string, $this->g_sql_table, true, "text", $this->g_row
        );
        $return["department_uuid"] = new FieldMdl( 
            "department_uuid", "department_uuid", "Department", true, EnumFieldDataType::_string, EnumFieldType::_select, $this->g_sql_table, true, "text telephone_number_field", $this->g_row, null, 2, LookupData::getDepartmentList(), "-- select department --", 6
        );
        $return["status_id"] = new FieldMdl( 
            "status_id", "status_id", "Status", true, EnumFieldDataType::_string, EnumFieldType::_select, $this->g_sql_table, true, "text", $this->g_row, null, 2, LookupData::getStatusList(), "-- select status --", 0, false
        );
        $this->g_fields = $return;
        return $this->g_fields;
    }
}