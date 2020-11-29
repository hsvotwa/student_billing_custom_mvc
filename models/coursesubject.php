<?php
class CoursesubjectMdl extends BaseMdl {
    public $g_current_unit_count = null;

    public function __construct ( $id = null ) {
        $this->g_id = $id;
        $this->g_current_unit_count = 0;
        $this->g_entity_name = "Course Subject";
        $this->g_sql_table = "tbl_course_subject_lecturer";
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

    public function getRecordPageTitle () {
        return "Add new subject";
    }

    public function courseHasSubject( $subject_uuid, $course_uuid, $lecturer_uuid ) {
        $query = "select * 
                        from tbl_course_subject_lecturer
                    where subject_uuid = '$subject_uuid'
                    and course_uuid = '$course_uuid'
                    and lecturer_uuid = '$lecturer_uuid'
                    and soft_deleted = " . EnumYesNo::no . ";";
        $existing = $this->getMySql()->getQueryResult( $query );
        return $existing && $existing->num_rows;
    }

    public function save() {
        if( $this->courseHasSubject( $_POST["subject_uuid"], $_POST["course_uuid"], $_POST["lecturer_uuid"]) ) {
            return true;
        }
        $query = "insert into tbl_course_subject_lecturer
                    set uuid = uuid(),
                    subject_uuid = '" . $_POST["subject_uuid"] . "',
                    course_uuid = '" . $_POST["course_uuid"] . "',
                    lecturer_uuid = '" . $_POST["lecturer_uuid"] . "',
                    soft_deleted = " . EnumYesNo::no . ",
                    created = now(),
                    last_modified = now();";
        return  $this->getMySql()->getQueryResult( $query );
    }

    public function remove( &$error_message ) {
        if( ! $_POST ) {
            return false;
        }
        $query = "update tbl_course_subject_lecturer
                    set soft_deleted = " . EnumYesNo::yes . ",
                    last_modified = now()
                where uuid = '" . $_POST["course_subject_uuid"] . "';";
       return $this->getMySql()->getQueryResult( $query );
    }

    public function getFields () {
        if ( $this->g_fields != null ) {
            return $this->g_fields;
        }
        $return = array ();
        $return["course_uuid"] = new FieldMdl( 
            "course_uuid", "course_uuid", "Course", true, EnumFieldDataType::_string, EnumFieldType::_select, $this->g_sql_table, true, "text", $this->g_row, null, 2, LookupData::getCourseList(), "-- select course --", 6
        );
        $return["subject_uuid"] = new FieldMdl( 
            "subject_uuid", "subject_uuid", "Subject", true, EnumFieldDataType::_string, EnumFieldType::_select, $this->g_sql_table, true, "text", $this->g_row, null, 2, LookupData::getSubjectList(), "-- select department --", 6
        );
        $return["lecturer_uuid"] = new FieldMdl( 
            "lecturer_uuid", "lecturer_uuid", "Lecturer", true, EnumFieldDataType::_string, EnumFieldType::_select, $this->g_sql_table, true, "text", $this->g_row, null, 2, LookupData::getLecturerList(), "-- select department --", 6
        );
        $this->g_fields = $return;
        return $this->g_fields;
    }
}