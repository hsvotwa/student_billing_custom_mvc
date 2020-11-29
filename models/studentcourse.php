<?php
class StudentcourseMdl extends BaseMdl {
    public $g_current_unit_count = null;

    public function __construct ( $id = null ) {
        $this->g_id = $id;
        $this->g_current_unit_count = 0;
        $this->g_entity_name = "Student Course";
        $this->g_sql_table = "tbl_student_course";
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
        return "Enrol in a course";
    }

    public function studentHasCourse( $course_uuid, $student_uuid ) {
        $query = "select * 
                        from tbl_student_course
                    where course_uuid = '$course_uuid'
                    and student_uuid = '$student_uuid'
                    and soft_deleted = " . EnumYesNo::no . ";";
        $existing = $this->getMySql()->getQueryResult( $query );
        return $existing && $existing->num_rows;
    }

    public function save() {
        if( $this->studentHasCourse( $_POST["course_uuid"], $_POST["student_uuid"]) ) {
            return true;
        }
        $query = "insert into tbl_student_course
                    set uuid = uuid(),
                    course_uuid = '" . $_POST["course_uuid"] . "',
                    student_uuid = '" . $_POST["student_uuid"] . "',
                    course_cost = '" . CourseMgr::getCost( $_POST["course_uuid"] ) . "',
                    soft_deleted = " . EnumYesNo::no . ",
                    created = now(),
                    last_modified = now();";
        return  $this->getMySql()->getQueryResult( $query );
    }

    public function remove( &$error_message ) {
        if( ! $_POST ) {
            return false;
        }
        $query = "update tbl_student_course
                    set soft_deleted = " . EnumYesNo::yes . ",
                    last_modified = now()
                where uuid = '" . $_POST["student_course_uuid"] . "';";
       return $this->getMySql()->getQueryResult( $query );
    }

    public function getFields () {
        if ( $this->g_fields != null ) {
            return $this->g_fields;
        }
        $return = array ();
        $return["student_uuid"] = new FieldMdl( 
            "student_uuid", "student_uuid", "Student", true, EnumFieldDataType::_string, EnumFieldType::_select, $this->g_sql_table, true, "text", $this->g_row, null, 2, LookupData::getAllStudents(), "-- select student --", 6
        );
        $return["course_uuid"] = new FieldMdl( 
            "course_uuid", "course_uuid", "Course", true, EnumFieldDataType::_string, EnumFieldType::_select, $this->g_sql_table, true, "text", $this->g_row, null, 2, LookupData::getCourseList(), "-- select department --", 6
        );
        $this->g_fields = $return;
        return $this->g_fields;
    }
}